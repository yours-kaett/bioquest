<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $student_id = $_SESSION['id'];
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
                        <h1>Learning Materials</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">BioQuest</li>
                                <li class="breadcrumb-item">Learning Materials</li>
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
                                            <?php
                                            $stmt = $conn->prepare(' SELECT * FROM tbl_topics ORDER BY id DESC ');
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result ->fetch_assoc()) {
                                                $id = $row['id'];
                                                $topic_title = $row['topic_title'];
                                                $filename = $row['filename'];
                                                $characterLimit = 20;
                                                $truncatedTitle = substr($topic_title, 0, $characterLimit);
                                                if (strlen($topic_title) > $characterLimit) {
                                                    $truncatedTitle .= '...';
                                                }
                                                echo '
                                                <div class="col-lg-2 col-md-2 col-sm-4 mb-2">
                                                    <a href="https://docs.google.com/viewerng/viewer?url=http://bioquest.rf.gd/modules/'.$filename.'" target="_blank">
                                                        <div class="d-flex align-items-center flex-column topic-card rounded-2 pt-4">
                                                            <i class="bi bi-file-earmark-arrow-down" style="color: #fff; font-size: 65px;"></i>
                                                            <h6 class="topic-title text-center text-white m-4">' . $truncatedTitle .'</h6>
                                                        </div>
                                                    </a>
                                                </div>
                                                ';
                                            }
                                            ?>
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
