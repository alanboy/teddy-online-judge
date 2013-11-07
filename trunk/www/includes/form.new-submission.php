<?php

	
	
	envios::imprimir_forma_de_envio( $_REQUEST['cid'] );
	
	?>
	<!--
	<div align="center" >
	<form action="contest_rank.php?cid=<?php echo $_REQUEST['cid']; ?>" method="POST" enctype="multipart/form-data">
		<br>
		<table border=0>
			 <tr><td  style="text-align: right">Codigo fuente&nbsp;&nbsp;</td><td><input name="userfile" type="file"></td></tr>
			
			 <tr><td style="text-align: right">Problema&nbsp;&nbsp;</td><td>
			 	<select name="prob">	
				<?php

				$probs = explode(' ', $row["Problemas"]);
				for ($i=0; $i< sizeof( $probs ); $i++) {
					echo "<option value=". $probs[$i] .">". $probs[$i] ."</option>"; //"<a href='verProblema.php?id=". $probs[$i]  ."'>". $probs[$i] ."</a>&nbsp;";
				}

				?>
				</select>
			 </td></tr>
			
			 <tr><td></td><td><input type="submit" value="Enviar Solucion"></td></tr>
		</table>
	    <input type="hidden" name="ENVIADO" value="SI">
	    <input type="hidden" name="cid" value="<?php echo $_REQUEST['cid']; ?>">
	    
	</form> 
	</div>
	-->

