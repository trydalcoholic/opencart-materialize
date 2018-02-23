<?php
class ModelExtensionMaterializeBlog extends Model {
	/* Blog */
	public function addBlogSeoUrl($data, $query) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = '" . $query . "'");

		if (isset($data['module_blog_seo_url'])) {
			foreach ($data['module_blog_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = '" . $query . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}
	}

	public function getSeoUrlInfoMaterializeBlogByQuery($query) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE query = '" . $this->db->escape($query) . "'");

		return $query->rows;
	}

	public function getSeoUrlMaterializeBlogByQuery($query) {
		$blog_seo_url_data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE query = '" . $this->db->escape($query) . "'");

		foreach ($query->rows as $result) {
			$blog_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $blog_seo_url_data;
	}

	/* Author */
	public function addAuthor($data) {
		$this->load->model('localisation/language');
		$language_info = $this->model_localisation_language->getLanguageByCode($this->config->get('config_language'));
		$front_language_id = $language_info['language_id'];
		$data['name'] = $data['author_description'][$front_language_id ]['name'];

		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_author SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$author_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_author SET image = '" . $this->db->escape($data['image']) . "' WHERE author_id = '" . (int)$author_id . "'");
		}

		if (isset($data['author_store'])) {
			foreach ($data['author_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_author_to_store SET author_id = '" . (int)$author_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		foreach ($data['author_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_author_description SET author_id = '" . (int)$author_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// SEO URL
		if (isset($data['author_seo_url'])) {
			foreach ($data['author_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'author_id=" . (int)$author_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}

		$this->cache->delete('author');

		return $author_id;
	}

	public function editAuthor($author_id, $data) {
		$this->load->model('localisation/language');
		$language_info = $this->model_localisation_language->getLanguageByCode($this->config->get('config_language'));
		$front_language_id = $language_info['language_id'];
		$data['name'] = $data['author_description'][$front_language_id ]['name'];

		$this->db->query("UPDATE " . DB_PREFIX . "blog_author SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE author_id = '" . (int)$author_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_author SET image = '" . $this->db->escape($data['image']) . "' WHERE author_id = '" . (int)$author_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_author_description WHERE author_id = '" . (int)$author_id . "'");

		foreach ($data['author_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_author_description SET author_id = '" . (int)$author_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_author_to_store WHERE author_id = '" . (int)$author_id . "'");

		if (isset($data['author_store'])) {
			foreach ($data['author_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_author_to_store SET author_id = '" . (int)$author_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'author_id=" . (int)$author_id . "'");

		if (isset($data['author_seo_url'])) {
			foreach ($data['author_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'author_id=" . (int)$author_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}

		$this->cache->delete('author');
	}

	public function deleteAuthor($author_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_author WHERE author_id = '" . (int)$author_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_author_description WHERE author_id = '" . (int)$author_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_author_to_store WHERE author_id = '" . (int)$author_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_author WHERE query = 'author_id=" . (int)$author_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'author_id=" . (int)$author_id . "'");

		$this->cache->delete('author');
	}

	public function getAuthor($author_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_author WHERE author_id = '" . (int)$author_id . "'");

		return $query->row;
	}

	public function getAuthorDescriptions($author_id) {
		$blog_author_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_author_description WHERE author_id = '" . (int)$author_id . "'");

		foreach ($query->rows as $result) {
			$blog_author_description_data[$result['language_id']] = array(
				'name'				=> $result['name'],
				'meta_title'		=> $result['meta_title'],
				'meta_h1'			=> $result['meta_h1'],
				'meta_description'	=> $result['meta_description'],
				'meta_keyword'		=> $result['meta_keyword'],
				'description'		=> $result['description']
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

	public function getAuthorSeoUrls($author_id) {
		$author_seo_url_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'author_id=" . (int)$author_id . "'");

		foreach ($query->rows as $result) {
			$author_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $author_seo_url_data;
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

	/* Category */
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$blog_category_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET image = '" . $this->db->escape($data['image']) . "' WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		}

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_description SET blog_category_id = '" . (int)$blog_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "blog_category_path` SET `blog_category_id` = '" . (int)$blog_category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "blog_category_path` SET `blog_category_id` = '" . (int)$blog_category_id . "', `path_id` = '" . (int)$blog_category_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_store SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['category_seo_url'])) {
			foreach ($data['category_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'blog_category_id=" . (int)$blog_category_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}

		// Set which layout to use with this category
		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_layout SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('category');

		return $blog_category_id;
	}

	public function editCategory($blog_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET image = '" . $this->db->escape($data['image']) . "' WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_description SET blog_category_id = '" . (int)$blog_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE path_id = '" . (int)$blog_category_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $category_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$category_path['blog_category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$category_path['blog_category_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "blog_category_path` SET blog_category_id = '" . (int)$category_path['blog_category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$blog_category_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "blog_category_path` SET blog_category_id = '" . (int)$blog_category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "blog_category_path` SET blog_category_id = '" . (int)$blog_category_id . "', `path_id` = '" . (int)$blog_category_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_store SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// SEO URL
		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'blog_category_id=" . (int)$blog_category_id . "'");

		if (isset($data['category_seo_url'])) {
			foreach ($data['category_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'blog_category_id=" . (int)$blog_category_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_layout SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('category');
	}

	public function deleteCategory($blog_category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_path WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_path WHERE path_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['blog_category_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'blog_category_id=" . (int)$blog_category_id . "'");

		$this->cache->delete('category');
	}

	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$category['blog_category_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "blog_category_path` SET blog_category_id = '" . (int)$category['blog_category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "blog_category_path` SET blog_category_id = '" . (int)$category['blog_category_id'] . "', `path_id` = '" . (int)$category['blog_category_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($category['blog_category_id']);
		}
	}

	public function getCategory($blog_category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "blog_category_path cp LEFT JOIN " . DB_PREFIX . "blog_category_description cd1 ON (cp.path_id = cd1.blog_category_id AND cp.blog_category_id != cp.path_id) WHERE cp.blog_category_id = c.blog_category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.blog_category_id) AS path FROM " . DB_PREFIX . "blog_category c LEFT JOIN " . DB_PREFIX . "blog_category_description cd2 ON (c.blog_category_id = cd2.blog_category_id) WHERE c.blog_category_id = '" . (int)$blog_category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCategories($data = array()) {
		$sql = "SELECT cp.blog_category_id AS blog_category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order, c1.status,(select count(post_id) as post_count from " . DB_PREFIX . "post_to_category pc where pc.blog_category_id = c1.blog_category_id) as post_count FROM " . DB_PREFIX . "blog_category_path cp LEFT JOIN " . DB_PREFIX . "blog_category c1 ON (cp.blog_category_id = c1.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category c2 ON (cp.path_id = c2.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_description cd1 ON (cp.path_id = cd1.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_description cd2 ON (cp.blog_category_id = cd2.blog_category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.blog_category_id";

		$sort_data = array(
			'post_count',
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getCategoryDescriptions($blog_category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'				=> $result['name'],
				'meta_title'		=> $result['meta_title'],
				'meta_h1'			=> $result['meta_h1'],
				'meta_description'	=> $result['meta_description'],
				'meta_keyword'		=> $result['meta_keyword'],
				'description'		=> $result['description']
			);
		}

		return $category_description_data;
	}

	public function getCategoryPath($blog_category_id) {
		$query = $this->db->query("SELECT blog_category_id, path_id, level FROM " . DB_PREFIX . "blog_category_path WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		return $query->rows;
	}

	public function getCategoryStores($blog_category_id) {
		$category_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_to_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}

		return $category_store_data;
	}

	public function getCategorySeoUrls($blog_category_id) {
		$category_seo_url_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'blog_category_id=" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$category_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $category_seo_url_data;
	}

	public function getCategoryLayouts($blog_category_id) {
		$category_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_to_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $category_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category");

		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}

	/* Comment */
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

	/* Post */
	public function addPost($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "post SET status = '" . (int)$data['status'] . "', comment_status = '" . (int)$data['comment_status'] . "', author_id = '" . (int)$data['author_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', viewed = '" . (int)$data['viewed'] . "', date_modified = NOW(), date_added = NOW()");

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
			foreach ($data['post_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET post_id = '" . (int)$post_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}
		}

		if (isset($data['post_author'])) {
			foreach ($data['post_author'] as $author_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_author SET post_id = '" . (int)$post_id . "', author_id = '" . (int)$author_id . "'");
			}
		}

		if( isset($data['main_category_id']) && $data['main_category_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "' AND blog_category_id = '" . (int)$data['main_category_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET post_id = '" . (int)$post_id . "', blog_category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
		} elseif (isset($data['post_category'][0])) {
			$this->db->query("UPDATE " . DB_PREFIX . "post_to_category SET main_category = 1 WHERE post_id = '" . (int)$post_id . "' AND blog_category_id = '" . (int)$data['post_category'][0] . "'");
		}

		if (isset($data['post_related'])) {
			foreach ($data['post_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_related SET post_id = '" . (int)$post_id . "', related_id = '" . (int)$related_id . "'");
			}
		}

		if (isset($data['post_seo_url'])) {
			foreach ($data['post_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'post_id=" . (int)$post_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}

		if (isset($data['post_layout'])) {
			foreach ($data['post_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_layout SET post_id = '" . (int)$post_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('post');

		return $post_id;
	}

	public function editPost($post_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "post SET status = '" . (int)$data['status'] . "', comment_status = '" . (int)$data['comment_status'] . "', author_id = '" . (int)$data['author_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', viewed = '" . (int)$data['viewed'] . "', date_modified = NOW() WHERE post_id = '" . (int)$post_id . "'");

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

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_author WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_author'])) {
			foreach ($data['post_author'] as $author_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_author SET post_id = '" . (int)$post_id . "', author_id = '" . (int)$author_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_category'])) {
			foreach ($data['post_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET post_id = '" . (int)$post_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}
		}

		if (isset($data['main_category_id']) && $data['main_category_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "' AND blog_category_id = '" . (int)$data['main_category_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET post_id = '" . (int)$post_id . "', blog_category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
		} elseif (isset($data['post_category'][0])) {
			$this->db->query("UPDATE " . DB_PREFIX . "post_to_category SET main_category = 1 WHERE post_id = '" . (int)$post_id . "' AND blog_category_id = '" . (int)$data['post_category'][0] . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_related'])) {
			foreach ($data['post_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_related SET post_id = '" . (int)$post_id . "', related_id = '" . (int)$related_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'post_id=" . (int)$post_id . "'");

		if (isset($data['post_seo_url'])) {
			foreach ($data['post_seo_url']as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'post_id=" . (int)$post_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_layout WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_layout'])) {
			foreach ($data['post_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_layout SET post_id = '" . (int)$post_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
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
			$data['comment_status'] = '1';

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
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'post_id=" . (int)$post_id . "'");

		$this->cache->delete('post');
	}

	public function getPost($post_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) WHERE p.post_id = '" . (int)$post_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

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
			$sql .= " AND p2c.blog_category_id = '" . (int)$data['filter_category'] . "'";
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

	public function getPostsByCategoryId($blog_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (p.post_id = p2c.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.blog_category_id = '" . (int)$blog_category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getPostDescriptions($post_id) {
		$post_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_description WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_description_data[$result['language_id']] = array(
				'name'				=> $result['name'],
				'description'		=> $result['description'],
				'meta_title'		=> $result['meta_title'],
				'meta_h1'			=> $result['meta_h1'],
				'meta_description'	=> $result['meta_description'],
				'meta_keyword'		=> $result['meta_keyword'],
				'tag'				=> $result['tag']
			);
		}

		return $post_description_data;
	}

	public function getPostCategories($post_id) {
		$post_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_category_data[] = $result['blog_category_id'];
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

	public function getPostSeoUrls($post_id) {
		$post_seo_url_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'post_id=" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $post_seo_url_data;
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
		$query = $this->db->query("SELECT blog_category_id FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "' AND main_category = '1' LIMIT 1");

		return ($query->num_rows ? (int)$query->row['blog_category_id'] : 0);
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
			$sql .= " AND p2c.blog_category_id = '" . (int)$data['filter_category'] . "'";
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