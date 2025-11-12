<?php
include('../includes/auth.php');
include('../config/db.php');
include('../includes/navbar.php');

$usuario_id = $_SESSION['usuario_id'];

// Obtener últimos partidos
$sql_partidos = "
  SELECT p.id, e1.nombre AS local, e2.nombre AS visitante, p.fecha_hora, p.resultado
  FROM partidos p
  JOIN equipos e1 ON p.equipo_local_id = e1.id
  JOIN equipos e2 ON p.equipo_visitante_id = e2.id
  ORDER BY p.fecha_hora DESC
  LIMIT 5;
";
$partidos = $conn->query($sql_partidos);

// Obtener tus apuestas recientes
$sql_apuestas = "
  SELECT a.id, e.nombre AS equipo, a.monto, a.pronostico, a.estado
  FROM apuestas a
  JOIN equipos e ON a.equipo_id = e.id
  WHERE a.usuario_id = $usuario_id
  ORDER BY a.fecha_apuesta DESC
  LIMIT 5;
";
$apuestas = $conn->query($sql_apuestas);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Quiniela MX</title>
    <link rel="stylesheet" href="../public/css/styles.css">
    <style>
        .dashboard {
            max-width: 1000px;
            margin: 2rem auto;
            display: grid;
            gap: 2rem;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            margin-bottom: 1rem;
            color: #1565c0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 0.8rem;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f5f5f5;
        }

        tr:hover {
            background-color: #fafafa;
        }
    </style>
</head>

<body>

    <div class="dashboard">
        <div class="card">
            <h3>👋 Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>!</h3>
            <p>Desde aquí puedes revisar tus apuestas, ver los resultados más recientes y participar en la Quiniela MX.</p>
        </div>

        <div class="card">
            <h3>🏟️ Últimos partidos</h3>
            <table>
                <tr>
                    <th>Local</th>
                    <th>Visitante</th>
                    <th>Fecha/Hora</th>
                    <th>Resultado</th>
                </tr>
                <?php while ($row = $partidos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['local']; ?></td>
                        <td><?php echo $row['visitante']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['fecha_hora'])); ?></td>
                        <td><?php echo $row['resultado'] ? $row['resultado'] : 'Pendiente'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="card">
            <h3>💸 Tus apuestas recientes</h3>
            <table>
                <tr>
                    <th>Equipo</th>
                    <th>Pronóstico</th>
                    <th>Monto</th>
                    <th>Estado</th>
                </tr>
                <?php if ($apuestas->num_rows > 0): ?>
                    <?php while ($ap = $apuestas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $ap['equipo']; ?></td>
                            <td><?php echo ucfirst($ap['pronostico']); ?></td>
                            <td>$<?php echo number_format($ap['monto'], 2); ?></td>
                            <td><?php echo ucfirst($ap['estado']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">No tienes apuestas aún.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

</body>

</html>