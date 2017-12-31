/*
SQLyog Community v12.4.1 (64 bit)
MySQL - 5.6.33-0ubuntu0.14.04.1 : Database - autofit
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*Data for the table `endpoint_type` */

insert  into `endpoint_type`(`id`,`name`,`label`) values 
(1,'CdAs400','CD AS400'),
(2,'CdTandem','CD Tandem'),
(3,'CdLinuxUnix','CD Linux/Unix'),
(4,'CdWindowsShare','CD Windows Share'),
(5,'CdWindows','CD Windows'),
(6,'CdZos','CD ZOS'),
(7,'FtgwSelfService','FTGW Self-Service'),
(8,'FtgwWindowsShare','FTGW Windows Share'),
(9,'FtgwWindows','FTGW Windows'),
(10,'FtgwLinuxunix','FTGW Linux/Unix'),
(11,'FtgwProtokollserver','FTGW Protokollserver'),
(12,'FtgwCdLinux/unix','FTGW CD Linux/Unix'),
(13,'FtgwCdWindows','FTGW CD Windows'),
(14,'FtgwCdTandem','FTGW CD Tandem'),
(15,'FtgwCdAs400','FTGW CD AS400'),
(16,'FtgwCdZos','FTGW CD ZOS'),
(17,'FtgwAwsS3','FTGW AWS S3');

/*Data for the table `endpoint_type_server_type` */

insert  into `endpoint_type_server_type`(`server_type_id`,`endpoint_type_id`) values 
(1,1),
(1,15),
(2,6),
(2,16),
(3,2),
(3,14),
(4,5),
(4,9),
(4,13),
(5,3),
(5,10),
(5,12),
(6,3),
(6,10),
(6,12),
(7,4),
(7,8),
(8,17);

/*Data for the table `environment` */

insert  into `environment`(`severity`,`name`,`short_name`) values 
(5,'Entwicklung','E'),
(10,'Test','T'),
(13,'Abnahme','A'),
(16,'Wartung','W'),
(20,'Produktion','P'),
(30,'Schulung','S');

/*Data for the table `product_type` */

insert  into `product_type`(`name`,`long_name`) values 
('cd',NULL),
('fgw',NULL);

/*Data for the table `server_type` */

insert  into `server_type`(`id`,`name`) values 
(1,'as400'),
(5,'linux'),
(2,'mvs'),
(3,'tandem'),
(6,'unix'),
(4,'windows'),
(7,'windowsshare'),
(8,'awss3bucket');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
