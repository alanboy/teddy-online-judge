<?php 

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Concursos");

	require_once("head.php");

?>
<div class="post_blanco">
	<ul id="subtabs" class="new-style clearfix">
		<li  class="subtab selected">
			<a href="#profile" onclick="ShowTab( 'tab-concursos-pasados');">
			<span>Pasados</span>
			</a>
		</li>
		<li  class="subtab">
			<a href="#personal" onclick="ShowTab( 'tab-concursos-futuros');">
			<span>Futuros</span>
			</a>
		</li>
		<li  class="subtab rightmost-tab">
			<a href="#newsecurity" onclick="ShowTab( 'tab-confursos-activos');">
			<span>Activos</span>
			</a>
		</li>
		<li  class="subtab rightmost-tab">
			<a href="#newsecurity" onclick="ShowTab( 'tab-concursos-nuevo');">
			<span>Crar un concurso</span>
			</a>
		</li>
	</ul>
</div>


<div id="tab-concursos-nuevo" class="post_blanco tab">
	<h2>Crear un concurso</h2>
	<?php include("form.new-contest.php"); ?>
</div>

<div id="tab-concursos-activos" class="post_blanco tab">
	<h2>Concursos Actuales</h2>
<?php
	$resultado = c_concurso::concursosActivos();
	if (SUCCESS($resultado))
	{
		gui::listaDeConcursos($resultado["concursos"]);
	}
?>
</div>

<div id="tab-concursos-pasados" class="post_blanco tab">
	<h2>Concursos Pasados</h2>
<?php
	$resultado = c_concurso::concursosPasados();
	if (SUCCESS($resultado))
	{
		gui::listaDeConcursos($resultado["concursos"]);
	}
?>
</div>

<div id="tab-concursos-futuros" class="post_blanco tab">

	<h2>Concursos Futuros</h2>
<?php
	$resultado = c_concurso::concursosFuturos();
	if (SUCCESS($resultado))
	{
		gui::listaDeConcursos($resultado["concursos"]);
	}
?>
</div>


<?php include_once("footer.php"); ?>

