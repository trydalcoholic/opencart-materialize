<?php
class ControllerExtensionModuleBlog extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/blog');

		$this->document->setTitle($this->language->get('blog_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('blog', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/blog', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/blog', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/blog', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/blog', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
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