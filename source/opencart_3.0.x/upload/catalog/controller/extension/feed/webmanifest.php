<?php
class ControllerExtensionFeedWebmanifest extends Controller {
	public function index() {
		if ($this->config->get('feed_webmanifest_status') == 1) {
			$manifest_settings = $this->config->get('feed_webmanifest_setting');
			$manifest_dynamic = $this->config->get('feed_webmanifest_dynamic');

			$language_id = $this->config->get('config_language_id');

			if ($manifest_settings['icons']) {
				$icons = $manifest_settings['icons'];
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

			$manifest .= '  "display": "' . $manifest_settings['display'] . '",';
			$manifest .= '  "orientation": "' . $manifest_settings['orientation'] . '",';
			$manifest .= '  "background_color": "#' . $manifest_settings['background_color']['hex'] . '",';
			$manifest .= '  "theme_color": "#' . $manifest_settings['theme_color']['hex'] . '",';
			$manifest .= '  "author": {';
			$manifest .= '    "name": "Semenov Anton",';
			$manifest .= '    "website": "https://openpixel.ru/",';
			$manifest .= '    "github": "https://github.com/trydalcoholic",';
			$manifest .= '    "source-repo": "https://github.com/trydalcoholic/opencart-materialize"';
			$manifest .= '  }';
			$manifest .= '}';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput($manifest);
	}
}