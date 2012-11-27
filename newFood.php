<html>
	<head>
	        <?php
	                include 'head.php';
	        ?>
	</head>
	<body>
		<?php 
			include "helperFunctions.php";
			if ($_POST["food"]){
				$query = sprintf("INSERT INTO foods(category_id, food) VALUES (%s, '%s')", $_POST["catID"], $_POST["food"]);
				echo $query;
				mysql_query($query);
			}
		?>

		<div data-role="page" data-add-back-btn="true">
		<div data-role="header">
			<h1>New Food</h1>
			<a href="logout.php" data-role="button" class="ui-btn-right">Logout</a>
	    </div><!-- /header -->

	    <div data-role="content" style="text-align: center;">
			<form action="newFood.php" id="newFood" method="POST">
				<input type="text" id= "quantField" name="food" style="display: inline; width: 50%;" placeholder="Food Name..."/>
				<div data-role="fieldcontain">
					<label for="select-choice-1" class="select">Category: </label>
					<select name="catID" data-mini="true">
						<?php
							$categories = mysql_query("SELECT * from categories");
							while($row = mysql_fetch_array($categories)){
						?>
							<option value="<?= $row["id"]?>"><?= $row["category"]?></option>
						<?php } ?>
					</select>
				</div>
				<input type="submit" data-theme="b" name="btnS" value="Create Food" />
			</form>
			
		</div>
		</div>
		
	</body>
</html>


