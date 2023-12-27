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
                <main id="main" class="main">
                    <div class="pagetitle">
                        <h1>Students Masterlist</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Reports</li>
                                <li class="breadcrumb-item">Students Masterlist</li>
                            </ol>
                        </nav>
                    </div>
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
                                                <thead class="bg-secondary-light">
                                                    <tr>
                                                        <th>Student_Name</th>
                                                        <th>Year_Level</th>
                                                        <th>Section</th>
                                                        <th>Student_ID</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $stmt = $conn->prepare(' SELECT
                                                    tbl_student.id,
                                                    tbl_student.student_id,
                                                    tbl_student.firstname,
                                                    tbl_student.middlename,
                                                    tbl_student.lastname,
                                                    tbl_year_level.year_level,
                                                    tbl_section.section,
                                                    tbl_student.email
                                                    FROM tbl_student
                                                    INNER JOIN tbl_year_level ON tbl_student.year_level = tbl_year_level.id
                                                    INNER JOIN tbl_section ON tbl_student.section = tbl_section.id
                                                    ORDER BY tbl_student.lastname ASC ');
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $student_id = $row['student_id'];
                                                        $firstname = $row['firstname'];
                                                        $middlename = $row['middlename'];
                                                        $lastname = $row['lastname'];
                                                        $year_level = $row['year_level'];
                                                        $section = $row['section'];
                                                        $email = $row['email'];
                                                        echo '
                                                            <tr>
                                                                <td>' . $firstname . " " . $middlename . " " . $lastname . '</td>
                                                                <td>' . $year_level . '</td>
                                                                <td>' . $section . '</td>
                                                                <td>' . $student_id . '</td>
                                                                <td>' . $email . '</td>
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
