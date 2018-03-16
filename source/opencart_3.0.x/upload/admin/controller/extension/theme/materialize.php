<?php
class ControllerExtensionThemeMaterialize extends Controller {
	private $error = array();

	public function install() {
		$this->load->model('extension/materialize/materialize');
		$this->load->model('user/user_group');
		$this->load->model('setting/setting');

		$this->model_extension_materialize_materialize->install();

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/materialize');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/materialize');

		$data['theme_materialize_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('theme_materialize', $data);
	}

	public function uninstall() {
		$this->load->model('extension/materialize/materialize');
		$this->load->model('user/user_group');

		$this->model_extension_materialize_materialize->uninstall();

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/materialize');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/materialize');
	}

	public function index() {
		$this->load->language('extension/theme/materialize');
		$this->load->language('extension/materialize/materialize');

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

		$this->load->model('extension/materialize/materialize');

		$this->load->model('localisation/language');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('theme_materialize', $this->request->post, $this->request->get['store_id']);

			$this->model_extension_materialize_materialize->editSocialIcon($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->get['apply'])) {
				$this->response->redirect($this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'], true));
			} else {
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme', true));
			}
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['product_limit'])) {
			$data['error_product_limit'] = $this->error['product_limit'];
		} else {
			$data['error_product_limit'] = '';
		}

		if (isset($this->error['product_description_length'])) {
			$data['error_product_description_length'] = $this->error['product_description_length'];
		} else {
			$data['error_product_description_length'] = '';
		}

		if (isset($this->error['image_category'])) {
			$data['error_image_category'] = $this->error['image_category'];
		} else {
			$data['error_image_category'] = '';
		}

		if (isset($this->error['image_thumb'])) {
			$data['error_image_thumb'] = $this->error['image_thumb'];
		} else {
			$data['error_image_thumb'] = '';
		}

		if (isset($this->error['image_popup'])) {
			$data['error_image_popup'] = $this->error['image_popup'];
		} else {
			$data['error_image_popup'] = '';
		}

		if (isset($this->error['image_product'])) {
			$data['error_image_product'] = $this->error['image_product'];
		} else {
			$data['error_image_product'] = '';
		}

		if (isset($this->error['image_additional'])) {
			$data['error_image_additional'] = $this->error['image_additional'];
		} else {
			$data['error_image_additional'] = '';
		}

		if (isset($this->error['image_related'])) {
			$data['error_image_related'] = $this->error['image_related'];
		} else {
			$data['error_image_related'] = '';
		}

		if (isset($this->error['image_compare'])) {
			$data['error_image_compare'] = $this->error['image_compare'];
		} else {
			$data['error_image_compare'] = '';
		}

		if (isset($this->error['image_wishlist'])) {
			$data['error_image_wishlist'] = $this->error['image_wishlist'];
		} else {
			$data['error_image_wishlist'] = '';
		}

		if (isset($this->error['image_cart'])) {
			$data['error_image_cart'] = $this->error['image_cart'];
		} else {
			$data['error_image_cart'] = '';
		}

		if (isset($this->error['image_location'])) {
			$data['error_image_location'] = $this->error['image_location'];
		} else {
			$data['error_image_location'] = '';
		}

		if (isset($this->error['percent_remainder'])) {
			$data['error_percent_remainder'] = $this->error['percent_remainder'];
		} else {
			$data['error_percent_remainder'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'], true)
		);

		$data['action'] = $this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'], true);

		$data['apply'] = $this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'] . '&apply', true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme', true);

		if (isset($this->request->get['store_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$setting_info = $this->model_setting_setting->getSetting('theme_materialize', $this->request->get['store_id']);
		}

		$data['theme_materialize_directory'] = 'materialize';

		if (isset($this->request->post['theme_materialize_installed_appeal'])) {
			$data['theme_materialize_installed_appeal'] = $this->request->post['theme_materialize_installed_appeal'];
		} else {
			$data['theme_materialize_installed_appeal'] = $this->config->get('theme_materialize_installed_appeal');
		}

		if (isset($this->request->post['theme_materialize_status'])) {
			$data['theme_materialize_status'] = $this->request->post['theme_materialize_status'];
		} elseif (isset($setting_info['theme_materialize_status'])) {
			$data['theme_materialize_status'] = $setting_info['theme_materialize_status'];
		} else {
			$data['theme_materialize_status'] = '';
		}

		if (isset($this->request->post['theme_materialize_image_zoom'])) {
			$data['theme_materialize_image_zoom'] = $this->request->post['theme_materialize_image_zoom'];
		} elseif (isset($setting_info['theme_materialize_image_zoom'])) {
			$data['theme_materialize_image_zoom'] = $setting_info['theme_materialize_image_zoom'];
		} else {
			$data['theme_materialize_image_zoom'] = '';
		}

		if (isset($this->request->post['theme_materialize_product_limit'])) {
			$data['theme_materialize_product_limit'] = $this->request->post['theme_materialize_product_limit'];
		} elseif (isset($setting_info['theme_materialize_product_limit'])) {
			$data['theme_materialize_product_limit'] = $setting_info['theme_materialize_product_limit'];
		} else {
			$data['theme_materialize_product_limit'] = 18;
		}

		if (isset($this->request->post['theme_materialize_product_description_length'])) {
			$data['theme_materialize_product_description_length'] = $this->request->post['theme_materialize_product_description_length'];
		} elseif (isset($setting_info['theme_materialize_product_description_length'])) {
			$data['theme_materialize_product_description_length'] = $setting_info['theme_materialize_product_description_length'];
		} else {
			$data['theme_materialize_product_description_length'] = 400;
		}

		if (isset($this->request->post['theme_materialize_image_category_width'])) {
			$data['theme_materialize_image_category_width'] = $this->request->post['theme_materialize_image_category_width'];
		} elseif (isset($setting_info['theme_materialize_image_category_width'])) {
			$data['theme_materialize_image_category_width'] = $setting_info['theme_materialize_image_category_width'];
		} else {
			$data['theme_materialize_image_category_width'] = 100;
		}

		if (isset($this->request->post['theme_materialize_image_category_height'])) {
			$data['theme_materialize_image_category_height'] = $this->request->post['theme_materialize_image_category_height'];
		} elseif (isset($setting_info['theme_materialize_image_category_height'])) {
			$data['theme_materialize_image_category_height'] = $setting_info['theme_materialize_image_category_height'];
		} else {
			$data['theme_materialize_image_category_height'] = 100;
		}

		if (isset($this->request->post['theme_materialize_image_thumb_width'])) {
			$data['theme_materialize_image_thumb_width'] = $this->request->post['theme_materialize_image_thumb_width'];
		} elseif (isset($setting_info['theme_materialize_image_thumb_width'])) {
			$data['theme_materialize_image_thumb_width'] = $setting_info['theme_materialize_image_thumb_width'];
		} else {
			$data['theme_materialize_image_thumb_width'] = 250;
		}

		if (isset($this->request->post['theme_materialize_image_thumb_height'])) {
			$data['theme_materialize_image_thumb_height'] = $this->request->post['theme_materialize_image_thumb_height'];
		} elseif (isset($setting_info['theme_materialize_image_thumb_height'])) {
			$data['theme_materialize_image_thumb_height'] = $setting_info['theme_materialize_image_thumb_height'];
		} else {
			$data['theme_materialize_image_thumb_height'] = 250;
		}

		if (isset($this->request->post['theme_materialize_image_popup_width'])) {
			$data['theme_materialize_image_popup_width'] = $this->request->post['theme_materialize_image_popup_width'];
		} elseif (isset($setting_info['theme_materialize_image_popup_width'])) {
			$data['theme_materialize_image_popup_width'] = $setting_info['theme_materialize_image_popup_width'];
		} else {
			$data['theme_materialize_image_popup_width'] = 1200;
		}

		if (isset($this->request->post['theme_materialize_image_popup_height'])) {
			$data['theme_materialize_image_popup_height'] = $this->request->post['theme_materialize_image_popup_height'];
		} elseif (isset($setting_info['theme_materialize_image_popup_height'])) {
			$data['theme_materialize_image_popup_height'] = $setting_info['theme_materialize_image_popup_height'];
		} else {
			$data['theme_materialize_image_popup_height'] = 1200;
		}

		if (isset($this->request->post['theme_materialize_image_product_width'])) {
			$data['theme_materialize_image_product_width'] = $this->request->post['theme_materialize_image_product_width'];
		} elseif (isset($setting_info['theme_materialize_image_product_width'])) {
			$data['theme_materialize_image_product_width'] = $setting_info['theme_materialize_image_product_width'];
		} else {
			$data['theme_materialize_image_product_width'] = 200;
		}

		if (isset($this->request->post['theme_materialize_image_product_height'])) {
			$data['theme_materialize_image_product_height'] = $this->request->post['theme_materialize_image_product_height'];
		} elseif (isset($setting_info['theme_materialize_image_product_height'])) {
			$data['theme_materialize_image_product_height'] = $setting_info['theme_materialize_image_product_height'];
		} else {
			$data['theme_materialize_image_product_height'] = 200;
		}

		if (isset($this->request->post['theme_materialize_image_additional_width'])) {
			$data['theme_materialize_image_additional_width'] = $this->request->post['theme_materialize_image_additional_width'];
		} elseif (isset($setting_info['theme_materialize_image_additional_width'])) {
			$data['theme_materialize_image_additional_width'] = $setting_info['theme_materialize_image_additional_width'];
		} else {
			$data['theme_materialize_image_additional_width'] = 100;
		}

		if (isset($this->request->post['theme_materialize_image_additional_height'])) {
			$data['theme_materialize_image_additional_height'] = $this->request->post['theme_materialize_image_additional_height'];
		} elseif (isset($setting_info['theme_materialize_image_additional_height'])) {
			$data['theme_materialize_image_additional_height'] = $setting_info['theme_materialize_image_additional_height'];
		} else {
			$data['theme_materialize_image_additional_height'] = 100;
		}

		if (isset($this->request->post['theme_materialize_image_related_width'])) {
			$data['theme_materialize_image_related_width'] = $this->request->post['theme_materialize_image_related_width'];
		} elseif (isset($setting_info['theme_materialize_image_related_width'])) {
			$data['theme_materialize_image_related_width'] = $setting_info['theme_materialize_image_related_width'];
		} else {
			$data['theme_materialize_image_related_width'] = 200;
		}

		if (isset($this->request->post['theme_materialize_image_related_height'])) {
			$data['theme_materialize_image_related_height'] = $this->request->post['theme_materialize_image_related_height'];
		} elseif (isset($setting_info['theme_materialize_image_related_height'])) {
			$data['theme_materialize_image_related_height'] = $setting_info['theme_materialize_image_related_height'];
		} else {
			$data['theme_materialize_image_related_height'] = 200;
		}

		if (isset($this->request->post['theme_materialize_image_compare_width'])) {
			$data['theme_materialize_image_compare_width'] = $this->request->post['theme_materialize_image_compare_width'];
		} elseif (isset($setting_info['theme_materialize_image_compare_width'])) {
			$data['theme_materialize_image_compare_width'] = $setting_info['theme_materialize_image_compare_width'];
		} else {
			$data['theme_materialize_image_compare_width'] = 90;
		}

		if (isset($this->request->post['theme_materialize_image_compare_height'])) {
			$data['theme_materialize_image_compare_height'] = $this->request->post['theme_materialize_image_compare_height'];
		} elseif (isset($setting_info['theme_materialize_image_compare_height'])) {
			$data['theme_materialize_image_compare_height'] = $setting_info['theme_materialize_image_compare_height'];
		} else {
			$data['theme_materialize_image_compare_height'] = 90;
		}

		if (isset($this->request->post['theme_materialize_image_wishlist_width'])) {
			$data['theme_materialize_image_wishlist_width'] = $this->request->post['theme_materialize_image_wishlist_width'];
		} elseif (isset($setting_info['theme_materialize_image_wishlist_width'])) {
			$data['theme_materialize_image_wishlist_width'] = $setting_info['theme_materialize_image_wishlist_width'];
		} else {
			$data['theme_materialize_image_wishlist_width'] = 75;
		}

		if (isset($this->request->post['theme_materialize_image_wishlist_height'])) {
			$data['theme_materialize_image_wishlist_height'] = $this->request->post['theme_materialize_image_wishlist_height'];
		} elseif (isset($setting_info['theme_materialize_image_wishlist_height'])) {
			$data['theme_materialize_image_wishlist_height'] = $setting_info['theme_materialize_image_wishlist_height'];
		} else {
			$data['theme_materialize_image_wishlist_height'] = 75;
		}

		if (isset($this->request->post['theme_materialize_image_cart_width'])) {
			$data['theme_materialize_image_cart_width'] = $this->request->post['theme_materialize_image_cart_width'];
		} elseif (isset($setting_info['theme_materialize_image_cart_width'])) {
			$data['theme_materialize_image_cart_width'] = $setting_info['theme_materialize_image_cart_width'];
		} else {
			$data['theme_materialize_image_cart_width'] = 75;
		}

		if (isset($this->request->post['theme_materialize_image_cart_height'])) {
			$data['theme_materialize_image_cart_height'] = $this->request->post['theme_materialize_image_cart_height'];
		} elseif (isset($setting_info['theme_materialize_image_cart_height'])) {
			$data['theme_materialize_image_cart_height'] = $setting_info['theme_materialize_image_cart_height'];
		} else {
			$data['theme_materialize_image_cart_height'] = 75;
		}

		if (isset($this->request->post['theme_materialize_image_location_width'])) {
			$data['theme_materialize_image_location_width'] = $this->request->post['theme_materialize_image_location_width'];
		} elseif (isset($setting_info['theme_materialize_image_location_width'])) {
			$data['theme_materialize_image_location_width'] = $setting_info['theme_materialize_image_location_width'];
		} else {
			$data['theme_materialize_image_location_width'] = 230;
		}

		if (isset($this->request->post['theme_materialize_image_location_height'])) {
			$data['theme_materialize_image_location_height'] = $this->request->post['theme_materialize_image_location_height'];
		} elseif (isset($setting_info['theme_materialize_image_location_height'])) {
			$data['theme_materialize_image_location_height'] = $setting_info['theme_materialize_image_location_height'];
		} else {
			$data['theme_materialize_image_location_height'] = 75;
		}

		/* Materialize template */

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$theme_materialize = array();

		foreach ($data['languages'] as $key => $language) {
			$theme_materialize[$language['language_id']][] = $this->language->get('theme_materialize');
		}

		if (isset($this->request->post['theme_materialize'])) {
			$data['theme_materialize'] = $this->request->post['theme_materialize'];
		} elseif ($this->config->get('theme_materialize') == true) {
			$data['theme_materialize'] = $this->config->get('theme_materialize');
		} else {
			$data['theme_materialize'] = '';
		}

		/* General */

		$data['theme_materialize_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();

		$data['theme_materialize_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

		if (isset($this->request->post['theme_materialize_color_background'])) {
			$data['theme_materialize_color_background'] = $this->request->post['theme_materialize_color_background'];
		} elseif ($this->config->get('theme_materialize_color_background') == true) {
			$data['theme_materialize_color_background'] = $this->config->get('theme_materialize_color_background');
		} else {
			$data['theme_materialize_color_background'] = 'grey lighten-3';
		}

		if (isset($this->request->post['theme_materialize_color_nav_btn'])) {
			$data['theme_materialize_color_nav_btn'] = $this->request->post['theme_materialize_color_nav_btn'];
		} elseif ($this->config->get('theme_materialize_color_nav_btn') == true) {
			$data['theme_materialize_color_nav_btn'] = $this->config->get('theme_materialize_color_nav_btn');
		} else {
			$data['theme_materialize_color_nav_btn'] = 'blue-grey darken-2';
		}

		if (isset($this->request->post['theme_materialize_color_nav_btn_text'])) {
			$data['theme_materialize_color_nav_btn_text'] = $this->request->post['theme_materialize_color_nav_btn_text'];
		} elseif ($this->config->get('theme_materialize_color_nav_btn_text') == true) {
			$data['theme_materialize_color_nav_btn_text'] = $this->config->get('theme_materialize_color_nav_btn_text');
		} else {
			$data['theme_materialize_color_nav_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['theme_materialize_color_cart_btn'])) {
			$data['theme_materialize_color_cart_btn'] = $this->request->post['theme_materialize_color_cart_btn'];
		} elseif ($this->config->get('theme_materialize_color_cart_btn') == true) {
			$data['theme_materialize_color_cart_btn'] = $this->config->get('theme_materialize_color_cart_btn');
		} else {
			$data['theme_materialize_color_cart_btn'] = 'red';
		}

		if (isset($this->request->post['theme_materialize_color_cart_btn_text'])) {
			$data['theme_materialize_color_cart_btn_text'] = $this->request->post['theme_materialize_color_cart_btn_text'];
		} elseif ($this->config->get('theme_materialize_color_cart_btn_text') == true) {
			$data['theme_materialize_color_cart_btn_text'] = $this->config->get('theme_materialize_color_cart_btn_text');
		} else {
			$data['theme_materialize_color_cart_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['theme_materialize_color_total_btn'])) {
			$data['theme_materialize_color_total_btn'] = $this->request->post['theme_materialize_color_total_btn'];
		} elseif ($this->config->get('theme_materialize_color_total_btn') == true) {
			$data['theme_materialize_color_total_btn'] = $this->config->get('theme_materialize_color_total_btn');
		} else {
			$data['theme_materialize_color_total_btn'] = 'light-blue darken-1';
		}

		if (isset($this->request->post['theme_materialize_color_total_btn_text'])) {
			$data['theme_materialize_color_total_btn_text'] = $this->request->post['theme_materialize_color_total_btn_text'];
		} elseif ($this->config->get('theme_materialize_color_total_btn_text') == true) {
			$data['theme_materialize_color_total_btn_text'] = $this->config->get('theme_materialize_color_total_btn_text');
		} else {
			$data['theme_materialize_color_total_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['theme_materialize_color_compare_btn'])) {
			$data['theme_materialize_color_compare_btn'] = $this->request->post['theme_materialize_color_compare_btn'];
		} elseif ($this->config->get('theme_materialize_color_compare_btn') == true) {
			$data['theme_materialize_color_compare_btn'] = $this->config->get('theme_materialize_color_compare_btn');
		} else {
			$data['theme_materialize_color_compare_btn'] = 'blue';
		}

		if (isset($this->request->post['theme_materialize_color_compare_btn_text'])) {
			$data['theme_materialize_color_compare_btn_text'] = $this->request->post['theme_materialize_color_compare_btn_text'];
		} elseif ($this->config->get('theme_materialize_color_compare_btn_text') == true) {
			$data['theme_materialize_color_compare_btn_text'] = $this->config->get('theme_materialize_color_compare_btn_text');
		} else {
			$data['theme_materialize_color_compare_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['theme_materialize_color_compare_total_btn'])) {
			$data['theme_materialize_color_compare_total_btn'] = $this->request->post['theme_materialize_color_compare_total_btn'];
		} elseif ($this->config->get('theme_materialize_color_compare_total_btn') == true) {
			$data['theme_materialize_color_compare_total_btn'] = $this->config->get('theme_materialize_color_compare_total_btn');
		} else {
			$data['theme_materialize_color_compare_total_btn'] = 'light-blue darken-2';
		}

		if (isset($this->request->post['theme_materialize_color_compare_total_btn_text'])) {
			$data['theme_materialize_color_compare_total_btn_text'] = $this->request->post['theme_materialize_color_compare_total_btn_text'];
		} elseif ($this->config->get('theme_materialize_color_compare_total_btn_text') == true) {
			$data['theme_materialize_color_compare_total_btn_text'] = $this->config->get('theme_materialize_color_compare_total_btn_text');
		} else {
			$data['theme_materialize_color_compare_total_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['theme_materialize_color_btt_btn'])) {
			$data['theme_materialize_color_btt_btn'] = $this->request->post['theme_materialize_color_btt_btn'];
		} elseif ($this->config->get('theme_materialize_color_btt_btn') == true) {
			$data['theme_materialize_color_btt_btn'] = $this->config->get('theme_materialize_color_btt_btn');
		} else {
			$data['theme_materialize_color_btt_btn'] = 'red';
		}

		if (isset($this->request->post['theme_materialize_color_btt_btn_text'])) {
			$data['theme_materialize_color_btt_btn_text'] = $this->request->post['theme_materialize_color_btt_btn_text'];
		} elseif ($this->config->get('theme_materialize_color_btt_btn_text') == true) {
			$data['theme_materialize_color_btt_btn_text'] = $this->config->get('theme_materialize_color_btt_btn_text');
		} else {
			$data['theme_materialize_color_btt_btn_text'] = 'white-text';
		}

		if (isset($this->request->post['theme_materialize_color_browser_bar'])) {
			$data['theme_materialize_color_browser_bar'] = $this->request->post['theme_materialize_color_browser_bar'];
		} elseif ($this->config->get('theme_materialize_color_browser_bar') == true) {
			$data['theme_materialize_color_browser_bar'] = $this->config->get('theme_materialize_color_browser_bar');
		} else {
			$data['theme_materialize_color_browser_bar'] = 'blue-grey darken-4';
		}

		if (isset($this->request->post['theme_materialize_color_browser_bar_hex'])) {
			$data['theme_materialize_color_browser_bar_hex'] = $this->request->post['theme_materialize_color_browser_bar_hex'];
		} elseif ($this->config->get('theme_materialize_color_browser_bar_hex') == true) {
			$data['theme_materialize_color_browser_bar_hex'] = $this->config->get('theme_materialize_color_browser_bar_hex');
		} else {
			$data['theme_materialize_color_browser_bar_hex'] = '#263238';
		}

		if (isset($this->request->post['theme_materialize_color_top_menu'])) {
			$data['theme_materialize_color_top_menu'] = $this->request->post['theme_materialize_color_top_menu'];
		} elseif ($this->config->get('theme_materialize_color_top_menu') == true) {
			$data['theme_materialize_color_top_menu'] = $this->config->get('theme_materialize_color_top_menu');
		} else {
			$data['theme_materialize_color_top_menu'] = 'blue-grey darken-4';
		}

		if (isset($this->request->post['theme_materialize_color_top_menu_text'])) {
			$data['theme_materialize_color_top_menu_text'] = $this->request->post['theme_materialize_color_top_menu_text'];
		} elseif ($this->config->get('theme_materialize_color_top_menu_text') == true) {
			$data['theme_materialize_color_top_menu_text'] = $this->config->get('theme_materialize_color_top_menu_text');
		} else {
			$data['theme_materialize_color_top_menu_text'] = 'white-text';
		}

		if (isset($this->request->post['theme_materialize_color_header'])) {
			$data['theme_materialize_color_header'] = $this->request->post['theme_materialize_color_header'];
		} elseif ($this->config->get('theme_materialize_color_header') == true) {
			$data['theme_materialize_color_header'] = $this->config->get('theme_materialize_color_header');
		} else {
			$data['theme_materialize_color_header'] = 'blue-grey darken-3';
		}

		if (isset($this->request->post['theme_materialize_color_header_text'])) {
			$data['theme_materialize_color_header_text'] = $this->request->post['theme_materialize_color_header_text'];
		} elseif ($this->config->get('theme_materialize_color_header_text') == true) {
			$data['theme_materialize_color_header_text'] = $this->config->get('theme_materialize_color_header_text');
		} else {
			$data['theme_materialize_color_header_text'] = 'blue-grey-text text-lighten-5';
		}

		if (isset($this->request->post['theme_materialize_color_navigation'])) {
			$data['theme_materialize_color_navigation'] = $this->request->post['theme_materialize_color_navigation'];
		} elseif ($this->config->get('theme_materialize_color_navigation') == true) {
			$data['theme_materialize_color_navigation'] = $this->config->get('theme_materialize_color_navigation');
		} else {
			$data['theme_materialize_color_navigation'] = 'blue-grey darken-2';
		}

		if (isset($this->request->post['theme_materialize_color_navigation_text'])) {
			$data['theme_materialize_color_navigation_text'] = $this->request->post['theme_materialize_color_navigation_text'];
		} elseif ($this->config->get('theme_materialize_color_navigation_text') == true) {
			$data['theme_materialize_color_navigation_text'] = $this->config->get('theme_materialize_color_navigation_text');
		} else {
			$data['theme_materialize_color_navigation_text'] = 'white-text';
		}

		if (isset($this->request->post['theme_materialize_color_search'])) {
			$data['theme_materialize_color_search'] = $this->request->post['theme_materialize_color_search'];
		} elseif ($this->config->get('theme_materialize_color_search') == true) {
			$data['theme_materialize_color_search'] = $this->config->get('theme_materialize_color_search');
		} else {
			$data['theme_materialize_color_search'] = 'blue-grey darken-1';
		}

		if (isset($this->request->post['theme_materialize_color_sidebar'])) {
			$data['theme_materialize_color_sidebar'] = $this->request->post['theme_materialize_color_sidebar'];
		} elseif ($this->config->get('theme_materialize_color_sidebar') == true) {
			$data['theme_materialize_color_sidebar'] = $this->config->get('theme_materialize_color_sidebar');
		} else {
			$data['theme_materialize_color_sidebar'] = 'blue-grey darken-2';
		}

		if (isset($this->request->post['theme_materialize_color_sidebar_text'])) {
			$data['theme_materialize_color_sidebar_text'] = $this->request->post['theme_materialize_color_sidebar_text'];
		} elseif ($this->config->get('theme_materialize_color_sidebar_text') == true) {
			$data['theme_materialize_color_sidebar_text'] = $this->config->get('theme_materialize_color_sidebar_text');
		} else {
			$data['theme_materialize_color_sidebar_text'] = 'white-text';
		}

		if (isset($this->request->post['theme_materialize_color_mobile_search'])) {
			$data['theme_materialize_color_mobile_search'] = $this->request->post['theme_materialize_color_mobile_search'];
		} elseif ($this->config->get('theme_materialize_color_mobile_search') == true) {
			$data['theme_materialize_color_mobile_search'] = $this->config->get('theme_materialize_color_mobile_search');
		} else {
			$data['theme_materialize_color_mobile_search'] = 'blue-grey lighten-1';
		}

		if (isset($this->request->post['theme_materialize_color_footer'])) {
			$data['theme_materialize_color_footer'] = $this->request->post['theme_materialize_color_footer'];
		} elseif ($this->config->get('theme_materialize_color_footer') == true) {
			$data['theme_materialize_color_footer'] = $this->config->get('theme_materialize_color_footer');
		} else {
			$data['theme_materialize_color_footer'] = 'blue-grey darken-3';
		}

		if (isset($this->request->post['theme_materialize_color_footer_text'])) {
			$data['theme_materialize_color_footer_text'] = $this->request->post['theme_materialize_color_footer_text'];
		} elseif ($this->config->get('theme_materialize_color_footer_text') == true) {
			$data['theme_materialize_color_footer_text'] = $this->config->get('theme_materialize_color_footer_text');
		} else {
			$data['theme_materialize_color_footer_text'] = 'grey-text text-lighten-3';
		}

		/* Footer */

		if (isset($this->request->post['theme_materialize_footer_contact'])) {
			$data['theme_materialize_footer_contact'] = $this->request->post['theme_materialize_footer_contact'];
		} else {
			$data['theme_materialize_footer_contact'] = $this->config->get('theme_materialize_footer_contact');
		}

		if (isset($this->request->post['theme_materialize_sn_index'])) {
			$data['theme_materialize_sn_index'] = $this->request->post['theme_materialize_sn_index'];
		} else {
			$data['theme_materialize_sn_index'] = $this->config->get('theme_materialize_sn_index');
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['theme_materialize_social_icon'])) {
			$theme_materialize_social_icons = $this->request->post['theme_materialize_social_icon'];
		} elseif ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$theme_materialize_social_icons = $this->model_extension_materialize_materialize->getSocialIcons();
		} else {
			$theme_materialize_social_icons = array();
		}

		$data['theme_materialize_social_icons'] = array();

		foreach ($theme_materialize_social_icons as $key => $value) {
			foreach ($value as $theme_materialize_social_icon) {
				if (is_file(DIR_IMAGE . $theme_materialize_social_icon['icon'])) {
					$icon = $theme_materialize_social_icon['icon'];
					$thumb = $theme_materialize_social_icon['icon'];
				} else {
					$icon = '';
					$thumb = 'no_image.png';
				}

				$data['theme_materialize_social_icons'][$key][] = array(
					'title'			=> $theme_materialize_social_icon['title'],
					'link'			=> $theme_materialize_social_icon['link'],
					'icon'			=> $icon,
					'thumb'			=> $this->model_tool_image->resize($thumb, 100, 100),
					'sort_order'	=> $theme_materialize_social_icon['sort_order']
				);
			}
		}

		/* Show fields */

		if (isset($this->request->post['theme_materialize_show_model'])) {
			$data['theme_materialize_show_model'] = $this->request->post['theme_materialize_show_model'];
		} else {
			$data['theme_materialize_show_model'] = $this->config->get('theme_materialize_show_model');
		}

		if (isset($this->request->post['theme_materialize_show_sku'])) {
			$data['theme_materialize_show_sku'] = $this->request->post['theme_materialize_show_sku'];
		} else {
			$data['theme_materialize_show_sku'] = $this->config->get('theme_materialize_show_sku');
		}

		if (isset($this->request->post['theme_materialize_show_upc'])) {
			$data['theme_materialize_show_upc'] = $this->request->post['theme_materialize_show_upc'];
		} else {
			$data['theme_materialize_show_upc'] = $this->config->get('theme_materialize_show_upc');
		}

		if (isset($this->request->post['theme_materialize_show_ean'])) {
			$data['theme_materialize_show_ean'] = $this->request->post['theme_materialize_show_ean'];
		} else {
			$data['theme_materialize_show_ean'] = $this->config->get('theme_materialize_show_ean');
		}

		if (isset($this->request->post['theme_materialize_show_jan'])) {
			$data['theme_materialize_show_jan'] = $this->request->post['theme_materialize_show_jan'];
		} else {
			$data['theme_materialize_show_jan'] = $this->config->get('theme_materialize_show_jan');
		}

		if (isset($this->request->post['theme_materialize_show_isbn'])) {
			$data['theme_materialize_show_isbn'] = $this->request->post['theme_materialize_show_isbn'];
		} else {
			$data['theme_materialize_show_isbn'] = $this->config->get('theme_materialize_show_isbn');
		}

		if (isset($this->request->post['theme_materialize_show_mpn'])) {
			$data['theme_materialize_show_mpn'] = $this->request->post['theme_materialize_show_mpn'];
		} else {
			$data['theme_materialize_show_mpn'] = $this->config->get('theme_materialize_show_mpn');
		}

		if (isset($this->request->post['theme_materialize_show_location'])) {
			$data['theme_materialize_show_location'] = $this->request->post['theme_materialize_show_location'];
		} else {
			$data['theme_materialize_show_location'] = $this->config->get('theme_materialize_show_location');
		}

		if (isset($this->request->post['theme_materialize_show_dimensions'])) {
			$data['theme_materialize_show_dimensions'] = $this->request->post['theme_materialize_show_dimensions'];
		} else {
			$data['theme_materialize_show_dimensions'] = $this->config->get('theme_materialize_show_dimensions');
		}

		if (isset($this->request->post['theme_materialize_show_weight'])) {
			$data['theme_materialize_show_weight'] = $this->request->post['theme_materialize_show_weight'];
		} else {
			$data['theme_materialize_show_weight'] = $this->config->get('theme_materialize_show_weight');
		}

		if (isset($this->request->post['theme_materialize_remainder'])) {
			$data['theme_materialize_remainder'] = $this->request->post['theme_materialize_remainder'];
		} else {
			$data['theme_materialize_remainder'] = $this->config->get('theme_materialize_remainder');
		}

		$data['remainders'] = array();

		$data['remainders'][] = array(
			'text'	=> $this->language->get('text_numerical'),
			'value'	=> 'numerical'
		);

		$data['remainders'][] = array(
			'text'	=> $this->language->get('text_progressbar'),
			'value'	=> 'progressbar'
		);

		if (isset($this->request->post['theme_materialize_percent_remainder'])) {
			$data['theme_materialize_percent_remainder'] = $this->request->post['theme_materialize_percent_remainder'];
		} else {
			$data['theme_materialize_percent_remainder'] = $this->config->get('theme_materialize_percent_remainder');
		}

		/* Payment methods */

		if (isset($this->request->post['theme_materialize_payment_image'])) {
			$data['theme_materialize_payment_image'] = $this->request->post['theme_materialize_payment_image'];
		} else {
			$data['theme_materialize_payment_image'] = $this->config->get('theme_materialize_payment_image');
		}

		if (isset($this->request->post['theme_materialize_payment_thumb']) && is_file(DIR_IMAGE . $this->request->post['theme_materialize_payment_thumb'])) {
			$data['theme_materialize_payment_thumb'] = $this->model_tool_image->resize($this->request->post['theme_materialize_payment_image'], 100, 100);
		} elseif (!empty($this->config->get('theme_materialize_payment_image'))) {
			$data['theme_materialize_payment_thumb'] = $this->model_tool_image->resize($this->config->get('theme_materialize_payment_image'), 100, 100);
		} else {
			$data['theme_materialize_payment_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['theme_materialize_payment_image_width'])) {
			$data['theme_materialize_payment_image_width'] = $this->request->post['theme_materialize_payment_image_width'];
		} else {
			$data['theme_materialize_payment_image_width'] = $this->config->get('theme_materialize_payment_image_width');
		}

		if (isset($this->request->post['theme_materialize_payment_image_height'])) {
			$data['theme_materialize_payment_image_height'] = $this->request->post['theme_materialize_payment_image_height'];
		} else {
			$data['theme_materialize_payment_image_height'] = $this->config->get('theme_materialize_payment_image_height');
		}

		/* Common */

		if (isset($this->request->post['theme_materialize_cache_css'])) {
			$data['theme_materialize_cache_css'] = $this->request->post['theme_materialize_cache_css'];
		} else {
			$data['theme_materialize_cache_css'] = $this->config->get('theme_materialize_cache_css');
		}

		$data['clear_css'] = $this->url->link('extension/theme/materialize/clearCss', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/theme/materialize', $data));
	}

	public function clearCss() {
		$this->cache->delete('compressed.css');

		$this->session->data['success'] = 'Кэш Css Очищен!';

		$this->response->redirect($this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'], true));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['theme_materialize_status'] == 1) {
			if (!$this->request->post['theme_materialize_product_limit']) {
				$this->error['product_limit'] = $this->language->get('error_limit');
			}

			if (!$this->request->post['theme_materialize_product_description_length']) {
				$this->error['product_description_length'] = $this->language->get('error_limit');
			}

			if (!$this->request->post['theme_materialize_image_category_width'] || !$this->request->post['theme_materialize_image_category_height']) {
				$this->error['image_category'] = $this->language->get('error_image_category');
			}

			if (!$this->request->post['theme_materialize_image_thumb_width'] || !$this->request->post['theme_materialize_image_thumb_height']) {
				$this->error['image_thumb'] = $this->language->get('error_image_thumb');
			}

			if (!$this->request->post['theme_materialize_image_popup_width'] || !$this->request->post['theme_materialize_image_popup_height']) {
				$this->error['image_popup'] = $this->language->get('error_image_popup');
			}

			if (!$this->request->post['theme_materialize_image_product_width'] || !$this->request->post['theme_materialize_image_product_height']) {
				$this->error['image_product'] = $this->language->get('error_image_product');
			}

			if (!$this->request->post['theme_materialize_image_additional_width'] || !$this->request->post['theme_materialize_image_additional_height']) {
				$this->error['image_additional'] = $this->language->get('error_image_additional');
			}

			if (!$this->request->post['theme_materialize_image_related_width'] || !$this->request->post['theme_materialize_image_related_height']) {
				$this->error['image_related'] = $this->language->get('error_image_related');
			}

			if (!$this->request->post['theme_materialize_image_compare_width'] || !$this->request->post['theme_materialize_image_compare_height']) {
				$this->error['image_compare'] = $this->language->get('error_image_compare');
			}

			if (!$this->request->post['theme_materialize_image_wishlist_width'] || !$this->request->post['theme_materialize_image_wishlist_height']) {
				$this->error['image_wishlist'] = $this->language->get('error_image_wishlist');
			}

			if (!$this->request->post['theme_materialize_image_cart_width'] || !$this->request->post['theme_materialize_image_cart_height']) {
				$this->error['image_cart'] = $this->language->get('error_image_cart');
			}

			if (!$this->request->post['theme_materialize_image_location_width'] || !$this->request->post['theme_materialize_image_location_height']) {
				$this->error['image_location'] = $this->language->get('error_image_location');
			}

			if (($this->request->post['theme_materialize_remainder'] == 'progressbar') && ((utf8_strlen($this->request->post['theme_materialize_percent_remainder']) < 1) || ($this->request->post['theme_materialize_percent_remainder'] < 1))) {
				$this->error['percent_remainder'] = $this->language->get('error_percent_remainder');
			}
		}

		return !$this->error;
	}
}