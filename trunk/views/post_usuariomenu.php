<?php

if (c_sesion::isLoggedIn()) {
	?>
	<div class="post">
		<div class="navcenter" align=center>
			<table border=0 style="width:100%">
				<tr class="navcenter">
					<td colspan=1>
						<a href="runs.php?user=<?php echo $_SESSION['userID']; ?>">
							<img id="avatar" src="https://secure.gravatar.com/avatar/<?php 
								$res = c_sesion::usuarioActual();
								if (SUCCESS($res)) {
									$user = $res["user"];
									echo md5($user['mail']);
								}
							?>?s=140" alt="" width="20" height="20"  />
						<b><?php echo $_SESSION['userID']; ?></b> !<br>
						</a>
					</td>
					<td>
						<a href="editprofile.php"><img src="img/71.png" > Editar tu perfil</a>
					</td>
					<td id="mailbox_menu">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="inbox.php">
								<img src="img/49.png" > Mensajes
							</a>
					</td>
					<td>
						<a onClick="LogOut()" style="cursor:pointer"><img src="img/55.png" > Cerrar Sesion</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<script>
	function LogOut()
	{
		Teddy.c_sesion.logout([],
		function(result) {
			window.location.reload( false );
		});
	}
	</script>
	<?php

	}else{ // No hay sesion

		?>
		<div class="post" >
			<div id="login_area" class="navcenter">
				
				<form id="login-form-top-nav" method="POST" >
					<img  src="img/37.png"> <input type='text' id="user" name="user"  placeholder="Usuario o Email" />
					<img  src="img/55.png"> <input type='password' id="pass" name="pass" placeholder="Contrase&ntilde;a" />
					<input type="submit" class="button" value="Iniciar sesion"  />
					<input type="button" class="button" value="Olvide mi contrase&ntilde;a" onClick="RequestResetPass(this)" />
					 o
					<a href="registro.php"><input type="button" class="button" value="Crea una cuenta" onClick="" /></a>
				</form>
			</div>

			<div align=center id="wrong" style="display:none;">
				<img  src="img/12.png"> Datos invalidos
			</div>
			<div align=center id="message" style="display:none">
				<img src="img/load.gif">
			</div>
		</div>
		<script>

		function RequestResetPass(form)
		{
			if ($("#user").val().length < 4)
			{
				return Teddy.error("Escribe tu usuario o correo");
			}

			Util.SerializeAndCallApi( 
				$(form).parent(),
				Teddy.c_usuario.RequestResetPass,
				function(result) {
					Teddy.msg("Revisa tu correo electronico");
				});
		}
	
		function IniciarSesionTopNav()
		{
			Util.SerializeAndCallApi( 
				$("#login-form-top-nav"), 
				Teddy.c_sesion.iniciar,
				function(result) {
					window.location = "runs.php?user=" + result.user.userID;
				});
			return false;
		}

		$("#login-form-top-nav").submit(IniciarSesionTopNav);
		</script>
		<?php
	}
