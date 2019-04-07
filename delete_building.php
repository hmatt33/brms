<!doctype html>
<html lang=en>
<head>
    <title>Delete a building</title>
    <meta charset=utf-8>
</head>
<body>
<div id="container">
<?php include("header.php"); ?>
<div id="content">
<!-- Start of delete building page-->
    <h2>Delete a building</h2>
    
<?php 
    //check for a valid building ID, through GET or POST:
    if ( (isset($_GET['BuildingID'])) && (is_numeric($_GET['BuildingID'])) ) { //from building delete link
        $id = $_GET['BuildingID'];
    } elseif ( (isset($_POST['BuildingID'])) && (is_numeric($_POST['BuildingID'])) ) { // Form submission.
        $id = $_POST['BuildingID'];
    } else { //if no valid ID, stop the script.
        echo '<p class="error">This page has been accessed in error.</p>';
        include ('footer.php'); 
        exit();
    }
    
    require ('mysqli_connect.php');
    //if the form has been submitted:
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['sure'] == 'Yes') {
            //delete the building
            $q = "DELETE FROM Buildings WHERE BuildingID=$id LIMIT 1";
            $result = mysqli_query($dbcon , $q);
            if (mysqli_affected_rows($dbcon ) == 1) { // If it ran OK.
                // Print a message:
                echo '<h3>The building has been deleted.</h3>';	
                } else { // If the query did not run OK.
                    //error message
                    echo '<p class="error">The building could not be deleted.<br>Probably because it does not exist or due to a system error.</p>';
                    //debug message
                    echo '<p>' . mysqli_error($dbcon ) . '<br />Query: ' . $q . '</p>';
                }
        } else { // No confirmation of deletion.
            echo '<h3>The user has NOT been deleted.</h3>';	
        }
    } else { // Show the form.
        // Retrieve the user's information:
        $q = "SELECT Name FROM Buildings WHERE BuildingID=$id";
        $result = mysqli_query ($dbcon , $q);
        if (mysqli_num_rows($result) == 1) { // Valid building ID, show the form.
            //get the building info
            $row = mysqli_fetch_array ($result, MYSQLI_NUM);
            //display the record being deleted:
            echo "<h3>Are you sure you want to permanently delete $row[0]?</h3>";
            //create the form:
            echo '<form action="delete_record.php" method="post">
            <input id="submit-yes" type="submit" name="sure" value="Yes"> 
            <input id="submit-no" type="submit" name="sure" value="No">
            <input type="hidden" name="BuildingID" value="' . $id . '">
            </form>';
        } else { // Not a valid user ID.
            echo '<p class="error">This page has been accessed in error.</p>';
            echo '<p>&nbsp;</p>';
        }
    } // End of the main submission conditional.
    mysqli_close($dbcon );
    echo '<p>&nbsp;</p>';
    include ('footer.php');
?>
</div>
</div>
</body>
</html>
