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
		$nick = "a" . time();
		$arg = array(
			"nombre" => "foobar",
			"email" => $nick . "@example.net",
			"password" => "foobar123123",
			"nick" => $nick,
			"ubicacion" => "celaya" );
		$result = c_usuario::nuevo($arg);

		$this->assertTrue(SUCCESS($result));
	}

	public function testNuevoUsuarioDuplicado()
	{
		$nick = "b" . time();
		$mail = $nick . "@dup.com";

		$arg = array(
			"nombre" => "foobar",
			"email" => $mail,
			"password" => "foobar123123",
			"nick" => $nick,
			"ubicacion" => "celaya");

		$result = c_usuario::nuevo($arg);
		$this->assertTrue(SUCCESS($result), "Crear usuario base");

		$arg["email"] = "2" . $mail;
		$result = c_usuario::nuevo($arg);
		$this->assertTrue(!SUCCESS($result), "Duplicar nick");

		$arg["email"] = $mail;
		$arg["nick"] = "z".$nick;
		$result = c_usuario::nuevo($arg);
		$this->assertTrue(!SUCCESS($result), "Duplicar mail");
	}

	public function testNuevoUsuarioNickInvalido()
	{
		$arg = array(
			"email" => "foo@example.net",
			"password" => "foobar123123",
			"nick" => "foobar123123",
			"ubicacion" => "celaya",
			"nombre" => "nombre",
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

	public function testEditarUsuario()
	{
		$nick = "d".time();
		$arg = array(
			"email" => $nick . "@example.net",
			"password" => "foobar123123",
			"nick" => $nick,
			"ubicacion" => "celaya",
			"nombre" => "nombre",
			);

		$result = c_usuario::nuevo($arg);
		$this->assertTrue(SUCCESS($result), "Crear usuario correcto");

		$result = c_usuario::editar($arg);
		$this->assertTrue(SUCCESS($result), "Editar sin cambiar datos");

		$arg["escuela"] = "Nueva escuela";
		$result = c_usuario::editar($arg);
		$this->assertTrue(SUCCESS($result));

		// Validar que se cambio en efecto la escuela

		$arg["escuela"] = "Universidad de Matanzas Camilo Cienfuegos (UMCC)";
		$result = c_usuario::editar($arg);
		$this->assertTrue(SUCCESS($result), "parentesis permitidos en escuela");

		$arg["escuela"] = "#file_links[E:\riwenkey.txt,1,S]";
		$result = c_usuario::editar($arg);
		$this->assertTrue(!SUCCESS($result), "editar a algo muy raro");

		$arg["escuela"] = "veryloooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooong";
		$result = c_usuario::editar($arg);
		$this->assertTrue(!SUCCESS($result), "editar escuela texto largo");

		$arg["escuela"] = "\"\'\n\r";
		$result = c_usuario::editar($arg);
		$this->assertTrue(!SUCCESS($result));
	}
}

