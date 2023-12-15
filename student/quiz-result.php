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
                        <h1>Quiz Result</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Room Number</li>
                                <li class="breadcrumb-item">Quiz</li>
                                <li class="breadcrumb-item">Quiz Result</li>
                            </ol>
                        </nav>
                    </div>
                    <section class="section dashboard">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="py-3 px-3">
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
                                                echo '<p>' . $question . '</p>';
                                                if ($student_answer !== '' && $student_answer === $correct_answer) {
                                                    echo '
                                                    <div class="btn-success btn rounded-0 d-flex align-items-center mb-4 p-2">
                                                        <span class="fs-6"><i class="bi bi-check"></i></span>&nbsp; &nbsp;
                                                        ' . $student_answer . '
                                                    </div>';
                                                    $score += 1;
                                                } else {
                                                    echo '
                                                    <div class="btn-success btn rounded-0 d-flex align-items-center mb-2 p-2">
                                                        <span class="fs-6"><i class="bi bi-x"></i></span>&nbsp; &nbsp;
                                                        ' . $student_answer . '
                                                    </div>
                                                    <div class="alert border-success d-flex align-items-center mb-4 p-2">
                                                        <span class="text-white">Correct answer:</span>&nbsp; &nbsp;
                                                        <span class="fw-bold text-white">' . $correct_answer . '</span>
                                                    </div>';
                                                    $score += 0;
                                                }
                                            }
                                            if ($score === $total_items) {
                                                echo '
                                                <hr>
                                                <div class="">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <p>Here is your score</p>
                                                        <h2>' . $score . ' / ' . $total_items . '</h2>
                                                        <h3 class="mt-3" style="color: #eddd33;">
                                                            <strong>[ P E R F E C T ]</strong>
                                                        </h3>
                                                    </div>
                                                </div>';
                                            } else if ($score == 0) {
                                                echo '
                                                <hr>
                                                <div class="">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <h3 class="mt-3" style="color: #ff0000;">
                                                            <strong>YOU HAVE NO SCORE!</strong>
                                                        </h3>
                                                    </div>
                                                </div>';
                                            } else {
                                                echo '
                                                <hr>
                                                <div class="">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <p>Here is your score</p>
                                                        <h2>' . $score . ' / ' . $total_items . '</h2>
                                                    </div>
                                                </div>';
                                            }

                                            ?>
                                            <a href="student-dashboard.php">
                                                <button class="btn-custom1">
                                                    <i class="bi bi-chevron-double-left"></i>&nbsp;Back to Dashboard
                                                </button>
                                            </a>
                                            <a href="quiz-leaderboard.php?room_number=<?php echo $room_number ?>">
                                                <button class="btn-custom">
                                                    <i class="bi bi-clipboard-data"></i>&nbsp;Leaderboard
                                                </button>
                                            </a>
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
