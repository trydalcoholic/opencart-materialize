ALTER TABLE `oc_product` ADD `add_cart` TINYINT(1) DEFAULT 1;
ALTER TABLE `oc_product_description` ADD `size_chart` TEXT NOT NULL AFTER `description`;

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

/* Blog */

CREATE TABLE IF NOT EXISTS `oc_blog_category` (
	`blog_category_id` INT(11) NOT NULL,
	`image` VARCHAR(255) DEFAULT NULL,
	`sort_order` INT(3) NOT NULL DEFAULT '0',
	`status` TINYINT(1) NOT NULL,
	`date_added` DATETIME NOT NULL,
	`date_modified` DATETIME NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_category_description` (
	`blog_category_id` INT(11) NOT NULL,
	`language_id` INT(11) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`description` TEXT NOT NULL,
	`meta_title` VARCHAR(255) NOT NULL,
	`meta_description` VARCHAR(255) NOT NULL,
	`meta_keyword` VARCHAR(255) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_category_to_layout` (
	`blog_category_id` INT(11) NOT NULL,
	`store_id` INT(11) NOT NULL,
	`layout_id` INT(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_category_to_store` (
	`blog_category_id` INT(11) NOT NULL,
	`store_id` INT(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_comment` (
	`blog_comment_id` INT(11) NOT NULL,
	`blog_post_id` INT(11) NOT NULL,
	`customer_id` INT(11) NOT NULL,
	`author` VARCHAR(64) NOT NULL,
	`email` VARCHAR(32) NOT NULL,
	`text` TEXT NOT NULL,
	`status` TINYINT(1) NOT NULL DEFAULT '0',
	`date_added` DATETIME NOT NULL,
	`date_modified` DATETIME NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_post` (
	`blog_post_id` INT(11) NOT NULL,
	`image` VARCHAR(255) NULL DEFAULT NULL,
	`author` VARCHAR(32) NOT NULL,
	`sort_order` INT(3) NOT NULL DEFAULT '0',
	`status` TINYINT(1) NOT NULL DEFAULT '1',
	`date_added` DATETIME NOT NULL,
	`date_modified` DATETIME NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_post_description` (
	`blog_post_id` INT(11) NOT NULL,
	`language_id` INT(11) NOT NULL,
	`title` VARCHAR(64) NOT NULL,
	`description` TEXT NOT NULL,
	`tag` TEXT NOT NULL,
	`meta_title` VARCHAR(255) NOT NULL,
	`meta_description` VARCHAR(255) NOT NULL,
	`meta_keyword` VARCHAR(255) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_post_to_category` (
	`blog_post_id` INT(11) NOT NULL,
	`blog_category_id` INT(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_post_to_layout` (
	`blog_post_id` INT(11) NOT NULL,
	`store_id` INT(11) NOT NULL,
	`layout_id` INT(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_post_to_store` (
	`blog_post_id` INT(11) NOT NULL,
	`store_id` INT(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_url_alias_blog` (
	`url_alias_id` INT(11) NOT NULL,
	`query` VARCHAR(255) NOT NULL,
	`keyword` VARCHAR(255) NOT NULL
) ENGINE=MyISAM;

ALTER TABLE `oc_blog_category` ADD PRIMARY KEY (`blog_category_id`);
ALTER TABLE `oc_blog_category_description` ADD PRIMARY KEY (`blog_category_id`,`language_id`), ADD KEY `name` (`name`);
ALTER TABLE `oc_blog_category_to_layout` ADD PRIMARY KEY (`blog_category_id`,`store_id`);
ALTER TABLE `oc_blog_category_to_store` ADD PRIMARY KEY (`blog_category_id`,`store_id`);
ALTER TABLE `oc_blog_comment` ADD PRIMARY KEY (`blog_comment_id`), ADD KEY `product_id` (`blog_post_id`);
ALTER TABLE `oc_blog_post` ADD PRIMARY KEY (`blog_post_id`);
ALTER TABLE `oc_blog_post_description` ADD PRIMARY KEY (`blog_post_id`,`language_id`);
ALTER TABLE `oc_blog_post_to_category` ADD PRIMARY KEY (`blog_post_id`,`blog_category_id`), ADD KEY `category_id` (`blog_category_id`);
ALTER TABLE `oc_blog_post_to_layout` ADD PRIMARY KEY (`blog_post_id`,`store_id`);
ALTER TABLE `oc_blog_post_to_store` ADD PRIMARY KEY (`blog_post_id`,`store_id`);
ALTER TABLE `oc_url_alias_blog` ADD PRIMARY KEY (`url_alias_id`), ADD KEY `query` (`query`), ADD KEY `keyword` (`keyword`);
ALTER TABLE `oc_blog_category` MODIFY `blog_category_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `oc_blog_comment` MODIFY `blog_comment_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `oc_blog_post` MODIFY `blog_post_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `oc_url_alias_blog` MODIFY `url_alias_id` INT(11) NOT NULL AUTO_INCREMENT;