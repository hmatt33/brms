<!doctype html>
<html lang="en">
<head>
    <title>Residents</title>
	<meta charset="utf-8">
</head>
<body>
<div id="container" class="col-sm-12">
<?php include('header.php'); ?>
<div id="content">

<!--Start of buildings page-->
<h2>All Residents of this Building </h2>

<p>
<?php
    //retrieve all the records from the buildings table.
    require ('mysqli_connect.php'); // Connect to the database.

        //looks for the variable named id that was passed into the url by the previous page
        if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { //from buildings.php
            //saves as variable so this page can use it
        	$id = $_GET['id'];
        }


    $pagerows = 30;
    // Has the total number of pagess already been calculated?
    if (isset($_GET['p']) && is_numeric ($_GET['p'])) {//already been calculated
        $pages=$_GET['p'];
    } else {
        //use this block of code to calculate the number of pages
        //First, check for the total number of records
        $q = "SELECT COUNT(ResidentID) FROM Residents WHERE BuildingID = $id";
        $result = mysqli_query ($dbcon, $q);
        $row = mysqli_fetch_array ($result, MYSQLI_NUM);
        $records = $row[0];
        //Now calculate the number of pages
        if ($records > $pagerows) { //if the number of records will fill more than one page
            //Calculatethe number of pages and round the result up to the nearest integer
            $pages = ceil ($records/$pagerows);
        } else {
            $pages = 1;
        }
    }
    //page check finished
    //Decalre which record to start with
    if (isset($_GET['s']) && is_numeric ($_GET['s'])) { //already been calculated
        $start = $_GET['s'];
    } else {
        $start = 0;
    }
    // Make the query:
    $q = "SELECT ResidentID, BuildingID, FirstName, LastName, Email, PhoneNumber, ApartNum, ResType, BillingAddress, EmerContactInfo, Edit, Del FROM Residents WHERE BuildingID=$id ORDER BY ResidentID ASC LIMIT $start, $pagerows";		
    $result = mysqli_query ($dbcon, $q); // Run the query.
    $residents = mysqli_num_rows($result);
    if ($result) { // If it ran OK, display the records.
    // Table header.
    echo '<table class="table table-striped" cellspacing="15">
        <thead><tr>
        <th scope="col"><b>Select</b></th>
        <th scope="col"><b>Resident ID</b></th>
        <th scope="col"><b>Building ID</b></th>
        <th scope="col"><b>First Name</b></th>
        <th scope="col"><b>Last Name</b></th>
        <th scope="col"><b>Email</b></th>
        <th scope="col"><b>Phone Number</b></th>
        <th scope="col"><b>Apartment/Unit</b></th>
        <th scope="col"><b>Resident Type</b></th>
	    <th scope="col"><b>Billing Address</b></th>
	    <th scope="col"><b>Emergency Contact Information</b></th>
	    <th scope="col"><b>Send Email</b></th>
        <th scope="col"><b>Edit</b></th>
        <th scope="col"><b>Delete</b></th>
        </tr>
	</thead>
    <form action="email_multiple.php" method="post">
	<tbody>';
    // Fetch and print all the records:
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $_SESSION['ResidentID'] = $row['ResidentID'];
        echo '<tr>
            <td><input type="checkbox" value="' . $row['Email'] . '" name="Emails[]"></td>
	        <td>' . $row['ResidentID'] . '</td>
            <td>' . $row['BuildingID'] . '</td>
            <td>' . $row['FirstName'] . '</td>
            <td>' . $row['LastName'] . '</td>
            <td>' . $row['Email'] . '</td>
            <td>' . $row['PhoneNumber'] . '</td>
            <td>' . $row['ApartNum'] . '</td>
            <td>' . $row['ResType'] . '</td>
	        <td>' . $row['BillingAddress'] . '</td>
	        <td>' . $row['EmerContactInfo'] . '</td>
				<td><a class="btn btn-primary" href="email_resident.php?id=' . $row['ResidentID'] . '">Email</a></td>
            <td><a class="btn btn-primary" href="edit_resident.php?id=' . $row['ResidentID'] . '">Edit</a></td>
            <td><a class="btn btn-primary" href="delete_resident.php?id=' . $row['ResidentID'] . '">Delete</a></td>
            </tr>';
        }
        echo '</tbody>';
        echo '</table>'; // Close the table.
        echo '<input type="submit" name="emailSubmit" value="Email Selected Residents" />';
        echo '</form>'; //checkbox form closed
        mysqli_free_result ($result); // Free up the resources.
    } else { // If it did not run OK.
        // Public message:
        echo '<p class="error">An error has occured, residents cannot be displayed</p>';
        // Debugging message:
        echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
    } // End of if ($result). Now display the total number of residents
    $q = "SELECT COUNT(ResidentID) FROM Residents WHERE BuildingID=$id";
    $result = mysqli_query ($dbcon, $q);
    $row = mysqli_fetch_array ($result, MYSQLI_NUM);
    $residents = $row[0];
    mysqli_close($dbcon); // Close the database connection.
    echo "<div class='alert alert-primary my-2' role='alert'><p>Total amount of Residents: $residents</p></div>";
    if ($pages > 1) {
        echo '<p>';
        //What number is the current page?
        $current_page = ($start/$pagerows) + 1;
        //If the page is not the first page then create a Previous link
        if ($current_page != 1) {
          echo '<a href="residents.php?s=' . ($start - $pagerows) . '&p=' . $pages . '&id=' . $id . '">Previous</a>';
        }
        //Create a Next link
        if ($current_page != $pages) {
          echo '<a href="residents.php?s=' . ($start + $pagerows) . '&p=' . $pages . '&id=' . $id . '">Next</a> ';
        }
        echo '</p>';
    }
        //creates link to add new resident
        //id was passed from buildings page and holds the building id
        //id now passed into the url to go to the add_resident page
        //add resident page will now have access to it
        echo '<br> <br> <br>';
        echo '<div class="my-2"><a href="add_resident.php?id=' . $id . '" class="btn btn-primary">Add New Resident</a></div>';
	echo '<div><a href="buildings.php" class="btn btn-info">Back to Buildings</a></div>';

?>
</p>
    <br>
	<footer>
		<?php include('footer.php'); ?>
	</footer>
    </div>
    </div>
</body>
</html>
