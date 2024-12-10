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
if ($rol !== 'Gestión de Riesgos') {
    // Mostrar un mensaje antes de redirigir
    echo '<script type="text/javascript">';
    echo 'alert("No tienes acceso a esta página. Serás redirigido.");';
    echo 'window.location.href = "logout.php";';
    echo '</script>';

    exit;
}

include('conectar.inc.php'); // Conectar a la base de datos

// Verificar si existe una debilidad
$verificar_debilidad = "SELECT ExistenRiesgosSignificativos FROM datosauditoria.gestionriesgos 
                        ORDER BY nrotramite DESC LIMIT 1;";
$stmt_verificar = $pdo->prepare($verificar_debilidad);
$stmt_verificar->execute();
$resultado = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

if ($resultado && $resultado['ExistenRiesgosSignificativos'] !== 0) {
    
} else {
    echo '<script type="text/javascript">
            alert("¡Error! El trámite anterior no tiene debilidades.");
          </script>';
}


// Comprobar si se ha enviado un formulario de eliminación
if (isset($_POST['eliminar_objetivo'])) {
    $nrotramite = $_POST['nrotramite'];

    // Eliminar registro de la tabla `gestionriesgos`
    $eliminar_objetivo = "DELETE FROM datosauditoria.gestionriesgos WHERE nrotramite = :nrotramite";
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

    $insertar_seguimiento = "INSERT INTO seguimiento (nrotramite, flujo, proceso, usuario, fecha_inicio, fecha_fin) 
    VALUES (:nrotramite_a_actualizar, 1, 'Acciones de Mitigación de Riesgos', :usuario, :fecha_inicio, NULL);";
    $stmt_insertar = $pdo->prepare($insertar_seguimiento);
    $stmt_insertar->bindParam(':nrotramite_a_actualizar', $nrotramite);
    $stmt_insertar->bindParam(':usuario', $usuario);
    $stmt_insertar->bindParam(':fecha_inicio', $fechaInicio);
    $stmt_insertar->execute();

    // Actualizar La descripción en la tabla `gestionriesgos`
    $actualizar_objetivo = "UPDATE datosauditoria.gestionriesgos SET AccionesMitigacionRiesgos = :descripcion_objetivo WHERE nrotramite = :nrotramite";
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

// Obtener los registros de la tabla gestionriesgos
$query = "SELECT * FROM datosauditoria.gestionriesgos";
$stmt = $pdo->prepare($query);
$stmt->execute();
$registros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acciones De Mitigacion De Riesgos - Gestion De Riesgos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php include('navbar.inc.php'); ?>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-9 offset-md-3">
                <h2>Acciones De Mitigacion De Riesgos - Gestion De Riesgos</h2>
                <hr>

                <h4 class="mt-4">Evaluacion-Gestion De Riesgos</h4>
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
                                        <textarea class="form-control" name="descripcion_objetivo" rows="2"><?php echo $registro['AccionesMitigacionRiesgos']; ?></textarea>
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
