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
if ($rol !== 'Auditoría Interna') {
    // Mostrar un mensaje antes de redirigir
    echo '<script type="text/javascript">';
    echo 'alert("No tienes acceso a esta página. Serás redirigido.");';
    echo 'window.location.href = "logout.php";';
    echo '</script>';

    exit;
}

include('conectar.inc.php'); // Conectar a la base de datos

// Comprobar si el formulario para agregar un nuevo trámite ha sido enviado
if (isset($_POST['accion']) && $_POST['accion'] === 'anadir' && isset($_POST['descripcion_objetivo'])) {
    $descripcion_objetivo = $_POST['descripcion_objetivo'];

    // Insertar nuevo trámite en la tabla `seguimiento`
    $insertar_seguimiento = "INSERT INTO seguimiento (nrotramite,flujo, proceso, usuario, fecha_inicio, fecha_fin)
    SELECT (nrotramite+1),(select f.Flujo from flujoauditoria f where f.Proceso like 'Establecer Objetivos del Desempeño') , 'Establecer Objetivos del Desempeño', :usuario, :fecha_inicio, NULL
    FROM `seguimiento` s
    ORDER BY nrotramite DESC
    LIMIT 1;
    ";
    $stmt = $pdo->prepare($insertar_seguimiento);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':fecha_inicio', $fechaInicio);
    
    if ($stmt->execute()) {
        // Segunda consulta: Insertar registros en la tabla `auditoriainterna`
        $insertar_objetivo = "INSERT INTO datosauditoria.auditoriainterna (nrotramite, EstablecerObjetivosDesempeno, DefinirObjetivosAuditoria, SeAceptanRecomendaciones, SeguimientoRecomendaciones, CierreAuditoria, ResolucionObservacionesRecomendaciones) VALUES ((SELECT (nrotramite) FROM `seguimiento` ORDER BY nrotramite DESC LIMIT 1), :descripcion_objetivo, null, null, null, null, null)";
        $stmt_objetivo = $pdo->prepare($insertar_objetivo);
        $stmt_objetivo->bindParam(':descripcion_objetivo', $descripcion_objetivo);
        $stmt_objetivo->execute();

        $insertar_objetivo = "INSERT INTO datosauditoria.controlinterno (nrotramite, EvaluacionControlInterno, HayDebilidadesControlInterno, RegistrarRecomendaciones) VALUES ((SELECT (nrotramite) FROM `seguimiento` ORDER BY nrotramite DESC LIMIT 1), null, null, null)";
        $stmt_objetivo = $pdo->prepare($insertar_objetivo);
        $stmt_objetivo->execute();

        $insertar_objetivo = "INSERT INTO datosauditoria.cumplimiento (nrotramite, CumplimientoDeNormas, CumpleConNormasYRegulaciones, AccionesCorrectivas) VALUES ((SELECT (nrotramite) FROM `seguimiento` ORDER BY nrotramite DESC LIMIT 1), null, null, null)";
        $stmt_objetivo = $pdo->prepare($insertar_objetivo);
        $stmt_objetivo->execute();

        $insertar_objetivo = "INSERT INTO datosauditoria.gestionriesgos (nrotramite, GestionDeRiesgos, ExistenRiesgosSignificativos	, AccionesMitigacionRiesgos) VALUES ((SELECT (nrotramite) FROM `seguimiento` ORDER BY nrotramite DESC LIMIT 1), null, null, null)";
        $stmt_objetivo = $pdo->prepare($insertar_objetivo);
        $stmt_objetivo->execute();

        $insertar_objetivo = "INSERT INTO datosauditoria.operaciones (nrotramite, EficienciaOperativa, EsEficienteLaOperacion	, PropuestasDeMejoraOperativa) VALUES ((SELECT (nrotramite) FROM `seguimiento` ORDER BY nrotramite DESC LIMIT 1), null, null, null)";
        $stmt_objetivo = $pdo->prepare($insertar_objetivo);
        $stmt_objetivo->execute();

        $insertar_objetivo = "INSERT INTO datosauditoria.planeacionestrategica (nrotramite, MedicionDelDesempeno, SeCumplenLosObjetivosDelDesempeno	, RecomendacionesParaMejorarDesempeno, ElaboracionDeInformes) VALUES ((SELECT (nrotramite) FROM `seguimiento` ORDER BY nrotramite DESC LIMIT 1), null, null, null,null)";
        $stmt_objetivo = $pdo->prepare($insertar_objetivo);

        // Ejecutar la segunda consulta
        if ($stmt_objetivo->execute()) {
            echo '<script type="text/javascript">
                    alert("¡Éxito! El trámite y los objetivos se han registrado correctamente.");
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    alert("¡Error! No se pudo registrar los objetivos.");
                  </script>';
        }
    } else {
        echo '<script type="text/javascript">
                alert("¡Error! Hubo un problema al registrar el trámite. Intenta nuevamente.");
              </script>';
    }
}

// Comprobar si se ha enviado un formulario de eliminación
if (isset($_POST['eliminar_objetivo'])) {
    $nrotramite = $_POST['nrotramite'];

    // Eliminar registro de la tabla `auditoriainterna`
    $eliminar_objetivo = "DELETE FROM datosauditoria.auditoriainterna WHERE nrotramite = :nrotramite";
    $stmt_eliminar = $pdo->prepare($eliminar_objetivo);
    $stmt_eliminar->bindParam(':nrotramite', $nrotramite);

    if ($stmt_eliminar->execute()) {
        echo '<script type="text/javascript">
                alert("¡Éxito! El objetivo se ha eliminado correctamente.");
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("¡Error! No se pudo eliminar el objetivo.");
              </script>';
    }
}

// Comprobar si se ha enviado un formulario de edición
if (isset($_POST['accion']) && $_POST['accion'] === 'editar' && isset($_POST['descripcion_objetivo'])) {
    $nrotramite = $_POST['nrotramite'];
    $descripcion_objetivo = $_POST['descripcion_objetivo'];

    // Actualizar el objetivo en la tabla `auditoriainterna`
    $actualizar_objetivo = "UPDATE datosauditoria.auditoriainterna SET EstablecerObjetivosDesempeno = :descripcion_objetivo WHERE nrotramite = :nrotramite";
    $stmt_actualizar = $pdo->prepare($actualizar_objetivo);
    $stmt_actualizar->bindParam(':nrotramite', $nrotramite);
    $stmt_actualizar->bindParam(':descripcion_objetivo', $descripcion_objetivo);

    if ($stmt_actualizar->execute()) {
        echo '<script type="text/javascript">
                alert("¡Éxito! El objetivo se ha actualizado correctamente.");
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("¡Error! No se pudo actualizar el objetivo.");
              </script>';
    }
}

// Obtener los registros de la tabla auditoriainterna
$query = "SELECT * FROM datosauditoria.auditoriainterna";
$stmt = $pdo->prepare($query);
$stmt->execute();
$registros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objetivo - Auditoría Interna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php include('navbar.inc.php'); ?>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-9 offset-md-3">
                <h2>Objetivo - Auditoría Interna</h2>
                <hr>
                <h4 class="mt-4">Añadir nuevo trámite</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label for="descripcion_objetivo" class="form-label">Descripción del Objetivo</label>
                        <textarea class="form-control" id="descripcion_objetivo" name="descripcion_objetivo" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="accion" value="anadir" class="btn btn-primary">Añadir Trámite</button>
                </form>

                <h4 class="mt-4">Objetivos de Auditoría Interna</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nro. Trámite</th>
                            <th scope="col">Descripción del Objetivo</th>
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
                                        <textarea class="form-control" name="descripcion_objetivo" rows="2"><?php echo $registro['EstablecerObjetivosDesempeno']; ?></textarea>
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
