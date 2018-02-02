<?php
class ControllerExtensionModuleCallback extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/callback');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('callback_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('setting/setting');

		$this->load->model('extension/materialize/materialize');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_callback', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$this->load->model('catalog/information');

		$data['informations'] = $this->model_catalog_information->getInformations();

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
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_extension'),
			'href'	=> $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('heading_title'),
			'href'	=> $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

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

		$data['module_callback_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();
		$data['module_callback_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

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

		if (isset($this->request->post['module_callback_phonemask_status'])) {
			$data['module_callback_phonemask_status'] = $this->request->post['module_callback_phonemask_status'];
		} else {
			$data['module_callback_phonemask_status'] = $this->config->get('module_callback_phonemask_status');
		}

		if (isset($this->request->post['module_callback_agreement'])) {
			$data['module_callback_agreement'] = $this->request->post['module_callback_agreement'];
		} else {
			$data['module_callback_agreement'] = $this->config->get('module_callback_agreement');
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

		if ($this->request->post['module_callback_status'] == 1) {
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
		}

		return !$this->error;
	}
}