<?php
class ModelExtensionModuleMapMaterialize extends Model {
	public function getLocationImage($location_id) {
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "location WHERE location_id = '" . (int)$location_id . "'");

		return $query->row;
	}
}