<?php
session_start();
include("../config/db.php");

// Recibe datos del formulario
$nombre = trim($_POST['nombre']);
$correo = trim($_POST['correo']);
$password = trim($_POST['password']);

// Validar datos básicos
if (empty($nombre) || empty($correo) || empty($password)) {
    $_SESSION['error'] = "Todos los campos son obligatorios.";
    header("Location: ../views/register.php");
    exit;
}

// Verifica si ya existe el correo
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "El correo ya está registrado.";
    header("Location: ../views/register.php");
    exit;
}

// Cifra la contraseña
$hash = password_hash($password, PASSWORD_BCRYPT);

// Inserta el nuevo usuario
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, password_hash, rol_id) VALUES (?, ?, ?, 2)");
$stmt->bind_param("sss", $nombre, $correo, $hash);

if ($stmt->execute()) {
    $_SESSION['usuario_id'] = $stmt->insert_id;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['rol'] = 2;
    header("Location: ../views/dashboard.php");
} else {
    $_SESSION['error'] = "Error al registrar usuario.";
    header("Location: ../views/register.php");
}

$stmt->close();
$conn->close();
