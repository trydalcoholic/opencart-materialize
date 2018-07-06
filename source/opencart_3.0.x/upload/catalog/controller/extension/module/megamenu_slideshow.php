<?php
class ControllerExtensionModuleMegamenuSlideshow extends Controller {
	public function index($slideshow) {
		static $megamenu_slideshow = 0;

		$this->load->model('tool/image');

		$this->document->addScript('catalog/view/theme/materialize/js/slick-carousel/slick.min.js');

		$this->document->addStyle('catalog/view/theme/materialize/stylesheet/slick-carousel/slick.css');
		$this->document->addStyle('catalog/view/theme/materialize/stylesheet/slick-carousel/slick-theme.css');

		$materialize_settings = $this->config->get('theme_materialize_settings');

		if (!empty($materialize_settings['optimization']['cached_colors'])) {
			$cached_colors = $this->cache->get('materialize.colors');
		} else {
			$cached_colors = false;
		}

		if (!$cached_colors) {
			$colors = $this->config->get('theme_materialize_colors');

			if (!empty($materialize_settings['optimization']['cached_colors'])) {
				$this->cache->set('materialize.colors', $colors);
			}
		} else {
			$colors = $cached_colors;
		}

		$data['color_add_cart'] = $colors['add_cart'];
		$data['color_add_cart_text'] = $colors['add_cart_text'];
		$data['color_more_detailed'] = $colors['more_detailed'];
		$data['color_more_detailed_text'] = $colors['more_detailed_text'];

		if ($slideshow['content_type'] == 'banner') {
			$this->load->model('design/banner');

			$results = $this->model_design_banner->getBanner($slideshow['content_info']);

			$data['banners'] = array();

			foreach ($results as $result) {
				if (isset($result['image']) && is_file(DIR_IMAGE . $result['image'])) {
					$data['banners'][] = array(
						'title'	=> $result['title'],
						'link'	=> $result['link'],
						'image'	=> $this->model_tool_image->resize($result['image'], 300, 200)
					);
				}
			}

			$data['megamenu_slideshow'] = $megamenu_slideshow++;

			return $this->load->view('extension/module/megamenu_slideshow', $data);
		}

		if ($slideshow['content_type'] == 'featured') {
			$this->load->language('product/materialize');
			$this->load->language('extension/module/featured');

			$this->load->model('catalog/product');
			$this->load->model('extension/module/megamenu');

			$setting = $this->model_extension_module_megamenu->getModule($slideshow['content_info']);

			$data['products'] = array();

			if (!$setting['limit']) {
				$setting['limit'] = 4;
			}

			if (!empty($setting['product'])) {
				$products = array_slice($setting['product'], 0, (int)$setting['limit']);

				foreach ($products as $product_id) {
					$product_info = $this->model_catalog_product->getProduct($product_id);

					if ($product_info) {
						if ($product_info['image']) {
							$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
						}

						if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
							$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
							$price = false;
						}

						if ((float)$product_info['special']) {
							$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
							$percent_discount = round(100-($product_info['special']/($product_info['price']/100)));
						} else {
							$special = false;
							$percent_discount = false;
						}

						if ($this->config->get('config_tax')) {
							$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
						} else {
							$tax = false;
						}

						if ($this->config->get('config_review_status')) {
							$rating = $product_info['rating'];
							$reviews = (int)$product_info['reviews'];
						} else {
							$rating = false;
							$reviews = false;
						}

						$labels = array();

						if ($this->config->get('module_label_status') == 1) {
							$results = $this->model_catalog_product->getProductLabels($product_info['product_id']);

							foreach ($results as $result) {
								$labels[] = array(
									'name'			=> $result['name'],
									'color'			=> $result['label_color'],
									'color_text'	=> $result['label_color_text']
								);
							}
						}

						if (($product_info['quantity'] <= 0) && (!$this->config->get('config_stock_checkout'))) {
							$add_cart = false;
						} else {
							$add_cart = true;
						}

						$data['products'][] = array(
							'percent_discount'	=> $percent_discount,
							'add_cart'			=> $add_cart,
							'labels'			=> $labels,
							'product_id'		=> $product_info['product_id'],
							'thumb'				=> $image,
							'name'				=> $product_info['name'],
							'description'		=> utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
							'price'				=> $price,
							'special'			=> $special,
							'tax'				=> $tax,
							'rating'			=> $rating,
							'reviews'			=> $reviews,
							'href'				=> $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
						);
					}
				}
			}

			$data['megamenu_slideshow'] = $megamenu_slideshow++;

			return $this->load->view('extension/module/megamenu_products', $data);
		}

		if ($slideshow['content_type'] == 'bestseller') {
			$this->load->language('product/materialize');
			$this->load->language('extension/module/bestseller');

			$this->load->model('catalog/product');
			$this->load->model('extension/module/megamenu');

			$data['products'] = array();

			$setting = $this->model_extension_module_megamenu->getModule($slideshow['content_info']);

			$results = $this->model_catalog_product->getBestSellerProducts($setting['limit']);

			if ($results) {
				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						$percent_discount = round(100-($result['special']/($result['price']/100)));
					} else {
						$special = false;
						$percent_discount = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
						$reviews = (int)$result['reviews'];
					} else {
						$rating = false;
						$reviews = false;
					}


					$labels = array();

					if ($this->config->get('module_label_status') == 1) {
						$labels_array = $this->model_catalog_product->getProductLabels($result['product_id']);

						foreach ($labels_array as $label) {
							$labels[] = array(
								'name'			=> $label['name'],
								'color'			=> $label['label_color'],
								'color_text'	=> $label['label_color_text']
							);
						}
					}

					if (($result['quantity'] <= 0) && (!$this->config->get('config_stock_checkout'))) {
						$add_cart = false;
					} else {
						$add_cart = true;
					}

					$data['products'][] = array(
						'add_cart'			=> $add_cart,
						'labels'			=> $labels,
						'product_id'		=> $result['product_id'],
						'thumb'				=> $image,
						'name'				=> $result['name'],
						'description'		=> utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 100) . '..',
						'price'				=> $price,
						'special'			=> $special,
						'percent_discount'	=> $percent_discount,
						'tax'				=> $tax,
						'rating'			=> $rating,
						'reviews'			=> $reviews,
						'href'				=> $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				}
			}

			$data['megamenu_slideshow'] = $megamenu_slideshow++;

			return $this->load->view('extension/module/megamenu_products', $data);
		}

		if ($slideshow['content_type'] == 'special') {
			$this->load->language('product/materialize');
			$this->load->language('extension/module/special');

			$this->load->model('catalog/product');
			$this->load->model('extension/module/megamenu');

			$setting = $this->model_extension_module_megamenu->getModule($slideshow['content_info']);

			$data['products'] = array();

			$filter_data = array(
				'sort'	=> 'pd.name',
				'order'	=> 'ASC',
				'start'	=> 0,
				'limit'	=> $setting['limit']
			);

			$results = $this->model_catalog_product->getProductSpecials($filter_data);

			if ($results) {
				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						$percent_discount = round(100-($result['special']/($result['price']/100)));
					} else {
						$special = false;
						$percent_discount = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
						$reviews = (int)$result['reviews'];
					} else {
						$rating = false;
						$reviews = false;
					}

					$labels = array();

					if ($this->config->get('module_label_status') == 1) {
						$labels_array = $this->model_catalog_product->getProductLabels($result['product_id']);

						foreach ($labels_array as $label) {
							$labels[] = array(
								'name'			=> $label['name'],
								'color'			=> $label['label_color'],
								'color_text'	=> $label['label_color_text']
							);
						}
					}

					if (($result['quantity'] <= 0) && (!$this->config->get('config_stock_checkout'))) {
						$add_cart = false;
					} else {
						$add_cart = true;
					}

					$data['products'][] = array(
						'add_cart'			=> $add_cart,
						'labels'			=> $labels,
						'product_id'		=> $result['product_id'],
						'thumb'				=> $image,
						'name'				=> $result['name'],
						'description'		=> utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 100) . '..',
						'price'				=> $price,
						'special'			=> $special,
						'percent_discount'	=> $percent_discount,
						'tax'				=> $tax,
						'rating'			=> $rating,
						'reviews'			=> $reviews,
						'href'				=> $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				}
			}

			$data['megamenu_slideshow'] = $megamenu_slideshow++;

			return $this->load->view('extension/module/megamenu_products', $data);
		}
	}
}