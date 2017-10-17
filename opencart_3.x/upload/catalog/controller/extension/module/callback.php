<?php
class ControllerExtensionModuleCallback extends Controller {
	public function index() {
		$this->load->language('extension/module/callback');

		$data['lang'] = $this->language->get('code');

		$module_callback = $this->config->get('module_callback');

		$data['module_callback_title'] = $module_callback[$this->config->get('config_language_id')]['title'];
		$data['module_callback_caption'] = $module_callback[$this->config->get('config_language_id')]['caption'];
		$data['module_callback_description'] = $module_callback[$this->config->get('config_language_id')]['description'];
		$data['module_callback_time'] = $this->config->get('module_callback_time');

		if ($this->config->get('module_callback_name') == 1) {
			$data['module_callback_name'] = $this->config->get('module_callback_name');

			if ($this->config->get('module_callback_name_required') == 1) {
				$data['module_callback_name_required'] = $this->config->get('module_callback_name_required');
			} else {
				$data['module_callback_name_required'] = '';
			}
		} else {
			$data['module_callback_name'] = '';
			$data['module_callback_name_required'] = '';
		}

		if ($this->config->get('module_callback_enquiry') == 1) {
			$data['module_callback_enquiry'] = $this->config->get('module_callback_enquiry');

			if ($this->config->get('module_callback_enquiry_required') == 1) {
				$data['module_callback_enquiry_required'] = $this->config->get('module_callback_enquiry_required');
			} else {
				$data['module_callback_enquiry_required'] = '';
			}
		} else {
			$data['module_callback_enquiry'] = '';
			$data['module_callback_enquiry_required'] = '';
		}

		if ($this->config->get('module_callback_calltime') == 1) {
			$data['module_callback_calltime'] = $this->config->get('module_callback_calltime');

			if ($this->config->get('module_callback_calltime_required') == 1) {
				$data['module_callback_calltime_required'] = $this->config->get('module_callback_calltime_required');
			} else {
				$data['module_callback_calltime_required'] = '';
			}
		} else {
			$data['module_callback_calltime'] = '';
			$data['module_callback_calltime_required'] = '';
		}

		if ($this->config->get('module_callback_callaction_status') == 1) {
			$data['module_callback_callaction_status'] = $this->config->get('module_callback_callaction_status');
		} else {
			$data['module_callback_callaction_status'] = '';
		}

		if ($this->config->get('module_callback_phonemask_status') == 1) {
			$data['module_callback_phonemask_status'] = $this->config->get('module_callback_phonemask_status');
		} else {
			$data['module_callback_phonemask_status'] = '';
		}

		if ($this->config->get('module_callback_status') == 1) {
			$data['module_callback_status'] = $this->config->get('module_callback_status');
		} else {
			$data['module_callback_status'] = '';
		}

		return $this->load->view('extension/module/callback', $data);
	}

	public function send() {
		$this->load->language('extension/module/callback');

		$language = $this->config->get('config_language_id');

		$module_callback = $this->config->get('module_callback');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['module_callback_telephone']) < 5) || (utf8_strlen($this->request->post['module_callback_telephone']) > 24)) {
				$json['error'] = $this->language->get('error_telephone');
			}

			if (isset($this->request->post['module_callback_name'])) {
				if (($this->config->get('module_callback_name_required') == 1) && ((utf8_strlen($this->request->post['module_callback_name']) < 3) || (utf8_strlen($this->request->post['module_callback_name']) > 25))) {
					$json['error'] = $this->language->get('error_name');
				}
			} else {
				$this->request->post['module_callback_name'] = '';
			}

			if (isset($this->request->post['module_callback_enquiry'])) {
				if (($this->config->get('module_callback_enquiry_required') == 1) && ((utf8_strlen($this->request->post['module_callback_enquiry']) < 10) || (utf8_strlen($this->request->post['module_callback_enquiry']) > 360))) {
					$json['error'] = $this->language->get('error_enquiry');
				}
			} else {
				$this->request->post['module_callback_enquiry'] = '';
			}

			if (isset($this->request->post['module_callback_calltime'])) {
				if (($this->config->get('module_callback_calltime_required') == 1) && empty($this->request->post['module_callback_calltime'])) {
					$json['error'] = $this->language->get('error_calltime');
				}
			} else {
				$this->request->post['module_callback_calltime'] = '';
			}

			if (!isset($json['error'])) {
				$this->load->model('extension/module/callback');

				$this->model_extension_module_callback->sendCallback($this->request->post);

				$json['success'] = $module_callback[$this->config->get('config_language_id')]['success'];
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}