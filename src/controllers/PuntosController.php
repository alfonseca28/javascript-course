<?php

class PuntosController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // ===============================
    // CALCULAR PUNTOS DE UN PARTIDO
    // ===============================
    public function procesarPartidoFinalizado($partido_id)
    {
        // 1. Obtener partido real
        $sql = "SELECT * FROM partidos WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $partido_id]);
        $partido = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$partido || $partido['estado_partido'] !== 'finalizado') {
            return false;
        }

        $real_local = (int)$partido['marcador_local'];
        $real_vs    = (int)$partido['marcador_visitante'];

        // 2. Obtener apuestas del partido
        $sqlA = "SELECT * FROM apuestas WHERE partido_id = :id";
        $stmtA = $this->pdo->prepare($sqlA);
        $stmtA->execute([':id' => $partido_id]);

        $apuestas = $stmtA->fetchAll(PDO::FETCH_ASSOC);

        foreach ($apuestas as $apuesta) {

            $ap_local = (int)$apuesta['apuesta_local'];
            $ap_vs    = (int)$apuesta['apuesta_visitante'];

            // 3. Calcular puntos
            $puntos = $this->calcularPuntos($real_local, $real_vs, $ap_local, $ap_vs);

            // 4. Guardar puntos en la apuesta
            $update = $this->pdo->prepare("
                UPDATE apuestas 
                SET puntos_obtenidos = :p 
                WHERE id = :id
            ");
            $update->execute([
                ':p' => $puntos,
                ':id' => $apuesta['id']
            ]);

            // 5. Sumar puntos al acumulado del usuario
            $this->sumarPuntosUsuario($apuesta['usuario_id'], $puntos);
        }

        return true;
    }

    // ===============================
    // REGLAS DE PUNTUACIÓN
    // ===============================
    private function calcularPuntos($real_l, $real_v, $ap_l, $ap_v)
    {
        // Exacto
        if ($real_l === $ap_l && $real_v === $ap_v) {
            return 3;
        }

        // Ganador real
        $real_ganador = $real_l <=> $real_v;
        $ap_ganador   = $ap_l <=> $ap_v;

        // Solo ganador
        if ($real_ganador === $ap_ganador) {
            return 1;
        }

        // Nada
        return 0;
    }

    // ===============================
    // SUMAR AL TOTAL DEL USUARIO
    // ===============================
    private function sumarPuntosUsuario($usuario_id, $puntos)
    {
        // Si no existe, crear registro
        $sqlCheck = "SELECT puntos_totales FROM puntos WHERE usuario_id = :u";
        $stmt = $this->pdo->prepare($sqlCheck);
        $stmt->execute([':u' => $usuario_id]);

        if ($stmt->rowCount() == 0) {
            $insert = $this->pdo->prepare("
                INSERT INTO puntos (usuario_id, puntos_totales)
                VALUES (:u, :p)
            ");
            $insert->execute([
                ':u' => $usuario_id,
                ':p' => $puntos
            ]);
        } else {
            $update = $this->pdo->prepare("
                UPDATE puntos 
                SET puntos_totales = puntos_totales + :p
                WHERE usuario_id = :u
            ");
            $update->execute([
                ':p' => $puntos,
                ':u' => $usuario_id
            ]);
        }
    }
}
