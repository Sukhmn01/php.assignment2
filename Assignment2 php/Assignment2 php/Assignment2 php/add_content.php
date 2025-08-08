<?php
session_start();
require './templates/header.php';
require './inc/db.php';
require './classes/Content.php';
require './inc/upload.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = getConnection();
$content = new Content($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $imgResult = uploadImage('image');
    $imagePath = isset($imgResult['path']) ? $imgResult['path'] : '';
    $content->add($_SESSION['user_id'], $title, $description, $imagePath);
    header("Location: dashboard.php");
    exit;
}
?>
<link rel="stylesheet" href="./css/style.css">
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required><br>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <input type="file" name="image"><br>
    <button type="submit">Create</button>
</form>
<?php require './templates/footer.php'; ?>

