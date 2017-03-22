<html>
<head>
	<title>
		2830 Participation Form
	</title>
<link rel="shortcut icon" type="icon" href="/favicon.ico"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<style>
		button:hover {
			cursor:pointer;
		}
	</style>
</head>
<body>
	<h2 style="text-align:center">STS 2830: Startup Operations for Entrepreneurs</h2>
	<hr style="width:66%">
	<div = id="formholder">
		<form id="submitform" method="POST" action="">
			<div style="text-align:center;padding-top:5px;font-size:20px">
				Enter your last name for speaking credit:
				<br>
				<input type="text" id="lnenter" name="ln" style="height:30px;width:250px;font-size:16px;margin-bottom:20px;margin-top:20px" />
				<br>
				<button id="subbtn" style="width:100px;height:40px;font-size:20px">Submit</button>
			</div>
		</form>
	</div>
	<div id="response" style="text-align:center;display:none;padding-top:20px">
		<h3>Your response has been recorded.</h3>
		<a href="/">Submit another response</a>
	</div>
	<script>
		window.onload = function(){
			document.getElementById("lnenter").focus();
		}
		$("#submitform").submit(function(e){
			e.preventDefault();
			if($("#lnenter").val().length > 0){
				$.ajax({
					type:"POST",
					url:"submitname.php",
					data:$("#submitform").serialize(),
					success:function(data)
					{
						$("#formholder").css("display", "none");
						$("#response").css("display", "block");
					}
				});
			}else{
				$("#lnenter").focus();
			}
		});
	</script>
</body>
</html>