<?php
    session_start();
    if (!isset($_SESSION['UserLevel']) or ($_SESSION['UserLevel'] != 1)) {
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
<div class="col-sm-12" id="container">
    <?php include('header.php'); ?>
<div id="content">

<!--Start of buildings page-->
<h2>All Users Registered in the System</h2>

<p>
<?php
    //retrieve all the records from the users table.
    require ('mysqli_connect.php'); // Connect to the database.

    $pagerows = 20;
    // Has the total number of pagess already been calculated?
    if (isset($_GET['p']) && is_numeric ($_GET['p'])) { //already been calculated
        $pages=$_GET['p'];
    } else {
        //use this block of code to calculate the number of pages
        //First, check for the total number of records
        $q = "SELECT COUNT(UserID) FROM Users";
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
    $q = "SELECT UserID, FirstName, LastName, Email, Username, Edit, Del FROM Users ORDER BY UserID ASC LIMIT $start, $pagerows";
    $result = mysqli_query ($dbcon, $q); // Run the query.
    $buildings = mysqli_num_rows($result);
    if ($result) { // If it ran OK, display the records.
    // Table header.
    echo '<table class="table table-striped" cellspacing="15">
        <thead>
        <tr><th scope="col"><b>User ID</b></th>
        <th scope="col"><b>First Name</b></th>
        <th scope="col"><b>Last Name</b></th>
        <th scope="col"><b>Email</b></th>
        <th scope="col"><b>Username</b></th>
        <th scope="col"><b>Edit</b></th>
        <th scope="col"><b>Delete</b></th></tr>
        </thead>
        <tbody>';
    // Fetch and print all the records:
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo '<tr>
            <td>' . $row['UserID'] . '</td>
            <td>' . $row['FirstName'] . '</td>
            <td>' . $row['LastName'] . '</td>
            <td>' . $row['Email'] . '</td>
            <td>' . $row['Username'] . '</td>
            <td><a href="edit_user.php?id=' . $row['UserID'] . '"class="btn btn-primary">Edit</a></td>
            <td><a href="delete_user.php?id=' . $row['UserID'] . '"class="btn btn-primary">Delete</a></td>
            </tr>';
        }
        echo '</tbody> </table>'; // Close the table.
        mysqli_free_result ($result); // Free up the resources.
    } else { // If it did not run OK.
        // Public message:
        echo '<p class="error">An error has occured, Users cannot be displayed</p>';
        // Debugging message:
        echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
    } // End of if ($result). Now display the total number of records/buildings.
    $q = "SELECT COUNT(UserID) FROM Users";
    $result = mysqli_query ($dbcon, $q);
    $row = mysqli_fetch_array ($result, MYSQLI_NUM);
    $users = $row[0];
    mysqli_close($dbcon); // Close the database connection.
    echo "<p>Total amount of Users: $users</p>";
    if ($pages > 1) {
    echo '<p>';
    //What number is the current page?
    $current_page = ($start/$pagerows) + 1;
        //If the page is not the first page then create a Previous link
        if ($current_page != 1) {
        echo '<a href="admin_page.php?s=' . ($start - $pagerows) . '&p=' . $pages . '" class="btn btn-info">Previous</a> ';
        }
        //Create a Next link
        if ($current_page != $pages) {
        echo '<a href="admin_page.php?s=' . ($start + $pagerows) . '&p=' . $pages . '" class="btn btn-info">Next</a> ';
        }
        echo '</p>';
    }
?>
</p>
    <br>
    <br>
    <br>
    <!--link to create new user-->
        <a href="register_user.php" class="btn btn-primary">Add new user</a>
	<br>
	<br>
	<a href="buildings.php" class="btn btn-info">Back to Buildings</a>
	<footer>
		<?php include('footer.html'); ?>
	</footer>
    </div>
    </div>
</body>
</html>
