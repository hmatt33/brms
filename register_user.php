<?php
    session_start();
    if (!isset($_SESSION['UserLevel']) or ($_SESSION['UserLevel'] != 1)) {
        header("Location: buildings.php");
        exit();
    }
    //only admin has access, if level is not 1, sent back to buildings.php
?>

<!doctype html>
<html lang=en>
<head>
    <title>Add a User</title>
    <meta charset=utf-8>
</head>
<body>
<div id="container">
<?php include("header.php"); ?>
<div id="content">
<!-- Start of add buildings page-->
        <div class="container"><h2>Register a User</h2></div>

<?php
require ('mysqli_connect.php');
    //After clicking the add building link
    //has the form been submitted?
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        //look for the users first name
        if (empty($_POST['FirstName'])) {
            $errors[] = 'You forgot to enter the users name.';
        } else {
            $fname = mysqli_real_escape_string($dbcon, trim($_POST['FirstName']));
        }
        //look for the users last name
        if (empty($_POST['LastName'])) {
            $errors[] = 'You forgot to enter the users last name.';
        } else {
            $lname = mysqli_real_escape_string($dbcon, trim($_POST['LastName']));
        }
        //look for the users email
        if (empty($_POST['Email'])) {
            $errors[] = 'You forgot to enter the users email.';
        } else {
            $e = mysqli_real_escape_string($dbcon, trim($_POST['Email']));
        }
        //look for the users username
        if (empty($_POST['Username'])) {
            $errors[] = 'You forgot to enter the username';
        } else {
            $uname = mysqli_real_escape_string($dbcon, trim($_POST['Username']));
        }
        if (!empty($_POST['Password'])) {
            if ($_POST['Password'] != $_POST['Password2']) {
                $errors[] = 'passwords did not match';
            } else {
                $p = mysqli_real_escape_string($dbcon, trim($_POST['Password']));
            }
        } else {
            $errors[] = 'You forgot to enter the password.';
        }
        //if there are no errors
        if (empty($errors)) {
            //check to make sure it isn't a duplicate
            //check the name, address and phone number
            $q = "SELECT UserID FROM Users WHERE Email='$e' AND UserID != $id";
            $result = mysqli_query($dbcon, $q);
            if (mysqli_num_rows($result) == 0) {
                //if no errors and no duplicate
                //add the new building
                $q = "INSERT INTO Users(FirstName, LastName, Email, Username, Password) VALUES('$fname', '$lname', '$e', '$uname', sha1('$p'))";
                $result = mysqli_query ($dbcon, $q);
                if (mysqli_affected_rows($dbcon) == 1) {
                    //if added correctly echo:
                    echo '<h3>User has been added.</h3>';
                } else {
                    //if add user failed
                    //error message
                    echo '<p class="error">The user could not be added due to a system error. We apologize for the inconvenience.</p>';
                    //debug message
                    echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>';
                }
                mysqli_close($dbcon);
            } else {
                //user already exits
                echo '<p class="error">user with this email already exists</p>';
            }
        } else { // Display the errors.
            echo '<p class="error">The following error(s) occurred:<br />';
            //echo each error in the error array
            foreach ($errors as $msg) {
                echo " - $msg<br />\n";
            }
            echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>';
            echo '</p><p>Please try again.</p>';
        } // End of if (empty($errors))section.
    } // End of the conditionals
?>
<div class="container">
    <form action="register_user.php" method="post">
        <div class="form-group row">
	   <div class="col-xs-3">
		<p><label class="col-form-label" for="FirstName">First Name:</label>
		<input class="form-control" id="FirstName" type="text" name="FirstName" size="30" maxlength="30" value="<?php if (isset($_POST['FirstName'])) echo $_POST['FirstName']; ?>"></p>
       		<p><label class="col-form-label" for="LastName">Last Name:</label>
		<input class="form-control" id="LastName" type="text" name="LastName" size="30" maxlength="40" value="<?php if (isset($_POST['LastName'])) echo $_POST['LastName']; ?>"></p>
        	<p><label class="col-form-label" for="Email">Email:</label>
		<input class="form-control" id="Email" type="email" name="Email" size="30" maxlength="60" value="<?php if (isset($_POST['Email'])) echo $_POST['Email']; ?>" > </p>
        	<p><label class="col-form-label" for="Username">Username:</label>
		<input class="form-control" id="Username" type="text" name="Username" size="30" maxlength="60" value="<?php if (isset($_POST['Username'])) echo $_POST['Username']; ?>" > </p>
        	<p><label class="col-form-label" for="Password">Password:</label>
		<input class="form-control" id="Password" type="password" name="Password" size="30" maxlength="60" value="<?php if (isset($_POST['Password'])) echo $_POST['Password']; ?>" > </p>
        	<p><label class="col-form-label" for="Password2">Confirm Password:</label>
		<input class="form-control" id="Password2" type="password" name="Password2" size="30" maxlength="60" value="<?php if (isset($_POST['Password2'])) echo $_POST['Password2']; ?>" > </p>
        	<p><input class="btn btn-primary" id="submit" type="submit" name="submit" value="Register"></p>
	   </div>
	</div>
    </form>
</div>



    <footer>
        <?php include('footer.html'); ?>
    </footer>
</div>
</div>
</body>
</html>
