/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 100134
 Source Host           : localhost:3306
 Source Schema         : proxy

 Target Server Type    : MySQL
 Target Server Version : 100134
 File Encoding         : 65001

 Date: 03/09/2018 19:37:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `migration` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES ('2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES ('2016_02_04_041533_create_tasks_table', 1);

-- ----------------------------
-- Table structure for papers
-- ----------------------------
DROP TABLE IF EXISTS `papers`;
CREATE TABLE `papers`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tasks_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of papers
-- ----------------------------
INSERT INTO `papers` VALUES (3, 1, '7279063.pdf', '2018-08-04 17:42:45', '2018-08-04 17:42:45');
INSERT INTO `papers` VALUES (4, 1, 'doc.htm', '2018-08-04 18:21:22', '2018-08-04 18:21:22');
INSERT INTO `papers` VALUES (5, 1, 'doc.pdf', '2018-08-04 18:21:22', '2018-08-04 18:21:22');
INSERT INTO `papers` VALUES (6, 1, 'main.pdf', '2018-08-04 18:21:22', '2018-08-04 18:21:22');
INSERT INTO `papers` VALUES (7, 1, 'stamp.htm', '2018-08-04 18:21:23', '2018-08-04 18:21:23');
INSERT INTO `papers` VALUES (8, 1, '07219945.pdf', '2018-08-11 16:41:19', '2018-08-11 16:41:19');
INSERT INTO `papers` VALUES (9, 1, '07885814.pdf', '2018-08-11 16:41:19', '2018-08-11 16:41:19');
INSERT INTO `papers` VALUES (10, 1, '07885814.txt', '2018-08-11 16:41:19', '2018-08-11 16:41:19');
INSERT INTO `papers` VALUES (11, 1, '1-s2.0-S0952197611000777-main.pdf', '2018-08-11 16:41:19', '2018-08-11 16:41:19');
INSERT INTO `papers` VALUES (12, 1, '1-s2.0-S0957417417300751-main.pdf', '2018-08-11 16:41:19', '2018-08-11 16:41:19');
INSERT INTO `papers` VALUES (13, 1, '07279063.pdf', '2018-08-28 21:04:01', '2018-08-28 21:04:01');
INSERT INTO `papers` VALUES (14, 1, '08422113.pdf', '2018-08-28 21:04:01', '2018-08-28 21:04:01');
INSERT INTO `papers` VALUES (15, 1, 'p531-chakraborty.pdf', '2018-08-28 21:04:02', '2018-08-28 21:04:02');
INSERT INTO `papers` VALUES (16, 1, '10.1007%2Fs10489-014-0604-3.pdf', '2018-09-03 12:13:12', '2018-09-03 12:13:12');
INSERT INTO `papers` VALUES (17, 1, 's10489-014-0604-3.pdf', '2018-09-03 12:13:12', '2018-09-03 12:13:12');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  INDEX `password_resets_email_index`(`email`) USING BTREE,
  INDEX `password_resets_token_index`(`token`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
INSERT INTO `password_resets` VALUES ('1017052013@grad.cse.buet.ac.bd', 'c45d9a68fdc9ed9b85741a1f005e5b6c4f172fe9ae649fb157dc74e9278acb23', '2018-08-11 16:41:31');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `moodle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `session` timestamp(0) NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE,
  UNIQUE INDEX `moodle`(`moodle`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Tarik Reza Toha', '1017052013@grad.cse.buet.ac.bd', '$2y$10$mSyTHktvhaen/2Cy73btn.cSh0hS9GxpbzyOYBOjt1i2ON1WqgE32', '1017052013', '2018-09-03 13:12:26', 'URBaaKfBG1ZAwqyHKkqy65mNfahuDdV8WcWKrS8ahinFXZCKcs6DX6ZhNxoz', '2018-07-20 15:56:28', '2018-09-03 13:11:52');
INSERT INTO `users` VALUES (2, 'Tarik Toha', 'tarik.toha@gmail.com', '$2y$10$NeZaoc9qGsCUeTsDbynm9.4bwkhjPDB2ch1mrWTl4ZTnYqXdWuyGO', NULL, NULL, 'XQDGbzTNQm6j1TUlm2Ii08rSoRn78EoY1ogRmT1FvfEwDbncQaOgo88aOeDZ', '2018-09-02 10:57:51', '2018-09-02 12:09:10');

SET FOREIGN_KEY_CHECKS = 1;
