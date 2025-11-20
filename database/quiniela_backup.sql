-- MySQL dump 10.13  Distrib 8.4.6, for Linux (x86_64)
--
-- Host: localhost    Database: quiniela
-- ------------------------------------------------------
-- Server version	8.4.6

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `apuestas`
--

DROP TABLE IF EXISTS `apuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apuestas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `partido_id` int NOT NULL,
  `eleccion` enum('local','empate','visitante') COLLATE utf8mb4_general_ci NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_apuesta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `acertada` tinyint(1) DEFAULT NULL,
  `monto_ganado` decimal(10,2) DEFAULT NULL,
  `pagada` tinyint(1) DEFAULT '0',
  `puntos_obtenidos` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_usuario_partido` (`usuario_id`,`partido_id`),
  KEY `partido_id` (`partido_id`),
  CONSTRAINT `apuestas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `apuestas_ibfk_2` FOREIGN KEY (`partido_id`) REFERENCES `partidos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apuestas`
--

LOCK TABLES `apuestas` WRITE;
/*!40000 ALTER TABLE `apuestas` DISABLE KEYS */;
INSERT INTO `apuestas` VALUES (4,2,1,'local',100.00,'2025-11-18 20:15:08',NULL,NULL,0,0),(5,2,2,'empate',100.00,'2025-11-18 20:15:08',NULL,NULL,0,0),(6,1,1,'visitante',100.00,'2025-11-18 20:15:08',NULL,NULL,0,0);
/*!40000 ALTER TABLE `apuestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuraciones`
--

DROP TABLE IF EXISTS `configuraciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuraciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `clave` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `valor` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clave` (`clave`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones`
--

LOCK TABLES `configuraciones` WRITE;
/*!40000 ALTER TABLE `configuraciones` DISABLE KEYS */;
INSERT INTO `configuraciones` VALUES (1,'monto_minimo_apuesta','100.00','Monto mínimo permitido para realizar apuesta','2025-11-13 16:33:27');
/*!40000 ALTER TABLE `configuraciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `abreviatura` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos`
--

LOCK TABLES `equipos` WRITE;
/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO `equipos` VALUES (1,'Club América','AME',NULL,1,'2025-11-13 16:33:27',NULL),(2,'Cruz Azul','CAZ',NULL,1,'2025-11-13 16:33:27',NULL),(3,'Chivas de Guadalajara','GDL',NULL,1,'2025-11-13 16:33:27',NULL),(4,'Tigres UANL','TIG',NULL,1,'2025-11-13 16:33:27',NULL),(5,'Club Monterrey','MTY',NULL,1,'2025-11-13 16:33:27',NULL),(6,'Toluca','TOL',NULL,1,'2025-11-13 16:33:27',NULL),(7,'Pumas UNAM','PUM',NULL,1,'2025-11-13 16:33:27',NULL),(8,'Club Tijuana','TIJ',NULL,1,'2025-11-13 16:33:27',NULL),(9,'FC Juárez','JUA',NULL,1,'2025-11-13 16:33:27',NULL),(10,'Club Pachuca','PAC',NULL,1,'2025-11-13 16:33:27',NULL),(11,'Club León','LEO',NULL,1,'2025-11-13 16:33:27',NULL),(12,'Atlas Guadalajara','ATL',NULL,1,'2025-11-13 16:33:27',NULL),(13,'Santos Laguna','SAN',NULL,1,'2025-11-13 16:33:27',NULL),(14,'Mazatlán FC','MAZ',NULL,1,'2025-11-13 16:33:27',NULL),(15,'Club Necaxa','NEC',NULL,1,'2025-11-13 16:33:27',NULL),(16,'Puebla FC','PUE',NULL,1,'2025-11-13 16:33:27',NULL),(17,'Querétaro FC','QRO',NULL,1,'2025-11-13 16:33:27',NULL),(18,'Atlético de San Luis','ASL',NULL,1,'2025-11-13 16:33:27',NULL);
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partidos`
--

DROP TABLE IF EXISTS `partidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `partidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `equipo_local_id` int NOT NULL,
  `equipo_visitante_id` int NOT NULL,
  `fecha` datetime NOT NULL,
  `jornada` int NOT NULL,
  `estadio` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` enum('pendiente','en_juego','finalizado') COLLATE utf8mb4_general_ci DEFAULT 'pendiente',
  `fecha_apuesta_limite` datetime DEFAULT NULL,
  `marcador_local` int DEFAULT NULL,
  `marcador_visitante` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `equipo_local_id` (`equipo_local_id`),
  KEY `equipo_visitante_id` (`equipo_visitante_id`),
  CONSTRAINT `partidos_ibfk_1` FOREIGN KEY (`equipo_local_id`) REFERENCES `equipos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `partidos_ibfk_2` FOREIGN KEY (`equipo_visitante_id`) REFERENCES `equipos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partidos`
--

LOCK TABLES `partidos` WRITE;
/*!40000 ALTER TABLE `partidos` DISABLE KEYS */;
INSERT INTO `partidos` VALUES (1,1,3,'2025-02-05 19:00:00',1,'Estadio Azteca','pendiente',NULL,NULL,NULL),(2,4,5,'2025-02-06 20:00:00',1,'Estadio Universitario','pendiente',NULL,NULL,NULL),(3,7,2,'2025-02-07 21:00:00',1,'Estadio Olímpico Universitario','pendiente',NULL,NULL,NULL);
/*!40000 ALTER TABLE `partidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puntos`
--

DROP TABLE IF EXISTS `puntos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `puntos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `partido_id` int NOT NULL,
  `puntos_obtenidos` int NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `puntos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puntos`
--

LOCK TABLES `puntos` WRITE;
/*!40000 ALTER TABLE `puntos` DISABLE KEYS */;
/*!40000 ALTER TABLE `puntos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puntos_partidos`
--

DROP TABLE IF EXISTS `puntos_partidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `puntos_partidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `partido_id` int NOT NULL,
  `puntos_obtenidos` int NOT NULL DEFAULT '0',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `partido_id` (`partido_id`),
  CONSTRAINT `puntos_partidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `puntos_partidos_ibfk_2` FOREIGN KEY (`partido_id`) REFERENCES `partidos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puntos_partidos`
--

LOCK TABLES `puntos_partidos` WRITE;
/*!40000 ALTER TABLE `puntos_partidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `puntos_partidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resultados`
--

DROP TABLE IF EXISTS `resultados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resultados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partido_id` int NOT NULL,
  `goles_local` int DEFAULT '0',
  `goles_visitante` int DEFAULT '0',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `registrado_por` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partido_id` (`partido_id`),
  KEY `registrado_por` (`registrado_por`),
  CONSTRAINT `resultados_ibfk_1` FOREIGN KEY (`partido_id`) REFERENCES `partidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `resultados_ibfk_2` FOREIGN KEY (`registrado_por`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultados`
--

LOCK TABLES `resultados` WRITE;
/*!40000 ALTER TABLE `resultados` DISABLE KEYS */;
INSERT INTO `resultados` VALUES (1,1,2,1,'2025-11-18 18:53:11',1),(2,2,0,0,'2025-11-18 18:53:11',1),(3,3,3,2,'2025-11-18 18:53:11',1);
/*!40000 ALTER TABLE `resultados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin'),(2,'usuario');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `area` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sede` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rol_id` int NOT NULL DEFAULT '2',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `correo` (`correo`),
  KEY `rol_id` (`rol_id`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Aarón Alfonseca Martinez','Alfonseca28','alfonseca.aaron@gmail.com','2291441074','Sistemas','HCV','$2y$12$mvSv3LY40en9C3VoxA5n/uNVAGZlM.C97TDY6KV5GCGOYo7mhGFBe',1,'2025-11-13 18:20:54'),(2,'Miguel Nava','Miguel10','miguelnava@gmail.com','2299058743','Sistemas','HCV','$2y$12$m0cVuaR0pKtnmZwYSAxche28Fh2H1bFi.BCHMJccbOEOlWJNrxkpO',2,'2025-11-13 22:16:41'),(4,'Administrador','admin','admin@example.com',NULL,NULL,NULL,'$2y$10$zV5GsyhQOdE31E4n4t4t/O1fZwNBy6jxf8nwfQhP8AYIaQ.uZnqZe',1,'2025-11-18 22:32:42'),(5,'Carlos Ruiz','carlosr','carlos@example.com','5512340001','IT','CDMX','$2y$10$uHfX9fT7krlocFh29MJNeOthdk5NdUYTh0S5J152As1HtrH.TD8Ai',2,'2025-11-19 00:15:06'),(6,'María López','marial','maria@example.com','5512340002','Ventas','Guadalajara','$2y$10$uHfX9fT7krlocFh29MJNeOthdk5NdUYTh0S5J152As1HtrH.TD8Ai',2,'2025-11-19 00:15:06'),(7,'Juan Pérez','juanp','juanp@example.com','5512340003','Marketing','Monterrey','$2y$10$uHfX9fT7krlocFh29MJNeOthdk5NdUYTh0S5J152As1HtrH.TD8Ai',2,'2025-11-19 00:15:06'),(8,'Ana Torres','anat','ana@example.com','5512340004','RRHH','CDMX','$2y$10$uHfX9fT7krlocFh29MJNeOth0S5J152As1HtrH.TD8Ai',2,'2025-11-19 00:15:06'),(9,'Luis García','luisg','luisg@example.com','5512340005','Operaciones','Toluca','$2y$10$uHfX9fT7krlocFh29MJNeOthdk5NdUYTh0S5J152As1HtrH.TD8Ai',2,'2025-11-19 00:15:06'),(10,'Fernanda Díaz','ferd','fer@example.com','5512340006','Logística','Puebla','$2y$10$uHfX9fT7krlocFh29MJNeOthdk5NdUYTh0S5J152As1HtrH.TD8Ai',2,'2025-11-19 00:15:06'),(11,'Ricardo Mendoza','ricardom','ricardo@example.com','5512340007','IT','CDMX','$2y$10$uHfX9fT7krlocFh29MJNeOthdk5NdUYTh0S5J152As1HtrH.TD8Ai',2,'2025-11-19 00:15:06'),(12,'Sofía Hernández','sofia_h','sofia@example.com','5512340008','Administración','Querétaro','$2y$10$uHfX9fT7krlocFh29MJNeOthdk5NdUYTh0S5J152As1HtrH.TD8Ai',2,'2025-11-19 00:15:06'),(13,'Diego Ramos','diegor','diego@example.com','5512340009','Compras','León','$2y$10$uHfX9fT7krlocFh29MJNeOthdk5NdUYTh0S5J152As1HtrH.TD8Ai',2,'2025-11-19 00:15:06'),(14,'Valeria Castillo','valeriac','valeria@example.com','5512340010','Finanzas','CDMX','$2y$10$uHfX9fT7krlocFh29MJNeOthdk5NdUYTh0S5J152As1HtrH.TD8Ai',2,'2025-11-19 00:15:06'),(15,'Ivan Alfonseca','Ivan27','alfonseca.ivan@gmail.com','2354789064','Sistemas','HCV','$2y$12$cFxfzZYupWRjrki3Ct8KGunaR8pOciJPuesSJyX1SOwJWOAF0iTgi',2,'2025-11-20 00:06:11');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-20 15:59:13
