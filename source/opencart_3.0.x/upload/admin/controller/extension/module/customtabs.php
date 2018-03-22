<?php
class ControllerExtensionModuleCustomtabs extends Controller {
	private $error = array();

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_customtab` (
				`product_customtab_id` INT(11) NOT NULL AUTO_INCREMENT,
				`product_id` INT(11) NOT NULL,
				`sort_order` INT(11) NOT NULL,
				`status` TINYINT(1) NOT NULL,
				PRIMARY KEY (`product_customtab_id`)
			) ENGINE=MyISAM;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_customtab_description` (
				`product_customtab_id` INT(11) NOT NULL,
				`language_id` INT(11) NOT NULL,
				`product_id` INT(11) NOT NULL,
				`title` VARCHAR(255) CHARACTER SET utf8 NOT NULL,
				`description` TEXT CHARACTER SET utf8 NOT NULL
			) ENGINE=MyISAM;
		");

		$this->load->model('setting/setting');

		$data['module_customtabs_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('module_customtabs', $data);
	}

	public function uninstall() {
		$this->db->query("
			DROP TABLE IF EXISTS
				`" . DB_PREFIX . "product_customtab`,
				`" . DB_PREFIX . "product_customtab_description`
			;
		");

		$this->load->model('user/user_group');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/customtabs');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/customtabs');
	}

	public function index() {
		$this->load->language('extension/module/customtabs');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('customtabs_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_customtabs', $this->request->post);

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
			'href'	=> $this->url->link('extension/module/customtabs', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/customtabs', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_customtabs_installed_appeal'])) {
			$data['module_customtabs_installed_appeal'] = $this->request->post['module_customtabs_installed_appeal'];
		} else {
			$data['module_customtabs_installed_appeal'] = $this->config->get('module_customtabs_installed_appeal');
		}

		if (isset($this->request->post['module_customtabs_status'])) {
			$data['module_customtabs_status'] = $this->request->post['module_customtabs_status'];
		} else {
			$data['module_customtabs_status'] = $this->config->get('module_customtabs_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/customtabs', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/customtabs')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}