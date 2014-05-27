<?php

	require "class.iCalReader.php";

	$ical = new ical($_GET["path"]);
	print_r($ical->events());

?>