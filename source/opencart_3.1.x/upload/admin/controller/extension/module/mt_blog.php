<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ControllerExtensionModuleMTBlog extends Controller {
	private $error = [];

	public function install() {
		$this->load->model('extension/mt_materialize/module/mt_blog/module');

		$this->model_extension_mt_materialize_module_mt_blog->install();

		$this->installEvents();
	}

	public function uninstall() {
		$this->load->model('extension/mt_materialize/module/mt_blog/module');

		$this->model_extension_mt_materialize_module_mt_blog->uninstall();

		$this->uninstallEvents();
	}

	public function index() {
		$this->load->model('setting/setting');
		$this->load->model('tool/image');

		$this->load->language('extension/module/mt_blog');

		$this->document->setTitle($this->language->get('module_title'));

		$this->document->addScript('view/javascript/mt_materialize/js/materialize.js');
		$this->document->addScript('view/javascript/mt_materialize/js/common.js');
		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/ckeditor/adapters/jquery.js');

		$this->document->addStyle('view/stylesheet/mt_materialize/sass/materialize.css');
		$this->document->addStyle('//fonts.googleapis.com/css?family=Roboto');
		$this->document->addStyle('//fonts.googleapis.com/icon?family=Material+Icons');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_mt_blog', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module'));
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 60, 60);

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = false;
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text'	=> '<i class="material-icons">home</i>',
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text'	=> $this->language->get('text_extension'),
			'href'	=> $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		];

		$data['breadcrumbs'][] = [
			'text'	=> $this->language->get('module_title'),
			'href'	=> $this->url->link('extension/module/mt_blog', 'user_token=' . $this->session->data['user_token'])
		];

		$data['action'] = $this->url->link('extension/module/mt_blog', 'user_token=' . $this->session->data['user_token']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		if (isset($this->request->post['module_mt_blog_status'])) {
			$data['module_mt_blog_status'] = $this->request->post['module_mt_blog_status'];
		} else {
			$data['module_mt_blog_status'] = $this->config->get('module_mt_blog_status');
		}

		$data['post_form'] = $this->getPostForm();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/mt_blog', $data));
	}

	public function getPostForm() {
		$json = [];

		$this->load->model('localisation/language');
		$this->load->model('setting/store');
		$this->load->model('tool/image');
		$this->load->model('user/user');

		$this->load->language('extension/module/mt_blog');

		$data['user_token'] = $this->session->data['user_token'];

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 250, 250);

		$data['stores'] = [];

		$data['stores'][] = [
			'store_id'	=> 0,
			'name'		=> $this->language->get('text_default')
		];

		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = [
				'store_id'	=> $store['store_id'],
				'name'		=> $store['name']
			];
		}

		$data['user'] = [];

		$user = $this->model_user_user->getUser($this->user->getId());

		$data['user'] = [
			'user_id'	=> $user['user_id'],
			'name'		=> $user['firstname'] . ' ' . $user['lastname'],
			'image'		=> $this->model_tool_image->resize(html_entity_decode($user['image'], ENT_QUOTES, 'UTF-8'), 40, 40)
		];

		if (isset($this->request->get['post_id'])) {
			$post_id = (int)$this->request->get['post_id'];
		}  else {
			$post_id = 0;
		}

		$data['post_id'] = $post_id;

		/*if (isset($this->request->post['post'])) {
			$data['post'] = $this->request->post['post'];
		} elseif (!empty($product_info)) {
			$data['post'] = $this->model_catalog_product->getProductDescriptions($product_id);
		} else {
			$data['post'] = array();
		}*/
		$data['post'] = [];

		$data['post']['settings'] = [
			'enable_rating'		=> true,
			'enable_comment'	=> true
		];

		$json['post_form'] = $this->load->view('extension/mt_materialize/mt_blog/post_form', $data);

		/*$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));*/
		return $json['post_form'];
	}

	public function getPostList() {
		$json = [];

		$this->load->model('extension/mt_materialize/module/mt_blog/post');
		$this->load->model('tool/image');
		$this->load->model('user/user');

		$this->load->language('extension/module/mt_blog');

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 30, 30);

		$data['posts'] = [];

		$results = $this->model_extension_mt_materialize_module_mt_blog_post->getPosts();

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'))) {
				$image = $this->model_tool_image->resize(html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'), 30, 30);
			} else {
				$image = $data['placeholder'];
			}

			$user_info = $this->model_user_user->getUser($result['author_id']);

			$data['posts'][] = [
				'post_id'		=> $result['post_id'],
				'image'			=> $image,
				'name'			=> $result['name'],
				'author'		=> $user_info['firstname'] . ' ' . $user_info['lastname'],
				'status'		=> $result['status'],
				'date_added'	=> date($this->language->get('date_format_short'), strtotime($result['date_added']))
			];
		}

		$json['post_list'] = $this->load->view('extension/mt_materialize/mt_blog/post_list', $data);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function savePostForm() {
		$this->load->language('extension/module/mt_blog');

		$json = [];

		if ($this->validate($this->request->post)) {
			$this->load->model('extension/mt_materialize/module/mt_blog/post');

			if (!empty($this->request->get['post_id'])) {
				$json['post_id'] = $this->request->get['post_id'];
				/*$this->extension_mt_materialize_module_mt_blog_post->editPost($this->request->post, $this->request->get['post_id']);*/
			} else {
				if (!empty($this->request->post['post']['date_published_start']['date'])) {
					$date_published_start = $this->request->post['post']['date_published_start']['date'] . ' ' . (isset($this->request->post['post']['date_published_start']['time']) ? $this->request->post['post']['date_published_start']['time'] : '00:00');
				} else {
					$date_published_start = '';
				}

				unset($this->request->post['post']['date_published_start']['date']);
				unset($this->request->post['post']['date_published_start']['time']);

				$this->request->post['post']['date_published_start'] = $date_published_start;

				if (!empty($this->request->post['post']['date_published_end']['date'])) {
					$date_published_end = $this->request->post['post']['date_published_end']['date'] . ' ' . (isset($this->request->post['post']['date_published_end']['time']) ? $this->request->post['post']['date_published_end']['time'] : '00:00');
				} else {
					$date_published_end = '';
				}

				unset($this->request->post['post']['date_published_end']['date']);
				unset($this->request->post['post']['date_published_end']['time']);

				$this->request->post['post']['date_published_end'] = $date_published_end;

				$json['post_id'] = $this->model_extension_mt_materialize_module_mt_blog_post->addPost($this->request->post['post']);
			}

			$json['success'] = 'Success';
		} else {
			$json['error'] = $this->error;
		}

		$json['get'] = $this->request->get;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function saveModuleSettings() {
		$this->load->language('extension/module/mt_blog');

		$json = [];

		if ($this->validate()) {
			$this->load->model('setting/setting');

			if (isset($this->request->post['module_mt_blog_status'])) {
				$this->request->post['module_mt_blog_status'] = 1;
			}

			$this->model_setting_setting->editSetting('module_mt_blog', $this->request->post);

			$json['success'] = 'Success';
		} else {
			$json['error'] = 'Error';
		}

		$json['post'] = $this->request->post;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate($data = []) {
		if (!$this->user->hasPermission('modify', 'extension/module/mt_blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($data['post'])) {
			$post = $data['post'];

			foreach ($post['description'] as $language_id => $value) {
				if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
					$this->error['name'][$language_id] = $this->language->get('error_name');
				}

				if (utf8_strlen($value['announcement']) > 255) {
					$this->error['announcement'][$language_id] = $this->language->get('error_announcement');
				}
			}

			if ($post['seo']['meta']) {
				foreach ($post['seo']['meta'] as $language_id => $value) {
					if (utf8_strlen($value['title']) > 255) {
						$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
					}

					if (utf8_strlen($value['h1']) > 255) {
						$this->error['meta_h1'][$language_id] = $this->language->get('error_meta_h1');
					}
				}
			}
		}

		return !$this->error;
	}

	protected function installEvents() {
		/*$this->load->model('setting/event');

		$this->model_setting_event->addEvent('theme_mt_materialize_menu_item', 'admin/view/common/column_left/before', 'extension/theme/mt_materialize/adminMaterializeMenuItem');*/
	}

	protected function uninstallEvents() {
		/*$this->load->model('setting/event');

		$this->model_setting_event->deleteEventByCode('');*/
	}
}