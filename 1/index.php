<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Incluir la conexión a la base de datos
include('conectar.inc.php');

// Consultar los datos de la tabla seguimiento usando PDO
try {
    $sql = "SELECT * FROM seguimiento";
    $stmt = $pdo->query($sql);
} catch (PDOException $e) {
    die("Error al ejecutar la consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir los estilos comunes -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Incluir el archivo navbar.inc.php -->
    <?php include('navbar.inc.php'); ?>

    <!-- Contenido principal -->
    <div class="content">
        <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Rol: <?php echo $_SESSION['rol']; ?>)</h2>
        <hr>

        <!-- Tabla con los datos de seguimiento -->
        <h3>Datos de Seguimiento</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nro Trámite</th>
                    <th>Flujo</th>
                    <th>Proceso</th>
                    <th>Usuario</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar si hay resultados
                if ($stmt->rowCount() > 0) {
                    // Mostrar los datos de cada fila
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>" . $row["nrotramite"] . "</td>
                                <td>" . $row["flujo"] . "</td>
                                <td>" . $row["proceso"] . "</td>
                                <td>" . $row["usuario"] . "</td>
                                <td>" . $row["fecha_inicio"] . "</td>
                                <td>" . $row["fecha_fin"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No hay datos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
