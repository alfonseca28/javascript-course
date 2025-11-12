<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión | Quiniela MX</title>
  <link rel="stylesheet" href="../public/css/styles.css">
</head>
<body>
  <div class="container">
    <h2>Iniciar sesión</h2>
    <form action="../actions/login_action.php" method="POST">
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button type="submit">Entrar</button>
    </form>
    <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
  </div>
</body>
</html>
