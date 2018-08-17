<?php
class ModelExtensionModuleMaterialize extends Model {
	public function getColorScheme($scheme_id) {
		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "materialize_color_schemes WHERE scheme_id = '" . $this->db->escape($scheme_id) . "'");

		if ($query->num_rows) {
			return json_decode($query->row['value'], true);
		} else {
			return null;
		}
	}
}