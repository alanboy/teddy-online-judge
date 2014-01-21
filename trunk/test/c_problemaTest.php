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

		$arg = array(
				"titulo" => $titulo,
				"problema" => "contenido del probmea: " . $titulo,
				"tiempoLimite" => 3456,
				"entrada" => "1 1\n1 2\n100 100\n",
				"salida" => "2\n3\n200\n",
			);
		$result = c_problema::nuevo($arg);

		$this->assertTrue(SUCCESS($result));

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

	}

}

