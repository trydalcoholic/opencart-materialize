<?php
class ControllerExtensionModuleMapYandex extends Controller {
	public function index($data) {
		return $this->load->view('extension/module/map_yandex', $data);
	}
}