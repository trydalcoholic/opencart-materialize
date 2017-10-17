<?php
class ControllerExtensionModuleQuickorder extends Controller {
	public function index() {
		$this->load->language('extension/module/quickorder');

		$data['lang'] = $this->language->get('code');

		$language = $this->config->get('config_language_id');

		$data['button_submit'] = $this->language->get('button_submit');

		$data['attract_title'] = $this->config->get('quickorder_title' . $language);
		$data['attract_description'] = $this->config->get('quickorder_description' . $language);

		$data['quickorder_time'] = $this->config->get('quickorder_time');

		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$data['entry_calltime'] = $this->language->get('entry_calltime');

		$data['error_telephone'] = $this->language->get('error_telephone');
		$data['error_email'] = $this->language->get('error_email');
		$data['error_name'] = $this->language->get('error_name');
		$data['error_email'] = $this->language->get('error_email');
		$data['error_enquiry'] = $this->language->get('error_enquiry');
		$data['error_calltime'] = $this->language->get('error_calltime');

		$data['text_email_error'] = $this->language->get('text_email_error');
		$data['text_email_success'] = $this->language->get('text_email_success');		

		$data['quickorder_modaltitle'] = $this->config->get('quickorder_modaltitle' . $language);
		$data['quickorder_button'] = $this->config->get('quickorder_button' . $language);

		if ($this->config->get('quickorder_name') == 1) {
			$data['quickorder_name'] = $this->config->get('quickorder_name');

			if ($this->config->get('quickorder_name_required') == 1) {
				$data['quickorder_name_required'] = $this->config->get('quickorder_name_required');
			} else {
				$data['quickorder_name_required'] = '';
			}
		} else {
			$data['quickorder_name'] = '';
			$data['quickorder_name_required'] = '';
		}

		if ($this->config->get('quickorder_email') == 1) {
			$data['quickorder_email'] = $this->config->get('quickorder_email');

			if ($this->config->get('quickorder_email_required') == 1) {
				$data['quickorder_email_required'] = $this->config->get('quickorder_email_required');
			} else {
				$data['quickorder_email_required'] = '';
			}
		} else {
			$data['quickorder_email'] = '';
			$data['quickorder_email_required'] = '';
		}

		if ($this->config->get('quickorder_enquiry') == 1) {
			$data['quickorder_enquiry'] = $this->config->get('quickorder_enquiry');

			if ($this->config->get('quickorder_enquiry_required') == 1) {
				$data['quickorder_enquiry_required'] = $this->config->get('quickorder_enquiry_required');
			} else {
				$data['quickorder_enquiry_required'] = '';
			}
		} else {
			$data['quickorder_enquiry'] = '';
			$data['quickorder_enquiry_required'] = '';
		}

		if ($this->config->get('quickorder_calltime') == 1) {
			$data['quickorder_calltime'] = $this->config->get('quickorder_calltime');

			if ($this->config->get('quickorder_calltime_required') == 1) {
				$data['quickorder_calltime_required'] = $this->config->get('quickorder_calltime_required');
			} else {
				$data['quickorder_calltime_required'] = '';
			}
		} else {
			$data['quickorder_calltime'] = '';
			$data['quickorder_calltime_required'] = '';
		}

		if ($this->config->get('quickorder_status') == 1) {
			$data['quickorder_status'] = $this->config->get('quickorder_status');
		} else {
			$data['quickorder_status'] = '';
		}

		if ($this->config->get('quickorder_phonemask') == 1) {
			$data['quickorder_phonemask'] = $this->config->get('quickorder_phonemask');
		} else {
			$data['quickorder_phonemask'] = '';
		}

		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			$data['product_title'] = $product_info['name'];
		}

		$data['product_link'] = $this->url->link('product/product', 'product_id=' . (int)$this->request->get['product_id']);

		$this->load->model('tool/image');

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		if ($product_info['image']) {
			$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
		} else {
			$data['thumb'] = '';
		}

		if ($this->config->get('quickorder_agreement')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('quickorder_agreement'));

			if ($information_info) {
				$data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_account_id'), true), $information_info['title'], $information_info['title']);
			} else {
				$data['text_agree'] = '';
			}
		} else {
			$data['text_agree'] = '';
		}

		if (isset($this->request->post['agree'])) {
			$data['agree'] = $this->request->post['agree'];
		} else {
			$data['agree'] = false;
		}

		return $this->load->view('extension/module/quickorder', $data);
	}

	public function send() {
		$this->load->language('extension/module/quickorder');

		$language = $this->config->get('config_language_id');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['quickorder_telephone']) < 5) || (utf8_strlen($this->request->post['quickorder_telephone']) > 24)) {
				$json['error'] = $this->language->get('error_telephone');
			}

			if (isset($this->request->post['quickorder_name'])) {
				if (($this->config->get('quickorder_name_required') == 1) && ((utf8_strlen($this->request->post['quickorder_name']) < 3) || (utf8_strlen($this->request->post['quickorder_name']) > 25))) {
					$json['error'] = $this->language->get('error_name');
				}
			} else {
				$this->request->post['quickorder_name'] = '';
			}

			if (isset($this->request->post['quickorder_email'])) {
				if (($this->config->get('quickorder_name_required') == 1) && (!preg_match($this->config->get('config_mail_regexp'), $this->request->post['quickorder_email']))) {
					$json['error'] = $this->language->get('error_email');
				}
			} else {
				$this->request->post['quickorder_email'] = '';
			}

			if (isset($this->request->post['quickorder_enquiry'])) {
				if (($this->config->get('quickorder_enquiry_required') == 1) && ((utf8_strlen($this->request->post['quickorder_enquiry']) < 10) || (utf8_strlen($this->request->post['quickorder_enquiry']) > 360))) {
					$json['error'] = $this->language->get('error_enquiry');
				}
			} else {
				$this->request->post['quickorder_enquiry'] = '';
			}

			if (isset($this->request->post['quickorder_calltime'])) {
				if (($this->config->get('quickorder_calltime_required') == 1) && empty($this->request->post['quickorder_calltime'])) {
					$json['error'] = $this->language->get('error_calltime');
				}
			} else {
				$this->request->post['quickorder_calltime'] = '';
			}

			// Agree to terms
			if ($this->config->get('quickorder_agreement')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('quickorder_agreement'));

				if ($information_info && !isset($this->request->post['agree'])) {
					$json['error'] = sprintf($this->language->get('error_agree'), '<b>&nbsp;' . $information_info['title'] . '</b>');
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('extension/module/quickorder');

				$this->model_extension_module_quickorder->sendQuickorder($this->request->post);

				$json['success'] = $this->config->get('quickorder_success' . $language);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}