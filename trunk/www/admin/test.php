<?php

	require_once("../../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("head.php");
	require_once("require_login.php");
	require_once("require_admin.php");

?>
<div class="post_blanco"  align=left>
		<h2>Estructura de Teddy</h2>

		<p>Estos directorios deben poder ser escritos por Teddy:</p>
		<table border=0>
<?php

		$files = array("/usr/teddy/casos", "/usr/teddy/codigos");

		foreach ($files as $file) {
			echo "<tr>";
			echo "<td>" . $file . "</td>";
			if (is_writable($file)) {
				echo "<td><b style='color: green'>OK</b></td>";
			} else {
				echo "<td><b style='color: red'>FAIL</b></td>";
			}
			echo "</tr>";
		}
?>
		</table>

		<hr>

 		<h2>Mailing System</h2>
		<p><a href="http://pear.php.net/package/Mail">Mail-1.2.0</a> from pear framework, los paquete a necesitar son : Mail y Net_STMP</p>
<?php
		require_once "Mail.php";

		$to = "Alan Gonzalez <alan.gohe@gmail.com>";

		$subject = "Hi!";
		$body = "Hi,\n\nHow are you?";

		$headers = array (
				'From' => MAIL_FROM,
				'To' => $to,
				'Subject' => $subject);

		$smtp = Mail::factory('smtp',
			array ('host' => MAIL_HOST,
				'port' => MAIL_PORT,
				'auth' => true,
				'username' => MAIL_USERNAME,
				'password' => MAIL_PASSWORD));

		/*
		$mail = $smtp->send($to, $headers, $body);

		if (PEAR::isError($mail)) {
			echo("<p>" . $mail->getMessage() . "</p>");
		} else {
			echo("<p>Message successfully sent!</p>");
		}
		*/
?>

</div>

	<?php include_once("post_footer.php"); ?>
