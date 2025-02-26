<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("UPDATE progress SET day = 1, drank_water = 0, learned = 0, indoor_exercise = 0, outdoor_exercise = 0 WHERE user_id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $_SESSION["message"] = "Your progress has been reset!";
} else {
    $_SESSION["message"] = "Error resetting progress!";
}

$stmt->close();
$conn->close();

header("Location: dashboard.php");
exit();
?>
