<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ModelExtensionMTMaterializeModuleMTBlogPost extends Model {
	public function addPost($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "mt_post SET sort_order = '" . (int)$data['sort_order'] . "', author_id = '" . (int)$data['author_id'] . "', status = '" . (int)$data['status'] . "', viewed = '" . (int)$data['viewed'] . "', settings = '" . $this->db->escape(json_encode($data['settings'])) . "', date_added = NOW(), date_modified = NOW()");

		$post_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "mt_post SET image = '" . $this->db->escape((string)$data['image']) . "' WHERE post_id = '" . (int)$post_id . "'");
		}

		foreach ($data['description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "mt_post_description SET post_id = '" . (int)$post_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		foreach ($data['seo']['meta'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "mt_post_description SET meta_title = '" . $this->db->escape($value['title']) . "', meta_h1 = '" . $this->db->escape($value['h1']) . "', meta_description = '" . $this->db->escape($value['description']) . "', meta_keyword = '" . $this->db->escape($value['keyword']) . "', tag = '" . $this->db->escape($value['tag']) . "' WHERE post_id = '" . (int)$post_id . "' AND language_id = '" . (int)$language_id . "'");
		}

		if (isset($data['store'])) {
			foreach ($data['post_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_store SET post_id = '" . (int)$post_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['category'])) {
			foreach ($data['post_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_blog_category SET product_id = '" . (int)$post_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}
		}

		if (isset($data['filter'])) {
			foreach ($data['post_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_filter SET post_id = '" . (int)$post_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['related'])) {
			foreach ($data['post_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_related SET post_id = '" . (int)$post_id . "', related_id = '" . (int)$related_id . "'");
			}
		}

		// SEO URL
		if (isset($data['seo_url'])) {
			foreach ($data['seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if ($keyword) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'post_id=" . (int)$post_id . "', keyword = '" . $this->db->escape($keyword) . "', push = '" . $this->db->escape('route=extension/mt_materialize/module/mt_blog/post&post_id=' . (int)$post_id) . "'");
					}
				}
			}
		}

		if (isset($data['layout'])) {
			foreach ($data['post_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_layout SET post_id = '" . (int)$post_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('post');

		return $post_id;
	}

	public function getPosts($data = []) {
		$sql = "SELECT * FROM " . DB_PREFIX . "mt_post p LEFT JOIN " . DB_PREFIX . "mt_post_description pd ON (p.post_id = pd.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape((string)$data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
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
}