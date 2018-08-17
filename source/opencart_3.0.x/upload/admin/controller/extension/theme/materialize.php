<?php
class ControllerExtensionThemeMaterialize extends Controller {
	private $error = array();
	private $installed_from_url = HTTP_CATALOG;

	public function install() {
		$this->load->model('extension/materialize/materialize');
		$this->load->model('user/user_group');
		$this->load->model('setting/setting');
		$this->load->model('setting/event');

		$this->model_extension_materialize_materialize->install($this->installSettings());

		$this->model_setting_event->addEvent('theme_materialize_menu_item', 'admin/view/common/column_left/before', 'extension/theme/materialize/adminMaterializeThemeMenuItem');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/common/cart/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/common/header/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/common/menu/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/common/search/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/common/footer/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/product/category/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/product/search/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/product/search/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/product/special/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/product/manufacturer/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/product/product/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/extension/module/bestseller/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/extension/module/featured/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/extension/module/latest/before', 'extension/module/materialize/colorScheme');
		$this->model_setting_event->addEvent('theme_materialize_color_scheme', 'catalog/view/extension/module/special/before', 'extension/module/materialize/colorScheme');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/materialize');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/materialize');

		$data['theme_materialize_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('theme_materialize', $data);
	}

	public function uninstall() {
		$this->load->model('extension/materialize/materialize');
		$this->load->model('user/user_group');
		$this->load->model('setting/event');

		$this->model_extension_materialize_materialize->uninstall();
		$this->model_setting_event->deleteEventByCode('theme_materialize_menu_item');
		$this->model_setting_event->deleteEventByCode('theme_materialize_color_scheme');

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
		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('catalog/information');
		$this->load->model('extension/materialize/materialize');
		$this->load->model('localisation/language');
		$this->load->model('localisation/stock_status');
		$this->load->model('setting/setting');
		$this->load->model('tool/image');

		if (isset($this->request->get['store_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$setting_info = $this->model_setting_setting->getSetting('theme_materialize', $this->request->get['store_id']);

			$dynamic_manifest_info = $this->config->get('theme_materialize_webmanifest_dynamic');

			if ($this->config->get('theme_materialize_installed_appeal') == true) {
				$template_installed = $this->config->get('theme_materialize_installed_appeal');
			} else {
				$template_installed = false;
			}

			if ($this->config->get('theme_materialize_template_version') == true) {
				$current_version = $this->config->get('theme_materialize_template_version');
			} else {
				$current_version = false;
			}

			if ($template_installed == true) {
				$data['updated'] = false;

				$installed = $this->language->get('materialize_title');

				$data['installed'] = $this->load->controller('extension/materialize/appeal/appeal/installed', $installed);
			} else {
				$data['installed'] = false;

				if ($this->templateVersion() != $current_version) {
					$this->update();

					$updated = $this->language->get('materialize_title');

					$data['updated'] = $this->load->controller('extension/materialize/appeal/appeal/updated', $updated);
				} else {
					$data['updated'] = false;
				}
			}
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && $this->validateManifest() && $this->validateBrowserconfig()) {
			if ($this->config->get('theme_materialize_template_version') == true) {
				$this->request->post['theme_materialize_template_version'] = $this->config->get('theme_materialize_template_version');
			} else {
				$this->request->post['theme_materialize_template_version'] = $this->templateVersion();
			}

			if ($this->config->get('theme_materialize_installed_appeal') == true) {
				$this->request->post['theme_materialize_installed_appeal'] = 0;
			}

			if (isset($this->request->post['color_schemes'])) {
				$data['color_schemes'] = $this->request->post['color_schemes'];

				$this->model_extension_materialize_materialize->addMaterializeColorScheme($data);
			}

			$theme_status = $this->request->post['theme_materialize_status'];
			$materialize_settings = $this->request->post['theme_materialize_settings'];

			if (empty($theme_status) || empty($materialize_settings['optimization']['cached_categories'])) {
				$this->load->model('localisation/language');

				$languages = $this->model_localisation_language->getLanguages();

				foreach ($languages as $language) {
					$this->cache->delete('materialize.categories.' . (int)$language['language_id']);
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

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['errors'] = $this->error;

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
			$data['theme_materialize_image_product_width'] = 344;
		}

		if (isset($this->request->post['theme_materialize_image_product_height'])) {
			$data['theme_materialize_image_product_height'] = $this->request->post['theme_materialize_image_product_height'];
		} elseif (isset($setting_info['theme_materialize_image_product_height'])) {
			$data['theme_materialize_image_product_height'] = $setting_info['theme_materialize_image_product_height'];
		} else {
			$data['theme_materialize_image_product_height'] = 194;
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
			$data['theme_materialize_image_related_width'] = 80;
		}

		if (isset($this->request->post['theme_materialize_image_related_height'])) {
			$data['theme_materialize_image_related_height'] = $this->request->post['theme_materialize_image_related_height'];
		} elseif (isset($setting_info['theme_materialize_image_related_height'])) {
			$data['theme_materialize_image_related_height'] = $setting_info['theme_materialize_image_related_height'];
		} else {
			$data['theme_materialize_image_related_height'] = 80;
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
			$data['theme_materialize_image_location_width'] = 450;
		}

		if (isset($this->request->post['theme_materialize_image_location_height'])) {
			$data['theme_materialize_image_location_height'] = $this->request->post['theme_materialize_image_location_height'];
		} elseif (isset($setting_info['theme_materialize_image_location_height'])) {
			$data['theme_materialize_image_location_height'] = $setting_info['theme_materialize_image_location_height'];
		} else {
			$data['theme_materialize_image_location_height'] = 300;
		}

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['informations'] = $this->model_catalog_information->getInformations();

		if (isset($this->request->post['theme_materialize_settings'])) {
			$data['theme_materialize_settings'] = $this->request->post['theme_materialize_settings'];

			$materialize_settings = $this->request->post['theme_materialize_settings'];

			if (!empty($materialize_settings['favicon']['image']) && is_file(DIR_IMAGE . $materialize_settings['favicon']['image'])) {
				$data['theme_materialize_favicon_image'] = $this->model_tool_image->resize($data['theme_materialize_settings']['favicon']['image'], 100, 100);
			} else {
				$data['theme_materialize_favicon_image'] = $data['placeholder'];
			}

			if (!empty($materialize_settings['favicon']['svg']) && is_file(DIR_IMAGE . $materialize_settings['favicon']['svg'])) {
				$data['theme_materialize_favicon_svg'] = $this->model_tool_image->resize($data['theme_materialize_settings']['favicon']['svg'], 100, 100);
			} else {
				$data['theme_materialize_favicon_svg'] = $data['placeholder'];
			}

			if (!empty($materialize_settings['favicon']['manifest']['image']) && is_file(DIR_IMAGE . $materialize_settings['favicon']['manifest']['image'])) {
				$data['theme_materialize_manifest_thumb'] = $this->model_tool_image->resize($data['theme_materialize_settings']['favicon']['manifest']['image'], 100, 100);
			} else {
				$data['theme_materialize_manifest_thumb'] = $data['placeholder'];
			}

			if (!empty($materialize_settings['favicon']['browserconfig']['image_small']) && is_file(DIR_IMAGE . $materialize_settings['favicon']['browserconfig']['image_small'])) {
				$data['theme_materialize_browserconfig_thumb_small'] = $this->model_tool_image->resize($data['theme_materialize_settings']['favicon']['browserconfig']['image_small'], 100, 100);
			} else {
				$data['theme_materialize_browserconfig_thumb_small'] = $data['placeholder'];
			}

			if (!empty($materialize_settings['favicon']['browserconfig']['image_large']) && is_file(DIR_IMAGE . $materialize_settings['favicon']['browserconfig']['image_large'])) {
				$data['theme_materialize_browserconfig_thumb_large'] = $this->model_tool_image->resize($data['theme_materialize_settings']['favicon']['browserconfig']['image_large'], 100, 100);
			} else {
				$data['theme_materialize_browserconfig_thumb_large'] = $data['placeholder'];
			}
		} elseif (!empty($setting_info['theme_materialize_settings'])) {
			$data['theme_materialize_settings'] = $setting_info['theme_materialize_settings'];

			if (!empty($setting_info['theme_materialize_settings']['favicon']['image'])) {
				$data['theme_materialize_favicon_image'] = $this->model_tool_image->resize($data['theme_materialize_settings']['favicon']['image'], 100, 100);
			} else {
				$data['theme_materialize_favicon_image'] = $data['placeholder'];
			}

			if (!empty($setting_info['theme_materialize_settings']['favicon']['svg'])) {
				$data['theme_materialize_favicon_svg'] = $this->model_tool_image->resize($data['theme_materialize_settings']['favicon']['svg'], 100, 100);
			} else {
				$data['theme_materialize_favicon_svg'] = $data['placeholder'];
			}

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

			$data['theme_materialize_settings']['color_scheme_name'] = 'blue-grey';

			$data['theme_materialize_favicon_image'] = $data['placeholder'];
			$data['theme_materialize_favicon_ico'] = $data['placeholder'];
			$data['theme_materialize_favicon_svg'] = $data['placeholder'];
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
		$data['theme_materialize_color_schemes'] = $this->model_extension_materialize_materialize->getMaterializeColorSchemes();

		$data['theme_materialize_custom_color_schemes'] = $this->model_extension_materialize_materialize->getMaterializeCustomColorSchemes();

		/*if (isset($this->request->post['theme_materialize_colors'])) {
			$data['theme_materialize_colors'] = $this->request->post['theme_materialize_colors'];
		} elseif (isset($setting_info['theme_materialize_colors'])) {
			$data['theme_materialize_colors'] = $setting_info['theme_materialize_colors'];
		} else {
			$data['theme_materialize_colors'] = array();

			$data['theme_materialize_colors'] = array(
				'background'				=> 'grey lighten-3',
				'add_cart'					=> 'red',
				'add_cart_text'				=> 'white-text',
				'more_detailed'				=> 'transparent',
				'more_detailed_text'		=> 'deep-orange-text',
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
				'mobile_menu'				=> 'blue-grey darken-2',
				'mobile_menu_hex'			=> '#455a64',
				'mobile_menu_text'			=> 'white-text',
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
		}*/

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

			if (!empty($data['theme_materialize_products']['payment']['image']) && is_file(DIR_IMAGE . $data['theme_materialize_products']['payment']['image'])) {
				$data['theme_materialize_payment_thumb'] = $this->model_tool_image->resize($data['theme_materialize_products']['payment']['image'], 100, 100);
			} else {
				$data['theme_materialize_payment_thumb'] = $data['placeholder'];
			}
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
		$data['materializeapi'] = $this->load->controller('extension/materialize/materializeapi/materializeapi');
		$data['appeal_footer'] = $this->load->controller('extension/materialize/appeal/appeal');

		$this->response->setOutput($this->load->view('extension/theme/materialize', $data));
	}

	protected function getMaterializeApi() {
		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$curl = curl_init('https://materialize.myefforts.ru/index.php?route=extension/module/materializeapi');

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($curl, CURLOPT_POST, 1);

		$response = curl_exec($curl);

		curl_close($curl);

		$materializeapi_info = json_decode($response, true);

		if ($materializeapi_info) {
			$materializeapi['donaters'] = $materializeapi_info['donaters'];
			$materializeapi['total_amount'] = $materializeapi_info['total_amount'];
			$materializeapi['versions'] = $materializeapi_info['versions'];
			$materializeapi['translators'] = $materializeapi_info['translators'];
			$materializeapi['changelogs'] = $materializeapi_info['changelogs'];
			$materializeapi['template_verstion'] = $this->templateVersion();

			return $materializeapi;
		} else {
			return false;
		}
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

				$favicons = $materialize_settings['favicon'];

				if (!empty($favicons['image'])) {
					$file = DIR_IMAGE . $favicons['image'];

					if (file_exists($file)) {
						$this->file = $file;

						$info = getimagesize($file);

						$this->width  = $info[0];
						$this->height = $info[1];
						$this->bits = isset($info['bits']) ? $info['bits'] : '';
						$this->mime = isset($info['mime']) ? $info['mime'] : '';

						if (($this->mime != 'image/gif') && ($this->mime != 'image/png') && ($this->mime != 'image/jpeg')) {
							$this->error['favicon_image'] = 'Главный фавикон должен быть в формате .png, .jpg или .gif!';
						}
					} else {
						exit('Error: Could not load image ' . $file . '!');
					}
				}

				if (!empty($favicons['svg'])) {
					$file = pathinfo(DIR_IMAGE . $favicons['svg'], PATHINFO_EXTENSION);

					if ($file != 'svg') {
						$this->error['favicon_svg'] = 'SVG фавикон должен быть в формате .svg!';
					}
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
			$this->load->model('localisation/language');

			$languages = $this->model_localisation_language->getLanguages();

			foreach ($languages as $language) {
				$this->cache->delete('materialize.categories.' . (int)$language['language_id']);
			}

			$json['success'] = 'Кэш категорий был очищен!';
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
			$this->load->model('localisation/language');

			$languages = $this->model_localisation_language->getLanguages();

			foreach ($languages as $language) {
				$this->cache->delete('materialize.categories.' . (int)$language['language_id']);
			}

			$cached_colors = $this->cache->get('materialize.colors');

			if ($cached_colors) {
				$this->cache->delete('materialize.colors');
			}

			$json['success'] = 'Кэш был очищен!';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function colorSchemeCreate() {
		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['scheme_id'])) {
				$scheme_id = $this->request->get['scheme_id'];
			} else {
				$scheme_id = '';
			}

			$json = $this->load->controller('extension/materialize/theme/color_scheme', $scheme_id);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function colorSchemeDeleteById() {
		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else {
			$this->load->model('extension/materialize/materialize');

			$this->model_extension_materialize_materialize->deleteMaterializeColorSchemeById($this->request->get['scheme_id']);

			$json['success'] = true;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function colorSchemesDeleteAll() {
		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else {
			$this->load->model('extension/materialize/materialize');

			$this->model_extension_materialize_materialize->deleteMaterializeCustomColorSchemes();

			$json['success'] = true;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function update() {
		$this->load->model('extension/materialize/materialize');
		$this->load->model('setting/setting');
		$this->load->model('setting/event');

		$this->model_extension_materialize_materialize->update();

		$this->model_setting_event->addEvent('theme_materialize_menu_item', 'admin/view/common/column_left/before', 'extension/theme/materialize/adminMaterializeThemeMenuItem');

		$data['theme_materialize_template_version'] = $this->templateVersion();

		$this->model_setting_setting->editSetting('theme_materialize', $data);
	}

	public function adminMaterializeThemeMenuItem($route, &$data) {
		$this->load->language('extension/materialize/materialize');

		$materialize = array();

		if ($this->user->hasPermission('access', 'extension/theme/materialize')) {
			$materialize[] = array(
				'name'		=> $this->language->get('text_materialize_settings'),
				'href'		=> $this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=0', true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/module/map') && $this->config->get('module_map_status') == 1) {
			$materialize[] = array(
				'name'		=> $this->language->get('text_map'),
				'href'		=> $this->url->link('extension/module/map', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/materialize/label/label') && $this->config->get('module_label_status') == 1) {
			$materialize[] = array(
				'name'		=> $this->language->get('text_labels'),
				'href'		=> $this->url->link('extension/materialize/label/label', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/module/quickorder') && $this->config->get('module_quickorder_status') == 1) {
			$materialize[] = array(
				'name'		=> $this->language->get('text_quickorder'),
				'href'		=> $this->url->link('extension/module/quickorder', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/materialize/sizechart/sizechart') && $this->config->get('module_sizechart_status') == 1) {
			$materialize[] = array(
				'name'		=> $this->language->get('text_sizechart'),
				'href'		=> $this->url->link('extension/materialize/sizechart/sizechart', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/module/megamenu') && $this->config->get('module_megamenu_status') == 1) {
			$materialize[] = array(
				'name'		=> 'Мега меню',
				'href'		=> $this->url->link('extension/module/megamenu', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		$callback = array();

		if ($this->user->hasPermission('access', 'extension/materialize/callback/callback')) {
			$callback[] = array(
				'name'		=> $this->language->get('text_callback'),
				'href'		=> $this->url->link('extension/materialize/callback/callback', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/dashboard/callback')) {
			$callback[] = array(
				'name'		=> $this->language->get('text_callback_dashboard'),
				'href'		=> $this->url->link('extension/dashboard/callback', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/module/callback')) {
			$callback[] = array(
				'name'		=> $this->language->get('text_callback_settings'),
				'href'		=> $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($callback && $this->config->get('module_callback_status') == 1) {
			$materialize[] = array(
				'name'		=> $this->language->get('text_callback'),
				'href'		=> '',
				'children'	=> $callback
			);
		}

		$blog = array();

		if ($this->user->hasPermission('access', 'extension/materialize/blog/category')) {
			$blog[] = array(
				'name'		=> $this->language->get('text_blog_category'),
				'href'		=> $this->url->link('extension/materialize/blog/category', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/materialize/blog/post')) {
			$blog[] = array(
				'name'		=> $this->language->get('text_blog_post'),
				'href'		=> $this->url->link('extension/materialize/blog/post', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/materialize/blog/author')) {
			$blog[] = array(
				'name'		=> $this->language->get('text_blog_author'),
				'href'		=> $this->url->link('extension/materialize/blog/author', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/materialize/blog/comment')) {
			$blog[] = array(
				'name'		=> $this->language->get('text_blog_comment'),
				'href'		=> $this->url->link('extension/materialize/blog/comment', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($this->user->hasPermission('access', 'extension/module/blog')) {
			$blog[] = array(
				'name'		=> $this->language->get('text_blog_settings'),
				'href'		=> $this->url->link('extension/module/blog', 'user_token=' . $this->session->data['user_token'], true),
				'children'	=> array()
			);
		}

		if ($blog && $this->config->get('module_blog_status') == 1) {
			$materialize[] = array(
				'name'		=> $this->language->get('text_blog'),
				'href'		=> '',
				'children'	=> $blog
			);
		}

		if ($materialize) {
			$data['menus'][] = array(
				'id'		=> 'menu-materialize',
				'icon'		=> 'fa fa-cogs',
				'name'		=> $this->language->get('text_materialize'),
				'href'		=> '',
				'children'	=> $materialize
			);
		}
	}

	protected function installSettings() {
		$data['color_schemes'] = array();

		$data['color_schemes']['blue_grey']['title'] = 'Blue Grey';

		$data['color_schemes']['blue_grey']['name'] = 'blue-grey';

		$data['color_schemes']['blue_grey']['hex'] = '#37474f';

		$data['color_schemes']['blue_grey']['value'] = array(
			'background'				=> 'grey lighten-3',
			'add_cart'					=> 'red',
			'add_cart_text'				=> 'white-text',
			'more_detailed'				=> 'transparent',
			'more_detailed_text'		=> 'deep-orange-text',
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
			'mobile_menu'				=> 'blue-grey darken-2',
			'mobile_menu_hex'			=> '#455a64',
			'mobile_menu_text'			=> 'white-text',
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

		return $data;
	}

	protected function templateVersion() {
		return $this->load->controller('extension/materialize/materializeapi/materializeapi/templateVersion');
	}
}