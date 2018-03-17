<?php
class ControllerCustomerCallback extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('customer/callback');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('customer/callback');

		$this->getList();
	}

	public function edit() {
		$this->load->language('customer/callback');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('customer/callback');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_customer_callback->editMaterializeCallback($this->request->get['callback_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('customer/callback');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customer/callback');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $callback_id) {
				$this->model_customer_callback->deleteMaterializeCallback($callback_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_id'])) {
			$filter_id = $this->request->get['filter_id'];
		} else {
			$filter_id = '';
		}

		if (isset($this->request->get['filter_telephone'])) {
			$filter_telephone = $this->request->get['filter_telephone'];
		} else {
			$filter_telephone = '';
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}

		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = '';
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('heading_title'),
			'href'	=> $this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['delete'] = $this->url->link('customer/callback/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['callbacks'] = array();

		$filter_data = array(
			'filter_id'			=> $filter_id,
			'filter_telephone'	=> $filter_telephone,
			'filter_name'		=> $filter_name,
			'filter_status'		=> $filter_status,
			'filter_date_added'	=> $filter_date_added,
			'filter_ip'			=> $filter_ip,
			'sort'				=> $sort,
			'order'				=> $order,
			'start'				=> ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'				=> $this->config->get('config_limit_admin')
		);

		$callback_total = $this->model_customer_callback->getMaterializeTotalCallbacks($filter_data);

		$results = $this->model_customer_callback->getMaterializeCallbacks($filter_data);

		foreach ($results as $result) {
			$data['callbacks'][] = array(
				'id'			=> $result['callback_id'],
				'telephone'		=> $result['telephone'],
				'name'			=> $result['name'],
				'status'		=> ($result['status'] ? '<span class="label label-success">'.$this->language->get('text_сalled').'</span>' : '<span class="label label-warning">'.$this->language->get('text_waiting').'</span>'),
				'ip'			=> $result['ip'],
				'date_added'	=> '<b>'.date($this->language->get('time_format'), strtotime($result['date_added'])).'</b><br>'.date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'			=> $this->url->link('customer/callback/edit', 'user_token=' . $this->session->data['user_token'] . '&callback_id=' . $result['callback_id'] . $url, true)
			);
		}

		$data['user_token'] = $this->session->data['user_token'];
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_id'] = $this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=id' . $url, true);
		$data['sort_telephone'] = $this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=telephone' . $url, true);
		$data['sort_name'] = $this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_status'] = $this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url, true);
		$data['sort_ip'] = $this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=ip' . $url, true);
		$data['sort_date_added'] = $this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $callback_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($callback_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($callback_total - $this->config->get('config_limit_admin'))) ? $callback_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $callback_total, ceil($callback_total / $this->config->get('config_limit_admin')));

		$data['filter_id'] = $filter_id;
		$data['filter_telephone'] = $filter_telephone;
		$data['filter_name'] = $filter_name;
		$data['filter_status'] = $filter_status;
		$data['filter_ip'] = $filter_ip;
		$data['filter_date_added'] = $filter_date_added;

		$data['sort'] = $sort;
		$data['order'] = $order;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/callback_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = sprintf($this->language->get('text_edit'), $this->request->get['callback_id']);

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->get['callback_id'])) {
			$data['callback_id'] = $this->request->get['callback_id'];
		} else {
			$data['callback_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['enquiry'])) {
			$data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$data['error_enquiry'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['action'] = $this->url->link('customer/callback/edit', 'user_token=' . $this->session->data['user_token'] . '&callback_id=' . $this->request->get['callback_id'] . $url, true);

		$data['cancel'] = $this->url->link('customer/callback', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['callback_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$callback_info = $this->model_customer_callback->getMaterializeCallback($this->request->get['callback_id']);
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($callback_info)) {
			$data['telephone'] = $callback_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($callback_info)) {
			$data['name'] = $callback_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['enquiry'])) {
			$data['enquiry'] = $this->request->post['enquiry'];
		} elseif (!empty($callback_info)) {
			$data['enquiry'] = $callback_info['enquiry'];
		} else {
			$data['enquiry'] = '';
		}

		if (isset($this->request->post['call_time'])) {
			$data['call_time'] = $this->request->post['call_time'];
		} elseif (!empty($callback_info)) {
			$data['call_time'] = $callback_info['call_time'];
		} else {
			$data['call_time'] = '';
		}

		if (isset($this->request->post['date_added'])) {
			$data['date_added'] = $this->request->post['date_added'];
		} elseif (!empty($callback_info)) {
			$data['date_added'] = $callback_info['date_added'];
		} else {
			$data['date_added'] = '';
		}

		if (isset($this->request->post['ip'])) {
			$data['ip'] = $this->request->post['ip'];
		} elseif (!empty($callback_info)) {
			$data['ip'] = $callback_info['ip'];
		} else {
			$data['ip'] = '';
		}

		if (isset($this->request->post['order_page'])) {
			$data['order_page'] = $this->request->post['order_page'];
		} elseif (!empty($callback_info)) {
			$data['order_page'] = $callback_info['order_page'];
		} else {
			$data['order_page'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($callback_info)) {
			$data['status'] = $callback_info['status'];
		} else {
			$data['status'] = true;
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/callback_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'customer/callback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if (utf8_strlen($this->request->post['name']) > 32) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (utf8_strlen($this->request->post['enquiry']) > 360) {
			$this->error['enquiry'] = $this->language->get('error_enquiry');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'customer/callback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function history() {
		$this->load->language('customer/callback');

		$this->load->model('customer/callback');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['histories'] = array();

		$results = $this->model_customer_callback->getMaterializeHistories($this->request->get['callback_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['histories'][] = array(
				'comment'		=> $result['comment'],
				'date_added'	=> '<b>'.date($this->language->get('date_format_short'), strtotime($result['date_added'])).'</b><br>'.date($this->language->get('time_format'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_customer_callback->getTotalMaterializeHistories($this->request->get['callback_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('customer/callback/history', 'user_token=' . $this->session->data['user_token'] . '&callback_id=' . $this->request->get['callback_id'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));

		$this->response->setOutput($this->load->view('customer/callback_history', $data));
	}

	public function addHistory() {
		$this->load->language('customer/callback');

		$json = array();

		if (!$this->user->hasPermission('modify', 'customer/callback')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$this->load->model('customer/callback');

			$this->model_customer_callback->addMaterializeHistory($this->request->get['callback_id'], $this->request->post['comment']);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			
			$this->load->model('customer/callback');

			$filter_data = array(
				'filter_name'	=> $filter_name,
				'start'			=> 0,
				'limit'			=> 5
			);

			$results = $this->model_customer_callback->getMaterializeCallbacks($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'callback_id'	=> $result['callback_id'],
					'name'			=> strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}