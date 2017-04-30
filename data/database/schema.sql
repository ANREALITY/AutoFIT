-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema autofit
-- -----------------------------------------------------
-- AutoFIT database

-- -----------------------------------------------------
-- Table `application`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `application` (
  `technical_short_name` CHAR(100) NOT NULL,
  `technical_id` CHAR(10) NULL,
  `active` TINYINT(1) NULL DEFAULT 0,
  `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`technical_short_name`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `environment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `environment` (
  `severity` TINYINT(1) NOT NULL,
  `name` CHAR(32) NOT NULL,
  `short_name` CHAR(1) NOT NULL,
  PRIMARY KEY (`severity`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `service_invoice`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `service_invoice` (
  `number` CHAR(16) NOT NULL,
  `description` CHAR(128) NULL,
  `application_technical_short_name` CHAR(100) NOT NULL,
  `environment_severity` TINYINT(1) NOT NULL,
  PRIMARY KEY (`number`),
  CONSTRAINT `fk_service_invoice_application`
  FOREIGN KEY (`application_technical_short_name`)
  REFERENCES `application` (`technical_short_name`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_service_invoice_environment`
  FOREIGN KEY (`environment_severity`)
  REFERENCES `environment` (`severity`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_service_invoice_application_idx` ON `service_invoice` (`application_technical_short_name` ASC);

CREATE INDEX `fk_service_invoice_environment_idx` ON `service_invoice` (`environment_severity` ASC);


-- -----------------------------------------------------
-- Table `product_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `product_type` (
  `name` VARCHAR(12) NOT NULL,
  `long_name` VARCHAR(64) NULL,
  PRIMARY KEY (`name`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `article` (
  `sku` CHAR(16) NOT NULL,
  `description` CHAR(100) NULL,
  `type` ENUM('basic', 'personal', 'on-demand') NULL,
  `product_type_name` VARCHAR(12) NOT NULL,
  PRIMARY KEY (`sku`),
  CONSTRAINT `fk_article_product_type`
  FOREIGN KEY (`product_type_name`)
  REFERENCES `product_type` (`name`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_article_product_type_idx` ON `article` (`product_type_name` ASC);


-- -----------------------------------------------------
-- Table `service_invoice_position`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `service_invoice_position` (
  `number` CHAR(12) NOT NULL,
  `order_quantity` CHAR(12) NULL,
  `description` CHAR(128) NULL,
  `status` CHAR(32) NOT NULL,
  `service_invoice_number` CHAR(16) NOT NULL,
  `article_sku` CHAR(16) NOT NULL,
  `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`number`),
  CONSTRAINT `fk_service_invoice_position_service_invoice`
  FOREIGN KEY (`service_invoice_number`)
  REFERENCES `service_invoice` (`number`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_service_invoice_position_article`
  FOREIGN KEY (`article_sku`)
  REFERENCES `article` (`sku`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_service_invoice_position_service_invoice_idx` ON `service_invoice_position` (`service_invoice_number` ASC);

CREATE INDEX `fk_service_invoice_position_article1_idx` ON `service_invoice_position` (`article_sku` ASC);


-- -----------------------------------------------------
-- Table `logical_connection`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `logical_connection` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` ENUM('CD', 'FTGW') NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `physical_connection`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `physical_connection` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` ENUM('end_to_end', 'end_to_middle', 'middle_to_end') NULL,
  `type` ENUM('CD', 'FTGW') NULL,
  `secure_plus` TINYINT(1) NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `logical_connection_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_physical_connection_logical_connection`
  FOREIGN KEY (`logical_connection_id`)
  REFERENCES `logical_connection` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_physical_connection_logical_connection_idx` ON `physical_connection` (`logical_connection_id` ASC);


-- -----------------------------------------------------
-- Table `customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `customer` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `server_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `server_type` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;

CREATE UNIQUE INDEX `name_UNIQUE` ON `server_type` (`name` ASC);


-- -----------------------------------------------------
-- Table `cluster`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cluster` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `virtual_node_name` VARCHAR(50) NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;

CREATE UNIQUE INDEX `virtual_node_name_UNIQUE` ON `cluster` (`virtual_node_name` ASC);


-- -----------------------------------------------------
-- Table `server`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `server` (
  `name` CHAR(32) NOT NULL,
  `active` TINYINT(1) NULL DEFAULT 0,
  `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `node_name` VARCHAR(50) NULL,
  `virtual_node_name` VARCHAR(50) NULL,
  `server_type_id` TINYINT UNSIGNED NOT NULL,
  `cluster_id` INT UNSIGNED NULL,
  PRIMARY KEY (`name`),
  CONSTRAINT `fk_server_server_type`
  FOREIGN KEY (`server_type_id`)
  REFERENCES `server_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_server_cluster`
  FOREIGN KEY (`cluster_id`)
  REFERENCES `cluster` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_server_server_type_idx` ON `server` (`server_type_id` ASC);

CREATE INDEX `fk_server_cluster_idx` ON `server` (`cluster_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_server_config`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_server_config` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dns_address` VARCHAR(253) NULL,
  `server_name` CHAR(32) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_endpoint_server_config_server`
  FOREIGN KEY (`server_name`)
  REFERENCES `server` (`name`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_server_config_server_idx` ON `endpoint_server_config` (`server_name` ASC);


-- -----------------------------------------------------
-- Table `external_server`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `external_server` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `endpoint`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` ENUM('source', 'target') NULL,
  `type` ENUM('CdAs400', 'CdTandem', 'CdLinuxUnix', 'CdWindows', 'CdWindowsShare', 'CdZos', 'FtgwLinuxUnix', 'FtgwWindows', 'FtgwWindowsShare', 'FtgwSelfService', 'FtgwProtocolServer', 'FtgwCdZos', 'FtgwCdTandem', 'FtgwCdAs400') NULL,
  `server_place` ENUM('internal', 'external') NULL,
  `contact_person` VARCHAR(500) NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `physical_connection_id` INT UNSIGNED NOT NULL,
  `application_technical_short_name` CHAR(100) NULL,
  `customer_id` INT UNSIGNED NULL,
  `endpoint_server_config_id` INT UNSIGNED NULL,
  `external_server_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_endpoint_physical_connection`
  FOREIGN KEY (`physical_connection_id`)
  REFERENCES `physical_connection` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_application`
  FOREIGN KEY (`application_technical_short_name`)
  REFERENCES `application` (`technical_short_name`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_customer`
  FOREIGN KEY (`customer_id`)
  REFERENCES `customer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_endpoint_server_config`
  FOREIGN KEY (`endpoint_server_config_id`)
  REFERENCES `endpoint_server_config` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_external_server`
  FOREIGN KEY (`external_server_id`)
  REFERENCES `external_server` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_physical_connection_idx` ON `endpoint` (`physical_connection_id` ASC);

CREATE INDEX `fk_endpoint_application_idx` ON `endpoint` (`application_technical_short_name` ASC);

CREATE INDEX `fk_endpoint_customer_idx` ON `endpoint` (`customer_id` ASC);

CREATE INDEX `fk_endpoint_endpoint_server_config_idx` ON `endpoint` (`endpoint_server_config_id` ASC);

CREATE INDEX `fk_endpoint_external_server_idx` ON `endpoint` (`external_server_id` ASC);


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NULL,
  `role` ENUM('member', 'admin', 'guest') NOT NULL DEFAULT 'member',
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `file_transfer_request`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `file_transfer_request` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `change_number` VARCHAR(50) NOT NULL,
  `status` ENUM('edit', 'pending', 'canceled', 'check', 'accepted', 'declined', 'completed') NOT NULL DEFAULT 'edit',
  `comment` VARCHAR(500) NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `logical_connection_id` INT UNSIGNED NOT NULL,
  `service_invoice_position_basic_number` CHAR(12) NOT NULL,
  `service_invoice_position_personal_number` CHAR(12) NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_file_transfer_request_logical_connection`
  FOREIGN KEY (`logical_connection_id`)
  REFERENCES `logical_connection` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_file_transfer_request_service_invoice_position_basic`
  FOREIGN KEY (`service_invoice_position_basic_number`)
  REFERENCES `service_invoice_position` (`number`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_file_transfer_request_service_invoice_position_personal`
  FOREIGN KEY (`service_invoice_position_personal_number`)
  REFERENCES `service_invoice_position` (`number`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_file_transfer_request_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_file_transfer_request_logical_connection_idx` ON `file_transfer_request` (`logical_connection_id` ASC);

CREATE INDEX `fk_file_transfer_request_service_invoice_position_basic_idx` ON `file_transfer_request` (`service_invoice_position_basic_number` ASC);

CREATE INDEX `fk_file_transfer_request_service_invoice_position_personal_idx` ON `file_transfer_request` (`service_invoice_position_personal_number` ASC);

CREATE INDEX `fk_file_transfer_request_user_idx` ON `file_transfer_request` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_cd_tandem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_cd_tandem` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(50) NULL COMMENT 'Verfahrensuser ??? ID ???',
  `folder` VARCHAR(200) NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_cd_tandem_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `endpoint_cd_as400`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_cd_as400` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(50) NULL COMMENT 'Verfahrensuser ??? ID ???',
  `folder` VARCHAR(200) NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_cd_as400_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `physical_connection_cd`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `physical_connection_cd` (
  `physical_connection_id` INT UNSIGNED NOT NULL,
  `secure_plus` TINYINT(1) NULL,
  PRIMARY KEY (`physical_connection_id`),
  CONSTRAINT `fk_physical_connection_cd_physical_connection`
  FOREIGN KEY (`physical_connection_id`)
  REFERENCES `physical_connection` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `physical_connection_ftgw`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `physical_connection_ftgw` (
  `physical_connection_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`physical_connection_id`),
  CONSTRAINT `fk_physical_connection_ftgw_physical_connection`
  FOREIGN KEY (`physical_connection_id`)
  REFERENCES `physical_connection` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `include_parameter_set`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `include_parameter_set` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `endpoint_ftgw_windows`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_ftgw_windows` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `folder` VARCHAR(200) NULL,
  `include_parameter_set_id` INT UNSIGNED NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_ftgw_windows_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_ftgw_windows_include_parameter_set`
  FOREIGN KEY (`include_parameter_set_id`)
  REFERENCES `include_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_ftgw_windows_endpoint_idx` ON `endpoint_ftgw_windows` (`endpoint_id` ASC);

CREATE INDEX `fk_endpoint_ftgw_windows_include_parameter_set_idx` ON `endpoint_ftgw_windows` (`include_parameter_set_id` ASC);


-- -----------------------------------------------------
-- Table `protocol_set`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `protocol_set` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `endpoint_ftgw_self_service`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_ftgw_self_service` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `ftgw_username` VARCHAR(50) NULL,
  `mailbox` VARCHAR(50) NULL,
  `connection_type` ENUM('internal', 'external', 'both') NULL,
  `protocol_set_id` INT UNSIGNED NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_ftgw_self_service_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_ftgw_self_service_protocol_set`
  FOREIGN KEY (`protocol_set_id`)
  REFERENCES `protocol_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_ftgw_self_service_protocol_set_idx` ON `endpoint_ftgw_self_service` (`protocol_set_id` ASC);


-- -----------------------------------------------------
-- Table `notification`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `notification` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(50) NOT NULL,
  `success` TINYINT(1) NULL,
  `failure` TINYINT(1) NULL,
  `logical_connection_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_notification_logical_connection`
  FOREIGN KEY (`logical_connection_id`)
  REFERENCES `logical_connection` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_notification_logical_connection_idx` ON `notification` (`logical_connection_id` ASC);


-- -----------------------------------------------------
-- Table `include_parameter`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `include_parameter` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `expression` VARCHAR(50) NULL,
  `include_parameter_set_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_include_parameter_include_parameter_set`
  FOREIGN KEY (`include_parameter_set_id`)
  REFERENCES `include_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_include_parameter_include_parameter_set_idx` ON `include_parameter` (`include_parameter_set_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_cluster_config`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_cluster_config` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dns_address` VARCHAR(253) NULL,
  `cluster_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_endpoint_cluster_config_cluster`
  FOREIGN KEY (`cluster_id`)
  REFERENCES `cluster` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_cluster_config_cluster_idx` ON `endpoint_cluster_config` (`cluster_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_cd_linux_unix`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_cd_linux_unix` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(50) NULL,
  `folder` VARCHAR(200) NULL,
  `transmission_type` ENUM('txt', 'bin') NULL,
  `transmission_interval` VARCHAR(50) NULL,
  `include_parameter_set_id` INT UNSIGNED NULL,
  `endpoint_cluster_config_id` INT UNSIGNED NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_cd_linux_unix_include_parameter_set`
  FOREIGN KEY (`include_parameter_set_id`)
  REFERENCES `include_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_cd_linux_unix_endpoint_cluster_config`
  FOREIGN KEY (`endpoint_cluster_config_id`)
  REFERENCES `endpoint_cluster_config` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_cd_linux_unix_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_cd_linux_unix_include_parameter_set_idx` ON `endpoint_cd_linux_unix` (`include_parameter_set_id` ASC);

CREATE INDEX `fk_endpoint_cd_linux_unix_endpoint_cluster_config_idx` ON `endpoint_cd_linux_unix` (`endpoint_cluster_config_id` ASC);


-- -----------------------------------------------------
-- Table `synchronization`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `synchronization` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `in_progress` TINYINT(1) NOT NULL DEFAULT 0,
  `type` ENUM('billing', 'application', 'server') NOT NULL,
  `last_sync` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;

CREATE UNIQUE INDEX `type_UNIQUE` ON `synchronization` (`type` ASC);


-- -----------------------------------------------------
-- Table `access_config_set`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `access_config_set` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `endpoint_cd_windows_share`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_cd_windows_share` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `sharename` VARCHAR(50) NULL,
  `folder` VARCHAR(200) NULL,
  `transmission_type` ENUM('txt', 'bin') NULL,
  `include_parameter_set_id` INT UNSIGNED NULL,
  `access_config_set_id` INT UNSIGNED NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_cd_windows_share_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_cd_windows_share_include_parameter_set`
  FOREIGN KEY (`include_parameter_set_id`)
  REFERENCES `include_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_cd_windows_share_access_config_set`
  FOREIGN KEY (`access_config_set_id`)
  REFERENCES `access_config_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_cd_windows_share_include_parameter_set_idx` ON `endpoint_cd_windows_share` (`include_parameter_set_id` ASC);

CREATE INDEX `fk_endpoint_cd_windows_share_access_config_set_idx` ON `endpoint_cd_windows_share` (`access_config_set_id` ASC);


-- -----------------------------------------------------
-- Table `access_config`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `access_config` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NULL,
  `permission_read` TINYINT NULL,
  `permission_write` TINYINT NULL,
  `permission_delete` TINYINT NULL,
  `access_config_set_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_access_config_access_config_set`
  FOREIGN KEY (`access_config_set_id`)
  REFERENCES `access_config_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_access_config_access_config_set_idx` ON `access_config` (`access_config_set_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_type` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `label` VARCHAR(50) NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `endpoint_type_server_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_type_server_type` (
  `server_type_id` TINYINT UNSIGNED NOT NULL,
  `endpoint_type_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`server_type_id`, `endpoint_type_id`),
  CONSTRAINT `fk_endpoint_type_server_type_endpoint_type`
  FOREIGN KEY (`endpoint_type_id`)
  REFERENCES `endpoint_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_type_server_type_server_type`
  FOREIGN KEY (`server_type_id`)
  REFERENCES `server_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_type_server_type_server_type_idx` ON `endpoint_type_server_type` (`server_type_id` ASC);

CREATE INDEX `fk_endpoint_type_server_type_endpoint_type_idx` ON `endpoint_type_server_type` (`endpoint_type_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_cd_windows`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_cd_windows` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `folder` VARCHAR(200) NULL,
  `transmission_type` ENUM('txt', 'bin') NULL,
  `include_parameter_set_id` INT UNSIGNED NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_cd_windows_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_cd_windows_include_parameter_set`
  FOREIGN KEY (`include_parameter_set_id`)
  REFERENCES `include_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_cd_windows_endpoint_idx` ON `endpoint_cd_windows` (`endpoint_id` ASC);

CREATE INDEX `fk_endpoint_cd_windows_include_parameter_set_idx` ON `endpoint_cd_windows` (`include_parameter_set_id` ASC);


-- -----------------------------------------------------
-- Table `file_parameter_set`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `file_parameter_set` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `endpoint_cd_zos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_cd_zos` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(50) NULL,
  `file_parameter_set_id` INT UNSIGNED NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_cd_zos_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_cd_zos_file_parameter_set`
  FOREIGN KEY (`file_parameter_set_id`)
  REFERENCES `file_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_cd_zos_file_parameter_set_idx` ON `endpoint_cd_zos` (`file_parameter_set_id` ASC);


-- -----------------------------------------------------
-- Table `file_parameter`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `file_parameter` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename` VARCHAR(50) NULL,
  `record_length` MEDIUMINT UNSIGNED NULL,
  `blocking` ENUM('vb', 'fb') NULL,
  `block_size` MEDIUMINT NULL,
  `file_parameter_set_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_file_parameter_file_parameter_set`
  FOREIGN KEY (`file_parameter_set_id`)
  REFERENCES `file_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_file_parameter_file_parameter_set_idx` ON `file_parameter` (`file_parameter_set_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_ftgw_protocol_server`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_ftgw_protocol_server` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(50) NULL,
  `folder` VARCHAR(200) NULL,
  `transmission_type` ENUM('txt', 'bin') NULL,
  `port` VARCHAR(5) NULL,
  `ip` VARCHAR(15) NULL,
  `dns_address` VARCHAR(253) NULL,
  `include_parameter_set_id` INT UNSIGNED NULL,
  `protocol_set_id` INT UNSIGNED NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_ftgw_protocol_server_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_ftgw_protocol_server_include_parameter_set`
  FOREIGN KEY (`include_parameter_set_id`)
  REFERENCES `include_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_ftgw_protocol_server_protocol_set`
  FOREIGN KEY (`protocol_set_id`)
  REFERENCES `protocol_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_ftgw_protocol_server_include_parameter_set_idx` ON `endpoint_ftgw_protocol_server` (`include_parameter_set_id` ASC);

CREATE INDEX `fk_endpoint_ftgw_protocol_server_protocol_set_idx` ON `endpoint_ftgw_protocol_server` (`protocol_set_id` ASC);


-- -----------------------------------------------------
-- Table `protocol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `protocol` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` ENUM('FTP', 'FTPs', 'SFTP', 'HTTP', 'HTTPs', 'WebDAV') NULL,
  `protocol_set_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_protocol_protocol_set`
  FOREIGN KEY (`protocol_set_id`)
  REFERENCES `protocol_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_protocol_protocol_set_idx` ON `protocol` (`protocol_set_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_ftgw_windows_share`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_ftgw_windows_share` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `sharename` VARCHAR(50) NULL,
  `folder` VARCHAR(200) NULL,
  `include_parameter_set_id` INT UNSIGNED NULL,
  `access_config_set_id` INT UNSIGNED NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_ftgw_windows_share_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_ftgw_windows_share_include_parameter_set`
  FOREIGN KEY (`include_parameter_set_id`)
  REFERENCES `include_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_ftgw_windows_share_access_config_set`
  FOREIGN KEY (`access_config_set_id`)
  REFERENCES `access_config_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_ftgw_windows_share_include_parameter_set_idx` ON `endpoint_ftgw_windows_share` (`include_parameter_set_id` ASC);

CREATE INDEX `fk_endpoint_ftgw_windows_share_access_config_set_idx` ON `endpoint_ftgw_windows_share` (`access_config_set_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_ftgw_linux_unix`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_ftgw_linux_unix` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(50) NULL,
  `folder` VARCHAR(200) NULL,
  `transmission_type` ENUM('txt', 'bin') NULL,
  `transmission_interval` VARCHAR(50) NULL,
  `include_parameter_set_id` INT UNSIGNED NULL,
  `endpoint_cluster_config_id` INT UNSIGNED NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_ftgw_linux_unix_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_ftgw_linux_unix_include_parameter_set`
  FOREIGN KEY (`include_parameter_set_id`)
  REFERENCES `include_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_ftgw_linux_unix_endpoint_cluster_config`
  FOREIGN KEY (`endpoint_cluster_config_id`)
  REFERENCES `endpoint_cluster_config` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_ftgw_linux_unix_include_parameter_set_idx` ON `endpoint_ftgw_linux_unix` (`include_parameter_set_id` ASC);

CREATE INDEX `fk_endpoint_ftgw_linux_unix_endpoint_cluster_config_idx` ON `endpoint_ftgw_linux_unix` (`endpoint_cluster_config_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_ftgw_cd_zos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_ftgw_cd_zos` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(50) NULL,
  `file_parameter_set_id` INT UNSIGNED NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_ftgw_cd_zos_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endpoint_ftgw_cd_zos_file_parameter_set`
  FOREIGN KEY (`file_parameter_set_id`)
  REFERENCES `file_parameter_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE INDEX `fk_endpoint_ftgw_cd_zos_file_parameter_set_idx` ON `endpoint_ftgw_cd_zos` (`file_parameter_set_id` ASC);


-- -----------------------------------------------------
-- Table `endpoint_ftgw_cd_tandem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_ftgw_cd_tandem` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(50) NULL,
  `folder` VARCHAR(200) NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_ftgw_cd_tandem_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `endpoint_ftgw_cd_as400`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `endpoint_ftgw_cd_as400` (
  `endpoint_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(50) NULL,
  `folder` VARCHAR(200) NULL,
  PRIMARY KEY (`endpoint_id`),
  CONSTRAINT `fk_endpoint_ftgw_cd_as400_endpoint`
  FOREIGN KEY (`endpoint_id`)
  REFERENCES `endpoint` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `audit_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `audit_log` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `resource_type` ENUM('order', 'server', 'cluster') NULL,
  `resource_id` VARCHAR(50) NULL,
  `action` ENUM('order.created', 'order.submitted', 'order.editing_started', 'order.updated', 'order.canceled', 'order.checking_started', 'order.accepted', 'order.declined', 'order.completed', 'order.exported', 'server.virtual_node_name_added', 'cluster.created') NULL,
  `datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_audit_log_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  COMMENT = '						';

CREATE INDEX `fk_audit_log_user_idx` ON `audit_log` (`user_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
