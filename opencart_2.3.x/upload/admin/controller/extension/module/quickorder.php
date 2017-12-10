<?php
class ControllerExtensionModuleQuickorder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/quickorder');

		$this->document->setTitle($this->language->get('quickorder_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_quickorder', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['quickorder_title'] = $this->language->get('quickorder_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_settings'] = $this->language->get('text_settings');
		$data['text_popup'] = $this->language->get('text_popup');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_enquiry'] = $this->language->get('text_enquiry');
		$data['text_call_time'] = $this->language->get('text_call_time');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_materialize'] = $this->language->get('text_materialize');

		$data['entry_phonemask'] = $this->language->get('entry_phonemask');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_button'] = $this->language->get('entry_button');
		$data['entry_success'] = $this->language->get('entry_success');
		$data['entry_fields'] = $this->language->get('entry_fields');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_checkout'] = $this->language->get('entry_checkout');

		$data['help_modaltitle'] = $this->language->get('help_modaltitle');
		$data['help_time'] = $this->language->get('help_time');
		$data['help_checkout'] = $this->language->get('help_checkout');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$this->load->model('catalog/information');

		$data['informations'] = $this->model_catalog_information->getInformations();

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['success'])) {
			$data['error_success'] = $this->error['success'];
		} else {
			$data['error_success'] = array();
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/quickorder', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/quickorder', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$module_quickorder = array();

		foreach ($data['languages'] as $key => $language) {
			$module_quickorder[$language['language_id']][] = $this->language->get('module_quickorder');
		}

		if (isset($this->request->post['module_quickorder'])) {
			$data['module_quickorder'] = $this->request->post['module_quickorder'];
		} elseif ($this->config->get('module_quickorder') == true) {
			$data['module_quickorder'] = $this->config->get('module_quickorder');
		} else {
			$data['module_quickorder'] = '';
		}

		if (isset($this->request->post['module_quickorder_name'])) {
			$data['module_quickorder_name'] = $this->request->post['module_quickorder_name'];
		} else {
			$data['module_quickorder_name'] = $this->config->get('module_quickorder_name');
		}

		if (isset($this->request->post['module_quickorder_name_required'])) {
			$data['module_quickorder_name_required'] = $this->request->post['module_quickorder_name_required'];
		} else {
			$data['module_quickorder_name_required'] = $this->config->get('module_quickorder_name_required');
		}

		if (isset($this->request->post['module_quickorder_email'])) {
			$data['module_quickorder_email'] = $this->request->post['module_quickorder_email'];
		} else {
			$data['module_quickorder_email'] = $this->config->get('module_quickorder_email');
		}

		if (isset($this->request->post['module_quickorder_email_required'])) {
			$data['module_quickorder_email_required'] = $this->request->post['module_quickorder_email_required'];
		} else {
			$data['module_quickorder_email_required'] = $this->config->get('module_quickorder_email_required');
		}

		if (isset($this->request->post['module_quickorder_enquiry'])) {
			$data['module_quickorder_enquiry'] = $this->request->post['module_quickorder_enquiry'];
		} else {
			$data['module_quickorder_enquiry'] = $this->config->get('module_quickorder_enquiry');
		}

		if (isset($this->request->post['module_quickorder_enquiry_required'])) {
			$data['module_quickorder_enquiry_required'] = $this->request->post['module_quickorder_enquiry_required'];
		} else {
			$data['module_quickorder_enquiry_required'] = $this->config->get('module_quickorder_enquiry_required');
		}

		if (isset($this->request->post['module_quickorder_calltime'])) {
			$data['module_quickorder_calltime'] = $this->request->post['module_quickorder_calltime'];
		} else {
			$data['module_quickorder_calltime'] = $this->config->get('module_quickorder_calltime');
		}

		if (isset($this->request->post['module_quickorder_calltime_required'])) {
			$data['module_quickorder_calltime_required'] = $this->request->post['module_quickorder_calltime_required'];
		} else {
			$data['module_quickorder_calltime_required'] = $this->config->get('module_quickorder_calltime_required');
		}

		if (isset($this->request->post['module_quickorder_phonemask_status'])) {
			$data['module_quickorder_phonemask_status'] = $this->request->post['module_quickorder_phonemask_status'];
		} else {
			$data['module_quickorder_phonemask_status'] = $this->config->get('module_quickorder_phonemask_status');
		}

		if (isset($this->request->post['module_quickorder_agreement'])) {
			$data['module_quickorder_agreement'] = $this->request->post['module_quickorder_agreement'];
		} else {
			$data['module_quickorder_agreement'] = $this->config->get('module_quickorder_agreement');
		}

		if (isset($this->request->post['module_quickorder_status'])) {
			$data['module_quickorder_status'] = $this->request->post['module_quickorder_status'];
		} else {
			$data['module_quickorder_status'] = $this->config->get('module_quickorder_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/quickorder', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/quickorder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['module_quickorder'] as $language_id => $value) {
			if (utf8_strlen($value['success']) < 1) {
				$this->error['success'][$language_id] = $this->language->get('error_success');
			}
		}

		return !$this->error;
	}
}