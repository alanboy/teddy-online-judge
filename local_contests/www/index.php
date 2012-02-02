<?php 
	require_once("bootstrap.php");

?>
<html>
	<head>
		<title>Teddy Online Judge - Home</title>
		<link rel="stylesheet" type="text/css" href="css/teddy_style.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery-ui.custom.min.js"></script>
	</head>
<body>

<div class="wrapper">
	<?php include_once("includes/header.php"); ?>
	<?php include_once("includes/menu.php"); ?>
	<?php include_once("includes/session_mananger.php"); ?>	

	<div class="post_blanco">
        
		<div align="center" >
			<h2>Bienvenido a Teddy</h2>
		</div>



		<table>
		<tr>
		<td style="text-align:justify;">
		    	<p>Teddy es un oso de peluche, como se puede apreciar en la figura 1.0. Lo que lo distingue de los dem&aacute;s peluches es que Teddy sabe programar.
			<br><br>
			Introducido al mundo de la programaci&oacute;n a la tierna edad de d&iacute;a y medio de haber sido fabricado, Teddy es uno de los programadores m&aacute;s h&aacute;biles, habiendo resuelto todos los problemas del mundo. Conoce todos los trucos y t&eacute;cnicas para convertir un problema aparentemente imposible en algo tan sencillo que hasta un oso podr&iacute;a resolver.
			<br><br>
			Hoy en d&iacute;a, Teddy dedica su tiempo libre a ayudar a los programadores a resolver sus propios problemas, y les ofrece un reto cada semana para que practiquen. 
			<br><br>
			Teddy no tiene dificultad evaluando c&oacute;digo en C/C++, Java, Python, PHP, VisualBasic.NET (aunque VisualBasic 6 no es de su particular agrado), C# o Perl.
			<br><br>
			Teddy ir&aacute; llevando un conteo de qu&eacute; problemas ha resuelto cada quien, y en cu&aacute;nto tiempo. Si logras acumular una cantidad considerable de puntos, quien sabe... 

			<!-- &iexcl;Teddy te podr&iacute;a dar una sorpr<a href="h.php">e</a>sa! -->
			&iexcl;Teddy te podr&iacute;a dar una sorpresa!
			</p>
		</td>
		<td valign="top">
			<img style="border: 1px" src="img/teddy.jpg">
		</td>
		</tr>
		</table>

	</div>


	<?php include_once("includes/footer.php"); ?>

</div>

<?php include("includes/ga.php"); ?>
</body>
</html>

