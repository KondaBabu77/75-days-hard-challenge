<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Get task completion status (checkboxes return values only if checked)
$drank_water = isset($_POST["drank_water"]) ? 1 : 0;
$learned = isset($_POST["learned"]) ? 1 : 0;
$indoor_exercise = isset($_POST["indoor_exercise"]) ? 1 : 0;
$outdoor_exercise = isset($_POST["outdoor_exercise"]) ? 1 : 0;

// Update progress for the user
$sql = "UPDATE progress SET drank_water = ?, learned = ?, indoor_exercise = ?, outdoor_exercise = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiii", $drank_water, $learned, $indoor_exercise, $outdoor_exercise, $user_id);
$stmt->execute();

// Check if all tasks are completed before increasing the day count
if ($drank_water && $learned && $indoor_exercise && $outdoor_exercise) {
    $conn->query("UPDATE progress SET day = day + 1 WHERE user_id = $user_id");
    $_SESSION["message"] = "Great job! You've completed today's tasks. Day updated!";
} else {
    $_SESSION["message"] = "Complete all tasks to progress to the next day!";
}

$stmt->close();
$conn->close();

header("Location: dashboard.php");
exit();
?>
