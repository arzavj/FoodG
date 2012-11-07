<!DOCTYPE html> 
<html>
	<head>
	<?php
		$loggingIn = 1;
		include "head.php";
		$error = "";
		$test = 0;
		if(!is_null($_POST['username'])){
			$query = sprintf('SELECT * from users WHERE username = "%s"', $_POST['username']);
			$result = mysql_query($query);
			if (mysql_num_rows($result) > 0){
				$error = "Username already taken. \n";
			}

			if ($_POST['password'] == $_POST['passwordConfirm']){
				if ($error == ""){	
					$insert = sprintf("INSERT INTO users (username, password) VALUES (\"%s\", \"%s\");", $_POST['username'], crypt($_POST['password'], $_POST['username']));
					mysql_query($insert);
					$uID = mysql_fetch_array(mysql_query("Select MAX(id) AS curr from users;"));
					$result2 = mysql_query("SELECT id from storages");
					while($row = mysql_fetch_array($result2)){
						$volume = intval($_POST['length']) * intval($_POST['width']) * intval($_POST['breadth']);
						$insert = sprintf("INSERT INTO user_storages (user_id, storage_id, max_volume) VALUES (%s, %s, %s);", $uID["curr"], $row["id"], $volume);
						mysql_query($insert);
					}
					
					$test = 1;	
				}
			} else {
				$error = $error."Passwords do not match.\n";
			}
		}
	?>

	</head>  
	<body> 
		<script>
			$(document).ready(function(){
				$("#reg").submit(checkDimensions);
			});

			function checkDimensions(){
				var error = "";
				if (!$("#width").val()){
					error = error + "Please enter a width \n";
				}
				
				if (!$("#height").val()){
					error = error + "Please enter a height \n";
				}

				if (!$("#breadth").val()){
					error = error + "Please enter a breadth \n";
				}

				if (error != ""){
					alert(error);
					return false;
				}

				return true;
			}

			function unhide(){
				$("#known").show();
			}

			function showSelect(){
				$("#known").hide();
				$("#unknown").show();
				updateVolume(document.getElementById("simple"));
			}

			function updateVolume(selectObj){
				var idx = selectObj.selectedIndex; 
				var which = selectObj.options[idx].value;

				if(which == 1){
					$("#width").val(1.2);
					$("#height").val(1.2);
					$("#breadth").val(1.2);
				}else if (which == 2){
					$("#width").val(2.4);
					$("#height").val(2.4);
					$("#breadth").val(2.4);
				}else if (which == 3){
					$("#width").val(3.6);
					$("#height").val(3.6);
					$("#breadth").val(3.6);
				}
			}
		</script>

		<div data-role="page">

			<div data-role="header">
				<a data-rel="back" data-icon="back">Back</a>
				<h1>Register</h1>

			</div><!-- /header -->

			<div data-role="content">
				<?php
					echo $error;
				?>

				<?php 
					if ($test){	
				?>
					<script>
						document.cookie =  'user-id=<?php echo $uID["curr"] ?>;'
						window.location="index.php";
					</script>
				<?php
					}
				?>

				<form action="register.php" method="POST" id="reg">
					<input type="text" name="username" id="user" placeholder="Username" >
					<input type="password" name="password" id="pass" placeholder="Password">
					<input type="password" name="passwordConfirm" id="passConfirm" placeholder="Password Confirmation">
					<label for="Space Dimensions" style="font-weight:bold;">Fridge Dimensions: </label>
					<div id="known">
						<center>
							<input type="number" name="width" id ="width" placeholder="L:" style="margin-left:10%;width:20%;display:inline;" step="any"/>
							<input type="number" name="height" id ="height" placeholder="W:" style="margin-left:10%;width:20%;display:inline;" step="any"/>
							<input type="number" name="breadth" id ="breadth" placeholder="B:" style="margin-left:10%;width:20%;display:inline;" step="any"/>
						</center>
						<a href="#" onclick="showSelect();">Don't know. Click here.</a>
					</div>
					<div id="unknown" style="display: none;">
						<select id="simple" onchange="updateVolume(this);">
							<option value="1">Small</option>
							<option value="2">Medium</option>
							<option value="3">Large</option>
						</select>
					</div>
					<br />
        			<input type="submit" value="Register" onclick="unhide();">
				</form>	
			</div><!-- /content -->
		</div><!-- /page -->
	</body>
</html>
