<?php
class ControllerExtensionMaterializeBlogAuthor extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/materialize/blog/author');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('extension/materialize/blog');

		$this->getList();
	}

	public function add() {
		$this->load->language('extension/materialize/blog/author');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('heading_title'));
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

		$this->load->model('extension/materialize/blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_materialize_blog->addAuthor($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/materialize/blog/author', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('extension/materialize/blog/author');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('heading_title'));
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

		$this->load->model('extension/materialize/blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_materialize_blog->editAuthor($this->request->get['author_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/materialize/blog/author', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('extension/materialize/blog/author');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('extension/materialize/blog');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $author_id) {
				$this->model_extension_materialize_blog->deleteAuthor($author_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/materialize/blog/author', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/materialize/blog/author', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('extension/materialize/blog/author/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/materialize/blog/author/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['authors'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$author_total = $this->model_extension_materialize_blog->getTotalAuthors();

		$results = $this->model_extension_materialize_blog->getAuthors($filter_data);

		foreach ($results as $result) {
			$data['authors'][] = array(
				'author_id'		=> $result['author_id'],
				'name'			=> $result['name'],
				'sort_order'	=> $result['sort_order'],
				'edit'			=> $this->url->link('extension/materialize/blog/author/edit', 'user_token=' . $this->session->data['user_token'] . '&author_id=' . $result['author_id'] . $url, true)
			);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/materialize/blog/author', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('extension/materialize/blog/author', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $author_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/materialize/blog/author', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($author_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($author_total - $this->config->get('config_limit_admin'))) ? $author_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $author_total, ceil($author_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/materialize/blog/author_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['author_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

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

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/materialize/blog/author', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['author_id'])) {
			$data['action'] = $this->url->link('extension/materialize/blog/author/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/materialize/blog/author/edit', 'user_token=' . $this->session->data['user_token'] . '&author_id=' . $this->request->get['author_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/materialize/blog/author', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['author_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$author_info = $this->model_extension_materialize_blog->getAuthor($this->request->get['author_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['author_description'])) {
			$data['author_description'] = $this->request->post['author_description'];
		} elseif (isset($this->request->get['author_id'])) {
			$data['author_description'] = $this->model_extension_materialize_blog->getAuthorDescriptions($this->request->get['author_id']);
		} else {
			$data['author_description'] = array();
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['blog_author_store'])) {
			$data['blog_author_store'] = $this->request->post['blog_author_store'];
		} elseif (isset($this->request->get['author_id'])) {
			$data['blog_author_store'] = $this->model_extension_materialize_blog->getAuthorStores($this->request->get['author_id']);
		} else {
			$data['blog_author_store'] = array(0);
		}

		if (isset($this->request->post['author_seo_url'])) {
			$data['author_seo_url'] = $this->request->post['author_seo_url'];
		} elseif (isset($this->request->get['author_id'])) {
			$data['author_seo_url'] = $this->model_extension_materialize_blog->getAuthorSeoUrls($this->request->get['author_id']);
		} else {
			$data['author_seo_url'] = array();
		}

		$this->load->model('setting/store');

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

		if (isset($this->request->post['author_store'])) {
			$data['author_store'] = $this->request->post['author_store'];
		} elseif (isset($this->request->get['author_id'])) {
			$data['author_store'] = $this->model_extension_materialize_blog->getAuthorStores($this->request->get['author_id']);
		} else {
			$data['author_store'] = array(0);
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($author_info)) {
			$data['image'] = $author_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($author_info) && is_file(DIR_IMAGE . $author_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($author_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($author_info)) {
			$data['sort_order'] = $author_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/materialize/blog/author_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/materialize/blog/author')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['author_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 64)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if ($this->request->post['author_seo_url']) {
			$this->load->model('design/seo_url');

			foreach ($this->request->post['author_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}

						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);

						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['author_id']) || (($seo_url['query'] != 'author_id=' . $this->request->get['author_id'])))) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');

								break;
							}
						}
					}
				}
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/materialize/blog/author')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('extension/materialize/blog/post');

		foreach ($this->request->post['selected'] as $author_id) {
			$post_total = $this->model_extension_materialize_blog_post->getTotalPostsByAuthorId($author_id);

			if ($post_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $post_total);
			}
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('extension/materialize/blog');

			$filter_data = array(
				'filter_name'	=> $this->request->get['filter_name'],
				'start'			=> 0,
				'limit'			=> 5
			);

			$results = $this->model_extension_materialize_blog->getAuthors($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'author_id'	=> $result['author_id'],
					'name'		=> strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}