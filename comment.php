<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'];
$upload_id = $_POST['upload_id'];
$comment = $_POST['comment'];

$stmt = $conn->prepare("INSERT INTO comments (user_id, upload_id, comment) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $upload_id, $comment);
$stmt->execute();

header("Location: index.php");
?>
