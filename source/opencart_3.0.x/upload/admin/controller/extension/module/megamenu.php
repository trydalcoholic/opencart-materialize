<?php
class ControllerExtensionModuleMegamenu extends Controller {
	private $error = array();

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "megamenu` (
				`category_id` int(11) NOT NULL,
				`megamenu` tinyint(1) NOT NULL,
				`type` varchar(32) NOT NULL,
				`banner_id` int(11) NOT NULL,
				PRIMARY KEY (`category_id`)
			) ENGINE=MyISAM;
		");

		$this->load->model('setting/setting');

		$data['module_megamenu_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('module_megamenu', $data);
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "megamenu`;");

		$this->load->model('user/user_group');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/megamenu');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/megamenu');
	}

	public function index() {
		$this->load->language('extension/module/megamenu');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('megamenu_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('setting/setting');

		$this->load->model('extension/materialize/megamenu');

		$this->load->model('design/banner');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_megamenu', $this->request->post);

			$this->model_extension_materialize_megamenu->addCategoryMegamenu($this->request->post);

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
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/megamenu', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/megamenu', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_megamenu_installed_appeal'])) {
			$data['module_megamenu_installed_appeal'] = $this->request->post['module_megamenu_installed_appeal'];
		} else {
			$data['module_megamenu_installed_appeal'] = $this->config->get('module_megamenu_installed_appeal');
		}

		if (isset($this->request->post['module_megamenu_fix'])) {
			$data['module_megamenu_fix'] = $this->request->post['module_megamenu_fix'];
		} else {
			$data['module_megamenu_fix'] = $this->config->get('module_megamenu_fix');
		}

		if (isset($this->request->post['module_megamenu_center'])) {
			$data['module_megamenu_center'] = $this->request->post['module_megamenu_center'];
		} else {
			$data['module_megamenu_center'] = $this->config->get('module_megamenu_center');
		}

		if (isset($this->request->post['module_megamenu_home'])) {
			$data['module_megamenu_home'] = $this->request->post['module_megamenu_home'];
		} else {
			$data['module_megamenu_home'] = $this->config->get('module_megamenu_home');
		}

		if (isset($this->request->post['module_megamenu_category_title'])) {
			$data['module_megamenu_category_title'] = $this->request->post['module_megamenu_category_title'];
		} else {
			$data['module_megamenu_category_title'] = $this->config->get('module_megamenu_category_title');
		}

		if (isset($this->request->post['module_megamenu_see_all'])) {
			$data['module_megamenu_see_all'] = $this->request->post['module_megamenu_see_all'];
		} else {
			$data['module_megamenu_see_all'] = $this->config->get('module_megamenu_see_all');
		}

		if (isset($this->request->post['module_megamenu_category_cache'])) {
			$data['module_megamenu_category_cache'] = $this->request->post['module_megamenu_category_cache'];
		} else {
			$data['module_megamenu_category_cache'] = $this->config->get('module_megamenu_category_cache');
		}

		if (isset($this->request->post['module_megamenu_status'])) {
			$data['module_megamenu_status'] = $this->request->post['module_megamenu_status'];
		} else {
			$data['module_megamenu_status'] = $this->config->get('module_megamenu_status');
		}

		/* Categories */

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$megamenu_info = $this->model_extension_materialize_megamenu->getMegamenuCategories();
		}

		$data['categories'] = array();

		$results = $this->model_extension_materialize_megamenu->getCategories();

		foreach ($results as $result) {
			$data['categories'][] = array(
				'category_id'	=> $result['category_id'],
				'name'			=> $result['name']
			);
		}

		if (isset($this->request->post['module_megamenu_category'])) {
			$data['module_megamenu_category'] = $this->request->post['module_megamenu_category'];
		} elseif (!empty($megamenu_info)) {
			$data['module_megamenu_category'] = $this->model_extension_materialize_megamenu->getMegamenuCategories();
		} else {
			$data['module_megamenu_category'] = array();
		}

		/* Banners */

		$data['banners'] = $this->model_design_banner->getBanners();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/megamenu', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/megamenu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}