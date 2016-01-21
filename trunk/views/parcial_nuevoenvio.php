<h2>enviar solucion</h2>


<?php

class envios
{
	private static function print_problem_chooser( $contest_id = null )
	{
		//cualquier problema es valido
		$presend = "";

		if($contest_id === null)
		{
			if (isset($_GET["send_to"]))
			{
				$presend = $_GET["send_to"];
			}

			?>
			<div>
				<input type="text" id="prob_id" placeholder="Problema" value="<?php echo $presend; ?>" maxlength="5">
			</div>
			<?php
			return;
		}
		else
		{

			//$valid_problems deberia ser un array
			$q = mysql_query( "SELECT * FROM Concurso WHERE CID = " . $contest_id . ";" ) or die ( mysql_error( ) ) ;
			$row = mysql_fetch_array( $q ) or die ( mysql_error( ) );
			$probs = explode(' ', $row["Problemas"]);

			echo "<select id=\"prob_id\">";	
			for ($i=0; $i< sizeof( $probs ); $i++)
			{
				echo "<option value=". $probs[$i] .">". $probs[$i] ."</option>"; 
			}
			echo "</select>";
		}
	}

	private static function print_flash_upload()
	{
		?>
			<div  style="display:none;" id="upload_0">
				<input id="flash_upload_file" name="fileInput" type="file" />
			</div>
		<?php
		
	}

	private static function print_text_area()
	{
		?>
			<Script>
				function checkForText(text){
					if(text.trim().length == 0){
						$("#ready_to_submit").fadeOut();
					}else{
						$("#ready_to_submit").fadeIn();
					}
					
				}
			</script>
			<div  style="" id="upload_2" aling=center>
				<textarea 
					cols		=	80 
					rows		=	25 
					id			=	"plain_text_area" 
					placeholder	=	'Pega el codigo fuente aqui' 
					onkeyup		=	"checkForText(this.value)" 
					onmousemove	=	"checkForText(this.value)"></textarea>
				<br>
				Lenguaje :
				<select id="lang">
					<option value="java">Java</option>
					<option value="c">C</option>
					<option value="cpp">C++</option>
					<option value="py">Python</option>
					<option value="php">PHP</option>
					<option value="pl">Perl</option>
				</select>
			</div>
		<?php
		
	}

	private static function print_basic_upload()
	{
		?>
		<div  id="upload_1" style="display:none;" >
			<form action="ajax.php" method="POST" enctype="multipart/form-data">
				<input id="basic_file" name="fileInput" type="file" />
				<input type="hidden">
			</form> 
		</div>
		<?php
		
	}

	public static function imprimir_forma_de_envio( $es_concurso = null )
	{
		?>
		<script>
			var source_file = {
				file_name 		: null,
				source_as_text 	: null,
				lang_ext		: null,
				execID			: null
			};
			
			var forma_de_envio_method = 2;

			function change_upload_method()
			{
				$("#upload_" + forma_de_envio_method ).fadeOut('fast', function(){
					if(forma_de_envio_method == 0)
						forma_de_envio_method = 2;
					else
						forma_de_envio_method = 0;
					$("#upload_" + forma_de_envio_method ).fadeIn();
				});
			}

			function showResult( success, full_text )
			{
				$("#waiting_space").slideUp('fast', function(){
					$("#result_space").html("<div class='teddy_response'>" + full_text + "</div>").slideDown('fast', function(){
						$("#form_space").fadeIn();
					});
				});
			}

			function doneUploading( response )
			{
				$("#result_space").html("");
				
				$("#form_space").fadeOut('fast', function(){
					$("#waiting_space").fadeIn('fast', function(){
						source_file.execID = response.execID;
						check_for_results( );
					});//fadeIn
				});//fadeOut
			}

			function send()
			{
				switch(forma_de_envio_method)
				{
					// - - - - - -- - - -- - - - - - -- - -
					// Lo enviare con flash
					case 0 :
					$('#flash_upload_file').uploadifySettings('scriptData' , {
							id_problema:  $("#prob_id").val(),
							lang		 : source_file.lang_ext,
							controller	: "c_ejecucion",
							method		: "nuevo",
							sid	 		: '<?php echo session_id(); ?>'
							<?php if($es_concurso !== null) echo ", 'id_concurso': " . $es_concurso; ?>
							
						});
						
					$('#flash_upload_file').uploadifyUpload();
					break;

					// - - - - - -- - - -- - - - - - -- - 
					// Lo enviare con el tag de file
					case 1 :
					break;

					// - - - - - -- - - -- - - - - - -- - -
					// Lo enviare en texto plano
					case 2 :
						Teddy.c_ejecucion.nuevo({
									lang 		: $('#lang').val(),
									id_problema	: $('#prob_id').val(),
									plain_source: $("#plain_text_area").val()
									<?php 
										if($es_concurso !== null) {
											echo ", 'id_concurso': " . $es_concurso; 
										}
									?>
								},
								doneUploading
							);
					break;
					default:
				}
			}//function

			function parse_the_result_from_teddy(response)
			{
				var html = "<div class='resultado_final'>"
					+ " " + response.status + " "
					+ "<div class='subtext' style='font-size: 10px;'>";

				switch(response.status)
				{
					case "NO_SALIDA": 
						html += "Ups, tu programa no creo un archivo data.out !";
					break;
					
					case "ERROR": 
						html += "WHOA ! Teddy tiene problemas para evaluar tu codigo.";
					break;
					
					
					case "TIEMPO": 
						html += "Tu programa no termino de ejecutarse en menos del limite de tiempo y fue interrumpido.";
					break;
					
					
					case "COMPILACION": 
						html += "Tu programa no compilo !";
						html += "<pre style='text-align:left'>" + response.compilador + "</pre>";
					break;
					
					
					case "RUNTIME_ERROR": 
						html += "Tu programa arrojo una exception !";
					break;
					
					
					case "OK": 
						html += "Felicidades ! Tu programa paso todos los casos de prueba !";
					break;
				}
				
				html += "</div>" 
					+ "</div>";
				
				return html;
			}

			function check_for_results()
			{
				Teddy.c_ejecucion.status({
							execID : source_file.execID
						},
						function(data) {
							if( data.status == "WAITING" || data.status == "JUDGING" )
							{
								setTimeout("check_for_results()", 1000);
							}else{
								showResult( true, parse_the_result_from_teddy(data));
							}
						}
					);
			}
		</script>
		<div align=center>
			<br><br>

			<div id="result_space" style="display:none;">
			</div>

			<table border=0 id="waiting_space" style="display:none;">
				<tr>
					<td><img src="img/load.gif"></td>
					<td>Revisando...</td>
				</tr>
			</table>

			<table border=0 id="form_space" style="text-align:center">
				<tr>
					<td colspan=1 >
						Codigo Fuente
						<div 
							style="font-size:10px; text-align:center;" 
							onClick="change_upload_method()">
							&iquest; Problemas ? <br>Puedes intentar otra manera de subir el codigo <a href="#">aqui</a>.</div>
						<br><br>
					</td>
				</tr>
				<tr>
					<td>
					<?php
						self::print_text_area();
						self::print_flash_upload();
						self::print_basic_upload();
					?>
					</td>
				</tr>
				<tr>
					<td><br><br>Problema</td>
				</tr>
				<tr>
					<td>
					<?php
						self::print_problem_chooser( $es_concurso );
					?>
					</td>
				</tr>
				<tr>
					<td colspan=2 align=center>
						<br><br>
						<div id="ready_to_submit" style="display:none;">
							<input type="button" value="Enviar" onClick="send()">
						</div>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}
	
}

envios::imprimir_forma_de_envio($_REQUEST['cid']);
/*
	
	
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

<?php

*/

