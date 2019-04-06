<?php											
    session_start();
    if (!isset($_SESSION['user_level']) or ($_SESSION['user_level'] != 1)) {
        header("Location: index.php");
        exit();
    }
    //only admin has access, if level is not 1, sent to index.php
?>

<!--display all users, only admin has access to this page -->
<!--Have edit and delete clumns link to edit/delete users pages for each entry-->