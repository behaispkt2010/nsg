ALTER TABLE `driver`
ADD COLUMN `phone_driver2`  varchar(255) NULL DEFAULT NULL AFTER `phone_driver`;
ALTER TABLE `driver`
ADD COLUMN `email`  varchar(255) NULL DEFAULT NULL AFTER `phone_driver2`;