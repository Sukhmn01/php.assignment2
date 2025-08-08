<?php
session_start();
$pageTitle = "Register";
require './templates/header.php';
require './inc/db.php';
require './classes/User.php';
require './inc/upload.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(isset($_POST['username']) ? $_POST['username'] : '');
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm = isset($_POST['confirm']) ? $_POST['confirm'] : '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match";
    }

    if (empty($error)) {
        $result = uploadImage('image');
        if (isset($result['error'])) {
            $error = $result['error'];
        } else {
            $imagePath = $result['path'];
            $conn = getConnection();
            $user = new User($conn);
            if ($user->register($username, $email, $password, $imagePath)) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Username or email already exists.";
            }
        }
    }
}
?>
<link rel="stylesheet" href="./css/style.css">
<form method="POST" enctype="multipart/form-data">
    <?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="confirm" placeholder="Confirm Password" required><br>
    <input type="file" name="image" required><br>
    <button type="submit">Register</button>
</form>
<?php require './templates/footer.php'; ?>

