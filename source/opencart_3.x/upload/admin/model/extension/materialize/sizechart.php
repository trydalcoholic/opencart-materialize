<?php
class ModelExtensionMaterializeSizechart extends Model {
	public function addSizechart($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "materialize_sizechart_group` SET sort_order = '" . (int)$data['sort_order'] . "'");

		$sizechart_group_id = $this->db->getLastId();

		foreach ($data['sizechart_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_sizechart_group_description SET sizechart_group_id = '" . (int)$sizechart_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['sizechart'])) {
			foreach ($data['sizechart'] as $sizechart) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_sizechart SET sizechart_group_id = '" . (int)$sizechart_group_id . "', sort_order = '" . (int)$sizechart['sort_order'] . "'");

				$sizechart_id = $this->db->getLastId();

				foreach ($sizechart['sizechart_description'] as $language_id => $sizechart_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_sizechart_description SET sizechart_id = '" . (int)$sizechart_id . "', language_id = '" . (int)$language_id . "', sizechart_group_id = '" . (int)$sizechart_group_id . "', name = '" . $this->db->escape($sizechart_description['name']) . "', description = '" . $this->db->escape($sizechart_description['description']) . "'");
				}
			}
		}

		return $sizechart_group_id;
	}

	public function editSizechart($sizechart_group_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "materialize_sizechart_group` SET sort_order = '" . (int)$data['sort_order'] . "' WHERE sizechart_group_id = '" . (int)$sizechart_group_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "materialize_sizechart_group_description WHERE sizechart_group_id = '" . (int)$sizechart_group_id . "'");

		foreach ($data['sizechart_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_sizechart_group_description SET sizechart_group_id = '" . (int)$sizechart_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "materialize_sizechart WHERE sizechart_group_id = '" . (int)$sizechart_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "materialize_sizechart_description WHERE sizechart_group_id = '" . (int)$sizechart_group_id . "'");

		if (isset($data['sizechart'])) {
			foreach ($data['sizechart'] as $sizechart) {
				if ($sizechart['sizechart_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_sizechart SET sizechart_id = '" . (int)$sizechart['sizechart_id'] . "', sizechart_group_id = '" . (int)$sizechart_group_id . "', sort_order = '" . (int)$sizechart['sort_order'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_sizechart SET sizechart_group_id = '" . (int)$sizechart_group_id . "', sort_order = '" . (int)$sizechart['sort_order'] . "'");
				}

				$sizechart_id = $this->db->getLastId();

				foreach ($sizechart['sizechart_description'] as $language_id => $sizechart_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_sizechart_description SET sizechart_id = '" . (int)$sizechart_id . "', language_id = '" . (int)$language_id . "', sizechart_group_id = '" . (int)$sizechart_group_id . "', name = '" . $this->db->escape($sizechart_description['name']) . "', description = '" . $this->db->escape($sizechart_description['description']) . "'");
				}
			}
		}
	}

	public function deleteSizechart($sizechart_group_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "materialize_sizechart_group` WHERE sizechart_group_id = '" . (int)$sizechart_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "materialize_sizechart_group_description` WHERE sizechart_group_id = '" . (int)$sizechart_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "materialize_sizechart` WHERE sizechart_group_id = '" . (int)$sizechart_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "materialize_sizechart_description` WHERE sizechart_group_id = '" . (int)$sizechart_group_id . "'");
	}

	public function getSizechartGroup($sizechart_group_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "materialize_sizechart_group` msg LEFT JOIN " . DB_PREFIX . "materialize_sizechart_group_description msgd ON (msg.sizechart_group_id = msgd.sizechart_group_id) WHERE msg.sizechart_group_id = '" . (int)$sizechart_group_id . "' AND msgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getSizechartGroups($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "materialize_sizechart_group` msg LEFT JOIN " . DB_PREFIX . "materialize_sizechart_group_description msgd ON (msg.sizechart_group_id = msgd.sizechart_group_id) WHERE msgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'msgd.name',
			'msg.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY msgd.name";
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
	}

	public function getSizechartGroupDescriptions($sizechart_group_id) {
		$sizechart_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "materialize_sizechart_group_description WHERE sizechart_group_id = '" . (int)$sizechart_group_id . "'");

		foreach ($query->rows as $result) {
			$sizechart_group_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $sizechart_group_data;
	}

	public function getSizechart($sizechart_id) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "materialize_sizechart_group_description msgd WHERE ms.sizechart_group_id = msgd.sizechart_group_id AND msgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "materialize_sizechart ms LEFT JOIN " . DB_PREFIX . "materialize_sizechart_description msd ON (ms.sizechart_id = msd.sizechart_id) WHERE ms.sizechart_id = '" . (int)$sizechart_id . "' AND msd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getSizecharts($data) {
		$sql = "SELECT *, (SELECT name FROM " . DB_PREFIX . "materialize_sizechart_group_description msgd WHERE ms.sizechart_group_id = msgd.sizechart_group_id AND msgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "materialize_sizechart ms LEFT JOIN " . DB_PREFIX . "materialize_sizechart_description msd ON (ms.sizechart_id = msd.sizechart_id) WHERE msd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND msd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " ORDER BY ms.sort_order ASC";

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
	}

	public function getSizechartDescriptions($sizechart_group_id) {
		$sizechart_data = array();

		$sizechart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "materialize_sizechart WHERE sizechart_group_id = '" . (int)$sizechart_group_id . "'");

		foreach ($sizechart_query->rows as $sizechart) {
			$sizechart_description_data = array();

			$sizechart_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "materialize_sizechart_description WHERE sizechart_id = '" . (int)$sizechart['sizechart_id'] . "'");

			foreach ($sizechart_description_query->rows as $sizechart_description) {
				$sizechart_description_data[$sizechart_description['language_id']] = array(
					'name'			=> $sizechart_description['name'],
					'description'	=> $sizechart_description['description']
				);
			}

			$sizechart_data[] = array(
				'sizechart_id'			=> $sizechart['sizechart_id'],
				'sizechart_description'	=> $sizechart_description_data,
				'sort_order'			=> $sizechart['sort_order']
			);
		}

		return $sizechart_data;
	}

	public function getTotalSizechartGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "materialize_sizechart_group`");

		return $query->row['total'];
	}
}