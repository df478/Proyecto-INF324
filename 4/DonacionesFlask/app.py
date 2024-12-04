
from flask import Flask,render_template, request, redirect, url_for
from flask_mysqldb import MySQL
from config import Config


app = Flask(__name__)
app.config.from_object(Config)
mysql = MySQL(app)

# Ruta para mostrar las campañas
@app.route('/')
def index():
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM campañas")
    campañas = cur.fetchall()
    cur.close()
    return render_template('index.html', campañas=campañas)

# Ruta para crear una nueva donación
@app.route('/create_donacion', methods=['GET', 'POST'])
def create_donacion():
    if request.method == 'POST':
        donante_id = request.form['donante_id']
        campaña_id = request.form['campaña_id']
        método_pago_id = request.form['método_pago_id']
        monto = request.form['monto']
        fecha = request.form['fecha']

        cursor = mysql.connection.cursor()
        cursor.execute('''INSERT INTO donaciones (donante_id, campaña_id, método_pago_id, monto, fecha) 
                          VALUES (%s, %s, %s, %s, %s)''', 
                       (donante_id, campaña_id, método_pago_id, monto, fecha))
        mysql.connection.commit()
        cursor.close()
        return redirect(url_for('index'))

    # Obtener las opciones para los select (donantes, campañas, métodos de pago)
    cursor = mysql.connection.cursor()
    cursor.execute('SELECT * FROM donantes')
    donantes = cursor.fetchall()

    cursor.execute('SELECT * FROM campañas')
    campañas = cursor.fetchall()

    cursor.execute('SELECT * FROM metodospago')
    metodospago = cursor.fetchall()

    return render_template('create_donacion.html', donantes=donantes, campañas=campañas, metodospago=metodospago)

# Ruta para listar todas las donaciones
@app.route('/donaciones')
def donaciones():
    cursor = mysql.connection.cursor()
    cursor.execute('''SELECT donaciones.id, donantes.nombre AS donante, campañas.nombre AS campaña, 
                             metodospago.nombre AS método_pago, monto, fecha 
                      FROM donaciones
                      JOIN donantes ON donantes.id = donaciones.donante_id
                      JOIN campañas ON campañas.id = donaciones.campaña_id
                      JOIN metodospago ON metodospago.id = donaciones.método_pago_id''')
    donaciones = cursor.fetchall()
    return render_template('donaciones.html', donaciones=donaciones)

# Ruta para eliminar una donación
@app.route('/delete_donacion/<int:id>', methods=['POST'])
def delete_donacion(id):
    cursor = mysql.connection.cursor()
    cursor.execute('DELETE FROM donaciones WHERE id = %s', (id,))
    mysql.connection.commit()
    cursor.close()
    return redirect(url_for('donaciones'))

# Ruta para editar una donación
@app.route('/edit_donacion/<int:id>', methods=['GET', 'POST'])
def edit_donacion(id):
    cursor = mysql.connection.cursor()
    cursor.execute('SELECT * FROM donaciones WHERE id = %s', (id,))
    donacion = cursor.fetchone()

    cursor.execute('SELECT * FROM donantes')
    donantes = cursor.fetchall()

    cursor.execute('SELECT * FROM campañas')
    campañas = cursor.fetchall()

    cursor.execute('SELECT * FROM metodospago')
    metodospago = cursor.fetchall()

    if request.method == 'POST':
        donante_id = request.form['donante_id']
        campaña_id = request.form['campaña_id']
        método_pago_id = request.form['método_pago_id']
        monto = request.form['monto']
        fecha = request.form['fecha']

        cursor.execute('''UPDATE donaciones SET donante_id = %s, campaña_id = %s, 
                          método_pago_id = %s, monto = %s, fecha = %s WHERE id = %s''',
                       (donante_id, campaña_id, método_pago_id, monto, fecha, id))
        mysql.connection.commit()
        cursor.close()
        return redirect(url_for('donaciones'))

    return render_template('edit_donacion.html', donacion=donacion, donantes=donantes, campañas=campañas, metodospago=metodospago)

# Ruta para crear un nuevo donante
@app.route('/create_donante', methods=['GET', 'POST'])
def create_donante():
    if request.method == 'POST':
        nombre = request.form['nombre']
        correo  = request.form['correo']
        telefono = request.form['telefono']

        cursor = mysql.connection.cursor()
        cursor.execute('''INSERT INTO donantes (nombre, correo, teléfono) 
                          VALUES (%s, %s, %s)''', (nombre, correo , telefono))
        mysql.connection.commit()
        cursor.close()
        return redirect(url_for('donantes'))

    return render_template('create_donante.html')

# Ruta para listar todos los donantes
@app.route('/donantes')
def donantes():
    cursor = mysql.connection.cursor()
    cursor.execute('SELECT * FROM donantes')
    donantes = cursor.fetchall()
    return render_template('donantes.html', donantes=donantes)

# Ruta para eliminar un donante
@app.route('/delete_donante/<int:id>', methods=['POST'])
def delete_donante(id):
    cursor = mysql.connection.cursor()
    cursor.execute('DELETE FROM donantes WHERE id = %s', (id,))
    mysql.connection.commit()
    cursor.close()
    return redirect(url_for('donantes'))

# Ruta para editar un donante
@app.route('/edit_donante/<int:id>', methods=['GET', 'POST'])
def edit_donante(id):
    cursor = mysql.connection.cursor()
    cursor.execute('SELECT * FROM donantes WHERE id = %s', (id,))
    donante = cursor.fetchone()

    if request.method == 'POST':
        nombre = request.form['nombre']
        correo = request.form['correo']
        telefono = request.form['telefono']

        cursor.execute('''UPDATE donantes SET nombre = %s, correo = %s, teléfono = %s WHERE id = %s''',
                       (nombre, correo, telefono, id))
        mysql.connection.commit()
        cursor.close()
        return redirect(url_for('donantes'))

    return render_template('edit_donante.html', donante=donante)
# Ruta para mostrar los metodos de pago
@app.route('/metodospago')
def metodospago():
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM metodospago")
    pagos = cur.fetchall()
    cur.close()
    return render_template('metodospago.html', pagos=pagos)

if __name__ == '__main__':
    app.run(debug=True)
