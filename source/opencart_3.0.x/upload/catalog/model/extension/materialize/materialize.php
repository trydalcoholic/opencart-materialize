<?php
class ModelExtensionMaterializeMaterialize extends Model {
	public function getSocialLinks() {
		$query = $this->db->query("SELECT link FROM " . DB_PREFIX . "materialize_social_networks");

		return $query->rows;
	}

	public function getSocialIcons() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "materialize_social_networks WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY sort_order ASC");

		return $query->rows;
	}
}