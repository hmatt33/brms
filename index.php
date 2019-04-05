<!doctype html>
<html lang=en>

<head>
	<title>BRMS Login</title>
	<meta charset=utf-8>
	<link rel="stylesheet" type="text/css" href="site_style.css">
</head>

<body>
	<div id='container'>
	<!--Start of index (index of site is login)-->
	<div id='content'>
		<h1>Welcome to the Building and Resident Management System</h1>
		<h2>Warning: Only authoriized users are allowed to access this system</h2>
		<h2>If you do not yet have a username and password, please contact your system admin</h2>

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
				// Retrieve the user_id, first_name and last name for person with that email and password
				$sql = "SELECT UserID, FirstName, LastName FROM Users WHERE (Username='$user' AND Password='$pass')";
				//run the query and assign it to the variable $result
				$result = mysqli_query ($dbcon, $sql);
				//Count the number of rows that match the email/password combination
				if (@mysqli_num_rows($result) == 1) {
				//The user input matched the database record
					// Start the session, fetch the record and insert the three values in an array
					session_start();
					$_SESSION = mysqli_fetch_array ($result, MYSQLI_ASSOC);
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