<?php
class ControllerExtensionModuleMegamenu extends Controller {
	private $error = array();
	private $installed_from_url = HTTP_CATALOG;

	public function install() {
		$this->load->model('extension/materialize/megamenu');
		$this->load->model('setting/setting');

		$this->model_extension_materialize_megamenu->install();

		$data['module_megamenu_installed_appeal'] = true;

		$this->model_setting_setting->editSetting('module_megamenu', $data);
	}

	public function uninstall() {
		$this->load->model('extension/materialize/megamenu');
		$this->load->model('user/user_group');

		$this->model_extension_materialize_megamenu->uninstall();

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/megamenu');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/megamenu');
	}

	public function index() {
		$this->load->language('extension/module/megamenu');
		$this->load->language('extension/materialize/materialize');

		$this->document->setTitle($this->language->get('megamenu_title'));

		$this->document->addScript('view/javascript/materialize/materialize.js');
		$this->document->addScript('view/javascript/codemirror/lib/codemirror.js');
		$this->document->addScript('view/javascript/codemirror/lib/xml.js');
		$this->document->addScript('view/javascript/codemirror/lib/formatting.js');

		$this->document->addStyle('view/javascript/materialize/materialize.css');
		$this->document->addStyle('view/javascript/codemirror/lib/codemirror.css');
		$this->document->addStyle('view/javascript/codemirror/theme/monokai.css');

		$this->load->model('extension/materialize/materialize');
		$this->load->model('extension/materialize/megamenu');
		$this->load->model('setting/setting');
		$this->load->model('tool/image');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			if ($this->config->get('module_megamenu_installed_appeal') == true) {
				$megamenu_installed = $this->config->get('module_megamenu_installed_appeal');
			} else {
				$megamenu_installed = false;
			}

			if ($this->config->get('module_megamenu_template_version') == true) {
				$current_version = $this->config->get('module_megamenu_template_version');
			} else {
				$current_version = false;
			}

			if ($megamenu_installed == true) {
				$data['updated'] = false;

				$installed = $this->language->get('megamenu_title');

				$data['installed'] = $this->load->controller('extension/materialize/appeal/appeal/installed', $installed);
			} else {
				$data['installed'] = false;

				if ($this->templateVersion() != $current_version) {
					$this->update();
				}
			}

			$megamenu_info = $this->model_extension_materialize_megamenu->getMegamenuCategories();
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ($this->config->get('module_megamenu_template_version') == true) {
				$this->request->post['module_megamenu_template_version'] = $this->config->get('module_megamenu_template_version');
			} else {
				$this->request->post['module_megamenu_template_version'] = $this->templateVersion();
			}

			if ($this->config->get('module_megamenu_installed_appeal') == true) {
				$this->request->post['module_megamenu_installed_appeal'] = 0;
			}

			$this->model_extension_materialize_megamenu->editCategoryMegamenu($this->request->post);

			$this->model_setting_setting->editSetting('module_megamenu', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['errors'] = $this->error;

		$data['user_token'] = $this->session->data['user_token'];

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/megamenu', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/megamenu', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 50, 50);

		if (isset($this->request->post['module_megamenu_settings'])) {
			$data['module_megamenu_settings'] = $this->request->post['module_megamenu_settings'];
		} elseif ($this->config->get('module_megamenu_settings') == true) {
			$data['module_megamenu_settings'] = $this->config->get('module_megamenu_settings');
		} else {
			$data['module_megamenu_settings'] = array();
		}

		if (isset($this->request->post['module_megamenu_status'])) {
			$data['module_megamenu_status'] = $this->request->post['module_megamenu_status'];
		} else {
			$data['module_megamenu_status'] = $this->config->get('module_megamenu_status');
		}

		/* Content type */
		$data['content_types'] = array();

		$data['content_types'][] = array(
			'value'	=> 'default',
			'name'	=> 'Стандартное меню',
		);

		$data['content_types'][] = array(
			'value'	=> 'simple_megamenu',
			'name'	=> 'Простое мега меню',
		);

		$data['content_types'][] = array(
			'value'	=> 'category_image',
			'name'	=> 'Изображение категории',
		);

		$data['content_types'][] = array(
			'value'	=> 'category_manufacturers',
			'name'	=> 'Производители из категории',
		);

		$data['content_types'][] = array(
			'value'	=> 'featured',
			'name'	=> 'Модуль Рекомендуемые',
		);

		$data['content_types'][] = array(
			'value'	=> 'bestseller',
			'name'	=> 'Модуль Хиты продаж',
		);

		$data['content_types'][] = array(
			'value'	=> 'special',
			'name'	=> 'Модуль Акции',
		);

		$data['content_types'][] = array(
			'value'	=> 'banner',
			'name'	=> 'Слайдшоу',
		);

		$data['content_types'][] = array(
			'value'	=> 'html',
			'name'	=> 'Модуль HTML контент',
		);

		$data['content_types'][] = array(
			'value'	=> 'image_custom',
			'name'	=> 'Своё изображение',
		);

		$data['content_types'][] = array(
			'value'	=> 'image_background',
			'name'	=> 'Фоновое изображение',
		);

		/* Get Materialize colors */
		$data['materialize_get_colors'] = $this->model_extension_materialize_materialize->getMaterializeColors();
		$data['materialize_get_colors_text'] = $this->model_extension_materialize_materialize->getMaterializeColorsText();

		/* Categories */
		$data['categories'] = array();

		$results = $this->model_extension_materialize_megamenu->getCategories();

		foreach ($results as $result) {
			$data['categories'][] = array(
				'category_id'	=> $result['category_id'],
				'name'			=> $result['name'],
				'sort_order'	=> $result['sort_order']
			);
		}

		if (isset($this->request->post['module_megamenu_category'])) {
			$data['module_megamenu_category'] = $this->request->post['module_megamenu_category'];
		} elseif (!empty($megamenu_info)) {
			$data['module_megamenu_category'] = $megamenu_info;
		} else {
			foreach ($data['categories'] as $category) {
				$data['module_megamenu_category'][$category['category_id']] = array(
					'color'			=> 'white',
					'color_text'	=> 'black-text',
					'content_type'	=> 'default',
					'content_info'	=> 0,
					'sort_order'	=> $category['sort_order']
				);
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['materializeapi'] = $this->load->controller('extension/materialize/materializeapi/materializeapi');
		$data['appeal_footer'] = $this->load->controller('extension/materialize/appeal/appeal');

		$this->response->setOutput($this->load->view('extension/module/megamenu', $data));
	}

	public function megamenuType() {
		$json = array();

		$this->load->model('design/banner');
		$this->load->model('setting/module');

		if ($this->request->get['content_type'] == 'banner') {
			$banners = $this->model_design_banner->getBanners();

			foreach ($banners as $banner) {
				$json[] = array(
					'name'		=> strip_tags($banner['name']),
					'module_id'	=> $banner['banner_id']
				);
			}
		} else {
			$this->load->language('extension/module/' . $this->request->get['content_type'], 'extension');

			$modules = $this->model_setting_module->getModulesByCode($this->request->get['content_type']);

			foreach ($modules as $module) {
				$json[] = array(
					'name'		=> strip_tags($module['name']),
					'module_id'	=> $module['module_id']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getMegamenuImages() {
		$json = array();

		$this->load->model('extension/materialize/megamenu');
		$this->load->model('tool/image');

		$megamenu_settings = $this->config->get('module_megamenu_settings');
		$category_id = $this->request->get['category_id'];
		$content_type = $this->request->get['content_type'];

		$image = $this->model_extension_materialize_megamenu->getMegamenuImageByCategoryId($category_id);

		if ($content_type == 'category_image') {
			$json['image_width'] = $megamenu_settings[$category_id]['image_width'];
			$json['image_height'] = $megamenu_settings[$category_id]['image_height'];
		} else {
			if (is_file(DIR_IMAGE . $image)) {
				$json['value'] = $image;
				$json['image'] = $this->model_tool_image->resize($image, 50, 50);
				$json['image_width'] = $megamenu_settings[$category_id]['image_width'];
				$json['image_height'] = $megamenu_settings[$category_id]['image_height'];

				if ($content_type == 'image_background') {
					$json['bg_code'] = $megamenu_settings[$category_id]['background_settings'];
				}
			} else {
				$json = false;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function clearCacheCategories() {
		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/theme/materialize')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else {
			$this->load->model('localisation/language');

			$languages = $this->model_localisation_language->getLanguages();

			foreach ($languages as $language) {
				$this->cache->delete('materialize.megamenu.categories.' . (int)$language['language_id']);
			}

			$json['success'] = 'Кэш категорий был очищен!';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/megamenu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['module_megamenu_settings'])) {
			foreach ($this->request->post['module_megamenu_settings'] as $category_id => $value) {
				if ((isset($value['image_width'])) && (empty($value['image_width']))) {
					$this->error['image_width'] = 'Укажите ширину изображения';
				}

				if ((isset($value['image_height'])) && (empty($value['image_height']))) {
					$this->error['image_height'] = 'Укажите высоту изображения';
				}
			}
		}

		return !$this->error;
	}

	protected function update() {
		$this->load->model('extension/materialize/materialize');
		$this->load->model('setting/setting');

		$this->model_extension_materialize_materialize->update();

		$data['module_megamenu_template_version'] = $this->templateVersion();

		$this->model_setting_setting->editSetting('module_megamenu', $data);
	}

	protected function templateVersion() {
		return $this->load->controller('extension/materialize/materializeapi/materializeapi/templateVersion');
	}
}