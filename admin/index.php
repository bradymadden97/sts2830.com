<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header('Location: /login');
		exit();
	}
	require '.../public_html/sts2830.com/config.php';
	try {
		$dateSelected= date("Y-m-d");
		if(isset($_SESSION['dateSelected'])){
			$dateSelected= $_SESSION['dateSelected'];
		}

		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("SELECT id, name, time, recorded FROM participation WHERE time > cast(:date as date) AND time < (cast(:date as date) + 1)");
		$stmt->bindParam(":date", $dateSelected);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$stmt2 = $conn->prepare("SELECT currentstate FROM hiddenpref WHERE id = 1");
		$stmt2->execute();
		$res2 = $stmt2->fetch();
		$chk = 'unchecked';
		if($res2['currentstate'] == 1){
			$chk = 'checked';
		}

		$timep = '10';
		if(isset($_SESSION['tp'])){
			$timep = $_SESSION['tp'];
		}

	}
	catch(PDOException $e) {
		error_log($e);
    }
?>
<html>
<head>
	<title>2830 Admin</title>
	<?php 
		if($timep != 'off'){
			echo "<meta http-equiv='refresh' content='".$timep."'>";
		}
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="shortcut icon" type="icon" href="/favicon.ico"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<style>
		.ar{
			border: 1px solid black;
			background: none;
			box-shadow: none;
			border-radius: 3px;
			padding: 5px;
			cursor: pointer;
		}
		.ar:focus{
			outline:0;
		}
		.refresh{
			background-color:#FFDB99;
		}
		.btn{
			cursor: pointer;
		}
		#datepicker-container{
		  text-align:center;
		}
		#datepicker-center{
		  display:inline-block;
		  margin:0 auto;
		}			
	</style>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
	<div style="text-align:center;border:1px solid black;z-index:999;position:absolute;top:-1px;left:5%">
		Auto-refresh:
		<br>
		<table>
			<tr>
				<td>
					<button id="10" class="ar <?php if($timep == '10') echo 'refresh' ?>">10s</button>
				</td>
				<td>
					<button id="30" class="ar <?php if($timep == '30') echo 'refresh' ?>">30s</button>
				</td>
				<td>
					<button id="60" class="ar <?php if($timep == '60') echo 'refresh' ?>">60s</button>
				</td>
				<td>
					<button id="off" class="ar <?php if($timep == 'off') echo 'refresh' ?>">Off</button>
				</td>
			</tr>
		</table>
	</div>
	<h2 style="text-align:center">2830 Admin</h2>
	<h4 style="margin-bottom:0;text-align:center"><?php echo DateTime::createFromFormat('Y-m-d', $dateSelected)->format("F jS, Y");?></h4>
	<div style="text-align:center"><button class="btn" id="changedate" style="font-size:10;margin-top:4px"">Change Date</button></div>
	
	<div><input name="datepicker" id="datepicker" type="hidden"/><span style="position:absolute;left:40%">&nbsp;</span></div>
	
	<hr style="width:66%">
	<div id="res">
		<form id="speakers" method="POST" action="adminrecord.php">
			<table cellpadding="5" align="center" style="text-align:center">
				<tr>
					<th>Last Name</th>
					<th>Time</th>
					<th>Recorded</th>
				</tr>
				<?php
				foreach($res as $r){
					$record = $r['recorded'];
					if($record == 0){
						echo '<tr>';
						echo '<td>'.$r['name'].'</td>';
						$t = date('g:i:s', strtotime($r['time'])+10800);
						echo '<td>'.$t.'</td>';
						echo '<td>'.'<button class="btn" name="rcrd" value="'.$r['id'].'" >Recorded</button></td>';
						echo '</tr>';
					}else{
						if($res2['currentstate'] == 0){
							echo '<tr>';
							echo '<td><s>'.$r['name'].'</s></td>';
							$t = date('g:i:s', strtotime($r['time'])+10800);
							echo '<td><s>'.$t.'</s></td>';
							echo '<td></td>';
							echo '</tr>';
						}
					}
				}
				?>
			</table>
		</form>
		<form id="recchange">
			<div style="text-align:center;z-index:999;position:absolute;top:-1px;left:70%;border:1px black solid;padding:5px;padding-top:5px">
				Hide already recorded:
				<div style="margin-top:10px;margin-bottom:0px">
					<input style"margin-bottom:0" class="btn" type="checkbox" <?php echo $chk; ?> id="hiderecord" name="hiderecord" />
				</div>
			</div>
		</form>
		<input type="hidden" name="tpref" id="tpref" />
	</div>
	<script>
		$("#speakers").submit(function(e){
			$.ajax({
				type:"POST",
				url:"adminrecord.php",
				data:$("#speakers").serialize(),
				success:function(d){
				}
			});
		});
		$("#hiderecord").change(function(){
			$.ajax({
				type:"POST",
				url:"recordchange.php",
				data:$("#recchange").serialize(),
				success:function(d){
				}
			});
		});
		$(".ar").click(function(e){
			var id = this.id;
			if(!$("#"+id).hasClass("refresh")){
				$(".ar").removeClass("refresh");
				$("#"+id).addClass("refresh");
				$("#tpref").val(id);
				$.ajax({
					type:"POST",
					url:"timepref.php",
					data:$("#tpref").serialize(),
					success:function(d){
						location.reload();
					}
				});	
			}
		});
		$("#changedate").on('click', function(e){
			$("#datepicker").datepicker({
				dateFormat: "yy-mm-dd",
				onSelect: function(){
					$.ajax({
						type: "POST",
						url: "changedate.php",
						data: $("#datepicker").serialize(),
						success:function(d){
							location.reload();
						}
					});
				}
			});
			$("#datepicker").val("<?php echo $dateSelected; ?>");
			$("#datepicker").datepicker("show");			
		});
	</script>
</body>
</html>
