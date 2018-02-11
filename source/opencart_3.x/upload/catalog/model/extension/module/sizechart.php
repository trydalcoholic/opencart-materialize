<?php
class ModelExtensionModuleSizechart extends Model {
	public function getSizechartByProductId($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_materialize_sizechart pms LEFT JOIN " . DB_PREFIX . "materialize_sizechart_description msd ON (pms.sizechart_id  = msd.sizechart_id) WHERE pms.product_id = '" . (int)$product_id . "'  AND msd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			return $query->row['description'];
		} else {
			return false;
		}

		return $query->rows;
	}
}