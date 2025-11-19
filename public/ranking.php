<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/models/Usuario.php';

$usuarioModel = new Usuario($pdo);
$ranking = $usuarioModel->obtenerRankingUsuarios();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ranking</title>
    <link rel="stylesheet" href="../assets/css/base.css">
</head>

<body>

    <h2>Ranking general de usuarios</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>Posición</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Puntos totales</th>
        </tr>

        <?php
        $pos = 1;
        foreach ($ranking as $row):
        ?>
            <tr>
                <td><strong><?= $pos++; ?></strong></td>
                <td><?= htmlspecialchars($row['nombre']); ?></td>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td><strong><?= $row['puntos_totales']; ?></strong></td>
            </tr>
        <?php endforeach; ?>

    </table>

</body>

</html>