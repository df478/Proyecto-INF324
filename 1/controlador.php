<?php
session_start();
include 'conectar.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $clave = $_POST['clave'] ?? '';

    // Consulta para verificar el usuario
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar contraseña sin hash
    if ($user && $clave === $user['clave']) {
        // Iniciar sesión
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['rol'] = $user['rol'];
        header('Location: index.php');
        exit;
    } else {
        // Mensaje de error
        $error = $user ? "Contraseña incorrecta." : "Usuario no encontrado.";
        $_SESSION['error'] = $error;
        header('Location: login.php');
        exit;
    }
}
?>
