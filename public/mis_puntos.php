<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/models/Usuario.php';

// Validar login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$usuarioId = $_SESSION['usuario_id'];
$usuarioModel = new Usuario($pdo);

$detalle = $usuarioModel->obtenerPuntosPorPartido($usuarioId);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis puntos por partido</title>
    <link rel="stylesheet" href="../assets/css/base.css">
</head>

<body>
    <h2>Puntos obtenidos por partido</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>Local</th>
            <th>Visitante</th>
            <th>Marcador</th>
            <th>Puntos obtenidos</th>
        </tr>

        <?php foreach ($detalle as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['equipo_local']); ?></td>
                <td><?= htmlspecialchars($row['equipo_visitante']); ?></td>
                <td><?= $row['marcador_local'] . " - " . $row['marcador_visitante']; ?></td>
                <td><strong><?= $row['puntos_obtenidos']; ?></strong></td>
            </tr>
        <?php endforeach; ?>

    </table>

</body>

</html>