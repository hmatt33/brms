<!doctype html>
<html lang=en>
<head>
    <title>Add a Building</title>
    <meta charset="utf-8">
</head>
<body>
<div id="container">
    <?php include("header.php"); ?>
<div id="content">
<!-- Start of add buildings page-->
        <div class="container"><h2>Register a building</h2></div>

<?php
require ('mysqli_connect.php');
    //After clicking the add building link
    //has the form been submitted?
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        //look for the building name
        if (empty($_POST['Name'])) {
            $errors[] = 'You forgot to enter the building name.';
        } else {
            $name = mysqli_real_escape_string($dbcon, trim($_POST['Name']));
        }
        //look for the building address
        if (empty($_POST['Address'])) {
            $errors[] = 'You forgot to enter the building address.';
        } else {
            $addr = mysqli_real_escape_string($dbcon, trim($_POST['Address']));
        }
        //look for the building's phone number
        if (empty($_POST['PhoneNumber'])) {
            $errors[] = 'You forgot to enter the buildings phone number.';
        } else {
            $phone = mysqli_real_escape_string($dbcon, trim($_POST['PhoneNumber']));
        }
        //look for number of total rooms in the building
        if (empty($_POST['TotalRooms'])) {
            $errors[] = 'You forgot to enter the total apartments/units';
        } else {
            $rooms = mysqli_real_escape_string($dbcon, trim($_POST['TotalRooms']));
        }
        //look for number of vacant rooms in the building
        if (empty($_POST['TotalVacRooms']) && $_POST['TotalVacRooms'] !=0) {
            $errors[] = 'You forgot to enter the number of vacant rooms';
        } else {
            $vac = mysqli_real_escape_string($dbcon, trim($_POST['TotalVacRooms']));
        }
        //if there are no errors
        if (empty($errors)) {
            //check to make sure it isn't a duplicate
            //check the name, address and phone number
            $q = "SELECT BuildingID FROM Buildings WHERE Address='$addr' AND PhoneNumber='$phone' AND BuildingID != $id";
            $result = mysqli_query($dbcon, $q);
            if (mysqli_num_rows($result) == 0) {
                //if no errors and no duplicate
                //add the new building
                $q = "INSERT INTO Buildings(Name, Address, PhoneNumber, TotalRooms, TotalVacRooms) VALUES('$name', '$addr', '$phone', '$rooms', '$vac')";
                $result = mysqli_query ($dbcon, $q);
                if (mysqli_affected_rows($dbcon) == 1) {
                    //if added correctly echo:
                    header("Location: buildings.php");
                    echo '<h3>building has been added.</h3>';
                } else {
                    //if add building failed
                    //error message
                    echo '<p class="error">The building could not be added due to a system error. We apologize for the inconvenience.</p>';
                    //debug message
                    echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>';
                }
                mysqli_close($dbcon);
            } else {
                //building already exits
                echo '<p class="error">building with this address and phone number already exists</p>';
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

<div class="container">
    <form action="add_building.php" method="post">
	<div class="form-group row">
	   <div class="col-xs-3">
        	<p><label class="col-form-label" for="Name">Building Name:</label>
		<input class="form-control" id="fname" type="text" name="Name" size="30" maxlength="30" value="<?php if (isset($_POST['Name'])) echo $_POST['Name']; ?>"></p>
        	<p><label class="col-form-label" for="Address">Buiding Address:</label>
		<input class="form-control" id="lname" type="text" name="Address" size="30" maxlength="40" value="<?php if (isset($_POST['Address'])) echo $_POST['Address']; ?>"></p>
        	<p><label class="col-form-label" for="PhoneNumber">Building Phone Number:</label>
		<input class="form-control" id="PhoneNumber" type="text" name="PhoneNumber" size="30" maxlength="60" value="<?php if (isset($_POST['PhoneNumber'])) echo $_POST['PhoneNumber']; ?>" > </p>
        	<p><label class="col-form-label" for="TotalRooms">Total Number of apartments/units:</label>
		<input class="form-control" id="TotalRooms" type="number" name="TotalRooms" size="30" maxlength="60" value="<?php if (isset($_POST['TotalRooms'])) echo $_POST['TotalRooms']; ?>" > </p>
        	<p><label class="col-form-label" for="TotalVacRooms">Total Vacant Rooms:</label>
		<input class="form-control" id="TotalVacRooms" type="number" name="TotalVacRooms" size="30" maxlength="60" value="<?php if (isset($_POST['TotalVacRooms'])) echo $_POST['TotalVacRooms']; ?>" > </p>
       		<div><p><input class="btn btn-primary" id="submit" type="submit" name="submit" value="Register"></p>
		<p><a href="buildings.php" class="btn btn-info">Back to Buildings</a></p></div>
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
