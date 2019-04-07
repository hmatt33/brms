<!doctype html>
<html lang="en">
<head>
    <title>All Buildings</title>
	<meta charset="utf-8">
</head>
<body>
<div id="container">
<?php include('header.php'); ?>
<div id="content">
        
<!--Start of buildings page-->
<h2>All Buildings Within the System</h2>

<p>
<?php 
    //retrieve all the records from the buildings table.
    require ('mysqli_connect.php'); // Connect to the database.
    
    $pagerows = 4;
    // Has the total number of pagess already been calculated?
    if (isset($_GET['p']) && is_numeric ($_GET['p'])) {//already been calculated
        $pages=$_GET['p'];
    } else {
        //use this block of code to calculate the number of pages
        //First, check for the total number of records
        $q = "SELECT COUNT(BuildingID) FROM Buildings";
        $result = @mysqli_query ($dbcon, $q);
        $row = @mysqli_fetch_array ($result, MYSQLI_NUM);
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
    $q = "SELECT BuildingID, Name, Address, PhoneNumber, TotalRooms, TotalVacRooms, Edit, Del FROM Buildings ORDER BY BuildingID ASC LIMIT $start, $pagerows";		
    $result = @mysqli_query ($dbcon, $q); // Run the query.
    $buildings = mysqli_num_rows($result);
    if ($result) { // If it ran OK, display the records.
    // Table header.
    echo '<table>
        <tr><td><b>Building ID</b></td>
        <tr><td><b>Building Name</b></td>
        <td><b>Address</b></td>
        <td><b>Phone Number</b></td>
        <td><b>Total Rooms</b></td>
        <td><b>Total Vacancies</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
        </tr>';
    // Fetch and print all the records:
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo '<tr>
            <td>' . $row['BuildingID'] . '</td>
            <td>' . $row['Name'] . '</td>
            <td>' . $row['Address'] . '</td>
            <td>' . $row['PhoneNumber'] . '</td>
            <td>' . $row['TotalRooms'] . '</td>
            <td>' . $row['TotalVacRooms'] . '</td>
            <td><a href="edit_building.php?id=' . $row['BuildingID'] . '">Delete</a></td>
            <td><a href="delete_building.php?id=' . $row['BuildingID'] . '">Delete</a></td>
            </tr>';
        }
        echo '</table>'; // Close the table.
        mysqli_free_result ($result); // Free up the resources.	
    } else { // If it did not run OK.
        // Public message:
        echo '<p class="error">An error has occured, buildings cannot be displayed</p>';
        // Debugging message:
        echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
    } // End of if ($result). Now display the total number of records/buildings.
    $q = "SELECT COUNT(BuildingID) FROM Buildings";
    $result = @mysqli_query ($dbcon, $q);
    $row = @mysqli_fetch_array ($result, MYSQLI_NUM);
    $buildings = $row[0];
    mysqli_close($dbcon); // Close the database connection.
    echo "<p>Total amount of Buildings: $buildings</p>";
    if ($pages > 1) {
        echo '<p>';
        //What number is the current page?
        $current_page = ($start/$pagerows) + 1;
        //If the page is not the first page then create a Previous link
        if ($current_page != 1) {
        echo '<a href="buildings.php?s=' . ($start - $pagerows) . '&p=' . $pages . '">Previous</a> ';
        }
        //Create a Next link
        if ($current_page != $pages) {
        echo '<a href="buildings.php?s=' . ($start + $pagerows) . '&p=' . $pages . '">Next</a> ';
        }
        echo '</p>';
    }
?>
</p> 
    <br>
    <br>
    <br>
    <!--link to create new building-->
    <div id="add">
        <a href="add_building.php">Add New Building</a>
    </div>
	<footer>
		<?php include('footer.php'); ?>
	</footer>
    </div>
    </div>
</body>
</html>