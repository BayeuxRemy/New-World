-- MySQL dump 10.13  Distrib 5.5.58, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: newWorld
-- ------------------------------------------------------
-- Server version	5.5.58-0+deb8u1

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
-- Table structure for table `AssemblageCmd`
--

DROP TABLE IF EXISTS `AssemblageCmd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AssemblageCmd` (
  `qtyProduit` float DEFAULT NULL,
  `idLot` int(11) NOT NULL,
  `idCommande` int(11) NOT NULL,
  PRIMARY KEY (`idLot`,`idCommande`),
  KEY `idCommande` (`idCommande`),
  CONSTRAINT `AssemblageCmd_ibfk_1` FOREIGN KEY (`idLot`) REFERENCES `Lots` (`idLot`),
  CONSTRAINT `AssemblageCmd_ibfk_2` FOREIGN KEY (`idCommande`) REFERENCES `Commandes` (`idCommande`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AssemblageCmd`
--

LOCK TABLES `AssemblageCmd` WRITE;
/*!40000 ALTER TABLE `AssemblageCmd` DISABLE KEYS */;
/*!40000 ALTER TABLE `AssemblageCmd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Commandes`
--

DROP TABLE IF EXISTS `Commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Commandes` (
  `idCommande` int(11) NOT NULL DEFAULT '0',
  `dateHeureLivraison` datetime DEFAULT NULL,
  `prixCommande` float DEFAULT NULL,
  `idConsom` int(11) NOT NULL,
  `idDistrib` int(11) NOT NULL,
  PRIMARY KEY (`idCommande`),
  KEY `idConsom` (`idConsom`),
  KEY `idDistrib` (`idDistrib`),
  CONSTRAINT `Commandes_ibfk_1` FOREIGN KEY (`idConsom`) REFERENCES `Consommateurs` (`idConsom`),
  CONSTRAINT `Commandes_ibfk_2` FOREIGN KEY (`idDistrib`) REFERENCES `Distributeurs` (`idDistrib`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Commandes`
--

LOCK TABLES `Commandes` WRITE;
/*!40000 ALTER TABLE `Commandes` DISABLE KEYS */;
/*!40000 ALTER TABLE `Commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Consommateurs`
--

DROP TABLE IF EXISTS `Consommateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Consommateurs` (
  `idConsom` int(11) NOT NULL DEFAULT '0',
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idConsom`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `Consommateurs_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Consommateurs`
--

LOCK TABLES `Consommateurs` WRITE;
/*!40000 ALTER TABLE `Consommateurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `Consommateurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Contact`
--

DROP TABLE IF EXISTS `Contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contact` (
  `idContact` int(11) NOT NULL DEFAULT '0',
  `nom` varchar(25) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `sujet` varchar(25) DEFAULT NULL,
  `message` varchar(250) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `ip` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idContact`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Contact`
--

LOCK TABLES `Contact` WRITE;
/*!40000 ALTER TABLE `Contact` DISABLE KEYS */;
INSERT INTO `Contact` VALUES (0,'Test','test@mail.fr','Test d\'envoie','Si le message et bien reçu et bien enregistrer dans la base, tout est OK.','2017-10-20 11:49:26','127.0.0.1');
/*!40000 ALTER TABLE `Contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Controle`
--

DROP TABLE IF EXISTS `Controle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Controle` (
  `idControle` int(11) NOT NULL DEFAULT '0',
  `dateControle` date DEFAULT NULL,
  `descriptionControle` varchar(250) DEFAULT NULL,
  `valideControle` tinyint(1) DEFAULT NULL,
  `idVisiteur` int(11) NOT NULL,
  `idProducteur` int(11) NOT NULL,
  PRIMARY KEY (`idControle`),
  KEY `idVisiteur` (`idVisiteur`),
  KEY `idProducteur` (`idProducteur`),
  CONSTRAINT `Controle_ibfk_1` FOREIGN KEY (`idVisiteur`) REFERENCES `Visiteurs` (`idVisiteur`),
  CONSTRAINT `Controle_ibfk_2` FOREIGN KEY (`idProducteur`) REFERENCES `Producteurs` (`idProducteur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Controle`
--

LOCK TABLES `Controle` WRITE;
/*!40000 ALTER TABLE `Controle` DISABLE KEYS */;
/*!40000 ALTER TABLE `Controle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Distributeurs`
--

DROP TABLE IF EXISTS `Distributeurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Distributeurs` (
  `idDistrib` int(11) NOT NULL DEFAULT '0',
  `libelleDistrib` varchar(25) DEFAULT NULL,
  `activiteDistrib` varchar(25) DEFAULT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idDistrib`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `Distributeurs_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Distributeurs`
--

LOCK TABLES `Distributeurs` WRITE;
/*!40000 ALTER TABLE `Distributeurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `Distributeurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Employe`
--

DROP TABLE IF EXISTS `Employe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Employe` (
  `idEmploye` int(11) DEFAULT NULL,
  `identifiant` varchar(25) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Employe`
--

LOCK TABLES `Employe` WRITE;
/*!40000 ALTER TABLE `Employe` DISABLE KEYS */;
INSERT INTO `Employe` VALUES (0,'test','ini01','Leponge','Bob');
/*!40000 ALTER TABLE `Employe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Horraires`
--

DROP TABLE IF EXISTS `Horraires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Horraires` (
  `idHorraires` int(11) NOT NULL DEFAULT '0',
  `jour` date DEFAULT NULL,
  `heureOuvertureMatin` time DEFAULT NULL,
  `heureFermetureMatin` time DEFAULT NULL,
  `heureOuverteAprem` time DEFAULT NULL,
  `heureFermetureAprem` time DEFAULT NULL,
  `idDistrib` int(11) NOT NULL,
  PRIMARY KEY (`idHorraires`),
  KEY `idDistrib` (`idDistrib`),
  CONSTRAINT `Horraires_ibfk_1` FOREIGN KEY (`idDistrib`) REFERENCES `Distributeurs` (`idDistrib`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Horraires`
--

LOCK TABLES `Horraires` WRITE;
/*!40000 ALTER TABLE `Horraires` DISABLE KEYS */;
/*!40000 ALTER TABLE `Horraires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lots`
--

DROP TABLE IF EXISTS `Lots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Lots` (
  `idLot` int(11) NOT NULL DEFAULT '0',
  `qtyLot` float DEFAULT NULL,
  `prixU` float DEFAULT NULL,
  `dateRecolte` date DEFAULT NULL,
  `dateLmite` date DEFAULT NULL,
  `idParcelle` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `idVariete` int(11) NOT NULL,
  `idUnite` int(11) NOT NULL,
  PRIMARY KEY (`idLot`),
  KEY `idParcelle` (`idParcelle`),
  KEY `idProduit` (`idProduit`),
  KEY `idVariete` (`idVariete`),
  KEY `idUnite` (`idUnite`),
  CONSTRAINT `Lots_ibfk_1` FOREIGN KEY (`idParcelle`) REFERENCES `Parcelles` (`idParcelle`),
  CONSTRAINT `Lots_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `Produits` (`idProduit`),
  CONSTRAINT `Lots_ibfk_3` FOREIGN KEY (`idVariete`) REFERENCES `Varietes` (`idVariete`),
  CONSTRAINT `Lots_ibfk_4` FOREIGN KEY (`idUnite`) REFERENCES `Unite` (`idUnite`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lots`
--

LOCK TABLES `Lots` WRITE;
/*!40000 ALTER TABLE `Lots` DISABLE KEYS */;
INSERT INTO `Lots` VALUES (1,10,5.5,'2018-03-10','2018-05-15',1,1,1,1);
/*!40000 ALTER TABLE `Lots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Parcelles`
--

DROP TABLE IF EXISTS `Parcelles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Parcelles` (
  `idParcelle` int(11) NOT NULL DEFAULT '0',
  `libelleParcelle` varchar(25) DEFAULT NULL,
  `cpParcelle` int(11) DEFAULT NULL,
  `ModeProdParcelle` varchar(25) DEFAULT NULL,
  `imgParcelle` varchar(250) DEFAULT NULL,
  `idProducteur` int(11) NOT NULL,
  `idVille` int(11) NOT NULL,
  PRIMARY KEY (`idParcelle`),
  KEY `idProducteur` (`idProducteur`),
  KEY `idVille` (`idVille`),
  CONSTRAINT `Parcelles_ibfk_1` FOREIGN KEY (`idProducteur`) REFERENCES `Producteurs` (`idProducteur`),
  CONSTRAINT `Parcelles_ibfk_2` FOREIGN KEY (`idVille`) REFERENCES `Villes` (`idVille`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Parcelles`
--

LOCK TABLES `Parcelles` WRITE;
/*!40000 ALTER TABLE `Parcelles` DISABLE KEYS */;
INSERT INTO `Parcelles` VALUES (1,'Parcelle Test N°1',05000,'Biologique','',1,1),(2,'Parcelle Test N°2',05000,'Biologique','',1,1);
/*!40000 ALTER TABLE `Parcelles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Producteurs`
--

DROP TABLE IF EXISTS `Producteurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Producteurs` (
  `idProducteur` int(11) NOT NULL DEFAULT '0',
  `libelleProducteur` varchar(25) DEFAULT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idProducteur`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `Producteurs_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Producteurs`
--

LOCK TABLES `Producteurs` WRITE;
/*!40000 ALTER TABLE `Producteurs` DISABLE KEYS */;
INSERT INTO `Producteurs` VALUES (1,'TestProducteur',1);
/*!40000 ALTER TABLE `Producteurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Produits`
--

DROP TABLE IF EXISTS `Produits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Produits` (
  `idProduit` int(11) NOT NULL DEFAULT '0',
  `nomProduit` varchar(25) DEFAULT NULL,
  `idRayons` int(10) DEFAULT NULL,
  `imgProduit` varchar(250) DEFAULT NULL,
  `validProduit` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idProduit`),
  KEY `Produits_fk_1` (`idRayons`),
  CONSTRAINT `Produits_fk_1` FOREIGN KEY (`idRayons`) REFERENCES `Rayons` (`idRayon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Produits`
--

LOCK TABLES `Produits` WRITE;
/*!40000 ALTER TABLE `Produits` DISABLE KEYS */;
INSERT INTO `Produits` VALUES (1,'Tomate',0,'',0),(2,'Carotte',0,'',0),(3,'Courgette',0,'',0),(101,'Pêche',0,'',1),(102,'Kaki',0,'',0),(103,'Poire',0,'',1),(201,'Steack',1,'',0),(202,'Poulet ',1,'',1),(301,'Saumon',3,'',1),(302,'Thon',3,'',0),(401,'Lait',4,'',0),(501,'Haricot',0,'',0),(502,'Fromage',4,'',1),(503,'Tofu',5,'',1),(504,'Quinoa',5,'',1),(505,'Pain',2,'',1);
/*!40000 ALTER TABLE `Produits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `QuestionsSecretes`
--

DROP TABLE IF EXISTS `QuestionsSecretes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `QuestionsSecretes` (
  `idQuestion` int(11) NOT NULL DEFAULT '0',
  `question` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idQuestion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `QuestionsSecretes`
--

LOCK TABLES `QuestionsSecretes` WRITE;
/*!40000 ALTER TABLE `QuestionsSecretes` DISABLE KEYS */;
/*!40000 ALTER TABLE `QuestionsSecretes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rayons`
--

DROP TABLE IF EXISTS `Rayons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rayons` (
  `idRayon` int(11) NOT NULL DEFAULT '0',
  `libelleRayon` varchar(25) DEFAULT NULL,
  `descRayon` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idRayon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Rayons`
--

LOCK TABLES `Rayons` WRITE;
/*!40000 ALTER TABLE `Rayons` DISABLE KEYS */;
INSERT INTO `Rayons` VALUES (0,'Fruits & Légumes','Contient tous les fruits et légumes'),(1,'Boucherie','Contient tous types de viandes animales venant de nos éleveurs'),(2,'Boulangerie','Contient tous les pains et patisseries'),(3,'Poissons & Crustacés','Contient tous les produits de nos pêcheurs'),(4,'Produits laitiers','Lait,yaourt,formage et ses derivés'),(5,'Bio','Contient tous les produit issue de l\'agriculture biologique');
/*!40000 ALTER TABLE `Rayons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ReponsesSecretes`
--

DROP TABLE IF EXISTS `ReponsesSecretes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ReponsesSecretes` (
  `reponse` varchar(25) DEFAULT NULL,
  `idUser` int(11) NOT NULL,
  `idQuestion` int(11) NOT NULL,
  PRIMARY KEY (`idUser`,`idQuestion`),
  KEY `idQuestion` (`idQuestion`),
  CONSTRAINT `ReponsesSecretes_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`),
  CONSTRAINT `ReponsesSecretes_ibfk_2` FOREIGN KEY (`idQuestion`) REFERENCES `QuestionsSecretes` (`idQuestion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ReponsesSecretes`
--

LOCK TABLES `ReponsesSecretes` WRITE;
/*!40000 ALTER TABLE `ReponsesSecretes` DISABLE KEYS */;
/*!40000 ALTER TABLE `ReponsesSecretes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Unite`
--

DROP TABLE IF EXISTS `Unite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Unite` (
  `idUnite` int(11) NOT NULL DEFAULT '0',
  `labelUnite` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idUnite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Unite`
--

LOCK TABLES `Unite` WRITE;
/*!40000 ALTER TABLE `Unite` DISABLE KEYS */;
INSERT INTO `Unite` VALUES (0,'Kg'),(1,'Litre'),(2,'Unité'),(3,'Barquette'),(4,'Cagette'),(5,'Sachet');
/*!40000 ALTER TABLE `Unite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `idUser` int(11) NOT NULL DEFAULT '0',
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `dateInscription` date DEFAULT NULL,
  `typeUser` varchar(25) DEFAULT NULL,
  `adresseIp` varchar(25) DEFAULT NULL,
  `tentativeCo` int(11) DEFAULT NULL,
  `nom` varchar(25) DEFAULT NULL,
  `prenom` varchar(25) DEFAULT NULL,
  `tel` int(11) DEFAULT NULL,
  `imgProfil` varchar(250) DEFAULT NULL,
  `descriptionProfil` varchar(250) DEFAULT NULL,
  `valideCompte` tinyint(1) DEFAULT NULL,
  `rue` varchar(250) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `ville` varchar(25) NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'test','ini01','test@mail.fr','2017-10-06','Admin','172.29.56.2',NULL,'test','test',600,NULL,'test',NULL,'','','',0,0);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Varietes`
--

DROP TABLE IF EXISTS `Varietes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Varietes` (
  `idVariete` int(11) NOT NULL DEFAULT '0',
  `libelleVariete` varchar(25) DEFAULT NULL,
  `descriptionPdt` varchar(250) DEFAULT NULL,
  `imgPdt` varchar(250) DEFAULT NULL,
  `idProduit` int(11) NOT NULL,
  `validPdt` tinyint(1) DEFAULT NULL,
  `dureeConserv` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVariete`),
  KEY `idProduit` (`idProduit`),
  CONSTRAINT `Varietes_ibfk_1` FOREIGN KEY (`idProduit`) REFERENCES `Produits` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Varietes`
--

LOCK TABLES `Varietes` WRITE;
/*!40000 ALTER TABLE `Varietes` DISABLE KEYS */;
INSERT INTO `Varietes` VALUES (1,'Ananas','Gros fruit charnu, allant du rouge au jaune. Très parfumé et légèrement acidulé. Parfait pour les salades','',1,0,NULL),(2,'Cerise','Fruit petit, un peu allongé, rouge brillant. Très bonne qualité gustative, peau fine. Parfait pour l\'apéritif','',1,0,NULL),(3,'Touchon','Variété demi-longue (15-17 cm), de couleur orange rougeâtre brillant et sans coeur. Tendres, croquantes, juteuses et sucrées.','',2,0,NULL),(4,'Nantaise','Variété très connue et apprécié par les cultivateurs. Lisse et brillante de couleur orange rouge, avec un coeur mince de la même couleur.','',2,1,NULL),(5,'Black Beauty','Variété très productive, rustique, fruits vert foncé.','',3,0,NULL),(6,'Complet','Pains au 5 céréals très nutritif, parfait pour les petits déjeuner','',505,1,NULL);
/*!40000 ALTER TABLE `Varietes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Villes`
--

DROP TABLE IF EXISTS `Villes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Villes` (
  `idVille` int(11) NOT NULL DEFAULT '0',
  `nomVille` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idVille`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Villes`
--

LOCK TABLES `Villes` WRITE;
/*!40000 ALTER TABLE `Villes` DISABLE KEYS */;
INSERT INTO `Villes` VALUES (1,'Gap');
/*!40000 ALTER TABLE `Villes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Visiteurs`
--

DROP TABLE IF EXISTS `Visiteurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Visiteurs` (
  `idVisiteur` int(11) NOT NULL DEFAULT '0',
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idVisiteur`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `Visiteurs_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Visiteurs`
--

LOCK TABLES `Visiteurs` WRITE;
/*!40000 ALTER TABLE `Visiteurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `Visiteurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contenuParcelle`
--

DROP TABLE IF EXISTS `contenuParcelle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contenuParcelle` (
  `idVariete` int(11) NOT NULL,
  `idParcelle` int(11) NOT NULL,
  PRIMARY KEY (`idVariete`,`idParcelle`),
  KEY `idParcelle` (`idParcelle`),
  CONSTRAINT `contenuParcelle_ibfk_1` FOREIGN KEY (`idVariete`) REFERENCES `Varietes` (`idVariete`),
  CONSTRAINT `contenuParcelle_ibfk_2` FOREIGN KEY (`idParcelle`) REFERENCES `Parcelles` (`idParcelle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contenuParcelle`
--

LOCK TABLES `contenuParcelle` WRITE;
/*!40000 ALTER TABLE `contenuParcelle` DISABLE KEYS */;
/*!40000 ALTER TABLE `contenuParcelle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-15 11:56:54
