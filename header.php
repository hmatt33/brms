<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>
<body>
    <div id="header">
        <h1>Building and Resident Management System</h1>
        <?php
        //displays person who is logged in
            echo '<p>Hello ';
            if(isset($_SESSION['FirstName'])) {
                echo "{$_SESSION['FirstName']}";
            }
            echo '</p>';
        ?>
        <div id="header-nav">
            <ul>
                <li><a href="buildings.php">Home</a></li>
                <li><a href="">FAQ</a></li>
                <li><a href="">Logout</a></li>
            </ul>
        </div>
    </div>
</body>
</html>