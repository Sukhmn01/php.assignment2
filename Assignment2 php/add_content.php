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

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    $imgResult = uploadImage('image');

    if (isset($imgResult['error'])) {
        $error = $imgResult['error'];
    } else {
        $imagePath = isset($imgResult['path']) ? $imgResult['path'] : '';

        $content->add($_SESSION['user_id'], $title, $description, $imagePath);
        header("Location: dashboard.php");
        exit;
    }
}
?>
<link rel="stylesheet" href="./css/style.css">

<h2>Add New Content</h2>

<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required value="<?= isset($title) ? htmlspecialchars($title) : '' ?>"><br>
    <textarea name="description" placeholder="Description" required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea><br>
    <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif"><br>
    <button type="submit">Create</button>
</form>

<?php require './templates/footer.php'; ?>

<?php require './templates/footer.php'; ?>

