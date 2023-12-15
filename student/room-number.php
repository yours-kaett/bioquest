<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $student_id = $_SESSION['id'];
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

        <div id="start">
            <div id="particles-js">
                <main id="main" class="">
                    <div class="pagetitle">
                        <h1>Room Number</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">BioQuest</li>
                                <li class="breadcrumb-item">Room Number</li>
                            </ol>
                        </nav>
                    </div>

                    <section class="section register d-flex flex-column align-items-center justify-content-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 d-flex flex-column align-items-center justify-content-center">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title"><sup class="text-danger">*</sup> You must input the room number to able to take quiz.</h5>
                                            <form action="room-number-check.php" method="POST" class="row g-3">
                                                <div class="col-lg-12">
                                                    <?php
                                                    if (isset($_GET['notfound'])) {
                                                    ?>
                                                        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center mt-3" role="alert">
                                                            <?php echo $_GET['notfound'], "Room number not found."; ?>
                                                            <a href="room-number.php">
                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </a>
                                                        </div>
                                                    <?php
                                                    }
                                                    if (isset($_GET['done'])) {
                                                    ?>
                                                        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center mt-3 w-100" role="alert">
                                                            <?php echo $_GET['done'], "You have already responded."; ?>
                                                            <a href="room-number.php">
                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </a>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-floating">
                                                        <input type="number" name="room_number" class="form-control w-100" id="room_number" placeholder="" required>
                                                        <label for="room_number">Room #</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button type="submit" class="btn-custom w-100 p-3">Enter</button>
                                                </div>
                                            </form>
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
