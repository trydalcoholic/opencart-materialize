<?php
class ModelExtensionMaterializeCallback extends Model {
	public function editMaterializeCallback($callback_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "materialize_callback SET telephone = '" . $this->db->escape($data['telephone']) . "', name = '" . $this->db->escape($data['name']) . "', enquiry = '" . $this->db->escape($data['enquiry']) . "', call_time = '" . $this->db->escape($data['call_time']) . "', status = '" . (int)$data['status'] . "' WHERE callback_id = '" . (int)$callback_id . "'");
	}

	public function deleteMaterializeCallback($callback_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "materialize_callback WHERE callback_id = '" . (int)$callback_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "materialize_callback_history WHERE callback_id = '" . (int)$callback_id . "'");
	}

	public function getMaterializeCallback($callback_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "materialize_callback WHERE callback_id = '" . (int)$callback_id . "'");

		return $query->row;
	}

	public function getMaterializeCallbacks($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "materialize_callback";

		$implode = array();

		if (isset($data['filter_id']) && $data['filter_id'] !== '') {
			$implode[] = "callback_id = '" . (int)$data['filter_id'] . "'";
		}

		if (!empty($data['filter_telephone'])) {
			$implode[] = "telephone LIKE '%" . $this->db->escape($data['filter_telephone']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_ip']) && $data['filter_ip'] !== '') {
			$implode[] = "ip = '" . $this->db->escape($data['filter_ip']) . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'callback_id',
			'telephone',
			'name',
			'status',
			'ip',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY callback_id";
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

	public function getMaterializeTotalCallbacks($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "materialize_callback";

		$implode = array();

		if (isset($data['filter_id']) && $data['filter_id'] !== '') {
			$implode[] = "callback_id = '" . (int)$data['filter_id'] . "'";
		}

		if (!empty($data['filter_telephone'])) {
			$implode[] = "telephone LIKE '%" . $this->db->escape($data['filter_telephone']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_ip']) && $data['filter_ip'] !== '') {
			$implode[] = "ip = '" . $this->db->escape($data['filter_ip']) . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function addMaterializeHistory($callback_id, $comment) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_callback_history SET callback_id = '" . (int)$callback_id . "', comment = '" . $this->db->escape(strip_tags($comment)) . "', date_added = NOW()");
	}

	public function getMaterializeHistories($callback_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT comment, date_added FROM " . DB_PREFIX . "materialize_callback_history WHERE callback_id = '" . (int)$callback_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalMaterializeHistories($callback_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "materialize_callback_history WHERE callback_id = '" . (int)$callback_id . "'");

		return $query->row['total'];
	}
}