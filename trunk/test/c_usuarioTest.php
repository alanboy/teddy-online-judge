<?php

class c_usuarioTest extends PHPUnit_Framework_TestCase
{
	public function testNuevoUsuarioSinParametros()
	{
		// Falta nick, ubicacion
		$arg = array(
			"nombre" => "foobar",
			"email" => "foo@example.net",
			"password" => "foobar123123",
			);
		$result = c_usuario::nuevo($arg);

		$this->assertTrue(!SUCCESS($result));
	}

	public function testNuevoUsuarioCorrecto()
	{
		$arg = array(
			"nombre" => "foobar",
			"email" => "foo@example.net",
			"password" => "foobar123123",
			"nick" => "u" . time(),
			"ubicacion" => "celaya" );
		$result = c_usuario::nuevo($arg);

		$this->assertTrue(SUCCESS($result));
	}

	public function testNuevoUsuarioDuplicado()
	{
		$arg = array(
			"nombre" => "foobar",
			"email" => "foo@example.net",
			"password" => "foobar123123",
			"nick" => "foobar123123",
			"ubicacion" => "celaya",
			);
		$result = c_usuario::nuevo($arg);

		$this->assertTrue(!SUCCESS($result));
	}

	public function testNuevoUsuarioNickInvalido()
	{
		$arg = array(
			"email" => "foo@example.net",
			"password" => "foobar123123",
			"nick" => "foobar123123",
			"ubicacion" => "celaya",
			);

		$arg["nick"] = " ";
		$result = c_usuario::nuevo($arg);
		$this->assertTrue(!SUCCESS($result));

		$arg["nick"] = " qwertyouioPPPPP.\"\"#$%&/";
		$result = c_usuario::nuevo($arg);
		$this->assertTrue(!SUCCESS($result));

		$arg["nick"] = "Eduardo#####{[]}";
		$result = c_usuario::nuevo($arg);
		$this->assertTrue(!SUCCESS($result));

		$arg["nick"] = "foobar with space";
		$result = c_usuario::nuevo($arg);
		$this->assertTrue(!SUCCESS($result));

		$arg["nick"] = "909090()()()()";
		$result = c_usuario::nuevo($arg);
		$this->assertTrue(!SUCCESS($result));

		$arg["nick"] = "veryloooooooooooooooooooooooooooooooooooooooooooooooooooooooooong";
		$result = c_usuario::nuevo($arg);
		$this->assertTrue(!SUCCESS($result));

		$arg["nick"] = "....";
		$result = c_usuario::nuevo($arg);
		$this->assertTrue(!SUCCESS($result));

		$arg["nick"] = "\"\'\n\r";
		$result = c_usuario::nuevo($arg);
		$this->assertTrue(!SUCCESS($result));
	}
}

