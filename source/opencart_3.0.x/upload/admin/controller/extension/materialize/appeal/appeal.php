<?php
class ControllerExtensionMaterializeAppealAppeal extends Controller {
	public function index() {
		$this->load->language('extension/materialize/appeal/appeal');

		return $this->load->view('extension/materialize/appeal/footer');
	}

	public function installed($installed) {
		$this->load->language('extension/materialize/appeal/appeal');

		$data['modal_title'] = sprintf($this->language->get('modal_title'), $installed);
		$data['modal_alert'] = sprintf($this->language->get('modal_alert'), $installed);

		return $this->load->view('extension/materialize/appeal/installed', $data);
	}

	public function updated($updated) {
		$this->load->language('extension/materialize/appeal/appeal');

		$data['modal_title'] = sprintf($this->language->get('modal_title_update'), $updated);
		$data['modal_alert'] = sprintf($this->language->get('modal_alert_update'), $updated);

		return $this->load->view('extension/materialize/appeal/updated', $data);
	}
}