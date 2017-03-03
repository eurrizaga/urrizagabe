# SQL Manager 2010 for MySQL 4.5.0.9
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : urrizaga


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS `urrizaga`;

CREATE DATABASE `urrizaga`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_spanish2_ci';

USE `urrizaga`;

#
# Structure for the `autorizacion` table : 
#

CREATE TABLE `autorizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_unidad` int(11) DEFAULT NULL,
  `fecha_autorizacion` datetime DEFAULT NULL,
  `fecha_desde` date DEFAULT NULL,
  `fecha_hasta` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `banco` table : 
#

CREATE TABLE `banco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish2_ci,
  `telefono` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `direccion` text COLLATE utf8_spanish2_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `cliente` table : 
#

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apellido` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `tipo_doc` varchar(3) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nro_doc` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `direccion` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `localidad` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cod_postal` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `provincia` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `pais` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `tel_fijo` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `tel_movil` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `fecha_ultima_op` date DEFAULT NULL,
  `observaciones` text COLLATE utf8_spanish2_ci,
  `problematico` tinyint(1) DEFAULT NULL,
  `iva` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `cliente.propietario` table : 
#

CREATE TABLE `cliente.propietario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuit` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `metodo_pago` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cbu` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `banco` int(11) DEFAULT NULL,
  `sucursal` int(11) DEFAULT NULL,
  `mailing` tinyint(1) DEFAULT NULL,
  `carpeta` int(11) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `disponibilidad` table : 
#

CREATE TABLE `disponibilidad` (
  `id_unidad` int(11) NOT NULL,
  `mes` int(11) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `cadena` varchar(32) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `edificio` table : 
#

CREATE TABLE `edificio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `direccion` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `contiene_cochera` tinyint(1) DEFAULT NULL,
  `contiene_depto` tinyint(1) DEFAULT NULL,
  `observaciones` text COLLATE utf8_spanish2_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `operacion` table : 
#

CREATE TABLE `operacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_unidad` int(11) DEFAULT NULL,
  `fecha_op` datetime DEFAULT NULL,
  `observaciones` text COLLATE utf8_spanish2_ci,
  `monto_operacion` float(9,2) DEFAULT NULL,
  `comision` float(9,2) DEFAULT NULL,
  `monto_abonado` float(9,2) DEFAULT NULL,
  `fecha_saldo` date DEFAULT NULL,
  `recargo` float(9,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `operacion.alquiler` table : 
#

CREATE TABLE `operacion.alquiler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_desde` date DEFAULT NULL,
  `fecha_hasta` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `operacion.venta` table : 
#

CREATE TABLE `operacion.venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `unidad` table : 
#

CREATE TABLE `unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_edificio` int(11) DEFAULT NULL,
  `id_propietario` int(11) DEFAULT NULL,
  `hab_venta` tinyint(1) DEFAULT NULL,
  `hab_alquiler` tinyint(1) DEFAULT NULL,
  `codigo` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `carpeta` int(11) DEFAULT NULL,
  `detalles` text COLLATE utf8_spanish2_ci,
  `fecha_ultima_op` date DEFAULT NULL,
  `tipo_unidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `unidad.cochera` table : 
#

CREATE TABLE `unidad.cochera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `dist_ascensor` int(11) DEFAULT NULL,
  `dist_esc_caracol` int(11) DEFAULT NULL,
  `dist_esc_bristol` int(11) DEFAULT NULL,
  `dist_esc_izq` int(11) DEFAULT NULL,
  `dist_esc_der` int(11) DEFAULT NULL,
  `ancho` float(9,2) DEFAULT NULL,
  `largo` float(9,2) DEFAULT NULL,
  `subsuelo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `unidad.departamento` table : 
#

CREATE TABLE `unidad.departamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Structure for the `usuario` table : 
#

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `password` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `per_admin_unid` tinyint(1) DEFAULT NULL,
  `per_alq_coch` tinyint(1) DEFAULT NULL,
  `per_alq_dep` tinyint(1) DEFAULT NULL,
  `per_admin_oper` tinyint(1) DEFAULT NULL,
  `per_logs` tinyint(1) DEFAULT NULL,
  `per_admin_user` tinyint(1) DEFAULT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `apellido` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estado` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `caja` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

#
# Data for the `cliente` table  (LIMIT 0,500)
#

INSERT INTO `cliente` (`id`, `apellido`, `nombre`, `tipo_doc`, `nro_doc`, `direccion`, `localidad`, `cod_postal`, `provincia`, `pais`, `tel_fijo`, `tel_movil`, `email`, `fecha_alta`, `fecha_ultima_op`, `observaciones`, `problematico`, `iva`) VALUES 
  (2,'1','1','DNI','1','1','1','1','1','1','1','1','1','2017-02-27',NULL,'1',NULL,'1'),
  (3,'4','9','DNI','2','2','2','2','2','2','2','2','2','2017-02-27',NULL,'12',NULL,'2'),
  (4,'1','1','DNI','1','1','1','1','1','1','1','1','1','2017-02-27',NULL,'1',NULL,'1'),
  (5,'3','3','DNI','3','3','3','3','3','3','3','3','3','2017-02-27',NULL,'3',NULL,'3'),
  (6,'pepe','coco','DNI','12345','asdasjh','fjdlskj','1234','jdhksj','sad','12344','123123','sadasa@sds.sds','2017-02-28',NULL,'dsfsdfsdf',NULL,'cf'),
  (7,'x','x','DNI','1','6','6','6','6','6','6','6','sadasa@sds.sds','2017-02-28',NULL,'',NULL,'');
COMMIT;

#
# Data for the `cliente.propietario` table  (LIMIT 0,500)
#

INSERT INTO `cliente.propietario` (`id`, `cuit`, `metodo_pago`, `cbu`, `banco`, `sucursal`, `mailing`, `carpeta`, `id_cliente`) VALUES 
  (1,'1','1','1',1,1,1,1,3),
  (2,'1','1','1',1,1,1,1,4),
  (3,'3','3','3',3,3,1,3,5),
  (4,'6','','6',6,6,1,6,7);
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;