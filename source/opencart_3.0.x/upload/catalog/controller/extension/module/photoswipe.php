<?php
class ControllerExtensionModulePhotoswipe extends Controller {
	public function index() {
		$this->load->language('extension/module/photoswipe');

		$this->document->addScript('catalog/view/theme/materialize/js/photoswipe/photoswipe.min.js');
		$this->document->addScript('catalog/view/theme/materialize/js/photoswipe/photoswipe-ui-default.min.js');

		$this->document->addStyle('catalog/view/theme/materialize/stylesheet/photoswipe/photoswipe.css');
		$this->document->addStyle('catalog/view/theme/materialize/stylesheet/photoswipe/default-skin/default-skin.css');

		return $this->load->view('extension/module/photoswipe');
	}
}