<?php
class ModelExtensionModuleCallback extends Model {
	public function sendCallback($data) {
		$this->load->language('mail/callback');

		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

		$message  = $this->language->get('text_waiting') . "\n";
		$message .= sprintf($this->language->get('text_telephone'), html_entity_decode($data['callback_telephone'], ENT_QUOTES, 'UTF-8')) . "\n";
		if ((html_entity_decode($data['callback_name'], ENT_QUOTES, 'UTF-8'))) {
			$message .= sprintf($this->language->get('text_name'), html_entity_decode($data['callback_name'], ENT_QUOTES, 'UTF-8')) . "\n";
		}
		if ((html_entity_decode($data['callback_enquiry'], ENT_QUOTES, 'UTF-8'))) {
			$message .= sprintf($this->language->get('text_enquiry'), html_entity_decode($data['callback_enquiry'], ENT_QUOTES, 'UTF-8')) . "\n";
		}
		if ((html_entity_decode($data['callback_calltime'], ENT_QUOTES, 'UTF-8'))) {
			$message .= sprintf($this->language->get('text_calltime'), html_entity_decode($data['callback_calltime'], ENT_QUOTES, 'UTF-8')) . "\n";
		}

		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
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