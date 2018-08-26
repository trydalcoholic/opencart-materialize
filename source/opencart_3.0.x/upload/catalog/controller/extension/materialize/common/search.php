<?php
class ControllerExtensionMaterializeCommonSearch extends Controller {
	public function autocomplete() {
		if ($this->config->get('theme_materialize_status') == 1) {
			$materialize_settings = $this->config->get('theme_materialize_settings');
			$livesearch = $materialize_settings['livesearch'];
		}

		$json = array();

		$this->load->model('extension/materialize/catalog/product');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = 0;
		}

		$show_label = false;

		if (!empty($livesearch['display_description'])) {
			$show_description = true;

			if (!empty($livesearch['display_description_length']) && $livesearch['display_description_length'] > 0) {
				$length_description = $livesearch['display_description_length'];
			} else {
				$length_description = 100;
			}
		} else {
			$show_description = false;
		}

		if (!empty($livesearch['display_image'])) {
			$filter_image = true;
		} else {
			$filter_image = false;
		}

		if (!empty($livesearch['search_description'])) {
			$filter_description = true;
		} else {
			$filter_description = false;
		}

		if (!empty($livesearch['search_tags'])) {
			$filter_tag = true;
		} else {
			$filter_tag = false;
		}

		if (!empty($livesearch['search_model'])) {
			$filter_model = true;
		} else {
			$filter_model = false;
		}

		if (!empty($livesearch['search_sku'])) {
			$filter_sku = true;
		} else {
			$filter_sku = false;
		}

		if (!empty($livesearch['search_manufacturer'])) {
			$filter_manufacturer = true;
		} else {
			$filter_manufacturer = false;
		}

		if (!empty($livesearch['display_price'])) {
			$filter_price = true;
		} else {
			$filter_price = false;
		}

		if (!empty($livesearch['display_rating'])) {
			$filter_rating = true;
		} else {
			$filter_rating = false;
		}

		$limit = $livesearch['settings_limit'];

		$filter_data = array(
			'show_description'		=> $show_description,
			'filter_name'			=> $filter_name,
			'filter_image'			=> $filter_image,
			'filter_description'	=> $filter_description,
			'filter_tag'			=> $filter_tag,
			'filter_model'			=> $filter_model,
			'filter_sku'			=> $filter_sku,
			'filter_manufacturer'	=> $filter_manufacturer,
			'filter_price'			=> $filter_price,
			'filter_rating'			=> $filter_rating,
			'filter_category_id'	=> $filter_category_id,
			'start'					=> 0,
			'limit'					=> $limit
		);

		if ($filter_image) {
			$this->load->model('tool/image');
		}

		$products = $this->model_extension_materialize_catalog_product->getProductsSearch($filter_data);

		foreach ($products as $product) {
			if (isset($product['image']) && $filter_image) {
				$image = $this->model_tool_image->resize($product['image'], 40, 40);
			} elseif (!isset($product['image']) && $filter_image) {
				$image = $this->model_tool_image->resize('placeholder.png', 40, 40);
			} else {
				$image = false;
			}

			if (($this->customer->isLogged() || !$this->config->get('config_customer_price')) && $filter_price) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$price = false;
			}

			if ((float)isset($product['special']) && $filter_price) {
				$special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$percent_discount = round(100-($product['special']/($product['price']/100)));
			} else {
				$special = false;
				$percent_discount = false;
			}

			if ($this->config->get('config_tax') && $filter_price) {
				$tax = $this->currency->format((float)$product['special'] ? $product['special'] : $product['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status') && $filter_rating) {
				$rating = (int)$product['rating'];
				$reviews = (int)$product['reviews'];
			} else {
				$rating = false;
				$reviews = false;
			}

			$labels = array();

			if (($this->config->get('module_label_status') == 1) && $show_label) {
				$labels_array = $this->model_catalog_product->getProductLabels($product['product_id']);

				foreach ($labels_array as $label) {
					$labels[] = array(
						'name'			=> $label['name'],
						'color'			=> $label['label_color'],
						'color_text'	=> $label['label_color_text']
					);
				}
			}

			$json['products'][] = array(
				'labels'			=> $labels,
				'reviews'			=> $reviews,
				'product_id'		=> $product['product_id'],
				'image'				=> $image,
				'name'				=> $product['name'],
				'description'		=> $show_description ? utf8_substr(trim(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8'))), 0, $length_description) . '...' : false,
				'price'				=> $price,
				'special'			=> $special,
				'percent_discount'	=> $percent_discount,
				'tax'				=> $tax,
				'rating'			=> $filter_rating ? $product['rating'] : false,
				'href'				=> $this->url->link('product/product', '&product_id=' . $product['product_id'])
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}