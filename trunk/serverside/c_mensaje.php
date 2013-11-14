<?php

class c_mensaje extends c_controller
{
	
	public static function nuevo()
	{
		if(isset($_REQUEST['enviado']) && $_REQUEST['enviado'] = "si"){
			echo '<div class="post_blanco"  align=center>';

			$msg = addslashes($_REQUEST['msg']);
			$para = addslashes($_REQUEST['para']);
			$q = "INSERT INTO Mensaje (de , para , mensaje, fecha ) VALUES (   '{$_SESSION['userID']}',  '{$para}',  '{$msg}', '" .date("Y-m-d H:i:s", time()).  "');";
			$resultado = mysql_query($q) or die('Donte be evil with teddy :P ' );
			echo "Mensaje enviado !";
			echo '</div>';
		}
	}

	public static function markasread()
	{
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
	}
	
	public static function lista()
	{
		$sql = "SELECT * FROM Mensaje WHERE de = ? OR para = ? ORDER BY fecha DESC";
	
	}

	public static function nuevo()
	{}

	public static function nuevo()
	{}
}
