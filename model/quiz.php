<?php
require_once('database.php');

class Quiz {
    private $db;

    //Constructor - make a new database object
    public function __construct() {
        $this->db = new Database();
    }
    
    //Get all quizzes
    public function getQuizQuestions($quizID) {

        $query = "SELECT * FROM Questions WHERE QuizID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $quizID);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    //Get all users total points for displaying on leaderboard
    public function insertScore($userId, $quizId, $score) {
        $query = "INSERT INTO userscores (UserID, QuizID, Score) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iii', $userId, $quizId, $score);
        $stmt->execute();
    }
}
