<?php
class ModelExtensionMaterializeMegamenu extends Model {
	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "megamenu` (
				`category_id` int(11) NOT NULL,
				`color` VARCHAR(25) NOT NULL,
				`color_text` VARCHAR(35) NOT NULL,
				`content_type` varchar(32) NOT NULL DEFAULT 'default',
				`content_info` varchar(255) NOT NULL DEFAULT '0',
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
				'color'			=> $result['color'],
				'color_text'	=> $result['color_text'],
				'content_type'	=> $result['content_type'],
				'content_info'	=> $result['content_info'],
				'sort_order'	=> $result['sort_order']
			);
		}

		return $megamenu_data;
	}

	public function getMegamenuImageByCategoryId($category_id) {
		$query = $this->db->query("SELECT content_info FROM " . DB_PREFIX . "megamenu WHERE category_id = '" . (int)$category_id . "'");

		if ($query->num_rows) {
			return $query->row['content_info'];
		} else {
			return 0;
		}
 	}

	public function editCategoryMegamenu($data) {
		foreach ($data['module_megamenu_category'] as $category_id => $value) {
			$this->db->query("
				REPLACE INTO " . DB_PREFIX . "megamenu SET
				category_id = '" . (int)$category_id . "',
				color = '" . $this->db->escape($value['color']) . "',
				color_text = '" . $this->db->escape($value['color_text']) . "',
				content_type = '" . $this->db->escape($value['content_type']) . "',
				content_info = '" . (isset($value['content_info']) ? $this->db->escape($value['content_info']) : 0) . "',
				sort_order = '" . (int)$value['sort_order'] . "'
			");

			$this->db->query("UPDATE " . DB_PREFIX . "category SET sort_order = '" . (int)$value['sort_order'] . "' WHERE category_id = '" . (int)$category_id . "'");
		}
	}
}