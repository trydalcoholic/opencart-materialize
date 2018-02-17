<?php
class ControllerExtensionModuleMap extends Controller {
	private $error = array();

	public function install() {
		$this->load->model('setting/setting');

		$data['module_map_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('module_map', $data);
	}

	public function uninstall() {
		$this->load->model('user/user_group');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/map');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/map');
	}

	public function index() {
		$this->load->language('extension/module/map');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('map_title'));
		$this->document->addScript('view/javascript/codemirror/lib/codemirror.js');
		$this->document->addScript('view/javascript/codemirror/lib/xml.js');
		$this->document->addScript('view/javascript/codemirror/lib/formatting.js');
		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addScript('view/javascript/summernote/summernote-image-attributes.js');
		$this->document->addScript('view/javascript/summernote/opencart.js');
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/codemirror/lib/codemirror.css');
		$this->document->addStyle('view/javascript/codemirror/theme/monokai.css');
		$this->document->addStyle('view/javascript/summernote/summernote.css');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('localisation/language');

		$this->load->model('setting/setting');

		$this->load->model('tool/image');

		$this->load->model('extension/materialize/materialize');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_map', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['error_geo_lat'])) {
			$data['error_geo_lat'] = $this->error['error_geo_lat'];
		} else {
			$data['error_geo_lat'] = '';
		}

		if (isset($this->error['error_geo_lng'])) {
			$data['error_geo_lng'] = $this->error['error_geo_lng'];
		} else {
			$data['error_geo_lng'] = '';
		}

		if (isset($this->error['error_google_api'])) {
			$data['error_google_api'] = $this->error['error_google_api'];
		} else {
			$data['error_google_api'] = '';
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
			'href'	=> $this->url->link('extension/module/map', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/map', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		/* Multi languages fields */

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$module_map = array();

		foreach ($data['languages'] as $key => $language) {
			$module_map[$language['language_id']][] = $this->language->get('module_map');
		}

		if (isset($this->request->post['module_map'])) {
			$data['module_map'] = $this->request->post['module_map'];
		} elseif ($this->config->get('module_map') == true) {
			$data['module_map'] = $this->config->get('module_map');
		} else {
			$data['module_map'] = '';
		}

		if (isset($this->request->post['module_map_installed_appeal'])) {
			$data['module_map_installed_appeal'] = $this->request->post['module_map_installed_appeal'];
		} else {
			$data['module_map_installed_appeal'] = $this->config->get('module_map_installed_appeal');
		}

		/* Maps */

		if (isset($this->request->post['module_map_maps'])) {
			$data['module_map_maps'] = $this->request->post['module_map_maps'];
		} else {
			$data['module_map_maps'] = $this->config->get('module_map_maps');
		}

		$data['maps'] = array();

		$data['maps'][] = array(
			'text'	=> $this->language->get('text_google_map'),
			'value'	=> 'google_maps'
		);

		$data['maps'][] = array(
			'text'	=> $this->language->get('text_yandex_map'),
			'value'	=> 'yandex_maps'
		);

		// Coordinates

		if (isset($this->request->post['module_map_google_api'])) {
			$data['module_map_google_api'] = $this->request->post['module_map_google_api'];
		} else {
			$data['module_map_google_api'] = $this->config->get('module_map_google_api');
		}

		if (isset($this->request->post['module_map_geo_lat'])) {
			$data['module_map_geo_lat'] = $this->request->post['module_map_geo_lat'];
		} else {
			$data['module_map_geo_lat'] = $this->config->get('module_map_geo_lat');
		}

		if (isset($this->request->post['module_map_geo_lng'])) {
			$data['module_map_geo_lng'] = $this->request->post['module_map_geo_lng'];
		} else {
			$data['module_map_geo_lng'] = $this->config->get('module_map_geo_lng');
		}

		// Icon

		if (isset($this->request->post['module_map_icon_pin'])) {
			$data['module_map_icon_pin'] = $this->request->post['module_map_icon_pin'];
		} else {
			$data['module_map_icon_pin'] = $this->config->get('module_map_icon_pin');
		}

		if (isset($this->request->post['module_map_icon_pin_thumb']) && is_file(DIR_IMAGE . $this->request->post['module_map_icon_pin_thumb'])) {
			$data['module_map_icon_pin_thumb'] = $this->model_tool_image->resize($this->request->post['module_map_icon_pin'], 100, 100);
		} elseif (!empty($this->config->get('module_map_icon_pin'))) {
			$data['module_map_icon_pin_thumb'] = $this->model_tool_image->resize($this->config->get('module_map_icon_pin'), 100, 100);
		} else {
			$data['module_map_icon_pin_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['module_map_icon_pin_width'])) {
			$data['module_map_icon_pin_width'] = $this->request->post['module_map_icon_pin_width'];
		} else {
			$data['module_map_icon_pin_width'] = $this->config->get('module_map_icon_pin_width');
		}

		if (isset($this->request->post['module_map_icon_pin_height'])) {
			$data['module_map_icon_pin_height'] = $this->request->post['module_map_icon_pin_height'];
		} else {
			$data['module_map_icon_pin_height'] = $this->config->get('module_map_icon_pin_height');
		}

		/* Colors */

		$data['module_map_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();
		$data['module_map_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

		if (isset($this->request->post['module_map_color_btn'])) {
			$data['module_map_color_btn'] = $this->request->post['module_map_color_btn'];
		} elseif ($this->config->get('module_map_color_btn') == true) {
			$data['module_map_color_btn'] = $this->config->get('module_map_color_btn');
		} else {
			$data['module_map_color_btn'] = 'blue';
		}

		if (isset($this->request->post['module_map_color_btn_text'])) {
			$data['module_map_color_btn_text'] = $this->request->post['module_map_color_btn_text'];
		} elseif ($this->config->get('module_map_color_btn_text') == true) {
			$data['module_map_color_btn_text'] = $this->config->get('module_map_color_btn_text');
		} else {
			$data['module_map_color_btn_text'] = 'white-text';
		}

		/* Status */

		if (isset($this->request->post['module_map_status'])) {
			$data['module_map_status'] = $this->request->post['module_map_status'];
		} else {
			$data['module_map_status'] = $this->config->get('module_map_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/map', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/map')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['module_map_status'] == 1) {
			if (utf8_strlen($this->request->post['module_map_geo_lat']) < 1) {
				$this->error['error_geo_lat'] = $this->language->get('error_geo_lat');
			}

			if (utf8_strlen($this->request->post['module_map_geo_lng']) < 1) {
				$this->error['error_geo_lng'] = $this->language->get('error_geo_lng');
			}

			if (($this->request->post['module_map_maps'] == 'google_maps') && (utf8_strlen($this->request->post['module_map_google_api']) < 1)) {
				$this->error['error_google_api'] = $this->language->get('error_google_api');
			}
		}

		return !$this->error;
	}
}