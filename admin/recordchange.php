<?php
	session_start();
	require '.../public_html/sts2830.com/config.php';
	$check = "";
	try {
		if(isset($_POST['hiderecord'])){
			$check = 1;
		}
		else{
			$check = 0;
		}
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("UPDATE hiddenpref SET currentstate=:curst, time=now() WHERE id = '1'");
		$stmt->bindParam(':curst', $check);
		$stmt->execute();	    
	}
	catch(PDOException $e) {
    }
	echo $check; 
?>