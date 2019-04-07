<!doctype html>
<html lang="en">
<head>
    <title>Password</title>
	<meta charset="utf-8">
</head>
<body>
<div id="container">

</div>
<body>

<?php
 //retrieve all the records from the users table.
    require ('mysqli_connect.php'); // Connect to the database.

$uname = $_POST["username"];
$passwd = $_POST["password"];
$newpass = $_POST["newpass"];
$confirmnew = $_POST["confirmnew"];
if($confirmnew == $newpass){
    $sql = "UPDATE Users SET Password='$newpass' WHERE Username='$uname'";
} else {
    echo '<p>passwords do no match.</p>';
    header("location: password.html");}


$result = @mysqli_query ($dbcon, $sql); // Run the query.

if ($result) { // If it ran OK, display the records.
    echo 'Password changed';
    header("location: buildings.php");
    } else { // If it did not run OK.
        // Public message:
        echo '<p class="error">An error has occured, buildings cannot be displayed</p>';
        // Debugging message:
        echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
    } // End of if ($result). Now display the total number of records/buildings.

?>

</body>
</html>
