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

        <style>
            fieldset input[type="radio"] {
                display: none;
            }

            fieldset input[type="radio"]+label {
                display: inline-block;
                padding: 18px;
                text-align: center;
                text-decoration: none;
                font-size: 16px;
                border: none;
                border-radius: 35px;
                cursor: pointer;
                color: #fff;
                background: linear-gradient(to right, #008672bd, #0583aaea);
                background-size: 200% 100%;
                transition: background-position 0.5s ease-in-out;
            }

            fieldset input[type="radio"]:checked+label {
                background: linear-gradient(to bottom, #000 0%, var(--primary-color) 100%);
                color: white;
            }
        </style>
    </head>

    <body>
        <?php include 'top-nav.php' ?>
        <?php include 'side-nav.php' ?>

        <div id="start">
            <div id="particles-js">
                <main id="main" class="">
                    <div class="row">
                        <div class="pagetitle col-lg-5">
                            <h1>Quiz Level - Medium</h1>
                            <nav style="--bs-breadcrumb-divider: '•';">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Room Number</li>
                                    <li class="breadcrumb-item">Quiz Level</li>
                                    <li class="breadcrumb-item">Quiz</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-2">
                            <span class="text-center" id="timer" style="font-weight: bolder; font-size: 40px; display: none;"></span>
                        </div>
                    </div>
                    <section class="section dashboard">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <?php
                                    $stmt = $conn->prepare(' SELECT room_number, student_id, student_answer FROM tbl_quiz_student WHERE room_number = ? AND student_id = ? ');
                                    $stmt->bind_param('ii', $room_number, $student_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $rows = $result->fetch_assoc();
                                    if (($rows['student_answer']) <> "") {
                                    ?>
                                        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center m-5" role="alert">
                                            <span>You have already responded.</span>
                                            <a href="room-number.php">
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </a>
                                        </div>
                                    <?php
                                        exit();
                                    }
                                    ?>
                                    <div class="card-body">
                                        <form action="quiz-check.php?id=<?php echo $room_number ?>" method="POST" class="p-3" id="quizForm">
                                            <?php
                                            $stmt = $conn->prepare(' SELECT * FROM tbl_quiz_student WHERE room_number = ? AND student_id = ? ');
                                            $stmt->bind_param('ii', $room_number, $student_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            if (mysqli_num_rows($result) > 0) {
                                                $student_answer = '';
                                                $stmt = $conn->prepare(' UPDATE tbl_quiz_student SET student_answer = ? WHERE room_number = ? AND student_id = ?  ');
                                                $stmt->bind_param('sii', $student_answer, $room_number, $student_id);
                                                $stmt->execute();
                                            } else {
                                                $stmt = $conn->prepare(' SELECT * FROM tbl_quiz WHERE room_number = ? ');
                                                $stmt->bind_param('i', $room_number);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                if ($result->num_rows > 0) {
                                                    while ($rows = $result->fetch_assoc()) {
                                                        $room_number = $rows["room_number"];
                                                        $direction = $rows["direction"];
                                                        $item_number = $rows["item_number"];
                                                        $question = $rows["question"];
                                                        $choice1 = $rows["choice1"];
                                                        $choice2 = $rows["choice2"];
                                                        $choice3 = $rows["choice3"];
                                                        $choice4 = $rows["choice4"];
                                                        $correct_answer = $rows["correct_answer"];
                                                        $stmt = $conn->prepare(' INSERT INTO tbl_quiz_student 
                                                            (room_number, direction, item_number, question, 
                                                            choice1, choice2, choice3, choice4, correct_answer, student_id) 
                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ');
                                                        $stmt->bind_param("ssissssssi", $room_number, $direction, $item_number, $question, $choice1, $choice2, $choice3, $choice4, $correct_answer, $student_id);
                                                        $stmt->execute();
                                                    }
                                                }
                                            }
                                            $stmt = $conn->prepare(' SELECT * FROM tbl_quiz WHERE room_number = ? ');
                                            $stmt->bind_param('i', $room_number);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            $questions = [];
                                            while ($row = $result->fetch_assoc()) {
                                                $questions[] = $row;
                                            }
                                            ?>
                                            <?php
                                            foreach ($questions as $question) {
                                                $item_number = $question['item_number'];
                                                $choices = [$question['choice1'], $question['choice2'], $question['choice3'], $question['choice4']];
                                                echo '
                                                    <div id="question_' . $item_number . '" style="display: none;">
                                                        <h3 class="fw-bold my-5">' . $question['question'] . '</h3>
                                                        <fieldset class="row mb-4 mt-3">
                                                            <div class="col-lg-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="choice1_' . $item_number . '" value="' . $choices[0] . '" required>
                                                                    <label class="form-check-label border-0 fw-bold fs-1 p-3 w-100 text-center" for="choice1_' . $item_number . '">
                                                                        ' . $choices[0] . '
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="choice2_' . $item_number . '" value="' . $choices[1] . '" required>
                                                                    <label class="form-check-label border-0 fw-bold fs-1 p-3 w-100 text-center" for="choice2_' . $item_number . '">
                                                                        ' . $choices[1] . '
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="choice3_' . $item_number . '" value="' . $choices[2] . '" required>
                                                                    <label class="form-check-label border-0 fw-bold fs-1 p-3 w-100 text-center" for="choice3_' . $item_number . '">
                                                                        ' . $choices[2] . '
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="choice4_' . $item_number . '" value="' . $choices[3] . '" required>
                                                                    <label class="form-check-label border-0 fw-bold fs-1 p-3 w-100 text-center" for="choice4_' . $item_number . '">
                                                                        ' . $choices[3] . '
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                ';
                                            }
                                            ?>
                                            <!-- <div class="modal fade" id="confirmationModal" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmation</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            Once you click the <span class="text-success">Confirm</span> button, the system will assume that you're already sure with your answer. <br /> Make sure to double check your answer before submitting it.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">I'll check my answers again</button>
                                                            <button type="submit" class="btn btn-success">Confirm</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </form>
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

        <script>
            var questionIndex = 0;
            var questions = <?php echo json_encode($questions); ?>;

            function showQuestion(index) {
                if (index < questions.length) {
                    var question = questions[index];
                    var item_number = question.item_number;
                    document.getElementById("question_" + item_number).style.display = "block";
                    for (var i = 1; i <= 4; i++) {
                        var choiceElement = document.getElementById("choice" + i + "_" + item_number);
                        if (choiceElement) {
                            choiceElement.innerText = question["choice" + i];
                        }
                    }
                    var timer = setInterval(function() {
                        document.getElementById("timer").style.display = "flex";
                        document.getElementById("timer").innerText = "00:" + (15 - timerCount).toString().padStart(2, "0");
                        timerCount++;
                        if (timerCount > 15) {
                            clearInterval(timer);
                            timerCount = 1;
                            hideQuestion(item_number);
                            if (index < questions.length - 1) {
                                showQuestion(index + 1);
                            } else {
                                document.getElementById("quizForm").submit();
                            }
                        }
                    }, 1000);

                } else {
                    setTimeout(function() {
                        document.getElementById("quizForm").submit();
                    }, 10000);
                }
            }

            function hideQuestion(item_number) {
                document.getElementById("question_" + item_number).style.display = "none";
            }
            var timerCount = 0;
            showQuestion(0);
        </script>

    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
}
