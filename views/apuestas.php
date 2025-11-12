<?php
include('../includes/auth.php');
include('../config/db.php');
include('../includes/navbar.php');

$usuario_id = $_SESSION['usuario_id'];

// Obtener partidos pendientes (sin resultado)
$sql = "
  SELECT p.id, e1.nombre AS local, e2.nombre AS visitante, p.fecha_hora
  FROM partidos p
  JOIN equipos e1 ON p.equipo_local_id = e1.id
  JOIN equipos e2 ON p.equipo_visitante_id = e2.id
  WHERE p.resultado IS NULL
  ORDER BY p.fecha_hora ASC;
";
$partidos = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apostar | Quiniela MX</title>
    <link rel="stylesheet" href="../public/css/styles.css">
    <style>
        .apuestas-container {
            max-width: 900px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #1565c0;
            margin-bottom: 1rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .partido {
            border: 1px solid #eee;
            padding: 1rem;
            border-radius: 0.5rem;
            background: #fafafa;
        }

        .equipos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
        }

        .opciones {
            display: flex;
            justify-content: space-around;
            margin-top: 0.5rem;
        }

        .opciones label {
            cursor: pointer;
        }

        .monto {
            margin-top: 0.8rem;
        }

        button {
            width: 100%;
            margin-top: 1rem;
        }

        .sin-partidos {
            text-align: center;
            color: #777;
            padding: 2rem;
        }
    </style>
</head>

<body>

    <div class="apuestas-container">
        <h2>Realizar apuesta</h2>

        <?php if ($partidos->num_rows > 0): ?>
            <form action="../actions/apostar_action.php" method="POST">
                <label for="partido">Selecciona un partido:</label>
                <select name="partido_id" id="partido" required>
                    <option value="">-- Selecciona un partido --</option>
                    <?php while ($p = $partidos->fetch_assoc()): ?>
                        <option value="<?php echo $p['id']; ?>">
                            <?php echo $p['local'] . " vs " . $p['visitante'] . " — " . date('d/m H:i', strtotime($p['fecha_hora'])); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <div class="opciones">
                    <label><input type="radio" name="pronostico" value="local" required> Gana Local</label>
                    <label><input type="radio" name="pronostico" value="empate"> Empate</label>
                    <label><input type="radio" name="pronostico" value="visitante"> Gana Visitante</label>
                </div>

                <div class="monto">
                    <label for="monto">Monto a apostar (mínimo $10, máximo $500):</label>
                    <input type="number" id="monto" name="monto" min="10" max="500" step="10" required>
                </div>

                <button type="submit">Confirmar apuesta</button>
            </form>
        <?php else: ?>
            <div class="sin-partidos">
                <p>Por ahora no hay partidos disponibles para apostar.</p>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>