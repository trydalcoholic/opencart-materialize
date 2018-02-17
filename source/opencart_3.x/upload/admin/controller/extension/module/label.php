<?php
class ControllerExtensionModuleLabel extends Controller {
	private $error = array();

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "materialize_label` (
				`label_id` INT(11) NOT NULL AUTO_INCREMENT,
				`label_color` VARCHAR(25) NOT NULL,
				`label_color_text` VARCHAR(35) NOT NULL,
				`sort_order` INT(3) NOT NULL,
				PRIMARY KEY (`label_id`)
			) ENGINE = MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "materialize_label_description` (
				`label_id` INT(11) NOT NULL,
				`language_id` INT(11) NOT NULL,
				`name` VARCHAR(20) NOT NULL,
				PRIMARY KEY (`label_id`, `language_id`)
			) ENGINE = MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_label` (
				`product_id` INT(11) NOT NULL,
				`label_id` INT(11) NOT NULL,
				PRIMARY KEY (`product_id`,`label_id`)
			) ENGINE = MyISAM;
		");

		$this->load->model('setting/setting');

		$data['module_label_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('module_label', $data);

		$this->load->model('user/user_group');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/materialize/label/label');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/materialize/label/label');
	}

	public function uninstall() {
		$this->db->query("
			DROP TABLE IF EXISTS
				`" . DB_PREFIX . "materialize_label`,
				`" . DB_PREFIX . "materialize_label_description`,
				`" . DB_PREFIX . "product_label`
			;
		");

		$this->load->model('user/user_group');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/materialize/label/label');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/materialize/label/label');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/label');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/label');
	}

	public function index() {
		$this->load->language('extension/module/label');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('label_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('setting/setting');

		$this->load->model('extension/materialize/materialize');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_label', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
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
			'text'	=> $this->language->get('text_module'),
			'href'	=> $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('heading_title'),
			'href'	=> $this->url->link('extension/module/label', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/label', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_label_installed_appeal'])) {
			$data['module_label_installed_appeal'] = $this->request->post['module_label_installed_appeal'];
		} else {
			$data['module_label_installed_appeal'] = $this->config->get('module_label_installed_appeal');
		}

		if (isset($this->request->post['module_label_status'])) {
			$data['module_label_status'] = $this->request->post['module_label_status'];
		} else {
			$data['module_label_status'] = $this->config->get('module_label_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/label', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/label')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}