<?php
class ControllerExtensionModuleSizechart extends Controller {
	public function index() {
		$this->load->language('extension/module/sizechart');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['sizechart_status'] = html_entity_decode($this->config->get('module_sizechart_status'));

		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
			$product_info = $this->model_catalog_product->getProduct($product_id);
		}

		return $data;
	}
}