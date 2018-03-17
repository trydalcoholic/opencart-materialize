<?php
class ModelBlogComment extends Model {
	public function addComment($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "post_comment SET author = '" . $this->db->escape($data['author']) . "', post_id = '" . (int)$data['post_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', email = '" . $this->db->escape($data['email']) . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "'");

		$comment_id = $this->db->getLastId();

		$this->cache->delete('post');

		return $comment_id;
	}

	public function editComment($comment_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "post_comment SET author = '" . $this->db->escape($data['author']) . "', post_id = '" . (int)$data['post_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', email = '" . $this->db->escape($data['email']) . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "', date_modified = NOW() WHERE comment_id = '" . (int)$comment_id . "'");

		$this->cache->delete('post');
	}

	public function deleteComment($comment_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_comment WHERE comment_id = '" . (int)$comment_id . "'");

		$this->cache->delete('post');
	}

	public function getComment($comment_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.name FROM " . DB_PREFIX . "post_description pd WHERE pd.post_id = c.post_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS post FROM " . DB_PREFIX . "post_comment c WHERE c.comment_id = '" . (int)$comment_id . "'");

		return $query->row;
	}

	public function getComments($data = array()) {
		$sql = "SELECT c.comment_id, pd.name, c.author, c.email, c.status, c.date_added FROM " . DB_PREFIX . "post_comment c LEFT JOIN " . DB_PREFIX . "post_description pd ON (c.post_id = pd.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_post'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_post']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND c.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND c.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'pd.name',
			'c.author',
			'c.email',
			'c.status',
			'c.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY c.date_added";
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

	public function getTotalComments($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_comment c LEFT JOIN " . DB_PREFIX . "post_description pd ON (c.post_id = pd.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_post'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_post']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND c.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND c.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalCommentsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_comment WHERE status = '0'");

		return $query->row['total'];
	}
}