
<!doctype html>
<html lang=en>
<head>
  <title>Change Password</title>
  <meta charset=utf-8>
</head>

<body>
  <div id="container">
    <?php include("header.php"); ?>
    <div id="content">
      <!-- Start of edit users page-->
      <h2>Change Password</h2>

      <?php
      session_start();

      $userid = $_SESSION['UserID'];
      //After clicking the Edit link in the admin page that displays all users
      //looks for a valid user ID, either through GET or POST:
      require ('mysqli_connect.php');
      //if the form is submitted
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();


        //look for the first name
        if (empty($_POST['NewPassword'])) {
          $errors[] = 'You forgot to enter the a new password.';
        } else {
          $newpass = mysqli_real_escape_string($dbcon, trim($_POST['NewPassword']));
        }
        //look for the last name
        if (empty($_POST['Password'])) {
          $errors[] = 'You forgot to enter your password.';
        } else {
          $pass = mysqli_real_escape_string($dbcon, trim($_POST['Password']));
        }
        //look for the email
        if (empty($_POST['ConfirmP'])) {
          $errors[] = 'You forgot to confirm your password.';
        } else {
          $confirm = mysqli_real_escape_string($dbcon, trim($_POST['ConfirmP']));
        }
        $sqluser = "SELECT Username FROM Users WHERE UserID=$userid";
        $result2 = mysqli_query ($dbcon, $sqluser);
        $row = mysqli_fetch_array ($result2, MYSQLI_NUM);
        $user = $row[0];
        if (!empty($_POST['Password'])) {
          $check = "SELECT UserID FROM Users WHERE Username='$user' AND Password=sha1('$pass')";
          $match = mysqli_query ($dbcon, $check);
          if(mysqli_num_rows($match) == 0) {
            $errors[] = 'Incorrect password';
          }
          if ($_POST['NewPassword'] != $_POST['ConfirmP']) {
            $errors[] = 'Passwords did not match.';
          } else {
            $p = mysqli_real_escape_string($dbcon, trim($_POST['Password']));
          }
        } else {
          $errors[] = 'You forgot to enter the password.';
        }
        //if there are no errors
        if (empty($errors)) {
          $q = "UPDATE Users SET Password=sha1('$newpass') WHERE Username='$user'";
          $result = mysqli_query ($dbcon, $q);
          if (mysqli_affected_rows($dbcon) == 1) {
            header('Location: logout.php');
          } else {
            //if update failed
            //error message
            echo '<p class="error">The user could not be edited due to a system error. We apologize for the inconvenience.</p>';
            //debug message
            echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>';
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
      
      echo '<form action="password.php" method="post">
      <p><label class="label" for="Username">Username:</label><input class="fl-left" type="text" name="Username" size="30" maxlength="50" value="' . $_SESSION['Username'] . '" disabled></p>
      <br>
      <p><label class="label" for="Password">Password:</label><input class="fl-left" type="password" name="Password" size="30" maxlength="50" value=""></p>
      <br>
      <p><label class="label" for="NewPassword">New Password:</label><input class="fl-left" type="password" name="NewPassword" size="30" maxlength="50" value=""></p>
      <br>
      <p><label class="label" for="ConfirmP">Confirm Password:</label><input class="fl-left" type="password" name="ConfirmP" size="30" maxlength="50" value=""></p>
      <br>
      <p><input id="submit" type="submit" name="submit" value="Submit"></p>
      <br>
      <input type="hidden" name="id" value="" />
      </form>';
      mysqli_close($dbcon);
      ?>
      <footer>
        <?php include('footer.html'); ?>
      </footer>
    </div>
  </div>
</body>
</html>
