<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $room_number = $_GET['room_number'];
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
                <main id="main" class="">
                    <div class="pagetitle">
                        <h1>Quiz Level</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Room Number</li>
                                <li class="breadcrumb-item">Quiz Level</li>
                            </ol>
                        </nav>
                    </div>

                    <section class="section register d-flex flex-column align-items-center justify-content-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 d-flex flex-column align-items-center justify-content-center">
                                    <div class="card mb-3 p-2">
                                        <div class="card-body">
                                            <h5 class="card-title">Select your preffered level.</h5>
                                            <form action="#">
                                                <a href="quiz-medium.php?room_number=<?php echo $room_number ?>">
                                                    <button class="btn-custom w-100 p-4 px-5" type="button">
                                                        Medium
                                                    </button>
                                                </a>&nbsp;
                                                <a href="quiz-hard.php?room_number=<?php echo $room_number ?>">
                                                    <button class="btn-custom w-100 p-4 px-5" type="button">
                                                        Hard
                                                    </button>
                                                </a>
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
