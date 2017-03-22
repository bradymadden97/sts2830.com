<?php
	require '.../public_html/sts2830.com/config.php';

	$lastname = "";
	if(isset($_POST['ln'])){
		$lastname = $_POST['ln'];
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("INSERT INTO participation (name) VALUES (:ln)");
		    $stmt->bindParam(':ln', $lastname);
		    $stmt->execute();
	    }
		catch(PDOException $e) {
    	}
	}
?>