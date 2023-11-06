<?php
session_start();
require_once('../model/quiz.php');
if(isset($_GET['quiz'])) {
    $quizId = $_GET['quiz'];
    $_SESSION['quizId'] = $quizId;
}
$quizId = $_SESSION['quizId'];

?>

<html lang="en">
<head>
    <?php
    if($quizId === '1') {
        echo "<title>CompTIA Security+ Quiz</title>";
    } elseif($quizId === '2') {
        echo "<title>CompTIA CASP+ Quiz</title>";
    }
    ?>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
if($quizId === '1') {
    echo "<h1>CompTIA Security+ Quiz</h1>";
} elseif($quizId === '2') {
    echo "<h1>CompTIA Security+ Quiz</h1>";
}
?>
<form action="..\controller\process_quiz.php" method="post">
    <?php
    $quiz = new Quiz();
    $questionsResults = $quiz->getQuizQuestions($quizId);
    $questions = [];
    while ($row = $questionsResults->fetch_assoc()) {
        $questions[] = $row;
    }
    for ($i = 0; $i < count($questions); $i++) {
        echo "<div class='question'>";
        echo "<p><strong>" . ($i + 1) . ". " . $questions[$i]['QuestionText'] . "</strong></p>";
        echo "<input type='radio' name='question" . ($i + 1) . "' value='a'> A. " . $questions[$i]['Option1'] . "<br>";
        echo "<input type='radio' name='question" . ($i + 1) . "' value='b'> B. " . $questions[$i]['Option2'] . "<br>";
        echo "<input type='radio' name='question" . ($i + 1) . "' value='c'> C. " . $questions[$i]['Option3'] . "<br>";
        echo "<input type='radio' name='question" . ($i + 1) . "' value='d'> D. " . $questions[$i]['Option4'] . "<br>";
        echo "</div>";
    }
    ?>
    <input type="hidden" name="quizId" value="<?php echo $quizId; ?>">
    <input type="submit" value="Submit">
</form>

</body>
</html>
