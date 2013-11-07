<?php

class c_problema extends c_controller
{
	
	public static function lista($request)
	{
		
			$consulta = "select probID, titulo, vistas, aceptados, intentos from Problema where publico = 'SI' ";
			$solved = array();
			if(isset($_GET["userID"]))
			{
				$query = "select distinct probID from Ejecucion where userID = '" . mysql_real_escape_string($_GET['userID']) . "' AND status = 'OK'";
				$resueltos = mysql_query($query) or die('Algo anda mal: ' . mysql_error());

				while($row = mysql_fetch_array($resueltos))
				{
					$solved[] = $row[0];
				}
			}
	
			if(isset($_GET["orden"])){
				$consulta .= (" ORDER BY " . mysql_real_escape_string($_GET["orden"])) ;
			}else{
				$consulta .= (" ORDER BY probID") ;
			}

			$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());

			if(isset($_GET["userID"])){

				echo "Hay un total de <b><span id='probs_left'></span></b> problemas no resueltos para <b>" . htmlentities( $_GET['userID'] ) . "</b>";
			}else{
				echo "Hay un total de <b>" . mysql_num_rows($resultado) . "</b> problemas<br>";
			}
	}

}
