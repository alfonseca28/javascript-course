<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/models/Usuario.php';

session_start();

// Solo usuarios logueados
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$usuarioModel = new Usuario($pdo);
$ranking = $usuarioModel->obtenerRankingUsuarios();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ranking General</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>

    <h2>🏆 Ranking General de la Quiniela</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Puntos Totales</th>
        </tr>

        <?php
        $pos = 1;
        foreach ($ranking as $fila):
        ?>
            <tr>
                <td><?= $pos++; ?></td>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['username']) ?></td>
                <td><strong><?= $fila['puntos_totales'] ?></strong></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>