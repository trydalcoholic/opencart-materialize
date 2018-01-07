<?php
class ControllerExtensionModuleCallback extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/callback');

		$this->document->setTitle($this->language->get('callback_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('setting/setting');

		$this->load->model('extension/module/materialize');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_callback', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$this->load->model('catalog/information');

		$data['informations'] = $this->model_catalog_information->getInformations();

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
		$data['text_none'] = $this->language->get('text_none');
		$data['text_materialize'] = $this->language->get('text_materialize');

		$data['entry_phonemask'] = $this->language->get('entry_phonemask');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_success'] = $this->language->get('entry_success');
		$data['entry_fields'] = $this->language->get('entry_fields');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_button_color'] = $this->language->get('entry_button_color');
		$data['entry_text_button'] = $this->language->get('entry_text_button');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_time'] = $this->language->get('entry_time');
		$data['entry_agreement'] = $this->language->get('entry_agreement');

		$data['help_time'] = $this->language->get('help_time');
		$data['help_agreement'] = $this->language->get('help_agreement');

		$data['error_time'] = $this->language->get('error_time');
		$data['error_success'] = $this->language->get('error_success');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['appeal_marketplace'] = $this->language->get('appeal_marketplace');
		$data['appeal_github'] = $this->language->get('appeal_github');
		$data['appeal_twitter'] = $this->language->get('appeal_twitter');
		$data['appeal_paypal'] = $this->language->get('appeal_paypal');
		$data['appeal_yandex_money'] = $this->language->get('appeal_yandex_money');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

		if (isset($this->error['text_button'])) {
			$data['error_text_button'] = $this->error['text_button'];
		} else {
			$data['error_text_button'] = array();
		}

		if (isset($this->error['success'])) {
			$data['error_success'] = $this->error['success'];
		} else {
			$data['error_success'] = array();
		}

		if (isset($this->error['error_module_callback_time'])) {
			$data['error_module_callback_time'] = $this->error['error_module_callback_time'];
		} else {
			$data['error_module_callback_time'] = '';
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

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$module_callback = array();

		foreach ($data['languages'] as $key => $language) {
			$module_callback[$language['language_id']][] = $this->language->get('module_callback');
		}

		if (isset($this->request->post['module_callback'])) {
			$data['module_callback'] = $this->request->post['module_callback'];
		} elseif ($this->config->get('module_callback') == true) {
			$data['module_callback'] = $this->config->get('module_callback');
		} else {
			$data['module_callback'] = '';
		}

		$data['module_callback_colors'] = $this->model_extension_module_materialize->getMaterializeColors();
		$data['module_callback_colors_text'] = $this->model_extension_module_materialize->getMaterializeColorsText();

		if (isset($this->request->post['module_callback_color_btn'])) {
			$data['module_callback_color_btn'] = $this->request->post['module_callback_color_btn'];
		} elseif ($this->config->get('module_callback_color_btn') == true) {
			$data['module_callback_color_btn'] = $this->config->get('module_callback_color_btn');
		} else {
			$data['module_callback_color_btn'] = 'red';
		}

		if (isset($this->request->post['module_callback_color_btn_text'])) {
			$data['module_callback_color_btn_text'] = $this->request->post['module_callback_color_btn_text'];
		} elseif ($this->config->get('module_callback_color_btn_text') == true) {
			$data['module_callback_color_btn_text'] = $this->config->get('module_callback_color_btn_text');
		} else {
			$data['module_callback_color_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['module_callback_name'])) {
			$data['module_callback_name'] = $this->request->post['module_callback_name'];
		} else {
			$data['module_callback_name'] = $this->config->get('module_callback_name');
		}

		if (isset($this->request->post['module_callback_name_required'])) {
			$data['module_callback_name_required'] = $this->request->post['module_callback_name_required'];
		} else {
			$data['module_callback_name_required'] = $this->config->get('module_callback_name_required');
		}

		if (isset($this->request->post['module_callback_enquiry'])) {
			$data['module_callback_enquiry'] = $this->request->post['module_callback_enquiry'];
		} else {
			$data['module_callback_enquiry'] = $this->config->get('module_callback_enquiry');
		}

		if (isset($this->request->post['module_callback_enquiry_required'])) {
			$data['module_callback_enquiry_required'] = $this->request->post['module_callback_enquiry_required'];
		} else {
			$data['module_callback_enquiry_required'] = $this->config->get('module_callback_enquiry_required');
		}

		if (isset($this->request->post['module_callback_calltime'])) {
			$data['module_callback_calltime'] = $this->request->post['module_callback_calltime'];
		} else {
			$data['module_callback_calltime'] = $this->config->get('module_callback_calltime');
		}

		if (isset($this->request->post['module_callback_calltime_required'])) {
			$data['module_callback_calltime_required'] = $this->request->post['module_callback_calltime_required'];
		} else {
			$data['module_callback_calltime_required'] = $this->config->get('module_callback_calltime_required');
		}

		if (isset($this->request->post['module_callback_time'])) {
			$data['module_callback_time'] = $this->request->post['module_callback_time'];
		} else {
			$data['module_callback_time'] = $this->config->get('module_callback_time');
		}

		if (isset($this->request->post['module_callback_callaction_status'])) {
			$data['module_callback_callaction_status'] = $this->request->post['module_callback_callaction_status'];
		} else {
			$data['module_callback_callaction_status'] = $this->config->get('module_callback_callaction_status');
		}

		if (isset($this->request->post['module_callback_agreement'])) {
			$data['module_callback_agreement'] = $this->request->post['module_callback_agreement'];
		} else {
			$data['module_callback_agreement'] = $this->config->get('module_callback_agreement');
		}

		if (isset($this->request->post['module_callback_phonemask_status'])) {
			$data['module_callback_phonemask_status'] = $this->request->post['module_callback_phonemask_status'];
		} else {
			$data['module_callback_phonemask_status'] = $this->config->get('module_callback_phonemask_status');
		}

		if (isset($this->request->post['module_callback_status'])) {
			$data['module_callback_status'] = $this->request->post['module_callback_status'];
		} else {
			$data['module_callback_status'] = $this->config->get('module_callback_status');
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

		foreach ($this->request->post['module_callback'] as $language_id => $value) {
			if (utf8_strlen($value['title']) < 1) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
			if (utf8_strlen($value['success']) < 1) {
				$this->error['success'][$language_id] = $this->language->get('error_success');
			}
			if (utf8_strlen($value['text_button']) < 1) {
				$this->error['text_button'][$language_id] = $this->language->get('error_text_button');
			}
		}

		if ($this->request->post['module_callback_callaction_status'] && ((utf8_strlen($this->request->post['module_callback_time']) < 1) || ($this->request->post['module_callback_time'] < 1))) {
			$this->error['error_module_callback_time'] = $this->language->get('error_time');
		}

		return !$this->error;
	}
}