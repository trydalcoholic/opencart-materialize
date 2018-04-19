<?php
class ControllerExtensionModuleMegamenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		$this->load->model('extension/module/megamenu');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		$data['color_navigation'] = $this->config->get('theme_materialize_color_navigation');
		$data['color_navigation_text'] = $this->config->get('theme_materialize_color_navigation_text');

		$module_megamenu_settings = $this->config->get('module_megamenu_settings');

		if ($module_megamenu_settings['home'] == 'on') {
			$data['home'] = $this->url->link('common/home');
		} else {
			$data['home'] = false;
		}

		if ($module_megamenu_settings['fix'] == 'on') {
			$data['fix'] = true;
		} else {
			$data['fix'] = false;
		}

		if ($module_megamenu_settings['center'] == 'on') {
			$data['center'] = true;
		} else {
			$data['center'] = false;
		}

		if ($module_megamenu_settings['category_title'] == 'on') {
			$data['category_title'] = true;
		} else {
			$data['category_title'] = false;
		}

		if ($module_megamenu_settings['see_all'] == 'on') {
			$data['see_all'] = true;
		} else {
			$data['see_all'] = false;
		}

		$data['categories'] = array();

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

				if ($category_1['megamenu'] == 1) {
					if ($category_1['type'] == 'image') {
						$category_1['content'] = $this->model_tool_image->resize($category_1['image'], 315, 315);
					} elseif ($category_1['type'] == 'manufacturers') {
						$this->load->model('catalog/manufacturer');

						$results = $this->model_catalog_manufacturer->getMegamenuManufacturersByCategoryId($category_1['category_id']);

						$category_1['content'] = array();

						foreach ($results as $result) {
							if (isset($result['image']) && is_file(DIR_IMAGE . $result['image'])) {
								$category_1['content'][] = array(
									'name'	=> $result['name'],
									'image'	=> $this->model_tool_image->resize($result['image'], 160, 90),
									'href'	=> $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
								);
							}
						}
					} elseif ($category_1['type'] == 'banner') {
						$this->load->model('design/banner');

						$category_1['content'] = array();

						$banner_id = $this->model_extension_module_megamenu->getMegamenuBannerIdByCategoryId($category_1['category_id']);

						$results = $this->model_design_banner->getBanner($banner_id);

						foreach ($results as $result) {
							if (isset($result['image']) && is_file(DIR_IMAGE . $result['image'])) {
								$category_1['content'][] = array(
									'title'	=> $result['title'],
									'link'	=> $result['link'],
									'image'	=> $this->model_tool_image->resize($result['image'], 300, 200)
								);
							}
						}
					} else {
						$category_1['type'] = '';
						$category_1['content'] = '';
					}
				} else {
					$category_1['type'] = '';
					$category_1['content'] = '';
				}

				$data['categories'][] = array(
					'category_id'	=> $category_1['category_id'],
					'name'			=> $category_1['name'],
					'megamenu'		=> $category_1['megamenu'],
					'type'			=> $category_1['type'],
					'content'		=> $category_1['content'],
					'href'			=> $this->url->link('product/category', 'path=' . $category_1['category_id']),
					'children'		=> $level_2_data
				);
			}
		}

		return $this->load->view('extension/module/megamenu', $data);
	}
}