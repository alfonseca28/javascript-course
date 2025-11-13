<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';

$auth = new AuthController($pdo);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->register();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro | Quiniela</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="form-container">
        <h2>Crear cuenta</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="email" name="correo" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a></p>
    </div>
</body>

</html>