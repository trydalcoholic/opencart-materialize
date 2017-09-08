<?php
class ModelBlogPost extends Model {
	public function getPost($blog_post_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blog_post i LEFT JOIN " . DB_PREFIX . "blog_post_description id ON (i.blog_post_id = id.blog_post_id) LEFT JOIN " . DB_PREFIX . "blog_post_to_store i2s ON (i.blog_post_id = i2s.blog_post_id) WHERE i.blog_post_id = '" . (int)$blog_post_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");

		return $query->row;
	}

	public function getPosts($data = array()) {
		if (!empty($data['filter_blog_category_id'])) {
			$sql = "SELECT * FROM " . DB_PREFIX . "blog_post_to_category p2c LEFT JOIN " . DB_PREFIX . "blog_post p ON (p2c.blog_post_id = p.blog_post_id)";
		} else {
			$sql = "SELECT * FROM " . DB_PREFIX . "blog_post p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "blog_post_description pd ON (p.blog_post_id = pd.blog_post_id) LEFT JOIN " . DB_PREFIX . "blog_post_to_store p2s ON (p.blog_post_id = p2s.blog_post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.status = '1'";

		if (!empty($data['filter_blog_category_id'])) {
			$sql .= " AND p2c.blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
		}

		if (!empty($data['filter_title'])) {
			$implode = array();
			$implode2 = array();

			$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_title'])));

			foreach ($words as $word) {
				$implode[] = "pd.title LIKE '%" . $this->db->escape($word) . "%'";
				$implode2[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
			}

			$sql .= " AND (" . implode(" AND ", $implode) . " OR " . implode(" AND ", $implode2) . ")";
		}


		if (!empty($data['filter_date_added'])) {
			$sql .= " AND p.date_added LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_date_added'])) . "%'";
		}

		$sort_data = array(
			'pd.title',
			'p.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.date_added";
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

	public function getTotalPosts($data = array()) {
		if (!empty($data['filter_blog_category_id'])) {
			$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_post_to_category p2c LEFT JOIN " . DB_PREFIX . "blog_post p ON (p2c.blog_post_id = p.blog_post_id)";
		} else {
			$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_post p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "blog_post_description pd ON (p.blog_post_id = pd.blog_post_id) LEFT JOIN " . DB_PREFIX . "blog_post_to_store p2s ON (p.blog_post_id = p2s.blog_post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.status = '1'";

		if (!empty($data['filter_blog_category_id'])) {
			$sql .= " AND p2c.blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
		}

		if (!empty($data['filter_title'])) {
			$implode = array();
			$implode2 = array();

			$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_title'])));

			foreach ($words as $word) {
				$implode[] = "pd.title LIKE '%" . $this->db->escape($word) . "%'";
				$implode2[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
			}

			$sql .= " AND (" . implode(" AND ", $implode) . " OR " . implode(" AND ", $implode2) . ")";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND p.date_added LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_date_added'])) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getPostLayoutId($blog_post_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_post_to_layout WHERE blog_post_id = '" . (int)$blog_post_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getPostsDate($date_type) {

		if ($date_type) {
			$sql = "SELECT DATE_FORMAT(date_added, '%Y-%m') AS date_added2, date_added FROM " . DB_PREFIX . "blog_post GROUP BY date_added2";
		} else {
			$sql = "SELECT DATE_FORMAT(date_added, '%Y') AS date_added2, date_added FROM " . DB_PREFIX . "blog_post GROUP BY date_added2";
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getPostTags($data) {
		$tag_data = array();
		$tag_data = $this->cache->get('post.tags.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id')  . '.' . (int)$data['limit']);

		if (!$tag_data) {
			$query = $this->db->query("SELECT pd.tag FROM " . DB_PREFIX . "blog_post_description pd LEFT JOIN " . DB_PREFIX . "blog_post_to_store p2s ON (pd.blog_post_id = p2s.blog_post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY pd.title ASC");

			foreach ($query->rows as $result) {
				$tags = explode(',',$result['tag']);
				foreach ($tags as $tag) {
					if(empty($tag_data) || !in_array($tag, $tag_data)) {
						$tag_data[] = $tag;
					}
				}

				if(count($tag_data) >= $data['limit']){
					break;
				}

			}

			ksort($tag_data);

			$this->cache->set('post.tags.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$data['limit'], $tag_data);
		}

		return $tag_data;
	}
}