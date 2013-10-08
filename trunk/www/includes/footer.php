<div class="post" style="background: #060a15; ">
	<div  align=center>
			<table border=0>
				<tr>
					<td class="footer" style="color: white;" colspan=2>
						 Hecho por <b><a href="http://twitter.com/_alanboy" style="color:white;">Alan Gonzalez @_alanboy</a></b>
						<br>
						Concepto <b><a href="http://twitter.com/lhchavez" style="color:white;">Luis Hector Chavez @lhchavez</a></b>
						<br><br>
					</td>

				</tr>
				<tr>
<!--
					<td>
					</td>
-->
				</tr>
			</table>
		</div>	
</div>

<script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>

<?php
if ( isset($resultado)) {
	mysql_free_result($resultado);
}

