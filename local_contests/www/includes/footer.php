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
				<tr align=center>
					<td>
					    <?php $root = file_exists ( "img/club.jpg" ); ?>
						<img src="<?php echo $root ? '' : '../'; ?>img/itc.jpg">
						<img src="<?php echo $root ? '' : '../'; ?>img/acm.jpg"> 
					</td>
				</tr>
			</table>
		</div>	
</div>


<?php

if( isset($resultado))
	mysql_free_result($resultado);

/*if( isset($enlace))
	mysql_close($enlace);*/
