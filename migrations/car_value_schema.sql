-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: car_value
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


--
-- Table structure for table `car_make`
--

DROP TABLE IF EXISTS `car_make`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_make` (
                            `make_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `make_name` varchar(50) NOT NULL,
                            PRIMARY KEY (`make_id`),
                            UNIQUE KEY `make_name` (`make_name`),
                            KEY `make_name_2` (`make_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1470 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `car_model`
--

DROP TABLE IF EXISTS `car_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_model` (
                             `model_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                             `make_id` int(11) unsigned NOT NULL,
                             `model_name` varchar(50) NOT NULL,
                             PRIMARY KEY (`model_id`),
                             UNIQUE KEY `model_name` (`model_name`),
                             KEY `make_id` (`make_id`),
                             KEY `model_name_2` (`model_name`),
                             CONSTRAINT `fk_make_model` FOREIGN KEY (`make_id`) REFERENCES `car_make` (`make_id`)
) ENGINE=InnoDB AUTO_INCREMENT=251190 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `car`
--

DROP TABLE IF EXISTS `car`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car` (
  `car_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(11) unsigned NOT NULL,
  `vin` varchar(50) NOT NULL,
  `trim_name` varchar(50) NOT NULL,
  `year_release` int(11) unsigned NOT NULL,
  `car_engine` varchar(50) NOT NULL,
  `fuel_type` varchar(50) NOT NULL,
  `driven_wheels` varchar(50) NOT NULL,
  `style` varchar(50) NOT NULL,
  `exterior_color` varchar(50) NOT NULL,
  `interior_color` varchar(50) NOT NULL,
  PRIMARY KEY (`car_id`),
  UNIQUE KEY `vin` (`vin`),
  KEY `trim_name` (`trim_name`),
  KEY `year_release` (`year_release`),
  KEY `fk_car_model` (`model_id`),
  CONSTRAINT `fk_car_model` FOREIGN KEY (`model_id`) REFERENCES `car_model` (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4713915 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dealer`
--

DROP TABLE IF EXISTS `dealer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dealer` (
  `dealer_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dealer_name` varchar(100) NOT NULL,
  `dealer_street` varchar(100) NOT NULL,
  `dealer_city` varchar(50) NOT NULL,
  `dealer_state` varchar(50) NOT NULL,
  `dealer_zip` varchar(50) NOT NULL,
  `seller_website` varchar(50) NOT NULL,
  `dealer_vdp_last_seen_date` date NOT NULL,
  `dealer_country` varchar(50) NOT NULL,
  PRIMARY KEY (`dealer_id`),
  UNIQUE KEY `UC_Dealer` (`dealer_name`,`dealer_city`,`dealer_street`,`dealer_state`,`dealer_zip`) USING HASH,
  KEY `dealer_name` (`dealer_name`),
  KEY `dealer_city` (`dealer_city`),
  KEY `dealer_street` (`dealer_street`),
  KEY `dealer_state` (`dealer_state`),
  KEY `dealer_zip` (`dealer_zip`),
  KEY `dealer_country` (`dealer_country`)
) ENGINE=InnoDB AUTO_INCREMENT=62742 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `inventory_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `car_id` int(11) unsigned NOT NULL,
  `dealer_id` int(11) unsigned NOT NULL,
  `listing_price` decimal(9,2) NOT NULL,
  `listing_mileage` int(11) NOT NULL,
  `used` tinyint(1) NOT NULL,
  `certified` tinyint(1) NOT NULL,
  `first_seen_date` date NOT NULL,
  `last_seen_date` date NOT NULL,
  `listing_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`inventory_id`),
  KEY `car_id` (`car_id`),
  KEY `dealer_id` (`dealer_id`),
  KEY `listing_price` (`listing_price`),
  KEY `first_seen_date` (`first_seen_date`),
  KEY `listing_mileage` (`listing_mileage`),
  CONSTRAINT `fk_car_inventory` FOREIGN KEY (`car_id`) REFERENCES `car` (`car_id`),
  CONSTRAINT `fk_dealer_inventory` FOREIGN KEY (`dealer_id`) REFERENCES `dealer` (`dealer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4713915 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-15 16:15:04
