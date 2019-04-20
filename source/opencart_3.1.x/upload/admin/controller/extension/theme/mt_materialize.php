<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ControllerExtensionThemeMTMaterialize extends Controller {
	private $error = [];

	public function install() {
		$this->load->model('extension/mt_materialize/theme/mt_materialize');

		$this->model_extension_mt_materialize_theme_mt_materialize->install();

		$this->installEvents();
	}

	public function uninstall() {
		$this->load->model('extension/mt_materialize/theme/mt_materialize');

		$this->model_extension_mt_materialize_theme_mt_materialize->uninstall();

		$this->uninstallEvents();
	}

	public function index() {
		$this->load->language('extension/theme/mt_materialize');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('view/javascript/mt_materialize/js/materialize.js');
		$this->document->addScript('view/javascript/mt_materialize/js/mt_settings.js');
		$this->document->addScript('view/javascript/mt_materialize/js/common.js');

		$this->document->addStyle('view/stylesheet/mt_materialize/sass/materialize.css');
		$this->document->addStyle('//fonts.googleapis.com/css?family=Roboto');
		$this->document->addStyle('//fonts.googleapis.com/icon?family=Material+Icons');

		$this->load->model('setting/setting');
		$this->load->model('tool/image');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->sassVariables();

			$this->model_setting_setting->editSetting('theme_mt_materialize', $this->request->post, $this->request->get['store_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme'));
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

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text'	=> $this->language->get('text_extension'),
			'href'	=> $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme')
		];

		$data['breadcrumbs'][] = [
			'text'	=> $this->language->get('heading_title'),
			'href'	=> $this->url->link('extension/theme/mt_materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'])
		];

		$data['user_token'] = $this->session->data['user_token'];

		$data['action'] = $this->url->link('extension/theme/mt_materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme');

		$data['mt_placeholder'] = $this->model_tool_image->resize('mt_template/i_want_to_eat.png', 344, 194);

		if (isset($this->request->get['store_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$setting_info = $this->model_setting_setting->getSetting('theme_mt_materialize', $this->request->get['store_id']);
		}

		if (isset($this->request->post['theme_mt_materialize_product_limit'])) {
			$data['theme_mt_materialize_product_limit'] = $this->request->post['theme_mt_materialize_product_limit'];
		} elseif (isset($setting_info['theme_mt_materialize_product_limit'])) {
			$data['theme_mt_materialize_product_limit'] = $setting_info['theme_mt_materialize_product_limit'];
		} else {
			$data['theme_mt_materialize_product_limit'] = 15;
		}

		if (isset($this->request->post['theme_mt_materialize_status'])) {
			$data['theme_mt_materialize_status'] = $this->request->post['theme_mt_materialize_status'];
		} elseif (isset($setting_info['theme_mt_materialize_status'])) {
			$data['theme_mt_materialize_status'] = $setting_info['theme_mt_materialize_status'];
		} else {
			$data['theme_mt_materialize_status'] = '';
		}

		if (isset($this->request->post['theme_mt_materialize_product_description_length'])) {
			$data['theme_mt_materialize_product_description_length'] = $this->request->post['theme_mt_materialize_product_description_length'];
		} elseif (isset($setting_info['theme_mt_materialize_product_description_length'])) {
			$data['theme_mt_materialize_product_description_length'] = $setting_info['theme_mt_materialize_product_description_length'];
		} else {
			$data['theme_mt_materialize_product_description_length'] = 100;
		}

		if (isset($this->request->post['theme_mt_materialize_image_category_width'])) {
			$data['theme_mt_materialize_image_category_width'] = $this->request->post['theme_mt_materialize_image_category_width'];
		} elseif (isset($setting_info['theme_mt_materialize_image_category_width'])) {
			$data['theme_mt_materialize_image_category_width'] = $setting_info['theme_mt_materialize_image_category_width'];
		} else {
			$data['theme_mt_materialize_image_category_width'] = 80;
		}

		if (isset($this->request->post['theme_mt_materialize_image_category_height'])) {
			$data['theme_mt_materialize_image_category_height'] = $this->request->post['theme_mt_materialize_image_category_height'];
		} elseif (isset($setting_info['theme_mt_materialize_image_category_height'])) {
			$data['theme_mt_materialize_image_category_height'] = $setting_info['theme_mt_materialize_image_category_height'];
		} else {
			$data['theme_mt_materialize_image_category_height'] = 80;
		}

		if (isset($this->request->post['theme_mt_materialize_image_thumb_width'])) {
			$data['theme_mt_materialize_image_thumb_width'] = $this->request->post['theme_mt_materialize_image_thumb_width'];
		} elseif (isset($setting_info['theme_mt_materialize_image_thumb_width'])) {
			$data['theme_mt_materialize_image_thumb_width'] = $setting_info['theme_mt_materialize_image_thumb_width'];
		} else {
			$data['theme_mt_materialize_image_thumb_width'] = 344;
		}

		if (isset($this->request->post['theme_mt_materialize_image_thumb_height'])) {
			$data['theme_mt_materialize_image_thumb_height'] = $this->request->post['theme_mt_materialize_image_thumb_height'];
		} elseif (isset($setting_info['theme_mt_materialize_image_thumb_height'])) {
			$data['theme_mt_materialize_image_thumb_height'] = $setting_info['theme_mt_materialize_image_thumb_height'];
		} else {
			$data['theme_mt_materialize_image_thumb_height'] = 194;
		}

		if (isset($this->request->post['theme_mt_materialize_image_popup_width'])) {
			$data['theme_mt_materialize_image_popup_width'] = $this->request->post['theme_mt_materialize_image_popup_width'];
		} elseif (isset($setting_info['theme_mt_materialize_image_popup_width'])) {
			$data['theme_mt_materialize_image_popup_width'] = $setting_info['theme_mt_materialize_image_popup_width'];
		} else {
			$data['theme_mt_materialize_image_popup_width'] = 500;
		}

		if (isset($this->request->post['theme_mt_materialize_image_popup_height'])) {
			$data['theme_mt_materialize_image_popup_height'] = $this->request->post['theme_mt_materialize_image_popup_height'];
		} elseif (isset($setting_info['theme_mt_materialize_image_popup_height'])) {
			$data['theme_mt_materialize_image_popup_height'] = $setting_info['theme_mt_materialize_image_popup_height'];
		} else {
			$data['theme_mt_materialize_image_popup_height'] = 500;
		}

		if (isset($this->request->post['theme_mt_materialize_image_product_width'])) {
			$data['theme_mt_materialize_image_product_width'] = $this->request->post['theme_mt_materialize_image_product_width'];
		} elseif (isset($setting_info['theme_mt_materialize_image_product_width'])) {
			$data['theme_mt_materialize_image_product_width'] = $setting_info['theme_mt_materialize_image_product_width'];
		} else {
			$data['theme_mt_materialize_image_product_width'] = 344;
		}

		if (isset($this->request->post['theme_mt_materialize_image_product_height'])) {
			$data['theme_mt_materialize_image_product_height'] = $this->request->post['theme_mt_materialize_image_product_height'];
		} elseif (isset($setting_info['theme_mt_materialize_image_product_height'])) {
			$data['theme_mt_materialize_image_product_height'] = $setting_info['theme_mt_materialize_image_product_height'];
		} else {
			$data['theme_mt_materialize_image_product_height'] = 194;
		}

		if (isset($this->request->post['theme_mt_materialize_image_additional_width'])) {
			$data['theme_mt_materialize_image_additional_width'] = $this->request->post['theme_mt_materialize_image_additional_width'];
		} elseif (isset($setting_info['theme_mt_materialize_image_additional_width'])) {
			$data['theme_mt_materialize_image_additional_width'] = $setting_info['theme_mt_materialize_image_additional_width'];
		} else {
			$data['theme_mt_materialize_image_additional_width'] = 74;
		}

		if (isset($this->request->post['theme_mt_materialize_image_additional_height'])) {
			$data['theme_mt_materialize_image_additional_height'] = $this->request->post['theme_mt_materialize_image_additional_height'];
		} elseif (isset($setting_info['theme_mt_materialize_image_additional_height'])) {
			$data['theme_mt_materialize_image_additional_height'] = $setting_info['theme_mt_materialize_image_additional_height'];
		} else {
			$data['theme_mt_materialize_image_additional_height'] = 74;
		}

		if (isset($this->request->post['theme_mt_materialize_image_related_width'])) {
			$data['theme_mt_materialize_image_related_width'] = $this->request->post['theme_mt_materialize_image_related_width'];
		} elseif (isset($setting_info['theme_mt_materialize_image_related_width'])) {
			$data['theme_mt_materialize_image_related_width'] = $setting_info['theme_mt_materialize_image_related_width'];
		} else {
			$data['theme_mt_materialize_image_related_width'] = 80;
		}

		if (isset($this->request->post['theme_mt_materialize_image_related_height'])) {
			$data['theme_mt_materialize_image_related_height'] = $this->request->post['theme_mt_materialize_image_related_height'];
		} elseif (isset($setting_info['theme_mt_materialize_image_related_height'])) {
			$data['theme_mt_materialize_image_related_height'] = $setting_info['theme_mt_materialize_image_related_height'];
		} else {
			$data['theme_mt_materialize_image_related_height'] = 80;
		}

		if (isset($this->request->post['theme_mt_materialize_image_compare_width'])) {
			$data['theme_mt_materialize_image_compare_width'] = $this->request->post['theme_mt_materialize_image_compare_width'];
		} elseif (isset($setting_info['theme_mt_materialize_image_compare_width'])) {
			$data['theme_mt_materialize_image_compare_width'] = $setting_info['theme_mt_materialize_image_compare_width'];
		} else {
			$data['theme_mt_materialize_image_compare_width'] = 90;
		}

		if (isset($this->request->post['theme_mt_materialize_image_compare_height'])) {
			$data['theme_mt_materialize_image_compare_height'] = $this->request->post['theme_mt_materialize_image_compare_height'];
		} elseif (isset($setting_info['theme_mt_materialize_image_compare_height'])) {
			$data['theme_mt_materialize_image_compare_height'] = $setting_info['theme_mt_materialize_image_compare_height'];
		} else {
			$data['theme_mt_materialize_image_compare_height'] = 90;
		}

		if (isset($this->request->post['theme_mt_materialize_image_wishlist_width'])) {
			$data['theme_mt_materialize_image_wishlist_width'] = $this->request->post['theme_mt_materialize_image_wishlist_width'];
		} elseif (isset($setting_info['theme_mt_materialize_image_wishlist_width'])) {
			$data['theme_mt_materialize_image_wishlist_width'] = $setting_info['theme_mt_materialize_image_wishlist_width'];
		} else {
			$data['theme_mt_materialize_image_wishlist_width'] = 47;
		}

		if (isset($this->request->post['theme_mt_materialize_image_wishlist_height'])) {
			$data['theme_mt_materialize_image_wishlist_height'] = $this->request->post['theme_mt_materialize_image_wishlist_height'];
		} elseif (isset($setting_info['theme_mt_materialize_image_wishlist_height'])) {
			$data['theme_mt_materialize_image_wishlist_height'] = $setting_info['theme_mt_materialize_image_wishlist_height'];
		} else {
			$data['theme_mt_materialize_image_wishlist_height'] = 47;
		}

		if (isset($this->request->post['theme_mt_materialize_image_cart_width'])) {
			$data['theme_mt_materialize_image_cart_width'] = $this->request->post['theme_mt_materialize_image_cart_width'];
		} elseif (isset($setting_info['theme_mt_materialize_image_cart_width'])) {
			$data['theme_mt_materialize_image_cart_width'] = $setting_info['theme_mt_materialize_image_cart_width'];
		} else {
			$data['theme_mt_materialize_image_cart_width'] = 47;
		}

		if (isset($this->request->post['theme_mt_materialize_image_cart_height'])) {
			$data['theme_mt_materialize_image_cart_height'] = $this->request->post['theme_mt_materialize_image_cart_height'];
		} elseif (isset($setting_info['theme_mt_materialize_image_cart_height'])) {
			$data['theme_mt_materialize_image_cart_height'] = $setting_info['theme_mt_materialize_image_cart_height'];
		} else {
			$data['theme_mt_materialize_image_cart_height'] = 47;
		}

		if (isset($this->request->post['theme_mt_materialize_image_location_width'])) {
			$data['theme_mt_materialize_image_location_width'] = $this->request->post['theme_mt_materialize_image_location_width'];
		} elseif (isset($setting_info['theme_mt_materialize_image_location_width'])) {
			$data['theme_mt_materialize_image_location_width'] = $setting_info['theme_mt_materialize_image_location_width'];
		} else {
			$data['theme_mt_materialize_image_location_width'] = 268;
		}

		if (isset($this->request->post['theme_mt_materialize_image_location_height'])) {
			$data['theme_mt_materialize_image_location_height'] = $this->request->post['theme_mt_materialize_image_location_height'];
		} elseif (isset($setting_info['theme_mt_materialize_image_location_height'])) {
			$data['theme_mt_materialize_image_location_height'] = $setting_info['theme_mt_materialize_image_location_height'];
		} else {
			$data['theme_mt_materialize_image_location_height'] = 50;
		}

		if (isset($this->request->post['theme_mt_materialize_products'])) {
			$data['theme_mt_materialize_products'] = $this->request->post['theme_mt_materialize_products'];
		} elseif (isset($setting_info['theme_mt_materialize_products'])) {
			$data['theme_mt_materialize_products'] = $setting_info['theme_mt_materialize_products'];
		} else {
			$data['theme_mt_materialize_products'] = [
				'fields'	=> array('tags')
			];
		}

		$data['product_fields'][] = [
			'text'		=> 'Model', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'model',
			'selected'	=> in_array('model', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'SKU', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'sku',
			'selected'	=> in_array('sku', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'UPC', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'upc',
			'selected'	=> in_array('upc', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'EAN', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'ean',
			'selected'	=> in_array('ean', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'JAN', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'jan',
			'selected'	=> in_array('jan', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'ISBN', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'isbn',
			'selected'	=> in_array('isbn', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'MPN', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'mpn',
			'selected'	=> in_array('mpn', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'Location', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'location',
			'selected'	=> in_array('location', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'Dimension', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'dimension',
			'selected'	=> in_array('dimension', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'Weight', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'weight',
			'selected'	=> in_array('weight', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'Progressbar', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'progressbar',
			'selected'	=> in_array('progressbar', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['product_fields'][] = [
			'text'		=> 'Tags', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'tags',
			'selected'	=> in_array('tags', $data['theme_mt_materialize_products']['fields']) ? 'selected' : ''
		];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['mt_footer'] = $this->load->controller('extension/mt_materialize/appeal/appeal/footer');

		$this->response->setOutput($this->load->view('extension/theme/mt_materialize', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/theme/mt_materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['theme_mt_materialize_product_limit']) {
			$this->error['product_limit'] = $this->language->get('error_limit');
		}

		if (!$this->request->post['theme_mt_materialize_product_description_length']) {
			$this->error['product_description_length'] = $this->language->get('error_limit');
		}

		if (!$this->request->post['theme_mt_materialize_image_category_width'] || !$this->request->post['theme_mt_materialize_image_category_height']) {
			$this->error['image_category'] = $this->language->get('error_image_category');
		}

		if (!$this->request->post['theme_mt_materialize_image_thumb_width'] || !$this->request->post['theme_mt_materialize_image_thumb_height']) {
			$this->error['image_thumb'] = $this->language->get('error_image_thumb');
		}

		if (!$this->request->post['theme_mt_materialize_image_popup_width'] || !$this->request->post['theme_mt_materialize_image_popup_height']) {
			$this->error['image_popup'] = $this->language->get('error_image_popup');
		}

		if (!$this->request->post['theme_mt_materialize_image_product_width'] || !$this->request->post['theme_mt_materialize_image_product_height']) {
			$this->error['image_product'] = $this->language->get('error_image_product');
		}

		if (!$this->request->post['theme_mt_materialize_image_additional_width'] || !$this->request->post['theme_mt_materialize_image_additional_height']) {
			$this->error['image_additional'] = $this->language->get('error_image_additional');
		}

		if (!$this->request->post['theme_mt_materialize_image_related_width'] || !$this->request->post['theme_mt_materialize_image_related_height']) {
			$this->error['image_related'] = $this->language->get('error_image_related');
		}

		if (!$this->request->post['theme_mt_materialize_image_compare_width'] || !$this->request->post['theme_mt_materialize_image_compare_height']) {
			$this->error['image_compare'] = $this->language->get('error_image_compare');
		}

		if (!$this->request->post['theme_mt_materialize_image_wishlist_width'] || !$this->request->post['theme_mt_materialize_image_wishlist_height']) {
			$this->error['image_wishlist'] = $this->language->get('error_image_wishlist');
		}

		if (!$this->request->post['theme_mt_materialize_image_cart_width'] || !$this->request->post['theme_mt_materialize_image_cart_height']) {
			$this->error['image_cart'] = $this->language->get('error_image_cart');
		}

		if (!$this->request->post['theme_mt_materialize_image_location_width'] || !$this->request->post['theme_mt_materialize_image_location_height']) {
			$this->error['image_location'] = $this->language->get('error_image_location');
		}

		return !$this->error;
	}

	public function adminMaterializeMenuItem($route, &$data) {
		if (isset($this->request->get['user_token']) && isset($this->session->data['user_token']) && ((string)$this->request->get['user_token'] == $this->session->data['user_token'])) {
			$this->load->language('extension/mt_materialize/common/column_left');

			$materialize = [];

			if ($this->user->hasPermission('access', 'extension/theme/mt_materialize')) {
				$materialize[] = [
					'name'		=> $this->language->get('mt_template_settings'),
					'href'		=> $this->url->link('extension/theme/mt_materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=0'),
					'children'	=> []
				];
			}

			if ($this->user->hasPermission('access', 'extension/module/mt_blog') && $this->config->get('module_mt_blog_status')) {
				$materialize[] = [
					'name'		=> $this->language->get('mt_blog'),
					'href'		=> $this->url->link('extension/module/mt_blog', 'user_token=' . $this->session->data['user_token']),
					'children'	=> []
				];
			}

			if ($this->user->hasPermission('access', 'extension/module/mt_filter') && $this->config->get('module_mt_filter_status')) {
				$materialize[] = [
					'name'		=> $this->language->get('mt_filter'),
					'href'		=> $this->url->link('extension/module/mt_filter', 'user_token=' . $this->session->data['user_token']),
					'children'	=> []
				];
			}

			$data['menus'][] = [
				'id'		=> 'menu-materialize',
				'icon'		=> 'fas fa-cogs',
				'name'		=> $this->language->get('mt_materialize_template'),
				'href'		=> '',
				'children'	=> $materialize
			];
		}
	}

	public function sassVariables() {
		$json = [];

		$file = DIR_CATALOG . "view/theme/mt_materialize/stylesheet/materialize/components/_mt-variables.scss";

		if (file_exists($file)) {
			unlink($file);
		}

		$sass = '$card_border_radius: 8px !default;' . "\n";

		if (!file_exists($file)) {
			$fp = fopen($file, "w");
			fwrite($fp, ltrim($sass));
			fclose($fp);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function installEvents() {
		$this->load->model('setting/event');

		$this->model_setting_event->addEvent('theme_mt_materialize_menu_item', 'admin/view/common/column_left/before', 'extension/theme/mt_materialize/adminMaterializeMenuItem');

		$this->model_setting_event->addEvent('theme_mt_materialize_header_settings', 'catalog/view/common/header/before', 'extension/mt_materialize/common/header');

		$this->model_setting_event->addEvent('theme_mt_materialize_data_product_display', 'catalog/view/common/home/before', 'catalog/controller/extension/mt_materialize/product/product/dataProductDisplay');
		$this->model_setting_event->addEvent('theme_mt_materialize_data_product_display', 'catalog/view/product/category/before', 'catalog/controller/extension/mt_materialize/product/product/dataProductDisplay');
	}

	protected function uninstallEvents() {
		$this->load->model('setting/event');

		$this->model_setting_event->deleteEventByCode('theme_mt_materialize_menu_item');
		$this->model_setting_event->deleteEventByCode('theme_mt_materialize_header_settings');
		$this->model_setting_event->deleteEventByCode('theme_mt_materialize_data_product_display');
	}
}