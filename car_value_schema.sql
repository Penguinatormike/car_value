
--
-- Table structure for table `car`
--

DROP TABLE IF EXISTS `car`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car` (
  `car_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(11) unsigned NOT NULL,
  `vin` varchar(255) NOT NULL,
  `trim_name` varchar(255) NOT NULL,
  `year_release` int(11) unsigned NOT NULL,
  `car_engine` varchar(255) NOT NULL,
  `fuel_type` varchar(255) NOT NULL,
  `driven_wheels` varchar(255) NOT NULL,
  `style` varchar(255) NOT NULL,
  `exterior_color` varchar(255) NOT NULL,
  `interior_color` varchar(255) NOT NULL,
  PRIMARY KEY (`car_id`),
  UNIQUE KEY `vin` (`vin`),
  KEY `trim_name` (`trim_name`),
  KEY `year_release` (`year_release`),
  KEY `fk_car_model` (`model_id`),
  CONSTRAINT `fk_car_model` FOREIGN KEY (`model_id`) REFERENCES `car_model` (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4713915 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `car_make`
--

DROP TABLE IF EXISTS `car_make`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_make` (
  `make_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `make_name` varchar(255) NOT NULL,
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
  `model_name` varchar(255) NOT NULL,
  PRIMARY KEY (`model_id`),
  UNIQUE KEY `model_name` (`model_name`),
  KEY `make_id` (`make_id`),
  KEY `model_name_2` (`model_name`),
  CONSTRAINT `fk_make_model` FOREIGN KEY (`make_id`) REFERENCES `car_make` (`make_id`)
) ENGINE=InnoDB AUTO_INCREMENT=251190 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dealer`
--

DROP TABLE IF EXISTS `dealer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dealer` (
  `dealer_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dealer_name` varchar(255) NOT NULL,
  `dealer_country` varchar(255) NOT NULL,
  `dealer_street` varchar(255) NOT NULL,
  `dealer_city` varchar(255) NOT NULL,
  `dealer_state` varchar(255) NOT NULL,
  `dealer_zip` varchar(255) NOT NULL,
  `seller_website` varchar(255) NOT NULL,
  `dealer_vdp_last_seen_date` date NOT NULL,
  PRIMARY KEY (`dealer_id`),
  UNIQUE KEY `UC_Dealer` (`dealer_name`,`dealer_city`,`dealer_street`,`dealer_state`,`dealer_zip`) USING HASH,
  KEY `dealer_name` (`dealer_name`),
  KEY `dealer_city` (`dealer_country`),
  KEY `dealer_city` (`dealer_city`),
  KEY `dealer_street` (`dealer_street`),
  KEY `dealer_state` (`dealer_state`),
  KEY `dealer_zip` (`dealer_zip`)
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
  `listing_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`inventory_id`),
  KEY `car_id` (`car_id`),
  KEY `dealer_id` (`dealer_id`),
  KEY `listing_price` (`listing_price`),
  KEY `listing_mileage` (`listing_mileage`),
  CONSTRAINT `fk_car_inventory` FOREIGN KEY (`car_id`) REFERENCES `car` (`car_id`),
  CONSTRAINT `fk_dealer_inventory` FOREIGN KEY (`dealer_id`) REFERENCES `dealer` (`dealer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4713915 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
