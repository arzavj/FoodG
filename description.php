<html>
	<head>
	        <?php
	                include 'head.php';
	        ?>
	</head>
	<body>
		<div data-role="header">
            <a data-rel="back" data-icon="back">Back</a>
			<h1>Apple</h1>
	    </div><!-- /header -->
		<div class="ui-grid-a">
			<div class="ui-block-a"><img src="images/apple.jpg" /></div>
			<div class="ui-block-b">
				<form action="index.php" method="post" data-ajax="false">
				 	<input type="hidden" name="name" value="Apple" />
					<div data-role="fieldcontain">
							<label for="quantity" class="ui-input-text">Quantity: </label>
							<input type="number" name="quantity" value= "1" style="width: 25%;"/><span>units</span>
					<div data-role="fieldcontain">
							<label for="expiry" class="ui-input-text">Expiry Date: </label>
							<input type="date" name="expiry"></input>			
					</div>
					<input type="submit" data-theme="b" value="Submit" />
				</form>
			</div>
		</div><!-- /grid-a -->
	</body>
</html>


