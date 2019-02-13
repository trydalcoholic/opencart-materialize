<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ControllerExtensionMTMaterializeAppealAppeal extends Controller {
	public function footer() {
		$this->load->language('extension/mt_materialize/appeal/appeal');

		$data['materialize_template'] = '<i class="fab fa-opencart"></i> <a href="//www.opencart.com/index.php?route=marketplace/extension/info&extension_id=30715" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" data-toggle="popover" title="<strong>Materialize Template</strong>" data-content="' . $this->language->get('appeal_marketplace') . '"><strong>Materialize Template</strong></a>';
		$data['patreon'] = '<i class="fab fa-patreon"></i> <a href="//www.patreon.com/opencart_materialize" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" data-toggle="popover" title="<strong>Patreon</strong>" data-content="' . $this->language->get('appeal_patreon') . '"><strong>Patreon</strong></a>';
		$data['github'] = '<i class="fab fa-github"></i> <a href="//github.com/trydalcoholic/opencart-materialize" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" data-toggle="popover" title="<strong>GitHub</strong>" data-content="' . $this->language->get('appeal_github') . '">GitHub</a>';
		$data['twitter'] = '<i class="fab fa-twitter"></i> <a href="//twitter.com/trydalcoholic" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" data-toggle="popover" title="<strong>Twitter</strong>" data-content="' . $this->language->get('appeal_twitter') . '">Twitter</a>';
		$data['paypal'] = '<i class="fab fa-paypal"></i> <a href="//www.paypal.me/trydalcoholic" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" data-toggle="popover" title="<strong>PayPal</strong>" data-content="' . $this->language->get('appeal_paypal') . '">PayPal</a>';
		$data['yandex'] = '<i class="fab fa-yandex-international"></i> <a href="//money.yandex.ru/to/41001413377821" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" data-toggle="popover" title="<strong>Yandex.Money</strong>" data-content="' . $this->language->get('appeal_yandex_money') . '">Yandex.Money</a>';

		return $this->load->view('extension/mt_materialize/appeal/mt_footer', $data);
	}
}