<?php
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'] ?? null;
    $area = $_POST['area'] ?? null;
    $sede = $_POST['sede'] ?? null;
    $password = $_POST['password'];

    // Encriptar contraseña
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre, username, correo, telefono, area, sede, password_hash, rol_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, 2)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nombre, $username, $correo, $telefono, $area, $sede, $password_hash);

    if ($stmt->execute()) {
        header("Location: ../views/login.php?success=1");
        exit();
    } else {
        echo "Error al registrar usuario: " . $stmt->error;
    }
}
