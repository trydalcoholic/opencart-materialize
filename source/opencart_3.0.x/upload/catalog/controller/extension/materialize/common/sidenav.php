<?php
class ControllerExtensionMaterializeCommonSidenav extends Controller {
	public function index() {
		$this->load->language('common/materialize');

		$this->load->language('common/cart');

		$this->load->language('common/header');

		$this->load->language('common/menu');

		$this->load->language('common/search');

		$data['color_sidebar'] = $this->config->get('theme_materialize_color_sidebar');
		$data['color_sidebar_text'] = $this->config->get('theme_materialize_color_sidebar_text');

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
		$data['email'] = $this->config->get('config_email');
		$data['telephone'] = $this->config->get('config_telephone');

		// Search
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		$data['product_path'] = $this->url->link('product/product');
		$data['color_mobile_search'] = $this->config->get('theme_materialize_color_mobile_search');

		// Callback module
		if ($this->config->get('module_callback_status') == 1) {
			$module_callback = $this->config->get('module_callback');

			$data['callback_text'] = $module_callback[$this->config->get('config_language_id')]['title'];
			$data['callback'] = $this->load->controller('extension/module/callback', $data);
		} else {
			$data['callback'] = false;
		}

		// Menu
		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'	=> $child['category_id'],
						'filter_sub_category'	=> true
					);

					$children_data[] = array(
						'name'	=> ($this->config->get('config_product_count') ? '<span class="new-badge" data-badge="' . $this->model_catalog_product->getTotalProducts($filter_data) . '">' . $child['name'] . '</span>' : $child['name']),
						'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'		=> $category['name'],
					'children'	=> $children_data,
					'column'	=> $category['column'] ? $category['column'] : 1,
					'href'		=> $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		// Links
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);

		$data['cart'] = $this->url->link('checkout/cart');
		$data['contact'] = $this->url->link('information/contact');
		$data['delivery'] = $this->url->link('information/information' . '&information_id=6');
		$data['about'] = $this->url->link('information/information' . '&information_id=4');

		if ($this->config->get('module_blog_status') == 1) {
			$data['blog'] = $this->url->link('extension/materialize/blog/blog');
		} else {
			$data['blog'] = '';
		}

		$this->response->setOutput($this->load->view('common/sidenav', $data));
	}
}