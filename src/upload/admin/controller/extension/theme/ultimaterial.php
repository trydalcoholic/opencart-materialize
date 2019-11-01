<?php

class ControllerExtensionThemeUltimaterial extends Controller {
	private $error = [];
	private static $default_settings = [
		'theme_ultimaterial_directory'                  => 'ultimaterial',
		'theme_ultimaterial_product_limit'              => 15,
		'theme_ultimaterial_status'                     => '',
		'theme_ultimaterial_product_description_length' => 100,
		'theme_ultimaterial_image_category_width'       => 80,
		'theme_ultimaterial_image_category_height'      => 80,
		'theme_ultimaterial_image_thumb_width'          => 228,
		'theme_ultimaterial_image_thumb_height'         => 228,
		'theme_ultimaterial_image_popup_width'          => 500,
		'theme_ultimaterial_image_popup_height'         => 500,
		'theme_ultimaterial_image_product_width'        => 228,
		'theme_ultimaterial_image_product_height'       => 228,
		'theme_ultimaterial_image_additional_width'     => 74,
		'theme_ultimaterial_image_additional_height'    => 74,
		'theme_ultimaterial_image_related_width'        => 80,
		'theme_ultimaterial_image_related_height'       => 80,
		'theme_ultimaterial_image_compare_width'        => 90,
		'theme_ultimaterial_image_compare_height'       => 90,
		'theme_ultimaterial_image_wishlist_width'       => 47,
		'theme_ultimaterial_image_wishlist_height'      => 47,
		'theme_ultimaterial_image_cart_width'           => 47,
		'theme_ultimaterial_image_cart_height'          => 47,
		'theme_ultimaterial_image_location_width'       => 268,
		'theme_ultimaterial_image_location_height'      => 50
	];

	public function index() {
		$this->load->language('extension/theme/ultimaterial');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addStyle('view/stylesheet/ultimaterial/template/common.min.css');

		$this->load->model('setting/setting');

		$required = [
			'theme_ultimaterial_product_limit'              => [
				'error' => 'product_limit',
				'text'  => $this->language->get('error_limit')
			],
			'theme_ultimaterial_product_description_length' => [
				'error' => 'product_description_length',
				'text'  => $this->language->get('error_limit')
			],
			'theme_ultimaterial_image_category_width'       => [
				'error' => 'image_category',
				'text'  => $this->language->get('error_image_category')
			],
			'theme_ultimaterial_image_category_height'      => [
				'error' => 'image_category',
				'text'  => $this->language->get('error_image_category')
			],
			'theme_ultimaterial_image_thumb_width'          => [
				'error' => 'image_thumb',
				'text'  => $this->language->get('error_image_thumb')
			],
			'theme_ultimaterial_image_thumb_height'         => [
				'error' => 'image_thumb',
				'text'  => $this->language->get('error_image_thumb')
			],
			'theme_ultimaterial_image_popup_width'          => [
				'error' => 'image_popup',
				'text'  => $this->language->get('error_image_popup')
			],
			'theme_ultimaterial_image_popup_height'         => [
				'error' => 'image_popup',
				'text'  => $this->language->get('error_image_popup')
			],
			'theme_ultimaterial_image_product_width'        => [
				'error' => 'image_product',
				'text'  => $this->language->get('error_image_product')
			],
			'theme_ultimaterial_image_product_height'       => [
				'error' => 'image_product',
				'text'  => $this->language->get('error_image_product')
			],
			'theme_ultimaterial_image_additional_width'     => [
				'error' => 'image_additional',
				'text'  => $this->language->get('error_image_additional')
			],
			'theme_ultimaterial_image_additional_height'    => [
				'error' => 'image_additional',
				'text'  => $this->language->get('error_image_additional')
			],
			'theme_ultimaterial_image_related_width'        => [
				'error' => 'image_related',
				'text'  => $this->language->get('error_image_related')
			],
			'theme_ultimaterial_image_related_height'       => [
				'error' => 'image_related',
				'text'  => $this->language->get('error_image_related')
			],
			'theme_ultimaterial_image_compare_width'        => [
				'error' => 'image_compare',
				'text'  => $this->language->get('error_image_compare')
			],
			'theme_ultimaterial_image_compare_height'       => [
				'error' => 'image_compare',
				'text'  => $this->language->get('error_image_compare')
			],
			'theme_ultimaterial_image_wishlist_width'       => [
				'error' => 'image_wishlist',
				'text'  => $this->language->get('error_image_wishlist')
			],
			'theme_ultimaterial_image_wishlist_height'      => [
				'error' => 'image_wishlist',
				'text'  => $this->language->get('error_image_wishlist')
			],
			'theme_ultimaterial_image_cart_width'           => [
				'error' => 'image_cart',
				'text'  => $this->language->get('error_image_cart')
			],
			'theme_ultimaterial_image_cart_height'          => [
				'error' => 'image_cart',
				'text'  => $this->language->get('error_image_cart')
			],
			'theme_ultimaterial_image_location_width'       => [
				'error' => 'image_location',
				'text'  => $this->language->get('error_image_location')
			],
			'theme_ultimaterial_image_location_height'      => [
				'error' => 'image_location',
				'text'  => $this->language->get('error_image_location')
			]
		];

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate($required)) {
			$this->model_setting_setting->editSetting('theme_ultimaterial', $this->request->post, $this->request->get['store_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme'));
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			foreach ($this->request->post as $key => $value){
				if (!empty($this->request->post[$key])) {
					$data[$key] = $this->request->post[$key];
				} else {
					$data[$key] = false;
				}
			}
		} elseif (isset($this->request->get['store_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$data = $this->model_setting_setting->getSetting('theme_ultimaterial', $this->request->get['store_id']);

			if (empty($data)) {
				$data = self::$default_settings;
			}
		} else {
			$data = self::$default_settings;
		}

		if (!empty($this->error)) {
			$data['error'] = $this->error;
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/theme/ultimaterial', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'])
		];

		$data['action'] = $this->url->link('extension/theme/ultimaterial', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme');

		$data['directories'] = [];

		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);

		foreach ($directories as $directory) {
			$data['directories'][] = basename($directory);
		}

		$data['color_scheme'] = $this->url->link('extension/theme/ultimaterial/color_scheme', 'user_token=' . $this->session->data['user_token']);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/theme/ultimaterial', $data));
	}

	protected function validate($required) {
		if (!$this->user->hasPermission('modify', 'extension/theme/ultimaterial')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($required as $key => $value) {
			if (empty($this->request->post[$key])) {
				$this->error[$value['error']] = $value['text'];
			}
		}

		return !$this->error;
	}
}
