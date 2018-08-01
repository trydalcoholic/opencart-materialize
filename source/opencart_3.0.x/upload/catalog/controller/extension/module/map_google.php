<?php
class ControllerExtensionModuleMapGoogle extends Controller {
	public function index($data) {
		return $this->load->view('extension/module/map_google', $data);
	}
}