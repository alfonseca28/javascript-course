<?php
session_start();

// Si el usuario no ha iniciado sesión, lo mandamos al login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

// Obtenemos datos del usuario en sesión
$nombre = $_SESSION['nombre'];
$rol_id = $_SESSION['rol_id']; // 1 = Admin, 2 = Usuario normal
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | Quiniela</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <!-- Header -->
    <header class="main-header">
        <div class="logo">
            <img src="../assets/images/logos/logo.png" alt="Logo Quiniela" />
            <h1>Quiniela MX</h1>
        </div>
        <nav class="nav-links">
            <a href="dashboard.php" class="active">Inicio</a>
            <?php if ($rol_id == 1): ?>
                <a href="#">Admin</a>
            <?php endif; ?>
            <a href="logout.php" class="logout-btn">Cerrar sesión</a>
        </nav>
    </header>

    <!-- Contenido principal -->
    <main class="dashboard-container">
        <h2>Bienvenido, <?= htmlspecialchars($nombre) ?> 👋</h2>

        <?php if ($rol_id == 1): ?>
            <p class="role-badge admin">Rol: Administrador</p>
        <?php else: ?>
            <p class="role-badge user">Rol: Usuario</p>
        <?php endif; ?>

        <section class="content-section">
            <h3>Panel principal</h3>
            <p>Desde aquí podrás participar en las quinielas de la Liguilla MX 2025.</p>

            <div class="cards-grid">
                <div class="card">
                    <h4>Mi Quiniela</h4>
                    <p>Revisa tus pronósticos y resultados.</p>
                    <button>Ver quiniela</button>
                </div>
                <div class="card">
                    <h4>Resultados</h4>
                    <p>Consulta los resultados de cada jornada.</p>
                    <button>Ver resultados</button>
                </div>
                <?php if ($rol_id == 1): ?>
                    <div class="card">
                        <h4>Administrar</h4>
                        <p>Gestiona usuarios, jornadas y partidos.</p>
                        <button>Ir al panel admin</button>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>

</html>