<?php
require_once('database.php');

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    //Create a new user
    public function createUser($username, $email, $password) {
        $dateRegistered = date('Y-m-d');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO Users (Username, Email, Password, DateRegistered) VALUES (?, ?, ?, ?)");
        
        $stmt->bind_param("ssss", $username, $email, $hashedPassword, $dateRegistered);
        return $stmt->execute();
    }

    //Check if email is unique
    public function isEmailUnique($email) {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows === 0;
    }

    //Get user by email
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM Users WHERE Email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }    
    
    //Get all users total points for displaying on leaderboard
    public function getAllUsersTotalPoints() {
        $sql = "SELECT Username, TotalPoints FROM Users ORDER BY TotalPoints DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    
    //Calculate topic mastery for a user
    public function getTopicMastery($userID, $quizID) {
        $sql = "SELECT * FROM `userscores` WHERE `QuizID` = 1 AND `UserID` = 6";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalAttempts = $result->num_rows;
        $totalscores = 0;
        while ($row = $result->fetch_assoc()) {
            $totalscores += $row['Score'];
        }
        if ($totalAttempts == 0) {
            return 0;
        }
        return round($totalscores / $totalAttempts, 2);
    }

    //Update total points for a user
    public function updateTotalPoints($userId, $points) {
        $sql = "UPDATE Users SET TotalPoints = TotalPoints + ? WHERE UserID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $points, $userId);
        $stmt->execute();
    }    
}
?>
