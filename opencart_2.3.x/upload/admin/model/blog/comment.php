<?php
class ModelBlogComment extends Model {
	public function addComment($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_comment SET author = '" . $this->db->escape($data['author']) . "', email = '" . $this->db->escape($data['email']) . "', blog_post_id = '" . (int)$data['blog_post_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$blog_comment_id = $this->db->getLastId();

		$this->cache->delete('blog_post');

		return $blog_comment_id;
	}

	public function editComment($blog_comment_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_comment SET author = '" . $this->db->escape($data['author']) . "', email = '" . $this->db->escape($data['email']) . "', blog_post_id = '" . (int)$data['blog_post_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE blog_comment_id = '" . (int)$blog_comment_id . "'");

		$this->cache->delete('blog_post');
	}

	public function deleteComment($blog_comment_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_comment WHERE blog_comment_id = '" . (int)$blog_comment_id . "'");

		$this->cache->delete('blog_post');
	}

	public function getComment($blog_comment_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.title FROM " . DB_PREFIX . "blog_post_description pd WHERE pd.blog_post_id = r.blog_post_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS title FROM " . DB_PREFIX . "blog_comment r WHERE r.blog_comment_id = '" . (int)$blog_comment_id . "'");

		return $query->row;
	}

	public function getComments($data = array()) {
		$sql = "SELECT r.blog_comment_id, pd.title, r.author, r.email, r.status, r.date_added FROM " . DB_PREFIX . "blog_comment r LEFT JOIN " . DB_PREFIX . "blog_post_description pd ON (r.blog_post_id = pd.blog_post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_title'])) {
			$sql .= " AND pd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND (r.author LIKE '" . $this->db->escape($data['filter_author']) . "%' OR r.email LIKE '" . $this->db->escape($data['filter_author']) . "%')";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'pd.title',
			'r.author',
			'r.email',
			'r.status',
			'r.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment r LEFT JOIN " . DB_PREFIX . "blog_post_description pd ON (r.blog_post_id = pd.blog_post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_title'])) {
			$sql .= " AND pd.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND (r.author LIKE '" . $this->db->escape($data['filter_author']) . "%' OR r.email LIKE '" . $this->db->escape($data['filter_author']) . "%')";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalCommentsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment WHERE status = '0'");

		return $query->row['total'];
	}
}