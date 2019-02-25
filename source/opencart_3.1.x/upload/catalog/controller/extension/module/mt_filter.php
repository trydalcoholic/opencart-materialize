<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ControllerExtensionModuleMTFilter extends Controller {
	public function index() {
		/* todo-materialize Add store availability */
		/* todo-materialize Add filter based on label module */

		$this->load->model('extension/mt_materialize/module/mt_filter');
		$this->load->model('tool/image');
		$this->load->model('localisation/currency');

		$this->document->addScript('catalog/view/theme/mt_materialize/js/mt_filter/mt_filter.js');
		$this->document->addStyle('catalog/view/theme/mt_materialize/stylesheet/mt_filter/mt_filter.css');

		$mt_filter_settings = $this->mtFilterSettings();
		$data['color'] = $mt_filter_settings['color'];
		$filters = $mt_filter_settings['filters'];
		$config_product_count = $this->config->get('config_product_count');

		/*if (!empty($mt_filter_settings['layout']['horizontal'])) {
			$data['horizontal'] = $mt_filter_settings['layout']['horizontal'];
		} else {
			$data['horizontal'] = false;
		}*/

		/*if (!empty($mt_filter_settings['cache']['status'])) {
			$cache_enable = true;
		} else {
			$cache_enable = false;
		}*/

		if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
		} else {
			$route = 'common/home';
		}

		$page_settings = '&location=' . $route . '&language=' . $this->config->get('config_language');

		$product_category = false;

		if ($route == 'product/category' && isset($this->request->get['path'])) {
			$page_settings .= '&path=' . $this->request->get['path'];

			$path = explode('_', (string)$this->request->get['path']);

			$product_category = end($path);
		}

		if ($route == 'product/manufacturer/info' && isset($this->request->get['manufacturer_id'])) {
			$product_manufacturer = (int)$this->request->get['manufacturer_id'];
		} else {
			$product_manufacturer = false;
		}

		if ($route == 'product/search' && isset($this->request->get['search'])) {
			$product_search = (string)$this->request->get['search'];
		} else {
			$product_search = false;
		}

		if ($route == 'product/special') {
			$product_special = true;
		} else {
			$product_special = false;
		}

		$placeholder = $this->model_tool_image->resize('placeholder.png', 25, 25);

		$data['mt_filters'] = [];
		$data['mt_filters2'] = [];

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . (int)$this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . (int)$this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . (int)$this->request->get['limit'];
		}

		$page_settings .= $url;

		$data['page_settings'] = str_replace('&amp;', '&', $page_settings);
		$data['module_name'] = $mt_filter_settings['description'][$this->config->get('config_language_id')]['name'];

		$slider_status = false;

		if (!empty($filters['price']['status']) && ($this->customer->isLogged() || !$this->config->get('config_customer_price'))) {
			$slider_status = true;

			if (isset($this->request->get['price_filter'])) {
				$data['price_filter_preselected'] = explode('-', $this->request->get['price_filter']);
			} else {
				$data['price_filter_preselected'] = [];
			}

			$price_data = [
				'category_id'		=> (int)$product_category,
				'config_tax'		=> $this->config->get('config_tax'),
				'currency_ratio'	=> $this->currency->getValue($this->session->data['currency'])
			];

			$get_prices = $this->model_extension_mt_materialize_module_mt_filter->getMinMaxPrice($price_data);

			$currency_data = $this->model_localisation_currency->getCurrencyByCode($this->session->data['currency']);

			$data['prices'] = [
				'symbol_left'		=> $currency_data['symbol_left'],
				'symbol_right'		=> $currency_data['symbol_right'],
				'decimal_place'		=> $currency_data['decimal_place'],
				'thousand_point'	=> $this->language->get('thousand_point'),
				'min_price'			=> (float)round($get_prices['min_price'], (int)$currency_data['decimal_place']),
				'max_price'			=> (float)round($get_prices['max_price'], (int)$currency_data['decimal_place'])
			];

			$data['mt_filters'][] = [
				'name'			=> $filters['price']['description'][$this->config->get('config_language_id')]['name'],
				'type'			=> 'price',
				'sort'			=> (int)$filters['price']['sort'],
				'collapsible'	=> !empty($filters['price']['collapsible']) ? true : false,
				'value'			=> true
			];
		}

		if (!empty($filters['keyword']['status'])) {
			if (isset($this->request->get['keyword_filter'])) {
				$preselected = (string)$this->request->get['keyword_filter'];
			} else {
				$preselected = false;
			}

			$data['mt_filters'][] = [
				'name'			=> $filters['keyword']['description'][$this->config->get('config_language_id')]['name'],
				'type'			=> 'keyword',
				'sort'			=> (int)$filters['keyword']['sort'],
				'collapsible'	=> !empty($filters['keyword']['collapsible']) ? true : false,
				'preselected'	=> $preselected
			];
		}

		if (!empty($filters['sub_categories']['status'])) {
			if (isset($this->request->get['sub_category_filter'])) {
				$preselected = explode(',', $this->request->get['sub_category_filter']);
			} else {
				$preselected = [];
			}

			$sub_categories = [];

			$filter_settings = [
				'category_id'	=> (int)$product_category,
				'image'			=> !empty($filters['sub_categories']['image']) ? true : false
			];

			$results = $this->model_extension_mt_materialize_module_mt_filter->getSubCategories($filter_settings);

			if (!empty($filters['sub_categories']['image']) && ($filters['sub_categories']['type'] === 'select_single' || $filters['sub_categories']['type'] === 'select_multiple')) {
				$image_width = 40;
				$image_height = 40;
			} else {
				$image_width = 25;
				$image_height = 25;
			}

			foreach ($results as $result) {
				if (!empty($filters['sub_categories']['image']) && is_file(DIR_IMAGE . html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'))) {
					$image = $this->model_tool_image->resize(html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'), $image_width, $image_height);
				} else {
					$image = $placeholder;
				}

				if ($config_product_count) {
					$filter_data = [
						'category_id'			=> (int)$product_category,
						'sub_category_filter'	=> (array)$result['category_id'],
					];

					$product_count = $this->model_extension_mt_materialize_module_mt_filter->getTotalProducts($filter_data);
				} else {
					$product_count = false;
				}

				$sub_categories[$filters['sub_categories']['description'][$this->config->get('config_language_id')]['name']][] = [
					'mt_filter_id'				=> 'mt-filter-sub-category-' . (int)$result['category_id'],
					'input_name'				=> 'sub_category_filter[]',
					'filter_value'				=> (int)$result['category_id'],
					'preselected'				=> !empty($preselected) ? in_array((int)$result['category_id'], $preselected) : false,
					'name'						=> $result['name'],
					'product_count'				=> $product_count,
					'product_count_disabled'	=> $product_count ? false : true,
					'image'						=> !empty($filters['sub_categories']['image']) ? $image : false
				];
			}

			if (!empty($sub_categories)) {
				$data['mt_filters'][] = [
					'type'			=> 'sub_category',
					'sort'			=> (int)$filters['sub_categories']['sort'],
					'collapsible'	=> !empty($filters['sub_categories']['collapsible']) ? true : false,
					'image'			=> !empty($filters['sub_categories']['image']) ? true : false,
					'input_type'	=> $filters['sub_categories']['type'],
					'value'			=> $sub_categories
				];
			}
		}

		if (!empty($filters['default_filters']['status'])) {
			if (isset($this->request->get['default_filter'])) {
				$preselected = explode(',', $this->request->get['default_filter']);
			} else {
				$preselected = [];
			}

			$default_filters = [];

			$filter_groups = $this->model_extension_mt_materialize_module_mt_filter->getDefaultFilters($product_category);

			if ($filter_groups) {
				foreach ($filter_groups as $filter_group) {
					$children_data = [];

					foreach ($filter_group['filter'] as $filter) {
						$children_data[] = [
							'filter_id'		=> (int)$filter['filter_id'],
							'mt_filter_id'	=> 'mt-filter-default-filter-' . (int)$filter_group['filter_group_id'] . '-' . (int)$filter['filter_id'],
							'name'			=> $filter['name']
						];
					}

					$default_filters[] = [
						'filter_group_id'	=> (int)$filter_group['filter_group_id'],
						'name'				=> $filter_group['name'],
						'filter'			=> $children_data
					];
				}
			}

			if (!empty($default_filters)) {
				$data['mt_filters'][] = [
					'type'			=> 'default_filters',
					'sort'			=> (int)$filters['default_filters']['sort'],
					'collapsible'	=> !empty($filters['default_filters']['collapsible']) ? true : false,
					'input_type'	=> $filters['default_filters']['type'],
					'preselected'	=> $preselected,
					'value'			=> $default_filters
				];
			}
		}

		if (!empty($filters['manufacturers']['status'])) {
			if (isset($this->request->get['manufacturer_filter'])) {
				$preselected = explode(',', $this->request->get['manufacturer_filter']);
			} else {
				$preselected = [];
			}

			$manufacturers = [];

			$filter_settings = [
				'category_id'	=> (int)$product_category,
				'image'			=> !empty($filters['manufacturers']['image']) ? true : false
			];

			$manufacturers_data = $this->model_extension_mt_materialize_module_mt_filter->getManufacturers($filter_settings);

			if ($manufacturers_data) {
				if (!empty($filters['manufacturers']['image']) && ($filters['manufacturers']['type'] === 'select_single' || $filters['manufacturers']['type'] === 'select_multiple')) {
					$image_width = 40;
					$image_height = 40;
				} else {
					$image_width = 25;
					$image_height = 25;
				}

				foreach ($manufacturers_data as $manufacturer) {
					if (!empty($filters['manufacturers']['image']) && is_file(DIR_IMAGE . html_entity_decode($manufacturer['image'], ENT_QUOTES, 'UTF-8'))) {
						$image = $this->model_tool_image->resize(html_entity_decode($manufacturer['image'], ENT_QUOTES, 'UTF-8'), $image_width, $image_height);
					} else {
						$image = $placeholder;
					}

					if ($config_product_count) {
						$filter_data = [
							'category_id'			=> (int)$product_category,
							'manufacturer_filter'	=> (array)$manufacturer['manufacturer_id'],
						];

						$product_count = $this->model_extension_mt_materialize_module_mt_filter->getTotalProducts($filter_data);
					} else {
						$product_count = false;
					}

					$manufacturers[$filters['manufacturers']['description'][$this->config->get('config_language_id')]['name']][] = [
						'mt_filter_id'				=> 'mt-filter-manufacturer-' . (int)$manufacturer['manufacturer_id'],
						'input_name'				=> 'manufacturer_filter[]',
						'preselected'				=> !empty($preselected) ? in_array((int)$manufacturer['manufacturer_id'], $preselected) : false,
						'filter_value'				=> (int)$manufacturer['manufacturer_id'],
						'name'						=> $manufacturer['name'],
						'product_count'				=> $product_count,
						'product_count_disabled'	=> $product_count ? false : true,
						'image'						=> !empty($filters['manufacturers']['image']) ? $image : false
					];
				}

				if (!empty($manufacturers)) {
					$data['mt_filters'][] = [
						'type'			=> 'manufacturer',
						'sort'			=> (int)$filters['manufacturers']['sort'],
						'collapsible'	=> !empty($filters['manufacturers']['collapsible']) ? true : false,
						'image'			=> !empty($filters['manufacturers']['image']) ? true : false,
						'input_type'	=> $filters['manufacturers']['type'],
						'value'			=> $manufacturers
					];
				}
			}
		}

		if (!empty($filters['attributes']['status'])) {
			if (isset($this->request->get['attribute_filter'])) {
				foreach ($this->request->get['attribute_filter'] as $key => $value) {
					foreach ($value as $text) {
						$preselected[$key][] = strip_tags(html_entity_decode(trim((string)$text), ENT_QUOTES, 'UTF-8'));
					}
				}
			} else {
				$preselected = [];
			}

			$attributes = [];

			$attributes_data = $this->model_extension_mt_materialize_module_mt_filter->getAttributes($product_category);

			if (!empty($attributes_data)) {
				foreach ($attributes_data as $attribute) {
					$attribute_filter = [];
					$attribute_text = strip_tags(html_entity_decode(trim($attribute['text']), ENT_QUOTES, 'UTF-8'));

					$attribute_filter[(int)$attribute['attribute_id']] = $attribute_text;

					if ($config_product_count) {
						$filter_data = [
							'category_id'		=> (int)$product_category,
							'attribute_filter'	=> $attribute_filter,
						];

						$product_count = $this->model_extension_mt_materialize_module_mt_filter->getTotalProducts($filter_data);
					} else {
						$product_count = false;
					}
					/*
					foreach ($this->request->get['attribute_filter'] as $key => $value) {
						$implode = [];

						foreach ($value as $text) {
							$implode[] = trim((string)$text);

							$attribute_filter_url .= '&attribute_filter[' . $key . '][]=' . trim((string)$text);
						}

						$attribute_filter[$key] = implode(',', $implode);
					}
					*/

					$attributes[$attribute['name']][] = [
						'mt_filter_id'				=> 'mt-filter-attribute-' . (int)$attribute['attribute_id'] . '-' . strval($attribute_text),
						'input_name'				=> 'attribute_filter[' . (int)$attribute['attribute_id'] . '][]',
						'preselected'				=> !empty($preselected[(int)$attribute['attribute_id']]) ? in_array($attribute_text, $preselected[(int)$attribute['attribute_id']]) : false,
						'filter_value'				=> $attribute_text,
						'name'						=> $attribute_text,
						'product_count'				=> $product_count,
						'product_count_disabled'	=> isset($product_count) ? false : true,
						'filter_data'				=> $filter_data
					];
				}
			}

			if (!empty($attributes)) {
				$data['mt_filters'][] = [
					'type'			=> 'attribute',
					'sort'			=> (int)$filters['attributes']['sort'],
					'collapsible'	=> !empty($filters['attributes']['collapsible']) ? true : false,
					'input_type'	=> $filters['attributes']['type'],
					'explanation'	=> !empty($filters['attributes']['explanation']) ? true : false,
					'value'			=> $attributes
				];
			}
		}

		if (!empty($filters['options']['status'])) {
			if (isset($this->request->get['option_filter'])) {
				foreach ($this->request->get['option_filter'] as $key => $value) {
					foreach ($value as $option_value) {
						$preselected[$key][] = (int)$option_value;
					}
				}
			} else {
				$preselected = [];
			}

			$options = [];

			$filter_settings = [
				'category_id'	=> (int)$product_category,
				'image'			=> !empty($filters['options']['image']) ? true : false
			];

			$options_data = $this->model_extension_mt_materialize_module_mt_filter->getOptions($filter_settings);

			if ($options_data) {
				if (!empty($filters['options']['image']) && ($filters['options']['type'] === 'select_single' || $filters['options']['type'] === 'select_multiple')) {
					$image_width = 40;
					$image_height = 40;
				} else {
					$image_width = 25;
					$image_height = 25;
				}

				foreach ($options_data as $option_data) {
					$option_value_data = [];

					foreach ($option_data['option_value_data'] as $option_value) {
						if (!empty($filters['options']['image'])) {
							if (is_file(DIR_IMAGE . html_entity_decode($option_value['image'], ENT_QUOTES, 'UTF-8'))) {
								$image = $this->model_tool_image->resize(html_entity_decode($option_value['image'], ENT_QUOTES, 'UTF-8'), $image_width, $image_height);
							} else {
								$image = $placeholder;
							}
						}

						$option_value_data[$option_value['name']] = [
							'option_value_id'	=> (int)$option_value['option_value_id'],
							'mt_filter_id'		=> 'mt-filter-option-' . (int)$option_data['option_id'] . '-' . (int)$option_value['option_value_id'],
							'name'				=> $option_value['name'],
							'image'				=> !empty($filters['options']['image']) ? $image : false,
							'sort_order'		=> (int)$option_value['sort_order']
						];
					}

					$options[] = [
						'option_id'			=> (int)$option_data['option_id'],
						'name'				=> $option_data['name'],
						'type'				=> $option_data['type'],
						'sort_order'		=> (int)$option_data['sort_order'],
						'option_value_data'	=> $option_value_data
					];
				}
			}

			if (!empty($options)) {
				$data['mt_filters'][] = [
					'type'			=> 'options',
					'sort'			=> (int)$filters['options']['sort'],
					'collapsible'	=> !empty($filters['options']['collapsible']) ? true : false,
					'image'			=> !empty($filters['options']['image']) ? true : false,
					'input_type'	=> $filters['options']['type'],
					'preselected'	=> $preselected,
					'value'			=> $options
				];
			}
		}

		if (!empty($filters['rating']['status'])) {
			if (isset($this->request->get['rating_filter'])) {
				$preselected = explode(',', $this->request->get['rating_filter']);
			} else {
				$preselected = [];
			}

			$rating_filter = [
				'0'	=> [
					'rating_id'		=> 5,
					'mt_filter_id'	=> 'mt-filter-rating-5'
				],
				'1' => [
					'rating_id'		=> 4,
					'mt_filter_id'	=> 'mt-filter-rating-4'
				],
				'2' => [
					'rating_id'		=> 3,
					'mt_filter_id'	=> 'mt-filter-rating-3'
				],
				'3'	=> [
					'rating_id'		=> 2,
					'mt_filter_id'	=> 'mt-filter-rating-2'
				],
				'4' => [
					'rating_id'		=> 1,
					'mt_filter_id'	=> 'mt-filter-rating-1'
				]
			];

			$data['mt_filters'][] = [
				'name'			=> $filters['rating']['description'][$this->config->get('config_language_id')]['name'],
				'type'			=> 'rating',
				'sort'			=> (int)$filters['rating']['sort'],
				'collapsible'	=> !empty($filters['rating']['collapsible']) ? true : false,
				'input_type'	=> $filters['rating']['type'],
				'preselected'	=> $preselected,
				'value'			=> $rating_filter
			];
		}

		if (!empty($filters['stock_statuses']['status'])) {
			if (isset($this->request->get['stock_status_filter'])) {
				$preselected = explode(',', $this->request->get['stock_status_filter']);
			} else {
				$preselected = [];
			}

			$stock_statuses = [];

			$stock_statuses_data = $this->model_extension_mt_materialize_module_mt_filter->getStockStatuses();

			if ($stock_statuses_data) {
				foreach ($stock_statuses_data as $stock_status) {
					$stock_statuses[] = [
						'stock_status_id'	=> (int)$stock_status['stock_status_id'],
						'mt_filter_id'		=> 'mt-filter-stock-status-' . (int)$stock_status['stock_status_id'],
						'name'				=> $stock_status['name']
					];
				}

				if (!empty($stock_statuses)) {
					$data['mt_filters'][] = [
						'name'			=> $filters['stock_statuses']['description'][$this->config->get('config_language_id')]['name'],
						'type'			=> 'stock_statuses',
						'sort'			=> (int)$filters['stock_statuses']['sort'],
						'collapsible'	=> !empty($filters['stock_statuses']['collapsible']) ? true : false,
						'input_type'	=> $filters['stock_statuses']['type'],
						'preselected'	=> $preselected,
						'value'			=> $stock_statuses
					];
				}
			}
		}

		if (!empty($filters['discount']['status'])) {
			if (isset($this->request->get['product_special_filter'])) {
				$preselected = explode(',', $this->request->get['product_special_filter']);
			} else {
				$preselected = [];
			}

			$discount = [];

			$discount[] = [
				'discount_id'	=> 1,
				'mt_filter_id'	=> 'mt-filter-product-special'
			];

			$data['mt_filters'][] = [
				'name'			=> $filters['discount']['description'][$this->config->get('config_language_id')]['name'],
				'type'			=> 'discount',
				'sort'			=> (int)$filters['discount']['sort'],
				'collapsible'	=> !empty($filters['discount']['collapsible']) ? true : false,
				'input_type'	=> $filters['discount']['type'],
				'preselected'	=> $preselected,
				'value'			=> $discount
			];
		}

		if (!empty($filters['reviews']['status'])) {
			if (isset($this->request->get['review_filter'])) {
				$preselected = explode(',', $this->request->get['review_filter']);
			} else {
				$preselected = [];
			}

			$review = [];

			$review[] = [
				'review_id'		=> 1,
				'mt_filter_id'	=> 'mt-filter-review'
			];

			$data['mt_filters'][] = [
				'name'			=> $filters['reviews']['description'][$this->config->get('config_language_id')]['name'],
				'type'			=> 'reviews',
				'sort'			=> (int)$filters['reviews']['sort'],
				'collapsible'	=> !empty($filters['reviews']['collapsible']) ? true : false,
				'input_type'	=> $filters['reviews']['type'],
				'preselected'	=> $preselected,
				'value'			=> $review
			];
		}

		if (!empty($data['mt_filters'])) {
			usort($data['mt_filters'], function($a, $b) {
				return ($a['sort'] - $b['sort']);
			});
		}

		if ($slider_status) {
			$this->document->addScript('catalog/view/theme/mt_materialize/js/nouislider/nouislider.js');
			$this->document->addStyle('catalog/view/theme/mt_materialize/stylesheet/nouislider/nouislider.css');
		}

		/*if ($cache_enable) {
			$this->cache->set('materialize.mt_filter.' . (int)$category_id . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $data);
		}*/

		$data['php_time'] = round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 4);

		return $this->load->view('extension/module/mt_filter', $data);

		/*if ($cache_enable) {
			$cache_data = $this->cache->get('materialize.mt_filter.' . (int)$category_id . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));
		}*/

		/*if (empty($cache_data)) {
			$category_status = $this->model_extension_mt_materialize_module_mt_filter->getCategoryStatus($category_id);

			if ($category_status) {
			}
		} else {
			$this->document->addScript('catalog/view/theme/mt_materialize/js/mt_filter/mt_filter.js');
			$this->document->addStyle('catalog/view/theme/mt_materialize/stylesheet/mt_filter/mt_filter.css');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . (int)$this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . (int)$this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . (int)$this->request->get['limit'];
			}

			$cache_data['page_settings'] = str_replace('&amp;', '&', '&language=' . $this->config->get('config_language') . '&path=' . $this->request->get['path'] . $url);

			if (isset($this->request->get['price_filter'])) {
				$cache_data['price_filter_selected'] = explode(',', $this->request->get['price_filter']);
			} else {
				$cache_data['price_filter_selected'] = [];
			}

			if (isset($this->request->get['sub_category_filter'])) {
				$cache_data['sub_category_filter_selected'] = explode(',', $this->request->get['sub_category_filter']);
			} else {
				$cache_data['sub_category_filter_selected'] = [];
			}

			if (isset($this->request->get['default_filter'])) {
				$cache_data['default_filter_selected'] = explode(',', $this->request->get['default_filter']);
			} else {
				$cache_data['default_filter_selected'] = [];
			}

			if (isset($this->request->get['manufacturer_filter'])) {
				$cache_data['manufacturer_filter_selected'] = explode(',', $this->request->get['manufacturer_filter']);
			} else {
				$cache_data['manufacturer_filter_selected'] = [];
			}

			if (isset($this->request->get['attribute_filter'])) {
				foreach ($this->request->get['attribute_filter'] as $key => $value) {
					foreach ($value as $text) {
						$cache_data['attribute_filter_selected'][$key][] = (string)$text;
					}
				}
			} else {
				$cache_data['attribute_filter_selected'] = [];
			}

			if (isset($this->request->get['option_filter'])) {
				$cache_data['option_filter_selected'] = explode(',', $this->request->get['option_filter']);
			} else {
				$cache_data['option_filter_selected'] = [];
			}

			if (isset($this->request->get['rating_filter'])) {
				$cache_data['rating_filter_selected'] = explode(',', $this->request->get['rating_filter']);
			} else {
				$cache_data['rating_filter_selected'] = [];
			}

			if (isset($this->request->get['stock_status_filter'])) {
				$cache_data['stock_status_filter_selected'] = explode(',', $this->request->get['stock_status_filter']);
			} else {
				$cache_data['stock_status_filter_selected'] = [];
			}

			if (isset($this->request->get['product_special_filter'])) {
				$cache_data['product_special_filter_selected'] = explode(',', $this->request->get['product_special_filter']);
			} else {
				$cache_data['product_special_filter_selected'] = [];
			}

			if (isset($this->request->get['review_filter'])) {
				$cache_data['review_filter_selected'] = explode(',', $this->request->get['review_filter']);
			} else {
				$cache_data['review_filter_selected'] = [];
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price') && !empty($cache_data['prices'])) {
				$this->document->addScript('catalog/view/theme/mt_materialize/js/nouislider/nouislider.js');
				$this->document->addStyle('catalog/view/theme/mt_materialize/stylesheet/nouislider/nouislider.css');
			}

			$cache_data['php_time'] = round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 4);

			return $this->load->view('extension/module/mt_filter', $cache_data);
		}*/
	}

	public function filter() {
		$json = [];

		$data = $this->getProducts($this->request->get);
		$data['product_grid'] = $this->request->get['product_grid'];
		$data['product_display'] = $this->load->controller('extension/mt_materialize/product/product/getProductDisplay');

		$json['data'] = $data; /* todo-materialize Remove this! */
		$json['current_location'] = $data['current_location'];
		$json['products'] = $this->load->view('extension/mt_materialize/mt_filter/product', $data);
		$json['php_time'] = round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 4);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function preSelectedFilterItems (&$route, &$data) {
		$preselected_data = $this->getProducts($this->request->get, true);

		$data['mt_filters'] = $preselected_data['mt_filters'];
		$data['products'] = $preselected_data['products'];
		$data['check_sql'] = $preselected_data['check_sql'];
		$data['sorts'] = $preselected_data['sorts'];
		$data['limits'] = $preselected_data['limits'];
		$data['pagination'] = $preselected_data['pagination'];
		$data['results'] = $preselected_data['results'];
		$data['sort'] = $preselected_data['sort'];
		$data['order'] = $preselected_data['order'];
		$data['limit'] = $preselected_data['limit'];
	}

	protected function getProducts($data, $explode = false) {
		$this->load->model('extension/mt_materialize/module/mt_filter');
		$this->load->model('localisation/currency');
		$this->load->model('tool/image');

		$this->load->language('product/category');

		if (isset($this->request->get['location'])) {
			$route = (string)$this->request->get['location'];
		} else {
			if (isset($this->request->get['route'])) {
				$route = (string)$this->request->get['route'];
			} else {
				$route = 'common/home';
			}
		}

		if ($route == 'product/category' && isset($this->request->get['path'])) {
			$path = '&path=' . $this->request->get['path'];

			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = [];

			$path = false;
		}

		$category_id = end($parts);

		$current_location = $this->url->link($route, 'language=' . $this->config->get('config_language') . $path);
		$mt_filter_settings = $this->mtFilterSettings();
		$filters = $mt_filter_settings['filters'];

		$url = '';
		$data['mt_filters'] = [];

		if (isset($this->request->get['price_filter'])) {
			$get_prices = $explode ? explode('-', (string)$this->request->get['price_filter']) : $this->request->get['price_filter'];

			$min_price = (float)$get_prices[0];
			$max_price = (float)$get_prices[1];

			$currency_data = $this->model_localisation_currency->getCurrencyByCode($this->session->data['currency']);

			$data['mt_filters'][] = [
				'type'	=> 'price',
				'sort'	=> (int)$filters['price']['sort'],
				'value'	=> $currency_data['symbol_left'] . (float)round($min_price, (int)$currency_data['decimal_place']) . $currency_data['symbol_right'] . ' — ' . $currency_data['symbol_left'] . (float)round($max_price, (int)$currency_data['decimal_place']) . $currency_data['symbol_right']
			];

			$price_filter_url = '&price_filter=' . (float)$get_prices[0] . '-' . (float)$get_prices[1];

			$url .= $price_filter_url;
		} else {
			$min_price = false;
			$max_price = false;
			$price_filter_url = false;
		}

		if (isset($this->request->get['keyword_filter'])) {
			$keyword_filter = (string)$this->request->get['keyword_filter'];

			$data['mt_filters'][] = [
				'type'	=> 'keyword',
				'sort'	=> (int)$filters['keyword']['sort'],
				'value'	=> $keyword_filter
			];

			$keyword_filter_url = '&keyword_filter=' . $keyword_filter;

			$url .= $keyword_filter_url;
		} else {
			$keyword_filter = false;
			$keyword_filter_url = false;
		}

		if (isset($this->request->get['sub_category_filter'])) {
			$sub_category_filter = $explode ? explode(',', (string)$this->request->get['sub_category_filter']) : $this->request->get['sub_category_filter'];

			$filter_settings = [
				'categories_id'	=> $sub_category_filter,
				'image'			=> !empty($filters['sub_categories']['image']) ? true : false
			];

			$sub_categories = [];

			$sub_category_data = $this->model_extension_mt_materialize_module_mt_filter->getSubCategoriesByFilter($filter_settings);

			foreach ($sub_category_data as $result) {
				if (!empty($filters['sub_categories']['image'])) {
					if (is_file(DIR_IMAGE . html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'))) {
						$image = $this->model_tool_image->resize(html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'), 24, 24);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', 24, 24);
					}
				}

				$sub_categories[] = [
					'category_id'	=> $result['category_id'],
					'mt_filter_id'	=> 'mt-filter-sub-category-' . (int)$result['category_id'],
					'name'			=> $result['name'],
					'image'			=> !empty($filters['sub_categories']['image']) ? $image : false
				];
			}

			$data['mt_filters'][] = [
				'type'	=> 'sub_categories',
				'sort'	=> (int)$filters['sub_categories']['sort'],
				'value'	=> $sub_categories
			];

			$implode = [];

			foreach ($sub_category_filter as $sub_category_id) {
				$implode[] = (int)$sub_category_id;
			}

			$sub_category_filter_url = '&sub_category_filter=' . implode(',', $implode);

			$url .= $sub_category_filter_url;
		} else {
			$sub_category_filter = false;
			$sub_category_filter_url = false;
		}

		if (isset($this->request->get['default_filter'])) {
			$default_filter = $explode ? explode(',', (string)$this->request->get['default_filter']) : $this->request->get['default_filter'];

			$filters_data = $this->model_extension_mt_materialize_module_mt_filter->getDefaultFiltersByFilter($default_filter);

			$default_filters = [];

			foreach ($filters_data as $result) {
				$default_filters[] = [
					'default_filter_id'	=> $result['filter_id'],
					'mt_filter_id'		=> 'mt-filter-default-filter-' . (int)$result['filter_group_id'] . '-' . (int)$result['filter_id'],
					'name'				=> (string)$result['name'] . ": " . (string)$result['text']
				];
			}

			$data['mt_filters'][] = [
				'name'	=> 'default_filters',
				'sort'	=> (int)$filters['default_filters']['sort'],
				'value'	=> $default_filters
			];

			$implode = [];

			foreach ($default_filter as $default_filter_id) {
				$implode[] = (int)$default_filter_id;
			}

			$default_filter_url = '&default_filter=' . implode(',', $implode);

			$url .= $default_filter_url;
		} else {
			$default_filter = false;
			$default_filter_url = false;
		}

		if (isset($this->request->get['manufacturer_filter'])) {
			$manufacturer_filter = $explode ? explode(',', (string)$this->request->get['manufacturer_filter']) : $this->request->get['manufacturer_filter'];

			$filter_settings = [
				'manufacturers_id'	=> $manufacturer_filter,
				'image'				=> !empty($filters['manufacturers']['image']) ? true : false
			];

			$manufacturers_data = $this->model_extension_mt_materialize_module_mt_filter->getManufacturersByFilter($filter_settings);

			$manufacturer_filters = [];

			foreach ($manufacturers_data as $result) {
				if (!empty($filters['manufacturers']['image'])) {
					if (is_file(DIR_IMAGE . html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'))) {
						$image = $this->model_tool_image->resize(html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'), 24, 24);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', 24, 24);
					}
				}

				$manufacturer_filters[] = [
					'manufacturer_id'	=> $result['manufacturer_id'],
					'mt_filter_id'		=> 'mt-filter-manufacturer-' . (int)$result['manufacturer_id'],
					'name'				=> $result['name'],
					'image'				=> !empty($filters['manufacturers']['image']) ? $image : false
				];
			}

			$data['mt_filters'][] = [
				'type'	=> 'manufacturer',
				'sort'	=> (int)$filters['manufacturers']['sort'],
				'value'	=> $manufacturer_filters
			];

			$implode = [];

			foreach ($manufacturer_filter as $manufacturer_id) {
				$implode[] = (int)$manufacturer_id;
			}

			$manufacturer_filter_url = '&manufacturer_filter=' . implode(',', $implode);

			$url .= $manufacturer_filter_url;
		} else {
			$manufacturer_filter = false;
			$manufacturer_filter_url = false;
		}

		if (isset($this->request->get['attribute_filter'])) {
			$attribute_filter = [];
			$attribute_filter_url = '';

			foreach ($this->request->get['attribute_filter'] as $key => $value) {
				$implode = [];

				foreach ($value as $text) {
					$implode[] = trim((string)$text);

					$attribute_filter_url .= '&attribute_filter[' . $key . '][]=' . trim((string)$text);
				}

				$attribute_filter[$key] = implode(',', $implode);
			}

			$attributes = [];

			$attributes_data = $this->model_extension_mt_materialize_module_mt_filter->getAttributesByFilter($attribute_filter);

			foreach ($attributes_data as $result) {
				$attributes[] = [
					'attribute_id'	=> (int)$result['attribute_id'],
					'mt_filter_id'	=> 'mt-filter-attribute-' . (int)$result['attribute_id'] . '-' . utf8_encode(strip_tags(html_entity_decode(trim((string)$result['text']), ENT_QUOTES, 'UTF-8'))),
					'name'			=> (string)$result['name'] . ": " . (string)$result['text']
				];
			}

			$data['mt_filters'][] = [
				'type'	=> 'attributes',
				'sort'	=> (int)$filters['attributes']['sort'],
				'value'	=> $attributes
			];

			$url .= $attribute_filter_url;
		} else {
			$attribute_filter = false;
			$attribute_filter_url = false;
		}

		if (isset($this->request->get['option_filter'])) {
			$option_filter = [];
			$option_filter_url = '';

			foreach ($this->request->get['option_filter'] as $key => $value) {
				foreach ($value as $option_value) {
					$option_filter[$key][] = (int)$option_value;

					$option_filter_url .= '&option_filter[' . $key . '][]=' . (int)$option_value;
				}
			}

			$filter_settings = [
				'option_values_id'	=> $option_filter,
				'image'				=> !empty($filters['options']['image']) ? true : false
			];
			$data['fasafsfasafsafsafs'] = $filter_settings;

			$options_data = $this->model_extension_mt_materialize_module_mt_filter->getOptionsByFilter($filter_settings);

			$option_filters = [];

			foreach ($options_data as $result) {
				if (!empty($filters['options']['image'])) {
					if (is_file(DIR_IMAGE . html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'))) {
						$image = $this->model_tool_image->resize(html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'), 24, 24);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', 24, 24);
					}
				}

				$option_filters[] = [
					'option_value_id'	=> (int)$result['option_value_id'],
					'mt_filter_id'		=> 'mt-filter-option-' . (int)$result['option_id'] . '-' . (int)$result['option_value_id'],
					'name'				=> (string)$result['name'] . ": " . (string)$result['text'],
					'image'				=> !empty($filters['options']['image']) ? $image : false
				];
			}

			$data['mt_filters'][] = [
				'type'	=> 'options',
				'sort'	=> (int)$filters['options']['sort'],
				'value'	=> $option_filters
			];

			$url .= $option_filter_url;
		} else {
			$option_filter = false;
			$option_filter_url = false;
		}

		if (isset($this->request->get['rating_filter'])) {
			$rating_filter = $explode ? explode(',', (string)$this->request->get['rating_filter']) : $this->request->get['rating_filter'];

			$rating_filters = [];

			foreach ($rating_filter as $rating_filter_id) {
				$name = '';

				for ($i = 0; $i < 5; ++$i) {
					if ($i < $rating_filter_id) {
						$name .= '<i class="material-icons yellow-text text-accent-4">star</i>';
					} else {
						$name .= '<i class="material-icons yellow-text text-accent-4">star_border</i>';
					}
				}

				$rating_filters[] = [
					'rating_filter_id'	=> (int)$rating_filter_id,
					'mt_filter_id'		=> 'mt-filter-rating-' . (int)$rating_filter_id,
					'name'				=> $name
				];
			}

			$data['mt_filters'][] = [
				'name'	=> $filters['rating']['description'][$this->config->get('config_language_id')]['name'],
				'type'	=> 'rating',
				'sort'	=> (int)$filters['rating']['sort'],
				'value'	=> $rating_filters
			];

			$implode = [];

			foreach ($rating_filter as $rating_value) {
				$implode[] = (int)$rating_value;
			}

			$rating_filter_url = '&rating_filter=' . implode(',', $implode);

			$url .= $rating_filter_url;
		} else {
			$rating_filter = false;
			$rating_filter_url = false;
		}

		if (isset($this->request->get['stock_status_filter'])) {
			$stock_status_filter = $explode ? explode(',', (string)$this->request->get['stock_status_filter']) : $this->request->get['stock_status_filter'];
			$stock_status_default = (int)$filters['stock_statuses']['default'];

			$stock_statuses_data = $this->model_extension_mt_materialize_module_mt_filter->getStockStatusesByFilter($stock_status_filter);

			$stock_status_filters = [];

			foreach ($stock_statuses_data as $result) {
				$stock_status_filters[] = [
					'stock_status_id'	=> $result['stock_status_id'],
					'mt_filter_id'		=> 'mt-filter-stock-status-' . (int)$result['stock_status_id'],
					'name'				=> $result['name']
				];
			}

			$data['mt_filters'][] = [
				'type'	=> 'stock_statuses',
				'sort'	=> (int)$filters['stock_statuses']['sort'],
				'value'	=> $stock_status_filters
			];

			$implode = [];

			foreach ($stock_status_filter as $stock_status_id) {
				$implode[] = (int)$stock_status_id;
			}

			$stock_status_filter_url = '&stock_status_filter=' . implode(',', $implode);

			$url .= $stock_status_filter_url;
		} else {
			$stock_status_filter = false;
			$stock_status_default = false;
			$stock_status_filter_url = false;
		}

		if (isset($this->request->get['product_special_filter'])) {
			$product_special_filter = true;

			$product_special_filters = [];

			$product_special_filters[] = [
				'mt_filter_id'	=> 'mt-filter-product-special',
				'name'			=> $filters['discount']['description'][$this->config->get('config_language_id')]['name']
			];

			$data['mt_filters'][] = [
				'type'	=> 'discount',
				'sort'	=> (int)$filters['discount']['sort'],
				'value'	=> $product_special_filters
			];

			$product_special_filter_url = '&product_special_filter=' . $product_special_filter;

			$url .= $product_special_filter_url;
		} else {
			$product_special_filter = false;
			$product_special_filter_url = false;
		}

		if (isset($this->request->get['review_filter'])) {
			$review_filter = true;

			$review_filters = [];

			$review_filters[] = [
				'mt_filter_id'	=> 'mt-filter-review',
				'name'			=> $filters['reviews']['description'][$this->config->get('config_language_id')]['name']
			];

			$data['mt_filters'][] = [
				'type'	=> 'review',
				'sort'	=> (int)$filters['reviews']['sort'],
				'value'	=> $review_filters
			];

			$review_filter_url = '&review_filter=' . $review_filter;

			$url .= $review_filter_url;
		} else {
			$review_filter = false;
			$review_filter_url = false;
		}

		if (isset($this->request->get['sort'])) {
			$sort = (string)$this->request->get['sort'];

			$url .= '&sort=' . (string)$this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = (string)$this->request->get['order'];

			$url .= '&order=' . (string)$this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];

			$url .= '&limit=' . (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}

		$filter_data = [
			'category_id'				=> $category_id,
			'keyword_filter'			=> $keyword_filter,
			'sub_category_filter'		=> $sub_category_filter,
			'default_filter'			=> $default_filter,
			'min_price'					=> $min_price,
			'max_price'					=> $max_price,
			'manufacturer_filter'		=> $manufacturer_filter,
			'attribute_filter'			=> $attribute_filter,
			'option_filter'				=> $option_filter,
			'rating_filter'				=> $rating_filter,
			'stock_status_filter'		=> $stock_status_filter,
			'stock_status_default'		=> $stock_status_default,
			'product_special_filter'	=> $product_special_filter,
			'review_filter'				=> $review_filter,
			'config_tax'				=> $this->config->get('config_tax'),
			'currency_ratio'			=> $this->currency->getValue($this->session->data['currency']),
			'sort'						=> $sort,
			'order'						=> $order,
			'start'						=> ($page - 1) * $limit,
			'limit'						=> $limit
		];

		$product_total = $this->model_extension_mt_materialize_module_mt_filter->getTotalProducts($filter_data);

		$query = $this->model_extension_mt_materialize_module_mt_filter->getProducts($filter_data);

		usort($data['mt_filters'], function($a, $b) {
			return ($a['sort'] - $b['sort']);
		});

		$current_location .= $url;

		$data['current_location'] = str_replace('&amp;', '&', $current_location);

		$data['check_sql'] = $query['check_sql']; /* todo-materialize Remove this! */

		$results = $query['query'];

		$data['products'] = [];

		if ($results) {
			$this->load->model('catalog/product'); /* todo-materialize Connect only if "options" are enabled */

			foreach ($results as $result) {
				if (is_file(DIR_IMAGE . html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'))) {
					$image = $this->model_tool_image->resize(html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
					$hor_image = $this->model_tool_image->resize($result['image'], 80, 80);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
					$hor_image = $this->model_tool_image->resize('placeholder.png', 80, 80);
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (float)$result['rating'];
					$reviews = (int)$result['reviews'];
				} else {
					$rating = false;
					$reviews = false;
				}

				$options = [];

				foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
					$product_option_value_data = [];

					foreach ($option['product_option_value'] as $option_value) {
						if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
							if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
								$option_price = $this->currency->format($this->tax->calculate($option_value['price'], $result['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
							} else {
								$option_price = false;
							}

							$product_option_value_data[] = [
								'product_option_value_id'	=> $option_value['product_option_value_id'],
								'option_value_id'			=> $option_value['option_value_id'],
								'name'						=> $option_value['name'],
								'image'						=> $this->model_tool_image->resize($option_value['image'], 40, 40),
								'price'						=> $option_price,
								'price_prefix'				=> $option_value['price_prefix']
							];
						}
					}

					$options[] = [
						'product_option_id'		=> $option['product_option_id'],
						'product_option_value'	=> $product_option_value_data,
						'option_id'				=> $option['option_id'],
						'name'					=> $option['name'],
						'type'					=> $option['type'],
						'value'					=> $option['value'],
						'required'				=> $option['required']
					];
				}

				$data['products'][] = [
					'product_id'	=> $result['product_id'],
					'thumb'			=> $image,
					'hor_image'		=> $hor_image,
					'name'			=> $result['name'],
					'description'	=> utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'options'		=> $options,
					'price'			=> $price,
					'special'		=> $special,
					'tax'			=> $tax,
					'minimum'		=> $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'		=> round($rating, 1),
					'reviews'		=> $reviews,
					'href'			=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . '&product_id=' . $result['product_id'] . $url)
				];
			}
		}

		$url = '';

		if (isset($this->request->get['price_filter'])) {
			$url .= $price_filter_url;
		}

		if (isset($this->request->get['keyword_filter'])) {
			$url .= $keyword_filter_url;
		}

		if (isset($this->request->get['sub_category_filter'])) {
			$url .= $sub_category_filter_url;
		}

		if (isset($this->request->get['default_filter'])) {
			$url .= $default_filter_url;
		}

		if (isset($this->request->get['manufacturer_filter'])) {
			$url .= $manufacturer_filter_url;
		}

		if (isset($this->request->get['attribute_filter'])) {
			$url .= $attribute_filter_url;
		}

		if (isset($this->request->get['option_filter'])) {
			$url .= $option_filter_url;
		}

		if (isset($this->request->get['rating_filter'])) {
			$url .= $rating_filter_url;
		}

		if (isset($this->request->get['stock_status_filter'])) {
			$url .= $stock_status_filter_url;
		}

		if (isset($this->request->get['product_special_filter'])) {
			$url .= $product_special_filter_url;
		}

		if (isset($this->request->get['review_filter'])) {
			$url .= $review_filter_url;
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . (int)$this->request->get['limit'];
		}

		$data['sorts'] = [];

		$data['sorts'][] = [
			'text'	=> $this->language->get('text_default'),
			'value'	=> 'p.sort_order-ASC',
			'href'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . '&sort=p.sort_order&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'	=> $this->language->get('text_name_asc'),
			'value'	=> 'pd.name-ASC',
			'href'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . '&sort=pd.name&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'	=> $this->language->get('text_name_desc'),
			'value'	=> 'pd.name-DESC',
			'href'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . '&sort=pd.name&order=DESC' . $url)
		];

		$data['sorts'][] = [
			'text'	=> $this->language->get('text_price_asc'),
			'value'	=> 'p.price-ASC',
			'href'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . '&sort=p.price&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'	=> $this->language->get('text_price_desc'),
			'value'	=> 'p.price-DESC',
			'href'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . '&sort=p.price&order=DESC' . $url)
		];

		if ($this->config->get('config_review_status')) {
			$data['sorts'][] = [
				'text'	=> $this->language->get('text_rating_desc'),
				'value'	=> 'rating-DESC',
				'href'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . '&sort=rating&order=DESC' . $url)
			];

			$data['sorts'][] = [
				'text'	=> $this->language->get('text_rating_asc'),
				'value'	=> 'rating-ASC',
				'href'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . '&sort=rating&order=ASC' . $url)
			];
		}

		$data['sorts'][] = [
			'text'	=> $this->language->get('text_model_asc'),
			'value'	=> 'p.model-ASC',
			'href'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . '&sort=p.model&order=ASC' . $url)
		];

		$data['sorts'][] = [
			'text'	=> $this->language->get('text_model_desc'),
			'value'	=> 'p.model-DESC',
			'href'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . '&sort=p.model&order=DESC' . $url)
		];

		$url = '';

		if (isset($this->request->get['price_filter'])) {
			$url .= $price_filter_url;
		}

		if (isset($this->request->get['keyword_filter'])) {
			$url .= $keyword_filter_url;
		}

		if (isset($this->request->get['sub_category_filter'])) {
			$url .= $sub_category_filter_url;
		}

		if (isset($this->request->get['default_filter'])) {
			$url .= $default_filter_url;
		}

		if (isset($this->request->get['manufacturer_filter'])) {
			$url .= $manufacturer_filter_url;
		}

		if (isset($this->request->get['attribute_filter'])) {
			$url .= $attribute_filter_url;
		}

		if (isset($this->request->get['option_filter'])) {
			$url .= $option_filter_url;
		}

		if (isset($this->request->get['rating_filter'])) {
			$url .= $rating_filter_url;
		}

		if (isset($this->request->get['stock_status_filter'])) {
			$url .= $stock_status_filter_url;
		}

		if (isset($this->request->get['product_special_filter'])) {
			$url .= $product_special_filter_url;
		}

		if (isset($this->request->get['review_filter'])) {
			$url .= $review_filter_url;
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['limits'] = [];

		$limits = array_unique([$this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100]);

		sort($limits);

		foreach($limits as $value) {
			$data['limits'][] = [
				'text'	=> $value,
				'value'	=> $value,
				'href'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . $url . '&limit=' . $value)
			];
		}

		$url = '';

		if (isset($this->request->get['price_filter'])) {
			$url .= $price_filter_url;
		}

		if (isset($this->request->get['keyword_filter'])) {
			$url .= $keyword_filter_url;
		}

		if (isset($this->request->get['sub_category_filter'])) {
			$url .= $sub_category_filter_url;
		}

		if (isset($this->request->get['default_filter'])) {
			$url .= $default_filter_url;
		}

		if (isset($this->request->get['manufacturer_filter'])) {
			$url .= $manufacturer_filter_url;
		}

		if (isset($this->request->get['attribute_filter'])) {
			$url .= $attribute_filter_url;
		}

		if (isset($this->request->get['option_filter'])) {
			$url .= $option_filter_url;
		}

		if (isset($this->request->get['rating_filter'])) {
			$url .= $rating_filter_url;
		}

		if (isset($this->request->get['stock_status_filter'])) {
			$url .= $stock_status_filter_url;
		}

		if (isset($this->request->get['product_special_filter'])) {
			$url .= $product_special_filter_url;
		}

		if (isset($this->request->get['review_filter'])) {
			$url .= $review_filter_url;
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total'	=> $product_total,
			'page'	=> $page,
			'limit'	=> $limit,
			'url'	=> $this->url->link($route, 'language=' . $this->config->get('config_language') . $path . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;

		return $data;
	}

	protected function mtFilterSettings() {
		$mt_filter_settings = $this->cache->get('materialize.mt_filter.settings.' . (int)$this->config->get('config_store_id'));

		if (!$mt_filter_settings) {
			$mt_filter_settings = $this->config->get('module_mt_filter_settings');

			if (!empty($mt_filter_settings['cache']['status'])) {
				$this->cache->set('materialize.mt_filter.settings.' . (int)$this->config->get('config_store_id'), $mt_filter_settings);
			}
		}

		return $mt_filter_settings;
	}
}