<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ControllerExtensionMTMaterializeProductProduct extends Controller {
	public function setProductDisplay() {
		if (!empty($this->request->post['product_display'])) {
			unset($this->session->data['product_display']);

			$this->session->data['product_display'] = $this->request->post['product_display'];
		}
	}

	public function getProductDisplay() {
		if (isset($this->session->data['product_display'])) {
			$product_display = $this->session->data['product_display'];
		} else {
			$product_display = 'grid';
		}

		return $product_display;
	}
}