/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : awugo4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-11-14 17:10:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for suit_price_normal
-- ----------------------------
DROP TABLE IF EXISTS `suit_price_normal`;
CREATE TABLE `suit_price_normal` (
  `nokey` int(11) NOT NULL AUTO_INCREMENT,
  `suit_id` int(11) NOT NULL COMMENT '方案id',
  `merge` int(11) NOT NULL DEFAULT '0' COMMENT '組合碼',
  `people` int(11) DEFAULT '0' COMMENT '人數',
  `weekday` int(11) DEFAULT NULL COMMENT '平日價',
  `friday` int(11) DEFAULT NULL COMMENT '周五價',
  `saturday` int(11) DEFAULT NULL COMMENT '周六價',
  `sunday` int(11) DEFAULT NULL COMMENT '周日價',
  `is_year` int(11) DEFAULT NULL COMMENT '是否全年度',
  `start` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '區間起始日',
  `end` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '區間結束日',
  `creator_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`nokey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
