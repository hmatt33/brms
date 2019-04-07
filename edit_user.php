<?php											
    session_start();
    if (!isset($_SESSION['UserLevel']) or ($_SESSION['UserLevel'] != 1)) {
        $alertmsg = "Sorry, you do not have admin status";
        echo "<script type='text/javascript'>alert('$alertmsg');</script>";
        header("Location: buildings.php");
        exit();
    }
    //only admin has access, if level is not 1, sent back to buildings.php
?>

<!doctype html>
<html lang=en>
<head>
    <title>Edit a User</title>
    <meta charset=utf-8>
</head>
    
<body>
<div id="container">
<?php include("header.php"); ?>
<div id="content">
<!-- Start of edit users page-->
<h2>Edit a User</h2>
    
<?php 
    //After clicking the Edit link in the admin page that displays all users
    //looks for a valid user ID, either through GET or POST:
    if ( (isset($_GET['UserID'])) && (is_numeric($_GET['UserID'])) ) { //from buildings.php
        $id = $_GET['UserID'];
        echo '<h2>Edit User ID: ';
        echo $id;
        echo '</h2>';
    } elseif ( (isset($_POST['UserID'])) && (is_numeric($_POST['UserID'])) ) {
        $id = $_POST['UserID'];
        echo '<h2>Edit User ID: ';
        echo $id;
        echo '</h2>';
    } else { // If no valid ID, stop the script
        echo '<p class="error">This page has been accessed in error.</p>';
        include ('footer.php'); 
        exit();
    }
    require ('mysqli_connect.php'); 
    //if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        //look for the first name
        if (empty($_POST['FirstName'])) {
            $errors[] = 'You forgot to enter the first name.';
        } else {
            $fname = mysqli_real_escape_string($dbcon, trim($_POST['FirstName']));
        }
        //look for the last name
        if (empty($_POST['LastName'])) {
            $errors[] = 'You forgot to enter the last name.';
        } else {
            $lname = mysqli_real_escape_string($dbcon, trim($_POST['Address']));
        }
        //look for the email
        if (empty($_POST['Email'])) {
            $errors[] = 'You forgot to enter the email.';
        } else {
            $e = mysqli_real_escape_string($dbcon, trim($_POST['Email']));
        }
        //look for username
        if (empty($_POST['Username'])) {
            $errors[] = 'You forgot to enter the username';
        } else {
            $uname = mysqli_real_escape_string($dbcon, trim($_POST['Username']));
        }
        //if there are no errors
        if (empty($errors)) {
            //check to make sure it isn't a duplicate
            //check the name, address and phone number
            $q = "SELECT UserID FROM Users WHERE Email='$e' AND UserID != $id";
            $result = mysqli_query($dbcon, $q);
            if (mysqli_num_rows($result) == 0) {
                //if no errors and no duplicate
                //do the update
                $q = "UPDATE Users SET FirstName='$fname', LastName='$lname', Email='$e', Username='$uname' WHERE UserID=$id LIMIT 1";
                $result = mysqli_query ($dbcon, $q);
                if (mysqli_affected_rows($dbcon) == 1) {
                    //if updated correctly echo:
                    echo '<h3>User has been edited.</h3>';
                } else {
                    //if update failed
                    //error message
                    echo '<p class="error">The user could not be edited due to a system error. We apologize for the inconvenience.</p>';
                    //debug message
                    echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>';
                }
            } else {
                //user with same email already exists
                echo '<p class="error">user with with this email already exits</p>';
            }
        } else { // Display the errors.
            echo '<p class="error">The following error(s) occurred:<br />';
            //echo each error in the error array
            foreach ($errors as $msg) {
                echo " - $msg<br />\n";
            }
            echo '</p><p>Please try again.</p>';
        } // End of if (empty($errors))section.
    } // End of the conditionals
    // Select the user's information:
    $q = "SELECT FirstName, LastName, Email, Username FROM Users WHERE UserID=$id";
    $result = mysqli_query ($dbcon, $q);
    //if id is valid
    if (mysqli_num_rows($result) == 1) {
        //get the user info
        $row = mysqli_fetch_array ($result, MYSQLI_NUM);
        //create the edit form:
        echo '<form action="edit_user.php" method="post">
        <p><label class="label" for="FirstName">First Name:</label><input class="fl-left" type="text" name="FirstName" size="30" maxlength="50" value="' . $row[0] . '"></p>
        <br>
        <p><label class="label" for="LastName">Last Name:</label><input class="fl-left" type="text" name="LastName" size="30" maxlength="50" value="' . $row[1] . '"></p>
        <br>
        <p><label class="label" for="Email">Email:</label><input class="fl-left" type="text" name="Email" size="30" maxlength="50" value="' . $row[2] . '"></p>
        <br>
        <p><label class="label" for="Username">Username:</label><input class="fl-left" type="text" name="Username" size="30" maxlength="50" value="' . $row[3] . '"></p>
        <br>
        <p><input id="submit" type="submit" name="submit" value="Edit"></p>
        <br>
        <input type="hidden" name="UserID" value="' . $id . '" />
        </form>';
    } else {
        echo '<p class="error">This page has been accessed in error.</p>';
    }
    mysqli_close($dbcon);
?>
    <footer>
		<?php include('footer.php'); ?>
	</footer>
</div>
</div>
</body>
</html>
