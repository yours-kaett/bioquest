<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $get_topic_id = $_GET['id'];
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="pagetitle">
                            <h1>Discussion</h1>
                            <nav style="--bs-breadcrumb-divider: '•';">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Menu</li>
                                    <li class="breadcrumb-item">Learn</li>
                                    <li class="breadcrumb-item">Discussion</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <a href="topics.php">
                        <i class="bi bi-arrow-left"></i>&nbsp; Back
                    </a>

                    <?php
                    $stmt = $conn->prepare(' SELECT id, topic_title FROM tbl_topics WHERE id = ? ');
                    $stmt->bind_param('i', $get_topic_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $topic_title = $row['topic_title'];
                    ?>

                    <section class="section dashboard">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card px-2">
                                    <div class="card-body">
                                        <h1 class="card-title fs-2"><?php echo $topic_title ?></h1>
                                        <?php
                                        $stmt = $conn->prepare(' SELECT * FROM tbl_sub_topics WHERE topic_id = ? GROUP BY lesson_number, lesson_title ORDER BY id ASC');
                                        $stmt->bind_param('i', $get_topic_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if (mysqli_num_rows($result) == 0) {
                                            echo "<div class='d-flex align-items-center flex-column py-3'>
                                                    <i class='bi bi-circle-x text-secondary' style='font-size: 80px;'></i>
                                                    <h6 class='text-secondary fw-bold mt-3'>Empty discussion for topic <span class='text-success'>" . $topic_title . "</span>.</h6>
                                                    <a href='topics.php' class='mt-3'>
                                                        <button class='btn btn-outline-success border-2 d-flex align-items-center fw-bold'>
                                                            <i class='bi bi-arrow-left fs-5'></i>
                                                            &nbsp; Back to Learn
                                                        </button>
                                                    </a>
                                                </div>";
                                        } else {
                                            while ($row = $result->fetch_assoc()) {
                                                $lesson_number = $row['lesson_number'];
                                                $lesson_title = $row['lesson_title'];
                                                echo '<h5 class="mt-4">Lesson # ' . $lesson_number . ': <span class="fw-bold">' . $lesson_title . '</span></h5>';
                                                $stmtInner = $conn->prepare(' SELECT * FROM tbl_sub_topics WHERE topic_id = ? AND lesson_number = ?');
                                                $stmtInner->bind_param('ii', $get_topic_id, $lesson_number);
                                                $stmtInner->execute();
                                                $resultInner = $stmtInner->get_result();
                                                while ($rowInner = $resultInner->fetch_assoc()) {
                                                    $section_title = $rowInner['section_title'];
                                                    $discussion = $rowInner['discussion'];
                                                    echo '
                                                        <div class="d-flex flex-column mt-3 mb-3 p-3">
                                                            <h3 class="text-center">' . $section_title . '</h3>
                                                            <p class="text-center">' . $discussion . '</p>
                                                        </div>
                                                    ';
                                                }
                                                echo '<hr />';
                                            }
                                        }
                                        ?>
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
