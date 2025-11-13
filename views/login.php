<?php
// views/login.php
session_start();
if (isset($_SESSION['usuario_id'])) {
  header("Location: dashboard.php");
  exit;
}

$pageTitle = "Iniciar sesión - Quiniela MX";
// indicamos estilos extra (rutas absolutas desde web root)
$styles = ['/public/css/auth.css'];
include('../includes/header.php');
?>
<div class="auth-wrap">
  <div class="auth-card" role="main" aria-labelledby="login-title">
    <h2 id="login-title"><span class="icon">🔐</span> Iniciar sesión</h2>

    <?php if (!empty($_SESSION['error'])): ?>
      <div style="margin-bottom:12px;color:#ffb4b4;background:#4d2b2b;padding:8px;border-radius:8px;">
        <?php echo htmlspecialchars($_SESSION['error']);
        unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>

    <form action="../actions/login_action.php" method="POST" novalidate>
      <div class="input-group">
        <label class="input-label" for="correo">Correo electrónico</label>
        <input id="correo" class="input-field" type="email" name="correo" placeholder="tu@correo.com" required>
      </div>

      <div class="input-group">
        <label class="input-label" for="password">Contraseña</label>
        <input id="password" class="input-field" type="password" name="password" placeholder="••••••••" required>
      </div>

      <button class="btn-primary" type="submit">Entrar</button>
    </form>

    <div class="auth-footer">
      ¿No tienes cuenta? <a href="register.php">Regístrate aquí</a>
    </div>
  </div>
</div>
<?php include('../includes/footer.php'); ?>