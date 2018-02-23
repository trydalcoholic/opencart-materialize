<?php
class ControllerExtensionDashboardCallback extends Controller {
	private $error = array();

	public function uninstall() {
		$this->load->model('user/user_group');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/dashboard/callback');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/dashboard/callback');
	}

	public function index() {
		$this->load->language('extension/dashboard/callback');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('callback_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('dashboard_callback', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=dashboard', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_extension'),
			'href'	=> $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=dashboard', true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('heading_title'),
			'href'	=> $this->url->link('extension/dashboard/callback', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/dashboard/callback', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=dashboard', true);

		if (isset($this->request->post['dashboard_callback_width'])) {
			$data['dashboard_callback_width'] = $this->request->post['dashboard_callback_width'];
		} else {
			$data['dashboard_callback_width'] = $this->config->get('dashboard_callback_width');
		}

		$data['columns'] = array();

		for ($i = 3; $i <= 12; $i++) {
			$data['columns'][] = $i;
		}

		if (isset($this->request->post['dashboard_callback_status'])) {
			$data['dashboard_callback_status'] = $this->request->post['dashboard_callback_status'];
		} else {
			$data['dashboard_callback_status'] = $this->config->get('dashboard_callback_status');
		}

		if (isset($this->request->post['dashboard_callback_sort_order'])) {
			$data['dashboard_callback_sort_order'] = $this->request->post['dashboard_callback_sort_order'];
		} else {
			$data['dashboard_callback_sort_order'] = $this->config->get('dashboard_callback_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/dashboard/callback_form', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/dashboard/callback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function dashboard() {
		$this->load->language('extension/dashboard/callback');

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('extension/dashboard/callback');

		$data['need_call'] = $this->model_extension_dashboard_callback->getMaterializeTotalCallbacks(array('filter_status' => '0'));

		$data['callback'] = $this->url->link('extension/materialize/callback/callback', 'user_token=' . $this->session->data['user_token'], true);

		return $this->load->view('extension/dashboard/callback_info', $data);
	}
}