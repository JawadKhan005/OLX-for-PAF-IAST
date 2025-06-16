<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "olx";

$conn = new mysqli($servername, $username, $password, $dbname);

// echo "Connected successfully";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
