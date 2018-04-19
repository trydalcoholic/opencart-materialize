<?php
class ControllerExtensionModuleMegamenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		$this->load->model('extension/module/megamenu');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		$data['color_navigation'] = $this->config->get('theme_materialize_color_navigation');

		if ($this->config->get('module_megamenu_home') == 'on') {
			$data['module_megamenu_home'] = $this->url->link('common/home');
		} else {
			$data['module_megamenu_home'] = false;
		}

		if ($this->config->get('module_megamenu_fix') == 'on') {
			$data['module_megamenu_fix'] = true;
		} else {
			$data['module_megamenu_fix'] = false;
		}

		if ($this->config->get('module_megamenu_center') == 'on') {
			$data['module_megamenu_center'] = true;
		} else {
			$data['module_megamenu_center'] = false;
		}

		if ($this->config->get('module_megamenu_category_title') == 'on') {
			$data['module_megamenu_category_title'] = true;
		} else {
			$data['module_megamenu_category_title'] = false;
		}

		if ($this->config->get('module_megamenu_see_all') == 'on') {
			$data['module_megamenu_see_all'] = true;
		} else {
			$data['module_megamenu_see_all'] = false;
		}

		$data['categories'] = array();

		$data['module_megamenu_category'] = $this->model_extension_module_megamenu->getMegamenuCategories();

		$categories_1 = $this->model_catalog_category->getCategories(0);

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

				$category_type = $this->model_extension_module_megamenu->getMegamenuCategoryTypeByCategoryId($category_1['category_id']);

				if ($category_type == 'image') {
					$category_type = $this->model_tool_image->resize($category_1['image'], 315, 315);
				} elseif ($category_type == 'manufacturers') {
					$this->load->model('catalog/manufacturer');

					$results = $this->model_catalog_manufacturer->getMegamenuManufacturersByCategoryId($category_1['category_id']);

					$category_type = array();

					foreach ($results as $result) {
						if (isset($result['image']) && is_file(DIR_IMAGE . $result['image'])) {
							$category_type[] = array(
								'name'	=> $result['name'],
								'image'	=> $this->model_tool_image->resize($result['image'], 160, 90),
								'href'	=> $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
							);
						}
					}
				} elseif ($category_type == 'banner') {
					$this->load->model('design/banner');

					$category_type = array();

					$banner_id = $this->model_extension_module_megamenu->getMegamenuBannerIdByCategoryId($category_1['category_id']);

					$results = $this->model_design_banner->getBanner($banner_id);

					foreach ($results as $result) {
						if (isset($result['image']) && is_file(DIR_IMAGE . $result['image'])) {
							$category_type[] = array(
								'title'	=> $result['title'],
								'link'	=> $result['link'],
								'image'	=> $this->model_tool_image->resize($result['image'], 300, 200)
							);
						}
					}
				} else {
					$category_type = '';
				}

				$data['categories'][] = array(
					'category_id'	=> $category_1['category_id'],
					'name'			=> $category_1['name'],
					'href'			=> $this->url->link('product/category', 'path=' . $category_1['category_id']),
					'children'		=> $level_2_data,
					'category_type'	=> $category_type
				);
			}
		}

		return $this->load->view('extension/module/megamenu', $data);
	}
}