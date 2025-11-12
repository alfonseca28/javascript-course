<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<header class="navbar">
    <h1>⚽ Quiniela MX</h1>
    <nav>
        <a href="dashboard.php">Inicio</a>
        <a href="apuestas.php">Apostar</a>
        <a href="resultados.php">Resultados</a>
        <a href="perfil.php">Perfil</a>
        <a href="../actions/logout.php" class="logout">Cerrar sesión</a>
    </nav>
</header>

<style>
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #1e88e5;
        color: white;
        padding: 1rem 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar h1 {
        margin: 0;
        font-size: 1.5rem;
    }

    .navbar nav a {
        color: white;
        text-decoration: none;
        margin-left: 1.5rem;
        font-weight: 500;
        transition: 0.3s;
    }

    .navbar nav a:hover {
        text-decoration: underline;
    }

    .logout {
        background: white;
        color: #1e88e5 !important;
        padding: 0.4rem 0.8rem;
        border-radius: 0.3rem;
    }

    .logout:hover {
        background: #f0f0f0;
    }
</style>