<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$following_id = $_POST['following_id']; // ID of the user to follow/unfollow

// Check if already following
$stmt = $conn->prepare("SELECT * FROM follows WHERE follower_id = ? AND following_id = ?");
$stmt->bind_param("ii", $user_id, $following_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If already following, unfollow
    $stmt = $conn->prepare("DELETE FROM follows WHERE follower_id = ? AND following_id = ?");
    $stmt->bind_param("ii", $user_id, $following_id);
} else {
    // If not following, follow
    $stmt = $conn->prepare("INSERT INTO follows (follower_id, following_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $following_id);
}
$stmt->execute();

header("Location: profile.php?user_id=$following_id");
exit();
?>
