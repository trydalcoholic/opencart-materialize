<?php
class ControllerExtensionFeedWebManifest extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/feed/google_sitemap');

		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('localisation/language');
		$this->load->model('extension/materialize/materialize');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$webmanifest_info = $this->model_setting_setting->getSetting('feed_webmanifest');
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ($this->request->post['feed_webmanifest_status'] == true) {
				if (empty($webmanifest_info['feed_webmanifest_setting']['icons'])) {
					if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
						$this->load->model('tool/image');

						$icon = (DIR_IMAGE . $this->config->get('config_icon'));
						$info = getimagesize($icon);
						$icon_type = isset($info['mime']) ? $info['mime'] : '';

						$icons[] = array(
							'src'	=> $this->model_tool_image->resize($this->config->get('config_icon'), 192, 192),
							'sizes'	=> '192x192',
							'type'	=> $icon_type
						);

						$icons[] = array(
							'src'	=> $this->model_tool_image->resize($this->config->get('config_icon'), 512, 512),
							'sizes'	=> '512x512',
							'type'	=> $icon_type
						);

						$this->request->post['feed_webmanifest_setting']['icons'] = $icons;
					} else {
						$icons = '';
					}
				} else {
					$icons = $webmanifest_info['feed_webmanifest_setting']['icons'];
				}

				$manifest  = '{';
				$manifest .= '  "name": "' . $this->request->post['feed_webmanifest_setting']['description']['name'] . '",';
				$manifest .= '  "short_name": "' . $this->request->post['feed_webmanifest_setting']['description']['short_name'] . '",';
				$manifest .= '  "description": "' . $this->request->post['feed_webmanifest_setting']['description']['description'] . '",';

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

				$manifest .= '  "lang": "en",';
				$manifest .= '  "dir": "ltr",';
				$manifest .= '  "start_url": "' . $this->request->post['feed_webmanifest_setting']['description']['start_url'] . '",';
				$manifest .= '  "display": "' . $this->request->post['feed_webmanifest_setting']['display'] . '",';
				$manifest .= '  "orientation": "' . $this->request->post['feed_webmanifest_setting']['orientation'] . '",';
				$manifest .= '  "background_color": "#' . $this->request->post['feed_webmanifest_setting']['background_color']['hex'] . '",';
				$manifest .= '  "theme_color": "#' . $this->request->post['feed_webmanifest_setting']['theme_color']['hex'] . '",';
				$manifest .= '  "author": {';
				$manifest .= '    "name": "Semenov Anton",';
				$manifest .= '    "website": "https://openpixel.ru/",';
				$manifest .= '    "github": "https://github.com/trydalcoholic",';
				$manifest .= '    "source-repo": "https://github.com/trydalcoholic/opencart-materialize"';
				$manifest .= '  }';
				$manifest .= '}';

				$file = DIR_CATALOG . "view/theme/materialize/js/manifest.json";

				if (file_exists($file)) {
					unlink($file);
				}

				if (!file_exists($file)) {
					$fp = fopen($file, "w");
					fwrite($fp, ltrim($manifest));
					fclose($fp);
				}
			} else {
				$file = DIR_CATALOG . "view/theme/materialize/js/manifest.json";

				if (file_exists($file)) {
					unlink($file);
				}
			}

			$this->model_setting_setting->editSetting('feed_webmanifest', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=feed', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['short_name'])) {
			$data['error_short_name'] = $this->error['short_name'];
		} else {
			$data['error_short_name'] = array();
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}

		if (isset($this->error['start_url'])) {
			$data['error_start_url'] = $this->error['start_url'];
		} else {
			$data['error_start_url'] = array();
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_home'),
			'href'	=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('text_extension'),
			'href'	=> $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=feed', true)
		);

		$data['breadcrumbs'][] = array(
			'text'	=> $this->language->get('heading_title'),
			'href'	=> $this->url->link('extension/feed/webmanifest', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/feed/webmanifest', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=feed', true);

		if (isset($this->request->post['feed_webmanifest_setting'])) {
			$data['feed_webmanifest_setting'] = $this->request->post['feed_webmanifest_setting'];
		} elseif (!empty($webmanifest_info['feed_webmanifest_setting'])) {
			$data['feed_webmanifest_setting'] = $webmanifest_info['feed_webmanifest_setting'];
		} else {
			$data['feed_webmanifest_setting'] = array();

			$data['feed_webmanifest_setting']['background_color'] = array(
				'color'	=> 'blue-grey darken-4',
				'hex'	=> '263238'
			);

			$data['feed_webmanifest_setting']['theme_color'] = array(
				'color'	=> 'blue-grey darken-3',
				'hex'	=> '37474f'
			);
		}

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['materialize_get_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();

		$data['feed_webmanifest_setting']['display_value'] = array(
			'fullscreen',
			'standalone',
			'minimal-ui',
			'browser',
		);

		$data['feed_webmanifest_setting']['orientation_value'] = array(
			'any',
			'natural',
			'landscape',
			'landscape-primary',
			'landscape-secondary',
			'portrait',
			'portrait-primary',
			'portrait-secondary',
		);

		$data['feed_webmanifest_setting']['related_applications_value'] = array(
			'platform'	=> array(
				'play',
				'itunes',
			),
			'url',
			'id',
		);

		if (isset($this->request->post['feed_webmanifest_status'])) {
			$data['feed_webmanifest_status'] = $this->request->post['feed_webmanifest_status'];
		} else {
			$data['feed_webmanifest_status'] = $this->config->get('feed_webmanifest_status');
		}

		if (!empty($webmanifest_info['feed_webmanifest_setting']['icons'])) {
			$data['test'] = $webmanifest_info['feed_webmanifest_setting']['icons'];
		} else {
			$data['test'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/feed/webmanifest', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/feed/webmanifest')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['feed_webmanifest_status'] == 1) {
			if ((utf8_strlen($this->request->post['feed_webmanifest_setting']['description']['name']) < 1) || (utf8_strlen($this->request->post['feed_webmanifest_setting']['description']['name']) > 45)) {
				$this->error['name'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['feed_webmanifest_setting']['description']['short_name']) < 1) || (utf8_strlen($this->request->post['feed_webmanifest_setting']['description']['short_name']) > 12)) {
				$this->error['short_name'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['feed_webmanifest_setting']['description']['description']) < 1) || (utf8_strlen($this->request->post['feed_webmanifest_setting']['description']['description']) > 1024)) {
				$this->error['description'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['feed_webmanifest_setting']['description']['start_url']) < 1) || (utf8_strlen($this->request->post['feed_webmanifest_setting']['description']['start_url']) > 512)) {
				$this->error['start_url'] = $this->language->get('error_name');
			}
		}

		return !$this->error;
	}
}