<?php
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';

$auth = new AuthController($pdo);

// Capturar mensajes de error en sesión
$error = "";
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // se borra para que no aparezca nuevamente
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->login();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión | Quiniela</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>

<body class="auth-page">
    <div class="form-container">
        <h2>Iniciar sesión</h2>

        <!-- NOTIFICACIÓN DE REGISTRO EXITOSO -->
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
            <div class="alert success show">
                Registro exitoso. Ahora puedes iniciar sesión.
            </div>
        <?php endif; ?>

        <!-- NOTIFICACIÓN DE ERROR -->
        <?php if (!empty($error)): ?>
            <div class="alert error show">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="login" placeholder="Usuario o correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>

        <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
    </div>

    <!-- SCRIPT PARA QUE LA ALERTA SE OCUlTE AUTOMÁTICAMENTE -->
    <script>
        const alert = document.querySelector(".alert");
        if (alert) {
            setTimeout(() => {
                alert.classList.remove("show");
            }, 3000);
        }
    </script>

</body>

</html>