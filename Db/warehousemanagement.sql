﻿# Host: localhost  (Version: 5.5.53)
# Date: 2019-07-12 19:39:45
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "customermapping"
#

DROP TABLE IF EXISTS `customermapping`;
CREATE TABLE `customermapping` (
  `Customer` char(255) NOT NULL,
  `Item` char(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "customermapping"
#

/*!40000 ALTER TABLE `customermapping` DISABLE KEYS */;
INSERT INTO `customermapping` VALUES ('PACE',''),('PACE','');
/*!40000 ALTER TABLE `customermapping` ENABLE KEYS */;

#
# Structure for table "events"
#

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventType` char(255) NOT NULL,
  `FunId` char(255) NOT NULL,
  `Description` char(255) NOT NULL,
  `eTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `uid` char(255) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "events"
#

/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;

#
# Structure for table "fun"
#

DROP TABLE IF EXISTS `fun`;
CREATE TABLE `fun` (
  `Code` char(255) DEFAULT NULL,
  `Name` char(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  UNIQUE KEY `FunID` (`Code`),
  UNIQUE KEY `NameId` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "fun"
#

/*!40000 ALTER TABLE `fun` DISABLE KEYS */;
INSERT INTO `fun` VALUES ('FID_5cff83f8a8e50','用戶查詢',NULL),('FID_5cff83f3cc78b','用戶創建',''),('FID_5cff84009828e','用戶修改',NULL),('FID_5cff834f54be2','儲位刪除','shelfDel'),('FID_5cff8348c6aa5','儲位修改',NULL),('FID_5cff8342a909e','儲位創建','shelfAdd'),('FID_5cff832418531','儲位查詢',NULL),('FID_5cff8405c3b06','用戶刪除',NULL),('FID_5d034aaca2804','貨物入庫',NULL),('FID_5d034ab318e54','貨物出庫',NULL),('FID_5d034abc98b6d','貨物轉移',NULL),('FID_5d034ac30a39c','貨物查詢',NULL);
/*!40000 ALTER TABLE `fun` ENABLE KEYS */;

#
# Structure for table "goods"
#

DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `palletId` char(255) NOT NULL DEFAULT '' COMMENT '棧板號',
  `model` char(1) NOT NULL DEFAULT '' COMMENT '機種',
  `item` char(1) NOT NULL DEFAULT '' COMMENT '料號',
  `so` char(1) NOT NULL DEFAULT '' COMMENT '訂單',
  `qty` char(1) NOT NULL DEFAULT '' COMMENT '數量',
  `customer` char(255) DEFAULT NULL COMMENT '客戶名稱',
  `shelfId` char(255) NOT NULL DEFAULT '' COMMENT '儲位',
  `uidIn` char(255) DEFAULT NULL COMMENT '入庫人',
  `dateIn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '入庫時間',
  `modifyTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '記錄時間',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `palletId` (`palletId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "goods"
#

INSERT INTO `goods` VALUES (1,'W000805714-005','T','9','W','1','','5A0101A','admin','2019-06-20 18:13:18','2019-06-20 18:13:18'),(2,'Z51926201','V','9','W','1','','5A0101A','admin','2019-06-25 09:13:51','2019-06-25 09:13:51');

#
# Structure for table "goods_shipped"
#

DROP TABLE IF EXISTS `goods_shipped`;
CREATE TABLE `goods_shipped` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `palletId` char(255) NOT NULL DEFAULT '' COMMENT '棧板號',
  `model` char(255) NOT NULL DEFAULT '' COMMENT '機種',
  `item` char(255) NOT NULL DEFAULT '' COMMENT '料號',
  `so` char(255) NOT NULL DEFAULT '' COMMENT '訂單',
  `qty` char(255) NOT NULL DEFAULT '' COMMENT '數量',
  `customer` char(255) DEFAULT NULL COMMENT '客戶',
  `uidIn` char(255) NOT NULL DEFAULT '' COMMENT '入庫人',
  `uidOut` char(255) NOT NULL DEFAULT '' COMMENT '出庫人',
  `dateIn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '入庫時間',
  `dateOut` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '出庫時間',
  `modifyTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '記錄時間',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `palletId` (`palletId`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

#
# Data for table "goods_shipped"
#

INSERT INTO `goods_shipped` VALUES (23,'Z21924404','IPC4100','90B3-9A10010','W000802765','360','','admin','admin','2019-06-18 17:07:10','2019-06-18 18:09:29','2019-06-18 18:09:29'),(24,'Z11924402','DCX4400','90B3-A710010','W000804169','400','','admin','admin','2019-06-18 17:07:26','2019-06-18 18:09:29','2019-06-18 18:09:29'),(25,'W000800084-025','TG2482A','90B2AA100010','W000800084','120','','admin','admin','2019-06-18 17:07:40','2019-06-18 18:09:29','2019-06-18 18:09:29'),(28,'W000804970-012','CM8200B','90B2-9410020','W000804970','270','','admin','admin','2019-06-18 17:05:05','2019-06-18 18:09:11','2019-06-18 18:09:11');

#
# Structure for table "rfid"
#

DROP TABLE IF EXISTS `rfid`;
CREATE TABLE `rfid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` char(255) NOT NULL,
  `fid` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

#
# Data for table "rfid"
#

/*!40000 ALTER TABLE `rfid` DISABLE KEYS */;
INSERT INTO `rfid` VALUES (82,'RID_5cff6e1e88eba','FID_5cff8348c6aa5'),(83,'RID_5cff6e1e88eba','FID_5cff834f54be2'),(84,'RID_5cff6e1e88eba','FID_5cff8342a909e'),(85,'RID_5cff6e1e88eba','FID_5cff832418531'),(86,'RID_5cff6e1e88eba','FID_5cff84009828e'),(87,'RID_5cff6e1e88eba','FID_5cff8405c3b06'),(88,'RID_5cff6e1e88eba','FID_5cff83f3cc78b'),(89,'RID_5cff6e1e88eba','FID_5cff83f8a8e50'),(90,'RID_5cff6e1e88eba','FID_5d034aaca2804');
/*!40000 ALTER TABLE `rfid` ENABLE KEYS */;

#
# Structure for table "role"
#

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `Code` char(255) NOT NULL,
  `Name` char(255) NOT NULL,
  UNIQUE KEY `RoleID` (`Code`),
  UNIQUE KEY `NameId` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "role"
#

/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES ('RID_5cff6e1e88eba','管理員'),('RID_5d03e3287e235','測試角色');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

#
# Structure for table "shelfs"
#

DROP TABLE IF EXISTS `shelfs`;
CREATE TABLE `shelfs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ShelfID` char(255) DEFAULT NULL,
  `Description` char(255) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `shelfID` (`ShelfID`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

#
# Data for table "shelfs"
#

/*!40000 ALTER TABLE `shelfs` DISABLE KEYS */;
INSERT INTO `shelfs` VALUES (21,'5A0101G',''),(20,'5A0101F',''),(19,'5A0101E',''),(30,'5A0101A',''),(26,'5A0101C',''),(23,'5A0101H',''),(27,'5A0101D',''),(32,'5A0101I',''),(31,'5A0101B','');
/*!40000 ALTER TABLE `shelfs` ENABLE KEYS */;

#
# Structure for table "urid"
#

DROP TABLE IF EXISTS `urid`;
CREATE TABLE `urid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` char(255) NOT NULL,
  `rid` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

#
# Data for table "urid"
#

/*!40000 ALTER TABLE `urid` DISABLE KEYS */;
INSERT INTO `urid` VALUES (65,'admin','RID_5cff6e1e88eba');
/*!40000 ALTER TABLE `urid` ENABLE KEYS */;

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` char(255) NOT NULL DEFAULT '' COMMENT '賬號',
  `name` char(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `pwd` char(255) NOT NULL DEFAULT '' COMMENT '密碼',
  `mail` char(255) DEFAULT NULL COMMENT '郵件',
  `lastLogin` datetime DEFAULT NULL COMMENT '最後登錄時間',
  `loginTimes` int(11) DEFAULT NULL COMMENT '總登錄次數',
  `loginAddr` char(255) DEFAULT NULL COMMENT '最後登錄地址',
  `enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '啟用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `RowId` (`id`),
  UNIQUE KEY `Uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Data for table "users"
#

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,'admin','管理員','$2y$10$3jnBKJBTtxREXzbNZR1kyu6vflDlVrnFblc7Vw/.58CTH4mm5Wov2',NULL,'2019-07-12 19:12:28',NULL,'127.0.0.1',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;