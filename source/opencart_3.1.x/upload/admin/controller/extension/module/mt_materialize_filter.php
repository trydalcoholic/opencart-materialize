<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ControllerExtensionModuleMTMaterializeFilter extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/mt_materialize_filter');

		$this->document->setTitle($this->language->get('module_title'));
		$this->document->addScript('view/javascript/mt_materialize/js/materialize.js');
		$this->document->addScript('view/javascript/mt_materialize/js/materializecolorpicker.js');
		$this->document->addStyle('view/javascript/mt_materialize/css/materialize.css');
		$this->document->addStyle('view/javascript/mt_materialize/css/materializecolorpicker.css');

		$this->load->model('extension/mt_materialize/theme/mt_materialize');
		$this->load->model('setting/setting');
		$this->load->model('localisation/language');
		$this->load->model('localisation/stock_status');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$filter_settings = $this->config->get('module_mt_materialize_filter_settings');
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_mt_materialize_filter', $this->request->post);

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
			'href'	=> $this->url->link('extension/module/mt_materialize_filter', 'user_token=' . $this->session->data['user_token'])
		);

		$data['action'] = $this->url->link('extension/module/mt_materialize_filter', 'user_token=' . $this->session->data['user_token']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['material_colors'] = $this->model_extension_mt_materialize_theme_mt_materialize->getMaterialColors();

		$data['filter_types'] = array();

		$data['filter_types'][] = array(
			'type'	=> 'checkbox',
			'name'	=> 'Checkboxes' /* todo-materialize Must be placed in a language variable */
		);

		$data['filter_types'][] = array(
			'type'	=> 'radio',
			'name'	=> 'Radio Buttons' /* todo-materialize Must be placed in a language variable */
		);

		$data['filter_types'][] = array(
			'type'	=> 'select_single',
			'name'	=> 'Single Select' /* todo-materialize Must be placed in a language variable */
		);

		$data['filter_types'][] = array(
			'type'	=> 'select_multiple',
			'name'	=> 'Multiple Select' /* todo-materialize Must be placed in a language variable */
		);

		$data['filter_types'][] = array(
			'type'	=> 'switches',
			'name'	=> 'Switches' /* todo-materialize Must be placed in a language variable */
		);

		$data['filter_types'][] = array(
			'type'	=> 'slider',
			'name'	=> 'Slider' /* todo-materialize Must be placed in a language variable */
		);

		$data['stock_statuses'] = array();

		$results = $this->model_localisation_stock_status->getStockStatuses();

		foreach ($results as $result) {
			$data['stock_statuses'][] = array(
				'stock_status_id'	=> $result['stock_status_id'],
				'name'				=> $result['name'],
			);
		}

		if (isset($this->request->post['module_mt_materialize_filter_status'])) {
			$data['module_mt_materialize_filter_status'] = $this->request->post['module_mt_materialize_filter_status'];
		} else {
			$data['module_mt_materialize_filter_status'] = $this->config->get('module_mt_materialize_filter_status');
		}

		if (isset($this->request->post['module_mt_materialize_filter_settings'])) {
			$data['module_mt_materialize_filter_settings'] = $this->request->post['module_mt_materialize_filter_settings'];
		} elseif (!empty($filter_settings)) {
			$data['module_mt_materialize_filter_settings'] = $filter_settings;
		} else {
			$data['module_mt_materialize_filter_settings'] = array();

			$data['module_mt_materialize_filter_settings']['color'] = array(
				'common'		=> array(
					'background'	=> array(
						'name'	=> 'white',
						'hex'	=> '#ffffff'
					),
					'text'			=> array(
						'name'	=> 'black-text',
						'hex'	=> '#000000'
					),
				),
				'header'		=> array(
					'background'	=> array(
						'name'	=> 'white',
						'hex'	=> '#ffffff'
					),
					'text'			=> array(
						'name'	=> 'black-text',
						'hex'	=> '#000000'
					),
				),
				'slider'		=> array(
					'secondary_background'	=> array(
						'name'	=> 'deep-purple lighten-3',
						'hex'	=> '#b39ddb'
					),
					'primary_background'	=> array(
						'name'	=> 'deep-purple',
						'hex'	=> '#673ab7'
					),
					'text'					=> array(
						'name'	=> 'white-text',
						'hex'	=> '#ffffff'
					)
				),
				'apply_button'	=> array(
					'background'	=> array(
						'name'	=> 'deep-purple',
						'hex'	=> '#673ab7'
					),
					'text'			=> array(
						'name'	=> 'white-text',
						'hex'	=> '#ffffff'
					)
				),
			);

			$data['module_mt_materialize_filter_settings']['filters'] = array(
				'price'				=> array(
					'collapsible'	=> true,
					'sort'			=> 0
				),
				'keyword'			=> array(
					'collapsible'	=> true,
					'sort'			=> 1
				),
				'sub_categories'	=> array(
					'collapsible'	=> true,
					'sort'			=> 2,
					'type'			=> 'checkbox',
					'image'			=> true
				),
				'default_filters'	=> array(
					'collapsible'	=> true,
					'sort'			=> 3,
					'type'			=> 'checkbox'
				),
				'manufacturers'		=> array(
					'collapsible'	=> true,
					'sort'			=> 4,
					'type'			=> 'checkbox',
					'image'			=> true
				),
				'attributes'		=> array(
					'collapsible'	=> true,
					'sort'			=> 5,
					'type'			=> 'checkbox',
					'explanation'	=> true
				),
				'options'			=> array(
					'collapsible'	=> true,
					'sort'			=> 6,
					'type'			=> 'checkbox',
					'image'			=> true
				),
				'rating'			=> array(
					'collapsible'	=> true,
					'sort'			=> 7,
					'type'			=> 'checkbox'
				),
				'stock_statuses'	=> array(
					'collapsible'	=> true,
					'sort'			=> 7,
					'type'			=> 'checkbox',
					'default'		=> 7
				),
				'discount'			=> array(
					'collapsible'	=> true,
					'sort'			=> 9,
					'type'			=> 'checkbox'
				),
				'reviews'			=> array(
					'collapsible'	=> true,
					'sort'			=> 10,
					'type'			=> 'checkbox'
				),
				'dimensions'		=> array(
					'collapsible'	=> true,
					'sort'			=> 11,
					'type'			=> 'slider'
				),
				'weight'			=> array(
					'collapsible'	=> true,
					'sort'			=> 12,
					'type'			=> 'slider'
				)
			);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['color_picker'] = $this->load->controller('extension/materialize/common/color_picker');

		$this->response->setOutput($this->load->view('extension/module/mt_materialize_filter', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/mt_materialize_filter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}