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
                    <div class="pagetitle">
                        <h1>Add Discussion</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Menu</li>
                                <li class="breadcrumb-item">Learn</li>
                                <li class="breadcrumb-item">Discussion</li>
                                <li class="breadcrumb-item">Add Discussion</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- success & error -->
                    <?php
                    if (isset($_GET['success'])) {
                    ?>
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center mb-4" role="alert">
                            <?php echo $_GET['success'], "New discussion has been saved successfully."; ?>
                            <a href="discussion.php?id=<?php echo $get_topic_id ?>">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </a>
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
                    $stmt = $conn->prepare(' SELECT 
                    tbl_sub_topics.topic_id,
                    tbl_topics.topic_title,
                    tbl_sub_topics.teacher_id
                    FROM tbl_sub_topics
                    INNER JOIN tbl_topics ON tbl_sub_topics.topic_id = tbl_topics.id
                    WHERE tbl_sub_topics.topic_id = ? AND tbl_sub_topics.teacher_id = ? ');
                    $stmt->bind_param('ii', $get_topic_id, $teacher_id);
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
                                        <form action="discussion-add-check.php" method="POST" class="mb-4 mt-4 w-100">
                                            <div id="rows-container"></div>
                                            <input type="text" name="topic_id" value="<?php echo $get_topic_id ?>" style="display: none;">
                                            <div class="col-lg-3">
                                                <button class="btn btn-outline-success w-50" id="addRow" type="button">
                                                    <i class="bi bi-plus-lg"></i>&nbsp; Add Section
                                                </button>
                                            </div>
                                            <div class="w-100 mt-5">
                                                <button class="btn btn-success btn-lg w-100" type="submit">Save</button>
                                            </div>
                                        </form>
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
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const addRowButton = document.getElementById("addRow");
                const rowsContainer = document.getElementById("rows-container");
                let rowCounter = 0;

                addRowButton.addEventListener("click", function() {
                    const newRow = document.createElement("div");
                    newRow.classList.add("row", "mb-2");
                    newRow.innerHTML = `
                        <div class="col-lg-4 col-md-4 col-sm-2 mt-2">
                            <div class="form-floating">
                                <input type="number" name="lesson_number_${rowCounter}" placeholder="" class="form-control" id="lesson_number" required>
                                <label for="lesson_number">Lesson #</label>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-4 col-sm-2 mt-2">
                            <div class="form-floating">
                                <input type="text" name="lesson_title_${rowCounter}" placeholder="" class="form-control" id="lesson_title" required>
                                <label for="lesson_title">Lesson Title</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-2 mt-2">
                            <div class="form-floating">
                                <input type="text" name="section_title_${rowCounter}" placeholder="" class="form-control" id="section_title" required>
                                <label for="section_title">Section Title</label>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-4 col-sm-2 mt-2 mb-3">
                            <div class="form-floating">
                                <textarea name="discussion_${rowCounter}" class="form-control" placeholder="" id="discussion" required></textarea>
                                <label for="discussion">Your discussion</label>
                            </div>
                        </div>
                        <hr>
                    `;
                    rowsContainer.appendChild(newRow);
                    rowCounter++;
                });
            });
        </script>

    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
}
