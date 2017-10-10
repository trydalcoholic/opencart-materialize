<?php
class ControllerExtensionModuleCallback extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/callback');

		$this->document->setTitle($this->language->get('callback_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('callback', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['callback_title'] = $this->language->get('callback_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_settings'] = $this->language->get('text_settings');
		$data['text_popup'] = $this->language->get('text_popup');
		$data['text_call_action'] = $this->language->get('text_call_action');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_enquiry'] = $this->language->get('text_enquiry');
		$data['text_call_time'] = $this->language->get('text_call_time');
		$data['text_materialize'] = $this->language->get('text_materialize');

		$data['entry_phonemask'] = $this->language->get('entry_phonemask');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_success'] = $this->language->get('entry_success');
		$data['entry_fields'] = $this->language->get('entry_fields');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_time'] = $this->language->get('entry_time');

		$data['help_modaltitle'] = $this->language->get('help_modaltitle');
		$data['help_time'] = $this->language->get('help_time');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['error_callback_time'])) {
			$data['error_callback_time'] = $this->error['error_callback_time'];
		} else {
			$data['error_callback_time'] = '';
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
			'href' => $this->url->link('extension/module/callback', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/callback', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'] . '&type=module', true);

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (isset($this->request->post['callback_modaltitle' . $language['language_id']])) {
				$data['callback_modaltitle' . $language['language_id']] = $this->request->post['callback_modaltitle' . $language['language_id']];
				$data['callback_success' . $language['language_id']] = $this->request->post['callback_success' . $language['language_id']];
				$data['callback_title' . $language['language_id']] = $this->request->post['callback_title' . $language['language_id']];
				$data['callback_description' . $language['language_id']] = $this->request->post['callback_description' . $language['language_id']];
			} else {
				$data['callback_modaltitle' . $language['language_id']] = $this->config->get('callback_modaltitle' . $language['language_id']);
				$data['callback_success' . $language['language_id']] = $this->config->get('callback_success' . $language['language_id']);
				$data['callback_title' . $language['language_id']] = $this->config->get('callback_title' . $language['language_id']);
				$data['callback_description' . $language['language_id']] = $this->config->get('callback_description' . $language['language_id']);
			}
		}

		if (isset($this->request->post['callback_name'])) {
			$data['callback_name'] = $this->request->post['callback_name'];
		} else {
			$data['callback_name'] = $this->config->get('callback_name');
		}

		if (isset($this->request->post['callback_name_required'])) {
			$data['callback_name_required'] = $this->request->post['callback_name_required'];
		} else {
			$data['callback_name_required'] = $this->config->get('callback_name_required');
		}

		if (isset($this->request->post['callback_enquiry'])) {
			$data['callback_enquiry'] = $this->request->post['callback_enquiry'];
		} else {
			$data['callback_enquiry'] = $this->config->get('callback_enquiry');
		}

		if (isset($this->request->post['callback_enquiry_required'])) {
			$data['callback_enquiry_required'] = $this->request->post['callback_enquiry_required'];
		} else {
			$data['callback_enquiry_required'] = $this->config->get('callback_enquiry_required');
		}

		if (isset($this->request->post['callback_calltime'])) {
			$data['callback_calltime'] = $this->request->post['callback_calltime'];
		} else {
			$data['callback_calltime'] = $this->config->get('callback_calltime');
		}

		if (isset($this->request->post['callback_calltime_required'])) {
			$data['callback_calltime_required'] = $this->request->post['callback_calltime_required'];
		} else {
			$data['callback_calltime_required'] = $this->config->get('callback_calltime_required');
		}

		if (isset($this->request->post['callback_time'])) {
			$data['callback_time'] = $this->request->post['callback_time'];
		} else {
			$data['callback_time'] = $this->config->get('callback_time');
		}

		if (isset($this->request->post['callback_status'])) {
			$data['callback_status'] = $this->request->post['callback_status'];
		} else {
			$data['callback_status'] = $this->config->get('callback_status');
		}

		if (isset($this->request->post['callback_phonemask'])) {
			$data['callback_phonemask'] = $this->request->post['callback_phonemask'];
		} else {
			$data['callback_phonemask'] = $this->config->get('callback_phonemask');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/callback', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/callback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['callback_time']) < 1) || ($this->request->post['callback_time'] < 1)) {
			$this->error['error_callback_time'] = $this->language->get('error_time');
		}

		return !$this->error;
	}
}