ALTER TABLE `driver`
ADD COLUMN `phone_driver2`  varchar(255) NULL DEFAULT NULL AFTER `phone_driver`;
ALTER TABLE `driver`
ADD COLUMN `email`  varchar(255) NULL DEFAULT NULL AFTER `phone_driver2`;
ALTER TABLE `users`
ADD COLUMN `idwho`  varchar(255) NULL DEFAULT NULL AFTER `code`;
ALTER TABLE `users`
MODIFY COLUMN `birthday`  varchar(255) NULL DEFAULT NULL AFTER `address`;
