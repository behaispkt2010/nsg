ALTER TABLE `driver`
ADD COLUMN `phone_driver2`  varchar(255) NULL DEFAULT NULL AFTER `phone_driver`;
ALTER TABLE `driver`
ADD COLUMN `email`  varchar(255) NULL DEFAULT NULL AFTER `phone_driver2`;

ALTER TABLE `driver`
ADD COLUMN `address`  varchar(255) NULL AFTER `email`,
ADD COLUMN `province`  int NULL AFTER `address`,
ADD COLUMN `district`  int NULL AFTER `province`,
ADD COLUMN `identity`  int NULL AFTER `district`,
ADD COLUMN `image_identity`  varchar(255) NULL AFTER `identity`,
ADD COLUMN `carmarker`  int NULL AFTER `image_identity`,
ADD COLUMN `image_car`  varchar(255) NULL AFTER `carmarker`;

ALTER TABLE `users`
ADD COLUMN `idwho`  varchar(255) NULL DEFAULT NULL AFTER `code`;
ALTER TABLE `users`
MODIFY COLUMN `birthday`  varchar(255) NULL DEFAULT NULL AFTER `address`;
ALTER TABLE `orders`
ADD COLUMN `discount`  int(255) NULL AFTER `number_license_driver`,
ADD COLUMN `tax`  int(255) NULL COMMENT 'Thuế' AFTER `discount`,
ADD COLUMN `transport_pay`  int(255) NULL COMMENT 'Phí vận chuyển' AFTER `tax`;

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `id_kho` int(11) NOT NULL DEFAULT '0',
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `inventory_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idinventory` int(11) NOT NULL,
  `idproduct` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nameproduct` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inventory_num` int(11) NOT NULL,
  `inventory_real` int(11) NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `transports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of transports
-- ----------------------------
INSERT INTO `transports` VALUES ('1', 'Xe máy', '0');
INSERT INTO `transports` VALUES ('2', 'Xe ba gác', '0');
INSERT INTO `transports` VALUES ('3', 'Xe tải 1 tấn', '0');
INSERT INTO `transports` VALUES ('4', 'Xe tải 3.5 tấn', '0');
INSERT INTO `transports` VALUES ('5', 'Xe tải 8 tấn', '0');
INSERT INTO `transports` VALUES ('6', 'xe cont 20\"', '0');
INSERT INTO `transports` VALUES ('7', 'Xe cont 40\"', '0');
INSERT INTO `transports` VALUES ('8', 'Xe cont lạnh', '0');
INSERT INTO `transports` VALUES ('9', 'Khác', '0');

UPDATE `order_status` SET `color`='#59b75c' WHERE (`id`='9');

-- ----------------------------
-- Table structure for cate_payment
-- ----------------------------
DROP TABLE IF EXISTS `cate_payment`;
CREATE TABLE `cate_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cate_payment
-- ----------------------------
INSERT INTO `cate_payment` VALUES ('1', 'Bán hàng', '0');
INSERT INTO `cate_payment` VALUES ('2', 'Môi giới', '0');
INSERT INTO `cate_payment` VALUES ('3', 'POS', '0');

-- ----------------------------
-- Table structure for input_output
-- ----------------------------
DROP TABLE IF EXISTS `input_output`;
CREATE TABLE `input_output` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `id_product` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addpress` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provinceid` int(11) DEFAULT NULL,
  `districtid` int(11) DEFAULT NULL,
  `id_kho` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of input_output
-- ----------------------------

-- ----------------------------
-- Table structure for input_output_detail
-- ----------------------------
DROP TABLE IF EXISTS `input_output_detail`;
CREATE TABLE `input_output_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_io` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `nameproduct` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `quantity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of input_output_detail
-- ----------------------------

-- ----------------------------
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `type_pay` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_pay_detail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `period_pay` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_pay` text COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `deleted` int(255) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `users`
ADD COLUMN `tagType`  text NULL AFTER `introCode`,
ADD COLUMN `note`  varchar(255) NULL AFTER `tagType`,
ADD COLUMN `invoice_name`  varchar(255) NULL AFTER `note`,
ADD COLUMN `invoice_tax`  varchar(255) NULL AFTER `invoice_name`,
ADD COLUMN `invoice_address`  varchar(255) NULL AFTER `invoice_tax`;

// insert tables
CREATE TABLE `car_marker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of car_marker
-- ----------------------------
INSERT INTO `car_marker` VALUES ('1', 'Toyota', '0');
INSERT INTO `car_marker` VALUES ('2', 'Honda', '0');
INSERT INTO `car_marker` VALUES ('3', 'Isuzu', '0');
INSERT INTO `car_marker` VALUES ('4', 'Hyundai', '0');
INSERT INTO `car_marker` VALUES ('5', 'Audi', '0');
INSERT INTO `car_marker` VALUES ('6', 'BMW', '0');
INSERT INTO `car_marker` VALUES ('7', 'Chevrolet', '0');
INSERT INTO `car_marker` VALUES ('8', 'Ford', '0');
INSERT INTO `car_marker` VALUES ('9', 'Infiniti', '0');
INSERT INTO `car_marker` VALUES ('10', 'Jaguar', '0');
INSERT INTO `car_marker` VALUES ('11', 'KIA', '0');
INSERT INTO `car_marker` VALUES ('12', 'Land Rover', '0');
INSERT INTO `car_marker` VALUES ('13', 'Lexus', '0');
INSERT INTO `car_marker` VALUES ('14', 'Maserati', '0');
INSERT INTO `car_marker` VALUES ('15', 'Mazda', '0');
INSERT INTO `car_marker` VALUES ('16', 'Mercedes-Benz', '0');
INSERT INTO `car_marker` VALUES ('17', 'MINI', '0');
INSERT INTO `car_marker` VALUES ('18', 'Mitsubishi', '0');
INSERT INTO `car_marker` VALUES ('19', 'Nissan', '0');
INSERT INTO `car_marker` VALUES ('20', 'Peugeot', '0');
INSERT INTO `car_marker` VALUES ('21', 'Porsche', '0');
INSERT INTO `car_marker` VALUES ('22', 'Renault', '0');
INSERT INTO `car_marker` VALUES ('23', 'Ssangyong', '0');
INSERT INTO `car_marker` VALUES ('24', 'Subara', '0');
INSERT INTO `car_marker` VALUES ('25', 'Suzuki', '0');
INSERT INTO `car_marker` VALUES ('26', 'UAZ', '0');
INSERT INTO `car_marker` VALUES ('27', 'Volkswagen', '0');
INSERT INTO `car_marker` VALUES ('28', 'Volvo', '0');

ALTER TABLE `orders`
CHANGE COLUMN `type_driver` `id_driver`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `remain_pay`;

ALTER TABLE `transports`
ADD COLUMN `created_at`  timestamp(255) NULL AFTER `deleted`,
ADD COLUMN `updated_at`  timestamp NULL AFTER `created_at`;



