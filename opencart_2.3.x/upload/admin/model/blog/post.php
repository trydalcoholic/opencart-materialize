<?php
class ModelBlogPost extends Model {
	public function addPost($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "post SET status = '" . (int)$data['status'] . "', author_id = '" . (int)$data['author_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW()");

		$post_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "post SET image = '" . $this->db->escape($data['image']) . "' WHERE post_id = '" . (int)$post_id . "'");
		}

		foreach ($data['post_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_description SET post_id = '" . (int)$post_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['post_store'])) {
			foreach ($data['post_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_store SET post_id = '" . (int)$post_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['post_category'])) {
			foreach ($data['post_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET post_id = '" . (int)$post_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		if (isset($data['post_author'])) {
			foreach ($data['post_author'] as $author_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_author SET post_id = '" . (int)$post_id . "', author_id = '" . (int)$author_id . "'");
			}
		}

		if(isset($data['main_category_id']) && $data['main_category_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "' AND category_id = '" . (int)$data['main_category_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET post_id = '" . (int)$post_id . "', category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
		} elseif(isset($data['post_category'][0])) {
			$this->db->query("UPDATE " . DB_PREFIX . "post_to_category SET main_category = 1 WHERE post_id = '" . (int)$post_id . "' AND category_id = '" . (int)$data['post_category'][0] . "'");
		}

		if (isset($data['post_related'])) {
			foreach ($data['post_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_related SET post_id = '" . (int)$post_id . "', related_id = '" . (int)$related_id . "'");
			}
		}

		if (isset($data['post_layout'])) {
			foreach ($data['post_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_layout SET post_id = '" . (int)$post_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'post_id=" . (int)$post_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('post');

		return $post_id;
	}

	public function editPost($post_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "post SET status = '" . (int)$data['status'] . "', author_id = '" . (int)$data['author_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "post SET image = '" . $this->db->escape($data['image']) . "' WHERE post_id = '" . (int)$post_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_description WHERE post_id = '" . (int)$post_id . "'");

		foreach ($data['post_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_description SET post_id = '" . (int)$post_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_store WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_store'])) {
			foreach ($data['post_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_store SET post_id = '" . (int)$post_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_category'])) {
			foreach ($data['post_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET post_id = '" . (int)$post_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		/* НЕСКОЛЬКО АТВОРОВ */
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_author WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_author'])) {
			foreach ($data['post_author'] as $author_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_author SET post_id = '" . (int)$post_id . "', author_id = '" . (int)$author_id . "'");
			}
		}
		/* НЕСКОЛЬКО АТВОРОВ */

		if(isset($data['main_category_id']) && $data['main_category_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "' AND category_id = '" . (int)$data['main_category_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET post_id = '" . (int)$post_id . "', category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
		} elseif(isset($data['post_category'][0])) {
			$this->db->query("UPDATE " . DB_PREFIX . "post_to_category SET main_category = 1 WHERE post_id = '" . (int)$post_id . "' AND category_id = '" . (int)$data['post_category'][0] . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_related'])) {
			foreach ($data['post_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_related SET post_id = '" . (int)$post_id . "', related_id = '" . (int)$related_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_layout WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_layout'])) {
			foreach ($data['post_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_layout SET post_id = '" . (int)$post_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'post_id=" . (int)$post_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('post');
	}

	public function copyPost($post_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "post p WHERE p.post_id = '" . (int)$post_id . "'");

		if ($query->num_rows) {
			$data = $query->row;

			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$data['post_description'] = $this->getPostDescriptions($post_id);
			$data['post_related'] = $this->getPostRelated($post_id);
			$data['post_category'] = $this->getPostCategories($post_id);
			$data['post_author'] = $this->getPostAuthors($post_id);
			$data['post_layout'] = $this->getPostLayouts($post_id);
			$data['post_store'] = $this->getPostStores($post_id);

			$data['main_category_id'] = $this->getPostMainCategoryId($post_id);

			$this->addPost($data);
		}
	}

	public function deletePost($post_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "post WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_description WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_author WHERE post_id = '" . (int)$post_id . "'");	
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_layout WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_store WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id . "'");

		$this->cache->delete('post');
	}

	public function getPost($post_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id . "' LIMIT 1) AS keyword FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) WHERE p.post_id = '" . (int)$post_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getPosts($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id)";

		if (!empty($data['filter_category'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (p.post_id = p2c.post_id)";
		}

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";


		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_image']) && !is_null($data['filter_image'])) {
			if ($data['filter_image'] == 1) {
				$sql .= " AND (p.image IS NOT NULL AND p.image <> '' AND p.image <> 'no_image.png')";
			} else {
				$sql .= " AND (p.image IS NULL OR p.image = '' OR p.image = 'no_image.png')";
			}
		}

		if (!empty($data['filter_category'])) {
			$sql .= " AND p2c.category_id = '" . (int)$data['filter_category'] . "'";
		}

		$sql .= " GROUP BY p.post_id";

		$sort_data = array(
			'pd.name',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
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

	public function getPostsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (p.post_id = p2c.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getPostDescriptions($post_id) {
		$post_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_description WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'          => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $post_description_data;
	}

	public function getPostCategories($post_id) {
		$post_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_category_data[] = $result['category_id'];
		}

		return $post_category_data;
	}

	public function getPostAuthors($post_id) {
		$post_author_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_author WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_author_data[] = $result['author_id'];
		}

		return $post_author_data;
	}

	public function getPostStores($post_id) {
		$post_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_store WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_store_data[] = $result['store_id'];
		}

		return $post_store_data;
	}

	public function getPostLayouts($post_id) {
		$post_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_layout WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $post_layout_data;
	}

	public function getPostMainCategoryId($post_id) {
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "' AND main_category = '1' LIMIT 1");

		return ($query->num_rows ? (int)$query->row['category_id'] : 0);
	}

	public function getPostRelated($post_id) {
		$post_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_related_data[] = $result['related_id'];
		}

		return $post_related_data;
	}

	public function getTotalPosts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.post_id) AS total FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (p.post_id = p2c.post_id)";

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_category']) && !is_null($data['filter_category'])) {
			$sql .= " AND p2c.category_id = '" . (int)$data['filter_category'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_image']) && !is_null($data['filter_image'])) {
			if ($data['filter_image'] == 1) {
				$sql .= " AND (p.image IS NOT NULL AND p.image <> '' AND p.image <> 'no_image.png')";
			} else {
				$sql .= " AND (p.image IS NULL OR p.image = '' OR p.image = 'no_image.png')";
			}
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalPostsByAuthorId($author_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post WHERE author_id = '" . (int)$author_id . "'");

		return $query->row['total'];
	}

	public function getTotalPostsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}