/*
Navicat MySQL Data Transfer

Source Server         : mycentos
Source Server Version : 50717
Source Host           : 120.78.186.249:3307
Source Database       : tp-renren

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2019-12-03 20:20:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sys_captcha
-- ----------------------------
DROP TABLE IF EXISTS `sys_captcha`;
CREATE TABLE `sys_captcha` (
  `uuid` char(36) NOT NULL COMMENT 'uuid',
  `code` varchar(6) NOT NULL COMMENT '验证码',
  `expire_time` datetime DEFAULT NULL COMMENT '过期时间',
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统验证码';

-- ----------------------------
-- Records of sys_captcha
-- ----------------------------

-- ----------------------------
-- Table structure for sys_config
-- ----------------------------
DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE `sys_config` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `param_key` varchar(50) DEFAULT NULL COMMENT 'key',
  `param_value` varchar(2000) DEFAULT NULL COMMENT 'value',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态   0：隐藏   1：显示',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `param_key` (`param_key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='系统配置信息表';

-- ----------------------------
-- Records of sys_config
-- ----------------------------
INSERT INTO `sys_config` VALUES ('1', 'CLOUD_STORAGE_CONFIG_KEY', '{\"aliyunAccessKeyId\":\"\",\"aliyunAccessKeySecret\":\"\",\"aliyunBucketName\":\"\",\"aliyunDomain\":\"\",\"aliyunEndPoint\":\"\",\"aliyunPrefix\":\"\",\"qcloudBucketName\":\"\",\"qcloudDomain\":\"\",\"qcloudPrefix\":\"\",\"qcloudSecretId\":\"\",\"qcloudSecretKey\":\"\",\"qiniuAccessKey\":\"NrgMfABZxWLo5B-YYSjoE8-AZ1EISdi1Z3ubLOeZ\",\"qiniuBucketName\":\"ios-app\",\"qiniuDomain\":\"http://7xqbwh.dl1.z0.glb.clouddn.com\",\"qiniuPrefix\":\"upload\",\"qiniuSecretKey\":\"uIwJHevMRWU0VLxFvgy0tAcOdGqasdtVlJkdy6vV\",\"type\":1}', '0', '云存储配置信息');

-- ----------------------------
-- Table structure for sys_log
-- ----------------------------
DROP TABLE IF EXISTS `sys_log`;
CREATE TABLE `sys_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL COMMENT '用户名',
  `operation` varchar(50) DEFAULT NULL COMMENT '用户操作',
  `method` varchar(200) DEFAULT NULL COMMENT '请求方法',
  `params` varchar(5000) DEFAULT NULL COMMENT '请求参数',
  `time` bigint(20) NOT NULL COMMENT '执行时长(毫秒)',
  `ip` varchar(64) DEFAULT NULL COMMENT 'IP地址',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统日志';

-- ----------------------------
-- Records of sys_log
-- ----------------------------

-- ----------------------------
-- Table structure for sys_menu
-- ----------------------------
DROP TABLE IF EXISTS `sys_menu`;
CREATE TABLE `sys_menu` (
  `menu_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) DEFAULT NULL COMMENT '父菜单ID，一级菜单为0',
  `name` varchar(50) DEFAULT NULL COMMENT '菜单名称',
  `url` varchar(200) DEFAULT NULL COMMENT '菜单URL',
  `perms` varchar(500) DEFAULT NULL COMMENT '授权(多个用逗号分隔，如：user:list,user:create)',
  `type` int(11) DEFAULT NULL COMMENT '类型   0：目录   1：菜单   2：按钮',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `order_num` int(11) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COMMENT='菜单管理';

-- ----------------------------
-- Records of sys_menu
-- ----------------------------
INSERT INTO `sys_menu` VALUES ('1', '0', '系统管理', 'sys', null, '0', 'system', '0');
INSERT INTO `sys_menu` VALUES ('2', '1', '管理员列表', 'sys/user', null, '1', 'admin', '1');
INSERT INTO `sys_menu` VALUES ('3', '1', '角色管理', 'sys/role', null, '1', 'role', '2');
INSERT INTO `sys_menu` VALUES ('4', '1', '菜单管理', 'sys/menu', null, '1', 'menu', '3');
INSERT INTO `sys_menu` VALUES ('5', '1', 'SQL监控', 'http://localhost:8080/renren-fast/druid/sql.html', null, '1', 'sql', '4');
INSERT INTO `sys_menu` VALUES ('6', '1', '定时任务', 'job/schedule', null, '1', 'job', '5');
INSERT INTO `sys_menu` VALUES ('7', '6', '查看', null, 'sys:schedule:list,sys:schedule:info', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('8', '6', '新增', null, 'sys:schedule:save', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('9', '6', '修改', null, 'sys:schedule:update', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('10', '6', '删除', null, 'sys:schedule:delete', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('11', '6', '暂停', null, 'sys:schedule:pause', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('12', '6', '恢复', null, 'sys:schedule:resume', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('13', '6', '立即执行', null, 'sys:schedule:run', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('14', '6', '日志列表', null, 'sys:schedule:log', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('15', '2', '查看', 'test', 'sys:user:list,sys:user:info', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('16', '2', '新增', '2', 'sys:user:save,sys:role:select', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('17', '2', '修改', null, 'sys:user:update,sys:role:select', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('18', '2', '删除', null, 'sys:user:delete', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('19', '3', '查看', null, 'sys:role:list,sys:role:info', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('20', '3', '新增', null, 'sys:role:save,sys:menu:list', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('21', '3', '修改', null, 'sys:role:update,sys:menu:list', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('22', '3', '删除', null, 'sys:role:delete', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('23', '4', '查看', null, 'sys:menu:list,sys:menu:info', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('24', '4', '新增', null, 'sys:menu:save,sys:menu:select', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('25', '4', '修改', null, 'sys:menu:update,sys:menu:select', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('26', '4', '删除', null, 'sys:menu:delete', '2', null, '0');
INSERT INTO `sys_menu` VALUES ('27', '1', '参数管理', 'sys/config', 'sys:config:list,sys:config:info,sys:config:save,sys:config:update,sys:config:delete', '1', 'config', '6');
INSERT INTO `sys_menu` VALUES ('29', '1', '系统日志', 'sys/log', 'sys:log:list', '1', 'log', '7');
INSERT INTO `sys_menu` VALUES ('30', '1', '文件上传', 'oss/oss', 'sys:oss:all', '1', 'oss', '6');
INSERT INTO `sys_menu` VALUES ('32', '1', 'testt', '123123', '21321', '1', 'dangdifill', '0');

-- ----------------------------
-- Table structure for sys_oss
-- ----------------------------
DROP TABLE IF EXISTS `sys_oss`;
CREATE TABLE `sys_oss` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) DEFAULT NULL COMMENT 'URL地址',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文件上传';

-- ----------------------------
-- Records of sys_oss
-- ----------------------------

-- ----------------------------
-- Table structure for sys_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_role`;
CREATE TABLE `sys_role` (
  `role_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) DEFAULT NULL COMMENT '角色名称',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  `create_user_id` bigint(20) DEFAULT NULL COMMENT '创建者ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='角色';

-- ----------------------------
-- Records of sys_role
-- ----------------------------
INSERT INTO `sys_role` VALUES ('1', '超级管理员', '', null, null);
INSERT INTO `sys_role` VALUES ('10', 'test', '1111', '1', null);

-- ----------------------------
-- Table structure for sys_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `sys_role_menu`;
CREATE TABLE `sys_role_menu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) DEFAULT NULL COMMENT '角色ID',
  `menu_id` bigint(20) DEFAULT NULL COMMENT '菜单ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COMMENT='角色与菜单对应关系';

-- ----------------------------
-- Records of sys_role_menu
-- ----------------------------
INSERT INTO `sys_role_menu` VALUES ('52', '1', '2');
INSERT INTO `sys_role_menu` VALUES ('53', '1', '15');
INSERT INTO `sys_role_menu` VALUES ('54', '1', '16');
INSERT INTO `sys_role_menu` VALUES ('55', '1', '17');
INSERT INTO `sys_role_menu` VALUES ('56', '1', '18');
INSERT INTO `sys_role_menu` VALUES ('57', '1', '3');
INSERT INTO `sys_role_menu` VALUES ('58', '1', '1');
INSERT INTO `sys_role_menu` VALUES ('59', '1', '4');
INSERT INTO `sys_role_menu` VALUES ('60', '1', '19');
INSERT INTO `sys_role_menu` VALUES ('61', '1', '20');
INSERT INTO `sys_role_menu` VALUES ('62', '1', '21');
INSERT INTO `sys_role_menu` VALUES ('63', '1', '22');
INSERT INTO `sys_role_menu` VALUES ('64', '1', '23');
INSERT INTO `sys_role_menu` VALUES ('65', '1', '24');
INSERT INTO `sys_role_menu` VALUES ('66', '1', '25');
INSERT INTO `sys_role_menu` VALUES ('67', '1', '26');
INSERT INTO `sys_role_menu` VALUES ('76', '10', '1');
INSERT INTO `sys_role_menu` VALUES ('77', '10', '2');
INSERT INTO `sys_role_menu` VALUES ('78', '10', '3');

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(100) DEFAULT NULL COMMENT '密码',
  `salt` varchar(20) DEFAULT NULL COMMENT '盐',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(100) DEFAULT NULL COMMENT '手机号',
  `status` varchar(32) DEFAULT NULL COMMENT '状态  disable：禁用   enable：正常',
  `create_user_id` bigint(20) DEFAULT NULL COMMENT '创建者ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `nickname` varchar(64) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COMMENT='系统用户';

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES ('1', 'admin', '63ee451939ed580ef3c4b6f0109d1fd0', 'YzcmCZNvbXocrsz9dm8e', 'root@renren.io', '13612345678', '1', '1', '2016-11-11 11:11:11', '123123', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('4', 'user', '63ee451939ed580ef3c4b6f0109d1fd0', 'YzcmCZNvbXocrsz9dm8e', 'root@renren.io', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('5', 'user1', 'f8f600b9b789630b2fd133078675c036', 'X5rddoEQlz5NHKewwQop', 'root@renren.io', '13612345678', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('6', 'user2', '6a1ed1e8037ef335045a3b01c2647f8e', 'OhwVeaZSF9hjS3wwKJPi', 'root@renren.io', '13612345678', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('7', 'user3', '63ee451939ed580ef3c4b6f0109d1fd0', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('8', 'user4', '63ee451939ed580ef3c4b6f0109d1fd0', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('9', 'user5', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('10', 'user6', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('13', 'user9', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('14', 'user10', '58d4d0c35a16d9d95eb40212397b041c', 'dBgBfmKL48K3xXoAxUHx', '498657135@qq.com', '13612345678', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('15', 'user11', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('16', 'user12', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('17', 'user13', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('18', 'user14', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('19', 'user15', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('20', 'user16', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('21', 'user17', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('22', 'user18', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('23', 'user19', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('24', 'user20', 'b92220f734426868515d7f76a5e0fdc2', 'YzcmCZNvbXocrsz9dm8e', '', '136123456787', '1', '1', '2019-10-25 10:10:01', 'hahaha', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif');
INSERT INTO `sys_user` VALUES ('25', '66666', '30206f755d76b229a0ccdcac14da22e7', '12wMcV84zVN4UdOmTIOi', '498657135@qq.com', '13828748467', '1', '1', '2019-11-05 14:26:41', null, null);
INSERT INTO `sys_user` VALUES ('26', '88888', 'bac91d9051bc7e3d62d6fdf34be33fbc', 'tQCJIVjHs0cJFHwoJohq', '498657135@qq.com', '13828748467', '1', '1', '2019-11-05 14:30:29', null, null);
INSERT INTO `sys_user` VALUES ('27', '66667', 'ba9636d6900818f13bd913931af7362b', 'qSjjaedcdlQZugQPOvw3', '498657135@qq.com', '13828748467', '1', '1', '2019-11-05 14:32:00', null, null);
INSERT INTO `sys_user` VALUES ('28', '666610', '8e192ac3622268dbae7f0b0b3e8d8326', 'CBu8H2MiL41CVzgtLTNw', '498657135@qq.com', '13828748467', '1', '1', '2019-11-05 14:33:39', null, null);
INSERT INTO `sys_user` VALUES ('29', '321321321', '38d7369b723ad3c98725f0db616a23cf', '32m3pNog0uHEIgC0LPTQ', null, null, null, '1', null, null, null);
INSERT INTO `sys_user` VALUES ('32', '3213213211', '1c5ed8548a254cc7d9830eb7e0f9316f', 'V2PkbDH5vqz6EkgqQWk1', null, null, null, '1', null, null, null);
INSERT INTO `sys_user` VALUES ('33', '32132132111', '2bed827fcd3f87554ce8906c91694247', 'Ru4xSHdPnOFHglFWwvDG', null, null, null, '1', null, null, null);
INSERT INTO `sys_user` VALUES ('40', '11111', 'da9a8c6f9340f3d00e35f8fe2db889d8', 'TyRkdvW2J58lPSPdLBIj', '498657135@qq.com', '1382874846724', '1', '1', null, null, null);
INSERT INTO `sys_user` VALUES ('49', '3777', 'da9a8c6f9340f3d00e35f8fe2db889d8', 'TyRkdvW2J58lPSPdLBIj', '498657135@qq.com', '13828748467', '1', '1', null, null, null);
INSERT INTO `sys_user` VALUES ('50', '123123', 'd6cafe47ce15fb5691795844ec4d9e91', 'MCCwokb48vtGfNEuYlVW', '498657135@qq.com', '13828748467', '1', '1', null, null, null);

-- ----------------------------
-- Table structure for sys_user_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_user_role`;
CREATE TABLE `sys_user_role` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL COMMENT '用户ID',
  `role_id` bigint(20) DEFAULT NULL COMMENT '角色ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COMMENT='用户与角色对应关系';

-- ----------------------------
-- Records of sys_user_role
-- ----------------------------
INSERT INTO `sys_user_role` VALUES ('2', '1', '1');
INSERT INTO `sys_user_role` VALUES ('21', '4', '1');
INSERT INTO `sys_user_role` VALUES ('22', '4', '2');
INSERT INTO `sys_user_role` VALUES ('25', '25', '2');
INSERT INTO `sys_user_role` VALUES ('26', '26', '3');
INSERT INTO `sys_user_role` VALUES ('27', '26', '1');
INSERT INTO `sys_user_role` VALUES ('28', '27', '2');
INSERT INTO `sys_user_role` VALUES ('30', '28', '2');
INSERT INTO `sys_user_role` VALUES ('31', '28', '3');
INSERT INTO `sys_user_role` VALUES ('34', '1', '52');
INSERT INTO `sys_user_role` VALUES ('35', '2', '52');
INSERT INTO `sys_user_role` VALUES ('36', '3', '52');
INSERT INTO `sys_user_role` VALUES ('43', '50', '1');
INSERT INTO `sys_user_role` VALUES ('44', '50', '2');
INSERT INTO `sys_user_role` VALUES ('45', '50', '10');
INSERT INTO `sys_user_role` VALUES ('46', '5', '3');
INSERT INTO `sys_user_role` VALUES ('52', '5', '10');
INSERT INTO `sys_user_role` VALUES ('53', '5', '1');
