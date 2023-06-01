-- phpMyAdmin SQL Dump
-- version OVH
-- https://www.phpmyadmin.net/
--
-- Hôte : swingstadmin.mysql.db
-- Généré le : mer. 29 mars 2023 à 19:11
-- Version du serveur : 5.7.41-log
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `swingstadmin`
--
CREATE DATABASE IF NOT EXISTS `swingstadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `swingstadmin`;

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`swingstadmin`@`%` PROCEDURE `get_content_page` (IN `P_page` VARCHAR(50) CHARSET utf8, IN `P_lang` VARCHAR(5) CHARSET utf8, IN `P_auth` VARCHAR(50) CHARSET utf8)  READS SQL DATA
    COMMENT 'get content page'
BEGIN 
	
    SELECT 
    	CP.id AS elem_id,
    	CP.elem AS elem, 
        CP.html_id_elem AS html_id, 
        CP.html_class_elem AS html_class, 
        CP.html_attr_elem AS html_attr, 
    	(
    		CASE 
    	    	WHEN lower(P_lang) = 'fr' THEN T.fr
    	    	WHEN lower(P_lang) = 'nl' THEN T.nl
    	    	WHEN lower(P_lang) = 'en' THEN T.en
    	    	WHEN lower(P_lang) = 'de' THEN T.de
    	    END
    	) AS txt, 
    	U.url AS url,
        CP.param AS param,
    	CP.order, 
        CP.description AS description,
    	U.target
    
    FROM swing_content_page AS CP
    	LEFT JOIN swing_trad AS T ON CP.trad_id = T.id
    	LEFT JOIN swing_url AS U ON CP.url_id = U.id
    
    WHERE CP.page = lower(P_page) 
    	AND (
			CASE 
				WHEN lower(P_auth) = 'grant' 		THEN CP.auth_id IN(1, 2, 3, 4, 5, 6)
				WHEN lower(P_auth) = 'admin' 		THEN CP.auth_id IN(1, 2, 3, 4, 5)
				WHEN lower(P_auth) = 'group' 		THEN CP.auth_id IN(2, 3, 4, 5)
				WHEN lower(P_auth) = 'user'  		THEN CP.auth_id IN(2, 3, 4)
				WHEN lower(P_auth) = 'newsletter'  THEN CP.auth_id IN(2, 3)
				ELSE CP.auth_id IN(2)
			END
		)
    	AND (
    		CASE
				WHEN U.auth_id IS NOT NULL THEN (
    	        	CASE 
						WHEN lower(P_auth) = 'grant' 		THEN U.auth_id IN(1, 2, 3, 4, 5, 6)
						WHEN lower(P_auth) = 'admin' 		THEN U.auth_id IN(1, 2, 3, 4, 5)
						WHEN lower(P_auth) = 'group' 		THEN U.auth_id IN(2, 3, 4, 5)
						WHEN lower(P_auth) = 'user'  		THEN U.auth_id IN(2, 3, 4)
						WHEN lower(P_auth) = 'newsletter'  THEN U.auth_id IN(2, 3)
						ELSE U.auth_id IN(2)
					END
				)
    	    	ELSE U.auth_id IS NULL
    	    END
    	)
		AND CP.active = 1 
	
    ORDER BY CP.order ASC;

END$$

CREATE DEFINER=`swingstadmin`@`%` PROCEDURE `get_diary` (IN `P_lang` VARCHAR(255) CHARSET utf8, IN `P_id` INT(20) UNSIGNED)  READS SQL DATA
    COMMENT 'get diary infos'
BEGIN

	IF P_id != 0 THEN
    
    	SELECT D.id, D.date, D.hour,
    		(
    			CASE 
        			WHEN lower(P_lang) = 'fr' THEN T.fr
        			WHEN lower(P_lang) = 'nl' THEN T.nl
        			WHEN lower(P_lang) = 'en' THEN T.en
        			WHEN lower(P_lang) = 'de' THEN T.de
        		END
    		) AS event_name,    
			GR.group AS groupe,
			D.address_id, U1.url AS reservation, D.event_planner_id,
			U.url AS poster,
			E.email AS email,
			TEL.tel AS tel,
			GSM.gsm AS gsm,
			D.price,
			U0.url AS map,
			D.gallery_id, D.sold_out, D.canceled, D.closed, D.description, D.created_at, D.updated_at
		FROM swing_diary AS D
			LEFT JOIN swing_trad AS T ON D.event_name_id = T.id
			LEFT JOIN swing_url AS U ON D.poster_id = U.id
			LEFT JOIN swing_url AS U0 ON D.url_map_id = U0.id
			LEFT JOIN swing_url AS U1 ON D.reservation_url_id = U1.id
			LEFT JOIN swing_group AS GR ON D.group_id = GR.id
			LEFT JOIN swing_email AS E ON D.email_id = E.id
			LEFT JOIN swing_tel AS TEL ON D.tel_id = TEL.id
			LEFT JOIN swing_gsm AS GSM ON D.gsm_id = GSM.id
		WHERE D.id = P_id AND D.active = 1;
    
    ELSE
    
    	SELECT D.id, D.date, D.hour,
    		(
    			CASE 
        			WHEN lower(P_lang) = 'fr' THEN T.fr
        			WHEN lower(P_lang) = 'nl' THEN T.nl
        			WHEN lower(P_lang) = 'en' THEN T.en
        			WHEN lower(P_lang) = 'de' THEN T.de
        		END
    		) AS event_name,    
			GR.group AS groupe,
			D.address_id, D.reservation_url_id, D.event_planner_id,
			U.url AS poster,
			E.email AS email,
			TEL.tel AS tel,
			GSM.gsm AS gsm,
			D.price,
			U0.url AS map,
			D.gallery_id, D.sold_out, D.canceled, D.closed, D.description, D.created_at, D.updated_at
		FROM swing_diary AS D
			LEFT JOIN swing_trad AS T ON D.event_name_id = T.id
			LEFT JOIN swing_url AS U ON D.poster_id = U.id
			LEFT JOIN swing_url AS U0 ON D.url_map_id = U0.id
			LEFT JOIN swing_group AS GR ON D.group_id = GR.id
			LEFT JOIN swing_email AS E ON D.email_id = E.id
			LEFT JOIN swing_tel AS TEL ON D.tel_id = TEL.id
			LEFT JOIN swing_gsm AS GSM ON D.gsm_id = GSM.id
        WHERE D.active = 1
		ORDER BY D.date DESC;
    
    END IF;

END$$

CREATE DEFINER=`swingstadmin`@`%` PROCEDURE `get_gallery` (IN `P_lang` VARCHAR(255) CHARSET utf8, IN `P_id` INT(20) UNSIGNED)  READS SQL DATA
    COMMENT 'get gallery infos'
BEGIN

	IF P_id != 0 THEN
    		
    	SELECT G.id AS gallery_id,
			(
    			CASE 
        			WHEN lower(P_lang) = 'fr' THEN T.fr
        			WHEN lower(P_lang) = 'nl' THEN T.nl
        			WHEN lower(P_lang) = 'en' THEN T.en
        			WHEN lower(P_lang) = 'de' THEN T.de
        		END
    		) AS title,
			U.url AS picture,
			G.date,
			U0.url AS dir,
			G.address_id, G.description
		FROM swing_gallery AS G
			LEFT JOIN swing_trad AS T ON G.name_id = T.id
			LEFT JOIN swing_url AS U ON G.picture_id = U.id
			LEFT JOIN swing_url AS U0 ON G.url_id = U0.id
			LEFT JOIN swing_address AS A ON G.address_id = A.id
		WHERE G.id = P_id;
    
    ELSE
    
    	SELECT G.id AS gallery_id,
			(
    			CASE 
        			WHEN lower(P_lang) = 'fr' THEN T.fr
        			WHEN lower(P_lang) = 'nl' THEN T.nl
        			WHEN lower(P_lang) = 'en' THEN T.en
        			WHEN lower(P_lang) = 'de' THEN T.de
        		END
    		) AS title,
			U.url AS picture,
			G.date,
			U0.url AS dir,
			G.address_id, G.description
		FROM swing_gallery AS G
			LEFT JOIN swing_trad AS T ON G.name_id = T.id
			LEFT JOIN swing_url AS U ON G.picture_id = U.id
			LEFT JOIN swing_url AS U0 ON G.url_id = U0.id
			LEFT JOIN swing_address AS A ON G.address_id = A.id
		ORDER BY G.date DESC;
    
    END IF;

END$$

CREATE DEFINER=`swingstadmin`@`%` PROCEDURE `get_gallery_img` (IN `P_gallery_id` INT(10) UNSIGNED, IN `P_active` INT(1) UNSIGNED)  READS SQL DATA
    COMMENT 'get img in gallery id'
BEGIN

	SELECT * 
    FROM swing_gallery_img 
    WHERE gallery_id = P_gallery_id 
    	AND active = P_active;

END$$

CREATE DEFINER=`swingstadmin`@`%` PROCEDURE `get_menu` (IN `p_like` VARCHAR(10), IN `p_auth` VARCHAR(50))  READS SQL DATA
    COMMENT 'get menu'
BEGIN

		SELECT M.id, M.name, T.en AS trad, U.url AS url, M.class, M.order, M.auth_id
			FROM swing_menu AS M 
			LEFT JOIN swing_trad AS T ON M.trad_id = T.id 
			LEFT JOIN swing_url AS U ON M.url_id = U.id 
		WHERE M.name LIKE p_like
			AND(
			CASE 
			WHEN p_auth = 'grant' 		THEN M.auth_id IN(1, 2, 3, 4, 5, 6)
			WHEN p_auth = 'admin' 		THEN M.auth_id IN(1, 2, 3, 4, 5)
			WHEN p_auth = 'group' 		THEN M.auth_id IN(2, 3, 4, 5)
			WHEN p_auth = 'user'  		THEN M.auth_id IN(2, 3, 4)
			WHEN p_auth = 'newsletter'  THEN M.auth_id IN(2, 3)
			ELSE M.auth_id IN(2)
			END
			) 
			AND M.active = 1 
		ORDER BY M.order ASC;
	
	END$$

CREATE DEFINER=`swingstadmin`@`%` PROCEDURE `get_musicians` (IN `P_lang` VARCHAR(5) CHARSET utf8)  READS SQL DATA
    COMMENT 'get musicians infos'
BEGIN

	SELECT 
		M.id, 
    	N.name AS firstname, N0.name AS lastname, 
    	U.url AS image, 
    	I.name AS instru_abvr, 
        (
    		CASE 
    	    	WHEN lower(P_lang) = 'fr' THEN T.fr
    	    	WHEN lower(P_lang) = 'nl' THEN T.nl
    	    	WHEN lower(P_lang) = 'en' THEN T.en
    	    	WHEN lower(P_lang) = 'de' THEN T.de
    	    END
    	) AS instrument, 
        (
    		CASE 
    	    	WHEN lower(P_lang) = 'fr' THEN T0.fr
    	    	WHEN lower(P_lang) = 'nl' THEN T0.nl
    	    	WHEN lower(P_lang) = 'en' THEN T0.en
    	    	WHEN lower(P_lang) = 'de' THEN T0.de
    	    END
    	) AS fonction,
    	F.name AS funct_name,
        M.order,
    	M.description
	FROM swing_members AS M
		LEFT JOIN swing_name AS N ON M.firstname_id = N.id
		LEFT JOIN swing_name AS N0 ON M.lastname_id = N0.id
		LEFT JOIN swing_instruments AS I ON M.instru_id = I.id
		LEFT JOIN swing_trad AS T ON I.instru_id = T.id
		LEFT JOIN swing_functions_group AS F ON M.function_id = F.id
		LEFT JOIN swing_trad AS T0 ON F.fonction_id = T0.id
		LEFT JOIN swing_url AS U ON M.img_id = U.id
	ORDER BY M.order ASC;

END$$

CREATE DEFINER=`swingstadmin`@`%` PROCEDURE `get_select_data` (IN `P_type` VARCHAR(50) CHARSET utf8, OUT `O_msg` VARCHAR(50) CHARSET utf8)  READS SQL DATA
    COMMENT 'get select input option data'
BEGIN 
	
    SET O_msg = 'SUCCESS !';

    IF P_type = 'account' THEN

        SELECT id, type FROM swing_account_type;

    ELSEIF P_type = 'address' THEN

        SELECT A.id, A.number, A.bte,
            T.type, T.abvr,
            S.street,
            O.town, O.postal_code,
            L.land
        FROM swing_address AS A
        LEFT JOIN swing_street_type AS T ON A.type_id = T.id
        LEFT JOIN swing_street AS S ON A.street_id = S.id
        LEFT JOIN swing_town AS O ON A.town_id = O.id
        LEFT JOIN swing_land AS L ON O.land_id = L.id;

    ELSEIF P_type = 'arranger' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'authorization' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'author' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'currency' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'function_group' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'group' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'gsm' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'instrument' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'instrument_type' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'land' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'lang' THEN

        SELECT id, abvr, lang FROM swing_lang WHERE active = 1;

    ELSEIF P_type = 'member' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'menu' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'music_sheet_id' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'music_sheet_num' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'music_sheet_title' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'name' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'page' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'status' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'street' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'street_type' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'style' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'tel' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'tone' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'town' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'trad' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'url' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSEIF P_type = 'user' THEN
        SET O_msg = 'WARNING WORK IN PROGRESS !';
    ELSE

        SET O_msg = 'ERROR TYPE INVALID !';

    END IF;

END$$

CREATE DEFINER=`swingstadmin`@`%` PROCEDURE `get_users` (IN `P_id` INT(20) UNSIGNED)  READS SQL DATA
    COMMENT 'get users infos'
BEGIN

	IF P_id != 0 THEN
	
    	SELECT 
            U.id AS user_id, 
            P.pseudo AS user_pseudo, E.email AS user_email, 
            N0.name AS firstname, N1.name AS lastname,
        	U.password AS user_password, 
            URL.url AS picture, B.date AS birthday, 
            ST.type AS user_street_type, STR.street AS user_street, A.number AS numero, A.bte AS user_bte, T.town AS user_town, T.postal_code AS cp, 
            LAND.land AS user_land, FLAG.url AS user_flags,
            G.group AS user_group, 
            -- U.account_type_id, 
            LANG.lang AS user_lang, 
            -- U.status_id AS user_status, 
            AUTH.auth AS user_auth, 
            IP.ip AS user_ip, IP.banned AS user_banned, IP.first_fail_date AS first_fail, IP.count_fail AS user_count_fail, 
            IP.count_fail_date AS user_count_fail_date,
            S1.status AS ip_status, IP.created_at AS ip_create, IP.updated_at AS ip_update,
            TEL.tel AS user_tel, GSM.gsm AS user_gsm, 
            U.conditions AS conditions,
            U.token AS token, U.active AS active, 
            U.description AS descr, 
            U.last_connexion AS last_connexion, U.created_at AS user_create, U.updated_at AS user_update
    	
        FROM swing_users AS U
        LEFT JOIN swing_pseudo AS P ON U.pseudo_id = P.id
        LEFT JOIN swing_email AS E ON U.email_id = E.id
        LEFT JOIN swing_name AS N0 ON U.firstname_id = N0.id
        LEFT JOIN swing_name AS N1 ON U.lastname_id = N1.id
        LEFT JOIN swing_url AS URL ON U.picture_id = URL.id
        LEFT JOIN swing_birthday AS B ON U.birthday_id = B.id
        LEFT JOIN swing_address AS A ON U.address_id = A.id
        LEFT JOIN swing_street_type AS ST ON A.type_id = ST.id
        LEFT JOIN swing_street AS STR ON A.street_id = STR.id
        LEFT JOIN swing_town AS T ON A.town_id = T.id
        LEFT JOIN swing_land AS LAND ON T.land_id = LAND.id
        LEFT JOIN swing_url AS FLAG ON LAND.flag_id = FLAG.id
        LEFT JOIN swing_group AS G ON U.group_id = G.id
        -- LEFT JOIN swing_account_type AS AT ON U.account_type_id = AT.id
        LEFT JOIN swing_lang AS LANG ON U.lang_id = LANG.id
        -- LEFT JOIN swing_status AS S ON U.status_id = S.id
        LEFT JOIN swing_authorization AS AUTH ON U.auth_id = AUTH.id
        LEFT JOIN swing_ip AS IP ON U.ip_id = IP.id
        LEFT JOIN swing_status AS S1 ON IP.status_id = S1.id
        LEFT JOIN swing_tel AS TEL ON U.tel_id = TEL.id
        LEFT JOIN swing_gsm AS GSM ON U.gsm_id = GSM.id

        -- LEFT JOIN swing_ AS  ON U._id = .id
        
        WHERE U.id = P_id;
    
    ELSE
    
    	SELECT 
            U.id AS user_id, 
            P.pseudo AS user_pseudo, E.email AS user_email, 
            CONCAT(N0.name, ' ', N1.name) AS user_name, 
            AUTH.auth AS user_auth,
            IP.ip AS user_ip, IP.banned AS user_banned,
            S1.status AS ip_status, U.active AS active,
            U.last_connexion AS last_connexion, U.created_at AS user_create, U.updated_at AS user_update
        
        FROM swing_users AS U
        LEFT JOIN swing_pseudo AS P ON U.pseudo_id = P.id
        LEFT JOIN swing_email AS E ON U.email_id = E.id
        LEFT JOIN swing_name AS N0 ON U.firstname_id = N0.id
        LEFT JOIN swing_name AS N1 ON U.lastname_id = N1.id
        LEFT JOIN swing_authorization AS AUTH ON U.auth_id = AUTH.id
        LEFT JOIN swing_ip AS IP ON U.ip_id = IP.id
        LEFT JOIN swing_status AS S1 ON IP.status_id = S1.id;

    END IF;
    
END$$

CREATE DEFINER=`swingstadmin`@`%` PROCEDURE `test` (IN `nbr` INT(10))  READS SQL DATA
    COMMENT 'test'
BEGIN
	SELECT * FROM swing_users
    WHERE id = nbr;
END$$

CREATE DEFINER=`swingstadmin`@`%` PROCEDURE `user_register` (IN `P_regexp_email` VARCHAR(255) CHARSET utf8, IN `P_firstname` VARCHAR(255) CHARSET utf8, IN `P_lastname` VARCHAR(255) CHARSET utf8, IN `P_ip` VARCHAR(50) CHARSET utf8, IN `P_email` VARCHAR(255) CHARSET utf8, IN `P_password` VARCHAR(255) CHARSET utf8, IN `P_pseudo` VARCHAR(255) CHARSET utf8, OUT `O_user_id` INT(20) UNSIGNED, OUT `O_message` VARCHAR(255) CHARSET utf8)  MODIFIES SQL DATA
    COMMENT 'db user register'
BEGIN
	# VARIABLES LOCALES
	DECLARE V_firstname_id 	INT(20);	# firstname id 	in swing_name
	DECLARE V_lastname_id 	INT(20); 	# lastname id 	in swing_name
	DECLARE V_ip_id 		INT(20); 	# ip address id in swing_ip
	DECLARE V_pseudo_id 	INT(20); 	# pseudo id 	in swing_pseudo
	DECLARE V_email_id 		INT(20); 	# email id 		in swing_email
	DECLARE S_firstname 	VARCHAR(255);	# select firstname id 	in swing_name
	DECLARE S_lastname 		VARCHAR(255);	# select lastname id 	in swing_name
	DECLARE S_ip 			VARCHAR(255);	# select ip id 			in swing_ip
	DECLARE S_pseudo 		VARCHAR(255);	# select pseudo id 		in swing_pseudo
	DECLARE S_email 		VARCHAR(255);	# select email id 		in swing_email
	# FIRSTNAME
    IF (SELECT id FROM swing_name WHERE lower(name) = lower(P_firstname)) IS NOT NULL
    	THEN SET V_firstname_id = (SELECT id FROM swing_name WHERE lower(name) = lower(P_firstname));
	ELSE
		INSERT INTO swing_name (name) VALUES (P_firstname);
        SET V_firstname_id = LAST_INSERT_ID();
	END IF;
	# LASTNAME
	IF (SELECT id FROM swing_name WHERE lower(name) = lower(P_lastname)) IS NOT NULL
		THEN SET V_lastname_id = (SELECT id FROM swing_name WHERE lower(name) = lower(P_lastname));
	ELSE
		INSERT INTO swing_name (name) VALUES (P_lastname);
		SET V_lastname_id = LAST_INSERT_ID();
	END IF;
	# IP
	IF (SELECT id FROM swing_ip WHERE ip = P_ip) IS NOT NULL
		THEN SET V_ip_id = (SELECT id FROM swing_ip WHERE ip = P_ip);
	ELSE
		INSERT INTO swing_ip (ip) VALUES (P_ip);
		SET V_ip_id = LAST_INSERT_ID();
	END IF;
	# TRANSACTION
	SET O_message = "ERROR";
	START TRANSACTION;
		# PSEUDO
		IF P_pseudo IS NULL OR (SELECT id FROM swing_pseudo WHERE pseudo = P_pseudo) IS NOT NULL
			THEN SET V_pseudo_id = NULL;
		ELSE
			INSERT INTO swing_pseudo (pseudo) VALUES (P_pseudo);
			SET V_pseudo_id = LAST_INSERT_ID();
		END IF;
		# EMAIL & USER
		IF P_email IS NOT NULL 
		  AND (SELECT id FROM swing_email WHERE lower(email) = P_email) IS NULL 
		  AND P_email REGEXP P_regexp_email
			THEN
        	# EMAIL
			INSERT INTO swing_email (email) VALUES (P_email);
			SET V_email_id = LAST_INSERT_ID();
			# USER
			INSERT INTO swing_users (pseudo_id, email_id, firstname_id, lastname_id, ip_id, password) 
				VALUES (V_pseudo_id, V_email_id, V_firstname_id, V_lastname_id, V_ip_id, P_password);
			SET O_user_id = LAST_INSERT_ID();
			# verif for message
			IF O_user_id IS NOT NULL THEN
				SET O_message = "SUCCESS";
			END IF;
		END IF;
	COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `swing_account_type`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_account_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_account_type`
--

INSERT INTO `swing_account_type` (`id`, `type`, `description`) VALUES
(1, 'public', 'visible par tous'),
(2, 'private', 'visible uniquement par user courrent et les admin');

-- --------------------------------------------------------

--
-- Structure de la table `swing_address`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_address` (
  `id` int(20) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED DEFAULT NULL,
  `street_id` int(20) UNSIGNED DEFAULT NULL,
  `number` int(10) UNSIGNED DEFAULT NULL,
  `bte` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `town_id` int(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_address`
--

INSERT INTO `swing_address` (`id`, `type_id`, `street_id`, `number`, `bte`, `town_id`) VALUES
(1, NULL, 2, 39, NULL, 1),
(2, 1, 1, 7, NULL, 2),
(3, 7, 3, NULL, NULL, 3),
(4, NULL, 4, NULL, NULL, 4),
(5, NULL, 5, 11, NULL, 4);

-- --------------------------------------------------------

--
-- Structure de la table `swing_arranger`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_arranger` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname_id` int(20) UNSIGNED DEFAULT NULL,
  `lastname_id` int(20) UNSIGNED DEFAULT NULL,
  `sex` char(1) COLLATE utf8_bin DEFAULT 'm',
  `date_id` int(20) UNSIGNED DEFAULT NULL,
  `picture_id` int(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `swing_authorization`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_authorization` (
  `id` int(10) UNSIGNED NOT NULL,
  `auth` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_authorization`
--

INSERT INTO `swing_authorization` (`id`, `auth`, `description`) VALUES
(1, 'admin', 'presque tous les droits'),
(2, 'site', 'fonctionnement du site'),
(3, 'newsletter', 'abonne aux newsletters'),
(4, 'user', 'simple utilisateur non membre du groupe'),
(5, 'group', 'simple utilisateur membre du groupe'),
(6, 'grant', 'absolument tous les droits');

-- --------------------------------------------------------

--
-- Structure de la table `swing_authors`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_authors` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname_id` int(10) UNSIGNED DEFAULT NULL,
  `lastname_id` int(10) UNSIGNED DEFAULT NULL,
  `sexe` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'm',
  `data_id` int(20) UNSIGNED DEFAULT NULL,
  `picture_id` int(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `swing_birthday`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_birthday` (
  `id` int(20) UNSIGNED NOT NULL,
  `date` date NOT NULL COMMENT 'yyyy-mm-dd'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `swing_content_page`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_content_page` (
  `id` int(20) UNSIGNED NOT NULL,
  `page` varchar(255) COLLATE utf8_bin NOT NULL,
  `elem` varchar(255) COLLATE utf8_bin NOT NULL,
  `html_id_elem` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `html_class_elem` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `html_attr_elem` text COLLATE utf8_bin,
  `trad_id` int(20) UNSIGNED DEFAULT NULL,
  `url_id` int(20) UNSIGNED DEFAULT NULL,
  `auth_id` int(10) UNSIGNED NOT NULL DEFAULT '2',
  `param` text COLLATE utf8_bin,
  `order` int(10) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_content_page`
--

INSERT INTO `swing_content_page` (`id`, `page`, `elem`, `html_id_elem`, `html_class_elem`, `html_attr_elem`, `trad_id`, `url_id`, `auth_id`, `param`, `order`, `active`, `description`) VALUES
(1, 'home', 'h1', NULL, NULL, '{\"style\": \"text-align: center;\"}', 61, NULL, 2, NULL, 1, 1, 'titre de la page'),
(2, 'home', 'img', 'home_img_group', NULL, '{\"alt\": \"home_img_group\"}', NULL, 16, 2, NULL, 2, 1, 'image du groupe'),
(3, 'home', 'h2', NULL, NULL, NULL, 54, NULL, 2, NULL, 3, 1, 'titre article presentation et bienvenue'),
(4, 'home', 'p', NULL, NULL, NULL, 55, NULL, 2, NULL, 4, 1, 'text 1 paragraph 1'),
(5, 'home', 'p', NULL, NULL, NULL, 56, NULL, 2, NULL, 5, 1, 'text 1 paragraph 2'),
(6, 'home', 'p', NULL, NULL, NULL, 57, NULL, 2, NULL, 6, 1, 'text 1 paragraph 3'),
(7, 'home', 'p', NULL, NULL, NULL, 58, NULL, 2, NULL, 7, 1, 'text 1 paragraph 4'),
(8, 'home', 'p', NULL, NULL, NULL, 59, NULL, 2, NULL, 8, 1, 'text 1 paragraph 5'),
(9, 'home', 'php_site_more', NULL, NULL, NULL, 60, 17, 2, NULL, 9, 1, 'plus d\'infos group'),
(10, 'group', 'h1', NULL, NULL, NULL, 6, NULL, 2, NULL, 1, 1, 'titre de la page'),
(11, 'group', 'section', 'presentation', NULL, NULL, NULL, NULL, 2, NULL, 2, 1, '%{ swing_content_page : id[12, 13, 14, 15, 16, 17, 18, 19, 20] }%'),
(12, 'group', 'h2', NULL, NULL, NULL, 12, NULL, 2, NULL, 3, 1, 'titre presentation'),
(13, 'group', 'p', NULL, NULL, NULL, 13, NULL, 2, NULL, 4, 1, 'text 1 paragraph 1'),
(14, 'group', 'p', NULL, NULL, NULL, 14, NULL, 2, NULL, 5, 1, 'text 1 paragraph 2'),
(15, 'group', 'p', NULL, NULL, NULL, 15, NULL, 2, NULL, 6, 1, 'text 1 paragraph 3'),
(16, 'group', 'p', NULL, NULL, NULL, 16, NULL, 2, NULL, 7, 1, 'text 1 paragraph 4'),
(17, 'group', 'p', NULL, NULL, NULL, 17, NULL, 2, NULL, 8, 1, 'text 1 paragraph 5'),
(18, 'group', 'p', NULL, NULL, NULL, 18, NULL, 2, NULL, 9, 0, 'text 1 paragraph 6'),
(19, 'group', 'p', NULL, NULL, NULL, 19, NULL, 2, NULL, 10, 1, 'text 1 paragraph 7'),
(20, 'group', 'p', NULL, NULL, NULL, 20, NULL, 2, NULL, 11, 1, 'text 1 paragraph 8'),
(21, 'group', 'section', 'musicos', NULL, NULL, NULL, NULL, 2, NULL, 12, 1, '%{ swing_content_page : id[22, 23] }%'),
(22, 'group', 'h2', NULL, NULL, NULL, 170, NULL, 2, NULL, 13, 1, 'titre musiciens'),
(23, 'group', 'php_site_musician_fiche', NULL, NULL, NULL, NULL, NULL, 2, '{\"0\": [\"first_conductor\"], \"1\": [\"SA1\", \"SA2\", \"ST1\", \"ST2\", \"SB\"], \"2\": [\"TP1\", \"TP2\", \"TP3\", \"TP4\"], \"3\": [\"TB1\", \"TB2\", \"TB3\", \"TB4\"], \"4\": [\"P\", \"G\", \"CB\", \"PRQ\", \"D\"], \"5\": [\"CHF\", \"CHM\"]}', 14, 1, 'liste des fiches des musiciens'),
(24, 'diary', 'php_site_build_diary', NULL, NULL, NULL, NULL, NULL, 2, NULL, 1, 1, 'build diary function'),
(25, 'technical', 'h2', NULL, NULL, NULL, 10, NULL, 2, NULL, 1, 1, 'titre de la page'),
(26, 'technical', 'div', 'technical_doc', NULL, '{\"style\": \"text-align: center;\"}', NULL, NULL, 2, NULL, 2, 1, '%{ swing_content_page : id[27] }%'),
(27, 'technical', 'iframe', NULL, NULL, '{\"src\": \"./resources/technique.pdf\", \"style\": \"color: white;\", \"width\": \"50%\", \"height\": \"500px\", \"frameborder\": \"0\"}', NULL, NULL, 2, NULL, 3, 1, 'lecteur PDF infos technique du groupe'),
(28, 'group', 'script', NULL, NULL, NULL, NULL, 51, 2, NULL, 15, 1, 'JS');

-- --------------------------------------------------------

--
-- Structure de la table `swing_continents`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_continents` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `abvr` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_continents`
--

INSERT INTO `swing_continents` (`id`, `name`, `abvr`, `description`) VALUES
(1, 'European Union', 'EU', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `swing_currency`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_currency` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency` varchar(255) COLLATE utf8_bin NOT NULL,
  `abvr` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `symbol` varchar(5) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_currency`
--

INSERT INTO `swing_currency` (`id`, `currency`, `abvr`, `symbol`, `description`) VALUES
(1, 'Euro', 'EUR', '€', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `swing_diary`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_diary` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `hour` time DEFAULT NULL,
  `event_name_id` int(10) UNSIGNED DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT '1',
  `address_id` int(20) UNSIGNED DEFAULT NULL,
  `reservation_url_id` int(10) UNSIGNED DEFAULT NULL,
  `event_planner_id` int(10) UNSIGNED DEFAULT NULL,
  `poster_id` int(10) UNSIGNED DEFAULT NULL,
  `email_id` int(20) UNSIGNED DEFAULT NULL,
  `tel_id` int(20) UNSIGNED DEFAULT NULL,
  `gsm_id` int(20) UNSIGNED DEFAULT NULL,
  `price` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `url_map_id` int(10) UNSIGNED DEFAULT NULL,
  `gallery_id` int(10) UNSIGNED DEFAULT NULL,
  `sold_out` tinyint(1) NOT NULL DEFAULT '0',
  `canceled` tinyint(1) NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_diary`
--

INSERT INTO `swing_diary` (`id`, `date`, `hour`, `event_name_id`, `group_id`, `address_id`, `reservation_url_id`, `event_planner_id`, `poster_id`, `email_id`, `tel_id`, `gsm_id`, `price`, `url_map_id`, `gallery_id`, `sold_out`, `canceled`, `closed`, `active`, `description`, `created_at`, `updated_at`) VALUES
(1, '2014-05-17', '20:30:00', 137, 1, 1, 52, 1, 26, NULL, NULL, 3, '%{ entry = 12€ }%, %{ presale = 10€ }%', 27, NULL, 1, 1, 1, 0, 'description/concert_20_ans', '2020-08-29 00:01:10', '2022-02-07 15:49:19'),
(2, '2014-06-15', '14:00:00', 151, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, NULL, '2020-08-29 23:13:30', '2020-08-30 00:17:17'),
(30, '2014-09-06', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Privé concert in Asse', '2021-05-04 14:48:54', '2021-05-04 14:58:09'),
(31, '2014-09-21', '16:30:00', 186, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Druivenfeest - GC Felix Sohie', '2021-05-04 14:48:54', '2021-05-04 15:12:38'),
(32, '2014-12-07', '16:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Herfst concert met Harmonie van Stokkel', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(33, '2014-12-09', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Privé concert in St-Pieters-Woluwe', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(34, '2015-06-14', '14:00:00', 151, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Maatjesfeest - Fête des maatjes', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(35, '2015-07-21', '14:30:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Gentse Feesten - Wedstrijd Podium van Muziekmozaïek Bigband', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(36, '2016-05-29', '15:00:00', 188, 1, 1, NULL, 1, 53, NULL, NULL, 3, '%{ entry = 8€ }%', 27, NULL, 0, 0, 1, 0, 'description/GC_Felix_Sohie_2016', '2021-05-04 14:48:54', '2021-05-04 16:07:12'),
(37, '2016-06-19', '14:00:00', 151, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Maatjesfeest - Fête des maatjes', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(38, '2016-09-18', '15:00:00', 186, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Druivenfeest - GC Felix Sohie', '2021-05-04 14:48:54', '2021-05-04 15:13:48'),
(39, '2016-10-15', '20:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Dubbel concert met ADM big band Tubize - Zie poster. (Zaal Eekhoorn)', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(40, '2016-11-27', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Concert 10 jaar Rotary (Theaterzaal De Warandapoort Tervuren)', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(41, '2017-05-05', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Repetitie week-end aan zee + Optreden (du 05/05/2017 au 07/05/2017)', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(42, '2017-05-27', '20:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Concert met ADM big band Tubize (Muziekschool François Daneels - Tubize)', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(43, '2017-06-04', '11:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Aperitief concert Café SPORTECHO', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(44, '2017-06-18', '14:00:00', 151, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Maatjesfeest - Fête des maatjes', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(45, '2017-07-16', '15:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Tervuren - Marktplein', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(46, '2017-09-16', '13:30:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Oostende Bigband Festival', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(47, '2017-12-16', '20:00:00', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '%{ entry = 14€ }%, %{ presale = 12€ }%', 27, NULL, 0, 0, 1, 0, 'Kerstconcert GC Felix Sohie Hoeilaart', '2021-05-04 14:48:54', '2021-05-04 17:02:52'),
(48, '2018-05-20', '14:30:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Jaarlijks concert. Serre GC Felix Sohie Hoeilaart (Gemeenteplein, 39 - 1560 Hoeilaart)', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(49, '2018-06-17', '14:00:00', 151, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Maatjesfeest (St-Katelijneplein - 1000 Brussel) Fête des maatjes (Place Ste-Catherine - 1000 Bruxelles)', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(50, '2018-09-16', '14:30:00', 186, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Druivenfestival (Podium GC Felix Sohie Hoeilaart (Gemeenteplein, 39 - 1560 Hoeilaart)', '2021-05-04 14:48:54', '2021-05-04 15:14:26'),
(51, '2019-04-07', '11:30:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Eetdag / Dîner du Big band. Cafetaria CC Felix Sohie (Gemeenteplein, 39 - 1560 Hoeilaart).  Bar geopend vanaf 11u30 - Eten vanaf 12u', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(52, '2019-06-08', '16:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Concert voor Café Sportecho (Gemeenteplein, 38 - 1560 Hoeilaart)', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(53, '2019-06-16', '14:00:00', 151, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Maatjesfeest (St-Katelijneplein - 1000 Brussel) - Fête des maatjes (Place Ste-Catherine - 1000 Bruxelles)', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(54, '2019-10-10', '14:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Concert CC Den Blank (Begijnhof, 11 - 3090 Overijse)', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(55, '2019-12-14', '20:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 'Kerstconcert in CC Felix SOhie te Hoeilaart (Gemeenteplein, 39 - 1560 Hoeilaart).', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(56, '2020-06-21', '14:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 'Maatjesfeest (St-Katelijneplein - 1000 Brussel) - Fête des maatjes (Place Ste-Catherine - 1000 Bruxelles) ', '2021-05-04 14:48:54', '2021-05-04 15:06:35'),
(57, '2022-06-19', '14:00:00', 151, 1, 3, NULL, 67, NULL, NULL, NULL, NULL, NULL, 66, NULL, 0, 0, 1, 1, 'Maatjesfeest (St-Katelijneplein - 1000 Brussel) - Fête des maatjes (Place Ste-Catherine - 1000 Bruxelles) ', '2021-05-04 14:48:54', '2022-06-21 14:41:25'),
(58, '2022-08-24', '20:00:00', 186, 1, 5, NULL, 70, NULL, NULL, NULL, NULL, NULL, 69, NULL, 0, 0, 1, 1, 'fête du raisin - Druivenfeesten', '2022-06-24 02:04:05', '2022-08-25 21:27:01'),
(59, '2023-05-21', '14:30:00', 216, 1, 1, 71, NULL, NULL, NULL, NULL, NULL, '%{ entry = 12€ }%, %{ presale = 10€ }%', 72, NULL, 0, 0, 0, 1, 'description/concert_21-mai-2023', '2023-01-13 13:09:01', '2023-01-13 14:26:07');

-- --------------------------------------------------------

--
-- Structure de la table `swing_district`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_district` (
  `id` int(20) UNSIGNED NOT NULL,
  `district` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `abvr` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_district`
--

INSERT INTO `swing_district` (`id`, `district`, `abvr`, `description`) VALUES
(1, 'Vlaamsbrabant', NULL, NULL),
(2, 'Brabant Wallon', 'BW', NULL),
(3, 'Région Bruxelles capitale', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `swing_email`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_email` (
  `id` int(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_email`
--

INSERT INTO `swing_email` (`id`, `email`) VALUES
(3, 'admin@swingshift.be'),
(4, 'john.doe@mail.com'),
(2, 'marc.collart@gmail.com'),
(1, 'trallocnivek@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `swing_functions_group`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_functions_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `fonction_id` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_functions_group`
--

INSERT INTO `swing_functions_group` (`id`, `name`, `fonction_id`, `description`) VALUES
(1, 'first_conductor', 130, 'Wanted'),
(2, 'second_conductor', 130, 'Jean-Marie Ganhy'),
(3, 'tresory', 132, 'Stéphane Dehandtschutter'),
(4, 'webmaster', 133, 'Kevin Collart'),
(5, 'president ad interim', 134, 'Edward Dombrecht'),
(6, 'secretaire ad interim', 136, 'Michel Boucquey'),
(7, 'administration', 0, 'Augustijn ?');

-- --------------------------------------------------------

--
-- Structure de la table `swing_gallery`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_gallery` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_id` int(10) UNSIGNED NOT NULL,
  `picture_id` int(10) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `address_id` int(10) UNSIGNED DEFAULT NULL,
  `url_id` int(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_gallery`
--

INSERT INTO `swing_gallery` (`id`, `name_id`, `picture_id`, `date`, `address_id`, `url_id`, `description`) VALUES
(1, 0, 0, '2013-01-01', NULL, 31, '%{ date = Y (only) }%'),
(2, 137, 26, '2014-05-17', 1, 32, 'anniversaire des 20 ans du Swing Shift Big Band'),
(3, 0, 0, '2013-12-08', NULL, NULL, 'Sint-Pieters-Woluwe, Fabry Zaal - 08/12/2013'),
(4, 0, 0, '2013-06-01', NULL, NULL, 'Maatjes feest Juni 2013, St-Kathelijneplein, Brussel'),
(5, 0, 0, '2014-09-21', NULL, NULL, 'Hoeilaart Druivenfeest - 21/09/2014'),
(6, 0, 0, '2014-06-15', NULL, NULL, 'Brussel, St-Kathelijneplein - Maatjesfeest - 15/06/2014'),
(7, 0, 0, '2015-03-01', NULL, NULL, 'De Swing Shift Big Band is in maart 2015 op week-end naar zee geweest.De bedoeling van deze uitstap was, in eerst instantie te repeteren, maar ook te genieten en gezellige momenten samen door te brengen. Doel 100% behaald …'),
(8, 0, 0, '2015-06-14', NULL, NULL, 'Brussel, St-Kathelijneplein - Maatjesfeest - 14/06/2015'),
(9, 0, 0, '2015-07-21', NULL, NULL, 'Gent Laurentplein - Gentsefeesten : Podium van Muziekmozaïek  - 21/07/2015'),
(10, 0, 0, '2016-09-18', NULL, NULL, 'Druivenfeest Hoeilaart Sept 2016'),
(11, 171, 50, '2016-10-15', NULL, NULL, 'Zaal Eekhoorn in Hoeilaart - Met ADM Big Band (Tubize)  - 15/10/2016'),
(12, 0, 0, '2017-05-06', NULL, NULL, 'Repetitie WE & concert in Oostduinkerke  - 06 & 07/05/2017 Avec l\'aimable participation d\'un photographe amateur de Kraainem.'),
(13, 0, 0, '2019-12-14', NULL, NULL, 'Kerstconcert Felix Sohie zall - Hoeilaart Déc 2019');

-- --------------------------------------------------------

--
-- Structure de la table `swing_gallery_img`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_gallery_img` (
  `id` int(20) UNSIGNED NOT NULL,
  `web_img_id` int(20) UNSIGNED NOT NULL,
  `full_url_id` int(20) UNSIGNED NOT NULL,
  `gallery_id` int(10) UNSIGNED NOT NULL,
  `order_list` int(10) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_gallery_img`
--

INSERT INTO `swing_gallery_img` (`id`, `web_img_id`, `full_url_id`, `gallery_id`, `order_list`, `active`, `description`) VALUES
(1, 65, 0, 2, 1, 1, '20 ans'),
(2, 0, 45, 2, 3, 1, 'img 2'),
(3, 42, 56, 2, 2, 1, 'img3');

-- --------------------------------------------------------

--
-- Structure de la table `swing_group`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `group` varchar(255) COLLATE utf8_bin NOT NULL,
  `society_id` int(10) UNSIGNED DEFAULT NULL,
  `style_id` int(10) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_group`
--

INSERT INTO `swing_group` (`id`, `group`, `society_id`, `style_id`, `description`) VALUES
(1, 'Swing Shift Big Band', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `swing_gsm`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_gsm` (
  `id` int(20) UNSIGNED NOT NULL,
  `gsm` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_gsm`
--

INSERT INTO `swing_gsm` (`id`, `gsm`) VALUES
(1, '0470/040.747'),
(2, '0475/69.32.56'),
(3, '0477/72.84.93');

-- --------------------------------------------------------

--
-- Structure de la table `swing_head_of_desk`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_head_of_desk` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `member_id` int(10) UNSIGNED DEFAULT NULL,
  `descr_id` int(10) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_head_of_desk`
--

INSERT INTO `swing_head_of_desk` (`id`, `name`, `member_id`, `descr_id`, `description`) VALUES
(1, 'bibliothecaire', NULL, NULL, NULL),
(2, 'drum/percu', 19, NULL, 'Kevin Collart'),
(3, 'sax', 6, NULL, 'Alex'),
(4, 'trombone', 14, NULL, 'Marc Collart'),
(5, 'trompette', NULL, NULL, NULL),
(6, 'rythmique (G/P/CB)', 15, NULL, 'Louis');

-- --------------------------------------------------------

--
-- Structure de la table `swing_instruments`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_instruments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `instru_id` int(20) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED DEFAULT NULL,
  `ton_id` int(10) UNSIGNED DEFAULT NULL,
  `num` int(10) UNSIGNED DEFAULT NULL,
  `img_id` int(20) UNSIGNED DEFAULT NULL,
  `land_id` int(10) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_instruments`
--

INSERT INTO `swing_instruments` (`id`, `name`, `instru_id`, `type_id`, `ton_id`, `num`, `img_id`, `land_id`, `description`) VALUES
(1, 'SA1', 28, 5, NULL, 1, NULL, NULL, NULL),
(2, 'SA2', 30, 5, NULL, 2, NULL, NULL, NULL),
(3, 'ST1', 29, 5, NULL, 3, NULL, NULL, NULL),
(4, 'ST2', 31, 5, NULL, 4, NULL, NULL, NULL),
(5, 'SB', 32, 5, NULL, 5, NULL, NULL, NULL),
(6, 'C', 33, 4, NULL, NULL, NULL, NULL, NULL),
(7, 'TP1', 34, 5, NULL, 1, NULL, NULL, NULL),
(8, 'TP2', 35, 5, NULL, 2, NULL, NULL, NULL),
(9, 'TP3', 36, 5, NULL, 3, NULL, NULL, NULL),
(10, 'TP4', 37, 5, NULL, 4, NULL, NULL, NULL),
(11, 'TB1', 38, 5, NULL, 1, NULL, NULL, NULL),
(12, 'TB2', 39, 5, NULL, 2, NULL, NULL, NULL),
(13, 'TB3', 40, 5, NULL, 3, NULL, NULL, NULL),
(14, 'TB4', 41, 5, NULL, 4, NULL, NULL, NULL),
(15, 'P', 42, 3, NULL, NULL, NULL, NULL, NULL),
(16, 'G', 43, 2, NULL, NULL, NULL, NULL, NULL),
(17, 'CB', 44, 1, NULL, NULL, NULL, NULL, NULL),
(18, 'PRQ', 45, 7, NULL, NULL, NULL, NULL, NULL),
(19, 'D', 46, 7, NULL, NULL, NULL, NULL, NULL),
(20, 'GB', 47, 2, NULL, NULL, NULL, NULL, NULL),
(21, 'CHM', 48, 8, NULL, NULL, NULL, NULL, NULL),
(22, 'CHF', 49, 8, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `swing_instrument_type`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_instrument_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `swing_ip`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_ip` (
  `id` int(20) UNSIGNED NOT NULL,
  `ip` varchar(64) COLLATE utf8_bin NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `first_fail_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `count_fail` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `count_fail_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_ip`
--

INSERT INTO `swing_ip` (`id`, `ip`, `banned`, `first_fail_date`, `count_fail`, `count_fail_date`, `status_id`, `created_at`, `updated_at`) VALUES
(1, '::1', 0, '2020-09-10 02:07:52', 0, '2020-09-10 02:07:52', 1, '2020-09-10 02:07:52', '2020-09-10 02:07:52');

-- --------------------------------------------------------

--
-- Structure de la table `swing_land`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_land` (
  `id` int(10) UNSIGNED NOT NULL,
  `land` varchar(255) COLLATE utf8_bin NOT NULL,
  `flag_id` int(10) UNSIGNED DEFAULT NULL,
  `continent_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_land`
--

INSERT INTO `swing_land` (`id`, `land`, `flag_id`, `continent_id`, `currency_id`, `description`) VALUES
(1, 'Belgique/België/Belgium', 1, NULL, NULL, NULL),
(2, 'Nederland', 5, NULL, NULL, NULL),
(3, 'Deutschland', 4, NULL, NULL, NULL),
(4, 'United Kingdom', 6, NULL, NULL, NULL),
(5, 'France', 3, NULL, NULL, NULL),
(6, 'United States of America', 7, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `swing_lang`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_lang` (
  `id` int(10) UNSIGNED NOT NULL,
  `abvr` char(10) COLLATE utf8_bin NOT NULL,
  `lang` varchar(255) COLLATE utf8_bin NOT NULL,
  `flag_id` int(10) UNSIGNED DEFAULT NULL,
  `land_id` int(10) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_lang`
--

INSERT INTO `swing_lang` (`id`, `abvr`, `lang`, `flag_id`, `land_id`, `active`) VALUES
(1, 'be-nl', 'Nederlands - België', 2, 1, 0),
(2, 'be-fr', 'Français - Belge', 8, 1, 0),
(3, 'nl', 'Nederlands', 5, 2, 1),
(4, 'en', 'English - United Kingdom', 6, 3, 1),
(5, 'de', 'Deutsche', 4, 4, 1),
(6, 'fr', 'Français - France', 3, 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `swing_members`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname_id` int(20) UNSIGNED NOT NULL,
  `lastname_id` int(20) UNSIGNED NOT NULL,
  `email_id` int(20) UNSIGNED DEFAULT NULL,
  `tel_id` int(20) UNSIGNED DEFAULT NULL,
  `gsm_id` int(20) UNSIGNED DEFAULT NULL,
  `img_id` int(20) UNSIGNED DEFAULT NULL,
  `instru_id` int(10) UNSIGNED DEFAULT NULL,
  `function_id` int(10) UNSIGNED DEFAULT NULL,
  `sexe` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'm',
  `order` int(10) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `INFOS` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_members`
--

INSERT INTO `swing_members` (`id`, `firstname_id`, `lastname_id`, `email_id`, `tel_id`, `gsm_id`, `img_id`, `instru_id`, `function_id`, `sexe`, `order`, `description`, `INFOS`) VALUES
(1, 22, 6, NULL, NULL, NULL, 45, NULL, 1, 'm', 1, NULL, 'CHEF BAND J-M'),
(2, 30, 29, NULL, NULL, NULL, 41, 3, NULL, 'm', 4, NULL, 'ST1 KLAUS'),
(3, 33, 3, NULL, NULL, NULL, 39, 1, NULL, 'm', 2, NULL, 'SA1 AUGUSTIJN'),
(4, 34, 4, NULL, NULL, NULL, 40, 2, NULL, 'm', 3, NULL, 'SA2 MICHEL V O'),
(5, 24, 4, NULL, NULL, NULL, 42, 4, 6, 'm', 5, NULL, 'ST2 MICHEL B'),
(6, 28, 5, NULL, NULL, NULL, 43, 5, NULL, 'm', 6, 'instru_id [5, 6]', 'SB ALEX'),
(7, 22, 6, NULL, NULL, NULL, 45, 8, 2, 'm', 8, NULL, 'TRP2 J-M + MAIN CHEF'),
(8, 45, 44, NULL, NULL, NULL, NULL, 7, NULL, 'm', 7, NULL, 'TRP1 Thomas Gathy'),
(9, 25, 7, NULL, NULL, NULL, 46, 9, 3, 'm', 9, NULL, 'TRP3 STEF'),
(10, 35, 8, NULL, NULL, NULL, 47, 10, NULL, 'm', 10, NULL, 'TRP4 FRANK'),
(11, 36, 9, NULL, NULL, NULL, 38, 11, NULL, 'm', 11, NULL, 'TRB1 SIMON'),
(12, 37, 10, NULL, NULL, NULL, 35, 12, 5, 'm', 12, NULL, 'TRB2 EDWARD'),
(13, 23, 11, NULL, NULL, NULL, 37, 13, NULL, 'm', 14, NULL, 'TRB3 PHIL'),
(14, 19, 12, 2, 1, 2, 36, 14, NULL, 'm', 15, NULL, 'TRB4/B MARC'),
(15, 20, 13, NULL, NULL, NULL, 24, 15, NULL, 'm', 16, NULL, 'P LOUIS'),
(16, 47, 46, NULL, NULL, NULL, NULL, 17, NULL, 'm', 18, 'instru_id = [17, 20]', 'CB/B Guy Farmer'),
(17, 40, 39, NULL, NULL, NULL, NULL, 16, NULL, 'm', 17, NULL, 'G STEFAAN B'),
(18, 41, 15, NULL, NULL, NULL, 25, 19, NULL, 'm', 20, NULL, 'D JAN'),
(19, 19, 16, 1, 1, 1, 23, 18, 4, 'm', 19, 'instru_id = [18, 19]', 'PRQ KEVIN'),
(20, 0, 0, NULL, NULL, NULL, NULL, 21, NULL, 'm', 22, 'wanted', 'CHM'),
(21, 42, 18, NULL, NULL, NULL, 48, 22, NULL, 'f', 21, NULL, 'CHF ERICA'),
(22, 38, 43, NULL, NULL, NULL, NULL, 12, NULL, 'm', 13, NULL, 'TRB2 MARK W');

-- --------------------------------------------------------

--
-- Structure de la table `swing_menu`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `trad_id` int(10) UNSIGNED NOT NULL,
  `url_id` int(10) UNSIGNED NOT NULL,
  `class` varchar(255) COLLATE utf8_bin DEFAULT 'active',
  `order` int(10) UNSIGNED NOT NULL,
  `auth_id` int(10) UNSIGNED NOT NULL DEFAULT '2',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_menu`
--

INSERT INTO `swing_menu` (`id`, `name`, `trad_id`, `url_id`, `class`, `order`, `auth_id`, `active`, `description`) VALUES
(1, 'main_home', 2, 9, 'active', 1, 2, 1, 'home page all visitors'),
(2, 'main_group', 6, 10, 'active', 2, 2, 1, 'group page all visitors'),
(3, 'main_diary', 7, 11, 'active', 3, 2, 1, 'diary page all visitors'),
(4, 'main_gallery', 8, 12, 'active', 4, 2, 0, 'gallery page all visitors'),
(5, 'main_demo', 9, 13, 'active', 5, 2, 1, 'demo page all visitors'),
(6, 'main_technical', 10, 14, 'active', 6, 2, 0, 'technical page all visitors'),
(7, 'main_contact', 11, 15, 'active', 7, 2, 1, 'contact page all visitors'),
(8, 'topright_profil', 163, 28, 'active', 1, 3, 0, 'profil page newsletter, users, members, admin, grant'),
(9, 'topleft_admin', 164, 29, 'active', 1, 1, 0, 'admin page admin, grant'),
(10, 'main_partitions', 165, 30, 'active', 9, 5, 0, 'partitions page search members, admin, grant'),
(11, 'admin_home', 164, 29, 'active', 1, 1, 0, 'admin home page (control panel)'),
(12, 'grant_users', 191, 54, 'active', 1, 6, 0, 'gestion des utilisateurs'),
(13, 'admin_site', 192, 58, 'active', 2, 1, 0, 'gestion du site (CMS)'),
(14, 'admin_diary', 193, 55, 'active', 3, 1, 0, 'gestion agenda'),
(15, 'admin_gallery', 194, 56, 'active', 4, 1, 0, 'gestion des galerie'),
(16, 'admin_partitions', 195, 57, 'active', 5, 1, 0, 'gestion des partitions CRUD'),
(17, 'topright_disconnect', 166, 59, 'active', 2, 3, 0, 'bouton se deconnecter'),
(18, 'topleft_site', 169, 9, 'active', 2, 1, 0, 'sortir du mode admin sur accueil');

-- --------------------------------------------------------

--
-- Structure de la table `swing_musicsheet`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_musicsheet` (
  `id` int(20) UNSIGNED NOT NULL,
  `title_id` int(20) UNSIGNED NOT NULL,
  `url_id` int(20) UNSIGNED DEFAULT NULL,
  `instru_id` int(10) UNSIGNED DEFAULT NULL,
  `ton_id` int(10) UNSIGNED DEFAULT NULL,
  `num_page` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `nbr_pages` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `swing_musicsheet_num`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_musicsheet_num` (
  `id` int(20) UNSIGNED NOT NULL,
  `title_id` int(20) UNSIGNED NOT NULL,
  `group_id` int(20) UNSIGNED NOT NULL DEFAULT '1',
  `number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `active` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_musicsheet_num`
--

INSERT INTO `swing_musicsheet_num` (`id`, `title_id`, `group_id`, `number`, `active`) VALUES
(1, 1, 1, '0', 0),
(2, 2, 1, '1', 1),
(3, 3, 1, '2', 0),
(4, 4, 1, '3', 0),
(5, 5, 1, '4', 0),
(6, 6, 1, '5', 0),
(7, 7, 1, '6', 0),
(8, 8, 1, '7', 0),
(9, 9, 1, '8', 0),
(10, 10, 1, '9', 0),
(11, 11, 1, '248', 1);

-- --------------------------------------------------------

--
-- Structure de la table `swing_musicsheet_title`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_musicsheet_title` (
  `id` int(20) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `author_id` int(20) DEFAULT NULL,
  `arranger_id` int(20) DEFAULT NULL,
  `style_id` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `groupe_id` int(20) DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_musicsheet_title`
--

INSERT INTO `swing_musicsheet_title` (`id`, `title`, `author_id`, `arranger_id`, `style_id`, `date`, `groupe_id`, `description`) VALUES
(1, 'Can\'t Take MyEyes off you', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'In the mood', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'American Patrol', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Little Brown Jug', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Don\'t be that way', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Song For MyDaughter (solo tpt)', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Fly Me To The Moon (Nestico)', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Pennsylvania 6-5000', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Mood Indigo', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Solitude', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'The Chicken', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `swing_name`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_name` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_name`
--

INSERT INTO `swing_name` (`id`, `name`) VALUES
(14, 'Adolfo'),
(5, 'Alex'),
(3, 'Augustijn'),
(40, 'Beart'),
(24, 'Boucquey'),
(20, 'Bugyaki'),
(41, 'Charlier'),
(19, 'Collart'),
(23, 'Collon'),
(36, 'Danhieux'),
(25, 'Dehandtschutter'),
(2, 'Derek'),
(26, 'Doe'),
(37, 'Dombrecht'),
(10, 'Edward'),
(18, 'Erica'),
(47, 'Farmer'),
(8, 'Frank'),
(22, 'Ganhy'),
(45, 'Gathy'),
(46, 'Guy'),
(35, 'Hannon'),
(21, 'Hendrickx'),
(1, 'Ivo'),
(15, 'Jan'),
(6, 'Jean-Marie'),
(27, 'John'),
(16, 'Kevin'),
(29, 'Klaus-Peter'),
(13, 'Louis'),
(12, 'Marc'),
(43, 'Mark'),
(4, 'Michel'),
(11, 'Philippe'),
(31, 'Pieter'),
(28, 'Puttemans'),
(42, 'Sewsanker'),
(9, 'Simon'),
(39, 'Stefaan'),
(7, 'Stéphane'),
(44, 'Thomas'),
(33, 'Van Haasteren'),
(34, 'Van Oudenhove'),
(32, 'Verchueren'),
(38, 'Weinel'),
(30, 'Winz'),
(17, 'Youri');

-- --------------------------------------------------------

--
-- Structure de la table `swing_newsletters`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_newsletters` (
  `id` int(10) UNSIGNED NOT NULL,
  `email_id` int(20) UNSIGNED NOT NULL,
  `user_id` int(20) UNSIGNED DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` tinyint(1) NOT NULL DEFAULT '1',
  `diary` tinyint(1) NOT NULL DEFAULT '1',
  `gallery` tinyint(1) NOT NULL DEFAULT '0',
  `demos` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_newsletters`
--

INSERT INTO `swing_newsletters` (`id`, `email_id`, `user_id`, `password`, `email`, `diary`, `gallery`, `demos`, `active`) VALUES
(1, 1, NULL, NULL, 1, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `swing_pages`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `page` varchar(255) COLLATE utf8_bin NOT NULL,
  `auth_id` int(10) UNSIGNED NOT NULL DEFAULT '2',
  `url_id` int(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_pages`
--

INSERT INTO `swing_pages` (`id`, `page`, `auth_id`, `url_id`, `active`) VALUES
(1, 'home', 2, NULL, 1),
(2, 'group', 2, NULL, 1),
(3, 'diary', 2, NULL, 1),
(4, 'gallery', 2, NULL, 0),
(5, 'demos', 2, NULL, 1),
(6, 'technical', 2, NULL, 0),
(7, 'contact', 2, NULL, 1),
(8, 'profil', 4, NULL, 0),
(9, 'musicsheet', 6, NULL, 0),
(10, 'admin', 1, NULL, 0),
(11, 'news', 3, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `swing_pseudo`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_pseudo` (
  `id` int(10) UNSIGNED NOT NULL,
  `pseudo` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_pseudo`
--

INSERT INTO `swing_pseudo` (`id`, `pseudo`) VALUES
(1, '@Pseudo#123');

-- --------------------------------------------------------

--
-- Structure de la table `swing_status`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_status`
--

INSERT INTO `swing_status` (`id`, `status`, `description`) VALUES
(1, 'active', 'actif sur le site'),
(2, 'sleep', 'en sommeil sur le site'),
(3, 'do not disturb', 'ne pas déranger'),
(4, 'close', 'fermé');

-- --------------------------------------------------------

--
-- Structure de la table `swing_street`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_street` (
  `id` int(20) UNSIGNED NOT NULL,
  `street` varchar(255) COLLATE utf8_bin NOT NULL,
  `trad_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_street`
--

INSERT INTO `swing_street` (`id`, `street`, `trad_id`) VALUES
(1, 'Célestin Cherpion', 0),
(2, 'Gemeenteplein', 0),
(3, 'Sainte-Catherine', 0),
(4, 'Justus Lipsiusplein', NULL),
(5, 'Begijnhof', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `swing_street_type`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_street_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `trad_id` int(10) UNSIGNED DEFAULT NULL,
  `abvr` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_street_type`
--

INSERT INTO `swing_street_type` (`id`, `type`, `trad_id`, `abvr`, `description`) VALUES
(1, 'rue', 214, 'R.', NULL),
(2, 'avenue', NULL, 'Av.', NULL),
(3, 'boulevard', NULL, 'Bld.', NULL),
(4, 'ruelle', NULL, 'Rlle.', NULL),
(5, 'clos', NULL, 'Cl.', NULL),
(6, 'chemin', NULL, 'Ch.', NULL),
(7, 'place', NULL, 'pl.', 'place');

-- --------------------------------------------------------

--
-- Structure de la table `swing_styles`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_styles` (
  `id` int(10) UNSIGNED NOT NULL,
  `style_id` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `swing_task`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_task` (
  `id` int(20) UNSIGNED NOT NULL,
  `user_id` int(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `close` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_task`
--

INSERT INTO `swing_task` (`id`, `user_id`, `name`, `description`, `created_at`, `updated_at`, `close`) VALUES
(1, 1, 'ASUS', 'lmkiqjsdmgijf', '2021-06-06 19:51:48', '2021-06-06 19:51:48', 0);

-- --------------------------------------------------------

--
-- Structure de la table `swing_tel`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_tel` (
  `id` int(20) UNSIGNED NOT NULL,
  `tel` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_tel`
--

INSERT INTO `swing_tel` (`id`, `tel`) VALUES
(1, '010/22.66.79');

-- --------------------------------------------------------

--
-- Structure de la table `swing_tone`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_tone` (
  `id` int(10) UNSIGNED NOT NULL,
  `US` varchar(255) COLLATE utf8_bin NOT NULL,
  `EU` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `desciption` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `swing_town`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_town` (
  `id` int(20) UNSIGNED NOT NULL,
  `town` varchar(255) COLLATE utf8_bin NOT NULL,
  `abvr` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `land_id` int(10) UNSIGNED DEFAULT NULL,
  `district_id` int(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_town`
--

INSERT INTO `swing_town` (`id`, `town`, `abvr`, `postal_code`, `land_id`, `district_id`, `description`) VALUES
(1, 'Hoeilaart', NULL, '1560', 1, 1, NULL),
(2, 'Pécrot', NULL, '1390', 1, 2, NULL),
(3, 'Bruxelles', 'BXL.', '1000', 1, 3, 'capitale belge'),
(4, 'Overijs', NULL, '3090', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `swing_trad`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_trad` (
  `id` int(10) UNSIGNED NOT NULL,
  `trad` varchar(255) COLLATE utf8_bin NOT NULL,
  `fr` longtext COLLATE utf8_bin,
  `nl` longtext COLLATE utf8_bin,
  `en` longtext COLLATE utf8_bin,
  `de` longtext COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_trad`
--

INSERT INTO `swing_trad` (`id`, `trad`, `fr`, `nl`, `en`, `de`) VALUES
(1, 'error/unknow', 'erreur inconnue', 'onbekende fout', 'unknown error', 'unbekannter Fehler'),
(2, 'page/home', 'accueil', 'Startpagina', 'home', 'Startseite'),
(3, 'page_error/not_found', 'La page [ %{page}% ] n\'existe pas !', 'De pagina [ %{page}% ] bestaat niet !', 'The page [ %{page}% ] does not exist !', 'Die Seite [ %{Seite}% ] existiert nicht !'),
(4, 'page_error/permiss', 'Vous n\'avez pas l\'autorisation d\'accéder à cette page !', 'U heeft geen toestemming om deze pagina te openen !', 'You do not have permission to access this page !', 'Sie haben keine Berechtigung, auf diese Seite zuzugreifen !'),
(5, 'form/require', 'champs obligatoire', 'Verplichte velden', 'Required fields', 'Benötigte Felder'),
(6, 'page/group', 'groupe', 'groep', 'group', 'gruppe'),
(7, 'page/diary', 'agenda', 'Kalender', 'diary', 'tagebuch'),
(8, 'page/gallery', 'galerie', 'galerij', 'gallery', 'galerie'),
(9, 'page/demos', 'démos', 'demos', 'demos', 'demos'),
(10, 'page/technical', 'technique', 'technisch', 'technical', 'technisch'),
(11, 'page/contact', 'contact', 'contact', 'contact', 'kontakt'),
(12, 'group/presentation_title', 'Chers amis de la musique,  bienvenue au Swing Shift Big Band !', 'Beste muziekliefhebber, welkom bij de Swing Shift Big Band !', 'Dear music lover,  welcome to the Swing Shift Big Band !', 'Liebe Musikfreunde, willkommen in der Swing Shift Big Band !'),
(13, 'group/presentation_p1', 'D’abord un petit bout d’histoire.  Depuis 1994, ça swinge le jeudi soir à Hoeilaart.  Lorsque le Victor\'s Big band cessa ses activités, après avoir gravité un quart de siècle autour de l’harmonie de Kraainem – Stockel, quelques musiciens décidèrent de continuer malgré tout. Ainsi naquit le Swing Shift Big Band.', 'Een stukje geschiedenis. Sinds 1994 swingt het op donderdagavond te Hoeilaart. Bij het ter ziele gaan van de Victors\' Big band, die een kwarteeuw geleden bij de Harmonie van Kraainem-Stokkel was aangesloten, besloten enkele muzikanten om toch verder te doen en de Swing Shift Big Band was een feit.', 'First, a bit of history:  Swingshift Big Band was born out of Victor’s Big Band which broke up in 1994 after playing for more than 25 years in the Kraainem/Stockel area.  Since then, Swingshift has been based in Hoeilaart, rehearsing there most Thursdays in café Sportecho, near the church of Hoeilaart. ', 'Zuerst ein bisschen Geschichte. Seit 1994 schwingt es am Donnerstagabend in Hoeilaart. Als die Victor\'s Big Band ihre Aktivitäten einstellte, nachdem sie ein Vierteljahrhundert um die Harmonie von Kraainem - Stockel herum gearbeitet hatten, beschlossen einige Musiker, trotzdem fortzufahren. So wurde die Swing Shift Big Band geboren.'),
(14, 'group/presentation_p2', 'Notre dada : amitié et jazz.  Combinez la musique et une bonne pinte après la répétition, au café Sportecho, face à l\'église d\'Hoeilaart, et vous avez la recette du succès.  Swing Shift réunit, via le jazz quelques Flamouches, Brusselleirs, Wallons, mais aussi 2 British, un Allemand, un Autrichien, une paire d\'Hollandais, un Américain, un Colombien … et même un Russe.', 'Onze leuze is tot op vandaag vriendschap en jazz spelen. Combineer dit met een goede babbel met een pintje na de repetitie, in café Sportecho, aan de kerk van Hoeilaart, en je hebt de sleutel tot het succes van een hechte groep. De Swing Shift verenigt via de jazz enkele Vloemingen, Brusseleirs, des amis de la Wallonie, 2 Britten, ein Deutscher, ein Osterreicher, een paar Hollanders, een Colombiaan, een Amerikaan, en zelfs een Rus. ', 'A characteristic of the band is the combination of friendship and jazz.  We like to drink a beer or two during and after rehearsals which creates a strong team spirit.  Swing Shift Big Band has musicians from Flanders, Brussels, Wallonia, and also England, Germany, Austria, Colombia, Netherlands, USA, and even Russia.', 'Unser Hobby: Freundschaft und Jazz. Kombinieren Sie die Musik und ein gutes Bier nach der Probe im Sportecho-Café gegenüber der Kirche von Hoeilaart, und Sie haben das Erfolgsrezept. Swing Shift bringt über Jazz einige Flamouches, Brusselleirs, Wallonen zusammen, aber auch zwei Briten, einen Deutschen, einen Österreicher, ein Paar Holländer, einen Amerikaner, einen Kolumbianer… und sogar einen Russen.'),
(15, 'group/presentation_p3', 'Le répertoire jazz est très large, allant du swing, au latin, en passant par le blues, le rock, le funk et d’autres styles de jazz.  Il est inspiré par des sommités telles que Glenn Miller, Benny Goodman, Duke Ellington, Count Basie, Sammy Nestico, ainsi que beaucoup d’autres compositeurs plus récents.', 'Het jazz repertoire is zeer breed, gaande van swing, latin, blues, rock, funk en andere jazz stijlen, geïnspireerd op de muziek van grootheden als Glenn Miller, Benny Goodman, Duke Ellington, Count Basie, Sammy Nestico en veel meer recentere componisten.', 'We play an extended range of jazz styles, from Swing to Latin, and also Blues, Rock and Funk. We are inspired not only by the famous Glenn Miller, Benny Goodman, Duke Ellington, Count Basie, Sammy Nestico, but also by more contemporary musicians.', 'Das Jazz-Repertoire ist sehr breit und reicht von Swing über Latin, Blues, Rock, Funk bis hin zu anderen Jazzstilen. Er ist inspiriert von Größen wie Glenn Miller, Benny Goodman, Herzog Ellington, Graf Basie, Sammy Nestico und vielen anderen neueren Komponisten.'),
(16, 'group/presentation_p4', 'Notre caractère international nous amène à avoir des contacts au-delà des frontières belges.  Ceci nous a permis d’effectuer quelques voyages musicaux, notamment à Copenhagen, Dresde, et le Languedoc dans le sud ensoleillé de la France.  Un concert dans le Parc Tivoli, le plus beau parc de la capitale danoise, l\'établissement de ponts avec un big band à Dresde (avec, à la clé, bières et cuisine allemandes) et un concert sous les platanes du Sud de la France, au BBQ annuel du club de pétanque local) : tous des souvenirs et moments mémorables, tant d’un point de vue musical, qu’au niveau humain.', 'Door ons internationaal karakter hebben wij natuurlijk ook contacten tot ver over de landsgrenzen heen. Dit heeft ons de mogelijkheid geboden om een aantal leuke driedaagse muzikale reizen te kunnen maken waaronder naar Kopenhagen, Dresden en de Languedoc in het zonnige Zuid-Frankrijk. Een optreden in het Tivoli park, het mooiste park in de Deense hoofdstad, een verbroedering met een lokale big band in Dresden, met bier en echte Duitse keuken of een concert onder de platanen op de jaarlijkse barbecue van de lokale petanqueclub in een Zuid-Frans dorpje tijdens een zwoele zomeravond: allemaal herinneringen van unieke, mooie muzikale momenten en nieuwe vriendschapsbanden.', 'Our international character allows us to play abroad and we have fond memories of our concerts in Copenhaguen (Tivoli Parc), Dresden (where we met a local band, and discovered German cooking & beer), Languedoc (where we played under the Plane trees in south of France at the annual BBQ of a local Pétanque club). ', 'Unser internationaler Charakter führt zu Kontakten über die belgischen Grenzen hinaus. Dies ermöglichte uns einige musikalische Reisen, insbesondere nach Kopenhagen, Dresden und Languedoc im sonnigen Südfrankreich. Ein Konzert im Tivoli-Park, dem schönsten Park der dänischen Hauptstadt, die Errichtung von Brücken mit einer Big Band in Dresden (mit deutschem Bier und deutscher Küche) und ein Konzert unter den Platanen Südfrankreichs , beim jährlichen BBQ des örtlichen Pétanque-Clubs): alle Erinnerungen und unvergesslichen Momente, sowohl aus musikalischer Sicht als auch auf menschlicher Ebene.'),
(17, 'group/presentation_p5', 'En Belgique, nous jouons une dizaine de concerts par an, notamment à la fête du raisin à Overijse et Hoeilaart.  Nous animons régulièrement l’ouverture de la fête des maatjes en juin à la place Ste-Catherine au cœur de Bruxelles.  Le bénéfice de ces concerts va en intégralité au fonctionnement de notre groupe.', 'In eigen land treden wij jaarlijks een 10-tal maal op, waarbij de Druivenfeesten in Overijse en Hoeilaart en de opening van de Maatjesfeesten op het St-Kathelijneplein in hartje Brussel vaste afspraken zijn. De opbrengst uit optredens gaat integraal naar de werking van onze Big Band.', 'We play around 10 concerts a year in Belgium.  We regularly play at the September Druivenfeest (Grape Festival) in Overijse and Hoeilaart, and the June Maatjesfeest (Herring Festival) in Place Saint-Catherine, in the centre of Brussels.  The revenue from our concerts goes towards the operating costs of the band.', 'In Belgien spielen wir ungefähr zehn Konzerte pro Jahr, insbesondere beim Grape Festival in Overijse und Hoeilaart. Wir veranstalten regelmäßig die Eröffnung des Maatjes Festivals im Juni am Place Ste-Catherine im Herzen von Brüssel. Der Nutzen dieser Konzerte liegt ganz im Funktionieren unserer Gruppe.'),
(18, 'group/presentation_p6', 'La direction artistique de Swing Shift est assurée par Ivo Hendrickx, trompettiste professionnel.', 'De Swing Shift staat heden ten dage onder de leiding van Ivo Hendrickx, professioneel trompettist.', 'Swing Shift plays under the artistical direction of Ivo Hendrickx, professionnal trumpetist.', 'Die künstlerische Leitung von Swing Shift übernimmt der professionelle Trompeter Ivo Hendrickx.'),
(19, 'group/presentation_p7', 'Pour en savoir plus sur notre Big band, ou pour faire appel à nos services, prenez contact avec nous !', 'Indien jullie meer wensen te weten over onze Big Band, of voor het boeken van een optreden, neem dan contact op met ons !', 'Please contact us for more information concerning our Big Band, or to book a concert !', 'Um mehr über unsere Big Band zu erfahren oder unsere Dienste zu nutzen, kontaktieren Sie uns !'),
(20, 'group/presentation_p8', 'Amusez-vous en écoutant le Swing Shift Big Band !', 'Geniet van de jazz muziek met de Swing Shift Big Band !', 'Have fun listening to the Swing Shift Big Band !', 'Viel Spaß beim Hören der Big Band Swing Shift !'),
(21, 'link_demo_concert', 'Écoutez notre DEMO et consultez nos PROCHAINS CONCERTS', 'Luister naar onze DEMO en bekijk onze VOLGENDE CONCERTEN', 'Listen to our DEMO and check our NEXT CONCERTS', 'Hören Sie sich unsere DEMO an und sehen Sie sich unsere NÄCHSTEN KONZERTE an'),
(22, 'group/musicos/sax_title', 'saxophones', 'saxofoons', 'saxophones', 'saxophone'),
(23, 'group/musicos/trp_title', 'trompettes', 'trompetten', 'trumpets', 'trompeten'),
(24, 'group/musicos/trb_title', 'trombones', 'trombones', 'trombones', 'Posaunen'),
(25, 'group/musicos/rythm_title', 'rythmique', 'ritmisch', 'rhythmic', 'rhythmisch'),
(26, 'group/musicos/vocal_title', 'chant', 'vocale', 'vocal', 'Vokal'),
(27, 'group/musicos/conductor_title', 'direction', 'dirigent', 'conductor', 'Dirigent'),
(28, 'instru_sax_alto_1', '1er saxophone alto', '1e altsaxofoon', '1st alt saxophone', '1. Altsaxophon'),
(29, 'instru_sax_tenor_1', '1er saxophone ténor', '1e tenorsaxofoon', '1st tenor saxophone', '1. Tenorsaxophon'),
(30, 'instru_sax_alto_2', '2e saxophone alto', '2e altsaxofoon', '2nd alt saxophone', '2. Altsaxophon'),
(31, 'instru_sax_tenor_2', '2e saxophone ténor', '2e tenorsaxofoon', '2nd tenor saxophone', '2. Tenorsaxophon'),
(32, 'instru_sax_baryton', 'saxophone baryton', 'baryton saxofoon', 'baritone saxophone', 'Baritonsaxophon'),
(33, 'instru_clarinet', 'clarinette', 'klarinet', 'clarinet', 'Klarinette'),
(34, 'instru_trp_1', '1ère trompette', '1e trompet', '1st trumpet', '1. Trompete'),
(35, 'instru_trp_2', '2ème trompette', '2e trompet', '2nd trumpet', '2. Trompete'),
(36, 'instru_trp_3', '3ème trompette', '3e trompet', '3rd trumpet', '3. Trompete'),
(37, 'instru_trp_4', '4ème trompette', '4e trompet', '4th trumpet', '4. Trompete'),
(38, 'instru_trb_1', '1er trombone', '1e trombone', '1st trombone', '1. Posaune'),
(39, 'instru_trb_2', '2ème trombone', '2e trombone', '2nd trombone', '2. Posaune'),
(40, 'instru_trb_3', '3ème trombone', '3e trombone', '3rd trombone', '3. Posaune'),
(41, 'instru_trb_4', '4ème trombone', '4e trombone', '4th trombone', '4. Posaune'),
(42, 'instru_piano', 'piano', 'piano', 'piano', 'Klavier'),
(43, 'instru_guitar', 'guitare', 'gitaar', 'guitar', 'Gitarre'),
(44, 'instru_contrebass', 'contrebasse', 'contrebasse', 'contrabass', 'Bass'),
(45, 'instru_prq', 'percussions', 'percussies', 'percussions', 'Percussions'),
(46, 'instru_drums', 'batterie', 'drums', 'drums', 'Schlagzeug'),
(47, 'instru_guit_bass', 'guitare basse', 'basgitaar', 'bass guitar', 'Bassgitarre'),
(48, 'instru_chant_m', 'chanteur', 'zanger', 'singer', 'Sänger'),
(49, 'instru_chant_f', 'chanteuse', 'zangeres', 'singer', 'Sänger'),
(50, 'word_send', 'envoyer', 'verzenden', 'send', 'senden'),
(51, 'word_name', 'nom', 'naam', 'name', 'Nachname'),
(52, 'word_mail', 'e-mail', 'e-mail', 'e-mail', 'Email'),
(53, 'word_msg', 'message', 'bericht', 'message', 'Botschaft'),
(54, 'home/welkom_title', 'Bienvenue !', 'Welkom !', 'Welkome !', 'herzlich willkommen !'),
(55, 'home/welkom_p1', 'Le Swing Shift Big Band, basé à Hoeilaart, est né en 1994 d’une poignée d’amis appréciant le jazz.', 'De Swing Shift Big Band, afkomstig uit Hoeilaart, werd in 1994 opgericht door een aantal vrienden jazz liefhebbers.', 'The Swing Shift Big Band is based in Hoeilaart and was started in 1994 by a couple of friends who loved jazz.', 'Die in Hoeilaart ansässige Swing Shift Big Band wurde 1994 als Tochter einer Handvoll jazzliebender Freunde geboren.'),
(56, 'home/welkom_p2', 'Un groupe typiquement belge, rassemblant  18 musiciens et 2 chanteurs issus de toutes les régions du pays et de diverses nationalités.', 'Een typische Belgische groep, die 18 muzikanten en 2 zangers verzamelt vanuit alle regio’s van het land, alsmede een handvol buitenlanders.', 'It is a typical Belgian group, with the 18 musicians and 2 singers coming from various parts of Belgium, and abroad.', 'Eine typisch belgische Gruppe, die 18 Musiker und 2 Sänger aus allen Regionen des Landes und aus verschiedenen Nationalitäten zusammenbringt.'),
(57, 'home/welkom_p3', 'Notre projet est d’interpréter les musiques de jazz traditionnelles pour big band (Glenn Miller, Benny Goodman, Duke Ellington, Count Basie, George Gershwin, Richard Roger, Horace Silver, Sammy Nestico…), ainsi que des arrangements de musiques plus contemporaines.', 'Ons project is het spelen van traditionele jazz big band muziek (Glenn Miller, Benny Goodman, Duke Ellington, Count Basie, George Gershwin, Richard Roger, Horace Silver, Sammy Nestico…), alsmede bewerkingen van hedendaagse songs.', 'Our repertoire covers the usual jazz big band music (Glenn Miller, Benny Goodman, Duke Ellington, Count Basie, George Gershwin, Richard Rogers, Horace Silver, Sammy Nestico…), plus arrangements of contemporary music.', 'Unser Projekt ist die Interpretation traditioneller Jazzmusik für Big Bands (Glenn Miller, Benny Goodman, Herzog Ellington, Graf Basie, George Gershwin, Richard Roger, Horace Silver, Sammy Nestico ...) sowie Arrangements zeitgenössischer Musik.'),
(58, 'home/welkom_p4', 'Notre groupe rassemble plusieurs musiciens talentueux. Vous serez agréablement surpris par la qualité de notre service !', 'Onze band verzamelt meerdere talentvolle muzikanten. U zal aangenaam verrast zijn door de kwaliteit van onze prestatie !', 'Our band gathers several talented musicians. You will be pleasantly surprised by the quality of our service !', 'Unsere Band versammelt mehrere talentierte Musiker. Sie werden von der Qualität unserer Dienstleistungen angenehm überrascht sein !'),
(59, 'home/welkom_p5', 'N’hésitez pas à nous contacter pour animer vos fêtes, soirées, … ou simplement venir nous écouter et passer un bon moment musical.', 'Aarzel niet ons te contacteren voor het opluisteren van feestelijke gelegenheden, … of simpelweg te genieten van een mooi muzikaal moment.', 'Don’t hesitate to contact us to bring a swing to your parties or events, or simply to enjoy listening to our music.', 'Zögern Sie nicht, uns zu kontaktieren, um Ihre Partys, Partys ... zu animieren, oder kommen Sie einfach und hören Sie uns zu und haben Sie eine gute musikalische Zeit.'),
(60, 'more_infos', 'Plus d\'info ...', 'Meer info ...', 'More info ...', 'Mehr Informationen ...'),
(61, 'home/title', 'Swing Shift Big Band', 'Swing Shift Big Band', 'Swing Shift Big Band', 'Swing Shift Big Band'),
(62, 'url/conditions', 'mentions legales', 'voorwaarden', 'terms and conditions', 'Geschäftsbedingungen'),
(63, 'url/sitemap', 'plan du site', 'sitemap', 'sitemap', 'Seitenverzeichnis'),
(64, 'technical_rider_pdf/title1_0_c', 'Swing Shift Big Band', 'Swing Shift Big Band', 'Swing Shift Big Band', 'Swing Shift Big Band'),
(65, 'technical_rider_pdf/title4_1_c', 'Fiche Technique', 'Technical Rider', 'Technical Rider', 'Technischer Fahrer'),
(66, 'technical_rider_pdf/title4_2_url_c', 'www.swingshift.be %{ url = \'https://swingshift.be/\' }%', 'www.swingshift.be %{ url = \'https://swingshift.be/\' }%', 'www.swingshift.be %{ url = \'https://swingshift.be/\' }%', 'www.swingshift.be %{ url = \'https://swingshift.be/\' }%'),
(67, 'technical_rider_pdf/contact/title2', 'Personnes de contact :', 'Contactpersonen :', 'Contact persons :', 'Kontaktpersonen :'),
(68, 'technical_rider_pdf/contact/p_1', 'Président a.i. : %{ member_id = 7, \'lastname_id firstname_id\' }% : %{ member_id = 7, gsm_id }%', 'President a.i. : %{ member_id = 7, \'lastname_id firstname_id\' }% : %{ member_id = 7, gsm_id }%', 'President a.i. : %{ member_id = 7, \'lastname_id firstname_id\' }% : %{ member_id = 7, gsm_id }%', 'Präsident a.i. : %{ member_id = 7, \'lastname_id firstname_id\' }% : %{ member_id = 7, gsm_id }%'),
(69, 'technical_rider_pdf/contact/p_2', 'Chef d\'orchestre a.i. : %{ member_id = 1, \'lastname_id firstname_id\' }% : %{ member_id = 1, gsm_id }%', 'Dirigent : %{ member_id = 1, \'lastname_id firstname_id\' }% : %{ member_id = 1, gsm_id }%', 'Conductor : %{ member_id = 1, \'lastname_id firstname_id\' }% : %{ member_id = 1, gsm_id }%', 'Dirigent : %{ member_id = 1, \'lastname_id firstname_id\' }% : %{ member_id = 1, gsm_id }%'),
(70, 'technical_rider_pdf/contact/p3', NULL, 'Klanktechnieker : Geert De Deken : +32/497/43.17.65 / avinspire@gmail.com', NULL, NULL),
(71, 'technical_rider_pdf/sound/title2', NULL, 'Klankinstallatie', NULL, NULL),
(72, 'technical_rider_pdf/sound/title3_1_U', NULL, 'FOH', NULL, NULL),
(73, 'technical_rider_pdf/sound/p1', NULL, 'Het gehuurde materiaal moet van goede kwalitijt zijn. Voor de keuze van merken vertrouwen we op de kennis en ervaring van de systeem-instalateur.', NULL, NULL),
(74, 'technical_rider_pdf/sound/p2', NULL, 'Minimum Stereo PA, 95 dBA aan de mixerplaats', NULL, NULL),
(75, 'technical_rider_pdf/sound/p3_0', NULL, 'Mixer : 32 kanaals met degelijke EQ en min 4 aux en 4 subgroups.', NULL, NULL),
(76, 'technical_rider_pdf/sound/p3_1', NULL, 'Phantoomvoeding.', NULL, NULL),
(77, 'technical_rider_pdf/sound/p3_2', NULL, '4 stereo compressors + reverb voorzien.', NULL, NULL),
(78, 'technical_rider_pdf/sound/title3_2_U', NULL, 'Monitoring', NULL, NULL),
(79, 'technical_rider_pdf/sound/p4_0', NULL, 'Monitoring gebeurt door frontmixer.', NULL, NULL),
(80, 'technical_rider_pdf/sound/p4_1', NULL, 'AUX 1 (Pre) : Zangers', NULL, NULL),
(81, 'technical_rider_pdf/sound/p4_2', NULL, 'AUX 2 (Pre) : Ritmesectie', NULL, NULL),
(82, 'technical_rider_pdf/sound/p4_3', NULL, 'AUX 3 (Pre) : Side Fills', NULL, NULL),
(83, 'technical_rider_pdf/sound/p4_4', NULL, 'AUX 4 (Pre) : FX Send', NULL, NULL),
(84, 'technical_rider_pdf/light/title2', NULL, 'Belichting', NULL, NULL),
(85, 'technical_rider_pdf/light/p1', NULL, 'De organisator verzorgt een correcte verlichting van de scene.', NULL, NULL),
(86, 'technical_rider_pdf/Logistic/title2', NULL, 'Logistiek', NULL, NULL),
(87, 'technical_rider_pdf/logistic/p1_0', NULL, 'Podium min 8m x 4m', NULL, NULL),
(88, 'technical_rider_pdf/logistic/p1_1', NULL, 'Regietafel met 2 stoelen in het midden van de zaal.', NULL, NULL),
(89, 'technical_rider_pdf/logistic/p1_2', NULL, 'Stoelen voor alle muzikanten.', NULL, NULL),
(90, 'technical_rider_pdf/logistic/p2_0', 'Stroomvoorziening 1 x 16A op 6 stopcontacten voor ritmesectie', NULL, NULL, NULL),
(91, 'technical_rider_pdf/logistic/p2_1', NULL, 'Stroomvoorziening versterking : 16 A', NULL, NULL),
(92, 'technical_rider_pdf/logistic/p2_2', NULL, 'Regietafel 6 stopcontacten 10 A op dezelfde fase.', NULL, NULL),
(93, 'technical_rider_pdf/logistic/p3', NULL, 'De organisator voorziet in drank voor de muzikanten en de technische begeleiding.', NULL, NULL),
(94, 'technical_rider_pdf/rights/title2_U', NULL, 'Rechten', NULL, NULL),
(95, 'technical_rider_pdf/rights/p1_list_*', NULL, 'Er mag niet gefilmd worden of opnamen gebeuren op eende welken anderen manier zonder schrijftelijke toelating van de band.', NULL, NULL),
(96, 'technical_rider_pdf/rights/p2_list_*', NULL, 'Alle eventuele rechten, duplicatie - auteursrechten vallen onder de verantwoordelijkheid van de organisator.', NULL, NULL),
(97, 'technical_rider_pdf/rights/p3_list_*', NULL, 'De Organisator is in orde met de regelgeving ivm geluidsorverlast. en', NULL, NULL),
(98, 'technical_rider_pdf/pricelist/title1_C', NULL, 'Priklijst', NULL, NULL),
(99, 'technical_rider_pdf/pricelist/p1', NULL, '(Rangschikking volgens MIDAS Venice)', NULL, NULL),
(100, 'technical_rider_pdf/pricelist/table/header/cell_1', NULL, 'Multi kabel', NULL, NULL),
(101, 'technical_rider_pdf/pricelist/table/header/cell_2', NULL, 'In mixer', NULL, NULL),
(102, 'technical_rider_pdf/pricelist/table/header/cell_3', NULL, 'Instrument', NULL, NULL),
(103, 'technical_rider_pdf/pricelist/table/header/cell_4', NULL, 'Type micro', NULL, NULL),
(104, 'technical_rider_pdf/pricelist/table/header/cell_5', '%{null}%', '%{null}%', '%{null}%', '%{null}%'),
(105, 'technical_rider_pdf/pricelist/table/row_1', NULL, '[1, 1, %{instru_id = }%, \'Sennheiser e 908 / DPA 4099\', null]', NULL, NULL),
(106, 'technical_rider_pdf/map/title1_C', NULL, 'Grondplan', NULL, NULL),
(107, 'technical_rider_pdf/map/img_1_C', '%{url_id = 20}%', '%{url_id = 20}%', '%{url_id = 20}%', '%{url_id = 20}%'),
(108, 'group/conductor/1', '%{ trad trad_id = 120 }%', '%{ trad trad_id = 120 }%', '%{ trad trad_id = 120 }%', '%{ trad trad_id = 120 }%'),
(109, 'group/conductor/2', '%{ trad trad_id = 135 }%', '%{ trad trad_id = 135 }%', '%{ trad trad_id = 135 }%', '%{ trad trad_id = 135 }%'),
(110, 'group/rythm/P', '%{ instruments instru_id = 15 }%', '%{ instruments instru_id = 15 }%', '%{ instruments instru_id = 15 }%', '%{ instruments instru_id = 15 }%'),
(111, 'group/rythm/G', '%{ instruments instru_id = 16 }%', '%{ instruments instru_id = 16 }%', '%{ instruments instru_id = 16 }%', '%{ instruments instru_id = 16 }%'),
(112, 'group/rythm/CB_GB', '%{ instruments instru_id = 17 & 20 }%', '%{ instruments instru_id = 17 & 20 }%', '%{ instruments instru_id = 17 & 20 }%', '%{ instruments instru_id = 17 & 20 }%'),
(113, 'group/rythm/PRQ', '%{ instruments instru_id = 18 }%', '%{ instruments instru_id = 18 }%', '%{ instruments instru_id = 18 }%', '%{ instruments instru_id = 18 }%'),
(114, 'group/rythm/D', '%{ instruments instru_id = 19 }%', '%{ instruments instru_id = 19 }%', '%{ instruments instru_id = 19 }%', '%{ instruments instru_id = 19 }%'),
(115, 'group/sax/SA1', '%{ instruments instru_id = 1 }%', '%{ instruments instru_id = 1 }%', '%{ instruments instru_id = 1 }%', '%{ instruments instru_id = 1 }%'),
(116, 'group/sax/SA2', '%{ instruments instru_id = 3 }%', '%{ instruments instru_id = 3 }%', '%{ instruments instru_id = 3 }%', '%{ instruments instru_id = 3 }%'),
(117, 'group/sax/ST1', '%{ instruments instru_id = 2 }%', '%{ instruments instru_id = 2 }%', '%{ instruments instru_id = 2 }%', '%{ instruments instru_id = 2 }%'),
(118, 'group/sax/ST2', '%{ instruments instru_id = 4 }%', '%{ instruments instru_id = 4 }%', '%{ instruments instru_id = 4 }%', '%{ instruments instru_id = 4 }%'),
(119, 'group/sax/SB_C', '%{ instruments instru_id = 5 }%', '%{ instruments instru_id = 5 }%', '%{ instruments instru_id = 5 }%', '%{ instruments instru_id = 5 }%'),
(120, 'group/trb/TB1', '%{ instruments instru_id = 11 }%', '%{ instruments instru_id = 11 }%', '%{ instruments instru_id = 11 }%', '%{ instruments instru_id = 11 }%'),
(121, 'group/trb/TB2', '%{ instruments instru_id = 12 }%', '%{ instruments instru_id = 12 }%', '%{ instruments instru_id = 12 }%', '%{ instruments instru_id = 12 }%'),
(122, 'group/trb/TB3', '%{ instruments instru_id = 13 }%', '%{ instruments instru_id = 13 }%', '%{ instruments instru_id = 13 }%', '%{ instruments instru_id = 13 }%'),
(123, 'group/trb/TB4', '%{ instruments instru_id = 14 }%', '%{ instruments instru_id = 14 }%', '%{ instruments instru_id = 14 }%', '%{ instruments instru_id = 14 }%'),
(124, 'group/trp/TP1', '%{ instruments instru_id = 7 }%', '%{ instruments instru_id = 7 }%', '%{ instruments instru_id = 7 }%', '%{ instruments instru_id = 7 }%'),
(125, 'group/trp/TP2', '%{ instruments instru_id = 8 }%', '%{ instruments instru_id = 8 }%', '%{ instruments instru_id = 8 }%', '%{ instruments instru_id = 8 }%'),
(126, 'group/trp/TP3', '%{ instruments instru_id = 9 }%', '%{ instruments instru_id = 9 }%', '%{ instruments instru_id = 9 }%', '%{ instruments instru_id = 9 }%'),
(127, 'group/trp/TP4', '%{ instruments instru_id = 10 }%', '%{ instruments instru_id = 10 }%', '%{ instruments instru_id = 10 }%', '%{ instruments instru_id = 10 }%'),
(128, 'group/vocal/CHF', '%{ instruments instru_id = 22 }%', '%{ instruments instru_id = 22 }%', '%{ instruments instru_id = 22 }%', '%{ instruments instru_id = 22 }%'),
(129, 'group/vocal/CHM', '%{ instruments instru_id = 21 }%', '%{ instruments instru_id = 21 }%', '%{ instruments instru_id = 21 }%', '%{ instruments instru_id = 21 }%'),
(130, 'word_principal_conductor', 'chef d\'orchestre principal', 'hoofddirigent', 'principal conductor', 'Hauptdirigent'),
(131, 'trad_pres_cond2_secr', '%{ trad trad_id = 134 }%, %{ trad trad_id = 136 }%, %{ trad trad_id = 135 }%', '%{ trad trad_id = 134 }%, %{ trad trad_id = 136 }%, %{ trad trad_id = 135 }%', '%{ trad trad_id = 134 }%, %{ trad trad_id = 136 }%, %{ trad trad_id = 135 }%', '%{ trad trad_id = 134 }%, %{ trad trad_id = 136 }%, %{ trad trad_id = 135 }%'),
(132, 'word_treasurer', 'trésorier', 'penningmeester', 'treasurer', 'Schatzmeister'),
(133, 'word_webmaster', 'webmaster', 'webmaster', 'webmaster', 'webmaster'),
(134, 'word_president', 'président par intérim', 'waarnemend president', 'acting president', 'Amtierender präsident'),
(135, 'word_second_conductor', 'second chef d\'orchestre', 'tweede dirigent', 'second conductor', 'zweiter Dirigent'),
(136, 'word_secretary', 'secrétaire par intérim', 'waarnemend secretaris', 'acting secretary', 'Stellvertretender sekretär'),
(137, 'swingshift/concert/20ans/title', 'Concert des 20 ans du SwingShift Big Band !', 'SwingShift Big Band 20-jarig jubileumconcert !', 'SwingShift Big Band 20th anniversary concert !', 'SwingShift Big Band Konzert zum 20-jährigen Jubiläum !'),
(138, 'word_entry', 'entrée', 'ingang', 'entrance', 'eingang'),
(139, 'word_presale', 'prévente', 'voorverkoop', 'presale', 'vorverkauf'),
(140, 'word_diary_table_date', 'date', 'datum', 'date', 'datum'),
(141, 'word_diary_table_hour', 'heure', 'uur', 'hour', 'stunde'),
(142, 'word_diary_table_event', 'évènement', 'evenement', 'event', 'veranstaltung'),
(143, 'word_diary_table_price', 'prix', 'prijs', 'price', 'preis'),
(144, 'word_diary_table_label', 'label', 'label', 'label', 'aufkleber'),
(145, 'word_diary_table_details', 'détails', 'details', 'details', 'einzelheiten'),
(146, 'word_diary_table_available_seats', 'places disponibles', 'beschikbare stoelen', 'available seats', 'verfügbare Sitzplätze'),
(147, 'word_diary_table_sold_out', 'complet', 'uitverkocht', 'sold out', 'ausverkauft'),
(148, 'word_diary_table_canceled', 'annuler', 'geannuleerd', 'canceled', 'abgesagt'),
(149, 'word_diary_table_closed', 'évènement fermé', 'gesloten evenement', 'closed event', 'geschlossene veranstaltung'),
(150, 'word_free', 'gratuit', 'vrij', 'free', 'frei'),
(151, 'swingshift/concert/maatjes2014/title', 'maatjesfeest', 'maatjesfeest', 'maatjesfeest', 'maatjesfeest'),
(152, 'word_password', 'mot de passe', 'wachtwoord', 'password', 'passwort'),
(153, 'word_login', 'identification', 'log in', 'login', 'Anmeldung'),
(154, 'placeholder_login', 'e-mail ou pseudo', 'e-mail of bijnaam', 'e-mail or nickname', 'e-mail oder spitzname'),
(155, 'sign_in/title', 'se connecter', 'inloggen', 'sign in', 'einloggen'),
(156, 'word_pseudo', 'pseudo', 'bijnaam', 'nickname', 'Spitzname'),
(157, 'word_firstname', 'Prénom', 'Voornaam', 'firstname', 'Vorname'),
(158, 'word_lastname', 'nom', 'achternaam', 'lastname', 'Nachname'),
(159, 'word_confirm', 'confirmer', 'bevestigen', 'confirm', 'bestätigen'),
(160, 'form_robot', 'je ne suis pas un robot', 'Ik ben geen robot', 'I am not a robot', 'Ich bin kein Roboter'),
(161, 'sign_up/title', 's\'enregistrer', 'registreren', 'register', 'registrieren'),
(162, 'form_conditions', 'j\'acceptes les conditions générales du site', 'Ik accepteer de algemene voorwaarden van de site', 'I accept the general conditions of the site', 'Ich akzeptiere die allgemeinen Bedingungen der Website'),
(163, 'page/profil', 'mon compte', 'mijn account', 'my account', 'mein Konto'),
(164, 'page/admin', 'administration', 'administratie', 'administration', 'Verwaltung'),
(165, 'page/partitions', 'partitions', 'bladmuziek', 'sheet music', 'Noten'),
(166, 'page/disconnect', 'se déconnecter', 'Afmelden', 'Sign out', 'Ausloggen'),
(167, 'newsletter/title', 'newsletter', 'nieuwsbrief', 'newsletter', 'newsletter'),
(168, 'form/contact', 'formulaire de contact', 'Contact Formulier', 'Contact form', 'Kontakt Formular'),
(169, 'page/site', 'site web', 'website', 'website', 'Webseite'),
(170, 'group/musicians_title', 'musiciens', 'muzikanten', 'musicians', 'Musiker'),
(171, 'swingshift/concert/ADM/title', 'Salle Eekhoorn à Hoeilaart - Avec ADM Big Band (Tubize)', 'Zaal Eekhoorn in Hoeilaart - Met ADM Big Band (Tubize)', 'Eekhoorn hall in Hoeilaart - With ADM Big Band (Tubize)', 'Eekhoorn halle in Hoeilaart - Mit ADM Big Band (Tubize)'),
(172, 'word_title', 'titre', 'titel', 'title', 'titel'),
(173, 'word_author', 'auteur', 'schrijver', 'author', 'autor'),
(174, 'word_description', 'description', 'beschrijving', 'description', 'beschreibung'),
(175, 'word_number', 'numero', 'nummer', 'number', 'nummer'),
(176, 'page/sign_in', 'connexion', 'connectie', 'connexion', 'connect'),
(177, 'page/sign_up', 'inscription', 'inscription', 'inscription', 'inscription'),
(178, 'view_gallery', 'Voir la galerie', 'Zie de galerij', 'See the gallery', 'Siehe die galerie'),
(179, 'word_price', 'prix', 'prijs', 'price', 'preis'),
(180, 'word_reservation', 'réservation', 'boeking', 'booking', 'buchung'),
(181, 'word_planner', 'organisateur', 'organisator', 'organizer', 'veranstalter'),
(182, 'word_tel', 'tel', 'telefoon', 'phone', 'telefon'),
(183, 'word_gsm', 'gsm', 'gsm', 'gsm', 'gsm'),
(184, 'word_last_update', 'dernière modification', 'laatste aanpassing', 'last modification', 'letzte Änderung'),
(185, 'description/concert_20_ans', '<div class=fr>\r\n	<p>Chers amis,</p>\r\n	<p>En 2014, Swing Shift existe depuis 20 ans !</p>\r\n	<p>Pour fêter celà, nous organisons un concert anniversaire le 17 mai 2014 en la salle du Centre Culturel Felix Sohie, Gemeenteplein 39 à 1560 Hoeilaart.</p>\r\n	<p>Le Swing Shift Big Band vous proposera à cette occasion un répertoire swing, comportant des classiques mais aussi des morceaux plus contemporains.</p>\r\n	<p>Nous vous invitons à venir fêter cet événement avec nous.</p>\r\n	<p>La cafétaria sera ouverte dès 18h30, la salle sera accessible à partir de 19h30, et le concert débutera à 20h précise.</p>\r\n	<p>Vous pouvez vous procurer les cartes d\'entrée directement auprès des musiciens, ou à la caisse du Centre Culturel Felix Sohie (10eur en prévente - 12eur à la caisse le jour du concert). Etant donné le nombre limité de places, nous vous conseillons de faire vos réservations dès que possible.</p>\r\n	<p>Nous nous réjouissons de vous accueillir nombreux.</p>\r\n	<p>Salutations musicales,</p>\r\n	<p>La direction.</p>\r\n</div>', '<div class=nl>\r\n	<p>Lieve vrienden,</p>\r\n	<p>In 2014 bestaat Swing Shift 20 jaar !</p>\r\n	<p>Om dit te vieren organiseren we op 17 mei 2014 een jubileumconcert in de hal van het Felix Sohie Cultureel Centrum, Gemeenteplein 39 te 1560 Hoeilaart.</p>\r\n	<p>De Swing Shift Big Band biedt je bij deze gelegenheid een swingrepertoire, met klassiekers maar ook meer eigentijdse stukken.</p>\r\n	<p>We nodigen je uit om dit evenement met ons te komen vieren.</p>\r\n	<p>De cafetaria is open vanaf 18.30 uur, de zaal is vanaf 19.30 uur toegankelijk en het concert begint stipt om 20.00 uur.</p>\r\n	<p>Je kunt de tickets rechtstreeks bij de muzikanten krijgen, of aan het loket van het Centre Culturel Felix Sohie (10 euro in voorverkoop - 12 euro aan het loket op de dag van het concert). Gezien het beperkte aantal plaatsen raden wij u aan om zo snel mogelijk te reserveren.</p>\r\n	<p>We kijken ernaar uit om velen van u te mogen verwelkomen.</p>\r\n	<p>Muzikale groeten,</p>\r\n	<p>De richting.</p>\r\n</div>', '<div class=en>\r\n	<p>Dear friends,</p>\r\n	<p>In 2014, Swing Shift has been around for 20 years !</p>\r\n	<p>To celebrate this, we are organizing an anniversary concert on May 17, 2014 in the hall of the Felix Sohie Cultural Center, Gemeenteplein 39 in 1560 Hoeilaart.</p>\r\n	<p>The Swing Shift Big Band will offer you on this occasion a swing repertoire, including classics but also more contemporary pieces.</p>\r\n	<p>We invite you to come and celebrate this event with us.</p>\r\n	<p>The cafeteria will be open from 6.30 p.m., the hall will be accessible from 7.30 p.m., and the concert will begin at 8 p.m. sharp.</p>\r\n	<p>You can get the tickets directly from the musicians, or at the ticket office of the Center Culturel Felix Sohie (10eur in presale - 12eur at the ticket office on the day of the concert). Given the limited number of places, we advise you to make your reservations as soon as possible.</p>\r\n	<p>We look forward to welcoming many of you.</p>\r\n	<p>Musical greetings,</p>\r\n	<p>The direction.</p>\r\n</div>', '<div class=de>\r\n	<p>Liebe Freunde,</p>\r\n	<p>Im Jahr 2014 gibt es Swing Shift seit 20 Jahren !</p>\r\n	<p>Um dies zu feiern, organisieren wir am 17. Mai 2014 ein Jubiläumskonzert in der Halle des Felix Sohie Kulturzentrums, Gemeenteplein 39, 1560 Hoeilaart.</p>\r\n	<p>Die Swing Shift Big Band bietet Ihnen bei dieser Gelegenheit ein Swing-Repertoire, das Klassiker, aber auch zeitgenössischere Stücke umfasst.</p>\r\n	<p>Wir laden Sie ein, dieses Ereignis mit uns zu feiern.</p>\r\n	<p>Die Cafeteria ist ab 18.30 Uhr geöffnet, der Saal ist ab 19.30 Uhr zugänglich und das Konzert beginnt pünktlich um 20.00 Uhr.</p>\r\n	<p>Sie können die Tickets direkt bei den Musikern oder an der Kasse des Centre Culturel Felix Sohie erhalten (10 Euro im Vorverkauf - 12 Euro an der Kasse am Tag des Konzerts). Aufgrund der begrenzten Anzahl von Plätzen empfehlen wir Ihnen, Ihre Reservierungen so schnell wie möglich vorzunehmen.</p>\r\n	<p>Wir freuen uns, viele von Ihnen begrüßen zu dürfen.</p>\r\n	<p>Musikalische Grüße,</p>\r\n	<p>Die Richtung.</p>\r\n</div>'),
(186, 'swingshift/concert/druivenfeest/title', 'druivenfeest', 'druivenfeest', 'druivenfeest', 'druivenfeest'),
(187, 'description/GC_Felix_Sohie_2016', 'Concert SwingShift Big Band dans la serre de la salle de Felix Sohie.', 'Big Band SwingShift concert in de serre van de zaal van Felix Sohie.', 'Big Band SwingShift concert in the greenhouse of Felix Sohie\'s hall.', 'Big Band SwingShift Konzert im Gewächshaus von Felix Sohies Halle.'),
(188, 'swingshift/concert/GC_Felix_Sohie_2016/title', 'GC Felix Sohie', 'GC Felix Sohie', 'GC Felix Sohie', 'GC Felix Sohie'),
(189, 'word_diary_table_action', 'action', 'actie', 'action', 'aktion'),
(190, 'word_diary_table_id', 'id', 'id', 'id', 'id'),
(191, 'page/gestion_users', 'gestion des utilisateurs', 'Gebruikersbeheer', 'User Management', 'Benutzerverwaltung'),
(192, 'page/gestion_site', 'gestion du site', 'website onderhoud', 'site management', 'site management'),
(193, 'page/gestion_diary', 'gestion de l\'agenda', 'dagboek beheer', 'diary management', 'Tagebuchverwaltung'),
(194, 'page/gestion_gallery', 'gestion des galeries', 'galerijbeheer', 'gallery management', 'Galeriemanagement'),
(195, 'page/gestion_partitions', 'gestion des partitions', 'beheer van muziekbladen', 'music sheet management', 'Notenblattverwaltung'),
(196, 'page/conditions', 'mentions legales', 'voorwaarden', 'terms and conditions', 'Geschäftsbedingungen'),
(197, 'page/news', 'news', 'news', 'news', 'news'),
(198, 'page/sitemap', 'plan du site', 'sitemap', 'sitemap', 'seitenverzeichnis'),
(199, 'diary/no_data', 'Il n\'y a aucune date actuellement !', 'Er zijn momenteel geen data !', 'There are currently no dates !', 'Zur Zeit sind keine Termine vorhanden !'),
(200, 'conditions/h1', 'MENTIONS LEGALES', 'JURIDISCHE KENNISGEVING', 'LEGAL NOTICE', 'IMPRESSUM'),
(201, 'conditions/CG/article1/h2', 'Conditions Générales', 'Voorwaarden', 'Terms and conditions', 'Geschäftsbedingungen'),
(202, 'conditions/CG/article1/h3', 'Préalable et mentions légales', 'Vereisten en juridische kennisgevingen', 'Prerequisites and legal notices', 'Voraussetzungen und rechtliche Hinweise'),
(203, 'conditions/CG/article1/h4-1', 'Le site:', 'De website:', 'The website:', 'Die Webseite:'),
(204, 'conditions/CG/article1/p1', 'Toutes les pages hébergées ou générées sous le nom de domaine swingshift.be et les noms qui lui sont liés, ainsi que le code source et les bases de données qui nourrissent ces pages.', 'Alle pagina\'s die worden gehost of gegenereerd onder de swingshift.be-domeinnaam en daaraan gekoppelde namen, evenals de broncode en databases die deze pagina\'s voeden.', 'All pages hosted or generated under the swingshift.be domain name and names linked to it, as well as the source code and databases that feed these pages.', 'Alle Seiten, die unter dem Domänennamen swingshift.be gehostet oder generiert werden, und die damit verknüpften Namen, sowie der Quellcode und die Datenbanken, die diese Seiten speisen.'),
(205, 'conditions/CG/article1/h4-2', 'Utilisateurs:', 'gebruikers:', 'Users:', 'Benutzer:'),
(206, 'conditions/CG/article1/p2', 'Toute personne physique capable qui crée un compte gratuit sur le site.', 'Elke bekwame natuurlijke persoon die een gratis account aanmaakt op de site.', 'Any capable natural person who creates a free account on the site.', 'Jede fähige natürliche Person, die ein kostenloses Konto auf der Website erstellt.'),
(207, 'conditions/CG/article1/h4-3', 'Le service:', 'De dienst:', 'The service:', 'Der Service:'),
(208, 'conditions/CG/article1/p3', 'Le service rendu par le site, soit: l\'usage d\'une plateforme qui vise à la publication d\'informations (tel que: partitions) à destination aux membres (musiciens) du Swing Shift Big Band.', 'De door de site verleende dienst, te weten: het gebruik van een platform dat zich richt op de publicatie van informatie (zoals: partituren) bestemd voor leden (muzikanten) van de Swing Shift Big Band.', 'The service rendered by the site, namely: the use of a platform which aims at the publication of information (such as: scores) intended for members (musicians) of the Swing Shift Big Band.', 'Der von der Website erbrachte Dienst, nämlich: die Nutzung einer Plattform, die auf die Veröffentlichung von Informationen (z. B. Partituren) abzielt, die für Mitglieder (Musiker) der Swing Shift Big Band bestimmt sind.'),
(209, 'conditions/CG/article1/h4-4', 'L\'éditeur:', 'De bewerker:', 'The editor:', 'Der Editor:'),
(210, 'conditions/CG/article1/p4', 'La personne physique ou morale propriétaire du site, c\'est à dire: propriétaire du nom de domaine et des accès à l\'hébergement et au code sources.', 'De natuurlijke of rechtspersoon die eigenaar is van de site, dat wil zeggen: eigenaar van de domeinnaam en toegang tot hosting en broncode.', 'The natural or legal person who owns the site, ie: owner of the domain name and access to hosting and source code.', 'Die natürliche oder juristische Person, der die Website gehört, dh: Eigentümer des Domainnamens und des Zugriffs auf das Hosting und den Quellcode.'),
(211, 'conditions/CG/article1/p5', 'Le site est actuellement édité par Collart Kevin - Rue Célestin Cherpion, 7 à 1390 Pécrot (Grez-Doiceau), Belgique.', 'De site wordt momenteel bewerkt door Collart Kevin - Rue Célestin Cherpion, 7, 1390 Pécrot (Grez-Doiceau), België.', 'The site is currently edited by Collart Kevin - Rue Célestin Cherpion, 7 at 1390 Pécrot (Grez-Doiceau), Belgium.', 'Die Website wird derzeit bearbeitet von Collart Kevin - Rue Célestin Cherpion, 7, 1390 Pécrot (Grez-Doiceau), Belgien.'),
(212, 'conditions/CG/article2/h3', 'Objet des conditions générales', 'Voorwerp van de algemene voorwaarden', 'Object of the general conditions', 'Gegenstand der Allgemeinen Geschäftsbedingungen'),
(213, 'conditions/CG/article2/p1', 'Les présentes Conditions Générales ont pour objet de définir les termes et conditions dans lesquelles le site swingshift.be fournit des services aux utilisateurs et de poser les règles qui régissent les rapports entre ces derniers et le site swingshift.be.', 'Het doel van deze Algemene Voorwaarden is om de voorwaarden te definiëren waaronder de swingshift.be site diensten verleent aan gebruikers en om de regels vast te leggen die de relatie tussen deze laatste en de swingshift.be site regelen.', 'The purpose of these General Conditions is to define the terms and conditions under which the swingshift.be site provides services to users and to lay down the rules that govern the relationship between the latter and the swingshift.be site.', 'Der Zweck dieser Allgemeinen Geschäftsbedingungen besteht darin, die Bedingungen zu definieren, unter denen die Website swingshift.be den Benutzern Dienstleistungen erbringt, und die Regeln festzulegen, die die Beziehung zwischen letzterer und der Website swingshift.be regeln.'),
(214, 'word_rue', 'rue', 'straat', 'street', 'Straße'),
(215, 'description/concert_21-mai-2023', '<div class=\"fr\">\r\n	<p>Le Swing Shift Big Band mené par Jean-Marie Ganhy, accompagné de la chanteuse Erica, propose une programmation très variée.</p>\r\n	<p>Vous pourrez profiter d\'un certain nombre de classiques du Big Band et du Jazz tels que Duke Ellington, Lennie Niehaus, Glenn Miller, Sammy Nestico, Carlos Jobim, Frank Foster etc.</p>\r\n	<p>Le Big Band joue également des arrangements surprenants développés pour le Big Band.</p>\r\n</div>', '<div class=\"nl\">\r\n	<p>De Swing Shift Big Band o.l.v. Jean-Marie Ganhy brengt samen met zangeres Erica een zeer gevarieerd programma.</p>\r\n	<p>Je zal kunnen genieten van een aantal Big Band en Jazzklassiekers zoal s van Duke Ellington, Lennie Niehaus, Glenn Miller, Sammy Nestico, Carlos Jobim, Frank Foster etc.</p>\r\n	<p>Ook speelt de Big Band enkele verrassende arrangementen uitgewerkt voor Big Band.</p>\r\n</div>', '<div class=\"en\">\r\n	<p>The Swing Shift Big Band led by Jean-Marie Ganhy, together with singer Erica, brings a very varied program.</p>\r\n	<p>You will be able to enjoy a number of Big Band and Jazz classics such as Duke Ellington, Lennie Niehaus, Glenn Miller, Sammy Nestico, Carlos Jobim, Frank Foster etc.</p>\r\n	<p>The Big Band also plays some surprising arrangements developed for Big Band.</p>\r\n</div>', '<div class=\"de\">\r\n	<p>Die Swing Shift Big Band unter der Leitung von Jean-Marie Ganhy bringt zusammen mit der Sängerin Erica ein sehr abwechslungsreiches Programm.</p>\r\n	<p>Sie werden eine Reihe von Big Band- und Jazz-Klassikern wie Duke Ellington, Lennie Niehaus, Glenn Miller, Sammy Nestico, Carlos Jobim, Frank Foster usw. genießen können.</p>\r\n	<p>Die Big Band spielt auch einige überraschende Arrangements, die für Big Band entwickelt wurden.</p>\r\n</div>'),
(216, 'swingshift/concert/21mai2023/title', 'Swing Shift Big Band en concert, sous la direction de Jean-Marie Ganhy', 'Swing Shift Big Band in concert, o.l.v. Jean-Marie Ganhy', 'Swing Shift Big Band in concert, conducted by Jean-Marie Ganhy', 'Konzert der Swing Shift Big Band unter der Leitung von Jean-Marie Ganhy');

-- --------------------------------------------------------

--
-- Structure de la table `swing_url`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_url` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `url` text COLLATE utf8_bin NOT NULL,
  `auth_id` int(10) UNSIGNED NOT NULL,
  `target` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_url`
--

INSERT INTO `swing_url` (`id`, `name`, `url`, `auth_id`, `target`, `active`, `description`) VALUES
(1, NULL, 'img/icon/Flag_of_Belgium.svg', 2, '_self', 1, 'flag'),
(2, NULL, 'img/icon/Flag_of_Flanders.svg', 2, '_self', 1, 'flag'),
(3, NULL, 'img/icon/Flag_of_France.svg', 2, '_self', 1, 'flag'),
(4, NULL, 'img/icon/Flag_of_Germany.svg', 2, '_self', 1, 'flag'),
(5, NULL, 'img/icon/Flag_of_the_Netherlands.svg', 2, '_self', 1, 'flag'),
(6, NULL, 'img/icon/Flag_of_the_United_Kingdom.svg', 2, '_self', 1, 'flag'),
(7, NULL, 'img/icon/Flag_of_the_United_States.svg', 2, '_self', 1, 'flag'),
(8, NULL, 'img/icon/Flag_of_Wallonia.svg', 2, '_self', 1, 'flag'),
(9, 'home', './', 2, '_self', 1, 'page d\'accueil'),
(10, 'group', '?page=group', 2, '_self', 1, 'page presentation du groupe'),
(11, 'diary', '?page=diary', 2, '_self', 1, 'page des évenements concert et autres dates de prestations'),
(12, 'gallery', '?page=gallery', 2, '_self', 0, 'pages des galeries souvenir'),
(13, 'demos', '?page=demos', 2, '_self', 1, 'page des demos du groupe (sons et videos)'),
(14, 'technical', '?page=technical', 2, '_self', 1, 'page des elements technique du groupe'),
(15, 'contact', '?page=contact', 2, '_self', 1, 'page de contact avec formulaire'),
(16, 'home_img_group', 'img/home/GROEP_2022.jpg', 2, NULL, 1, 'image'),
(17, 'more_infos', '?page=group', 2, '_self', 1, 'plus d\'infos'),
(18, 'conditions', '?page=conditions', 2, '_self', 1, 'mentions legales'),
(19, 'sitemap', '?page=sitemap', 2, '_self', 1, 'plan du site'),
(20, NULL, 'img/technical/grondplan.png', 2, NULL, 1, 'image'),
(21, 'musicos/conductor', 'img/musician/conductor/web_Ivo_Hendrickx.jpg', 2, NULL, 1, 'Ivo Hendrickx'),
(22, 'musicos/bass', 'img/musician/rythm/web_Adolfo.jpg', 2, NULL, 1, 'Adolfo'),
(23, 'musicos/prq', 'img/musician/rythm/web_Kevin.jpg', 2, NULL, 1, 'Collart Kevin'),
(24, 'musicos/p', 'img/musician/rythm/web_louis.jpg', 2, NULL, 1, 'Bougiaki Louis'),
(25, 'musicos/d', 'img/musician/rythm/web_Jan_2022.jpg', 2, NULL, 1, 'Jan'),
(26, 'poster/concert_20ans', 'img/affiches/swingshift_20ans.jpg', 2, NULL, 1, 'affiche de concert'),
(27, NULL, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d630.8449315731445!2d4.473388053427963!3d50.76853406311386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3da0d0436dacf%3A0xc4f9fe975b2f2574!2sGemeenschapscentrum%20Felix%20Sohie!5e0!3m2!1sfr!2sbe!4v1598687476343!5m2!1sfr!2sbe', 2, NULL, 1, NULL),
(28, 'profil', '?page=profil', 3, 'self', 0, 'page profil ou mon compte'),
(29, 'admin', '?mode=admin&page=admin', 1, 'self', 0, 'page administration home'),
(30, 'partitions', '?page=partitions', 5, 'self', 0, 'partitions page'),
(31, 'gallery_img_2013_felix_sohie_zaal', 'img/gallery/2013/felix_sohie_zaal', 2, 'self', 1, 'dossier des images'),
(32, 'gallery_img_2014_20_ans_swingshift_big_band', 'img/gallery/2014/20_ans_swingshift_big_band', 2, 'self', 1, NULL),
(33, 'rezal_facebook', 'https://www.facebook.com/swingshiftbigb/', 2, '_blank', 1, 'lien facebook'),
(34, 'rezal_youtube', 'https://www.youtube.com/watch?v=5rzYgaUmIfA', 2, '_blank', 0, 'lien youtube demo swing shift big band'),
(35, 'musicos/tb2', 'img/musician/bone/web_Edward.jpg', 2, NULL, 1, 'Edward'),
(36, 'musicos/tb4', 'img/musician/bone/web_Marc.jpg', 2, NULL, 1, 'Marc Collart'),
(37, 'musicos/tb3', 'img/musician/bone/web_Philippe.jpg', 2, NULL, 1, 'Philippe Colon'),
(38, 'musicos/tb1', 'img/musician/bone/web_Simon.jpg', 2, NULL, 1, 'Simon'),
(39, 'musicos/sa1', 'img/musician/sax/web_Augustijn.jpg', 2, NULL, 1, 'Augustiln'),
(40, 'musicos/sa2', 'img/musician/sax/web_Michel.jpg', 2, NULL, 1, 'Michel'),
(41, 'musicos/st1', 'img/musician/sax/web_Klaus.jpg', 2, NULL, 1, 'Klaus'),
(42, 'musicos/st2', 'img/musician/sax/web_Michel_B.jpg', 2, NULL, 1, 'Michel Boucquey'),
(43, 'musicos/sb', 'img/musician/sax/web_Alex.jpg', 2, NULL, 1, 'Alex Puttemans'),
(44, 'musicos/tp1', 'img/musician/web_square_anonymous.jpg', 2, NULL, 1, 'Wanted trumpet 1'),
(45, 'musicos/tp2', 'img/musician/trumpet/web_Jean-Marie.jpg', 2, NULL, 1, 'Jean-Marie Ganhy'),
(46, 'musicos/tp3', 'img/musician/trumpet/web_stef_2022.jpg', 2, NULL, 1, 'Stephane Dehanschutter'),
(47, 'musicos/tp4', 'img/musician/trumpet/web_Frank.jpg', 2, NULL, 1, 'Frank'),
(48, 'musicos/chf', 'img/musician/vocal/web_Erica.jpg', 2, NULL, 1, 'Erica'),
(49, 'musicos/chm', 'img/musician/vocal/web_Youri.jpg', 2, NULL, 1, 'Youri'),
(50, 'poster/concertADM', 'img/affiches/concert oct 2016.png', 2, NULL, 1, 'affiche de concert'),
(51, 'JS/group', 'js/group.js', 2, NULL, 1, 'resize img'),
(52, 'resarvation/concert_20_ans/test', 'https//:swingshift-examen.be?page=reservation', 2, '_blank', 1, 'test affichage pour reservation via diary'),
(53, 'poster/GC_Felix_Sohie_2016', 'img/affiches/67b208aff1-BBaffiche-2016.jpg', 2, NULL, 1, 'affiche concert GC Felix Sohie (serre) 2016'),
(54, 'gestion_users', '?mode=admin&page=gestion_users', 6, NULL, 0, 'gestion des utilisateurs'),
(55, 'gestion_diary', '?mode=admin&page=gestion_diary', 1, NULL, 0, 'gestion agenda'),
(56, 'gestion_gallery', '?mode=admin&page=gestion_gallery', 1, NULL, 0, 'gestion gallery'),
(57, 'gestion_partitions', '?mode=admin&page=gestion_partitions', 1, NULL, 0, 'gestion partitions (CRUD)'),
(58, 'gestion_site', '?mode=admin&page=gestion_site', 1, NULL, 0, 'gestion site (CMS)'),
(59, 'sign_out', '?action=destroy', 3, NULL, 0, 'se deconnecter'),
(60, 'site_swing_shift_complet_url', 'https//:swingshift-examen.be', 2, '_blank', 1, 'lien complet pour le site du swingshift big band de hoeilaart de belgique'),
(61, 'logo_swingshift', './logo.jpg', 2, NULL, 1, 'logo du group swingshift'),
(62, 'sign_in', '?page=sign_in', 2, NULL, 0, 'connexion au site'),
(63, 'sign_up', '?page=sign_up', 2, NULL, 0, 's\'enregistrer sur le site'),
(64, 'news_sign_up', '?page=news', 2, NULL, 0, 'inscription a la newsletter'),
(65, 'gallery/20ans/img_1_web', 'img/gallery/2014/20_ans_swingshift_big_band/0a0e8516a4-SWING SHIFT BIGBAND 2014-6368.jpg', 2, NULL, 1, 'format web'),
(66, NULL, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d890.5798552184491!2d4.348552110951523!3d50.85079127412177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3c3864d4667e1%3A0x77729c9af80df0da!2sPl.%20Sainte-Catherine%2C%201000%20Bruxelles!5e0!3m2!1sfr!2sbe!4v1646849577728!5m2!1sfr!2sbe', 2, NULL, 1, 'place St-catherine Maatjes'),
(67, NULL, 'https://noordzeemerdunord.be/events/?lang=fr', 2, '_blank', 1, 'Noordzee siteweb/event'),
(68, 'google_map/druivenfeet/overijs', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d446.03279878574807!2d4.5374999097744615!3d50.77293132099843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3d9ab32dec241%3A0x3fbea692c1e3554d!2sParking%20Kerk!5e0!3m2!1sfr!2sbe!4v1656036675014!5m2!1sfr!2sbe', 2, NULL, 1, 'place de l\'eglise overijs'),
(69, 'druivenfeest/2022', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2523.3092262961236!2d4.5349411159047825!3d50.769841072180206!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3d9ce4d3b496f%3A0x57b650ac21789dc6!2sBegijnhof%2011%2C%203090%20Overijse!5e0!3m2!1sfr!2sbe!4v1661026437334!5m2!1sfr!2sbe', 2, NULL, 1, 'druivenfeest overijs 2022 (Bgijnhof 11, 3090, Overijs)'),
(70, 'event_planner_siteweb', 'https://www.overijse.be/thema/detail/200/programma', 2, '_blank', 1, 'site overijs programme druivenfeest 2022'),
(71, 'concert/21-mai-2023/reservation', 'https://apps.ticketmatic.com/widgets/den_blank/addtickets?accesskey=4b1010ceb643ecc95f3d72b8&event=17930&flow=returnorcheckout&l=fr&returnurl=http%3A%2F%2Fticketshop.ticketmatic.com%2Fden_blank%2Ffelixsohie%2Freturn%3Fl%3Dfr&saleschannelid=10000&signature=50af133559bf2a039064acda6979af1dfb572df75f9d40dbde573c741574de61&skinid=10002#!/addtickets', 2, NULL, 1, NULL),
(72, 'google_map/salle-felix-sohie', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2523.3981568596228!2d4.471755615904715!3d50.768192372299524!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3da0d0688cc0d%3A0x4b0a0a3c2a9a5fab!2sGemeenteplein%2039%2C%201560%20Hoeilaart!5e0!3m2!1sfr!2sbe!4v1673619810035!5m2!1sfr!2sbe', 2, NULL, 1, NULL),
(73, 'hamburger_menu', 'img/site/hamburger.png', 2, NULL, 1, 'icon du menu hamburger en blanc et transparent');

-- --------------------------------------------------------

--
-- Structure de la table `swing_users`
--
-- Création : lun. 20 mars 2023 à 23:29
--

CREATE TABLE `swing_users` (
  `id` int(20) UNSIGNED NOT NULL,
  `pseudo_id` int(20) UNSIGNED DEFAULT NULL,
  `email_id` int(20) UNSIGNED NOT NULL,
  `firstname_id` int(20) UNSIGNED DEFAULT NULL,
  `lastname_id` int(20) UNSIGNED DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `picture_id` int(20) UNSIGNED DEFAULT NULL,
  `birthday_id` int(20) UNSIGNED DEFAULT NULL,
  `address_id` int(20) UNSIGNED DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `account_type_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `lang_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `status_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `auth_id` int(10) UNSIGNED NOT NULL DEFAULT '4',
  `ip_id` int(20) UNSIGNED NOT NULL,
  `tel_id` int(20) UNSIGNED DEFAULT NULL,
  `gsm_id` int(20) UNSIGNED DEFAULT NULL,
  `conditions` tinyint(1) NOT NULL DEFAULT '1',
  `token` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_bin,
  `last_connexion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `swing_users`
--

INSERT INTO `swing_users` (`id`, `pseudo_id`, `email_id`, `firstname_id`, `lastname_id`, `password`, `picture_id`, `birthday_id`, `address_id`, `group_id`, `account_type_id`, `lang_id`, `status_id`, `auth_id`, `ip_id`, `tel_id`, `gsm_id`, `conditions`, `token`, `active`, `description`, `last_connexion`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 26, 27, '$2y$12$FkwBpcTwz.LDw63eYjUfi.4.2sfyRk2mKimmvlOPpP/fPtyR2aVKy', NULL, NULL, 2, 1, 1, 6, 1, 6, 1, 1, 1, 1, NULL, 1, 'admin webmaster, percussionniste et batteur', '2020-09-10 02:07:52', '2020-09-10 02:07:52', '2021-05-17 09:52:16');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `swing_account_type`
--
ALTER TABLE `swing_account_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Index pour la table `swing_address`
--
ALTER TABLE `swing_address`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_arranger`
--
ALTER TABLE `swing_arranger`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_authorization`
--
ALTER TABLE `swing_authorization`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `auth` (`auth`);

--
-- Index pour la table `swing_authors`
--
ALTER TABLE `swing_authors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_birthday`
--
ALTER TABLE `swing_birthday`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`);

--
-- Index pour la table `swing_content_page`
--
ALTER TABLE `swing_content_page`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_continents`
--
ALTER TABLE `swing_continents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `swing_currency`
--
ALTER TABLE `swing_currency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currency` (`currency`);

--
-- Index pour la table `swing_diary`
--
ALTER TABLE `swing_diary`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_district`
--
ALTER TABLE `swing_district`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_email`
--
ALTER TABLE `swing_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `swing_functions_group`
--
ALTER TABLE `swing_functions_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `swing_gallery`
--
ALTER TABLE `swing_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_gallery_img`
--
ALTER TABLE `swing_gallery_img`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_group`
--
ALTER TABLE `swing_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_gsm`
--
ALTER TABLE `swing_gsm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gsm` (`gsm`);

--
-- Index pour la table `swing_head_of_desk`
--
ALTER TABLE `swing_head_of_desk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `swing_instruments`
--
ALTER TABLE `swing_instruments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `swing_instrument_type`
--
ALTER TABLE `swing_instrument_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_ip`
--
ALTER TABLE `swing_ip`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`);

--
-- Index pour la table `swing_land`
--
ALTER TABLE `swing_land`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `land` (`land`);

--
-- Index pour la table `swing_lang`
--
ALTER TABLE `swing_lang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `abvr` (`abvr`);

--
-- Index pour la table `swing_members`
--
ALTER TABLE `swing_members`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_menu`
--
ALTER TABLE `swing_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `swing_musicsheet`
--
ALTER TABLE `swing_musicsheet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_id` (`title_id`);

--
-- Index pour la table `swing_musicsheet_num`
--
ALTER TABLE `swing_musicsheet_num`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_musicsheet_title`
--
ALTER TABLE `swing_musicsheet_title`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Index pour la table `swing_name`
--
ALTER TABLE `swing_name`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `swing_newsletters`
--
ALTER TABLE `swing_newsletters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- Index pour la table `swing_pages`
--
ALTER TABLE `swing_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page` (`page`);

--
-- Index pour la table `swing_pseudo`
--
ALTER TABLE `swing_pseudo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Index pour la table `swing_status`
--
ALTER TABLE `swing_status`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_street`
--
ALTER TABLE `swing_street`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `street` (`street`);

--
-- Index pour la table `swing_street_type`
--
ALTER TABLE `swing_street_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_styles`
--
ALTER TABLE `swing_styles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_task`
--
ALTER TABLE `swing_task`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_tel`
--
ALTER TABLE `swing_tel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tel` (`tel`);

--
-- Index pour la table `swing_tone`
--
ALTER TABLE `swing_tone`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `US` (`US`);

--
-- Index pour la table `swing_town`
--
ALTER TABLE `swing_town`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `town` (`town`);

--
-- Index pour la table `swing_trad`
--
ALTER TABLE `swing_trad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `select` (`trad`);

--
-- Index pour la table `swing_url`
--
ALTER TABLE `swing_url`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `swing_users`
--
ALTER TABLE `swing_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `swing_account_type`
--
ALTER TABLE `swing_account_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `swing_address`
--
ALTER TABLE `swing_address`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `swing_arranger`
--
ALTER TABLE `swing_arranger`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `swing_authorization`
--
ALTER TABLE `swing_authorization`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `swing_authors`
--
ALTER TABLE `swing_authors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `swing_birthday`
--
ALTER TABLE `swing_birthday`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `swing_content_page`
--
ALTER TABLE `swing_content_page`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `swing_continents`
--
ALTER TABLE `swing_continents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `swing_currency`
--
ALTER TABLE `swing_currency`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `swing_diary`
--
ALTER TABLE `swing_diary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `swing_district`
--
ALTER TABLE `swing_district`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `swing_email`
--
ALTER TABLE `swing_email`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `swing_functions_group`
--
ALTER TABLE `swing_functions_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `swing_gallery`
--
ALTER TABLE `swing_gallery`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `swing_gallery_img`
--
ALTER TABLE `swing_gallery_img`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `swing_group`
--
ALTER TABLE `swing_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `swing_gsm`
--
ALTER TABLE `swing_gsm`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `swing_head_of_desk`
--
ALTER TABLE `swing_head_of_desk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `swing_instruments`
--
ALTER TABLE `swing_instruments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `swing_instrument_type`
--
ALTER TABLE `swing_instrument_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `swing_ip`
--
ALTER TABLE `swing_ip`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `swing_land`
--
ALTER TABLE `swing_land`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `swing_lang`
--
ALTER TABLE `swing_lang`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `swing_members`
--
ALTER TABLE `swing_members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `swing_menu`
--
ALTER TABLE `swing_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `swing_musicsheet`
--
ALTER TABLE `swing_musicsheet`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `swing_musicsheet_num`
--
ALTER TABLE `swing_musicsheet_num`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `swing_musicsheet_title`
--
ALTER TABLE `swing_musicsheet_title`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `swing_name`
--
ALTER TABLE `swing_name`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `swing_newsletters`
--
ALTER TABLE `swing_newsletters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `swing_pages`
--
ALTER TABLE `swing_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `swing_pseudo`
--
ALTER TABLE `swing_pseudo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `swing_status`
--
ALTER TABLE `swing_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `swing_street`
--
ALTER TABLE `swing_street`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `swing_street_type`
--
ALTER TABLE `swing_street_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `swing_styles`
--
ALTER TABLE `swing_styles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `swing_task`
--
ALTER TABLE `swing_task`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `swing_tel`
--
ALTER TABLE `swing_tel`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `swing_tone`
--
ALTER TABLE `swing_tone`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `swing_town`
--
ALTER TABLE `swing_town`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `swing_trad`
--
ALTER TABLE `swing_trad`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT pour la table `swing_url`
--
ALTER TABLE `swing_url`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT pour la table `swing_users`
--
ALTER TABLE `swing_users`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
