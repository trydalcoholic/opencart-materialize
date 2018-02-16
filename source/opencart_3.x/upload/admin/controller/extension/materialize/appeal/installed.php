<?php
class ControllerExtensionMaterializeAppealInstalled extends Controller {
	public function index() {
		$this->load->language('extension/materialize/appeal/appeal');

		$data['modal_title'] = sprintf($this->language->get('modal_title'), $this->request->get['modal_title']);
		$data['modal_alert'] = sprintf($this->language->get('modal_alert'), $this->request->get['modal_title']);

		$this->response->setOutput($this->load->view('extension/materialize/appeal/installed', $data));
	}

	public function footer() {
		$this->load->language('extension/materialize/appeal/appeal');

		$data['appeal_footer'] = true;

		$this->response->setOutput($this->load->view('extension/materialize/appeal/footer', $data));
	}
}