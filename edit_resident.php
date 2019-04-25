<!doctype html>
<html lang=en>
<head>
  <title>Edit a Resident</title>
  <meta charset=utf-8>
</head>
<body>
  <div id="container">
    <?php include("header.php"); ?>
    <div id="content">
      <!-- Start of edit residents page-->
      <div class="container"><h2>Edit a Resident</h2></div>

      <?php
      //After clicking the Edit link in the builings page
      //looks for a valid building ID, either through GET or POST:
      if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { //from buildings.php
        $id = $_GET['id'];
      } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
        $id = $_POST['id'];
      } else { // If no valid ID, stop the script
        echo '<p class="error">This page has been accessed in error.</p>';
        include ('footer.php');
        exit();
      }
      require ('mysqli_connect.php');
      // Has the form been submitted?
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        //look for the building name
        if (empty($_POST['FirstName'])) {
          $errors[] = 'You forgot to enter first name.';
        } else {
          $fname = mysqli_real_escape_string($dbcon, trim($_POST['FirstName']));
        }
        //look for the building address
        if (empty($_POST['LastName'])) {
          $errors[] = 'You forgot to enter last name.';
        } else {
          $lname = mysqli_real_escape_string($dbcon, trim($_POST['LastName']));
        }
        if (empty($_POST['Email'])) {
          $errors[] = 'You forgot to enter the email.';
        } else {
          $email = mysqli_real_escape_string($dbcon, trim($_POST['Email']));
        }
        //look for the building's phone number
        if (empty($_POST['PhoneNumber'])) {
          $errors[] = 'You forgot to enter the phone number.';
        } else {
          $phone = mysqli_real_escape_string($dbcon, trim($_POST['PhoneNumber']));
        }
        //look for number of total rooms in the building
        if (empty($_POST['ApartNum'])) {
          $errors[] = 'You forgot to enter the apartment number.';
        } else {
          $apart = mysqli_real_escape_string($dbcon, trim($_POST['ApartNum']));
        }
        //look for number of vacant rooms in the building
        if (empty($_POST['ResType'])) {
          $errors[] = 'You forgot to enter the resident type.';
        } else {
          $res = mysqli_real_escape_string($dbcon, trim($_POST['ResType']));
        }
        if (empty($_POST['BillingAddress'])) {
          $errors[] = 'You forgot to enter the billing address';
        } else {
          $bill = mysqli_real_escape_string($dbcon, trim($_POST['BillingAddress']));
        }
        if (empty($_POST['EmerContactInfo'])) {
          $errors[] = 'You forgot to enter the emergency contact information.';
        } else {
          $emer = mysqli_real_escape_string($dbcon, trim($_POST['EmerContactInfo']));
        }
        //if there are no errors
        if (empty($errors)) {
          //check to make sure it isn't a duplicate
          //check the name, address and phone number
          $q = "SELECT ResidentID FROM Residents WHERE FirstName='$fname' AND LastName='$lname' AND Email='$email' AND PhoneNumber='$phone' AND ApartNum='$apart' AND ResType='$res' AND BillingAddress='$bill' AND EmerContactInfo='$emer' AND ResidentID != $id";
          $result = mysqli_query($dbcon, $q);
          if (mysqli_num_rows($result) == 0) {
            //if no errors and no duplicate
            //do the update
            $q = "UPDATE Residents SET FirstName='$fname', LastName='$lname', Email='$email', PhoneNumber='$phone', ApartNum='$apart', ResType='$res', BillingAddress='$bill', EmerContactInfo='$emer' WHERE ResidentID=$id LIMIT 1";
            $result = mysqli_query ($dbcon, $q);
            if (mysqli_affected_rows($dbcon) == 1) {
              //if updated redirect to residents page for the building in which the resident lives:
              $q = "SELECT BuildingID FROM Residents WHERE ResidentID='$id'";
              $result = mysqli_query ($dbcon, $q);
            } else {
              //if update failed
              //error message
              echo '<p class="error">This resident could not be edited due to a system error. We apologize for the inconvenience.</p>';
              //debug message
              echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>';
            }
          } else {
            //building already exits
            echo '<p class="error">Resident with this information already exits</p>';

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
      $q = "SELECT FirstName, LastName, Email, PhoneNumber, ApartNum, ResType, BillingAddress, EmerContactInfo FROM Residents WHERE ResidentID=$id";
      $result = mysqli_query ($dbcon, $q);
      //if id is valid
      if (mysqli_num_rows($result) == 1) {
        //get the building info
        $row = mysqli_fetch_array ($result, MYSQLI_NUM);
        //create the edit form:
        echo '<div class="container"><form action="edit_resident.php" method="post"><div class="form-group row"><div class="col-xs-3">
        <p><label class="col-form-label" for="FirstName">First Name:</label><input class="fl-left form-control" type="text" name="FirstName" size="30" maxlength="50" value="' . $row[0] . '"></p>
        <br>
        <p><label class="col-form-label" for="LastName">Last Name:</label><input class="fl-left form-control" type="text" name="LastName" size="30" maxlength="50" value="' . $row[1] . '"></p>
        <br>
        <p><label class="col-form-label" for="Emai">Email:</label><input class="fl-left form-control" type="text" name="Email" size="30" maxlength="50" value="' . $row[2] . '"></p>
        <br>
        <p><label class="col-form-label" for="PhoneNumber">Phone Number:</label><input class="fl-left form-control" type="text" name="PhoneNumber" size="30" maxlength="50" value="' . $row[3] . '"></p>
        <br>
        <p><label class="col-form-label" for="ApartNum">Apartment Number:</label><input class="fl-left form-control" type="text" name="ApartNum" size="30" maxlength="50" value="' . $row[4] . '"></p>
        <br>
        <p><label class="col-form-label" for="ResType">Resident Type:</label><input class="fl-left form-control" type="text" name="ResType" size="30" maxlength="50" value="' . $row[5] . '"></p>
        <br>
        <p><label class="col-form-label" for="BillingAddress">Billing Address:</label><input class="fl-left form-control" type="text" name="BillingAddress" size="30" maxlength="50" value="' . $row[6] . '"></p>
        <br>
        <p><label class="col-form-label" for="EmerContactInfo">Emergency Contact Information:</label><input class="fl-left form-control" type="text" name="EmerContactInfo" size="30" maxlength="50" value="' . $row[7] . '"></p>
        <br>
        <input type="hidden" name="id" value="' . $id . '" />
        <p><input class="btn btn-primary" id="submit" type="submit" name="submit" value="Edit"></p>
        <a href="residents.php?id=' . $id . '"  class="btn btn-info">Back to Residents</a>
        </div></div></form></div>';
      } else {
        echo '<p class="error">This page has been accessed in error.</p>';
      }
      mysqli_close($dbcon);
      ?>
      <footer>
        <?php include('footer.html'); ?>
      </footer>
    </div>
  </div>
</body>
</html>
