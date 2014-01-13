<html doctype>
	<head>
		<link rel="stylesheet" type="text/css" href="/teddy/css/teddy_style.css" />
		<link rel="stylesheet" type="text/css" href="/teddy/uploadify/uploadify.css" />
		<link type="text/css" rel="stylesheet" href="/teddy/css/SyntaxHighlighter.css"></link>

		<script language="javascript" src="/teddy/js/jquery.min.js"></script>
		<script language="javascript" src="/teddy/js/jquery-ui.custom.min.js"></script>

		<script language="javascript" type="text/javascript" src="/teddy/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
		<script language="javascript" type="text/javascript" src="/teddy/uploadify/swfobject.js"></script>
		<script language="javascript" src="/teddy/js/shCore.js"></script>
		<script language="javascript" src="/teddy/js/shBrushCSharp.js"></script>
		<script language="javascript" src="/teddy/js/shBrushCpp.js"></script>
		<script language="javascript" src="/teddy/js/shBrushJava.js"></script>
		<script language="javascript" src="/teddy/js/shBrushPython.js"></script>
		<script language="javascript" src="/teddy/js/shBrushXml.js"></script>

		<script language="javascript" src="/teddy/js/teddy.js"></script>

		<title>
		<?php
			if (defined("PAGE_TITLE")) {
				echo PAGE_TITLE . " - "; 
			}
		?>Teddy Online Judge</title>

		<meta name="description" content="">
	</head>
	
<body>
<div class="wrapper">

	<div id="fb-root"></div>

	<a href="https://github.com/alanboy/teddy-online-judge/" target="_blank">
		<img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png" alt="Fork me on GitHub">
	</a>

	<div class="header" align=center>
			<table>
				<tr>
					<td rowspan=2>
	<!--
						<span class="rounded_image" style="background-image:url(img/teddy.jpg);">
							<img src="img/teddy.jpg" style="opacity:0;">
						</span>
	-->
					</td>
					<td><h1>teddy online judge</h1></td>
					<td rowspan=2 valign=top>
						<div 
							style="margin-left: 5px; margin-top: 7px;"
							class="fb-like" 
							data-href="https://www.facebook.com/pages/Teddy-Online-Judge/124087854360498" 
							data-send="true" 
							data-layout="button_count" 
							data-width="150"
							data-show-faces="false">
						</div>
						<div style="margin-top:5px; margin-left: 5px; width: 170px; margin-right: 0px;">
							<a href="https://twitter.com/teddyOJ" class="twitter-follow-button" data-show-count="false" data-lang="es">Segui @clubdeprogra</a>
						</div>
					</td>
				</tr>
				<tr>
					<td><h2>teddy es un oso de peluche</h2></td>
				</tr>
			</table>
		</div>

		<?php
			include_once("post_navmenu.php");
			include_once("post_usuariomenu.php");
		?>
