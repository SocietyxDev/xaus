<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'];
$upload_id = $_POST['upload_id'];

$stmt = $conn->prepare("INSERT INTO likes (user_id, upload_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE user_id=user_id");
$stmt->bind_param("ii", $user_id, $upload_id);
$stmt->execute();

header("Location: index.php");
?>
