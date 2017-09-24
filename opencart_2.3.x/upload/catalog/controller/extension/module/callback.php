<?php
class ControllerExtensionModuleCallback extends Controller {
	public function index() {
		$this->load->language('extension/module/callback');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['button_submit'] = $this->language->get('button_submit');
		$data['text_success'] = $this->language->get('text_success');

		$data['attract_title'] = $this->language->get('attract_title');
		$data['attract_text'] = $this->language->get('attract_text');

		$data['error_name'] = $this->language->get('error_name');
		$data['error_telephone'] = $this->language->get('error_telephone');

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$data['callback_status'] = str_replace('http', 'https', html_entity_decode($this->config->get('callback_status')));
		} else {
			$data['callback_status'] = html_entity_decode($this->config->get('callback_status'));
		}

		return $this->load->view('extension/module/callback', $data);
	}

	public function send() {
		$this->load->language('extension/module/callback');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['callback_name']) < 3) || (utf8_strlen($this->request->post['callback_name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['callback_telephone']) < 5) || (utf8_strlen($this->request->post['callback_telephone']) > 24)) {
				$json['error'] = $this->language->get('error_telephone');
			}

			if (!isset($json['error'])) {
				$this->load->model('extension/module/callback');

				$this->model_extension_module_callback->sendCallback($this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}