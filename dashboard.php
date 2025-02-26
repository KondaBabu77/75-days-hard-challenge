<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include("db.php"); // Database connection

$user_id = $_SESSION["user_id"];

// Check if progress exists
$check_progress = $conn->prepare("SELECT * FROM progress WHERE user_id = ?");
$check_progress->bind_param("i", $user_id);
$check_progress->execute();
$result = $check_progress->get_result();

if ($result->num_rows == 0) {
    // If no progress found, insert a default progress entry
    $conn->query("INSERT INTO progress (user_id, day, drank_water, learned, indoor_exercise, outdoor_exercise) 
                  VALUES ($user_id, 1, 0, 0, 0, 0)");
    header("Location: dashboard.php"); // Refresh the page after inserting
    exit();
}

$user = $result->fetch_assoc();
$completed = ($user["day"] == 75);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>75 Days Challenge</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard-container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
    <h3>Day: <?php echo $user["day"]; ?>/75</h3>

    <?php if ($completed): ?>
        <div class="success-banner">
            🎉 Congratulations, <?php echo htmlspecialchars($_SESSION["username"]); ?>! You completed the 75 Days Challenge! 🎉
            <a href="download_certificate.php" class="btn">Download Certificate</a>
        </div>
    <?php else: ?>
        <div class="task-container">
            <form action="update_progress.php" method="POST">
                <label><input type="checkbox" name="drank_water" <?php if ($user["drank_water"]) echo "checked"; ?>> Drank 4 liters of water</label>
                <label><input type="checkbox" name="learned" <?php if ($user["learned"]) echo "checked"; ?>> Learned for 30 minutes</label>
                <label><input type="checkbox" name="indoor_exercise" <?php if ($user["indoor_exercise"]) echo "checked"; ?>> Did indoor exercise</label>
                <label><input type="checkbox" name="outdoor_exercise" <?php if ($user["outdoor_exercise"]) echo "checked"; ?>> Did outdoor exercise</label>

                <button type="submit" class="btn update-btn">Update Progress</button>
            </form>

            <form action="reset_progress.php" method="POST">
                <button type="submit" class="btn reset-btn">Reset Progress</button>
            </form>

            <!-- Logout Button -->
            <form action="logout.php" method="POST">
                <button type="submit" class="btn logout-btn">Logout</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<script src="scripts/script.js"></script>
</body>
</html>
