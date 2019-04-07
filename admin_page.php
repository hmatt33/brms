<?php											
    session_start();
    if (!isset($_SESSION['user_level']) or ($_SESSION['user_level'] != 1)) {
        $alertmsg = "Sorry, you do not have admin status";
        echo "<script type='text/javascript'>alert('$alertmsg');</script>";
        header("Location: buildings.php");
        exit();
    }
    //only admin has access, if level is not 1, sent back to buildings.php
?>

<!--display all users, only admin has access to this page -->
<!--Have edit and delete clumns link to edit/delete users pages for each entry-->
<!doctype html>
<html lang="en">
<head>
    <title>All Users</title>
	<meta charset="utf-8">
</head>
<body>
<div id="container">
<?php include('header.php'); ?>
<div id="content">
        
<!--Start of buildings page-->
<h2>All Users Registered in the System</h2>

<p>
<?php 
    //retrieve all the records from the users table.
    require ('mysqli_connect.php'); // Connect to the database.
    
    $pagerows = 4;
    // Has the total number of pagess already been calculated?
    if (isset($_GET['p']) && is_numeric ($_GET['p'])) { //already been calculated
        $pages=$_GET['p'];
    } else {
        //use this block of code to calculate the number of pages
        //First, check for the total number of records
        $q = "SELECT COUNT(UserID) FROM Users";
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
    $q = "SELECT UserID, FirstName, LastName, Email, Username, Edit, Del FROM Users ORDER BY UserID ASC LIMIT $start, $pagerows";
    $result = @mysqli_query ($dbcon, $q); // Run the query.
    $buildings = mysqli_num_rows($result);
    if ($result) { // If it ran OK, display the records.
    // Table header.
    echo '<table>
        <tr><td><b>User ID</b></td>
        <tr><td><b>First Name</b></td>
        <td><b>Last Name</b></td>
        <td><b>Email</b></td>
        <td><b>Username</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
        </tr>';
    // Fetch and print all the records:
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo '<tr>
            <td>' . $row['UserID'] . '</td>
            <td>' . $row['FirstName'] . '</td>
            <td>' . $row['LastName'] . '</td>
            <td>' . $row['Email'] . '</td>
            <td>' . $row['Username'] . '</td>
            <td><a href="edit_building.php?id=' . $row['UserID'] . '">Delete</a></td>
            <td><a href="delete_building.php?id=' . $row['UserID'] . '">Delete</a></td>
            </tr>';
        }
        echo '</table>'; // Close the table.
        mysqli_free_result ($result); // Free up the resources.	
    } else { // If it did not run OK.
        // Public message:
        echo '<p class="error">An error has occured, Users cannot be displayed</p>';
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
        echo '<a href="admin_page.php?s=' . ($start - $pagerows) . '&p=' . $pages . '">Previous</a> ';
        }
        //Create a Next link
        if ($current_page != $pages) {
        echo '<a href="admin_page.php?s=' . ($start + $pagerows) . '&p=' . $pages . '">Next</a> ';
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
        <a href="register_user.php">Add new user</a>
    </div>
	<footer>
		<?php include('footer.php'); ?>
	</footer>
    </div>
    </div>
</body>
</html>