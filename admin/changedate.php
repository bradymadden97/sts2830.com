<?php
	session_start();
	$dateSelected = $_POST['datepicker'];
	$_SESSION['dateSelected'] = $dateSelected;
	echo $_SESSION['dateSelected'];
?>