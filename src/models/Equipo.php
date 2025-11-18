<?php
class Equipo
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT * FROM equipos ORDER BY nombre";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
