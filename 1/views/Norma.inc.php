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
if ($rol !== 'Cumplimiento') {
    header('Location: index.php'); // Redirigir a dashboard si no tiene acceso
    exit;
}

include('conectar.inc.php'); // Conectar a la base de datos

// Verificar si el tramite anterior tiene fecha de fin
$verificar_fecha_fin = "SELECT fecha_fin FROM `seguimiento` 
                        WHERE proceso LIKE '¿Existen Riesgos Significativos?' 
                        ORDER BY nrotramite DESC LIMIT 1;";
$stmt_verificar = $pdo->prepare($verificar_fecha_fin);
$stmt_verificar->execute();
$resultado = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

if ($resultado && $resultado['fecha_fin'] !== null) {
    // Si existe fecha_fin, continuar con la inserción del nuevo trámite
    if (isset($_POST['accion']) && $_POST['accion'] === 'anadir' && isset($_POST['descripcion_objetivo'])) {
        $descripcion_objetivo = $_POST['descripcion_objetivo'];

        // Insertar nuevo trámite en la tabla `seguimiento`
        $insertar_seguimiento = "INSERT INTO seguimiento (flujo, proceso, usuario, fecha_inicio, fecha_fin)
        SELECT (flujo + 1), 'Cumplimiento de Normas', :usuario, :fecha_inicio, NULL
        FROM `seguimiento` 
        WHERE proceso LIKE 'Cierre de Auditoría'
        ORDER BY nrotramite DESC
        LIMIT 1;";
        
        $stmt_insertar = $pdo->prepare($insertar_seguimiento);
        $stmt_insertar->bindParam(':usuario', $usuario);
        $stmt_insertar->bindParam(':fecha_inicio', $fechaInicio);

        if ($stmt_insertar->execute()) {
            // Segunda consulta: Insertar un registro en la tabla `cumplimiento`
            $insertar_objetivo = "INSERT INTO datosauditoria.cumplimiento 
            (nrotramite, CumplimientoDeNormas, CumpleConNormasYRegulaciones, AccionesCorrectivas) 
            VALUES (LAST_INSERT_ID(), :descripcion_objetivo, null, null)";

            // Preparar y ejecutar la consulta
            $stmt_objetivo = $pdo->prepare($insertar_objetivo);
            $stmt_objetivo->bindParam(':descripcion_objetivo', $descripcion_objetivo);

            // Ejecutar la segunda consulta
            if ($stmt_objetivo->execute()) {
                echo '<script type="text/javascript">
                        alert("¡Éxito! El trámite y la descripción se han registrado correctamente.");
                      </script>';
            } else {
                echo '<script type="text/javascript">
                        alert("¡Error! No se pudo registrar la descripción.");
                      </script>';
            }
        } else {
            echo '<script type="text/javascript">
                    alert("¡Error! Hubo un problema al registrar el trámite. Intenta nuevamente.");
                  </script>';
        }
    }
} else {
    echo '<script type="text/javascript">
            alert("¡Error! El trámite anterior no tiene fecha de fin. No se puede registrar un nuevo trámite.");
          </script>';
}


// Comprobar si se ha enviado un formulario de eliminación
if (isset($_POST['eliminar_objetivo'])) {
    $nrotramite = $_POST['nrotramite'];

    // Eliminar registro de la tabla `cumplimiento`
    $eliminar_objetivo = "DELETE FROM datosauditoria.cumplimiento WHERE nrotramite = :nrotramite";
    $stmt_eliminar = $pdo->prepare($eliminar_objetivo);
    $stmt_eliminar->bindParam(':nrotramite', $nrotramite);

    if ($stmt_eliminar->execute()) {
        echo '<script type="text/javascript">
                alert("¡Éxito! La descripción se ha eliminado correctamente.");
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("¡Error! No se pudo eliminar La descripción.");
              </script>';
    }
}

// Comprobar si se ha enviado un formulario de edición
if (isset($_POST['accion']) && $_POST['accion'] === 'editar' && isset($_POST['descripcion_objetivo'])) {
    $nrotramite = $_POST['nrotramite'];
    $descripcion_objetivo = $_POST['descripcion_objetivo'];

    // Actualizar La descripción en la tabla `cumplimiento`
    $actualizar_objetivo = "UPDATE datosauditoria.cumplimiento SET CumplimientoDeNormas = :descripcion_objetivo WHERE nrotramite = :nrotramite";
    $stmt_actualizar = $pdo->prepare($actualizar_objetivo);
    $stmt_actualizar->bindParam(':nrotramite', $nrotramite);
    $stmt_actualizar->bindParam(':descripcion_objetivo', $descripcion_objetivo);

    if ($stmt_actualizar->execute()) {
        echo '<script type="text/javascript">
                alert("¡Éxito! La descripción se ha actualizado correctamente.");
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("¡Error! No se pudo actualizar La descripción.");
              </script>';
    }
}

// Obtener los registros de la tabla cumplimiento
$query = "SELECT * FROM datosauditoria.cumplimiento where CumplimientoDeNormas is not null";
$stmt = $pdo->prepare($query);
$stmt->execute();
$registros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cumplimiento de Normas - Cumplimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php include('navbar.inc.php'); ?>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-9 offset-md-3">
                <h2>Cumplimiento de Normas - Cumplimiento</h2>
                <hr>
                <h4 class="mt-4">Añadir nuevo trámite</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label for="descripcion_objetivo" class="form-label">Descripción de la evaluación</label>
                        <textarea class="form-control" id="descripcion_objetivo" name="descripcion_objetivo" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="accion" value="anadir" class="btn btn-primary">Añadir Trámite</button>
                </form>

                <h4 class="mt-4">Evaluacion-Cumplimiento de Normas</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nro. Trámite</th>
                            <th scope="col">Descripción</th>
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
                                        <textarea class="form-control" name="descripcion_objetivo" rows="2"><?php echo $registro['CumplimientoDeNormas']; ?></textarea>
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
