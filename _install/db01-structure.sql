--
-- Table structure for table 'permissions'
--
CREATE TABLE IF NOT EXISTS `permissions` (
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `description` TEXT DEFAULT NULL,
    `name` VARCHAR(255) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'roles'
--
CREATE TABLE IF NOT EXISTS `roles` (
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `description` TEXT DEFAULT NULL,
    `name` VARCHAR(255) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'role_permissions'
--
CREATE TABLE IF NOT EXISTS `role_permissions` (
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `permission_id` BIGINT(20) NOT NULL,
    `role_id` BIGINT(20) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `role_permissions_permission_id` (`permission_id`),
    KEY `role_permissions_role_id` (`role_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'users'
--
CREATE TABLE IF NOT EXISTS `users` (
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `activated` TINYINT(1) NOT NULL DEFAULT FALSE,
    `activation_code` VARCHAR(64) DEFAULT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `email` VARCHAR(254) NOT NULL,
    `forename` VARCHAR(100) NOT NULL,
    `password` TEXT NOT NULL,
    `remember_token` VARCHAR(255) DEFAULT NULL,
    `remember_identifier` VARCHAR(255) DEFAULT NULL,
    `salt` TEXT NOT NULL,
    `surname` VARCHAR(100) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `username` VARCHAR(32) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'user_permissions'
--
CREATE TABLE IF NOT EXISTS `user_permissions` (
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `permission_id` BIGINT(20) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `user_id` BIGINT(20) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_permissions_permission_id` (`permission_id`),
    KEY `user_permissions_user_id` (`user_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'user_roles'
--
CREATE TABLE IF NOT EXISTS `user_roles` (
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `role_id` BIGINT(20) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `user_id` BIGINT(20) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_roles_role_id` (`role_id`),
    KEY `user_roles_user_id` (`user_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
