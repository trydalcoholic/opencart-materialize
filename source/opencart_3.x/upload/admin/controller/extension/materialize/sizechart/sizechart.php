<?php
class ControllerExtensionMaterializeSizechartSizechart extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/materialize/sizechart/sizechart');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('extension/materialize/sizechart');

		$this->getList();
	}

	public function add() {
		$this->load->language('extension/materialize/sizechart/sizechart');
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

		$this->load->model('extension/materialize/sizechart');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_materialize_sizechart->addSizechart($this->request->post);

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

			$this->response->redirect($this->url->link('extension/materialize/sizechart/sizechart', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('extension/materialize/sizechart/sizechart');
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

		$this->load->model('extension/materialize/sizechart');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_materialize_sizechart->editSizechart($this->request->get['sizechart_group_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('extension/materialize/sizechart/sizechart', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('extension/materialize/sizechart/sizechart');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('extension/materialize/sizechart');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $sizechart_group_id) {
				$this->model_extension_materialize_sizechart->deleteSizechart($sizechart_group_id);
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

			$this->response->redirect($this->url->link('extension/materialize/sizechart/sizechart', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'msgd.name';
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
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('heading_title'),
			'href'	=> $this->url->link('extension/materialize/sizechart/sizechart', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('extension/materialize/sizechart/sizechart/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/materialize/sizechart/sizechart/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['sizecharts'] = array();

		$filter_data = array(
			'sort'	=> $sort,
			'order'	=> $order,
			'start'	=> ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'	=> $this->config->get('config_limit_admin')
		);

		$sizechart_total = $this->model_extension_materialize_sizechart->getTotalSizechartGroups();

		$results = $this->model_extension_materialize_sizechart->getSizechartGroups($filter_data);

		foreach ($results as $result) {
			$data['sizecharts'][] = array(
				'sizechart_group_id'	=> $result['sizechart_group_id'],
				'name'					=> $result['name'],
				'sort_order'			=> $result['sort_order'],
				'edit'					=> $this->url->link('extension/materialize/sizechart/sizechart/edit', 'user_token=' . $this->session->data['user_token'] . '&sizechart_group_id=' . $result['sizechart_group_id'] . $url, true)
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

		$data['sort_name'] = $this->url->link('extension/materialize/sizechart/sizechart', 'user_token=' . $this->session->data['user_token'] . '&sort=msgd.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('extension/materialize/sizechart/sizechart', 'user_token=' . $this->session->data['user_token'] . '&sort=msg.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $sizechart_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/materialize/sizechart/sizechart', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($sizechart_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sizechart_total - $this->config->get('config_limit_admin'))) ? $sizechart_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sizechart_total, ceil($sizechart_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/materialize/sizechart/sizechart_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['sizechart_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['group'])) {
			$data['error_group'] = $this->error['group'];
		} else {
			$data['error_group'] = array();
		}

		if (isset($this->error['sizechart'])) {
			$data['error_sizechart'] = $this->error['sizechart'];
		} else {
			$data['error_sizechart'] = array();
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('heading_title'),
			'href'	=> $this->url->link('extension/materialize/sizechart/sizechart', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['sizechart_group_id'])) {
			$data['action'] = $this->url->link('extension/materialize/sizechart/sizechart/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/materialize/sizechart/sizechart/edit', 'user_token=' . $this->session->data['user_token'] . '&sizechart_group_id=' . $this->request->get['sizechart_group_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/materialize/sizechart/sizechart', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['sizechart_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$sizechart_group_info = $this->model_extension_materialize_sizechart->getSizechartGroup($this->request->get['sizechart_group_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['current_language'] = $this->config->get('config_language_id');

		if (isset($this->request->post['sizechart_group_description'])) {
			$data['sizechart_group_description'] = $this->request->post['sizechart_group_description'];
		} elseif (isset($this->request->get['sizechart_group_id'])) {
			$data['sizechart_group_description'] = $this->model_extension_materialize_sizechart->getSizechartGroupDescriptions($this->request->get['sizechart_group_id']);
		} else {
			$data['sizechart_group_description'] = array();
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($sizechart_group_info)) {
			$data['sort_order'] = $sizechart_group_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['sizechart'])) {
			$data['sizecharts'] = $this->request->post['sizechart'];
		} elseif (isset($this->request->get['sizechart_group_id'])) {
			$data['sizecharts'] = $this->model_extension_materialize_sizechart->getSizechartDescriptions($this->request->get['sizechart_group_id']);
		} else {
			$data['sizecharts'] = array();
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/materialize/sizechart/sizechart_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/materialize/sizechart/sizechart')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['sizechart_group_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 64)) {
				$this->error['group'][$language_id] = $this->language->get('error_group');
			}
		}

		if (isset($this->request->post['sizechart'])) {
			foreach ($this->request->post['sizechart'] as $sizechart_id => $sizechart) {
				foreach ($sizechart['sizechart_description'] as $language_id => $sizechart_description) {
					if ((utf8_strlen($sizechart_description['name']) < 1) || (utf8_strlen($sizechart_description['name']) > 64)) {
						$this->error['sizechart'][$sizechart_id][$language_id] = $this->language->get('error_name');
					}
				}
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/materialize/sizechart/sizechart')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('extension/materialize/sizechart');

			$sizechart_data = array(
				'filter_name'	=> $this->request->get['filter_name'],
				'start'			=> 0,
				'limit'			=> 5
			);

			$sizecharts = $this->model_extension_materialize_sizechart->getSizecharts($sizechart_data);

			foreach ($sizecharts as $sizechart) {
				$json[] = array(
					'sizechart_id'	=> $sizechart['sizechart_id'],
					'name'			=> strip_tags(html_entity_decode($sizechart['group'] . ' &gt; ' . $sizechart['name'], ENT_QUOTES, 'UTF-8'))
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