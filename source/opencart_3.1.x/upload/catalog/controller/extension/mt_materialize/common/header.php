<?php
/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

class ControllerExtensionMTMaterializeCommonHeader extends Controller {
	public function index(&$route, &$data) {
		$data['email'] = $this->config->get('config_email');
		$data['open'] = nl2br($this->config->get('config_open'));
		$data['formatted_telephone'] = str_replace(['(',')',' '],'', $data['telephone']);
	}
}