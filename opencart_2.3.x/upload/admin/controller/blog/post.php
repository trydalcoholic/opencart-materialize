<?php
class ControllerBlogPost extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('blog/post');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('blog/post');

		$this->getList();
	}

	public function add() {
		$this->load->language('blog/post');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('blog/post');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_blog_post->addPost($this->request->post);

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

			$this->response->redirect($this->url->link('blog/post', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('blog/post');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('blog/post');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_blog_post->editPost($this->request->get['post_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('blog/post', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('blog/post');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('blog/post');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $post_id) {
				$this->model_blog_post->deletePost($post_id);
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

			$this->response->redirect($this->url->link('blog/post', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('blog/post');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('blog/post');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $post_id) {
				$this->model_blog_post->copyPost($post_id);
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

			$this->response->redirect($this->url->link('blog/post', 'token=' . $this->session->data['token'] . $url, true));
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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('blog/post', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('blog/post/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['copy'] = $this->url->link('blog/post/copy', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('blog/post/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['posts'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
            'filter_category' => $filter_category,
			'filter_status'   => $filter_status,
			'filter_image'    => $filter_image,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$post_total = $this->model_blog_post->getTotalPosts($filter_data);

		$results = $this->model_blog_post->getPosts($filter_data);

		$this->load->model('blog/category');

		$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC'
		);

		$data['categories'] = $this->model_blog_category->getCategories($filter_data);

		foreach ($results as $result) {

			$category =  $this->model_blog_post->getPostCategories($result['post_id']);

			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$data['posts'][] = array(
				'post_id'    => $result['post_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'category'   => $category,
				'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('blog/post/edit', 'token=' . $this->session->data['token'] . '&post_id=' . $result['post_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_materialize'] = $this->language->get('text_materialize');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_category'] = $this->language->get('column_category');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_image'] = $this->language->get('entry_image');

		$data['button_copy'] = $this->language->get('button_copy');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

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

		$data['sort_name'] = $this->url->link('blog/post', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_status'] = $this->url->link('blog/post', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('blog/post', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

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
		$pagination->url = $this->url->link('blog/post', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

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

		$this->response->setOutput($this->load->view('blog/post_list', $data));
	}

	protected function getForm() {
		//CKEditor
		if ($this->config->get('config_editor_default')) {
			$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
			$this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
		} else {
			$this->document->addScript('view/javascript/summernote/summernote.js');
			$this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
			$this->document->addScript('view/javascript/summernote/opencart.js');
			$this->document->addStyle('view/javascript/summernote/summernote.css');
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['post_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_h1'] = $this->language->get('entry_meta_h1');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_author'] = $this->language->get('entry_author');
		$data['entry_authors'] = $this->language->get('entry_authors');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_related'] = $this->language->get('entry_related');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_main_category'] = $this->language->get('entry_main_category');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_related'] = $this->language->get('help_related');
		$data['help_tag'] = $this->language->get('help_tag');
		$data['help_authors'] = $this->language->get('help_authors');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_apply'] = $this->language->get('button_apply');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_links'] = $this->language->get('tab_links');
		$data['tab_design'] = $this->language->get('tab_design');

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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('blog/post', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['post_id'])) {
			$data['action'] = $this->url->link('blog/post/add', 'token=' . $this->session->data['token'] . $url, true);
			$data['action_stay'] = $this->url->link('blog/post/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('blog/post/edit', 'token=' . $this->session->data['token'] . '&post_id=' . $this->request->get['post_id'] . $url, true);
			$data['action_stay'] = $this->url->link('blog/post/updateStay', 'token=' . $this->session->data['token'] . '&post_id=' . $this->request->get['post_id'] . $url, true);

			$data['post_page'] = HTTP_CATALOG.'index.php?route=blog/post&post_id='.$this->request->get['post_id'];
		}

		$data['cancel'] = $this->url->link('blog/post', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['post_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$post_info = $this->model_blog_post->getPost($this->request->get['post_id']);
		}

		$data['token'] = $this->session->data['token'];
		$data['ckeditor'] = $this->config->get('config_editor_default');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['lang'] = $this->language->get('lang');

		if (isset($this->request->post['post_description'])) {
			$data['post_description'] = $this->request->post['post_description'];
		} elseif (isset($this->request->get['post_id'])) {
			$data['post_description'] = $this->model_blog_post->getPostDescriptions($this->request->get['post_id']);
		} else {
			$data['post_description'] = array();
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['post_store'])) {
			$data['post_store'] = $this->request->post['post_store'];
		} elseif (isset($this->request->get['post_id'])) {
			$data['post_store'] = $this->model_blog_post->getPostStores($this->request->get['post_id']);
		} else {
			$data['post_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($post_info)) {
			$data['keyword'] = $post_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($post_info)) {
			$data['sort_order'] = $post_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($post_info)) {
			$data['status'] = $post_info['status'];
		} else {
			$data['status'] = true;
		}

		$this->load->model('blog/author');

		$data['authors'] = $this->model_blog_author->getAuthors();

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
			$author_info = $this->model_blog_author->getAuthor($post_info['author_id']);

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
			$authors = $this->model_blog_post->getPostAuthors($this->request->get['post_id']);
		} else {
			$authors = array();
		}

		$data['post_authors'] = array();

		foreach ($authors as $author_id) {
			$author_info = $this->model_blog_author->getAuthor($author_id);

			if ($author_info) {
				$data['post_authors'][] = array(
					'author_id'	=> $author_info['author_id'],
					'name'		=> $author_info['name']
				);
			}
		}

		// Categories
		$this->load->model('blog/category');

		$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC'
		);

		$data['categories'] = $this->model_blog_category->getCategories($filter_data);

		// Filters

		if (isset($this->request->post['main_category_id'])) {
			$data['main_category_id'] = $this->request->post['main_category_id'];
		} elseif (isset($post_info)) {
			$data['main_category_id'] = $this->model_blog_post->getPostMainCategoryId($this->request->get['post_id']);
		} else {
			$data['main_category_id'] = 0;
		}

		if (isset($this->request->post['post_category'])) {
			$data['post_category'] = $this->request->post['post_category'];
		} elseif (isset($this->request->get['post_id'])) {
			$data['post_category'] = $this->model_blog_post->getPostCategories($this->request->get['post_id']);
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
			$posts = $this->model_blog_post->getPostRelated($this->request->get['post_id']);
		} else {
			$posts = array();
		}

		$data['post_relateds'] = array();

		foreach ($posts as $post_id) {
			$related_info = $this->model_blog_post->getPost($post_id);

			if ($related_info) {
				$data['post_relateds'][] = array(
					'post_id' => $related_info['post_id'],
					'name'    => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['post_layout'])) {
			$data['post_layout'] = $this->request->post['post_layout'];
		} elseif (isset($this->request->get['post_id'])) {
			$data['post_layout'] = $this->model_blog_post->getPostLayouts($this->request->get['post_id']);
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

		$this->response->setOutput($this->load->view('blog/post_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'blog/post')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['post_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('blog/url_alias');

			$url_alias_info = $this->model_blog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['post_id']) && $url_alias_info['query'] != 'post_id=' . $this->request->get['post_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['post_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'blog/post')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'blog/post')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function updateStay() {
		$this->load->language('blog/post');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('blog/post');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_blog_post->editPost($this->request->get['post_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['post_id'])) {
				$url .= '&post_id=' . $this->request->get['post_id'];
			}
		
			$this->response->redirect($this->url->link('blog/post/edit', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getForm();
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('blog/post');

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
				'filter_name'  => $filter_name,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_blog_post->getPosts($filter_data);

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