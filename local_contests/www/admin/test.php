<?php


    session_start();

	include_once("../config.php");
	include_once("../includes/db_con.php");	

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/teddy_style.css" />
		    <title>Admin - Estado</title>
			<script src="../js/jquery.min.js"></script>
			<script src="../js/jquery-ui.custom.min.js"></script>
    <style>
    h1{
        margin-top: 30px;
    }
   </style>
    </head>
    <body>

    <div class="wrapper">
	    <div class="header">
	    	<h1>teddy online judge</h1>
	    	<h2>teddy es un oso de peluche</h2>
	    </div>

    	<?php include_once("../includes/admin.menu.php"); ?>

        <div class="post_blanco"  align=left>
        <h2>Estructura de Teddy</h2>

        <p>this files must be writtable by teddy</p>
        <table border=0>
        <?php

	        $files = array("../../work_zone", "../../codigos");

	        foreach($files as $file){
		        echo "<tr>";
		        echo "<td>" . $file . "</td>";
		        if (is_writable($file)) {
			        echo "<td><b style='color: green'>OK</b></td>";
		        } else {
			        echo "<td><b style='color: red'>FAIL</b></td>";
		        }
		        echo "</tr>";
	        }
        ?>
        </table>

        <br><br>


        <p>this files must be executable</p>
        <table border=0>
        <?php
	        $files = array("../../bin/compileC", "../../bin/compileC++", "../../bin/runC", "../../bin/runPerl", "../../bin/runPython", "../../bin/runJava");

	        foreach($files as $file){
		        echo "<tr>";
		        echo "<td>" . $file . "</td>";
		        if (is_executable($file)) {
			        echo "<td><b style='color: green'>OK</b></td>";
		        } else {
			        echo "<td><b style='color: red'>FAIL</b></td>";
		        }
		        echo "</tr>";
	        }
        ?>
        </table>

		<hr>

        
		

        <h2>Compiladores y entornos de programacion</h2>
        <p>Compiladores y entornos de programacion</p>
        <b>java</b>
        <?php
        $out = array();
        $com= "java -version";    
        echo "<pre>" ;
        echo exec("$com 2>&1", $out, $err);
        foreach ($out as $value) {
	       echo "$value\n"; 
        }
        echo "</pre>" ;
        ?>

        <b>javac</b>
        <?php
        $out = array();
        $com= "javac -version";    
        echo "<pre>" ;
        echo exec("$com 2>&1", $out, $err);
        foreach ($out as $value) {
	       echo "$value\n"; 
        }
        echo "</pre>" ;
        ?>

        <b>gcc</b>
        <?php
        $out = array();
        $com= "gcc -v";    
        echo "<pre>" ;
        echo exec("$com 2>&1", $out, $err);
        foreach ($out as $value) {
            //echo "$value\n"; 
        }
        echo "</pre>" ;
        ?>

        <b>g++</b>
        <?php
        $out = array();
        $com= "g++ -v";    
        echo "<pre>" ;
        echo exec("$com 2>&1", $out, $err);
        foreach ($out as $value) {
            //echo "$value\n"; 
        }
        echo "</pre>" ;
        ?>

        <b>python</b>
        <?php
        $out = array();
        $com= "python -V";    
        echo "<pre>" ;
        exec("$com 2>&1", $out, $err);
        foreach ($out as $value) {
            echo "$value\n"; 
        }
        echo "</pre>" ;


        ?>

        <b>perl</b>
        <?php
        $out = array();
        $com= "perl -v";    
        echo "<pre>" ;
        exec("$com 2>&1", $out, $err);
        foreach ($out as $value) {
            echo "$value\n"; 
        }
        echo "</pre>" ;


        ?>




    </div>
</div>
<?php include("../includes/ga.php"); ?>
</body>
</html>
