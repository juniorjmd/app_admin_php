-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: intra_aaa_v3
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adm_menus`
--

DROP TABLE IF EXISTS `adm_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adm_menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `display_name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user` int NOT NULL,
  `date_crt` datetime NOT NULL,
  `id_wp` int DEFAULT '0',
  `ruta_fisica` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_menus`
--

LOCK TABLES `adm_menus` WRITE;
/*!40000 ALTER TABLE `adm_menus` DISABLE KEYS */;
INSERT INTO `adm_menus` VALUES (21,'gestion_humana','Queremos facilitarte el trámite de solicitudes en la que puedas interactuar con nosotros Por eso, disponemos para ti los siguientes formatos:','Gestión Humana',1,'2024-12-16 00:00:00',113,'uploads/gestion_humana'),(22,'seguridad_laboral','Es vital para nuestra compañía garantizar la seguridad a todos los colaboradores en sus entornos y circunstancias laborales. Contemplamos todos los eventos, escenas y situaciones en las que pueden presentarse riesgos laborales. Para su información, desplegamos a continuación un listado de todas las matrices de identificación de peligro, evaluación y valoración de los riesgos según las ultimas actualizaciones:\r\n\r\nMatriz de identificación de peligro, evaluación y valoración de los riesgos:','Seguridad Laboral',1,'2024-12-16 00:00:00',115,'uploads/seguridad_laboral'),(23,'gestion_de_la_calidad','Apreciado líder de Proceso, Aquí podrás consultar información del Sistema de Gestión de Calidad pendiente por migrar a Kawak, debido a ajustes de desarrollo que se deben hacer en el software:','Gestión de la Calidad',1,'2024-12-16 00:00:00',117,'uploads/gestion_de_la_calidad'),(24,'gestion_de_riesgos','documentos de interes :','Gestión De Riesgos',1,'2024-12-16 00:00:00',119,'uploads/gestion_de_riesgos'),(25,'bd_catastral','Devolución cargo fijo resolución 830. \r\n\r\nEn el siguiente enlace podrá consultar el avance de la ejecución de la devolución de cargos fijos de acueducto y alcantarillado por aplicación de la Resolución 830.','Base de Datos Catastral',1,'2024-12-16 00:00:00',121,'uploads/bd_catastral'),(26,'facturacion','Calendario de Facturación','Facturación',1,'2024-12-16 00:00:00',123,'uploads/facturacion'),(27,'efr','somos efr','efr',1,'2024-12-18 00:00:00',185,'uploads/efr');
/*!40000 ALTER TABLE `adm_menus` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `adm_menus_BEFORE_INSERT` BEFORE INSERT ON `adm_menus` FOR EACH ROW BEGIN
   set new.date_crt = curdate();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `adm_perfil`
--

DROP TABLE IF EXISTS `adm_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adm_perfil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `activo` tinyint DEFAULT '1',
  `crt_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_perfil`
--

LOCK TABLES `adm_perfil` WRITE;
/*!40000 ALTER TABLE `adm_perfil` DISABLE KEYS */;
INSERT INTO `adm_perfil` VALUES (1,'Admin',1,'2024-11-26 15:06:51'),(2,'folder_admin',1,'2024-11-26 15:06:51');
/*!40000 ALTER TABLE `adm_perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_perfil_recurso`
--

DROP TABLE IF EXISTS `adm_perfil_recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adm_perfil_recurso` (
  `id` int NOT NULL AUTO_INCREMENT,
  `recurso` int DEFAULT NULL,
  `perfil` int DEFAULT NULL,
  `activo` tinyint DEFAULT '1',
  `crt_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_perfil_recurso`
--

LOCK TABLES `adm_perfil_recurso` WRITE;
/*!40000 ALTER TABLE `adm_perfil_recurso` DISABLE KEYS */;
INSERT INTO `adm_perfil_recurso` VALUES (248,1,1,1,'2024-12-10 17:20:45'),(249,3,1,1,'2024-12-10 17:20:45'),(250,4,1,1,'2024-12-10 17:20:45'),(251,5,1,1,'2024-12-10 17:20:45'),(252,6,1,1,'2024-12-10 17:20:45'),(253,2,1,1,'2024-12-10 17:20:45'),(254,7,1,1,'2024-12-10 17:20:45'),(255,8,1,1,'2024-12-10 17:20:45');
/*!40000 ALTER TABLE `adm_perfil_recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_recurso`
--

DROP TABLE IF EXISTS `adm_recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adm_recurso` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `activo` tinyint DEFAULT '1',
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `crt_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `icono` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `tipo` int DEFAULT '1' COMMENT '1: link principal , 2 : permiso a proceso => este debe pertenecer a algun link principal',
  `padre` int DEFAULT '0' COMMENT 'si es padre el cero significa que pertene al home de la aplicacion y que se aplica a todas las paginas en general',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_recurso`
--

LOCK TABLES `adm_recurso` WRITE;
/*!40000 ALTER TABLE `adm_recurso` DISABLE KEYS */;
INSERT INTO `adm_recurso` VALUES (1,'usuarios','usuario menu',1,'user','2024-11-26 16:01:00','<i class=\"fas fa-users\"></i>',1,0),(2,'carpetas','carpetas menu',1,'folder','2024-11-26 16:01:00','<i class=\"fas fa-folder\"></i>',1,0),(3,'CREAR_USUARIOS','creacion de nuevos usuarios',1,NULL,'2024-11-27 15:29:07',NULL,2,1),(4,'ELIMINAR_USUARIOS','eliminar usuario',1,NULL,'2024-11-27 15:29:07',NULL,2,1),(5,'ACTUALIZAR_USUARIOS','actualizar usuarios',1,NULL,'2024-11-27 15:29:07',NULL,2,1),(6,'CAMBIAR_PASS_USUARIOS','cambiar contraseña a los usuarios',1,NULL,'2024-12-03 14:55:24',NULL,2,1),(7,'perfiles','perfil menu',1,'perfil','2024-12-03 19:28:28','<i class=\"fas fa-id-badge\"></i>',1,0),(8,'CREAR_PERFIL','creacion de perfiles',1,NULL,'2024-12-04 20:27:26',NULL,2,7);
/*!40000 ALTER TABLE `adm_recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_session`
--

DROP TABLE IF EXISTS `adm_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adm_session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET latin1 NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `usuario` int NOT NULL,
  `key` text CHARACTER SET latin1 NOT NULL,
  `fecha_hora_ini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_hora_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1192 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_session`
--

LOCK TABLES `adm_session` WRITE;
/*!40000 ALTER TABLE `adm_session` DISABLE KEYS */;
INSERT INTO `adm_session` VALUES (1000,'admin',0,1,'e01f3c6ef140b070032d3e403d970072062d6878','2024-11-26 18:38:11','2024-11-26 13:41:25'),(1001,'admin',0,1,'admin20241126011125','2024-11-26 18:41:25','2024-11-26 13:43:49'),(1002,'admin',0,1,'admin20241126011149','2024-11-26 18:43:49','2024-11-26 13:52:31'),(1003,'admin',0,1,'dfe458ef83852673f56e959170c1f409a44cf06b','2024-11-26 18:52:31','2024-11-26 13:52:54'),(1004,'admin',0,1,'1ef6bdc97deb1074ab5cd1efb05bdc4545a4ff9f','2024-11-26 18:52:54','2024-11-26 14:03:03'),(1005,'admin',0,1,'02b44e70fbaeff6977f970af6d6918074f33146c','2024-11-26 19:03:03','2024-11-26 14:08:16'),(1006,'admin',0,1,'dc7603f13accfb28aa48c723b549fb6fec5df180','2024-11-26 19:08:16','2024-11-26 14:09:59'),(1007,'admin',0,1,'4f82218184759d307edc50d4b3d5d679b0509c54','2024-11-26 19:09:59','2024-11-26 14:20:40'),(1008,'admin',0,1,'4424465eb79bb196e59abfa26d02840bad85710d','2024-11-26 19:20:40','2024-11-26 14:20:48'),(1009,'admin',0,1,'0fa1f1bfc80d5eec7d268b0ed991292fa769ea52','2024-11-26 19:20:48','2024-11-26 14:31:01'),(1010,'admin',0,1,'4adf057f80d68db5f828d3ebe53644f41ca3c900','2024-11-26 19:31:01','2024-11-26 14:31:01'),(1011,'admin',0,1,'0f4a7448b41c1127d3b52950f35608782609c2a8','2024-11-26 20:20:06','2024-11-26 15:21:13'),(1012,'admin',0,1,'dce14c1d7cc915ea7f1fd418cf692d3e7a911db8','2024-11-26 20:21:13','2024-11-26 15:30:47'),(1013,'admin',0,1,'b8cad481530057afde690fdef47f4a52d6b09ecc','2024-11-26 20:30:47','2024-11-26 15:35:26'),(1014,'admin',0,1,'e6b932924e1d8bedea5613756dcf92ad548c599f','2024-11-26 20:35:26','2024-11-26 15:35:37'),(1015,'admin',0,1,'3599566cf757a774b4f0a979d2fc839307b090be','2024-11-26 20:35:37','2024-11-26 16:33:29'),(1016,'admin',0,1,'7f02fe9c52974c892f7c59a3e43637e151a64a48','2024-11-26 21:33:29','2024-11-26 16:52:24'),(1017,'admin',0,1,'971af768de8746a077c64e91dbf1c5c4e8a14d3a','2024-11-26 21:52:24','2024-11-26 17:02:37'),(1018,'admin',0,1,'9255963e66aacfc4fe850873eb450e19c778bbc4','2024-11-26 22:02:37','2024-11-27 08:20:04'),(1019,'admin',0,1,'622491d4a9b38442e6c1ac50dafac549557a5c62','2024-11-27 13:20:04','2024-11-27 08:52:10'),(1020,'admin',0,1,'3254ee90b815f30b04eba23837d293f352183180','2024-11-27 13:52:10','2024-11-27 10:02:35'),(1021,'admin',0,1,'7d94f9fb4ebd6fbf3133d2363495fd49da1c3a1b','2024-11-27 15:02:35','2024-11-27 10:08:03'),(1022,'admin',0,1,'43d932118857540b6eb2432991d62362e6571a2b','2024-11-27 15:08:03','2024-11-27 10:09:34'),(1023,'admin',0,1,'bcb0c211e873090bb10623561cc7c032aac5ffaa','2024-11-27 15:09:34','2024-11-27 10:10:21'),(1024,'admin',0,1,'46c7e6fdc26f04a459ff90febcf65a44a455757e','2024-11-27 15:10:21','2024-11-27 10:14:37'),(1025,'admin',0,1,'92e334ce4f6e5c4a52343148235cffe8fd88ae6e','2024-11-27 15:14:37','2024-11-27 10:16:50'),(1026,'admin',0,1,'b9db40ede00c7d5b9124b1c4eaffc3e2af1e3cee','2024-11-27 15:16:50','2024-11-27 10:18:17'),(1027,'admin',0,1,'01946dc7f8fa1c16f9774ebf1d98269507e392a4','2024-11-27 15:18:17','2024-11-27 10:19:15'),(1028,'admin',0,1,'97c402e6fa5c4f11f3d4a087e46f6d6f8df44704','2024-11-27 15:19:15','2024-11-27 11:14:51'),(1029,'admin',0,1,'aba7d81a2fb09483bcbf1c54ec7537eeb43cbe8c','2024-11-27 16:14:51','2024-11-27 14:04:20'),(1030,'admin',0,1,'af3aa1a5015b7aa575d27201424538037397d404','2024-11-27 19:04:20','2024-11-27 15:30:40'),(1031,'admin',0,1,'b990c0aa13fd7af0de93dbbf1daf316c05351f07','2024-11-27 20:30:40','2024-11-27 15:37:15'),(1032,'admin',0,1,'3379c774b92316dc1df67e8b60fb6ba74787bbbf','2024-11-27 20:37:15','2024-11-27 16:55:33'),(1033,'admin',0,1,'ef3607af12bb1e39b87ee7e1adab19fefb143639','2024-11-27 21:55:33','2024-11-28 08:31:30'),(1034,'admin',0,1,'acd551ce31fd111bb67c01bf32c5a28b3416411a','2024-11-28 13:31:30','2024-11-28 10:12:07'),(1035,'admin',0,1,'3d7285276c069ed692afc6542ad45b4a165636e4','2024-11-28 15:12:07','2024-11-28 16:15:24'),(1036,'admin',0,1,'d3c4905a2b3a1aaafd3925d0dacf3cf30ae50750','2024-11-28 21:15:24','2024-11-28 16:15:24'),(1037,'admin',0,1,'d3c4905a2b3a1aaafd3925d0dacf3cf30ae50750','2024-11-28 21:15:24','2024-11-29 09:54:50'),(1038,'admin',0,1,'c9c53aacafa6d049d768ac14e832adb93c0eb70d','2024-11-29 14:54:50','2024-11-29 09:54:50'),(1039,'admin',0,1,'c9c53aacafa6d049d768ac14e832adb93c0eb70d','2024-11-29 14:54:50','2024-11-29 10:01:22'),(1040,'admin',0,1,'f835c7b75e8da0e41f75ff0b4f108e5cc835402a','2024-11-29 15:01:22','2024-11-29 10:01:22'),(1041,'admin',0,1,'f835c7b75e8da0e41f75ff0b4f108e5cc835402a','2024-11-29 15:01:22','2024-11-29 12:06:02'),(1044,'admin',0,1,'292bfe7de1bb6624d76f6b2b6945c7bb80f04d37','2024-11-29 17:06:02','2024-11-29 12:24:52'),(1045,'admin',0,1,'cfb54241bd9f45f5636676b725a13a59888a48c1','2024-11-29 17:24:52','2024-11-29 12:24:52'),(1046,'admin',0,1,'cfb54241bd9f45f5636676b725a13a59888a48c1','2024-11-29 17:24:52','2024-11-29 12:27:01'),(1047,'admin',0,1,'c077f8e0725df44a331e36ab268544f1821d3dc7','2024-11-29 17:27:01','2024-11-29 12:27:01'),(1048,'admin',0,1,'c077f8e0725df44a331e36ab268544f1821d3dc7','2024-11-29 17:27:01','2024-11-29 12:27:03'),(1049,'admin',0,1,'dc6821a66d0c3d10106abc675bf4a6bd804df74d','2024-11-29 17:27:03','2024-11-29 12:27:03'),(1050,'admin',0,1,'dc6821a66d0c3d10106abc675bf4a6bd804df74d','2024-11-29 17:27:03','2024-11-29 12:27:08'),(1051,'admin',0,1,'dbce08f7a7701b165d5dbfd30a4ca17d8d96ff16','2024-11-29 17:27:08','2024-11-29 12:27:08'),(1052,'admin',0,1,'dbce08f7a7701b165d5dbfd30a4ca17d8d96ff16','2024-11-29 17:27:08','2024-11-29 12:27:09'),(1053,'admin',0,1,'375e4c253cfc8c0019fb274e76779ff3ede1b5d8','2024-11-29 17:27:09','2024-11-29 12:27:09'),(1054,'admin',0,1,'375e4c253cfc8c0019fb274e76779ff3ede1b5d8','2024-11-29 17:27:09','2024-11-29 12:27:10'),(1055,'admin',0,1,'40cb897db14d2f9cdb828c01c512c0f50ef7f7de','2024-11-29 17:27:10','2024-11-29 12:27:10'),(1056,'admin',0,1,'40cb897db14d2f9cdb828c01c512c0f50ef7f7de','2024-11-29 17:27:10','2024-11-29 12:27:19'),(1057,'admin',0,1,'d23541675eb02e063a3afa974b86b8f2aac8cf85','2024-11-29 17:27:19','2024-11-29 12:27:19'),(1058,'admin',0,1,'d23541675eb02e063a3afa974b86b8f2aac8cf85','2024-11-29 17:27:19','2024-11-29 12:27:21'),(1059,'admin',0,1,'4cd0e2788dc329010a80cdf7bf75253926fe60d7','2024-11-29 17:27:21','2024-11-29 12:27:21'),(1060,'admin',0,1,'4cd0e2788dc329010a80cdf7bf75253926fe60d7','2024-11-29 17:27:21','2024-11-29 12:28:41'),(1061,'admin',0,1,'3b17c392af6ce39e7aab60ff8685f50dc87adc6a','2024-11-29 17:28:41','2024-11-29 12:28:41'),(1062,'admin',0,1,'3b17c392af6ce39e7aab60ff8685f50dc87adc6a','2024-11-29 17:28:41','2024-11-29 12:32:26'),(1063,'admin',0,1,'60d8e95f2968598a90de14d662772a6cdac9ed0f','2024-11-29 17:32:26','2024-11-29 12:32:26'),(1064,'admin',0,1,'60d8e95f2968598a90de14d662772a6cdac9ed0f','2024-11-29 17:32:26','2024-11-29 12:33:24'),(1065,'admin',0,1,'b7fdc3ad1f0bd2be0fbd32a7c45759008e729e61','2024-11-29 17:33:24','2024-11-29 12:33:24'),(1066,'admin',0,1,'b7fdc3ad1f0bd2be0fbd32a7c45759008e729e61','2024-11-29 17:33:24','2024-11-29 12:34:39'),(1067,'admin',0,1,'64a8bf3c9871769bfee5026cc2bf11bf6c5e12e3','2024-11-29 17:34:39','2024-11-29 12:34:39'),(1068,'admin',0,1,'64a8bf3c9871769bfee5026cc2bf11bf6c5e12e3','2024-11-29 17:34:39','2024-11-29 12:34:43'),(1069,'admin',0,1,'22c063f79f56f7aee21281a06538f4015486ddaa','2024-11-29 17:34:43','2024-11-29 12:35:12'),(1070,'admin',0,1,'c164e5a48e2743a086b957ff7f5d53b945a424b9','2024-11-29 17:35:12','2024-11-29 12:35:12'),(1071,'admin',0,1,'c164e5a48e2743a086b957ff7f5d53b945a424b9','2024-11-29 17:35:12','2024-11-29 12:35:28'),(1072,'admin',0,1,'b7c2474635dc0533a14a529a7a0a0cb9a1adac4f','2024-11-29 17:35:28','2024-11-29 12:35:28'),(1073,'admin',0,1,'b7c2474635dc0533a14a529a7a0a0cb9a1adac4f','2024-11-29 17:35:28','2024-11-29 12:35:30'),(1074,'admin',0,1,'cbea7ff0d9b99e630eb9775b73127e15976d801b','2024-11-29 17:35:30','2024-11-29 12:35:30'),(1075,'admin',0,1,'cbea7ff0d9b99e630eb9775b73127e15976d801b','2024-11-29 17:35:30','2024-11-29 12:35:31'),(1076,'admin',0,1,'ae4fe8484e5129c0145eb2f5cce56e4ebe31cfd2','2024-11-29 17:35:31','2024-11-29 12:35:31'),(1077,'admin',0,1,'ae4fe8484e5129c0145eb2f5cce56e4ebe31cfd2','2024-11-29 17:35:31','2024-11-29 12:35:33'),(1078,'admin',0,1,'291a59e2b91b23952e7e0fac66391bead751ac84','2024-11-29 17:35:33','2024-11-29 12:35:33'),(1079,'admin',0,1,'291a59e2b91b23952e7e0fac66391bead751ac84','2024-11-29 17:35:33','2024-11-29 12:35:36'),(1080,'admin',0,1,'96f3474e5ad8cf61a1a4fa782584dd41c9978120','2024-11-29 17:35:36','2024-11-29 12:35:36'),(1081,'admin',0,1,'96f3474e5ad8cf61a1a4fa782584dd41c9978120','2024-11-29 17:35:36','2024-11-29 12:36:37'),(1082,'admin',0,1,'bc59add06473dec2e01af986087f303062206293','2024-11-29 17:36:37','2024-11-29 12:36:37'),(1083,'admin',0,1,'bc59add06473dec2e01af986087f303062206293','2024-11-29 17:36:37','2024-11-29 12:36:47'),(1084,'admin',0,1,'700d04dda3a45c0b699503681cdf44f9c2f1d6eb','2024-11-29 17:36:47','2024-11-29 12:36:47'),(1085,'admin',0,1,'700d04dda3a45c0b699503681cdf44f9c2f1d6eb','2024-11-29 17:36:47','2024-11-29 12:37:06'),(1086,'admin',0,1,'7dfeead869aa3027a93f0bb9361dfb70bce2b817','2024-11-29 17:37:06','2024-11-29 12:37:06'),(1087,'admin',0,1,'7dfeead869aa3027a93f0bb9361dfb70bce2b817','2024-11-29 17:37:06','2024-11-29 13:42:01'),(1088,'admin',0,1,'bccbe45d20e142d9369f60f6f5964e8d8d4daf94','2024-11-29 18:42:01','2024-11-29 13:42:30'),(1089,'admin',0,1,'ab875bd5a262255b2e0ab904855945f8749e705d','2024-11-29 18:42:30','2024-11-29 13:42:30'),(1090,'admin',0,1,'ab875bd5a262255b2e0ab904855945f8749e705d','2024-11-29 18:42:30','2024-11-29 13:42:31'),(1091,'admin',0,1,'2830f0dc9b011a6aa0390855997e04a458d002cc','2024-11-29 18:42:31','2024-11-29 13:42:31'),(1092,'admin',0,1,'2830f0dc9b011a6aa0390855997e04a458d002cc','2024-11-29 18:42:31','2024-11-29 13:42:33'),(1093,'admin',0,1,'a93fdd8706321b05d1765c41c2bca648ec85e327','2024-11-29 18:42:33','2024-11-29 13:42:33'),(1094,'admin',0,1,'a93fdd8706321b05d1765c41c2bca648ec85e327','2024-11-29 18:42:33','2024-11-29 13:42:37'),(1095,'admin',0,1,'e81a6aad0f4282297ff1e8a0df19a97cd277a5b1','2024-11-29 18:42:37','2024-11-29 13:42:37'),(1096,'admin',0,1,'e81a6aad0f4282297ff1e8a0df19a97cd277a5b1','2024-11-29 18:42:37','2024-11-29 13:42:38'),(1097,'admin',0,1,'7419abd42cbd059743b1ec3a030f233a43ef9e33','2024-11-29 18:42:38','2024-11-29 13:42:38'),(1098,'admin',0,1,'7419abd42cbd059743b1ec3a030f233a43ef9e33','2024-11-29 18:42:38','2024-11-29 13:42:49'),(1099,'admin',0,1,'3c780c47a3d19c06b1a1c8bc86aeb920fb7781b6','2024-11-29 18:42:49','2024-11-29 13:42:49'),(1100,'admin',0,1,'3c780c47a3d19c06b1a1c8bc86aeb920fb7781b6','2024-11-29 18:42:49','2024-11-29 13:43:00'),(1101,'admin',0,1,'5462e6ebb774ace497e3adea636bfdd376c78ad2','2024-11-29 18:43:00','2024-11-29 13:43:00'),(1102,'admin',0,1,'5462e6ebb774ace497e3adea636bfdd376c78ad2','2024-11-29 18:43:00','2024-11-29 13:44:34'),(1103,'admin',0,1,'12497425a656f9647cf0d6343c50ad0020988fc4','2024-11-29 18:44:34','2024-11-29 13:44:34'),(1104,'admin',0,1,'12497425a656f9647cf0d6343c50ad0020988fc4','2024-11-29 18:44:34','2024-11-29 13:45:08'),(1105,'admin',0,1,'93e055988bfa52a16688532102a34210abe94ab6','2024-11-29 18:45:08','2024-11-29 13:45:08'),(1106,'admin',0,1,'93e055988bfa52a16688532102a34210abe94ab6','2024-11-29 18:45:08','2024-11-29 13:45:13'),(1107,'admin',0,1,'c3b4bc4b20235dbae24301447d239e57685ceb28','2024-11-29 18:45:13','2024-11-29 13:45:13'),(1108,'admin',0,1,'c3b4bc4b20235dbae24301447d239e57685ceb28','2024-11-29 18:45:13','2024-11-29 13:45:44'),(1109,'admin',0,1,'1ddc9b8f38358260783fc7794a8ca6da5601ea81','2024-11-29 18:45:44','2024-11-29 13:45:53'),(1110,'admin',0,1,'cf7601b071c493f0340c0a06c8bbbc19ae1b4433','2024-11-29 18:45:53','2024-11-29 13:46:00'),(1111,'admin',0,1,'5462e6ebb774ace497e3adea636bfdd376c78ad2','2024-11-29 18:46:00','2024-11-29 13:46:02'),(1112,'admin',0,1,'a969c0fd565b773f8819767e72e186b027fc8c58','2024-11-29 18:46:02','2024-11-29 13:46:06'),(1113,'admin',0,1,'8118a86f0ee99682714e439ab5c21f113813f1fb','2024-11-29 18:46:06','2024-11-29 13:47:02'),(1114,'admin',0,1,'a969c0fd565b773f8819767e72e186b027fc8c58','2024-11-29 18:47:02','2024-11-29 13:47:03'),(1115,'admin',0,1,'d43c2723a7c72139fcf1704cb2da41355665d268','2024-11-29 18:47:03','2024-11-29 13:47:12'),(1116,'admin',0,1,'a82973b31b1acc3e8f54ac26931ba84d9fffc568','2024-11-29 18:47:12','2024-11-29 13:47:20'),(1117,'admin',0,1,'50c68c148a0b7601ba48d9d133676d808366f960','2024-11-29 18:47:20','2024-11-29 16:14:17'),(1118,'admin',0,1,'9ed012fdf8bb838718c4e91e1cfe445a74120127','2024-11-29 21:14:17','2024-12-02 08:50:06'),(1119,'admin',0,1,'ef9c7120c1ed3bed05190ca55820dc57b19979ad','2024-12-02 13:50:06','2024-12-02 13:41:25'),(1121,'admin',0,1,'76e3eee8c4dd37b190b57ea6afd97327e4c5b766','2024-12-02 18:35:28','2024-12-02 13:35:48'),(1123,'admin',0,1,'58eee7eb7de13d19b63af2115519e7609deb175c','2024-12-02 18:35:48','2024-12-02 16:36:23'),(1124,'admin',0,1,'53e7ccddeb425505591d893563c16b6c4817f5d1','2024-12-02 21:36:23','2024-12-02 16:37:58'),(1125,'admin',0,1,'6d52ffa8e5744dfc3a6d6cb3af8cf1916f0cb43e','2024-12-02 21:37:58','2024-12-02 16:38:03'),(1126,'admin',0,1,'302b17c017a55a5950dfba023f008ffd025315e0','2024-12-02 21:38:03','2024-12-02 16:40:32'),(1127,'admin',0,1,'6084a12119a749b6f37da9d770bca3b08f240dd1','2024-12-02 21:40:32','2024-12-02 16:40:44'),(1128,'admin',0,1,'d809f4ed68618c2093e2c10b1e3e1315a35b0de9','2024-12-02 21:40:44','2024-12-03 08:17:39'),(1129,'admin',0,1,'c9ae523865b7e53d27a080b2b9b8d650f8b496e7','2024-12-03 13:17:39','2024-12-03 09:36:39'),(1130,'admin',0,1,'4fe50ce305a1fe23b5bcd02899136afcbcd8d04a','2024-12-03 14:36:39','2024-12-03 10:03:04'),(1131,'admin',0,1,'224642b42008e33681cd236a24a2c8e043233653','2024-12-03 15:03:04','2024-12-03 10:20:07'),(1132,'admin',0,1,'3ddb7487438cfd0818d4f680edb5c72d15ada5ef','2024-12-03 15:20:07','2024-12-03 10:22:14'),(1133,'admin',0,1,'044a97585f9d10293031c267373d64fd4e500b42','2024-12-03 15:22:14','2024-12-03 10:23:06'),(1134,'admin',0,1,'07ce6337cc75ca25280dfd15dfc95610113e3cdb','2024-12-03 15:23:06','2024-12-03 10:40:44'),(1135,'admin',0,1,'40c811948c3c18292bbf18a7233a74097653c8fc','2024-12-03 15:40:44','2024-12-03 11:20:43'),(1136,'admin',0,1,'1ab2880368d32896ce9c9fc51ba153d3238c2522','2024-12-03 16:20:43','2024-12-03 11:33:52'),(1137,'admin',0,1,'b094de5c25d71b3b9ce915ebb00b8554f3fc02b8','2024-12-03 16:33:52','2024-12-03 11:34:08'),(1138,'admin',0,1,'1598024b3871255aa4dfe0fc9ad476c2f01399fe','2024-12-03 16:34:08','2024-12-03 16:12:27'),(1139,'admin',0,1,'aa4c3bc3b68c7db4496a41ad2277372ea6fac4da','2024-12-03 21:12:27','2024-12-04 08:47:52'),(1140,'admin',0,1,'75ea906584884b09601286a6406acfe7294bb68f','2024-12-04 13:47:52','2024-12-04 12:05:23'),(1141,'admin',0,1,'36384e0fc4ac6cf2ccb5d84d9f8c0ae5a9c929ba','2024-12-04 17:05:23','2024-12-06 08:07:18'),(1142,'admin',0,1,'e67e0a04e1263ba5e7f78fa2636ad6df07a6e656','2024-12-06 13:07:18','2024-12-09 08:39:47'),(1143,'admin',0,1,'25b79533b53562d20682e53d971ea661fcbf1192','2024-12-09 13:39:47','2024-12-09 14:32:14'),(1144,'admin',0,1,'01ff6a0399da9f6d6645ece426f62204a2428b08','2024-12-09 19:32:14','2024-12-10 08:23:26'),(1145,'admin',0,1,'2ddbea4dca8f684a1f29ef918ab583ef98c4e822','2024-12-10 13:23:26','2024-12-10 09:44:24'),(1146,'admin',0,1,'c506ea104c122a62f19c41657300646ec29db007','2024-12-10 14:44:24','2024-12-10 14:35:23'),(1147,'admin',0,1,'1eeba1cfbeacdb69265fa22e3e6563db0a591284','2024-12-10 19:35:23','2024-12-11 09:19:19'),(1148,'admin',0,1,'c1e668a1336d6aa9534e27252eb2015e6c563a9f','2024-12-11 14:19:19','2024-12-12 08:22:29'),(1149,'admin',0,1,'efbc8b735fd7913a2820f33111a757c16f9ee0b3','2024-12-12 13:22:29','2024-12-12 08:22:56'),(1150,'admin',0,1,'a22ce009a048d041a6f8a5ddb1ffd7f7e7a725f0','2024-12-12 13:22:56','2024-12-12 11:33:10'),(1151,'admin',0,1,'8df49c2d02dfdb62385558241ee8efa434a90d19','2024-12-12 16:33:10','2024-12-12 11:38:57'),(1152,'admin',0,1,'5deb6bb2ac404e09ecb83c5bed0236f4719b7636','2024-12-12 16:38:57','2024-12-13 08:45:41'),(1153,'admin',0,1,'d072c0051294dce5b7067dd764c5a968ccf8b11c','2024-12-13 13:45:41','2024-12-13 10:53:57'),(1154,'admin',0,1,'fe6e8269e0d076db96b14b78ca51535f8fb784ba','2024-12-13 15:53:57','2024-12-13 10:55:58'),(1155,'admin',0,1,'ad01beff6f9335e24a876ef136982c65aaf01425','2024-12-13 15:55:58','2024-12-13 10:56:17'),(1156,'admin',0,1,'55c1aac8b1a9fa6d25898775c46c0c0d81064645','2024-12-13 15:56:17','2024-12-13 10:56:46'),(1157,'admin',0,1,'ca948f215913b2866e8bc23bc3ba7151733d9405','2024-12-13 15:56:46','2024-12-13 10:56:52'),(1158,'admin',0,1,'6bc62d5c0e4dd201e816dc4aac0bc2f9d693cf63','2024-12-13 15:56:52','2024-12-16 08:42:48'),(1159,'admin',0,1,'ba09a792b9fc3b0f9bd038daf8408b2bbcbe28f5','2024-12-16 13:42:48','2024-12-17 09:34:18'),(1160,'admin',0,1,'f9956e56e38b71fbfc32bb1d07531348455c82cf','2024-12-17 14:34:18','2024-12-17 10:42:53'),(1161,'admin',0,1,'9a9d55e3b7b41aad87748e99e504e67587105a3b','2024-12-17 15:42:53','2024-12-17 10:43:58'),(1162,'admin',0,1,'fc59ac95b449d0351f0cebb62ce7f15a6d1a1667','2024-12-17 15:43:58','2024-12-17 11:56:34'),(1163,'admin',0,1,'e2fff8b98746b19ec92109adf9235a5152783e91','2024-12-17 16:56:34','2024-12-17 11:59:55'),(1164,'leobredor',0,6,'9296cace8150b1438753dacdccfd750ae3eee3fb','2024-12-17 16:56:48','2024-12-17 11:57:09'),(1165,'leobredor',0,6,'d237901dc889c24fec9ca064abef7af42ba80a3c','2024-12-17 16:57:09','2024-12-17 12:00:23'),(1166,'admin',0,1,'56d80ef2c69a5cbbd7cc2428e356863dd447a0d8','2024-12-17 16:59:55','2024-12-17 12:04:30'),(1167,'leobredor',1,6,'b7b24b8643cabade0765c36446cbf507857a3e7e','2024-12-17 17:00:23',NULL),(1168,'admin',0,1,'3cb795b49e1e2275be9b7e41ab0a3ad1e030a86b','2024-12-17 17:04:30','2024-12-18 05:38:41'),(1169,'admin',0,1,'5e3d7c9cf10bcd8ee8d4efb233d6ddbde8102013','2024-12-18 10:38:41','2024-12-26 08:58:19'),(1170,'admin',0,1,'d3b99c9696d0293c5217b0c0a3d8836138832b06','2024-12-26 13:58:19','2024-12-26 14:55:58'),(1171,'admin',0,1,'0b4fcbf156851ebee327498af13096a4757e85b7','2024-12-26 19:55:58','2024-12-26 16:02:40'),(1172,'admin',0,1,'b409d660d3155de8fb7971c9ef5d341d560e635d','2024-12-26 21:02:40','2024-12-26 16:02:42'),(1173,'admin',0,1,'46fd5f5dc0ce227a0413c76b827a6ea0492ac209','2024-12-26 21:02:42','2024-12-26 16:11:04'),(1174,'admin',0,1,'7c601d1a7761243eb41403c9695e8a5543b8ebbd','2024-12-26 21:11:04','2024-12-26 16:11:25'),(1175,'admin',0,1,'17ce3c0eddd482eac1e30383bb785dd6f8225e40','2024-12-26 21:11:25','2024-12-26 16:15:11'),(1176,'admin',0,1,'ded2a9969cad5f94b049f1ac096acb4af02fcb7a','2024-12-26 21:15:11','2024-12-26 16:31:44'),(1177,'admin',0,1,'030b19c7ddf3b8e30349c3946dbd8c7deada6f4e','2024-12-26 21:31:44','2024-12-26 16:32:09'),(1178,'admin',0,1,'c9f2fd9ea560f4ad396f7f8031c61514feeda2a1','2024-12-26 21:32:09','2024-12-27 09:11:45'),(1179,'admin',0,1,'068a50e4630736ea24f117da191239e0fd829723','2024-12-27 14:11:45','2024-12-27 14:30:24'),(1180,'admin',0,1,'26c036496383b55130215e02a90b58cfdeb5d129','2024-12-27 19:30:24','2024-12-27 20:46:59'),(1181,'admin',0,1,'7f0f2e0e4918419ae76614af56190eb0076b85c7','2024-12-28 01:46:59','2024-12-28 04:46:33'),(1182,'admin',0,1,'4f45b93a6db3ad29aed2b61d18ba1bd03d1092d1','2024-12-28 09:46:33','2024-12-28 12:39:21'),(1183,'admin',0,1,'db05cfa6211060197fbab092d116e40ed8f70c3d','2024-12-28 17:39:21','2024-12-30 09:31:12'),(1184,'admin',0,1,'f798ed5f7b5bef56e34b55c9db6018fa5d26777b','2024-12-30 14:31:12','2024-12-30 09:35:15'),(1185,'admin',0,1,'78cdcd35b286406eddd56eb08af787403ae6ab8d','2024-12-30 14:35:15','2024-12-30 11:07:28'),(1186,'admin',0,1,'be11e3d738da47ba981bdb1392830a580cae2f89','2024-12-30 16:07:28','2024-12-30 17:36:13'),(1187,'admin',0,1,'c1bc60b89e36f2b103533f4c78158e9c82520004','2024-12-30 22:36:13','2024-12-30 17:36:28'),(1188,'admin',0,1,'3f762c423cea9e0facb85c14b8373ab82395a524','2024-12-30 22:36:28','2024-12-31 07:43:30'),(1189,'admin',0,1,'74254b18fb13c5030f26e904a8c924d5db19a7fb','2024-12-31 12:43:30','2025-01-02 08:17:55'),(1190,'admin',0,1,'d535f0951c94de32db850cb167b8210c5601b591','2025-01-02 13:17:55','2025-01-02 10:26:01'),(1191,'admin',1,1,'59ed3b272fd9948462023907eaa800da8b07c403','2025-01-02 15:26:01',NULL);
/*!40000 ALTER TABLE `adm_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_users`
--

DROP TABLE IF EXISTS `adm_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adm_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_crt` int DEFAULT NULL,
  `date_crt` datetime DEFAULT NULL,
  `activo` tinyint DEFAULT '1',
  `perfil` int NOT NULL,
  `login` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `mail` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cambiar_pass` tinyint DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_users`
--

LOCK TABLES `adm_users` WRITE;
/*!40000 ALTER TABLE `adm_users` DISABLE KEYS */;
INSERT INTO `adm_users` VALUES (1,'Administrador general',1,'2024-11-26 00:00:00',1,1,'admin','de317c6ef49ca6da808d948edb64a987cd75f237','jdominguez@grupocinte.com',0),(3,'José de Jesús Domínguez Padilla',0,'2024-12-02 00:00:00',1,1,'juniorjmd','de317c6ef49ca6da808d948edb64a987cd75f237','juniorjmd@gmail.com',1),(6,'luz elena obredor',1,'2024-12-02 00:00:00',1,2,'leobredor','bfcde64c919563d43252d64d4594b5e1c9a35697','leobredor@grupocinte.com',0),(8,'usuario 1',1,'2024-12-12 00:00:00',1,2,'usuario1','$2y$10$4v6w7AZ5FTCKA45SVmFRA..HQJhreREEJEYbP4kMsuEoOf/Np1Xze','usuario@email.com',1);
/*!40000 ALTER TABLE `adm_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `adm_users_BEFORE_INSERT` BEFORE INSERT ON `adm_users` FOR EACH ROW BEGIN
set new.date_crt = curdate();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `adm_users_menu`
--

DROP TABLE IF EXISTS `adm_users_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adm_users_menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `menu` int NOT NULL,
  `crt_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_menu` (`user`,`menu`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_users_menu`
--

LOCK TABLES `adm_users_menu` WRITE;
/*!40000 ALTER TABLE `adm_users_menu` DISABLE KEYS */;
INSERT INTO `adm_users_menu` VALUES (12,3,21,'2024-12-16 17:12:02'),(15,3,25,'2024-12-16 17:21:15'),(17,3,24,'2024-12-16 17:21:41'),(32,6,26,'2024-12-17 12:00:09'),(35,1,24,'2024-12-17 12:04:49'),(36,1,25,'2024-12-17 12:04:50'),(37,1,26,'2024-12-17 12:04:52'),(38,1,21,'2024-12-17 12:06:04'),(39,1,23,'2024-12-17 12:06:09'),(40,1,22,'2024-12-17 12:06:10'),(41,1,27,'2025-01-02 10:50:00');
/*!40000 ALTER TABLE `adm_users_menu` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`intra_aaa_v3`@`localhost`*/ /*!50003 TRIGGER `adm_users_menu_BEFORE_INSERT` BEFORE INSERT ON `adm_users_menu` FOR EACH ROW BEGIN
 set new.crt_date = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'intra_aaa_v3'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-20  6:47:13
