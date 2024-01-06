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
                                <?php
                                if (isset($_GET['updated_account_status'])) {
                                ?>
                                    <div class="alert alert-success rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                                        <?php echo $_GET['updated_account_status'], "Account status has been updated successfully."; ?>
                                        <a href="students-masterlist.php">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </a>
                                    </div>
                                <?php
                                }
                                if (isset($_GET['unable'])) {
                                ?>
                                    <div class="alert alert-warning rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                                        <?php echo $_GET['unable'], "Unable to update account status."; ?>
                                        <a href="students-masterlist.php">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </a>
                                    </div>
                                <?php
                                }
                                if (isset($_GET['unknown'])) {
                                ?>
                                    <div class="alert alert-danger rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                                        <?php echo $_GET['unknown'], "Unknown error occured."; ?>
                                        <a href="students-masterlist.php">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive mt-3">
                                            <table class="table" id="table">
                                                <col width="15%">
                                                <col width="15%">
                                                <col width="15%">
                                                <col width="15%">
                                                <col width="15%">
                                                <col width="15%">
                                                <thead class="bg-secondary-light">
                                                    <tr>
                                                        <th>Lastname</th>
                                                        <th>Firstname</th>
                                                        <th>Middlename</th>
                                                        <th>Year_Level & Section</th>
                                                        <th>Student_ID</th>
                                                        <th>Email</th>
                                                        <th>Status</th>
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
                                                    tbl_student.email,
                                                    tbl_account_status.account_status
                                                    FROM tbl_student
                                                    INNER JOIN tbl_year_level ON tbl_student.year_level = tbl_year_level.id
                                                    INNER JOIN tbl_section ON tbl_student.section = tbl_section.id
                                                    INNER JOIN tbl_account_status ON tbl_student.account_status_id = tbl_account_status.id
                                                    ORDER BY tbl_student.lastname ASC ');
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $id = $row['id'];
                                                        $student_id = $row['student_id'];
                                                        $firstname = $row['firstname'];
                                                        $middlename = $row['middlename'];
                                                        $lastname = $row['lastname'];
                                                        $year_level = $row['year_level'];
                                                        $section = $row['section'];
                                                        $email = $row['email'];
                                                        $account_status = $row['account_status'];
                                                        if ($account_status === "Requested") {
                                                            $a_indicator = "none";
                                                            $r_indicator = "flex";
                                                        } elseif ($account_status === "Active") {
                                                            $a_indicator = "flex";
                                                            $r_indicator = "none";
                                                        }
                                                        echo '
                                                            <tr>
                                                                <td>' . $lastname . '</td>
                                                                <td>' . $firstname . '</td>
                                                                <td>' . $middlename . '</td>
                                                                <td>' . $year_level . ' - ' . $section . '</td>
                                                                <td>' . $student_id . '</td>
                                                                <td>' . $email . '</td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm" style="display: ' . $r_indicator . '" data-bs-toggle="modal" data-bs-target="#requestedModal' . $id . '">
                                                                            <i class="bi bi-bell"></i>&nbsp ' . $account_status . '
                                                                    </button>
                                                                    <button class="btn btn-primary btn-sm" style="display: ' . $a_indicator . '" data-bs-toggle="modal" data-bs-target="#activeStatusModal' . $id . '">
                                                                        <i class="bi bi-radioactive"></i>&nbsp ' . $account_status . '
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        ';
                                                    ?>

                                                        <div class="modal fade" id="requestedModal<?php echo $id ?>" tabindex="-1" aria-labelledby="requestedModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content p-1 bg-dark">
                                                                    <form action="account-requested.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data" class="row p-2">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title text-white fs-5" id="requestedModalLabel">Change Account Status</h1>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p class="d-flex align-items-center justify-content-center">Are you sure you want this account set as <span class="bg-primary text-white mx-1 px-1 rounded">Active</span>?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" name="submit" class="btn btn-success" id="loaderButton">
                                                                                <span id="submitBlank">
                                                                                    <span id="submit">Yes</span>
                                                                                </span>
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="activeStatusModal<?php echo $id ?>" tabindex="-1" aria-labelledby="activeStatusModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content p-1 bg-dark">
                                                                    <form action="account-active.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data" class="row">
                                                                        <div class="modal-header mt-0">
                                                                            <h1 class="modal-title text-white fs-5" id="activeStatusModalLabel">Change Account Status</h1>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p class="d-flex align-items-center justify-content-center">Are you sure you want this account set as <span class="bg-warning text-dark mx-1 px-1 rounded">Requested</span>?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" name="submit" class="btn btn-success" id="loaderButton">
                                                                                <span id="submitBlank">
                                                                                    <span id="submit">Yes</span>
                                                                                </span>
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
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
