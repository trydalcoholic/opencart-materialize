<?php
class ControllerExtensionModuleSizechart extends Controller {
	private $error = array();

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "materialize_sizechart` (
				`sizechart_id` INT(11) NOT NULL AUTO_INCREMENT,
				`sizechart_group_id` INT(11) NOT NULL,
				`sort_order` INT(3) NOT NULL,
				PRIMARY KEY (`sizechart_id`)
			) ENGINE = MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "materialize_sizechart_description` (
				`sizechart_id` INT(11) NOT NULL,
				`language_id` INT(11) NOT NULL,
				`sizechart_group_id` INT(11) NOT NULL,
				`name` VARCHAR(64) NOT NULL,
				`description` TEXT NOT NULL,
				PRIMARY KEY (`sizechart_id`, `language_id`)
			) ENGINE = MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "materialize_sizechart_group` (
				`sizechart_group_id` INT(11) NOT NULL AUTO_INCREMENT,
				`sort_order` INT(3) NOT NULL,
				PRIMARY KEY (`sizechart_group_id`)
			) ENGINE = MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "materialize_sizechart_group_description` (
				`sizechart_group_id` INT(11) NOT NULL,
				`language_id` INT(11) NOT NULL,
				`name` VARCHAR(64) NOT NULL,
				PRIMARY KEY (`sizechart_group_id`, `language_id`)
			) ENGINE = MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_materialize_sizechart` (
				`product_id` INT(11) NOT NULL,
				`sizechart_id` INT(11) NOT NULL,
				PRIMARY KEY (`product_id`,`sizechart_id`)
			) ENGINE = MyISAM;
		");

		$this->load->model('setting/setting');

		$data['module_sizechart_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('module_sizechart', $data);

		$this->load->model('user/user_group');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/materialize/sizechart/sizechart');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/materialize/sizechart/sizechart');
	}

	public function uninstall() {
		$this->db->query("
			DROP TABLE IF EXISTS
				`" . DB_PREFIX . "materialize_sizechart`,
				`" . DB_PREFIX . "materialize_sizechart_description`,
				`" . DB_PREFIX . "materialize_sizechart_group`,
				`" . DB_PREFIX . "materialize_sizechart_group_description`,
				`" . DB_PREFIX . "product_materialize_sizechart`
			;
		");

		$this->load->model('user/user_group');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/materialize/sizechart/sizechart');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/materialize/sizechart/sizechart');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/sizechart');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/sizechart');
	}

	public function index() {
		$this->load->language('extension/module/sizechart');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('sizechart_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_sizechart', $this->request->post);

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
			'href'	=> $this->url->link('extension/module/sizechart', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/sizechart', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_sizechart_installed_appeal'])) {
			$data['module_sizechart_installed_appeal'] = $this->request->post['module_sizechart_installed_appeal'];
		} else {
			$data['module_sizechart_installed_appeal'] = $this->config->get('module_sizechart_installed_appeal');
		}

		if (isset($this->request->post['module_sizechart_status'])) {
			$data['module_sizechart_status'] = $this->request->post['module_sizechart_status'];
		} else {
			$data['module_sizechart_status'] = $this->config->get('module_sizechart_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/sizechart', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/sizechart')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}