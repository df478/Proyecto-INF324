<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

date_default_timezone_set('America/La_Paz');

$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol']; // Obtener el rol del usuario desde la sesión
$fechaInicio = date('Y-m-d');
// Verificar que el rol tenga acceso a esta pantalla
if ($rol !== 'Control Interno') {
    // Mostrar un mensaje antes de redirigir
    echo '<script type="text/javascript">';
    echo 'alert("No tienes acceso a esta página. Serás redirigido.");';
    echo 'window.location.href = "logout.php";';
    echo '</script>';

    exit;
}

include('conectar.inc.php'); // Conectar a la base de datos

// Verificar si el tramite anterior tiene fecha de fin
$verificar_fecha_fin = "SELECT fecha_fin FROM `seguimiento` 
                        WHERE proceso LIKE 'Evaluación del Control Interno' 
                        ORDER BY nrotramite DESC LIMIT 1;";
$stmt_verificar = $pdo->prepare($verificar_fecha_fin);
$stmt_verificar->execute();
$resultado = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

if ($resultado && $resultado['fecha_fin'] !== null) {
    
} else {
    echo '<script type="text/javascript">
            alert("¡Error! El trámite anterior no tiene fecha de fin. No se puede registrar un nuevo trámite.");
          </script>';
}


// Comprobar si se ha enviado un formulario de eliminación
if (isset($_POST['eliminar_objetivo'])) {
    $nrotramite = $_POST['nrotramite'];

    // Eliminar registro de la tabla `controlinterno`
    $eliminar_objetivo = "DELETE FROM datosauditoria.controlinterno WHERE nrotramite = :nrotramite";
    $stmt_eliminar = $pdo->prepare($eliminar_objetivo);
    $stmt_eliminar->bindParam(':nrotramite', $nrotramite);

    if ($stmt_eliminar->execute()) {
        echo '<script type="text/javascript">
                alert("¡Éxito! La desicion se ha eliminado correctamente.");
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("¡Error! No se pudo eliminar La desicion.");
              </script>';
    }
}

// Comprobar si se ha enviado un formulario de edición
if (isset($_POST['accion']) && $_POST['accion'] === 'editar' && isset($_POST['descripcion_objetivo'])) {
    $nrotramite = $_POST['nrotramite'];
    $descripcion_objetivo = $_POST['descripcion_objetivo'];

    // Validar y convertir el valor de $descripcion_objetivo a los valores adecuados para la base de datos
    if ($descripcion_objetivo === 'No se evalúo') {
        $descripcion_objetivo_db = null;  // Si es "No se evalúo", almacenamos NULL
    } elseif ($descripcion_objetivo === 'NO') {
        $descripcion_objetivo_db = 0;  // Si es "NO", almacenamos 0
    } elseif ($descripcion_objetivo === 'SI') {
        $descripcion_objetivo_db = 1;  // Si es "SI", almacenamos 1
    } else {
        // Si el valor no es válido, mostramos un mensaje de error
        echo '<script type="text/javascript">
                alert("¡Error! Valor de descripción no válido.");
              </script>';
        exit;
    }

    // Actualizar la decisión en la tabla `controlinterno`
    $actualizar_objetivo = "UPDATE datosauditoria.controlinterno SET HayDebilidadesControlInterno = :descripcion_objetivo WHERE nrotramite = :nrotramite";
    $stmt_actualizar = $pdo->prepare($actualizar_objetivo);
    $stmt_actualizar->bindParam(':nrotramite', $nrotramite);
    $stmt_actualizar->bindParam(':descripcion_objetivo', $descripcion_objetivo_db);

    if ($stmt_actualizar->execute()) {
        echo '<script type="text/javascript">
                alert("¡Éxito! La decisión se ha actualizado correctamente.");
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("¡Error! No se pudo actualizar la decisión.");
              </script>';
    }

    $insertar_seguimiento = "INSERT INTO seguimiento (nrotramite, flujo, proceso, usuario, fecha_inicio, fecha_fin) 
    VALUES (:nrotramite_a_actualizar, 1, '¿Hay Debilidades en el Control Interno?', :usuario, :fecha_inicio, NULL);";
    $stmt_insertar = $pdo->prepare($insertar_seguimiento);
    $stmt_insertar->bindParam(':nrotramite_a_actualizar', $nrotramite);
    $stmt_insertar->bindParam(':usuario', $usuario);
    $stmt_insertar->bindParam(':fecha_inicio', $fechaInicio);
    $stmt_insertar->execute();
}


// Obtener los registros de la tabla controlinterno
$query = "SELECT * FROM datosauditoria.controlinterno";
$stmt = $pdo->prepare($query);
$stmt->execute();
$registros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Hay Debilidades en el Control Interno?</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php include('navbar.inc.php'); ?>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-9 offset-md-3">
                <h2>¿Hay Debilidades en el Control Interno?</h2>
                <hr>

                <h4 class="mt-4">Evaluacion-Control-Interno</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nro. Trámite</th>
                            <th scope="col">¿Hay Debilidades en el Control Interno?</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registros as $registro): ?>
                            <tr>
                                <td><?php echo $registro['nrotramite']; ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="nrotramite" value="<?php echo $registro['nrotramite']; ?>">

                                        <?php
                                        $descripcion = ($registro['HayDebilidadesControlInterno'] === null) ? 'No se evalúo' : (($registro['HayDebilidadesControlInterno'] === 0) ? 'NO' : 'SI');
                                        ?>

                                        <select class="form-control" name="descripcion_objetivo">
                                            <option value="No se evalúo" <?php echo ($descripcion === 'No se evalúo') ? 'selected' : ''; ?>>No se evalúo</option>
                                            <option value="NO" <?php echo ($descripcion === 'NO') ? 'selected' : ''; ?>>NO</option>
                                            <option value="SI" <?php echo ($descripcion === 'SI') ? 'selected' : ''; ?>>SI</option>
                                        </select>

                                        <button type="submit" name="accion" value="editar" class="btn btn-warning mt-2">Actualizar</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="nrotramite" value="<?php echo $registro['nrotramite']; ?>">
                                        <button type="submit" name="eliminar_objetivo" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
