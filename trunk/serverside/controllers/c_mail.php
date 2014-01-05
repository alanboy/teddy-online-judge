<?php

class c_mail
{
	public static function EnviarMail($cuerpo, $destinatario, $titulo) {

		$headers = array(
			'From' => MAIL_FROM,
			'To' => $destinatario,
			'Subject' => $titulo
		);

		$smtp = Mail::factory('smtp', array(
			'host' => MAIL_HOST,
			'port' => MAIL_PORT,
			'auth' => true,
			'username' => MAIL_USERNAME,
			'password' => MAIL_PASSWORD
		));

		$mail = $smtp->send($destinatario, $headers, $cuerpo);

		if (PEAR::isError($mail)) {
			throw new Exception($mail->getMessage());
		}
	}

}
