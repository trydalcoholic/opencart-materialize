<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ControllerExtensionModuleMTBlog extends Controller {
	private $error = [];

	public function install() {
		$this->load->model('extension/mt_materialize/module/mt_blog');

		$this->model_extension_mt_materialize_module_mt_blog->install();

		$this->installEvents();
	}

	public function uninstall() {
		$this->load->model('extension/mt_materialize/module/mt_blog');

		$this->model_extension_mt_materialize_module_mt_blog->uninstall();

		$this->uninstallEvents();
	}

	public function index() {
		$this->load->model('tool/image');

		$this->load->language('extension/module/mt_blog');

		$this->document->setTitle($this->language->get('module_title'));

		$this->document->addScript('view/javascript/mt_materialize/materialize.js');

		$this->document->addStyle('view/stylesheet/mt_materialize/sass/materialize.css');
		$this->document->addStyle('view/stylesheet/mt_materialize/sass/stylesheet.css');
		$this->document->addStyle('//fonts.googleapis.com/css?family=Roboto');
		$this->document->addStyle('//fonts.googleapis.com/icon?family=Material+Icons');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_mt_blog', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module'));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = false;
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text'	=> $this->language->get('text_extension'),
			'href'	=> $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		];

		$data['breadcrumbs'][] = [
			'text'	=> $this->language->get('module_title'),
			'href'	=> $this->url->link('extension/module/mt_blog', 'user_token=' . $this->session->data['user_token'])
		];

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 25, 25);

		$data['action'] = $this->url->link('extension/module/mt_blog', 'user_token=' . $this->session->data['user_token']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		if (isset($this->request->post['module_mt_blog_status'])) {
			$data['module_mt_blog_status'] = $this->request->post['module_mt_blog_status'];
		} else {
			$data['module_mt_blog_status'] = $this->config->get('module_mt_blog_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/mt_blog', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/mt_blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function installEvents() {
		/*$this->load->model('setting/event');

		$this->model_setting_event->addEvent('theme_mt_materialize_menu_item', 'admin/view/common/column_left/before', 'extension/theme/mt_materialize/adminMaterializeMenuItem');*/
	}

	protected function uninstallEvents() {
		/*$this->load->model('setting/event');

		$this->model_setting_event->deleteEventByCode('');*/
	}
}