<?php
// Connect to the MySQL database
$con = new mysqli("localhost", "root", "", "indoor_game_management_system");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
