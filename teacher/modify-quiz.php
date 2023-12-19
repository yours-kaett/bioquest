<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare(' SELECT * FROM tbl_quiz WHERE room_number = ? ORDER BY item_number DESC');
    $stmt->bind_param('i', $_GET['room_number']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();
    $section_id = $rows['section_id'];
    $year_level = $rows['year_level'];
    $room_number = $rows['room_number'];
    $direction = $rows['direction'];

    $stmt = $conn->prepare(' SELECT * FROM tbl_teacher WHERE id = ?');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $year_level = $row['year_level'];
    $section = $row['section'];
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
                        <h1>Modify Quiz</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Menu</li>
                                <li class="breadcrumb-item">Modify Quiz</li>
                            </ol>
                        </nav>
                    </div>
                    <?php
                    if (isset($_GET['error'])) {
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center mb-4" role="alert">
                            <div>
                                <?php echo $_GET['error']; ?>
                                <a href="modify-quiz.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <section class="section dashboard">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="modify-quiz-check.php" method="POST" class="mb-4 w-100">
                                    <div class="row mb-3">
                                        <input type="number" name="year_level" value="<?php echo $year_level ?>" style="display: none;" required>
                                        <input type="number" name="section_id" value="<?php echo $section ?>" style="display: none;" required>
                                        <div class="col-lg-3 col-md-3 col-sm-3 mt-2">
                                            <div class="form-floating">
                                                <input type="number" name="room_number" id="room_number" value="<?php echo $room_number ?>" class="form-control" placeholder="" required>
                                                <label for="room_number">Room number</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-8 mt-2">
                                            <div class="form-floating">
                                                <input type="text" name="direction" id="direction" value="<?php echo $direction ?>" class="form-control" placeholder="" required>
                                                <label for="direction">Include some direction for your quiz.</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div id="rows-container"></div>
                                    <div class="col-lg-3">
                                        <button class="btn btn-success rounded-5" style="padding: 12px;" id="addRow" type="button">
                                            <i class="bi bi-plus-lg"></i>&nbsp; Add Item
                                        </button>
                                        <button class="btn-custom" type="submit">
                                            <i class="bi bi-capslock"></i>&nbsp; Save
                                        </button>
                                    </div>
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

        <?php
        $get_item_number = $rows['item_number'] + 1;
        ?>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const addRowButton = document.getElementById("addRow");
                const rowsContainer = document.getElementById("rows-container");
                let rowCounter = 0;
                let itemNumber = <?php echo $get_item_number ?>;
                addRowButton.addEventListener("click", function() {
                    const newRow = document.createElement("div");
                    newRow.classList.add("row", "mb-2");
                    newRow.innerHTML = `
                        <div class="col-lg-3 col-md-3 col-sm-3 mt-2">
                            <div class="form-floating">
                                <input type="number" name="item_number_${rowCounter}" value="${itemNumber++}" placeholder="" class="form-control" style="background-color: #e4e4e4;" id="item_number" readonly>
                                <label for="item_number">Item number</label>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 mt-2">
                            <div class="form-floating">
                                <input type="text" name="question_${rowCounter}" placeholder="" class="form-control" id="question" required>
                                <label for="question">Type your question</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                            <div class="form-floating">
                                <input type="text" name="choice1_${rowCounter}" placeholder="" class="form-control" id="choice1" required>
                                <label for="choice1">Your choice number 1</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                            <div class="form-floating">
                                <input type="text" name="choice2_${rowCounter}" placeholder="" class="form-control" id="choice2" required>
                                <label for="choice2">Your choice number 2</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                            <div class="form-floating">
                                <input type="text" name="choice3_${rowCounter}" placeholder="" class="form-control" id="choice3" required>
                                <label for="choice3">Your choice number 3</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                            <div class="form-floating">
                                <input type="text" name="choice4_${rowCounter}" placeholder="" class="form-control" id="choice4" required>
                                <label for="choice4">Your choice number 4</label>
                            </div>
                        </div>
                        <div class="col-lg126 col-md-12 col-sm-12 mt-2 mb-3">
                            <div class="form-floating">
                                <input type="text" name="correct_answer_${rowCounter}" placeholder="" class="form-control" id="correct_answer" required>
                                <label for="correct_answer">The correct answer</label>
                            </div>
                        </div>
                        <hr>
                    `;
                    rowsContainer.appendChild(newRow);
                    rowCounter++;
                });
            });
        </script>

    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
}
