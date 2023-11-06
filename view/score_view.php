<?php
require_once('../model/quiz.php');
$score = isset($_GET['score']) ? $_GET['score'] : 0;
$points = isset($_GET['points']) ? $_GET['points'] : 0;
$answers = isset($_GET['answers']) ? json_decode($_GET['answers']) : [];
session_start();
$quizId = $_SESSION['quizId'];

?>

<html lang="en">
<head>
    <title>Quiz Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Quiz Results</h1>
<p>You scored: <?php echo $score; ?>%</p>
<p>You were awarded <?php echo $points; ?> points!</p>

<a href="dashboard.php">Return to Dashboard</a>

</body>
</html>
