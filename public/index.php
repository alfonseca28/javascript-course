<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';

$auth = new AuthController($pdo);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->login();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión | Quiniela</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="auth-page">
    <div class="form-container">
        <h2>Iniciar sesión</h2>
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
            <p class="success">Registro exitoso. Ahora puedes iniciar sesión.</p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="login" placeholder="Usuario o correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
    </div>
</body>

</html>