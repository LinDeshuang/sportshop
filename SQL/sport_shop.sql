/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sport_shop

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-03-07 20:36:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for address
-- ----------------------------
DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `consignee` varchar(20) NOT NULL,
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `address_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of address
-- ----------------------------

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '855ed25e03d8099dcf5f0197191cc7a4');

-- ----------------------------
-- Table structure for cart
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL,
  `good_id` int(8) NOT NULL,
  `num` int(8) NOT NULL,
  `color` varchar(20) NOT NULL,
  `size` varchar(20) NOT NULL,
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cart
-- ----------------------------

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(8) NOT NULL,
  `cate_name` varchar(20) NOT NULL,
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '0', '运动装', '1520410714', '0');
INSERT INTO `category` VALUES ('2', '1', '球衣', '1520410727', '0');
INSERT INTO `category` VALUES ('4', '1', '紧身运动服', '1520410775', '0');
INSERT INTO `category` VALUES ('3', '1', '运动休闲服', '1520410748', '0');
INSERT INTO `category` VALUES ('5', '1', '冲锋衣', '1520410816', '0');
INSERT INTO `category` VALUES ('6', '1', '滑雪必备', '1520410888', '0');
INSERT INTO `category` VALUES ('7', '0', '健身器材', '1520410910', '0');
INSERT INTO `category` VALUES ('8', '7', '哑铃', '1520410936', '0');
INSERT INTO `category` VALUES ('9', '7', '臂力器', '1520410951', '0');
INSERT INTO `category` VALUES ('10', '7', '健身护具', '1520411025', '0');
INSERT INTO `category` VALUES ('11', '7', '瑜伽垫', '1520411140', '0');
INSERT INTO `category` VALUES ('12', '0', '运动鞋', '1520411218', '0');
INSERT INTO `category` VALUES ('13', '12', '足球鞋', '1520411242', '0');
INSERT INTO `category` VALUES ('14', '12', '篮球鞋', '1520411253', '0');
INSERT INTO `category` VALUES ('15', '12', '跑步鞋', '1520411267', '0');
INSERT INTO `category` VALUES ('16', '12', '旱冰鞋', '1520411309', '0');
INSERT INTO `category` VALUES ('17', '12', '网球鞋', '1520411398', '0');
INSERT INTO `category` VALUES ('18', '0', '球类', '1520411442', '0');
INSERT INTO `category` VALUES ('19', '18', '篮球', '1520411459', '0');
INSERT INTO `category` VALUES ('20', '18', '足球', '1520411470', '0');
INSERT INTO `category` VALUES ('21', '18', '乒乓球', '1520411484', '0');
INSERT INTO `category` VALUES ('22', '18', '羽毛球', '1520411515', '0');
INSERT INTO `category` VALUES ('23', '18', '排球', '1520411527', '0');
INSERT INTO `category` VALUES ('24', '18', '网球', '1520411538', '0');
INSERT INTO `category` VALUES ('25', '18', '毽球', '1520411605', '0');
INSERT INTO `category` VALUES ('26', '18', '其他', '1520411623', '0');
INSERT INTO `category` VALUES ('27', '0', '运动用具', '1520411922', '0');
INSERT INTO `category` VALUES ('28', '27', '乒乓球拍', '1520411678', '0');
INSERT INTO `category` VALUES ('29', '27', '羽毛球拍', '1520411700', '0');
INSERT INTO `category` VALUES ('30', '27', '网球拍', '1520411715', '0');
INSERT INTO `category` VALUES ('31', '27', '滑板', '1520411808', '0');
INSERT INTO `category` VALUES ('32', '27', '头盔', '1520412028', '0');
INSERT INTO `category` VALUES ('33', '0', '辅助用品', '1520412063', '0');
INSERT INTO `category` VALUES ('34', '33', '护腕', '1520412078', '0');
INSERT INTO `category` VALUES ('35', '33', '护膝', '1520412090', '0');
INSERT INTO `category` VALUES ('36', '33', '护目镜', '1520412144', '0');
INSERT INTO `category` VALUES ('37', '33', '球网', '1520412163', '0');

-- ----------------------------
-- Table structure for good
-- ----------------------------
DROP TABLE IF EXISTS `good`;
CREATE TABLE `good` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `good_name` varchar(30) NOT NULL COMMENT '商品名称',
  `photo` varchar(255) NOT NULL,
  `price` varchar(12) NOT NULL COMMENT '价格',
  `intro` varchar(255) DEFAULT NULL COMMENT '简介',
  `inventory` int(8) NOT NULL COMMENT '库存',
  `cate_id` varchar(40) NOT NULL COMMENT '所属分类id',
  `color` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '商品状态',
  `sale_count` int(8) NOT NULL DEFAULT '0' COMMENT '销售量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of good
-- ----------------------------
INSERT INTO `good` VALUES ('1', '科比24号湖人球衣', '[\"\\/upload\\/good\\/201803070502\\/201803070502481.jpg\",\"\\/upload\\/good\\/201803070503\\/201803070503826.jpg\",\"\\/upload\\/good\\/201803070503\\/201803070503993.jpg\"]', '299', '科比经典纯棉正品湖人球衣，值得拥有', '500', '运动装-球衣', '[\"\\u7d2b\\u8272\",\"\\u767d\\u8272\"]', '[\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', '1520413387', '0', '1', '0');
INSERT INTO `good` VALUES ('2', '恒大足球衣', '[\"\\/upload\\/good\\/201803070504\\/201803070504337.jpg\",\"\\/upload\\/good\\/201803070504\\/201803070504731.jpg\",\"\\/upload\\/good\\/201803070504\\/201803070504257.jpg\"]', '199', '恒大经典红色球衣，你值得拥有', '600', '运动装-球衣', '[\"\\u7ea2\\u8272\"]', '[\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', '1520413499', '0', '1', '0');
INSERT INTO `good` VALUES ('3', '室内室外篮球鞋', '[\"\\/upload\\/good\\/201803070813\\/201803070813535.jpg\",\"\\/upload\\/good\\/201803070813\\/201803070813962.jpg\",\"\\/upload\\/good\\/201803070813\\/201803070813152.jpg\"]', '256', '三级缓震，舒适内穿，室内室外均可穿着', '1000', '运动鞋-篮球鞋', '[\"\\u9ed1\\u9ec4\"]', '[\"37\",\"38\",\"39\",\"40\",\"41\",\"42\"]', '1520424797', '0', '1', '0');
INSERT INTO `good` VALUES ('4', '实用哑铃', '[\"\\/upload\\/good\\/201803070816\\/201803070816385.jpg\"]', '150', '可调节重量，使用方便', '350', '健身器材-哑铃', '[\"\\u9ed1\\u8272\"]', '[\"15kg\",\"25kg\"]', '1520424981', '0', '1', '0');
INSERT INTO `good` VALUES ('5', '实用臂力器', '[\"\\/upload\\/good\\/201803070818\\/201803070818865.jpg\",\"\\/upload\\/good\\/201803070818\\/201803070818642.jpg\"]', '50', '方便实用，耐用性好的臂力器', '60', '健身器材-臂力器', '[\"\\u9ed1\\u8272\",\"\\u767d\\u8272\"]', '[\"40kg\",\"50kg\",\"60kg\"]', '1520425117', '0', '1', '0');
INSERT INTO `good` VALUES ('6', '品牌高质量羽毛球', '[\"\\/upload\\/good\\/201803070822\\/201803070822357.jpg\",\"\\/upload\\/good\\/201803070822\\/201803070822022.jpg\"]', '50', '质量保证，标准比赛使用的羽毛球', '500', '球类-羽毛球', '[\"\\u767d\\u8272\"]', '[\"\\u5927\\u7b52\"]', '1520425336', '0', '1', '0');
INSERT INTO `good` VALUES ('7', '室内室外耐磨篮球', '[\"\\/upload\\/good\\/201803070826\\/201803070826912.jpg\",\"\\/upload\\/good\\/201803070826\\/201803070826475.jpg\",\"\\/upload\\/good\\/201803070826\\/201803070826208.jpg\"]', '200', '标准比赛用球，弹性好，耐磨。', '500', '球类-篮球', '[\"\\u7ea2\\u8272\",\"\\u7070\\u8272\"]', '[\"\\u6807\\u51c6\",\"\\u8bad\\u7ec3\\u7403\"]', '1520425585', '0', '1', '0');
INSERT INTO `good` VALUES ('8', '轻便防滑瑜伽垫', '[\"\\/upload\\/good\\/201803070827\\/201803070827768.jpg\",\"\\/upload\\/good\\/201803070828\\/201803070828034.jpg\"]', '50', '极其轻便。防滑性好', '400', '健身器材-瑜伽垫', '[\"\\u84dd\\u8272\",\"\\u7c89\\u8272\",\"\\u7d2b\\u8272\",\"\\u9ed1\\u8272\"]', '[\"\\u5927\",\"\\u4e2d\",\"\\u5c0f\"]', '1520425693', '0', '1', '0');
INSERT INTO `good` VALUES ('9', '黑曼巴运动紧身衣', '[\"\\/upload\\/good\\/201803070830\\/201803070830672.jpg\"]', '200', '纯棉吸汗，弹性极好', '400', '运动装-紧身运动服', '[\"\\u9ed1\\u8272\"]', '[\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', '1520425826', '0', '1', '0');
INSERT INTO `good` VALUES ('10', '男女休闲运动装', '[\"\\/upload\\/good\\/201803070832\\/201803070832346.jpg\"]', '200', '舒适轻便，修身款', '300', '运动装-运动休闲服', '[\"\\u7070\\u8272\"]', '[\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', '1520425929', '0', '1', '0');
INSERT INTO `good` VALUES ('11', '紧身运动套装', '[\"\\/upload\\/good\\/201803070834\\/201803070834989.jpg\"]', '300', '纯棉吸汗，弹性极佳', '400', '运动装-紧身运动服', '[\"\\u9ed1\\u8272\"]', '[\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', '1520426047', '0', '1', '0');
INSERT INTO `good` VALUES ('12', '标准乒乓球拍', '[\"\\/upload\\/good\\/201803070835\\/201803070835265.jpg\"]', '50', '比赛标准球拍', '500', '运动用具-乒乓球拍', '[\"\\u7ea2\\u8272\"]', '[\"\\u6807\\u51c6\"]', '1520426118', '0', '1', '0');

-- ----------------------------
-- Table structure for main_order
-- ----------------------------
DROP TABLE IF EXISTS `main_order`;
CREATE TABLE `main_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL,
  `order_num` varchar(20) NOT NULL,
  `consignee` varchar(20) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `address` varchar(100) NOT NULL,
  `express` varchar(10) NOT NULL,
  `worth` varchar(15) NOT NULL,
  `pay_type` varchar(10) NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '订单状态，0为待处理，1为已发货，2为已收货',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_order
-- ----------------------------

-- ----------------------------
-- Table structure for sub_order
-- ----------------------------
DROP TABLE IF EXISTS `sub_order`;
CREATE TABLE `sub_order` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  `good_size` varchar(10) NOT NULL,
  `good_color` varchar(10) NOT NULL,
  `good_num` int(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sub_order
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL COMMENT '账号',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `gender` char(1) NOT NULL DEFAULT '0' COMMENT '性别，1为男，2为女，0为未知',
  `nickname` varchar(30) NOT NULL COMMENT '昵称',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(25) NOT NULL COMMENT '手机号',
  `address` varchar(100) NOT NULL COMMENT '收货地址',
  `create_time` int(11) NOT NULL COMMENT '注册时间',
  `delete_time` int(11) DEFAULT '0',
  `status` char(1) DEFAULT '1' COMMENT '用户状态，1为启用，2为禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
