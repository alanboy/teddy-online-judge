<?php

	require_once("../../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("../includes/head.php");

	// This page requires a logged user
	require_once("includes/require_login.php")

?>
	<div class="post_blanco"  align=center>
				<table border=0>
					<form class="form-big" method=POST >
						<tr><td>Enviar Mensaje</td></tr>
						<tr><td>Para<input name="para" type=text id="msg_to"></td></tr>
						<tr><td><textarea name="msg" cols=44 rows=5></textarea></td></tr>
						<tr><td><input type=submit value="Enviar Mensaje"></td></tr>
						<input type=hidden name="enviado" value="si" >
					</form>
				</table>
				<?php
				$q = "SELECT * FROM Mensaje WHERE de = '{$_SESSION['userID']}' OR para = '{$_SESSION['userID']}' ORDER BY fecha DESC";
				echo "<table border=0>";
				$total = 0;
				while($row = mysql_fetch_array($resultado))
				{
?>

						<tr style="background-color: #white;">
							<td>De <b><?php echo $row['de']; ?></b>&nbsp;&nbsp;</td> 
							<td>Para <b><?php echo $row['para']; ?></b>
								&nbsp;&nbsp;<span style="cursor: pointer" onclick="document.getElementById('msg_to').value = '<?php echo $row['para']; ?>';">[reply]</span>&nbsp;&nbsp;
<?php
					if($row['unread'] != 0){
						?>&nbsp;&nbsp;<span>[UNREAD]</span>&nbsp;&nbsp; <?php
					}

?>
							</td> 
							<td>Fecha <b><?php echo $row['fecha']; ?></b>&nbsp;&nbsp;</td>
						</tr>
						<tr><td colspan=3><hr></td><tr>
						<tr style="background-color: #white;">
						<td colspan=3><?php 
					//echo $row['mensaje']."<br>"; 
					// Order of replacement
					$str     = $row['mensaje'];
					$order   = array("\r\n", "\n", "\r");
					$replace = '<br />';

					$newstr = str_replace($order, $replace, $str);

					echo $newstr;
?></td>
						</tr>
						<tr>
							<td colspan=3>&nbsp;</td>
						</tr>
<?php
				}
				echo "</table>";
		?>
	</div>

	<?php include_once("../includes/footer.php"); ?>

