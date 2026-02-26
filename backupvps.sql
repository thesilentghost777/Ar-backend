/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.1-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ANGER
-- ------------------------------------------------------
-- Server version	11.8.1-MariaDB-4

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
-- Table structure for table `auto_ecole_notifications`
--

DROP TABLE IF EXISTS `auto_ecole_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `auto_ecole_notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `titre` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','succes','alerte','paiement','cours','parrainage') NOT NULL,
  `lu` tinyint(1) NOT NULL DEFAULT 0,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auto_ecole_notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `auto_ecole_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auto_ecole_notifications`
--

LOCK TABLES `auto_ecole_notifications` WRITE;
/*!40000 ALTER TABLE `auto_ecole_notifications` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `auto_ecole_notifications` VALUES
(1,1,'Nouveau filleul !','Ls Test User s\'est inscrit avec votre code de parrainage.','parrainage',0,'[]','2026-02-24 07:41:36','2026-02-24 07:41:36'),
(2,1,'Nouveau filleul !','Moratl Track s\'est inscrit avec votre code de parrainage.','parrainage',0,'[]','2026-02-25 07:44:56','2026-02-25 07:44:56'),
(3,1,'Nouveau filleul !','Yzy Tracj s\'est inscrit avec votre code de parrainage.','parrainage',0,'[]','2026-02-25 08:18:15','2026-02-25 08:18:15'),
(4,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz - Définitions et concepts de base\" avec 20/20','cours',0,'[]','2026-02-25 08:38:32','2026-02-25 08:38:32'),
(5,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz - Organes et dispositifs du véhicule\" avec 12/20','cours',0,'[]','2026-02-25 08:40:54','2026-02-25 08:40:54'),
(6,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz - Signalisation routière\" avec 14/20','cours',0,'[]','2026-02-25 08:54:43','2026-02-25 08:54:43'),
(7,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz - Règles de circulation routière\" avec 14/20','cours',0,'[]','2026-02-25 08:56:25','2026-02-25 08:56:25'),
(8,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz - Règles administratives\" avec 14/20','cours',0,'[]','2026-02-25 08:59:43','2026-02-25 08:59:43'),
(9,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz - Responsabilité civile et pénale\" avec 20/20','cours',0,'[]','2026-02-25 09:00:56','2026-02-25 09:00:56'),
(10,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – S\'installer au poste de conduite\" avec 20/20','cours',0,'[]','2026-02-25 09:13:07','2026-02-25 09:13:07'),
(11,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Regarder autour de soi\" avec 16/20','cours',0,'[]','2026-02-25 09:17:26','2026-02-25 09:17:26'),
(12,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Agir sans mettre en danger\" avec 18/20','cours',0,'[]','2026-02-25 09:18:38','2026-02-25 09:18:38'),
(13,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Avertir les autres usagers\" avec 20/20','cours',0,'[]','2026-02-25 09:19:50','2026-02-25 09:19:50'),
(14,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Démarrer et s\'arrêter\" avec 18/20','cours',0,'[]','2026-02-25 09:21:25','2026-02-25 09:21:25'),
(15,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Tenue du volant en ligne droite\" avec 14/20','cours',0,'[]','2026-02-25 09:22:02','2026-02-25 09:22:02'),
(16,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Rotation du volant\" avec 20/20','cours',0,'[]','2026-02-25 09:22:53','2026-02-25 09:22:53'),
(17,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Utilisation de l\'embrayage\" avec 14/20','cours',0,'[]','2026-02-25 09:24:54','2026-02-25 09:24:54'),
(18,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Utilisation des freins\" avec 16/20','cours',0,'[]','2026-02-25 09:30:45','2026-02-25 09:30:45'),
(19,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Utilisation de la boîte de vitesses\" avec 14/20','cours',0,'[]','2026-02-25 09:31:46','2026-02-25 09:31:46'),
(20,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Diriger la voiture en avant\" avec 14/20','cours',0,'[]','2026-02-25 09:33:17','2026-02-25 09:33:17'),
(21,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Diriger la voiture en arrière\" avec 18/20','cours',0,'[]','2026-02-25 09:48:13','2026-02-25 09:48:13'),
(22,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Ranger la voiture\" avec 20/20','cours',0,'[]','2026-02-25 09:49:15','2026-02-25 09:49:15'),
(23,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Lecture de la notice constructeur\" avec 16/20','cours',0,'[]','2026-02-25 09:49:54','2026-02-25 09:49:54'),
(24,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Changement de roue et ampoule\" avec 18/20','cours',0,'[]','2026-02-25 09:50:36','2026-02-25 09:50:36'),
(25,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Aides à la conduite et conduite économique\" avec 14/20','cours',0,'[]','2026-02-25 09:52:59','2026-02-25 09:52:59'),
(26,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Prévisions et situations d\'urgence\" avec 12/20','cours',0,'[]','2026-02-25 09:54:05','2026-02-25 09:54:05'),
(27,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Règles de circulation et signalisation\" avec 18/20','cours',0,'[]','2026-02-25 09:55:21','2026-02-25 09:55:21'),
(28,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Vitesse et voie de circulation\" avec 18/20','cours',0,'[]','2026-02-25 09:56:09','2026-02-25 09:56:09'),
(29,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Distances de sécurité et intersections\" avec 18/20','cours',0,'[]','2026-02-25 09:57:05','2026-02-25 09:57:05'),
(30,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Dépassement, croisement et virages\" avec 20/20','cours',0,'[]','2026-02-25 09:57:52','2026-02-25 09:57:52'),
(31,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Arrêt, stationnement et usagers\" avec 18/20','cours',0,'[]','2026-02-25 09:58:41','2026-02-25 09:58:41'),
(32,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Conditions particulières de conduite\" avec 14/20','cours',0,'[]','2026-02-25 09:59:34','2026-02-25 09:59:34'),
(33,4,'Quiz réussi!','Félicitations! Vous avez réussi le quiz \"Quiz – Alcool, accidents et facteurs de risque\" avec 18/20','cours',0,'[]','2026-02-25 10:00:30','2026-02-25 10:00:30');
/*!40000 ALTER TABLE `auto_ecole_notifications` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `auto_ecole_paiements`
--

DROP TABLE IF EXISTS `auto_ecole_paiements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `auto_ecole_paiements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `destinataire_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `type_paiement` varchar(255) DEFAULT NULL,
  `methode` varchar(255) DEFAULT NULL,
  `methode_paiement` varchar(255) DEFAULT NULL,
  `montant` decimal(12,2) NOT NULL,
  `solde_avant` decimal(12,2) NOT NULL DEFAULT 0.00,
  `solde_apres` decimal(12,2) NOT NULL DEFAULT 0.00,
  `transaction_id` varchar(255) DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `transaction_externe` varchar(255) DEFAULT NULL,
  `token_pay` varchar(255) DEFAULT NULL,
  `tranche` varchar(255) DEFAULT NULL,
  `frais_type` varchar(255) DEFAULT NULL,
  `statut` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'en_attente',
  `description` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `date_paiement` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auto_ecole_paiements_reference_unique` (`reference`),
  KEY `auto_ecole_paiements_user_id_foreign` (`user_id`),
  KEY `auto_ecole_paiements_destinataire_id_foreign` (`destinataire_id`),
  KEY `auto_ecole_paiements_transaction_id_index` (`transaction_id`),
  CONSTRAINT `auto_ecole_paiements_destinataire_id_foreign` FOREIGN KEY (`destinataire_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `auto_ecole_paiements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auto_ecole_paiements`
--

LOCK TABLES `auto_ecole_paiements` WRITE;
/*!40000 ALTER TABLE `auto_ecole_paiements` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `auto_ecole_paiements` VALUES
(1,2,NULL,'depot',NULL,'code_caisse',NULL,10000.00,0.00,10000.00,NULL,'REF-20260225082359-154649F8',NULL,NULL,NULL,NULL,NULL,'valide','Dépôt via Code Caisse - CC-2B947E32FB',NULL,NULL,'2026-02-25 07:23:59','2026-02-25 07:23:59'),
(2,2,NULL,'paiement_frais',NULL,'systeme',NULL,10000.00,10000.00,0.00,NULL,'REF-20260225082853-8CB392C1',NULL,NULL,NULL,'formation',NULL,'valide','Frais de formation',NULL,NULL,'2026-02-25 07:28:53','2026-02-25 07:28:53'),
(7,3,NULL,'depot',NULL,'code_caisse',NULL,10000.00,0.00,10000.00,NULL,'REF-20260225085654-6689D6DF',NULL,NULL,NULL,NULL,NULL,'valide','Dépôt via Code Caisse - CC-EDE87B7A98',NULL,NULL,'2026-02-25 07:56:54','2026-02-25 07:56:54'),
(13,4,NULL,'depot',NULL,'code_caisse',NULL,10000.00,0.00,10000.00,NULL,'REF-20260225091924-99C24D00',NULL,NULL,NULL,NULL,NULL,'valide','Dépôt via Code Caisse - CC-3541412738',NULL,NULL,'2026-02-25 08:19:24','2026-02-25 08:19:24'),
(14,4,NULL,'paiement_frais',NULL,'systeme',NULL,10000.00,10000.00,0.00,NULL,'REF-20260225092011-D9D888C4',NULL,NULL,NULL,'formation',NULL,'valide','Frais de formation',NULL,NULL,'2026-02-25 08:20:11','2026-02-25 08:20:11');
/*!40000 ALTER TABLE `auto_ecole_paiements` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `auto_ecole_users`
--

DROP TABLE IF EXISTS `auto_ecole_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `auto_ecole_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `quartier` varchar(255) DEFAULT NULL,
  `type_permis` enum('permis_a','permis_b','permis_t') NOT NULL DEFAULT 'permis_b',
  `type_cours` enum('en_ligne','presentiel','les_deux') NOT NULL DEFAULT 'en_ligne',
  `vague` enum('1','2') NOT NULL DEFAULT '1',
  `session_id` bigint(20) unsigned DEFAULT NULL,
  `centre_examen_id` bigint(20) unsigned DEFAULT NULL,
  `code_parrainage` varchar(255) NOT NULL,
  `parrain_id` bigint(20) unsigned DEFAULT NULL,
  `niveau_parrainage` int(11) NOT NULL DEFAULT -1,
  `solde` decimal(12,2) NOT NULL DEFAULT 0.00,
  `validated` tinyint(1) NOT NULL DEFAULT 0,
  `cours_debloques` tinyint(1) NOT NULL DEFAULT 0,
  `status_frais_formation` enum('non_paye','paye','dispense') NOT NULL DEFAULT 'non_paye',
  `status_frais_inscription` enum('non_paye','paye','dispense') NOT NULL DEFAULT 'non_paye',
  `status_examen_blanc` enum('non_paye','paye','dispense') NOT NULL DEFAULT 'non_paye',
  `status_frais_examen` enum('non_paye','paye','dispense') NOT NULL DEFAULT 'non_paye',
  `description_paiement_formation` text DEFAULT NULL,
  `description_paiement_inscription` text DEFAULT NULL,
  `description_paiement_examen_blanc` text DEFAULT NULL,
  `description_paiement_examen` text DEFAULT NULL,
  `premier_depot_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auto_ecole_users_telephone_unique` (`telephone`),
  UNIQUE KEY `auto_ecole_users_code_parrainage_unique` (`code_parrainage`),
  KEY `auto_ecole_users_session_id_foreign` (`session_id`),
  KEY `auto_ecole_users_centre_examen_id_foreign` (`centre_examen_id`),
  KEY `auto_ecole_users_parrain_id_foreign` (`parrain_id`),
  CONSTRAINT `auto_ecole_users_centre_examen_id_foreign` FOREIGN KEY (`centre_examen_id`) REFERENCES `centres_examen` (`id`) ON DELETE SET NULL,
  CONSTRAINT `auto_ecole_users_parrain_id_foreign` FOREIGN KEY (`parrain_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `auto_ecole_users_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions1` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auto_ecole_users`
--

LOCK TABLES `auto_ecole_users` WRITE;
/*!40000 ALTER TABLE `auto_ecole_users` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `auto_ecole_users` VALUES
(1,'CFPAM','Test','600000001','$2y$12$xUYJMx.IGFy/RUk/bTEkPuxHkh8wAqzUIIU/3.co5kGlw9w4ltYf2',NULL,NULL,'permis_b','en_ligne','1',NULL,NULL,'ANGER-2026-0101001',NULL,-1,0.00,1,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-24 08:40:56','2026-02-24 08:40:56',NULL),
(2,'Test User','Ls','611223344','$2y$12$GFjhxlusJFC0h12kQDylPeJNN56uSEAJ6j9iB8RtkoTojoiTd9Rui',NULL,NULL,'permis_b','en_ligne','1',1,2,'XXCQF2PE',1,-1,0.00,0,1,'paye','non_paye','non_paye','non_paye','Payé le 25/02/2026 à 08:28',NULL,NULL,NULL,'2026-02-25 07:23:59',NULL,'2026-02-24 07:41:36','2026-02-25 07:28:53',NULL),
(3,'Track','Moratl','699887766','$2y$12$a78hqsz4TezlJGpO2kQRkOidhqZml7/gO.YfoLR4BtvYEq/q18DAC',NULL,NULL,'permis_b','en_ligne','1',NULL,2,'6NC1IEBP',1,-1,10000.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,'2026-02-25 07:56:54',NULL,'2026-02-25 07:44:56','2026-02-25 07:56:54',NULL),
(4,'Tracj','Yzy','622334455','$2y$12$dTkNWdElKWsgAf1XL1iTMOlJDMElF3uav9TCUK04Frt1Wfjbs/AOC',NULL,NULL,'permis_b','en_ligne','1',NULL,2,'JSUZSR9P',1,-1,0.00,0,1,'paye','non_paye','non_paye','non_paye','Payé le 25/02/2026 à 09:20',NULL,NULL,NULL,'2026-02-25 08:19:24',NULL,'2026-02-25 08:18:15','2026-02-25 08:20:11',NULL),
(57,'TATKEU','Job','655511512','$2y$12$EMPJJsHKt23TR.atZoLUbeBWedtEmUuG82jpObTX0pwCWz5GiIDMG',NULL,'Ekounou','permis_b','presentiel','1',NULL,NULL,'ANGER202605',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(58,'CHUISSE','Hermann','677538018','$2y$12$0c0/2ToOd6A0xwOJrzM0RO7p.BH3svsT/hBuWIHguq','1995-11-02','Etoudi','permis_a','en_ligne','1',NULL,NULL,'ANGER202606',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(59,'Fotso','Cyr','650927818','$2y$12$YbEmq7pudfmb3Mm8MAub2e7UtLZuxmUArFN0jKDNCzIHS/XECb96a',NULL,NULL,'permis_b','en_ligne','1',NULL,NULL,'ANGER202607',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(60,'Ken','Fabi','672935972','$2y$12$1eVj1ujIvVdA8WgmJsd/FuvsMR/cSXUdDOapoQ2gsV9pUrlswzuiu','2009-09-08',NULL,'permis_b','en_ligne','1',NULL,NULL,'ANGER202608',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(61,'Cyrus','Fotso','650927815','$2y$12$T152r3kqPY/87NpFGeKUIufHzmC.DSSqMS4..gE1sttUZMG2vOX/y',NULL,NULL,'permis_b','en_ligne','1',NULL,NULL,'ANGER202609',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(62,'Kamdem','Kevin','658610966','$2y$12$nL1ZnbsNa3G.uPHTp90X2OcqCEBFEfvUiUB2EKu5K2mKpM/UIL/bO',NULL,'Yaoundé','permis_b','en_ligne','1',NULL,NULL,'ANGER202610',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(63,'Neossi','Idolin','657884096','$2y$12$.PWlzYCjRYXCo9bJKINU0.UZGTqQyubgnxVXfLbpsyG.wfn7SzovG','2005-12-30','Cité u','permis_a','en_ligne','1',NULL,NULL,'ANGER202611',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(64,'Jeffrey','Yaj','696072368','$2y$12$UU6jDlmbTtQuvHvh57n8gOuXDMYk7ahW4JiPBP.RWGVjr3Xs14Z5a',NULL,NULL,'permis_b','en_ligne','1',NULL,NULL,'ANGER202612',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(65,'Uui','Kll','9','$2y$12$AARB2780uoMO1xFiA/t7ZuWLuwQq24fLpQJgHOssW/jejgblPDX/S','2025-12-18',NULL,'permis_a','en_ligne','1',NULL,NULL,'ANGER202613',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(66,'BELL','AQIL','686301238','$2y$12$yA8njmGuZpsN.NmmlaJrqOdHTzjJmZzUWkq9/CbpMFZrJJ7D5NH5W','2005-08-03',NULL,'permis_a','les_deux','1',NULL,NULL,'ANGER202614',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(67,'Bessala','Joseph Armel','691642961','$2y$12$EjS6BcMKYWcYiAhJ.5iRvubLgkU47c1Gu476CaGTx./Jkxfngdaba','2001-07-21','Melen','permis_a','en_ligne','1',NULL,NULL,'ANGER202615',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(68,'BRIA','DOMINIQUE','699707810','$2y$12$06YBZ7IofS6ukTqE22fUnuw1wMZ1gFAObO1IywIdZpKaYCbY27wnq','2006-02-10','Ekoumdoum','permis_a','presentiel','1',NULL,NULL,'ANGER202616',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(69,'Ndoko','Girest','658033888','$2y$12$t5tQSmGeF1xY4cl2F.YYV.e.6/yfQ.V3sVoHnCgXdsRVdauQFbqPa','2006-01-27','Bonaberie','permis_a','en_ligne','1',NULL,NULL,'ANGER202617',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(70,'Alsefo','Fozuma','688897227','$2y$12$jisUq/.HBFQ2Sg7.vFlVgOzL7ITBU2.C95t9cUV.yuhuLx6MKlHs.','2000-01-01',NULL,'permis_a','en_ligne','1',NULL,NULL,'ANGER202618',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(71,'Landris','Joseph','691474625','$2y$12$RDdKka7KRA6oWDdFHR0bIOoNScf3N26DspKQ8jbR6lIhpAUEWAXgq','2004-03-22','Ekounou','permis_b','en_ligne','1',NULL,NULL,'ANGER202621',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(72,'Trd','Ghj','632332223','$2y$12$IGbUdjfkg1iPQ1gKrVfq6OXApxYhF0XZOZBvrLWtDM6zU10OtVZFG',NULL,NULL,'permis_a','presentiel','1',NULL,NULL,'ANGER202622',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(73,'Vlad','Dior','691332611','$2y$12$Z4u0.j2CF5X4siCB/znfYupVPemAQ9lyirh9JWZDs27d9tn.itc.u',NULL,'Baladji','permis_b','en_ligne','1',NULL,NULL,'ANGER202623',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(74,'Teto','Josh','659092750','$2y$12$f2fJcYOZmn4etdYpEmI/QO5Yip6eiF16Bu7P8l8SraJOWH/Efm2pS',NULL,'Explosif','permis_b','en_ligne','1',NULL,NULL,'ANGER202624',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(75,'KOM','Raoul','692326583','$2y$12$2tSLexCK3/o1/UPPpuZkNeIhR9zOz6mPYH3exqzv7CFuqqO4XUcAO',NULL,NULL,'permis_b','en_ligne','1',NULL,NULL,'ANGER202625',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(76,'KOM','Raoul','692356583','$2y$12$RiAYqC1xERT/S0uNoEmkUOMFO7F35yMwtSyZw5XXHrxucjFRM4Moy',NULL,NULL,'permis_b','en_ligne','1',NULL,NULL,'ANGER202626',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(77,'Domo Eteme','Joseph Willyame','691369838','$2y$12$tr.UYwmmpA5oXC9AQroWxOU0X2tWUzwFUxdziSjTAzjg4NFupHskK',NULL,'Nkoabang','permis_b','en_ligne','1',NULL,NULL,'ANGER202627',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(78,'YANU','BARNABAS','695045000','$2y$12$ABTMPh57zCGTBugXwAqaROTQYiCMC964n6TnY8dZBQ3IpKTUmDAJ6',NULL,'Camp sonel essos','permis_b','en_ligne','1',NULL,NULL,'ANGER202628',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(79,'ONGOLO','Jordan','653783826','$2y$12$fSZ/LjQ54Z13CSMt3T9gXuVXqGrWj4iIzLk0QD8snB1Lq10ryZlde',NULL,NULL,'permis_b','les_deux','1',NULL,NULL,'ANGER202629',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(80,'Bella','Jeannot Romuald','698427442','$2y$12$AVLP8ILD9xSKcwlOQSmKH.SQ.CZ3NgRaMV.r6QQ8.8buiAQ0Em5/G',NULL,'Santa Barbara','permis_b','les_deux','1',NULL,NULL,'ANGER202630',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(81,'Onana Fouman','Serges Giovanni','659436873','$2y$12$j496xTWBOcgUpgJ/dwUJSuq4eJRrxxz/S0bCGcPRu8Kh2DG9ezYIO',NULL,'Nkoabang','permis_b','en_ligne','1',NULL,NULL,'ANGER202631',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(82,'Jackai','Jack','658579016','$2y$12$gD0WehCIWBTSRFYxkbh2f./iPLp9X3flcPAFuvNn/58sOgSC5qC2S',NULL,'New York City','permis_b','les_deux','1',NULL,NULL,'ANGER202632',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(83,'Nghakepain Foloum','Abdou','691276610','$2y$12$yx5v59yykYZE3yxwsvKIvus28G.Oyu69rQxaN5ZLLwTC07GO3F/SO',NULL,'Éleveur','permis_b','en_ligne','1',NULL,NULL,'ANGER202633',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(84,'Foe Foe','Christophe Ivan Youane','697395074','$2y$12$h7oIZjwvJROTmalmpNMnG.Zt6uu/HyG7eXdaBP4B4Tpk6kYrkFwp6',NULL,'Messassi','permis_b','presentiel','1',NULL,NULL,'ANGER202634',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(85,'Medzoa Ngono','Paulin Donald','506970819','$2y$12$h/X9aSIAE.UxtC/pk/sCIuTv8nOQO07cuW/za.62o69X6tKvPqn..',NULL,'Olembe','permis_b','presentiel','1',NULL,NULL,'ANGER202635',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(86,'Destin De Limapak','Désiré','693364678','$2y$12$jBoy8p1eP8.tMTzI8DDM9O/9VStKqIRJ.tO7o7ey9c/5Vk.H5iwAy',NULL,'Ngousso','permis_b','en_ligne','1',NULL,NULL,'ANGER202636',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(87,'Medzoa Ngono','Paulin Donald','697081915','$2y$12$6Q8646uM4xuBfU.3bgpLZ.uR0kt6ym6Zds2qsXgSWWO6tLkr8qCvG',NULL,'Olembe','permis_b','en_ligne','1',NULL,NULL,'ANGER202637',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(88,'Melingui Essindi','Romanic','694274528','$2y$12$hGfpNV01ya4qE6Ke9LWvouS5.I5KzHR99rt0MpV7i.0FdwIy2ReBe',NULL,'Ekounou','permis_b','en_ligne','1',NULL,NULL,'ANGER202638',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(89,'Keni','Charly','657692556','$2y$12$rHkmltw4o8e4rc5iH..gqOLHBjKQzMUej3zihTL5O4bT4UmF4zO8.',NULL,'Maeture Nkomo','permis_b','en_ligne','1',NULL,NULL,'ANGER202639',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(90,'Fofou','Mayva Claire','677009822','$2y$12$vlDgyGCWHyaKAiBuZZRFmuEp3Ou4DERDOjckq8o4K/ANOcAv9QwJO',NULL,'Nvogh betsi','permis_b','en_ligne','1',NULL,NULL,'ANGER202640',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(91,'Balogue','Alex Daniel','655456062','$2y$12$UyWhy/WRTGPuY56AJIMIQum9Tii3g3L0rM2VsbHl49fUwjj2GSaH.',NULL,'Ekounou','permis_b','presentiel','1',NULL,NULL,'ANGER202641',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(92,'NDJOCK','PHILIPPE LANDRY','678499099','$2y$12$RiWAp3HxqTrnZT3wzBYXeOsCadOmyEj.ASBg5LEcMS36hR9yCtrqK',NULL,'Obala','permis_b','presentiel','1',NULL,NULL,'ANGER202642',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(93,'TIENTCHEU KANDJI','Raphaël Patrick','653383825','$2y$12$FsJ7k.e1xU.JCu12A3Vqne.GmLXi1hCl26gqB5BTcbB.3SKHtMTTy',NULL,'MBANGA QUARTIER 3','permis_b','en_ligne','1',NULL,NULL,'ANGER202643',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(94,'SINGHE FOSSI','Prisca','658546876','$2y$12$5XgxciInKJrbj3WtvfsbIOUyGBrBMoSZ4vhhkgMqFe1144SOXerpK',NULL,'Nkoabang','permis_b','en_ligne','1',NULL,NULL,'ANGER202644',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(95,'ABEGA','Patricia','699048124','$2y$12$mHlOjaSl42BOMCyFFv.VluyVrbnoXiCcjj5UkTGmUn3QHd/tz8Qny',NULL,'MFOU','permis_b','en_ligne','1',NULL,NULL,'ANGER202645',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(96,'NDONGO NOAH','JEAN YVES','693759843','$2y$12$napRyZ1GmmZ1iK0V36oihuTWMiIamnYjK94flyBvOK9MlJ7/iI9vG',NULL,'ETOA par AHALA','permis_b','en_ligne','1',NULL,NULL,'ANGER202646',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(97,'Eve\'e Nkoumba','Paule Brenda','237659443','$2y$12$FnpM5vJf5yn2XfNWWu2qD.ol4Jhw6qlOOXwje6Y/opsLB8nOMY3Nm',NULL,'Ekounou','permis_b','en_ligne','1',NULL,NULL,'ANGER202647',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(98,'Eve\'e Nkoumba','Paule Brenda','659443395','$2y$12$ASgPHTsEcxo71ct.9xAlgeVMbLvE.IPH.ucfTH9FVRM6VcRYF4.0W',NULL,'Ekounou','permis_b','presentiel','1',NULL,NULL,'ANGER202648',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(99,'Akono Ayinda','Dominique Savio','658263419','$2y$12$cPWkjF1C6ZCSgQ8QeJVswOegIErUXeUo10fRx7vTopM.bCFiflJty',NULL,'Odza borne 10','permis_b','les_deux','1',NULL,NULL,'ANGER202649',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(100,'Talla Ndassi','Talitpa','680011534','$2y$12$abuApEseByS1scXCOhqx0OM7VdcH3vmjsENDldvnmZ.0K8wVh6lBG',NULL,'Ekounou','permis_b','les_deux','1',NULL,NULL,'ANGER202650',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(101,'Abanda Ekobena','Hubert Cédric','682214643','$2y$12$2mfCpKH1jobjL6zkqFEbx.VUR3cwb57S6nWwHtM22jwK9V2lZn9o2',NULL,'Obili','permis_b','presentiel','1',NULL,NULL,'ANGER202651',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL),
(102,'NDi NGOUKOU','Théodore Junior','693531953','$2y$12$EiysqH7EEF6Cj8pzO6CuTudvLywFo8CKkfJarWJ6DQbwJXuVYMQPK',NULL,'Awae escalier','permis_b','en_ligne','1',NULL,NULL,'ANGER202652',1,-1,0.00,0,0,'non_paye','non_paye','non_paye','non_paye',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 11:43:06','2026-02-25 11:43:06',NULL);
/*!40000 ALTER TABLE `auto_ecole_users` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `centres_examen`
--

DROP TABLE IF EXISTS `centres_examen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `centres_examen` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centres_examen`
--

LOCK TABLES `centres_examen` WRITE;
/*!40000 ALTER TABLE `centres_examen` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `centres_examen` VALUES
(1,'Ngaoundéré','Adamaoua',NULL,1,'2026-02-20 18:48:05','2026-02-20 18:48:05'),
(2,'Yaoundé','Centre',NULL,1,'2026-02-20 18:48:54','2026-02-20 18:48:54'),
(3,'Bertoua','Est',NULL,1,'2026-02-20 18:49:13','2026-02-20 18:49:13'),
(4,'Maroua','Extrême-Nord',NULL,1,'2026-02-20 18:49:39','2026-02-20 18:49:39'),
(5,'Douala','Littoral',NULL,1,'2026-02-20 18:50:08','2026-02-20 18:50:08'),
(6,'Garoua','Nord',NULL,1,'2026-02-20 18:50:37','2026-02-20 18:50:37'),
(7,'Bamenda','Nord Ouest',NULL,1,'2026-02-20 18:50:56','2026-02-20 18:50:56'),
(8,'Bafoussam','Ouest',NULL,1,'2026-02-20 18:51:15','2026-02-20 18:51:15'),
(9,'Ebolowa','SUD',NULL,1,'2026-02-20 18:51:39','2026-02-20 18:51:39'),
(10,'Buéa','Sud-Ouest',NULL,1,'2026-02-20 18:52:09','2026-02-20 18:52:09');
/*!40000 ALTER TABLE `centres_examen` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `chapitres`
--

DROP TABLE IF EXISTS `chapitres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `chapitres` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint(20) unsigned NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ordre` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chapitres_module_id_foreign` (`module_id`),
  CONSTRAINT `chapitres_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chapitres`
--

LOCK TABLES `chapitres` WRITE;
/*!40000 ALTER TABLE `chapitres` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `chapitres` VALUES
(5,2,'S\'installer au poste de conduite','Réglages siège, rétroviseurs, vitres, ceinture, passagers, bagages',1,1,'2026-02-19 13:01:12','2026-02-19 12:15:06'),
(6,2,'Regarder autour de soi','Angles morts, rétroviseurs, direction et mobilité du regard',2,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(7,2,'Agir sans mettre en danger','Précautions montée/descente, portières, vérification pneus et espace',3,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(8,2,'Avertir les autres usagers','Clignotants, avertisseur sonore, signal de détresse, feux d\'avertissement',4,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(9,2,'Démarrer et s\'arrêter','Mise en marche, arrêt moteur, démarrage sur terrain plat/côte/descente',5,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(10,3,'Tenue du volant en ligne droite','Position des mains, maintien du cap',1,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(11,3,'Rotation du volant','Sans déplacer les mains, simple déplacement, chevauchement des mains',2,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(12,4,'Utilisation de l\'embrayage','Débrayage/embrayage en circulation, démarrage en côte, passage des vitesses',1,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(13,4,'Utilisation des freins','Frein principal, frein secondaire, frein moteur',2,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(14,4,'Utilisation de la boîte de vitesses','Manipulation du levier, montée/rétrogradage, choix du rapport, démarrage de secours',3,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(15,4,'Diriger la voiture en avant','Contrôle direction, trajectoire rectiligne, manipulation d\'autres commandes',4,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(16,4,'Diriger la voiture en arrière','Marche arrière ligne droite/courbe, position du corps, mains/pieds, demi-tour',5,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(17,4,'Ranger la voiture','Stationnement en épi, en bataille, en créneau',6,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(18,5,'Lecture de la notice constructeur','Savoir lire et exploiter la notice du véhicule',1,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(20,5,'Changement de roue et ampoule','Démonter/changer une roue, changer une ampoule ou un fusible',3,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(21,5,'Aides à la conduite et conduite économique','Régulateur, limiteur, ABS, GPS, économie de carburant',4,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(22,5,'Prévisions et situations d\'urgence','Route de secours, carburant, documents, pannes, incendie, remorquage',5,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(23,6,'Règles de circulation et signalisation','Intersections, feux, gestes agents, panneaux, marquages au sol',1,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(25,6,'Vitesse et voie de circulation','Adapter sa vitesse, rouler à droite, voies réservées, marquages',3,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(26,6,'Distances de sécurité et intersections','Évaluation distances, franchissement des intersections, priorités',4,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(27,6,'Dépassement, croisement et virages','Règles de dépassement, croisement, technique de virage, force centrifuge',5,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(28,6,'Arrêt, stationnement et comportement envers les usagers','Réglementation arrêt/stationnement, catégories d\'usagers, communication',6,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(29,6,'Itinéraire et conditions particulières de conduite','Préparation itinéraire, nuit, adhérence réduite, montagne, fatigue',7,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(30,6,'Alcool, accidents et facteurs de risque','Effets alcool, comportement en cas d\'accident, principaux facteurs de mortalité',8,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(31,7,'Definitions',NULL,1,1,'2026-02-19 16:16:48','2026-02-19 16:16:48'),
(32,7,'Description des organes et des dispositifs du vehicule',NULL,2,1,'2026-02-19 16:16:48','2026-02-19 16:16:48'),
(33,7,'Signalisation routiere',NULL,3,1,'2026-02-19 16:16:48','2026-02-19 16:16:48'),
(34,7,'Regles applicable a la circulation routiere',NULL,4,1,'2026-02-19 16:16:48','2026-02-19 16:16:48'),
(35,7,'Regles administratives',NULL,5,1,'2026-02-19 16:16:48','2026-02-19 16:16:48'),
(36,7,'Responsibiliter civile et penale du conducteur',NULL,6,1,'2026-02-19 16:16:48','2026-02-19 16:16:48');
/*!40000 ALTER TABLE `chapitres` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `codes_caisse`
--

DROP TABLE IF EXISTS `codes_caisse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `codes_caisse` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `montant` decimal(12,2) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `utilise` tinyint(1) NOT NULL DEFAULT 0,
  `utilise_at` timestamp NULL DEFAULT NULL,
  `expire_at` timestamp NULL DEFAULT NULL,
  `cree_par` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codes_caisse_code_unique` (`code`),
  KEY `codes_caisse_user_id_foreign` (`user_id`),
  KEY `codes_caisse_cree_par_foreign` (`cree_par`),
  CONSTRAINT `codes_caisse_cree_par_foreign` FOREIGN KEY (`cree_par`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `codes_caisse_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `codes_caisse`
--

LOCK TABLES `codes_caisse` WRITE;
/*!40000 ALTER TABLE `codes_caisse` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `codes_caisse` VALUES
(1,'CC-2B947E32FB',10000.00,2,1,'2026-02-25 07:23:59',NULL,2,'2026-02-25 07:22:49','2026-02-25 07:23:59'),
(2,'CC-EDE87B7A98',10000.00,3,1,'2026-02-25 07:56:54',NULL,2,'2026-02-25 07:51:45','2026-02-25 07:56:54'),
(3,'CC-3541412738',10000.00,4,1,'2026-02-25 08:19:24',NULL,2,'2026-02-25 08:19:04','2026-02-25 08:19:24');
/*!40000 ALTER TABLE `codes_caisse` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `config_paiements`
--

DROP TABLE IF EXISTS `config_paiements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `config_paiements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `frais_formation` decimal(10,2) NOT NULL DEFAULT 40000.00,
  `frais_inscription` decimal(10,2) NOT NULL DEFAULT 10000.00,
  `frais_examen_blanc` decimal(10,2) NOT NULL DEFAULT 12500.00,
  `frais_examen` decimal(10,2) NOT NULL DEFAULT 30000.00,
  `depot_minimum` decimal(10,2) NOT NULL DEFAULT 10000.00,
  `code_parrainage_defaut` varchar(255) DEFAULT NULL,
  `whatsapp_support` varchar(255) DEFAULT NULL,
  `lien_telechargement_app` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_paiements`
--

LOCK TABLES `config_paiements` WRITE;
/*!40000 ALTER TABLE `config_paiements` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `config_paiements` VALUES
(1,10000.00,10000.00,12500.00,30000.00,10000.00,'ANGER-2026-0101001','237696087354','https://play.google.com/store/apps/details?id=com.anonymous.angeraphael','2026-02-19 20:56:40','2026-02-25 07:18:26');
/*!40000 ALTER TABLE `config_paiements` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `filleuls`
--

DROP TABLE IF EXISTS `filleuls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `filleuls` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parrain_id` bigint(20) unsigned NOT NULL,
  `filleul_id` bigint(20) unsigned NOT NULL,
  `niveau_parrain_lors_ajout` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filleuls_parrain_id_foreign` (`parrain_id`),
  KEY `filleuls_filleul_id_foreign` (`filleul_id`),
  CONSTRAINT `filleuls_filleul_id_foreign` FOREIGN KEY (`filleul_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `filleuls_parrain_id_foreign` FOREIGN KEY (`parrain_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filleuls`
--

LOCK TABLES `filleuls` WRITE;
/*!40000 ALTER TABLE `filleuls` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `filleuls` VALUES
(1,1,2,0,'2026-02-24 07:41:36','2026-02-24 07:41:36'),
(2,1,3,0,'2026-02-25 07:44:56','2026-02-25 07:44:56'),
(3,1,4,0,'2026-02-25 08:18:15','2026-02-25 08:18:15');
/*!40000 ALTER TABLE `filleuls` ENABLE KEYS */;
UNLOCK TABLES;
commit;

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

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
commit;

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
  `attempts` tinyint(3) unsigned NOT NULL,
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

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `jours_pratique`
--

DROP TABLE IF EXISTS `jours_pratique`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jours_pratique` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lieu_pratique_id` bigint(20) unsigned NOT NULL,
  `jour` enum('lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche') NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jours_pratique_lieu_pratique_id_foreign` (`lieu_pratique_id`),
  CONSTRAINT `jours_pratique_lieu_pratique_id_foreign` FOREIGN KEY (`lieu_pratique_id`) REFERENCES `lieux_pratique` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jours_pratique`
--

LOCK TABLES `jours_pratique` WRITE;
/*!40000 ALTER TABLE `jours_pratique` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `jours_pratique` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `lecons`
--

DROP TABLE IF EXISTS `lecons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chapitre_id` bigint(20) unsigned NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu_texte` text DEFAULT NULL,
  `url_web` varchar(255) DEFAULT NULL,
  `url_video` varchar(255) DEFAULT NULL,
  `ordre` int(11) NOT NULL DEFAULT 0,
  `duree_minutes` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lecons_chapitre_id_foreign` (`chapitre_id`),
  CONSTRAINT `lecons_chapitre_id_foreign` FOREIGN KEY (`chapitre_id`) REFERENCES `chapitres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecons`
--

LOCK TABLES `lecons` WRITE;
/*!40000 ALTER TABLE `lecons` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `lecons` VALUES
(21,5,'Régler le siège et le dossier','Savoir régler correctement le siège et le dossier avant de conduire.',NULL,'https://ange-raphael.supahuman.site/pratique/Comment_Bien_R_gler_Le_Si_ge_De_La_Voiture_Et_le_Volant_-_Plus_Jamais_Mal_Au_Dos_360P.mp4',1,10,1,'2026-02-19 13:01:12','2026-02-19 12:20:20'),
(22,5,'Régler les rétroviseurs','Savoir régler les rétroviseurs intérieur et extérieurs.',NULL,'https://ange-raphael.supahuman.site/pratique/Comment_bien_r_gler_les_r_troviseurs_et_les_dangers_720P.mp4',2,10,1,'2026-02-19 13:01:12','2026-02-19 12:22:33'),
(23,5,'Vérifier la transparence des vitres','Vérifier et nettoyer les vitres avant le départ.',NULL,'https://ange-raphael.supahuman.site/pratique/Comment_Nettoyer_des_Vitres_de_Voiture_Comme_un_Pro_720P.mp4',3,5,1,'2026-02-19 13:01:12','2026-02-19 12:23:18'),
(24,5,'Installer les passagers','Influence des passagers sur la conduite, règles de sécurité.',NULL,'https://ange-raphael.supahuman.site/pratique/Comment_doivent_s_installer_les_passagers_d_une_voiture_720P.mp4',4,10,1,'2026-02-19 13:01:12','2026-02-19 12:24:28'),
(25,5,'Boucler les ceintures','Boucler sa ceinture et celle des passagers, importance de la ceinture.',NULL,'https://ange-raphael.supahuman.site/pratique/L_utilisation_de_la_ceinture_de_s_curit_720P.mp4',5,10,1,'2026-02-19 13:01:12','2026-02-19 12:24:58'),
(27,6,'Angles morts','Connaissance et gestion des angles morts.',NULL,'https://ange-raphael.supahuman.site/pratique/LES_ANGLES_MORTS.mp4',1,15,1,'2026-02-19 13:01:12','2026-02-19 12:31:03'),
(28,6,'Utilisation des rétroviseurs','Savoir regarder correctement dans les rétroviseurs.',NULL,'https://ange-raphael.supahuman.site/pratique/RETROVISEURS.mp4',2,15,1,'2026-02-19 13:01:12','2026-02-19 12:33:26'),
(29,6,'Direction et mobilité du regard','Notions sur la direction du regard et son importance en conduite.',NULL,'https://ange-raphael.supahuman.site/pratique/MOBILITE_REGARD.mp4',3,10,1,'2026-02-19 13:01:12','2026-02-19 12:36:00'),
(30,7,'Précautions en montant/descendant du véhicule','Précautions à prendre en montant et descendant de voiture.',NULL,'https://ange-raphael.supahuman.site/pratique/Comment_entrer_sortir.mp4',1,10,1,'2026-02-19 13:01:12','2026-02-19 12:39:23'),
(32,7,'Vérifier les pneus et l\'espace disponible','Vérifier qu\'aucun pneu n\'est dégonflé et que l\'espace est libre.',NULL,'https://ange-raphael.supahuman.site/pratique/pneus.mp4',3,10,1,'2026-02-19 13:01:12','2026-02-19 12:41:42'),
(34,8,'Clignotants','Faire fonctionner immédiatement les clignotants, savoir quand les utiliser.',NULL,'https://ange-raphael.supahuman.site/pratique/le_clignotant.mp4',1,10,1,'2026-02-19 13:01:12','2026-02-19 12:43:18'),
(35,8,'Avertisseur sonore','Faire fonctionner l\'avertisseur sonore, savoir quand l\'utiliser.',NULL,'https://ange-raphael.supahuman.site/pratique/avertisseur_sonore.mp4',2,10,1,'2026-02-19 13:01:12','2026-02-19 12:44:26'),
(36,8,'Signal de détresse et feux d\'avertissement','Utiliser le signal de détresse et les feux pour avertir.',NULL,'https://ange-raphael.supahuman.site/pratique/feux_détresse.mp4',3,10,1,'2026-02-19 13:01:12','2026-02-19 12:48:12'),
(37,9,'Mettre le moteur en marche','Clé de contact, point mort, frein à main – procédure complète.',NULL,'https://ange-raphael.supahuman.site/pratique/DÉMARRER.mp4',1,15,1,'2026-02-19 13:01:12','2026-02-19 12:50:46'),
(38,9,'Arrêter le moteur','Procédure pour arrêter le moteur correctement.',NULL,'https://ange-raphael.supahuman.site/pratique/s_arrêter.mp4',2,5,1,'2026-02-19 13:01:12','2026-02-19 12:52:49'),
(40,9,'Démarrage sur terrain plat, en montée et en descente','Techniques de démarrage selon le profil du terrain.',NULL,'https://ange-raphael.supahuman.site/pratique/Démarrer_terrains_plat.mp4',4,20,1,'2026-02-19 13:01:12','2026-02-19 12:54:11'),
(41,9,'Arrêter la voiture à un endroit précis','Savoir arrêter la voiture roulant lentement à un endroit précis.',NULL,'https://ange-raphael.supahuman.site/pratique/arret_precis.mp4',5,15,1,'2026-02-19 13:01:12','2026-02-19 12:55:47'),
(42,10,'Tenir le volant en ligne droite','Position et pression des mains sur le volant en ligne droite.',NULL,'https://ange-raphael.supahuman.site/pratique/MANIPULER_VOLANT.mp4',1,15,1,'2026-02-19 13:01:12','2026-02-19 12:58:42'),
(43,11,'Rotation du volant','Technique de rotation du volant',NULL,'https://ange-raphael.supahuman.site/pratique/tenir_tourner_le_volant.mp4',1,15,1,'2026-02-19 13:01:12','2026-02-19 13:02:43'),
(46,12,'Débrayage et embrayage en circulation','Utilisation correcte de l\'embrayage pendant la circulation.',NULL,'https://ange-raphael.supahuman.site/pratique/embrayage.mp4',1,20,1,'2026-02-19 13:01:12','2026-02-19 13:05:39'),
(47,12,'Démarrage et arrêt en côte','Avec et sans frein à main – technique du démarrage en côte.',NULL,'https://ange-raphael.supahuman.site/pratique/DEMARRAGE_EN_COTE.mp4',2,20,1,'2026-02-19 13:01:12','2026-02-19 13:06:55'),
(48,12,'Passage des vitesses selon la vitesse','Passage en fonction de la vitesse : 20 km/h, 30 km/h, 40 km/h.',NULL,'https://ange-raphael.supahuman.site/pratique/LES_VITESSES.mp4',3,20,1,'2026-02-19 13:01:12','2026-02-19 13:08:17'),
(49,13,'Frein principal','Utilisation et dosage du frein principal.',NULL,'https://ange-raphael.supahuman.site/pratique/FREIN.mp4',1,15,1,'2026-02-19 13:01:12','2026-02-19 13:09:33'),
(50,13,'Frein secondaire (frein à main)','Le frein à main dans une voiture\r\n\r\nLe frein à main, aussi appelé frein de stationnement, est un dispositif de sécurité essentiel dans tout véhicule. Son rôle principal est de maintenir la voiture immobile lorsqu\'elle est garée, en empêchant tout mouvement involontaire, notamment sur une pente.\r\n\r\nFonctionnement\r\n\r\nIl agit généralement sur les roues arrière via un câble mécanique relié à un levier (ou une pédale dans certains véhicules). Lorsqu\'on actionne ce levier, le câble tire sur les mâchoires ou les plaquettes de frein, bloquant ainsi les roues. Sur les véhicules modernes, il est souvent remplacé par un frein de stationnement électrique(bouton électronique), plus compact et pratique.\r\n\r\nUtilisations\r\n\r\nSon usage premier est le stationnement, mais il peut aussi servir en cas de défaillance du frein principal, ou en conduite sportive pour effectuer des dérapages contrôlés.\r\n\r\nEntretien\r\n\r\nAvec le temps, le câble peut se détendre ou se corrodre, réduisant l\'efficacité du frein. Il est conseillé de le faire vérifier régulièrement lors des révisions. Un frein à main mal réglé peut ne pas retenir le véhicule correctement, ce qui représente un véritable danger.\r\n\r\nEn résumé, c\'est un élément simple mais indispensable pour la sécurité et le bon usage du véhicule au quotidien.',NULL,NULL,2,10,1,'2026-02-19 13:01:12','2026-02-25 09:29:55'),
(51,13,'Frein moteur','Utilisation et avantages du frein moteur.',NULL,'https://ange-raphael.supahuman.site/pratique/frein_moteur.mp4',3,15,1,'2026-02-19 13:01:12','2026-02-19 13:11:02'),
(52,14,'Manipulation du levier de vitesses','Savoir manipuler le levier de vitesses correctement.',NULL,'https://ange-raphael.supahuman.site/pratique/LEVIER_V.mp4',1,15,1,'2026-02-19 13:01:12','2026-02-19 13:13:33'),
(53,14,'Montée des vitesses et rétrogradage','Savoir monter et rétrograder en douceur.',NULL,'https://ange-raphael.supahuman.site/pratique/LES_VITESSES.mp4',2,20,1,'2026-02-19 13:01:12','2026-02-19 13:14:32'),
(54,14,'Choisir le rapport de vitesse adapté','Choisir le rapport convenable selon la situation.',NULL,'https://ange-raphael.supahuman.site/pratique/ajuster_vitesse.mp4',3,15,1,'2026-02-19 13:01:12','2026-02-19 13:15:31'),
(58,15,'Maintenir une trajectoire rectiligne','Maintenir une trajectoire rectiligne à diverses allures.',NULL,'https://ange-raphael.supahuman.site/pratique/trajectoire_r.mp4',2,20,1,'2026-02-19 13:01:12','2026-02-19 13:18:19'),
(59,15,'Trajectoire rectiligne avec manipulation d\'autres commandes','Maintenir la trajectoire tout en manipulant d\'autres commandes.',NULL,'https://ange-raphael.supahuman.site/pratique/AMÉLIORER_Trajectoires.mp4',3,20,1,'2026-02-19 13:01:12','2026-02-19 13:20:04'),
(60,16,'Marche arrière en ligne droite','Savoir faire une marche arrière en ligne droite.',NULL,'https://ange-raphael.supahuman.site/pratique/MARCHE_ARRIÈRE.mp4',1,20,1,'2026-02-19 13:01:12','2026-02-19 13:22:26'),
(61,16,'Marche arrière en courbe','Savoir faire une marche arrière en courbe.',NULL,'https://ange-raphael.supahuman.site/pratique/marche_arrière_en_courbe.mp4',2,20,1,'2026-02-19 13:01:12','2026-02-19 13:23:39'),
(62,16,'Position du corps, mains et pieds en marche arrière','Posture correcte pendant une marche arrière.',NULL,'https://ange-raphael.supahuman.site/pratique/RMA.mp4',3,15,1,'2026-02-19 13:01:12','2026-02-25 09:36:46'),
(63,16,'Demi-tour en sécurité','Savoir réaliser un demi-tour en toute sécurité.',NULL,'https://ange-raphael.supahuman.site/pratique/DEMI-TOUR.mp4',4,20,1,'2026-02-19 13:01:12','2026-02-19 13:26:01'),
(64,17,'Stationnement en épi','Technique du stationnement en épi.',NULL,'https://ange-raphael.supahuman.site/pratique/EN_ÉPI.mp4',1,20,1,'2026-02-19 13:01:12','2026-02-19 13:27:23'),
(65,17,'Stationnement en bataille','Technique du stationnement en bataille.',NULL,'https://ange-raphael.supahuman.site/pratique/BATAILLE.mp4',2,20,1,'2026-02-19 13:01:12','2026-02-19 13:28:12'),
(66,17,'Stationnement en créneau','Technique du stationnement en créneau.',NULL,'https://ange-raphael.supahuman.site/pratique/CRÉNEAU.mp4',3,25,1,'2026-02-19 13:01:12','2026-02-19 13:28:56'),
(67,18,'Lire et exploiter la notice du constructeur','Savoir lire la notice du constructeur et en extraire les informations utiles.\r\n\r\n La notice constructeur\r\n\r\nLa notice constructeur (ou manuel du propriétaire) est le document officiel fourni par le fabricant du véhicule. Elle contient toutes les informations nécessaires à l\'utilisation et à l\'entretien du véhicule. Tout conducteur doit savoir la consulter.\r\n\r\nElle indique notamment les intervalles de vidange, les types de fluides à utiliser, les pressions de gonflage des pneus, les capacités du réservoir, et les témoins lumineux du tableau de bord avec leur signification.\r\n\r\n---\r\n\r\n## Les vérifications à effectuer régulièrement\r\n\r\nAvant de prendre la route, et de façon régulière, le conducteur doit contrôler plusieurs points essentiels.\r\n\r\nLe niveau d\'huile moteur se vérifie moteur froid, à l\'aide de la jauge. Il doit se situer entre les repères MIN et MAX. Un niveau trop bas peut endommager gravement le moteur.\r\n\r\nLe niveau du liquide de refroidissement s\'observe dans le vase d\'expansion. Il évite la surchauffe du moteur. Il ne faut jamais ouvrir le bouchon moteur chaud.\r\n\r\nLe niveau du liquide de frein doit être entre MIN et MAX dans le bocal prévu à cet effet. Une baisse anormale peut signaler une fuite ou une usure des plaquettes.\r\n\r\nLe lave-glace doit être régulièrement rempli. Un pare-brise mal nettoyé réduit la visibilité et constitue un danger.\r\n\r\nLa pression des pneus se vérifie à froid avec un manomètre. Une pression incorrecte augmente la distance de freinage et accélère l\'usure des pneus. Les valeurs recommandées sont indiquées dans la notice et parfois sur le montant de la portière.\r\n\r\nL\'état des pneus doit aussi être contrôlé : la profondeur des rainures doit être supérieure à 1,6 mm (limite légale), mais il est conseillé de changer les pneus à partir de 3 mm pour des raisons de sécurité.\r\n\r\n---\r\n\r\n## L\'entretien périodique\r\n\r\nL\'entretien suit un calendrier défini par le constructeur, généralement tous les ans ou tous les 15 000 à 30 000 km selon les véhicules.\r\n\r\nIl comprend la vidange (changement de l\'huile moteur et du filtre à huile), le remplacement du filtre à air, du filtre à carburant, des bougies, et la vérification de la courroie de distribution, dont la rupture peut détruire le moteur.\r\n\r\nLe carnet d\'entretien permet de suivre l\'historique des interventions. Il est important pour la revente du véhicule et prouve que l\'entretien a bien été effectué.\r\n\r\n\r\n\r\nUn véhicule bien entretenu est plus sûr, plus économique et moins polluant. Négliger l\'entretien engage la responsabilité du conducteur en cas d\'accident lié à un défaut mécanique connu.',NULL,NULL,1,15,1,'2026-02-19 13:01:12','2026-02-19 13:30:56'),
(72,20,'Démonter et changer une roue','Procédure complète pour changer une roue.',NULL,'https://ange-raphael.supahuman.site/pratique/changer_roue.mp4',1,25,1,'2026-02-19 13:01:12','2026-02-19 13:37:30'),
(75,21,'Régulateur et limiteur de vitesse','Utilisation du régulateur et du limiteur de vitesse.',NULL,'https://ange-raphael.supahuman.site/pratique/Régulateur_Vitesse.mp4',1,15,1,'2026-02-19 13:01:12','2026-02-19 13:38:59'),
(76,21,'ABS','Fonctionnement et utilisation de l\'ABS.',NULL,'https://ange-raphael.supahuman.site/pratique/ABS.mp4',2,15,1,'2026-02-19 13:01:12','2026-02-19 13:39:49'),
(77,21,'Aides à la navigation (GPS)','Utilisation du GPS et des aides à la navigation.',NULL,'https://ange-raphael.supahuman.site/pratique/GPS.mp4',3,10,1,'2026-02-19 13:01:12','2026-02-19 13:40:27'),
(78,21,'Conduite économique','Notions de conduite économique et écologique.',NULL,'https://ange-raphael.supahuman.site/pratique/conduite_Economique.mp4',4,15,1,'2026-02-19 13:01:12','2026-02-19 13:41:29'),
(79,22,'Prévisions de voyage (carburant, documents, itinéraire)','Prévisions de voyage – Carburant, Documents, Itinéraire\r\n\r\nLe carburant\r\n\r\nAvant tout départ, vérifiez le niveau de carburant et estimez la consommation selon la distance prévue. Sur autoroute, prévoyez une marge car les stations peuvent être espacées. Ne roulez jamais en réserve : tomber en panne sur la route est dangereux et sanctionnable sur certaines voies.\r\n\r\n## Les documents obligatoires\r\n\r\nTout conducteur doit avoir avec lui : le permis de conduire, la carte grise du véhicule, l\'attestation d\'assurance (vignette verte sur le pare-brise + certificat), et une pièce d\'identité. En cas de contrôle, l\'absence de ces documents peut entraîner une amende. Pour un voyage à l\'étranger, renseignez-vous sur les documents spécifiques exigés par le pays.\r\n\r\nL\'itinéraire\r\n\r\nPlanifiez votre trajet avant de partir : consultez une carte ou un GPS, informez-vous sur les travaux, les bouchons ou les conditions météo. Évitez de consulter votre téléphone ou de reprogrammer le GPS en conduisant. Prévoyez les aires de repos, surtout pour les longs trajets (pause obligatoire toutes les 2 heures).\r\n\r\n Situations d\'urgence\r\n\r\nAyez toujours dans le véhicule : un triangle de présignalisation, un gilet jaune réfléchissant (accessible sans sortir du véhicule), une trousse de premiers secours, et si possible un extincteur. En cas de panne, allumez les feux de détresse, mettez le gilet, posez le triangle à distance réglementaire et appelez les secours.\r\n\r\nÀ retenir\r\n\r\nUn voyage bien préparé réduit les risques d\'accident, d\'infraction et de panne. L\'anticipation est une qualité essentielle du bon conducteur.',NULL,NULL,1,15,1,'2026-02-19 13:01:12','2026-02-19 13:43:20'),
(80,22,'Arrêt en cas de défaillance du frein principal','Savoir s\'arrêter si le frein principal défaille.',NULL,'https://ange-raphael.supahuman.site/pratique/freins_défaillants.mp4',2,15,1,'2026-02-19 13:01:12','2026-02-19 13:44:17'),
(81,22,'Freinage d\'urgence','Savoir freiner dans une situation d\'urgence.',NULL,'https://ange-raphael.supahuman.site/pratique/freinage_urgence.mp4',3,15,1,'2026-02-19 13:01:12','2026-02-19 13:45:15'),
(82,22,'Dégager la chaussée et remorquage','Savoir dégager la chaussée, remorquer et se faire remorquer.',NULL,'https://ange-raphael.supahuman.site/pratique/remorque.mp4',4,15,1,'2026-02-19 13:01:12','2026-02-19 13:48:44'),
(83,22,'Conduite à tenir en cas d\'incendie','Conduite à tenir en cas d\'incendie\r\nIncendie du moteur\r\n\r\nSi vous voyez de la fumée sous le capot, arrêtez-vous immédiatement, coupez le moteur et n\'ouvrez pas le capot brusquement (l\'air alimente le feu). Éloignez-vous du véhicule et appelez le 18 (pompiers) ou le 112. N\'essayez pas d\'éteindre seul un incendie important.\r\n\r\nSi vous disposez d\'un extincteur, dirigez-le à la base des flammes par une légère ouverture du capot, sans vous mettre en danger.\r\nIncendie à l\'intérieur de l\'habitacle\r\n\r\nArrêtez le véhicule, coupez le contact, évacuez immédiatement tous les passagers. Ne perdez pas de temps à récupérer des affaires. Éloignez-vous à au moins 50 mètres du véhicule car le réservoir peut exploser.\r\nSur autoroute ou voie rapide\r\n\r\nAllumez les feux de détresse, arrêtez-vous sur la bande d\'arrêt d\'urgence, mettez le gilet jaune, posez le triangle de signalisation, et éloignez-vous derrière les glissières de sécurité avant d\'appeler les secours.\r\nNuméros d\'urgence à retenir\r\n\r\n    18 : Pompiers\r\n    15 : SAMU\r\n    17 : Police\r\n    112 : Numéro d\'urgence européen (fonctionne partout)\r\n\r\nÀ retenir\r\n\r\nEn cas d\'incendie, la priorité absolue est l\'évacuation des personnes. Aucun bien matériel ne vaut une vie. Agissez vite, gardez votre calme et alertez les secours.',NULL,NULL,5,10,1,'2026-02-19 13:01:12','2026-02-19 13:50:54'),
(84,23,'Règles aux intersections (sans signalisation)','Règles de priorité aux intersections sans signalisation.',NULL,'https://ange-raphael.supahuman.site/pratique/intersection.mp4',1,20,1,'2026-02-19 13:01:12','2026-02-19 13:52:00'),
(85,23,'Règles aux intersections avec panneaux et feux','Règles aux intersections avec panneaux et feux\r\n\r\nLa règle générale : la priorité à droite\r\n\r\nEn l\'absence de tout panneau ou feu, la priorité à droite s\'applique : tout véhicule venant de votre droite est prioritaire. Cette règle de base s\'applique dans les zones urbaines et les voies de même importance.\r\n\r\nLes panneaux aux intersections\r\n\r\nCédez le passage (triangle pointe en bas) : vous devez laisser passer tous les véhicules venant de gauche et de droite. Vous n\'êtes pas prioritaire mais vous n\'êtes pas obligé de vous arrêter si la voie est libre.\r\n\r\nStop (octogone rouge) : arrêt obligatoire même si la voie semble libre. Vous devez marquer un arrêt complet, regarder des deux côtés, puis repartir. Ne pas s\'arrêter au stop est une infraction grave.\r\n\r\nPassage prioritaire (losange jaune) : vous êtes sur une route prioritaire. Les autres voitures doivent vous céder le passage.\r\n\r\nFin de priorité (losange jaune barré) : vous perdez votre priorité, revenez aux règles normales.\r\n\r\nLes feux de signalisation\r\n\r\nLe feu vert autorise le passage, mais restez vigilant aux piétons et aux véhicules qui brûlent le rouge.\r\n\r\nLe feu **orange fixe** impose de s\'arrêter si vous pouvez le faire en sécurité. Il ne signifie pas accélérer.\r\n\r\nLe feu **rouge** impose un arrêt total avant la ligne. Passer au rouge est une infraction majeure : retrait de 4 points et amende.\r\n\r\nLe feu rouge clignotant signifie arrêt absolu obligatoire (passages à niveau, certaines intersections dangereuses).\r\n\r\nLa flèche verte clignotante autorise à tourner dans la direction indiquée avec une priorité réduite : vous cédez le passage aux piétons et aux autres véhicules.\r\n\r\n## Les feux pour piétons et véhicules spéciaux\r\n\r\nLes feux pour piétons (bonhomme vert/rouge) sont indépendants des feux voitures. Respectez-les même si la route semble libre. Un piéton engagé sur le passage est toujours prioritaire.\r\n\r\nOrdre de priorité à retenir\r\n\r\nQuand plusieurs règles s\'appliquent, voici l\'ordre : les feux priment sur tout, ensuite les panneaux, ensuite la priorité à droite.\r\n\r\nÀ retenir\r\n\r\nUne intersection mal négociée est l\'une des premières causes d\'accidents. Anticipez, réduisez votre vitesse en approche, regardez des deux côtés, et ne présumez jamais que les autres respecteront les règles.',NULL,NULL,2,20,1,'2026-02-19 13:01:12','2026-02-19 13:58:06'),
(86,23,'Gestes de l\'agent','Comprendre et obéir aux gestes de l\'agent de circulation.',NULL,'https://ange-raphael.supahuman.site/pratique/GESTUELLE.mp4',3,15,1,'2026-02-19 13:01:12','2026-02-19 13:54:00'),
(88,23,'Signalisation horizontale (marquages au sol)','Connaissance des marquages au sol.',NULL,'https://ange-raphael.supahuman.site/pratique/Marquage.mp4',5,15,1,'2026-02-19 13:01:12','2026-02-19 13:55:10'),
(93,25,'Adapter sa vitesse aux situations','Choisir et modifier son allure selon les capacités et la réglementation.',NULL,'https://ange-raphael.supahuman.site/pratique/LIMITATIONS_Vitesse.mp4',1,20,1,'2026-02-19 13:01:12','2026-02-19 14:06:10'),
(94,25,'Choisir la voie de circulation','# Choisir la voie de circulation\r\n\r\n## Le principe de base : serrer à droite\r\n\r\nEn circulation normale, tout conducteur doit rouler le plus à droite possible. La voie de gauche n\'est pas une voie de circulation permanente, c\'est une voie de dépassement. Occuper la voie de gauche sans raison est une infraction.\r\n\r\n## Sur une route à deux voies\r\n\r\nVous roulez à droite. Vous ne vous déplacez à gauche que pour dépasser, puis vous revenez immédiatement à droite. Rester sur la voie de gauche après un dépassement est interdit et dangereux.\r\n\r\n## Sur une route à trois voies ou plus\r\n\r\nLa voie de droite est réservée à la circulation normale. La voie du milieu sert au dépassement ou lorsque la voie de droite est encombrée. La voie de gauche est réservée aux dépassements rapides et ne doit pas être utilisée en circulation fluide.\r\n\r\nSur autoroute, il est formellement interdit de dépasser par la droite.\r\n\r\n## Adapter sa voie à la situation\r\n\r\nEn approche d\'un carrefour, positionnez-vous à l\'avance dans la bonne voie selon votre direction : voie de droite pour tourner à droite, voie de gauche pour tourner à gauche, voie du milieu pour aller tout droit si plusieurs voies existent.\r\n\r\nEn cas d\'embouteillage, restez dans votre file. Les changements de voie répétés sont dangereux, stressants pour les autres et souvent inutiles.\r\n\r\n## La vitesse et le choix de voie\r\n\r\nLa voie choisie doit correspondre à votre vitesse. Un véhicule lent doit rester à droite et ne pas gêner la circulation. En dessous de 80 km/h sur autoroute, vous devez obligatoirement rouler sur la voie de droite sauf en cas de dépassement.\r\n\r\nLes limites à respecter sont : 50 km/h en agglomération, 80 km/h sur route, 110 km/h sur voie express, 130 km/h sur autoroute (110 par temps de pluie).\r\n\r\n## Adaptations à la circulation\r\n\r\nPar temps de pluie, brouillard ou route glissante, réduisez votre vitesse et augmentez vos distances de sécurité. La distance minimale recommandée est de 2 secondes avec le véhicule devant vous, et davantage par mauvais temps.\r\n\r\nEn ville, adaptez votre allure aux piétons, aux deux-roues et aux arrêts fréquents. En zone scolaire ou résidentielle, soyez particulièrement vigilant.\r\n\r\n## À retenir\r\n\r\nChoisir la bonne voie, c\'est anticiper, se positionner tôt et adapter sa vitesse. Une mauvaise voie au mauvais moment peut provoquer un accident ou bloquer toute la circulation.',NULL,NULL,2,15,1,'2026-02-19 13:01:12','2026-02-19 14:07:21'),
(95,26,'Évaluer et maintenir les distances de sécurité','Calcul de la distance de sécurité minimale à diverses allures.',NULL,'https://ange-raphael.supahuman.site/pratique/distance_sécurité.mp4',1,20,1,'2026-02-19 13:01:12','2026-02-19 14:08:51'),
(97,26,'Évaluer distances et vitesses des autres véhicules','Identifier les véhicules, causes d\'erreur d\'évaluation.',NULL,'https://ange-raphael.supahuman.site/pratique/Distances.mp4',3,15,1,'2026-02-19 13:01:12','2026-02-19 14:09:58'),
(99,27,'Croisement de dépassement','Réglementation, choisir le moment et l\'endroit pour dépasser, et cours sur les croisements',NULL,'https://ange-raphael.supahuman.site/pratique/Croisements_Dépassements.mp4',1,20,1,'2026-02-19 13:01:12','2026-02-19 14:20:34'),
(101,27,'Passer un virage en sécurité','Signalisation, évaluation des difficultés, allure, trajectoire, force centrifuge.',NULL,'https://ange-raphael.supahuman.site/pratique/virage.mp4',3,25,1,'2026-02-19 13:01:12','2026-02-19 14:21:26'),
(102,28,'Réglementation arrêt et stationnement','Règles sur route et en agglomération. Feux de détresse et triangle.',NULL,'https://ange-raphael.supahuman.site/pratique/Arret_stationnement.mp4',1,20,1,'2026-02-19 13:01:12','2026-02-19 14:22:37'),
(103,28,'Comportement envers les différentes catégories d\'usagers','Piétons, deux-roues, véhicules lents, transports en commun, urgences.',NULL,'https://ange-raphael.supahuman.site/pratique/autres_usagers.mp4',2,20,1,'2026-02-19 13:01:12','2026-02-19 14:24:01'),
(104,29,'Suivre et préparer un itinéraire','Suivre et préparer un itinéraire\r\n\r\n Préparer son itinéraire avant le départ\r\n\r\nUn bon conducteur ne découvre pas son trajet au dernier moment. Avant de partir, identifiez votre point de départ et votre destination, estimez la distance et la durée du trajet, repérez les grandes voies à emprunter (nationales, autoroutes, rocades) et notez les points de repère importants comme les villes traversées, les échangeurs ou les ronds-points principaux.\r\n\r\nConsultez les informations trafic pour anticiper les bouchons, travaux ou accidents sur votre route. Des applications comme Waze ou Google Maps peuvent vous y aider, mais configurez-les avant de démarrer.\r\n\r\n## Utiliser un GPS\r\n\r\nLe GPS est un outil précieux mais il ne remplace pas la vigilance. Entrez votre destination avant de partir, jamais en roulant. Écoutez les instructions vocales plutôt que de regarder l\'écran. Si le GPS vous annonce un changement de direction, anticipez-le en vous positionnant dans la bonne voie à l\'avance.\r\n\r\nNe suivez pas le GPS aveuglément : il peut se tromper, proposer des routes fermées ou inadaptées à votre véhicule. Le bon conducteur garde un sens critique.\r\n\r\n## Lire et utiliser une carte\r\n\r\nSavoir lire une carte routière reste une compétence essentielle en cas de panne de batterie ou d\'absence de réseau. Une carte indique les routes nationales, départementales et autoroutes avec leurs numéros, les distances entre les villes, et les points d\'intérêt comme les stations-service ou les aires de repos.\r\n\r\nSuivre l\'itinéraire en conduisant\r\n\r\nSur la route, respectez la signalisation directionnelle : les panneaux verts indiquent les autoroutes, les bleus les voies express, les blancs les routes ordinaires. Anticipez les sorties et changements de voie sans attendre le dernier moment.\r\n\r\nSi vous vous trompez de route, ne faites pas demi-tour brusquement. Continuez jusqu\'au prochain endroit sûr pour faire le point calmement.\r\n\r\nÀ retenir\r\n\r\nUn itinéraire bien préparé évite le stress, les manœuvres dangereuses et les pertes de temps. La route se conduit avec les yeux, pas les oreilles collées au GPS.',NULL,NULL,1,20,1,'2026-02-19 13:01:12','2026-02-19 14:25:28'),
(105,29,'Conduite de nuit et visibilité réduite','Adapter la vitesse à la distance de visibilité nocturne.',NULL,'https://ange-raphael.supahuman.site/pratique/Comment_conduire_la_nuit.mp4',2,20,1,'2026-02-19 13:01:12','2026-02-19 14:26:06'),
(108,29,'Effets de la fatigue','Signes de fatigue, risques, pauses, alimentation, climatisation.',NULL,'https://ange-raphael.supahuman.site/pratique/fatigue.mp4',5,15,1,'2026-02-19 13:01:12','2026-02-19 14:27:31'),
(109,30,'Effets de l\'alcool sur la conduite','Perception, réaction, prise de risques, alcoolémie, sanctions.',NULL,'https://ange-raphael.supahuman.site/pratique/alcool.mp4',1,20,1,'2026-02-19 13:01:12','2026-02-19 14:28:29'),
(110,30,'Comportement en cas d\'accident','Comportement en cas d\'accident\r\n\r\nLes obligations légales immédiates\r\n\r\nTout conducteur impliqué dans un accident a des obligations légales. Ne pas les respecter constitue le délit de fuite, passible de prison et de retrait de permis.\r\n\r\nVous devez : vous arrêter immédiatement, protéger les lieux, secourir les blessés et alerter les secours.\r\n\r\nProtéger les lieux\r\n\r\nAvant tout, sécurisez la zone pour éviter un second accident. Allumez les feux de détresse, mettez votre gilet jaune, posez le triangle de signalisation à environ 30 mètres en amont sur route et 100 mètres sur autoroute. Ne fumez pas, coupez les moteurs des véhicules impliqués pour éviter tout risque d\'incendie.\r\n\r\n## Alerter les secours\r\n\r\nAppelez immédiatement les secours en précisant le lieu exact de l\'accident, le nombre de blessés et leur état apparent, la nature de l\'accident et les risques particuliers comme une fuite de carburant ou un câble électrique arraché.\r\n\r\nLes numéros à composer sont le 15 pour le SAMU, le 18 pour les pompiers, le 17 pour la police, ou le 112 depuis n\'importe quel téléphone.\r\n\r\nSecourir sans aggraver\r\n\r\nSi une personne est blessée, parlez-lui pour la rassurer et lui demander de ne pas bouger. Ne déplacez jamais un blessé sauf en cas de danger immédiat comme un incendie, car un mauvais déplacement peut aggraver une blessure à la colonne vertébrale.\r\n\r\nSi une personne est inconsciente mais respire, placez-la en Position Latérale de Sécurité (PLS). Si elle ne respire plus, pratiquez un massage cardiaque si vous êtes formé et attendez les secours.\r\n\r\nLe constat amiable\r\n\r\nEn l\'absence de blessé, remplissez un constat amiable avec l\'autre conducteur. Notez les informations essentielles : noms, adresses, plaques d\'immatriculation, assureurs, et numéros de contrat. Prenez des photos des dégâts et de la position des véhicules. Le constat doit être signé par les deux parties et envoyé à votre assurance dans les 5 jours ouvrés.\r\n\r\nÀ retenir\r\n\r\nEn cas d\'accident : Protéger, Alerter, Secourir. Dans cet ordre. Garder son calme est essentiel pour agir efficacement et ne pas aggraver la situation.',NULL,NULL,2,15,1,'2026-02-19 13:01:12','2026-02-19 14:30:39'),
(111,30,'Principaux facteurs d\'accidents et recommandations','Vitesse, alcool, fatigue, ceinture, téléphone, distances, infrastructure.',NULL,NULL,3,20,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(112,26,'Intersection',NULL,NULL,'https://ange-raphael.supahuman.site/pratique/Intersection.mp4',3,10,1,'2026-02-19 14:11:52','2026-02-19 14:11:52'),
(113,31,'Quelque definition et concept de base','Quelque definition et concept de base','https://ange-raphael.supahuman.site/theorique/base.html',NULL,1,15,1,'2026-02-19 16:16:48','2026-02-19 15:20:27'),
(114,31,'Definition de la route','Definition de la route','https://ange-raphael.supahuman.site/theorique/definition.html',NULL,2,15,1,'2026-02-19 16:16:48','2026-02-19 15:20:43'),
(115,31,'Role de la route','Role de la route','https://ange-raphael.supahuman.site/theorique/role.html',NULL,3,15,1,'2026-02-19 16:16:48','2026-02-19 15:20:57'),
(116,31,'Les principale partie d\'une route','Les principale partie d\'une route','https://ange-raphael.supahuman.site/theorique/partie.html',NULL,4,15,1,'2026-02-19 16:16:48','2026-02-19 16:02:45'),
(117,31,'Les type de routes','Les type de routes','https://ange-raphael.supahuman.site/theorique/type.html',NULL,5,15,1,'2026-02-19 16:16:48','2026-02-19 16:03:02'),
(120,31,'Les routes en agglomations','Les routes en agglomations','https://ange-raphael.supahuman.site/theorique/agglomeration.html',NULL,8,15,1,'2026-02-19 16:16:48','2026-02-19 16:03:25'),
(122,32,'definition , role et classification des vehicules','definition , role et classification des vehicules','https://ange-raphael.supahuman.site/theorique/vehicule.html',NULL,1,15,1,'2026-02-19 16:16:48','2026-02-19 16:48:21'),
(124,32,'Les principaux organes du vehicules','Les principaux organes du vehicules','https://ange-raphael.supahuman.site/theorique/organe.html',NULL,3,15,1,'2026-02-19 16:16:48','2026-02-19 16:48:35'),
(125,32,'le controle et l\'entretien du vehicule','le controle et l\'entretien du vehicule','https://ange-raphael.supahuman.site/theorique/entretien.html',NULL,4,15,1,'2026-02-19 16:16:48','2026-02-19 16:48:50'),
(127,33,'Definition et caracterisques d\'un signal','Definition et caracterisques d\'un signal','https://ange-raphael.supahuman.site/theorique/signalisation.html',NULL,1,15,1,'2026-02-19 16:16:48','2026-02-25 08:51:11'),
(129,33,'injonctions des agents reglant la circulation','injonctions des agents reglant la circulation','https://ange-raphael.supahuman.site/theorique/agent.html',NULL,3,15,1,'2026-02-19 16:16:48','2026-02-25 08:52:22'),
(134,34,'Dispositions generale','Dispositions generale','https://ange-raphael.supahuman.site/theorique/regle.html',NULL,1,25,1,'2026-02-19 16:16:48','2026-02-19 17:40:48'),
(141,35,'Regle administrative de circulation des vehicules automobile','Regle administrative de circulation des vehicules automobile','https://ange-raphael.supahuman.site/theorique/adminstratif.html',NULL,3,30,1,'2026-02-19 16:16:48','2026-02-25 08:58:14'),
(143,36,'Les infractions au code de la route et leur consequence','Les infractions au code de la route et leur consequence','https://ange-raphael.supahuman.site/theorique/penale.html',NULL,2,20,1,'2026-02-19 16:16:48','2026-02-19 18:12:00'),
(152,33,'tous les panneaux de signalisation et marquages routiers',NULL,'https://ange-raphael.supahuman.site/theorique/signaux_marquage.html',NULL,5,10,1,'2026-02-19 16:58:16','2026-02-19 17:30:55');
/*!40000 ALTER TABLE `lecons` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `lieux_pratique`
--

DROP TABLE IF EXISTS `lieux_pratique`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lieux_pratique` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lieux_pratique`
--

LOCK TABLES `lieux_pratique` WRITE;
/*!40000 ALTER TABLE `lieux_pratique` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `lieux_pratique` ENABLE KEYS */;
UNLOCK TABLES;
commit;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_12_14_064938_create_auto_ecole_tables',1),
(6,'2025_12_14_075252_create_personal_access_tokens_table',2),
(7,'2025_12_15_create_cni_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('theorique','pratique') NOT NULL,
  `type_permis` enum('permis_a','permis_b','tous') NOT NULL DEFAULT 'tous',
  `ordre` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `modules` VALUES
(2,'Apprentissage de l\'utilisation des commandes','S\'installer, regarder, avertir, démarrer et s\'arrêter','pratique','tous',2,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(3,'Utilisation du volant','Maîtrise des techniques de tenue et de rotation du volant','pratique','tous',3,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(4,'Maîtrise du véhicule','Embrayage, freinage, boîte de vitesses, direction avant/arrière, rangement','pratique','tous',4,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(5,'Vérifications et entretien','Entretien courant, dépannage et conduite économique','pratique','tous',5,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(6,'Adaptations à la circulation','Règles de circulation, signalisation, comportements en conduite','pratique','tous',6,1,'2026-02-19 13:01:12','2026-02-19 13:01:12'),
(7,'Module theorique Auto ecole','Cours theorique de conduite auto','theorique','tous',1,1,'2026-02-19 16:16:48','2026-02-19 15:17:54');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;
commit;

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

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `personal_access_tokens` VALUES
(3,'App\\Models\\AutoEcoleUser',4,'auto-ecole-token','234b1bb7a6d77807425df4fa06fe5fb610a3db284d7e6cd0c4961d4b3426411b','[\"*\"]','2026-02-25 10:00:46',NULL,'2026-02-25 08:18:34','2026-02-25 10:00:46');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `progression_lecons`
--

DROP TABLE IF EXISTS `progression_lecons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `progression_lecons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `lecon_id` bigint(20) unsigned NOT NULL,
  `completee` tinyint(1) NOT NULL DEFAULT 0,
  `date_completion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `progression_lecons_user_id_lecon_id_unique` (`user_id`,`lecon_id`),
  KEY `progression_lecons_lecon_id_foreign` (`lecon_id`),
  CONSTRAINT `progression_lecons_lecon_id_foreign` FOREIGN KEY (`lecon_id`) REFERENCES `lecons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `progression_lecons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `progression_lecons`
--

LOCK TABLES `progression_lecons` WRITE;
/*!40000 ALTER TABLE `progression_lecons` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `progression_lecons` VALUES
(1,4,113,1,'2026-02-25 08:27:53','2026-02-25 08:27:53','2026-02-25 08:27:53'),
(2,4,114,1,'2026-02-25 08:28:01','2026-02-25 08:28:01','2026-02-25 08:28:01'),
(3,4,115,1,'2026-02-25 08:28:09','2026-02-25 08:28:09','2026-02-25 08:28:09'),
(4,4,116,1,'2026-02-25 08:28:35','2026-02-25 08:28:25','2026-02-25 08:28:35'),
(5,4,117,1,'2026-02-25 08:36:42','2026-02-25 08:36:42','2026-02-25 08:36:42'),
(6,4,120,1,'2026-02-25 08:37:04','2026-02-25 08:37:04','2026-02-25 08:37:04'),
(7,4,122,1,'2026-02-25 08:39:20','2026-02-25 08:39:20','2026-02-25 08:39:20'),
(8,4,124,1,'2026-02-25 08:39:28','2026-02-25 08:39:28','2026-02-25 08:39:28'),
(9,4,125,1,'2026-02-25 08:39:32','2026-02-25 08:39:32','2026-02-25 08:39:32'),
(10,4,127,1,'2026-02-25 08:53:06','2026-02-25 08:53:06','2026-02-25 08:53:06'),
(11,4,129,1,'2026-02-25 08:53:17','2026-02-25 08:53:17','2026-02-25 08:53:17'),
(12,4,152,1,'2026-02-25 08:53:24','2026-02-25 08:53:24','2026-02-25 08:53:24'),
(13,4,134,1,'2026-02-25 08:55:03','2026-02-25 08:55:03','2026-02-25 08:55:03'),
(14,4,141,1,'2026-02-25 08:58:49','2026-02-25 08:58:49','2026-02-25 08:58:49'),
(15,4,143,1,'2026-02-25 09:00:00','2026-02-25 09:00:00','2026-02-25 09:00:00'),
(16,4,21,1,'2026-02-25 09:07:55','2026-02-25 09:07:55','2026-02-25 09:07:55'),
(17,4,22,1,'2026-02-25 09:08:09','2026-02-25 09:08:09','2026-02-25 09:08:09'),
(18,4,23,1,'2026-02-25 09:08:34','2026-02-25 09:08:34','2026-02-25 09:08:34'),
(19,4,24,1,'2026-02-25 09:12:24','2026-02-25 09:12:24','2026-02-25 09:12:24'),
(20,4,25,1,'2026-02-25 09:12:41','2026-02-25 09:12:41','2026-02-25 09:12:41'),
(21,4,27,1,'2026-02-25 09:16:18','2026-02-25 09:16:18','2026-02-25 09:16:18'),
(22,4,28,1,'2026-02-25 09:16:32','2026-02-25 09:16:32','2026-02-25 09:16:32'),
(23,4,29,1,'2026-02-25 09:16:45','2026-02-25 09:16:45','2026-02-25 09:16:45'),
(24,4,30,1,'2026-02-25 09:17:56','2026-02-25 09:17:56','2026-02-25 09:17:56'),
(25,4,32,1,'2026-02-25 09:18:10','2026-02-25 09:18:10','2026-02-25 09:18:10'),
(26,4,34,1,'2026-02-25 09:19:11','2026-02-25 09:19:11','2026-02-25 09:19:11'),
(27,4,35,1,'2026-02-25 09:19:22','2026-02-25 09:19:22','2026-02-25 09:19:22'),
(28,4,36,1,'2026-02-25 09:19:32','2026-02-25 09:19:32','2026-02-25 09:19:32'),
(29,4,37,1,'2026-02-25 09:20:11','2026-02-25 09:20:11','2026-02-25 09:20:11'),
(30,4,38,1,'2026-02-25 09:20:20','2026-02-25 09:20:20','2026-02-25 09:20:20'),
(31,4,40,1,'2026-02-25 09:20:48','2026-02-25 09:20:48','2026-02-25 09:20:48'),
(32,4,41,1,'2026-02-25 09:21:05','2026-02-25 09:21:05','2026-02-25 09:21:05'),
(33,4,42,1,'2026-02-25 09:21:47','2026-02-25 09:21:47','2026-02-25 09:21:47'),
(34,4,43,1,'2026-02-25 09:22:29','2026-02-25 09:22:29','2026-02-25 09:22:29'),
(35,4,46,1,'2026-02-25 09:23:10','2026-02-25 09:23:10','2026-02-25 09:23:10'),
(36,4,47,1,'2026-02-25 09:24:15','2026-02-25 09:24:15','2026-02-25 09:24:15'),
(37,4,48,1,'2026-02-25 09:24:31','2026-02-25 09:24:31','2026-02-25 09:24:31'),
(38,4,49,1,'2026-02-25 09:25:34','2026-02-25 09:25:34','2026-02-25 09:25:34'),
(39,4,50,1,'2026-02-25 09:30:07','2026-02-25 09:30:07','2026-02-25 09:30:07'),
(40,4,51,1,'2026-02-25 09:30:29','2026-02-25 09:30:29','2026-02-25 09:30:29'),
(41,4,52,1,'2026-02-25 09:31:04','2026-02-25 09:31:04','2026-02-25 09:31:04'),
(42,4,53,1,'2026-02-25 09:31:16','2026-02-25 09:31:16','2026-02-25 09:31:16'),
(43,4,54,1,'2026-02-25 09:31:31','2026-02-25 09:31:31','2026-02-25 09:31:31'),
(44,4,58,1,'2026-02-25 09:32:08','2026-02-25 09:32:08','2026-02-25 09:32:08'),
(45,4,59,1,'2026-02-25 09:33:04','2026-02-25 09:33:04','2026-02-25 09:33:04'),
(46,4,60,1,'2026-02-25 09:33:37','2026-02-25 09:33:37','2026-02-25 09:33:37'),
(47,4,61,1,'2026-02-25 09:33:50','2026-02-25 09:33:50','2026-02-25 09:33:50'),
(48,4,62,1,'2026-02-25 09:47:42','2026-02-25 09:47:42','2026-02-25 09:47:42'),
(49,4,63,1,'2026-02-25 09:47:53','2026-02-25 09:47:53','2026-02-25 09:47:53'),
(50,4,64,1,'2026-02-25 09:48:34','2026-02-25 09:48:34','2026-02-25 09:48:34'),
(51,4,65,1,'2026-02-25 09:48:46','2026-02-25 09:48:46','2026-02-25 09:48:46'),
(52,4,66,1,'2026-02-25 09:48:57','2026-02-25 09:48:57','2026-02-25 09:48:57'),
(53,4,67,1,'2026-02-25 09:49:31','2026-02-25 09:49:31','2026-02-25 09:49:31'),
(54,4,72,1,'2026-02-25 09:50:16','2026-02-25 09:50:16','2026-02-25 09:50:16'),
(55,4,75,1,'2026-02-25 09:50:56','2026-02-25 09:50:56','2026-02-25 09:50:56'),
(56,4,76,1,'2026-02-25 09:52:21','2026-02-25 09:52:21','2026-02-25 09:52:21'),
(57,4,77,1,'2026-02-25 09:52:32','2026-02-25 09:52:32','2026-02-25 09:52:32'),
(58,4,78,1,'2026-02-25 09:52:43','2026-02-25 09:52:43','2026-02-25 09:52:43'),
(59,4,79,1,'2026-02-25 09:53:15','2026-02-25 09:53:15','2026-02-25 09:53:15'),
(60,4,80,1,'2026-02-25 09:53:25','2026-02-25 09:53:25','2026-02-25 09:53:25'),
(61,4,81,1,'2026-02-25 09:53:35','2026-02-25 09:53:35','2026-02-25 09:53:35'),
(62,4,82,1,'2026-02-25 09:53:44','2026-02-25 09:53:44','2026-02-25 09:53:44'),
(63,4,83,1,'2026-02-25 09:53:49','2026-02-25 09:53:49','2026-02-25 09:53:49'),
(64,4,84,1,'2026-02-25 09:54:29','2026-02-25 09:54:29','2026-02-25 09:54:29'),
(65,4,85,1,'2026-02-25 09:54:34','2026-02-25 09:54:34','2026-02-25 09:54:34'),
(66,4,86,1,'2026-02-25 09:54:47','2026-02-25 09:54:47','2026-02-25 09:54:47'),
(67,4,88,1,'2026-02-25 09:55:04','2026-02-25 09:55:04','2026-02-25 09:55:04'),
(68,4,93,1,'2026-02-25 09:55:47','2026-02-25 09:55:47','2026-02-25 09:55:47'),
(69,4,94,1,'2026-02-25 09:55:52','2026-02-25 09:55:52','2026-02-25 09:55:52'),
(70,4,95,1,'2026-02-25 09:56:31','2026-02-25 09:56:31','2026-02-25 09:56:31'),
(71,4,97,1,'2026-02-25 09:56:40','2026-02-25 09:56:40','2026-02-25 09:56:40'),
(72,4,112,1,'2026-02-25 09:56:50','2026-02-25 09:56:50','2026-02-25 09:56:50'),
(73,4,99,1,'2026-02-25 09:57:27','2026-02-25 09:57:27','2026-02-25 09:57:27'),
(74,4,101,1,'2026-02-25 09:57:36','2026-02-25 09:57:36','2026-02-25 09:57:36'),
(75,4,102,1,'2026-02-25 09:58:13','2026-02-25 09:58:13','2026-02-25 09:58:13'),
(76,4,103,1,'2026-02-25 09:58:25','2026-02-25 09:58:25','2026-02-25 09:58:25'),
(77,4,104,1,'2026-02-25 09:58:58','2026-02-25 09:58:58','2026-02-25 09:58:58'),
(78,4,105,1,'2026-02-25 09:59:09','2026-02-25 09:59:09','2026-02-25 09:59:09'),
(79,4,108,1,'2026-02-25 09:59:18','2026-02-25 09:59:18','2026-02-25 09:59:18'),
(80,4,109,1,'2026-02-25 10:00:00','2026-02-25 10:00:00','2026-02-25 10:00:00'),
(81,4,110,1,'2026-02-25 10:00:08','2026-02-25 10:00:08','2026-02-25 10:00:08'),
(82,4,111,1,'2026-02-25 10:00:13','2026-02-25 10:00:13','2026-02-25 10:00:13');
/*!40000 ALTER TABLE `progression_lecons` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` bigint(20) unsigned NOT NULL,
  `enonce` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `type` enum('qcm','vrai_faux') NOT NULL,
  `explication` text DEFAULT NULL,
  `ordre` int(11) NOT NULL DEFAULT 0,
  `points` int(11) NOT NULL DEFAULT 1,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_quiz_id_foreign` (`quiz_id`),
  CONSTRAINT `questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3071 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `questions` VALUES
(501,5,'Avant de démarrer, quelle est la première chose à régler ?',NULL,'qcm','Le siège doit être réglé en premier pour atteindre confortablement toutes les commandes.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(502,5,'Le rétroviseur intérieur doit permettre de voir :',NULL,'qcm','Le rétroviseur intérieur doit cadrer la totalité de la lunette arrière.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(503,5,'La ceinture de sécurité doit être bouclée avant de démarrer.',NULL,'vrai_faux','La ceinture est obligatoire pour le conducteur et tous les passagers avant tout déplacement.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(504,5,'Les rétroviseurs extérieurs doivent être réglés de façon à voir :',NULL,'qcm','Chaque rétroviseur extérieur doit montrer une fine bande de carrosserie et la route derrière.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(505,5,'Un passager supplémentaire à l\'arrière influence la conduite.',NULL,'vrai_faux','Un passager modifie le centre de gravité et le comportement du véhicule.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(506,5,'Quel réglage faut-il effectuer si les pédales sont trop éloignées ?',NULL,'qcm','Il faut reculer ou avancer le siège longitudinalement pour atteindre les pédales confortablement.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(507,5,'Les bagages placés sur la plage arrière peuvent devenir des projectiles en cas de freinage brusque.',NULL,'vrai_faux','Des bagages mal fixés peuvent blesser les occupants lors d\'un freinage d\'urgence.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(508,5,'Le dossier du siège conducteur doit être positionné :',NULL,'qcm','Un dossier quasi vertical permet un bon contrôle du volant sans fatiguer les bras.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(509,5,'Avant de partir, il faut vérifier que les vitres sont propres et dégagées.',NULL,'vrai_faux','Une mauvaise visibilité à travers les vitres est une cause d\'accident.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(510,5,'Un enfant de moins de 10 ans doit être installé :',NULL,'qcm','Les enfants de moins de 10 ans doivent utiliser un siège ou dispositif homologué.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(601,6,'Un angle mort est une zone que le conducteur ne peut pas voir avec les rétroviseurs.',NULL,'vrai_faux','Les angles morts sont des zones non couvertes par les rétroviseurs ; il faut tourner la tête.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(602,6,'À quelle fréquence doit-on consulter les rétroviseurs en conduite normale ?',NULL,'qcm','Vérifier les rétroviseurs toutes les 5 à 8 secondes permet d\'anticiper les situations.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(603,6,'Avant un changement de voie à gauche, le conducteur doit regarder dans :',NULL,'qcm','Il faut consulter le rétroviseur central, le rétroviseur gauche puis l\'angle mort gauche.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(604,6,'Le regard doit être fixé sur la route juste devant le capot pour une bonne conduite.',NULL,'vrai_faux','Le regard doit être loin devant (horizon) pour anticiper, pas juste devant le capot.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(605,6,'Quel est le principal angle mort d\'un véhicule de tourisme ?',NULL,'qcm','Les angles morts principaux se situent sur les côtés arrière gauche et droit du véhicule.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(606,6,'Pour vérifier un angle mort, le conducteur doit :',NULL,'qcm','Tourner brièvement la tête vers la zone concernée est indispensable car les rétroviseurs ne couvrent pas cet espace.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(607,6,'Le rétroviseur extérieur droit est obligatoire sur tout véhicule de tourisme.',NULL,'vrai_faux','Les deux rétroviseurs extérieurs sont obligatoires pour assurer la visibilité latérale.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(608,6,'Le regard mobile permet au conducteur de :',NULL,'qcm','Balayer visuellement l\'environnement permet d\'anticiper les dangers et d\'agir à temps.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(609,6,'Avant de tourner à droite en ville, il faut vérifier l\'angle mort droit pour les cyclistes.',NULL,'vrai_faux','Les cyclistes se placent souvent dans les angles morts ; il faut les vérifier avant de tourner.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(610,6,'Un rétroviseur panoramique (grand-angle) élimine totalement les angles morts.',NULL,'vrai_faux','Aucun rétroviseur n\'élimine totalement les angles morts ; la vérification par rotation de la tête reste indispensable.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(701,7,'En sortant du véhicule dans une rue passante, il faut ouvrir la portière côté trottoir en premier.',NULL,'vrai_faux','Descendre du côté trottoir évite d\'ouvrir la portière face à la circulation.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(702,7,'Avant d\'ouvrir une portière, le conducteur doit :',NULL,'qcm','Vérifier dans les rétroviseurs et par-dessus l\'épaule est indispensable pour éviter de blesser un usager vulnérable.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(703,7,'Un pneu dégonflé peut être détecté visuellement avant de prendre le volant.',NULL,'vrai_faux','Il faut faire le tour du véhicule avant de partir pour vérifier l\'état des pneus.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(704,7,'Dans une allée de parking très étroite, il faut prioritairement :',NULL,'qcm','Vérifier l\'espace disponible de chaque côté évite les accrochages avec les obstacles latéraux.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(705,7,'Laisser le moteur tourner pendant une longue attente dans un garage fermé est sans danger.',NULL,'vrai_faux','Les gaz d\'échappement (monoxyde de carbone) sont mortels en espace confiné.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(706,7,'Quelle est la bonne procédure pour monter dans le véhicule en côte ?',NULL,'qcm','Se tenir à la carrosserie et entrer rapidement limite le risque de glissade ou de choc.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(707,7,'Une portière mal fermée peut s\'ouvrir brusquement en roulant et causer un accident.',NULL,'vrai_faux','Une portière non verrouillée est une cause directe d\'accident grave.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(708,7,'La zone de visibilité réduite autour d\'un véhicule est particulièrement dangereuse pour :',NULL,'qcm','Les enfants et les personnes petites sont invisibles dans les angles morts proches du véhicule.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(709,7,'Avant de reculer dans une cour, il faut faire le tour du véhicule à pied.',NULL,'vrai_faux','Inspecter la zone à pied permet de détecter obstacles et personnes non visibles de l\'habitacle.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(710,7,'En stationnement en pente, il faut toujours serrer le frein à main quelle que soit l\'inclinaison.',NULL,'vrai_faux','Le frein à main doit être serré en stationnement pour éviter tout mouvement incontrôlé.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(801,8,'Les clignotants doivent être activés combien de temps avant une manœuvre ?',NULL,'qcm','Activer les clignotants suffisamment à l\'avance prévient les autres usagers de vos intentions.',1,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(802,8,'L\'avertisseur sonore peut être utilisé librement en agglomération la nuit.',NULL,'vrai_faux','En agglomération, entre 22h et 6h, l\'usage du klaxon est interdit sauf danger immédiat.',2,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(803,8,'Les feux de détresse s\'utilisent lorsque le véhicule constitue un obstacle imprévu.',NULL,'vrai_faux','Les feux de détresse signalent une immobilisation imprévue ou un danger sur la chaussée.',3,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(804,8,'Un conducteur doit mettre son clignotant droit pour :',NULL,'qcm','Le clignotant droit indique tout déplacement vers la droite (voie, créneau, arrêt).',4,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(805,8,'Le klaxon peut avertir un conducteur qui s\'apprête à empiéter sur votre voie.',NULL,'vrai_faux','L\'avertisseur sonore est autorisé hors agglomération pour prévenir un danger imminent.',5,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(806,8,'Les feux de détresse doivent être utilisés en cas de :',NULL,'qcm','Les feux de détresse signalent un danger ou une immobilisation afin d\'alerter les autres usagers.',6,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(807,8,'Le clignotant doit être désactivé manuellement si le volant ne le coupe pas automatiquement.',NULL,'vrai_faux','Après certaines manœuvres légères, le clignotant ne se désactive pas seul ; le conducteur doit le couper.',7,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(808,8,'Les appels de phares servent à avertir d\'un danger ou à signaler sa présence.',NULL,'vrai_faux','Les appels de phares peuvent signaler un danger, demander le passage ou indiquer sa présence.',8,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(809,8,'Lorsque le véhicule est en panne sur autoroute, on doit mettre les feux de détresse ET placer un triangle de signalisation.',NULL,'vrai_faux','La réglementation impose feux de détresse + triangle à 30 m minimum sur autoroute pour sécuriser la zone.',9,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(810,8,'Un conducteur qui souhaite tourner à gauche doit mettre son clignotant :',NULL,'qcm','Le clignotant gauche s\'active avant et pendant la manœuvre de tournage à gauche.',10,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(901,9,'Avant de démarrer, le levier de vitesse doit être en position :',NULL,'qcm','Le point mort est requis pour démarrer sans risquer un démarrage en traction brutale.',1,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(902,9,'Pour démarrer en côte sans rouler en arrière, on peut utiliser :',NULL,'qcm','Le frein à main maintient le véhicule pendant le passage du point de patinage de l\'embrayage.',2,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(903,9,'Après un calage, il faut remettre le levier en point mort avant de relancer le démarreur.',NULL,'vrai_faux','Relancer en prise entraînerait un bond dangereux du véhicule.',3,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(904,9,'Pour arrêter le moteur, il faut couper le contact après avoir stoppé le véhicule.',NULL,'vrai_faux','Le moteur doit être arrêté uniquement lorsque le véhicule est immobilisé et en point mort.',4,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(905,9,'En descente, pour repartir il faut engager une vitesse basse et doser le frein.',NULL,'vrai_faux','Partir en descente avec un rapport adapté évite le survoltage et garantit le contrôle.',5,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(906,9,'Le frein à main doit être serré avant de couper le contact en stationnement.',NULL,'vrai_faux','Le frein à main immobilise le véhicule et prévient tout mouvement non souhaité.',6,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(907,9,'Pour s\'arrêter à un endroit précis, on doit :',NULL,'qcm','Anticiper et freiner progressivement permet de s\'arrêter exactement à l\'endroit voulu.',7,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(908,9,'Le calage du moteur survient lorsque l\'embrayage est relâché trop rapidement à bas régime.',NULL,'vrai_faux','Un relâchement trop brusque de l\'embrayage à bas régime éteint le moteur (calage).',8,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(909,9,'Pour démarrer sur terrain plat, quelle est la bonne séquence ?',NULL,'qcm','La séquence correcte garantit un démarrage souple et sécurisé.',9,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(910,9,'Après un long stationnement, il est inutile de vérifier les alentours avant de démarrer.',NULL,'vrai_faux','Vérifier les alentours avant tout départ est une règle de sécurité fondamentale.',10,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1001,10,'La position recommandée des mains sur le volant en ligne droite est dite \"9h15\" ou \"10h10\".',NULL,'vrai_faux','Ces positions offrent un bon contrôle du volant et laissent les pouces accessibles aux commandes.',1,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1002,10,'Conduire avec une seule main sur le volant en ligne droite est toujours recommandé.',NULL,'vrai_faux','Les deux mains sur le volant garantissent un meilleur contrôle notamment en cas d\'imprévus.',2,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1003,10,'En ligne droite, la pression exercée sur le volant doit être :',NULL,'qcm','Une pression ferme mais souple permet de corriger sans fatigue et de réagir rapidement.',3,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1004,10,'Sur autoroute, les mains peuvent reposer sur les genoux car la route est rectiligne.',NULL,'vrai_faux','Les mains doivent toujours rester sur le volant pour réagir à tout imprévu.',4,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1005,10,'Une légère déviation du véhicule en ligne droite peut indiquer :',NULL,'qcm','Un mauvais parallélisme ou un pneu sous-gonflé peut provoquer une dérive.',5,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1006,10,'Les pouces doivent entourer la jante du volant, pas rester en extension.',NULL,'vrai_faux','Les pouces autour de la jante évitent de les blesser en cas de choc du volant (rebond).',6,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1007,10,'En ligne droite, la direction des yeux doit être :',NULL,'qcm','Regarder loin devant permet d\'anticiper et de maintenir naturellement la trajectoire.',7,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1008,10,'Tenir le volant uniquement par le bas (6h) est une bonne pratique.',NULL,'vrai_faux','Tenir le volant par le bas réduit le contrôle et le temps de réaction.',8,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1009,10,'Sur route avec ornières, le conducteur doit exercer une pression plus ferme sur le volant.',NULL,'vrai_faux','Les irrégularités de la route transmettent des chocs au volant ; une prise ferme maintient la trajectoire.',9,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1010,10,'En cas de crevaison, des mains bien placées sur le volant permettent de garder le contrôle.',NULL,'vrai_faux','Une bonne tenue du volant est essentielle pour contrôler le véhicule lors d\'une crevaison subite.',10,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1101,11,'La technique \"sans déplacer les mains\" est adaptée pour les virages :',NULL,'qcm','Cette technique est utilisée pour les légères corrections de trajectoire en ligne droite ou virages doux.',1,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1102,11,'En rotation avec chevauchement des mains, les deux mains se croisent sur la couronne.',NULL,'vrai_faux','Dans la technique de chevauchement, une main pousse pendant que l\'autre tire en passant au-dessus.',2,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1103,11,'La technique de rotation avec \"simple déplacement des mains\" convient pour les virages prononcés en stationnement.',NULL,'vrai_faux','Cette technique donne une plus grande amplitude de rotation, utile pour les manœuvres à faible vitesse.',3,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1104,11,'Après un virage, le volant doit revenir en position droite :',NULL,'qcm','Le volant doit être ramené activement pour reprendre la trajectoire souhaitée.',4,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1105,11,'Il est dangereux de lâcher le volant pour le laisser revenir seul à grande vitesse.',NULL,'vrai_faux','À grande vitesse, lâcher le volant pour le laisser revenir peut provoquer une perte de contrôle.',5,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1106,11,'La technique de chevauchement des mains est déconseillée à haute vitesse car elle réduit le contrôle.',NULL,'vrai_faux','À haute vitesse, le chevauchement des mains diminue la capacité de réaction rapide.',6,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1107,11,'La position de la main gauche reste fixe pendant toute la rotation dans la technique \"sans déplacer les mains\".',NULL,'vrai_faux','Dans cette technique, les deux mains restent fixes sur la couronne et exercent une poussée-traction.',7,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1108,11,'La méthode de rotation \"par simple déplacement\" consiste à :',NULL,'qcm','Une main tire en glissant sur la couronne tandis que l\'autre accompagne le mouvement.',8,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1109,11,'En marche arrière, la rotation du volant produit l\'effet inverse de la marche avant.',NULL,'vrai_faux','En marche arrière, tourner à droite fait aller l\'arrière à droite mais l\'avant à gauche.',9,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1110,11,'Pour un demi-tour complet du volant, on utilise plutôt la technique :',NULL,'qcm','Le chevauchement permet une amplitude maximale de rotation du volant.',10,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1201,12,'Le \"point de patinage\" de l\'embrayage correspond au moment où :',NULL,'qcm','Le point de patinage est l\'instant où les disques d\'embrayage commencent à entraîner la roue.',1,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1202,12,'Il faut laisser le pied sur la pédale d\'embrayage en roulant en palier.',NULL,'vrai_faux','Garder le pied sur l\'embrayage use prématurément la butée de débrayage.',2,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1203,12,'Pour passer de la 1re à la 2e vitesse à 20 km/h, on doit :',NULL,'qcm','La séquence correcte est : débrayer → sélectionner 2e → embrayer progressivement.',3,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1204,12,'Lorsqu\'on roule en 4e et qu\'on doit freiner, on passe en 3e avant de freiner.',NULL,'vrai_faux','On freine d\'abord puis on rétrograde au rapport adapté à la nouvelle vitesse.',4,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1205,12,'Pour démarrer en côte sans reculer sans frein à main, on peut utiliser :',NULL,'qcm','Le frein de service maintient le véhicule pendant le dosage embrayage/accélérateur.',5,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1206,12,'Un embrayage trop rapide à bas régime provoque :',NULL,'qcm','Un embrayage trop rapide avec un régime trop bas éteint le moteur (calage).',6,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1207,12,'L\'embrayage doit toujours être relâché progressivement au démarrage.',NULL,'vrai_faux','Un relâchement progressif permet un démarrage souple sans à-coups.',7,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1208,12,'Le patinage excessif de l\'embrayage (pédale à mi-course longtemps) use le disque.',NULL,'vrai_faux','Un patinage prolongé génère une forte chaleur qui détériore le disque d\'embrayage.',8,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1209,12,'En descente prononcée, il est recommandé d\'enfoncer l\'embrayage pour freiner plus vite.',NULL,'vrai_faux','En descente, il faut garder une vitesse enclenchée pour bénéficier du frein moteur.',9,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1210,12,'En circulation urbaine, les changements de vitesse doivent être :',NULL,'qcm','Des changements fréquents et adaptés à la circulation fluide réduisent la consommation et l\'usure.',10,2,1,'2026-02-19 16:02:58','2026-02-19 16:02:58'),
(1301,13,'Le frein principal (pédale) agit sur :',NULL,'qcm','Le frein à pédale actionne les freins des quatre roues via le circuit hydraulique.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1302,13,'L\'ABS empêche le blocage des roues lors d\'un freinage d\'urgence.',NULL,'vrai_faux','L\'ABS module automatiquement la pression de freinage pour éviter le blocage des roues.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1303,13,'Le frein à main doit être utilisé pour freiner à grande vitesse.',NULL,'vrai_faux','Le frein à main est un frein de stationnement ; à haute vitesse, son utilisation peut provoquer un tête-à-queue.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1304,13,'Le frein moteur est obtenu en :',NULL,'qcm','Rétrograder dans un rapport inférieur permet au moteur de freiner naturellement le véhicule.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1305,13,'Freiner fort puis moduler est plus efficace que freiner légèrement sur une longue distance.',NULL,'vrai_faux','Le freinage progressif mais ferme est plus court et contrôlé que le freinage tardif à fond.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1306,13,'En cas de défaillance du frein principal, il faut immédiatement :',NULL,'qcm','Utiliser le frein à main progressivement et rétrograder permet de ralentir en gardant le contrôle.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1307,13,'Sur sol mouillé, la distance de freinage augmente par rapport au sol sec.',NULL,'vrai_faux','Sur sol mouillé, l\'adhérence est réduite, ce qui allonge considérablement la distance de freinage.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1308,13,'Le frein moteur est particulièrement utile en descente car il :',NULL,'qcm','Le frein moteur soulage les freins en descente et évite leur surchauffe.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1309,13,'Il faut enfoncer l\'embrayage simultanément au freinage d\'urgence.',NULL,'vrai_faux','En freinage d\'urgence, on freine à fond ; l\'embrayage est enfoncé seulement juste avant l\'arrêt pour éviter le calage.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1310,13,'L\'usage du frein à main en roulant peut bloquer les roues arrière et provoquer un tête-à-queue.',NULL,'vrai_faux','Le frein à main agit sur les roues arrière ; son utilisation en marche peut déstabiliser le véhicule.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1401,14,'Pour passer la première vitesse depuis le point mort, le levier de vitesse doit être poussé vers :',NULL,'qcm','La position de la 1re vitesse est en haut à gauche sur la majorité des boîtes de vitesses 5/6.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1402,14,'La montée des vitesses doit se faire de manière progressive (1→2→3…) sans sauter de rapport.',NULL,'vrai_faux','On peut sauter des rapports (exemple : 3→5) pour une conduite plus économique si la vitesse le permet.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1403,14,'Rouler trop longtemps dans un rapport trop bas (sur-régime) entraîne une surconsommation.',NULL,'vrai_faux','Le sur-régime consomme plus de carburant et use le moteur inutilement.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1404,14,'En descente prononcée, il est conseillé de passer en rapport bas pour utiliser le frein moteur.',NULL,'vrai_faux','Un rapport bas en descente freine naturellement le véhicule et préserve les freins.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1405,14,'Le démarrage de secours (sans démarreur) nécessite :',NULL,'qcm','Pour un démarrage de secours, le véhicule est poussé ou lancé en côte, on embraye brusquement en 2e.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1406,14,'Le rétrogradage doit se faire moteur à un régime adapté pour éviter les à-coups.',NULL,'vrai_faux','Rétrograder avec un régime adéquat assure une transition douce et sécurisée.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1407,14,'En ville, quel rapport est généralement utilisé entre 30 et 50 km/h ?',NULL,'qcm','La 3e vitesse correspond à une plage de 30-50 km/h en circulation urbaine.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1408,14,'Il est possible de rétrograder de la 5e à la 3e directement.',NULL,'vrai_faux','On peut sauter des rapports en rétrogradant si la vitesse du véhicule est adaptée.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1409,14,'Laisser le levier de vitesse en point mort en descente est une bonne pratique d\'économie.',NULL,'vrai_faux','Rouler au point mort en descente est dangereux ; on perd le frein moteur et le contrôle.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1410,14,'La marche arrière ne doit être engagée que lorsque le véhicule est complètement arrêté.',NULL,'vrai_faux','Engager la marche arrière en roulant peut endommager la boîte de vitesses.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1501,15,'À grande vitesse, les mouvements du volant doivent être :',NULL,'qcm','À haute vitesse, les corrections doivent être fines pour éviter une réaction exagérée du véhicule.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1502,15,'Pour maintenir une trajectoire rectiligne sur route bombée, le conducteur doit :',NULL,'qcm','La dévers de la route pousse le véhicule vers la droite ; il faut compenser légèrement.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1503,15,'On peut utiliser le régulateur de vitesse tout en regardant dans les rétroviseurs.',NULL,'vrai_faux','Le régulateur maintient la vitesse mais le conducteur reste entièrement responsable de la trajectoire.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1504,15,'En ligne droite sur autoroute, il est inutile de corriger le volant.',NULL,'vrai_faux','Des micro-corrections constantes du volant sont nécessaires pour maintenir la trajectoire.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1505,15,'Manipuler le GPS en conduisant en ligne droite est sans danger si on ne regarde que 2 secondes.',NULL,'vrai_faux','À 90 km/h, 2 secondes de distraction représentent 50 mètres parcourus les yeux fermés.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1506,15,'La direction assistée permet au conducteur de braquer sans effort mais il reste responsable du contrôle.',NULL,'vrai_faux','La direction assistée facilite le braquage mais n\'enlève pas la responsabilité du conducteur.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1507,15,'À quelle vitesse la sur-direction du volant est-elle particulièrement dangereuse ?',NULL,'qcm','À grande vitesse, un sur-braquage provoque une instabilité et un risque de tête-à-queue.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1508,15,'Pour maintenir sa trajectoire en passant dans une flaque d\'eau, il faut :',NULL,'qcm','Garder le volant droit et ne pas freiner évite l\'aquaplanage et le dérapage.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1509,15,'En cas d\'aquaplanage, freiner à fond permet de retrouver l\'adhérence plus vite.',NULL,'vrai_faux','En aquaplanage, il faut lever le pied de l\'accélérateur sans freiner brusquement.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1510,15,'Le gabarit du véhicule doit être pris en compte pour maintenir une trajectoire sécurisée.',NULL,'vrai_faux','Le conducteur doit intégrer la largeur et la longueur du véhicule dans le calcul de ses trajectoires.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1601,16,'En marche arrière, tourner le volant vers la droite déplace l\'arrière du véhicule vers la droite.',NULL,'vrai_faux','Oui, en marche arrière le volant agit de la même façon que l\'avant, mais l\'avant part dans la direction opposée.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1602,16,'Pendant une marche arrière, la vitesse doit être :',NULL,'qcm','La marche arrière doit toujours être effectuée lentement pour garder le contrôle.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1603,16,'Pour surveiller la trajectoire en marche arrière, le conducteur doit :',NULL,'qcm','Retourner la tête et utiliser les rétroviseurs ensemble offre la meilleure visibilité.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1604,16,'Un demi-tour en 3 manœuvres est interdit si la chaussée est inférieure à 6 mètres de large.',NULL,'vrai_faux','La largeur minimale autorisée peut varier, mais plus la chaussée est étroite plus le demi-tour est risqué.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1605,16,'Lors d\'une marche arrière en courbe à gauche, le volant doit être tourné vers :',NULL,'qcm','Pour suivre une courbe vers la gauche en marche arrière, on braque à gauche.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1606,16,'En marche arrière, les feux de recul (blancs) s\'allument automatiquement.',NULL,'vrai_faux','Les feux de recul s\'allument automatiquement lorsque la marche arrière est engagée.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1607,16,'Avant d\'effectuer un demi-tour, on doit s\'assurer que la voie est suffisamment large et dégagée.',NULL,'vrai_faux','Un demi-tour sans vérifier la voie peut bloquer la circulation ou causer un accident.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1608,16,'La position correcte du corps en marche arrière est :',NULL,'qcm','Se retourner vers l\'arrière tout en posant la main droite sur le dossier du siège passager offre la meilleure visibilité directe.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1609,16,'Les pieds doivent rester sur les pédales en marche arrière pour pouvoir freiner rapidement.',NULL,'vrai_faux','Maintenir les pieds prêts sur les pédales permet un arrêt immédiat si nécessaire.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1610,16,'Il est interdit d\'effectuer un demi-tour à une intersection avec feux tricolores.',NULL,'vrai_faux','Le demi-tour aux intersections à feux est généralement interdit car il perturbe et met en danger la circulation.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1701,17,'Le stationnement en créneau consiste à se garer :',NULL,'qcm','Le créneau est un stationnement parallèle au trottoir entre deux véhicules.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1702,17,'Pour réussir un créneau, le conducteur doit commencer par reculer après s\'être aligné avec le véhicule de devant.',NULL,'vrai_faux','On s\'aligne avec la voiture de devant, puis on recule en braquant pour s\'insérer dans l\'espace.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1703,17,'Le stationnement en épi se fait avec un angle d\'environ :',NULL,'qcm','Le stationnement en épi est généralement à 45° ou 60° par rapport au trottoir ou à la ligne.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1704,17,'En stationnement en bataille, le véhicule est stationné perpendiculairement au trottoir.',NULL,'vrai_faux','Le stationnement en bataille (à 90°) est perpendiculaire au sens de circulation.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1705,17,'Pour sortir d\'un stationnement en épi en marche arrière, il faut vérifier les angles morts.',NULL,'vrai_faux','En sortant en marche arrière d\'un épi, les angles morts peuvent masquer des piétons ou cyclistes.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1706,17,'La distance minimale entre deux véhicules garés en créneau est :',NULL,'qcm','Il faut laisser suffisamment d\'espace (environ 50 cm) à l\'avant et à l\'arrière pour pouvoir ressortir.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1707,17,'Le frein à main doit être serré après tout stationnement, quelle que soit la pente.',NULL,'vrai_faux','Le frein à main sécurise l\'arrêt du véhicule même sur terrain plat en cas de défaillance.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1708,17,'En sortant d\'un stationnement en créneau, on doit mettre le clignotant gauche.',NULL,'vrai_faux','Le clignotant gauche indique aux usagers que l\'on quitte le stationnement en s\'insérant dans la circulation.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1709,17,'Le stationnement en bataille est plus facile à entrer mais plus difficile à sortir qu\'un créneau.',NULL,'vrai_faux','L\'entrée en bataille est simple mais la sortie en marche arrière demande de surveiller les usagers.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1710,17,'Pour un créneau réussi, l\'espace disponible doit être d\'au moins combien de fois la longueur du véhicule ?',NULL,'qcm','Un espace d\'au moins 1,5 fois la longueur du véhicule est nécessaire pour réaliser un créneau.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1801,18,'La notice constructeur indique la pression recommandée pour les pneus.',NULL,'vrai_faux','La notice contient les pressions de gonflage recommandées pour chaque configuration de charge.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1802,18,'La notice constructeur est spécifique à chaque modèle de véhicule.',NULL,'vrai_faux','Chaque véhicule a une notice adaptée à ses caractéristiques techniques.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1803,18,'La notice indique les intervalles d\'entretien recommandés par le constructeur.',NULL,'vrai_faux','Les révisions périodiques sont détaillées dans la notice pour préserver le véhicule.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1804,18,'On peut se passer de la notice si on connaît bien les véhicules en général.',NULL,'vrai_faux','Chaque modèle a des spécificités techniques propres que seule la notice de ce modèle détaille.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1805,18,'La notice indique la charge utile maximale du véhicule.',NULL,'vrai_faux','La charge utile maximale figure dans la notice et sur la plaque constructeur du véhicule.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1806,18,'La signification des voyants du tableau de bord peut être trouvée dans la notice.',NULL,'vrai_faux','La notice explique chaque voyant et la conduite à tenir lorsqu\'il s\'allume.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1807,18,'La notice indique toujours comment réaliser soi-même les réparations majeures.',NULL,'vrai_faux','La notice indique les opérations d\'entretien courant mais renvoie au professionnel pour les réparations complexes.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1808,18,'Quelle information ne figure PAS habituellement dans la notice constructeur ?',NULL,'qcm','Le tarif d\'assurance n\'est pas une donnée technique ; elle figure dans les contrats d\'assurance.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1809,18,'La notice indique la capacité du réservoir de carburant.',NULL,'vrai_faux','La capacité du réservoir est une donnée technique mentionnée dans la notice.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(1810,18,'Pour connaître le type d\'huile moteur recommandé, on consulte :',NULL,'qcm','La notice constructeur précise le type et la viscosité de l\'huile moteur adaptée.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2001,20,'Avant de changer une roue, il faut positionner le triangle de signalisation.',NULL,'vrai_faux','Le triangle protège le conducteur et les autres usagers pendant la manœuvre.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2002,20,'Le cric doit être placé sous un point de levage spécifique indiqué dans la notice.',NULL,'vrai_faux','Placer le cric au mauvais endroit peut endommager la carrosserie ou provoquer une chute.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2003,20,'Les boulons de roue doivent être desserrés avant de lever le véhicule avec le cric.',NULL,'vrai_faux','Desserrer les boulons avec la roue au sol évite que la roue tourne.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2004,20,'Après avoir changé une roue de secours, on peut rouler à la même vitesse que d\'habitude.',NULL,'vrai_faux','Une roue de secours galette impose une vitesse maximale limitée (généralement 80 km/h).',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2005,20,'Pour changer une ampoule de phare, il faut couper le contact au préalable.',NULL,'vrai_faux','Couper le contact évite un choc électrique et protège les composants électroniques.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2006,20,'Un fusible est conçu pour protéger le circuit électrique contre les surcharges.',NULL,'vrai_faux','Le fusible fond en cas de surcharge et protège ainsi le câblage et les composants.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2007,20,'Les boulons de roue doivent être serrés en croix (alternativement) pour assurer une fixation homogène.',NULL,'vrai_faux','Serrer en croix répartit la pression uniformément et évite le voilement du disque.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2008,20,'La pression de la roue de secours doit être vérifiée régulièrement même si elle n\'est pas utilisée.',NULL,'vrai_faux','Un pneu de secours sous-gonflé est inutilisable en cas de besoin.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2009,20,'Pour régler les projecteurs après remplacement d\'une ampoule, on utilise :',NULL,'qcm','Un mur blanc ou un appareil de réglage permet de vérifier et ajuster l\'orientation des phares.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2010,20,'Toucher une ampoule halogène avec les doigts nus réduit sa durée de vie.',NULL,'vrai_faux','La graisse des doigts crée des points chauds sur le verre qui fragilisent l\'ampoule halogène.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2101,21,'Le régulateur de vitesse maintient automatiquement une vitesse définie par le conducteur.',NULL,'vrai_faux','Le régulateur maintient la vitesse choisie sans action sur l\'accélérateur.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2102,21,'Le limiteur de vitesse empêche le véhicule de dépasser la vitesse programmée.',NULL,'vrai_faux','Contrairement au régulateur, le limiteur empêche de dépasser la vitesse maximale programmée.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2103,21,'Le régulateur de vitesse peut être utilisé en ville à faible vitesse sans danger.',NULL,'vrai_faux','Le régulateur est déconseillé en ville car les conditions de circulation changent trop rapidement.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2104,21,'L\'ABS permet de conserver la direction du véhicule pendant un freinage d\'urgence.',NULL,'vrai_faux','L\'ABS empêche le blocage des roues et permet de diriger le véhicule même en freinant fort.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2105,21,'En conduite économique, il faut éviter les accélérations brutales.',NULL,'vrai_faux','Les accélérations brusques consomment beaucoup plus de carburant que les accélérations progressives.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2106,21,'La conduite économique consiste à rouler le plus lentement possible.',NULL,'vrai_faux','L\'éco-conduite n\'est pas synonyme de lenteur ; elle consiste à anticiper et à optimiser la consommation.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2107,21,'Un GPS peut distraire le conducteur et provoquer un accident.',NULL,'vrai_faux','Toute interaction avec le GPS en roulant détourne l\'attention de la route.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2108,21,'Rouler à un régime moteur élevé en ville est la meilleure façon d\'économiser du carburant.',NULL,'vrai_faux','Un régime élevé est synonyme de forte consommation ; il faut monter rapidement en rapport.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2109,21,'Le GPS doit être programmé avant de démarrer, pas pendant la conduite.',NULL,'vrai_faux','Programmer le GPS en mouvement est une distraction dangereuse.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2110,21,'La conduite économique réduit à la fois la consommation de carburant et l\'usure du véhicule.',NULL,'vrai_faux','Anticiper et conduire en douceur réduit la consommation et prolonge la durée de vie des organes mécaniques.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2201,22,'Avant un long voyage, il est recommandé de vérifier le niveau de carburant et les documents du véhicule.',NULL,'vrai_faux','Vérifier carburant, papiers et itinéraire de secours est la base de toute préparation au voyage.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2202,22,'En cas de défaillance du frein principal, la première action est d\'ouvrir la portière pour ralentir.',NULL,'vrai_faux','En cas de défaillance, on utilise le frein à main progressivement et on rétrograde.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2203,22,'En cas de freinage d\'urgence avec ABS, il faut pomper le frein.',NULL,'vrai_faux','Avec l\'ABS, il faut maintenir une pression ferme et constante ; ne pas pomper.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2204,22,'Pour remorquer un véhicule en panne, la distance de remorquage doit être signalée.',NULL,'vrai_faux','Le remorquage doit respecter les règles : câble visible, vitesse limitée, feux de détresse.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2205,22,'En cas d\'incendie du véhicule, la première action est d\'éloigner les occupants.',NULL,'vrai_faux','Évacuer immédiatement les occupants est prioritaire avant toute tentative d\'extinction.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2206,22,'Un conducteur prudent emporte toujours un extincteur dans son véhicule.',NULL,'vrai_faux','Un extincteur adapté (poudre ou CO2) permet d\'intervenir rapidement sur un début d\'incendie.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2207,22,'Pour dégager la chaussée après un accident, on doit déplacer les véhicules avant l\'arrivée de la police.',NULL,'vrai_faux','Si personne n\'est blessé, dégager la chaussée est conseillé pour éviter un carambolage secondaire.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2208,22,'En cas de panne sur route, les passagers doivent rester dans le véhicule.',NULL,'vrai_faux','Sur une route rapide, les passagers doivent quitter le véhicule et s\'éloigner derrière la glissière.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2209,22,'Le triangle de pré-signalisation doit être placé à au moins 30 mètres en amont de la panne.',NULL,'vrai_faux','Le triangle doit être placé au minimum 30 m avant la panne (et plus loin sur route rapide).',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2210,22,'En cas d\'incendie moteur, ouvrir le capot rapidement est la bonne réaction.',NULL,'vrai_faux','Ouvrir le capot peut attiser les flammes en apportant de l\'oxygène ; il faut d\'abord évacuer.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2301,23,'À une intersection sans signalisation, la règle générale est de céder le passage au véhicule venant de droite.',NULL,'vrai_faux','La règle de la priorité à droite s\'applique quand aucun panneau ou marquage ne l\'indique autrement.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2302,23,'Un feu orange clignotant signifie :',NULL,'qcm','Un feu orange clignotant impose de passer avec prudence, il signale un danger ou un carrefour non géré.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2303,23,'Un panneau triangulaire à bordure rouge est un panneau de :',NULL,'qcm','Les panneaux triangulaires à bordure rouge sont des panneaux de danger ou d\'avertissement.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2304,23,'Les gestes de l\'agent de circulation priment sur les feux tricolores.',NULL,'vrai_faux','Les gestes de l\'agent ont une autorité supérieure aux feux tricolores et aux panneaux.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2305,23,'Une ligne blanche continue au centre de la route :',NULL,'qcm','Une ligne blanche continue est infranchissable pour les véhicules dans les deux sens.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2306,23,'Le panneau \"STOP\" impose de s\'arrêter même si la visibilité est parfaite.',NULL,'vrai_faux','Le panneau STOP oblige un arrêt complet quelle que soit la visibilité.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2307,23,'Un feu rouge clignotant se rencontre à :',NULL,'qcm','Le feu rouge clignotant est caractéristique des passages à niveau et de certains carrefours dangereux.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2308,23,'Le panneau rond à bordure rouge est un panneau de :',NULL,'qcm','Les panneaux ronds à bordure rouge sont des panneaux d\'interdiction ou d\'obligation.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2309,23,'Les marquages en zigzag jaune sur la chaussée indiquent une zone de stationnement interdit.',NULL,'vrai_faux','Les zigzags jaunes marquent les zones réservées aux bus ou d\'arrêt interdit selon les pays.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2310,23,'Un panneau de priorité (flèche jaune sur fond blanc) indique que vous êtes prioritaire.',NULL,'vrai_faux','Le panneau de route prioritaire indique que vous bénéficiez de la priorité sur les voies transversales.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2501,25,'La vitesse maximale en agglomération est de 50 km/h sauf indication contraire.',NULL,'vrai_faux','En agglomération, la limite générale est 50 km/h sauf panneau spécifique.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2502,25,'On doit rouler aussi près que possible du côté droit de la chaussée.',NULL,'vrai_faux','En dehors des dépassements, la règle de la droite impose de serrer le côté droit de la route.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2503,25,'Les voies réservées aux bus peuvent être empruntées par les cyclistes.',NULL,'vrai_faux','Dans de nombreux pays, les cyclistes sont autorisés à circuler sur les voies réservées aux bus.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2504,25,'La vitesse doit être adaptée aux conditions de circulation même si la limite réglementaire n\'est pas atteinte.',NULL,'vrai_faux','Adapter sa vitesse aux conditions (météo, trafic, visibilité) est une obligation légale et de sécurité.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2505,25,'Sur une route à 3 voies, le conducteur peut circuler dans la voie de gauche en permanence.',NULL,'vrai_faux','La voie de gauche est réservée aux dépassements ; on doit revenir à droite après avoir dépassé.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2506,25,'La limitation de vitesse sur autoroute est généralement de :',NULL,'qcm','La vitesse maximale sur autoroute est de 100 km/h dans la plupart des pays africains.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2507,25,'Rouler trop lentement sans raison valable peut constituer une infraction.',NULL,'vrai_faux','Une vitesse anormalement basse sans raison perturbe la circulation et peut être sanctionnée.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2508,25,'Le marquage en pointillés blancs sépare les voies de même sens.',NULL,'vrai_faux','Les pointillés blancs délimitent les voies de même sens et peuvent être franchis.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2509,25,'La vitesse de réaction augmente lorsque le conducteur est fatigué.',NULL,'vrai_faux','La fatigue ralentit les réflexes, ce qui allonge le temps de réaction.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2510,25,'Une voie de décélération permet au conducteur de :',NULL,'qcm','La voie de décélération est utilisée pour réduire sa vitesse avant de quitter une voie rapide.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2601,26,'La distance de sécurité minimale correspond à la distance parcourue en 2 secondes.',NULL,'vrai_faux','La règle des 2 secondes est la méthode simple pour évaluer une distance de sécurité suffisante.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2602,26,'Par mauvais temps, la distance de sécurité doit être augmentée.',NULL,'vrai_faux','La pluie ou le verglas réduit l\'adhérence et allonge la distance de freinage.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2603,26,'À une intersection, on doit d\'abord détecter puis évaluer avant d\'agir.',NULL,'vrai_faux','La séquence DÉTECTER → ÉVALUER → AGIR est fondamentale pour franchir les intersections en sécurité.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2604,26,'Un conducteur qui sous-estime la vitesse d\'un véhicule venant en face risque de :',NULL,'qcm','Sous-estimer la vitesse d\'un véhicule en face peut conduire à une tentative de dépassement suicidaire.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2605,26,'En ville, la distance de sécurité est moins importante qu\'en rase campagne.',NULL,'vrai_faux','En ville, la distance de sécurité reste cruciale car les réactions inattendues sont fréquentes.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2606,26,'Le gabarit du véhicule doit être pris en compte lors du franchissement d\'une intersection étroite.',NULL,'vrai_faux','La largeur du véhicule conditionne la manière de franchir les intersections et les passages étroits.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2607,26,'À quelle vitesse la distance d\'arrêt d\'un véhicule est-elle la plus courte ?',NULL,'qcm','Plus la vitesse est faible, plus la distance d\'arrêt est courte.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2608,26,'Le croisement sur route étroite nécessite de tenir compte de la largeur des deux véhicules.',NULL,'vrai_faux','En croisement serré, les deux conducteurs doivent ajuster leur position latérale.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2609,26,'Un camion en face semble moins rapide qu\'une voiture car il est plus grand.',NULL,'vrai_faux','La taille du véhicule crée une illusion d\'optique qui fait sous-estimer sa vitesse.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2610,26,'Pour estimer la distance de sécurité, on choisit un point fixe et on vérifie si le véhicule devant le dépasse avant nous.',NULL,'vrai_faux','C\'est la méthode du \"repère fixe\" pour mesurer la règle des 2 secondes.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2701,27,'Le dépassement est interdit dans les virages et au sommet des côtes.',NULL,'vrai_faux','Dépasser en virage ou en haut d\'une côte est très dangereux car la visibilité est insuffisante.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2702,27,'Pour dépasser, il faut signaler son intention à l\'avance avec le clignotant gauche.',NULL,'vrai_faux','Activer le clignotant avant le dépassement prévient les autres usagers.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2703,27,'La force centrifuge en virage tend à pousser le véhicule vers :',NULL,'qcm','La force centrifuge pousse le véhicule vers l\'extérieur du virage.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2704,27,'Pour faciliter le dépassement du véhicule derrière soi, on peut serrer à droite et ralentir légèrement.',NULL,'vrai_faux','Faciliter le dépassement par le véhicule derrière est une règle de courtoisie et de sécurité.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2705,27,'En virage, la trajectoire idéale consiste à :',NULL,'qcm','La bonne trajectoire est : aborder large, couper la corde, ressortir large pour limiter la force centrifuge.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2706,27,'Pendant un dépassement, le conducteur doit maintenir une vitesse supérieure à celle du véhicule dépassé.',NULL,'vrai_faux','Pour réduire le temps d\'exposition au danger, le dépassement doit être effectué rapidement.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2707,27,'Le croisement est difficile si les deux véhicules ont un gabarit important.',NULL,'vrai_faux','En croisement de poids lourds, chaque conducteur doit ajuster sa position latérale.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2708,27,'La distance de visibilité avant un dépassement doit être suffisante pour dépasser et revenir.',NULL,'vrai_faux','La distance libre doit permettre de dépasser et de réintégrer la file en sécurité.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2709,27,'Freiner en virage augmente le risque de dérapage.',NULL,'vrai_faux','Freiner en virage peut provoquer un blocage des roues et un dérapage car l\'adhérence est déjà sollicitée.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2710,27,'Le dépassement par la droite est interdit sauf si le véhicule de devant tourne à gauche.',NULL,'vrai_faux','Le dépassement par la droite est interdit sauf situations réglementairement définies.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2801,28,'Il est interdit de stationner devant une entrée carrossable.',NULL,'vrai_faux','Bloquer une entrée carrossable est une infraction au code de la route.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2802,28,'En cas d\'arrêt d\'urgence sur route, on doit mettre les feux de détresse et placer un triangle.',NULL,'vrai_faux','Cette obligation de sécurité protège les occupants et les autres usagers.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2803,28,'Les piétons ont toujours la priorité aux passages cloutés.',NULL,'vrai_faux','Les piétons ont la priorité sur les passages pour piétons dûment signalisés.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2804,28,'Un stationnement gênant est moins grave qu\'un stationnement dangereux.',NULL,'vrai_faux','Ces deux infractions sont sanctionnées différemment ; le stationnement dangereux est plus grave.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2805,28,'En approchant d\'un véhicule de transport scolaire à l\'arrêt, le conducteur doit :',NULL,'qcm','Des enfants peuvent traverser imprévisiblement autour d\'un bus scolaire à l\'arrêt.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2806,28,'Les motocyclistes sont plus vulnérables que les automobilistes car ils n\'ont pas de carrosserie protectrice.',NULL,'vrai_faux','Les deux-roues motorisés sont des usagers vulnérables car ils sont moins visibles et moins protégés.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2807,28,'Les véhicules de secours (ambulances, pompiers) doivent être laissés passer.',NULL,'vrai_faux','Il est obligatoire de céder le passage aux véhicules prioritaires avec gyrophare et sirène.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2808,28,'On peut stationner sur un trottoir si la chaussée est encombrée.',NULL,'vrai_faux','Le stationnement sur trottoir est interdit car il gêne les piétons, notamment les PMR.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2809,28,'Un conducteur doit réduire sa vitesse en passant près d\'un cycliste.',NULL,'vrai_faux','Le cycliste est un usager vulnérable ; il faut s\'éloigner et réduire la vitesse en le croisant.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2810,28,'La durée maximale d\'un arrêt momentané est :',NULL,'qcm','Un arrêt est considéré momentané si le conducteur reste présent et prêt à repartir immédiatement.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2901,29,'La nuit, la distance de visibilité diminue et la vitesse doit être adaptée en conséquence.',NULL,'vrai_faux','De nuit, on ne voit que ce que les phares éclairent ; la vitesse doit permettre de s\'arrêter dans cette distance.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2902,29,'Sur chaussée mouillée, le temps de freinage est multiplié par environ :',NULL,'qcm','Sur chaussée mouillée, la distance de freinage est environ double de celle sur sol sec.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2903,29,'En cas de verglas, il est recommandé d\'utiliser les freinages brusques pour s\'arrêter.',NULL,'vrai_faux','Sur verglas, tout mouvement brusque provoque une perte d\'adhérence ; il faut être très progressif.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2904,29,'En montagne, les freins peuvent surchauffer en descente si l\'on ne rétrograde pas.',NULL,'vrai_faux','En longue descente, utiliser le frein moteur préserve les freins de la surchauffe.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2905,29,'En tunnel, il faut allumer les feux de croisement même de jour.',NULL,'vrai_faux','Le Code de la route impose l\'allumage des feux en tunnel.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2906,29,'Les premiers signes de fatigue au volant sont :',NULL,'qcm','Les picotements aux yeux et les bâillements répétés sont des signaux d\'alarme de la fatigue.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2907,29,'Pour lutter contre la fatigue, il suffit d\'ouvrir la fenêtre et de mettre de la musique forte.',NULL,'vrai_faux','Ces techniques sont temporaires ; la seule solution est de s\'arrêter et se reposer.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2908,29,'La lecture de carte ou de GPS doit être faite avant de prendre la route.',NULL,'vrai_faux','Consulter une carte en roulant est une distraction majeure.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2909,29,'En montagne, le conducteur prioritaire dans un croisement difficile est :',NULL,'qcm','En montagne, le véhicule montant est prioritaire car il est plus difficile de redémarrer en côte.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(2910,29,'Par forte pluie, l\'aquaplanage peut survenir même à vitesse modérée.',NULL,'vrai_faux','L\'aquaplanage dépend de l\'épaisseur de la lame d\'eau et de l\'état des pneus, pas seulement de la vitesse.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3001,30,'L\'alcool ralentit le temps de réaction du conducteur.',NULL,'vrai_faux','L\'alcool altère les réflexes et allonge considérablement le temps de réaction.',1,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3002,30,'Le café ou une douche froide permettent de faire baisser rapidement le taux d\'alcoolémie.',NULL,'vrai_faux','Seul le temps permet d\'éliminer l\'alcool ; café et douche froide n\'ont aucun effet sur l\'alcoolémie.',2,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3003,30,'Le délit de fuite après un accident est passible de sanctions pénales.',NULL,'vrai_faux','Quitter les lieux d\'un accident sans s\'arrêter est un délit grave pénalement sanctionné.',3,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3004,30,'La non-assistance à personne en danger est une infraction.',NULL,'vrai_faux','Ne pas porter secours à une victime d\'accident alors qu\'on peut le faire sans risque est un délit.',4,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3005,30,'L\'utilisation du téléphone portable en conduisant multiplie le risque d\'accident par :',NULL,'qcm','L\'usage du téléphone au volant multiplie le risque d\'accident par 3 à 4.',5,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3006,30,'La vitesse excessive est l\'une des premières causes de mortalité sur la route.',NULL,'vrai_faux','La vitesse est impliquée dans environ 30% des accidents mortels selon les statistiques routières.',6,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3007,30,'Balisage d\'un accident : le triangle doit être placé du côté de la circulation qui s\'approche.',NULL,'vrai_faux','Le triangle doit être placé en amont de l\'accident pour avertir les véhicules qui arrivent.',7,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3008,30,'L\'alcool au volant augmente la prise de risques en diminuant le sens du danger.',NULL,'vrai_faux','L\'alcool altère le jugement et le sens des risques, poussant à des comportements plus dangereux.',8,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3009,30,'En cas d\'accident avec blessés, la priorité est d\'appeler les secours.',NULL,'vrai_faux','Alerter les secours (police, pompiers, SAMU) est la première action à réaliser.',9,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3010,30,'La fatigue au volant a des effets comparables à ceux de l\'alcool sur la conduite.',NULL,'vrai_faux','La privation de sommeil affecte les réflexes, le jugement et l\'attention comme le ferait l\'alcool.',10,2,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(3011,31,'Qu\'est-ce qu\'une route selon le code de la route ?',NULL,'qcm','La route est une voie de communication terrestre aménagée pour la circulation des véhicules.',1,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3012,31,'Quel est le rôle principal de la route ?',NULL,'qcm','La route permet la circulation des personnes et des biens d\'un lieu à un autre de manière sécurisée.',2,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3013,31,'Parmi les éléments suivants, lequel fait partie des principales parties d\'une route ?',NULL,'qcm','La chaussée est la partie centrale de la route réservée à la circulation des véhicules.',3,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3014,31,'L\'autoroute est réservée :',NULL,'qcm','L\'autoroute est exclusivement réservée aux véhicules à moteur et interdit aux piétons, cyclistes et engins lents.',4,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3015,31,'Une agglomération est définie comme :',NULL,'qcm','Une agglomération est un espace sur lequel sont groupés des immeubles bâtis rapprochés dont l\'entrée et la sortie sont signalées par des panneaux.',5,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3016,31,'L\'accotement d\'une route est :',NULL,'qcm','L\'accotement est la partie latérale de la route située entre la chaussée et le fossé ou le talus.',6,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3017,31,'Les routes nationales sont classées dans la catégorie des routes :',NULL,'qcm','Les routes nationales sont des voies de communication d\'intérêt national reliant les grandes villes du pays.',7,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3018,31,'Vrai ou Faux : Un trottoir fait partie des principales parties d\'une route en agglomération.',NULL,'vrai_faux','Vrai. Le trottoir est la partie surélevée de la route réservée aux piétons en agglomération.',8,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3019,31,'Un aménagement routier a pour but de :',NULL,'qcm','Les aménagements routiers visent à améliorer la sécurité et fluidité du trafic (dos d\'âne, ralentisseurs, ilots, etc.).',9,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3020,31,'Vrai ou Faux : Une voie express et une autoroute sont identiques.',NULL,'vrai_faux','Faux. La voie express est une route à chaussées séparées mais avec des accès à niveau possibles, contrairement à l\'autoroute qui n\'a que des accès dénivelés.',10,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3021,32,'Un véhicule automobile est défini comme :',NULL,'qcm','Un véhicule automobile est tout engin propulsé par un moteur, conçu pour se déplacer sur une route.',1,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3022,32,'La carrosserie d\'un véhicule a pour rôle principal de :',NULL,'qcm','La carrosserie protège les occupants et supporte la structure esthétique du véhicule.',2,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3023,32,'Le système de freinage a pour rôle de :',NULL,'qcm','Le frein permet de réduire la vitesse ou d\'immobiliser le véhicule en toute sécurité.',3,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3024,32,'Avant de prendre la route, le conducteur doit vérifier :',NULL,'qcm','Le contrôle avant départ inclut les niveaux (huile, eau, carburant), les pneumatiques, les feux et les freins.',4,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3025,32,'Le PTAC (Poids Total Autorisé en Charge) représente :',NULL,'qcm','Le PTAC est le poids maximum auquel peut être chargé un véhicule, déterminé par le constructeur et inscrit sur la carte grise.',5,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3026,32,'Quelle est la fonction du moteur dans un véhicule ?',NULL,'qcm','Le moteur transforme l\'énergie (thermique, électrique) en énergie mécanique pour propulser le véhicule.',6,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3027,32,'Vrai ou Faux : Le contrôle technique d\'un véhicule est obligatoire.',NULL,'vrai_faux','Vrai. Le contrôle technique est obligatoire pour s\'assurer que le véhicule respecte les normes de sécurité en vigueur.',7,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3028,32,'La direction d\'un véhicule permet de :',NULL,'qcm','La direction permet au conducteur d\'orienter les roues directrices afin de guider le véhicule.',8,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3029,32,'Un véhicule surchargé présente comme principal danger :',NULL,'qcm','La surcharge allonge la distance de freinage, déséquilibre le véhicule et augmente l\'usure des pneumatiques.',9,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3030,32,'Vrai ou Faux : L\'état des pneumatiques n\'a aucune influence sur la tenue de route.',NULL,'vrai_faux','Faux. Des pneumatiques usés ou sous-gonflés réduisent l\'adhérence et augmentent le risque d\'accident.',10,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3031,33,'Un panneau triangulaire à fond blanc et liseré rouge indique :',NULL,'qcm','Les panneaux triangulaires sont des panneaux de danger qui avertissent le conducteur d\'un danger proche.',1,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3032,33,'Un feu tricolore rouge signifie :',NULL,'qcm','Le feu rouge impose un arrêt absolu avant la ligne d\'arrêt.',2,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3033,33,'Un panneau circulaire à fond bleu indique :',NULL,'qcm','Les panneaux circulaires à fond bleu sont des panneaux d\'obligation ou d\'indication positive.',3,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3034,33,'Les marquages au sol de couleur jaune continue interdisent :',NULL,'qcm','Une ligne jaune continue au sol interdit le stationnement sur la portion concernée.',4,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3035,33,'Lorsqu\'un agent de police fait face aux conducteurs avec les bras étendus horizontalement, cela signifie :',NULL,'qcm','L\'agent face aux conducteurs bras horizontaux = STOP, les conducteurs doivent s\'arrêter.',5,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3036,33,'Vrai ou Faux : Un panneau d\'interdiction est toujours de forme ronde.',NULL,'vrai_faux','Vrai. Les panneaux d\'interdiction sont de forme circulaire avec un liseré rouge.',6,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3037,33,'Un feu orange (jaune) fixe signifie :',NULL,'qcm','Le feu orange fixe annonce le passage au rouge et impose un arrêt, sauf si l\'arrêt est dangereux.',7,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3038,33,'La ligne blanche continue au milieu de la chaussée interdit :',NULL,'qcm','La ligne continue blanche au centre interdit le franchissement et le dépassement.',8,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3039,33,'Quel est l\'ordre d\'autorité des signaux sur la route ?',NULL,'qcm','L\'ordre de priorité est : agents de police > feux tricolores > panneaux > marquages au sol.',9,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3040,33,'Vrai ou Faux : Un panneau rectangulaire à fond bleu donne une indication de direction ou d\'information.',NULL,'vrai_faux','Vrai. Les panneaux rectangulaires bleus sont des panneaux d\'indication (direction, services, etc.).',10,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3041,34,'En agglomération, la vitesse maximale autorisée est de :',NULL,'qcm','En agglomération, la vitesse est limitée à 50 km/h sauf indication contraire.',1,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3042,34,'La distance de sécurité entre deux véhicules doit être au minimum de :',NULL,'qcm','La distance de sécurité doit au moins égaler la distance parcourue en 2 secondes, soit environ la moitié du compteur en mètres.',2,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3043,34,'Le dépassement est interdit dans les situations suivantes :',NULL,'qcm','Le dépassement est interdit dans les virages, les côtes, aux intersections, sur les passages piétons et en présence de ligne continue.',3,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3044,34,'À une intersection non réglementée, la priorité appartient à :',NULL,'qcm','À une intersection sans signalisation, on applique la règle de la priorité à droite.',4,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3045,34,'Vrai ou Faux : Il est permis de faire demi-tour sur une autoroute.',NULL,'vrai_faux','Faux. Le demi-tour est strictement interdit sur les autoroutes.',5,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3046,34,'En cas de brouillard dense, le conducteur doit :',NULL,'qcm','Par brouillard dense, le conducteur doit réduire sa vitesse, allumer les feux antibrouillard et augmenter la distance de sécurité.',6,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3047,34,'Le croisement de nuit s\'effectue avec :',NULL,'qcm','La nuit en cas de croisement, on passe des feux de route aux feux de croisement (code) pour ne pas éblouir le conducteur venant en face.',7,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3048,34,'Sur une chaussée à double sens avec ligne blanche continue, vous devez :',NULL,'qcm','La ligne continue interdit le franchissement : le conducteur doit rester de son côté.',8,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3049,34,'La vitesse maximale autorisée sur autoroute est généralement de :',NULL,'qcm','Sur autoroute hors agglomération, la vitesse maximale est généralement fixée à 120 km/h par temps sec.',9,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3050,34,'Vrai ou Faux : Le conducteur peut stationner sur un passage piéton.',NULL,'vrai_faux','Faux. Le stationnement sur un passage piéton est strictement interdit car il met en danger les piétons.',10,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3051,35,'Le permis de conduire de catégorie B autorise la conduite de :',NULL,'qcm','Le permis B autorise la conduite des voitures particulières et des véhicules dont le PTAC ne dépasse pas 3,5 tonnes.',1,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3052,35,'La carte grise (certificat d\'immatriculation) est :',NULL,'qcm','La carte grise est le document officiel attestant l\'immatriculation d\'un véhicule et les informations de son propriétaire.',2,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3053,35,'Vrai ou Faux : Il est obligatoire de présenter son permis de conduire à tout agent de police qui le demande.',NULL,'vrai_faux','Vrai. Tout conducteur est tenu de présenter son permis de conduire à toute réquisition des agents de l\'ordre.',3,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3054,35,'Un élève conducteur peut conduire sur la route publique :',NULL,'qcm','Un élève conducteur peut circuler sur la voie publique uniquement en conduite accompagnée avec un moniteur agréé ou sous les conditions légales définies.',4,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3055,35,'Le certificat de visite technique d\'un véhicule est délivré par :',NULL,'qcm','Le contrôle technique est effectué dans des centres agréés par l\'État.',5,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3056,35,'Quel document doit obligatoirement se trouver à bord du véhicule ?',NULL,'qcm','À bord, le conducteur doit avoir : le permis de conduire, la carte grise et l\'attestation d\'assurance.',6,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3057,35,'Le permis de conduire de catégorie A autorise la conduite :',NULL,'qcm','Le permis A est destiné aux motocyclettes.',7,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3058,35,'Vrai ou Faux : Une auto-école doit être agréée par les autorités compétentes pour dispenser des cours de conduite.',NULL,'vrai_faux','Vrai. Toute auto-école doit disposer d\'un agrément délivré par le ministère en charge des transports.',8,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3059,35,'En cas de changement de domicile, le propriétaire d\'un véhicule doit :',NULL,'qcm','En cas de changement d\'adresse, le propriétaire doit faire modifier sa carte grise dans les délais légaux.',9,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3060,35,'La suspension du permis de conduire peut être prononcée par :',NULL,'qcm','La suspension du permis de conduire est prononcée par les autorités judiciaires ou administratives compétentes.',10,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3061,36,'L\'assurance responsabilité civile automobile est :',NULL,'qcm','L\'assurance RC auto est obligatoire pour tout véhicule circulant sur la voie publique. Elle couvre les dommages causés aux tiers.',1,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3062,36,'Un conducteur en état d\'ivresse (taux d\'alcool supérieur au seuil légal) engage sa responsabilité :',NULL,'qcm','La conduite sous l\'emprise de l\'alcool engage à la fois la responsabilité pénale (infraction) et civile (réparation des dommages).',2,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3063,36,'Vrai ou Faux : Circuler sans attestation d\'assurance est une infraction punissable par la loi.',NULL,'vrai_faux','Vrai. La non-présentation de l\'attestation d\'assurance est une infraction au code de la route passible de sanction.',3,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3064,36,'La responsabilité pénale du conducteur peut être engagée en cas de :',NULL,'qcm','La responsabilité pénale s\'applique en cas d\'infraction au code de la route (excès de vitesse grave, conduite en état d\'ivresse, homicide involontaire, etc.).',4,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3065,36,'L\'attestation d\'assurance doit être présentée :',NULL,'qcm','L\'attestation d\'assurance doit être présentée à toute réquisition des forces de l\'ordre.',5,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3066,36,'En cas d\'accident de la route avec blessés, le conducteur responsable doit :',NULL,'qcm','En cas d\'accident avec blessés, le conducteur doit s\'arrêter, sécuriser les lieux, porter secours aux victimes et prévenir les secours.',6,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3067,36,'Vrai ou Faux : Le délit de fuite après un accident est une infraction pénale grave.',NULL,'vrai_faux','Vrai. Le délit de fuite est une infraction pénale qui aggrave la responsabilité du conducteur impliqué dans un accident.',7,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3068,36,'La responsabilité civile consiste à :',NULL,'qcm','La responsabilité civile oblige le responsable d\'un dommage à le réparer financièrement, généralement par l\'intermédiaire de son assureur.',8,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3069,36,'Un grand excès de vitesse (dépassement important de la limite autorisée) peut entraîner :',NULL,'qcm','Un grand excès de vitesse peut entraîner une amende importante, la suspension ou l\'annulation du permis de conduire, voire une peine d\'emprisonnement.',9,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(3070,36,'Vrai ou Faux : Un conducteur peut être poursuivi pénalement même s\'il n\'a pas causé d\'accident, uniquement pour une infraction grave au code de la route.',NULL,'vrai_faux','Vrai. Certaines infractions graves (ivresse au volant, grand excès de vitesse) peuvent être poursuivies pénalement même sans accident.',10,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chapitre_id` bigint(20) unsigned NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `note_passage` int(11) NOT NULL DEFAULT 12,
  `duree_minutes` int(11) NOT NULL DEFAULT 30,
  `ordre` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_chapitre_id_foreign` (`chapitre_id`),
  CONSTRAINT `quiz_chapitre_id_foreign` FOREIGN KEY (`chapitre_id`) REFERENCES `chapitres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz`
--

LOCK TABLES `quiz` WRITE;
/*!40000 ALTER TABLE `quiz` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `quiz` VALUES
(5,5,'Quiz – S\'installer au poste de conduite','Évaluation sur les réglages et la mise en sécurité avant départ.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(6,6,'Quiz – Regarder autour de soi','Évaluation sur la gestion du regard, des angles morts et des rétroviseurs.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(7,7,'Quiz – Agir sans mettre en danger','Évaluation sur les précautions à la montée/descente et à l\'ouverture.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(8,8,'Quiz – Avertir les autres usagers','Évaluation sur l\'utilisation des clignotants, klaxon et feux d\'urgence.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(9,9,'Quiz – Démarrer et s\'arrêter','Évaluation sur les procédures de démarrage et d\'arrêt du véhicule.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(10,10,'Quiz – Tenue du volant en ligne droite','Évaluation sur la position des mains et le maintien du cap.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(11,11,'Quiz – Rotation du volant','Évaluation sur les trois techniques de rotation du volant.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(12,12,'Quiz – Utilisation de l\'embrayage','Évaluation sur l\'embrayage en circulation et le démarrage en côte.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(13,13,'Quiz – Utilisation des freins','Évaluation sur les différents types de freinage.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(14,14,'Quiz – Utilisation de la boîte de vitesses','Évaluation sur les rapports, montée et rétrogradage.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(15,15,'Quiz – Diriger la voiture en avant','Évaluation sur la direction et le maintien de trajectoire.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(16,16,'Quiz – Diriger la voiture en arrière','Évaluation sur la marche arrière et le demi-tour.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(17,17,'Quiz – Ranger la voiture','Évaluation sur les techniques de stationnement.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(18,18,'Quiz – Lecture de la notice constructeur','Évaluation sur l\'exploitation de la notice du véhicule.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(20,20,'Quiz – Changement de roue et ampoule','Évaluation sur les interventions de première urgence.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(21,21,'Quiz – Aides à la conduite et conduite économique','Évaluation sur les équipements d\'assistance et l\'éco-conduite.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(22,22,'Quiz – Prévisions et situations d\'urgence','Évaluation sur la gestion des pannes et des situations critiques.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(23,23,'Quiz – Règles de circulation et signalisation','Évaluation sur les règles, panneaux, feux et gestes de l\'agent.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(25,25,'Quiz – Vitesse et voie de circulation','Évaluation sur le choix de la vitesse et de la voie.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(26,26,'Quiz – Distances de sécurité et intersections','Évaluation sur les distances et le franchissement des intersections.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(27,27,'Quiz – Dépassement, croisement et virages','Évaluation sur les règles de dépassement, croisement et prise de virage.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(28,28,'Quiz – Arrêt, stationnement et usagers','Évaluation sur la réglementation et le comportement envers les usagers.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(29,29,'Quiz – Conditions particulières de conduite','Évaluation sur la conduite de nuit, par adhérence réduite et en montagne.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(30,30,'Quiz – Alcool, accidents et facteurs de risque','Évaluation sur les effets de l\'alcool, la conduite à tenir et les risques.',12,30,1,1,'2026-02-19 16:02:59','2026-02-19 16:02:59'),
(31,31,'Quiz - Définitions et concepts de base','Évaluez vos connaissances sur les définitions fondamentales du code de la route.',12,20,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(32,32,'Quiz - Organes et dispositifs du véhicule','Testez vos connaissances sur les parties, organes et entretien du véhicule.',12,20,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(33,33,'Quiz - Signalisation routière','Évaluez vos connaissances sur les panneaux, marquages et signaux lumineux.',12,20,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(34,34,'Quiz - Règles de circulation routière','Testez vos connaissances sur les règles de vitesse, dépassement et circulation.',12,20,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(35,35,'Quiz - Règles administratives','Testez vos connaissances sur le permis de conduire et les règles administratives.',12,20,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44'),
(36,36,'Quiz - Responsabilité civile et pénale','Testez vos connaissances sur l\'assurance, les infractions et leurs conséquences.',12,20,1,1,'2026-02-19 20:53:44','2026-02-19 20:53:44');
/*!40000 ALTER TABLE `quiz` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reponses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint(20) unsigned NOT NULL,
  `texte` text NOT NULL,
  `est_correcte` tinyint(1) NOT NULL DEFAULT 0,
  `ordre` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reponses_question_id_foreign` (`question_id`),
  CONSTRAINT `reponses_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=893 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reponses`
--

LOCK TABLES `reponses` WRITE;
/*!40000 ALTER TABLE `reponses` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `reponses` VALUES
(1,501,'Le siège conducteur',1,1,NULL,NULL),
(2,501,'Les rétroviseurs extérieurs',0,2,NULL,NULL),
(3,501,'La ceinture de sécurité',0,3,NULL,NULL),
(4,501,'Le volant',0,4,NULL,NULL),
(5,502,'L\'intégralité de la lunette arrière',1,1,NULL,NULL),
(6,502,'Une partie de la banquette arrière uniquement',0,2,NULL,NULL),
(7,502,'Le côté gauche de la route',0,3,NULL,NULL),
(8,502,'Le tableau de bord',0,4,NULL,NULL),
(9,503,'Vrai',1,1,NULL,NULL),
(10,503,'Faux',0,2,NULL,NULL),
(11,504,'Une fine bande de carrosserie et la chaussée derrière',1,1,NULL,NULL),
(12,504,'Uniquement la chaussée sur les côtés',0,2,NULL,NULL),
(13,504,'Le capot moteur',0,3,NULL,NULL),
(14,504,'L\'intérieur du véhicule',0,4,NULL,NULL),
(15,505,'Vrai',1,1,NULL,NULL),
(16,505,'Faux',0,2,NULL,NULL),
(17,506,'Avancer ou reculer le siège longitudinalement',1,1,NULL,NULL),
(18,506,'Régler l\'inclinaison du dossier',0,2,NULL,NULL),
(19,506,'Régler la hauteur du siège uniquement',0,3,NULL,NULL),
(20,506,'Rien, il faut s\'adapter',0,4,NULL,NULL),
(21,507,'Vrai',1,1,NULL,NULL),
(22,507,'Faux',0,2,NULL,NULL),
(23,508,'Quasi vertical, légèrement incliné vers l\'arrière',1,1,NULL,NULL),
(24,508,'Fortement incliné vers l\'arrière',0,2,NULL,NULL),
(25,508,'Complètement droit à 90°',0,3,NULL,NULL),
(26,508,'Incliné vers l\'avant pour mieux voir',0,4,NULL,NULL),
(27,509,'Vrai',1,1,NULL,NULL),
(28,509,'Faux',0,2,NULL,NULL),
(29,510,'Dans un siège auto ou rehausseur homologué',1,1,NULL,NULL),
(30,510,'Sur la banquette arrière sans dispositif particulier',0,2,NULL,NULL),
(31,510,'À l\'avant avec la ceinture normale',0,3,NULL,NULL),
(32,510,'Sur les genoux d\'un adulte à l\'arrière',0,4,NULL,NULL),
(33,601,'Vrai',1,1,NULL,NULL),
(34,601,'Faux',0,2,NULL,NULL),
(35,602,'Toutes les 5 à 8 secondes',1,1,NULL,NULL),
(36,602,'Uniquement avant de changer de voie',0,2,NULL,NULL),
(37,602,'Une fois par minute',0,3,NULL,NULL),
(38,602,'Seulement en agglomération',0,4,NULL,NULL),
(39,603,'Rétroviseur central, rétroviseur gauche, puis angle mort gauche',1,1,NULL,NULL),
(40,603,'Uniquement le rétroviseur central',0,2,NULL,NULL),
(41,603,'L\'angle mort droit',0,3,NULL,NULL),
(42,603,'Rétroviseur droit uniquement',0,4,NULL,NULL),
(43,604,'Vrai',0,1,NULL,NULL),
(44,604,'Faux',1,2,NULL,NULL),
(45,605,'Les zones latérales arrière gauche et droit',1,1,NULL,NULL),
(46,605,'La zone directement devant le capot',0,2,NULL,NULL),
(47,605,'La zone derrière le véhicule',0,3,NULL,NULL),
(48,605,'La zone à gauche du conducteur uniquement',0,4,NULL,NULL),
(49,606,'Tourner brièvement la tête vers la zone concernée',1,1,NULL,NULL),
(50,606,'Regarder uniquement dans le rétroviseur intérieur',0,2,NULL,NULL),
(51,606,'Klaxonner pour avertir',0,3,NULL,NULL),
(52,606,'Ralentir et attendre',0,4,NULL,NULL),
(53,607,'Vrai',1,1,NULL,NULL),
(54,607,'Faux',0,2,NULL,NULL),
(55,608,'Balayer visuellement l\'environnement et anticiper les dangers',1,1,NULL,NULL),
(56,608,'Voir uniquement devant soi',0,2,NULL,NULL),
(57,608,'Regarder plus rapidement pour conduire plus vite',0,3,NULL,NULL),
(58,608,'Éviter de regarder les rétroviseurs',0,4,NULL,NULL),
(59,609,'Vrai',1,1,NULL,NULL),
(60,609,'Faux',0,2,NULL,NULL),
(61,610,'Vrai',0,1,NULL,NULL),
(62,610,'Faux',1,2,NULL,NULL),
(63,701,'Vrai',1,1,NULL,NULL),
(64,701,'Faux',0,2,NULL,NULL),
(65,702,'Regarder dans les rétroviseurs et par-dessus l\'épaule',1,1,NULL,NULL),
(66,702,'Ouvrir rapidement sans regarder',0,2,NULL,NULL),
(67,702,'Klaxonner avant d\'ouvrir',0,3,NULL,NULL),
(68,702,'Allumer les feux de détresse',0,4,NULL,NULL),
(69,703,'Vrai',1,1,NULL,NULL),
(70,703,'Faux',0,2,NULL,NULL),
(71,704,'Vérifier l\'espace disponible de chaque côté avant d\'avancer',1,1,NULL,NULL),
(72,704,'Accélérer pour passer rapidement',0,2,NULL,NULL),
(73,704,'Klaxonner pour prévenir',0,3,NULL,NULL),
(74,704,'Rester au milieu sans regarder les côtés',0,4,NULL,NULL),
(75,705,'Vrai',0,1,NULL,NULL),
(76,705,'Faux',1,2,NULL,NULL),
(77,706,'Se tenir à la carrosserie et entrer rapidement en sécurité',1,1,NULL,NULL),
(78,706,'Courir vers la portière sans regarder',0,2,NULL,NULL),
(79,706,'Laisser la portière grande ouverte pendant qu\'on monte',0,3,NULL,NULL),
(80,706,'Monter par la portière côté circulation',0,4,NULL,NULL),
(81,707,'Vrai',1,1,NULL,NULL),
(82,707,'Faux',0,2,NULL,NULL),
(83,708,'Les enfants et les personnes de petite taille',1,1,NULL,NULL),
(84,708,'Les camions et les bus',0,2,NULL,NULL),
(85,708,'Les motos roulant à grande vitesse',0,3,NULL,NULL),
(86,708,'Les véhicules venant en face',0,4,NULL,NULL),
(87,709,'Vrai',1,1,NULL,NULL),
(88,709,'Faux',0,2,NULL,NULL),
(89,710,'Vrai',1,1,NULL,NULL),
(90,710,'Faux',0,2,NULL,NULL),
(91,801,'Suffisamment à l\'avance (en règle générale 3 secondes ou plus)',1,1,NULL,NULL),
(92,801,'Au moment exact de la manœuvre',0,2,NULL,NULL),
(93,801,'Après avoir commencé la manœuvre',0,3,NULL,NULL),
(94,801,'Uniquement si d\'autres véhicules sont présents',0,4,NULL,NULL),
(95,802,'Vrai',0,1,NULL,NULL),
(96,802,'Faux',1,2,NULL,NULL),
(97,803,'Vrai',1,1,NULL,NULL),
(98,803,'Faux',0,2,NULL,NULL),
(99,804,'Tourner à droite, changer de voie à droite ou se ranger à droite',1,1,NULL,NULL),
(100,804,'Dépasser un véhicule lent',0,2,NULL,NULL),
(101,804,'Ralentir brusquement',0,3,NULL,NULL),
(102,804,'Signaler une panne',0,4,NULL,NULL),
(103,805,'Vrai',1,1,NULL,NULL),
(104,805,'Faux',0,2,NULL,NULL),
(105,806,'Panne ou immobilisation imprévue sur la chaussée',1,1,NULL,NULL),
(106,806,'Indiquer un virage à droite',0,2,NULL,NULL),
(107,806,'Signaler que l\'on va dépasser',0,3,NULL,NULL),
(108,806,'Faire des appels de phares en tunnel',0,4,NULL,NULL),
(109,807,'Vrai',1,1,NULL,NULL),
(110,807,'Faux',0,2,NULL,NULL),
(111,808,'Vrai',1,1,NULL,NULL),
(112,808,'Faux',0,2,NULL,NULL),
(113,809,'Vrai',1,1,NULL,NULL),
(114,809,'Faux',0,2,NULL,NULL),
(115,810,'Avant de commencer à tourner, en avance suffisante',1,1,NULL,NULL),
(116,810,'Au moment où l\'on coupe la roue',0,2,NULL,NULL),
(117,810,'Après avoir tourné',0,3,NULL,NULL),
(118,810,'Uniquement si un autre véhicule arrive en face',0,4,NULL,NULL),
(119,901,'Point mort (N)',1,1,NULL,NULL),
(120,901,'Première vitesse',0,2,NULL,NULL),
(121,901,'Deuxième vitesse',0,3,NULL,NULL),
(122,901,'Marche arrière',0,4,NULL,NULL),
(123,902,'Le frein à main',1,1,NULL,NULL),
(124,902,'L\'accélérateur seul',0,2,NULL,NULL),
(125,902,'Une vitesse élevée',0,3,NULL,NULL),
(126,902,'Le frein de service à fond',0,4,NULL,NULL),
(127,903,'Vrai',1,1,NULL,NULL),
(128,903,'Faux',0,2,NULL,NULL),
(129,904,'Vrai',1,1,NULL,NULL),
(130,904,'Faux',0,2,NULL,NULL),
(131,905,'Vrai',1,1,NULL,NULL),
(132,905,'Faux',0,2,NULL,NULL),
(133,906,'Vrai',1,1,NULL,NULL),
(134,906,'Faux',0,2,NULL,NULL),
(135,907,'Anticiper et freiner progressivement bien avant l\'endroit visé',1,1,NULL,NULL),
(136,907,'Freiner brusquement juste avant l\'endroit',0,2,NULL,NULL),
(137,907,'Couper le contact pour ralentir',0,3,NULL,NULL),
(138,907,'Mettre le levier en point mort loin de l\'endroit',0,4,NULL,NULL),
(139,908,'Vrai',1,1,NULL,NULL),
(140,908,'Faux',0,2,NULL,NULL),
(141,909,'Embrayage enfoncé → 1re vitesse → lâcher frein à main → doser embrayage + accélérateur',1,1,NULL,NULL),
(142,909,'Débrayer → 2e vitesse → démarrer',0,2,NULL,NULL),
(143,909,'Démarrer sans embrayer',0,3,NULL,NULL),
(144,909,'Accélérer puis engager la vitesse',0,4,NULL,NULL),
(145,910,'Vrai',0,1,NULL,NULL),
(146,910,'Faux',1,2,NULL,NULL),
(147,1001,'Vrai',1,1,NULL,NULL),
(148,1001,'Faux',0,2,NULL,NULL),
(149,1002,'Vrai',0,1,NULL,NULL),
(150,1002,'Faux',1,2,NULL,NULL),
(151,1003,'Ferme mais souple',1,1,NULL,NULL),
(152,1003,'Très forte pour contrôler',0,2,NULL,NULL),
(153,1003,'Très légère pour ne pas fatiguer',0,3,NULL,NULL),
(154,1003,'Variable selon la vitesse uniquement',0,4,NULL,NULL),
(155,1004,'Vrai',0,1,NULL,NULL),
(156,1004,'Faux',1,2,NULL,NULL),
(157,1005,'Un mauvais parallélisme ou un pneu sous-gonflé',1,1,NULL,NULL),
(158,1005,'La couleur de la route',0,2,NULL,NULL),
(159,1005,'Un excès de carburant',0,3,NULL,NULL),
(160,1005,'Un rétroviseur mal réglé',0,4,NULL,NULL),
(161,1006,'Vrai',1,1,NULL,NULL),
(162,1006,'Faux',0,2,NULL,NULL),
(163,1007,'Loin devant, vers l\'horizon',1,1,NULL,NULL),
(164,1007,'Sur les bords de la route',0,2,NULL,NULL),
(165,1007,'Sur le tableau de bord',0,3,NULL,NULL),
(166,1007,'Sur le marquage central',0,4,NULL,NULL),
(167,1008,'Vrai',0,1,NULL,NULL),
(168,1008,'Faux',1,2,NULL,NULL),
(169,1009,'Vrai',1,1,NULL,NULL),
(170,1009,'Faux',0,2,NULL,NULL),
(171,1010,'Vrai',1,1,NULL,NULL),
(172,1010,'Faux',0,2,NULL,NULL),
(173,1101,'Légers virages en ligne droite ou corrections mineures',1,1,NULL,NULL),
(174,1101,'Virages serrés à basse vitesse',0,2,NULL,NULL),
(175,1101,'Créneau en stationnement',0,3,NULL,NULL),
(176,1101,'Demi-tour',0,4,NULL,NULL),
(177,1102,'Vrai',1,1,NULL,NULL),
(178,1102,'Faux',0,2,NULL,NULL),
(179,1103,'Vrai',1,1,NULL,NULL),
(180,1103,'Faux',0,2,NULL,NULL),
(181,1104,'Activement, en accompagnant le retour',1,1,NULL,NULL),
(182,1104,'En le lâchant pour qu\'il revienne seul',0,2,NULL,NULL),
(183,1104,'En conservant le braquage jusqu\'à la prochaine ligne droite',0,3,NULL,NULL),
(184,1104,'En freinant d\'abord',0,4,NULL,NULL),
(185,1105,'Vrai',1,1,NULL,NULL),
(186,1105,'Faux',0,2,NULL,NULL),
(187,1106,'Vrai',1,1,NULL,NULL),
(188,1106,'Faux',0,2,NULL,NULL),
(189,1107,'Vrai',1,1,NULL,NULL),
(190,1107,'Faux',0,2,NULL,NULL),
(191,1108,'Une main glisse sur la couronne en tirant, l\'autre accompagne',1,1,NULL,NULL),
(192,1108,'Les deux mains restent fixes',0,2,NULL,NULL),
(193,1108,'Les mains se croisent à chaque demi-tour',0,3,NULL,NULL),
(194,1108,'Une seule main est utilisée',0,4,NULL,NULL),
(195,1109,'Vrai',1,1,NULL,NULL),
(196,1109,'Faux',0,2,NULL,NULL),
(197,1110,'Chevauchement des mains',1,1,NULL,NULL),
(198,1110,'Sans déplacer les mains',0,2,NULL,NULL),
(199,1110,'Simple déplacement',0,3,NULL,NULL),
(200,1110,'Une seule main',0,4,NULL,NULL),
(201,1201,'Le moteur commence à entraîner les roues partiellement',1,1,NULL,NULL),
(202,1201,'L\'embrayage est totalement relâché',0,2,NULL,NULL),
(203,1201,'Le moteur est au ralenti',0,3,NULL,NULL),
(204,1201,'La vitesse maximale est atteinte',0,4,NULL,NULL),
(205,1202,'Vrai',0,1,NULL,NULL),
(206,1202,'Faux',1,2,NULL,NULL),
(207,1203,'Débrayer → passer en 2e → embrayer progressivement',1,1,NULL,NULL),
(208,1203,'Accélérer → passer en 2e sans débrayer',0,2,NULL,NULL),
(209,1203,'Freiner → passer en 2e → débrayer',0,3,NULL,NULL),
(210,1203,'Débrayer → frein → 2e → embrayer',0,4,NULL,NULL),
(211,1204,'Vrai',0,1,NULL,NULL),
(212,1204,'Faux',1,2,NULL,NULL),
(213,1205,'Le frein de service (pied) pendant le passage du point de patinage',1,1,NULL,NULL),
(214,1205,'L\'accélérateur à fond',0,2,NULL,NULL),
(215,1205,'La marche arrière',0,3,NULL,NULL),
(216,1205,'Le clignotant',0,4,NULL,NULL),
(217,1206,'Le calage du moteur',1,1,NULL,NULL),
(218,1206,'Une accélération brusque',0,2,NULL,NULL),
(219,1206,'Un rétrogradage automatique',0,3,NULL,NULL),
(220,1206,'L\'activation de l\'ABS',0,4,NULL,NULL),
(221,1207,'Vrai',1,1,NULL,NULL),
(222,1207,'Faux',0,2,NULL,NULL),
(223,1208,'Vrai',1,1,NULL,NULL),
(224,1208,'Faux',0,2,NULL,NULL),
(225,1209,'Vrai',0,1,NULL,NULL),
(226,1209,'Faux',1,2,NULL,NULL),
(227,1210,'Fréquents et adaptés au flux de circulation',1,1,NULL,NULL),
(228,1210,'Le plus rares possible',0,2,NULL,NULL),
(229,1210,'Uniquement en 1re et 2e vitesse',0,3,NULL,NULL),
(230,1210,'Toujours en passant plusieurs rapports à la fois',0,4,NULL,NULL),
(231,1301,'Les quatre roues',1,1,NULL,NULL),
(232,1301,'Les roues avant uniquement',0,2,NULL,NULL),
(233,1301,'Les roues arrière uniquement',0,3,NULL,NULL),
(234,1301,'Le moteur',0,4,NULL,NULL),
(235,1302,'Vrai',1,1,NULL,NULL),
(236,1302,'Faux',0,2,NULL,NULL),
(237,1303,'Vrai',0,1,NULL,NULL),
(238,1303,'Faux',1,2,NULL,NULL),
(239,1304,'Rétrograder dans un rapport inférieur',1,1,NULL,NULL),
(240,1304,'Accélérer légèrement',0,2,NULL,NULL),
(241,1304,'Passer au point mort',0,3,NULL,NULL),
(242,1304,'Couper le contact',0,4,NULL,NULL),
(243,1305,'Vrai',1,1,NULL,NULL),
(244,1305,'Faux',0,2,NULL,NULL),
(245,1306,'Utiliser le frein à main progressivement et rétrograder',1,1,NULL,NULL),
(246,1306,'Couper le contact',0,2,NULL,NULL),
(247,1306,'Accélérer pour dépasser le danger',0,3,NULL,NULL),
(248,1306,'Ouvrir la portière et sauter',0,4,NULL,NULL),
(249,1307,'Vrai',1,1,NULL,NULL),
(250,1307,'Faux',0,2,NULL,NULL),
(251,1308,'Réduit la chaleur produite par les freins principaux',1,1,NULL,NULL),
(252,1308,'Augmente la vitesse en descente',0,2,NULL,NULL),
(253,1308,'Remplace totalement le frein à pédale',0,3,NULL,NULL),
(254,1308,'N\'a aucun effet en descente',0,4,NULL,NULL),
(255,1309,'Vrai',0,1,NULL,NULL),
(256,1309,'Faux',1,2,NULL,NULL),
(257,1310,'Vrai',1,1,NULL,NULL),
(258,1310,'Faux',0,2,NULL,NULL),
(259,1401,'En haut à gauche (position typique de la 1re)',1,1,NULL,NULL),
(260,1401,'En bas à droite',0,2,NULL,NULL),
(261,1401,'En haut à droite',0,3,NULL,NULL),
(262,1401,'En bas à gauche',0,4,NULL,NULL),
(263,1402,'Vrai',0,1,NULL,NULL),
(264,1402,'Faux',1,2,NULL,NULL),
(265,1403,'Vrai',1,1,NULL,NULL),
(266,1403,'Faux',0,2,NULL,NULL),
(267,1404,'Vrai',1,1,NULL,NULL),
(268,1404,'Faux',0,2,NULL,NULL),
(269,1405,'Faire pousser le véhicule, embrayer brusquement en 2e avec contact mis',1,1,NULL,NULL),
(270,1405,'Recharger la batterie avec un câble',0,2,NULL,NULL),
(271,1405,'Utiliser uniquement le démarreur de secours électrique',0,3,NULL,NULL),
(272,1405,'Appeler un garagiste',0,4,NULL,NULL),
(273,1406,'Vrai',1,1,NULL,NULL),
(274,1406,'Faux',0,2,NULL,NULL),
(275,1407,'3e vitesse',1,1,NULL,NULL),
(276,1407,'1re vitesse',0,2,NULL,NULL),
(277,1407,'5e vitesse',0,3,NULL,NULL),
(278,1407,'2e vitesse uniquement',0,4,NULL,NULL),
(279,1408,'Vrai',1,1,NULL,NULL),
(280,1408,'Faux',0,2,NULL,NULL),
(281,1409,'Vrai',0,1,NULL,NULL),
(282,1409,'Faux',1,2,NULL,NULL),
(283,1410,'Vrai',1,1,NULL,NULL),
(284,1410,'Faux',0,2,NULL,NULL),
(285,1501,'Légers et précis',1,1,NULL,NULL),
(286,1501,'Amples et rapides',0,2,NULL,NULL),
(287,1501,'Inexistants',0,3,NULL,NULL),
(288,1501,'Fréquents et brusques',0,4,NULL,NULL),
(289,1502,'Exercer une légère compensation vers la gauche',1,1,NULL,NULL),
(290,1502,'Accélérer pour compenser',0,2,NULL,NULL),
(291,1502,'Freiner légèrement',0,3,NULL,NULL),
(292,1502,'Rien de spécial',0,4,NULL,NULL),
(293,1503,'Vrai',1,1,NULL,NULL),
(294,1503,'Faux',0,2,NULL,NULL),
(295,1504,'Vrai',0,1,NULL,NULL),
(296,1504,'Faux',1,2,NULL,NULL),
(297,1505,'Vrai',0,1,NULL,NULL),
(298,1505,'Faux',1,2,NULL,NULL),
(299,1506,'Vrai',1,1,NULL,NULL),
(300,1506,'Faux',0,2,NULL,NULL),
(301,1507,'À grande vitesse (voie rapide, autoroute)',1,1,NULL,NULL),
(302,1507,'Au stationnement',0,2,NULL,NULL),
(303,1507,'En marche arrière lente',0,3,NULL,NULL),
(304,1507,'En 1re vitesse',0,4,NULL,NULL),
(305,1508,'Maintenir le volant droit et ne pas freiner',1,1,NULL,NULL),
(306,1508,'Freiner à fond pour réduire la vitesse',0,2,NULL,NULL),
(307,1508,'Tourner brusquement pour éviter la flaque',0,3,NULL,NULL),
(308,1508,'Accélérer pour traverser rapidement',0,4,NULL,NULL),
(309,1509,'Vrai',0,1,NULL,NULL),
(310,1509,'Faux',1,2,NULL,NULL),
(311,1510,'Vrai',1,1,NULL,NULL),
(312,1510,'Faux',0,2,NULL,NULL),
(313,1601,'Vrai',1,1,NULL,NULL),
(314,1601,'Faux',0,2,NULL,NULL),
(315,1602,'Très lentement, avec précaution',1,1,NULL,NULL),
(316,1602,'Rapidement pour réduire la durée de la manœuvre',0,2,NULL,NULL),
(317,1602,'À la vitesse normale de circulation',0,3,NULL,NULL),
(318,1602,'Au même rythme que la marche avant',0,4,NULL,NULL),
(319,1603,'Se retourner et utiliser les rétroviseurs',1,1,NULL,NULL),
(320,1603,'Regarder uniquement dans le rétroviseur central',0,2,NULL,NULL),
(321,1603,'Se fier uniquement aux capteurs de stationnement',0,3,NULL,NULL),
(322,1603,'Regarder devant soi',0,4,NULL,NULL),
(323,1604,'Vrai',0,1,NULL,NULL),
(324,1604,'Faux',1,2,NULL,NULL),
(325,1605,'La gauche',1,1,NULL,NULL),
(326,1605,'La droite',0,2,NULL,NULL),
(327,1605,'Tout droit',0,3,NULL,NULL),
(328,1605,'N\'importe quelle direction',0,4,NULL,NULL),
(329,1606,'Vrai',1,1,NULL,NULL),
(330,1606,'Faux',0,2,NULL,NULL),
(331,1607,'Vrai',1,1,NULL,NULL),
(332,1607,'Faux',0,2,NULL,NULL),
(333,1608,'Corps tourné vers l\'arrière, main droite sur le dossier passager',1,1,NULL,NULL),
(334,1608,'Corps tourné à gauche uniquement',0,2,NULL,NULL),
(335,1608,'Rester face au volant en utilisant les rétroviseurs',0,3,NULL,NULL),
(336,1608,'Corps penché vers l\'avant',0,4,NULL,NULL),
(337,1609,'Vrai',1,1,NULL,NULL),
(338,1609,'Faux',0,2,NULL,NULL),
(339,1610,'Vrai',1,1,NULL,NULL),
(340,1610,'Faux',0,2,NULL,NULL),
(341,1701,'Parallèlement au trottoir entre deux véhicules',1,1,NULL,NULL),
(342,1701,'Perpendiculairement au trottoir',0,2,NULL,NULL),
(343,1701,'En diagonale à 45°',0,3,NULL,NULL),
(344,1701,'Face au trottoir',0,4,NULL,NULL),
(345,1702,'Vrai',1,1,NULL,NULL),
(346,1702,'Faux',0,2,NULL,NULL),
(347,1703,'45° à 60° par rapport au trottoir',1,1,NULL,NULL),
(348,1703,'90°',0,2,NULL,NULL),
(349,1703,'10°',0,3,NULL,NULL),
(350,1703,'30°',0,4,NULL,NULL),
(351,1704,'Vrai',1,1,NULL,NULL),
(352,1704,'Faux',0,2,NULL,NULL),
(353,1705,'Vrai',1,1,NULL,NULL),
(354,1705,'Faux',0,2,NULL,NULL),
(355,1706,'Environ 50 cm à l\'avant et à l\'arrière',1,1,NULL,NULL),
(356,1706,'10 cm suffisent',0,2,NULL,NULL),
(357,1706,'2 mètres minimum',0,3,NULL,NULL),
(358,1706,'Aucun espace requis',0,4,NULL,NULL),
(359,1707,'Vrai',1,1,NULL,NULL),
(360,1707,'Faux',0,2,NULL,NULL),
(361,1708,'Vrai',1,1,NULL,NULL),
(362,1708,'Faux',0,2,NULL,NULL),
(363,1709,'Vrai',1,1,NULL,NULL),
(364,1709,'Faux',0,2,NULL,NULL),
(365,1710,'Au moins 1,5 fois la longueur du véhicule',1,1,NULL,NULL),
(366,1710,'Exactement la longueur du véhicule',0,2,NULL,NULL),
(367,1710,'3 fois la longueur du véhicule',0,3,NULL,NULL),
(368,1710,'La largeur du véhicule suffit',0,4,NULL,NULL),
(369,1801,'Vrai',1,1,NULL,NULL),
(370,1801,'Faux',0,2,NULL,NULL),
(371,1802,'Vrai',1,1,NULL,NULL),
(372,1802,'Faux',0,2,NULL,NULL),
(373,1803,'Vrai',1,1,NULL,NULL),
(374,1803,'Faux',0,2,NULL,NULL),
(375,1804,'Vrai',0,1,NULL,NULL),
(376,1804,'Faux',1,2,NULL,NULL),
(377,1805,'Vrai',1,1,NULL,NULL),
(378,1805,'Faux',0,2,NULL,NULL),
(379,1806,'Vrai',1,1,NULL,NULL),
(380,1806,'Faux',0,2,NULL,NULL),
(381,1807,'Vrai',0,1,NULL,NULL),
(382,1807,'Faux',1,2,NULL,NULL),
(383,1808,'Le tarif de l\'assurance du véhicule',1,1,NULL,NULL),
(384,1808,'La pression des pneus',0,2,NULL,NULL),
(385,1808,'Les intervalles d\'entretien',0,3,NULL,NULL),
(386,1808,'La charge utile maximale',0,4,NULL,NULL),
(387,1809,'Vrai',1,1,NULL,NULL),
(388,1809,'Faux',0,2,NULL,NULL),
(389,1810,'La notice constructeur du véhicule',1,1,NULL,NULL),
(390,1810,'Le vendeur de pièces détachées',0,2,NULL,NULL),
(391,1810,'Le magazine automobile local',0,3,NULL,NULL),
(392,1810,'Internet uniquement',0,4,NULL,NULL),
(419,2001,'Vrai',1,1,NULL,NULL),
(420,2001,'Faux',0,2,NULL,NULL),
(421,2002,'Vrai',1,1,NULL,NULL),
(422,2002,'Faux',0,2,NULL,NULL),
(423,2003,'Vrai',1,1,NULL,NULL),
(424,2003,'Faux',0,2,NULL,NULL),
(425,2004,'Vrai',0,1,NULL,NULL),
(426,2004,'Faux',1,2,NULL,NULL),
(427,2005,'Vrai',1,1,NULL,NULL),
(428,2005,'Faux',0,2,NULL,NULL),
(429,2006,'Vrai',1,1,NULL,NULL),
(430,2006,'Faux',0,2,NULL,NULL),
(431,2007,'Vrai',1,1,NULL,NULL),
(432,2007,'Faux',0,2,NULL,NULL),
(433,2008,'Vrai',1,1,NULL,NULL),
(434,2008,'Faux',0,2,NULL,NULL),
(435,2009,'Un mur blanc ou un appareil de réglage optique',1,1,NULL,NULL),
(436,2009,'L\'œil nu uniquement',0,2,NULL,NULL),
(437,2009,'Un tournevis uniquement',0,3,NULL,NULL),
(438,2009,'Un multimètre électrique',0,4,NULL,NULL),
(439,2010,'Vrai',1,1,NULL,NULL),
(440,2010,'Faux',0,2,NULL,NULL),
(441,2101,'Vrai',1,1,NULL,NULL),
(442,2101,'Faux',0,2,NULL,NULL),
(443,2102,'Vrai',1,1,NULL,NULL),
(444,2102,'Faux',0,2,NULL,NULL),
(445,2103,'Vrai',0,1,NULL,NULL),
(446,2103,'Faux',1,2,NULL,NULL),
(447,2104,'Vrai',1,1,NULL,NULL),
(448,2104,'Faux',0,2,NULL,NULL),
(449,2105,'Vrai',1,1,NULL,NULL),
(450,2105,'Faux',0,2,NULL,NULL),
(451,2106,'Vrai',0,1,NULL,NULL),
(452,2106,'Faux',1,2,NULL,NULL),
(453,2107,'Vrai',1,1,NULL,NULL),
(454,2107,'Faux',0,2,NULL,NULL),
(455,2108,'Vrai',0,1,NULL,NULL),
(456,2108,'Faux',1,2,NULL,NULL),
(457,2109,'Vrai',1,1,NULL,NULL),
(458,2109,'Faux',0,2,NULL,NULL),
(459,2110,'Vrai',1,1,NULL,NULL),
(460,2110,'Faux',0,2,NULL,NULL),
(461,2201,'Vrai',1,1,NULL,NULL),
(462,2201,'Faux',0,2,NULL,NULL),
(463,2202,'Vrai',0,1,NULL,NULL),
(464,2202,'Faux',1,2,NULL,NULL),
(465,2203,'Vrai',0,1,NULL,NULL),
(466,2203,'Faux',1,2,NULL,NULL),
(467,2204,'Vrai',1,1,NULL,NULL),
(468,2204,'Faux',0,2,NULL,NULL),
(469,2205,'Vrai',1,1,NULL,NULL),
(470,2205,'Faux',0,2,NULL,NULL),
(471,2206,'Vrai',1,1,NULL,NULL),
(472,2206,'Faux',0,2,NULL,NULL),
(473,2207,'Vrai',1,1,NULL,NULL),
(474,2207,'Faux',0,2,NULL,NULL),
(475,2208,'Vrai',0,1,NULL,NULL),
(476,2208,'Faux',1,2,NULL,NULL),
(477,2209,'Vrai',1,1,NULL,NULL),
(478,2209,'Faux',0,2,NULL,NULL),
(479,2210,'Vrai',0,1,NULL,NULL),
(480,2210,'Faux',1,2,NULL,NULL),
(481,2301,'Vrai',1,1,NULL,NULL),
(482,2301,'Faux',0,2,NULL,NULL),
(483,2302,'Passer avec prudence, attention à un danger',1,1,NULL,NULL),
(484,2302,'S\'arrêter obligatoirement',0,2,NULL,NULL),
(485,2302,'Accélérer avant qu\'il passe au rouge',0,3,NULL,NULL),
(486,2302,'Interdiction de passage',0,4,NULL,NULL),
(487,2303,'Danger ou avertissement',1,1,NULL,NULL),
(488,2303,'Interdiction',0,2,NULL,NULL),
(489,2303,'Obligation',0,3,NULL,NULL),
(490,2303,'Information',0,4,NULL,NULL),
(491,2304,'Vrai',1,1,NULL,NULL),
(492,2304,'Faux',0,2,NULL,NULL),
(493,2305,'Interdit de franchissement dans les deux sens',1,1,NULL,NULL),
(494,2305,'Autorisation de dépassement',0,2,NULL,NULL),
(495,2305,'Zone de stationnement',0,3,NULL,NULL),
(496,2305,'Limite de voie pour piétons',0,4,NULL,NULL),
(497,2306,'Vrai',1,1,NULL,NULL),
(498,2306,'Faux',0,2,NULL,NULL),
(499,2307,'Passages à niveau',1,1,NULL,NULL),
(500,2307,'Intersections en ville uniquement',0,2,NULL,NULL),
(501,2307,'Entrées d\'autoroute',0,3,NULL,NULL),
(502,2307,'Parkings souterrains',0,4,NULL,NULL),
(503,2308,'Interdiction ou obligation',1,1,NULL,NULL),
(504,2308,'Danger',0,2,NULL,NULL),
(505,2308,'Information',0,3,NULL,NULL),
(506,2308,'Direction',0,4,NULL,NULL),
(507,2309,'Vrai',1,1,NULL,NULL),
(508,2309,'Faux',0,2,NULL,NULL),
(509,2310,'Vrai',1,1,NULL,NULL),
(510,2310,'Faux',0,2,NULL,NULL),
(535,2501,'Vrai',1,1,NULL,NULL),
(536,2501,'Faux',0,2,NULL,NULL),
(537,2502,'Vrai',1,1,NULL,NULL),
(538,2502,'Faux',0,2,NULL,NULL),
(539,2503,'Vrai',1,1,NULL,NULL),
(540,2503,'Faux',0,2,NULL,NULL),
(541,2504,'Vrai',1,1,NULL,NULL),
(542,2504,'Faux',0,2,NULL,NULL),
(543,2505,'Vrai',0,1,NULL,NULL),
(544,2505,'Faux',1,2,NULL,NULL),
(545,2506,'100 km/h',1,1,NULL,NULL),
(546,2506,'130 km/h',0,2,NULL,NULL),
(547,2506,'80 km/h',0,3,NULL,NULL),
(548,2506,'120 km/h',0,4,NULL,NULL),
(549,2507,'Vrai',1,1,NULL,NULL),
(550,2507,'Faux',0,2,NULL,NULL),
(551,2508,'Vrai',1,1,NULL,NULL),
(552,2508,'Faux',0,2,NULL,NULL),
(553,2509,'Vrai',1,1,NULL,NULL),
(554,2509,'Faux',0,2,NULL,NULL),
(555,2510,'Réduire sa vitesse avant de quitter la voie rapide',1,1,NULL,NULL),
(556,2510,'Accélérer pour s\'insérer dans la circulation',0,2,NULL,NULL),
(557,2510,'Dépasser un véhicule lent',0,3,NULL,NULL),
(558,2510,'Stationner temporairement',0,4,NULL,NULL),
(559,2601,'Vrai',1,1,NULL,NULL),
(560,2601,'Faux',0,2,NULL,NULL),
(561,2602,'Vrai',1,1,NULL,NULL),
(562,2602,'Faux',0,2,NULL,NULL),
(563,2603,'Vrai',1,1,NULL,NULL),
(564,2603,'Faux',0,2,NULL,NULL),
(565,2604,'Tenter un dépassement dangereux et provoquer une collision',1,1,NULL,NULL),
(566,2604,'Réduire sa vitesse automatiquement',0,2,NULL,NULL),
(567,2604,'Améliorer son anticipation',0,3,NULL,NULL),
(568,2604,'Augmenter la distance de sécurité',0,4,NULL,NULL),
(569,2605,'Vrai',0,1,NULL,NULL),
(570,2605,'Faux',1,2,NULL,NULL),
(571,2606,'Vrai',1,1,NULL,NULL),
(572,2606,'Faux',0,2,NULL,NULL),
(573,2607,'À la vitesse la plus basse',1,1,NULL,NULL),
(574,2607,'À 50 km/h',0,2,NULL,NULL),
(575,2607,'À 90 km/h',0,3,NULL,NULL),
(576,2607,'La vitesse n\'influe pas sur la distance d\'arrêt',0,4,NULL,NULL),
(577,2608,'Vrai',1,1,NULL,NULL),
(578,2608,'Faux',0,2,NULL,NULL),
(579,2609,'Vrai',1,1,NULL,NULL),
(580,2609,'Faux',0,2,NULL,NULL),
(581,2610,'Vrai',1,1,NULL,NULL),
(582,2610,'Faux',0,2,NULL,NULL),
(583,2701,'Vrai',1,1,NULL,NULL),
(584,2701,'Faux',0,2,NULL,NULL),
(585,2702,'Vrai',1,1,NULL,NULL),
(586,2702,'Faux',0,2,NULL,NULL),
(587,2703,'L\'extérieur du virage',1,1,NULL,NULL),
(588,2703,'L\'intérieur du virage',0,2,NULL,NULL),
(589,2703,'Vers l\'avant',0,3,NULL,NULL),
(590,2703,'Vers le bas',0,4,NULL,NULL),
(591,2704,'Vrai',1,1,NULL,NULL),
(592,2704,'Faux',0,2,NULL,NULL),
(593,2705,'Aborder large, couper la corde, ressortir large',1,1,NULL,NULL),
(594,2705,'Couper directement la corde sans aborder large',0,2,NULL,NULL),
(595,2705,'Rester au centre de la chaussée tout au long du virage',0,3,NULL,NULL),
(596,2705,'Freiner dans le virage pour réduire la vitesse',0,4,NULL,NULL),
(597,2706,'Vrai',1,1,NULL,NULL),
(598,2706,'Faux',0,2,NULL,NULL),
(599,2707,'Vrai',1,1,NULL,NULL),
(600,2707,'Faux',0,2,NULL,NULL),
(601,2708,'Vrai',1,1,NULL,NULL),
(602,2708,'Faux',0,2,NULL,NULL),
(603,2709,'Vrai',1,1,NULL,NULL),
(604,2709,'Faux',0,2,NULL,NULL),
(605,2710,'Vrai',1,1,NULL,NULL),
(606,2710,'Faux',0,2,NULL,NULL),
(607,2801,'Vrai',1,1,NULL,NULL),
(608,2801,'Faux',0,2,NULL,NULL),
(609,2802,'Vrai',1,1,NULL,NULL),
(610,2802,'Faux',0,2,NULL,NULL),
(611,2803,'Vrai',1,1,NULL,NULL),
(612,2803,'Faux',0,2,NULL,NULL),
(613,2804,'Vrai',1,1,NULL,NULL),
(614,2804,'Faux',0,2,NULL,NULL),
(615,2805,'Ralentir fortement et se préparer à s\'arrêter',1,1,NULL,NULL),
(616,2805,'Klaxonner pour avertir les enfants',0,2,NULL,NULL),
(617,2805,'Dépasser rapidement pour ne pas gêner',0,3,NULL,NULL),
(618,2805,'Rien de particulier',0,4,NULL,NULL),
(619,2806,'Vrai',1,1,NULL,NULL),
(620,2806,'Faux',0,2,NULL,NULL),
(621,2807,'Vrai',1,1,NULL,NULL),
(622,2807,'Faux',0,2,NULL,NULL),
(623,2808,'Vrai',0,1,NULL,NULL),
(624,2808,'Faux',1,2,NULL,NULL),
(625,2809,'Vrai',1,1,NULL,NULL),
(626,2809,'Faux',0,2,NULL,NULL),
(627,2810,'Le temps nécessaire pour une brève opération, conducteur présent',1,1,NULL,NULL),
(628,2810,'15 minutes maximum',0,2,NULL,NULL),
(629,2810,'5 minutes précisément',0,3,NULL,NULL),
(630,2810,'1 heure si on laisse le moteur tourner',0,4,NULL,NULL),
(631,2901,'Vrai',1,1,NULL,NULL),
(632,2901,'Faux',0,2,NULL,NULL),
(633,2902,'Le double',1,1,NULL,NULL),
(634,2902,'Le triple',0,2,NULL,NULL),
(635,2902,'1,5 fois',0,3,NULL,NULL),
(636,2902,'Identique au sec',0,4,NULL,NULL),
(637,2903,'Vrai',0,1,NULL,NULL),
(638,2903,'Faux',1,2,NULL,NULL),
(639,2904,'Vrai',1,1,NULL,NULL),
(640,2904,'Faux',0,2,NULL,NULL),
(641,2905,'Vrai',1,1,NULL,NULL),
(642,2905,'Faux',0,2,NULL,NULL),
(643,2906,'Picotements aux yeux et bâillements répétés',1,1,NULL,NULL),
(644,2906,'Une excellente concentration',0,2,NULL,NULL),
(645,2906,'Une accélération du rythme cardiaque',0,3,NULL,NULL),
(646,2906,'Une vision très nette',0,4,NULL,NULL),
(647,2907,'Vrai',0,1,NULL,NULL),
(648,2907,'Faux',1,2,NULL,NULL),
(649,2908,'Vrai',1,1,NULL,NULL),
(650,2908,'Faux',0,2,NULL,NULL),
(651,2909,'Le véhicule qui monte',1,1,NULL,NULL),
(652,2909,'Le véhicule qui descend',0,2,NULL,NULL),
(653,2909,'Le véhicule le plus léger',0,3,NULL,NULL),
(654,2909,'Le premier arrivé',0,4,NULL,NULL),
(655,2910,'Vrai',1,1,NULL,NULL),
(656,2910,'Faux',0,2,NULL,NULL),
(657,3001,'Vrai',1,1,NULL,NULL),
(658,3001,'Faux',0,2,NULL,NULL),
(659,3002,'Vrai',0,1,NULL,NULL),
(660,3002,'Faux',1,2,NULL,NULL),
(661,3003,'Vrai',1,1,NULL,NULL),
(662,3003,'Faux',0,2,NULL,NULL),
(663,3004,'Vrai',1,1,NULL,NULL),
(664,3004,'Faux',0,2,NULL,NULL),
(665,3005,'3 à 4 fois',1,1,NULL,NULL),
(666,3005,'Le double',0,2,NULL,NULL),
(667,3005,'10 fois',0,3,NULL,NULL),
(668,3005,'Aucun effet prouvé',0,4,NULL,NULL),
(669,3006,'Vrai',1,1,NULL,NULL),
(670,3006,'Faux',0,2,NULL,NULL),
(671,3007,'Vrai',1,1,NULL,NULL),
(672,3007,'Faux',0,2,NULL,NULL),
(673,3008,'Vrai',1,1,NULL,NULL),
(674,3008,'Faux',0,2,NULL,NULL),
(675,3009,'Vrai',1,1,NULL,NULL),
(676,3009,'Faux',0,2,NULL,NULL),
(677,3010,'Vrai',1,1,NULL,NULL),
(678,3010,'Faux',0,2,NULL,NULL),
(679,3011,'Un chemin réservé aux piétons uniquement',0,1,NULL,NULL),
(680,3011,'Une voie de communication terrestre aménagée pour la circulation des véhicules',1,2,NULL,NULL),
(681,3011,'Un espace vert reliant deux villes',0,3,NULL,NULL),
(682,3011,'Un tunnel souterrain réservé aux transports en commun',0,4,NULL,NULL),
(683,3012,'Servir de frontière entre deux régions',0,1,NULL,NULL),
(684,3012,'Permettre uniquement le transport de marchandises',0,2,NULL,NULL),
(685,3012,'Assurer la circulation des personnes et des biens de façon sécurisée',1,3,NULL,NULL),
(686,3012,'Délimiter les zones urbaines des zones rurales',0,4,NULL,NULL),
(687,3013,'La chaussée',1,1,NULL,NULL),
(688,3013,'Le panneau publicitaire',0,2,NULL,NULL),
(689,3013,'La borne téléphonique',0,3,NULL,NULL),
(690,3013,'Le feu de signalisation commercial',0,4,NULL,NULL),
(691,3014,'À tous les usagers y compris les piétons',0,1,NULL,NULL),
(692,3014,'Aux vélos et motos uniquement',0,2,NULL,NULL),
(693,3014,'Aux camions et bus uniquement',0,3,NULL,NULL),
(694,3014,'Exclusivement aux véhicules à moteur autorisés',1,4,NULL,NULL),
(695,3015,'Une forêt traversée par une route nationale',0,1,NULL,NULL),
(696,3015,'Un espace groupant des immeubles bâtis rapprochés, signalé par des panneaux',1,2,NULL,NULL),
(697,3015,'Un carrefour entre deux routes principales',0,3,NULL,NULL),
(698,3015,'Un quartier résidentiel sans signalisation particulière',0,4,NULL,NULL),
(699,3016,'La partie centrale réservée aux véhicules lourds',0,1,NULL,NULL),
(700,3016,'La bande délimitant les voies de circulation',0,2,NULL,NULL),
(701,3016,'La partie latérale de la route entre la chaussée et le fossé ou talus',1,3,NULL,NULL),
(702,3016,'Le passage réservé aux piétons',0,4,NULL,NULL),
(703,3017,'Intérêt national',1,1,NULL,NULL),
(704,3017,'Intérêt local uniquement',0,2,NULL,NULL),
(705,3017,'Intérêt privé',0,3,NULL,NULL),
(706,3017,'Intérêt touristique exclusivement',0,4,NULL,NULL),
(707,3018,'Vrai',1,1,NULL,NULL),
(708,3018,'Faux',0,2,NULL,NULL),
(709,3019,'Augmenter la vitesse maximale autorisée',0,1,NULL,NULL),
(710,3019,'Réduire la largeur des voies de circulation',0,2,NULL,NULL),
(711,3019,'Décorer les abords de la route',0,3,NULL,NULL),
(712,3019,'Améliorer la sécurité et la fluidité du trafic',1,4,NULL,NULL),
(713,3020,'Vrai',0,1,NULL,NULL),
(714,3020,'Faux',1,2,NULL,NULL),
(715,3021,'Un engin remorqué par un animal',0,1,NULL,NULL),
(716,3021,'Une bicyclette à assistance électrique uniquement',0,2,NULL,NULL),
(717,3021,'Tout engin propulsé par un moteur et conçu pour circuler sur route',1,3,NULL,NULL),
(718,3021,'Un engin exclusivement réservé au transport de marchandises',0,4,NULL,NULL),
(719,3022,'Assurer la propulsion du véhicule',0,1,NULL,NULL),
(720,3022,'Protéger les occupants et donner la forme extérieure au véhicule',1,2,NULL,NULL),
(721,3022,'Permettre le freinage d\'urgence',0,3,NULL,NULL),
(722,3022,'Contrôler la direction du véhicule',0,4,NULL,NULL),
(723,3023,'Réduire la vitesse et immobiliser le véhicule',1,1,NULL,NULL),
(724,3023,'Augmenter la puissance du moteur',0,2,NULL,NULL),
(725,3023,'Orienter les roues directrices',0,3,NULL,NULL),
(726,3023,'Régler la suspension du véhicule',0,4,NULL,NULL),
(727,3024,'Uniquement le niveau de carburant',0,1,NULL,NULL),
(728,3024,'Seulement les rétroviseurs et les ceintures',0,2,NULL,NULL),
(729,3024,'Uniquement les feux de croisement',0,3,NULL,NULL),
(730,3024,'Les niveaux, les pneumatiques, les feux et les freins',1,4,NULL,NULL),
(731,3025,'Le poids du véhicule à vide',0,1,NULL,NULL),
(732,3025,'Le poids maximum autorisé du véhicule chargé',1,2,NULL,NULL),
(733,3025,'Le poids de la charge transportée uniquement',0,3,NULL,NULL),
(734,3025,'La puissance maximale du moteur',0,4,NULL,NULL),
(735,3026,'Permettre le freinage du véhicule',0,1,NULL,NULL),
(736,3026,'Orienter les roues du véhicule',0,2,NULL,NULL),
(737,3026,'Absorber les chocs de la route',0,3,NULL,NULL),
(738,3026,'Transformer l\'énergie pour propulser le véhicule',1,4,NULL,NULL),
(739,3027,'Vrai',1,1,NULL,NULL),
(740,3027,'Faux',0,2,NULL,NULL),
(741,3028,'Accélérer ou freiner le véhicule',0,1,NULL,NULL),
(742,3028,'Démarrer et arrêter le moteur',0,2,NULL,NULL),
(743,3028,'Orienter les roues pour guider le véhicule',1,3,NULL,NULL),
(744,3028,'Régler la hauteur des sièges',0,4,NULL,NULL),
(745,3029,'L\'allongement de la distance de freinage et la perte de stabilité',1,1,NULL,NULL),
(746,3029,'Une meilleure adhérence au sol',0,2,NULL,NULL),
(747,3029,'Une réduction de la consommation de carburant',0,3,NULL,NULL),
(748,3029,'Un meilleur refroidissement du moteur',0,4,NULL,NULL),
(749,3030,'Vrai',0,1,NULL,NULL),
(750,3030,'Faux',1,2,NULL,NULL),
(751,3031,'Une obligation de tourner à droite',0,1,NULL,NULL),
(752,3031,'Un danger sur la route à proximité',1,2,NULL,NULL),
(753,3031,'Une interdiction de dépasser',0,3,NULL,NULL),
(754,3031,'Une zone de stationnement autorisé',0,4,NULL,NULL),
(755,3032,'Arrêt absolu obligatoire',1,1,NULL,NULL),
(756,3032,'Ralentir et passer avec prudence',0,2,NULL,NULL),
(757,3032,'Accélérer pour dégager l\'intersection',0,3,NULL,NULL),
(758,3032,'Klaxonner et continuer',0,4,NULL,NULL),
(759,3033,'Un danger imminent',0,1,NULL,NULL),
(760,3033,'Une interdiction formelle',0,2,NULL,NULL),
(761,3033,'Une zone de travaux',0,3,NULL,NULL),
(762,3033,'Une obligation ou indication positive',1,4,NULL,NULL),
(763,3034,'Le dépassement sur cette voie',0,1,NULL,NULL),
(764,3034,'La circulation des piétons',0,2,NULL,NULL),
(765,3034,'Le stationnement sur cette portion de route',1,3,NULL,NULL),
(766,3034,'L\'accès aux voies rapides',0,4,NULL,NULL),
(767,3035,'Les conducteurs peuvent passer librement',0,1,NULL,NULL),
(768,3035,'Les conducteurs doivent s\'arrêter',1,2,NULL,NULL),
(769,3035,'Les conducteurs doivent accélérer',0,3,NULL,NULL),
(770,3035,'Les conducteurs peuvent doubler',0,4,NULL,NULL),
(771,3036,'Vrai',1,1,NULL,NULL),
(772,3036,'Faux',0,2,NULL,NULL),
(773,3037,'Accélérer pour passer avant le rouge',0,1,NULL,NULL),
(774,3037,'Continuer normalement',0,2,NULL,NULL),
(775,3037,'Se préparer à s\'arrêter sauf si l\'arrêt est dangereux',1,3,NULL,NULL),
(776,3037,'Klaxonner et passer',0,4,NULL,NULL),
(777,3038,'La circulation à plus de 50 km/h',0,1,NULL,NULL),
(778,3038,'Le stationnement de nuit',0,2,NULL,NULL),
(779,3038,'L\'entrée dans une zone résidentielle',0,3,NULL,NULL),
(780,3038,'Le franchissement et le dépassement',1,4,NULL,NULL),
(781,3039,'Agents de police > feux tricolores > panneaux > marquages au sol',1,1,NULL,NULL),
(782,3039,'Panneaux > feux tricolores > agents de police > marquages',0,2,NULL,NULL),
(783,3039,'Feux tricolores > agents de police > panneaux > marquages',0,3,NULL,NULL),
(784,3039,'Marquages > panneaux > feux > agents de police',0,4,NULL,NULL),
(785,3040,'Vrai',1,1,NULL,NULL),
(786,3040,'Faux',0,2,NULL,NULL),
(787,3041,'30 km/h',0,1,NULL,NULL),
(788,3041,'70 km/h',0,2,NULL,NULL),
(789,3041,'50 km/h',1,3,NULL,NULL),
(790,3041,'90 km/h',0,4,NULL,NULL),
(791,3042,'Au moins 5 mètres quelle que soit la vitesse',0,1,NULL,NULL),
(792,3042,'La distance parcourue en au moins 2 secondes',1,2,NULL,NULL),
(793,3042,'La longueur d\'un véhicule',0,3,NULL,NULL),
(794,3042,'10 mètres dans tous les cas',0,4,NULL,NULL),
(795,3043,'Sur une route droite à 3 voies',0,1,NULL,NULL),
(796,3043,'Quand la vitesse est inférieure à 30 km/h',0,2,NULL,NULL),
(797,3043,'Sur une voie à sens unique bien éclairée',0,3,NULL,NULL),
(798,3043,'Dans les virages, les côtes et aux passages piétons',1,4,NULL,NULL),
(799,3044,'Au véhicule venant de droite',1,1,NULL,NULL),
(800,3044,'Au véhicule le plus rapide',0,2,NULL,NULL),
(801,3044,'Au véhicule le plus lourd',0,3,NULL,NULL),
(802,3044,'Au véhicule venant de gauche',0,4,NULL,NULL),
(803,3045,'Vrai',0,1,NULL,NULL),
(804,3045,'Faux',1,2,NULL,NULL),
(805,3046,'Allumer uniquement les feux de route et maintenir sa vitesse',0,1,NULL,NULL),
(806,3046,'Klaxonner régulièrement et continuer',0,2,NULL,NULL),
(807,3046,'Réduire sa vitesse, allumer les antibrouillards et augmenter la distance de sécurité',1,3,NULL,NULL),
(808,3046,'S\'arrêter immédiatement sur la voie',0,4,NULL,NULL),
(809,3047,'Les feux de route (pleins phares)',0,1,NULL,NULL),
(810,3047,'Les feux de croisement (code)',1,2,NULL,NULL),
(811,3047,'Les feux de détresse uniquement',0,3,NULL,NULL),
(812,3047,'Sans feux pour ne pas gêner',0,4,NULL,NULL),
(813,3048,'Vous pouvez dépasser si aucun véhicule n\'est en face',0,1,NULL,NULL),
(814,3048,'Vous pouvez franchir la ligne pour éviter un obstacle',0,2,NULL,NULL),
(815,3048,'Vous pouvez franchir la ligne en klaxonnant',0,3,NULL,NULL),
(816,3048,'Vous devez rester strictement de votre côté',1,4,NULL,NULL),
(817,3049,'120 km/h par temps sec',1,1,NULL,NULL),
(818,3049,'90 km/h en toutes circonstances',0,2,NULL,NULL),
(819,3049,'150 km/h par beau temps',0,3,NULL,NULL),
(820,3049,'100 km/h en agglomération',0,4,NULL,NULL),
(821,3050,'Vrai',0,1,NULL,NULL),
(822,3050,'Faux',1,2,NULL,NULL),
(823,3051,'Les poids lourds de plus de 10 tonnes',0,1,NULL,NULL),
(824,3051,'Les voitures particulières et véhicules jusqu\'à 3,5 tonnes de PTAC',1,2,NULL,NULL),
(825,3051,'Les motocyclettes uniquement',0,3,NULL,NULL),
(826,3051,'Les bus et autocars',0,4,NULL,NULL),
(827,3052,'Un document d\'assurance du véhicule',0,1,NULL,NULL),
(828,3052,'Le carnet d\'entretien du véhicule',0,2,NULL,NULL),
(829,3052,'L\'autorisation de circuler la nuit',0,3,NULL,NULL),
(830,3052,'Le document officiel d\'immatriculation du véhicule',1,4,NULL,NULL),
(831,3053,'Vrai',1,1,NULL,NULL),
(832,3053,'Faux',0,2,NULL,NULL),
(833,3054,'Librement dès le début de sa formation',0,1,NULL,NULL),
(834,3054,'Seulement la nuit',0,2,NULL,NULL),
(835,3054,'Sous conditions légales avec un moniteur agréé',1,3,NULL,NULL),
(836,3054,'Jamais avant l\'obtention du permis',0,4,NULL,NULL),
(837,3055,'Un centre technique agréé par l\'État',1,1,NULL,NULL),
(838,3055,'Le garagiste de son choix',0,2,NULL,NULL),
(839,3055,'La mairie de la commune',0,3,NULL,NULL),
(840,3055,'L\'auto-école ayant formé le conducteur',0,4,NULL,NULL),
(841,3056,'Uniquement le permis de conduire',0,1,NULL,NULL),
(842,3056,'La carte nationale d\'identité et le permis',0,2,NULL,NULL),
(843,3056,'Le permis, la carte grise et l\'attestation d\'assurance',1,3,NULL,NULL),
(844,3056,'Le carnet de santé du conducteur',0,4,NULL,NULL),
(845,3057,'Des véhicules légers de tourisme',0,1,NULL,NULL),
(846,3057,'Des camions et tracteurs',0,2,NULL,NULL),
(847,3057,'Des tricycles motorisés uniquement',0,3,NULL,NULL),
(848,3057,'Des motocyclettes',1,4,NULL,NULL),
(849,3058,'Vrai',1,1,NULL,NULL),
(850,3058,'Faux',0,2,NULL,NULL),
(851,3059,'Ne rien faire, cela n\'est pas obligatoire',0,1,NULL,NULL),
(852,3059,'Faire modifier sa carte grise dans les délais légaux',1,2,NULL,NULL),
(853,3059,'Racheter une nouvelle carte grise sans conditions',0,3,NULL,NULL),
(854,3059,'Informer uniquement son assureur',0,4,NULL,NULL),
(855,3060,'Par le directeur de l\'auto-école',0,1,NULL,NULL),
(856,3060,'Par tout agent de police sur la voie publique',0,2,NULL,NULL),
(857,3060,'Par les autorités judiciaires ou administratives compétentes',1,3,NULL,NULL),
(858,3060,'Par le voisinage ayant porté plainte',0,4,NULL,NULL),
(859,3061,'Facultative et dépend du type de véhicule',0,1,NULL,NULL),
(860,3061,'Obligatoire pour tout véhicule circulant sur la voie publique',1,2,NULL,NULL),
(861,3061,'Obligatoire uniquement pour les véhicules de plus de 5 ans',0,3,NULL,NULL),
(862,3061,'Recommandée mais non obligatoire',0,4,NULL,NULL),
(863,3062,'Uniquement sa responsabilité civile',0,1,NULL,NULL),
(864,3062,'Uniquement sa responsabilité pénale',0,2,NULL,NULL),
(865,3062,'Aucune responsabilité si l\'accident est dû à un tiers',0,3,NULL,NULL),
(866,3062,'Sa responsabilité civile et pénale à la fois',1,4,NULL,NULL),
(867,3063,'Vrai',1,1,NULL,NULL),
(868,3063,'Faux',0,2,NULL,NULL),
(869,3064,'Un simple retard au feu rouge',0,1,NULL,NULL),
(870,3064,'L\'oubli d\'un clignotant en ville',0,2,NULL,NULL),
(871,3064,'La conduite en état d\'ivresse ou homicide involontaire',1,3,NULL,NULL),
(872,3064,'Le non-lavage de son véhicule',0,4,NULL,NULL),
(873,3065,'À toute réquisition des forces de l\'ordre',1,1,NULL,NULL),
(874,3065,'Uniquement lors d\'un accident',0,2,NULL,NULL),
(875,3065,'Seulement en cas de contrôle au poste frontière',0,3,NULL,NULL),
(876,3065,'Seulement si le véhicule est impliqué dans une infraction',0,4,NULL,NULL),
(877,3066,'Partir rapidement pour éviter les problèmes',0,1,NULL,NULL),
(878,3066,'S\'arrêter, sécuriser, porter secours et alerter les secours',1,2,NULL,NULL),
(879,3066,'Appeler son assureur avant de faire quoi que ce soit',0,3,NULL,NULL),
(880,3066,'Continuer sa route et signaler l\'accident plus tard',0,4,NULL,NULL),
(881,3067,'Vrai',1,1,NULL,NULL),
(882,3067,'Faux',0,2,NULL,NULL),
(883,3068,'Être emprisonné pour infraction au code de la route',0,1,NULL,NULL),
(884,3068,'Perdre son permis de conduire définitivement',0,2,NULL,NULL),
(885,3068,'Payer une amende fixée par le tribunal pénal',0,3,NULL,NULL),
(886,3068,'Réparer financièrement les dommages causés à autrui',1,4,NULL,NULL),
(887,3069,'Uniquement un avertissement verbal',0,1,NULL,NULL),
(888,3069,'Une simple mise en garde sans suite légale',0,2,NULL,NULL),
(889,3069,'Une amende, suspension/annulation du permis ou emprisonnement',1,3,NULL,NULL),
(890,3069,'L\'obligation de refaire un stage de conduite',0,4,NULL,NULL),
(891,3070,'Vrai',1,1,NULL,NULL),
(892,3070,'Faux',0,2,NULL,NULL);
/*!40000 ALTER TABLE `reponses` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `resultats_quiz`
--

DROP TABLE IF EXISTS `resultats_quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `resultats_quiz` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `quiz_id` bigint(20) unsigned NOT NULL,
  `note` decimal(5,2) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `bonnes_reponses` int(11) NOT NULL,
  `reussi` tinyint(1) NOT NULL DEFAULT 0,
  `reponses_utilisateur` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`reponses_utilisateur`)),
  `tentative` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resultats_quiz_user_id_foreign` (`user_id`),
  KEY `resultats_quiz_quiz_id_foreign` (`quiz_id`),
  CONSTRAINT `resultats_quiz_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE,
  CONSTRAINT `resultats_quiz_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultats_quiz`
--

LOCK TABLES `resultats_quiz` WRITE;
/*!40000 ALTER TABLE `resultats_quiz` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `resultats_quiz` VALUES
(1,4,31,20.00,10,10,1,'{\"3011\":680,\"3012\":685,\"3013\":687,\"3014\":694,\"3015\":696,\"3016\":701,\"3017\":703,\"3018\":707,\"3019\":712,\"3020\":714}',1,'2026-02-25 08:38:32','2026-02-25 08:38:32'),
(2,4,32,12.00,10,6,1,'{\"3021\":717,\"3022\":720,\"3023\":723,\"3024\":727,\"3025\":732,\"3026\":738,\"3027\":740,\"3028\":744,\"3029\":745,\"3030\":749}',1,'2026-02-25 08:40:54','2026-02-25 08:40:54'),
(3,4,33,14.00,10,7,1,'{\"3031\":752,\"3032\":755,\"3033\":762,\"3034\":763,\"3035\":767,\"3036\":771,\"3037\":776,\"3038\":780,\"3039\":781,\"3040\":785}',1,'2026-02-25 08:54:43','2026-02-25 08:54:43'),
(4,4,34,4.00,10,2,0,'{\"3041\":787,\"3042\":791,\"3043\":795,\"3044\":799,\"3045\":803,\"3046\":805,\"3047\":809,\"3048\":813,\"3049\":817,\"3050\":821}',1,'2026-02-25 08:55:29','2026-02-25 08:55:29'),
(5,4,34,14.00,10,7,1,'{\"3041\":789,\"3042\":792,\"3043\":798,\"3044\":799,\"3045\":803,\"3046\":807,\"3047\":809,\"3048\":813,\"3049\":817,\"3050\":822}',2,'2026-02-25 08:56:25','2026-02-25 08:56:25'),
(6,4,35,14.00,10,7,1,'{\"3051\":824,\"3052\":830,\"3053\":831,\"3054\":835,\"3055\":837,\"3056\":843,\"3057\":846,\"3058\":849,\"3059\":851,\"3060\":855}',1,'2026-02-25 08:59:43','2026-02-25 08:59:43'),
(7,4,36,20.00,10,10,1,'{\"3061\":860,\"3062\":866,\"3063\":867,\"3064\":871,\"3065\":873,\"3066\":878,\"3067\":881,\"3068\":886,\"3069\":889,\"3070\":891}',1,'2026-02-25 09:00:56','2026-02-25 09:00:56'),
(8,4,5,20.00,10,10,1,'{\"501\":1,\"502\":5,\"503\":9,\"504\":11,\"505\":15,\"506\":17,\"507\":21,\"508\":23,\"509\":27,\"510\":29}',1,'2026-02-25 09:13:07','2026-02-25 09:13:07'),
(9,4,6,16.00,10,8,1,'{\"601\":33,\"602\":36,\"603\":39,\"604\":43,\"605\":45,\"606\":49,\"607\":53,\"608\":55,\"609\":59,\"610\":62}',1,'2026-02-25 09:17:26','2026-02-25 09:17:26'),
(10,4,7,18.00,10,9,1,'{\"701\":63,\"702\":65,\"703\":69,\"704\":71,\"705\":75,\"706\":77,\"707\":81,\"708\":83,\"709\":87,\"710\":89}',1,'2026-02-25 09:18:38','2026-02-25 09:18:38'),
(11,4,8,20.00,10,10,1,'{\"801\":91,\"802\":96,\"803\":97,\"804\":99,\"805\":103,\"806\":105,\"807\":109,\"808\":111,\"809\":113,\"810\":115}',1,'2026-02-25 09:19:50','2026-02-25 09:19:50'),
(12,4,9,18.00,10,9,1,'{\"901\":119,\"902\":123,\"903\":127,\"904\":129,\"905\":131,\"906\":133,\"907\":135,\"908\":139,\"909\":141,\"910\":145}',1,'2026-02-25 09:21:25','2026-02-25 09:21:25'),
(13,4,10,14.00,10,7,1,'{\"1001\":147,\"1002\":149,\"1003\":151,\"1004\":155,\"1005\":157,\"1006\":161,\"1007\":163,\"1008\":167,\"1009\":169,\"1010\":171}',1,'2026-02-25 09:22:02','2026-02-25 09:22:02'),
(14,4,11,20.00,10,10,1,'{\"1101\":173,\"1102\":177,\"1103\":179,\"1104\":181,\"1105\":185,\"1106\":187,\"1107\":189,\"1108\":191,\"1109\":195,\"1110\":197}',1,'2026-02-25 09:22:53','2026-02-25 09:22:53'),
(15,4,12,14.00,10,7,1,'{\"1201\":201,\"1202\":205,\"1203\":207,\"1204\":211,\"1205\":213,\"1206\":217,\"1207\":221,\"1208\":223,\"1209\":225,\"1210\":227}',1,'2026-02-25 09:24:54','2026-02-25 09:24:54'),
(16,4,13,16.00,10,8,1,'{\"1301\":231,\"1302\":235,\"1303\":237,\"1304\":239,\"1305\":243,\"1306\":245,\"1307\":249,\"1308\":251,\"1309\":255,\"1310\":257}',1,'2026-02-25 09:30:45','2026-02-25 09:30:45'),
(17,4,14,14.00,10,7,1,'{\"1401\":259,\"1402\":263,\"1403\":265,\"1404\":267,\"1405\":269,\"1406\":273,\"1407\":275,\"1408\":279,\"1409\":281}',1,'2026-02-25 09:31:46','2026-02-25 09:31:46'),
(18,4,15,14.00,10,7,1,'{\"1501\":285,\"1502\":289,\"1503\":293,\"1504\":295,\"1505\":297,\"1506\":299,\"1507\":301,\"1508\":305,\"1509\":309,\"1510\":311}',1,'2026-02-25 09:33:17','2026-02-25 09:33:17'),
(19,4,16,18.00,10,9,1,'{\"1601\":313,\"1602\":315,\"1603\":319,\"1604\":323,\"1605\":325,\"1606\":329,\"1607\":331,\"1608\":333,\"1609\":337,\"1610\":339}',1,'2026-02-25 09:48:13','2026-02-25 09:48:13'),
(20,4,17,20.00,10,10,1,'{\"1701\":341,\"1702\":345,\"1703\":347,\"1704\":351,\"1705\":353,\"1706\":355,\"1707\":359,\"1708\":361,\"1709\":363,\"1710\":365}',1,'2026-02-25 09:49:15','2026-02-25 09:49:15'),
(21,4,18,16.00,10,8,1,'{\"1801\":369,\"1802\":371,\"1803\":373,\"1804\":375,\"1805\":377,\"1806\":379,\"1807\":381,\"1808\":383,\"1809\":387,\"1810\":389}',1,'2026-02-25 09:49:54','2026-02-25 09:49:54'),
(22,4,20,18.00,10,9,1,'{\"2001\":419,\"2002\":421,\"2003\":423,\"2004\":425,\"2005\":427,\"2006\":429,\"2007\":431,\"2008\":433,\"2009\":435,\"2010\":439}',1,'2026-02-25 09:50:36','2026-02-25 09:50:36'),
(23,4,21,14.00,10,7,1,'{\"2101\":441,\"2102\":443,\"2103\":445,\"2104\":447,\"2105\":449,\"2106\":451,\"2107\":453,\"2108\":455,\"2109\":457,\"2110\":459}',1,'2026-02-25 09:52:59','2026-02-25 09:52:59'),
(24,4,22,12.00,10,6,1,'{\"2201\":461,\"2202\":463,\"2203\":465,\"2204\":467,\"2205\":469,\"2206\":471,\"2207\":473,\"2208\":475,\"2209\":477}',1,'2026-02-25 09:54:05','2026-02-25 09:54:05'),
(25,4,23,18.00,10,9,1,'{\"2301\":481,\"2302\":484,\"2303\":487,\"2304\":491,\"2305\":493,\"2306\":497,\"2307\":499,\"2308\":503,\"2309\":507,\"2310\":509}',1,'2026-02-25 09:55:21','2026-02-25 09:55:21'),
(26,4,25,18.00,10,9,1,'{\"2501\":535,\"2502\":537,\"2503\":539,\"2504\":541,\"2505\":543,\"2506\":545,\"2507\":549,\"2508\":551,\"2509\":553,\"2510\":555}',1,'2026-02-25 09:56:09','2026-02-25 09:56:09'),
(27,4,26,18.00,10,9,1,'{\"2601\":559,\"2602\":561,\"2603\":563,\"2604\":565,\"2605\":569,\"2606\":571,\"2607\":573,\"2608\":577,\"2609\":579,\"2610\":581}',1,'2026-02-25 09:57:05','2026-02-25 09:57:05'),
(28,4,27,20.00,10,10,1,'{\"2701\":583,\"2702\":585,\"2703\":587,\"2704\":591,\"2705\":593,\"2706\":597,\"2707\":599,\"2708\":601,\"2709\":603,\"2710\":605}',1,'2026-02-25 09:57:52','2026-02-25 09:57:52'),
(29,4,28,18.00,10,9,1,'{\"2801\":607,\"2802\":609,\"2803\":611,\"2804\":613,\"2805\":615,\"2806\":619,\"2807\":621,\"2808\":623,\"2809\":625,\"2810\":627}',1,'2026-02-25 09:58:41','2026-02-25 09:58:41'),
(30,4,29,14.00,10,7,1,'{\"2901\":631,\"2902\":634,\"2903\":637,\"2904\":639,\"2905\":641,\"2906\":643,\"2907\":647,\"2908\":649,\"2909\":651,\"2910\":655}',1,'2026-02-25 09:59:34','2026-02-25 09:59:34'),
(31,4,30,18.00,10,9,1,'{\"3001\":657,\"3002\":659,\"3003\":661,\"3004\":663,\"3005\":665,\"3006\":669,\"3007\":671,\"3008\":673,\"3009\":675,\"3010\":677}',1,'2026-02-25 10:00:30','2026-02-25 10:00:30');
/*!40000 ALTER TABLE `resultats_quiz` ENABLE KEYS */;
UNLOCK TABLES;
commit;

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

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sessions` VALUES
('BIDMb0fjTAMneFHaFBPccpeEfgopP3JsExe1kZWn',2,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoicVc0ZGs1TXI1VURpTUpsR1dSSUpWTU5lU2ZUMTNsSFhjMEw4UTF5cSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vYXV0by1lY29sZS9sZWNvbnMiO3M6NToicm91dGUiO3M6Mjk6ImFkbWluLmF1dG8tZWNvbGUubGVjb25zLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9',1772019878);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sessions1`
--

DROP TABLE IF EXISTS `sessions1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `date_communication_enregistrement` date DEFAULT NULL,
  `date_enregistrement_vague1` date DEFAULT NULL,
  `date_enregistrement_vague2` date DEFAULT NULL,
  `date_transfert_reconduction` date DEFAULT NULL,
  `date_depot_departemental` date DEFAULT NULL,
  `date_depot_regional` date DEFAULT NULL,
  `date_examen_theorique` date DEFAULT NULL,
  `date_examen_pratique` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions1`
--

LOCK TABLES `sessions1` WRITE;
/*!40000 ALTER TABLE `sessions1` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sessions1` VALUES
(1,'Session Avril 2026','2026-04-05','2026-04-01','2026-04-05','2026-04-12','2026-04-20','2026-04-20','2026-04-29','2026-04-29',1,'2026-02-24 07:22:33','2026-02-24 07:22:33');
/*!40000 ALTER TABLE `sessions1` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `user_cni`
--

DROP TABLE IF EXISTS `user_cni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_cni` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `cni_recto_path` varchar(255) DEFAULT NULL,
  `cni_verso_path` varchar(255) DEFAULT NULL,
  `statut` enum('en_attente','valide','rejete') NOT NULL DEFAULT 'en_attente',
  `motif_rejet` text DEFAULT NULL,
  `soumis_at` timestamp NULL DEFAULT NULL,
  `traite_at` timestamp NULL DEFAULT NULL,
  `traite_par` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_cni_user_id_unique` (`user_id`),
  KEY `user_cni_traite_par_foreign` (`traite_par`),
  CONSTRAINT `user_cni_traite_par_foreign` FOREIGN KEY (`traite_par`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `user_cni_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_cni`
--

LOCK TABLES `user_cni` WRITE;
/*!40000 ALTER TABLE `user_cni` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `user_cni` VALUES
(1,2,'cni/2/3w3m20A5KFKCUcXevTHNLS2yGNCF6l8V4Ywc5VDk.jpg','cni/2/Lfk3CXz62zAsJSD6KopNGPNBNcxNWWb6BYZINDCL.jpg','valide',NULL,'2026-02-25 06:47:09','2026-02-25 06:47:24',2,'2026-02-24 17:41:17','2026-02-25 06:47:24',NULL);
/*!40000 ALTER TABLE `user_cni` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `user_lieux_pratique`
--

DROP TABLE IF EXISTS `user_lieux_pratique`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_lieux_pratique` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `lieu_pratique_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_lieux_pratique_user_id_foreign` (`user_id`),
  KEY `user_lieux_pratique_lieu_pratique_id_foreign` (`lieu_pratique_id`),
  CONSTRAINT `user_lieux_pratique_lieu_pratique_id_foreign` FOREIGN KEY (`lieu_pratique_id`) REFERENCES `lieux_pratique` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_lieux_pratique_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `auto_ecole_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_lieux_pratique`
--

LOCK TABLES `user_lieux_pratique` WRITE;
/*!40000 ALTER TABLE `user_lieux_pratique` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `user_lieux_pratique` ENABLE KEYS */;
UNLOCK TABLES;
commit;

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
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `users` VALUES
(1,'Test User','test@example.com','2026-02-19 11:48:55','$2y$12$h5LRYQW8ttyVUD1xDbeAqOEzhWMWjJ3PCV1UUAChzdwXqHsqYrWGm','NcofKBeHfB','2026-02-19 11:48:55','2026-02-19 11:48:55'),
(2,'ghost','ghost@gmail.com',NULL,'$2y$12$xUYJMx.IGFy/RUk/bTEkPuxHkh8wAqzUIIU/3.co5kGlw9w4ltYf2',NULL,'2026-02-19 11:50:38','2026-02-19 11:50:38');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-02-25 12:45:00
