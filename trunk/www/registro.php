<?php	

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");
	require_once("includes/head.php");

	if(isset($_REQUEST["form"]) && ($_REQUEST["form"] == true)):
		$nombre = addslashes($_REQUEST["nombre"]);
		$email = addslashes($_REQUEST["email"]);
		$password = crypt(addslashes($_REQUEST["password"]));
		$ubicacion = addslashes($_REQUEST["ubicacion"]);
		$escuela = addslashes($_REQUEST["escuela"]);
		$form = addslashes($_REQUEST["form"]);
		$nick = addslashes($_REQUEST["nick"]);
		$twitter = addslashes($_REQUEST["twitter"]);

		$query = "select * from Usuario where userID = '$nick' or mail = '$email'";
		$rs = mysql_query($query) or die('Algo anda mal: ' . mysql_error());

		$validate = false;

		if(mysql_numrows($rs)==0)
		{
			$query = "insert into Usuario(userID, nombre, pswd, ubicacion, escuela, mail, twitter) 
			values ('$nick','$nombre','$password','$ubicacion','$escuela', '$email', '$twitter')";
			$rs = mysql_query($query) or die("upts");
			$validate = true; 
		}
	endif;
?>
	<div class="post_blanco">
		<form action="" method="post" onsubmit="return validate()">
		<?php if(isset($_REQUEST["form"]) && ($_REQUEST["form"] == true)): ?>
			<?php if($validate): ?>
				<h2>bSuccess=true;</h2>
				<p>
					Hola <b><?php echo $nick ?></b> ! Haz sido seleccionado de una lista de miles para poder enviar problemas a Teddy ! Saluda a Teddy de mi parte. <br><div align="right">Atte: <b>El script de inscripcion </b>
				</p>
				</div>
			<?php else: ?>
				<h2>Ups :-(</h2>
				<p>
					Una de dos... o ya hay un usuario con este <b>nick</b> o ya esta registrado este <b>mail</b>. Hmm puedes intentar resetear tu contrase&ntilde;a o bien <a href="javascript:history.go(-1);">regresar</a> e intentar de nuevo. <br><div align="right">Atte: <b>El script de inscripcion </b></div>
				</p>
			<?php endif; ?>
		<?php else: ?>
			<p>
			Ingresa los datos necesarios para registrarte en el Juez Teddy.
			</p>
			<label for="nombre">
				Nombre Completo:
			</label>
			<input type="text" id="nombre" name="nombre" class="text" />
			<label for="email">
				Correo :
			</label>
			<input type="text" id="email" name="email" class="text" />

			<label for="twitter">
				twitter :
			</label>
			<input type="text" id="twitter" name="twitter" class="text" />

			<label for="nick">
				Nick (sin espacios):
			</label>
			<input type="text" id="nick" name="nick" class="text" />
			<label for="password">
				Password:
			</label>
			<input type="password" id="password" name="password" class="text" />
			<label for="re_password">
				Confirma Password:
			</label>
			<input type="password" id="re_password" name="re_password" class="text" />
			<label>
				Ubicación:
			</label>
			<select id="ubicacion" name="ubicacion" >
				<script language="javascript">
				for(var hi=0; hi<states.length; hi++)
				{
						document.write("<option value=\""+states[hi]+"\">"+states[hi]+"</option>");
				}
				</script>
			</select>
			<label>
				Escuela de Procedencia :
			</label>
			<input type="text" id="escuela" name="escuela" class="text" />
			<input type="submit" class="button" value="Registrar" />
			<input type="hidden" id="form" name="form" value="false" />
			<?php endif; ?> 
		</form>
	</div>

	<?php include_once("includes/footer.php"); ?>

