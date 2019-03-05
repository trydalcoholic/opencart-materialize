<?php
/**
 * @package		Materialize Template
 * @author		Anton Semenov
 * @copyright	Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license		https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link		https://github.com/trydalcoholic/opencart-materialize
 */

class ControllerExtensionModuleMTMaterializeSearchEngine extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/mt_materialize_search_engine');

		$this->document->setTitle($this->language->get('module_title'));
		$this->document->addScript('view/javascript/mt_materialize/js/materialize.js');
		$this->document->addStyle('view/javascript/mt_materialize/css/materialize.css');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_mt_materialize_search_engine', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module'));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('module_title'),
			'href'	=> $this->url->link('extension/module/mt_materialize_search_engine', 'user_token=' . $this->session->data['user_token'])
		);

		$data['action'] = $this->url->link('extension/module/mt_materialize_search_engine', 'user_token=' . $this->session->data['user_token']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		if (isset($this->request->post['module_mt_materialize_search_engine_status'])) {
			$data['module_mt_materialize_search_engine_status'] = $this->request->post['module_mt_materialize_search_engine_status'];
		} else {
			$data['module_mt_materialize_search_engine_status'] = $this->config->get('module_mt_materialize_search_engine_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/mt_materialize_search_engine', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/mt_materialize_search_engine')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}