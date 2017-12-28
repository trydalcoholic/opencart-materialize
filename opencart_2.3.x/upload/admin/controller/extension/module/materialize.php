<?php
class ControllerExtensionModuleMaterialize extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/materialize');

		$this->document->setTitle($this->language->get('materialize_title'));
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

		$this->load->model('setting/setting');

		$this->load->model('tool/image');

		$this->load->model('extension/module/materialize');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_materialize', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->get['apply'])) {
				$this->response->redirect($this->url->link('extension/module/materialize', 'token=' . $this->session->data['token'], true));
			} else {
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['materialize_title'] = $this->language->get('materialize_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_type'] = $this->language->get('entry_type');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_apply'] = $this->language->get('button_apply');

		$data['tab_colors'] = $this->language->get('tab_colors');
		$data['tab_header'] = $this->language->get('tab_header');
		$data['tab_footer'] = $this->language->get('tab_footer');
		$data['tab_product'] = $this->language->get('tab_product');
		$data['tab_common'] = $this->language->get('tab_common');
		$data['tab_buttons'] = $this->language->get('tab_buttons');
		$data['tab_map'] = $this->language->get('tab_map');
		$data['tab_desktop'] = $this->language->get('tab_desktop');
		$data['tab_mobile'] = $this->language->get('tab_mobile');

		$data['text_extension'] = $this->language->get('text_extension');
		$data['text_success'] = $this->language->get('text_success');
		$data['text_materialize'] = $this->language->get('text_materialize');

		$data['entry_text'] = $this->language->get('entry_text');

		$data['entry_bar'] = $this->language->get('entry_bar');
		$data['entry_colors'] = $this->language->get('entry_colors');
		$data['entry_top_menu'] = $this->language->get('entry_top_menu');
		$data['entry_header'] = $this->language->get('entry_header');
		$data['entry_navigation'] = $this->language->get('entry_navigation');
		$data['entry_search'] = $this->language->get('entry_search');
		$data['entry_sidebar'] = $this->language->get('entry_sidebar');
		$data['entry_mob_search'] = $this->language->get('entry_mob_search');
		$data['entry_footer'] = $this->language->get('entry_footer');
		$data['entry_background'] = $this->language->get('entry_background');
		$data['entry_nav_btn'] = $this->language->get('entry_nav_btn');
		$data['entry_cart_btn'] = $this->language->get('entry_cart_btn');
		$data['entry_total_btn'] = $this->language->get('entry_total_btn');
		$data['entry_compare_btn'] = $this->language->get('entry_compare_btn');
		$data['entry_tot_cmp_btn'] = $this->language->get('entry_tot_cmp_btn');
		$data['entry_btt_btn'] = $this->language->get('entry_btt_btn');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_contact'] = $this->language->get('entry_contact');
		$data['entry_socials'] = $this->language->get('entry_socials');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_not_index'] = $this->language->get('entry_not_index');

		$data['entry_show_fields'] = $this->language->get('entry_show_fields');
		$data['entry_fields'] = $this->language->get('entry_fields');
		$data['entry_show'] = $this->language->get('entry_show');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_upc'] = $this->language->get('entry_upc');
		$data['entry_ean'] = $this->language->get('entry_ean');
		$data['entry_jan'] = $this->language->get('entry_jan');
		$data['entry_isbn'] = $this->language->get('entry_isbn');
		$data['entry_mpn'] = $this->language->get('entry_mpn');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_weight'] = $this->language->get('entry_weight');
		$data['entry_show_remainder'] = $this->language->get('entry_show_remainder');
		$data['entry_calculation'] = $this->language->get('entry_calculation');

		$data['entry_payment'] = $this->language->get('entry_payment');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_icon'] = $this->language->get('entry_icon');

		$data['entry_api'] = $this->language->get('entry_api');
		$data['entry_geocode'] = $this->language->get('entry_geocode');
		$data['entry_lat'] = $this->language->get('entry_lat');
		$data['entry_lng'] = $this->language->get('entry_lng');
		$data['entry_icon_pin'] = $this->language->get('entry_icon_pin');
		$data['entry_image_size'] = $this->language->get('entry_image_size');

		$data['help_colors'] = $this->language->get('help_colors');
		$data['help_not_index'] = $this->language->get('help_not_index');
		$data['help_payment'] = $this->language->get('help_payment');
		$data['help_image_size'] = $this->language->get('help_image_size');
		$data['help_google_map'] = $this->language->get('help_google_map');
		$data['help_geocode'] = $this->language->get('help_geocode');

		$data['error_permission'] = $this->language->get('error_permission');
		$data['error_percent_remainder'] = $this->language->get('error_percent_remainder');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['error_module_materialize_percent_remainder'])) {
			$data['error_module_materialize_percent_remainder'] = $this->error['error_module_materialize_percent_remainder'];
		} else {
			$data['error_module_materialize_percent_remainder'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_extension'),
			'href'	=> $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('heading_title'),
			'href'	=> $this->url->link('extension/module/materialize', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/materialize', 'token=' . $this->session->data['token'], true);

		$data['apply'] = $this->url->link('extension/module/materialize', 'token=' . $this->session->data['token'] . '&apply', true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

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
			$data['module_materialize'] = '';
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

		if (isset($this->request->post['module_materialize_color_compare_btn'])) {
			$data['module_materialize_color_compare_btn'] = $this->request->post['module_materialize_color_compare_btn'];
		} elseif ($this->config->get('module_materialize_color_compare_btn') == true) {
			$data['module_materialize_color_compare_btn'] = $this->config->get('module_materialize_color_compare_btn');
		} else {
			$data['module_materialize_color_compare_btn'] = 'blue';
		}

		if (isset($this->request->post['module_materialize_color_compare_btn_text'])) {
			$data['module_materialize_color_compare_btn_text'] = $this->request->post['module_materialize_color_compare_btn_text'];
		} elseif ($this->config->get('module_materialize_color_compare_btn_text') == true) {
			$data['module_materialize_color_compare_btn_text'] = $this->config->get('module_materialize_color_compare_btn_text');
		} else {
			$data['module_materialize_color_compare_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['module_materialize_color_compare_total_btn'])) {
			$data['module_materialize_color_compare_total_btn'] = $this->request->post['module_materialize_color_compare_total_btn'];
		} elseif ($this->config->get('module_materialize_color_compare_total_btn') == true) {
			$data['module_materialize_color_compare_total_btn'] = $this->config->get('module_materialize_color_compare_total_btn');
		} else {
			$data['module_materialize_color_compare_total_btn'] = 'light-blue darken-2';
		}

		if (isset($this->request->post['module_materialize_color_compare_total_btn_text'])) {
			$data['module_materialize_color_compare_total_btn_text'] = $this->request->post['module_materialize_color_compare_total_btn_text'];
		} elseif ($this->config->get('module_materialize_color_compare_total_btn_text') == true) {
			$data['module_materialize_color_compare_total_btn_text'] = $this->config->get('module_materialize_color_compare_total_btn_text');
		} else {
			$data['module_materialize_color_compare_total_btn_text'] = 'white-text';
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

		/* Show fields */
		if (isset($this->request->post['module_materialize_show_model'])) {
			$data['module_materialize_show_model'] = $this->request->post['module_materialize_show_model'];
		} else {
			$data['module_materialize_show_model'] = $this->config->get('module_materialize_show_model');
		}

		if (isset($this->request->post['module_materialize_show_sku'])) {
			$data['module_materialize_show_sku'] = $this->request->post['module_materialize_show_sku'];
		} else {
			$data['module_materialize_show_sku'] = $this->config->get('module_materialize_show_sku');
		}

		if (isset($this->request->post['module_materialize_show_upc'])) {
			$data['module_materialize_show_upc'] = $this->request->post['module_materialize_show_upc'];
		} else {
			$data['module_materialize_show_upc'] = $this->config->get('module_materialize_show_upc');
		}

		if (isset($this->request->post['module_materialize_show_ean'])) {
			$data['module_materialize_show_ean'] = $this->request->post['module_materialize_show_ean'];
		} else {
			$data['module_materialize_show_ean'] = $this->config->get('module_materialize_show_ean');
		}

		if (isset($this->request->post['module_materialize_show_jan'])) {
			$data['module_materialize_show_jan'] = $this->request->post['module_materialize_show_jan'];
		} else {
			$data['module_materialize_show_jan'] = $this->config->get('module_materialize_show_jan');
		}

		if (isset($this->request->post['module_materialize_show_isbn'])) {
			$data['module_materialize_show_isbn'] = $this->request->post['module_materialize_show_isbn'];
		} else {
			$data['module_materialize_show_isbn'] = $this->config->get('module_materialize_show_isbn');
		}

		if (isset($this->request->post['module_materialize_show_mpn'])) {
			$data['module_materialize_show_mpn'] = $this->request->post['module_materialize_show_mpn'];
		} else {
			$data['module_materialize_show_mpn'] = $this->config->get('module_materialize_show_mpn');
		}

		if (isset($this->request->post['module_materialize_show_location'])) {
			$data['module_materialize_show_location'] = $this->request->post['module_materialize_show_location'];
		} else {
			$data['module_materialize_show_location'] = $this->config->get('module_materialize_show_location');
		}

		if (isset($this->request->post['module_materialize_show_dimensions'])) {
			$data['module_materialize_show_dimensions'] = $this->request->post['module_materialize_show_dimensions'];
		} else {
			$data['module_materialize_show_dimensions'] = $this->config->get('module_materialize_show_dimensions');
		}

		if (isset($this->request->post['module_materialize_show_weight'])) {
			$data['module_materialize_show_weight'] = $this->request->post['module_materialize_show_weight'];
		} else {
			$data['module_materialize_show_weight'] = $this->config->get('module_materialize_show_weight');
		}

		if (isset($this->request->post['module_materialize_show_remainder'])) {
			$data['module_materialize_show_remainder'] = $this->request->post['module_materialize_show_remainder'];
		} else {
			$data['module_materialize_show_remainder'] = $this->config->get('module_materialize_show_remainder');
		}

		if (isset($this->request->post['module_materialize_type_remainder'])) {
			$data['module_materialize_type_remainder'] = $this->request->post['module_materialize_type_remainder'];
		} else {
			$data['module_materialize_type_remainder'] = $this->config->get('module_materialize_type_remainder');
		}

		if (isset($this->request->post['module_materialize_percent_remainder'])) {
			$data['module_materialize_percent_remainder'] = $this->request->post['module_materialize_percent_remainder'];
		} else {
			$data['module_materialize_percent_remainder'] = $this->config->get('module_materialize_percent_remainder');
		}

		/* Payment methods */
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

		if ($this->request->post['module_materialize_type_remainder'] && ((utf8_strlen($this->request->post['module_materialize_percent_remainder']) < 1) || ($this->request->post['module_materialize_percent_remainder'] < 1))) {
			$this->error['error_module_materialize_percent_remainder'] = $this->language->get('error_percent_remainder');
		}

		return !$this->error;
	}
}