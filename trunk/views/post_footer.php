<div class="post footer" align=center>
	<p>
	Hecho por <b><a href="http://twitter.com/_alanboy" >Alan Gonzalez @_alanboy</a></b>
	;
	Concepto <b><a href="http://twitter.com/lhchavez" >Luis Hector Chavez @lhchavez</a></b>
	;
	Infraestructura por <b><a href="http://itcelaya.edu.mx/" >Instituto Tecnologico de Celaya</a></b>
	</p>
	<p>
	contribuciones de los usuarios bajo la licencia <a href="http://creativecommons.org/licenses/by-sa/3.0/" >cc-wiki</a> con atribucion requerida
	</p>
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
 
