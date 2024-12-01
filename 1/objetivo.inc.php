<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$rol = $_SESSION['rol']; // Obtener el rol del usuario desde la sesión

// Verificar que el rol tenga acceso a esta pantalla
if ($rol !== 'Auditoría Interna') {
    header('Location: index.php'); // Redirigir a dashboard si no tiene acceso
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objetivo - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir los estilos comunes -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Incluir el archivo navbar.inc.php -->
    <?php include('navbar.inc.php'); ?>

    <!-- Contenido principal -->
    <div class="content">
        <h2>Objetivo - Auditoría Interna</h2>
        <hr>
        
        <!-- Información del objetivo -->
        <div class="card">
            <div class="card-header">
                Objetivo de Auditoría Interna
            </div>
            <div class="card-body">
                <h5 class="card-title">Descripción del objetivo</h5>
                <p class="card-text">
                    Aquí puedes mostrar la descripción o el detalle del objetivo de Auditoría Interna.
                </p>
            </div>
        </div>

        <!-- Botones de acción -->
        <?php if ($rol === 'Auditoría Interna'): ?>
            <a href="editar_objetivo.inc.php" class="btn btn-primary mt-3">Editar Objetivo</a>
            <a href="eliminar_objetivo.inc.php" class="btn btn-danger mt-3">Eliminar Objetivo</a>
        <?php endif; ?>
    </div>

</body>
</html>
