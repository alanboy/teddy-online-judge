<table><?php

foreach ($msgs as $mensaje) {

	?>
	<tr style="background-color: #white;">
		<td>De <b> <?php echo $mensaje['de']; ?></b>&nbsp;&nbsp;</td> 
		<td>Para <b><?php echo $mensaje['de']; ?></b>&nbsp;&nbsp;</td>
	</tr>

	<tr>
		<td colspan=3><hr>
		</td>
	<tr>
	<tr style="background-color: #white;">
		<td colspan=3>
		<?php
			$str     = $mensaje['mensaje'];
			$order   = array("\r\n", "\n", "\r");
			$replace = '<br />';

			//Processes \r\n's first so they aren't converted twice.
			$newstr = str_replace($order, $replace, $str);

			echo $newstr;
		?>
		</td>
	</tr>
		<tr>
		<td colspan=3>&nbsp;</td>
	</tr>
	<?php
}
?>
</table>
