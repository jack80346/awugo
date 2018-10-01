/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : awugo4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-10-01 11:05:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for price_suit
-- ----------------------------
DROP TABLE IF EXISTS `price_suit`;
CREATE TABLE `price_suit` (
  `nokey` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `period_year` int(11) NOT NULL DEFAULT '0' COMMENT '年度',
  `period_start` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '區間起始日',
  `period_end` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '區間結束日',
  `people` int(11) NOT NULL DEFAULT '0' COMMENT '人數',
  `price` int(11) DEFAULT '0',
  `creator_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`nokey`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
