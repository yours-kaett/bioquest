<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
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
                        <h1>Quizes</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Reports</li>
                                <li class="breadcrumb-item">Quizes</li>
                            </ol>
                        </nav>
                    </div>
                    <?php
                    if (isset($_GET['success'])) {
                    ?>
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center mb-4" role="alert">
                            <div>
                                <?php echo $_GET['success'], "New quiz has been saved successfully!"; ?>
                                <a href="quizes.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    if (isset($_GET['updated'])) {
                    ?>
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center mb-4" role="alert">
                            <div>
                                <?php echo $_GET['updated'], "Quiz has been updated successfully!"; ?>
                                <a href="quizes.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    if (isset($_GET['error'])) {
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center mb-4" role="alert">
                            <div>
                                <?php echo $_GET['error'], "Error inserting data."; ?>
                                <a href="quizes.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    if (isset($_GET['unknown'])) {
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center mb-4" role="alert">
                            <div>
                                <?php echo $_GET['unknown'], "Unknown error occurred."; ?>
                                <a href="quizes.php">
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
                                <!-- <div class="mt-2 mb-3">
                                    <button class="btn-custom">
                                        <i class="bi bi-printer"></i>&nbsp; PDF
                                    </button>
                                    <button class="btn-custom">
                                        <i class="bi bi-download"></i>&nbsp; XLSX
                                    </button>
                                </div> -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive mt-3">
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
                                                    tbl_section.section, 
                                                    tbl_quiz.teacher_id, 
                                                    tbl_quiz.room_number, 
                                                    COUNT(tbl_quiz.room_number) AS num_items
                                                    FROM tbl_quiz
                                                    INNER JOIN tbl_section ON tbl_quiz.section_id = tbl_section.id
                                                    WHERE tbl_quiz.teacher_id = ? 
                                                    GROUP BY tbl_quiz.room_number 
                                                    ORDER BY tbl_quiz.id DESC');
                                                    $stmt->bind_param('i', $user_id);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $id = $row['id'];
                                                        $section = $row['section'];
                                                        $room_number = $row['room_number'];
                                                        $num_items = $row['num_items'];
                                                        echo '
                                                            <tr>
                                                                <td>' . $room_number . '</td>
                                                                <td>Section ' . $section . '</td>
                                                                <td>' . $num_items . '</td>
                                                                <td>
                                                                    <a href="view-quiz.php?room_number=' . $room_number . '" title="View Quiz">
                                                                        <button class="btn btn-success">
                                                                            <i class="bi bi-eye"></i>
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
