<?php
class ModelExtensionMaterializeMegamenu extends Model {
	public function addCategoryMegamenu($data) {
		foreach ($data['module_megamenu_category'] as $category_id => $value) {
			$this->db->query("REPLACE INTO " . DB_PREFIX . "megamenu SET category_id = '" . (int)$category_id . "', megamenu = '" . $this->db->escape($value['megamenu']) . "', type = '" . $this->db->escape($value['type']) . "', banner_id = '" . $this->db->escape($value['banner_id']) . "'");
		}
	}

	public function getCategoryMegamenuByCategoryId($category_id) {
		$query = $this->db->query("SELECT megamenu FROM " . DB_PREFIX . "megamenu WHERE category_id = '" . (int)$category_id . "'");

		if ($query->num_rows) {
			return (int)$query->row['megamenu'];
		} else {
			return 0;
		}
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
				'megamenu'	=> $result['megamenu'],
				'type'		=> $result['type'],
				'banner_id'	=> $result['banner_id']
			);
		}

		return $megamenu_data;
	}
}