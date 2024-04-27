-- MySQL dump 10.13  Distrib 8.0.26, for Win64 (x86_64)
--
-- Host: localhost    Database: lg_db
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
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `amount` float NOT NULL,
  `status` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `RID_idx` (`receiver_id`),
  KEY `SID_idx` (`sender_id`),
  CONSTRAINT `RID` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  CONSTRAINT `SID` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `document` varchar(8) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `wallet_id` int DEFAULT NULL,
  `user_type` varchar(30) NOT NULL DEFAULT 'REGULAR',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document_UNIQUE` (`document`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `WID_idx` (`wallet_id`),
  CONSTRAINT `WID` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Andy Alvarado','99887766','andy@yopmail.com','$2y$10$cYShBi05uaqWDwsphJbQdOSOqBtqPuzX3q3iN3ZT3a1qr/78DWU/S',1,'REGULAR','2024-01-01 05:00:00','2024-01-01 05:00:00'),(2,'Andy Alvarado','11223344','andy3@yopmail.com','$2y$10$cYShBi05uaqWDwsphJbQdOSOqBtqPuzX3q3iN3ZT3a1qr/78DWU/S',23,'REGULAR','2024-04-26 14:48:58','2024-04-26 14:48:58'),(3,'Andy Alvarado','11223324','andy5@yopmail.com','$2y$10$sFFR/4RlarMIlUoneMqdk.PEhiLwGp5cRbeYuc0ZKOB40LTTKon5W',24,'REGULAR','2024-04-26 19:29:35','2024-04-26 19:29:35'),(4,'Andy Alvarado','14223644','andy4@yopmail.com','$2y$10$Uec4fz7yRggAN0sPE7CO7OtMFoRgKatFSerM5Xgqv6K3xYC1YyuIK',25,'REGULAR','2024-04-26 20:03:07','2024-04-26 20:03:07'),(5,'Andy Alvarado','14223664','andy6@yopmail.com','$2y$10$9UZDex8XkhKZ/jtgxEVMt.PyCfM5UBv8pgoEf.3aLrh7rB96aK2jO',26,'REGULAR','2024-04-26 20:03:16','2024-04-26 20:03:16'),(6,'Andy Alvarado','17223664','andy7@yopmail.com','$2y$10$HgUxiaOmdj6OCqv291cjtulXl5lV.EAi2SRmgb0fkiz3zEitLPtKC',27,'REGULAR','2024-04-26 20:03:20','2024-04-26 20:03:20'),(7,'Andy Alvarado','87223664','andy8@yopmail.com','$2y$10$O.qyxLbkyLG0SuIR0jS8KOasvqkZIWi6G42hlE6y1TaImocbBe.P.',28,'REGULAR','2024-04-26 20:03:30','2024-04-26 20:03:30'),(8,'Andy Alvarado','87223694','andy9@yopmail.com','$2y$10$xjZFFykH5NCdt49iGo7/t.Y79fgzQeLdTLGMK8hNHa0NvnVVD2n7.',29,'REGULAR','2024-04-26 20:03:53','2024-04-26 20:03:53'),(9,'Andy Alvarado','87253694','andy10@yopmail.com','$2y$10$QJxSN8liPtT1K5ZUtmBjx.W.5mcz.T49WYvc912NJ23Evd88ivAQq',30,'MERCHANT','2024-04-26 20:05:03','2024-04-26 20:05:03'),(10,'Andy Alvarado','87533694','andy11@yopmail.com','$2y$10$HJjWiCmG0UgzRz7EgSw4I.ekRgHVUBu/Xh51kg0qiu2qqSXXWpRMS',31,'MERCHANT','2024-04-26 20:05:32','2024-04-26 20:05:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `balance` float NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallets`
--

LOCK TABLES `wallets` WRITE;
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;
INSERT INTO `wallets` VALUES (1,500,'2024-01-01 05:00:00','2024-01-01 05:00:00'),(23,100,'2024-04-26 14:48:58','2024-04-26 14:48:58'),(24,100,'2024-04-26 19:29:35','2024-04-26 19:29:35'),(25,50,'2024-04-26 20:03:07','2024-04-26 20:03:07'),(26,50,'2024-04-26 20:03:16','2024-04-26 20:03:16'),(27,50,'2024-04-26 20:03:20','2024-04-26 20:03:20'),(28,50,'2024-04-26 20:03:30','2024-04-26 20:03:30'),(29,50,'2024-04-26 20:03:53','2024-04-26 20:03:53'),(30,50,'2024-04-26 20:05:03','2024-04-26 20:05:03'),(31,50,'2024-04-26 20:05:32','2024-04-26 20:05:32');
/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-26 15:06:11
