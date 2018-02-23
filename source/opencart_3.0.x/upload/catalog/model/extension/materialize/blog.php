<?php
class ModelExtensionMaterializeBlog extends Model {
	/* Author */
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

	/* Category */
	public function getCategory($blog_category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blog_category bc LEFT JOIN " . DB_PREFIX . "blog_category_description bcd ON (bc.blog_category_id = bcd.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_to_store bc2s ON (bc.blog_category_id = bc2s.blog_category_id) WHERE bc.blog_category_id = '" . (int)$blog_category_id . "' AND bcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND bc2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND bc.status = '1'");

		return $query->row;
	}

	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category bc LEFT JOIN " . DB_PREFIX . "blog_category_description bcd ON (bc.blog_category_id = bcd.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_to_store bc2s ON (bc.blog_category_id = bc2s.blog_category_id) WHERE bc.parent_id = '" . (int)$parent_id . "' AND bcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND bc2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND bc.status = '1' ORDER BY bc.sort_order, LCASE(bcd.name)");

		return $query->rows;
	}

	public function getCategoryFilters($blog_category_id) {
		$implode = array();

		$query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "blog_category_filter WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$implode[] = (int)$result['filter_id'];
		}

		$filter_group_data = array();

		if ($implode) {
			$filter_group_query = $this->db->query("SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");

			foreach ($filter_group_query->rows as $filter_group) {
				$filter_data = array();

				$filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");

				foreach ($filter_query->rows as $filter) {
					$filter_data[] = array(
						'filter_id' => $filter['filter_id'],
						'name'      => $filter['name']
					);
				}

				if ($filter_data) {
					$filter_group_data[] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'filter'          => $filter_data
					);
				}
			}
		}

		return $filter_group_data;
	}

	public function getCategoryLayoutId($blog_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_to_layout WHERE blog_category_id = '" . (int)$blog_category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category c LEFT JOIN " . DB_PREFIX . "blog_category_to_store c2s ON (c.blog_category_id = c2s.blog_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row['total'];
	}

	/* Comment */
	public function addComment($post_id, $data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "post_comment SET author = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', post_id = '" . (int)$post_id . "', text = '" . $this->db->escape($data['text']) . "', date_added = NOW()");

		$comment_id = $this->db->getLastId();

		$this->load->language('blog/post');
		$this->load->model('extension/materialize/blog');

		$post_info = $this->model_extension_materialize_blog->getPost($post_id);

		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

		$message  = $this->language->get('text_waiting') . "\n";
		$message .= sprintf($this->language->get('text_post'), html_entity_decode($post_info['name'], ENT_QUOTES, 'UTF-8')) . "\n";
		$message .= sprintf($this->language->get('text_commentator'), html_entity_decode($data['name'], ENT_QUOTES, 'UTF-8')) . "\n";
		$message .= sprintf($this->language->get('text_email'), $data['email']) . "\n";
		$message .= $this->language->get('text_comment') . "\n";
		$message .= html_entity_decode($data['text'], ENT_QUOTES, 'UTF-8') . "\n\n";

		$mail = new Mail($this->config->get('config_mail_engine'));
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

		$mail->setTo($this->config->get('config_email'));
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject($subject);
		$mail->setText($message);
		$mail->send();

		$emails = explode(',', $this->config->get('config_mail_alert_email'));

		foreach ($emails as $email) {
			if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$mail->setTo($email);
				$mail->send();
			}
		}
	}

	public function getCommentsByPostId($post_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}

		$query = $this->db->query("SELECT c.comment_id, c.author, c.email, c.text, p.post_id, pd.name, p.image, c.date_added FROM " . DB_PREFIX . "post_comment c LEFT JOIN " . DB_PREFIX . "post p ON (c.post_id = p.post_id) LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) WHERE p.post_id = '" . (int)$post_id . "' AND p.status = '1' AND c.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalCommentsByPostId($post_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_comment c LEFT JOIN " . DB_PREFIX . "post p ON (c.post_id = p.post_id) LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) WHERE p.post_id = '" . (int)$post_id . "' AND p.status = '1' AND c.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}

	/* Post */
	public function updateViewed($post_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "post SET viewed = (viewed + 1) WHERE post_id = '" . (int)$post_id . "'");
	}

	public function getPost($post_id) {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, ba.image AS author_image, p.image, (SELECT bad.name FROM " . DB_PREFIX . "blog_author_description bad WHERE bad.author_id = p.author_id AND bad.language_id = '" . (int)$this->config->get('config_language_id') . "') AS author, p.sort_order FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) LEFT JOIN " . DB_PREFIX . "post_to_store p2s ON (p.post_id = p2s.post_id) LEFT JOIN " . DB_PREFIX . "blog_author ba ON (p.author_id = ba.author_id) WHERE p.post_id = '" . (int)$post_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'post_id'			=> $query->row['post_id'],
				'name'				=> $query->row['name'],
				'description'		=> $query->row['description'],
				'meta_title'		=> $query->row['meta_title'],
				'meta_h1'			=> $query->row['meta_h1'],
				'meta_description'	=> $query->row['meta_description'],
				'meta_keyword'		=> $query->row['meta_keyword'],
				'tag'				=> $query->row['tag'],
				'image'				=> $query->row['image'],
				'author_id'			=> $query->row['author_id'],
				'author_image'		=> $query->row['author_image'],
				'author'			=> $query->row['author'],
				'sort_order'		=> $query->row['sort_order'],
				'status'			=> $query->row['status'],
				'comment_status'	=> $query->row['comment_status'],
				'date_added'		=> $query->row['date_added'],
				'date_modified'		=> $query->row['date_modified'],
				'viewed'			=> $query->row['viewed']
			);
		} else {
			return false;
		}
	}

	public function getPosts($data = array()) {
		$sql = "SELECT p.post_id";

		if (!empty($data['filter_blog_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "blog_category_path cp LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (cp.blog_category_id = p2c.blog_category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "post_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "post_filter pf ON (p2c.post_id = pf.post_id) LEFT JOIN " . DB_PREFIX . "post p ON (pf.post_id = p.post_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "post p ON (p2c.post_id = p.post_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "post p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "post_to_author p2a ON (p.post_id = p2a.post_id) LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) LEFT JOIN " . DB_PREFIX . "post_to_store p2s ON (p.post_id = p2s.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_blog_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_blog_category_id'] . "'";
			} else {
				$sql .= " AND p2c.blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			$sql .= ")";
		}

		if (!empty($data['filter_author_id'])) {
			$sql .= " AND (p.author_id = '" . (int)$data['filter_author_id'] . "' OR p2a.author_id = '" . (int)$data['filter_author_id'] . "')";
		}

		$sql .= " GROUP BY p.post_id";

		$sort_data = array(
			'pd.name',
			'p.sort_order',
			'p.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
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

		$post_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$post_data[$result['post_id']] = $this->getPost($result['post_id']);
		}

		return $post_data;
	}

	public function getPostRelated($post_id) {
		$post_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_related pr LEFT JOIN " . DB_PREFIX . "post p ON (pr.related_id = p.post_id) LEFT JOIN " . DB_PREFIX . "post_to_store p2s ON (p.post_id = p2s.post_id) WHERE pr.post_id = '" . (int)$post_id . "' AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$post_data[$result['related_id']] = $this->getPost($result['related_id']);
		}

		return $post_data;
	}

	public function getPostLayoutId($post_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_layout WHERE post_id = '" . (int)$post_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getPostAuthors($post_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_author WHERE post_id = '" . (int)$post_id . "'");

		return $query->rows;
	}

	public function getTotalPosts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.post_id) AS total";

		if (!empty($data['filter_blog_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "blog_category_path cp LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (cp.blog_category_id = p2c.blog_category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "post_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "post_filter pf ON (p2c.post_id = pf.post_id) LEFT JOIN " . DB_PREFIX . "post p ON (pf.post_id = p.post_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "post p ON (p2c.post_id = p.post_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "post p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "post_to_author p2a ON (p.post_id = p2a.post_id) LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) LEFT JOIN " . DB_PREFIX . "post_to_store p2s ON (p.post_id = p2s.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_blog_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_blog_category_id'] . "'";
			} else {
				$sql .= " AND p2c.blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			$sql .= ")";
		}

		if (!empty($data['filter_author_id'])) {
			$sql .= " AND p.author_id = '" . (int)$data['filter_author_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}