<?php

	$menu = array(
		"default" => array(
			"/index" => "home",
			"/problemas" => "problemas",
			"/enviar" => "enviar ",
			"/runs" => "ejecuciones",
			"/rank" => "rank",
			"/contest" => "concursos",
			"/faq" => "ayuda ",
		),
		"USER" => array(
			"/index" => "home",
			"/problemas" => "problemas",
			"/enviar" => "enviar ",
			"/runs" => "ejecuciones",
			"/rank" => "rank",
			"/contest" => "concursos",
			"/faq" => "ayuda ",
		),
		"ADMIN" => array(
			"/index" => "home",
			"/problemas" => "problemas",
			"/enviar" => "enviar ",
			"/runs" => "ejecuciones",
			"/rank" => "rank",
			"/contest" => "concursos",
			"/faq" => "ayuda ",
			"/admin/problemas" => "<b>problemas</b>",
			"/nuevoproblema" => "<b>nuevo problema</b>",
			"/admin/soluciones" => "<b>soluciones</b>",
			"/admin/runs" => "<b>ejecuciones</b>",
			"/admin/usuarios" => "<b>usuarios</b>",
		),
		"OWNER" => array(
			"/index" => "home",
			"/problemas" => "problemas",
			"/enviar" => "enviar ",
			"/runs" => "ejecuciones",
			"/rank" => "rank",
			"/contest" => "concursos",
			"/faq" => "ayuda ",
			"/admin/test" => "estado",
			"/admin/problemas" => "problemas",
			"/admin/soluciones" => "soluciones",
			"/admin/inbox" => "mensajes",
			"/admin/runs" => "ejecuciones",
			"/admin/usuarioslaksjf" => "usuarios",
			"/admin/log" => "log",
			"/admin/config" => "configuracion"
		)
	);

?><div class="post">
	<div class="navcenter">
		<?php
		$usermenu = $menu["default"];
		$result = c_sesion::usuarioActual();

		if (SUCCESS($result))
		{
			switch($result["user"]["cuenta"])
			{
				case "USER":
				case "ADMIN":
				case "OWNER":
					$usermenu = $menu[$result["user"]["cuenta"]];
			}
		}

		foreach ($usermenu as $key => $value )
		{
			echo "<a href=\"" . $key . ".php\">". $value ."</a>&nbsp;&nbsp;&nbsp;";
		}
		?>
	</div>
</div>


<div id="notif_area"  class="post hidden" >
	<div class="navcenter">
	</div>
</div>

