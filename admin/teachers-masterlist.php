<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
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
                                                        <th>Teacher_Name</th>
                                                        <th>Handled Year & Section</th>
                                                        <th>Username</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $stmt = $conn->prepare(' SELECT
                                                    tbl_teacher.id,
                                                    tbl_teacher.username,
                                                    tbl_teacher.firstname,
                                                    tbl_teacher.middlename,
                                                    tbl_teacher.lastname,
                                                    tbl_year_level.year_level,
                                                    tbl_section.section,
                                                    tbl_teacher.email
                                                    FROM tbl_teacher
                                                    INNER JOIN tbl_year_level ON tbl_teacher.year_level = tbl_year_level.id
                                                    INNER JOIN tbl_section ON tbl_teacher.section = tbl_section.id
                                                    ORDER BY tbl_teacher.lastname ASC ');
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $username = $row['username'];
                                                        $firstname = $row['firstname'];
                                                        $middlename = $row['middlename'];
                                                        $lastname = $row['lastname'];
                                                        $year_level = $row['year_level'];
                                                        $section = $row['section'];
                                                        $email = $row['email'];
                                                        echo '
                                                            <tr>
                                                                <td>' . $firstname . " " . $middlename . " " . $lastname . '</td>
                                                                <td>' . $year_level . ' - ' . $section . '</td>
                                                                <td>' . $username . '</td>
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
