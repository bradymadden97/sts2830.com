<?php
	session_start();
	require '.../public_html/sts2830.com/config.php';
	try {
		if(isset($_POST['log'])){
			$name = $_POST['log'];

			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("SELECT id FROM users WHERE :user = name");
			$stmt->bindParam(":user", $name);
			$stmt->execute();
			$res = $stmt->fetch();
			if($res){
				$_SESSION['user'] = $res['id'];
				header('Location: http://admin.sts2830.com');
			}else{
				header('Location: /');
				exit();
			}
		}else{
			header('Location: /');
			exit();
		}
	}
	catch(PDOException $e) {
		error_log($e);
    }
?>