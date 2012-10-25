<head>
        <?php
                include 'head.php';
        ?>
</head>
<body>
        <div data-role="header">
                <a href="#Home" data-icon="back">Back</a>
                        <h1>Categories</h1>
        </div><!-- /header -->

	<img src="images/apple.jpg" />
	
	<form action="submit.php" method="post">
		<h1> Apple </h1> <input type="hidden" name="name" value="Apple" />
		Quantity: <input type="text" name="quantity" value= "1" style="width: 25%;"/><br />
		<input type="submit" value="Submit" />
	</form>
</body>
