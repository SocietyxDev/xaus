<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file = $_FILES['file'];

    $target = "uploads/" . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $target);

    $stmt = $conn->prepare("INSERT INTO uploads (user_id, file_path, title, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $_SESSION['user_id'], $target, $title, $description);
    $stmt->execute();
    header("Location: index.php");
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <input type="text" name="title" required placeholder="Title">
    <textarea name="description" required placeholder="Description"></textarea>
    <button type="submit">Upload</button>
</form>
