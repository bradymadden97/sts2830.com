<?php
	session_start();
	if(isset($_SESSION['user'])){
		header('Location: /');
	}


?>
<html>
<head>
	<title>2830 Admin - Login</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="shortcut icon" type="icon" href="/favicon.ico"/>
</head>
<body>
	<div style="text-align:center">
		<h2>STS 2830 Admin Login</h2>
		<form method="POST" action="login.php">
			<input placeholder="Username" name="log" id="log" style="font-size:18px" />
			<div><button style="font-size:18;margin-top:10">Log in</button></div>
		</form>
	</div>
	<div style="font-size:16px;margin-top:50px;text-align:center">
		Lost Student? <a href="http://sts2830.com/">Go here</a>.
	</div>
	<script>
		$(document).ready(function(){
			$("#log").focus();
		});
	</script>
</body>
</html>
