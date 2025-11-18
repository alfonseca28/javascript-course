<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/models/Equipo.php';
require_once __DIR__ . '/../src/models/Partido.php';

// Verificar login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$equipoModel = new Equipo($pdo);
$partidoModel = new Partido($pdo);

// Obtener equipos para formulario
$equipos = $equipoModel->obtenerTodos();

// Insertar nuevo partido
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $local = $_POST['equipo_local'] ?? null;
    $visitante = $_POST['equipo_visitante'] ?? null;
    $fecha = $_POST['fecha'] ?? null;

    if ($local == $visitante) {
        $mensaje = "Un equipo no puede jugar contra sí mismo.";
    } else {
        $partidoModel->crear($local, $visitante, $fecha);
        $mensaje = "Partido registrado correctamente.";
    }
}

$partidos = $partidoModel->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Partidos</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <style>
        .container {
            max-width: 900px;
            margin: 30px auto;
            background: #111;
            padding: 20px;
            border-radius: 10px;
        }

        h2 {
            color: #fff;
        }

        form select,
        form input,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border-bottom: 1px solid #333;
            color: #fff;
        }

        .msg {
            background: #00800090;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Registrar Partido</h2>

        <?php if ($mensaje): ?>
            <p class="msg"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Equipo Local</label>
            <select name="equipo_local" required>
                <option value="">Seleccionar</option>
                <?php foreach ($equipos as $eq): ?>
                    <option value="<?= $eq['id'] ?>"><?= htmlspecialchars($eq['nombre']) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Equipo Visitante</label>
            <select name="equipo_visitante" required>
                <option value="">Seleccionar</option>
                <?php foreach ($equipos as $eq): ?>
                    <option value="<?= $eq['id'] ?>"><?= htmlspecialchars($eq['nombre']) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Fecha del partido</label>
            <input type="datetime-local" name="fecha" required>

            <button type="submit">Registrar Partido</button>
        </form>

        <h2>Partidos Registrados</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Local</th>
                <th>Visitante</th>
                <th>Fecha</th>
            </tr>
            <?php foreach ($partidos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['local']) ?></td>
                    <td><?= htmlspecialchars($p['visitante']) ?></td>
                    <td><?= $p['fecha'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>