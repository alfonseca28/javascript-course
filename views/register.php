<?php
// views/register.php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

$pageTitle = "Crear cuenta - Quiniela MX";
$styles = ['/public/css/auth.css'];
include('../includes/header.php');
?>
<div class="auth-wrap">
    <div class="auth-card" role="main" aria-labelledby="register-title">
        <h2 id="register-title"><span class="icon">📝</span> Crear cuenta</h2>

        <?php if (!empty($_SESSION['error'])): ?>
            <div style="margin-bottom:12px;color:#ffb4b4;background:#4d2b2b;padding:8px;border-radius:8px;">
                <?php echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="../actions/register_action.php" method="POST" novalidate>
            <div class="input-group">
                <label class="input-label" for="nombre">Nombre completo</label>
                <input id="nombre" class="input-field" type="text" name="nombre" placeholder="Nombre completo" required>
            </div>

            <div class="input-group">
                <label class="input-label" for="username">Nombre de usuario</label>
                <input id="username" class="input-field" type="text" name="username" placeholder="Usuario" required>
            </div>

            <div class="input-group">
                <label class="input-label" for="correo">Correo electrónico</label>
                <input id="correo" class="input-field" type="email" name="correo" placeholder="tu@correo.com" required>
            </div>

            <div class="input-group">
                <label class="input-label" for="telefono">Número de teléfono</label>
                <input id="telefono" class="input-field" type="tel" name="telefono" placeholder="55 1234 5678">
            </div>

            <div class="input-group">
                <label class="input-label" for="area">Área o departamento</label>
                <input id="area" class="input-field" type="text" name="area" placeholder="IT, Marketing, etc.">
            </div>

            <div class="input-group">
                <label class="input-label" for="sede">Sede</label>
                <input id="sede" class="input-field" type="text" name="sede" placeholder="CDMX, Monterrey...">
            </div>

            <div class="input-group">
                <label class="input-label" for="password">Contraseña</label>
                <input id="password" class="input-field" type="password" name="password" placeholder="••••••••" required>
            </div>

            <button class="btn-primary" type="submit">Registrarse</button>
        </form>

        <div class="auth-footer">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
        </div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>