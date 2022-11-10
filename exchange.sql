-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: localhost    Database: exchange
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accountcrypto`
--

DROP TABLE IF EXISTS `accountcrypto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accountcrypto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `name_on_account` varchar(30) DEFAULT NULL,
  `publickey` varchar(45) DEFAULT NULL,
  `privatekey` varchar(60) DEFAULT NULL,
  `comment` varchar(60) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_tb_accountcrypto_users_idx` (`user_id`),
  CONSTRAINT `fk_tb_accountcrypto_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountcrypto`
--

LOCK TABLES `accountcrypto` WRITE;
/*!40000 ALTER TABLE `accountcrypto` DISABLE KEYS */;
/*!40000 ALTER TABLE `accountcrypto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accountfiat`
--

DROP TABLE IF EXISTS `accountfiat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accountfiat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `name_on_account` varchar(30) DEFAULT NULL,
  `bank_name` varchar(45) DEFAULT NULL,
  `bank_address` varchar(60) DEFAULT NULL,
  `accnumber1` varchar(45) DEFAULT NULL COMMENT 'iban',
  `accnumber2` varchar(45) DEFAULT NULL COMMENT 'swift code',
  `accnumber3` varchar(45) DEFAULT NULL,
  `comment` varchar(60) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_tb_accountfiat_users1_idx` (`user_id`),
  CONSTRAINT `fk_tb_accountfiat_users1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountfiat`
--

LOCK TABLES `accountfiat` WRITE;
/*!40000 ALTER TABLE `accountfiat` DISABLE KEYS */;
/*!40000 ALTER TABLE `accountfiat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `balance`
--

DROP TABLE IF EXISTS `balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_crypto1` decimal(11,10) NOT NULL DEFAULT '0.0000000000',
  `account_crypto2` decimal(11,10) NOT NULL DEFAULT '0.0000000000',
  `account_fiat1` decimal(10,2) NOT NULL DEFAULT '0.00',
  `account_fiat2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `account_fiat3` decimal(10,2) NOT NULL DEFAULT '0.00',
  `user_id` int(11) NOT NULL,
  `account_crypto3` decimal(11,10) DEFAULT '0.0000000000',
  `account_fiat4` decimal(10,2) DEFAULT '0.00',
  `account_fiat5` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`,`user_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_balance_user1_idx` (`user_id`),
  CONSTRAINT `fk_balance_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance`
--

LOCK TABLES `balance` WRITE;
/*!40000 ALTER TABLE `balance` DISABLE KEYS */;
/*!40000 ALTER TABLE `balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `iso` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `iso3` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `dial` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_name_iso_iso3_dial_unique` (`name`,`iso`,`iso3`,`dial`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Afghanistan','AF','AFG','93','AFN','Afghani'),(2,'Albania','AL','ALB','355','ALL','Lek'),(3,'Algeria','DZ','DZA','213','DZD','Algerian Dinar'),(4,'American Samoa','AS','ASM','1-684','USD','US Dollar'),(5,'Andorra','AD','AND','376','EUR','Euro'),(6,'Angola','AO','AGO','244','AOA','Kwanza'),(7,'Anguilla','AI','AIA','1-264','XCD','East Caribbean Dollar'),(8,'Antarctica','AQ','ATA','672',NULL,NULL),(9,'Antigua and Barbuda','AG','ATG','1-268','XCD','East Caribbean Dollar'),(10,'Argentina','AR','ARG','54','ARS','Argentine Peso'),(11,'Armenia','AM','ARM','374','AMD','Armenian Dram'),(12,'Aruba','AW','ABW','297','AWG','Aruban Florin'),(13,'Australia','AU','AUS','61','AUD','Australian Dollar'),(14,'Austria','AT','AUT','43','EUR','Euro'),(15,'Azerbaijan','AZ','AZE','994','AZN','Azerbaijanian Manat'),(16,'Bahamas','BS','BHS','1-242','BSD','Bahamian Dollar'),(17,'Bahrain','BH','BHR','973','BHD','Bahraini Dinar'),(18,'Bangladesh','BD','BGD','880','BDT','Taka'),(19,'Barbados','BB','BRB','1-246','BBD','Barbados Dollar'),(20,'Belarus','BY','BLR','375','BYR','Belarussian Ruble'),(21,'Belgium','BE','BEL','32','EUR','Euro'),(22,'Belize','BZ','BLZ','501','BZD','Belize Dollar'),(23,'Benin','BJ','BEN','229','XOF','CFA Franc BCEAO'),(24,'Bermuda','BM','BMU','1-441','BMD','Bermudian Dollar'),(25,'Bhutan','BT','BTN','975','INR','Indian Rupee'),(26,'Bolivia, Plurinational State of','BO','BOL','591','BOB','Boliviano'),(27,'Bonaire, Sint Eustatius and Saba','BQ','BES','599','USD','US Dollar'),(28,'Bosnia and Herzegovina','BA','BIH','387','BAM','Convertible Mark'),(29,'Botswana','BW','BWA','267','BWP','Pula'),(30,'Bouvet Island','BV','BVT','47','NOK','Norwegian Krone'),(31,'Brazil','BR','BRA','55','BRL','Brazilian Real'),(32,'British Indian Ocean Territory','IO','IOT','246','USD','US Dollar'),(33,'Brunei Darussalam','BN','BRN','673','BND','Brunei Dollar'),(34,'Bulgaria','BG','BGR','359','BGN','Bulgarian Lev'),(35,'Burkina Faso','BF','BFA','226','XOF','CFA Franc BCEAO'),(36,'Burundi','BI','BDI','257','BIF','Burundi Franc'),(37,'Cambodia','KH','KHM','855','KHR','Riel'),(38,'Cameroon','CM','CMR','237','XAF','CFA Franc BEAC'),(39,'Canada','CA','CAN','1','CAD','Canadian Dollar'),(40,'Cape Verde','CV','CPV','238','CVE','Cabo Verde Escudo'),(41,'Cayman Islands','KY','CYM','1-345','KYD','Cayman Islands Dollar'),(42,'Central African Republic','CF','CAF','236','XAF','CFA Franc BEAC'),(43,'Chad','TD','TCD','235','XAF','CFA Franc BEAC'),(44,'Chile','CL','CHL','56','CLP','Chilean Peso'),(45,'China','CN','CHN','86','CNY','Yuan Renminbi'),(46,'Christmas Island','CX','CXR','61','AUD','Australian Dollar'),(47,'Cocos (Keeling) Islands','CC','CCK','61','AUD','Australian Dollar'),(48,'Colombia','CO','COL','57','COP','Colombian Peso'),(49,'Comoros','KM','COM','269','KMF','Comoro Franc'),(50,'Congo','CG','COG','242','XAF','CFA Franc BEAC'),(51,'Congo, the Democratic Republic of the','CD','COD','243',NULL,NULL),(52,'Cook Islands','CK','COK','682','NZD','New Zealand Dollar'),(53,'Costa Rica','CR','CRI','506','CRC','Costa Rican Colon'),(54,'Croatia','HR','HRV','385','HRK','Croatian Kuna'),(55,'Cuba','CU','CUB','53','CUP','Cuban Peso'),(56,'Curaçao','CW','CUW','599','ANG','Netherlands Antillean Guilder'),(57,'Cyprus','CY','CYP','357','EUR','Euro'),(58,'Czech Republic','CZ','CZE','420','CZK','Czech Koruna'),(59,'Côte d\'Ivoire','CI','CIV','225','XOF','CFA Franc BCEAO'),(60,'Denmark','DK','DNK','45','DKK','Danish Krone'),(61,'Djibouti','DJ','DJI','253','DJF','Djibouti Franc'),(62,'Dominica','DM','DMA','1-767','XCD','East Caribbean Dollar'),(63,'Dominican Republic','DO','DOM','1-809','DOP','Dominican Peso'),(64,'Ecuador','EC','ECU','593','USD','US Dollar'),(65,'Egypt','EG','EGY','20','EGP','Egyptian Pound'),(66,'El Salvador','SV','SLV','503','USD','US Dollar'),(67,'Equatorial Guinea','GQ','GNQ','240','XAF','CFA Franc BEAC'),(68,'Eritrea','ER','ERI','291','ERN','Nakfa'),(69,'Estonia','EE','EST','372','EUR','Euro'),(70,'Ethiopia','ET','ETH','251','ETB','Ethiopian Birr'),(71,'Falkland Islands (Malvinas)','FK','FLK','500','FKP','Falkland Islands Pound'),(72,'Faroe Islands','FO','FRO','298','DKK','Danish Krone'),(73,'Fiji','FJ','FJI','679','FJD','Fiji Dollar'),(74,'Finland','FI','FIN','358','EUR','Euro'),(75,'France','FR','FRA','33','EUR','Euro'),(76,'French Guiana','GF','GUF','594','EUR','Euro'),(77,'French Polynesia','PF','PYF','689','XPF','CFP Franc'),(78,'French Southern Territories','TF','ATF','262','EUR','Euro'),(79,'Gabon','GA','GAB','241','XAF','CFA Franc BEAC'),(80,'Gambia','GM','GMB','220','GMD','Dalasi'),(81,'Georgia','GE','GEO','995','GEL','Lari'),(82,'Germany','DE','DEU','49','EUR','Euro'),(83,'Ghana','GH','GHA','233','GHS','Ghana Cedi'),(84,'Gibraltar','GI','GIB','350','GIP','Gibraltar Pound'),(85,'Greece','GR','GRC','30','EUR','Euro'),(86,'Greenland','GL','GRL','299','DKK','Danish Krone'),(87,'Grenada','GD','GRD','1-473','XCD','East Caribbean Dollar'),(88,'Guadeloupe','GP','GLP','590','EUR','Euro'),(89,'Guam','GU','GUM','1-671','USD','US Dollar'),(90,'Guatemala','GT','GTM','502','GTQ','Quetzal'),(91,'Guernsey','GG','GGY','44','GBP','Pound Sterling'),(92,'Guinea','GN','GIN','224','GNF','Guinea Franc'),(93,'Guinea-Bissau','GW','GNB','245','XOF','CFA Franc BCEAO'),(94,'Guyana','GY','GUY','592','GYD','Guyana Dollar'),(95,'Haiti','HT','HTI','509','USD','US Dollar'),(96,'Heard Island and McDonald Islands','HM','HMD','672','AUD','Australian Dollar'),(97,'Holy See (Vatican City State)','VA','VAT','39-06','EUR','Euro'),(98,'Honduras','HN','HND','504','HNL','Lempira'),(99,'Hong Kong','HK','HKG','852','HKD','Hong Kong Dollar'),(100,'Hungary','HU','HUN','36','HUF','Forint'),(101,'Iceland','IS','ISL','354','ISK','Iceland Krona'),(102,'India','IN','IND','91','INR','Indian Rupee'),(103,'Indonesia','ID','IDN','62','IDR','Rupiah'),(104,'Iran, Islamic Republic of','IR','IRN','98','IRR','Iranian Rial'),(105,'Iraq','IQ','IRQ','964','IQD','Iraqi Dinar'),(106,'Ireland','IE','IRL','353','EUR','Euro'),(107,'Isle of Man','IM','IMN','44','GBP','Pound Sterling'),(108,'Israel','IL','ISR','972','ILS','New Israeli Sheqel'),(109,'Italy','IT','ITA','39','EUR','Euro'),(110,'Jamaica','JM','JAM','1-876','JMD','Jamaican Dollar'),(111,'Japan','JP','JPN','81','JPY','Yen'),(112,'Jersey','JE','JEY','44','GBP','Pound Sterling'),(113,'Jordan','JO','JOR','962','JOD','Jordanian Dinar'),(114,'Kazakhstan','KZ','KAZ','7','KZT','Tenge'),(115,'Kenya','KE','KEN','254','KES','Kenyan Shilling'),(116,'Kiribati','KI','KIR','686','AUD','Australian Dollar'),(117,'Korea, Democratic People\'s Republic of','KP','PRK','850','KPW','North Korean Won'),(118,'Korea, Republic of','KR','KOR','82','KRW','Won'),(119,'Kuwait','KW','KWT','965','KWD','Kuwaiti Dinar'),(120,'Kyrgyzstan','KG','KGZ','996','KGS','Som'),(121,'Lao People\'s Democratic Republic','LA','LAO','856','LAK','Kip'),(122,'Latvia','LV','LVA','371','EUR','Euro'),(123,'Lebanon','LB','LBN','961','LBP','Lebanese Pound'),(124,'Lesotho','LS','LSO','266','ZAR','Rand'),(125,'Liberia','LR','LBR','231','LRD','Liberian Dollar'),(126,'Libya','LY','LBY','218','LYD','Libyan Dinar'),(127,'Liechtenstein','LI','LIE','423','CHF','Swiss Franc'),(128,'Lithuania','LT','LTU','370','EUR','Euro'),(129,'Luxembourg','LU','LUX','352','EUR','Euro'),(130,'Macao','MO','MAC','853','MOP','Pataca'),(131,'Macedonia, the Former Yugoslav Republic of','MK','MKD','389','MKD','Denar'),(132,'Madagascar','MG','MDG','261','MGA','Malagasy Ariary'),(133,'Malawi','MW','MWI','265','MWK','Kwacha'),(134,'Malaysia','MY','MYS','60','MYR','Malaysian Ringgit'),(135,'Maldives','MV','MDV','960','MVR','Rufiyaa'),(136,'Mali','ML','MLI','223','XOF','CFA Franc BCEAO'),(137,'Malta','MT','MLT','356','EUR','Euro'),(138,'Marshall Islands','MH','MHL','692','USD','US Dollar'),(139,'Martinique','MQ','MTQ','596','EUR','Euro'),(140,'Mauritania','MR','MRT','222','MRO','Ouguiya'),(141,'Mauritius','MU','MUS','230','MUR','Mauritius Rupee'),(142,'Mayotte','YT','MYT','262','EUR','Euro'),(143,'Mexico','MX','MEX','52','MXN','Mexican Peso'),(144,'Micronesia, Federated States of','FM','FSM','691','USD','US Dollar'),(145,'Moldova, Republic of','MD','MDA','373','MDL','Moldovan Leu'),(146,'Monaco','MC','MCO','377','EUR','Euro'),(147,'Mongolia','MN','MNG','976','MNT','Tugrik'),(148,'Montenegro','ME','MNE','382','EUR','Euro'),(149,'Montserrat','MS','MSR','1-664','XCD','East Caribbean Dollar'),(150,'Morocco','MA','MAR','212','MAD','Moroccan Dirham'),(151,'Mozambique','MZ','MOZ','258','MZN','Mozambique Metical'),(152,'Myanmar','MM','MMR','95','MMK','Kyat'),(153,'Namibia','NA','NAM','264','ZAR','Rand'),(154,'Nauru','NR','NRU','674','AUD','Australian Dollar'),(155,'Nepal','NP','NPL','977','NPR','Nepalese Rupee'),(156,'Netherlands','NL','NLD','31','EUR','Euro'),(157,'New Caledonia','NC','NCL','687','XPF','CFP Franc'),(158,'New Zealand','NZ','NZL','64','NZD','New Zealand Dollar'),(159,'Nicaragua','NI','NIC','505','NIO','Cordoba Oro'),(160,'Niger','NE','NER','227','XOF','CFA Franc BCEAO'),(161,'Nigeria','NG','NGA','234','NGN','Naira'),(162,'Niue','NU','NIU','683','NZD','New Zealand Dollar'),(163,'Norfolk Island','NF','NFK','672','AUD','Australian Dollar'),(164,'Northern Mariana Islands','MP','MNP','1-670','USD','US Dollar'),(165,'Norway','NO','NOR','47','NOK','Norwegian Krone'),(166,'Oman','OM','OMN','968','OMR','Rial Omani'),(167,'Pakistan','PK','PAK','92','PKR','Pakistan Rupee'),(168,'Palau','PW','PLW','680','USD','US Dollar'),(169,'Palestine, State of','PS','PSE','970',NULL,NULL),(170,'Panama','PA','PAN','507','USD','US Dollar'),(171,'Papua New Guinea','PG','PNG','675','PGK','Kina'),(172,'Paraguay','PY','PRY','595','PYG','Guarani'),(173,'Peru','PE','PER','51','PEN','Nuevo Sol'),(174,'Philippines','PH','PHL','63','PHP','Philippine Peso'),(175,'Pitcairn','PN','PCN','870','NZD','New Zealand Dollar'),(176,'Poland','PL','POL','48','PLN','Zloty'),(177,'Portugal','PT','PRT','351','EUR','Euro'),(178,'Puerto Rico','PR','PRI','1','USD','US Dollar'),(179,'Qatar','QA','QAT','974','QAR','Qatari Rial'),(180,'Romania','RO','ROU','40','RON','New Romanian Leu'),(181,'Russian Federation','RU','RUS','7','RUB','Russian Ruble'),(182,'Rwanda','RW','RWA','250','RWF','Rwanda Franc'),(183,'Réunion','RE','REU','262','EUR','Euro'),(184,'Saint Barthélemy','BL','BLM','590','EUR','Euro'),(185,'Saint Helena, Ascension and Tristan da Cunha','SH','SHN','290','SHP','Saint Helena Pound'),(186,'Saint Kitts and Nevis','KN','KNA','1-869','XCD','East Caribbean Dollar'),(187,'Saint Lucia','LC','LCA','1-758','XCD','East Caribbean Dollar'),(188,'Saint Martin (French part)','MF','MAF','590','EUR','Euro'),(189,'Saint Pierre and Miquelon','PM','SPM','508','EUR','Euro'),(190,'Saint Vincent and the Grenadines','VC','VCT','1-784','XCD','East Caribbean Dollar'),(191,'Samoa','WS','WSM','685','WST','Tala'),(192,'San Marino','SM','SMR','378','EUR','Euro'),(193,'Sao Tome and Principe','ST','STP','239','STD','Dobra'),(194,'Saudi Arabia','SA','SAU','966','SAR','Saudi Riyal'),(195,'Senegal','SN','SEN','221','XOF','CFA Franc BCEAO'),(196,'Serbia','RS','SRB','381','RSD','Serbian Dinar'),(197,'Seychelles','SC','SYC','248','SCR','Seychelles Rupee'),(198,'Sierra Leone','SL','SLE','232','SLL','Leone'),(199,'Singapore','SG','SGP','65','SGD','Singapore Dollar'),(200,'Sint Maarten (Dutch part)','SX','SXM','1-721','ANG','Netherlands Antillean Guilder'),(201,'Slovakia','SK','SVK','421','EUR','Euro'),(202,'Slovenia','SI','SVN','386','EUR','Euro'),(203,'Solomon Islands','SB','SLB','677','SBD','Solomon Islands Dollar'),(204,'Somalia','SO','SOM','252','SOS','Somali Shilling'),(205,'South Africa','ZA','ZAF','27','ZAR','Rand'),(206,'South Georgia and the South Sandwich Islands','GS','SGS','500',NULL,NULL),(207,'South Sudan','SS','SSD','211','SSP','South Sudanese Pound'),(208,'Spain','ES','ESP','34','EUR','Euro'),(209,'Sri Lanka','LK','LKA','94','LKR','Sri Lanka Rupee'),(210,'Sudan','SD','SDN','249','SDG','Sudanese Pound'),(211,'Suriname','SR','SUR','597','SRD','Surinam Dollar'),(212,'Svalbard and Jan Mayen','SJ','SJM','47','NOK','Norwegian Krone'),(213,'Swaziland','SZ','SWZ','268','SZL','Lilangeni'),(214,'Sweden','SE','SWE','46','SEK','Swedish Krona'),(215,'Switzerland','CH','CHE','41','CHF','Swiss Franc'),(216,'Syrian Arab Republic','SY','SYR','963','SYP','Syrian Pound'),(217,'Taiwan, Province of China','TW','TWN','886','TWD','New Taiwan Dollar'),(218,'Tajikistan','TJ','TJK','992','TJS','Somoni'),(219,'Tanzania, United Republic of','TZ','TZA','255','TZS','Tanzanian Shilling'),(220,'Thailand','TH','THA','66','THB','Baht'),(221,'Timor-Leste','TL','TLS','670','USD','US Dollar'),(222,'Togo','TG','TGO','228','XOF','CFA Franc BCEAO'),(223,'Tokelau','TK','TKL','690','NZD','New Zealand Dollar'),(224,'Tonga','TO','TON','676','TOP','Pa’anga'),(225,'Trinidad and Tobago','TT','TTO','1-868','TTD','Trinidad and Tobago Dollar'),(226,'Tunisia','TN','TUN','216','TND','Tunisian Dinar'),(227,'Turkey','TR','TUR','90','TRY','Turkish Lira'),(228,'Turkmenistan','TM','TKM','993','TMT','Turkmenistan New Manat'),(229,'Turks and Caicos Islands','TC','TCA','1-649','USD','US Dollar'),(230,'Tuvalu','TV','TUV','688','AUD','Australian Dollar'),(231,'Uganda','UG','UGA','256','UGX','Uganda Shilling'),(232,'Ukraine','UA','UKR','380','UAH','Hryvnia'),(233,'United Arab Emirates','AE','ARE','971','AED','UAE Dirham'),(234,'United Kingdom','GB','GBR','44','GBP','Pound Sterling'),(235,'United States','US','USA','1','USD','US Dollar'),(236,'United States Minor Outlying Islands','UM','UMI','1','USD','US Dollar'),(237,'Uruguay','UY','URY','598','UYU','Peso Uruguayo'),(238,'Uzbekistan','UZ','UZB','998','UZS','Uzbekistan Sum'),(239,'Vanuatu','VU','VUT','678','VUV','Vatu'),(240,'Venezuela, Bolivarian Republic of','VE','VEN','58','VEF','Bolivar'),(241,'Viet Nam','VN','VNM','84','VND','Dong'),(242,'Virgin Islands, British','VG','VGB','1-284','USD','US Dollar'),(243,'Virgin Islands, U.S.','VI','VIR','1-340','USD','US Dollar'),(244,'Wallis and Futuna','WF','WLF','681','XPF','CFP Franc'),(245,'Western Sahara','EH','ESH','212','MAD','Moroccan Dirham'),(246,'Yemen','YE','YEM','967','YER','Yemeni Rial'),(247,'Zambia','ZM','ZMB','260','ZMW','Zambian Kwacha'),(248,'Zimbabwe','ZW','ZWE','263','ZWL','Zimbabwe Dollar'),(249,'Åland Islands','AX','ALA','358','EUR','Euro');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `firstname` char(35) DEFAULT NULL,
  `lastname` char(35) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(60) NOT NULL,
  `verification` int(11) DEFAULT '0' COMMENT '0=not verified\n1=in progress\n2=verified',
  `birthday` date DEFAULT NULL COMMENT '''YYYY-MM-DD''',
  `identification` varchar(15) DEFAULT NULL,
  `typeid` varchar(20) DEFAULT NULL COMMENT '0= Passport\n1= Driving License     \n2= Identification card',
  `country` char(40) DEFAULT NULL,
  `state` char(40) DEFAULT NULL COMMENT 'state/province',
  `city` char(40) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `postalcode` varchar(15) DEFAULT NULL,
  `telephone` int(15) DEFAULT NULL,
  `language` varchar(25) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL COMMENT '0=usd\n1=euro\n2=yene\n3=real',
  `ModifiedIP` varchar(16) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedIP` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `id_user_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='tabela de usuarios';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (6,'nickee','Nicolas','M2afra','nickmafra@hotmail.com','$2y$10$PhGFFDKTyoAboZehYulujepcSkIAAG9hOja5CbTvEBZwSVYcVTnzG',0,'1997-07-29',NULL,NULL,'BR','SP','Praia Grande','Ruazinha, n 20','11222333',1334811234,NULL,NULL,NULL,NULL,0,NULL,NULL),(7,'davi','fff','ff','eeee','eeeee',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL),(8,'paulo','paull','doido1','3333','445555',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-02  6:49:32
