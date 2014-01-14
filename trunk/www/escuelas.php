<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("head.php");

	$escuelas = c_escuela::lista();
	$escuelas = $escuelas["escuelas"];
	require_once("post_escuelas.php");

	require_once("post_footer.php");



