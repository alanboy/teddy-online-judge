<?php

	require_once("../../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("head.php");

	require_once("require_login.php");
	require_once("require_admin.php");

?>
<div class="post_blanco"  align=center>
		<h2>Problemas</h2>

<?php
		$consulta = "select * from Problema order by probid ";
	$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());
?>

    <table border='0' width=100%> 
	<thead> <tr >
        <th >ID</th> 
		<th >Titulo</th> 
		<th >Publico</th>
		<th >data.in</th> 
		<th >data.out</th>  
		<th >Vistas</th> 
		<th >Aceptados</th> 
		<th >Intentos</th> 
		<th >Radio</th>
		<th ></th>
		</tr> 
	</thead> 
	<tbody>
	<?php

	$flag = true;

    while($row = mysql_fetch_array($resultado)){

		if( $row['intentos'] != 0)
			$ratio = ($row['aceptados'] / $row['intentos'])*100;
		else
			$ratio = "0.0";

		if($flag){
	        	echo "<TR style=\"background:#e7e7e7;\">";
			$flag = false;
		}else{
	        	echo "<TR style=\"background:white;\">";
			$flag = true;
		}

        if(file_exists( "../../casos/" . $row['probID'] . ".in" )){
            $datain =  filesize ( "../../casos/" . $row['probID'] . ".in"  ) . " bytes";
        }else{
            $datain =  "<div style='color:red'>x</div>" ;
        }

        if(file_exists( "../../casos/" . $row['probID'] . ".out" )){
            $dataout =  filesize ( "../../casos/" . $row['probID'] . ".out"  ). " bytes" ;
        }else{
            $dataout =  "<div style='color:red'>x</div>" ;
        }


        ?>
            <TD align='center'>
            	<a href="../verProblema.php?id=<?php echo $row['probID'] ?>" target="_blank">
            	<?php echo $row['probID'] ?>
            	</a>
            </TD>
            <TD align='left'>
            	<a href="../verProblema.php?id=<?php echo $row['probID'] ?>" target="_blank">
            	<?php echo $row['titulo'] ?>
            	</a>
            </TD>
            <TD align='center'><?php echo $row['publico'] ?> </TD>
            <TD align='center'><?php echo $datain ?> </TD>
            <TD align='center'><?php echo $dataout ?> </TD>
            <TD align='center'><?php echo $row['vistas'] ?> </TD>
            <TD align='center'><?php echo $row['aceptados'] ?> </TD>
            <TD align='center'><?php echo $row['intentos'] ?> </TD>
            <TD align='center'><?php printf( "%2.2f%%", $ratio ) ?> </TD>
            <TD align='center'>editar</TD>
        </tr>
        <?php
	}
	?>		
	</tbody>
	</table>
	</div>

	<?php include_once("post_footer.php"); ?>

