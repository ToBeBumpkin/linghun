/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50715
Source Host           : localhost:3306
Source Database       : soul

Target Server Type    : MYSQL
Target Server Version : 50715
File Encoding         : 65001

Date: 2017-01-17 18:01:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `article` longtext,
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('2', '第一个', '<p>若无缘，三千大千世界，百万菩提众生，为何与我笑颜独展，唯独与我相见；</p><p>若有缘，待到灯花百结之后，三尺之雪，一夜白发，至此无语，却只有灰烬，没有复燃；</p><p><img src=\"/soul/public/static/upload/20161118/1479437694778574.jpg\" title=\"1479437694778574.jpg\" alt=\"13.jpg\"/></p>', null);
INSERT INTO `article` VALUES ('3', 'fdfdsa', '<p>fasfdsafdsafdsfdsa<img src=\"http://img.baidu.com/hi/jx2/j_0026.gif\"/><br/></p>', null);
INSERT INTO `article` VALUES ('4', 'fffffffffffffdas', '<p>gdasasas</p>\n', null);
INSERT INTO `article` VALUES ('5', 'sssssssssssss', '<p>dddddddddddddddddxxxxxxxxxxxxxx</p>\n\n<p><img alt=\"\" src=\"https://gss0.baidu.com/8_BXsjip0QIZ8tyhnq/timg?wh_rate=0&amp;wapiknow&amp;quality=100&amp;size=w250&amp;sec=0&amp;di=ca41db06d23a28609ccf34db83c856fc&amp;src=http%3A%2F%2Fd.hiphotos.baidu.com%2Fzhidao%2Fwh%253D800%252C450%2Fsign%3D907bb1250023dd542126af60e1399fea%2F37d3d539b6003af361ef11213c2ac65c1038b61e.jpg\" style=\"height:140px; width:250px\" /></p>\n\n<h1>fdas</h1>\n', null);

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `content` varchar(255) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES ('1', 'haode', '971708992', 'fdsafds', 'qqqqqqqqqqqqqqqqqq', '2014-01-06 15:19:45', null);
INSERT INTO `comment` VALUES ('3', '11111', '1111111111', '1111111111', '::1', '2017-01-06 17:26:48', null);
INSERT INTO `comment` VALUES ('4', '11111111', '22222222', '223333333333333333333333333', '192.168.1.113', '2017-01-06 17:28:29', null);
INSERT INTO `comment` VALUES ('5', 'fdsaf', 'fdasfdas', 'fdasasasasasasasasasasasasasasasasas', '192.168.1.113', '2017-01-07 11:19:02', null);
INSERT INTO `comment` VALUES ('6', 'ad', 'fdas', 'fdasfdas', '::1', '2017-01-07 11:22:07', null);
INSERT INTO `comment` VALUES ('7', 'ssssssssss', 'ssssssssss', 'ssssssssssss', '127.0.0.1', '2017-01-07 16:08:56', null);
INSERT INTO `comment` VALUES ('8', '111111', '111', '11111111111', '127.0.0.1', '2017-01-07 16:22:25', '中国 西北 新疆维吾尔自治区 克拉玛依市');
INSERT INTO `comment` VALUES ('9', 'ffffffffffff', 'dddddddddddd', 'dffffffffffff', '127.0.0.1', '2017-01-07 16:23:01', '未分配或者内网IP   ');

-- ----------------------------
-- Table structure for imgtext
-- ----------------------------
DROP TABLE IF EXISTS `imgtext`;
CREATE TABLE `imgtext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `imgpath` varchar(255) NOT NULL,
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `update_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of imgtext
-- ----------------------------
INSERT INTO `imgtext` VALUES ('23', 'fds', 'fdasfdsa<img src=\"http://localhost/soul/public/static/admin/plugins/layui/images/face/26.gif\" alt=\"[怒]\">', 'aa6da201612171554389166.jpg', '2016-12-17 15:54:41', null);
INSERT INTO `imgtext` VALUES ('24', 'ceshi', 'fdsafdas', 'db54d201701060951067766.jpg', '2017-01-06 09:51:09', null);
INSERT INTO `imgtext` VALUES ('25', '', '<p>风雨只是一时终究会过去。彩虹总会在前方。</p>', 'b1d73201701061123462412.jpg', '2017-01-06 11:23:58', null);
INSERT INTO `imgtext` VALUES ('26', '', '<p>The Old Road ~ Tree Tunnel - Ballynoe, County Down, Northern Ireland. © Cat-Art ~ Cat Shatwell.:</p>', '7e0e6201701061124293941.jpg', '2017-01-06 11:24:30', null);
INSERT INTO `imgtext` VALUES ('27', '', '<p>喜欢一个人，就是在一起很开心；爱一个人，就是即使不开心，也想在一起。</p>', 'f13bb201701061124544155.jpg', '2017-01-06 11:24:55', null);
INSERT INTO `imgtext` VALUES ('28', '', '<p>世界上只有想不通的人，没有走不通的路。</p>', 'b3603201701061125359192.jpg', '2017-01-06 11:25:36', null);
INSERT INTO `imgtext` VALUES ('29', '', '<p>付出真心，才会得到真心，却可能伤的彻底；保持距离，才能保护自己，却注定永远寂寞。</p>', '874e3201701061126035560.jpg', '2017-01-06 11:26:05', null);
INSERT INTO `imgtext` VALUES ('30', '', '<p>有些话，不说，会变成心事；<br>有些人，不见，却如同影子；<br>有些爱，不提，只有风知情。</p>', '6439b20170106112650219.jpg', '2017-01-06 11:26:52', null);
INSERT INTO `imgtext` VALUES ('31', '', '<p>有些话，不说，会变成心事；<br>有些人，不见，却如同影子；<br>有些爱，不提，只有风知情。</p>', '6439b20170106112650219.jpg', '2017-01-06 11:26:52', null);
INSERT INTO `imgtext` VALUES ('32', '', '<p>风雨只是一时终究会过去。彩虹总会在前方。</p>', 'b1d73201701061123462412.jpg', '2017-01-06 11:23:58', null);
INSERT INTO `imgtext` VALUES ('33', 'xxxx', 'xxxxxxxxx', '417bb201701132010021743.jpg', '2017-01-13 20:10:04', null);

-- ----------------------------
-- Table structure for manager
-- ----------------------------
DROP TABLE IF EXISTS `manager`;
CREATE TABLE `manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of manager
-- ----------------------------
INSERT INTO `manager` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `manager` VALUES ('3', 'cc', '1aabac6d068eef6a7bad3fdf50a05cc8');
INSERT INTO `manager` VALUES ('6', '33', '182be0c5cdcd5072bb1864cdee4d3d6e');
INSERT INTO `manager` VALUES ('7', '22', '633de4b0c14ca52ea2432a3c8a5c4c31');
INSERT INTO `manager` VALUES ('8', 'gg', '73c18c59a39b18382081ec00bb456d43');

-- ----------------------------
-- Table structure for postcard
-- ----------------------------
DROP TABLE IF EXISTS `postcard`;
CREATE TABLE `postcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `descript` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `fountpath` varchar(255) DEFAULT NULL,
  `backpath` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `update_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of postcard
-- ----------------------------
INSERT INTO `postcard` VALUES ('3', 'fdasfffffffffffffff', '<font><font><img src=\"http://localhost/soul/public/static/admin/plugins/layui/images/face/26.gif\" alt=\"[怒]\">fdasfdsa</font></font><img src=\"http://localhost/soul/public/static/admin/plugins/layui/images/face/15.gif\" alt=\"[生病]\">fds', 'a97c0201612201835123245.zip', '6a984201612201835188435.jpg', '2a683201612201835222819.png', '2016-12-20 19:16:19', '2016-12-20 19:16:19');
INSERT INTO `postcard` VALUES ('4', '烦烦烦烦烦烦烦烦烦烦烦烦烦烦烦方法', '<font><font>反反复复烦烦烦烦烦烦烦烦烦烦烦烦烦烦烦</font></font>', '5d21a201612201932119134.ai', 'dda31201612201932177555.png', 'a394c20161220193223256.jpg', '2016-12-20 19:32:25', null);
INSERT INTO `postcard` VALUES ('5', '幅度萨芬仿盛大范德萨', 'f\'d\'sa\'f\'f', 'd887020161220193310787.ai', 'b6b68201612201932452713.jpg', '9692a201612201932529050.png', '2016-12-20 19:33:22', null);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `loginnum` int(11) DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'soul', 'a63ac70eb111e390c59d67e9446f56b4', null, null, null);
INSERT INTO `user` VALUES ('2', 'dddd', '50f84daf3a6dfd6a9f20c9f8ef428942', null, null, null);
INSERT INTO `user` VALUES ('3', 'fff', '343d9040a671c45832ee5381860e2996', null, null, null);
INSERT INTO `user` VALUES ('4', 'qqq', 'b2ca678b4c936f905fb82f2733f5297f', null, null, null);
INSERT INTO `user` VALUES ('5', 'qq', '099b3b060154898840f0ebdfb46ec78f', null, null, null);
INSERT INTO `user` VALUES ('6', 'ww', 'ad57484016654da87125db86f4227ea3', null, null, null);
INSERT INTO `user` VALUES ('8', 'hh', '5e36941b3d856737e81516acd45edc50', null, null, null);
