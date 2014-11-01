<?php 

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Concursos");

	require_once("head.php");

?>

<div class="">
	<ul id="subtabs" class="new-style clearfix">
		<li  class="subtab selected">
			<a href="#pasados" onclick="ShowTab( 'tab-concursos-pasados', this);">
			<span>Pasados</span>
			</a>
		</li>
		<li  class="subtab">
			<a href="#futuros" onclick="ShowTab( 'tab-concursos-futuros', this);">
			<span>Futuros</span>
			</a>
		</li>
		<li  class="subtab rightmost-tab">
			<a href="#activos" onclick="ShowTab( 'tab-concursos-activos', this);">
			<span>Activos</span>
			</a>
		</li>
		<li  class="subtab rightmost-tab">
			<a href="#nuevo" onclick="ShowTab( 'tab-concursos-nuevo', this);">
			<span>Crar un concurso</span>
			</a>
		</li>
	</ul>
</div>


<div id="tab-concursos-nuevo" class="post_blanco tab">
	<h2>Crear un concurso</h2>
	<?php include("parcial_nuevoconcurso.php"); ?>
</div>

<div id="tab-concursos-activos" class="post_blanco tab">
	<h2>Concursos Actuales</h2>
<?php
	$resultado = c_concurso::concursosActivos();
	if (SUCCESS($resultado))
	{
		$concursos = $resultado["concursos"];
		include "parcial_listadeconcursos.php";	
	}
?>
</div>

<div id="tab-concursos-pasados" class="post_blanco tab">
	<h2>Concursos Pasados</h2>
<?php
	$resultado = c_concurso::concursosPasados();
	if (SUCCESS($resultado))
	{
		$concursos = $resultado["concursos"];
		include "parcial_listadeconcursos.php";	
	}
?>
</div>

<div id="tab-concursos-futuros" class="post_blanco tab">

	<h2>Concursos Futuros</h2>
<?php
	$resultado = c_concurso::concursosFuturos();
	if (SUCCESS($resultado))
	{
		$concursos = $resultado["concursos"];
		include "parcial_listadeconcursos.php";	
	}
?>
</div>


<?php include_once("post_footer.php"); ?>

