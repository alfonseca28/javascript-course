<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/models/Partido.php';
require_once __DIR__ . '/../src/models/Apuesta.php';

// Proteger ruta
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$partidoModel = new Partido($pdo);
$apuestaModel = new Apuesta($pdo);

$partidos = $partidoModel->obtenerTodos();
$mensaje = "";

// Procesar apuesta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $partido_id = $_POST['partido_id'] ?? null;
    $eleccion = $_POST['eleccion'] ?? null;
    $monto = $_POST['monto'] ?? null;

    if (!$partido_id || !$eleccion || !$monto) {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        // Verificar si ya existe
        if ($apuestaModel->existeApuesta($usuario_id, $partido_id)) {
            $mensaje = "Ya realizaste una apuesta para este partido.";
        } else {
            $apuestaModel->crear($usuario_id, $partido_id, $eleccion, $monto);
            $mensaje = "Apuesta registrada correctamente.";
        }
    }
}

// Obtener apuestas del usuario
$misApuestas = $apuestaModel->obtenerPorUsuario($usuario_id);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Apuesta</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <style>
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #111;
            padding: 20px;
            border-radius: 10px;
        }

        h2 {
            color: #fff;
        }

        .msg {
            background: #00800080;
            padding: 10px;
            color: #fff;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        select,
        input,
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
            color: white;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Realizar Apuesta</h2>

        <?php if ($mensaje): ?>
            <p class="msg"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Partido</label>
            <select name="partido_id" required>
                <option value="">Selecciona un partido</option>
                <?php foreach ($partidos as $p): ?>
                    <option value="<?= $p['id'] ?>">
                        <?= $p['local'] ?> vs <?= $p['visitante'] ?> — <?= $p['fecha'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Tu selección</label>
            <select name="eleccion" required>
                <option value="">Selecciona</option>
                <option value="local">Gana Local</option>
                <option value="empate">Empate</option>
                <option value="visitante">Gana Visitante</option>
            </select>

            <label>Monto</label>
            <input type="number" name="monto" min="1" required>

            <button type="submit">Guardar Apuesta</button>
        </form>

        <h2>Mis Apuestas</h2>

        <table>
            <tr>
                <th>Partido</th>
                <th>Elección</th>
                <th>Monto</th>
                <th>Fecha</th>
            </tr>

            <?php foreach ($misApuestas as $a): ?>
                <tr>
                    <td><?= $a['local'] ?> vs <?= $a['visitante'] ?></td>
                    <td><?= ucfirst($a['eleccion']) ?></td>
                    <td>$<?= $a['monto'] ?></td>
                    <td><?= $a['fecha'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

</body>

</html>