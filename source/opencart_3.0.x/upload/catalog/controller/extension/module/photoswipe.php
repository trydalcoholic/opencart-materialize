<?php
class ControllerExtensionModulePhotoswipe extends Controller {
	public function index($data) {
		$this->load->language('extension/module/photoswipe');

		return $this->load->view('extension/module/photoswipe', $data);
	}
}