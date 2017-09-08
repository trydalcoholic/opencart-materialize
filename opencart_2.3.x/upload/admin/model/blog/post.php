<?php
class ModelBlogPost extends Model {
	public function addPost($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_post SET author = '" . $this->db->escape($data['author']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$blog_post_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_post SET image = '" . $this->db->escape($data['image']) . "' WHERE blog_post_id = '" . (int)$blog_post_id . "'");
		}

		foreach ($data['post_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_post_description SET blog_post_id = '" . (int)$blog_post_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['post_store'])) {
			foreach ($data['post_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_post_to_store SET blog_post_id = '" . (int)$blog_post_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['blog_post_category'])) {
			foreach ($data['blog_post_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_post_to_category SET blog_post_id = '" . (int)$blog_post_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}
		}

		if (isset($data['post_layout'])) {
			foreach ($data['post_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_post_to_layout SET blog_post_id = '" . (int)$blog_post_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias_blog SET query = 'blog_post_id=" . (int)$blog_post_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('post');

		return $blog_post_id;
	}

	public function editPost($blog_post_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_post SET author = '" . $this->db->escape($data['author']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE blog_post_id = '" . (int)$blog_post_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_post SET image = '" . $this->db->escape($data['image']) . "' WHERE blog_post_id = '" . (int)$blog_post_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_post_description WHERE blog_post_id = '" . (int)$blog_post_id . "'");

		foreach ($data['post_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_post_description SET blog_post_id = '" . (int)$blog_post_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_post_to_store WHERE blog_post_id = '" . (int)$blog_post_id . "'");

		if (isset($data['post_store'])) {
			foreach ($data['post_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_post_to_store SET blog_post_id = '" . (int)$blog_post_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_post_to_category WHERE blog_post_id = '" . (int)$blog_post_id . "'");

		if (isset($data['blog_post_category'])) {
			foreach ($data['blog_post_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_post_to_category SET blog_post_id = '" . (int)$blog_post_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_post_to_layout WHERE blog_post_id = '" . (int)$blog_post_id . "'");

		if (isset($data['post_layout'])) {
			foreach ($data['post_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_post_to_layout SET blog_post_id = '" . (int)$blog_post_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias_blog WHERE query = 'blog_post_id=" . (int)$blog_post_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias_blog SET query = 'blog_post_id=" . (int)$blog_post_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('post');
	}

	public function deletePost($blog_post_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_post WHERE blog_post_id = '" . (int)$blog_post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_post_description WHERE blog_post_id = '" . (int)$blog_post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_post_to_category WHERE blog_post_id = '" . (int)$blog_post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_post_to_store WHERE blog_post_id = '" . (int)$blog_post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_post_to_layout WHERE blog_post_id = '" . (int)$blog_post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_comment WHERE blog_post_id = '" . (int)$blog_post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias_blog WHERE query = 'blog_post_id=" . (int)$blog_post_id . "'");

		$this->cache->delete('post');
	}

	public function getPost($blog_post_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias_blog WHERE query = 'blog_post_id=" . (int)$blog_post_id . "') AS keyword FROM " . DB_PREFIX . "blog_post WHERE blog_post_id = '" . (int)$blog_post_id . "'");

		return $query->row;
	}

	public function getPostCategories($blog_post_id) {
		$blog_post_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_post_to_category WHERE blog_post_id = '" . (int)$blog_post_id . "'");

		foreach ($query->rows as $result) {
			$blog_post_category_data[] = $result['blog_category_id'];
		}

		return $blog_post_category_data;
	}

	public function getPosts($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "blog_post i LEFT JOIN " . DB_PREFIX . "blog_post_description id ON (i.blog_post_id = id.blog_post_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			if (isset($data['filter_title'])) {
				$sql .= " AND id.title LIKE '%" . $this->db->escape($data['filter_title']) . "%'";
			}

			if (!empty($data['filter_author'])) {
				$sql .= " AND i.author LIKE '%" . $this->db->escape($data['filter_author']) . "%'";
			}

			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND i.status = '" . (int)$data['filter_status'] . "'";
			}

			if (!empty($data['filter_date_added'])) {
				$sql .= " AND DATE(i.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
			}


			$sort_data = array(
				'id.title',
				'i.author',
				'i.sort_order',
				'i.date_added'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY id.title";
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
			$post_data = $this->cache->get('post.' . (int)$this->config->get('config_language_id'));

			if (!$post_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_post i LEFT JOIN " . DB_PREFIX . "blog_post_description id ON (i.blog_post_id = id.blog_post_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$post_data = $query->rows;

				$this->cache->set('post.' . (int)$this->config->get('config_language_id'), $post_data);
			}

			return $post_data;
		}
	}

	public function getPostDescriptions($blog_post_id) {
		$post_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_post_description WHERE blog_post_id = '" . (int)$blog_post_id . "'");

		foreach ($query->rows as $result) {
			$post_description_data[$result['language_id']] = array(
				'title'            => $result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $post_description_data;
	}

	public function getPostStores($blog_post_id) {
		$post_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_post_to_store WHERE blog_post_id = '" . (int)$blog_post_id . "'");

		foreach ($query->rows as $result) {
			$post_store_data[] = $result['store_id'];
		}

		return $post_store_data;
	}

	public function getPostLayouts($blog_post_id) {
		$post_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_post_to_layout WHERE blog_post_id = '" . (int)$blog_post_id . "'");

		foreach ($query->rows as $result) {
			$post_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $post_layout_data;
	}

	public function getTotalPosts($data = array()) {

		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_post i LEFT JOIN " . DB_PREFIX . "blog_post_description id ON (i.blog_post_id = id.blog_post_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";


		if (isset($data['filter_title'])) {
			$sql .= " AND id.title LIKE '%" . $this->db->escape($data['filter_title']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND i.author LIKE '%" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND i.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(i.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalPostsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_post_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}