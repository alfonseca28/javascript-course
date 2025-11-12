<?php
session_start();
include("../config/db.php");

$correo = trim($_POST['correo']);
$password = trim($_POST['password']);

if (empty($correo) || empty($password)) {
    $_SESSION['error'] = "Debes completar ambos campos.";
    header("Location: ../views/login.php");
    exit;
}

// Busca el usuario
$stmt = $conn->prepare("SELECT id, nombre, password_hash, rol_id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $nombre, $hash, $rol);
    $stmt->fetch();

    if (password_verify($password, $hash)) {
        $_SESSION['usuario_id'] = $id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['rol'] = $rol;
        header("Location: ../views/dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Contraseña incorrecta.";
    }
} else {
    $_SESSION['error'] = "Usuario no encontrado.";
}

$stmt->close();
$conn->close();

header("Location: ../views/login.php");
exit;
