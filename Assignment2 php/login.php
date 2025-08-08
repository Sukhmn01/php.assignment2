<?php
session_start();
$pageTitle = "Login";
require './templates/header.php';
require './inc/db.php';
require './classes/User.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = getConnection();
    $user = new User($conn);
    $login = $user->login($_POST['username'], $_POST['password']);
    if ($login) {
        $_SESSION['user_id'] = $login['id'];
        $_SESSION['username'] = $login['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Incorrect login.";
    }
}
?>
<form method="POST">
    <link rel="stylesheet" href="./css/style.css">
    <?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<?php require './templates/footer.php'; ?>
