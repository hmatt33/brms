<!doctype html>
<html lang=en>
<head>
    <title>Edit a Building</title>
    <meta charset=utf-8>
</head>

<body>
<div id="container">
<?php include("header.php"); ?>
<div id="content">
<!-- Start of edit buildings page-->
        <h2>Edit a building</h2>
    
<?php 
    //After clicking the Edit link in the builings page
    //looks for a valid building ID, either through GET or POST:
    if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { //from buildings.php
        $id = $_GET['id'];
        echo '<h2>Edit Building ID: ';
        echo $id;
        echo '</h2>';
    } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
        $id = $_POST['id'];
        echo '<h2>Edit Building ID: ';
        echo $id;
        echo '</h2>';
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
            $errors[] = 'You forgot to enter the total rooms';
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
                //do the update
                $q = "UPDATE Buildings SET Name='$name', Address='$addr', PhoneNumber='$phone', TotalRooms='$rooms', TotalVacRooms='$vac' WHERE BuildingID=$id LIMIT 1";
                $result = mysqli_query ($dbcon, $q);
                if (mysqli_affected_rows($dbcon) == 1) {
                    //if updated correctly echo:
                    echo '<h3>building has been edited.</h3>';
                } else {
                    //if update failed
                    //error message
                    echo '<p class="error">The building could not be edited due to a system error. We apologize for the inconvenience.</p>';
                    //debug message
                    echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>';
                }
            } else {
                //building already exits
                echo '<p class="error">building with this address and phone number already exits</p>';
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
    $q = "SELECT Name, Address, PhoneNumber, TotalRooms, TotalVacRooms FROM Buildings WHERE BuildingID=$id";
    $result = mysqli_query ($dbcon, $q);
    //if id is valid
    if (mysqli_num_rows($result) == 1) {
        //get the building info
        $row = mysqli_fetch_array ($result, MYSQLI_NUM);
        //create the edit form:
        echo '<form action="edit_building.php" method="post">
        <p><label class="label" for="Name">Building Name:</label><input class="fl-left" type="text" name="Name" size="30" maxlength="50" value="' . $row[0] . '"></p>
        <br>
        <p><label class="label" for="Address">Building Address:</label><input class="fl-left" type="text" name="Address" size="30" maxlength="50" value="' . $row[1] . '"></p>
        <br>
        <p><label class="label" for="PhoneNumber">Building Phone Number:</label><input class="fl-left" type="text" name="PhoneNumber" size="30" maxlength="50" value="' . $row[2] . '"></p>
        <br>
        <p><label class="label" for="TotalRooms">Total Number of Rooms:</label><input class="fl-left" type="number" name="TotalRooms" size="30" maxlength="50" value="' . $row[3] . '"></p>
        <br>
        <p><label class="label" for="TotalVacRooms">Number of Vacant Rooms:</label><input class="fl-left" type="number" name="TotalVacRooms" size="30" maxlength="50" value="' . $row[4] . '"></p>
        <br>
        <p><input id="submit" type="submit" name="submit" value="Edit"></p>
        <br>
        <input type="hidden" name="id" value="' . $id . '" />
        </form>';
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
