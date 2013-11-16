
var CurrentRuns = null;
var CurrentRank = null;

window.onload = function ()
{
	dp.SyntaxHighlighter.ClipboardSwf = 'flash/clipboard.swf';
	dp.SyntaxHighlighter.HighlightAll('code');
}

/*
 * Mensajes
		var foo = function(){
			$("#mailbox_menu").fadeTo("slow", .4, function(){
				$("#mailbox_menu").fadeTo("slow", 1, foo);
			});
		}
		*/

//////////////////////////////////////////////
//registro.php
var states = new Array("Mexico","Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo, Democratic Republic", "Congo, Republic of the", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Mongolia", "Morocco", "Monaco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Norway", "Oman", "Pakistan", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Samoa", "San Marino", " Sao Tome", "Saudi Arabia", "Senegal", "Serbia and Montenegro", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe");

function _validate()
{
	if( $('#nombre')[0].value.length<7)
	{
		return Array("Ingrese su nombre completo por favor.", $('#nombre')[0]);
	}

	if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#email')[0].value)))
	{
		return Array("Ingrese un email valido.", $('#email')[0]);
	}

	if($("#nick")[0].value.indexOf(" ") > -1)
	{
		return Array("Tu nick no puede contener espacios.", $('#nick')[0]);
	}

	if($("#twitter")[0].value.indexOf("@") != -1)
	{
		//return Array("Tu id de twitter sin el arroba plis :P", $('twitter'));
		$("#twitter")[0].value = $("#twitter")[0].value.substring(1);
	}

	if($("#nick")[0].value.length < 5)
	{
		return Array("Tu nick no debe ser menor a 5 caracteres.", $('#nick')[0]);
	}

	if($("#password")[0].value.length<5)
	{
		return Array("Ingresa un password con una logitud de 5 caracteres.", $('#password')[0]);
	}

	if($("#password")[0].value != $("#re_password")[0].value)
	{
		return Array("Los passwords ingresados no son iguales. Confirma nuevamente tu password", $("#re_password")[0]);
	}
	if($("#escuela")[0].value.length==0)
	{
		return Array("Ingresa tu escuela de procedencia, es muy importante para para nosotros. Gracias", $('#escuela')[0]);
	}
	return true;
}

function validateNewUser()
{
	rs = _validate();
	if(rs === true)
	{
		$("form").value="true";
		return true;
	}
	else
	{
		alert(rs[0]);
		rs[1].focus();
		rs[1].select();
		return false;
	}
}


//////////////////////////////////////////////
//contest.php
function show_new_contest()
{
	$("#new_contest_button").slideUp('fast', function (){
			$("#new_contest_form").slideDown();
		});
}

//////////////////////////////////////////////
//contest_rank.php
function updateTime()
{
	data = $("#time_left").html().split(":");
	hora = data[0];
	min = data[1];
	seg = data[2];

	if(--seg < 0){
		seg = 59;
		if(--min < 0){
			min = 59;
			if(--hora < 0){
				hora = 59;
			}
			hora = hora < 10 ? "0" + hora : hora;
		}
		min = min < 10 ? "0" + min : min;
	}

	seg = seg < 10 ? "0" + seg : seg;
	if(hora == 0 && min == 0 && seg == 0)
	{
		window.location.reload( false );
	}

	//hora = hora < 10 ? "0" + hora : hora;
	$("#time_left").html(hora+":"+min+":"+seg);
}



function showRuns()
{
	//los runs han cambiado, entonces mostrar el rank
	askforrank();

	$("#runs_div").fadeOut("fast", function (){
		html = "";

		for( a = 0; a < CurrentRuns.length; a++ )
		{	

			if(a%2 ==0){
				html += "<TR style=\"background:#e7e7e7;\">";
			}else{
				html += "<TR style=\"background:white;\">";
			}

			//color them statusessss
			switch(CurrentRuns[a].status)
			{
				case "COMPILACION":
					CurrentRuns[a].status = "<span style='color:red;'>" + CurrentRuns[a].status + "</span>";
				break;

				case "TIEMPO":
					CurrentRuns[a].status = "<span style='color:brown;'>" + CurrentRuns[a].status + "</span>";
				break;

				case "OK":
					CurrentRuns[a].status = "<span style='color:green;'><b>" + CurrentRuns[a].status + "</b></span>";
				break;

				case "RUNTIME_ERROR":
					CurrentRuns[a].status = "<span style='color:blue;'><b>" + CurrentRuns[a].status + "</b></span>";				
				break;

				case "INCORRECTO":
					CurrentRuns[a].status = "<span style='color:red;'><b>" + CurrentRuns[a].status + "</b></span>";				
				break;

				case "JUDGING":
					case "WAITING":
					CurrentRuns[a].status = "<span style='color:purple;'>" + CurrentRuns[a].status + "...</span>";	//<img src='img/load.gif'>
				break;
			}

			html +=  "<TD align='center' ><a href='verCodigo.php?execID=" +CurrentRuns[a].execID+ "'>" +CurrentRuns[a].execID+ "</a></TD>";
			html +=  "<TD align='center' ><a href='verProblema.php?id=" +CurrentRuns[a].probID+"'>" +CurrentRuns[a].probID+"</a> </TD>";
			html +=  "<TD align='center' ><a href='runs.php?user=" +CurrentRuns[a].userID+"'>" +CurrentRuns[a].userID+"</a> </TD>";
			html +=  "<TD align='center' >" +CurrentRuns[a].LANG+"</TD>";
			html +=  "<TD align='center' >" +CurrentRuns[a].status+"</TD>";
			html +=  "<TD align='center' >" +(parseInt(CurrentRuns[a].tiempo)/1000)+" Seg. </TD>";
			html +=  "<TD align='center' >" +CurrentRuns[a].fecha+" </TD>";
			html +=  "</TR>";
		}

		document.getElementById("runs_tabla").innerHTML = html;
		$("#runs_div").fadeIn();
	})
}

function runsCallback(data)
{
	if(CurrentRuns === null)
	{
		//es la primera vez
		CurrentRuns = data;
		showRuns();
		return;
	}

	if(CurrentRuns.length == data.length)
	{
		//asumir que es el mismo, aunque no necesariamente
		//es el caso 
		return;
	}

	CurrentRuns = data;
	showRuns();
}

function askforruns (cid)
{
	$.ajax({
			url: "ajax/runs.php",
			data: "cid="+cid,
			cache: false,
			success: function(data){
				var obj = jQuery.parseJSON(data);
				runsCallback(obj);
				setTimeout("askforruns("+cid+")",5000);
			},
			error: function(data)
			{
				setTimeout("askforruns("+cid+")",10000);
			}
		});
}

function showRank()
{
	$("#ranking_tabla").fadeOut("fast", function (){
			html = "";
			for( a = 0; a < CurrentRank.length; a++ )
			{
			if(a%2 ==0)
			{
			html += "<TR style=\"background:#e7e7e7; height: 50px;\">";
			}else{
			html += "<TR style=\"background:white; height: 50px;\">";
			}
			html +=  "<TD align='center' style='font-size: 18px' ><b>" +CurrentRank[a].RANK+ "</b></a></TD>";
			html +=  "<TD align='center' >" +CurrentRank[a].userID+"</a> </TD>";
			html +=  "<TD align='center' >" +CurrentRank[a].ENVIOS+"</a> </TD>";
			html +=  "<TD align='center' >" +CurrentRank[a].OK+"</a> </TD>";
			var problemas = [ /* <?php foreach($PROBLEMAS as $p){echo $p . ",";}; ?> */ ];
			//console.log(problemas)
			//console.log(CurrentRank[a].problemas)
			for( z = 0 ; z < problemas.length ; z++ )
			{
			var rankValueHtml = "";
			for ( p in CurrentRank[a].problemas  )
			{
				if(p == problemas[z])
				{
					rankValueHtml = "x";
					//CurrentRank[a].problemas[p].bad
					if(CurrentRank[a].problemas[p].ok > 0)
					{
						tiempo = parseInt(CurrentRank[a].problemas[p].ok_time / 60);
						tiempo += ":"; 
						bar = parseInt((parseInt(CurrentRank[a].problemas[p].ok_time % 60)));
						if(bar<=9){ bar = "0"+bar;}
						tiempo += bar;
						//tiempo += parseInt((parseInt(CurrentRank[a].problemas[p].ok_time % 60)*60)/100);
						/*
						   100 - 60
						   x - 
						   (x*60)/100
						   */
						rankValueHtml = "<b>" +  tiempo + "</b> / "+CurrentRank[a].problemas[p].ok_time+"<br>";
						rankValueHtml += "("+CurrentRank[a].problemas[p].bad+")";
					}else{
						rankValueHtml = "-"+CurrentRank[a].problemas[p].bad+"";
					}
				}
			}
	html +=  "<TD align='center' >" + rankValueHtml +"</TD>";
			}
	html +=  "<TD align='center' >" +CurrentRank[a].PENALTY+" </TD>";
	html +=  "</TR>";
			}

	document.getElementById("ranking_tabla").innerHTML = html;
	$("#ranking_tabla").fadeIn();
	});
}

function askforrank()
{
	$.ajax({
			url: "ajax/rank.php",
			data: "cid=2",
			cache: false,
			success: function(data){
				CurrentRank = jQuery.parseJSON(data);
				showRank();
			}
		});
}

function logout()
{
	$.ajax({
		url: "ajax.php",
		dataType: "json",
		type : "POST",
		data: {
			'controller' : "c_sesion",
			'method' : "logout"
		}
	}).always(function (response){
		// Probar response con errores
		window.location.reload( false );
	});//always
}

function lost()
{
	if ($("#user").val().length < 2) {
		alert("Escribe tu nombre de usuario o correo electronico en el campo.");
		return;
	}

	$('#login_area').slideUp('slow', function() {
			$('#wrong').slideUp('slow');
			$('#message').slideDown('slow', function() {
				$.ajax({
						url: "ajax.php",
						dataType: 'json',
						data: {
							'controller' : "c_user",
							'method' : "lostpassword",
							'user' : $("#user").val()
						}
					}).always(function(response){
						//response
						$('#login_area').slideDown('slow');
					});
				
				});
		});
}

function login()
{
	$('#login_area').slideUp('slow', function() {
			$('#wrong').slideUp('slow');
			$('#message').slideDown('slow', function() {
				$.ajax({
					context: document.body,
					url: "ajax.php",
					dataType: "json",
					type : "POST",
					data: {
						'controller' : "c_sesion",
						'method' : "login",
						'pass': $("#pass").val(),
						'user': $("#user").val()
					},
				})
				.always(function (response){
						$('#message').fadeOut('slow', function() {
							if(response.user)
							{
								location.reload(true);
							}
							else
							{
							$("#wrong").slideDown("slow", function (){ 
								$('#login_area').slideDown('slow', function() {
									$("#login_area").effect("shake", { times:2 }, 100);
									});
								});
							}
						});//fadeOut
					});//always
				});//slide down
			});//slide up
	return false;
}


