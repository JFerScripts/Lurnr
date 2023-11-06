<?php
session_start();
require_once('../model/quiz.php');
require_once('../model/user.php');

$score = 0;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the quizId from the POST data
    $quizId = $_POST['quizId'];
    $quiz = new Quiz();
    $questionsResults = $quiz->getQuizQuestions($quizId);
    
    $questions = [];
    while ($row = $questionsResults->fetch_assoc()) {
        $questions[] = $row;
    }
    
    $numQuestionId = 1;
    $answers = [];
    foreach ($questions as $question) {
        // Convert numQuestionId to string
        $questionId = strval($numQuestionId);
        
        // Convert database correct answer from int to corresponding letter
        $correctAnswer = "";
        switch($question['CorrectOption']) {
            case 1: $correctAnswer = 'a'; break;
            case 2: $correctAnswer = 'b'; break;
            case 3: $correctAnswer = 'c'; break;
            case 4: $correctAnswer = 'd'; break;
        }
        // Get answer from POST data
        $answer = isset($_POST['question' . $questionId]) ? 'question' . $questionId . ' ' . $_POST['question' . $questionId] : '';
        $answers[] = $answer;

        if (isset($_POST['question' . $questionId]) && $_POST['question' . $questionId] == $correctAnswer) {
            $score += 10;
        }
    
        $numQuestionId++;
    }
    
    $points = $score;
    if ($score > 70) {
        $points += 30;
    }

    // Record score to `userscores` table.
    $quiz->insertScore($_SESSION['UserID'], $quizId, $score);

    // Update `TotalPoints` in `users` table.
    $user = new User();
    $user->updateTotalPoints($_SESSION['UserID'], $points);
}

// Redirect to the score view page with the score
header("Location: ../view/score_view.php?points=" . $points . "&score=" . $score . "&answers=" . json_encode($answers));
exit();

