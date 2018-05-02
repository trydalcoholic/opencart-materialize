<?php
class ControllerExtensionModuleAdultContent extends Controller {
	public function index($adult_info) {
		$this->load->language('extension/module/adult_content');

		$this->load->model('catalog/information');

		$agreement_info = $this->model_catalog_information->getInformation($adult_info['agreement_id']);

		$data['agreement_title'] = $agreement_info['title'];
		$data['agreement_description'] = html_entity_decode($agreement_info['description'], ENT_QUOTES, 'UTF-8');
		$data['agreement_id'] = $adult_info['agreement_id'];
		$data['back_link'] = $adult_info['back_link'];

		return $this->load->view('extension/module/adult_content', $data);
	}

	public function agree() {
		$this->load->language('extension/module/adult_content');

		$this->load->model('catalog/information');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$information_info = $this->model_catalog_information->getInformation($this->request->post['adult_content_agreement_id']);

			if ($information_info && !isset($this->request->post['adult_content_agree'])) {
				$json['error'] = sprintf($this->language->get('error_agree'), '<b>&nbsp;' . $information_info['title'] . '</b>');
			}

			if (!isset($json['error'])) {
				$json['success'] = true;

				$this->session->data['adult_content_accept'] = true;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}