<?php
//dashboard.php
require_once('../controller/user_controller.php');
$userController = new UserController();
$userController->updateUserSession($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>

    </style>
</head>
<body>
    <div class="page-header">
        <h1>Welcome, <?php echo $_SESSION['username'] ?? 'John Doe'; ?>!</h1>
        <div class="user-info">
            <?php
            $rank = $_SESSION['totalPoints'] ?? 0;
            $rank = floor($rank / 200) + 1;
            ?>
            <strong>Rank:</strong><?php echo strval($rank) ?><br>
            <strong>Total Points:</strong> <?php echo $_SESSION['totalPoints'] ?? 0; ?>
        </div>
    </div>

    <div class="dashboard-container">
    <div class="dashboard">
        <div class="left-column">
            <div class="leaderboard">
                <h2>Leaderboard</h2>
                <?php
                $leaderboard = $_SESSION['leaderboard'] ?? [];
                foreach ($leaderboard as $i => $row) {
                    echo "<div class='leaderboard-item'>";
                    echo ($i + 1) . ". " . $row['Username'] . " - " . $row['TotalPoints'] . " points";
                    echo "</div>";
                }

                ?>

            </div>
        </div>

        <div class="right-column">
            <div class="mastery">
                <?php
                    $secPlusMastery = $_SESSION['secPlusMastery'] ?? 0;
                    $caspPlusMastery = $_SESSION['caspPlusMastery'] ?? 0;
                    $topicData = [
                        'Security' => $secPlusMastery,
                        'CASP+' => $caspPlusMastery,
                        // Add more topics and data here as needed
                    ];
                ?>

                <table>
                    <th><h2>Mastery by Topic</h2></th>
                    <th><h2>Study Materials & Quizzes</h2></th>
                    <?php foreach ($topicData as $topic => $mastery) : ?>
                        <tr>
                            <div class="charts">
                            <div class="chart-container">
                                <td><strong><?php echo $topic; ?>:</strong> <?php echo $mastery; ?>% mastery</td>
                                    <td>
                                            <?php if ($topic === 'Security') : ?>
                                                <canvas id="securityPieChart"></canvas>
                                            <?php elseif ($topic === 'CASP+') : ?>
                                                <canvas id="caspPieChart"></canvas>
                                            <?php endif; ?>
                                    </td>
                                </div>
                            </div>
                            <div class="courses">
                                <td>
                                    <?php if ($topic === 'Security') : ?>
                                        <a class="course-link" href="course.php">CompTIA Security+ Course<br><img class="icon" src="./img/book.png" alt="Book Icon"></a>
                                        </br><a class="quiz-link" href="quiz_view.php?quiz=1">Security+ Quiz<br><img class="icon" src="./img/quiz.png" alt="Quiz Icon"></a>   
                                    <?php elseif ($topic === 'CASP+') : ?>
                                        <a class="course-link" href="course.php">CompTIA CASP+ Materials<br><img class="icon" src="./img/book.png" alt="Book Icon"></a>
                                        </br><a class="quiz-link" href="quiz_view.php?quiz=2">CASP+ Quiz<br><img class="icon" src="./img/quiz.png" alt="Quiz Icon"></a>
                                    <?php endif; ?>
                                </td>
                            </div>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>


    <form method="post" action="dashboard.php">
        <button class="button" type="submit" name="logout">Log Out</button>
    </form>

    <script>
        // PHP array to JavaScript array conversion
        const topicData = <?php echo json_encode($topicData); ?>;

        // Create the Security+ Pie Chart
        const securityData = {
            labels: ['Completed', 'Remaining'],
            datasets: [{
                data: [topicData['Security'], 100 - topicData['Security']],
                backgroundColor: ['#4caf50', '#ddd'],
            }],
        };

        const securityPieChart = new Chart(document.getElementById('securityPieChart'), {
            type: 'pie',
            data: securityData,
        });

        // Create the CASP+ Pie Chart
        const caspData = {
            labels: ['Completed', 'Remaining'],
            datasets: [{
                data: [topicData['CASP+'], 100 - topicData['CASP+']],
                backgroundColor: ['#4caf50', '#ddd'],
            }],
        };

        const caspPieChart = new Chart(document.getElementById('caspPieChart'), {
            type: 'pie',
            data: caspData,
        });
    </script>
</body>
</html>
