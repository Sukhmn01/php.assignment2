<?php
session_start();
require './templates/header.php';
require './inc/db.php';
require './classes/Content.php';
require './inc/upload.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$conn = getConnection();
$content = new Content($conn);
$item = $content->getById($_GET['id']);

if (!$item || $item['user_id'] != $_SESSION['user_id']) {
    echo "Unauthorized";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $imagePath = $item['image'];

    if (!empty($_FILES['image']['name'])) {
        $upload = uploadImage('image');
        if (isset($upload['path'])) {
            $imagePath = $upload['path'];
        }
    }

    $content->update($item['id'], $title, $description, $imagePath);
    header("Location: dashboard.php");
    exit;
}
?>
<link rel="stylesheet" href="./css/style.css">
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= htmlspecialchars($item['title']) ?>" required><br>
    <textarea name="description" required><?= htmlspecialchars($item['description']) ?></textarea><br>
    <input type="file" name="image"><br>
    <button type="submit">Update</button>
</form>
<?php require './templates/footer.php'; ?>

