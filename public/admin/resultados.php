<?php
session_start();

// Validar que sea admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header("Location: ../dashboard.php");
    exit;
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/controllers/PuntosController.php';

// Obtener partidos
$sql = "
    SELECT p.*, 
           el.nombre AS equipo_local, 
           ev.nombre AS equipo_visitante
    FROM partidos p
    JOIN equipos el ON el.id = p.equipo_local_id
    JOIN equipos ev ON ev.id = p.equipo_visitante_id
    ORDER BY p.fecha DESC
";
$stmt = $pdo->query($sql);
$partidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? null;
    $local_goles = $_POST['local_goles'] ?? null;
    $visitante_goles = $_POST['visitante_goles'] ?? null;

    if ($id !== null && $local_goles !== null && $visitante_goles !== null) {

        // Actualiza el marcador
        $update = $pdo->prepare("
            UPDATE partidos 
            SET marcador_local = :ml,
                marcador_visitante = :mv,
                estado_partido = 'finalizado'
            WHERE id = :id
        ");

        $update->execute([
            ':ml' => $local_goles,
            ':mv' => $visitante_goles,
            ':id' => $id
        ]);

        // Procesar puntos
        $puntos = new PuntosController($pdo);
        $puntos->procesarPartidoFinalizado($id);

        $mensaje = "Resultado actualizado y puntos asignados correctamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cargar Resultados</title>
    <link rel="stylesheet" href="../../assets/css/base.css">
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>

<body>

    <h2 style="text-align:center; margin-top:20px;">Cargar Resultados de Partidos</h2>

    <?php if (!empty($mensaje)): ?>
        <p class="success" style="text-align:center;"><?= $mensaje ?></p>
    <?php endif; ?>

    <div class="cards-grid" style="width:80%; margin:auto;">

        <?php foreach ($partidos as $p): ?>
            <div class="card">
                <h4><?= htmlspecialchars($p['equipo_local']) ?> vs <?= htmlspecialchars($p['equipo_visitante']) ?></h4>
                <p><strong>Fecha:</strong> <?= $p['fecha'] ?></p>
                <p><strong>Sede:</strong> <?= $p['sede'] ?></p>

                <?php if ($p['estado_partido'] === 'finalizado'): ?>
                    <p><strong>Marcador:</strong> <?= $p['marcador_local'] ?> - <?= $p['marcador_visitante'] ?></p>
                    <p style="color: green; font-weight:bold;">Partido finalizado</p>
                <?php else: ?>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">

                        <label>Goles Local</label>
                        <input type="number" name="local_goles" min="0" required>

                        <label>Goles Visitante</label>
                        <input type="number" name="visitante_goles" min="0" required>

                        <button type="submit">Guardar Resultado</button>
                    </form>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>

    </div>

</body>

</html>