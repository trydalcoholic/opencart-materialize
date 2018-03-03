<?php
class ControllerExtensionModuleQuickorder extends Controller {
	public function index() {
		$this->load->language('extension/module/quickorder');
		$this->load->language('materialize/materialize');

		$data['lang'] = $this->language->get('code');

		$module_quickorder = $this->config->get('module_quickorder');

		$data['module_quickorder_button'] = $module_quickorder[$this->config->get('config_language_id')]['text_button'];
		$data['module_quickorder_color_btn'] = $this->config->get('module_quickorder_color_btn');
		$data['module_quickorder_color_btn_text'] = $this->config->get('module_quickorder_color_btn_text');

		if ($this->config->get('module_quickorder_name') == 1) {
			$data['module_quickorder_name'] = $this->config->get('module_quickorder_name');

			if ($this->config->get('module_quickorder_name_required') == 1) {
				$data['module_quickorder_name_required'] = $this->config->get('module_quickorder_name_required');
			} else {
				$data['module_quickorder_name_required'] = '';
			}
		} else {
			$data['module_quickorder_name'] = '';
			$data['module_quickorder_name_required'] = '';
		}

		if ($this->config->get('module_quickorder_email') == 1) {
			$data['module_quickorder_email'] = $this->config->get('module_quickorder_email');

			if ($this->config->get('module_quickorder_email_required') == 1) {
				$data['module_quickorder_email_required'] = $this->config->get('module_quickorder_email_required');
			} else {
				$data['module_quickorder_email_required'] = '';
			}
		} else {
			$data['module_quickorder_email'] = '';
			$data['module_quickorder_email_required'] = '';
		}

		if ($this->config->get('module_quickorder_enquiry') == 1) {
			$data['module_quickorder_enquiry'] = $this->config->get('module_quickorder_enquiry');

			if ($this->config->get('module_quickorder_enquiry_required') == 1) {
				$data['module_quickorder_enquiry_required'] = $this->config->get('module_quickorder_enquiry_required');
			} else {
				$data['module_quickorder_enquiry_required'] = '';
			}
		} else {
			$data['module_quickorder_enquiry'] = '';
			$data['module_quickorder_enquiry_required'] = '';
		}

		if ($this->config->get('module_quickorder_calltime') == 1) {
			$data['module_quickorder_calltime'] = $this->config->get('module_quickorder_calltime');

			if ($this->config->get('module_quickorder_calltime_required') == 1) {
				$data['module_quickorder_calltime_required'] = $this->config->get('module_quickorder_calltime_required');
			} else {
				$data['module_quickorder_calltime_required'] = '';
			}
		} else {
			$data['module_quickorder_calltime'] = '';
			$data['module_quickorder_calltime_required'] = '';
		}

		if ($this->config->get('module_quickorder_phonemask_status') == 1) {
			$data['module_quickorder_phonemask_status'] = $this->config->get('module_quickorder_phonemask_status');
		} else {
			$data['module_quickorder_phonemask_status'] = '';
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
			$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height'));
		} else {
			$data['thumb'] = '';
		}

		if ($this->config->get('module_quickorder_agreement')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('module_quickorder_agreement'));

			if ($information_info) {
				$data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('module_quickorder_agreement'), true), $information_info['title'], $information_info['title']);
			} else {
				$data['text_agree'] = '';
			}
		} else {
			$data['text_agree'] = '';
		}

		if (isset($this->request->post['module_quickorder_agree'])) {
			$data['module_quickorder_agree'] = $this->request->post['module_quickorder_agree'];
		} else {
			$data['module_quickorder_agree'] = false;
		}

		if ($this->config->get('module_quickorder_status') == 1) {
			$data['module_quickorder_status'] = $this->config->get('module_quickorder_status');
		} else {
			$data['module_quickorder_status'] = '';
		}

		return $this->load->view('extension/module/quickorder', $data);
	}

	public function send() {
		$this->load->language('extension/module/quickorder');

		$language = $this->config->get('config_language_id');

		$module_quickorder = $this->config->get('module_quickorder');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['module_quickorder_telephone']) < 5) || (utf8_strlen($this->request->post['module_quickorder_telephone']) > 24)) {
				$json['error'] = $this->language->get('error_telephone');
			}

			if (isset($this->request->post['module_quickorder_name'])) {
				if (($this->config->get('module_quickorder_name_required') == 1) && ((utf8_strlen($this->request->post['module_quickorder_name']) < 3) || (utf8_strlen($this->request->post['module_quickorder_name']) > 25))) {
					$json['error'] = $this->language->get('error_name');
				}
			} else {
				$this->request->post['module_quickorder_name'] = '';
			}

			if (isset($this->request->post['module_quickorder_email'])) {
				if (($this->config->get('module_quickorder_email_required') == 1) && (!filter_var($this->request->post['module_quickorder_email'], FILTER_VALIDATE_EMAIL))) {
					$json['error'] = $this->language->get('error_email');
				}
			} else {
				$this->request->post['module_quickorder_email'] = '';
			}

			if (isset($this->request->post['module_quickorder_enquiry'])) {
				if (($this->config->get('module_quickorder_enquiry_required') == 1) && ((utf8_strlen($this->request->post['module_quickorder_enquiry']) < 10) || ((utf8_strlen($this->request->post['module_quickorder_enquiry'])) > 360))) {
					$json['error'] = $this->language->get('error_enquiry');
				}
			} else {
				$this->request->post['module_quickorder_enquiry'] = '';
			}

			if (isset($this->request->post['module_quickorder_calltime'])) {
				if (($this->config->get('module_quickorder_calltime_required') == 1) && (empty($this->request->post['module_quickorder_calltime']))) {
					$json['error'] = $this->language->get('error_calltime');
				}
			} else {
				$this->request->post['module_quickorder_calltime'] = '';
			}

			// Agree to terms
			if ($this->config->get('module_quickorder_agreement')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('module_quickorder_agreement'));

				if ($information_info && !isset($this->request->post['module_quickorder_agree'])) {
					$json['error'] = sprintf($this->language->get('error_agree'), '<b>&nbsp;' . $information_info['title'] . '</b>');
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('extension/module/quickorder');

				$this->model_extension_module_quickorder->sendQuickorder($this->request->post);

				$json['success'] = $module_quickorder[$this->config->get('config_language_id')]['success'];
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}