<?php

require_once("../../serverside/bootstrap.php");


function decrypt($s){
	$final_pass = "";
	$v = str_split($s, 9);
	$b = "";
	foreach( $v as $t){
		$word = "";
		for($i =0 ; $i < strlen($t); $i++){

			if( ctype_upper( $t{$i} ) ) $word .= "1";
				else $word .= "0";
		}
		$b .= $word;
	}

	$v = str_split($b, 9);
	$key = bindec  ( $v[0] );
	
	for( $i = 1; $i < count($v); $i++){
		$car = bindec($v[$i]);
		if( $i % 2 == 0) $car += $key;
			else $car -= $key;
		$final_pass .= chr($car);
	}

	return $final_pass;
}



if(isset($_REQUEST["log_out"])){
	unset($_SESSION['status']);
	unset($_SESSION['userID']);
	unset($_SESSION['userMode']);
	unset($_SESSION['mail']);
	echo "<script> window.location = '" . $_SERVER['HTTP_REFERER'] . "';</script>";			
	return;		
}

if (!isset($_POST["user"])) {
    TEDDY_LOG("Faltan parametros para iniciar sesion");
    echo json_encode(array(
        "sucess" => false,
        "success" => false
    ));
    return;
}

$usuario = addslashes( $_POST["user"] );
$pass = decrypt($_POST["pswd"]);

if (($usuario != $_POST["user"])) {
	echo "{\"sucess\": false, \"badguy\": true, \"msg\": \"Portate bien <b>". $_SERVER['REMOTE_ADDR'] ."</b>\"}";
	return;
}

//consultasr contraseña de estre presunto usuario
$consulta = "select pswd, cuenta, userID, mail from Usuario where BINARY ( userID = '{$usuario}' or mail = '{$usuario}')";
$resultado = mysql_query($consulta) or die('Dont be evil with teddy :P ');
TEDDY_LOG("hi there");

//si regreso 0 resultados tons este usuario ni existe
if(mysql_num_rows($resultado) != 1) {
	$_SESSION['status'] = "WRONG";
	if( isset($resultado))
		mysql_free_result($resultado);
	mysql_close($enlace);
	echo "{\"sucess\": false, \"badguy\": false}";
	return;
}


//si existe este usuario, revisar su contraseña
$row = mysql_fetch_array($resultado);

if(crypt($pass, $row[0] ) != $row[0]){
	$_SESSION['status'] = "WRONG";
	echo "{\"sucess\": false, \"badguy\": false}";
	if( isset($resultado))
 		mysql_free_result($resultado);
	mysql_close($enlace);
	return;
}




$_SESSION['userID'] = $row['userID'];
$_SESSION['mail'] = $row['mail'];
$_SESSION['status'] = "OK";
$_SESSION['userMode'] = $row["cuenta"] ;
echo "{\"sucess\": true, \"badguy\": false}";

if( isset($resultado))
	mysql_free_result($resultado);

if(isset($enlace))
	mysql_close($enlace);
		
?>
