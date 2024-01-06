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
                <main id="main" class="">
                    <div class="pagetitle">
                        <h1>Neuron</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">BioQuest</li>
                                <li class="breadcrumb-item">Simulations</li>
                                <li class="breadcrumb-item">Neuron</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="simulations.php" class="text-white">
                        <i class="bi bi-arrow-left"></i>&nbsp; Back
                    </a>
                    <section class="section register d-flex flex-column align-items-center justify-content-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 d-flex flex-column align-items-center justify-content-center">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <iframe width="1110" height="740" src="https://phet.colorado.edu/sims/html/neuron/latest/neuron_all.html" frameborder="0" class="mt-3 position-relative" style="z-index: 1;"></iframe>
                                            <div class="w-100 position-relative" style="height: 90px; top: -70px; z-index: 1; background: #000;"></div>
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
