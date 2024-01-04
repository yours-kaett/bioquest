<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $get_room_number = $_GET['room_number'];
    $stmt = $conn->prepare('SELECT * FROM tbl_quiz WHERE room_number = ?');
    $stmt->bind_param('s', $get_room_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $section_id = $row['section_id'];
    $room_number = $row['room_number'];
    $direction = $row['direction'];
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
                <main id="main">
                    <div class="pagetitle">
                        <h1>Quiz</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Menu</li>
                                <li class="breadcrumb-item">Quiz</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="quizes.php" class="text-white">
                        <i class="bi bi-arrow-left"></i>&nbsp; Back
                    </a>
                    <section class="section dashboard">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="view-quiz-update.php?room_number=<?php echo $room_number ?>" method="POST" class="mb-4 w-100">
                                    <div class="row mb-2">
                                        <input value="<?php echo $section_id ?>" type="number" name="section_id" style="display: none;" required>
                                        <div class="col-lg-3 col-md-3 col-sm-3 mt-2">
                                            <div class="form-floating">
                                                <input value="<?php echo $room_number ?>" type="number" name="room_number" id="room_number" class="form-control" required>
                                                <label for="room_number">Room number</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md98 col-sm-9 mt-2 mb-3">
                                            <div class="form-floating">
                                                <input value="<?php echo $direction ?>" type="text" name="direction" id="direction" class="form-control" required>
                                                <label for="direction">Include some direction for your quiz.</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <?php
                                        $stmt = $conn->prepare('SELECT * FROM tbl_quiz WHERE room_number = ? ORDER BY item_number ASC ');
                                        $stmt->bind_param('s', $room_number);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $rowCounter = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            $item_number = $row['item_number'];
                                            $question = $row['question'];
                                            $choice1 = $row['choice1'];
                                            $choice2 = $row['choice2'];
                                            $choice3 = $row['choice3'];
                                            $choice4 = $row['choice4'];
                                            $correct_answer = $row['correct_answer'];
                                            echo '
                                            <div class="col-lg-3 col-md-3 col-sm-3 mt-2">
                                                <div class="form-floating">
                                                    <input type="number" name="item_number_'.$rowCounter.'" value="' . $item_number . '" class="form-control" id="item_number">
                                                    <label for="item_number">Item number</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 mt-2">
                                                <div class="form-floating">
                                                    <input type="text" name="question_'.$rowCounter.'" value="' . $question . '" class="form-control" id="question" required>
                                                    <label for="question">Type your question</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                                <div class="form-floating">
                                                    <input type="text" name="choice1_'.$rowCounter.'" value="' . $choice1 . '" class="form-control" id="choice1" required>
                                                    <label for="choice1">Your choice number 1</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                                <div class="form-floating">
                                                    <input type="text" name="choice2_'.$rowCounter.'" value="' . $choice2 . '" class="form-control" id="choice2" required>
                                                    <label for="choice2">Your choice number 2</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                                <div class="form-floating">
                                                    <input type="text" name="choice3_'.$rowCounter.'" value="' . $choice3 . '" class="form-control" id="choice3" required>
                                                    <label for="choice3">Your choice number 3</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                                <div class="form-floating">
                                                    <input type="text" name="choice4_'.$rowCounter.'" value="' . $choice4 . '" class="form-control" id="choice4" required>
                                                    <label for="choice4">Your choice number 4</label>
                                                </div>
                                            </div>
                                            <div class="col-lg126 col-md-12 col-sm-12 mt-2 mb-3">
                                                <div class="form-floating">
                                                    <input type="text" name="correct_answer_'.$rowCounter.'" value="' . $correct_answer . '" class="form-control" id="correct_answer" required>
                                                    <label for="correct_answer">The correct answer</label>
                                                </div>
                                            </div>
                                            <hr>
                                            ';
                                            $rowCounter++;
                                        }
                                        ?>
                                    </div>
                                    <a href="modify-quiz?room_number=<?php echo $room_number ?>">
                                        <button  class="btn btn-success rounded-5" style="padding: 12px;" type="button">
                                            <i class="bi bi-plus-lg"></i>&nbsp;Add Items
                                        </button>
                                    </a>
                                    
                                    <button class="btn-custom" type="submit">
                                        <i class="bi bi-capslock"></i>&nbsp;Update Quiz
                                    </button>
                                </form>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
