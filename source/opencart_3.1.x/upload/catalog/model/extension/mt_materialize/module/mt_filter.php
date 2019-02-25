<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ModelExtensionMTMaterializeModuleMTFilter extends Model {
	public function getCategoryStatus($category_id) {
		$query = $this->db->query("SELECT status, COUNT(DISTINCT p2c.product_id) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.category_id = c.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1' LIMIT 1");

		if ($query->row['status'] && $query->row['total']) {
			return true;
		} else {
			return false;
		}
	}

	public function getMinMaxPrice($data) {
		/* Sample sql query
		SELECT
		  MIN(IF(tp.tax_percent IS NOT NULL, IFNULL(ps.price, p.price) + (IFNULL(ps.price, p.price) * tp.tax_percent / 100) + IFNULL(ta.tax_amount, 0), IFNULL(ps.price, p.price)) * 0.78460002) AS min_price_eur,
		  MAX(IF(tp.tax_percent IS NOT NULL, IFNULL(ps.price, p.price) + (IFNULL(ps.price, p.price) * tp.tax_percent / 100) + IFNULL(ta.tax_amount, 0), IFNULL(ps.price, p.price)) * 0.78460002) AS max_price_eur,
		  MIN(IF(tp.tax_percent IS NOT NULL, IFNULL(ps.price, p.price) + (IFNULL(ps.price, p.price) * tp.tax_percent / 100) + IFNULL(ta.tax_amount, 0), IFNULL(ps.price, p.price)) * 1) AS min_price_usd,
		  MAX(IF(tp.tax_percent IS NOT NULL, IFNULL(ps.price, p.price) + (IFNULL(ps.price, p.price) * tp.tax_percent / 100) + IFNULL(ta.tax_amount, 0), IFNULL(ps.price, p.price)) * 1) AS max_price_usd
		FROM oc_product p
		  LEFT JOIN oc_product_to_category p2c ON (p.product_id = p2c.product_id)
		  LEFT JOIN oc_product_to_store p2s ON (p.product_id = p2s.product_id)
		  LEFT JOIN (SELECT product_id, price FROM oc_product_special ps WHERE ps.customer_group_id = '1' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS ps ON (p.product_id = ps.product_id)
		  LEFT JOIN (
			SELECT
			  tr2.tax_class_id, tr1.rate AS tax_percent
			FROM oc_tax_rate tr1
			  INNER JOIN oc_tax_rate_to_customer_group tr2cg ON (tr1.tax_rate_id = tr2cg.tax_rate_id)
			  LEFT JOIN oc_tax_rule tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id)
			WHERE tr1.type = 'P' AND tr2cg.customer_group_id = '1' ORDER BY tr2.priority
		  ) AS tp ON (p.tax_class_id = tp.tax_class_id)
		  LEFT JOIN (
			SELECT
			  tr2.tax_class_id, tr1.rate AS tax_amount
			FROM oc_tax_rate tr1
			  INNER JOIN oc_tax_rate_to_customer_group tr2cg ON (tr1.tax_rate_id = tr2cg.tax_rate_id)
			  LEFT JOIN oc_tax_rule tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id)
			WHERE tr1.type = 'F' AND tr2cg.customer_group_id = '1' ORDER BY tr2.priority
		  ) AS ta ON (p.tax_class_id = ta.tax_class_id)
		WHERE p2c.category_id = '20' AND p.date_available <= NOW() AND p.status = '1' AND p2s.store_id = '0'
		*/ /* todo-materialize Remove before release! */
		if (!empty($data['config_tax'])) {
			$sql = "SELECT MIN(IF(tp.tax_percent IS NOT NULL, IFNULL(ps.price, p.price) + (IFNULL(ps.price, p.price) * tp.tax_percent / 100) + IFNULL(ta.tax_amount, 0), IFNULL(ps.price, p.price)) * '" . (float)$data['currency_ratio'] . "') AS min_price, MAX(IF(tp.tax_percent IS NOT NULL, IFNULL(ps.price, p.price) + (IFNULL(ps.price, p.price) * tp.tax_percent / 100) + IFNULL(ta.tax_amount, 0), IFNULL(ps.price, p.price)) * '" . (float)$data['currency_ratio'] . "') AS max_price";
		} else {
			$sql = "SELECT MIN(IFNULL(ps.price, p.price) * '" . (float)$data['currency_ratio'] . "') AS min_price, MAX(IFNULL(ps.price, p.price) * '" . (float)$data['currency_ratio'] . "') AS max_price";
		}

		$sql .= " FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN (SELECT product_id, price FROM " . DB_PREFIX . "product_special ps WHERE ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS ps ON (p.product_id = ps.product_id)";

		if (!empty($data['config_tax'])) {
			$sql .= " LEFT JOIN (SELECT tr2.tax_class_id, tr1.rate AS tax_percent FROM " . DB_PREFIX . "tax_rate tr1 INNER JOIN " . DB_PREFIX . "tax_rate_to_customer_group tr2cg ON (tr1.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN " . DB_PREFIX . "tax_rule tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) WHERE tr1.type = 'P' AND tr2cg.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY tr2.priority) AS tp ON (p.tax_class_id = tp.tax_class_id) LEFT JOIN (SELECT tr2.tax_class_id, tr1.rate AS tax_amount FROM " . DB_PREFIX . "tax_rate tr1 INNER JOIN " . DB_PREFIX . "tax_rate_to_customer_group tr2cg ON (tr1.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN " . DB_PREFIX . "tax_rule tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) WHERE tr1.type = 'F' AND tr2cg.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY tr2.priority) AS ta ON (p.tax_class_id = ta.tax_class_id)";
		}

		$sql .= " WHERE p.date_available <= NOW() AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['category_id'])) {
			$sql .= " AND p2c.category_id = '" . (int)$data['category_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getSubCategories($data) {
		$sql = "SELECT c.category_id, cd.name";

		if (!empty($data['image'])) {
			$sql .= ", c.image";
		}

		$sql .= " FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.parent_id = '" . (int)$data['category_id'] . "' AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getSubCategoriesByFilter($data) {
		$sql = "SELECT c.category_id, cd.name";

		if (!empty($data['image'])) {
			$sql .= ", c.image";
		}

		$sql .= " FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id IN (";

		$implode = [];

		foreach ($data['categories_id'] as $category_id) {
			$implode[] = "'" . (int)$category_id . "'";
		}

		$sql .= implode(",", $implode) . ") AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, LCASE(cd.name)";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getDefaultFilters($category_id) {
		$implode = [];

		$query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$implode[] = (int)$result['filter_id'];
		}

		$filter_group_data = [];

		if ($implode) {
			$filter_group_query = $this->db->query("SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");

			foreach ($filter_group_query->rows as $filter_group) {
				$filter_data = [];

				$filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");

				foreach ($filter_query->rows as $filter) {
					$filter_data[] = [
						'filter_id'	=> $filter['filter_id'],
						'name'		=> $filter['name']
					];
				}

				if ($filter_data) {
					$filter_group_data[] = [
						'filter_group_id'	=> $filter_group['filter_group_id'],
						'name'				=> $filter_group['name'],
						'filter'			=> $filter_data
					];
				}
			}
		}

		return $filter_group_data;
	}

	public function getDefaultFiltersByFilter($data) {
		$sql = "SELECT f.filter_id, fd.filter_group_id, fgd.name AS name, fd.name AS text FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (";

		$implode = [];

		foreach ($data as $filter_id) {
			$implode[] = "'" . (int)$filter_id . "'";
		}

		$sql .= implode(",", $implode) . ") AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY fg.sort_order, LCASE(fgd.name), f.sort_order, LCASE(fd.name)";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getManufacturers($data) {
		$manufacturer_data = [];

		$sql = "SELECT p.manufacturer_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";

		if (!empty($data['category_id'])) {
			$sql .= " WHERE p2c.category_id = '" . (int)$data['category_id'] . "'";
		}

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$manufacturer_data[] = (int)$result['manufacturer_id'];
		}

		if ($manufacturer_data) {
			$sql = "SELECT m.manufacturer_id, m.name";

			if (!empty($data['image'])) {
				$sql .= ", m.image";
			}

			$sql .= " FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m.manufacturer_id IN (" . implode(',', $manufacturer_data) . ") AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY m.sort_order ASC LIMIT " . (int)count($manufacturer_data);

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			return false;
		}
	}

	public function getManufacturersByFilter($data) {
		$sql = "SELECT m.manufacturer_id, m.name";

		if (!empty($data['image'])) {
			$sql .= ", m.image";
		}

		$sql .= " FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m.manufacturer_id IN (";

		$implode = [];

		foreach ($data['manufacturers_id'] as $manufacturer_id) {
			$implode[] = "'" . (int)$manufacturer_id . "'";
		}

		$sql .= implode(",", $implode) . ") AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY m.sort_order ASC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAttributes($category_id) {
		$sql = "SELECT DISTINCT pa.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id)";

		if (!empty($category_id)) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (pa.product_id = p2c.product_id)";
		}

		$sql .= " WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($category_id)) {
			$sql .= " AND p2c.category_id = '" . (int)$category_id . "'";
		}

		$sql .= " ORDER BY a.sort_order, LCASE(name)";

		$query = $this->db->query($sql);

		$attributes_data = $query->rows;

		return $attributes_data;
	}

	public function getAttributesByFilter($data) {
		$sql = "SELECT a.attribute_id, ad.name FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE a.attribute_id IN (";

		$implode = [];

		foreach ($data as $key => $value) {
			$implode[] = "'" . (int)$key . "'";
		}

		$sql .= "" . implode(",", $implode) . ") AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, LCASE(ad.name)";

		$query = $this->db->query($sql);

		$attributes_names = [];

		foreach ($query->rows as $result) {
			$attributes_names[$result['attribute_id']] = $result['name'];
		}

		$attributes_data = [];

		foreach ($data as $key => $value) {
			$attributes = explode(',', $value);

			foreach ($attributes as $text) {
				$attributes_data[] = [
					'attribute_id'	=> (int)$key,
					'name'			=> (string)$attributes_names[$key],
					'text'			=> (string)$text
				];
			}
		}

		return $attributes_data;
	}

	public function getOptions($data) {
		$option_data = [];

		$sql = "SELECT o.option_id, od.name, o.type, o.sort_order FROM " . DB_PREFIX . "option o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) LEFT JOIN " . DB_PREFIX . "product_option po ON (o.option_id = po.option_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (po.product_id = p2c.product_id) WHERE od.language_id = '" . (int)$this->config->get('config_language_id') . "' AND (o.type = 'radio' OR o.type = 'checkbox' OR o.type = 'select')";

		if (!empty($data['category_id'])) {
			$sql .= " AND p2c.category_id = '" . (int)$data['category_id'] . "'";
		}

		$sql .= " ORDER BY o.sort_order";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$option_value_data = [];

			$sql = "SELECT ov.option_value_id, ovd.name, ov.sort_order";

			if ($data['image']) {
				$sql .= ", ov.image";
			}

			$sql .= " FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (ov.option_value_id = pov.option_value_id) WHERE ov.option_id = '" . (int)$result['option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pov.quantity > '0' ORDER BY ov.sort_order";

			$option_value_data_query = $this->db->query($sql);

			foreach ($option_value_data_query->rows as $option_value) {
				$option_value_data[$option_value['name']] = [
					'option_value_id'	=> (int)$option_value['option_value_id'],
					'name'				=> $option_value['name'],
					'image'				=> $data['image'] ? $option_value['image'] : false,
					'sort_order'		=> (int)$option_value['sort_order']
				];
			}

			$option_data[$result['name']] = [
				'option_id'			=> (int)$result['option_id'],
				'name'				=> $result['name'],
				'type'				=> $result['type'],
				'sort_order'		=> (int)$result['sort_order'],
				'option_value_data'	=> $option_value_data
			];
		}

		return $option_data;
	}

	public function getOptionsByFilter($data) {
		$sql = "SELECT o.option_id, od.name AS name, ov.option_value_id, ovd.name AS text";

		if ($data['image']) {
			$sql .= ", ov.image";
		}

		$sql .= " FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) LEFT JOIN " . DB_PREFIX . "option o ON (ov.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE ov.option_value_id IN (";

		$implode = [];

		foreach ($data['option_values_id'] as $key => $option_values_id) {
			foreach ($option_values_id as $option_value) {
				$implode[] = "'" . (int)$option_value . "'";
			}
		}

		$sql .= implode(",", $implode) . ") AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order, LCASE(od.name), ov.sort_order, LCASE(ovd.name)";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getStockStatuses() {
		$query = $this->db->query("SELECT stock_status_id, name FROM " . DB_PREFIX . "stock_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

		return $query->rows;
	}

	public function getStockStatusesByFilter($data) {
		$sql = "SELECT stock_status_id, name FROM " . DB_PREFIX . "stock_status WHERE stock_status_id IN (";

		$implode = [];

		foreach ($data as $stock_status_id) {
			$implode[] = "'" . (int)$stock_status_id . "'";
		}

		$sql .= implode(",", $implode) . ") AND language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getProducts($data = []) {
		$mt_filtering_settings = $this->mtFilteringSettings();

		$sql = "SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN (SELECT product_id, price FROM " . DB_PREFIX . "product_special ps WHERE ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id ORDER BY ps.priority ASC, ps.price ASC";

		if (!empty($data['product_special_filter'])) {
			$sql .= " ) AS ps ON (p.product_id = ps.product_id)";
		} else {
			$sql .= " LIMIT 1) AS ps ON (p.product_id = ps.product_id)";
		}

		if (!empty($data['keyword_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

			if (in_array('manufacturers', $mt_filtering_settings['filters']['keyword'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)";
			}
		}

		if (!empty($data['default_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pdf ON (p.product_id = pdf.product_id)";
		}

		if (!empty($data['attribute_filter'])) {
			/* A simple example for properly filtering attributes.
			SELECT DISTINCT
			  p2c.product_id
			FROM
			  oc_product_to_category p2c
			  LEFT JOIN oc_product_attribute pa2 ON (pa2.product_id = p2c.product_id)
			  LEFT JOIN oc_product_attribute pa4 ON (pa4.product_id = p2c.product_id)
			WHERE
			  pa2.attribute_id = '2' AND (pa2.text = '1' OR pa2.text = '4')
			  AND
			  pa4.attribute_id = '4' AND (pa4.text = '8gb' OR pa4.text = '16gb')
			*/ /* todo-materialize Remove before release! */
			foreach ($data['attribute_filter'] as $key => $value) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute pa" . (int)$key . " ON (p.product_id = pa" . (int)$key . ".product_id)";
			}
		}

		if (!empty($data['option_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (p.product_id = pov.product_id)";
		}

		if (!empty($data['rating_filter'])) {
			$sql .= " LEFT JOIN (SELECT product_id, AVG(rating) AS rating FROM " . DB_PREFIX . "review WHERE status = '1' GROUP BY product_id) AS r1 ON (p.product_id = r1.product_id)";
		}

		if (!empty($data['review_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "review r2 ON (p.product_id = r2.product_id)";
		}

		if (!empty($data['config_tax'])) {
			$sql .= " LEFT JOIN (SELECT tr2.tax_class_id, tr1.rate AS tax_percent FROM " . DB_PREFIX . "tax_rate tr1 INNER JOIN " . DB_PREFIX . "tax_rate_to_customer_group tr2cg ON (tr1.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN " . DB_PREFIX . "tax_rule tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) WHERE tr1.type = 'P' AND tr2cg.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY tr2.priority) AS tp ON (p.tax_class_id = tp.tax_class_id) LEFT JOIN (SELECT tr2.tax_class_id, tr1.rate AS tax_amount FROM " . DB_PREFIX . "tax_rate tr1 INNER JOIN " . DB_PREFIX . "tax_rate_to_customer_group tr2cg ON (tr1.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN " . DB_PREFIX . "tax_rule tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) WHERE tr1.type = 'F' AND tr2cg.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY tr2.priority) AS ta ON (p.tax_class_id = ta.tax_class_id)";
		}

		$sql .= " WHERE p.date_available <= NOW() AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['keyword_filter']) && !empty($mt_filtering_settings)) {
			$or = false;

			$sql .= " AND (";

			if (in_array('product_name', $mt_filtering_settings['filters']['keyword'])) {
				$sql .= "(";

				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['keyword_filter'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				$sql .= ")";

				$or = true;
			}

			if (in_array('product_description', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "pd.description LIKE '%" . $this->db->escape((string)$data['keyword_filter']) . "%'";

				$or = true;
			}

			if (in_array('product_meta_title', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "pd.meta_title LIKE '%" . $this->db->escape((string)$data['keyword_filter']) . "%'";

				$or = true;
			}

			if (in_array('product_meta_description', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "pd.meta_description LIKE '%" . $this->db->escape((string)$data['keyword_filter']) . "%'";

				$or = true;
			}

			if (in_array('product_meta_keywords', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "pd.meta_keyword LIKE '%" . $this->db->escape((string)$data['keyword_filter']) . "%'";

				$or = true;
			}

			if (in_array('product_tags', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR (";
				}

				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['keyword_filter'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if ($or) {
					$sql .= ")";
				}

				$or = true;
			}

			if (in_array('field_model', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_sku', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_upc', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_ean', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_jan', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_isbn', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_mpn', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_dimensions', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "p.length = '" . (float)$data['keyword_filter'] . "'";
				$sql .= " OR p.width = '" . (float)$data['keyword_filter'] . "'";
				$sql .= " OR p.height = '" . (float)$data['keyword_filter'] . "'";

				$or = true;
			}

			if (in_array('field_weight', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "p.weight = '" . (float)$data['keyword_filter'] . "'";

				$or = true;
			}

			if (in_array('manufacturers', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "m.name LIKE '%" . $this->db->escape((string)$data['keyword_filter']) . "%'";

				$or = true;
			}

			$sql .= ")";
		}

		if (!empty($data['sub_category_filter'])) {
			$sql .= " AND p2c.category_id IN (";

			$implode = [];

			foreach ($data['sub_category_filter'] as $category_id) {
				$implode[] = "'" . (int)$category_id . "'";
			}

			$sql .= implode(",", $implode) . ")";
		} elseif (!empty($data['category_id'])) {
			$sql .= " AND p2c.category_id = '" . (int)$data['category_id'] . "'";
		}

		if (!empty($data['default_filter'])) {
			$sql .= " AND pdf.filter_id IN (";

			$implode = [];

			foreach ($data['default_filter'] as $default_filter_id) {
				$implode[] = "'" . (int)$default_filter_id . "'";
			}

			$sql .= implode(",", $implode) . ")";
		}

		if (!empty($data['attribute_filter'])) {
			foreach ($data['attribute_filter'] as $key => $value) {
				$sql .= " AND (pa" . (int)$key . ".attribute_id = '" . (int)$key . "'";

				$implode = [];

				$filters = explode(',', $value);

				foreach ($filters as $text) {
					$implode[] = "pa" . (int)$key . ".text = '" . $this->db->escape((string)$text) . "'";
				}

				$sql .= " AND (" . implode(' OR ', $implode) . "))";
			}
		}

		if (!empty($data['option_filter'])) {
			$sql .= " AND (";

			$implode = [];

			foreach ($data['option_filter'] as $option_id => $option_values_id) {
				foreach ($option_values_id as $option_value_id) {
					$implode[] = "(pov.option_value_id = '" . (int)$option_value_id . "')";
				}
			}

			$sql .= implode(' OR ', $implode);

			$sql .= ")";
		}

		if (!empty($data['manufacturer_filter'])) {
			$sql .= " AND p.manufacturer_id IN (";

			$implode = [];

			foreach ($data['manufacturer_filter'] as $manufacturer_id) {
				$implode[] = "'" . (int)$manufacturer_id . "'";
			}

			$sql .= implode(",", $implode) . ")";
		}

		if (!empty($data['rating_filter'])) {
			$implode = [];

			$sql .= " AND (";

			foreach ($data['rating_filter'] as $rating) {
				$implode[] = "ROUND(r1.rating) = '" . (int)$rating . "'";
			}

			if ($implode) {
				$sql .= " " . implode(" OR ", $implode) . "";
			}

			$sql .= ")";
		}

		if (!empty($data['review_filter'])) {
			$sql .= " AND r2.status = '1'";
		}

		if (!empty($data['stock_status_filter'])) {
			$sql .= " AND ((p.quantity > '0' AND '" . $data['stock_status_default'] . "' IN(";

			$implode = [];

			foreach ($data['stock_status_filter'] as $stock_status_id) {
				$implode[] = "'" . (int)$stock_status_id . "'";
			}

			$sql .= implode(",", $implode) . ")) OR (p.quantity <= '0' AND p.stock_status_id IN(" . implode(",", $implode) . ")))";
		}

		if (!empty($data['product_special_filter'])) {
			$sql .= " AND ps.product_id = p.product_id";
		}

		if (isset($data['min_price']) && !empty($data['max_price'])) {
			if (!empty($data['config_tax'])) {
				$sql .= " AND ((IF(tp.tax_percent IS NOT NULL, IFNULL(ps.price, p.price) + (IFNULL(ps.price, p.price) * tp.tax_percent / 100) + IFNULL(ta.tax_amount, 0), IFNULL(ps.price, p.price)) * '" . (float)$data['currency_ratio'] . "') BETWEEN '" . (float)$data['min_price'] . "' AND '" . (float)$data['max_price'] . "')";
			} else {
				$sql .= " AND ((IFNULL(ps.price, p.price) * '" . (float)$data['currency_ratio'] . "') BETWEEN '" . (float)$data['min_price'] . "' AND '" . (float)$data['max_price'] . "')";
			}
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$check_sql = $sql; /* todo-materialize Remove this */

		$query = $this->db->query($sql);

		$implode_products = [];

		foreach ($query->rows as $result) {
			$implode_products[(int)$result['product_id']] = (int)$result['product_id'];
		}

		$count_implode_products = (int)count($implode_products);

		$implode_products_implode = implode("','", $implode_products);

		if ($implode_products) {
			/* todo-materialize Get "stock status" depending on the settings of the "labels" in the admin panel. Otherwise "(SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status," should not be used in the sql query */
			$sql = "SELECT p.product_id, p.quantity, p.stock_status_id, p.image, p.price, p.tax_class_id, p.subtract, p.minimum, pd.name, pd.description, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id IN ('" . $implode_products_implode . "')";

			$sql .= " GROUP BY p.product_id";

			$sort_data = [
				'pd.name',
				'p.model',
				'p.quantity',
				'p.price',
				'rating',
				'p.sort_order',
				'p.date_added'
			];

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} elseif ($data['sort'] == 'p.price') {
					$sql .= " ORDER BY IFNULL(special, p.price)";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.sort_order";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC, LCASE(pd.name) DESC";
			} else {
				$sql .= " ASC, LCASE(pd.name) ASC";
			}

			$sql .= " LIMIT " . (int)$count_implode_products;

			$query = $this->db->query($sql);

			$products = [
				'query'		=> $query->rows,
				'check_sql'	=> $check_sql
			];
			return $products;
		} else {
			return false;
		}
	}

	public function getTotalProducts($data = []) {
		$mt_filtering_settings = $this->mtFilteringSettings();

		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN (SELECT product_id, price FROM " . DB_PREFIX . "product_special ps WHERE ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id ORDER BY ps.priority ASC, ps.price ASC";

		if (!empty($data['product_special_filter'])) {
			$sql .= " ) AS ps ON (p.product_id = ps.product_id)";
		} else {
			$sql .= " LIMIT 1) AS ps ON (p.product_id = ps.product_id)";
		}

		if (!empty($data['keyword_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

			if (in_array('manufacturers', $mt_filtering_settings['filters']['keyword'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)";
			}
		}

		if (!empty($data['default_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pdf ON (p.product_id = pdf.product_id)";
		}

		if (!empty($data['attribute_filter'])) {
			foreach ($data['attribute_filter'] as $key => $value) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute pa" . (int)$key . " ON (p.product_id = pa" . (int)$key . ".product_id)";
			}
		}

		if (!empty($data['option_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (p.product_id = pov.product_id)";
		}

		if (!empty($data['rating_filter'])) {
			$sql .= " LEFT JOIN (SELECT product_id, AVG(rating) AS rating FROM " . DB_PREFIX . "review WHERE status = '1' GROUP BY product_id) AS r1 ON (p.product_id = r1.product_id)";
		}

		if (!empty($data['review_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "review r2 ON (p.product_id = r2.product_id)";
		}

		if (!empty($data['config_tax'])) {
			$sql .= " LEFT JOIN (SELECT tr2.tax_class_id, tr1.rate AS tax_percent FROM " . DB_PREFIX . "tax_rate tr1 INNER JOIN " . DB_PREFIX . "tax_rate_to_customer_group tr2cg ON (tr1.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN " . DB_PREFIX . "tax_rule tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) WHERE tr1.type = 'P' AND tr2cg.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY tr2.priority) AS tp ON (p.tax_class_id = tp.tax_class_id) LEFT JOIN (SELECT tr2.tax_class_id, tr1.rate AS tax_amount FROM " . DB_PREFIX . "tax_rate tr1 INNER JOIN " . DB_PREFIX . "tax_rate_to_customer_group tr2cg ON (tr1.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN " . DB_PREFIX . "tax_rule tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) WHERE tr1.type = 'F' AND tr2cg.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY tr2.priority) AS ta ON (p.tax_class_id = ta.tax_class_id)";
		}

		$sql .= " WHERE p.date_available <= NOW() AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['keyword_filter']) && !empty($mt_filtering_settings)) {
			$or = false;

			$sql .= " AND (";

			if (in_array('product_name', $mt_filtering_settings['filters']['keyword'])) {
				$sql .= "(";

				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['keyword_filter'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				$sql .= ")";

				$or = true;
			}

			if (in_array('product_description', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "pd.description LIKE '%" . $this->db->escape((string)$data['keyword_filter']) . "%'";

				$or = true;
			}

			if (in_array('product_meta_title', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "pd.meta_title LIKE '%" . $this->db->escape((string)$data['keyword_filter']) . "%'";

				$or = true;
			}

			if (in_array('product_meta_description', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "pd.meta_description LIKE '%" . $this->db->escape((string)$data['keyword_filter']) . "%'";

				$or = true;
			}

			if (in_array('product_meta_keywords', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "pd.meta_keyword LIKE '%" . $this->db->escape((string)$data['keyword_filter']) . "%'";

				$or = true;
			}

			if (in_array('product_tags', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR (";
				}

				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['keyword_filter'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if ($or) {
					$sql .= ")";
				}

				$or = true;
			}

			if (in_array('field_model', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_sku', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_upc', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_ean', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_jan', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_isbn', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_mpn', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['keyword_filter'])) . "'";

				$or = true;
			}

			if (in_array('field_dimensions', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "p.length = '" . (float)$data['keyword_filter'] . "'";
				$sql .= " OR p.width = '" . (float)$data['keyword_filter'] . "'";
				$sql .= " OR p.height = '" . (float)$data['keyword_filter'] . "'";

				$or = true;
			}

			if (in_array('field_weight', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "p.weight = '" . (float)$data['keyword_filter'] . "'";

				$or = true;
			}

			if (in_array('manufacturers', $mt_filtering_settings['filters']['keyword'])) {
				if ($or) {
					$sql .= " OR ";
				}

				$sql .= "m.name LIKE '%" . $this->db->escape((string)$data['keyword_filter']) . "%'";

				$or = true;
			}

			$sql .= ")";
		}

		if (!empty($data['sub_category_filter'])) {
			$sql .= " AND p2c.category_id IN (";

			$implode = [];

			foreach ($data['sub_category_filter'] as $category_id) {
				$implode[] = "'" . (int)$category_id . "'";
			}
			$sql .= implode(",", $implode) . ")";
		} else {
			$sql .= " AND p2c.category_id = '" . (int)$data['category_id'] . "'";
		}

		if (!empty($data['default_filter'])) {
			$sql .= " AND pdf.filter_id IN (";

			$implode = [];

			foreach ($data['default_filter'] as $default_filter_id) {
				$implode[] = "'" . (int)$default_filter_id . "'";
			}

			$sql .= implode(",", $implode) . ")";
		}

		if (!empty($data['attribute_filter'])) {
			foreach ($data['attribute_filter'] as $key => $value) {
				$sql .= " AND (pa" . (int)$key . ".attribute_id = '" . (int)$key . "'";

				$implode = [];

				$filters = explode(',', $value);

				foreach ($filters as $text) {
					$implode[] = "pa" . (int)$key . ".text = '" . $this->db->escape((string)$text) . "'";
				}

				$sql .= " AND (" . implode(' OR ', $implode) . "))";
			}
		}

		if (!empty($data['option_filter'])) {
			$sql .= " AND (";

			$implode = [];

			foreach ($data['option_filter'] as $option_id => $option_values_id) {
				foreach ($option_values_id as $option_value_id) {
					$implode[] = "(pov.option_value_id = '" . (int)$option_value_id . "')";
				}
			}

			$sql .= implode(' OR ', $implode);

			$sql .= ")";
		}

		if (!empty($data['manufacturer_filter'])) {
			$sql .= " AND p.manufacturer_id IN (";

			$implode = [];

			foreach ($data['manufacturer_filter'] as $manufacturer_id) {
				$implode[] = "'" . (int)$manufacturer_id . "'";
			}

			$sql .= implode(",", $implode) . ")";
		}

		if (!empty($data['rating_filter'])) {
			$implode = [];

			$sql .= " AND (";

			foreach ($data['rating_filter'] as $rating) {
				$implode[] = "ROUND(r1.rating) = '" . (int)$rating . "'";
			}

			if ($implode) {
				$sql .= " " . implode(" OR ", $implode) . "";
			}

			$sql .= ")";
		}

		if (!empty($data['review_filter'])) {
			$sql .= " AND r2.status = '1'";
		}

		if (!empty($data['stock_status_filter'])) {
			$sql .= " AND ((p.quantity > '0' AND '" . $data['stock_status_default'] . "' IN(";

			$implode = [];

			foreach ($data['stock_status_filter'] as $stock_status_id) {
				$implode[] = "'" . (int)$stock_status_id . "'";
			}

			$sql .= implode(",", $implode) . ")) OR (p.quantity <= '0' AND p.stock_status_id IN(" . implode(",", $implode) . ")))";
		}

		if (!empty($data['product_special_filter'])) {
			$sql .= " AND ps.product_id = p.product_id";
		}

		if (isset($data['min_price']) && !empty($data['max_price'])) {
			if (!empty($data['config_tax'])) {
				$sql .= " AND ((IF(tp.tax_percent IS NOT NULL, IFNULL(ps.price, p.price) + (IFNULL(ps.price, p.price) * tp.tax_percent / 100) + IFNULL(ta.tax_amount, 0), IFNULL(ps.price, p.price)) * '" . (float)$data['currency_ratio'] . "') BETWEEN '" . (float)$data['min_price'] . "' AND '" . (float)$data['max_price'] . "')";
			} else {
				$sql .= " AND ((IFNULL(ps.price, p.price) * '" . (float)$data['currency_ratio'] . "') BETWEEN '" . (float)$data['min_price'] . "' AND '" . (float)$data['max_price'] . "')";
			}
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	protected function mtFilteringSettings() {
		$mt_filtering_settings = $this->cache->get('materialize.mt_filtering.settings.' . (int)$this->config->get('config_store_id'));

		if (!$mt_filtering_settings) {
			$mt_filter_settings = $this->config->get('module_mt_filter_settings');
			$mt_filtering_settings = $this->config->get('module_mt_filtering_settings');

			if (!empty($mt_filter_settings['cache']['status'])) {
				$this->cache->set('materialize.mt_filtering.settings.' . (int)$this->config->get('config_store_id'), $mt_filtering_settings);
			}
		}

		return $mt_filtering_settings;
	}
}