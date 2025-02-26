<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Explore</h2>";

// Get recent uploads
$result = $conn->query("SELECT uploads.*, users.username FROM uploads 
                        JOIN users ON uploads.user_id = users.id 
                        ORDER BY uploads.created_at DESC");

while ($row = $result->fetch_assoc()) {
    echo "<div>
            <h3>{$row['username']}</h3>
            <h4>{$row['title']}</h4>
            <p>{$row['description']}</p>
            <img src='{$row['file_path']}' width='200'>
          </div>";
}
?>
<a href="index.php">Back to Home</a>
