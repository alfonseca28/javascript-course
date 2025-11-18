<?php

class Apuesta
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Registrar apuesta
    public function crear($usuario_id, $partido_id, $eleccion, $monto)
    {
        $sql = "INSERT INTO apuestas (usuario_id, partido_id, eleccion, monto)
                VALUES (:usuario_id, :partido_id, :eleccion, :monto)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':partido_id' => $partido_id,
            ':eleccion' => $eleccion,
            ':monto' => $monto
        ]);
    }

    // Evitar apuestas duplicadas
    public function existeApuesta($usuario_id, $partido_id)
    {
        $sql = "SELECT id FROM apuestas WHERE usuario_id = :usuario_id AND partido_id = :partido_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':partido_id' => $partido_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener apuestas del usuario
    public function obtenerPorUsuario($usuario_id)
    {
        $sql = "
            SELECT a.id, a.eleccion, a.monto,
                   p.fecha,
                   el.nombre AS local,
                   ev.nombre AS visitante
            FROM apuestas a
            JOIN partidos p ON p.id = a.partido_id
            JOIN equipos el ON el.id = p.equipo_local_id
            JOIN equipos ev ON ev.id = p.equipo_visitante_id
            WHERE a.usuario_id = :usuario_id
            ORDER BY p.fecha DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
