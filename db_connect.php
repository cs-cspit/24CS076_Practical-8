<?php
$servername = "localhost";
$username = "root";       // replace with your DB username
$password = "";           // replace with your DB password
$dbname = "event_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
