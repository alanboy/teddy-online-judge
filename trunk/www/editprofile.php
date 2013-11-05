<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");
	require_once("includes/head.php");

	if(isset($_REQUEST["form"]) && ($_REQUEST["form"] == true)):

		$nombre = addslashes($_REQUEST["nombre"]);
		$email = addslashes($_REQUEST["email"]);
	//	$ubicacion = addslashes($_REQUEST["ubicacion"]);
		$escuela = addslashes($_REQUEST["escuela"]);
		$form = addslashes($_REQUEST["form"]);

		$twitter = addslashes($_REQUEST["twitter"]);

		$query = "update  `Usuario` 
			SET  nombre = '{$nombre}', escuela = '{$escuela}', mail = '{$email}', `twitter` =  '{$twitter}' 
			WHERE  `Usuario`.`userID` =  '{$_SESSION['userID']}' LIMIT 1 ;";

		$rs = mysql_query($query) or die(mysql_error());

	endif;

	
?>

	<div class="post" >
		<?php function showContent($datos){ ?>
		<form action="" method="post" onsubmit="return validate()" class="datos" 
			style="width: 500px; 
				margin:auto;
				margin-top:30px;
				padding:30px;
				border:1px solid #bbb;
				-moz-border-radius:11px;">
				
		<?php if(isset($_REQUEST["form"]) && ($_REQUEST["form"] == true)): ?>
			<?php if(true): ?>
				<h2>Yeah !!   &nbsp;&nbsp;&nbsp;  :-)</h2>
				<p>
					Hola <b><?php echo $_SESSION['userID'] ?></b> ! Haz editado correctamente tus datos !<br/> Saluda a Teddy de mi parte. <br><div align="right">Atte: <b>El script de edicion de perfiles. </b></div>
				</p>
			<?php else: ?>
				<h2>Ups :-(</h2>
				<p>
					Una de dos... o ya hay un usuario con este <b>nick</b> o ya esta registrado este <b>mail</b>. Hmm puedes intentar resetear tu contrase&ntilde;a o bien <a href="javascript:history.go(-1);">regresar</a> e intentar de nuevo. <br><div align="right">Atte: <b>El script de edicion de perfiles. </b></div>
				</p>
			<?php endif; ?>
		<?php else: ?>
			<p>
				Aqui puedes cambiar los datos de tu perfil. Todo menos tu nick.
			</p>
			
			<label for="nick">
				Nick :
			</label>
			<input type="text" id="nick" name="nick" class="text" value="<?php echo $datos['userID']; ?>" DISABLED/>
			
			<label for="nombre" class="datos">
				Nombre Completo:
			</label>
			<input type="text" id="nombre" name="nombre" class="text datos" value="<?php echo $datos['nombre']; ?>"/>
			
			<label for="email" class="datos">
				Correo :
			</label>
			<input type="text" id="email" name="email" class="text datos" value="<?php echo $datos['mail']; ?>"/>
			
			<label for="twitter">
				twitter :
			</label>
			<input type="text" id="twitter" name="twitter" class="text" value="<?php echo $datos['twitter']; ?>"/>
			
<!--
			<label for="password">
				Password:
			</label>
			<input type="password" id="password" name="password" class="text" value=""/>
			<label for="re_password">
				Confirma Password:
			</label>
			<input type="password" id="re_password" name="re_password" class="text" value=""/>
-->

			<label>
				Escuela de Procedencia :
			</label>
			<input type="text" id="escuela" name="escuela" class="text" value="<?php echo $datos['escuela']; ?>"/>
			<input type="submit" class="button" value="Actualizar mis datos" />
			<input type="hidden" id="form" name="form" value="false" />
			<?php endif; ?> 
		</form>
		<?php } ?>

		<?php 
			if( ! isset($_SESSION['userID'] ) ){
				?> <div align="center">Debes iniciar sesion en la parte de abajo para poder editar tus datos.</div> <?php
			}else{
				
				
					//mysql_query("select * from Usuario where userID = '". slashes() ."'")
					$query = sprintf("select * FROM Usuario WHERE userID='%s'", mysql_real_escape_string($_SESSION['userID']));
					//echo $query;
					$foo = mysql_query($query) or die(mysql_error());
					//echo ">" . mysql_num_rows($foo). "< <br>";
					$r = mysql_fetch_array($foo);
					//var_dump($r);
					showContent($r);
			}
		?>
	</div>

	<?php include_once("includes/footer.php"); ?>

