<?php
class ModelExtensionMaterializeMegamenu extends Model {
	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "megamenu` (
				`category_id` int(11) NOT NULL,
				`content_type` varchar(32) NOT NULL DEFAULT 'default',
				`content_info` int(11) NOT NULL DEFAULT '0',
				`sort_order` int(3) NOT NULL DEFAULT '0',
				PRIMARY KEY (`category_id`)
			)
		");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "megamenu`");
	}

	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->rows;
	}

	public function getMegamenuCategories() {
		$megamenu_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "megamenu");

		foreach ($query->rows as $result) {
			$megamenu_data[$result['category_id']] = array(
				'content_type'	=> $result['content_type'],
				'content_info'	=> $result['content_info'],
				'sort_order'	=> $result['sort_order']
			);
		}

		return $megamenu_data;
	}

	public function addCategoryMegamenu($data) {
		foreach ($data['module_megamenu_category'] as $category_id => $value) {
			$this->db->query("
				REPLACE INTO " . DB_PREFIX . "megamenu SET
				category_id = '" . (int)$category_id . "',
				content_type = '" . $this->db->escape($value['content_type']) . "',
				content_info = '" . (isset($value['content_info']) ?  (int)($value['content_info']) : 0) . "',
				sort_order = '" . (int)$value['sort_order'] . "'
			");
		}
	}
}