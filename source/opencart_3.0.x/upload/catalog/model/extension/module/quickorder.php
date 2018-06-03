<?php
class ModelExtensionModuleQuickorder extends Model {
	public function sendQuickorder($data) {
		$this->load->language('mail/quickorder');

		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

		$message  = $this->language->get('text_waiting') . "\n";
		$message .= sprintf($this->language->get('text_product'), html_entity_decode($data['module_quickorder_product_title'], ENT_QUOTES, 'UTF-8')) . "\n";
		$message .= sprintf($this->language->get('text_link'), html_entity_decode($data['module_quickorder_product_link'], ENT_QUOTES, 'UTF-8')) . "\n";
		$message .= sprintf($this->language->get('text_telephone'), html_entity_decode($data['module_quickorder_telephone'], ENT_QUOTES, 'UTF-8')) . "\n";
		if ((html_entity_decode($data['module_quickorder_name'], ENT_QUOTES, 'UTF-8'))) {
			$message .= sprintf($this->language->get('text_name'), html_entity_decode($data['module_quickorder_name'], ENT_QUOTES, 'UTF-8')) . "\n";
		}
		if ((html_entity_decode($data['module_quickorder_email'], ENT_QUOTES, 'UTF-8'))) {
			$message .= sprintf($this->language->get('text_email'), html_entity_decode($data['module_quickorder_email'], ENT_QUOTES, 'UTF-8')) . "\n";
		}
		if ((html_entity_decode($data['module_quickorder_enquiry'], ENT_QUOTES, 'UTF-8'))) {
			$message .= sprintf($this->language->get('text_enquiry'), html_entity_decode($data['module_quickorder_enquiry'], ENT_QUOTES, 'UTF-8')) . "\n";
		}
		if ((html_entity_decode($data['module_quickorder_calltime'], ENT_QUOTES, 'UTF-8'))) {
			$message .= sprintf($this->language->get('text_calltime'), html_entity_decode($data['module_quickorder_calltime'], ENT_QUOTES, 'UTF-8')) . "\n";
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