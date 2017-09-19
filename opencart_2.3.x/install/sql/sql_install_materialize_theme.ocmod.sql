ALTER TABLE `oc_product` ADD `add_cart` TINYINT(1) DEFAULT 1;
ALTER TABLE `oc_product_description` ADD `size_chart` TEXT NOT NULL AFTER `description`;

INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'blog/category', 'blog');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'blog/author', 'authors');

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

CREATE TABLE IF NOT EXISTS `oc_blog_author` (
	`author_id` int(11) NOT NULL,
	`name` varchar(64) NOT NULL,
	`image` varchar(255) DEFAULT NULL,
	`sort_order` int(3) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_author_description` (
	`author_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(64) NOT NULL,
	`description` text NOT NULL,
	`meta_title` varchar(255) NOT NULL,
	`meta_h1` varchar(255) NOT NULL,
	`meta_description` varchar(255) NOT NULL,
	`meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_author_to_store` (
	`author_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_category` (
	`category_id` int(11) NOT NULL,
	`image` varchar(255) DEFAULT NULL,
	`parent_id` int(11) NOT NULL DEFAULT '0',
	`sort_order` int(3) NOT NULL DEFAULT '0',
	`status` tinyint(1) NOT NULL,
	`date_added` datetime NOT NULL,
	`date_modified` datetime NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_category_description` (
	`category_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(255) NOT NULL,
	`description` text NOT NULL,
	`meta_title` varchar(255) NOT NULL,
	`meta_h1` varchar(255) NOT NULL,
	`meta_description` varchar(255) NOT NULL,
	`meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_category_filter` (
	`category_id` int(11) NOT NULL,
	`filter_id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_category_path` (
	`category_id` int(11) NOT NULL,
	`path_id` int(11) NOT NULL,
	`level` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_category_to_layout` (
	`category_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL,
	`layout_id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_blog_category_to_store` (
	`category_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_post` (
	`post_id` int(11) NOT NULL,
	`image` varchar(255) DEFAULT NULL,
	`sort_order` int(11) NOT NULL DEFAULT '0',
	`author_id` int(11) NOT NULL,
	`status` tinyint(1) NOT NULL DEFAULT '0',
	`viewed` int(5) NOT NULL DEFAULT '0',
	`date_added` datetime NOT NULL,
	`date_modified` datetime NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_post_comment` (
	`comment_id` int(11) NOT NULL,
	`post_id` int(11) NOT NULL,
	`author` varchar(64) NOT NULL,
	`email` varchar(32) NOT NULL,
	`text` text NOT NULL,
	`status` tinyint(1) NOT NULL DEFAULT '0',
	`date_added` datetime NOT NULL,
	`date_modified` datetime NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_post_description` (
	`post_id` int(11) NOT NULL,
	`language_id` int(11) NOT NULL,
	`name` varchar(255) NOT NULL,
	`description` text NOT NULL,
	`tag` text NOT NULL,
	`meta_title` varchar(255) NOT NULL,
	`meta_h1` varchar(255) NOT NULL,
	`meta_description` varchar(255) NOT NULL,
	`meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_post_filter` (
	`post_id` int(11) NOT NULL,
	`filter_id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_post_related` (
	`post_id` int(11) NOT NULL,
	`related_id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_post_to_author` (
	`post_id` int(11) NOT NULL,
	`author_id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_post_to_category` (
	`post_id` int(11) NOT NULL,
	`category_id` int(11) NOT NULL,
	`main_category` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_post_to_layout` (
	`post_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL,
	`layout_id` int(11) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `oc_post_to_store` (
	`post_id` int(11) NOT NULL,
	`store_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM;

ALTER TABLE `oc_blog_author` ADD PRIMARY KEY (`author_id`);
ALTER TABLE `oc_blog_author_description` ADD PRIMARY KEY (`author_id`,`language_id`);
ALTER TABLE `oc_blog_author_to_store` ADD PRIMARY KEY (`author_id`,`store_id`);
ALTER TABLE `oc_blog_category` ADD PRIMARY KEY (`category_id`), ADD KEY `parent_id` (`parent_id`);
ALTER TABLE `oc_blog_category_description` ADD PRIMARY KEY (`category_id`,`language_id`), ADD KEY `name` (`name`);
ALTER TABLE `oc_blog_category_filter` ADD PRIMARY KEY (`category_id`,`filter_id`);
ALTER TABLE `oc_blog_category_path` ADD PRIMARY KEY (`category_id`,`path_id`);
ALTER TABLE `oc_blog_category_to_layout` ADD PRIMARY KEY (`category_id`,`store_id`);
ALTER TABLE `oc_blog_category_to_store` ADD PRIMARY KEY (`category_id`,`store_id`);
ALTER TABLE `oc_post` ADD PRIMARY KEY (`post_id`);
ALTER TABLE `oc_post_comment` ADD PRIMARY KEY (`comment_id`), ADD KEY `post_id` (`post_id`);
ALTER TABLE `oc_post_description` ADD PRIMARY KEY (`post_id`,`language_id`), ADD KEY `name` (`name`);
ALTER TABLE `oc_post_filter` ADD PRIMARY KEY (`post_id`,`filter_id`);
ALTER TABLE `oc_post_related` ADD PRIMARY KEY (`post_id`,`related_id`);
ALTER TABLE `oc_post_to_author` ADD PRIMARY KEY (`post_id`,`author_id`), ADD KEY `author_id` (`author_id`);
ALTER TABLE `oc_post_to_category` ADD PRIMARY KEY (`post_id`,`category_id`), ADD KEY `category_id` (`category_id`);
ALTER TABLE `oc_post_to_layout` ADD PRIMARY KEY (`post_id`,`store_id`);
ALTER TABLE `oc_post_to_store` ADD PRIMARY KEY (`post_id`,`store_id`);
ALTER TABLE `oc_blog_author` MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `oc_blog_category` MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `oc_post` MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `oc_post_comment` MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;