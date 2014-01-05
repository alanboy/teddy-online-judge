<?php

// Revisar que el usuario exista
$param = array(
		"nick" => $_GET["user"]
	);

$response = c_usuario::getByNickOrEmail($param);

if (SUCCESS($response))
{
	if (is_null($response["user"]))
	{
		//User does not exist
		return;
	}
	else
	{
		$user = $response["user"];
		?>
		<table border=0>
		<tr>
			<td>
			<span class="rounded_image" style="background-image:url(https://secure.gravatar.com/avatar/<?php echo md5( $user["mail"] ); ?>);">
				<img src="https://secure.gravatar.com/avatar/<?php echo md5( $user["mail"] ); ?>" style="opacity:0;">
			</span>
			</td>
			<td width='400px'>
				<h2><?php echo $user["userID"]; ?></h2>
				<b><?php echo $user["nombre"]; ?></b>
				<br>
				<?php echo $user["ubicacion"]; ?>
				<b> - </b>
				<?php echo $user["escuela"]; ?>
			</td>
			<td >
				<table border=0 >
					<tr align=center>
						<td ><b>Enviados</b></td>
						<td ><b>Resueltos</b></td>
						<td ><b>Radio</b></td>
						<!-- <td><b>Concursos</b>&nbsp;&nbsp;</td> -->
						<td><b>Twitter</b></td>
					</tr>
					<tr>
						<td><?php echo $user["tried"]; ?></td>
						<td><b><?php echo $user["solved"]; ?></b></td>
						<td><?php echo $user["ratio"]; ?></td>
						<!--<td> <?php //echo $user["n_concursos"]; ?></td>-->
						<td><?php echo $user["twitter"]; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
		<?php
	}
}

