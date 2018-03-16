<?php
class ControllerExtensionModuleQuickorder extends Controller {
	private $error = array();

	public function uninstall() {
		$this->load->model('setting/setting');

		$data['module_quickorder_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('module_quickorder', $data);

		$this->load->model('user/user_group');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/quickorder');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/quickorder');
	}

	public function index() {
		$this->load->language('extension/module/quickorder');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('quickorder_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('setting/setting');

		$this->load->model('extension/materialize/materialize');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_quickorder', $this->request->post);

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

		if (isset($this->error['success'])) {
			$data['error_success'] = $this->error['success'];
		} else {
			$data['error_success'] = array();
		}

		if (isset($this->error['text_button'])) {
			$data['error_text_button'] = $this->error['text_button'];
		} else {
			$data['error_text_button'] = array();
		}

		$data['user_token'] = $this->session->data['user_token'];

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
			'href'	=> $this->url->link('extension/module/quickorder', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/quickorder', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

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

		if (isset($this->request->post['module_quickorder_installed_appeal'])) {
			$data['module_quickorder_installed_appeal'] = $this->request->post['module_quickorder_installed_appeal'];
		} else {
			$data['module_quickorder_installed_appeal'] = $this->config->get('module_quickorder_installed_appeal');
		}

		$data['module_quickorder_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();
		$data['module_quickorder_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

		if (isset($this->request->post['module_quickorder_color_btn'])) {
			$data['module_quickorder_color_btn'] = $this->request->post['module_quickorder_color_btn'];
		} elseif ($this->config->get('module_quickorder_color_btn') == true) {
			$data['module_quickorder_color_btn'] = $this->config->get('module_quickorder_color_btn');
		} else {
			$data['module_quickorder_color_btn'] = 'blue';
		}

		if (isset($this->request->post['module_quickorder_color_btn_text'])) {
			$data['module_quickorder_color_btn_text'] = $this->request->post['module_quickorder_color_btn_text'];
		} elseif ($this->config->get('module_quickorder_color_btn_text') == true) {
			$data['module_quickorder_color_btn_text'] = $this->config->get('module_quickorder_color_btn_text');
		} else {
			$data['module_quickorder_color_btn_text'] = 'white-text';
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

		if ($this->request->post['module_quickorder_status'] == 1) {
			foreach ($this->request->post['module_quickorder'] as $language_id => $value) {
				if (utf8_strlen($value['text_button']) < 1) {
					$this->error['text_button'][$language_id] = $this->language->get('error_text_button');
				}
				if (utf8_strlen($value['success']) < 1) {
					$this->error['success'][$language_id] = $this->language->get('error_success');
				}
			}
		}

		return !$this->error;
	}
}