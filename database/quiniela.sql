-- ========================================
-- CREACIÓN BASE DE DATOS QUINIELA (MySQL)
-- ========================================
CREATE DATABASE IF NOT EXISTS quiniela
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE quiniela;

-- ========================================
-- 1. Tabla: roles
-- ========================================
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO roles (nombre) VALUES ('admin'), ('usuario');

-- ========================================
-- 2. Tabla: usuarios
-- ========================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    correo VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20) DEFAULT NULL,
    area VARCHAR(100) DEFAULT NULL,
    sede VARCHAR(100) DEFAULT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL DEFAULT 2,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 3. Tabla: equipos
-- ========================================
CREATE TABLE equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    abreviatura VARCHAR(10),
    logo_url VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 4. Tabla: partidos
-- ========================================
CREATE TABLE partidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipo_local_id INT NOT NULL,
    equipo_visitante_id INT NOT NULL,
    fecha DATETIME NOT NULL,
    jornada INT NOT NULL,
    estadio VARCHAR(100),
    estado ENUM('pendiente', 'en_juego', 'finalizado') DEFAULT 'pendiente',
    fecha_apuesta_limite DATETIME NULL,
    FOREIGN KEY (equipo_local_id) REFERENCES equipos(id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT,
    FOREIGN KEY (equipo_visitante_id) REFERENCES equipos(id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 5. Tabla: resultados
-- ========================================
CREATE TABLE resultados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    partido_id INT NOT NULL UNIQUE,
    goles_local INT DEFAULT 0,
    goles_visitante INT DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    registrado_por INT NOT NULL,
    FOREIGN KEY (partido_id) REFERENCES partidos(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE,
    FOREIGN KEY (registrado_por) REFERENCES usuarios(id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 6. Tabla: apuestas
-- ========================================
CREATE TABLE apuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    partido_id INT NOT NULL,
    eleccion ENUM('local','empate','visitante') NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    fecha_apuesta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    acertada BOOLEAN DEFAULT NULL,
    monto_ganado DECIMAL(10,2) DEFAULT NULL,
    pagada BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT,
    FOREIGN KEY (partido_id) REFERENCES partidos(id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT,
    CONSTRAINT unique_usuario_partido UNIQUE(usuario_id, partido_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 7. Tabla: configuraciones de la quiniela
-- ========================================
CREATE TABLE configuraciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) NOT NULL UNIQUE,
    valor VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255) DEFAULT NULL,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar valor por defecto para monto mínimo de apuesta
INSERT INTO configuraciones (clave, valor, descripcion)
VALUES ('monto_minimo_apuesta', '100.00', 'Monto mínimo permitido para realizar apuesta');

-- ========================================
-- 8. Datos iniciales: Equipos Liga MX (Temporada 2025)
-- ========================================
INSERT INTO equipos (nombre, abreviatura, logo_url, activo)
VALUES
    ('Club América', 'AME', NULL, TRUE),
    ('Cruz Azul', 'CAZ', NULL, TRUE),
    ('Chivas de Guadalajara', 'GDL', NULL, TRUE),
    ('Tigres UANL', 'TIG', NULL, TRUE),
    ('Club Monterrey', 'MTY', NULL, TRUE),
    ('Toluca', 'TOL', NULL, TRUE),
    ('Pumas UNAM', 'PUM', NULL, TRUE),
    ('Club Tijuana', 'TIJ', NULL, TRUE),
    ('FC Juárez', 'JUA', NULL, TRUE),
    ('Club Pachuca', 'PAC', NULL, TRUE),
    ('Club León', 'LEO', NULL, TRUE),
    ('Atlas Guadalajara', 'ATL', NULL, TRUE),
    ('Santos Laguna', 'SAN', NULL, TRUE),
    ('Mazatlán FC', 'MAZ', NULL, TRUE),
    ('Club Necaxa', 'NEC', NULL, TRUE),
    ('Puebla FC', 'PUE', NULL, TRUE),
    ('Querétaro FC', 'QRO', NULL, TRUE),
    ('Atlético de San Luis', 'ASL', NULL, TRUE);

-- ========================================
-- Base de datos lista para usarse
-- ========================================
