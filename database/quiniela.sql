-- ========================================
--  CREACIÓN BASE DE DATOS QUINIELA (MySQL)
-- ========================================
CREATE DATABASE IF NOT EXISTS quiniela CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE quiniela;

-- ========================================
-- 1. Tabla: roles
-- ========================================
CREATE TABLE
    roles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL UNIQUE
    );

INSERT INTO
    roles (nombre)
VALUES
    ('admin'),
    ('usuario');

-- ========================================
-- 2. Tabla: usuarios
-- ========================================
CREATE TABLE
    usuarios (
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
        CONSTRAINT fk_usuarios_roles FOREIGN KEY (rol_id) REFERENCES roles (id)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ========================================
-- 3. Tabla: equipos
-- ========================================
CREATE TABLE
    equipos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL UNIQUE,
        abreviatura VARCHAR(10),
        logo_url VARCHAR(255),
        activo BOOLEAN DEFAULT TRUE
    );

-- ========================================
-- 4. Tabla: partidos
-- ========================================
CREATE TABLE
    partidos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        equipo_local_id INT NOT NULL,
        equipo_visitante_id INT NOT NULL,
        fecha DATETIME NOT NULL,
        jornada INT NOT NULL,
        estadio VARCHAR(100),
        estado ENUM('pendiente', 'en_juego', 'finalizado') DEFAULT 'pendiente',
        FOREIGN KEY (equipo_local_id) REFERENCES equipos (id),
        FOREIGN KEY (equipo_visitante_id) REFERENCES equipos (id)
    );

-- ========================================
-- 5. Tabla: resultados
-- ========================================
CREATE TABLE
    resultados (
        id INT AUTO_INCREMENT PRIMARY KEY,
        partido_id INT NOT NULL UNIQUE,
        goles_local INT DEFAULT 0,
        goles_visitante INT DEFAULT 0,
        fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        registrado_por INT,
        FOREIGN KEY (partido_id) REFERENCES partidos (id),
        FOREIGN KEY (registrado_por) REFERENCES usuarios (id)
    );

-- ========================================
-- 6. Tabla: apuestas
-- ========================================
CREATE TABLE
    apuestas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        partido_id INT NOT NULL,
        eleccion ENUM('local', 'empate', 'visitante') NOT NULL,
        monto DECIMAL(10, 2) NOT NULL,
        fecha_apuesta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        acertada BOOLEAN DEFAULT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
        FOREIGN KEY (partido_id) REFERENCES partidos (id),
        CONSTRAINT unique_apuesta UNIQUE (usuario_id, partido_id)
    );

-- ========================================
-- 7. Datos iniciales: Equipos Liga MX (Temporada 2025)
-- ========================================
INSERT INTO
    equipos (nombre, abreviatura, logo_url, activo)
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
--  Base de datos lista para usarse
--  Puedes registrar usuarios, partidos y apuestas.
-- ========================================