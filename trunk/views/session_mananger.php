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
								// Get email from db
								// echo md5( $_SESSION['mail'] ); 
							?>?s=140" alt="" width="20" height="20"  />
						</a>
						Bienvenido <b><?php echo $_SESSION['userID']; ?></b> !<br>
					</td>
					<td>
						<a href="runs.php?user=<?php echo $_SESSION['userID']; ?>"><img src="img/67.png" > Mi perfil</a>
					</td>
					<td>
						<a href="editprofile.php"><img src="img/71.png" > Editar tu perfil</a>
					</td>
					<td>
						<a href="problemas.php?userID=<?php echo $_SESSION['userID']; ?>"><img src="img/67.png" > Problemas no resueltos</a>
					</td>
					<td id="mailbox_menu">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="inbox.php">
								<img src="img/49.png" > Mensajes (0)
							</a>
					</td>
					<?php 
					if(c_sesion::isLoggedIn()) 
					{
						?>
						<td>
							<a href="admin/"><img src="img/71.png" >Administracion</a>
						</td>
						<?php
						}
					?>
					<td>
						<a onClick="logout()"><img src="img/55.png" > Cerrar Sesion</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php

	}else{

		?>
		<div class="post" >
			<div id="login_area" class="navcenter">
				
				<form id="login-form-top-nav" method="POST" >
					<img  src="img/37.png"> <input type='text' id="user" name="user"  placeholder="Usuario o Email" />
					<img  src="img/55.png"> <input type='password' id="pass" name="pass" placeholder="Contrase&ntilde;a" />
					<input type="submit" class="button" value="Iniciar sesion"  />
					<input type="button" class="button" value="Olvide mi contrase&ntilde;a" onClick="RequestResetPass(this)" />
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
