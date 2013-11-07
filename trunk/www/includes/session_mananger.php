<?php

function ok(){
	?>
	<div class="post">
		<div class="navcenter" align=center>
			<table border=0 style="width:100%">
				<tr class="navcenter">
					<td colspan=1>
						<a href="runs.php?user=<?php echo $_SESSION['userID']; ?>">
							<img id="avatar" src="https://secure.gravatar.com/avatar/<?php echo md5( $_SESSION['mail'] ); ?>?s=140" alt="" width="20" height="20"  />
						</a>
						Bienvenido <b><?php echo $_SESSION['userID']; ?></b> !<br>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="runs.php?user=<?php echo $_SESSION['userID']; ?>"><img src="img/67.png" > Mi perfil</a>					
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="editprofile.php"><img src="img/71.png" > Editar tu perfil</a>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="problemas.php?userID=<?php echo $_SESSION['userID']; ?>"><img src="img/67.png" > Problemas no resueltos</a>
					</td>

					
					<?php
					//buscar mensajes no leidos para este usuario
					$consulta = "select id from Mensaje where para = '{$_SESSION["userID"]}' AND unread = '1';";

					$resultado = mysql_query($consulta) or die('Donte be evil with teddy :P ' . mysql_error());

					if(mysql_num_rows($resultado) > 0){
						?>
							<script type="text/javascript">
								var foo = function(){
									$("#mailbox_menu").fadeTo("slow", .4, function(){
										$("#mailbox_menu").fadeTo("slow", 1, foo);
									});
								}

								$(document).ready( foo );
							</script>
						<?php
					}
					?>
					<td id="mailbox_menu">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="inbox.php">
								<img src="img/49.png" > 
								Mensajes (<?php echo mysql_num_rows($resultado) ?>)
							</a>
					
					</td>
					<?php
					?>

			<?php if (($_SESSION["userMode"] == "ADMIN")||($_SESSION["userMode"] == "OWNER")) { ?>
				<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin/"><img src="img/71.png" >Administracion</a>
				</td>
			<?php } ?>


			<td>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="includes/login_app.php?log_out=logout"><img src="img/55.png" > Cerrar Sesion</a>
			</td>

				</tr>
			</table>

		</div>
		
	</div>
	<?php
	}


	/* 
		no hay sesion activa
	*/
	function none(){
	?>
		<div class="post" >
			<div id="login_area" class="navcenter">
				<form method="post" onSubmit="return submitdata()">
					<img  src="img/37.png"> <input type="text" value="" id="user" placeholder="usuario">
					<img  src="img/55.png"> <input type="password" value="" id="pswd" placeholder="contrase&ntilde;a">
					<input type="submit" value="Iniciar Sesion">
					<input type="button" onClick="lost()" id="lost_pass" value="Olvide mi contase&ntilde;a"> 
				</form>
			</div>
			<div align=center id="wrong" style="display:none;">
				<img  src="img/12.png"> Datos invalidos
			</div>
			<div align=center id="message" style="display:none">
				<img src="img/load.gif">
			</div>
		</div>
	<?php
	}



	if(isset($_SESSION['status']) && $_SESSION['status'] == "OK") { 
		ok();
	}else{
		none();
	}
