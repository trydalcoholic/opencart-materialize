<?php
class ModelBlogAuthor extends Model {
	public function getAuthor($author_id) {
		$query = $this->db->query("SELECT DISTINCT *, bad.name AS name FROM " . DB_PREFIX . "blog_author ba LEFT JOIN " . DB_PREFIX . "blog_author_description bad ON (ba.author_id = bad.author_id) LEFT JOIN " . DB_PREFIX . "blog_author_to_store ba2s ON (ba.author_id = ba2s.author_id) WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "' && ba.author_id = '" . (int)$author_id . "' AND ba2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		return $query->row;
	}

	public function getAuthors($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "blog_author ba LEFT JOIN " . DB_PREFIX . "blog_author_to_store ba2s ON (ba.author_id = ba2s.author_id) LEFT JOIN " . DB_PREFIX . "blog_author_description bad ON (ba.author_id = bad.author_id) WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "' && ba2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

			$sort_data = array(
				'name',
				'sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY bad.name";
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
			$blog_author_data = $this->cache->get('blog_author.' . (int)$this->config->get('config_language_id').'.'. (int)$this->config->get('config_store_id'));

			if (!$blog_author_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_author ba LEFT JOIN " . DB_PREFIX . "blog_author_to_store ba2s ON (ba.author_id = ba2s.author_id) LEFT JOIN " . DB_PREFIX . "blog_author_description bad ON (ba.author_id = bad.author_id) WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "' && ba2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY bad.name");

				$blog_author_data = $query->rows;

				$this->cache->set('blog_author.' . (int)$this->config->get('config_language_id') . '.'. (int)$this->config->get('config_store_id'), $blog_author_data);
			}

			return $blog_author_data;
		}
	}
}