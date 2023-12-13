-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: bdm
-- ------------------------------------------------------
-- Server version	8.0.32

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
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito` (
  `ID_Carrito` int NOT NULL AUTO_INCREMENT,
  `ID_Producto_Carrito` int NOT NULL,
  `NombreProduct` varchar(20) NOT NULL,
  `Precio` int NOT NULL,
  `Cant` int NOT NULL,
  PRIMARY KEY (`ID_Carrito`),
  KEY `fk_IdProductoCarrito` (`ID_Producto_Carrito`),
  CONSTRAINT `fk_IdProductoCarrito` FOREIGN KEY (`ID_Producto_Carrito`) REFERENCES `productos` (`ID_Producto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
INSERT INTO `carrito` VALUES (1,8,'Monitor AOC24G1A',3000,1),(2,5,'LogitechG502',1200,1),(3,8,'Monitor AOC24G1A',3000,1),(4,8,'Monitor AOC24G1A',3000,1),(5,5,'LogitechG502',1200,1),(6,8,'Monitor AOC24G1A',3000,1);
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `ID_Categoria` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) NOT NULL,
  `ID_Proveedor` int NOT NULL,
  PRIMARY KEY (`ID_Categoria`),
  KEY `fk_ProveedorCategoria` (`ID_Proveedor`),
  CONSTRAINT `fk_ProveedorCategoria` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'perifericos',1),(2,'pantallas',1),(3,'set-ups',1),(4,'consolasyjuegos',1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factura` (
  `ID_Factura` int NOT NULL AUTO_INCREMENT,
  `ID_OrdenCompra_Factura` int DEFAULT NULL,
  `ID_Product_Factura` int DEFAULT NULL,
  `Precio` float DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `ID_Cliente_Factura` int DEFAULT NULL,
  `MetPago_Factura` int DEFAULT NULL,
  PRIMARY KEY (`ID_Factura`),
  KEY `fk_IdOrdenCompraFactura` (`ID_OrdenCompra_Factura`),
  KEY `fk_IdProductoFactura` (`ID_Product_Factura`),
  KEY `fk_IdMetPagoFactura` (`MetPago_Factura`),
  KEY `fk_IdClienteFactura` (`ID_Cliente_Factura`),
  CONSTRAINT `fk_IdClienteFactura` FOREIGN KEY (`ID_Cliente_Factura`) REFERENCES `user` (`ID_User`),
  CONSTRAINT `fk_IdMetPagoFactura` FOREIGN KEY (`MetPago_Factura`) REFERENCES `metodopago` (`ID_MetPago`),
  CONSTRAINT `fk_IdOrdenCompraFactura` FOREIGN KEY (`ID_OrdenCompra_Factura`) REFERENCES `ord_compra` (`ID_OrdCompra`),
  CONSTRAINT `fk_IdProductoFactura` FOREIGN KEY (`ID_Product_Factura`) REFERENCES `productos` (`ID_Producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenes` (
  `ID_Imagen` int NOT NULL AUTO_INCREMENT,
  `ID_Producto` int NOT NULL,
  `Imagen` blob,
  `video` int DEFAULT NULL,
  PRIMARY KEY (`ID_Imagen`),
  KEY `fk_IdProducto` (`ID_Producto`),
  CONSTRAINT `fk_IdProducto` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
INSERT INTO `imagenes` VALUES (12,5,_binary 'imgs/G5021.jpg',0),(13,5,_binary 'imgs/G5022.jpg',0),(14,5,_binary 'imgs/G5023.jpg',0),(15,5,_binary 'imgs/G502 LIGHTSPEED Wireless Gaming Mouse.mp4',1),(24,8,_binary 'imgs/aoc1.jpg',0),(25,8,_binary 'imgs/aoc2.png',0),(26,8,_binary 'imgs/aoc3.png',0),(27,8,_binary 'imgs/aoc4video.mp4',1);
/*!40000 ALTER TABLE `imagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodopago`
--

DROP TABLE IF EXISTS `metodopago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodopago` (
  `ID_MetPago` int NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_MetPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodopago`
--

LOCK TABLES `metodopago` WRITE;
/*!40000 ALTER TABLE `metodopago` DISABLE KEYS */;
/*!40000 ALTER TABLE `metodopago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oferta`
--

DROP TABLE IF EXISTS `oferta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oferta` (
  `ID_Oferta` int NOT NULL AUTO_INCREMENT,
  `RowDate` date NOT NULL,
  `FechaFin` date NOT NULL,
  `FechaInicio` date NOT NULL,
  `Porcentaje` float DEFAULT NULL,
  `ID_Producto` int NOT NULL,
  PRIMARY KEY (`ID_Oferta`),
  KEY `fk_IdProductoOferta` (`ID_Producto`),
  CONSTRAINT `fk_IdProductoOferta` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oferta`
--

LOCK TABLES `oferta` WRITE;
/*!40000 ALTER TABLE `oferta` DISABLE KEYS */;
/*!40000 ALTER TABLE `oferta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ord_compra`
--

DROP TABLE IF EXISTS `ord_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ord_compra` (
  `ID_OrdCompra` int NOT NULL AUTO_INCREMENT,
  `ID_Producto_OrdCompra` int NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `subtotal` float DEFAULT NULL,
  `cantidadProducto` int DEFAULT NULL,
  `ID_Cliente_OrdCompra` int NOT NULL,
  PRIMARY KEY (`ID_OrdCompra`),
  KEY `fk_IdProductoOrdCompra` (`ID_Producto_OrdCompra`),
  KEY `fk_IdProductoIdUser` (`ID_Cliente_OrdCompra`),
  CONSTRAINT `fk_IdProductoIdUser` FOREIGN KEY (`ID_Cliente_OrdCompra`) REFERENCES `user` (`ID_User`),
  CONSTRAINT `fk_IdProductoOrdCompra` FOREIGN KEY (`ID_Producto_OrdCompra`) REFERENCES `productos` (`ID_Producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ord_compra`
--

LOCK TABLES `ord_compra` WRITE;
/*!40000 ALTER TABLE `ord_compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `ord_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago`
--

DROP TABLE IF EXISTS `pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pago` (
  `ID_Pago` int NOT NULL AUTO_INCREMENT,
  `ID_Factura` int DEFAULT NULL,
  `CantPago` int DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  PRIMARY KEY (`ID_Pago`),
  KEY `fk_IdPagoFactura` (`ID_Factura`),
  CONSTRAINT `fk_IdPagoFactura` FOREIGN KEY (`ID_Factura`) REFERENCES `factura` (`ID_Factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago`
--

LOCK TABLES `pago` WRITE;
/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `ID_Producto` int NOT NULL AUTO_INCREMENT,
  `NombreProduct` varchar(20) NOT NULL,
  `DescripcionProduct` varchar(100) NOT NULL,
  `Precio` int NOT NULL,
  `RowDate` date NOT NULL,
  `CantDisponible` int NOT NULL,
  `Rating` int DEFAULT NULL,
  `RowIdUser` int NOT NULL,
  `ID_Proveedor` int NOT NULL,
  `ID_Categoria` int DEFAULT NULL,
  PRIMARY KEY (`ID_Producto`),
  KEY `fk_RowIdUserProducto` (`RowIdUser`),
  KEY `fk_IdProveedorProducto` (`ID_Proveedor`),
  KEY `fk_IdCategoriaProducto` (`ID_Categoria`),
  CONSTRAINT `fk_IdCategoriaProducto` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID_Categoria`),
  CONSTRAINT `fk_IdProveedorProducto` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`),
  CONSTRAINT `fk_RowIdUserProducto` FOREIGN KEY (`RowIdUser`) REFERENCES `user` (`ID_User`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (5,'LogitechG502','mouse gamer pro',1200,'2023-11-06',10,5,5,1,1),(8,'Monitor AOC24G1A','monitor de 165hz con freesync 1080p',3000,'2023-11-09',10,4,14,1,2);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `ID_Proveedor` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) NOT NULL,
  `ID_Rol` int NOT NULL,
  PRIMARY KEY (`ID_Proveedor`),
  KEY `fk_Rol` (`ID_Rol`),
  CONSTRAINT `fk_Rol` FOREIGN KEY (`ID_Rol`) REFERENCES `roles` (`ID_Rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'corsair',2);
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `ID_Rol` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`ID_Rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'comprador'),(2,'vendedor'),(3,'administrador');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipousuario` (
  `ID_TipoUsuario` int NOT NULL,
  `TipoDeUsuario` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_TipoUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipousuario`
--

LOCK TABLES `tipousuario` WRITE;
/*!40000 ALTER TABLE `tipousuario` DISABLE KEYS */;
INSERT INTO `tipousuario` VALUES (1,'Publico'),(2,'Privado');
/*!40000 ALTER TABLE `tipousuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `ID_User` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) NOT NULL,
  `ApellidoP` varchar(20) NOT NULL,
  `ApellidoM` varchar(20) NOT NULL,
  `NomUsuario` varchar(20) NOT NULL,
  `FechaNacimiento` date NOT NULL,
  `ID_Proveedor` int DEFAULT NULL,
  `ID_Rol` int NOT NULL,
  `correo` varchar(30) NOT NULL,
  `contra` varchar(30) NOT NULL,
  `FechaIngreso` date NOT NULL,
  `imgperfil` longblob,
  `TipeUser` int DEFAULT NULL,
  `activo` int DEFAULT '0',
  PRIMARY KEY (`ID_User`),
  KEY `fk_RolUser` (`ID_Rol`),
  KEY `fk_Proveedor` (`ID_Proveedor`),
  KEY `fk_TipoUsuario` (`TipeUser`),
  CONSTRAINT `fk_Proveedor` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`),
  CONSTRAINT `fk_RolUser` FOREIGN KEY (`ID_Rol`) REFERENCES `roles` (`ID_Rol`),
  CONSTRAINT `fk_TipoUsuario` FOREIGN KEY (`TipeUser`) REFERENCES `tipousuario` (`ID_TipoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (5,'oscar','rodriguez','saldivar','hosky','2003-02-03',1,1,'oscar@gmail.com','12345678','2023-09-21',_binary 'xenojiva.jpg',1,1),(14,'aylin','martinez','rodriguez','panda','1993-07-07',1,2,'aylin@gmail.com','12345678aA1!','2023-10-18',_binary 'rathalos.png',1,0),(15,'edgar','rodriguez','saldivar','rector','1990-07-12',1,3,'edgar@gmail.com','12345678aA1!','2023-10-18',_binary 'talon.jpg',1,0),(16,'naomi','martinez','rodriguez','naghomi','1996-06-13',1,2,'naomi@gmail.com','12345678aA1!','2023-10-19',_binary 'garnet.jpeg',2,0),(18,'arturo','rodriguez','saldivar','max','2012-06-07',1,2,'arturo@gmail.com','12345678aA1!','2023-10-19',_binary 'Diablosnegra.jpg',1,0),(19,'poncho','isarel','perez','poncho','2023-11-06',1,1,'poncho@gmail.com','12345678aA!','2023-11-14',_binary 'FjypmIWWAAEPuis.jfif',1,0),(20,'anette','padilla','moreno','aneki_i','2001-05-21',1,1,'anettepm60@gmail.com','12345678aA!','2023-11-14',_binary '1211477.jpg',2,0);
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

-- Dump completed on 2023-11-17  3:14:11
