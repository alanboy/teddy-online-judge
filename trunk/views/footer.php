<div class="post" style="background: #060a15; ">
	<div  align=center>
		<table border=0>
			<tr>
			<td>
				<!--<img src="img/mail.png">-->
			</td>
			<td class="footer" style="color: white;" colspan=2>
				Hecho por <b><a href="http://twitter.com/_alanboy" style="color:white;">Alan Gonzalez @_alanboy</a></b>
				<br>
				Concepto <b><a href="http://twitter.com/lhchavez" style="color:white;">Luis Hector Chavez @lhchavez</a></b>
			</td>
			</tr>
			<tr>
			<td>
			</td>
			<td class="footer" style="color: white;" colspan=2>
				alanboy@itcelaya.edu.mx
			</td>
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
	if (!$TEDDY_GA_MUTE) 
	{
	?><!-- GOOGLE Analitics -->
		<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
		try {
			var pageTracker = _gat._getTracker("<?php echo $TEDDY_GA_ID; ?>");
			pageTracker._trackPageview();
		} catch(err) {}</script>
			<!-- GOOGLE Analitics -->
	<?php
	}
?>
</body>
</html> 
 
