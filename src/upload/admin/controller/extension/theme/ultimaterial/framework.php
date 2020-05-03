<?php

class ControllerExtensionThemeUltimaterialFramework extends Controller {
	public function index() {
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$this->response->setOutput($this->load->view('extension/theme/ultimaterial/framework', $data));
	}
}
