<?php
class ModelBlogAuthor extends Model {
	public function addAuthor($data) {

		$this->load->model('localisation/language');
		$language_info = $this->model_localisation_language->getLanguageByCode($this->config->get('config_language'));
		$front_language_id = $language_info['language_id'];
		$data['name'] = $data['blog_author_description'][$front_language_id ]['name'];
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_author SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$author_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_author SET image = '" . $this->db->escape($data['image']) . "' WHERE author_id = '" . (int)$author_id . "'");
		}

		foreach ($data['blog_author_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_author_description SET author_id = '" . (int)$author_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['blog_author_store'])) {
			foreach ($data['blog_author_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_author_to_store SET author_id = '" . (int)$author_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'author_id=" . (int)$author_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('author');

		return $author_id;
	}

	public function editAuthor($author_id, $data) {
		
		$this->load->model('localisation/language');
		$language_info = $this->model_localisation_language->getLanguageByCode($this->config->get('config_language'));
		$front_language_id = $language_info['language_id'];
		$data['name'] = $data['blog_author_description'][$front_language_id ]['name'];

		$this->db->query("UPDATE " . DB_PREFIX . "blog_author SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE author_id = '" . (int)$author_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_author SET image = '" . $this->db->escape($data['image']) . "' WHERE author_id = '" . (int)$author_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_author_description WHERE author_id = '" . (int)$author_id . "'");

		foreach ($data['blog_author_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_author_description SET author_id = '" . (int)$author_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_author_to_store WHERE author_id = '" . (int)$author_id . "'");

		if (isset($data['blog_author_store'])) {
			foreach ($data['blog_author_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_author_to_store SET author_id = '" . (int)$author_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'author_id=" . (int)$author_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'author_id=" . (int)$author_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('author');
	}

	public function deleteAuthor($author_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_author WHERE author_id = '" . (int)$author_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_author_to_store WHERE author_id = '" . (int)$author_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'author_id=" . (int)$author_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_author_description WHERE author_id = '" . (int)$author_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_author WHERE query = 'author_id=" . (int)$author_id . "'");

		$this->cache->delete('author');
	}

	public function getAuthor($author_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'author_id=" . (int)$author_id . "' LIMIT 1) AS keyword FROM " . DB_PREFIX . "blog_author WHERE author_id = '" . (int)$author_id . "'");

		return $query->row;
	}

	public function getAuthorDescriptions($author_id) {
		$blog_author_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_author_description WHERE author_id = '" . (int)$author_id . "'");

		foreach ($query->rows as $result) {
			$blog_author_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'          => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $blog_author_description_data;
	}

	public function getAuthors($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "blog_author";

		$sql = "SELECT c.author_id, bad.name, c.sort_order FROM " . DB_PREFIX . "blog_author c LEFT JOIN " . DB_PREFIX . "blog_author_description bad ON (c.author_id = bad.author_id) WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getAuthorStores($author_id) {
		$blog_author_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_author_to_store WHERE author_id = '" . (int)$author_id . "'");

		foreach ($query->rows as $result) {
			$blog_author_store_data[] = $result['store_id'];
		}

		return $blog_author_store_data;
	}

	public function getTotalAuthors() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_author");

		return $query->row['total'];
	}
}