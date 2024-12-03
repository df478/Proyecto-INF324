import os
import cv2
import numpy as np
from flask import Flask, render_template, request, redirect, url_for, send_from_directory

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
    # Leer la imagen
    image = cv2.imread(filepath)

    # Convertir la imagen a escala de grises
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    # Aplicar un umbral para detectar bordes
    _, threshold  = cv2.threshold(gray, 127, 255, cv2.THRESH_BINARY)

    # Encontrar los contornos en la imagen umbralizada
    contours, _ = cv2.findContours(threshold , cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)

    i=0

    # Dibujar las formas geométricas encontradas
    for contour in contours:
        # here we are ignoring first counter because  
        # findcontour function detects whole image as shape 
        if i == 0: 
            i = 1
            continue

        # cv2.approxPloyDP() function to approximate the shape 
        approx = cv2.approxPolyDP( 
        contour, 0.01 * cv2.arcLength(contour, True), True)

        # using drawContours() function 
        cv2.drawContours(image, [contour], 0, (69, 182, 255), 5)

        # finding center point of shape 
        M = cv2.moments(contour) 
        if M['m00'] != 0.0: 
            x = int(M['m10']/M['m00']) 
            y = int(M['m01']/M['m00']) 

        # putting shape name at center of each shape 
        if len(approx) == 3: 
            cv2.putText(image, 'Triangulo', (x, y), 
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 0, 0), 2) 
    
        elif len(approx) == 4: 
            cv2.putText(image, 'Cuadrilatero', (x, y), 
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 0, 0), 2) 
    
        elif len(approx) == 5: 
            cv2.putText(image, 'Pentagono', (x, y), 
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 0, 0), 2) 
    
        elif len(approx) == 6: 
            cv2.putText(image, 'Hexagono', (x, y), 
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 0, 0), 2) 
  
        else: 
            cv2.putText(image, 'Circulo', (x, y), 
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 0, 0), 2) 

    # Guardar la imagen procesada
    processed_image_path = os.path.join(PROCESSED_FOLDER, f"processed_{filename}")
    cv2.imwrite(processed_image_path, image)

    return processed_image_path

# Ruta para servir las imágenes subidas y procesadas
@app.route('/uploads/<filename>')
def uploaded_file(filename):
    return send_from_directory(app.config['UPLOAD_FOLDER'], filename)

@app.route('/static/images/<filename>')
def processed_file(filename):
    return send_from_directory(app.config['PROCESSED_FOLDER'], filename)

if __name__ == '__main__':
    app.run(debug=True)
