<?php
class ModelExtensionModuleMaterialize extends Model {
	public function getMaterializeColors() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "materialize_colors ORDER BY name ASC");

		return $query->rows;
	}

	public function getMaterializeColorsText() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "materialize_colors_text ORDER BY name ASC");

		return $query->rows;
	}
}