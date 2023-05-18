<?php
$servername = "localhost";
$username = "mattiaTeriaca";
$password = "admin";
$db = "Admin_Panel";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


?>