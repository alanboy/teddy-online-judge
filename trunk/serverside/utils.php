<?php

	function SUCCESS($res)
	{
		return $res["result"] === "ok";
	}

	function writeFormInput($label, $id, $placeholder = null)
	{
		echo "<label for='$id'>$label</label>";
		$value = "";
		if (isset($_POST[$id]))
		{
			$value = $_POST[$id];
		}
		echo "<input type='text' id='$id' name='$id' class='text' value='$value' />";
	}

