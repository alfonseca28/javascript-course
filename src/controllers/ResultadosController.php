<?php

class ResultadosController
{

    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function obtenerPartidosPendientes()
    {
        $sql = "SELECT * FROM partidos WHERE goles_local IS NULL AND goles_visitante IS NULL";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardarResultado($data)
    {
        $sql = "UPDATE partidos 
                SET goles_local = ?, goles_visitante = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['goles_local'],
            $data['goles_visitante'],
            $data['partido_id']
        ]);
    }
}
