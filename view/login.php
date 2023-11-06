<?php
session_start();
$login_msg = $_SESSION['login_msg'] ?? null;
unset($_SESSION['login_msg']);
?>

<html>
<head>
    <title>LurnR</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>LurnR</h1>
    <h2>Education for winners</h2>
    
    <form method='POST' action="../controller/login_controller.php">
        <h3>Email:<input class="text" type="text"
            name="email"></h3>
        <h3>Password: <input class="text" type="password" name="pw"></h3>
        <input class="button" type="submit" value="Login" name="login">
        <input class="button" type="submit" value="Sign Up" name="signup">
    </form>
    <?php if (isset($login_msg)): ?>
        <h2><?php echo $login_msg; ?></h2>
    <?php endif; ?>
</body>
</html>