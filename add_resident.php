<!doctype html>
<html lang=en>
<head>
    <title>Add a Resident</title>
    <meta charset=utf-8>
</head> 
<body>
<div id="container">
<?php include("header.php"); ?>
<div id="content">
<!-- Start of add residents page-->
        <h2>Add a resident</h2>

<?php 
require ('mysqli_connect.php'); 
    //After clicking the add resident link
    //has the form been submitted?
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        //look for the building id the resident belongs to
        if (empty($_POST['BuildingID'])) {
            $errors[] = 'You forgot to enter the building id.';
        } else {
            $buildid = mysqli_real_escape_string($dbcon, trim($_POST['BuildingID']));
        }
        //look for the resident first name
        if (empty($_POST['FirstName'])) {
            $errors[] = 'You forgot to enter the resident name.';
        } else {
            $name = mysqli_real_escape_string($dbcon, trim($_POST['FirstName']));
        }
        //look for the resident lastname
        if (empty($_POST['LastName'])) {
            $errors[] = 'You forgot to enter the resident address.';
        } else {
            $last = mysqli_real_escape_string($dbcon, trim($_POST['LastName']));
        }
         if (empty($_POST['Email'])) {
            $errors[] = 'You forgot to enter the resident email.';
        } else {
            $email = mysqli_real_escape_string($dbcon, trim($_POST['Email']));
        }
        //look for the resident's phone number
        if (empty($_POST['PhoneNumber'])) {
            $errors[] = 'You forgot to enter the resident phone number.';
        } else {
            $phone = mysqli_real_escape_string($dbcon, trim($_POST['PhoneNumber']));
        }
        //look for number of resident apartment
        if (empty($_POST['ApartNum'])) {
            $errors[] = 'You forgot to enter resident apartment number.';
        } else {
            $apart = mysqli_real_escape_string($dbcon, trim($_POST['ApartNum']));
        }
        //look for resident type
        if (empty($_POST['ResType'])) {
            $errors[] = 'You forgot to enter resident type';
        } else {
            $res = mysqli_real_escape_string($dbcon, trim($_POST['ResType']));
        }
          if (empty($_POST['BillingAddress'])) {
            $errors[] = 'You forgot to enter the resident billing address.';
        } else {
            $bill = mysqli_real_escape_string($dbcon, trim($_POST['BillingAddress']));
        }
          if (empty($_POST['EmerContactInfo'])) {
            $errors[] = 'You forgot to enter the resident emergency contact info.';
        } else {
            $emer = mysqli_real_escape_string($dbcon, trim($_POST['EmerContactInfo']));
        }
        //if there are no errors
        if (empty($errors)) {
            //check to make sure it isn't a duplicate
            //check the name, address and phone number
            $q = "SELECT ResidentID FROM Residents WHERE BuildingID=$buildid";
            $result = mysqli_query($dbcon, $q);
            if (mysqli_num_rows($result) == 0) {
                //if no errors and no duplicate
                //add the new resident
                $q = "INSERT INTO Residents(BuildingID, FirstName, LastName, Email, PhoneNumber, ApartNum, ResType, BillingAddress, EmerContactInfo) VALUES('$buildid', '$name', '$last', '$email', '$phone', '$apart', '$res', '$bill', '$emer')";
                $result = mysqli_query ($dbcon, $q);
                if (mysqli_affected_rows($dbcon) == 1) {
                    //if added correctly echo:          
                    header("Location: residents.php");
                    echo '<h3>resident has been added.</h3>';
                } else {
                    //if add building failed
                    //error message
                    echo '<p class="error">The resident could not be added due to a system error. We apologize for the inconvenience.</p>';
                    //debug message
                    echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>';
                }
                mysqli_close($dbcon);
            } else {
                //resident already exists
                echo '<p class="error">resident with this address and phone number already exists</p>';
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
?>
    <h2>Register</h2>
    <form action="add_resident.php" method="post">
        <p><label class="label" for="ResidentID">Resident ID:</label><input id="ResidentID" type="number" name="Name" size="30" maxlength="30" value="<?php if (isset($_POST['ResidentID'])) echo $_POST['ResidentID']; ?>"></p>
        <p><label class="label" for="BuildID">Building ID:</label><input id="BuildID" type="number" name="Name" size="30" maxlength="30" value="<?php if (isset($_POST['BuildingID'])) echo $_POST['BuildingID']; ?>"></p>
        <p><label class="label" for="FirstName">First Name:</label><input id="FirstName" type="text" name="FirstName" size="30" maxlength="30" value="<?php if (isset($_POST['FirstName'])) echo $_POST['FirstName']; ?>"></p>
        <p><label class="label" for="LastName">Last Name:</label><input id="LastName" type="text" name="LastName" size="30" maxlength="40" value="<?php if (isset($_POST['LastName'])) echo $_POST['LastName']; ?>"></p>
        <p><label class="label" for="Email">Last Name:</label><input id="Email" type="text" name="Email" size="30" maxlength="40" value="<?php if (isset($_POST['Email'])) echo $_POST['Email']; ?>"></p>
        <p><label class="label" for="PhoneNumber">Resident Phone Number:</label><input id="PhoneNumber" type="text" name="PhoneNumber" size="30" maxlength="60" value="<?php if (isset($_POST['PhoneNumber'])) echo $_POST['PhoneNumber']; ?>" > </p>
        <p><label class="label" for="ApartNum">Apartment Number:</label><input id="ApartNum" type="number" name="ApartNum" size="30" maxlength="60" value="<?php if (isset($_POST['ApartNum'])) echo $_POST['ApartNum']; ?>" > </p>
        <p><label class="label" for="ResType">Resident Type:</label><input id="ResType" type="text" name="ResType" size="30" maxlength="60" value="<?php if (isset($_POST['ResType'])) echo $_POST['ResType']; ?>" > </p>
        <p><label class="label" for="BillingAddress">Billing Address:</label><input id="BillingAddress" type="text" name="BillingAddress" size="30" maxlength="60" value="<?php if (isset($_POST['BillingAddress'])) echo $_POST['BillingAddress']; ?>" > </p>
        <p><label class="label" for="EmerContactInfo">Emergency Contact Info:</label><input id="EmerContactInfo" type="text" name="EmerContactInfo" size="30" maxlength="60" value="<?php if (isset($_POST['EmerContactInfo'])) echo $_POST['EmerContactInfo']; ?>" > </p>
        <p><input id="submit" type="submit" name="submit" value="Register"></p>
    </form>
    
    <footer>
        <?php include('footer.html'); ?>
    </footer>
</div>
</div>
</body>
</html>