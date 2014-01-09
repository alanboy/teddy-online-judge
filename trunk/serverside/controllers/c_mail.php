<?php

class c_mail
{
	public static function EnviarMail($cuerpo, $destinatario, $titulo) {

		if (!file_exists("Mail.php")) {
			Logger::error("Imposible enviar mail sin Pear Mail");
			return array("result" => "error", "reason" => "Imposible enviar mail sin Pear Mail");
		}

		$headers = array(
			'From' => MAIL_FROM,
			'To' => $destinatario,
			'Subject' => $titulo
		);

		$smtp = @Mail::factory('smtp', array(
			'host' => MAIL_HOST,
			'port' => MAIL_PORT,
			'auth' => true,
			'username' => MAIL_USERNAME,
			'password' => MAIL_PASSWORD
		));

		$mail = $smtp->send($destinatario, $headers, $cuerpo);

		if (PEAR::isError($mail)) {
			Logger::error($mail->getMessage());
			//throw new Exception($mail->getMessage());
			return array("result" => "error");
		}

		return array("result" => "ok");
	}

}
