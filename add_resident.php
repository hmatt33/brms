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
        <div class="container"><h2>Add a Resident</h2></div>
<?php 

if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { //from residents
        $id = $_GET['id'];
    } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
        $id = $_POST['id'];
    } else { // If no valid ID, stop the script
        echo '<p class="error">This page has been accessed in error.</p>';
        include ('footer.php'); 
        exit();
    }

require ('mysqli_connect.php');
    //After clicking the add resident link
    //has the form been submitted?
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
      
        //look for the resident first name
        if (empty($_POST['FirstName'])) {
            $errors[] = 'You forgot to enter the resident name.';
        } else {
            $fname = mysqli_real_escape_string($dbcon, trim($_POST['FirstName']));
        }
        //look for the resident lastname
        if (empty($_POST['LastName'])) {
            $errors[] = 'You forgot to enter the resident address.';
        } else {
            $lname = mysqli_real_escape_string($dbcon, trim($_POST['LastName']));
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
            //add the new resident
            $q = "INSERT INTO Residents(BuildingID, FirstName, LastName, Email, PhoneNumber, ApartNum, ResType, BillingAddress, EmerContactInfo, Edit, Del) VALUES('$id', '$fname', '$lname', '$email', '$phone', '$apart', '$res', '$bill', '$emer', 'Edit', 'Delete')";
            $result = mysqli_query ($dbcon, $q);
            if (mysqli_affected_rows($dbcon) == 1) {
                //if added correctly echo:          
                header("Location: residents.php?id=$id");
                echo '<h3>resident has been added.</h3>';
            } else {
                //if add building failed
                //error message
                echo '<p class="error">The resident could not be added due to a system error. We apologize for the inconvenience.</p>';
                //debug message
                echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>';
            }
            mysqli_close($dbcon);
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
<div class="container">
    <form action="add_resident.php" method="post">
	<div class="form-group row">
	<div class="col-xs-3">
        <p><label class="col-form-label" for="FirstName">First Name:</label><input class="form-control" id="FirstName" type="text" name="FirstName" size="30" maxlength="30" value="<?php if (isset($_POST['FirstName'])) echo $_POST['FirstName']; ?>"></p>

        <p><label class="col-form-label" for="LastName">Last Name:</label><input class="form-control" id="LastName" type="text" name="LastName" size="30" maxlength="40" value="<?php if (isset($_POST['LastName'])) echo $_POST['LastName']; ?>"></p>

        <p><label class="col-form-label" for="Email">Email:</label><input class="form-control" id="Email" type="email" name="Email" size="30" maxlength="60" value="<?php if (isset($_POST['Email'])) echo $_POST['Email']; ?>"></p>

        <p><label class="col-form-label" for="PhoneNumber">Resident Phone Number:</label><input class="form-control" id="PhoneNumber" type="text" name="PhoneNumber" size="30" maxlength="60" value="<?php if (isset($_POST['PhoneNumber'])) echo $_POST['PhoneNumber']; ?>" > </p>

        <p><label class="col-form-label" for="ApartNum">Apartment Number:</label><input class="form-control" id="ApartNum" type="number" name="ApartNum" size="30" maxlength="60" value="<?php if (isset($_POST['ApartNum'])) echo $_POST['ApartNum']; ?>" > </p>

        <p><label class="col-form-label" for="ResType">Resident Type:</label><input class="form-control" id="ResType" type="text" name="ResType" size="30" maxlength="60" value="<?php if (isset($_POST['ResType'])) echo $_POST['ResType']; ?>" > </p>

        <p><label class="col-form-label" for="BillingAddress">Billing Address:</label><input class="form-control" id="BillingAddress" type="text" name="BillingAddress" size="30" maxlength="60" value="<?php if (isset($_POST['BillingAddress'])) echo $_POST['BillingAddress']; ?>" > </p>

        <p><label class="col-formlabel" for="EmerContactInfo">Emergency Contact Info:</label><input class="form-control" id="EmerContactInfo" type="text" name="EmerContactInfo" size="30" maxlength="60" value="<?php if (isset($_POST['EmerContactInfo'])) echo $_POST['EmerContactInfo']; ?>" > </p>

        <input type="hidden" name="id" value="<?php echo $id ?>"/>

        <p><input class="btn btn-primary" id="submit" type="submit" name="submit" value="Register"></p>
	<a href="residents.php?id=<?php echo $id ?>" class="btn btn-info">Back to Residents</a>
	</div></div>
    </form>
</div>
    <footer>
        <?php include('footer.html'); ?>
    </footer>
</div>
</div>
</body>
</html>
