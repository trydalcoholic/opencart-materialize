<?php
class ControllerExtensionMaterializeProductProduct extends Controller {
	public function index() {
		return false;
	}

	public function updatePrice() {
		$json = array();

		$this->load->model('catalog/product');
		$this->load->model('extension/materialize/catalog/product');

		$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		$option_price = 0;

		if (isset($this->request->post['option']) && $this->request->post['option']) {
			foreach($this->request->post['option'] as $product_option_id => $value) {
				$result = $this->model_extension_materialize_catalog_product->getUpdateOptionsList($this->request->get['product_id'], $product_option_id);
				if ($result) {
					if ($result['type'] == 'select' || $result['type'] == 'radio') {
						$option_values = $this->model_extension_materialize_catalog_product->getUpdateOptionValues($value, $product_option_id);
						if ($option_values) {
							if ($option_values['price_prefix'] == '+') {
								$option_price += $option_values['price'];
							} elseif ($option_values['price_prefix'] == '-') {
								$option_price -= $option_values['price'];
							}
						}
					} elseif ($result['type'] == 'checkbox' && is_array($value)) {
						foreach ($value as $product_option_value_id) {
							$option_values = $this->model_extension_materialize_catalog_product->getUpdateOptionChcekboxValues($product_option_value_id, $product_option_id);
							if($option_values) {
								if ($option_values['price_prefix'] == '+') {
									$option_price += $option_values['price'];
								} elseif ($option_values['price_prefix'] == '-') {
									$option_price -= $option_values['price'];
								}
							}
						}
					}
				}
			}
		}

		$price = $product_info['price'];
		$new_price_found = 0;

		$discount_amount = $this->model_extension_materialize_catalog_product->getDiscountAmountForUpdatePrice($this->request->get['product_id'], $this->request->post['quantity']);

		if ($discount_amount) {
			$price = $discount_amount;
		}

		if ($product_info['special']) {
			$price = $product_info['special'];
			$new_price_found = 1;
		}

		$total_price = $price + $option_price;

		$unit_price = $this->tax->calculate($total_price, $product_info['tax_class_id'], $this->config->get('config_tax'));
		$total = $this->currency->format($unit_price * $this->request->post['quantity'], $this->session->data['currency']);

		$unit_tax = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
		$tax_total = $this->currency->format(((float)$product_info['special'] ? ($product_info['special'] + $option_price) : ($product_info['price'] + $option_price)) * $this->request->post['quantity'], $this->session->data['currency']);

		$json['total_price'] = $total;
		$json['new_price_found'] = $new_price_found;
		$json['tax_price'] = $tax_total;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}