<?php
// includes/header.php
// Uso recomendado:
// $pageTitle = "Dashboard | Quiniela MX";
// $styles = ['/public/css/dashboard.css'];
// include '../includes/header.php';

if (!isset($pageTitle)) $pageTitle = "Quiniela MX";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <!-- CSS global principal -->
    <link rel="stylesheet" href="/public/css/main.css">

    <!-- Estilos adicionales (si la vista los pasa en $styles) -->
    <?php
    if (isset($styles) && is_array($styles)) {
        foreach ($styles as $s) {
            $s = htmlspecialchars($s);
            echo "<link rel=\"stylesheet\" href=\"{$s}\">" . PHP_EOL;
        }
    }
    ?>
</head>

<body>
    <!-- 🔹 Header global (navbar) -->
    <header class="main-header">
        <div class="logo">🏆 Quiniela MX</div>
        <nav class="navbar">
            <a href="/views/dashboard.php">Inicio</a>
            <a href="/views/apuestas.php">Apuestas</a>
            <a href="/views/resultados.php">Resultados</a>
            <a href="/views/perfil.php">Perfil</a>
            <a href="/actions/logout.php" class="logout-btn">Salir</a>
        </nav>
    </header>