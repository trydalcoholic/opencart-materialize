<?php
class ModelExtensionMaterializeCatalogProduct extends Model {
	/* Update price */
	public function getUpdateOptionsList($product_id, $product_option_id) {
		$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($option_query->num_rows) {
			return $option_query->row;
		} else {
			return '';
		}
	}

	public function getUpdateOptionValues($value, $product_option_id) {
		$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($option_value_query->num_rows) {
			return $option_value_query->row;
		} else {
			return '';
		}
	}

	public function getUpdateOptionChcekboxValues($product_option_value_id, $product_option_id) {
		$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($option_value_query->num_rows) {
			return $option_value_query->row;
		} else {
			return '';
		}
	}

	public function getDiscountAmountForUpdatePrice($product_id, $quantity) {
		$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

		if ($product_discount_query->num_rows) {
			return $product_discount_query->row['price'];
		} else {
			return '';
		}
	}

	/* Live search */
	public function getProductsSearch($data = array()) {
		$sql = "SELECT p.product_id, pd.name";

		if (!empty($data['show_description'])) {
			$sql .= ", pd.description";
		}

		if (!empty($data['filter_image'])) {
			$sql .= ", p.image";
		}

		if (!empty($data['filter_price'])) {
			$sql .= " , p.price, p.tax_class_id, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";
		}

		if (!empty($data['filter_rating'])) {
			$sql .= ", (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews";
		}

		if (!empty($data['filter_manufacturer'])) {
			$sql .= ", m.name AS manufacturer";
			$manufacturer_join = " LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)";
		} else {
			$manufacturer_join = false;
		}

		if (!empty($data['filter_category_id'])) {
			$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id) LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) " . $manufacturer_join . "";
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p " . $manufacturer_join . "";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
		}

		$sql .= " AND (";

		$implode = array();

		$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

		foreach ($words as $word) {
			$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
		}

		if ($implode) {
			$sql .= " " . implode(" AND ", $implode) . "";
		}

		if (!empty($data['filter_description'])) {
			$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " OR p.model LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_sku'])) {
			$sql .= " OR p.sku LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_manufacturer'])) {
			$sql .= " OR m.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_tag'])) {
			$sql .= " OR ";

			$implode = array();

			$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

			foreach ($words as $word) {
				$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
			}

			if ($implode) {
				$sql .= " " . implode(" AND ", $implode) . "";
			}
		}

		$sql .= ")";

		$sql .= " GROUP BY (pd.name) ORDER BY LCASE(pd.name) ASC, LCASE(pd.name) ASC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 5;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
}