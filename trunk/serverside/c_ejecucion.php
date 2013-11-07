<?php

class c_ejecucion extends c_controller
{
	public static function nuevo()
	{
	global $CDATA;	

	//tomo el valor de un elemento de tipo texto del formulario
	$usuario 		= $_SESSION	["userID"];
	$prob    		= $_POST["prob"];
	$CONCURSO_ID 	= $_REQUEST['cid'];

	//revisar que su ultimo envio sea mayor a 5 minutos
	//revisar que este problema exista para este concurso
	$PROBLEMAS = explode(' ', $CDATA["Problemas"]);

	$found = false;

	for ($i=0; $i< sizeof( $PROBLEMAS ); $i++)
	{
		if($prob ==$PROBLEMAS[$i]) $found = true;
	}

	if(!$found)
	{
		echo "<br><div align='center'><b>Ups, este problema no es parte de este concurso.</b><br><br></div>";
		imprimirForma();
		return;
	}

	//revisar si existe este problema
	$consulta = "select probID , titulo from Problema where BINARY ( probID = '{$prob}' ) ";
	$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());

	//si este problema no existe, salir
	if(mysql_num_rows($resultado) != 1)
	{
		echo "<br><div align='center'><b>Ups, este problema no existe.</b><br>Vuelve a intentar. Recuerda que el id es el numero que acompa&ntilde;a a cada problema.<br><br></div>";
		imprimirForma();
		return;
	}

	$row = mysql_fetch_array( $resultado );
	$TITULO = $row["titulo"];

	//datos del archivo
	$nombre_archivo = $_FILES['userfile']['name'];
	$tipo = $_FILES['userfile']['type'];
	$fname = $_FILES['userfile']['name'];

	//revisar que no existan espacios en blacno en el nombre del archivo
	$fname = strtr($fname, " ", "0");
	$fname = strtr($fname, "_", "0");
	$fname = strtr($fname, "'", "0");

	//compruebo si las características del archivo son las que deseo
	//si (no es text/x-java) y (no termina con .java) tons no es java
	if (!(endsWith($fname, ".java") || endsWith($fname, ".c") || endsWith($fname, ".cpp")|| endsWith($fname, ".py") || endsWith($fname, ".pl")) )
	{
		echo "<br><br><div align='center'><h2>Error :-(</h2>Debes subir un archivo que contenga un codigo fuente valio y que termine en alguna de las extensiones que <b>teddy</b> soporta.<br>";
		echo "Tipo no permitido: <b>". $tipo . "</b> para <b>". $_FILES['userfile']['name'] ."</b></div><br>";
		imprimirForma();
		return;
	}

	//insertar userID, probID, remoteIP
	mysql_query ( "INSERT INTO Ejecucion (`userID` , `probID` , `remoteIP`, `Concurso`) VALUES ('{$usuario}', {$prob}, '" . $_SERVER['REMOTE_ADDR']. "', " . $_REQUEST['cid'] . "); " ) or die('Algo anda mal: ' . mysql_error());
	$resultado = mysql_query ( "SELECT `execID` FROM `Ejecucion` order by `fecha` desc limit 1;" ) or die('Algo anda mal: ' . mysql_error());
	$row = mysql_fetch_array ( $resultado );

	$execID = $row["execID"];

	//mover el archio a donde debe de estar
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], "../codigos/" . $execID . "_" . $fname)){

	}else{
		//if no problem al subirlo	
		echo "Ocurrio algun error al subir el archivo. No pudo guardarse.";
	}

	imprimirForma();
}
	}

}
