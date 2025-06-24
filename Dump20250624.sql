-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: Stripe_Pay
-- ------------------------------------------------------
-- Server version	8.0.42-0ubuntu0.24.04.1

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
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `stripe_session_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','paid','canceled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,'REF-685A3AFE23F66','pramobackup@gmail.com',33.00,'cs_test_a1pDZ1Q7bONoB0nL2cYTYmbRDbPzk8pnYPMCRHYBmDidlveF6OIiZxLAtr','pending','2025-06-24 05:43:26'),(2,'REF-685A3B44D5BBD','pramobackup@gmail.com',33.00,'cs_test_a16J8v8jlVVNN3sLUmQsUOxAJvyy9WxPCgEoc6SQtdKF2nN5DtDgidwHMW','pending','2025-06-24 05:44:37'),(3,'REF-685A3D377D334','pramobackup@gmail.com',33.00,'cs_test_a1SuLVSWfK1wHSI7F4QtgYWoc3FN5E52cJSkZ5lr21SkNZw0V78kjrzJp2','pending','2025-06-24 05:52:56'),(4,'REF-685A3F48759AC','pramobackup@gmail.com',33.00,'cs_test_a1ePRUPyd77AJCS4xIwkImQiQlpWSFfof5wq5Eb6LFI5rHvCIQnrGg41KX','pending','2025-06-24 06:01:45'),(5,'REF-685A40C3CD178','pramobackup@gmail.com',22.00,'cs_test_a1yR5C7q6vWivbDQvrmeOnlkrBmlspRsrUi9UEDBN9qU3EU8ZEL0ZhjCgs','pending','2025-06-24 06:08:09'),(6,'REF-685A435D9DCB1','pramobackup@gmail.com',22.00,'cs_test_a1F7qwV68HGzIgkObGXaGXVyA4DNKUdZC15V0OkLrVvRS5Q6qIDB0cSIeF','pending','2025-06-24 06:19:10'),(7,'REF-685A43D1CFA5E','pramobackup@gmail.com',22.00,'cs_test_a1FUaEziTYKbtfFP1IA9awEHQ4q6CwT6xmngB3nlGUl1dAuyyhRAzEllzu','paid','2025-06-24 06:21:06');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-24 12:07:04
