<?php
class ControllerExtensionThemeUltimaterialColorScheme extends Controller {
	public function index() {
		$this->load->language('extension/theme/ultimaterial');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addStyle('https://fonts.googleapis.com/icon?family=Material+Icons');
		$this->document->addStyle('view/stylesheet/ultimaterial/template/vendor/materialize/materialize.css');
		$this->document->addStyle('view/stylesheet/ultimaterial/template/vendor/bootstrap/bootstrap-grid.css');
		$this->document->addStyle('view/stylesheet/ultimaterial/template/extension/theme/ultimaterial/color_scheme.css');
		$this->document->addScript('view/stylesheet/ultimaterial/vendor/materialize-1.0.0/dist/js/materialize.min.js');
		$this->document->addScript('view/stylesheet/ultimaterial/vendor/sortable-1.10.1/Sortable.min.js');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = HTTP_CATALOG . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/theme/ultimaterial/color_scheme', $data));
	}
}
