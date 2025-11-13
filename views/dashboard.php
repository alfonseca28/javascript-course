<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include_once "../includes/header.php";
require_once "../config/db.php";
?>

<link rel="stylesheet" href="../public/css/dashboard.css">

<main class="dashboard-container">
    <section class="dashboard-section resultados">
        <h2>Resultados de la Jornada</h2>
        <div class="resultados-list">
            <!-- Aquí se mostrarán los resultados dinámicos -->
            <p>Cargando resultados...</p>
        </div>
    </section>

    <section class="dashboard-section apuestas">
        <h2>Mis Pronósticos</h2>
        <div class="apuestas-list">
            <!-- Aquí se mostrarán las apuestas del usuario -->
            <p>No has realizado apuestas aún.</p>
        </div>
    </section>

    <section class="dashboard-section posiciones">
        <h2>Tabla de Posiciones</h2>
        <table class="tabla-posiciones">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Aciertos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Juan Pérez</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>María López</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>Tú</td>
                    <td>5</td>
                </tr>
            </tbody>
        </table>
    </section>
</main>

<?php include_once "../includes/footer.php"; ?>