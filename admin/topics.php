<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $teacher_id = $_SESSION['id'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../other-includes/head.php' ?>
        <style>
            .topic-card {
                display: inline-block;
                background: linear-gradient(to right, #00ad93e5, #003546ea);
                background-size: 200% 100%;
                transition: background-position 0.5s ease-in-out;
            }

            .topic-card:hover {
                background-position: right center;
                animation: gradientMove 2s infinite alternate;
                transition: background-position 0.9s ease-in-out;
            }

            @keyframes gradientMove {
                to {
                    background-position: left center;
                }
            }

            /* .topic-title {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 30ch;
            } */
        </style>
    </head>

    <body>
        <?php include 'top-nav.php' ?>
        <?php include 'side-nav.php' ?>
        <div id="start">
            <div id="particles-js">
                <main id="main" class="main">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="pagetitle">
                            <h1>Learning Materials</h1>
                            <nav style="--bs-breadcrumb-divider: '•';">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Menu</li>
                                    <li class="breadcrumb-item">Learning Materials</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <button class="btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#addTopicModal">
                                <i class="bi bi-plus-lg"></i>&nbsp; Add New
                            </button>
                        </div>
                    </div>

                    <section class="section dashboard">
                        <?php
                        if (isset($_GET['error'])) {
                        ?>
                            <div class="alert alert-warning rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                                <?php echo $_GET['error'], "Only PDF files with less than 100MB are allowed to upload"; ?>
                                <a href="topics.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['topic_exist'])) {
                        ?>
                            <div class="alert alert-warning rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                                <?php echo $_GET['topic_exist'], "Topic already exist."; ?>
                                <a href="topics.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['success'])) {
                        ?>
                            <div class="alert alert-success rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                                <?php echo $_GET['success'], "Module has been imported successfully."; ?>
                                <a href="topics.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['not_uploaded'])) {
                        ?>
                            <div class="alert alert-danger rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                                <?php echo $_GET['not_uploaded'], "Your file was unable to upload."; ?>
                                <a href="topics.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['file_exist'])) {
                        ?>
                            <div class="alert alert-warning rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                                <?php echo $_GET['file_exist'], "File already exist."; ?>
                                <a href="topics.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }

                        if (isset($_GET['not_allowed'])) {
                        ?>
                            <div class="alert alert-warning rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                                <?php echo $_GET['not_allowed'], "Your file is not allowed to upload. Please select DOC, DOCX or PDF only."; ?>
                                <a href="topics.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }

                        if (isset($_GET['unknown'])) {
                        ?>
                            <div class="alert alert-danger rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                                <?php echo $_GET['unknown'], "Unknown error occured."; ?>
                                <a href="topics.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
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
                                            while ($row = $result->fetch_assoc()) {
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
                                                    <a href="https://docs.google.com/viewerng/viewer?url=http://bioquest.rf.gd/modules/' . $filename . '" target="_blank">
                                                        <div class="d-flex align-items-center flex-column topic-card rounded-2 pt-4">
                                                            <i class="bi bi-file-earmark-arrow-down" style="color: #fff; font-size: 65px;"></i>
                                                            <h6 class="topic-title text-center text-white m-4">' . $truncatedTitle . '</h6>
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
                    <div class="modal fade" id="addTopicModal" tabindex="-1" aria-labelledby="addTopicModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-1 bg-dark">
                                <form action="add-topic-check.php" method="post" enctype="multipart/form-data" class="row p-2">
                                    <div class="modal-header">
                                        <h1 class="modal-title text-white fs-5" id="addTopicModalLabel">Add New Topic</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-12 mb-4">
                                            <label for="topic_title">Topic Title</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-collection"></i>
                                                </span>
                                                <input type="text" name="topic_title" class="form-control" id="topic_title" placeholder="Type here..." required />
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label for="fileToUpload">Import Module</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-journal"></i>
                                                </span>
                                                <input type="file" name="fileToUpload" class="form-control" id="fileToUpload" placeholder="Type here..." required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn btn-success" id="loaderButton">
                                            <span id="submitBlank">
                                                <span id="submit">Save</span>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
