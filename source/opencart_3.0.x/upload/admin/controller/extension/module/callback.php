<?php
class ControllerExtensionModuleCallback extends Controller {
	private $error = array();

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "materialize_callback` (
				`callback_id` INT NOT NULL AUTO_INCREMENT,
				`telephone` VARCHAR(32) NOT NULL,
				`name` VARCHAR(32) NOT NULL,
				`enquiry` VARCHAR(360) NOT NULL,
				`call_time` TIME NOT NULL,
				`ip` VARCHAR(40) NOT NULL,
				`date_added` DATETIME NOT NULL,
				`order_page` TEXT NOT NULL,
				`status` TINYINT(1) NOT NULL,
				PRIMARY KEY (`callback_id`)
			) ENGINE = MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "materialize_callback_history` (
				`callback_history_id` INT(11) NOT NULL AUTO_INCREMENT,
				`callback_id` INT NOT NULL,
				`comment` TEXT NOT NULL,
				`date_added` DATETIME NOT NULL,
				PRIMARY KEY (`callback_history_id`)
			) ENGINE = MyISAM;
		");

		$this->load->model('setting/setting');

		$data['module_callback_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('module_callback', $data);

		$this->load->model('user/user_group');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/materialize/callback/callback');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/materialize/callback/callback');
	}

	public function uninstall() {
		$this->db->query("
			DROP TABLE IF EXISTS
				`" . DB_PREFIX . "materialize_callback`,
				`" . DB_PREFIX . "materialize_callback_history`
			;
		");

		$this->load->model('user/user_group');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/materialize/callback/callback');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/materialize/callback/callback');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/callback');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/callback');
	}

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

		if (isset($this->error['caption'])) {
			$data['error_caption'] = $this->error['caption'];
		} else {
			$data['error_caption'] = array();
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}

		if (isset($this->error['error_callback_time'])) {
			$data['error_callback_time'] = $this->error['error_callback_time'];
		} else {
			$data['error_callback_time'] = '';
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

		if (isset($this->request->post['module_callback_installed_appeal'])) {
			$data['module_callback_installed_appeal'] = $this->request->post['module_callback_installed_appeal'];
		} else {
			$data['module_callback_installed_appeal'] = $this->config->get('module_callback_installed_appeal');
		}

		$data['module_callback_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();
		$data['module_callback_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

		if (isset($this->request->post['module_callback_color_btn'])) {
			$data['module_callback_color_btn'] = $this->request->post['module_callback_color_btn'];
		} elseif ($this->config->get('module_callback_color_btn') == true) {
			$data['module_callback_color_btn'] = $this->config->get('module_callback_color_btn');
		} else {
			$data['module_callback_color_btn'] = 'green darken-1';
		}

		if (isset($this->request->post['module_callback_color_btn_text'])) {
			$data['module_callback_color_btn_text'] = $this->request->post['module_callback_color_btn_text'];
		} elseif ($this->config->get('module_callback_color_btn_text') == true) {
			$data['module_callback_color_btn_text'] = $this->config->get('module_callback_color_btn_text');
		} else {
			$data['module_callback_color_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['module_callback_color_bubble'])) {
			$data['module_callback_color_bubble'] = $this->request->post['module_callback_color_bubble'];
		} elseif ($this->config->get('module_callback_color_bubble') == true) {
			$data['module_callback_color_bubble'] = $this->config->get('module_callback_color_bubble');
		} else {
			$data['module_callback_color_bubble'] = 'green lighten-1';
		}

		if (isset($this->request->post['module_callback_color_bubble_text'])) {
			$data['module_callback_color_bubble_text'] = $this->request->post['module_callback_color_bubble_text'];
		} elseif ($this->config->get('module_callback_color_bubble_text') == true) {
			$data['module_callback_color_bubble_text'] = $this->config->get('module_callback_color_bubble_text');
		} else {
			$data['module_callback_color_bubble_text'] = 'white-text';
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

			if ($this->request->post['module_callback_callaction_status'] == 1) {
				foreach ($this->request->post['module_callback'] as $language_id => $value) {
					if (utf8_strlen($value['caption']) < 1) {
						$this->error['caption'][$language_id] = $this->language->get('error_title');
					}
					if (utf8_strlen($value['description']) < 1) {
						$this->error['description'][$language_id] = $this->language->get('error_description');
					}
				}

				if (utf8_strlen($this->request->post['module_callback_time']) < 1 || $this->request->post['module_callback_time'] < 1) {
					$this->error['error_callback_time'] = $this->language->get('error_time');
				}
			}
		}

		return !$this->error;
	}
}