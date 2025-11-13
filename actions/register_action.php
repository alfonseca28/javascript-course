<?php
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturamos los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $area = trim($_POST['area'] ?? '');
    $sede = trim($_POST['sede'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validar campos vacíos
    if (empty($nombre) || empty($username) || empty($correo) || empty($password)) {
        header("Location: ../views/register.php?error=Campos+obligatorios+faltantes");
        exit();
    }

    // Encriptar contraseña
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Preparar y ejecutar el INSERT
    $sql = "INSERT INTO usuarios (nombre, username, correo, telefono, area, sede, password_hash, rol_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, 2)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nombre, $username, $correo, $telefono, $area, $sede, $password_hash);

    if ($stmt->execute()) {
        // Redirigir con indicador de éxito
        header("Location: ../views/login.php?success=1");
        exit();
    } else {
        header("Location: ../views/register.php?error=" . urlencode("Error al registrar usuario: " . $stmt->error));
        exit();
    }
}
