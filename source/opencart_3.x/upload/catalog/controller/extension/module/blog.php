<?php
class ControllerExtensionModuleBlog extends Controller {
	public function index() {
		$this->load->language('extension/module/blog');

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		return $this->load->view('extension/module/blog', $data);
	}
}