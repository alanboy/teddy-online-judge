<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("includes/head.php");

	// This page requires a logged user
	require_once("includes/require_login.php")

		/*
	// Mark message as read
		if(isset($_REQUEST['enviado']) && $_REQUEST['enviado'] = "si"){
			echo '<div class="post_blanco"  align=center>';
			$msg = addslashes($_REQUEST['msg']);
			$q = "INSERT INTO Mensaje (de , para , mensaje, fecha ) VALUES (   '{$_SESSION['userID']}',  'alanboy',  '{$msg}', '" .date("Y-m-d H:i:s", time()).  "');";
			$resultado = mysql_query($q) or die('Donte be evil with teddy :P ' );
			echo "Mensaje enviado !";
			echo '</div>';
		}
		 */

?>
	<div class="post_blanco"  align=center>
		<?php
			
			if(!isset($_SESSION['userID'])){
				echo "Inicia session";
			}else{
				
				$q = "SELECT * FROM Mensaje WHERE de = '{$_SESSION['userID']}' OR para = '{$_SESSION['userID']}' ORDER BY fecha DESC";

				$resultado = mysql_query($q) or die('Donte be evil with teddy :P ');
			
				echo "<table border=0>";
				$total = 0;

				while($row = mysql_fetch_array($resultado)){

					?>
						
					<tr style="background-color: #white;">
						<td>De <b><?php echo $row['de']; ?></b>&nbsp;&nbsp;</td> <td>Para <b><?php echo $row['para']; ?></b>&nbsp;&nbsp;</td> <td>Fecha <b><?php echo $row['fecha']; ?></b>&nbsp;&nbsp;</td>
					</tr>
					<tr><td colspan=3><hr></td><tr>
					<tr style="background-color: #white;">
						<td colspan=3>
						<?php 
							//echo $row['mensaje']."<br>"; 
							// Order of replacement
							$str     = $row['mensaje'];
							$order   = array("\r\n", "\n", "\r");
							$replace = '<br />';

							// Processes \r\n's first so they aren't converted twice.
							$newstr = str_replace($order, $replace, $str);

							echo $newstr;
						?>
						</td>
					</tr>
					<tr>
						<td colspan=3>&nbsp;</td>
					</tr>
					<?php
				}
				echo "</table>";			
				?>
				
				
				<table border=0>
					<form class="form-big" method=POST >
						<tr><td>Enviar Mensaje</td></tr>
						<tr><td><textarea name="msg" cols=44 rows=5></textarea></td></tr>
						<tr><td><input type=submit value="Enviar Mensaje"></td></tr>					
						<input type=hidden name="enviado" value="si" >
					</form>
				</table>
				<?php
			}
			
		?>

	
	</div>

	<?php include_once("includes/footer.php"); ?>

