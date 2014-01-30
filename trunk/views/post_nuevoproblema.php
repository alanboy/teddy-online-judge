<div class="post_blanco">
	<?php
		if (is_null($editarproblema))
		{
			?><h2>Crear un nuevo problema</h2><?php
		}
		else
		{
			?><h2>Editar problema</h2><?php
		}
	?>
<form class="form-big" method="post">

	<p>Aqui van instrucciones y recomencadaciones para crear un problema.</p>

	<label for="titulo">
		Titulo:
	</label>
	<input type="text" name="titulo"  class="text datos" placeholder="titulo"
			<?php
			if (!is_null($editarproblema))
			{
				echo "value=\"". $editarproblema["titulo"] ."\"";
			}
			?>
			/>

	<label for="tiempoLimite">
		Tiempo limite (segundos):
	</label>
	<input type="text" name="tiempoLimite"  class="text datos" placeholder="tiempolimite"
			<?php
			if (!is_null($editarproblema))
			{
				echo "value=\"". $editarproblema["tiempoLimite"] ."\"";
			}
			?>
			/>

	<label for="problema">
		Redaccion del problema:
	</label>
	<textarea name="problema"  class="text datos" placeholder="problema"><?php
			if (!is_null($editarproblema))
			{
				echo $editarproblema["problema"] ;
			}
			?></textarea>

	<label for="entrada">
		Casos de prueba(entrada):
	</label>
	<textarea name="entrada"  class="text datos" placeholder="entrada"></textarea>

	<label for="salida">
		Casos de prueba(salida):
	</label>
	<textarea name="salida"  class="text datos" placeholder="salida"></textarea>

	<?php
		if (is_null($editarproblema))
		{
			?><input type="button" onClick="NuevoProblema(this)" value="Crear nuevo problema"><?php
		}
		else
		{
			?><input type="button" onClick="EditarProblema(this)" value="Guardar cambios"><?php
		}
	?>
</form>
<Script>
	function NuevoProblema(form){
		Util.SerializeAndCallApi(
			$(form).parent(),
			Teddy.c_problema.nuevo,
			function(result) {
				Teddy.msg("Revisa tu correo electronico");
			});
		return false;
	}
</Script>
</div>

