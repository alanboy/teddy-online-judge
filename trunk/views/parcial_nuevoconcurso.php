

<form id="new_contest" action="" class="form-big" method="post" onsubmit="return validate()">
		<p>	Forma para crear un concurso </p>

		<label for="cname">Nombre del concurso</label>
		<input placeholder="Nombre del concurso" type="text" id="cname" name="cname" class="text"/>

		<label for="cdesc">Descripcion del concurso</label>
		<input placeholder="Descripcion del concurso" type="text" id="cdesc" name="cdesc" class="text" />

		<label for="inicio">Hora actual en Teddy (<?php echo date("d-m-Y H:i:s", mktime(date("H"), date("i") )); ?>)<br><br>
				Inicio del Concurso ( DD-MM-YYYY HH:MM:SS )
		</label>

		<input type="text" id="inicio" name="inicio" class="text" 
			value="<?php echo date("d-m-Y H:i:s", mktime(date("H"), date("i") + 10 )); ?>" />

		<label for="fin">Fin del Concurso ( DD-MM-YYYY HH:MM:SS )</label>
		<input type="text" id="fin" name="fin" class="text" 
			value="<?php echo date("d-m-Y H:i:s", mktime(date("H")+1, date("i") + 10 )); ?>"/>

		<label for="pset">Problemas, ID de los problemas separados por un espacio</label>
		<input placeholder="1 6 7" type="text" id="pset" name="pset" class="text" />

		<input type="submit" class="button" value="Agendar concurso" />
		<input type="hidden" id="form" name="form" value="true" />
</form>

