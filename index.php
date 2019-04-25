<!doctype html>
<html lang=en>

<head>
	<title>BRMS Login</title>
	<meta charset=utf-8>
		    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
	<div id='container' class="container mx-sm-3 mb-2">
	<!--Start of index (index of site is login)-->
	<div id='content'>
	<div class="jumbotron bg-dark rounded">
		<h1 class="display-4 text-center text-light">Welcome to the Building and Resident Management System</h1>
		<p class="lead text-center text-light">*If you do not yet have a username and password, please contact your system admin</p>
	</div>
	<div class="alert alert-warning">
	<p class="text-center"> WARNING: Only authorized users are allowed to access this system. </p>
	</div>
		<?php
		//This section processes submissions from the login form.
		//Check if the form has been submitted:
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//connect to database
			require ('mysqli_connect.php');
			//check username:
			if (!empty($_POST['Username'])) {
				$user = mysqli_real_escape_string($dbcon, $_POST['Username']);
			} else {
				$user = FALSE;
				echo '<p class="error">You forgot to enter your username.</p>';
			}
			//check password:
			if (!empty($_POST['Password'])) {
					$pass = mysqli_real_escape_string($dbcon, $_POST['Password']);
			} else {
				$pass = FALSE;
				echo '<p class="error">You forgot to enter your password.</p>';
			}
			if ($user && $pass){
			//if no problems
				// Retrieve the user id, first name, and last name for user with that email and password
				$sql = "SELECT UserID, FirstName, LastName, Email, UserLevel FROM Users WHERE (Username='$user' AND Password=sha1('$pass'))";
				//run the query and assign it to the variable $result
				$result = mysqli_query ($dbcon, $sql);
				//Count the number of rows that match the email/password combination
				if (mysqli_num_rows($result) == 1) {
				//The user input matched the database record
					// Start the session, fetch the record and insert the 5 values in an array
					session_start();
					$_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
					$_SESSION['UserLevel'] = (int) $_SESSION['UserLevel'];
					$_SESSION['Username'] = $user;
					//after logging in person is taken to buildings page
					header('Location: buildings.php');
					exit(); // Cancels the rest of the script.
					mysqli_free_result($result);
					mysqli_close($dbcon);
				} else { // No match was made.
					echo '<p class="error">The username and password do not match our records.<br>Please contact your system admin</p>';
				}

			} else { // If there was a problem.
				echo '<p class="error">Please try again.</p>';
			}
			mysqli_close($dbcon);
		}
		// End of login php validation
		?>

		<!--add in login form-->
		<?php include ('login_form.php'); ?>

		<br>

		<footer>
			<?php include('footer.html'); ?>
		</footer>
	</div>
	</div>
	<!--End of index page (index of site is the login, first thing person sees is the login)-->
</body>
</html>
