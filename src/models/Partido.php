<?php
class Partido
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function crear($local, $visitante, $fecha)
    {
        $sql = "INSERT INTO partidos (equipo_local_id, equipo_visitante_id, fecha) 
                VALUES (:local, :visitante, :fecha)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':local' => $local,
            ':visitante' => $visitante,
            ':fecha' => $fecha
        ]);
    }

    public function obtenerTodos()
    {
        $sql = "
            SELECT p.id, 
                   el.nombre AS local,
                   ev.nombre AS visitante,
                   p.fecha
            FROM partidos p
            JOIN equipos el ON el.id = p.equipo_local_id
            JOIN equipos ev ON ev.id = p.equipo_visitante_id
            ORDER BY fecha DESC
        ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
