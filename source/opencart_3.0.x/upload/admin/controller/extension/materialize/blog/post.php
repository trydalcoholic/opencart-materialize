<?php
class ControllerExtensionMaterializeBlogPost extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/materialize/blog/post');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('extension/materialize/blog');

		$this->getList();
	}

	public function add() {
		$this->load->language('extension/materialize/blog/post');
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
			$this->model_extension_materialize_blog->addPost($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('extension/materialize/blog/post');
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
			$this->model_extension_materialize_blog->editPost($this->request->get['post_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('extension/materialize/blog/post');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('extension/materialize/blog');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $post_id) {
				$this->model_extension_materialize_blog->deletePost($post_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}


			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('extension/materialize/blog/post');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('extension/materialize/blog');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $post_id) {
				$this->model_extension_materialize_blog->copyPost($post_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = NULL;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_image'])) {
			$filter_image = $this->request->get['filter_image'];
		} else {
			$filter_image = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('extension/materialize/blog/post/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['copy'] = $this->url->link('extension/materialize/blog/post/copy', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/materialize/blog/post/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['posts'] = array();

		$filter_data = array(
			'filter_name'		=> $filter_name,
			'filter_category'	=> $filter_category,
			'filter_status'		=> $filter_status,
			'filter_image'		=> $filter_image,
			'sort'				=> $sort,
			'order'				=> $order,
			'start'				=> ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'				=> $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$post_total = $this->model_extension_materialize_blog->getTotalPosts($filter_data);

		$results = $this->model_extension_materialize_blog->getPosts($filter_data);

		$this->load->model('extension/materialize/blog');

		$filter_data = array(
			'sort'	=> 'name',
			'order'	=> 'ASC'
		);

		$data['categories'] = $this->model_extension_materialize_blog->getCategories($filter_data);

		foreach ($results as $result) {
			$category =  $this->model_extension_materialize_blog->getPostCategories($result['post_id']);

			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$data['posts'][] = array(
				'post_id'	=> $result['post_id'],
				'image'		=> $image,
				'name'		=> $result['name'],
				'category'	=> $category,
				'status'	=> $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'		=> $this->url->link('extension/materialize/blog/post/edit', 'user_token=' . $this->session->data['user_token'] . '&post_id=' . $result['post_id'] . $url, true)
			);
		}

		$data['user_token'] = $this->session->data['user_token'];

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.name' . $url, true);
		$data['sort_status'] = $this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . '&sort=p.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $post_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($post_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($post_total - $this->config->get('config_limit_admin'))) ? $post_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $post_total, ceil($post_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_category'] = $filter_category;
		$data['filter_status'] = $filter_status;
		$data['filter_image'] = $filter_image;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/materialize/blog/post_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['post_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['post_id'])) {
			$data['action'] = $this->url->link('extension/materialize/blog/post/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
			$data['apply'] = $this->url->link('extension/materialize/blog/post/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/materialize/blog/post/edit', 'user_token=' . $this->session->data['user_token'] . '&post_id=' . $this->request->get['post_id'] . $url, true);
			$data['apply'] = $this->url->link('extension/materialize/blog/post/apply', 'user_token=' . $this->session->data['user_token'] . '&post_id=' . $this->request->get['post_id'] . $url, true);
			$data['post_page'] = HTTP_CATALOG . 'index.php?route=extension/materialize/blog/post&post_id=' . $this->request->get['post_id'];
		}

		$data['cancel'] = $this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['post_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$post_info = $this->model_extension_materialize_blog->getPost($this->request->get['post_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['post_description'])) {
			$data['post_description'] = $this->request->post['post_description'];
		} elseif (isset($this->request->get['post_id'])) {
			$data['post_description'] = $this->model_extension_materialize_blog->getPostDescriptions($this->request->get['post_id']);
		} else {
			$data['post_description'] = array();
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

		if (isset($this->request->post['post_store'])) {
			$data['post_store'] = $this->request->post['post_store'];
		} elseif (isset($this->request->get['post_id'])) {
			$data['post_store'] = $this->model_extension_materialize_blog->getPostStores($this->request->get['post_id']);
		} else {
			$data['post_store'] = array(0);
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($post_info)) {
			$data['sort_order'] = $post_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		if (isset($this->request->post['viewed'])) {
			$data['viewed'] = $this->request->post['viewed'];
		} elseif (!empty($post_info)) {
			$data['viewed'] = $post_info['viewed'];
		} else {
			$data['viewed'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($post_info)) {
			$data['status'] = $post_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['comment_status'])) {
			$data['comment_status'] = $this->request->post['comment_status'];
		} elseif (!empty($post_info)) {
			$data['comment_status'] = $post_info['comment_status'];
		} else {
			$data['comment_status'] = true;
		}

		$data['authors'] = $this->model_extension_materialize_blog->getAuthors();

		if (isset($this->request->post['author_id'])) {
			$data['author_id'] = $this->request->post['author_id'];
		} elseif (!empty($post_info)) {
			$data['author_id'] = $post_info['author_id'];
		} else {
			$data['author_id'] = 0;
		}

		if (isset($this->request->post['author'])) {
			$data['author'] = $this->request->post['author'];
		} elseif (!empty($post_info)) {
			$author_info = $this->model_extension_materialize_blog->getAuthor($post_info['author_id']);

			if ($author_info) {
				$data['author'] = $author_info['name'];
			} else {
				$data['author'] = '';
			}
		} else {
			$data['author'] = '';
		}

		// Authors
		if (isset($this->request->post['post_author'])) {
			$authors = $this->request->post['post_author'];
		} elseif (isset($this->request->get['post_id'])) {
			$authors = $this->model_extension_materialize_blog->getPostAuthors($this->request->get['post_id']);
		} else {
			$authors = array();
		}

		$data['post_authors'] = array();

		foreach ($authors as $author_id) {
			$author_info = $this->model_extension_materialize_blog->getAuthor($author_id);

			if ($author_info) {
				$data['post_authors'][] = array(
					'author_id'	=> $author_info['author_id'],
					'name'		=> $author_info['name']
				);
			}
		}

		// Categories

		if (isset($this->request->post['post_category'])) {
			$categories = $this->request->post['post_category'];
		} elseif (isset($this->request->get['post_id'])) {
			$categories = $this->model_extension_materialize_blog->getPostCategories($this->request->get['post_id']);
		} else {
			$categories = array();
		}

		$data['post_categories'] = array();

		foreach ($categories as $blog_category_id) {
			$category_info = $this->model_extension_materialize_blog->getCategory($blog_category_id);

			if ($category_info) {
				$data['post_categories'][] = array(
					'blog_category_id'	=> $category_info['blog_category_id'],
					'name'				=> ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Main category
		$filter_data = array(
			'sort'	=> 'name',
			'order'	=> 'ASC'
		);

		$data['categories'] = $this->model_extension_materialize_blog->getCategories($filter_data);

		// Filters
		if (isset($this->request->post['main_category_id'])) {
			$data['main_category_id'] = $this->request->post['main_category_id'];
		} elseif (isset($post_info)) {
			$data['main_category_id'] = $this->model_extension_materialize_blog->getPostMainCategoryId($this->request->get['post_id']);
		} else {
			$data['main_category_id'] = 0;
		}

		if (isset($this->request->post['post_category'])) {
			$data['post_category'] = $this->request->post['post_category'];
		} elseif (isset($this->request->get['post_id'])) {
			$data['post_category'] = $this->model_extension_materialize_blog->getPostCategories($this->request->get['post_id']);
		} else {
			$data['post_category'] = array();
		}

		// Image
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($post_info)) {
			$data['image'] = $post_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($post_info) && is_file(DIR_IMAGE . $post_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($post_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['post_related'])) {
			$posts = $this->request->post['post_related'];
		} elseif (isset($this->request->get['post_id'])) {
			$posts = $this->model_extension_materialize_blog->getPostRelated($this->request->get['post_id']);
		} else {
			$posts = array();
		}

		$data['post_relateds'] = array();

		foreach ($posts as $post_id) {
			$related_info = $this->model_extension_materialize_blog->getPost($post_id);

			if ($related_info) {
				$data['post_relateds'][] = array(
					'post_id'	=> $related_info['post_id'],
					'name'		=> $related_info['name']
				);
			}
		}

		if (isset($this->request->post['post_seo_url'])) {
			$data['post_seo_url'] = $this->request->post['post_seo_url'];
		} elseif (isset($this->request->get['post_id'])) {
			$data['post_seo_url'] = $this->model_extension_materialize_blog->getPostSeoUrls($this->request->get['post_id']);
		} else {
			$data['post_seo_url'] = array();
		}

		if (isset($this->request->post['post_layout'])) {
			$data['post_layout'] = $this->request->post['post_layout'];
		} elseif (isset($this->request->get['post_id'])) {
			$data['post_layout'] = $this->model_extension_materialize_blog->getPostLayouts($this->request->get['post_id']);
		} else {
			$data['post_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$this->response->setOutput($this->load->view('extension/materialize/blog/post_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/materialize/blog/post')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['post_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if ($this->request->post['post_seo_url']) {
			$this->load->model('design/seo_url');

			foreach ($this->request->post['post_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}

						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);

						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['post_id']) || (($seo_url['query'] != 'post_id=' . $this->request->get['post_id'])))) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');

								break;
							}
						}
					}
				}
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/materialize/blog/post')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'extension/materialize/blog/post')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function apply() {
		$this->load->language('extension/materialize/blog/post');
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
			$this->model_extension_materialize_blog->editPost($this->request->get['post_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

		if (isset($this->request->get['post_id'])) {
			$url .= '&post_id=' . $this->request->get['post_id'];
		}
			$this->response->redirect($this->url->link('extension/materialize/blog/post/edit', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('extension/materialize/blog');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'	=> $filter_name,
				'start'			=> 0,
				'limit'			=> $limit
			);

			$results = $this->model_extension_materialize_blog->getPosts($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'post_id'	=> $result['post_id'],
					'name'		=> strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}