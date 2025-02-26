<?php
$host = "localhost";
$user = "root"; 
$pass = ""; 
$db = "challenge_db";

// Enable error reporting for better debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($host, $user, $pass, $db);

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    exit("Database Connection Failed: " . $conn->connect_error);
}
?>
