<?php
class ControllerExtensionModuleBlog extends Controller {
	private $error = array();

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_author` (
				`author_id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(64) NOT NULL,
				`image` varchar(255) DEFAULT NULL,
				`sort_order` int(3) NOT NULL,
				PRIMARY KEY (`author_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_author_description` (
				`author_id` int(11) NOT NULL,
				`language_id` int(11) NOT NULL,
				`name` varchar(64) NOT NULL,
				`description` text NOT NULL,
				`meta_title` varchar(255) NOT NULL,
				`meta_h1` varchar(255) NOT NULL,
				`meta_description` varchar(255) NOT NULL,
				`meta_keyword` varchar(255) NOT NULL,
				PRIMARY KEY (`author_id`, `language_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_author_to_store` (
				`author_id` int(11) NOT NULL,
				`store_id` int(11) NOT NULL,
				PRIMARY KEY (`author_id`, `store_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_category` (
				`blog_category_id` int(11) NOT NULL AUTO_INCREMENT,
				`image` varchar(255) DEFAULT NULL,
				`parent_id` int(11) NOT NULL DEFAULT '0',
				`sort_order` int(3) NOT NULL DEFAULT '0',
				`status` tinyint(1) NOT NULL,
				`date_added` datetime NOT NULL,
				`date_modified` datetime NOT NULL,
				PRIMARY KEY (`blog_category_id`),
				INDEX (`parent_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_category_description` (
				`blog_category_id` int(11) NOT NULL,
				`language_id` int(11) NOT NULL,
				`name` varchar(255) NOT NULL,
				`description` text NOT NULL,
				`meta_title` varchar(255) NOT NULL,
				`meta_h1` varchar(255) NOT NULL,
				`meta_description` varchar(255) NOT NULL,
				`meta_keyword` varchar(255) NOT NULL,
				PRIMARY KEY (`blog_category_id`, `language_id`),
				INDEX (`name`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_category_path` (
				`blog_category_id` int(11) NOT NULL,
				`path_id` int(11) NOT NULL,
				`level` int(11) NOT NULL,
				PRIMARY KEY (`blog_category_id`, `path_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_category_to_layout` (
				`blog_category_id` int(11) NOT NULL,
				`store_id` int(11) NOT NULL,
				`layout_id` int(11) NOT NULL,
				PRIMARY KEY (`blog_category_id`, `store_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_category_to_store` (
				`blog_category_id` int(11) NOT NULL,
				`store_id` int(11) NOT NULL,
				PRIMARY KEY (`blog_category_id`, `store_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "post` (
				`post_id` int(11) NOT NULL AUTO_INCREMENT,
				`image` varchar(255) DEFAULT NULL,
				`sort_order` int(11) NOT NULL DEFAULT '0',
				`author_id` int(11) NOT NULL,
				`status` tinyint(1) NOT NULL DEFAULT '0',
				`comment_status` tinyint(1) NOT NULL DEFAULT '1',
				`viewed` int(5) NOT NULL DEFAULT '0',
				`date_added` datetime NOT NULL,
				`date_modified` datetime NOT NULL,
				PRIMARY KEY (`post_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "post_comment` (
				`comment_id` int(11) NOT NULL AUTO_INCREMENT,
				`post_id` int(11) NOT NULL,
				`author` varchar(64) NOT NULL,
				`email` varchar(32) NOT NULL,
				`text` text NOT NULL,
				`status` tinyint(1) NOT NULL DEFAULT '0',
				`date_added` datetime NOT NULL,
				`date_modified` datetime NOT NULL,
				PRIMARY KEY (`comment_id`),
				INDEX (`post_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "post_description` (
				`post_id` int(11) NOT NULL,
				`language_id` int(11) NOT NULL,
				`name` varchar(255) NOT NULL,
				`description` text NOT NULL,
				`tag` text NOT NULL,
				`meta_title` varchar(255) NOT NULL,
				`meta_h1` varchar(255) NOT NULL,
				`meta_description` varchar(255) NOT NULL,
				`meta_keyword` varchar(255) NOT NULL,
				PRIMARY KEY (`post_id`, `language_id`),
				INDEX (`name`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "post_related` (
				`post_id` int(11) NOT NULL,
				`related_id` int(11) NOT NULL,
				PRIMARY KEY (`post_id`, `related_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "post_to_author` (
				`post_id` int(11) NOT NULL,
				`author_id` int(11) NOT NULL,
				PRIMARY KEY (`post_id`, `author_id`),
				INDEX (`author_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "post_to_category` (
				`post_id` int(11) NOT NULL,
				`blog_category_id` int(11) NOT NULL,
				`main_category` tinyint(1) NOT NULL DEFAULT '0',
				PRIMARY KEY (`post_id`, `blog_category_id`),
				INDEX (`blog_category_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "post_to_layout` (
				`post_id` int(11) NOT NULL,
				`store_id` int(11) NOT NULL,
				`layout_id` int(11) NOT NULL,
				PRIMARY KEY (`post_id`, `store_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "post_to_store` (
				`post_id` int(11) NOT NULL,
				`store_id` int(11) NOT NULL DEFAULT '0',
				PRIMARY KEY (`post_id`, `store_id`)
			) ENGINE=MyISAM;
		");

		$this->load->model('setting/setting');

		$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name = 'Blog';");

		$data['module_blog_layout_id'] = $this->db->getLastId();

		$layout_routes = array(
			'extension/materialize/blog/blog',
			'extension/materialize/blog/category',
			'extension/materialize/blog/search',
			'extension/materialize/blog/author',
			'extension/materialize/blog/author/info',
			'extension/materialize/blog/post'
		);

		foreach ($layout_routes as $layout_route) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = '" . (int)$data['module_blog_layout_id'] . "', store_id = '0', route = '" . $layout_route . "'");
		}

		$this->load->model('user/user_group');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/materialize/blog/category');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/materialize/blog/category');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/materialize/blog/post');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/materialize/blog/post');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/materialize/blog/author');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/materialize/blog/author');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/materialize/blog/comment');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/materialize/blog/comment');

		$data['module_blog_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('module_blog', $data);
	}

	public function uninstall() {
		$this->load->model('extension/materialize/blog');

		$query = $this->db->query("SELECT author_id FROM " . DB_PREFIX . "blog_author");

		foreach ($query as $author_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'author_id=" . (int)$author_id . "'");
		}

		$query = $this->db->query("SELECT blog_category_id FROM " . DB_PREFIX . "blog_category");

		foreach ($query as $blog_category_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'blog_category_id=" . (int)$blog_category_id . "'");
		}

		$query = $this->db->query("SELECT post_id FROM " . DB_PREFIX . "post");

		foreach ($query as $post_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'post_id=" . (int)$post_id . "'");
		}

		$this->db->query("
			DROP TABLE IF EXISTS
				`" . DB_PREFIX . "blog_author`,
				`" . DB_PREFIX . "blog_author_description`,
				`" . DB_PREFIX . "blog_author_to_store`,
				`" . DB_PREFIX . "blog_category`,
				`" . DB_PREFIX . "blog_category_description`,
				`" . DB_PREFIX . "blog_category_path`,
				`" . DB_PREFIX . "blog_category_to_layout`,
				`" . DB_PREFIX . "blog_category_to_store`,
				`" . DB_PREFIX . "post`,
				`" . DB_PREFIX . "post_comment`,
				`" . DB_PREFIX . "post_description`,
				`" . DB_PREFIX . "post_related`,
				`" . DB_PREFIX . "post_to_author`,
				`" . DB_PREFIX . "post_to_category`,
				`" . DB_PREFIX . "post_to_layout`,
				`" . DB_PREFIX . "post_to_store`
			;
		");

		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'extension/materialize/blog/blog';");
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'extension/materialize/blog/author';");

		$this->load->model('setting/setting');

		$data['module_blog_layout_id'] = $this->config->get('module_blog_layout_id');

		$this->db->query("DELETE FROM " . DB_PREFIX . "layout WHERE layout_id = '" . (int)$data['module_blog_layout_id'] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "layout_route WHERE layout_id = '" . (int)$data['module_blog_layout_id'] . "'");

		$this->load->model('user/user_group');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/materialize/blog/category');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/materialize/blog/category');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/materialize/blog/post');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/materialize/blog/post');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/materialize/blog/author');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/materialize/blog/author');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/materialize/blog/comment');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/materialize/blog/comment');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/blog');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/blog');
	}

	public function index() {
		$this->load->language('extension/module/blog');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('blog_title'));
		$this->document->addScript('view/javascript/codemirror/lib/codemirror.js');
		$this->document->addScript('view/javascript/codemirror/lib/xml.js');
		$this->document->addScript('view/javascript/codemirror/lib/formatting.js');
		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addScript('view/javascript/summernote/summernote-image-attributes.js');
		$this->document->addScript('view/javascript/summernote/opencart.js');
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/codemirror/lib/codemirror.css');
		$this->document->addStyle('view/javascript/codemirror/theme/monokai.css');
		$this->document->addStyle('view/javascript/summernote/summernote.css');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('localisation/language');

		$this->load->model('setting/extension');

		$this->load->model('setting/setting');

		$this->load->model('setting/store');

		$this->load->model('extension/materialize/blog');

		$this->load->model('extension/materialize/materialize');

		$query = 'extension/materialize/blog/blog';

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_blog', $this->request->post);

			$this->model_extension_materialize_blog->addBlogSeoUrl($this->request->post, $query);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_module'),
			'href'	=> $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('heading_title'),
			'href'	=> $this->url->link('extension/module/blog', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/blog', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$data['clear'] = $this->url->link('extension/module/blog/cacheClear', 'user_token=' . $this->session->data['user_token'], true);

		$data['languages'] = $this->model_localisation_language->getLanguages();

		/* Multi languages fields */

		$module_blog = array();

		foreach ($data['languages'] as $key => $language) {
			$module_blog[$language['language_id']][] = $this->language->get('module_blog');
		}

		if (isset($this->request->post['module_blog'])) {
			$data['module_blog'] = $this->request->post['module_blog'];
		} elseif ($this->config->get('module_blog') == true) {
			$data['module_blog'] = $this->config->get('module_blog');
		} else {
			$data['module_blog'] = '';
		}

		if (isset($this->request->post['module_blog_layout_id'])) {
			$data['module_blog_layout_id'] = $this->config->get('module_blog_layout_id');
		} else {
			$data['module_blog_layout_id'] = $this->config->get('module_blog_layout_id');
		}

		if (isset($this->request->post['module_blog_installed_appeal'])) {
			$data['module_blog_installed_appeal'] = $this->request->post['module_blog_installed_appeal'];
		} else {
			$data['module_blog_installed_appeal'] = $this->config->get('module_blog_installed_appeal');
		}

		/* Options */

		if (isset($this->request->post['module_blog_post_limit'])) {
			$data['module_blog_post_limit'] = $this->request->post['module_blog_post_limit'];
		} elseif ($this->config->get('module_blog_post_limit') == true) {
			$data['module_blog_post_limit'] = $this->config->get('module_blog_post_limit');
		} else {
			$data['module_blog_post_limit'] = '18';
		}

		if (isset($this->request->post['module_blog_views_status'])) {
			$data['module_blog_views_status'] = $this->request->post['module_blog_views_status'];
		} else {
			$data['module_blog_views_status'] = $this->config->get('module_blog_views_status');
		}

		if (isset($this->request->post['module_blog_link_status'])) {
			$data['module_blog_link_status'] = $this->request->post['module_blog_link_status'];
		} else {
			$data['module_blog_link_status'] = $this->config->get('module_blog_link_status');
		}

		if (isset($this->request->post['module_blog_comment_status'])) {
			$data['module_blog_comment_status'] = $this->request->post['module_blog_comment_status'];
		} else {
			$data['module_blog_comment_status'] = $this->config->get('module_blog_comment_status');
		}

		/* Captchas */

		if (isset($this->request->post['module_blog_config_captcha'])) {
			$data['module_blog_config_captcha'] = $this->request->post['module_blog_config_captcha'];
		} else {
			$data['module_blog_config_captcha'] = $this->config->get('module_blog_config_captcha');
		}

		$data['captchas'] = array();

		$extensions = $this->model_setting_extension->getInstalled('captcha');

		foreach ($extensions as $code) {
			$this->load->language('extension/captcha/' . $code, 'extension');

			if ($this->config->get('captcha_' . $code . '_status')) {
				$data['captchas'][] = array(
					'text'	=> $this->language->get('extension')->get('heading_title'),
					'value'	=> $code
				);
			}
		}

		/* Seo */

		$blog_seo_info = array();

		$results = $this->model_extension_materialize_blog->getSeoUrlInfoMaterializeBlogByQuery($query);

		foreach ($results as $result) {
			$blog_seo_info[] = array(
				'seo_url_id'	=> $result['seo_url_id'],
				'query'			=> $result['query']
			);
		}

		if (!empty($blog_seo_info)) {
			$blog_seo_url_id = $blog_seo_info[0]['seo_url_id'];
		} else {
			$blog_seo_url_id = '';
		}

		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id'	=> 0,
			'name'		=> $this->language->get('text_default')
		);

		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id'	=> $store['store_id'],
				'name'		=> $store['name']
			);
		}

		if (isset($this->request->post['module_blog_seo_url'])) {
			$data['module_blog_seo_url'] = $this->request->post['module_blog_seo_url'];
		} elseif (!empty($blog_seo_url_id)) {
			$data['module_blog_seo_url'] = $this->model_extension_materialize_blog->getSeoUrlMaterializeBlogByQuery($query);
		} else {
			$data['module_blog_seo_url'] = array();
		}

		/* Colors */

		$data['module_blog_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();
		$data['module_blog_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

		if (isset($this->request->post['module_blog_color_snippet'])) {
			$data['module_blog_color_snippet'] = $this->request->post['module_blog_color_snippet'];
		} elseif ($this->config->get('module_blog_color_snippet') == true) {
			$data['module_blog_color_snippet'] = $this->config->get('module_blog_color_snippet');
		} else {
			$data['module_blog_color_snippet'] = 'blue-grey';
		}

		if (isset($this->request->post['module_blog_color_title'])) {
			$data['module_blog_color_title'] = $this->request->post['module_blog_color_title'];
		} elseif ($this->config->get('module_blog_color_title') == true) {
			$data['module_blog_color_title'] = $this->config->get('module_blog_color_title');
		} else {
			$data['module_blog_color_title'] = 'white-text';
		}

		if (isset($this->request->post['module_blog_color_tabs'])) {
			$data['module_blog_color_tabs'] = $this->request->post['module_blog_color_tabs'];
		} elseif ($this->config->get('module_blog_color_tabs') == true) {
			$data['module_blog_color_tabs'] = $this->config->get('module_blog_color_tabs');
		} else {
			$data['module_blog_color_tabs'] = 'blue-grey lighten-5';
		}

		if (isset($this->request->post['module_blog_color_tabs_icon'])) {
			$data['module_blog_color_tabs_icon'] = $this->request->post['module_blog_color_tabs_icon'];
		} elseif ($this->config->get('module_blog_color_tabs_icon') == true) {
			$data['module_blog_color_tabs_icon'] = $this->config->get('module_blog_color_tabs_icon');
		} else {
			$data['module_blog_color_tabs_icon'] = 'blue-grey-text text-darken-4';
		}

		if (isset($this->request->post['module_blog_color_tabs_indicator'])) {
			$data['module_blog_color_tabs_indicator'] = $this->request->post['module_blog_color_tabs_indicator'];
		} elseif ($this->config->get('module_blog_color_tabs_indicator') == true) {
			$data['module_blog_color_tabs_indicator'] = $this->config->get('module_blog_color_tabs_indicator');
		} else {
			$data['module_blog_color_tabs_indicator'] = 'blue-grey';
		}

		if (isset($this->request->post['module_blog_color_tabs_indicator_hex'])) {
			$data['module_blog_color_tabs_indicator_hex'] = $this->request->post['module_blog_color_tabs_indicator_hex'];
		} elseif ($this->config->get('module_blog_color_tabs_indicator_hex') == true) {
			$data['module_blog_color_tabs_indicator_hex'] = $this->config->get('module_blog_color_tabs_indicator_hex');
		} else {
			$data['module_blog_color_tabs_indicator_hex'] = '#607d8b';
		}

		/* Status */

		if (isset($this->request->post['module_blog_status'])) {
			$data['module_blog_status'] = $this->request->post['module_blog_status'];
		} else {
			$data['module_blog_status'] = $this->config->get('module_blog_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/blog', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['module_blog_status'] == 1) {
			foreach ($this->request->post['module_blog'] as $language_id => $value) {
				if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 64)) {
					$this->error['name'][$language_id] = $this->language->get('error_name');
				}
			}

			if ($this->request->post['module_blog_seo_url']) {
				$this->load->model('design/seo_url');

				$query = 'extension/materialize/blog/blog';

				foreach ($this->request->post['module_blog_seo_url'] as $store_id => $language) {
					foreach ($language as $language_id => $keyword) {
						if (!empty($keyword)) {
							if (count(array_keys($language, $keyword)) > 1) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
							}

							$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);

							foreach ($seo_urls as $seo_url) {
								if (($seo_url['store_id'] == $store_id) && ($seo_url['query'] != $query)) {
									$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');

									break;
								}
							}
						}
					}
				}
			}
		}

		return !$this->error;
	}
}