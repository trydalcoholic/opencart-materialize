<?php
class ControllerExtensionModuleCallback extends Controller {
	public function index() {
		$this->load->language('extension/module/callback');

		$data['lang'] = $this->language->get('code');

		$language = $this->config->get('config_language_id');

		$data['button_submit'] = $this->language->get('button_submit');

		$data['attract_title'] = $this->config->get('callback_title' . $language);
		$data['attract_description'] = $this->config->get('callback_description' . $language);

		$data['callback_time'] = $this->config->get('callback_time');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$data['entry_calltime'] = $this->language->get('entry_calltime');

		$data['error_telephone'] = $this->language->get('error_telephone');
		$data['error_name'] = $this->language->get('error_name');
		$data['error_enquiry'] = $this->language->get('error_enquiry');
		$data['error_calltime'] = $this->language->get('error_calltime');

		$data['callback_modaltitle'] = $this->config->get('callback_modaltitle' . $language);

		if ($this->config->get('callback_name') == 1) {
			$data['callback_name'] = $this->config->get('callback_name');

			if ($this->config->get('callback_name_required') == 1) {
				$data['callback_name_required'] = $this->config->get('callback_name_required');
			} else {
				$data['callback_name_required'] = '';
			}
		} else {
			$data['callback_name'] = '';
			$data['callback_name_required'] = '';
		}

		if ($this->config->get('callback_enquiry') == 1) {
			$data['callback_enquiry'] = $this->config->get('callback_enquiry');

			if ($this->config->get('callback_enquiry_required') == 1) {
				$data['callback_enquiry_required'] = $this->config->get('callback_enquiry_required');
			} else {
				$data['callback_enquiry_required'] = '';
			}
		} else {
			$data['callback_enquiry'] = '';
			$data['callback_enquiry_required'] = '';
		}

		if ($this->config->get('callback_calltime') == 1) {
			$data['callback_calltime'] = $this->config->get('callback_calltime');

			if ($this->config->get('callback_calltime_required') == 1) {
				$data['callback_calltime_required'] = $this->config->get('callback_calltime_required');
			} else {
				$data['callback_calltime_required'] = '';
			}
		} else {
			$data['callback_calltime'] = '';
			$data['callback_calltime_required'] = '';
		}

		if ($this->config->get('callback_status') == 1) {
			$data['callback_status'] = $this->config->get('callback_status');
		} else {
			$data['callback_status'] = '';
		}

		if ($this->config->get('callback_phonemask') == 1) {
			$data['callback_phonemask'] = $this->config->get('callback_phonemask');
		} else {
			$data['callback_phonemask'] = '';
		}

		return $this->load->view('extension/module/callback', $data);
	}

	public function send() {
		$this->load->language('extension/module/callback');

		$language = $this->config->get('config_language_id');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['callback_telephone']) < 5) || (utf8_strlen($this->request->post['callback_telephone']) > 24)) {
				$json['error'] = $this->language->get('error_telephone');
			}

			if (isset($this->request->post['callback_name'])) {
				if (($this->config->get('callback_name_required') == 1) && ((utf8_strlen($this->request->post['callback_name']) < 3) || (utf8_strlen($this->request->post['callback_name']) > 25))) {
					$json['error'] = $this->language->get('error_name');
				}
			} else {
				$this->request->post['callback_name'] = '';
			}

			if (isset($this->request->post['callback_enquiry'])) {
				if (($this->config->get('callback_enquiry_required') == 1) && ((utf8_strlen($this->request->post['callback_enquiry']) < 10) || (utf8_strlen($this->request->post['callback_enquiry']) > 360))) {
					$json['error'] = $this->language->get('error_enquiry');
				}
			} else {
				$this->request->post['callback_enquiry'] = '';
			}

			if (isset($this->request->post['callback_calltime'])) {
				if (($this->config->get('callback_calltime_required') == 1) && empty($this->request->post['callback_calltime'])) {
					$json['error'] = $this->language->get('error_calltime');
				}
			} else {
				$this->request->post['callback_calltime'] = '';
			}

			if (!isset($json['error'])) {
				$this->load->model('extension/module/callback');

				$this->model_extension_module_callback->sendCallback($this->request->post);

				$json['success'] = $this->config->get('callback_success' . $language);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}