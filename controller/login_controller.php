<?php
session_start();
require_once('user_controller.php');
require_once('../model/user.php');
require_once('../util/security.php');

Security::checkHTTPS();

$login_msg = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? null;
    $password = $_POST['pw'] ?? null;

    if (isset($email) && isset($password)) {
        // Handle the login functionality
        $userController = new UserController();
        $isValidUser = $userController->validUser($email, $password);
        echo $isValidUser;
        if ($isValidUser) {
            $login_msg = 'Successful Authentication - Welcome ' . $email . '!';
            header("Location: ../view/dashboard.php");
            exit();
        } else {
            $login_msg = 'Failed Authentication - try again.';
        }
    } else {
        $login_msg = 'Please provide email and password.';
    }
    $_SESSION['login_msg'] = $login_msg;
    header("Location: ../view/login.php");
    exit();
} 
elseif (isset($_POST['signup'])) {
    // Redirect to the sign up page
    header("Location: ../view/signup.php");
    exit();
}
?>
