<?php 
	require_once("bootstrap.php");

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/teddy_style.css" />
		<title>Teddy Online Judge - Enviar solucion</title>
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery-ui.custom.min.js"></script>

        <script type="text/javascript" src="uploadify/swfobject.js"></script>
        <script type="text/javascript" src="uploadify/jquery.uploadify.v2.1.0.min.js"></script>
		<link rel="stylesheet" type="text/css" href="uploadify/uploadify.css" />
		
	</head>
<body>
<div class="wrapper">

	<?php include_once("includes/header.php"); ?>
	<?php include_once("includes/menu.php"); ?>
	<?php include_once("includes/session_mananger.php"); ?>	

	<div class="post_blanco" style="background:white;" >

		<div class="subtitle" align="center">enviar solucion</div>

		<?php

		/* **************
			Start
		************** */

		if( ! isset($_SESSION['userID'] ) ){
			?> <div align="center">Debes iniciar sesion en la parte de arriba para poder enviar problemas a <b>Teddy</b>.</div> <?php
			
		}else{
			envios::imprimir_forma_de_envio();

		}

		?>

		</div>


	<?php include_once("includes/footer.php"); ?>
	</div>
<?php include("includes/ga.php"); ?>
</body>
</html>

