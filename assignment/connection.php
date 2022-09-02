<?php
/* Author: Roushan
Date: 02-09-22
Version: 1.0
Description: This file consists of php code for making a connection to the database.
Change the values as per your server and database
*/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
