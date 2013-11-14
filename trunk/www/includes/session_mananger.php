<?php

if (isset($_SESSION['userID'])) 
{
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
					//if (($_SESSION["userMode"] == "ADMIN")||($_SESSION["userMode"] == "OWNER")) 
					if(0) // Test for admin from DB
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
			<form method="post" onSubmit="return login()">
				<img  src="img/37.png"> <input type="text" value="" id="user" placeholder="usuario o email">
				<img  src="img/55.png"> <input type="password" value="" id="pass" placeholder="contrase&ntilde;a">
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

