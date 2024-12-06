import os
import numpy as np
from flask import Flask, render_template, request, redirect, url_for, send_from_directory
import matplotlib.image as mpimg
import matplotlib.pyplot as plt

app = Flask(__name__)

# Configurar las carpetas de subida y las imágenes procesadas
UPLOAD_FOLDER = 'uploads/'
PROCESSED_FOLDER = 'static/images/'
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
app.config['PROCESSED_FOLDER'] = PROCESSED_FOLDER

# Asegúrate de que las carpetas existen
os.makedirs(UPLOAD_FOLDER, exist_ok=True)
os.makedirs(PROCESSED_FOLDER, exist_ok=True)

@app.route('/')
def index():
    # Listar las imágenes en la carpeta de subida
    uploaded_images = os.listdir(app.config['UPLOAD_FOLDER'])
    processed_images = os.listdir(app.config['PROCESSED_FOLDER'])
    
    # Filtrar solo archivos de imagen (si es necesario)
    uploaded_images = [f for f in uploaded_images if f.endswith(('.png', '.jpg', '.jpeg', '.gif'))]
    processed_images = [f for f in processed_images if f.endswith(('.png', '.jpg', '.jpeg', '.gif'))]
    
    return render_template('index.html', uploaded_images=uploaded_images, processed_images=processed_images)

@app.route('/upload', methods=['POST'])
def upload_image():
    if 'file' not in request.files:
        return redirect(request.url)
    file = request.files['file']
    if file.filename == '':
        return redirect(request.url)

    # Guardar el archivo subido
    filename = file.filename
    filepath = os.path.join(app.config['UPLOAD_FOLDER'], filename)
    file.save(filepath)

    # Procesar la imagen
    processed_image_path = process_image(filepath, filename)

    # Redirigir al usuario a la página con la imagen procesada
    return redirect('/')

def process_image(filepath, filename):
    # Leer la imagen con matplotlib
    image = mpimg.imread(filepath)  # Leer la imagen como matriz NumPy

    # Convertir a escala de grises si es una imagen RGB
    if image.ndim == 3:  # Si tiene 3 canales (RGB o RGBA)
        grayscale_image = np.dot(image[:, :, :3], [0.2989, 0.5870, 0.1140])  # Conversión ponderada a escala de grises
    else:
        grayscale_image = image  # Ya está en escala de grises

    # Binarizar la imagen recorriendo los píxeles
    threshold = 0.5 if grayscale_image.max() <= 1 else 128  # Ajustar umbral según el rango de valores
    binary_image = (grayscale_image >= threshold).astype(int)

    # Función para encontrar contornos
    def find_contours(binary_image):
        contours = []
        visited = np.zeros_like(binary_image, dtype=bool)

        def is_edge(x, y):
            if binary_image[x, y] == 0:
                return False
            neighbors = [
                (x-1, y), (x+1, y), (x, y-1), (x, y+1),
                (x-1, y-1), (x-1, y+1), (x+1, y-1), (x+1, y+1)
            ]
            for nx, ny in neighbors:
                if 0 <= nx < binary_image.shape[0] and 0 <= ny < binary_image.shape[1]:
                    if binary_image[nx, ny] == 0:
                        return True
            return False

        for x in range(binary_image.shape[0]):
            for y in range(binary_image.shape[1]):
                if binary_image[x, y] == 1 and not visited[x, y] and is_edge(x, y):
                    contour = []
                    stack = [(x, y)]
                    while stack:
                        cx, cy = stack.pop()
                        if visited[cx, cy]:
                            continue
                        visited[cx, cy] = True
                        contour.append((cx, cy))
                        neighbors = [(cx-1, cy), (cx+1, cy), (cx, cy-1), (cx, cy+1)]
                        for nx, ny in neighbors:
                            if (0 <= nx < binary_image.shape[0] and 0 <= ny < binary_image.shape[1] and
                                    binary_image[nx, ny] == 1 and not visited[nx, ny] and is_edge(nx, ny)):
                                stack.append((nx, ny))
                    contours.append(contour)
        return contours

    # Función para simplificar el contorno
    def simplify_contour(contour, epsilon):
        """
        Simplifica un contorno eliminando puntos redundantes con base en la distancia mínima (`epsilon`).
        """
        simplified = [contour[0]]  # Comenzar con el primer punto
        for i in range(1, len(contour)):
            # Calcular distancia entre el último punto simplificado y el actual
            distance = np.linalg.norm(np.array(contour[i]) - np.array(simplified[-1]))
            if distance >= epsilon:  # Solo añadir si la distancia supera `epsilon`
                simplified.append(contour[i])
        # Asegurar que el contorno esté cerrado
        if np.linalg.norm(np.array(simplified[0]) - np.array(simplified[-1])) >= epsilon:
            simplified.append(simplified[0])
        return simplified

    # Calcular el centro y verificar si es un círculo
    def is_circle(contour, epsilon=3):
        contour = np.array(contour)
        centroid = np.mean(contour, axis=0)

        distances = np.linalg.norm(contour - centroid, axis=1)
        mean_distance = np.mean(distances)

        # Comprobar si todas las distancias son aproximadamente iguales
        if np.all(np.abs(distances - mean_distance) < epsilon):
            return True, centroid
        return False, centroid

    # Función para etiquetar formas según la longitud del contorno simplificado
    def is_triangle(len_simplified):
        if len_simplified == 3:
            return True
        else:
            return False

    # Función para calcular propiedades geométricas de un contorno
    def contour_properties(contour):
        """
        Calcula área, perímetro y relación de distancias al centroide para un contorno.
        """
        contour = np.array(contour)
        perimeter = np.sum([np.linalg.norm(contour[i] - contour[(i + 1) % len(contour)]) for i in range(len(contour))])
        area = 0.5 * np.abs(np.dot(contour[:, 0], np.roll(contour[:, 1], 1)) - np.dot(contour[:, 1], np.roll(contour[:, 0], 1)))
        centroid = np.mean(contour, axis=0)
        distances = np.linalg.norm(contour - centroid, axis=1)
        max_distance = np.max(distances)
        min_distance = np.min(distances)
        distance_ratio = max_distance / min_distance if min_distance != 0 else np.inf
        return area, perimeter, distance_ratio

    # Función para verificar si un contorno es un cuadrilátero
    def is_quadrilateral(contour):
        """
        Clasifica un contorno como cuadrilátero basándose en propiedades geométricas.
        """
        # Calcular propiedades del contorno
        contour = np.array(contour)
        area, perimeter, distance_ratio = contour_properties(contour)

        # Criterios para cuadriláteros
        if 1.2 <= distance_ratio <= 2.5 and perimeter > 250:  # Ajustar según tamaño esperado
            return True
        return False

    # Función para verificar si un contorno es un hexágono
    def is_hexagon(contour):
        """
        Clasifica un contorno como hexágono basado en propiedades geométricas.
        """
        # Calcular propiedades del contorno
        contour = np.array(contour)
        area, perimeter, distance_ratio = contour_properties(contour)
        # Criterios para hexágonos
        if 1.2 <= distance_ratio <= 2.5 and 0.01 <= area / (perimeter ** 2) <= 0.05:  # Ajustar según tamaño esperado
            return True
        return False    

    # Encontrar contornos
    contours = find_contours(binary_image)

    # Visualización de contornos originales y simplificados
    plt.figure(figsize=(10, 10))
    plt.imshow(image, cmap='gray')

    for contour in contours[1:]:
        original = np.array(contour)
        simplified = np.array(simplify_contour(contour, epsilon=65))  # Ajustar epsilon según sea necesario

        is_circle_flag, centroid = is_circle(contour)
        is_triangle_flag = is_triangle(len(simplified))

        if is_circle_flag:
            label = "Círculo"
        elif is_triangle_flag:
            label = "Triángulo"
        elif is_quadrilateral(original):  # Cuadrilátero
            label = "Cuadrilátero"
        elif is_hexagon(original):  # Hexágono
            label = "Hexágono"
        else:
            label = "No Clasificado"

        simplified_contour = np.array(contour)

        # Dibujar contorno simplificado
        plt.plot(simplified_contour[:, 1], simplified_contour[:, 0], 'o-', label=f"{label}")

        # Etiquetar en la posición media del contorno
        plt.text(centroid[1], centroid[0], label, color='black', fontsize=12, ha='center')

    plt.legend()
    plt.title("Contornos y Clasificación de Formas")
    plt.savefig(os.path.join(PROCESSED_FOLDER, f"processed_{filename}"))
    plt.close()

    # Retornar la ruta de la imagen procesada
    return os.path.join(PROCESSED_FOLDER, f"processed_{filename}")

# Ruta para servir las imágenes subidas y procesadas
@app.route('/uploads/<filename>')
def uploaded_file(filename):
    return send_from_directory(app.config['UPLOAD_FOLDER'], filename)

@app.route('/static/images/<filename>')
def processed_file(filename):
    return send_from_directory(app.config['PROCESSED_FOLDER'], filename)

if __name__ == '__main__':
    app.run(debug=True)
