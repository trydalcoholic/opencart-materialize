<?php
class ModelExtensionModuleMegamenu extends Model {
	public function getMegamenuBannerIdByCategoryId($category_id) {
		$query = $this->db->query("SELECT banner_id FROM " . DB_PREFIX . "megamenu WHERE category_id = '" . (int)$category_id . "' AND megamenu = '1'");

		if ($query->num_rows) {
			return $query->row['banner_id'];
		} else {
			return 0;
		}
	}

	public function getMegamenuCategoryTypeByCategoryId($category_id) {
		$query = $this->db->query("SELECT type FROM " . DB_PREFIX . "megamenu WHERE category_id = '" . (int)$category_id . "' AND megamenu = '1'");

		if ($query->num_rows) {
			return $query->row['type'];
		} else {
			return 0;
		}
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