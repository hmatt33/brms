-- MySQL dump 10.13  Distrib 5.7.19, for Linux (i686)
--
-- Host: localhost    Database: brms
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `Buildings`
--

DROP TABLE IF EXISTS `Buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Buildings` (
  `BuildingID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `PhoneNumber` int(11) NOT NULL,
  `TotalRooms` int(11) NOT NULL,
  `TotalVacRooms` int(11) NOT NULL,
  `Res` varchar(20) NOT NULL DEFAULT 'Show Residents',
  `Edit` varchar(10) NOT NULL DEFAULT 'Edit',
  `Del` varchar(10) NOT NULL DEFAULT 'Delete',
  PRIMARY KEY (`BuildingID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Buildings`
--

LOCK TABLES `Buildings` WRITE;
/*!40000 ALTER TABLE `Buildings` DISABLE KEYS */;
INSERT INTO `Buildings` VALUES (1,'Building 199','105 street',1111111133,100,20,'Show Residents','Edit','Delete'),(2,'Building 1','103 street',1111113211,50,10,'Show Residents','Edit','Delete'),(4,'the build','343049 stretet',343049304,23,2,'Show Residents','Edit','Delete'),(5,'the build 2','33049 stretet',3430434,20,1,'Show Residents','Edit','Delete'),(6,'123 built','123 the 123',203483249,33,3,'Show Residents','Edit','Delete'),(8,'hotel','motel',12348392,55,36,'Show Residents','Edit','Delete'),(9,'test building 404','some road out there',68584483,790,600,'Show Residents','Edit','Delete');
/*!40000 ALTER TABLE `Buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Residents`
--

DROP TABLE IF EXISTS `Residents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Residents` (
  `ResidentID` int(11) NOT NULL AUTO_INCREMENT,
  `BuildingID` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(100) NOT NULL,
  `ApartNum` varchar(100) NOT NULL,
  `ResType` varchar(100) NOT NULL,
  `BillingAddress` varchar(100) DEFAULT NULL,
  `EmerContactInfo` varchar(100) NOT NULL,
  `Edit` varchar(10) NOT NULL DEFAULT 'Edit',
  `Del` varchar(10) NOT NULL DEFAULT 'Delete',
  PRIMARY KEY (`ResidentID`),
  KEY `Build_ID` (`BuildingID`),
  CONSTRAINT `Residents_ibfk_1` FOREIGN KEY (`BuildingID`) REFERENCES `Buildings` (`BuildingID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Residents`
--

LOCK TABLES `Residents` WRITE;
/*!40000 ALTER TABLE `Residents` DISABLE KEYS */;
INSERT INTO `Residents` VALUES (1,1,'Sean','Boyle','sb@gmail.com','7327778686','121','Resident','100 Wallabee Way','Bob','Edit','Delete'),(4,1,'hey','hey','hey','hey','1234','hey','hey','hey','Edit','Delete'),(5,2,'Harry','Henderson','hc@gmail.com','7324567868','2387','Resident','123 Charge Here','Harrys Wife','Edit','Delete');
/*!40000 ALTER TABLE `Residents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Edit` varchar(10) NOT NULL DEFAULT 'Edit',
  `Del` varchar(10) NOT NULL DEFAULT 'Delete',
  `UserLevel` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'Matt','Hunt','test@test.com','test','seed','Edit','Delete',1),(2,'johny','smithy','test2@test.com','jsmithy','seedy','Edit','Delete',0),(4,'sean','boyle','sb@gmail.com','seboy','test','Edit','Delete',0);
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-16 14:54:00
