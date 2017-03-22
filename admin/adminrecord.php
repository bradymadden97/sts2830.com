<?php
	session_start();
	require '.../public_html/sts2830.com/config.php';

	$idrecord = "";
	if(isset($_POST['rcrd'])){
		$idrecord = $_POST['rcrd'];
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("UPDATE participation SET recorded='1' WHERE id = :rcrd");
		    $stmt->bindParam(':rcrd', $idrecord);
		    $stmt->execute();
		    
	    }
		catch(PDOException $e) {
    	}
	}
	header("Location: /");
	exit();
?>