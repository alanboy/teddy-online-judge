<?php

class utils
{
	function endsWith( $str, $sub ) 
	{
		return ( substr( $str, strlen( $str ) - strlen( $sub ) ) == $sub );
	}

	public static function color_result( $res )
	{
		switch($res){
			case "COMPILACION":
				return "<span style='color:red;'>" . $res . "</span>";
				
			case "TIEMPO":
				return "<span style='color:brown;'>" . $res . "</span>";
				
			case "OK":
				return "<span style='color:green;'><b>" . $res . "</b></span>";
				
			case "RUNTIME_ERROR":
				return "<span style='color:blue;'><b>" . $res . "</b></span>";				
				
			case "INCORRECTO":
				return "<span style='color:red;'><b>" . $res . "</b></span>";				
				
			case "JUDGING":
				
			case "WAITING":
				return "<span style='color:purple;'>" . $res . "...</span>";	//<img src='img/load.gif'>
		}
		return $res;
	}
}

class envios
{
	private static function print_problem_chooser( $contest_id = null )
	{
		//cualquier problema es valido
		if($contest_id === null)
		{
			?>
			<div>
			   <input type="text" id="prob_id" placeholder="Problema"  value="" maxlength="5"> 
			</div>
			<?php
			return;
		}

		//$valid_problems deberia ser un array
		//con problemas validos para enviar
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

	private static function print_flash_upload()
	{
		?>
			<div   id="upload_0">
				<input id="flash_upload_file" name="fileInput" type="file" />
			</div>

			<script>
            $(document).ready(function() {
                $('#flash_upload_file').uploadify({
                    'uploader'  : 'uploadify/uploadify.swf',
                    'script'    : 'ajax/enviar.php',
                    'cancelImg' : 'uploadify/cancel.png',
                    'auto'      : false,
                    'height'    : 30,
                    'sizeLimit' : 1024*1024,
                    'buttonText': 'Buscar Archivo',
					'fileDesc' 	:'Codigo Fuente',
					'fileExt'	: '*.c;*.cpp;*.java;*.cs;*.pl;*.py;*.php',
                    'onSelect'  : function (e, q, f)  { 
							source_file.file_name = f.name;
							var parts = f.name.split(".");
							source_file.lang_ext = parts[parts.length -1 ];
							$("#ready_to_submit").fadeIn();
							
						},
                    'onCancel'  : function ()  { 
							$("#ready_to_submit").fadeOut();
							
						},
                    'onComplete'  : function (a,b,c,json_response,f){ 
							try{
								doneUploading( $.parseJSON(json_response));	
							}catch(e){
								console.error(e);
							}
						
						},
				 	'onError'  : function (){ 
							alert('Error');
					}
                });
            });
			</script>
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
			<div  style="display:none;" id="upload_2" aling=center>
				<textarea 
					cols		=	40 
					rows		=	15 
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
			
			var forma_de_envio_method = 0;

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
					if( !response.success ) {
						showResult(false, response.reason);
						
					}else{
						$("#waiting_space").fadeIn('fast', function(){
							source_file.execID = response.execID;
							check_for_results( );
						});//fadeIn
					}
				});//fadeOut
			}

			function send()
			{
				
				switch(forma_de_envio_method){
					
					
					
					// - - - - - -- - - -- - - - - - -- - -
					// Lo enviare con flash
					// - - - - - -- - - -- - - - - - -- - -
					case 0 : 
					$('#flash_upload_file').uploadifySettings('scriptData' , {
							'id_problema':  $("#prob_id").val(),
							'lang'		 : source_file.lang_ext,
							'sid'	 	: '<?php echo session_id(); ?>'
							<?php if($es_concurso !== null) echo ", 'id_concurso': " . $es_concurso; ?>
							
						});
						
					$('#flash_upload_file').uploadifyUpload();
					break;
					
					
					
					
					// - - - - - -- - - -- - - - - - -- - -					
					// Lo enviare con el tag de file
					// - - - - - -- - - -- - - - - - -- - -					
					case 1 : 

					break;
					
					
					
					// - - - - - -- - - -- - - - - - -- - -					
					// Lo enviare en texto plano
					// - - - - - -- - - -- - - - - - -- - -					
					case 2 : 
						$.ajax({ 
								url: "ajax/enviar.php", 
								type : "POST",	
								data: {
									lang 		: $('#lang').val(),
									id_problema	: $('#prob_id').val(),
									plain_source: $("#plain_text_area").val()
									<?php if($es_concurso !== null) echo ", 'id_concurso': " . $es_concurso; ?>
								},
								success: function(data){
								
									try{
										doneUploading( $.parseJSON(data) );	
									}catch(e){
										console.error(e);
									}
								},
								failure: function (){
									showResult(false, "Algo anda mal, intenta de nuevo.");
									
								}
							});//ajax
					break;
					default:
				}
			}//function

			function parse_the_result_from_teddy(json)
			{
				/*
					Concurso: "-1"
					LANG: "JAVA"
					execID: "7102718307"
					fecha: "2011-08-17 19:43:59"
					probID: "1"
					remoteIP: "127.0.0.1"
					status: "COMPILACION"
					tiempo: "0"
					userID: "alanboy"
				*/
				var comment = "";

				switch(json.status)
				{
					case "NO_SALIDA": 
						comment = "Ups, tu programa no creo un archivo data.out !";
					break;
					
					case "ERROR": 
						comment = "WHOA ! Teddy tiene problemas para evaluar tu codigo.";
					break;
					
					
					case "TIEMPO": 
						comment = "Tu programa no termino de ejecutarse en menos del limite de tiempo y fue interrumpido.";
					break;
					
					
					case "COMPILACION": 
						comment = "Tu programa no compilo !";
					break;
					
					
					case "RUNTIME_ERROR": 
						comment = "Tu programa arrojo una exception !";
					break;
					
					
					case "OK": 
						comment = "Felicidades ! Tu programa paso todos los casos de prueba !";
					break;
				}
				
				var html = "<div class='resultado_final'>"
					+ " " + json.status + " "
					+ "<div class='subtext' style='font-size: 10px;'>"
					+ comment
					+ "</div>"
					+ "</div>";
				
				return html;
			}

			function check_for_results()
			{
				$.ajax({ 
					url: "ajax/run_status.php", 
					data: {
						execID : source_file.execID
					},
					success: function(data)
					{
						j = jQuery.parseJSON(data);

						if( j.status == "WAITING" || j.status == "JUDGING" )
						{
							//volver a revisar el estado en uno o medio segundo
							setTimeout("check_for_results()", 1000);
						}else{
							//parse the judinging result
							showResult( true, parse_the_result_from_teddy(j) );
						}
					},
					failure: function (){
						showResult(false, "Error en Teddy !");
					}
				});
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
						self::print_flash_upload();
						self::print_basic_upload();
						self::print_text_area();
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

