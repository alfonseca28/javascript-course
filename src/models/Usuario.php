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

    // Registrar nuevo usuario con los campos adicionales
    public function registrar($nombre, $username, $correo, $password_hash, $telefono = null, $area = null, $sede = null)
    {
        $sql = "INSERT INTO usuarios (nombre, username, correo, password_hash, telefono, area, sede)
                VALUES (:nombre, :username, :correo, :password_hash, :telefono, :area, :sede)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':username' => $username,
            ':correo' => $correo,
            ':password_hash' => $password_hash,
            ':telefono' => $telefono,
            ':area' => $area,
            ':sede' => $sede
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

    // Verificar existencia por username o correo (para registro)
    public function existeUsernameOCorreo($username, $correo)
    {
        $sql = "SELECT id, username, correo FROM usuarios WHERE username = :username OR correo = :correo LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username, ':correo' => $correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // false si no existe
    }
}
