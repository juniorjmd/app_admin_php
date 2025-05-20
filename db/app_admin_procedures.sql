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
-- Dumping routines for database 'intra_aaa_v3'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_permisos_by_user_id` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`intra_aaa_v3`@`localhost` PROCEDURE `sp_get_permisos_by_user_id`( in  _usr_id int)
BEGIN
      DECLARE _id_perfil int ; 
      DECLARE _error TEXT;
	  DECLARE _msg TEXT;
	  DECLARE _code INT;
      select perfil  into _id_perfil from   adm_users where id = _usr_id ; 
      if _id_perfil > 0 then 
           SELECT recurso as id ,
                         nombre,
                        descripcion,
                         direccion,
                       icono,
                        tipo,
                        padre 
            FROM vw_perfil_recurso
            where  perfil = _id_perfil ; 
       else
		   SET _error = 'error';
			SET _msg = 'usuario no posee perfil valido o con permisos asignados';
			SET _code = 1;
			SELECT 
				JSON_OBJECT(
					'error', _error,
					'msg', _msg,
					'code', _code
				) AS procedure_response;
      end if; 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_get_user_by_key_session` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`intra_aaa_v3`@`localhost` PROCEDURE `sp_get_user_by_key_session`(IN _key_session TEXT)
BEGIN
    DECLARE _error TEXT;
    DECLARE _msg TEXT;
    DECLARE _code INT;
    DECLARE _user_id INT;
    DECLARE _user_name TEXT;
    DECLARE _perfil INT;
    DECLARE _active_session BOOLEAN;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Error handling
        GET DIAGNOSTICS CONDITION 1
            _msg = MESSAGE_TEXT,
            _code = MYSQL_ERRNO;
        
        SET _error = 'error';
        
        SELECT 
            JSON_OBJECT(
                'error', _error,
                'msg', _msg,
                'code', _code
            ) AS procedure_response;
        ROLLBACK;
    END;

    -- Start transaction
    START TRANSACTION;

    -- Check if the session key exists and is active
    SELECT 
        COUNT(*), 
        adm_users.id, 
        adm_users.name, 
        adm_users.perfil, 
        adm_session.activo 
    INTO 
        _active_session, 
        _user_id, 
        _user_name, 
        _perfil, 
        _active_session 
    FROM 
        adm_session
    INNER JOIN 
        adm_users ON adm_users.id = adm_session.usuario
    WHERE 
        adm_session.key = _key_session;

    IF _active_session = 0 THEN
        SET _error = 'error';
        SET _msg = 'Session key does not exist or is not active';
        SET _code = 1;
        
        SELECT 
            JSON_OBJECT(
                'error', _error,
                'msg', _msg,
                'code', _code
            ) AS procedure_response;
        ROLLBACK;
    ELSE
       /* WITH permisos AS (
            SELECT perfil,
                   JSON_ARRAYAGG(JSON_OBJECT(
                       'id', recurso,
                       'nombre', nombre,
                       'descripcion', descripcion,
                       'direccion', direccion,
                       'icono', icono,
                       'tipo', tipo,
                       'padre', padre )) AS recursos_json
            FROM vw_perfil_recurso
            GROUP BY perfil 
        )*/
        SELECT 
            JSON_OBJECT(
                'error', 'ok',
                'msg', 'ok',
                'code', 0,
                'user', JSON_OBJECT(
                    'id', _user_id,
                    'name', _user_name,
                    'perfil' , adm_users.perfil,
                    'mail' , mail,
                    'cambiar_pass' , cambiar_pass,
                    'permisos', null
                )
            ) AS procedure_response
        FROM 
            adm_users 
       -- LEFT JOIN  permisos ON permisos.perfil = _perfil 
        where adm_users.id = _user_id;
        COMMIT;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_login` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`intra_aaa_v3`@`localhost` PROCEDURE `sp_login`(IN `_usuarios` VARCHAR(45), IN `_pass` TEXT, IN `_key` TEXT)
    SQL SECURITY INVOKER
BEGIN
    declare _count , _count_perfil int;
    declare _id_usuarios , _id_perfil int;
    set _count = 0;
    set _count_perfil = 0; 
    select count(*) , id , perfil  into _count , _id_usuarios , _id_perfil from adm_users
    where adm_users.activo  = true and Login = _usuarios and pass = _pass group by id;
    if _count > 0 then
        SET SQL_SAFE_UPDATES = 0;
			update adm_session set activo = false ,
			fecha_hora_fin = now()
			where usuario = _id_usuarios and
			activo = true ;
        SET SQL_SAFE_UPDATES = 1;
        -- validamos que tenga activo el PERFIL	
        select count(*)   into _count_perfil   from adm_perfil
        where activo = true and id = _id_perfil  ;
        
        if _count_perfil > 0 then
			INSERT INTO  `adm_session` ( `nombre`, `usuario`,`key`,`fecha_hora_ini` )
			VALUES ( _usuarios,_id_usuarios, _key , now() );
			 SELECT JSON_OBJECT(
					'error', 'ok',
					'msg', 'ok'
				) AS procedure_response;
		else
			SELECT JSON_OBJECT(
					'error', 'error',
					'msg', 'perfil inactivo'
				) AS procedure_response;
		end if;
	else
        SELECT JSON_OBJECT(
				'error', 'error',
				'msg', 'usuario o contraseña invalidos'
			) AS procedure_response;
    end if;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-20  6:50:54
