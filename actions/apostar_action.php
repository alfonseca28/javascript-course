<?php
include('../includes/auth.php');
include('../config/db.php');

$usuario_id = $_SESSION['usuario_id'];
$partido_id = $_POST['partido_id'];
$pronostico = $_POST['pronostico'];
$monto = $_POST['monto'];

// Validaciones básicas
if (!$partido_id || !$pronostico || !$monto) {
    die("Datos incompletos.");
}

if ($monto < 10 || $monto > 500) {
    die("El monto debe estar entre $10 y $500.");
}

// Verificar que el partido aún no haya iniciado
$sql_check = "SELECT fecha_hora FROM partidos WHERE id = $partido_id AND resultado IS NULL";
$res = $conn->query($sql_check);
if ($res->num_rows === 0) {
    die("El partido ya comenzó o no existe.");
}

// Registrar la apuesta
$sql_insert = "
  INSERT INTO apuestas (usuario_id, partido_id, equipo_id, monto, pronostico, estado, fecha_apuesta)
  VALUES (?, ?, NULL, ?, ?, 'pendiente', NOW())
";

$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("iiis", $usuario_id, $partido_id, $monto, $pronostico);

if ($stmt->execute()) {
    header("Location: ../views/dashboard.php?msg=apuesta_ok");
} else {
    echo "Error al registrar apuesta: " . $conn->error;
}

$stmt->close();
$conn->close();
