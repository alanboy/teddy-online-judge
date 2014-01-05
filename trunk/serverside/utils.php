<?php

function SUCCESS($res)
{
	if ($res["result"] != "ok") {
		// Log?
	}
	return $res["result"] === "ok";
}

function sanitize($res)
{
	return $htmlentities(utf8_decode($res));
}



class utils
{
	function endsWith( $str, $sub )
	{
		return ( substr( $str, strlen( $str ) - strlen( $sub ) ) == $sub );
	}

	public static function color_result( $res )
	{
		switch($res){
			case "COMPILACION":
				return "<span style='color:red;'>" . $res . "</span>";
				
			case "TIEMPO":
				return "<span style='color:brown;'>" . $res . "</span>";
				
			case "OK":
				return "<span style='color:green;'><b>" . $res . "</b></span>";
				
			case "RUNTIME_ERROR":
				return "<span style='color:blue;'><b>" . $res . "</b></span>";				
				
			case "INCORRECTO":
				return "<span style='color:red;'><b>" . $res . "</b></span>";				
				
			case "JUDGING":
				
			case "WAITING":
				return "<span style='color:purple;'>" . $res . "...</span>";	//<img src='img/load.gif'>
		}
		return $res;
	}
}
