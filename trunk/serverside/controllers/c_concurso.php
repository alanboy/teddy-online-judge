<?php

class c_concurso extends c_controller
{
	public static function rank()
	{
		if(isset($_REQUEST['cid'])){
			$cid = addslashes($_REQUEST['cid']);
		}else{
			$cid = "-1";
		}

		$resultado = mysql_query( "select Inicio from Concurso where ( CID = {$cid}  ) ;" ) or die(mysql_error());
		$row = mysql_fetch_array($resultado);
		$inicio = $row['Inicio'];
		$data = array();
		
		$resultado = mysql_query( "select * from Ejecucion where ( Concurso = {$cid}  ) ;" );
		while($row = mysql_fetch_array($resultado)){

			//setear el userID
			//	userID->userID 
			$data[ $row[ 'userID' ] ][ 'userID' ] = $row['userID'];

			//setear penalty en cero
			//	userID->PENALTY = 0
			if(!isset($data[ $row[ 'userID' ] ]["PENALTY"])){
				$data[ $row[ 'userID' ] ]["PENALTY"] = 0;
			}


			//setear penalty en cero
			//	userID->PENALTY = 0
			if(!isset($data[ $row[ 'userID' ] ]["ENVIOS"])){
				$data[ $row[ 'userID' ] ]["ENVIOS"] = 0;
			}


			//setear penalty en cero
			//	userID->PENALTY = 0
			if(!isset($data[ $row[ 'userID' ] ]["RANK"])){
				$data[ $row[ 'userID' ] ]["RANK"] = 0;
			}

			//setear ok's en cero
			//	userID->OK = 0
			if(!isset($data[ $row[ 'userID' ] ]["OK"])){
				$data[ $row[ 'userID' ] ]["OK"] = 0;
			}

			//set this problem 
			// userID->problemas->probID = 0
			if(!isset($data[ $row[ 'userID' ] ][ "problemas" ][ $row['probID'] ])){
				$data[ $row[ 'userID' ] ][ "problemas" ][ $row['probID'] ]["probID"] = $row['probID'];
				$data[ $row[ 'userID' ] ][ "problemas" ][ $row['probID'] ]["bad"] = 0;
				$data[ $row[ 'userID' ] ][ "problemas" ][ $row['probID'] ]["ok"] = 0;
				$data[ $row[ 'userID' ] ][ "problemas" ][ $row['probID'] ]["ok_time"] = 0;
			}

			$data[ $row[ 'userID' ] ]["ENVIOS"]++;

			if($row["status"] == "OK") {

				//si resolvio el mismo problema, solo agregar uno al ok total
				if($data[ $row[ 'userID' ] ][ "problemas" ][ $row['probID'] ]["ok"] == 0 ) $data[ $row[ 'userID' ] ]["OK"]++;

				$data[ $row[ 'userID' ] ][ "problemas" ][ $row['probID'] ]["ok"]++;
				$data[ $row[ 'userID' ] ][ "problemas" ][ $row['probID'] ]["ok_time"] = intval( (strtotime($row['fecha'])-strtotime($inicio))/60 );

			}else{
				$data[ $row[ 'userID' ] ][ "problemas" ][ $row['probID'] ]["bad"]++;
			}

		}


		//calcular penalty
		foreach( $data as $userID => $userArr)
		{

			foreach( $userArr['problemas'] as $probID => $probArr)
			{
				//estoy en cada problema de cada usuario
				if( $probArr['ok'] == 0 ){
					continue;
				}

				$data[ $userID ]['PENALTY'] += ((int)$probArr['bad']) * 20 ;
				$data[ $userID ]['PENALTY'] += ((int)$probArr['ok_time'])  ;
			}
		}

		// Comparison function
		function cmp($a, $b)
		{
			if($a['OK'] == $b['OK']){
				if ($a['PENALTY'] == $b['PENALTY']){
					if ($a['ENVIOS'] == $b['ENVIOS']){
						return 0;
					}
					return ($a['ENVIOS'] < $b['ENVIOS']) ? -1 : 1;
				}
				return ($a['PENALTY'] < $b['PENALTY']) ? -1 : 1;
			}
			return ($a['OK'] > $b['OK']) ? -1 : 1;	
		}


		// SORTING
		uasort($data, 'cmp');

		//agregando el rank
		$R = 1;
		foreach( $data as $row => $k){
			if(isset($old)){
				if(($data[$old]["OK"] == $data[$row]["OK"]) && ($data[$old]["PENALTY"] == $data[$row]["PENALTY"])){
					$data[$row]['RANK'] = $R;
				}else{
					$R++;
					$data[$row]['RANK'] = $R;			
				}
			}else{
				$data[$row]['RANK'] = $R;		
			}

			$old = $row;
		}

		$data2 = array();
		$i = 0;
		foreach( $data as $row => $k){
			$data2[$i++] = $data[$row];
		}

		return array(
			"result" => "ok",
			"rank" => $data2
		);

	}


	public static function info($request)
	{
		$sql = "SELECT * from Concurso where CID = ? limit 1;";
		$inputarray = array($request["cid"]);

		global $db;
		$result = $db->Execute($sql, $inputarray);
		$resultData = $result->GetArray();

		$contest = null;
		if (sizeof($resultData)== 1)
		{
			$contest = $resultData[0];

			if( (time() > strtotime($contest["Inicio"])) 
				&& (time() < strtotime($contest["Final"]))) {
				$contest["status"] = "NOW";

			} else if ((time() > strtotime($contest["Final"]))) {
				$contest["status"] = "PAST";		

			}else if (time() < strtotime($contest["Inicio"])) {
				$contest["status"] = "FUTURE";

			}

			//$contest["status"] = "PAST";
		}

		return array(
					"result" => "ok",
					"concurso" => $contest
				);
	}

	public static function canshow()
	{
		//validar el concurso que voy a renderear
		if(!isset($_REQUEST["cid"]))
		{
			die(header("Location: contest.php"));
		}

		//validar que el concurso exista
		$q = "SELECT * from Concurso where CID = ". mysql_real_escape_string( $_REQUEST['cid'] ) .";";
		$resultado = mysql_query($q) or pretty_die("Error al buscar este concurso.");

		if(mysql_num_rows($resultado) != 1)
		{
			die("Este concurso no existe.");
		}

		$CONTEST = NULL;
		$STATUS = null;
		$CDATA = null;

		//este concurso existe
		$CONTEST = $_REQUEST['cid'] ;

		//revisar si, es pasado, actual, o en el futuro
		$row = mysql_fetch_array($resultado);

		// cdata contiene los datos de este concurso que trae el sql
		$CDATA = $row;	

		if( (time() > strtotime($row["Inicio"])) && ( time() < strtotime($row["Final"]) ) ){
			// activo
			$STATUS = "NOW";
		}

		if( (time() > strtotime($row["Final"])) ){
			// ya termino
			$STATUS = "PAST";		
		}

		if( time() < strtotime($row["Inicio"]) ){
			// activo
			$STATUS = "FUTURE";
		}
	}

	private static function concursosLista($sql)
	{
		$timestamp = date( "Y-m-d H:i:s" );

		$nArguments = substr_count($sql, '?');
		$inputarray = array(  );

		while ($nArguments-- > 0)
		{
			array_push($inputarray, $timestamp);
		}

		global $db;
		$result = $db->Execute($sql, $inputarray);
		$resultData = $result->GetArray();

		return array(
				"result" => "ok",
				"concursos" => $resultData
			);
	}

	public static function concursosActivos()
	{
		$sql = "select * from Concurso where BINARY ( ? > Inicio AND ?  < Final ) limit 10";
		return self::concursosLista($sql);
	}


	public static function concursosPasados()
	{
		$sql = "select * from Concurso where BINARY ( Final < ? ) order by Final  limit 50 ";
		return self::concursosLista($sql);
	}

	public static function concursosFuturos()
	{
		$sql = "select * from Concurso where BINARY ( Inicio > ? ) limit 10";
		return self::concursosLista($sql);
	}

	public static function nuevo()
	{
			$cname 	= addslashes($_REQUEST["cname"]);
			$cdesc 	= addslashes($_REQUEST["cdesc"]);
			$inicio = addslashes($_REQUEST["inicio"]);
			$fin 	= addslashes($_REQUEST["fin"]);
			$pset 	= addslashes($_REQUEST["pset"]);

			if (strlen($cname) < 5) {
			    $msg =  "Escribe un titulo mas explicativo.";
			    return array("result" => false, "msg" => $msg);
			}
			
			if (strlen($cdesc) < 5) {
			    $msg =  "Escribe una descripcion mas explicativa.";
			    return array("result" => false, "msg" => $msg);
			}
			
					
			//parsear fecha de inicio
			if (($time_inicio = strtotime($inicio)) === false) {
			    $msg =  "La fecha de inicio es invalida.";
			    return array("result" => false, "msg" => $msg);
			} 

			//que no sea en el pasado
			if(time() > $time_inicio){
				$msg = "No puedes iniciar un concurso en el pasado.";
				return array("result" => false, "msg" => $msg);
			}

			//parsear fecha de final
			if (($time_fin = strtotime($fin)) === false) {
			    $msg =  "La fecha de fin es invalida.";
			    return array("result" => false, "msg" => $msg);
			} 

			if($time_fin < $time_inicio){
				$msg = "El concurso no puede terminar... antes de comenzar.";
				return array("result" => false, "msg" => $msg);
			}

			$datetime1 = new DateTime($inicio);
			$datetime2 = new DateTime($fin);
			$intervalo = $datetime1->diff($datetime2);
			
			if( (($intervalo->format('%h')*60)+$intervalo->format('%i')) > (60*5)){
				$msg = "No puedes hacer concursos de mas de cinco horas.";
				return array("result" => false, "msg" => $msg);
			}
			
			
			//verificar los problemas
			$probs = explode(' ', $pset);
			
			if(sizeof($probs) >= 6){
				$msg = "Maximo 6 problemas";
				return array("result" => false, "msg" => $msg);
			}
			
			if(sizeof($probs) < 2){
				$msg = "Minimo 2 problemas";
				return array("result" => false, "msg" => $msg);
			}
			
			for ($i=0; $i< sizeof( $probs ); $i++) {
			
				//no puede haber dos problemas iguales
				//todo
				
				$query = "select probID from Problema where probID = '".addslashes($probs[ $i ])."' AND PUBLICO = 'SI'";				
				$rs = mysql_query($query) or die('Algo anda mal: ' . mysql_error());
				
				if(mysql_numrows($rs)!=1){
					$msg = "El problema " . $probs[ $i ] . " no existe.";
					return array("result" => false, "msg" => $msg);
				}
				
			}
			
			$query = "insert into Concurso(Titulo, Descripcion, Inicio, Final, Problemas, Owner) 
								   values ('$cname','$cdesc','" . date("Y-m-d H:i:s", $time_inicio) . "','" . date("Y-m-d H:i:s", $time_fin) . "','$pset', '" . $_SESSION['userID'] . "')";
			$rs = mysql_query($query) or die("Algo anda mal.");
			return array("result" => true, "msg" => "Concurso guardado.");
		}
}
