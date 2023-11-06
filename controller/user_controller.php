<?php
session_start();
require_once('..\model\user.php');

class UserController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function handleSignup() {
        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            //check if the email is unique
            if (!$this->userModel->isEmailUnique($email)) {
                echo "Email already exists. Please try again.";
                exit(); // Stop execution here.
            }

            //try to create the user
            if ($this->userModel->createUser($username, $email, $password)) {
                //If user creation was successful go to the login
                header("Location: ../view/login.php");
                exit();
            } else {
                //If registration fails throw error
                echo "Registration failed. Please try again.";
            }
        } else {
            //If all fields arent set throw error
            echo "Please fill out all the fields.";
        }
    }

    public function updateUserSession($email) {
        $user = $this->userModel->getUserByEmail($email);
        $_SESSION['username'] = $user['Username'];
        $_SESSION['totalPoints'] = $user['TotalPoints'];
        //populate the session with leaderboard data
        $leaderboard = $this->userModel->getAllUsersTotalPoints();
        $data = [];
        while ($row = $leaderboard->fetch_assoc()) {
            $data[] = $row;
        }
        $_SESSION['leaderboard'] = $data;
        $userId = $user['UserID'];
        $secPlusMastery = $this->userModel->getTopicMastery($userId, 1);
        $caspPlusMastery = $this->userModel->getTopicMastery($userId, 2);
        $_SESSION['secPlusMastery'] = $secPlusMastery;
        $_SESSION['caspPlusMastery'] = $caspPlusMastery;
        
    }

    public function validUser($email, $password) {
        // retrieve the user based on email
        $user = $this->userModel->getUserByEmail($email);
        
        //if user not found or password does not match, return false
        //using password_verify to compare the hashed password
        if (!$user || !password_verify($password, $user['Password'])) {
            return false;
        }
        $userId = $user['UserID'];
        $_SESSION['UserID'] = $userId;
        $_SESSION['email'] = $email;

        //user found and password matches
        return true;
    }

}

if (isset($_GET['action']) && $_GET['action'] == 'signup') {
    $userController = new UserController();
    $userController->handleSignup();
}
?>
