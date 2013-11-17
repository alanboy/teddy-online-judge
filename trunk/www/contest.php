<?php 

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Concursos");

	require_once("includes/head.php");

?>
<table>
	<tr>
	<td valign=top>
	<div id="new_contest_form" class="post_blanco">
		<h2>Crear un concurso</h2>
		<?php include("includes/form.new-contest.php"); ?>
	</div>
	</td>
	<td>
	<div class="post">
		<table >
			<tr  style="vertical-align: top">
				<td>
				<h2>Concursos Actuales</h2>
				<?php
				$resultado = c_concurso::concursosActivos();
				if (SUCCESS($resultado))
				{
					gui::listaDeConcursos($resultado["concursos"]);
				}
				?>
				</td>
				<td>
				<h2>Concursos Pasados</h2>
				<?php
				$resultado = c_concurso::concursosPasados();
				if (SUCCESS($resultado))
				{
					gui::listaDeConcursos($resultado["concursos"]);
				}
				?>
				</td>
				<td>
				<h2>Concursos Futuros</h2>
				<?php
				$resultado = c_concurso::concursosFuturos();
				if (SUCCESS($resultado))
				{
					gui::listaDeConcursos($resultado["concursos"]);
				}
				?>
				</td>
			</tr>
		</table>
</div>
</td>
</tr>
</table>

<?php include_once("includes/footer.php"); ?>

