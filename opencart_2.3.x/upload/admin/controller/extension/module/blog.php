<?php
class ControllerExtensionModuleBlog extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/blog');

		$this->document->setTitle($this->language->get('blog_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('blog', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['blog_title'] = $this->language->get('blog_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_materialize'] = $this->language->get('text_materialize');
		$data['text_year'] = $this->language->get('text_year');
		$data['text_month'] = $this->language->get('text_month');

		$data['text_search'] = $this->language->get('text_search');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_recent_post'] = $this->language->get('text_recent_post');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['entry_search_status'] = $this->language->get('entry_search_status');
		$data['entry_search_sort_order'] = $this->language->get('entry_search_sort_order');
		$data['entry_category_status'] = $this->language->get('entry_category_status');
		$data['entry_category_sort_order'] = $this->language->get('entry_category_sort_order');
		$data['entry_post_status']  =  $this->language->get('entry_post_status');
		$data['entry_post_limit']  =  $this->language->get('entry_post_limit');
		$data['entry_post_sort_order']  =  $this->language->get('entry_post_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/blog', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/blog', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/blog', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/blog', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['search_status'])) {
			$data['search_status'] = $this->request->post['search_status'];
		} elseif (!empty($module_info)) {
			$data['search_status'] = $module_info['search_status'];
		} else {
			$data['search_status'] = '';
		}

		if (isset($this->request->post['search_sort_order'])) {
			$data['search_sort_order'] = $this->request->post['search_sort_order'];
		} elseif (!empty($module_info)) {
			$data['search_sort_order'] = $module_info['search_sort_order'];
		} else {
			$data['search_sort_order'] = '';
		}

		if (isset($this->request->post['category_status'])) {
			$data['category_status'] = $this->request->post['category_status'];
		} elseif (!empty($module_info)) {
			$data['category_status'] = $module_info['category_status'];
		} else {
			$data['category_status'] = '';
		}

		if (isset($this->request->post['category_sort_order'])) {
			$data['category_sort_order'] = $this->request->post['category_sort_order'];
		} elseif (!empty($module_info)) {
			$data['category_sort_order'] = $module_info['category_sort_order'];
		} else {
			$data['category_sort_order'] = '';
		}

		if (isset($this->request->post['post_status'])) {
			$data['post_status'] = $this->request->post['post_status'];
		} elseif (!empty($module_info)) {
			$data['post_status'] = $module_info['post_status'];
		} else {
			$data['post_status'] = '';
		}

		if (isset($this->request->post['post_limit'])) {
			$data['post_limit'] = $this->request->post['post_limit'];
		} elseif (!empty($module_info)) {
			$data['post_limit'] = $module_info['post_limit'];
		} else {
			$data['post_limit'] = '';
		}

		if (isset($this->request->post['post_sort_order'])) {
			$data['post_sort_order'] = $this->request->post['post_sort_order'];
		} elseif (!empty($module_info)) {
			$data['post_sort_order'] = $module_info['post_sort_order'];
		} else {
			$data['post_sort_order'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
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

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
}