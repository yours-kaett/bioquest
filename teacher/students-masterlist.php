<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- ======= Head ======= -->
        <?php include '../other-includes/head.php' ?>
    </head>

    <body>
        <!-- ======= Header ======= -->
        <?php include 'top-nav.php' ?>
        <!-- ======= Sidebar ======= -->
        <?php include 'side-nav.php' ?>
        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Students Masterlist</h1>
                <nav style="--bs-breadcrumb-divider: '•';">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Reports</a></li>
                        <li class="breadcrumb-item">Students Masterlist</li>
                    </ol>
                </nav>
            </div>
            <section class="section dashboard">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mt-2 mb-3">
                            <button class="btn btn-outline-success">
                                <i class="bi bi-printer"></i>&nbsp; PDF
                            </button>
                            <button class="btn btn-outline-success">
                                <i class="bi bi-download"></i>&nbsp; XLSX
                            </button>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover" id="table">
                                        <thead class="bg-secondary-light">
                                            <tr>
                                                <th>Student_ID</th>
                                                <th>Student_Name</th>
                                                <th>Year_Level</th>
                                                <th>Section</th>
                                                <th>Email</th>
                                                <th>Action</th>
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
                                                        <td>' . $student_id . '</td>
                                                        <td>' . $firstname . " " . $middlename . " " . $lastname . '</td>
                                                        <td>' . $year_level . '</td>
                                                        <td>' . $section . '</td>
                                                        <td>' . $email . '</td>
                                                        <td>
                                                            <a href="edit-quiz.php?id=' . $user_id . '">
                                                                <button class="btn btn-outline-primary">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                            </a>
                                                            <a href="delete-quiz.php?id=' . $user_id . '">
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

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Scripts -->
        <?php include '../other-includes/scripts.php' ?>

    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
}
