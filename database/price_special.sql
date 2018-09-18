/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : awugo4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-09-18 11:47:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for price_special
-- ----------------------------
DROP TABLE IF EXISTS `price_special`;
CREATE TABLE `price_special` (
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of price_special
-- ----------------------------
INSERT INTO `price_special` VALUES ('1', '867', '59', '106', '0102', '0105', '5', '400', 'dd', 'dd', '2018-09-18 10:13:43', '2018-09-18 10:13:46');
INSERT INTO `price_special` VALUES ('2', '867', '59', '106', '0211', '0215', '3', '500', 'dd', 'dd', '2018-09-18 10:14:15', '2018-09-18 10:14:19');
INSERT INTO `price_special` VALUES ('3', '867', '59', '107', '0103', '0104', '5', '1000', 'dd', 'dd', '2018-09-18 10:14:56', '2018-09-18 10:14:58');
INSERT INTO `price_special` VALUES ('4', '867', '59', '107', '0204', '0224', '3', '1200', 'dd', 'dd', '2018-09-18 10:15:33', '2018-09-18 10:15:35');
INSERT INTO `price_special` VALUES ('5', '867', '59', '106', '0102', '0105', '3', '800', 'dd', 'dd', '2018-09-18 11:39:38', '2018-09-18 11:39:43');
