/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: coba_asistencias
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB-0+deb13u1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `asistencias`
--

DROP TABLE IF EXISTS `asistencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `asistencias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `matricula` varchar(20) NOT NULL,
  `fecha` date NOT NULL,
  `hora_entrada` timestamp NULL DEFAULT NULL,
  `hora_salida` timestamp NULL DEFAULT NULL,
  `estado` enum('presente','retardo','falta','justificada') NOT NULL DEFAULT 'falta',
  `kiosco_entrada_id` bigint(20) unsigned DEFAULT NULL,
  `kiosco_salida_id` bigint(20) unsigned DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asistencias_matricula_fecha_unique` (`matricula`,`fecha`),
  KEY `asistencias_kiosco_entrada_id_foreign` (`kiosco_entrada_id`),
  KEY `asistencias_kiosco_salida_id_foreign` (`kiosco_salida_id`),
  KEY `asistencias_fecha_index` (`fecha`),
  CONSTRAINT `asistencias_kiosco_entrada_id_foreign` FOREIGN KEY (`kiosco_entrada_id`) REFERENCES `kioscos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `asistencias_kiosco_salida_id_foreign` FOREIGN KEY (`kiosco_salida_id`) REFERENCES `kioscos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `asistencias_matricula_foreign` FOREIGN KEY (`matricula`) REFERENCES `estudiantes` (`matricula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencias`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `asistencias` WRITE;
/*!40000 ALTER TABLE `asistencias` DISABLE KEYS */;
INSERT INTO `asistencias` VALUES
(1,'24B4405001','2026-10-21','2026-10-22 05:36:15','2026-10-22 05:42:42','retardo',1,1,NULL,'2026-10-22 05:36:15','2026-10-22 05:42:42');
/*!40000 ALTER TABLE `asistencias` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `calificaciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `matricula` varchar(20) NOT NULL,
  `materia_id` bigint(20) unsigned NOT NULL,
  `parcial` tinyint(4) NOT NULL,
  `calificacion` decimal(4,1) NOT NULL,
  `periodo` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calificaciones_matricula_materia_id_parcial_periodo_unique` (`matricula`,`materia_id`,`parcial`,`periodo`),
  KEY `calificaciones_materia_id_foreign` (`materia_id`),
  CONSTRAINT `calificaciones_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `calificaciones_matricula_foreign` FOREIGN KEY (`matricula`) REFERENCES `estudiantes` (`matricula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calificaciones`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `calificaciones` WRITE;
/*!40000 ALTER TABLE `calificaciones` DISABLE KEYS */;
INSERT INTO `calificaciones` VALUES
(1,'24B4405001',1,1,6.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(2,'24B4405001',1,2,6.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(3,'24B4405001',1,3,10.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(4,'24B4405001',2,1,10.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(5,'24B4405001',2,2,6.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(6,'24B4405001',2,3,8.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(7,'24B4405001',3,1,7.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(8,'24B4405001',3,2,6.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(9,'24B4405001',3,3,9.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(10,'24B4405001',4,1,9.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(11,'24B4405001',4,2,7.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(12,'24B4405001',4,3,9.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(13,'24B4405001',5,1,6.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(14,'24B4405001',5,2,9.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(15,'24B4405001',5,3,10.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(16,'24B4405002',1,1,6.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(17,'24B4405002',1,2,8.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(18,'24B4405002',1,3,8.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(19,'24B4405002',2,1,9.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(20,'24B4405002',2,2,9.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(21,'24B4405002',2,3,8.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(22,'24B4405002',3,1,10.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(23,'24B4405002',3,2,6.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(24,'24B4405002',3,3,7.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(25,'24B4405002',4,1,7.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(26,'24B4405002',4,2,9.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(27,'24B4405002',4,3,7.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(28,'24B4405002',5,1,9.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(29,'24B4405002',5,2,10.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(30,'24B4405002',5,3,10.0,'2025-2026-1','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(31,'24B4405003',1,1,6.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(32,'24B4405003',1,2,6.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(33,'24B4405003',1,3,8.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(34,'24B4405003',2,1,6.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(35,'24B4405003',2,2,10.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(36,'24B4405003',2,3,6.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(37,'24B4405003',3,1,8.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(38,'24B4405003',3,2,8.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(39,'24B4405003',3,3,10.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(40,'24B4405003',4,1,8.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(41,'24B4405003',4,2,8.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(42,'24B4405003',4,3,8.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(43,'24B4405003',5,1,10.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(44,'24B4405003',5,2,10.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(45,'24B4405003',5,3,6.0,'2025-2026-1','2026-10-22 04:46:11','2026-10-22 04:46:11');
/*!40000 ALTER TABLE `calificaciones` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `estudiante_tutor`
--

DROP TABLE IF EXISTS `estudiante_tutor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiante_tutor` (
  `tutor_id` bigint(20) unsigned NOT NULL,
  `matricula` varchar(20) NOT NULL,
  PRIMARY KEY (`tutor_id`,`matricula`),
  KEY `estudiante_tutor_matricula_foreign` (`matricula`),
  CONSTRAINT `estudiante_tutor_matricula_foreign` FOREIGN KEY (`matricula`) REFERENCES `estudiantes` (`matricula`) ON DELETE CASCADE,
  CONSTRAINT `estudiante_tutor_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `tutores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante_tutor`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `estudiante_tutor` WRITE;
/*!40000 ALTER TABLE `estudiante_tutor` DISABLE KEYS */;
INSERT INTO `estudiante_tutor` VALUES
(1,'24B4405001'),
(1,'24B4405002');
/*!40000 ALTER TABLE `estudiante_tutor` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `estudiantes`
--

DROP TABLE IF EXISTS `estudiantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiantes` (
  `matricula` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido_paterno` varchar(100) NOT NULL,
  `apellido_materno` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `curp` varchar(18) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `semestre` varchar(5) NOT NULL,
  `grupo` varchar(5) NOT NULL,
  `turno` enum('Matutino','Vespertino') NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`matricula`),
  UNIQUE KEY `estudiantes_curp_unique` (`curp`),
  UNIQUE KEY `estudiantes_email_unique` (`email`),
  KEY `estudiantes_semestre_grupo_turno_index` (`semestre`,`grupo`,`turno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiantes`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `estudiantes` WRITE;
/*!40000 ALTER TABLE `estudiantes` DISABLE KEYS */;
INSERT INTO `estudiantes` VALUES
('24B4405001','Juan','Pérez','López','2008-01-15',NULL,NULL,NULL,'3','A','Matutino',1,'2026-10-22 04:46:10','2026-10-22 04:46:10'),
('24B4405002','María','García','Hernández','2008-02-15',NULL,NULL,NULL,'3','A','Matutino',1,'2026-10-22 04:46:10','2026-10-22 04:46:10'),
('24B4405003','Luis','Ramírez','Sánchez','2008-03-15',NULL,NULL,NULL,'3','A','Matutino',1,'2026-10-22 04:46:10','2026-10-22 04:46:10');
/*!40000 ALTER TABLE `estudiantes` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `horarios`
--

DROP TABLE IF EXISTS `horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `horarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `semestre` varchar(5) NOT NULL,
  `grupo` varchar(5) NOT NULL,
  `turno` enum('Matutino','Vespertino') NOT NULL,
  `dia_semana` tinyint(4) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `materia_id` bigint(20) unsigned NOT NULL,
  `docente` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `horarios_materia_id_foreign` (`materia_id`),
  KEY `horarios_semestre_grupo_turno_dia_semana_index` (`semestre`,`grupo`,`turno`,`dia_semana`),
  CONSTRAINT `horarios_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarios`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `horarios` WRITE;
/*!40000 ALTER TABLE `horarios` DISABLE KEYS */;
INSERT INTO `horarios` VALUES
(1,'3','A','Matutino',1,'07:00:00','08:40:00',1,'Prof. Matemáticas III','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(2,'3','A','Matutino',1,'08:50:00','10:30:00',2,'Prof. Física II','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(3,'3','A','Matutino',1,'10:40:00','12:20:00',4,'Prof. Literatura','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(4,'3','A','Matutino',2,'07:00:00','08:40:00',3,'Prof. Química II','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(5,'3','A','Matutino',2,'08:50:00','10:30:00',5,'Prof. Historia de México','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(6,'3','A','Matutino',3,'07:00:00','08:40:00',1,'Prof. Matemáticas III','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(7,'3','A','Matutino',3,'08:50:00','10:30:00',2,'Prof. Física II','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(8,'3','A','Matutino',4,'07:00:00','08:40:00',4,'Prof. Literatura','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(9,'3','A','Matutino',4,'08:50:00','10:30:00',3,'Prof. Química II','2026-10-22 04:46:11','2026-10-22 04:46:11'),
(10,'3','A','Matutino',5,'07:00:00','08:40:00',5,'Prof. Historia de México','2026-10-22 04:46:11','2026-10-22 04:46:11');
/*!40000 ALTER TABLE `horarios` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `kioscos`
--

DROP TABLE IF EXISTS `kioscos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kioscos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `token` varchar(64) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kioscos_slug_unique` (`slug`),
  UNIQUE KEY `kioscos_token_unique` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kioscos`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `kioscos` WRITE;
/*!40000 ALTER TABLE `kioscos` DISABLE KEYS */;
INSERT INTO `kioscos` VALUES
(1,'Prefectura','prefectura','Entrada principal','token_prefectura',1,'2026-10-22 04:46:10','2026-10-22 05:40:58'),
(2,'Dirección','direccion','Edificio administrativo','token_direccion',1,'2026-10-22 04:46:10','2026-10-22 05:40:58'),
(3,'Subdirección','subdireccion','Edificio administrativo','token_subdireccion',1,'2026-10-22 04:46:10','2026-10-22 05:40:58');
/*!40000 ALTER TABLE `kioscos` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `materias`
--

DROP TABLE IF EXISTS `materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `clave` varchar(20) NOT NULL,
  `semestre` varchar(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `materias_clave_unique` (`clave`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES
(1,'Matemáticas III','MAT301','3','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(2,'Física II','FIS301','3','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(3,'Química II','QUI301','3','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(4,'Literatura','ESP301','3','2026-10-22 04:46:10','2026-10-22 04:46:10'),
(5,'Historia de México','HIS301','3','2026-10-22 04:46:10','2026-10-22 04:46:10');
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_01_01_000001_create_estudiantes_table',1),
(5,'2025_01_01_000002_create_tutores_table',1),
(6,'2025_01_01_000003_create_estudiante_tutor_table',1),
(7,'2025_01_01_000004_add_fields_to_users_table',1),
(8,'2025_01_01_000005_create_materias_table',1),
(9,'2025_01_01_000006_create_horarios_table',1),
(10,'2025_01_01_000007_create_calificaciones_table',1),
(11,'2025_01_01_000008_create_kioscos_table',1),
(12,'2025_01_01_000009_create_asistencias_table',1),
(13,'2025_01_01_000010_create_reportes_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `reportes`
--

DROP TABLE IF EXISTS `reportes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reportes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `matricula` varchar(20) NOT NULL,
  `tipo` enum('conducta','academico','medico','otro') NOT NULL,
  `descripcion` text NOT NULL,
  `creado_por` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reportes_matricula_foreign` (`matricula`),
  KEY `reportes_creado_por_foreign` (`creado_por`),
  CONSTRAINT `reportes_creado_por_foreign` FOREIGN KEY (`creado_por`) REFERENCES `users` (`id`),
  CONSTRAINT `reportes_matricula_foreign` FOREIGN KEY (`matricula`) REFERENCES `estudiantes` (`matricula`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reportes`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `reportes` WRITE;
/*!40000 ALTER TABLE `reportes` DISABLE KEYS */;
/*!40000 ALTER TABLE `reportes` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('7eTssOqTYtE7vzIzKTulRrf1IvNHTowC8jfHJlHj',NULL,'127.0.0.1','curl/8.14.1','eyJfdG9rZW4iOiJqZTlqakxjR2wyOHNualAyejBQcHA4V0xrdEdkNzc1OU43N2xibjFRIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792625546),
('7iBB7FumSeC0gBPk6j3TNbNECNtUmwcl2UqfjSeO',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0','eyJfdG9rZW4iOiJwVHAyMm91bjRpeUZVSlQ4WEpwSVVEUjc2U3Y0NmMwTFI2WmVLNVFuIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792625304),
('af07j2DEKFnD0gmlB1IydjD6kbElIIcNA8hL3Ltw',NULL,'127.0.0.1','curl/8.14.1','eyJfdG9rZW4iOiJ2QVUwdWZkZVJBdVR5aDAxOXVhdkJZZDFGZE1CTWR5MUtKQXdPZFVuIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792624992),
('E5qNc3Oov5dj83FhbUTgb1Ljtut0YzJAw06sHfT6',5,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0','eyJfdG9rZW4iOiJEZnlRZ0I1QVBDb1Y3ZEdwaFI1Z1hObmJITHNEY3RMNkNuY0VwOWFaIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9lc3R1ZGlhbnRlcyIsInJvdXRlIjoiZmlsYW1lbnQuYWRtaW4ucmVzb3VyY2VzLmVzdHVkaWFudGVzLmluZGV4In0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo1LCJwYXNzd29yZF9oYXNoX3dlYiI6ImFjMzgzNmE3MzJmZDMwNGE0NDc0NWVkZDQ4ZGYyZWYyYThhM2FmZTE5Mzg0ZGU4OTc4ZmU4YmNmNTAzMjZmMjIiLCJ0YWJsZXMiOnsiZTZiNmNjYWM0YmJiZDYxNTg5ZmZiYmFjZGM4OTRlZjlfcGVyX3BhZ2UiOiI1MCJ9fQ==',1792627466),
('fHzXK83wcKQbLu2J3euTlmhxVKCIXSmntmROhPt9',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0','eyJfdG9rZW4iOiJQSWJxemlFb1pPWHhqeDZTdXdDVHpENURPMzFmMlZKVDNJRXZCeU1BIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9raW9zY29cL3ByZWZlY3R1cmEiLCJyb3V0ZSI6Imtpb3Njby5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1792626252),
('IJwQGH0SzhRZCkOq8wrawpw8JJ0MbIGenZdz03hP',NULL,'127.0.0.1','curl/8.14.1','eyJfdG9rZW4iOiJjclhXUjJyVjhZSGdlOHpkYjhLa3pwemIyUGEwNXJpalFDSXlWMlA1IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792625775),
('M0n48XYA78gGzBsqvvv1SLKwQnshUv90CuMwazbT',NULL,'127.0.0.1','curl/8.14.1','eyJfdG9rZW4iOiI1MzVEZlFYZ1E3Mk9qd2FOTXVlTnNtMjBlekptWUxxVzIxcnFKMlFvIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792626717),
('m0pBsmyBLMo3TV8qYehJOfKC68SbjklG7wxbYtMf',NULL,'127.0.0.1','curl/8.14.1','eyJfdG9rZW4iOiI3VDVLeTBHU01VTzFwa3BYWm9yYk5RNWVFS2Qwb0kzS2k1SEdCY3QzIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792626162),
('pPOOVeeR93qt6aRIQs3KZOGN1APJo3VYHzs4WZc7',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0','eyJfdG9rZW4iOiJHQmtpYXVsNkRkMU1tMU15aGVLS2VjekZHUDRpRDdDZFM5TEpvdkpXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792624704);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `tutores`
--

DROP TABLE IF EXISTS `tutores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tutores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido_paterno` varchar(100) NOT NULL,
  `apellido_materno` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `parentesco` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tutores_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tutores`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `tutores` WRITE;
/*!40000 ALTER TABLE `tutores` DISABLE KEYS */;
INSERT INTO `tutores` VALUES
(1,'Roberto','Pérez','Gómez','9511234567','tutor@coba.edu.mx','Padre','2026-10-22 04:46:11','2026-10-22 04:46:11');
/*!40000 ALTER TABLE `tutores` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rol` enum('admin','alumno','tutor') NOT NULL DEFAULT 'alumno',
  `matricula` varchar(20) DEFAULT NULL,
  `tutor_id` bigint(20) unsigned DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_matricula_unique` (`matricula`),
  UNIQUE KEY `users_tutor_id_unique` (`tutor_id`),
  CONSTRAINT `users_matricula_foreign` FOREIGN KEY (`matricula`) REFERENCES `estudiantes` (`matricula`) ON DELETE SET NULL,
  CONSTRAINT `users_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `tutores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Juan Pérez López','juan@coba.edu.mx','alumno','24B4405001',NULL,NULL,'$2y$12$GK0lCjmCoVdtFozeBAw0FuMpQAc1jGzeSsIm3Xf0aG031MD0IxxWG',NULL,'2026-10-22 04:46:10','2026-10-22 04:46:10'),
(2,'María García Hernández','maría@coba.edu.mx','alumno','24B4405002',NULL,NULL,'$2y$12$PvqE.B4FsGTkkJPwI0G2teNjyaepSzFHYSeABYWUUEg1TzLJgU2q2',NULL,'2026-10-22 04:46:10','2026-10-22 04:46:10'),
(3,'Luis Ramírez Sánchez','luis@coba.edu.mx','alumno','24B4405003',NULL,NULL,'$2y$12$YpN.5fGlMH4gLltBBe9DMOFxEw2muyWBwQ1Agl3dPS.859u.uqiEm',NULL,'2026-10-22 04:46:11','2026-10-22 04:46:11'),
(4,'Roberto Pérez Gómez','tutor@coba.edu.mx','tutor',NULL,1,NULL,'$2y$12$l2Q4yKVbhlPTNIrYy7KVAeCqiyYOr8L7nr8e01oJV6M8mnc7Pq3cC',NULL,'2026-10-22 04:46:11','2026-10-22 05:01:23'),
(5,'Administrador','shersmartinez34@hotmail.com','admin',NULL,NULL,NULL,'$2y$12$yjP5zZ0oukTNwP6O6wOrR.11zln6eyPtyZV34KebwsQljE/XQVAgm',NULL,'2026-10-22 04:50:00','2026-10-22 04:58:28');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-10-21 18:59:57
