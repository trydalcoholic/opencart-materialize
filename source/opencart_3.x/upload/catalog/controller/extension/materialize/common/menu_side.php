<?php
class ControllerExtensionMaterializeCommonMenuSide extends Controller {
	public function index() {
		$this->load->language('common/menu');

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'	=> $child['category_id'],
						'filter_sub_category'	=> true
					);

					$children_data[] = array(
						'name'	=> ($this->config->get('config_product_count') ? '<span class="new-badge" data-badge="' . $this->model_catalog_product->getTotalProducts($filter_data) . '">' . $child['name'] . '</span>' : $child['name']),
						'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'		=> $category['name'],
					'children'	=> $children_data,
					'column'	=> $category['column'] ? $category['column'] : 1,
					'href'		=> $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		return $this->load->view('common/menu_side', $data);
	}
}