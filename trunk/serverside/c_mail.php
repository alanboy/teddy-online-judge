<?php

//require_once "Mail.php";
class c_mail
{
	function EnviarMail($cuerpo, $destinatario, $titulo) {

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
			//Logger::error($mail->getMessage());
			throw new Exception($mail->getMessage());
		}
	}

}
//EnviarMail( "this is body, hody", "alan@caffeina.mx", "titulo");
