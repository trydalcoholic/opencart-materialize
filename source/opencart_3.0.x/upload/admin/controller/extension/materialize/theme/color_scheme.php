<?php
class ControllerExtensionMaterializeThemeColorScheme extends Controller {
	public function index($scheme_id) {
		$this->load->language('extension/theme/materialize');
		$this->load->language('extension/materialize/materialize');

		$this->load->model('extension/materialize/materialize');

		$data['theme_materialize_get_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();

		$data['theme_materialize_get_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

		$data['total_schemes'] = $this->model_extension_materialize_materialize->getTotalMaterializeColorSchemes();

		$data['color_schemes'] = array();

		if (!empty($scheme_id)) {
			$scheme_info = $this->model_extension_materialize_materialize->getMaterializeColorScheme($scheme_id);

			$data['agsajsghasjg'] = $scheme_info;

			$data['color_schemes']['custom_scheme']['title'] = $scheme_info['title'];

			$data['color_schemes']['custom_scheme']['name'] = $scheme_info['name'];

			$data['color_schemes']['custom_scheme']['hex'] = $scheme_info['hex'];

			$data['color_schemes']['custom_scheme']['value'] = $scheme_info['value'];
		} else {
			$data['color_schemes']['custom_scheme']['title'] = 'Custom Scheme';

			$data['color_schemes']['custom_scheme']['name'] = 'white';

			$data['color_schemes']['custom_scheme']['hex'] = '#ffffff';

			$data['color_schemes']['custom_scheme']['value'] = array(
				'background'				=> 'white',
				'add_cart'					=> 'white',
				'add_cart_text'				=> 'black-text',
				'more_detailed'				=> 'white',
				'more_detailed_text'		=> 'black-text',
				'cart_btn'					=> 'white',
				'cart_btn_text'				=> 'black-text',
				'total_btn'					=> 'white',
				'total_btn_text'			=> 'black-text',
				'compare_btn'				=> 'white',
				'compare_btn_text'			=> 'black-text',
				'compare_total_btn'			=> 'white',
				'compare_total_btn_text'	=> 'black-text',
				'btt_btn'					=> 'white',
				'btt_btn_text'				=> 'black-text',
				'browser_bar'				=> 'white',
				'browser_bar_hex'			=> '#ffffff',
				'mobile_menu'				=> 'white',
				'mobile_menu_hex'			=> '#ffffff',
				'mobile_menu_text'			=> 'black-text',
				'top_menu'					=> 'white',
				'top_menu_text'				=> 'black-text',
				'header'					=> 'white',
				'header_text'				=> 'black-text',
				'navigation'				=> 'white',
				'navigation_text'			=> 'black-text',
				'search'					=> 'white',
				'search_text'				=> 'black-text',
				'sidebar'					=> 'white',
				'sidebar_text'				=> 'black-text',
				'mobile_search'				=> 'white',
				'footer'					=> 'white',
				'footer_text'				=> 'black-text',
			);
		}

		return $this->load->view('extension/materialize/theme/color_scheme', $data);
	}
}