<?php

class Puntos
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Sumar puntos al usuario
    public function sumar($usuario_id, $puntos)
    {
        $sql = "UPDATE puntos 
                SET puntos = puntos + :pts
                WHERE usuario_id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':pts' => $puntos,
            ':id' => $usuario_id
        ]);
    }

    // Crear registro si no existe
    public function crearSiNoExiste($usuario_id)
    {
        $sql = "INSERT IGNORE INTO puntos (usuario_id, puntos)
                VALUES (:id, 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $usuario_id]);
    }

    // Obtener ranking
    public function ranking()
    {
        $sql = "
            SELECT u.username, p.puntos
            FROM puntos p
            JOIN usuarios u ON u.id = p.usuario_id
            ORDER BY p.puntos DESC
        ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerHistorialPuntos($usuarioId)
    {
        $sql = "
        SELECT 
            pp.puntos_obtenidos,
            pp.fecha_registro,
            pa.id AS partido_id,
            pa.equipo_local_id,
            pa.equipo_visitante_id,
            pa.fecha AS fecha_partido,
            pa.jornada,
            pa.estadio
        FROM puntos_partidos pp
        INNER JOIN partidos pa ON pp.partido_id = pa.id
        WHERE pp.usuario_id = :uid
        ORDER BY pp.fecha_registro DESC
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':uid' => $usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
