<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_id'];

// Get user info
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo "<h2>{$user['username']}'s Profile</h2>";

// Show follow/unfollow button if viewing another user's profile
if ($user_id != $_SESSION['user_id']) {
    echo "<form method='post' action='follow.php'>
            <input type='hidden' name='following_id' value='$user_id'>
            <button type='submit'>Follow/Unfollow</button>
          </form>";
}

// Show user's uploads
$stmt = $conn->prepare("SELECT * FROM uploads WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div>
            <h3>{$row['title']}</h3>
            <p>{$row['description']}</p>
            <img src='{$row['file_path']}' width='200'>
          </div>";
}
?>
<a href="index.php">Back to Home</a>
