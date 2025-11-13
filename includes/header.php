<?php
// includes/header.php
// Uso: en views antes de HTML poner:
// $pageTitle = "Mi Título"; $styles = ['/public/css/auth.css']; include '../includes/header.php';
// IMPORTANTE: ajustar la ruta de include desde la ubicación del archivo que lo usa.
// En tus views actuales (en /views) usar: include('../includes/header.php');

if (!isset($pageTitle)) $pageTitle = "Quiniela MX";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <!-- CSS global (si existe) -->
    <link rel="stylesheet" href="/public/css/main.css">

    <!-- Carga estilos adicionales pasados desde la vista -->
    <?php
    if (isset($styles) && is_array($styles)) {
        foreach ($styles as $s) {
            // seguridad: evitar rutas malformadas
            $s = htmlspecialchars($s);
            echo "<link rel=\"stylesheet\" href=\"{$s}\">" . PHP_EOL;
        }
    }
    ?>
</head>

<body>