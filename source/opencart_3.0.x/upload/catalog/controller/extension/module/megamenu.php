<?php
class ControllerExtensionModuleMegamenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		$this->load->model('extension/module/megamenu');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

		$materialize_settings = $this->config->get('theme_materialize_settings');
		$module_megamenu_settings = $this->config->get('module_megamenu_settings');

		if (!empty($materialize_settings['optimization']['cached_colors'])) {
			$cached_colors = true;
		} else {
			$cached_colors = false;
		}

		if ($cached_colors) {
			$colors = $this->cache->get('materialize.colors');

			if (!$colors) {
				$colors = $this->config->get('theme_materialize_colors');

				$this->cache->set('materialize.colors', $colors);
			}
		} else {
			$colors = $this->config->get('theme_materialize_colors');
		}

		$data['color_navigation'] = $colors['navigation'];
		$data['color_navigation_text'] = $colors['navigation_text'];

		if (!empty($module_megamenu_settings['optimization']['cached_categories'])) {
			$cached_categories = true;

			$data['categories'] = $this->cache->get('materialize.megamenu.categories.' . (int)$this->config->get('config_language_id'));
		} else {
			$cached_categories = false;
		}

		if (!empty($module_megamenu_settings['home'])) {
			$data['home'] = $this->url->link('common/home');
		} else {
			$data['home'] = false;
		}

		if (!empty($module_megamenu_settings['fix'])) {
			$data['fix'] = true;
		} else {
			$data['fix'] = false;
		}

		if (!empty($module_megamenu_settings['center'])) {
			$data['center'] = true;
		} else {
			$data['center'] = false;
		}

		if (!empty($module_megamenu_settings['category_title'])) {
			$data['category_title'] = true;
		} else {
			$data['category_title'] = false;
		}

		if (!empty($module_megamenu_settings['see_all'])) {
			$data['see_all'] = true;
		} else {
			$data['see_all'] = false;
		}

		if (!$cached_categories || empty($data['categories'])) {
			$categories_1 = $this->model_extension_module_megamenu->getCategories(0);

			foreach ($categories_1 as $category_1) {
				if ($category_1['top']) {
					$filter_data = array(
						'filter_category_id'	=> $category_1['category_id'],
						'filter_sub_category'	=> true
					);

					$level_2_data = array();

					$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

					foreach ($categories_2 as $category_2) {
						$filter_data = array(
							'filter_category_id'	=> $category_2['category_id'],
							'filter_sub_category'	=> true
						);

						if ($category_2['image']) {
							$image = $this->model_tool_image->resize($category_2['image'], 42, 42);
						} else {
							$image = '';
						}

						$level_3_data = array();

						$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

						foreach ($categories_3 as $category_3) {
							$filter_data = array(
								'filter_category_id'	=> $category_3['category_id'],
								'filter_sub_category'	=> true
							);

							$level_3_data[] = array(
								'name'	=> ($this->config->get('config_product_count') ? '<span class="new-badge" data-badge="' . $this->model_catalog_product->getTotalProducts($filter_data) . '">' . $category_3['name'] . '</span>' : $category_3['name']),
								'href'	=> $this->url->link('product/category', 'path=' . $category_3['category_id'])
							);
						}

						$level_2_data[] = array(
							'title'		=> $category_2['name'],
							'name'		=> ($this->config->get('config_product_count') ? '<span class="new-badge" data-badge="' . $this->model_catalog_product->getTotalProducts($filter_data) . '">' . $category_2['name'] . '</span>' : $category_2['name']),
							'href'		=> $this->url->link('product/category', 'path=' . $category_2['category_id']),
							'image'		=> $image,
							'children'	=> $level_3_data
						);
					}

					if ($category_1['content_type'] == 'category_image') {
						if (is_file(DIR_IMAGE . $category_1['image'])) {
							$category_1['content_info'] = $this->model_tool_image->resize($category_1['image'], $module_megamenu_settings[$category_1['category_id']]['image_width'], $module_megamenu_settings[$category_1['category_id']]['image_height']);
						} else {
							$category_1['content_info'] = false;
						}
					} else if ($category_1['content_type'] == 'image_custom') {
						if (is_file(DIR_IMAGE . $category_1['content_info'])) {
							$category_1['content_info'] = $this->model_tool_image->resize($category_1['content_info'], $module_megamenu_settings[$category_1['category_id']]['image_width'], $module_megamenu_settings[$category_1['category_id']]['image_height']);
						} else {
							$category_1['content_info'] = false;
						}
					} else if ($category_1['content_type'] == 'image_background') {
						if (is_file(DIR_IMAGE . $category_1['content_info'])) {
							$image = $category_1['content_info'];

							$category_1['content_info'] = array();

							$category_1['content_info']['image'] = $this->model_tool_image->resize($image, $module_megamenu_settings[$category_1['category_id']]['image_width'], $module_megamenu_settings[$category_1['category_id']]['image_height']);
							$category_1['content_info']['settings'] = $module_megamenu_settings[$category_1['category_id']]['background_settings'];
						} else {
							$category_1['content_info'] = false;
						}
					} elseif ($category_1['content_type'] == 'category_manufacturers') {
						$this->load->model('catalog/manufacturer');

						$results = $this->model_catalog_manufacturer->getMegamenuManufacturersByCategoryId($category_1['category_id']);

						$category_1['content_info'] = array();

						foreach ($results as $result) {
							if (isset($result['image']) && is_file(DIR_IMAGE . $result['image'])) {
								$category_1['content_info'][] = array(
									'name'	=> $result['name'],
									'image'	=> $this->model_tool_image->resize($result['image'], 160, 90),
									'href'	=> $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
								);
							}
						}
					} elseif ($category_1['content_type'] == 'html') {
						$setting = $this->model_extension_module_megamenu->getModule($category_1['content_info']);

						$category_1['content_info'] = $this->load->controller('extension/module/html', $setting);
					} else {
						$slideshow = array(
							'content_type'	=> $category_1['content_type'],
							'content_info'	=> $category_1['content_info']
						);

						$category_1['content_info'] = $this->load->controller('extension/module/megamenu_slideshow', $slideshow);
					}

					$data['categories'][] = array(
						'category_id'	=> $category_1['category_id'],
						'name'			=> $category_1['name'],
						'color'			=> $category_1['color'],
						'color_text'	=> $category_1['color_text'],
						'content_type'	=> $category_1['content_type'],
						'content_info'	=> $category_1['content_info'],
						'href'			=> $this->url->link('product/category', 'path=' . $category_1['category_id']),
						'children'		=> $level_2_data
					);
				}
			}

			if ($cached_categories) {
				$this->cache->set('materialize.megamenu.categories.' . (int)$this->config->get('config_language_id'), $data['categories']);
			}
		}

		return $this->load->view('extension/module/megamenu', $data);
	}
}