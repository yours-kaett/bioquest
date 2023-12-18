<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $student_id = $_SESSION['id'];
    $stmt = $conn->prepare('SELECT * FROM tbl_student WHERE id = ?');
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $year_level = $row['year_level'];
    $section_id = $row['section'];
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
                        <h1>Available Quizes</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">BioQuest</li>
                                <li class="breadcrumb-item">Available Quizes</li>
                            </ol>
                        </nav>
                    </div>

                    <section class="section dashboard">
                    <div class="row">
                            <div class="col-lg-12">
                                <div class="card px-2">
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                        <div class="table-responsive">
                                            <table class="table">
                                            <colgroup>
                                                <col width="20%">
                                                <col width="20%">
                                                <col width="20%">
                                                <col width="20%">
                                            </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th>Room #</th>
                                                        <th>Number of Items</th>
                                                        <th>Prepared By</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $stmt = $conn->prepare(' SELECT 
                                                    tbl_quiz.room_number, 
                                                    COUNT(tbl_quiz.item_number) AS all_items,
                                                    tbl_teacher.firstname,
                                                    tbl_teacher.middlename,
                                                    tbl_teacher.lastname
                                                    FROM tbl_quiz 
                                                    INNER JOIN tbl_teacher ON tbl_quiz.teacher_id = tbl_teacher.id
                                                    WHERE tbl_quiz.year_level = ? AND tbl_quiz.section_id = ? 
                                                    GROUP BY tbl_quiz.room_number ');
                                                    $stmt->bind_param('ii', $year_level, $section_id);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $room_number = $row['room_number'];
                                                        $all_items = $row['all_items'];
                                                        $firstname = $row['firstname'];
                                                        $middlename = $row['middlename'];
                                                        $lastname = $row['lastname'];
                                                        echo '
                                                        <tr>
                                                            <td>' . $room_number . '</td>
                                                            <td>' . $all_items . '</td>
                                                            <td>Inst. ' . $firstname . " " . $middlename . " " . $lastname . '</td>
                                                            <td>
                                                                <a href="room-number.php?room_number='. $room_number .'">
                                                                    <button class="btn-custom">
                                                                        Take Quiz
                                                                    </button>
                                                                    
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        ';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
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
