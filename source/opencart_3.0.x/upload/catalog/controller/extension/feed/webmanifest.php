<?php
class ControllerExtensionFeedWebmanifest extends Controller {
	public function index() {
		$materialize_settings = $this->config->get('theme_materialize_settings');
		$manifest_dynamic = $this->config->get('theme_materialize_webmanifest_dynamic');
		$language_id = $this->config->get('config_language_id');

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

		if (!empty($materialize_settings['favicon']['manifest']['image'])) {
			$this->load->model('tool/image');

			$manifest_image = $materialize_settings['favicon']['manifest']['image'];

			$icon = (DIR_IMAGE . $manifest_image);
			$info = getimagesize($icon);
			$icon_type = isset($info['mime']) ? $info['mime'] : '';

			$icons[] = array(
				'src'	=> $this->model_tool_image->resize($manifest_image, 144, 144),
				'sizes'	=> '144x144',
				'type'	=> $icon_type
			);

			$icons[] = array(
				'src'	=> $this->model_tool_image->resize($manifest_image, 192, 192),
				'sizes'	=> '192x192',
				'type'	=> $icon_type
			);

			$icons[] = array(
				'src'	=> $this->model_tool_image->resize($manifest_image, 512, 512),
				'sizes'	=> '512x512',
				'type'	=> $icon_type
			);
		} else {
			$icons = '';
		}

		$manifest  = '{';
		$manifest .= '  "name": "' . $manifest_dynamic[$language_id]['name'] . '",';
		$manifest .= '  "short_name": "' . $manifest_dynamic[$language_id]['short_name'] . '",';
		$manifest .= '  "description": "' . $manifest_dynamic[$language_id]['description'] . '",';
		$manifest .= '  "lang": "' . $this->language->get('code') . '",';
		$manifest .= '  "dir": "' . $this->language->get('direction') . '",';
		$manifest .= '  "start_url": "' . $manifest_dynamic[$language_id]['start_url'] . '",';

		if (!empty($icons)) {
			$manifest .= '  "icons": [';
			for ($i = 0; $i < count($icons); $i++) {
				if ($i < (count($icons) - 1)) {
					$manifest .= '    {';
					$manifest .= '      "src": "' . $icons[$i]['src'] . '",';
					$manifest .= '      "sizes": "' . $icons[$i]['sizes'] . '",';
					$manifest .= '      "type": "' . $icons[$i]['type'] . '"';
					$manifest .= '    },';
				} else {
					$manifest .= '    {';
					$manifest .= '      "src": "' . $icons[$i]['src'] . '",';
					$manifest .= '      "sizes": "' . $icons[$i]['sizes'] . '",';
					$manifest .= '      "type": "' . $icons[$i]['type'] . '"';
					$manifest .= '    }';
				}
			}
			$manifest .= '  ],';
		}

		$manifest .= '  "prefer_related_applications": false,';
		$manifest .= '  "display": "' . $materialize_settings['favicon']['manifest']['display'] . '",';
		$manifest .= '  "orientation": "' . $materialize_settings['favicon']['manifest']['orientation'] . '",';
		$manifest .= '  "background_color": "#' . $materialize_settings['favicon']['manifest']['background_color']['hex'] . '",';
		$manifest .= '  "theme_color": "' . $colors['browser_bar_hex'] . '"';
		$manifest .= '}';

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput($manifest);
	}
}