<?php
class ControllerExtensionModuleMaterialize extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/materialize');

		$this->document->setTitle($this->language->get('materialize_title'));

		$this->load->model('setting/setting');

		$this->load->model('tool/image');

		$this->load->model('extension/module/materialize');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_materialize', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

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
			'href'	=> $this->url->link('extension/module/materialize', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/materialize', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$module_materialize = array();

		foreach ($data['languages'] as $key => $language) {
			$module_materialize[$language['language_id']][] = $this->language->get('module_materialize');
		}

		if (isset($this->request->post['module_materialize'])) {
			$data['module_materialize'] = $this->request->post['module_materialize'];
		} elseif ($this->config->get('module_materialize') == true) {
			$data['module_materialize'] = $this->config->get('module_materialize');
		} else {
			$data['module_materialize'] = $module_materialize;
		}

		/* General */
		$data['module_materialize_colors'] = $this->model_extension_module_materialize->getMaterializeColors();
		$data['module_materialize_colors_text'] = $this->model_extension_module_materialize->getMaterializeColorsText();

		if (isset($this->request->post['module_materialize_color_background'])) {
			$data['module_materialize_color_background'] = $this->request->post['module_materialize_color_background'];
		} elseif ($this->config->get('module_materialize_color_background') == true) {
			$data['module_materialize_color_background'] = $this->config->get('module_materialize_color_background');
		} else {
			$data['module_materialize_color_background'] = 'grey lighten-3';
		}

		if (isset($this->request->post['module_materialize_color_nav_btn'])) {
			$data['module_materialize_color_nav_btn'] = $this->request->post['module_materialize_color_nav_btn'];
		} elseif ($this->config->get('module_materialize_color_nav_btn') == true) {
			$data['module_materialize_color_nav_btn'] = $this->config->get('module_materialize_color_nav_btn');
		} else {
			$data['module_materialize_color_nav_btn'] = 'blue-grey darken-2';
		}

		if (isset($this->request->post['module_materialize_color_nav_btn_text'])) {
			$data['module_materialize_color_nav_btn_text'] = $this->request->post['module_materialize_color_nav_btn_text'];
		} elseif ($this->config->get('module_materialize_color_nav_btn_text') == true) {
			$data['module_materialize_color_nav_btn_text'] = $this->config->get('module_materialize_color_nav_btn_text');
		} else {
			$data['module_materialize_color_nav_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['module_materialize_color_cart_btn'])) {
			$data['module_materialize_color_cart_btn'] = $this->request->post['module_materialize_color_cart_btn'];
		} elseif ($this->config->get('module_materialize_color_cart_btn') == true) {
			$data['module_materialize_color_cart_btn'] = $this->config->get('module_materialize_color_cart_btn');
		} else {
			$data['module_materialize_color_cart_btn'] = 'red';
		}

		if (isset($this->request->post['module_materialize_color_cart_btn_text'])) {
			$data['module_materialize_color_cart_btn_text'] = $this->request->post['module_materialize_color_cart_btn_text'];
		} elseif ($this->config->get('module_materialize_color_cart_btn_text') == true) {
			$data['module_materialize_color_cart_btn_text'] = $this->config->get('module_materialize_color_cart_btn_text');
		} else {
			$data['module_materialize_color_cart_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['module_materialize_color_total_btn'])) {
			$data['module_materialize_color_total_btn'] = $this->request->post['module_materialize_color_total_btn'];
		} elseif ($this->config->get('module_materialize_color_total_btn') == true) {
			$data['module_materialize_color_total_btn'] = $this->config->get('module_materialize_color_total_btn');
		} else {
			$data['module_materialize_color_total_btn'] = 'light-blue darken-1';
		}

		if (isset($this->request->post['module_materialize_color_total_btn_text'])) {
			$data['module_materialize_color_total_btn_text'] = $this->request->post['module_materialize_color_total_btn_text'];
		} elseif ($this->config->get('module_materialize_color_total_btn_text') == true) {
			$data['module_materialize_color_total_btn_text'] = $this->config->get('module_materialize_color_total_btn_text');
		} else {
			$data['module_materialize_color_total_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['module_materialize_color_btt_btn'])) {
			$data['module_materialize_color_btt_btn'] = $this->request->post['module_materialize_color_btt_btn'];
		} elseif ($this->config->get('module_materialize_color_btt_btn') == true) {
			$data['module_materialize_color_btt_btn'] = $this->config->get('module_materialize_color_btt_btn');
		} else {
			$data['module_materialize_color_btt_btn'] = 'red';
		}

		if (isset($this->request->post['module_materialize_color_btt_btn_text'])) {
			$data['module_materialize_color_btt_btn_text'] = $this->request->post['module_materialize_color_btt_btn_text'];
		} elseif ($this->config->get('module_materialize_color_btt_btn_text') == true) {
			$data['module_materialize_color_btt_btn_text'] = $this->config->get('module_materialize_color_btt_btn_text');
		} else {
			$data['module_materialize_color_btt_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['module_materialize_color_browser_bar'])) {
			$data['module_materialize_color_browser_bar'] = $this->request->post['module_materialize_color_browser_bar'];
		} elseif ($this->config->get('module_materialize_color_browser_bar') == true) {
			$data['module_materialize_color_browser_bar'] = $this->config->get('module_materialize_color_browser_bar');
		} else {
			$data['module_materialize_color_browser_bar'] = 'blue-grey darken-4';
		}

		if (isset($this->request->post['module_materialize_color_browser_bar_hex'])) {
			$data['module_materialize_color_browser_bar_hex'] = $this->request->post['module_materialize_color_browser_bar_hex'];
		} elseif ($this->config->get('module_materialize_color_browser_bar_hex') == true) {
			$data['module_materialize_color_browser_bar_hex'] = $this->config->get('module_materialize_color_browser_bar_hex');
		} else {
			$data['module_materialize_color_browser_bar_hex'] = '#263238';
		}

		if (isset($this->request->post['module_materialize_color_top_menu'])) {
			$data['module_materialize_color_top_menu'] = $this->request->post['module_materialize_color_top_menu'];
		} elseif ($this->config->get('module_materialize_color_top_menu') == true) {
			$data['module_materialize_color_top_menu'] = $this->config->get('module_materialize_color_top_menu');
		} else {
			$data['module_materialize_color_top_menu'] = 'blue-grey darken-4';
		}

		if (isset($this->request->post['module_materialize_color_top_menu_text'])) {
			$data['module_materialize_color_top_menu_text'] = $this->request->post['module_materialize_color_top_menu_text'];
		} elseif ($this->config->get('module_materialize_color_top_menu_text') == true) {
			$data['module_materialize_color_top_menu_text'] = $this->config->get('module_materialize_color_top_menu_text');
		} else {
			$data['module_materialize_color_top_menu_text'] = 'white-text';
		}

		if (isset($this->request->post['module_materialize_color_header'])) {
			$data['module_materialize_color_header'] = $this->request->post['module_materialize_color_header'];
		} elseif ($this->config->get('module_materialize_color_header') == true) {
			$data['module_materialize_color_header'] = $this->config->get('module_materialize_color_header');
		} else {
			$data['module_materialize_color_header'] = 'blue-grey darken-3';
		}

		if (isset($this->request->post['module_materialize_color_header_text'])) {
			$data['module_materialize_color_header_text'] = $this->request->post['module_materialize_color_header_text'];
		} elseif ($this->config->get('module_materialize_color_header_text') == true) {
			$data['module_materialize_color_header_text'] = $this->config->get('module_materialize_color_header_text');
		} else {
			$data['module_materialize_color_header_text'] = 'blue-grey-text text-lighten-5';
		}

		if (isset($this->request->post['module_materialize_color_navigation'])) {
			$data['module_materialize_color_navigation'] = $this->request->post['module_materialize_color_navigation'];
		} elseif ($this->config->get('module_materialize_color_navigation') == true) {
			$data['module_materialize_color_navigation'] = $this->config->get('module_materialize_color_navigation');
		} else {
			$data['module_materialize_color_navigation'] = 'blue-grey darken-2';
		}

		if (isset($this->request->post['module_materialize_color_navigation_text'])) {
			$data['module_materialize_color_navigation_text'] = $this->request->post['module_materialize_color_navigation_text'];
		} elseif ($this->config->get('module_materialize_color_navigation_text') == true) {
			$data['module_materialize_color_navigation_text'] = $this->config->get('module_materialize_color_navigation_text');
		} else {
			$data['module_materialize_color_navigation_text'] = 'white-text';
		}

		if (isset($this->request->post['module_materialize_color_search'])) {
			$data['module_materialize_color_search'] = $this->request->post['module_materialize_color_search'];
		} elseif ($this->config->get('module_materialize_color_search') == true) {
			$data['module_materialize_color_search'] = $this->config->get('module_materialize_color_search');
		} else {
			$data['module_materialize_color_search'] = 'blue-grey darken-1';
		}

		if (isset($this->request->post['module_materialize_color_sidebar'])) {
			$data['module_materialize_color_sidebar'] = $this->request->post['module_materialize_color_sidebar'];
		} elseif ($this->config->get('module_materialize_color_sidebar') == true) {
			$data['module_materialize_color_sidebar'] = $this->config->get('module_materialize_color_sidebar');
		} else {
			$data['module_materialize_color_sidebar'] = 'blue-grey darken-2';
		}

		if (isset($this->request->post['module_materialize_color_sidebar_text'])) {
			$data['module_materialize_color_sidebar_text'] = $this->request->post['module_materialize_color_sidebar_text'];
		} elseif ($this->config->get('module_materialize_color_sidebar_text') == true) {
			$data['module_materialize_color_sidebar_text'] = $this->config->get('module_materialize_color_sidebar_text');
		} else {
			$data['module_materialize_color_sidebar_text'] = 'white-text';
		}

		if (isset($this->request->post['module_materialize_color_mobile_search'])) {
			$data['module_materialize_color_mobile_search'] = $this->request->post['module_materialize_color_mobile_search'];
		} elseif ($this->config->get('module_materialize_color_mobile_search') == true) {
			$data['module_materialize_color_mobile_search'] = $this->config->get('module_materialize_color_mobile_search');
		} else {
			$data['module_materialize_color_mobile_search'] = 'blue-grey lighten-1';
		}

		if (isset($this->request->post['module_materialize_color_footer'])) {
			$data['module_materialize_color_footer'] = $this->request->post['module_materialize_color_footer'];
		} elseif ($this->config->get('module_materialize_color_footer') == true) {
			$data['module_materialize_color_footer'] = $this->config->get('module_materialize_color_footer');
		} else {
			$data['module_materialize_color_footer'] = 'blue-grey darken-3';
		}

		if (isset($this->request->post['module_materialize_color_footer_text'])) {
			$data['module_materialize_color_footer_text'] = $this->request->post['module_materialize_color_footer_text'];
		} elseif ($this->config->get('module_materialize_color_footer_text') == true) {
			$data['module_materialize_color_footer_text'] = $this->config->get('module_materialize_color_footer_text');
		} else {
			$data['module_materialize_color_footer_text'] = 'grey-text text-lighten-3';
		}

		if (isset($this->request->post['module_materialize_color_footer_text_sn'])) {
			$data['module_materialize_color_footer_text_sn'] = $this->request->post['module_materialize_color_footer_text_sn'];
		} elseif ($this->config->get('module_materialize_color_footer_text_sn') == true) {
			$data['module_materialize_color_footer_text_sn'] = $this->config->get('module_materialize_color_footer_text_sn');
		} else {
			$data['module_materialize_color_footer_text_sn'] = '#eeeeee';
		}

		/* Footer */
		if (isset($this->request->post['module_materialize_footer_contact'])) {
			$data['module_materialize_footer_contact'] = $this->request->post['module_materialize_footer_contact'];
		} else {
			$data['module_materialize_footer_contact'] = $this->config->get('module_materialize_footer_contact');
		}

		if (isset($this->request->post['module_materialize_sn_fb'])) {
			$data['module_materialize_sn_fb'] = $this->request->post['module_materialize_sn_fb'];
		} else {
			$data['module_materialize_sn_fb'] = $this->config->get('module_materialize_sn_fb');
		}

		if (isset($this->request->post['module_materialize_sn_g'])) {
			$data['module_materialize_sn_g'] = $this->request->post['module_materialize_sn_g'];
		} else {
			$data['module_materialize_sn_g'] = $this->config->get('module_materialize_sn_g');
		}

		if (isset($this->request->post['module_materialize_sn_inst'])) {
			$data['module_materialize_sn_inst'] = $this->request->post['module_materialize_sn_inst'];
		} else {
			$data['module_materialize_sn_inst'] = $this->config->get('module_materialize_sn_inst');
		}

		if (isset($this->request->post['module_materialize_sn_tw'])) {
			$data['module_materialize_sn_tw'] = $this->request->post['module_materialize_sn_tw'];
		} else {
			$data['module_materialize_sn_tw'] = $this->config->get('module_materialize_sn_tw');
		}

		if (isset($this->request->post['module_materialize_sn_yt'])) {
			$data['module_materialize_sn_yt'] = $this->request->post['module_materialize_sn_yt'];
		} else {
			$data['module_materialize_sn_yt'] = $this->config->get('module_materialize_sn_yt');
		}

		if (isset($this->request->post['module_materialize_sn_vk'])) {
			$data['module_materialize_sn_vk'] = $this->request->post['module_materialize_sn_vk'];
		} else {
			$data['module_materialize_sn_vk'] = $this->config->get('module_materialize_sn_vk');
		}

		if (isset($this->request->post['module_materialize_sn_ok'])) {
			$data['module_materialize_sn_ok'] = $this->request->post['module_materialize_sn_ok'];
		} else {
			$data['module_materialize_sn_ok'] = $this->config->get('module_materialize_sn_ok');
		}

		if (isset($this->request->post['module_materialize_sn_index'])) {
			$data['module_materialize_sn_index'] = $this->request->post['module_materialize_sn_index'];
		} else {
			$data['module_materialize_sn_index'] = $this->config->get('module_materialize_sn_index');
		}

		/* Product */
		if (isset($this->request->post['module_materialize_payment_image'])) {
			$data['module_materialize_payment_image'] = $this->request->post['module_materialize_payment_image'];
		} else {
			$data['module_materialize_payment_image'] = $this->config->get('module_materialize_payment_image');
		}

		if (isset($this->request->post['module_materialize_payment_thumb']) && is_file(DIR_IMAGE . $this->request->post['module_materialize_payment_thumb'])) {
			$data['module_materialize_payment_thumb'] = $this->model_tool_image->resize($this->request->post['module_materialize_payment_image'], 100, 100);
		} elseif (!empty($this->config->get('module_materialize_payment_image'))) {
			$data['module_materialize_payment_thumb'] = $this->model_tool_image->resize($this->config->get('module_materialize_payment_image'), 100, 100);
		} else {
			$data['module_materialize_payment_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['module_materialize_payment_image_width'])) {
			$data['module_materialize_payment_image_width'] = $this->request->post['module_materialize_payment_image_width'];
		} else {
			$data['module_materialize_payment_image_width'] = $this->config->get('module_materialize_payment_image_width');
		}

		if (isset($this->request->post['module_materialize_payment_image_height'])) {
			$data['module_materialize_payment_image_height'] = $this->request->post['module_materialize_payment_image_height'];
		} else {
			$data['module_materialize_payment_image_height'] = $this->config->get('module_materialize_payment_image_height');
		}

		/* Maps */
		$data['module_materialize_maps'] = $this->model_extension_module_materialize->getMaterializeMaps();

		if (isset($this->request->post['module_materialize_map'])) {
			$data['module_materialize_map'] = $this->request->post['module_materialize_map'];
		} else {
			$data['module_materialize_map'] = $this->config->get('module_materialize_map');
		}

		if (isset($this->request->post['module_materialize_google_api'])) {
			$data['module_materialize_google_api'] = $this->request->post['module_materialize_google_api'];
		} else {
			$data['module_materialize_google_api'] = $this->config->get('module_materialize_google_api');
		}

		if (isset($this->request->post['module_materialize_geo_lat'])) {
			$data['module_materialize_geo_lat'] = $this->request->post['module_materialize_geo_lat'];
		} else {
			$data['module_materialize_geo_lat'] = $this->config->get('module_materialize_geo_lat');
		}

		if (isset($this->request->post['module_materialize_geo_lng'])) {
			$data['module_materialize_geo_lng'] = $this->request->post['module_materialize_geo_lng'];
		} else {
			$data['module_materialize_geo_lng'] = $this->config->get('module_materialize_geo_lng');
		}

		if (isset($this->request->post['module_materialize_icon_pin'])) {
			$data['module_materialize_icon_pin'] = $this->request->post['module_materialize_icon_pin'];
		} else {
			$data['module_materialize_icon_pin'] = $this->config->get('module_materialize_icon_pin');
		}

		if (isset($this->request->post['module_materialize_icon_pin_thumb']) && is_file(DIR_IMAGE . $this->request->post['module_materialize_icon_pin_thumb'])) {
			$data['module_materialize_icon_pin_thumb'] = $this->model_tool_image->resize($this->request->post['module_materialize_icon_pin'], 100, 100);
		} elseif (!empty($this->config->get('module_materialize_icon_pin'))) {
			$data['module_materialize_icon_pin_thumb'] = $this->model_tool_image->resize($this->config->get('module_materialize_icon_pin'), 100, 100);
		} else {
			$data['module_materialize_icon_pin_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if (isset($this->request->post['module_materialize_icon_pin_width'])) {
			$data['module_materialize_icon_pin_width'] = $this->request->post['module_materialize_icon_pin_width'];
		} else {
			$data['module_materialize_icon_pin_width'] = $this->config->get('module_materialize_icon_pin_width');
		}

		if (isset($this->request->post['module_materialize_icon_pin_height'])) {
			$data['module_materialize_icon_pin_height'] = $this->request->post['module_materialize_icon_pin_height'];
		} else {
			$data['module_materialize_icon_pin_height'] = $this->config->get('module_materialize_icon_pin_height');
		}

		/* Status */
		if (isset($this->request->post['module_materialize_status'])) {
			$data['module_materialize_status'] = $this->request->post['module_materialize_status'];
		} else {
			$data['module_materialize_status'] = $this->config->get('module_materialize_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/materialize', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}