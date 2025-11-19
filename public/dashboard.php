<?php
session_start();

// Si el usuario no ha iniciado sesión, lo mandamos al login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

// Cargar conexión y modelos
require_once __DIR__ . '/../config/db.php';               // <-- obtiene $pdo
require_once __DIR__ . '/../src/models/Usuario.php';
require_once __DIR__ . '/../src/models/Partido.php';
require_once __DIR__ . '/../src/models/Apuesta.php';

// Crear instancias de modelos PASANDO $pdo al constructor
$usuarioModel = new Usuario($pdo);
$partidoModel = new Partido($pdo);
$apuestaModel = new Apuesta($pdo);

// Obtenemos datos del usuario en sesión
$usuario_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['nombre'];
$rol_id = $_SESSION['rol_id']; // 1 = Admin, 2 = Usuario normal

// Obtener historial de puntos (asegúrate que el método existe en Usuario)
$historial = [];
if (method_exists($usuarioModel, 'obtenerHistorialPuntos')) {
    $historial = $usuarioModel->obtenerHistorialPuntos($usuario_id);
}

// (Opcional) obtener ranking si tienes el método
$ranking = [];
if (method_exists($usuarioModel, 'obtenerRankingUsuarios')) {
    $ranking = $usuarioModel->obtenerRankingUsuarios();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | Quiniela</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <!-- Chart.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Header -->
    <header class="main-header">
        <div class="logo">
            <img src="../assets/images/logos/logo.png" alt="Logo Quiniela" />
            <h1>Quiniela MX</h1>
        </div>
        <nav class="nav-links">
            <a href="dashboard.php" class="active">Inicio</a>
            <?php if ($rol_id == 1): ?>
                <a href="admin_panel.php">Admin</a>
            <?php endif; ?>
            <a href="logout.php" class="logout-btn">Cerrar sesión</a>
        </nav>
    </header>

    <!-- Contenido principal -->
    <main class="dashboard-container">
        <h2>Bienvenido, <?= htmlspecialchars($nombre) ?> 👋</h2>

        <?php if ($rol_id == 1): ?>
            <p class="role-badge admin">Rol: Administrador</p>
        <?php else: ?>
            <p class="role-badge user">Rol: Usuario</p>
        <?php endif; ?>

        <!-- Tarjetas del panel -->
        <section class="content-section">
            <h3>Panel principal</h3>

            <div class="cards-grid">
                <div class="card">
                    <h4>Mi Quiniela</h4>
                    <p>Revisa tus pronósticos y resultados.</p>
                    <button onclick="window.location.href='quiniela.php'">Ver quiniela</button>
                </div>

                <div class="card">
                    <h4>Resultados</h4>
                    <p>Consulta los resultados de cada jornada.</p>
                    <button onclick="window.location.href='resultados.php'">Ver resultados</button>
                </div>

                <?php if ($rol_id == 1): ?>
                    <div class="card">
                        <h4>Administrar</h4>
                        <p>Gestiona usuarios, jornadas y partidos.</p>
                        <button onclick="window.location.href='admin_panel.php'">Ir al panel admin</button>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Historial de puntos -->
        <section class="content-section">
            <h3>Mi Historial de Puntos</h3>

            <?php if (empty($historial)): ?>
                <p>Todavía no tienes puntos registrados.</p>
            <?php else: ?>
                <table class="tabla-puntos">
                    <thead>
                        <tr>
                            <th>Partido</th>
                            <th>Resultado</th>
                            <th>Puntos</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historial as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['equipo_local']) ?> vs <?= htmlspecialchars($row['equipo_visitante']) ?></td>
                                <td><?= htmlspecialchars($row['marcador_local']) ?> - <?= htmlspecialchars($row['marcador_visitante']) ?></td>
                                <td class="puntos"><?= htmlspecialchars($row['puntos_obtenidos']) ?></td>
                                <td><?= htmlspecialchars($row['fecha']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

        <!-- Gráfica -->
        <?php if (!empty($historial)): ?>
            <section class="content-section">
                <h3>Estadísticas</h3>
                <canvas id="graficaPuntos" height="120"></canvas>
            </section>

            <script>
                const puntos = <?= json_encode(array_column($historial, 'puntos_obtenidos')); ?>;
                const labels = <?= json_encode(array_map(fn($p) => "Partido " . $p['partido_id'], $historial)); ?>;

                new Chart(document.getElementById('graficaPuntos'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Puntos por partido',
                            data: puntos,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        }
                    }
                });
            </script>
        <?php endif; ?>

        <!-- Ranking (opcional, si $ranking no está vacío) -->
        <?php if (!empty($ranking)): ?>
            <section class="content-section">
                <h3>Ranking general</h3>
                <table class="tabla-puntos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Puntos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $pos = 1;
                        foreach ($ranking as $r): ?>
                            <tr>
                                <td><?= $pos++ ?></td>
                                <td><?= htmlspecialchars($r['username'] ?? $r['nombre']) ?></td>
                                <td><?= htmlspecialchars($r['puntos_totales'] ?? 0) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php endif; ?>

    </main>
</body>

</html>