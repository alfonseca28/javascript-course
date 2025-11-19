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

    public function obtenerRankingUsuarios()
    {
        $sql = "
        SELECT 
            u.id,
            u.nombre,
            u.username,
            COALESCE(SUM(pu.puntos_obtenidos), 0) AS puntos_totales
        FROM usuarios u
        LEFT JOIN puntos_usuarios pu ON u.id = pu.usuario_id
        GROUP BY u.id
        ORDER BY puntos_totales DESC, u.nombre ASC
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerHistorialPuntos($usuarioId)
    {
        $sql = "
        SELECT 
            p.partido_id,
            p.puntos_obtenidos,
            p.fecha,
            pa.marcador_local,
            pa.marcador_visitante,
            pa.equipo_local,
            pa.equipo_visitante
        FROM puntos p
        INNER JOIN partidos pa ON p.partido_id = pa.id
        WHERE p.usuario_id = :uid
        ORDER BY p.fecha DESC
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':uid' => $usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPuntosPorPartido($usuarioId)
    {
        $sql = "
        SELECT 
            pa.equipo_local,
            pa.equipo_visitante,
            pa.marcador_local,
            pa.marcador_visitante,
            p.puntos_obtenidos
        FROM puntos p
        INNER JOIN partidos pa ON p.partido_id = pa.id
        WHERE p.usuario_id = :uid
        ORDER BY pa.id ASC
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':uid' => $usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
