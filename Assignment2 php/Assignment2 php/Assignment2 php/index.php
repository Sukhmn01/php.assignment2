<?php
session_start();
$pageTitle = "Home";
require './templates/header.php';
?>
<link rel="stylesheet" href="./css/style.css">
<section class="hero-section">
    <div class="container">
        <h1>Welcome to <span class="highlight">SecureHub</span></h1>
        <?php if (isset($_SESSION['username'])): ?>
            <p>Hello, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
            <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        <?php else: ?>
            <a href="register.php" class="btn btn-success">Register</a>
            <a href="login.php" class="btn btn-primary">Login</a>
        <?php endif; ?>
    </div>
</section>
<?php require './templates/footer.php'; ?>

