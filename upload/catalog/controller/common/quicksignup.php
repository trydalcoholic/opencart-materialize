<?php
class ControllerCommonQuicksignup extends Controller {
	public function index() {
		$this->load->language('common/quicksignup');

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['login'] = $this->url->link('account/login', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');

		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_details'] = $this->language->get('text_details');
		$data['text_signin_register'] = $this->language->get('text_signin_register');
		$data['text_new_customer'] = $this->language->get('text_new_customer');
		$data['text_returning'] = $this->language->get('text_returning');
		$data['text_returning_customer'] = $this->language->get('text_returning_customer');
		
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['text_forgotten'] = $this->language->get('text_forgotten');
		$data['text_email_error'] = $this->language->get('text_email_error');
		$data['text_email_success'] = $this->language->get('text_email_success');

		
		$data['button_login'] = $this->language->get('button_login');
		$data['button_continue'] = $this->language->get('button_continue');
		
		$data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
		
		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

			if ($information_info) {
				$data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$data['text_agree'] = '';
			}
		} else {
			$data['text_agree'] = '';
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/quicksignup.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/quicksignup.tpl', $data);
		} else {
			return $this->load->view('common/quicksignup.tpl', $data);
		}
	}
	
	public function register() {
		$json =array();
		$this->language->load('common/quicksignup');
		$this->language->load('account/success');
		$this->load->model('account/customer');
		$this->load->model('catalog/information');
		$this->load->model('account/quicksignup');
		
		if ($this->customer->isLogged()) {
			$json['islogged'] = true;
		}else if(isset($this->request->post)) {
			if ((utf8_strlen(trim($this->request->post['name'])) < 1) || (utf8_strlen(trim($this->request->post['name'])) > 32)) {
				$json['error'] = $json['error_name'] = $this->language->get('error_name');
			}
			
			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
				$json['error'] = $json['error_email'] = $this->language->get('error_email');
			}

			if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
				$json['error'] = $json['error_email'] = $this->language->get('error_exists');
			}

			if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
				$json['error'] = $json['error_telephone'] = $this->language->get('error_telephone');
			}
			
			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$json['error'] = $json['error_password'] = $this->language->get('error_password');
			}
			
			// Agree to terms
			if ($this->config->get('config_account_id')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
				if ($information_info && !isset($this->request->post['agree'])) {
					$json['error'] = sprintf($this->language->get('error_agree'), $information_info['title']);
				}
			}
		}else{
			$json['error'] = $this->language->get('error_warning');
		}
		
		if(!$json) {
		
			$this->model_account_quicksignup->addCustomer($this->request->post);
			$json['success'] = true;
			$this->customer->login($this->request->post['email'], $this->request->post['password']);

			unset($this->session->data['guest']);

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->request->post['name']
			);

			$this->model_account_activity->addActivity('register', $activity_data);
			
			if ($this->customer->isLogged()) {
				$json['now_login'] = true;
			}
			
			
			$json['heading_title'] = $this->language->get('heading_title');

			$this->load->model('account/customer_group');

			$customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->config->get('config_customer_group_id'));

			if ($customer_group_info && !$customer_group_info['approval']) {
				$json['text_message'] = sprintf($this->language->get('text_message'), $this->config->get('config_name'), $this->url->link('information/contact'));
			} else {
				$json['text_message'] = sprintf($this->language->get('text_approval'), $this->config->get('config_name'), $this->url->link('information/contact'));
			}
			
			if ($this->cart->hasProducts()) {
				$json['continue'] = $this->url->link('checkout/cart');
			} else {
				$json['continue'] = $this->url->link('account/account', '', 'SSL');
			}

			$json['button_continue'] = $this->language->get('button_continue');
			
		}
		
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function login() {
		
		$json =array();
		$this->language->load('common/quicksignup');
		$this->load->model('account/customer');
		
		if ($this->customer->isLogged()) {
			$json['islogged'] = true;
		}else if(isset($this->request->post)) {
			if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
				$json['error'] = $this->language->get('error_login');
			}
			$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
			if ($customer_info && !$customer_info['approved']) {
				$json['error'] = $this->language->get('error_approved');
			}
		}else{
			$json['error'] = $this->language->get('error_warning');
		}
		
		if(!$json) {
			$json['success'] = true;
			unset($this->session->data['guest']);
			
			// Default Shipping Address
			$this->load->model('account/address');

			if ($this->config->get('config_tax_customer') == 'payment') {
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			if ($this->config->get('config_tax_customer') == 'shipping') {
				$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);

			$this->model_account_activity->addActivity('login', $activity_data);
		}
		
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}