<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/controllers/ResultadosController.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header("Location: index.php");
    exit;
}

$controller = new ResultadosController($pdo);
$partidos = $controller->obtenerPartidosPendientes();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->guardarResultado($_POST);
    header("Location: registrar_resultados.php?ok=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Resultados</title>
    <link rel="stylesheet" href="../assets/css/base.css">
</head>

<body>

    <h2>Registrar Resultados de Partidos</h2>

    <?php if (isset($_GET['ok'])): ?>
        <p class="success">Resultado guardado correctamente.</p>
    <?php endif; ?>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Local</th>
            <th>Visitante</th>
            <th>Fecha</th>
            <th>Registrar</th>
        </tr>

        <?php foreach ($partidos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['equipo_local']) ?></td>
                <td><?= htmlspecialchars($p['equipo_visitante']) ?></td>
                <td><?= $p['fecha_partido'] ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="partido_id" value="<?= $p['id'] ?>">
                        <input type="number" name="goles_local" placeholder="Goles Local" required>
                        <input type="number" name="goles_visitante" placeholder="Goles Visitante" required>
                        <button type="submit">Guardar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>