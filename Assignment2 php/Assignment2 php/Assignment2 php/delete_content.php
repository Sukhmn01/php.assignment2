<?php
session_start();
require './inc/db.php';
require './classes/Content.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$conn = getConnection();
$content = new Content($conn);
$item = $content->getById($_GET['id']);

if ($item && $item['user_id'] == $_SESSION['user_id']) {
    $content->delete($item['id']);
}

header("Location: dashboard.php");
exit;

