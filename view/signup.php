<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Sign Up</h1>
    <form method="POST" action="../controller/user_controller.php?action=signup">
        <label for="username">Username:</label>
        <input class="text" type="text" id="username" name="username" required><br><br>
        
        <label for="email">Email:</label>
        <input class="text" type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input class="text" type="password" id="password" name="password" required><br><br>

        <input class="button" type="submit" value="Sign Up">
    </form>
</body>
</html>