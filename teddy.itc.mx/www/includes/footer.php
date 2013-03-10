<div class="post" style="background: #060a15; ">

	<div  align=center>
			<table border=0>
				<tr>
					<td class="footer" style="color: white;" colspan=2>
						Programacion <b><a href="http://twitter.com/_alanboy" style="color:white;">Alan Gonzalez</a></b>
						<br>
						Concepto <b><a href="http://twitter.com/lhchavez" style="color:white;">Luis Hector Chavez</a></b>
						<br><br>
						
					</td>

				</tr>
				<tr>
					<td>
					    <?php $root = file_exists ( "img/club.jpg" ); ?>
					    
						<a href="http://www.itc.mx"><img src="<?php echo $root ? '' : '../'; ?>img/itc.jpg"></a>
					</td>
				</tr>
			</table>
		</div>	
</div>

						<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>	<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) {return;}
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
							<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>				

<?php

if( isset($resultado))
	mysql_free_result($resultado);

/*if( isset($enlace))
	mysql_close($enlace);*/
