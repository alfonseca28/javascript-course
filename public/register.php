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
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>

<body class="auth-page">
    <div class="form-container">
        <h2>Crear cuenta</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="nombre" placeholder="Nombre completo" required
                value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

            <input type="text" name="username" placeholder="Usuario" required
                value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

            <input type="email" name="correo" placeholder="Correo" required
                value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">

            <input type="password" name="password" placeholder="Contraseña" required>

            <input type="text" name="telefono" placeholder="Teléfono"
                value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">

            <input type="text" name="area" placeholder="Área"
                value="<?= htmlspecialchars($_POST['area'] ?? '') ?>">

            <input type="text" name="sede" placeholder="Sede"
                value="<?= htmlspecialchars($_POST['sede'] ?? '') ?>">

            <button type="submit">Registrarse</button>
        </form>

        <p>¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a></p>
    </div>
</body>

</html>