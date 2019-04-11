<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container mx-sm-3 mb-2">
	<h1 class="text-center">Login</h1>

	<form action="index.php" method="post">
		
		<div class="form-group">
			<p><label class="label" for="Username">Username:</label>
			<input id="Username" class="form-control" type="text" name="Username" placeholder="Enter username" size="30" maxlength="60" value="<?php if (isset($_POST['Username'])) echo $_POST['Username']; ?>" > </p>
		</div>

		<br>
		
		<div class="form-group">
			<p><label class="label" for="Password">Password:</label>
			<input id="Password" class="form-control" type="password" name="Password" placeholder="Enter password" size="20" maxlength="20" value="<?php if (isset($_POST['Password'])) echo $_POST['Password']; ?>" > </p>
		</div>
		<p>&nbsp;</p>
		

		<p><button type="submit" name="submit" class="btn btn-primary">Login</button></p>
	</form>
	<br>
</div>
</body>
</html>
