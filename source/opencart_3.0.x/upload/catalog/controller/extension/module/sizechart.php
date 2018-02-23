<?php
class ControllerExtensionModuleSizechart extends Controller {
	public function index() {
		$this->load->language('extension/module/sizechart');

		$this->load->model('extension/module/sizechart');

		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		$sizechart = $this->model_extension_module_sizechart->getSizechartByProductId($product_id);

		if (!empty($sizechart)) {
			$data['sizechart'] = html_entity_decode($sizechart, ENT_QUOTES, 'UTF-8');
		} else {
			$data['sizechart'] = '';
		}

		return $this->load->view('extension/module/sizechart', $data);
	}
}