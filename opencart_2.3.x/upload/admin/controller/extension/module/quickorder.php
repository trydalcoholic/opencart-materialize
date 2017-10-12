<?php
class ControllerExtensionModuleQuickorder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/quickorder');

		$this->document->setTitle($this->language->get('quickorder_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('quickorder', $this->request->post);

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

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'] . '&type=module', true);

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (isset($this->request->post['quickorder_modaltitle' . $language['language_id']])) {
				$data['quickorder_modaltitle' . $language['language_id']] = $this->request->post['quickorder_modaltitle' . $language['language_id']];
				$data['quickorder_button' . $language['language_id']] = $this->request->post['quickorder_button' . $language['language_id']];
				$data['quickorder_success' . $language['language_id']] = $this->request->post['quickorder_success' . $language['language_id']];
			} else {
				$data['quickorder_modaltitle' . $language['language_id']] = $this->config->get('quickorder_modaltitle' . $language['language_id']);
				$data['quickorder_button' . $language['language_id']] = $this->config->get('quickorder_button' . $language['language_id']);
				$data['quickorder_success' . $language['language_id']] = $this->config->get('quickorder_success' . $language['language_id']);
			}
		}

		if (isset($this->request->post['quickorder_name'])) {
			$data['quickorder_name'] = $this->request->post['quickorder_name'];
		} else {
			$data['quickorder_name'] = $this->config->get('quickorder_name');
		}

		if (isset($this->request->post['quickorder_name_required'])) {
			$data['quickorder_name_required'] = $this->request->post['quickorder_name_required'];
		} else {
			$data['quickorder_name_required'] = $this->config->get('quickorder_name_required');
		}

		if (isset($this->request->post['quickorder_email'])) {
			$data['quickorder_email'] = $this->request->post['quickorder_email'];
		} else {
			$data['quickorder_email'] = $this->config->get('quickorder_email');
		}

		if (isset($this->request->post['quickorder_email_required'])) {
			$data['quickorder_email_required'] = $this->request->post['quickorder_email_required'];
		} else {
			$data['quickorder_email_required'] = $this->config->get('quickorder_email_required');
		}

		if (isset($this->request->post['quickorder_enquiry'])) {
			$data['quickorder_enquiry'] = $this->request->post['quickorder_enquiry'];
		} else {
			$data['quickorder_enquiry'] = $this->config->get('quickorder_enquiry');
		}

		if (isset($this->request->post['quickorder_enquiry_required'])) {
			$data['quickorder_enquiry_required'] = $this->request->post['quickorder_enquiry_required'];
		} else {
			$data['quickorder_enquiry_required'] = $this->config->get('quickorder_enquiry_required');
		}

		if (isset($this->request->post['quickorder_calltime'])) {
			$data['quickorder_calltime'] = $this->request->post['quickorder_calltime'];
		} else {
			$data['quickorder_calltime'] = $this->config->get('quickorder_calltime');
		}

		if (isset($this->request->post['quickorder_calltime_required'])) {
			$data['quickorder_calltime_required'] = $this->request->post['quickorder_calltime_required'];
		} else {
			$data['quickorder_calltime_required'] = $this->config->get('quickorder_calltime_required');
		}

		if (isset($this->request->post['quickorder_status'])) {
			$data['quickorder_status'] = $this->request->post['quickorder_status'];
		} else {
			$data['quickorder_status'] = $this->config->get('quickorder_status');
		}

		if (isset($this->request->post['quickorder_phonemask'])) {
			$data['quickorder_phonemask'] = $this->request->post['quickorder_phonemask'];
		} else {
			$data['quickorder_phonemask'] = $this->config->get('quickorder_phonemask');
		}

		if (isset($this->request->post['quickorder_agreement'])) {
			$data['quickorder_agreement'] = $this->request->post['quickorder_agreement'];
		} else {
			$data['quickorder_agreement'] = $this->config->get('quickorder_agreement');
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

		return !$this->error;
	}
}