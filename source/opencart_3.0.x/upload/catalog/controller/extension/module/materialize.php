<?php
class ControllerExtensionModuleMaterialize extends Controller {
	public function index() {
		return false;
	}

	public function colorScheme($route, &$data) {
		if ($this->config->get('theme_materialize_status') == 1) {
			$materialize_settings = $this->config->get('theme_materialize_settings');

			if (!empty($materialize_settings['optimization']['cached_colors'])) {
				$cached_colors = true;
			} else {
				$cached_colors = false;
			}

			if ($cached_colors) {
				$colors = $this->cache->get('materialize.colors');

				if (!$colors) {
					$this->load->model('extension/module/materialize');

					$colors = $this->model_extension_module_materialize->getColorScheme($materialize_settings['color_scheme_id']);

					$this->cache->set('materialize.colors', $colors);
				}
			} else {
				$this->load->model('extension/module/materialize');

				$colors = $this->model_extension_module_materialize->getColorScheme($materialize_settings['color_scheme_id']);
			}

			$data['color_browser_bar'] = $colors['browser_bar_hex'];
			$data['color_background'] = $colors['background'];
			$data['color_top_menu'] = $colors['top_menu'];
			$data['color_top_menu_text'] = $colors['top_menu_text'];
			$data['color_header'] = $colors['header'];
			$data['color_header_text'] = $colors['header_text'];
			$data['color_mobile_menu'] = $colors['mobile_menu_hex'];
			$data['color_mobile_menu_text'] = $colors['mobile_menu_text'];
			$data['color_sidebar'] = $colors['sidebar'];
			$data['color_sidebar_text'] = $colors['sidebar_text'];
			$data['color_btt'] = $colors['btt_btn'];
			$data['color_btt_text'] = $colors['btt_btn_text'];
			$data['color_compare'] = $colors['compare_btn'];
			$data['color_compare_text'] = $colors['compare_btn_text'];
			$data['color_compare_total'] = $colors['compare_total_btn'];
			$data['color_compare_total_text'] = $colors['compare_total_btn_text'];
			$data['color_navigation'] = $colors['navigation'];
			$data['color_navigation_text'] = $colors['navigation_text'];
			$data['color_cart'] = $colors['cart_btn'];
			$data['color_cart_text'] = $colors['cart_btn_text'];
			$data['color_cart_total'] = $colors['total_btn'];
			$data['color_cart_total_text'] = $colors['total_btn_text'];
			$data['color_header'] = $colors['header'];
			$data['color_search'] = $colors['search'];
			$data['color_search_text'] = $colors['search_text'];
			$data['color_footer'] = $colors['footer'];
			$data['color_footer_text'] = $colors['footer_text'];
			$data['color_more_detailed'] = $colors['more_detailed'];
			$data['color_more_detailed_text'] = $colors['more_detailed_text'];
			$data['color_add_cart'] = $colors['add_cart'];
			$data['color_add_cart_text'] = $colors['add_cart_text'];
		} else {
			return false;
		}
	}
}