<?php

class c_problemaTest extends PHPUnit_Framework_TestCase
{
	public function testNuevoProblemaSinParametros()
	{
		// falta titulo
		$arg = array(
				"problema" => "",
				"tiempoLimite" => "",
				"entrada" => "",
				"salida" => "",
			);

		$result = c_problema::nuevo($arg);

		// esto debe fallar porque no hay sesion
		// y porque falta el parametro titulo
		$this->assertTrue(!SUCCESS($result));
	}

	public function testNuevoProblemaCorrecto()
	{
		$titulo = "a" . time();

		$rlistaprobs = array("public" => "NO");
		$res = c_problema::lista($rlistaprobs);
		$probs = $res["problemas"];
		$found = false;
		for($i =0; $i < sizeof($probs);  $i++)
		{
			if ($probs[$i]["titulo"] == $titulo)
			{
				$found = true;
				break;
			}
		}

		$this->assertTrue(!$found);


		$contents = "";
		for ($i = 0; $i < 100; $i++)
		{
			$contents .= "a";
		}
		$arg = array(
				"titulo" => $titulo,
				"problema" => $contents,
				"tiempoLimite" => 3456,
				"entrada" => "1 1\n1 2\n100 100\n",
				"salida" => "2\n3\n200\n",
			);

		// crear un usuario e iniciar sesion
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


		$result = c_problema::nuevo($arg);
		$this->assertTrue(SUCCESS($result));

		$this->assertTrue(SUCCESS($result), "Crear un nuevo problema correctamente");

		$rlistaprobs = array("public" => "NO");
		$res = c_problema::lista($rlistaprobs);
		$probs = $res["problemas"];
		$found = false;
		$found_prob = null;
		for($i =0; $i < sizeof($probs);  $i++)
		{
			if ($probs[$i]["titulo"] == $titulo)
			{
				$found = true;
				$found_prob = $probs[$i];
				break;
			}
		}
		$this->assertTrue($found);

		$this->assertEquals( $found_prob["titulo"], $arg["titulo"] );
		$this->assertEquals( $found_prob["problema"], $arg["problema"] );
		$this->assertEquals( $found_prob["tiempoLimite"], $arg["tiempoLimite"] );
		$this->assertEquals( $found_prob["usuario_redactor"], $argu["user"] );

	}

}

