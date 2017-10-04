<?php
class ControllerExtensionModuleCallback extends Controller {
	public function index() {
		$this->load->language('extension/module/callback');

		$language = $this->config->get('config_language_id');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['button_submit'] = $this->language->get('button_submit');
		$data['text_success'] = $this->language->get('text_success');

		$data['attract_title'] = $this->config->get('callback_title' . $language);
		$data['attract_description'] = $this->config->get('callback_description' . $language);

		$data['callback_time'] = $this->config->get('callback_time');

		$data['error_name'] = $this->language->get('error_name');
		$data['error_telephone'] = $this->language->get('error_telephone');

		if ($this->config->get('callback_status') == 0) {
			$data['callback_status'] = '';
		} else {
			$data['callback_status'] = $this->config->get('callback_status');
		}

		if ($this->config->get('callback_phonemask') == 0) {
			$data['callback_phonemask'] = '';
		} else {
			$data['callback_phonemask'] = $this->config->get('callback_phonemask');
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