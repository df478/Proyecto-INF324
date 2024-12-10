<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

date_default_timezone_set('America/La_Paz');

// Incluir la conexión a la base de datos
include('conectar.inc.php');

// Consultar los datos de la tabla seguimiento usando PDO
try {
    $rol = $_SESSION['rol'];
    $sql = "SELECT * FROM `seguimiento`";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} catch (PDOException $e) {
    die("Error al ejecutar la consulta: " . $e->getMessage());
}

// Manejar la eliminación de un registro
if (isset($_POST['eliminar_tramite'])) {
    $id = $_POST['id'];

    try {
        // Intentar eliminar el trámite
        $eliminar_tramite = "DELETE FROM `seguimiento` WHERE id = :id";
        $stmt_eliminar = $pdo->prepare($eliminar_tramite);
        $stmt_eliminar->bindParam(':id', $id);

        // Ejecutar la eliminación
        if ($stmt_eliminar->execute()) {
            echo '<script>alert("¡Éxito! El trámite ha sido eliminado correctamente.");</script>';
        }
    } catch (PDOException $e) {
        // Si hay un error (como la violación de la clave foránea), mostrar el mensaje de error
        if ($e->getCode() == 23000) { // Código de error para violación de clave foránea
            echo '<script>alert("¡Error! No se pudo eliminar el trámite porque tiene registros relacionados.");</script>';
        } else {
            echo '<script>alert("¡Error! Hubo un problema al intentar eliminar el trámite.");</script>';
        }
    }
}


// Manejar la finalización de un trámite
// Manejar la finalización de un trámite
if (isset($_POST['finalizar_tramite'])) {
    $id = $_POST['id'];
    $fecha_fin = date('Y-m-d'); // Obtener la fecha y hora actual

    // Verificar si el campo fecha_fin es NULL antes de proceder
    $verificar_fecha_fin = "SELECT fecha_fin FROM `seguimiento` WHERE id = :id";
    $stmt_verificar = $pdo->prepare($verificar_fecha_fin);
    $stmt_verificar->bindParam(':id', $id);
    $stmt_verificar->execute();
    $resultado = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

    if ($resultado && $resultado['fecha_fin'] === null) {
        // Si fecha_fin es NULL, proceder con la actualización
        $finalizar_tramite = "UPDATE `seguimiento` SET fecha_fin = :fecha_fin WHERE id = :id";
        $stmt_finalizar = $pdo->prepare($finalizar_tramite);
        $stmt_finalizar->bindParam(':fecha_fin', $fecha_fin);
        $stmt_finalizar->bindParam(':id', $id);

        if ($stmt_finalizar->execute()) {
            echo '<script>alert("¡Éxito! El trámite ha sido finalizado correctamente.");</script>';
        } else {
            echo '<script>alert("¡Error! No se pudo finalizar el trámite.");</script>';
        }
    } else {
        // Si fecha_fin no es NULL, mostrar un mensaje de error
        echo '<script>alert("¡Error! El trámite ya ha sido finalizado anteriormente.");</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>" . $row["nrotramite"] . "</td>
                                <td>" . $row["flujo"] . "</td>
                                <td>" . $row["proceso"] . "</td>
                                <td>" . $row["usuario"] . "</td>
                                <td>" . $row["fecha_inicio"] . "</td>
                                <td>" . $row["fecha_fin"] . "</td>
                                <td>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                                        <button type='submit' name='eliminar_tramite' class='btn btn-danger btn-sm'>Eliminar</button>
                                    </form>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                                        <button type='submit' name='finalizar_tramite' class='btn btn-success btn-sm'>Finalizar</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No hay datos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
