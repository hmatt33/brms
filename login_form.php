<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
</head>
<body>
	<h2>Login</h2>

	<form action="index.php" method="post">

		<p><label class="label" for="Username">Username:</label>
		<input id="Username" type="text" name="Username" size="30" maxlength="60" value="<?php if (isset($_POST['Username'])) echo $_POST['Username']; ?>" > </p>

		<br>

		<p><label class="label" for="Password">Password:</label>
		<input id="Password" type="password" name="Password" size="20" maxlength="20" value="<?php if (isset($_POST['Password'])) echo $_POST['Password']; ?>" > </p>

		<p>&nbsp;</p>
		
		<p><input id="submit" type="submit" name="submit" value="Login"></p>

	</form>
	<br>

</body>
</html>