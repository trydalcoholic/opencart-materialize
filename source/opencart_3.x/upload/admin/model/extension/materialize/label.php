<?php
class ModelExtensionMaterializeLabel extends Model {
	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "materialize_label` (
				`label_id` INT(11) NOT NULL AUTO_INCREMENT,
				`label_color` VARCHAR(25) NOT NULL,
				`label_color_text` VARCHAR(35) NOT NULL,
				`sort_order` INT(3) NOT NULL,
				PRIMARY KEY (`label_id`)
			) ENGINE = MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "materialize_label_description` (
				`label_id` INT(11) NOT NULL,
				`language_id` INT(11) NOT NULL,
				`name` VARCHAR(20) NOT NULL,
				PRIMARY KEY (`label_id`, `language_id`)
			) ENGINE = MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_label` (
				`product_id` INT(11) NOT NULL,
				`label_id` INT(11) NOT NULL,
				PRIMARY KEY (`product_id`,`label_id`)
			) ENGINE = MyISAM;
		");
	}

	public function uninstall() {
		$this->db->query("
			DROP TABLE IF EXISTS
				`" . DB_PREFIX . "materialize_label`,
				`" . DB_PREFIX . "materialize_label_description`,
				`" . DB_PREFIX . "product_label`
			;
		");
	}

	public function addLabel($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_label SET label_color = '" . $this->db->escape($data['label_color']) . "', label_color_text = '" . $this->db->escape($data['label_color_text']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$label_id = $this->db->getLastId();

		foreach ($data['label_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_label_description SET label_id = '" . (int)$label_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		return $label_id;
	}

	public function editLabel($label_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "materialize_label SET label_color = '" . $this->db->escape($data['label_color']) . "', label_color_text = '" . $this->db->escape($data['label_color_text']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE label_id = '" . (int)$label_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "materialize_label_description WHERE label_id = '" . (int)$label_id . "'");

		foreach ($data['label_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_label_description SET label_id = '" . (int)$label_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
	}

	public function deleteLabel($label_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "materialize_label WHERE label_id = '" . (int)$label_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "materialize_label_description WHERE label_id = '" . (int)$label_id . "'");
	}

	public function getLabel($label_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "materialize_label WHERE label_id = '" . (int)$label_id . "'");

		return $query->row;
	}

	public function getLabels($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "materialize_label ml LEFT JOIN " . DB_PREFIX . "materialize_label_description mld ON (ml.label_id = mld.label_id) WHERE mld.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'mld.name',
				'ml.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY mld.name";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
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

			return $query->rows;
		} else {
			$label_data = array();

			$query = $this->db->query("SELECT label_id, name FROM " . DB_PREFIX . "materialize_label_description WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

			$label_data = $query->rows;

			return $label_data;
		}
	}

	public function getLabelDescriptions($label_id) {
		$label_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "materialize_label_description WHERE label_id = '" . (int)$label_id . "'");

		foreach ($query->rows as $result) {
			$label_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $label_data;
	}

	public function getTotalLabels() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "materialize_label");

		return $query->row['total'];
	}
}