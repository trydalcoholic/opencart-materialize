ALTER TABLE `oc_product` ADD `add_cart` TINYINT(1) DEFAULT 1;
ALTER TABLE `oc_product_description` ADD `size_chart` LONGTEXT NOT NULL AFTER `description`;

CREATE TABLE IF NOT EXISTS `oc_product_customtab` (
	`product_customtab_id` INT(11) NOT NULL AUTO_INCREMENT,
	`product_id` INT(11) NOT NULL,
	`sort_order` INT(11) NOT NULL,
	`status` TINYINT(1) NOT NULL,
	PRIMARY KEY (`product_customtab_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_product_customtab_description` (
	`product_customtab_id` INT(11) NOT NULL,
	`language_id` INT(11) NOT NULL,
	`product_id` INT(11) NOT NULL,
	`title` VARCHAR(255) CHARACTER SET utf8 NOT NULL,
	`description` TEXT CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_product_additionalfield` (
	`product_additionalfield_id` INT(11) NOT NULL AUTO_INCREMENT,
	`product_id` INT(11) NOT NULL,
	`sort_order` INT(11) NOT NULL,
	`status` TINYINT(1) NOT NULL,
	PRIMARY KEY (`product_additionalfield_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_product_additionalfield_text` (
	`product_additionalfield_id` INT(11) NOT NULL,
	`language_id` INT(11) NOT NULL,
	`product_id` INT(11) NOT NULL,
	`title` VARCHAR(255) CHARACTER SET utf8 NOT NULL,
	`text` VARCHAR(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM;