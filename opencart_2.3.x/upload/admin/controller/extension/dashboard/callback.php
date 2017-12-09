<?php
class ControllerExtensionDashboardCallback extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/callback');

		$this->document->setTitle($this->language->get('callback_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('dashboard_callback', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=dashboard', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_materialize'] = $this->language->get('text_materialize');

		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=dashboard', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/dashboard/callback', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/dashboard/callback', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=dashboard', true);

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

		$data['callback_title'] = $this->language->get('callback_title');

		$data['text_view'] = $this->language->get('text_view');

		$data['token'] = $this->session->data['token'];

		$this->load->model('extension/dashboard/callback');

		$data['need_call'] = $this->model_extension_dashboard_callback->getMaterializeTotalCallbacks(array('filter_status' => '0'));

		$data['callback'] = $this->url->link('customer/callback', 'token=' . $this->session->data['token'], true);

		return $this->load->view('extension/dashboard/callback_info', $data);
	}
}