<!DOCTYPE html>
<html>
<head>
    <title><?= isset($pageTitle) ? $pageTitle : "My Site" ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <h1>SecureHub</h1>
    <nav>
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main>

