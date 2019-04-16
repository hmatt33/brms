<!doctype html>
<html lang=en>
<head>
    <title>Delete a Resident</title>
    <meta charset=utf-8>
</head>
<body>
<div id="container">
<?php include("header.php"); ?>
<div id="content">
<!-- Start of delete building page-->
    
<?php 
    //check for a valid resident ID, through GET or POST:
    if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { //from building delete link
        $id = $_GET['id'];
    } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
        $id = $_POST['id'];
    } else { //if no valid ID, stop the script.
        echo '<p class="error">This page has been accessed in error.</p>';
        include ('footer.php'); 
        exit();
    }
    
    require ('mysqli_connect.php');
$q2 = "SELECT BuildingID FROM Residents WHERE ResidentID=$id";
$result = mysqli_query($dbcon, $q2);
$row = mysqli_fetch_array($result, MYSQLI_NUM);
$building = $row[0];
    //if the form has been submitted:
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['sure'] == 'Yes') {
            //delete the resident
            $q = "DELETE FROM Residents WHERE ResidentID=$id LIMIT 1";
            $result = mysqli_query($dbcon , $q);
            if (mysqli_affected_rows($dbcon ) == 1) { // If it ran OK.
                // Print a message:
                echo '<h3>The resident has been deleted.</h3>';
		header("Location: residents.php?id=" . $building);
                } else { // If the query did not run OK.
                    //error message
                    echo '<p class="error">The resident could not be deleted.<br>Probably because it does not exist or due to a system error.</p>';
                    //debug message
                    echo '<p>' . mysqli_error($dbcon ) . '<br />Query: ' . $q . '</p>';
                }
        } else { // No confirmation of deletion.
            echo '<h3>The resident has NOT been deleted.</h3>';	
	    header("Location: residents.php?id=" . $building);
        }
    } else { // Show the form.
        // Retrieve the user's information:
        $q = "SELECT BuildingID, FirstName, LastName FROM Residents WHERE ResidentID=$id";
        $result = mysqli_query ($dbcon , $q);
        if (mysqli_num_rows($result) == 1) { // Valid resident ID, show the form.
            //get the resident info
            $row = mysqli_fetch_array ($result, MYSQLI_NUM);
            //display the record being deleted:
            echo "<h3>Are you sure you want to permanently delete $row[1] " . $row[2] . "?</h3>";
            //create the form:
            echo '<form action="delete_resident.php" method="post">
            <input id="submit-yes" type="submit" name="sure" value="Yes"> 
            <input id="submit-no" type="submit" name="sure" value="No">
            <input type="hidden" name="id" value="' . $id . '">
	<input type="hidden" name="BuildingID" value="' . $row[0] . '">
            </form>';

        } else { // Not a valid user ID.
            echo '<p class="error">This page has been accessed in error.</p>';
            echo '<p>&nbsp;</p>';
        }
    } // End of the main submission conditional.
    mysqli_close($dbcon );
    echo '<p>&nbsp;</p>';

    include ('footer.html');
?>
</div>
</div>
</body>
</html>
