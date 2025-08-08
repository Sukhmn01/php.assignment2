<?php
session_start();
require './templates/header.php';
require './inc/db.php';
require './classes/Content.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = getConnection();
$content = new Content($conn);
$items = $content->getAll();
?>
<link rel="stylesheet" href="./css/style.css">

<h2>Your Content</h2>
<a href="add_content.php" class="btn">Add New Content</a>

<?php if (count($items) === 0): ?>
    <p>No content found. Start by adding new content!</p>
<?php else: ?>
    <?php foreach ($items as $item): ?>
        <div class="content-item" style="border:1px solid #ccc; margin:10px 0; padding:10px;">
            <h3><?= htmlspecialchars($item['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>

            <?php
            $relativePath = $item['image'];
            $serverPath = __DIR__ . '/' . $relativePath;

            if (!empty($relativePath) && file_exists($serverPath)): ?>
                <img src="<?= htmlspecialchars($relativePath) ?>" alt="Image for <?= htmlspecialchars($item['title']) ?>" width="150" style="display:block; margin-bottom:10px;">
            <?php else: ?>
                <p><em>No image available</em></p>
            <?php endif; ?>

            <a href="edit_content.php?id=<?= $item['id'] ?>">Edit</a> |
            <a href="delete_content.php?id=<?= $item['id'] ?>" onclick="return confirm('Are you sure you want to delete this content?')">Delete</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require './templates/footer.php'; ?>
