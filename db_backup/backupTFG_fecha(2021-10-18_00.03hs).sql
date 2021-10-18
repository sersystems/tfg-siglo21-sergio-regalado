-- MySQL dump 10.13  Distrib 8.0.26, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: biblioteca_popular_sur
-- ------------------------------------------------------
-- Server version	8.0.26

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
-- Table structure for table `clase`
--

DROP TABLE IF EXISTS `clase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clase` (
  `id` int NOT NULL AUTO_INCREMENT,
  `taller_id` int NOT NULL,
  `titulo` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `numero` tinyint(3) unsigned zerofill NOT NULL,
  `fecha` date NOT NULL,
  `horario` time NOT NULL,
  `duracion` tinyint NOT NULL,
  `estado` enum('DICTADO','PENDIENTE') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_clase_taller1_idx` (`taller_id`),
  CONSTRAINT `fk_clase_taller1` FOREIGN KEY (`taller_id`) REFERENCES `taller` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clase`
--

LOCK TABLES `clase` WRITE;
/*!40000 ALTER TABLE `clase` DISABLE KEYS */;
INSERT INTO `clase` VALUES (1,1,'BIENVENIDA',001,'2021-03-03','17:00:00',60,'DICTADO'),(2,1,'ORÍGENES MUSICALES',002,'2021-03-05','17:00:00',60,'PENDIENTE'),(3,1,'TIEMPOS MUSICALES',003,'2021-03-10','17:00:00',60,'PENDIENTE'),(4,1,'NOTAS MUSICALES',004,'2021-03-12','17:00:00',60,'PENDIENTE'),(5,1,'LA VOZ',005,'2021-03-17','17:00:00',60,'PENDIENTE'),(6,1,'ENTONACIÓN',006,'2021-03-19','17:00:00',60,'PENDIENTE'),(7,1,'LA GUITARRA',007,'2021-03-26','17:00:00',60,'PENDIENTE'),(8,1,'AFINACIÓN',008,'2021-03-31','17:00:00',60,'PENDIENTE'),(9,1,'TU CANCIÓN ',009,'2021-04-07','17:00:00',60,'PENDIENTE'),(10,1,'CIERRE',010,'2021-04-14','17:00:00',60,'PENDIENTE'),(11,2,'INTRODUCCIÓN A LA COMPUTACIÓN',001,'2021-03-02','18:00:00',90,'PENDIENTE'),(12,2,'HARDWARE',002,'2021-03-04','18:00:00',90,'PENDIENTE'),(13,2,'SOFTWARE',003,'2021-03-09','18:00:00',90,'PENDIENTE'),(14,2,'SISTEMAS OPERATIVOS',004,'2021-03-11','18:00:00',90,'PENDIENTE'),(15,2,'NAVEGADORES DE INTERNET',005,'2021-03-16','18:00:00',90,'PENDIENTE'),(16,2,'CIERRE',006,'2021-03-18','18:00:00',90,'PENDIENTE'),(17,3,'INTRODUCCION A LA COMPUTACION',001,'2021-05-04','19:00:00',120,'PENDIENTE'),(18,3,'NAVEVEGADORES DE INTERNET',002,'2021-05-06','19:00:00',120,'PENDIENTE'),(19,3,'REDES SOCIALES',003,'2021-05-11','19:00:00',120,'PENDIENTE'),(20,3,'ZOOM',004,'2021-05-13','19:00:00',120,'PENDIENTE'),(21,3,'MEET',005,'2021-05-18','19:00:00',120,'PENDIENTE'),(22,3,'MICROSOFT OFFICE 2016',006,'2021-05-20','19:00:00',120,'PENDIENTE'),(23,3,'POLARIS OFFICE',007,'2021-05-25','19:00:00',120,'PENDIENTE'),(24,3,'CIERRE DE CURSADA',008,'2021-05-27','19:00:00',120,'PENDIENTE'),(25,4,'BIENVENIDAD & INTRO',001,'2021-10-26','16:00:00',60,'PENDIENTE'),(26,4,'REPASO DE EXCEL BASICO',002,'2021-10-29','16:00:00',60,'PENDIENTE'),(27,4,'EXCEL - FUNCIONES NIVEL 1',003,'2021-11-02','16:00:00',60,'PENDIENTE'),(28,4,'EXCEL - FUNCIONES NIVEL 2',004,'2021-11-05','16:00:00',60,'PENDIENTE'),(29,4,'EXCEL - FUNCIONES NIVEL 3',005,'2021-11-09','16:00:00',60,'PENDIENTE'),(30,4,'EXCEL - TABLAS DINAMICAS',006,'2021-11-12','16:00:00',60,'PENDIENTE'),(31,4,'WORD - OPERACIONES AVANZADAS',007,'2021-11-16','16:00:00',60,'PENDIENTE'),(32,4,'POWER - OPERACIONES AVANZADAS',008,'2021-11-19','16:00:00',60,'PENDIENTE'),(33,4,'EVALUACIÓN FINAL',009,'2021-11-23','16:00:00',60,'PENDIENTE');
/*!40000 ALTER TABLE `clase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contrasenia`
--

DROP TABLE IF EXISTS `contrasenia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contrasenia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `hash` char(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_contrasenia_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_contrasenia_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contrasenia`
--

LOCK TABLES `contrasenia` WRITE;
/*!40000 ALTER TABLE `contrasenia` DISABLE KEYS */;
INSERT INTO `contrasenia` VALUES (1,1,'$2y$12$nr.SRcbDtd9tCnpjlSWIqeVF.dCWwqLH7GzXj/rBvdWg1z7bSQx/G','2021-06-25 17:53:44','2021-06-25 17:53:44'),(2,2,'$2y$12$qoUVMAG9p/re26JPUK3xOux4sOFmn9QqyeLBRrRUJ93zoNMQJIHQC','2021-06-25 18:00:14','2021-06-25 18:00:14'),(3,3,'$2y$12$pxA/OdAk4LMXiQwnSUaCWeR9xBh4brPUi1nEcHGNzsh8aAWjuoSpy','2021-06-25 18:05:26','2021-06-25 18:05:26'),(4,4,'$2y$12$8nkbN2XuewWtuwwcbeg58O7T9kvhGsyo7dGkhg0F7lj4Qs96qdopW','2021-06-25 18:07:57','2021-06-25 18:07:57'),(5,5,'$2y$12$Wj1vLNEcKGneOxHVoX4R6u.7dq7nd279ObK8u7lNvV24dqkthzK96','2021-06-26 02:35:20','2021-06-26 02:35:20');
/*!40000 ALTER TABLE `contrasenia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diploma`
--

DROP TABLE IF EXISTS `diploma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diploma` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo_verificacion` char(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `bloque_smart_contract` int NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_verificacion_UNIQUE` (`codigo_verificacion`),
  UNIQUE KEY `bloque_smart_contract_UNIQUE` (`bloque_smart_contract`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diploma`
--

LOCK TABLES `diploma` WRITE;
/*!40000 ALTER TABLE `diploma` DISABLE KEYS */;
INSERT INTO `diploma` VALUES (1,'BC008880128RO83',8880128,'2021-07-04 22:53:47'),(2,'BC008880384AG7',8880384,'2021-07-04 23:58:00');
/*!40000 ALTER TABLE `diploma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `direccion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `institucion_id` int DEFAULT NULL,
  `direccion` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo_postal` char(6) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `provincia` char(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `localidad` char(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pais_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_direccion_pais1_idx` (`pais_id`),
  KEY `fk_direccion_usuario1_idx` (`usuario_id`),
  KEY `fk_direccion_institucion1_idx` (`institucion_id`),
  CONSTRAINT `fk_direccion_institucion1` FOREIGN KEY (`institucion_id`) REFERENCES `institucion` (`id`),
  CONSTRAINT `fk_direccion_pais1` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`),
  CONSTRAINT `fk_direccion_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
INSERT INTO `direccion` VALUES (1,1,NULL,'GUEMES 614 (O)','5425','SAN JUAN','RAWSON',1),(2,2,NULL,'AV. ESPAÑA 1577 (S)','5423','SAN JUAN','VILLA KRAUSE',1),(3,3,NULL,'AV. SAN MARTIN 3411','5500','MENDOZA','CAPITAL',1),(4,4,NULL,'GRAL. PAZ (E)','5400','MORE@MORE.COM','CAPITAL',1),(5,5,NULL,'AV. MENDOZA 2588','5425','SAN JUAN','RAWSON',1),(6,NULL,1,'AV. MENDOZA Y DR. ORTEGA','5425','SAN JUAN','RAWSON',1);
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documento_tipo`
--

DROP TABLE IF EXISTS `documento_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documento_tipo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denominacion_corta` char(4) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `denominacion_larga` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pais_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_documento_tipo_pais1_idx` (`pais_id`),
  CONSTRAINT `fk_documento_tipo_pais1` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_tipo`
--

LOCK TABLES `documento_tipo` WRITE;
/*!40000 ALTER TABLE `documento_tipo` DISABLE KEYS */;
INSERT INTO `documento_tipo` VALUES (1,'CC','CEDULA DE CIUDADANIA',5),(2,'CI','CEDULA DE IDENTIDAD',2),(3,'DNI','DOCUMENTO UNICO DE IDENTIDAD',1);
/*!40000 ALTER TABLE `documento_tipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripcion`
--

DROP TABLE IF EXISTS `inscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscripcion` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `taller_id` int NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  `asistencia_final` float(4,2) DEFAULT NULL,
  `calificacion_final` float(4,2) DEFAULT '0.00',
  `situacion_cursada` enum('APROBADO','DESAPROBADO','EN CURSO','PENDIENTE') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `diploma_id` int DEFAULT NULL,
  PRIMARY KEY (`id`,`usuario_id`,`taller_id`),
  KEY `fk_usuario_has_taller_taller1_idx` (`taller_id`),
  KEY `fk_usuario_has_taller_usuario1_idx` (`usuario_id`),
  KEY `fk_inscripcion_diploma1_idx` (`diploma_id`),
  CONSTRAINT `fk_inscripcion_diploma1` FOREIGN KEY (`diploma_id`) REFERENCES `diploma` (`id`),
  CONSTRAINT `fk_usuario_has_taller_taller1` FOREIGN KEY (`taller_id`) REFERENCES `taller` (`id`),
  CONSTRAINT `fk_usuario_has_taller_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion`
--

LOCK TABLES `inscripcion` WRITE;
/*!40000 ALTER TABLE `inscripcion` DISABLE KEYS */;
INSERT INTO `inscripcion` VALUES (1,3,1,'2021-03-01',75.00,8.00,'APROBADO',1),(2,3,2,'2021-03-01',75.00,8.00,'APROBADO',NULL),(3,5,1,'2021-02-25',65.00,4.00,'DESAPROBADO',NULL),(4,5,2,'2021-03-02',90.00,5.00,'DESAPROBADO',NULL),(5,2,1,'2021-02-26',90.00,10.00,'APROBADO',2),(6,2,3,'2021-07-04',0.00,0.00,'PENDIENTE',NULL);
/*!40000 ALTER TABLE `inscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institucion`
--

DROP TABLE IF EXISTS `institucion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `institucion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cuit` char(11) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `responsable_tipo` enum('MONOTRIBUTISTA SOCIAL','RESPONSABLE INSCRIPTO','RESPONSABLE MONOTRIBUTO','SUJETO EXENTO','SUJETO NO CATEGORIZADO') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_contrato_social` date NOT NULL,
  `registro_conabip` char(4) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correo_electronico` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institucion`
--

LOCK TABLES `institucion` WRITE;
/*!40000 ALTER TABLE `institucion` DISABLE KEYS */;
INSERT INTO `institucion` VALUES (1,'BIBLIOTECA POPULAR SUR','30710471068','SUJETO EXENTO','2004-12-04','4222','bibliotecapopularsur@hotmail.es','2021-06-27 00:36:06','2021-06-27 00:36:06');
/*!40000 ALTER TABLE `institucion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pais` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES (1,'ARGENTINA'),(2,'BOLIVIA'),(3,'BRASIL'),(4,'CHILE'),(5,'COLOMBIA'),(6,'COSTA RICA'),(7,'CUBA'),(8,'ECUADOR'),(9,'EL SALVADOR'),(10,'GUATEMALA'),(11,'HAITÍ'),(12,'HONDURAS'),(13,'MÉXICO'),(14,'NICARAGUA'),(15,'PANAMÁ'),(16,'PARAGUAY'),(17,'PERÚ'),(18,'URUGUAY'),(19,'VENEZUELA');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suscripcion`
--

DROP TABLE IF EXISTS `suscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suscripcion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `fecha_vto` date DEFAULT NULL,
  `importe` float(10,2) NOT NULL,
  `estado` enum('CADUCADO','EN PROCESO','VIGENTE') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_suscripcion_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_suscripcion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suscripcion`
--

LOCK TABLES `suscripcion` WRITE;
/*!40000 ALTER TABLE `suscripcion` DISABLE KEYS */;
INSERT INTO `suscripcion` VALUES (1,2,'2021-05-25',150.00,'CADUCADO','2021-02-25 18:29:38','2021-02-25 18:30:40'),(3,3,'2021-05-10',150.00,'CADUCADO','2021-03-11 00:39:57','2021-03-11 00:40:51'),(4,3,'2021-09-26',150.00,'CADUCADO','2021-06-26 00:44:37','2021-06-26 04:16:41'),(5,2,'2021-10-04',150.00,'CADUCADO','2021-07-05 00:24:19','2021-07-05 00:27:34');
/*!40000 ALTER TABLE `suscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taller`
--

DROP TABLE IF EXISTS `taller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taller` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `dia_horario` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_cierre` date NOT NULL,
  `carga_horaria` smallint NOT NULL,
  `cupo_max` tinyint NOT NULL,
  `cupo_actual` tinyint NOT NULL,
  `estado` enum('EN CURSO','FINALIZADO','PENDIENTE','SUSPENDIDO') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taller`
--

LOCK TABLES `taller` WRITE;
/*!40000 ALTER TABLE `taller` DISABLE KEYS */;
INSERT INTO `taller` VALUES (1,'GUITARRA & CANTO','MARTES Y JUEVES DE 17 A 18H','2021-03-03','2021-04-14',11,10,7,'FINALIZADO','2021-02-01 18:10:54','2021-07-04 23:48:33'),(2,'COMPUTACION I','LUNES Y VIERNES DE 18 A 19:30H','2021-03-02','2021-03-24',9,20,18,'FINALIZADO','2021-02-05 18:39:36','2021-03-31 18:39:36'),(3,'COMPUTACION II','MARTES Y JUEVES DE 19 A 21H','2021-05-04','2021-05-27',16,20,19,'FINALIZADO','2021-07-04 21:47:07','2021-07-04 21:59:46'),(4,'COMPUTACION III','MARTES Y VIERNES DE 16 A 17HS','2021-10-26','2021-11-26',9,10,10,'PENDIENTE','2021-10-17 23:50:58','2021-10-17 23:59:55');
/*!40000 ALTER TABLE `taller` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefono`
--

DROP TABLE IF EXISTS `telefono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefono` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `institucion_id` int DEFAULT NULL,
  `tipo` enum('TELEFONO FIJO','TELEFONO MOVIL') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `prefijo` char(5) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `numero` char(9) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_telefono_usuario1_idx` (`usuario_id`),
  KEY `fk_telefono_institucion1_idx` (`institucion_id`),
  CONSTRAINT `fk_telefono_institucion1` FOREIGN KEY (`institucion_id`) REFERENCES `institucion` (`id`),
  CONSTRAINT `fk_telefono_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefono`
--

LOCK TABLES `telefono` WRITE;
/*!40000 ALTER TABLE `telefono` DISABLE KEYS */;
INSERT INTO `telefono` VALUES (1,2,NULL,'TELEFONO MOVIL','264','5887744'),(2,2,NULL,'TELEFONO MOVIL','264','6441010'),(3,NULL,1,'TELEFONO MOVIL','264','4280577'),(4,1,NULL,'TELEFONO MOVIL','264','5668874');
/*!40000 ALTER TABLE `telefono` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol` enum('ADMINISTRADOR','DOCENTE','SOCIO') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documento_tipo_id` int NOT NULL,
  `documento_nro` char(9) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `sexo` enum('F','M') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `correo_electronico` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fotografia` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('ACTIVO','SUSPENDIDO') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo_electronico_UNIQUE` (`correo_electronico`),
  KEY `fk_usuario_documento_tipo1_idx` (`documento_tipo_id`),
  CONSTRAINT `fk_usuario_documento_tipo1` FOREIGN KEY (`documento_tipo_id`) REFERENCES `documento_tipo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'ADMINISTRADOR','SERGIO','REGALADO ALESSI',1,'28005630','M','1980-03-11','ser@ser.com','/public_html/img/fotografia/usuario_1.jpg','ACTIVO','2021-06-25 17:53:44','2021-06-25 17:53:44'),(2,'SOCIO','MORENA LORENA','AGUIRRE',1,'45788555','F','2000-06-20','more@more.com','/public_html/img/fotografia/usuario_2.jpg','ACTIVO','2021-06-25 18:00:14','2021-06-25 18:00:14'),(3,'SOCIO','LUIS ARMANDO','RODRIGUEZ',1,'25122455','M','1975-11-01','luis@gmail.com','/public_html/img/fotografia/usuario_3.jpg','ACTIVO','2021-06-25 18:05:25','2021-06-25 18:05:25'),(4,'SOCIO','MARIELA ADRINA','GARCIA',1,'31004888','M','1985-04-15','mariela@gmail.com','/public_html/img/fotografia/usuario_4.jpg','ACTIVO','2021-06-25 18:07:57','2021-06-25 18:07:57'),(5,'SOCIO','CARLOS ALBERTO','MANRIQUE',1,'22144752','M','1972-10-13','carlos@gmail.com','/public_html/img/fotografia/usuario_5.jpg','ACTIVO','2021-06-26 02:35:19','2021-06-26 02:35:19');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-17 21:03:40
