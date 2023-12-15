<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $student_id = $_SESSION['id'];
    $room_number =  $_GET['room_number'];
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
                padding: 8px 16px;
                border: 1px solid #ccc;
                border-radius: 4px;
                cursor: pointer;
            }

            fieldset input[type="radio"]:checked+label {
                background-color: #094a00;
                color: white;
            }
        </style>
    </head>

    <body>
        <?php include 'top-nav.php' ?>
        <?php include 'side-nav.php' ?>
        <div id="start">
            <div id="particles-js">
                <main id="main" class="main">
                    <div class="row">
                        <div class="pagetitle col-lg-5">
                            <h1>Quiz</h1>
                            <nav style="--bs-breadcrumb-divider: '•';">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Pages</li>
                                    <li class="breadcrumb-item">Room Number</li>
                                    <li class="breadcrumb-item">Quiz</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-2">
                            <p class="text-center" id="timer" style="font-weight: bolder; font-size: 50px; display: none;">10</p>
                        </div>
                    </div>
                    <section class="section dashboard">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                        $stmt = $conn->prepare(' SELECT 
                                        room_number,
                                        direction,
                                        item_number,
                                        question,
                                        choice1,
                                        choice2,
                                        choice3,
                                        choice4,
                                        correct_answer
                                        FROM tbl_quiz WHERE room_number = ? ');
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
                                                $student_answer = '';
                                                $stmt = $conn->prepare(' INSERT INTO tbl_quiz_student 
                                                (student_id, room_number, direction, item_number, question, choice1, choice2, choice3, choice4, correct_answer, student_answer) 
                                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ');
                                                $stmt->bind_param("iisisssssss", $student_id, $room_number, $direction, $item_number, $question, $choice1, $choice2, $choice3, $choice4, $correct_answer, $student_answer);
                                                $stmt->execute();
                                            }
                                        }
                                        ?>
                                        <form action="quiz-check.php?id=<?php echo $room_number ?>" method="POST" class="p-3" id="quizForm">
                                            <?php
                                            // $stmt = $conn->prepare(' SELECT * FROM tbl_quiz_student WHERE room_number = ? AND student_id = ? ');
                                            // $stmt->bind_param('ii', $room_number, $student_id);
                                            // $stmt->execute();
                                            // $result = $stmt->get_result();
                                            // if (mysqli_num_rows($result) > 0) {
                                            //     $student_answer = '';
                                            //     $stmt = $conn->prepare(' UPDATE tbl_quiz_student SET student_answer = ? WHERE room_number = ? AND student_id = ?  ');
                                            //     $stmt->bind_param('sii', $student_answer, $room_number, $student_id);
                                            //     $stmt->execute();
                                            // }
                                                
                                            
                                            $stmt = $conn->prepare(' SELECT * FROM tbl_quiz WHERE room_number = ? ORDER BY id ASC ');
                                            $stmt->bind_param('i', $room_number);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            $questions = [];
                                            while ($row = $result->fetch_assoc()) {
                                                $questions[] = $row;
                                            }
                                            
                                            foreach ($questions as $question) {
                                                $item_number = $question['item_number'];
                                                $choices = [$question['choice1'], $question['choice2'], $question['choice3'], $question['choice4']];
                                                echo '
                                                    <div id="question_' . $item_number . '" style="display: none;">
                                                        <h3 class="fw-bold my-5">' . $item_number . ". " . $question['question'] . '</h3>
                                                        <fieldset class="row mb-4 mt-3">
                                                            <div class="col-lg-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="choice1_' . $item_number . '" value="' . $choices[0] . '" required>
                                                                    <label class="form-check-label border fw-bold fs-1 p-5 w-100 text-center" for="choice1_' . $item_number . '">
                                                                        ' . $choices[0] . '
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="choice2_' . $item_number . '" value="' . $choices[1] . '" required>
                                                                    <label class="form-check-label border fw-bold fs-1 p-5 w-100 text-center" for="choice2_' . $item_number . '">
                                                                        ' . $choices[1] . '
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="choice3_' . $item_number . '" value="' . $choices[2] . '" required>
                                                                    <label class="form-check-label border fw-bold fs-1 p-5 w-100 text-center" for="choice3_' . $item_number . '">
                                                                        ' . $choices[2] . '
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="choice4_' . $item_number . '" value="' . $choices[3] . '" required>
                                                                    <label class="form-check-label border fw-bold fs-1 p-5 w-100 text-center" for="choice4_' . $item_number . '">
                                                                        ' . $choices[3] . '
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                ';
                                            }
                                            ?>
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
                        document.getElementById("timer").innerText = (9 - timerCount).toString().padStart(2, "0");
                        timerCount++;
                        if (timerCount > 9) {
                            clearInterval(timer);
                            timerCount = 0;
                            hideQuestion(item_number);
                            showQuestion(index + 1);
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
