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
                <h1>Dashboard</h1>
                <nav style="--bs-breadcrumb-divider: '•';">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Menu</li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <!-- First Small Card -->
                            <div class="col-xxl-4 col-md-4">
                                <div class="card info-card first-small-card">
                                    <div class="card-body">
                                        <h5 class="card-title">First <span>| sub title</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>000</h6>
                                                <span class="text-success small pt-1 fw-bold">?</span> <span class="text-muted small pt-2 ps-1">text</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Second Small Card -->
                            <div class="col-xxl-4 col-md-4">
                                <div class="card info-card second-small-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Second <span>| sub title</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>000</h6>
                                                <span class="text-success small pt-1 fw-bold">?</span> <span class="text-muted small pt-2 ps-1">text</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Third Small Card -->
                            <div class="col-xxl-4 col-md-4">
                                <div class="card info-card third-small-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Third <span>| sub title</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>000</h6>
                                                <span class="text-danger small pt-1 fw-bold">?</span> <span class="text-muted small pt-2 ps-1">text</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Reports -->
                            <div class="col-xxl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Reports <span>| Today</span></h5>
                                    </div>
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
