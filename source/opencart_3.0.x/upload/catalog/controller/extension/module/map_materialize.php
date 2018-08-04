<?php
class ControllerExtensionModuleMapMaterialize extends Controller {
	public function index($data) {
		$this->load->model('extension/module/map_materialize');

		$module_map_settings = $this->config->get('module_map_settings');

		if (!empty($module_map_settings['email'])) {
			$email_store = $this->config->get('config_email');;
		} else {
			$email_store = false;
		}

		$colors = $module_map_settings['colors'];

		$data['color_panel'] = $colors['panel_color'];
		$data['color_panel_text'] = $colors['panel_color_text'];
		$data['color_panel_icons'] = $colors['panel_icons_color'];
		$data['color_marker'] = $colors['marker_color_hex'];
		$data['color_btn'] = $colors['btn_color'];
		$data['color_btn_text'] = $colors['btn_color_text'];

		if (!empty($module_map_settings['map']['zoom'])) {
			$data['map_zoom'] = $module_map_settings['map']['zoom'];
		} else {
			$data['map_zoom'] = 16;
		}

		$data['api_key'] = $module_map_settings['map']['api_key'];

		foreach ($data['locations'] as $key => $value) {
			if ($value['geocode']) {
				$coordinates = explode(',', $value['geocode']);
				$lat = trim($coordinates[0]);
				$lng = trim($coordinates[1]);
			} else {
				$lat = '';
				$lng = '';
			}

			if ($value['image']) {
				$location_image = $this->model_extension_module_map_materialize->getLocationImage($value['location_id']);
				$thumbnail = $this->model_tool_image->resize($location_image['image'], 40, 40);
			} else {
				$thumbnail = false;
			}

			$data['locations'][$key] = array(
				'location_id'	=> $value['location_id'],
				'name'			=> $value['name'],
				'store_name'	=> html_entity_decode($value['name'], ENT_QUOTES, 'UTF-8'),
				'address'		=> nl2br($value['address']),
				'geocode'		=> $value['geocode'],
				'lat'			=> $lat,
				'lng'			=> $lng,
				'telephone'		=> $value['telephone'],
				'formatted_tel'	=> str_replace(array('(',')',' '),'', $value['telephone']),
				'email'			=> $email_store,
				'fax'			=> $value['fax'],
				'image'			=> $value['image'],
				'thumbnail'		=> $thumbnail,
				'open'			=> nl2br($value['open']),
				'comment'		=> $value['comment']
			);
		}

		if ($this->config->get('config_image')) {
			$thumbnail = $this->model_tool_image->resize($this->config->get('config_image'), 40, 40);
		} else {
			$thumbnail = false;
		}

		if (!empty($data['geocode'])) {
			$coordinates = explode(',', $data['geocode']);
			$data['lat'] = trim($coordinates[0]);
			$data['lng'] = trim($coordinates[1]);
		} else {
			$data['lat'] = '';
			$data['lng'] = '';
		}

		$main_store[] = array(
			'location_id'	=> 0,
			'name'			=> $data['store'],
			'store_name'	=> html_entity_decode($data['store'], ENT_QUOTES, 'UTF-8'),
			'address'		=> nl2br($data['address']),
			'geocode'		=> $data['geocode'],
			'lat'			=> $data['lat'],
			'lng'			=> $data['lng'],
			'telephone'		=> $data['telephone'],
			'formatted_tel'	=> str_replace(array('(',')',' '),'', $data['telephone']),
			'email'			=> $email_store,
			'fax'			=> $data['fax'],
			'image'			=> $data['image'],
			'thumbnail'		=> $thumbnail,
			'open'			=> nl2br($data['open']),
			'comment'		=> $data['comment']
		);

		$data['locations'] = array_merge($main_store, $data['locations']);

		if ($module_map_settings['map']['type'] == 'google_maps') {
			$data['map_script'] = $this->load->view('extension/module/map_google', $data);
		} else {
			$data['map_script'] = $this->load->view('extension/module/map_yandex', $data);
		}

		return $this->load->view('extension/module/map_materialize', $data);
	}

	public function moduleMapAdd($route, &$data) {
		if ($this->config->get('module_map_status') == 1) {
			$data['map_materialize'] = $this->load->controller('extension/module/map_materialize', $data);
		} else {
			$data['map_materialize'] = false;
		}
	}
}