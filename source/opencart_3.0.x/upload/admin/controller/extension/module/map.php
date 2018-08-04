<?php
class ControllerExtensionModuleMap extends Controller {
	private $error = array();

	public function install() {
		$this->load->model('setting/setting');
		$this->load->model('setting/event');

		$this->model_setting_event->addEvent('module_map_add_module', 'catalog/view/information/contact/before', 'extension/module/map_materialize/moduleMapAdd');

		$data['module_map_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('module_map', $data);
	}

	public function uninstall() {
		$this->load->model('setting/event');
		$this->load->model('user/user_group');

		$this->model_setting_event->deleteEventByCode('module_map_add_module');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/map');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/map');
	}

	public function index() {
		$this->load->language('extension/module/map');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('map_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('setting/setting');
		$this->load->model('tool/image');
		$this->load->model('extension/materialize/materialize');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_map', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['errors'] = $this->error;

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
			'href'	=> $this->url->link('extension/module/map', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/map', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['module_map_settings'])) {
			$data['module_map_settings'] = $this->request->post['module_map_settings'];
		} elseif ($this->config->get('module_map_settings') == true) {
			$data['module_map_settings'] = $this->config->get('module_map_settings');
		} else {
			$data['module_map_settings'] = array();

			$data['module_map_settings']['colors'] = array(
				'panel_color'		=> 'deep-purple accent-4',
				'panel_color_text'	=> 'white-text',
				'panel_icons_color'	=> 'deep-purple-text text-accent-4',
				'marker_color'		=> 'deep-purple accent-4',
				'marker_color_hex'	=> '#6200ea',
				'btn_color'			=> 'white',
				'btn_color_text'	=> 'deep-purple-text text-accent-4',
			);
		}

		if (isset($this->request->post['module_map_status'])) {
			$data['module_map_status'] = $this->request->post['module_map_status'];
		} else {
			$data['module_map_status'] = $this->config->get('module_map_status');
		}

		$data['maps_value'] = array();

		$data['maps_value'][] = array(
			'text'	=> $this->language->get('text_google_map'),
			'value'	=> 'google_maps'
		);

		$data['maps_value'][] = array(
			'text'	=> $this->language->get('text_yandex_map'),
			'value'	=> 'yandex_maps'
		);

		/* Colors */
		$data['materialize_get_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();
		$data['materialize_get_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['materializeapi'] = $this->load->controller('extension/materialize/materializeapi/materializeapi');
		$data['appeal_footer'] = $this->load->controller('extension/materialize/appeal/appeal');

		$this->response->setOutput($this->load->view('extension/module/map', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/map')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}