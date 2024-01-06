<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../other-includes/head.php' ?>
        <link href="assets/vendor/boxicons/css/boxicons.css" rel="stylesheet">
    </head>

    <body>
        <?php include 'top-nav.php' ?>
        <?php include 'side-nav.php' ?>
        <div id="start">
            <div id="particles-js">
                <main id="main" class="main">
                    <div class="pagetitle">
                        <h1>Simulations</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">BioQuest</li>
                                <li class="breadcrumb-item">Simulations</li>
                            </ol>
                        </nav>
                    </div>

                    <section class="section dashboard">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card px-2" style="background: none !important;">
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                        <div class="row">
                                            <div class="col-lg-2 col-md-2 col-sm-4 mb-2">
                                                <a href="human-body.php">
                                                    <div class="d-flex align-items-center flex-column topic-card rounded-2 pt-4">
                                                        <i class="bx bx-body" style="color: #fff; font-size: 65px;"></i>
                                                        <h6 class="topic-title text-center text-white m-4">Human Body</h6>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 mb-2">
                                                <a href="density.php">
                                                    <div class="d-flex align-items-center flex-column topic-card rounded-2 pt-4">
                                                        <i class="bx bx-water" style="color: #fff; font-size: 65px;"></i>
                                                        <h6 class="topic-title text-center text-white m-4">Density</h6>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 mb-2">
                                                <a href="natural-selection.php">
                                                    <div class="d-flex align-items-center flex-column topic-card rounded-2 pt-4">
                                                        <i class="bx bx-vertical-center" style="color: #fff; font-size: 65px;"></i>
                                                        <h6 class="topic-title text-center text-white m-4">Natural Selection</h6>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 mb-2">
                                                <a href="gene-expression.php">
                                                    <div class="d-flex align-items-center flex-column topic-card rounded-2 pt-4">
                                                        <i class="bx bx-dna" style="color: #fff; font-size: 65px;"></i>
                                                        <h6 class="topic-title text-center text-white m-4">Gene Expression</h6>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 mb-2">
                                                <a href="molecule-polarity.php">
                                                    <div class="d-flex align-items-center flex-column topic-card rounded-2 pt-4">
                                                        <i class="bx bx-git-branch" style="color: #fff; font-size: 65px;"></i>
                                                        <h6 class="topic-title text-center text-white m-4">Molecule Polarity</h6>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 mb-2">
                                                <a href="neuron.php">
                                                    <div class="d-flex align-items-center flex-column topic-card rounded-2 pt-4">
                                                        <i class="bx bx-braille" style="color: #fff; font-size: 65px;"></i>
                                                        <h6 class="topic-title text-center text-white m-4">Neuron</h6>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 mb-2">
                                                <a href="color-vision.php">
                                                    <div class="d-flex align-items-center flex-column topic-card rounded-2 pt-4">
                                                        <i class="bx bx-show" style="color: #fff; font-size: 65px;"></i>
                                                        <h6 class="topic-title text-center text-white m-4">Color Vision</h6>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 mb-2">
                                                <a href="ph-scale.php">
                                                    <div class="d-flex align-items-center flex-column topic-card rounded-2 pt-4">
                                                        <i class="bx bx-bar-chart-alt-2" style="color: #fff; font-size: 65px;"></i>
                                                        <h6 class="topic-title text-center text-white m-4">pH Scale</h6>
                                                    </div>
                                                </a>
                                            </div>
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
