<?php
class ControllerExtensionModuleMegamenu extends Controller {
	private $error = array();
	private $template_version = '0.81';
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
		$this->document->addStyle('view/javascript/materialize/materialize.css');

		$this->load->model('extension/materialize/megamenu');
		$this->load->model('setting/setting');

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

				if ($this->template_version != $current_version) {
					$this->update();
				}
			}

			$megamenu_info = $this->model_extension_materialize_megamenu->getMegamenuCategories();
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ($this->config->get('module_megamenu_template_version') == true) {
				$this->request->post['module_megamenu_template_version'] = $this->config->get('module_megamenu_template_version');
			} else {
				$this->request->post['module_megamenu_template_version'] = $this->template_version;
			}

			if ($this->config->get('module_megamenu_installed_appeal') == true) {
				$this->request->post['module_megamenu_installed_appeal'] = 0;
			}

			$this->model_extension_materialize_megamenu->addCategoryMegamenu($this->request->post);

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
			'name'	=> 'Стандартный',
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
					'content_type'	=> 'default',
					'content_info'	=> 0,
					'sort_order'	=> $category['sort_order']
				);
			}
		}

		/* Materialize API */
		$materializeapi = $this->getMaterializeApi();

		if ($materializeapi) {
			$data['materializeapi'] = true;
			$data['materializeapi_donaters'] = $materializeapi['donaters'];
			$data['materializeapi_total_amount'] = $materializeapi['total_amount'];
			$data['materializeapi_versions'] = $materializeapi['versions'];
			$data['materializeapi_translators'] = $materializeapi['translators'];
			$data['materializeapi_changelogs'] = $materializeapi['changelogs'];
			$data['materializeapi_template_verstion'] = $materializeapi['template_verstion'];
		} else {
			$data['materializeapi'] = false;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['appeal_footer'] = $this->load->controller('extension/materialize/appeal/appeal');

		$this->response->setOutput($this->load->view('extension/module/megamenu', $data));
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
			$materializeapi['template_verstion'] = $this->template_version;

			return $materializeapi;
		} else {
			return false;
		}
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

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/megamenu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function update() {
		$this->load->model('extension/materialize/materialize');
		$this->load->model('setting/setting');

		$this->model_extension_materialize_materialize->update();

		$data['module_megamenu_template_version'] = $this->template_version;

		$this->model_setting_setting->editSetting('module_megamenu', $data);
	}
}