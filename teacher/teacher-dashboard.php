<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $teacher_id = $_SESSION['id'];
    $stmt = $conn->prepare('SELECT * FROM tbl_teacher WHERE id = ?');
    $stmt->bind_param('i', $teacher_id);
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
                        <h1>Dashboard</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">BioQuest</li>
                                <li class="breadcrumb-item">Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                    <section class="section dashboard">
                        <div class="row">
                            <div class="col-xxl-4 col-md-4">
                                <div class="card info-card small-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Learning Materials</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-5 card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-lightbulb"></i>
                                            </div>
                                            <div class="ps-3">
                                                <?php
                                                $stmt = $conn->prepare('SELECT * FROM tbl_topics');
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $topic_items = mysqli_num_rows($result);
                                                echo "<h6>$topic_items items &nbsp; <a href='topics.php'><button class='btn-custom'>View</button></a></h6>";
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-md-4">
                                <div class="card info-card small-card">
                                    <div class="card-body">
                                        <h5 class="card-title">My Students</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-5 card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-3">
                                                <?php
                                                $stmt = $conn->prepare('SELECT * FROM tbl_student WHERE year_level = ? AND section = ?');
                                                $stmt->bind_param('ii', $year_level, $section);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $students = mysqli_num_rows($result);
                                                echo "<h6>$students people &nbsp; <a href='students-masterlist.php'><button class='btn-custom'>View</button></a></h6>";
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-md-4">
                                <div class="card info-card small-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Quizes</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-5 card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-grid"></i>
                                            </div>
                                            <div class="ps-3">
                                                <?php
                                                $stmt = $conn->prepare('SELECT * FROM tbl_quiz WHERE teacher_id = ? GROUP BY room_number');
                                                $stmt->bind_param('i', $teacher_id);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $quizes = mysqli_num_rows($result);
                                                echo "<h6>$quizes items &nbsp; <a href='quizes.php'><button class='btn-custom'>View</button></a></h6>";
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card px-2">
                                    <div class="card-body">
                                        <h5 class="card-title">All Quizes</h5>
                                        <div class="table-responsive">
                                            <table class="table" id="table">
                                                <colgroup>
                                                    <col width="20%">
                                                    <col width="20%">
                                                    <col width="20%">
                                                    <col width="20%">
                                                </colgroup>
                                                <thead class="bg-secondary-light">
                                                    <tr>
                                                        <th>Room_Number</th>
                                                        <th>Student_Takers</th>
                                                        <th>Number_Of_Items</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $num_items = 0;
                                                    $stmt = $conn->prepare(' SELECT 
                                                    tbl_quiz.id,
                                                    tbl_year_level.year_level, 
                                                    tbl_section.section, 
                                                    tbl_quiz.teacher_id, 
                                                    tbl_quiz.room_number, 
                                                    COUNT(tbl_quiz.room_number) AS num_items
                                                    FROM tbl_quiz
                                                    INNER JOIN tbl_year_level ON tbl_quiz.year_level = tbl_year_level.id
                                                    INNER JOIN tbl_section ON tbl_quiz.section_id = tbl_section.id
                                                    WHERE tbl_quiz.teacher_id = ? 
                                                    GROUP BY tbl_quiz.room_number 
                                                    ORDER BY tbl_quiz.id DESC');
                                                    $stmt->bind_param('i', $teacher_id);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $id = $row['id'];
                                                        $year_level = $row['year_level'];
                                                        $section = $row['section'];
                                                        $room_number = $row['room_number'];
                                                        $num_items = $row['num_items'];
                                                        echo '
                                                    <tr>
                                                        <td>' . $room_number . '</td>
                                                        <td>' . $year_level . ' - ' . $section . '</td>
                                                        <td>' . $num_items . '</td>
                                                        <td>
                                                            <a href="view-quiz.php?room_number=' . $room_number . '" title="View Quiz">
                                                                <button class="btn btn-outline-primary">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                            </a>
                                                            <a href="delete-quiz.php?id=' . $id . '" title="Remove Quiz">
                                                                <button class="btn btn-outline-danger">
                                                                    <i class="bi bi-trash"></i>
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
