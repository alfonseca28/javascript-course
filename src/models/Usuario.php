<?php
// ========================================
// Archivo: /src/models/Usuario.php
// ========================================
require_once __DIR__ . '/../../config/db.php';

class Usuario
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Registrar nuevo usuario
    public function registrar($nombre, $username, $correo, $password_hash)
    {
        $sql = "INSERT INTO usuarios (nombre, username, correo, password_hash) 
                VALUES (:nombre, :username, :correo, :password_hash)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':username' => $username,
            ':correo' => $correo,
            ':password_hash' => $password_hash
        ]);
    }

    // Buscar usuario por username o correo
    public function obtenerPorLogin($login)
    {
        $sql = "SELECT * FROM usuarios WHERE username = :login OR correo = :login LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':login' => $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
