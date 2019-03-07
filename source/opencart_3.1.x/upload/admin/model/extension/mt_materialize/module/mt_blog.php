<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ModelExtensionMTMaterializeModuleMTBlog extends Model {
	public function install() {
		$this->load->model('setting/store');

		/* Installing tables */
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_blog_category` (
				`blog_category_id` int(11) NOT NULL AUTO_INCREMENT,
				`image` varchar(255) DEFAULT NULL,
				`parent_id` int(11) NOT NULL DEFAULT '0',
				`sort_order` int(3) NOT NULL DEFAULT '0',
				`status` tinyint(1) NOT NULL,
				`date_added` datetime NOT NULL,
				`date_modified` datetime NOT NULL,
				PRIMARY KEY (`blog_category_id`),
				INDEX (`parent_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_blog_category_description` (
				`blog_category_id` int(11) NOT NULL,
				`language_id` int(11) NOT NULL,
				`name` varchar(255) NOT NULL,
				`description` text NOT NULL,
				`meta_title` varchar(255) NOT NULL,
				`meta_h1` varchar(255) NOT NULL,
				`meta_description` varchar(255) NOT NULL,
				`meta_keyword` varchar(255) NOT NULL,
				PRIMARY KEY (`blog_category_id`, `language_id`),
				INDEX (`name`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_blog_category_path` (
				`blog_category_id` int(11) NOT NULL,
				`path_id` int(11) NOT NULL,
				`level` int(11) NOT NULL,
				PRIMARY KEY (`blog_category_id`, `path_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_blog_category_to_filter` (
				`blog_category_id` int(11) NOT NULL,
				`filter_id` int(11) NOT NULL,
				PRIMARY KEY (`blog_category_id`, `filter_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_blog_category_to_layout` (
				`blog_category_id` int(11) NOT NULL,
				`store_id` int(11) NOT NULL,
				`layout_id` int(11) NOT NULL,
				PRIMARY KEY (`blog_category_id`, `store_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_blog_category_to_store` (
				`blog_category_id` int(11) NOT NULL,
				`store_id` int(11) NOT NULL,
				PRIMARY KEY (`blog_category_id`, `store_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_post` (
				`post_id` int(11) NOT NULL AUTO_INCREMENT,
				`image` varchar(255) DEFAULT NULL,
				`sort_order` int(11) NOT NULL DEFAULT '0',
				`author_id` int(11) NOT NULL,
				`status` tinyint(1) NOT NULL DEFAULT '0',
				`comment_status` tinyint(1) NOT NULL DEFAULT '1',
				`viewed` int(5) NOT NULL DEFAULT '0',
				`date_added` datetime NOT NULL,
				`date_modified` datetime NOT NULL,
				PRIMARY KEY (`post_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_post_description` (
				`post_id` int(11) NOT NULL,
				`language_id` int(11) NOT NULL,
				`name` varchar(255) NOT NULL,
				`description` text NOT NULL,
				`tag` text NOT NULL,
				`meta_title` varchar(255) NOT NULL,
				`meta_h1` varchar(255) NOT NULL,
				`meta_description` varchar(255) NOT NULL,
				`meta_keyword` varchar(255) NOT NULL,
				PRIMARY KEY (`post_id`, `language_id`),
				INDEX (`name`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_post_comment` (
				`comment_id` int(11) NOT NULL AUTO_INCREMENT,
				`post_id` int(11) NOT NULL,
				`parent_id` int(11) NOT NULL,
				`customer_id` int(11) NOT NULL,
				`author` varchar(64) NOT NULL,
				`email` varchar(32) NOT NULL,
				`text` text NOT NULL,
				`status` tinyint(1) NOT NULL DEFAULT '0',
				`date_added` datetime NOT NULL,
				`date_modified` datetime NOT NULL,
				PRIMARY KEY (`comment_id`),
				INDEX (`post_id`, `parent_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_post_related` (
				`post_id` int(11) NOT NULL,
				`related_id` int(11) NOT NULL,
				PRIMARY KEY (`post_id`, `related_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_post_to_author` (
				`post_id` int(11) NOT NULL,
				`author_id` int(11) NOT NULL,
				PRIMARY KEY (`post_id`, `author_id`),
				INDEX (`author_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_post_to_category` (
				`post_id` int(11) NOT NULL,
				`blog_category_id` int(11) NOT NULL,
				`main_category` tinyint(1) NOT NULL DEFAULT '0',
				PRIMARY KEY (`post_id`, `blog_category_id`),
				INDEX (`blog_category_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_post_to_layout` (
				`post_id` int(11) NOT NULL,
				`store_id` int(11) NOT NULL,
				`layout_id` int(11) NOT NULL,
				PRIMARY KEY (`post_id`, `store_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mt_post_to_store` (
				`post_id` int(11) NOT NULL,
				`store_id` int(11) NOT NULL DEFAULT '0',
				PRIMARY KEY (`post_id`, `store_id`)
			) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;
		");

		/* Installing layouts */
		$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name = 'Materialize Blog'");

		$blog_layout_id = $this->db->getLastId();

		$layout_routes = [
			'extension/materialize/blog',
			'extension/materialize/blog/category',
			'extension/materialize/blog/search',
			'extension/materialize/blog/author',
			'extension/materialize/blog/author/info',
			'extension/materialize/blog/post'
		];

		$stores = [];

		$stores_info = $this->model_setting_store->getStores();

		foreach ($stores_info as $store) {
			$stores[$store['store_id']] = $layout_routes;
		}

		foreach ($stores as $store_id => $layout_routes) {
			foreach ($layout_routes as $layout) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = '" . (int)$blog_layout_id . "', store_id = '" . (int)$store_id . "', route = '" . $this->db->escape($layout) . "'");
			}
		}
	}

	public function uninstall() {
		$this->db->query("
			DROP TABLE IF EXISTS
				`" . DB_PREFIX . "mt_blog_category`,
				`" . DB_PREFIX . "mt_blog_category_description`,
				`" . DB_PREFIX . "mt_blog_category_path`,
				`" . DB_PREFIX . "mt_blog_category_to_layout`,
				`" . DB_PREFIX . "mt_blog_category_to_store`,
				`" . DB_PREFIX . "mt_post`,
				`" . DB_PREFIX . "mt_post_description`,
				`" . DB_PREFIX . "mt_post_comment`,
				`" . DB_PREFIX . "mt_post_related`,
				`" . DB_PREFIX . "mt_post_to_author`,
				`" . DB_PREFIX . "mt_post_to_category`,
				`" . DB_PREFIX . "mt_post_to_layout`,
				`" . DB_PREFIX . "mt_post_to_store`
			;
		");
	}
}