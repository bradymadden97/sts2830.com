<?php
	session_start();
	$timepref = $_POST['tpref'];
	$_SESSION["tp"] = $timepref;
	echo $_SESSION["tp"];
?>