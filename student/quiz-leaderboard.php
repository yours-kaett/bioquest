<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $student_id = $_SESSION['id'];
    $room_number = $_GET['room_number'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../other-includes/head.php' ?>
    </head>

    <body>
        <?php include 'top-nav.php' ?>
        <?php include 'side-nav.php' ?>
        <div id="start">
            <div id="particles-js">
                <main id="main" class="main">
                    <div class="pagetitle">
                        <h1>Leaderboard</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Quiz</li>
                                <li class="breadcrumb-item">Quiz Result</li>
                                <li class="breadcrumb-item">Leaderboard</li>
                            </ol>
                        </nav>
                    </div>

                    <section class="section dashboard">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card px-2">
                                    <div class="card-body">
                                        <h5 class="card-title">Quiz Game Ranking</h5>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="d-flex flex-column border rounded p-3">
                                                    <?php
                                                    $stmt = $conn->prepare(' SELECT * FROM tbl_quiz_student WHERE room_number = ? AND student_id = ? ORDER BY item_number ASC');
                                                    $stmt->bind_param('ii', $room_number, $student_id);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($rows = $result->fetch_assoc()) {
                                                        $item_number = $rows['item_number'];
                                                        $question = $rows['question'];
                                                        $choice1 = $rows['choice1'];
                                                        $choice2 = $rows['choice2'];
                                                        $choice3 = $rows['choice3'];
                                                        $choice4 = $rows['choice4'];
                                                        $correct_answer = $rows['correct_answer'];
                                                        $student_answer = $rows['student_answer'];
                                                        $total_items = mysqli_num_rows($result);
                                                        if ($student_answer !== '' && $student_answer === $correct_answer) {
                                                            $score += 1;
                                                        } else {
                                                            $score += 0;
                                                        }
                                                    }
                                                    $passing_score = $total_items / 2;
                                                    if ($score === $total_items) {
                                                        echo '
                                                        <div class="d-flex flex-column align-items-center">
                                                            <i class="bi bi-trophy-fill" style="font-size: 70px; color: #eddd33;"></i>
                                                            <p>Score Attained</p>
                                                            <h2>' . $score . ' / ' . $total_items . '</h2>
                                                            <h3 class="mt-3" style="color: #eddd33;">
                                                                <strong>[ P E R F E C T ]</strong>
                                                            </h3>
                                                        </div>';
                                                    } else if ($score == 0) {
                                                        echo '
                                                        <div class="d-flex flex-column align-items-center">
                                                            <i class="bi bi-type-strikethrough" style="font-size: 70px; color: #ff0000;"></i>
                                                            <h3 class="mt-3" style="color: #ff0000;">
                                                                <strong>YOU HAVE NO SCORE!</strong>
                                                            </h3>
                                                        </div>';
                                                    } else if ($score < $passing_score) {
                                                        echo '
                                                        <div class="d-flex flex-column align-items-center">
                                                            <i class="bi bi-award" style="font-size: 70px; color: #ed7133;"></i>
                                                            <p>Score Attained</p>
                                                            <h2>' . $score . ' / ' . $total_items . '</h2>
                                                            <h3 class="mt-3" style="color: #ed7133  ;">
                                                                <strong>NEED TO STUDY HARD</strong>
                                                            </h3>
                                                        </div>';
                                                    } else {
                                                        echo '
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="bi bi-award" style="font-size: 70px; color: #eddd33;"></i>
                                                                <p>Score Attained</p>
                                                                <h2>' . $score . ' / ' . $total_items . '</h2>
                                                                <h3 class="mt-3" style="color: #eddd33  ;">
                                                                    <strong>YOU DID A GREAT JOB!</strong>
                                                                </h3>
                                                            </div> ';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="border rounded p-3">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Rank</th>
                                                                    <th>Score Attained</th>
                                                                    <th>Challenger</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $stmt = $conn->prepare(' SELECT 
                                                                tbl_quiz_ranking.img_url, 
                                                                tbl_quiz_ranking.student_id, 
                                                                tbl_quiz_ranking.room_number,
                                                                tbl_quiz_ranking.score,
                                                                tbl_student.firstname,
                                                                tbl_student.middlename,
                                                                tbl_student.lastname
                                                                FROM tbl_quiz_ranking 
                                                                INNER JOIN tbl_student ON tbl_quiz_ranking.student_id = tbl_student.id
                                                                WHERE tbl_quiz_ranking.room_number = ?
                                                                ORDER BY tbl_quiz_ranking.score DESC ');
                                                                $stmt->bind_param('i', $room_number);
                                                                $stmt->execute();
                                                                $result = $stmt->get_result();

                                                                $rank = 0;
                                                                $prevScore = PHP_INT_MAX;
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $img_url = $row['img_url'];
                                                                    $firstname = $row['firstname'];
                                                                    $middlename = $row['middlename'];
                                                                    $lastname = $row['lastname'];
                                                                    $score = $row['score'];
                                                                    $all_items = $row['all_items'];
                                                                    if ($score < $prevScore) {
                                                                        $rank++;
                                                                    }
                                                                    echo '<tr>
                                                                            <td>' . $rank . '</td>
                                                                            <td>' . $score . " / " . $total_items . '</td>
                                                                            <td>' . $firstname . " " . $middlename . " " . $lastname . '</td>
                                                                            <td>
                                                                                <img src="../assets/img/profiles/' . $img_url . '" style="width: 35px; height: 35px; border-radius: 50%;" alt="Challenger Profile" />
                                                                            </td>
                                                                        </tr>';
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="js/jquery-2.2.3.min.js"></script>
        <script src="js/particles.js"></script>
        <script src="js/app.js"></script>
        
    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
}
