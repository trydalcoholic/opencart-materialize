<?php
class ModelExtensionModuleCallback extends Model {
	public function sendCallback($data) {
		$this->load->language('mail/callback');

		$this->db->query("INSERT INTO " . DB_PREFIX . "materialize_callback SET telephone = '" . $this->db->escape(trim($data['module_callback_telephone'])) . "', name = '" . $this->db->escape(trim($data['module_callback_name'])) . "', enquiry = '" . $this->db->escape(trim($data['module_callback_enquiry'])) . "', call_time  = '" . $this->db->escape(trim($data['module_callback_calltime'])) . "', order_page  = '" . $this->db->escape(html_entity_decode($data['order_page'], ENT_QUOTES, 'UTF-8')) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '0', date_added = NOW()");

		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

		$message  = $this->language->get('text_waiting') . "\n";
		$message .= sprintf($this->language->get('text_telephone'), trim($data['module_callback_telephone'])) . "\n";
		if ($data['module_callback_name']) {
			$message .= sprintf($this->language->get('text_name'), trim($data['module_callback_name'])) . "\n";
		}
		if ($data['module_callback_enquiry']) {
			$message .= sprintf($this->language->get('text_enquiry'), trim($data['module_callback_enquiry'])) . "\n";
		}
		if ($data['module_callback_calltime']) {
			$message .= sprintf($this->language->get('text_calltime'), trim($data['module_callback_calltime'])) . "\n";
		}

		$mail = new Mail($this->config->get('config_mail_engine'));
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

		$mail->setTo($this->config->get('config_email'));
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject($subject);
		$mail->setText($message);
		$mail->send();

		// Send to additional alert emails
		$emails = explode(',', $this->config->get('config_alert_email'));

		foreach ($emails as $email) {
			if ($email && preg_match($this->config->get('config_mail_regexp'), $email)) {
				$mail->setTo($email);
				$mail->send();
			}
		}
	}
}