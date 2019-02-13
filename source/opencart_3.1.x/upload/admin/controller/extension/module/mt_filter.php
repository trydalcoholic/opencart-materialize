<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ControllerExtensionModuleMTFilter extends Controller {
	private $error = [];

	public function install() {
		$this->installEvents();
	}

	public function uninstall() {
		$this->uninstallEvents();
	}

	public function index() {
		$this->load->language('extension/module/mt_filter');

		$this->document->setTitle($this->language->get('module_title'));
		$this->document->addScript('view/javascript/mt_materialize/js/materialize.js');
		$this->document->addScript('view/javascript/mt_materialize/js/materializecolorpicker.js');
		$this->document->addStyle('view/javascript/mt_materialize/css/materialize.css');
		$this->document->addStyle('view/javascript/mt_materialize/css/materializecolorpicker.css');

		$this->load->model('catalog/attribute');
		$this->load->model('extension/mt_materialize/theme/mt_materialize');
		$this->load->model('setting/setting');
		$this->load->model('localisation/language');
		$this->load->model('localisation/stock_status');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$filter_settings = $this->config->get('module_mt_filter_settings');
			$filtering_settings = $this->config->get('module_mt_filtering_settings');
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_mt_filter', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->get['apply'])) {
				$this->response->redirect($this->url->link('extension/module/mt_filter', 'user_token=' . $this->session->data['user_token']));
			} else {
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module'));
			}
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = false;
		}

		if (isset($this->error['module_name']['description']['name'])) {
			$data['error_module_name'] = $this->error['module_name']['description']['name'];
		} else {
			$data['error_module_name'] = false;
		}

		if (isset($this->error['price']['description']['name'])) {
			$data['error_price_name'] = $this->error['price']['description']['name'];
		} else {
			$data['error_price_name'] = false;
		}

		if (isset($this->error['keyword']['description']['name'])) {
			$data['error_keyword_name'] = $this->error['keyword']['description']['name'];
		} else {
			$data['error_keyword_name'] = false;
		}

		if (isset($this->error['sub_categories']['description']['name'])) {
			$data['error_sub_categories_name'] = $this->error['sub_categories']['description']['name'];
		} else {
			$data['error_sub_categories_name'] = false;
		}

		if (isset($this->error['manufacturers']['description']['name'])) {
			$data['error_manufacturers_name'] = $this->error['manufacturers']['description']['name'];
		} else {
			$data['error_manufacturers_name'] = false;
		}

		if (isset($this->error['rating']['description']['name'])) {
			$data['error_rating_name'] = $this->error['rating']['description']['name'];
		} else {
			$data['error_rating_name'] = false;
		}

		if (isset($this->error['stock_statuses']['description']['name'])) {
			$data['error_stock_statuses_name'] = $this->error['stock_statuses']['description']['name'];
		} else {
			$data['error_stock_statuses_name'] = false;
		}

		if (isset($this->error['discount']['description']['name'])) {
			$data['error_discount_name'] = $this->error['discount']['description']['name'];
		} else {
			$data['error_discount_name'] = false;
		}

		if (isset($this->error['reviews']['description']['name'])) {
			$data['error_reviews_name'] = $this->error['reviews']['description']['name'];
		} else {
			$data['error_reviews_name'] = false;
		}

		if (isset($this->error['dimensions']['description']['name'])) {
			$data['error_dimensions_name'] = $this->error['dimensions']['description']['name'];
		} else {
			$data['error_dimensions_name'] = false;
		}

		if (isset($this->error['weight']['description']['name'])) {
			$data['error_weight_name'] = $this->error['weight']['description']['name'];
		} else {
			$data['error_weight_name'] = false;
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		];

		$data['breadcrumbs'][] = [
			'text'	=> $this->language->get('module_title'),
			'href'	=> $this->url->link('extension/module/mt_filter', 'user_token=' . $this->session->data['user_token'])
		];

		$data['action'] = $this->url->link('extension/module/mt_filter', 'user_token=' . $this->session->data['user_token']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		$data['apply'] = str_replace('&amp;', '&', $this->url->link('extension/module/mt_filter', 'user_token=' . $this->session->data['user_token'] . '&apply'));

		$data['user_token'] = $this->session->data['user_token'];

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['material_colors'] = $this->model_extension_mt_materialize_theme_mt_materialize->getMaterialColors();

		$data['filter_types'] = [];

		$data['filter_types'][] = [
			'type'	=> 'checkbox',
			'name'	=> 'Checkboxes' /* todo-materialize Must be placed in a language variable */
		];

		$data['filter_types'][] = [
			'type'	=> 'radio',
			'name'	=> 'Radio Buttons' /* todo-materialize Must be placed in a language variable */
		];

		$data['filter_types'][] = [
			'type'	=> 'select_single',
			'name'	=> 'Single Select' /* todo-materialize Must be placed in a language variable */
		];

		$data['filter_types'][] = [
			'type'	=> 'select_multiple',
			'name'	=> 'Multiple Select' /* todo-materialize Must be placed in a language variable */
		];

		$data['filter_types'][] = [
			'type'	=> 'switches',
			'name'	=> 'Switches' /* todo-materialize Must be placed in a language variable */
		];

		$data['filter_types'][] = [
			'type'	=> 'slider',
			'name'	=> 'Slider' /* todo-materialize Must be placed in a language variable */
		];

		$data['attribute_groups'] = [];

		$results = $this->model_catalog_attribute->getAttributes();

		foreach ($results as $result) {
			$data['attributes'][] = [
				'attribute_id'			=> $result['attribute_id'],
				'name'					=> $result['name'],
				'attribute_group'		=> $result['attribute_group']
			];
		}

		$data['stock_statuses'] = [];

		$results = $this->model_localisation_stock_status->getStockStatuses();

		foreach ($results as $result) {
			$data['stock_statuses'][] = [
				'stock_status_id'	=> $result['stock_status_id'],
				'name'				=> $result['name'],
			];
		}

		if (isset($this->request->post['module_mt_filter_status'])) {
			$data['module_mt_filter_status'] = $this->request->post['module_mt_filter_status'];
		} else {
			$data['module_mt_filter_status'] = $this->config->get('module_mt_filter_status');
		}

		if (isset($this->request->post['module_mt_filter_attributes'])) {
			$data['module_mt_filter_attributes'] = $this->request->post['module_mt_filter_attributes'];
		} else {
			$data['module_mt_filter_attributes'] = $this->config->get('module_mt_filter_attributes');
		}

		if (isset($this->request->post['module_mt_filtering_settings'])) {
			$data['module_mt_filtering_settings'] = $this->request->post['module_mt_filtering_settings'];
		} elseif (!empty($filtering_settings)) {
			$data['module_mt_filtering_settings'] = $this->config->get('module_mt_filtering_settings');
		} else {
			$data['module_mt_filtering_settings'] = [];

			$data['module_mt_filtering_settings']['filters'] = [
				'keyword'	=> [
					'product_name',
					'product_description',
					'product_tags',
					'field_model',
					'field_sku'
				]
			];
		}

		if (isset($this->request->post['module_mt_filter_settings'])) {
			$data['module_mt_filter_settings'] = $this->request->post['module_mt_filter_settings'];
		} elseif (!empty($filter_settings)) {
			$data['module_mt_filter_settings'] = $filter_settings;
		} else {
			$data['module_mt_filter_settings'] = [];

			$data['module_mt_filter_settings']['color'] = [
				'common'		=> [
					'background'	=> [
						'name'	=> 'white',
						'hex'	=> '#ffffff'
					],
					'text'			=> [
						'name'	=> 'black-text',
						'hex'	=> '#000000'
					],
					'border'	=> [
						'name'	=> 'grey lighten-2',
						'hex'	=> '#e0e0e0'
					]
				],
				'header'		=> [
					'background'	=> [
						'name'	=> 'white',
						'hex'	=> '#ffffff'
					],
					'text'			=> [
						'name'	=> 'black-text',
						'hex'	=> '#000000'
					]
				],
				'slider'		=> [
					'secondary_background'	=> [
						'name'	=> 'deep-purple lighten-3',
						'hex'	=> '#b39ddb'
					],
					'primary_background'	=> [
						'name'	=> 'deep-purple',
						'hex'	=> '#673ab7'
					],
					'text'					=> [
						'name'	=> 'white-text',
						'hex'	=> '#ffffff'
					]
				],
				'apply_button'	=> [
					'background'	=> [
						'name'	=> 'deep-purple',
						'hex'	=> '#673ab7'
					],
					'text'			=> [
						'name'	=> 'white-text',
						'hex'	=> '#ffffff'
					]
				]
			];

			$data['module_mt_filter_settings']['filters'] = [
				'price'				=> [
					'collapsible'	=> true,
					'sort'			=> 0
				],
				'keyword'			=> [
					'collapsible'	=> true,
					'settings'		=> [
						'product_name',
						'product_description',
						'product_tags',
						'field_model',
						'field_sku'
					],
					'sort'			=> 1
				],
				'sub_categories'	=> [
					'collapsible'	=> true,
					'sort'			=> 2,
					'type'			=> 'checkbox',
					'image'			=> true
				],
				'default_filters'	=> [
					'collapsible'	=> true,
					/*'change_logic'	=> true,*/
					'sort'			=> 3,
					'type'			=> 'checkbox'
				],
				'manufacturers'		=> [
					'collapsible'	=> true,
					'sort'			=> 4,
					'type'			=> 'checkbox',
					'image'			=> true
				],
				'attributes'		=> [
					'collapsible'	=> true,
					'sort'			=> 5,
					'type'			=> 'checkbox',
					'explanation'	=> true
				],
				'options'			=> [
					'collapsible'	=> true,
					'sort'			=> 6,
					'type'			=> 'checkbox',
					'image'			=> true
				],
				'rating'			=> [
					'collapsible'	=> true,
					'sort'			=> 7,
					'type'			=> 'checkbox'
				],
				'stock_statuses'	=> [
					'collapsible'	=> true,
					'sort'			=> 7,
					'type'			=> 'checkbox',
					'default'		=> 7
				],
				'discount'			=> [
					'collapsible'	=> true,
					'sort'			=> 9,
					'type'			=> 'checkbox'
				],
				'reviews'			=> [
					'collapsible'	=> true,
					'sort'			=> 10,
					'type'			=> 'checkbox'
				],
				'dimensions'		=> [
					'collapsible'	=> true,
					'sort'			=> 11,
					'type'			=> 'slider'
				],
				'weight'			=> [
					'collapsible'	=> true,
					'sort'			=> 12,
					'type'			=> 'slider'
				]
			];
		}

		$data['search_selection'] = [];

		$data['search_selection'][] = [
			'text'		=> 'Product Name', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'product_name',
			'selected'	=> in_array('product_name', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Product Description', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'product_description',
			'selected'	=> in_array('product_description', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Product Meta Title', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'product_meta_title',
			'selected'	=> in_array('product_meta_title', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Product Meta Description', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'product_meta_description',
			'selected'	=> in_array('product_meta_description', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Product Meta Keywords', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'product_meta_keywords',
			'selected'	=> in_array('product_meta_keywords', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Product Tags', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'product_tags',
			'selected'	=> in_array('product_tags', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Field Model', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'field_model',
			'selected'	=> in_array('field_model', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Field SKU', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'field_sku',
			'selected'	=> in_array('field_sku', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Field UPC', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'field_upc',
			'selected'	=> in_array('field_upc', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Field EAN', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'field_ean',
			'selected'	=> in_array('field_ean', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Field JAN', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'field_jan',
			'selected'	=> in_array('field_jan', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Field ISBN', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'field_isbn',
			'selected'	=> in_array('field_isbn', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Field MPN', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'field_mpn',
			'selected'	=> in_array('field_mpn', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Field Dimensions', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'field_dimensions',
			'selected'	=> in_array('field_dimensions', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Field Weight', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'field_weight',
			'selected'	=> in_array('field_weight', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['search_selection'][] = [
			'text'		=> 'Manufacturers', /* todo-materialize Must be placed in a language variable */
			'value'		=> 'manufacturers',
			'selected'	=> in_array('manufacturers', $data['module_mt_filtering_settings']['filters']['keyword']) ? 'selected' : false
		];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['mt_footer'] = $this->load->controller('extension/mt_materialize/appeal/appeal/footer');

		$this->response->setOutput($this->load->view('extension/module/mt_filter', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/mt_filter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['module_mt_filter_status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['description'], 'module_name');
		}

		if (isset($this->request->post['module_mt_filter_settings']['filters']['price']['status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['filters']['price']['description'], 'price');
		}

		if (isset($this->request->post['module_mt_filter_settings']['filters']['keyword']['status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['filters']['keyword']['description'], 'keyword');
		}

		if (isset($this->request->post['module_mt_filter_settings']['filters']['sub_categories']['status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['filters']['sub_categories']['description'], 'sub_categories');
		}

		if (isset($this->request->post['module_mt_filter_settings']['filters']['manufacturers']['status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['filters']['manufacturers']['description'], 'manufacturers');
		}

		if (isset($this->request->post['module_mt_filter_settings']['filters']['rating']['status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['filters']['rating']['description'], 'rating');
		}

		if (isset($this->request->post['module_mt_filter_settings']['filters']['stock_statuses']['status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['filters']['stock_statuses']['description'], 'stock_statuses');
		}

		if (isset($this->request->post['module_mt_filter_settings']['filters']['discount']['status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['filters']['discount']['description'], 'discount');
		}

		if (isset($this->request->post['module_mt_filter_settings']['filters']['reviews']['status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['filters']['reviews']['description'], 'reviews');
		}

		if (isset($this->request->post['module_mt_filter_settings']['filters']['dimensions']['status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['filters']['dimensions']['description'], 'dimensions');
		}

		if (isset($this->request->post['module_mt_filter_settings']['filters']['weight']['status'])) {
			$this->checkErrorsName($this->request->post['module_mt_filter_settings']['filters']['weight']['description'], 'weight');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function checkErrorsName($data, $error_name) {
		foreach ($data as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 64)) {
				return $this->error[$error_name]['description']['name'][$language_id] = ($error_name === 'module_name') ? $this->language->get('error_module_name') : $this->language->get('error_filter_name');
			}
		}
	}

	protected function installEvents() {
		$this->load->model('setting/event');

		$this->model_setting_event->addEvent('module_mt_filter_category_settings', 'catalog/view/product/category/before', 'extension/module/mt_filter/categoryProductPreSelected');
	}

	protected function uninstallEvents() {
		$this->load->model('setting/event');

		$this->model_setting_event->deleteEventByCode('module_mt_filter_category_settings');
	}
}