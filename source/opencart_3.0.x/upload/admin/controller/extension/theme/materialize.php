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

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('theme_materialize', $this->request->post, $this->request->get['store_id']);

			$this->model_extension_materialize_materialize->editSocialIcon($this->request->post);

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

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['user_token'] = $this->session->data['user_token'];

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

		if (isset($this->request->get['store_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$setting_info = $this->model_setting_setting->getSetting('theme_materialize', $this->request->get['store_id']);
		}

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

		if (isset($this->request->post['theme_materialize'])) {
			$data['theme_materialize'] = $this->request->post['theme_materialize'];
		} elseif ($this->config->get('theme_materialize') == true) {
			$data['theme_materialize'] = $this->config->get('theme_materialize');
		} else {
			$data['theme_materialize'] = '';
		}

		/* Common */

		if (isset($this->request->post['theme_materialize_settings'])) {
			$data['theme_materialize_settings'] = $this->request->post['theme_materialize_settings'];
		} elseif ($this->config->get('theme_materialize_settings') == true) {
			$data['theme_materialize_settings'] = $this->config->get('theme_materialize_settings');
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
			);

			$data['theme_materialize_settings']['cache'] = array(
				'css'	=> '',
			);
		}

		/* Colors */

		$data['theme_materialize_get_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();

		$data['theme_materialize_get_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

		if (isset($this->request->post['theme_materialize_colors'])) {
			$data['theme_materialize_colors'] = $this->request->post['theme_materialize_colors'];
		} elseif ($this->config->get('theme_materialize_colors') == true) {
			$data['theme_materialize_colors'] = $this->config->get('theme_materialize_colors');
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

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

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
		} elseif ($this->config->get('theme_materialize_products') == true) {
			$data['theme_materialize_products'] = $this->config->get('theme_materialize_products');
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
			);

			$data['theme_materialize_products']['image'] = array(
				'imagezoom'	=> '',
			);
		}

		/* Payment methods */

		if (isset($this->request->post['theme_materialize_payment_image'])) {
			$data['theme_materialize_payment_image'] = $this->request->post['theme_materialize_payment_image'];
		} else {
			$data['theme_materialize_payment_image'] = $this->config->get('theme_materialize_payment_image');
		}

		if (isset($this->request->post['theme_materialize_payment_thumb']) && is_file(DIR_IMAGE . $this->request->post['theme_materialize_payment_thumb'])) {
			$data['theme_materialize_payment_thumb'] = $this->model_tool_image->resize($this->request->post['theme_materialize_payment_image'], 100, 100);
		} elseif ($this->config->get('theme_materialize_payment_image') == true) {
			$data['theme_materialize_payment_thumb'] = $this->model_tool_image->resize($this->config->get('theme_materialize_payment_image'), 100, 100);
		} else {
			$data['theme_materialize_payment_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['theme_materialize_payment_image_width'])) {
			$data['theme_materialize_payment_image_width'] = $this->request->post['theme_materialize_payment_image_width'];
		} else {
			$data['theme_materialize_payment_image_width'] = $this->config->get('theme_materialize_payment_image_width');
		}

		if (isset($this->request->post['theme_materialize_payment_image_height'])) {
			$data['theme_materialize_payment_image_height'] = $this->request->post['theme_materialize_payment_image_height'];
		} else {
			$data['theme_materialize_payment_image_height'] = $this->config->get('theme_materialize_payment_image_height');
		}

		$data['clear_css'] = $this->url->link('extension/theme/materialize/clearCss', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/theme/materialize', $data));
	}

	public function clearCss() {
		$this->cache->delete('compressed.css');

		$this->session->data['success'] = 'Кэш Css Очищен!';

		$this->response->redirect($this->url->link('extension/theme/materialize', 'user_token=' . $this->session->data['user_token'] . '&store_id=' . $this->request->get['store_id'], true));
	}

	public function appealInstall() {
		$this->load->language('extension/module/materialize/appeal/appeal');

		$data['modal_title'] = sprintf($this->language->get('modal_title'), $this->request->get['modal_title']);
		$data['modal_alert'] = sprintf($this->language->get('modal_alert'), $this->request->get['modal_title']);

		$this->response->setOutput($this->load->view('extension/materialize/appeal/installed', $data));
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
		}

		return !$this->error;
	}
}