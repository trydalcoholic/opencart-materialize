<?php
class ControllerExtensionMaterializeMaterializeApiMaterializeApi extends Controller {
	public function index() {
		$curl = curl_init('https://materialize.myefforts.ru/index.php?route=extension/module/materializeapi');

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($curl, CURLOPT_POST, 1);

		$response = curl_exec($curl);

		curl_close($curl);

		$materializeapi_info = json_decode($response, true);

		if ($materializeapi_info) {
			$data['donaters'] = $materializeapi_info['donaters'];
			$data['total_amount'] = $materializeapi_info['total_amount'];
			$data['translators'] = $materializeapi_info['translators'];
			$data['versions'] = $materializeapi_info['versions'];
			$data['changelogs'] = $materializeapi_info['changelogs'];
			$data['template_verstion'] = $this->templateVersion();

			return $this->load->view('extension/materialize/materializeapi/materializeapi', $data);
		} else {
			return false;
		}
	}

	public function templateVersion() {
		$template_version = '0.81';

		return $template_version;
	}
}