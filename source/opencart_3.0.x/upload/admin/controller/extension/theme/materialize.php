<?php
class ControllerExtensionThemeMaterialize extends Controller {
	private $error = array();

	public function install() {
		$this->load->model('extension/materialize/materialize');
		$this->load->model('user/user_group');
		$this->load->model('setting/setting');

		$this->model_extension_materialize_materialize->install();

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/materialize');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/materialize');

		$data['theme_materialize_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('theme_materialize', $data);
	}

	public function uninstall() {
		$this->load->model('extension/materialize/materialize');
		$this->load->model('user/user_group');

		$this->model_extension_materialize_materialize->uninstall();

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/materialize');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/materialize');

		$cached_categories = $this->cache->get('materialize.categories');
		$cached_colors = $this->cache->get('materialize.colors');

		if ($cached_categories) {
			$this->cache->delete('materialize.categories');
		}

		if ($cached_colors) {
			$this->cache->delete('materialize.colors');
		}
	}

	public function index() {
		$this->load->language('extension/theme/materialize');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('materialize_title'));
		$this->document->addScript('view/javascript/codemirror/lib/codemirror.js');
		$this->document->addScript('view/javascript/codemirror/lib/xml.js');
		$this->document->addScript('view/javascript/codemirror/lib/formatting.js');
		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addScript('view/javascript/summernote/summernote-image-attributes.js');
		$this->document->addScript('view/javascript/summernote/opencart.js');
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/codemirror/lib/codemirror.css');
		$this->document->addStyle('view/javascript/codemirror/theme/monokai.css');
		$this->document->addStyle('view/javascript/summernote/summernote.css');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('setting/setting');

		$this->load->model('tool/image');

		$this->load->model('extension/materialize/materialize');

		$this->load->model('localisation/language');

		$this->load->model('catalog/information');

		if (isset($this->request->get['store_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$setting_info = $this->model_setting_setting->getSetting('theme_materialize', $this->request->get['store_id']);

			$dynamic_manifest_info = $this->config->get('theme_materialize_webmanifest_dynamic');
		}

		$check_update = $this->model_extension_materialize_materialize->checkUpdate();

		if ($check_update == false) {
			$data['theme_materialize_updates_appeal'] = true;
		} else {
			$data['theme_materialize_updates_appeal'] = false;
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && $this->validateManifest() && $this->validateBrowserconfig()) {
			$theme_status = $this->request->post['theme_materialize_status'];
			$materialize_settings = $this->request->post['theme_materialize_settings'];

			if (empty($theme_status) || empty($materialize_settings['optimization']['cached_categories'])) {
				$cached_categories = $this->cache->get('materialize.categories');

				if ($cached_categories) {
					$this->cache->delete('materialize.categories');
				}
			}

			if (empty($theme_status) || empty($materialize_settings['optimization']['cached_colors'])) {
				$cached_colors = $this->cache->get('materialize.colors');

				if ($cached_colors) {
					$this->cache->delete('materialize.colors');
				}
			}

			$this->model_setting_setting->editSetting('theme_materialize', $this->request->post, $this->request->get['store_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->get['apply'])) {
				$this->response->redirect($this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'], true));
			} else {
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme', true));
			}
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['product_limit'])) {
			$data['error_product_limit'] = $this->error['product_limit'];
		} else {
			$data['error_product_limit'] = '';
		}

		if (isset($this->error['product_description_length'])) {
			$data['error_product_description_length'] = $this->error['product_description_length'];
		} else {
			$data['error_product_description_length'] = '';
		}

		if (isset($this->error['image_category'])) {
			$data['error_image_category'] = $this->error['image_category'];
		} else {
			$data['error_image_category'] = '';
		}

		if (isset($this->error['image_thumb'])) {
			$data['error_image_thumb'] = $this->error['image_thumb'];
		} else {
			$data['error_image_thumb'] = '';
		}

		if (isset($this->error['image_popup'])) {
			$data['error_image_popup'] = $this->error['image_popup'];
		} else {
			$data['error_image_popup'] = '';
		}

		if (isset($this->error['image_product'])) {
			$data['error_image_product'] = $this->error['image_product'];
		} else {
			$data['error_image_product'] = '';
		}

		if (isset($this->error['image_additional'])) {
			$data['error_image_additional'] = $this->error['image_additional'];
		} else {
			$data['error_image_additional'] = '';
		}

		if (isset($this->error['image_related'])) {
			$data['error_image_related'] = $this->error['image_related'];
		} else {
			$data['error_image_related'] = '';
		}

		if (isset($this->error['image_compare'])) {
			$data['error_image_compare'] = $this->error['image_compare'];
		} else {
			$data['error_image_compare'] = '';
		}

		if (isset($this->error['image_wishlist'])) {
			$data['error_image_wishlist'] = $this->error['image_wishlist'];
		} else {
			$data['error_image_wishlist'] = '';
		}

		if (isset($this->error['image_cart'])) {
			$data['error_image_cart'] = $this->error['image_cart'];
		} else {
			$data['error_image_cart'] = '';
		}

		if (isset($this->error['image_location'])) {
			$data['error_image_location'] = $this->error['image_location'];
		} else {
			$data['error_image_location'] = '';
		}

		if (isset($this->error['adult_content'])) {
			$data['error_adult_content'] = $this->error['adult_content'];
		} else {
			$data['error_adult_content'] = '';
		}

		if (isset($this->error['manifest_name'])) {
			$data['error_manifest_name'] = $this->error['manifest_name'];
		} else {
			$data['error_manifest_name'] = '';
		}

		if (isset($this->error['manifest_short_name'])) {
			$data['error_manifest_short_name'] = $this->error['manifest_short_name'];
		} else {
			$data['error_manifest_short_name'] = '';
		}

		if (isset($this->error['manifest_description'])) {
			$data['error_manifest_description'] = $this->error['manifest_description'];
		} else {
			$data['error_manifest_description'] = '';
		}

		if (isset($this->error['manifest_start_url'])) {
			$data['error_manifest_start_url'] = $this->error['manifest_start_url'];
		} else {
			$data['error_manifest_start_url'] = '';
		}

		if (isset($this->error['manifest_dynamic_name'])) {
			$data['error_dynamic_name'] = $this->error['manifest_dynamic_name'];
		} else {
			$data['error_dynamic_name'] = array();
		}

		if (isset($this->error['manifest_dynamic_short_name'])) {
			$data['error_dynamic_short_name'] = $this->error['manifest_dynamic_short_name'];
		} else {
			$data['error_dynamic_short_name'] = array();
		}

		if (isset($this->error['manifest_dynamic_description'])) {
			$data['error_dynamic_description'] = $this->error['manifest_dynamic_description'];
		} else {
			$data['error_dynamic_description'] = array();
		}

		if (isset($this->error['manifest_dynamic_start_url'])) {
			$data['error_dynamic_start_url'] = $this->error['manifest_dynamic_start_url'];
		} else {
			$data['error_dynamic_start_url'] = array();
		}

		if (isset($this->error['browserconfig_image'])) {
			$data['error_browserconfig_image'] = $this->error['browserconfig_image'];
		} else {
			$data['error_browserconfig_image'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'], true)
		);

		$data['action'] = $this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'], true);

		$data['apply'] = $this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'] . '&apply', true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme', true);

		$data['theme_materialize_directory'] = 'materialize';

		if (isset($this->request->post['theme_materialize_installed_appeal'])) {
			$data['theme_materialize_installed_appeal'] = $this->request->post['theme_materialize_installed_appeal'];
		} else {
			$data['theme_materialize_installed_appeal'] = $this->config->get('theme_materialize_installed_appeal');
		}

		if (isset($this->request->post['theme_materialize_status'])) {
			$data['theme_materialize_status'] = $this->request->post['theme_materialize_status'];
		} elseif (isset($setting_info['theme_materialize_status'])) {
			$data['theme_materialize_status'] = $setting_info['theme_materialize_status'];
		} else {
			$data['theme_materialize_status'] = '';
		}

		if (isset($this->request->post['theme_materialize_product_limit'])) {
			$data['theme_materialize_product_limit'] = $this->request->post['theme_materialize_product_limit'];
		} elseif (isset($setting_info['theme_materialize_product_limit'])) {
			$data['theme_materialize_product_limit'] = $setting_info['theme_materialize_product_limit'];
		} else {
			$data['theme_materialize_product_limit'] = 18;
		}

		if (isset($this->request->post['theme_materialize_product_description_length'])) {
			$data['theme_materialize_product_description_length'] = $this->request->post['theme_materialize_product_description_length'];
		} elseif (isset($setting_info['theme_materialize_product_description_length'])) {
			$data['theme_materialize_product_description_length'] = $setting_info['theme_materialize_product_description_length'];
		} else {
			$data['theme_materialize_product_description_length'] = 400;
		}

		if (isset($this->request->post['theme_materialize_image_category_width'])) {
			$data['theme_materialize_image_category_width'] = $this->request->post['theme_materialize_image_category_width'];
		} elseif (isset($setting_info['theme_materialize_image_category_width'])) {
			$data['theme_materialize_image_category_width'] = $setting_info['theme_materialize_image_category_width'];
		} else {
			$data['theme_materialize_image_category_width'] = 100;
		}

		if (isset($this->request->post['theme_materialize_image_category_height'])) {
			$data['theme_materialize_image_category_height'] = $this->request->post['theme_materialize_image_category_height'];
		} elseif (isset($setting_info['theme_materialize_image_category_height'])) {
			$data['theme_materialize_image_category_height'] = $setting_info['theme_materialize_image_category_height'];
		} else {
			$data['theme_materialize_image_category_height'] = 100;
		}

		if (isset($this->request->post['theme_materialize_image_thumb_width'])) {
			$data['theme_materialize_image_thumb_width'] = $this->request->post['theme_materialize_image_thumb_width'];
		} elseif (isset($setting_info['theme_materialize_image_thumb_width'])) {
			$data['theme_materialize_image_thumb_width'] = $setting_info['theme_materialize_image_thumb_width'];
		} else {
			$data['theme_materialize_image_thumb_width'] = 250;
		}

		if (isset($this->request->post['theme_materialize_image_thumb_height'])) {
			$data['theme_materialize_image_thumb_height'] = $this->request->post['theme_materialize_image_thumb_height'];
		} elseif (isset($setting_info['theme_materialize_image_thumb_height'])) {
			$data['theme_materialize_image_thumb_height'] = $setting_info['theme_materialize_image_thumb_height'];
		} else {
			$data['theme_materialize_image_thumb_height'] = 250;
		}

		if (isset($this->request->post['theme_materialize_image_popup_width'])) {
			$data['theme_materialize_image_popup_width'] = $this->request->post['theme_materialize_image_popup_width'];
		} elseif (isset($setting_info['theme_materialize_image_popup_width'])) {
			$data['theme_materialize_image_popup_width'] = $setting_info['theme_materialize_image_popup_width'];
		} else {
			$data['theme_materialize_image_popup_width'] = 1200;
		}

		if (isset($this->request->post['theme_materialize_image_popup_height'])) {
			$data['theme_materialize_image_popup_height'] = $this->request->post['theme_materialize_image_popup_height'];
		} elseif (isset($setting_info['theme_materialize_image_popup_height'])) {
			$data['theme_materialize_image_popup_height'] = $setting_info['theme_materialize_image_popup_height'];
		} else {
			$data['theme_materialize_image_popup_height'] = 1200;
		}

		if (isset($this->request->post['theme_materialize_image_product_width'])) {
			$data['theme_materialize_image_product_width'] = $this->request->post['theme_materialize_image_product_width'];
		} elseif (isset($setting_info['theme_materialize_image_product_width'])) {
			$data['theme_materialize_image_product_width'] = $setting_info['theme_materialize_image_product_width'];
		} else {
			$data['theme_materialize_image_product_width'] = 200;
		}

		if (isset($this->request->post['theme_materialize_image_product_height'])) {
			$data['theme_materialize_image_product_height'] = $this->request->post['theme_materialize_image_product_height'];
		} elseif (isset($setting_info['theme_materialize_image_product_height'])) {
			$data['theme_materialize_image_product_height'] = $setting_info['theme_materialize_image_product_height'];
		} else {
			$data['theme_materialize_image_product_height'] = 200;
		}

		if (isset($this->request->post['theme_materialize_image_additional_width'])) {
			$data['theme_materialize_image_additional_width'] = $this->request->post['theme_materialize_image_additional_width'];
		} elseif (isset($setting_info['theme_materialize_image_additional_width'])) {
			$data['theme_materialize_image_additional_width'] = $setting_info['theme_materialize_image_additional_width'];
		} else {
			$data['theme_materialize_image_additional_width'] = 100;
		}

		if (isset($this->request->post['theme_materialize_image_additional_height'])) {
			$data['theme_materialize_image_additional_height'] = $this->request->post['theme_materialize_image_additional_height'];
		} elseif (isset($setting_info['theme_materialize_image_additional_height'])) {
			$data['theme_materialize_image_additional_height'] = $setting_info['theme_materialize_image_additional_height'];
		} else {
			$data['theme_materialize_image_additional_height'] = 100;
		}

		if (isset($this->request->post['theme_materialize_image_related_width'])) {
			$data['theme_materialize_image_related_width'] = $this->request->post['theme_materialize_image_related_width'];
		} elseif (isset($setting_info['theme_materialize_image_related_width'])) {
			$data['theme_materialize_image_related_width'] = $setting_info['theme_materialize_image_related_width'];
		} else {
			$data['theme_materialize_image_related_width'] = 200;
		}

		if (isset($this->request->post['theme_materialize_image_related_height'])) {
			$data['theme_materialize_image_related_height'] = $this->request->post['theme_materialize_image_related_height'];
		} elseif (isset($setting_info['theme_materialize_image_related_height'])) {
			$data['theme_materialize_image_related_height'] = $setting_info['theme_materialize_image_related_height'];
		} else {
			$data['theme_materialize_image_related_height'] = 200;
		}

		if (isset($this->request->post['theme_materialize_image_compare_width'])) {
			$data['theme_materialize_image_compare_width'] = $this->request->post['theme_materialize_image_compare_width'];
		} elseif (isset($setting_info['theme_materialize_image_compare_width'])) {
			$data['theme_materialize_image_compare_width'] = $setting_info['theme_materialize_image_compare_width'];
		} else {
			$data['theme_materialize_image_compare_width'] = 90;
		}

		if (isset($this->request->post['theme_materialize_image_compare_height'])) {
			$data['theme_materialize_image_compare_height'] = $this->request->post['theme_materialize_image_compare_height'];
		} elseif (isset($setting_info['theme_materialize_image_compare_height'])) {
			$data['theme_materialize_image_compare_height'] = $setting_info['theme_materialize_image_compare_height'];
		} else {
			$data['theme_materialize_image_compare_height'] = 90;
		}

		if (isset($this->request->post['theme_materialize_image_wishlist_width'])) {
			$data['theme_materialize_image_wishlist_width'] = $this->request->post['theme_materialize_image_wishlist_width'];
		} elseif (isset($setting_info['theme_materialize_image_wishlist_width'])) {
			$data['theme_materialize_image_wishlist_width'] = $setting_info['theme_materialize_image_wishlist_width'];
		} else {
			$data['theme_materialize_image_wishlist_width'] = 75;
		}

		if (isset($this->request->post['theme_materialize_image_wishlist_height'])) {
			$data['theme_materialize_image_wishlist_height'] = $this->request->post['theme_materialize_image_wishlist_height'];
		} elseif (isset($setting_info['theme_materialize_image_wishlist_height'])) {
			$data['theme_materialize_image_wishlist_height'] = $setting_info['theme_materialize_image_wishlist_height'];
		} else {
			$data['theme_materialize_image_wishlist_height'] = 75;
		}

		if (isset($this->request->post['theme_materialize_image_cart_width'])) {
			$data['theme_materialize_image_cart_width'] = $this->request->post['theme_materialize_image_cart_width'];
		} elseif (isset($setting_info['theme_materialize_image_cart_width'])) {
			$data['theme_materialize_image_cart_width'] = $setting_info['theme_materialize_image_cart_width'];
		} else {
			$data['theme_materialize_image_cart_width'] = 75;
		}

		if (isset($this->request->post['theme_materialize_image_cart_height'])) {
			$data['theme_materialize_image_cart_height'] = $this->request->post['theme_materialize_image_cart_height'];
		} elseif (isset($setting_info['theme_materialize_image_cart_height'])) {
			$data['theme_materialize_image_cart_height'] = $setting_info['theme_materialize_image_cart_height'];
		} else {
			$data['theme_materialize_image_cart_height'] = 75;
		}

		if (isset($this->request->post['theme_materialize_image_location_width'])) {
			$data['theme_materialize_image_location_width'] = $this->request->post['theme_materialize_image_location_width'];
		} elseif (isset($setting_info['theme_materialize_image_location_width'])) {
			$data['theme_materialize_image_location_width'] = $setting_info['theme_materialize_image_location_width'];
		} else {
			$data['theme_materialize_image_location_width'] = 230;
		}

		if (isset($this->request->post['theme_materialize_image_location_height'])) {
			$data['theme_materialize_image_location_height'] = $this->request->post['theme_materialize_image_location_height'];
		} elseif (isset($setting_info['theme_materialize_image_location_height'])) {
			$data['theme_materialize_image_location_height'] = $setting_info['theme_materialize_image_location_height'];
		} else {
			$data['theme_materialize_image_location_height'] = 75;
		}

		/* Materialize template */

		$data['languages'] = $this->model_localisation_language->getLanguages();

		/*$theme_materialize = array();

		foreach ($data['languages'] as $key => $language) {
			$theme_materialize[$language['language_id']][] = $this->language->get('theme_materialize');
		}*/

		/*if (isset($this->request->post['theme_materialize'])) {
			$data['theme_materialize'] = $this->request->post['theme_materialize'];
		} elseif ($this->config->get('theme_materialize') == true) {
			$data['theme_materialize'] = $this->config->get('theme_materialize');
		} else {
			$data['theme_materialize'] = '';
		}*/

		/* Common */

		$data['informations'] = $this->model_catalog_information->getInformations();

		if (!empty($setting_info['favicon']['manifest'])) {
			$data['manifest_info'] = $setting_info['favicon']['manifest'];
		}

		if (isset($this->request->post['theme_materialize_settings'])) {
			$data['theme_materialize_settings'] = $this->request->post['theme_materialize_settings'];
		} elseif (isset($setting_info['theme_materialize_settings'])) {
			$data['theme_materialize_settings'] = $setting_info['theme_materialize_settings'];

			if (!empty($setting_info['theme_materialize_settings']['favicon']['manifest']['image'])) {
				$data['theme_materialize_manifest_thumb'] = $this->model_tool_image->resize($data['theme_materialize_settings']['favicon']['manifest']['image'], 100, 100);
			} else {
				$data['theme_materialize_manifest_thumb'] = $data['placeholder'];
			}

			if (!empty($setting_info['theme_materialize_settings']['favicon']['browserconfig']['image_small'])) {
				$data['theme_materialize_browserconfig_thumb_small'] = $this->model_tool_image->resize($data['theme_materialize_settings']['favicon']['browserconfig']['image_small'], 100, 100);
			} else {
				$data['theme_materialize_browserconfig_thumb_small'] = $data['placeholder'];
			}

			if (!empty($setting_info['theme_materialize_settings']['favicon']['browserconfig']['image_large'])) {
				$data['theme_materialize_browserconfig_thumb_large'] = $this->model_tool_image->resize($data['theme_materialize_settings']['favicon']['browserconfig']['image_large'], 100, 100);
			} else {
				$data['theme_materialize_browserconfig_thumb_large'] = $data['placeholder'];
			}
		} else {
			$data['theme_materialize_settings'] = array();

			$data['theme_materialize_settings']['header'] = array(
				'phone'			=> 'on',
				'email'			=> 'on',
				'working_hours'	=> 'on',
			);

			$data['theme_materialize_settings']['footer'] = array(
				'contact_information'	=> '',
			);

			$data['theme_materialize_settings']['social'] = array(
				'show_footer'	=> '',
				'not_index'		=> '',
				'meta_data'		=> 'on',
			);

			$data['theme_materialize_settings']['adult_content'] = array(
				'status'	=> '',
				'agreement'	=> '',
				'back_link'	=> '',
			);

			$data['theme_materialize_settings']['favicon']['browserconfig']['background_color'] = array(
				'color'	=> 'blue-grey darken-4',
				'hex'	=> '263238'
			);

			$data['theme_materialize_settings']['favicon']['manifest']['type'] = 'static';
			$data['theme_materialize_settings']['favicon']['manifest']['display'] = 'standalone';
			$data['theme_materialize_settings']['favicon']['manifest']['background_color'] = array(
				'color'	=> 'grey lighten-3',
				'hex'	=> 'eeeeee'
			);

			$data['theme_materialize_manifest_thumb'] = $data['placeholder'];
			$data['theme_materialize_browserconfig_thumb_small'] = $data['placeholder'];
			$data['theme_materialize_browserconfig_thumb_large'] = $data['placeholder'];
		}

		/* Manifest Settings */
		$data['theme_materialize_settings']['favicon']['manifest']['direction_value'] = array(
			'ltr',
			'rtl',
			'auto',
		);

		$data['theme_materialize_settings']['favicon']['manifest']['display_value'] = array(
			'fullscreen',
			'standalone',
			'minimal-ui',
			'browser',
		);

		$data['theme_materialize_settings']['favicon']['manifest']['orientation_value'] = array(
			'any',
			'natural',
			'landscape',
			'landscape-primary',
			'landscape-secondary',
			'portrait',
			'portrait-primary',
			'portrait-secondary',
		);

		if (isset($this->request->post['theme_materialize_webmanifest_dynamic'])) {
			$data['theme_materialize_webmanifest_dynamic'] = $this->request->post['theme_materialize_webmanifest_dynamic'];
		} elseif (isset($dynamic_manifest_info)) {
			$data['theme_materialize_webmanifest_dynamic'] = $dynamic_manifest_info;
		} else {
			$data['theme_materialize_webmanifest_dynamic'] = array();
		}

		/* Colors */
		$data['theme_materialize_get_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();

		$data['theme_materialize_get_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

		if (isset($this->request->post['theme_materialize_colors'])) {
			$data['theme_materialize_colors'] = $this->request->post['theme_materialize_colors'];
		} elseif (isset($setting_info['theme_materialize_colors'])) {
			$data['theme_materialize_colors'] = $setting_info['theme_materialize_colors'];
		} else {
			$data['theme_materialize_colors'] = array();

			$data['theme_materialize_colors'] = array(
				'background'				=> 'grey lighten-3',
				'add_cart'					=> 'red',
				'add_cart_text'				=> 'white-text',
				'more_detailed'				=> 'red',
				'more_detailed_text'		=> 'white-text',
				'cart_btn'					=> 'red',
				'cart_btn_text'				=> 'white-text',
				'total_btn'					=> 'light-blue darken-1',
				'total_btn_text'			=> 'white-text',
				'compare_btn'				=> 'blue',
				'compare_btn_text'			=> 'white-text',
				'compare_total_btn'			=> 'light-blue darken-2',
				'compare_total_btn_text'	=> 'white-text',
				'btt_btn'					=> 'red',
				'btt_btn_text'				=> 'white-text',
				'browser_bar'				=> 'blue-grey darken-4',
				'browser_bar_hex'			=> '#263238',
				'nav_btn'					=> 'blue-grey darken-2',
				'nav_btn_text'				=> 'white-text',
				'top_menu'					=> 'blue-grey darken-4',
				'top_menu_text'				=> 'white-text',
				'header'					=> 'blue-grey darken-3',
				'header_text'				=> 'blue-grey-text text-lighten-5',
				'navigation'				=> 'blue-grey darken-2',
				'navigation_text'			=> 'white-text',
				'search'					=> 'white',
				'search_text'				=> 'blue-grey-text text-darken-4',
				'sidebar'					=> 'blue-grey darken-2',
				'sidebar_text'				=> 'white-text',
				'mobile_search'				=> 'blue-grey lighten-1',
				'footer'					=> 'blue-grey darken-3',
				'footer_text'				=> 'grey-text text-lighten-3',
			);
		}

		/* Social icons */
		if (isset($this->request->post['theme_materialize_social_icon'])) {
			$theme_materialize_social_icons = $this->request->post['theme_materialize_social_icon'];
		} elseif ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$theme_materialize_social_icons = $this->model_extension_materialize_materialize->getSocialIcons();
		} else {
			$theme_materialize_social_icons = array();
		}

		$data['theme_materialize_social_icons'] = array();

		foreach ($theme_materialize_social_icons as $key => $value) {
			foreach ($value as $theme_materialize_social_icon) {
				if (is_file(DIR_IMAGE . $theme_materialize_social_icon['icon'])) {
					$icon = $theme_materialize_social_icon['icon'];
					$thumb = $theme_materialize_social_icon['icon'];
				} else {
					$icon = '';
					$thumb = 'no_image.png';
				}

				$data['theme_materialize_social_icons'][$key][] = array(
					'title'			=> $theme_materialize_social_icon['title'],
					'link'			=> $theme_materialize_social_icon['link'],
					'icon'			=> $icon,
					'thumb'			=> $this->model_tool_image->resize($thumb, 100, 100),
					'sort_order'	=> $theme_materialize_social_icon['sort_order']
				);
			}
		}

		/* Products */
		if (isset($this->request->post['theme_materialize_products'])) {
			$data['theme_materialize_products'] = $this->request->post['theme_materialize_products'];
		} elseif (isset($setting_info['theme_materialize_products'])) {
			$data['theme_materialize_products'] = $setting_info['theme_materialize_products'];

			if (!empty($data['theme_materialize_products']['payment']['image'])) {
				$data['theme_materialize_payment_thumb'] = $this->model_tool_image->resize($data['theme_materialize_products']['payment']['image'], 100, 100);
			} else {
				$data['theme_materialize_payment_thumb'] = $data['placeholder'];
			}
		} else {
			$data['theme_materialize_products'] = array();

			$data['theme_materialize_products']['fields'] = array(
				'model'			=> '',
				'sku'			=> '',
				'upc'			=> '',
				'ean'			=> '',
				'jan'			=> '',
				'isbn'			=> '',
				'mpn'			=> '',
				'location'		=> '',
				'dimension'		=> '',
				'weight'		=> '',
				'progressbar'	=> '',
				'tags'			=> 'on',
			);

			$data['theme_materialize_products']['imagezoom'] = '';

			$data['theme_materialize_products']['payment'] = array();
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/theme/materialize', $data));
	}

	public function appealInstall() {
		$this->load->language('extension/module/materialize/appeal/appeal');

		$data['modal_title'] = sprintf($this->language->get('modal_title'), $this->request->get['modal_title']);
		$data['modal_alert'] = sprintf($this->language->get('modal_alert'), $this->request->get['modal_title']);

		$this->response->setOutput($this->load->view('extension/materialize/appeal/installed', $data));
	}

	public function appealUpdate() {
		$this->load->language('extension/module/materialize/appeal/appeal');

		$data['modal_title'] = sprintf($this->language->get('modal_update_title'), $this->request->get['modal_title']);
		$data['modal_alert'] = sprintf($this->language->get('modal_update_alert'), $this->request->get['modal_title']);

		$this->response->setOutput($this->load->view('extension/materialize/appeal/updated', $data));
	}

	public function appealFooter() {
		$this->load->language('extension/module/materialize/appeal/appeal');

		$data['appeal_footer'] = true;

		$this->response->setOutput($this->load->view('extension/materialize/appeal/footer', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['theme_materialize_status'] == 1) {
			if (!$this->request->post['theme_materialize_product_limit']) {
				$this->error['product_limit'] = $this->language->get('error_limit');
			}

			if (!$this->request->post['theme_materialize_product_description_length']) {
				$this->error['product_description_length'] = $this->language->get('error_limit');
			}

			if (!$this->request->post['theme_materialize_image_category_width'] || !$this->request->post['theme_materialize_image_category_height']) {
				$this->error['image_category'] = $this->language->get('error_image_category');
			}

			if (!$this->request->post['theme_materialize_image_thumb_width'] || !$this->request->post['theme_materialize_image_thumb_height']) {
				$this->error['image_thumb'] = $this->language->get('error_image_thumb');
			}

			if (!$this->request->post['theme_materialize_image_popup_width'] || !$this->request->post['theme_materialize_image_popup_height']) {
				$this->error['image_popup'] = $this->language->get('error_image_popup');
			}

			if (!$this->request->post['theme_materialize_image_product_width'] || !$this->request->post['theme_materialize_image_product_height']) {
				$this->error['image_product'] = $this->language->get('error_image_product');
			}

			if (!$this->request->post['theme_materialize_image_additional_width'] || !$this->request->post['theme_materialize_image_additional_height']) {
				$this->error['image_additional'] = $this->language->get('error_image_additional');
			}

			if (!$this->request->post['theme_materialize_image_related_width'] || !$this->request->post['theme_materialize_image_related_height']) {
				$this->error['image_related'] = $this->language->get('error_image_related');
			}

			if (!$this->request->post['theme_materialize_image_compare_width'] || !$this->request->post['theme_materialize_image_compare_height']) {
				$this->error['image_compare'] = $this->language->get('error_image_compare');
			}

			if (!$this->request->post['theme_materialize_image_wishlist_width'] || !$this->request->post['theme_materialize_image_wishlist_height']) {
				$this->error['image_wishlist'] = $this->language->get('error_image_wishlist');
			}

			if (!$this->request->post['theme_materialize_image_cart_width'] || !$this->request->post['theme_materialize_image_cart_height']) {
				$this->error['image_cart'] = $this->language->get('error_image_cart');
			}

			if (!$this->request->post['theme_materialize_image_location_width'] || !$this->request->post['theme_materialize_image_location_height']) {
				$this->error['image_location'] = $this->language->get('error_image_location');
			}

			if ($this->request->post['theme_materialize_settings']) {
				$materialize_settings = $this->request->post['theme_materialize_settings'];

				$adult_content = $materialize_settings['adult_content'];

				if (isset($adult_content['status']) && empty($adult_content['back_link'])) {
					$this->error['adult_content'] = $this->language->get('error_adult_content');
				}
			}
		}

		return !$this->error;
	}

	protected function validateManifest() {
		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$theme_status = $this->request->post['theme_materialize_status'];
		$materialize_settings = $this->request->post['theme_materialize_settings'];

		$file = DIR_CATALOG . "view/theme/materialize/js/manifest.json";

		if (file_exists($file)) {
			unlink($file);
		}

		if (!empty($materialize_settings['favicon']['manifest']['status'])) {
			if ($materialize_settings['favicon']['manifest']['type'] == 'static') {
				if ((utf8_strlen($this->request->post['theme_materialize_settings']['favicon']['manifest']['name']) < 1) || (utf8_strlen($this->request->post['theme_materialize_settings']['favicon']['manifest']['name']) > 45)) {
					$this->error['manifest_name'] = 'Имя манифеста должно быть от 1 до 45 символов!';
				}

				if ((utf8_strlen($this->request->post['theme_materialize_settings']['favicon']['manifest']['short_name']) < 1) || (utf8_strlen($this->request->post['theme_materialize_settings']['favicon']['manifest']['short_name']) > 12)) {
					$this->error['manifest_short_name'] = 'Короткое имя манифеста должно быть от 1 до 12 символов!';
				}

				if ((utf8_strlen($this->request->post['theme_materialize_settings']['favicon']['manifest']['description']) < 1) || (utf8_strlen($this->request->post['theme_materialize_settings']['favicon']['manifest']['description']) > 1024)) {
					$this->error['manifest_description'] = 'Описание манифеста должно быть от 1 до 1024 символов!';
				}

				if ((utf8_strlen($this->request->post['theme_materialize_settings']['favicon']['manifest']['start_url']) < 1) || (utf8_strlen($this->request->post['theme_materialize_settings']['favicon']['manifest']['start_url']) > 512)) {
					$this->error['manifest_start_url'] = 'Стартовый URL манифеста должно быть от 1 до 512 символов!';
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

				$manifest  = '{' . "\n";
				$manifest .= '  "name": "' . $this->request->post['theme_materialize_settings']['favicon']['manifest']['name'] . '",' . "\n";
				$manifest .= '  "short_name": "' . $this->request->post['theme_materialize_settings']['favicon']['manifest']['short_name'] . '",' . "\n";
				$manifest .= '  "description": "' . $this->request->post['theme_materialize_settings']['favicon']['manifest']['description'] . '",' . "\n";
				$manifest .= '  "lang": "' . $this->request->post['theme_materialize_settings']['favicon']['manifest']['lang'] . '",' . "\n";
				$manifest .= '  "dir": "' . $this->request->post['theme_materialize_settings']['favicon']['manifest']['dir'] . '",' . "\n";
				$manifest .= '  "start_url": "' . $this->request->post['theme_materialize_settings']['favicon']['manifest']['start_url'] . '",' . "\n";

				if (!empty($icons)) {
					$manifest .= '  "icons": [' . "\n";
					for ($i = 0; $i < count($icons); $i++) {
						if ($i < (count($icons) - 1)) {
							$manifest .= '    {' . "\n";
							$manifest .= '      "src": "' . $icons[$i]['src'] . '",' . "\n";
							$manifest .= '      "sizes": "' . $icons[$i]['sizes'] . '",' . "\n";
							$manifest .= '      "type": "' . $icons[$i]['type'] . '"' . "\n";
							$manifest .= '    },' . "\n";
						} else {
							$manifest .= '    {' . "\n";
							$manifest .= '      "src": "' . $icons[$i]['src'] . '",' . "\n";
							$manifest .= '      "sizes": "' . $icons[$i]['sizes'] . '",' . "\n";
							$manifest .= '      "type": "' . $icons[$i]['type'] . '"' . "\n";
							$manifest .= '    }' . "\n";
						}
					}
					$manifest .= '  ],' . "\n";
				}

				$manifest .= '  "prefer_related_applications": false,' . "\n";
				$manifest .= '  "display": "' . $this->request->post['theme_materialize_settings']['favicon']['manifest']['display'] . '",' . "\n";
				$manifest .= '  "orientation": "' . $this->request->post['theme_materialize_settings']['favicon']['manifest']['orientation'] . '",' . "\n";
				$manifest .= '  "background_color": "#' . $this->request->post['theme_materialize_settings']['favicon']['manifest']['background_color']['hex'] . '",' . "\n";
				$manifest .= '  "theme_color": "' . $this->request->post['theme_materialize_colors']['browser_bar_hex'] . '"' . "\n";
				$manifest .= '}';

				if (!file_exists($file)) {
					$fp = fopen($file, "w");
					fwrite($fp, ltrim($manifest));
					fclose($fp);
				}
			} else {
				foreach ($this->request->post['theme_materialize_webmanifest_dynamic'] as $language_id => $value) {
					if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 45)) {
						$this->error['manifest_dynamic_name'] = 'Имя манифеста должно быть от 1 до 45 символов!';
					}

					if ((utf8_strlen($value['short_name']) < 1) || (utf8_strlen($value['short_name']) > 12)) {
						$this->error['manifest_dynamic_short_name'] = 'Короткое имя манифеста должно быть от 1 до 12 символов!';
					}

					if ((utf8_strlen($value['description']) < 1) || (utf8_strlen($value['description']) > 1024)) {
						$this->error['manifest_dynamic_description'] = 'Описание манифеста должно быть от 1 до 1024 символов!';
					}

					if ((utf8_strlen($value['start_url']) < 1) || (utf8_strlen($value['start_url']) > 512)) {
						$this->error['manifest_dynamic_start_url'] = 'Стартовый URL манифеста должно быть от 1 до 512 символов!';
					}
				}
			}
		}

		return !$this->error;
	}

	protected function validateBrowserconfig() {
		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$theme_status = $this->request->post['theme_materialize_status'];
		$materialize_settings = $this->request->post['theme_materialize_settings'];

		$file = DIR_CATALOG . "view/theme/materialize/js/browserconfig.xml";

		if (file_exists($file)) {
			unlink($file);
		}

		if (!empty($materialize_settings['favicon']['browserconfig']['status'])) {
			$this->load->model('tool/image');

			$icons = array();

			if (!empty($materialize_settings['favicon']['browserconfig']['image_small'])) {
				$image_small = $materialize_settings['favicon']['browserconfig']['image_small'];

				$icons['square70x70'] = $this->model_tool_image->resize($image_small, 128, 128);
				$icons['square150x150'] = $this->model_tool_image->resize($image_small, 270, 270);

			}

			if (!empty($materialize_settings['favicon']['browserconfig']['image_large'])) {
				$image_large = $materialize_settings['favicon']['browserconfig']['image_large'];

				$icons['wide310x150'] = $this->model_tool_image->resize($image_large, 558, 270);
				$icons['square310x310'] = $this->model_tool_image->resize($image_large, 558, 558);
			}

			if (!empty($icons)) {
				$browserconfig  = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
				$browserconfig .= '<browserconfig>' . "\n";
				$browserconfig .= '  <msapplication>' . "\n";
				$browserconfig .= '    <tile>' . "\n";

				foreach ($icons as $key => $value) {
					if ($key == 'square70x70')		{$browserconfig .= '      <square70x70logo src="' . $value . '"/>' . "\n";}
					if ($key == 'square150x150')	{$browserconfig .= '      <square150x150logo src="' . $value . '"/>' . "\n";}
					if ($key == 'wide310x150')		{$browserconfig .= '      <wide310x150logo src="' . $value . '"/>' . "\n";}
					if ($key == 'square310x310')	{$browserconfig .= '      <square310x310logo src="' . $value . '"/>' . "\n";}
				}

				$browserconfig .= '      <TileColor>#' . $this->request->post['theme_materialize_settings']['favicon']['browserconfig']['background_color']['hex'] . '</TileColor>' . "\n";
				$browserconfig .= '    </tile>' . "\n";
				$browserconfig .= '  </msapplication>' . "\n";
				$browserconfig .= '</browserconfig>';

				if (!file_exists($file)) {
					$fp = fopen($file, "w");
					fwrite($fp, ltrim($browserconfig));
					fclose($fp);
				}
			} else {
				$this->error['browserconfig_image'] = 'Для browserconfig.xml изображения обязательны!';
			}
		}

		return !$this->error;
	}

	public function clearCacheCategories() {
		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else {
			$cached_categories = $this->cache->get('materialize.categories');

			if ($cached_categories) {
				$this->cache->delete('materialize.categories');

				$json['success'] = 'Кэш категорий был очищен!';
			} else {
				$json['info'] = 'Кэш категорий был пуст!';
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function clearCacheColors() {
		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else {
			$cached_colors = $this->cache->get('materialize.colors');

			if ($cached_colors) {
				$this->cache->delete('materialize.colors');

				$json['success'] = 'Кэш цветов был очищен!';
			} else {
				$json['info'] = 'Кэш цветов был пуст!';
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function clearCacheAll() {
		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else {
			$cached_categories = $this->cache->get('materialize.categories');
			$cached_colors = $this->cache->get('materialize.colors');

			if ($cached_categories) {
				$this->cache->delete('materialize.categories');
			}

			if ($cached_colors) {
				$this->cache->delete('materialize.colors');
			}

			if (!$cached_categories && !$cached_colors) {
				$json['info'] = 'Кэш был пуст!';
			} else {
				$json['success'] = 'Кэш был очищен!';
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}