<?php

	$execID = $_GET["execID"];

	$resultado = c_ejecucion::details($_GET);
	$run = $resultado["run"];

	$file  = "../codigos/" . $execID  ;

	switch($run["LANG"])
	{
		case "JAVA": 	$file .= ".java"; 	$sintaxcolor = "java"; 		break;
		case "C": 		$file .= ".c"; 		$sintaxcolor = "c"; 		break;
		case "C++": 	$file .= ".cpp"; 	$sintaxcolor = "cpp"; 		break;
		case "C#":		$file .= ".cs"; 	$sintaxcolor = "csharp"; 	break;
		case "Python": 	$file .= ".py"; 	$sintaxcolor = "py"; 		break;
		case "Perl": 	$file .= ".pl"; 	$sintaxcolor = "py"; 		break;
		case "Php": 	$file .= ".php"; 	$sintaxcolor = "php"; 		break;
		default : 		$file .= ".java"; 	$sintaxcolor = "java";
	}

	if (!file_exists($file)) 
	{
		echo "No encuentro el archivo original.";
	}
	else
	{
		$codigo = file_get_contents($file);
		$codigo = htmlspecialchars($codigo);

		?>
		<div class="post">
			<div align=center >
				<table border='0' style="font-size: 14px;" > 
				<thead> <tr >
					<th width='12%'>execID</th> 
					<th width='12%'>Usuario</th> 
					<th width='12%'>Lenguaje</th> 
					<th width='12%'>Resultado</th> 
					<th width='10%'>Tiempo</th> 
					<th width='14%'>Fecha</th>
					</tr> 
				</thead> 
				<tbody>
				<?php
					echo "<TR style=\"background:#e7e7e7;\">";
					echo "<TD align='center' >". $run['execID'] ."</TD>";
					echo "<TD align='center' ><a href='runs.php?user=". $run['userID']  ."'>". $run["userID"]   ."</a> </TD>";
					echo "<TD align='center' >". $run['LANG']   ."</TD>";
					echo "<TD align='center' >". $run['status']   ."</TD>";
					echo "<TD align='center' ><b>". $run['tiempo'] / 1000  ."</b> Segundos </TD>";

					$datewformat = date("F j, Y h:i:s A", strtotime($run['fecha']));
					echo "<TD align='center' >". $datewformat . "</TD>";
					echo "</TR>";
				?>		
				</tbody>
				</table>
			</div>
		</div>
		<?php
		echo "<textarea name=\"code\" class=\"$sintaxcolor\" cols=\"60\" runs=\"10\">{$codigo}</textarea>";
	}
	
	
