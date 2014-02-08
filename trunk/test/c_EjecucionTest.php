<?php

class c_EjecucionTest extends PHPUnit_Framework_TestCase
{
	public function testNuevaEjecucion()
	{
		// Crear un usuario e iniciar sesion
		$nick = "p" . time();
		$uarg = array(
			"nombre" => "problem tester",
			"email" => $nick . "@example.net",
			"password" => "foobar23123",
			"nick" => $nick,
			"user" => $nick,
			"ubicacion" => "celaya" );
		$result = c_usuario::nuevo($uarg);
		$result = c_sesion::login($uarg);


		// Crear un nuevo problema
		$contents = $titulo = "prob" . time();

		for ($i = 0; $i < 100; $i++)
			$contents .= "lorem ipsum";

		$arg = array(
				"titulo" => $titulo,
				"problema" => $contents,
				"tiempoLimite" => 3456,
				"entrada" => "1 1\n1 2\n100 100\n",
				"salida" => "2\n3\n200\n",
			);
		$result = c_problema::nuevo($arg);


		// Crear un nuevo envio
		$arg = array(
			"id_problema" => $result["probID"],
			"lang" => "java",
			"plain_source" => "import java.io.*;
					class Main{ public static void main(String []a) throws Exception{
					BufferedReader br = new BufferedReader(new FileReader(\"data.in\"));
					PrintWriter pw = new PrintWriter((\"data.out\"));
					String s;
					while((s=br.readLine()) != null){
							pw.println(Integer.parseInt(s.split(\" \")[0])  + Integer.parseInt(s.split(\" \")[1])   );
					}
					pw.flush(); pw.close();
					} }" );

		$result = c_ejecucion::nuevo($arg);

		//Revisar el estado del run hasta que no sea waiting...
		$detalles = c_ejecucion::details($result);

		$retry = 0;
		while( ($retry < 5) &&  
				(($detalles["run"]["status"] == "WAITING" )
				|| (	$detalles["run"]["status"] == "JUDGING" )))
		{
			$retry++;
			sleep(1);
			$detalles = c_ejecucion::details($result);
		}

		$this->assertEquals( $detalles["run"]["status"], "OK" );
	}

}

