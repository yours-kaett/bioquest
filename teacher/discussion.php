<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $teacher_id = $_SESSION['id'];
    $get_topic_id = $_GET['id'];
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="pagetitle">
                            <h1>Discussion</h1>
                            <nav style="--bs-breadcrumb-divider: '•';">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Menu</li>
                                    <li class="breadcrumb-item">Learning Materials</li>
                                    <li class="breadcrumb-item">Discussion</li>
                                </ol>
                            </nav>
                        </div>
                        <div></div>
                    </div>
                    <?php
                    if (isset($_GET['success'])) {
                    ?>
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center mb-4" role="alert">
                            <div>
                                <?php echo $_GET['success']; ?>
                                <a href="discussion.php?id=<? echo $get_topic_id ?>">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    if (isset($_GET['error'])) {
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center mb-4" role="alert">
                            <div>
                                <?php echo $_GET['error']; ?>
                                <a href="discussion.php?id=<? echo $get_topic_id ?>">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

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
                                        $stmt = $conn->prepare(' SELECT * FROM tbl_sub_topics WHERE topic_id = ? AND teacher_id = ? GROUP BY lesson_number, lesson_title ORDER BY id ASC');
                                        $stmt->bind_param('ii', $get_topic_id, $teacher_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if (mysqli_num_rows($result) == 0) {
                                            echo "<div class='d-flex align-items-center flex-column py-3'>
                                                    <i class='bi bi-circle-x text-secondary' style='font-size: 80px;'></i>
                                                    <h6 class='text-secondary fw-bold mt-3'>Empty discussion for topic entitled <span class='text-success'>" . $topic_title . "</span>.</h6>
                                                    <a href='topics.php' class='mt-3'>
                                                        <button class='btn-custom border-2 d-flex align-items-center fw-bold'>
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
                                                $stmtInner = $conn->prepare(' SELECT * FROM tbl_sub_topics WHERE topic_id = ? AND teacher_id = ? AND lesson_number = ?');
                                                $stmtInner->bind_param('iii', $get_topic_id, $teacher_id, $lesson_number);
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
