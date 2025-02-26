<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get unread notifications
$stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Notifications</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['message']}</p>";
}

// Mark notifications as read
$conn->query("UPDATE notifications SET is_read = TRUE WHERE user_id = $user_id");
?>
<a href="index.php">Back to Home</a>
