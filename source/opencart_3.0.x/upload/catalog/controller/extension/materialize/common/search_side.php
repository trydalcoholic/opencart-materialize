<?php
class ControllerExtensionMaterializeCommonSearchSide extends Controller {
	public function index() {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		if ($this->config->get('module_materialize_status') == 1) {
			$data['color_mobile_search'] = $this->config->get('module_materialize_color_mobile_search');
		} else {
			$data['color_mobile_search'] = 'blue-grey lighten-1';
		}

		return $this->load->view('common/search_side', $data);
	}
}