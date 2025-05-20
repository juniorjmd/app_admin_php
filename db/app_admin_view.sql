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
-- Temporary view structure for view `vw_adm_recurso`
--

DROP TABLE IF EXISTS `vw_adm_recurso`;
/*!50001 DROP VIEW IF EXISTS `vw_adm_recurso`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_adm_recurso` AS SELECT 
 1 AS `id`,
 1 AS `nombre`,
 1 AS `descripcion`,
 1 AS `activo`,
 1 AS `direccion`,
 1 AS `crt_date`,
 1 AS `icono`,
 1 AS `tipo`,
 1 AS `padre`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_adm_session`
--

DROP TABLE IF EXISTS `vw_adm_session`;
/*!50001 DROP VIEW IF EXISTS `vw_adm_session`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_adm_session` AS SELECT 
 1 AS `id`,
 1 AS `nombre`,
 1 AS `usuario`,
 1 AS `key`,
 1 AS `fecha_hora_ini`,
 1 AS `fecha_hora_fin`,
 1 AS `estado`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_adm_users`
--

DROP TABLE IF EXISTS `vw_adm_users`;
/*!50001 DROP VIEW IF EXISTS `vw_adm_users`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_adm_users` AS SELECT 
 1 AS `cambiar_pass`,
 1 AS `id`,
 1 AS `name`,
 1 AS `user_crt`,
 1 AS `date_crt`,
 1 AS `activo`,
 1 AS `perfil`,
 1 AS `login`,
 1 AS `pass`,
 1 AS `mail`,
 1 AS `nombrePerfil`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_adm_users_menu`
--

DROP TABLE IF EXISTS `vw_adm_users_menu`;
/*!50001 DROP VIEW IF EXISTS `vw_adm_users_menu`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_adm_users_menu` AS SELECT 
 1 AS `id`,
 1 AS `menu`,
 1 AS `user`,
 1 AS `name`,
 1 AS `description`,
 1 AS `display_name`,
 1 AS `id_wp`,
 1 AS `ruta_fisica`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_perfil_recurso`
--

DROP TABLE IF EXISTS `vw_perfil_recurso`;
/*!50001 DROP VIEW IF EXISTS `vw_perfil_recurso`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_perfil_recurso` AS SELECT 
 1 AS `perfil`,
 1 AS `recurso`,
 1 AS `nombre`,
 1 AS `descripcion`,
 1 AS `activo`,
 1 AS `direccion`,
 1 AS `crt_date`,
 1 AS `icono`,
 1 AS `tipo`,
 1 AS `padre`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'intra_aaa_v3'
--

--
-- Final view structure for view `vw_adm_recurso`
--

/*!50001 DROP VIEW IF EXISTS `vw_adm_recurso`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`intra_aaa_v3`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_adm_recurso` AS select `adm_recurso`.`id` AS `id`,`adm_recurso`.`nombre` AS `nombre`,`adm_recurso`.`descripcion` AS `descripcion`,`adm_recurso`.`activo` AS `activo`,`adm_recurso`.`direccion` AS `direccion`,`adm_recurso`.`crt_date` AS `crt_date`,`adm_recurso`.`icono` AS `icono`,`adm_recurso`.`tipo` AS `tipo`,`adm_recurso`.`padre` AS `padre` from `adm_recurso` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_adm_session`
--

/*!50001 DROP VIEW IF EXISTS `vw_adm_session`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`intra_aaa_v3`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_adm_session` AS select `adm_session`.`id` AS `id`,`adm_session`.`nombre` AS `nombre`,`adm_session`.`usuario` AS `usuario`,`adm_session`.`key` AS `key`,`adm_session`.`fecha_hora_ini` AS `fecha_hora_ini`,`adm_session`.`fecha_hora_fin` AS `fecha_hora_fin`,(case `adm_session`.`activo` when true then 'Activo' else 'Inactivo' end) AS `estado` from `adm_session` order by `adm_session`.`fecha_hora_ini` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_adm_users`
--

/*!50001 DROP VIEW IF EXISTS `vw_adm_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`intra_aaa_v3`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_adm_users` AS select `adm_users`.`cambiar_pass` AS `cambiar_pass`,`adm_users`.`id` AS `id`,`adm_users`.`name` AS `name`,`adm_users`.`user_crt` AS `user_crt`,`adm_users`.`date_crt` AS `date_crt`,`adm_users`.`activo` AS `activo`,`adm_users`.`perfil` AS `perfil`,`adm_users`.`login` AS `login`,`adm_users`.`pass` AS `pass`,`adm_users`.`mail` AS `mail`,coalesce(`adm_perfil`.`nombre`,'No Asignado') AS `nombrePerfil` from (`adm_users` left join `adm_perfil` on((`adm_perfil`.`id` = `adm_users`.`perfil`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_adm_users_menu`
--

/*!50001 DROP VIEW IF EXISTS `vw_adm_users_menu`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`intra_aaa_v3`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_adm_users_menu` AS select `adm_users_menu`.`id` AS `id`,`adm_users_menu`.`menu` AS `menu`,`adm_users_menu`.`user` AS `user`,`adm_menus`.`name` AS `name`,`adm_menus`.`description` AS `description`,`adm_menus`.`display_name` AS `display_name`,`adm_menus`.`id_wp` AS `id_wp`,`adm_menus`.`ruta_fisica` AS `ruta_fisica` from (`adm_users_menu` join `adm_menus` on((`adm_menus`.`id` = `adm_users_menu`.`menu`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_perfil_recurso`
--

/*!50001 DROP VIEW IF EXISTS `vw_perfil_recurso`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`intra_aaa_v3`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_perfil_recurso` AS select `adm_perfil_recurso`.`perfil` AS `perfil`,`adm_recurso`.`id` AS `recurso`,`adm_recurso`.`nombre` AS `nombre`,`adm_recurso`.`descripcion` AS `descripcion`,`adm_recurso`.`activo` AS `activo`,`adm_recurso`.`direccion` AS `direccion`,`adm_recurso`.`crt_date` AS `crt_date`,`adm_recurso`.`icono` AS `icono`,`adm_recurso`.`tipo` AS `tipo`,`adm_recurso`.`padre` AS `padre` from ((`adm_perfil_recurso` join `adm_perfil` on(((`adm_perfil`.`id` = `adm_perfil_recurso`.`perfil`) and (`adm_perfil`.`activo` = true)))) join `adm_recurso` on(((`adm_recurso`.`id` = `adm_perfil_recurso`.`recurso`) and (`adm_recurso`.`activo` = true)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-20  6:49:46
