<?php
include('../database-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    $student_id = $_SESSION['id'];
    $stmt = $conn->prepare(' SELECT 
    tbl_student.id,
    tbl_student.email,
    tbl_student.firstname,
    tbl_student.middlename,
    tbl_student.lastname,
    tbl_year_level.year_level,
    tbl_section.section,
    tbl_student.img_url
    FROM tbl_student
    INNER JOIN tbl_year_level ON tbl_student.year_level = tbl_year_level.id
    INNER JOIN tbl_section ON tbl_student.section = tbl_section.id
    WHERE tbl_student.id = ? ');
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $firstname = $row['firstname'];
    $middlename = $row['middlename'];
    $lastname = $row['lastname'];
    $year_level = $row['year_level'];
    $section = $row['section'];
    $img_url = $row['img_url'];

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
                <main id="main" class="main">
                    <div class="pagetitle">
                        <h1>Profile</h1>
                        <nav style="--bs-breadcrumb-divider: '•';">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">BioQuest</li>
                                <li class="breadcrumb-item">Profile</li>
                            </ol>
                        </nav>
                    </div>

                    <section class="section profile">
                        <div class="row">
                            <div class="col-xl-8">
                                <?php
                                if (isset($_GET['too_large'])) {
                                ?>
                                    <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                        <?php echo $_GET['too_large'], "Sorry, your file is too large."; ?>
                                        <a href="profile.php">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </a>
                                    </div>
                                <?php
                                }
                                if (isset($_GET['updated_img'])) {
                                ?>
                                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                        <?php echo $_GET['updated_img'], "Profile picture updated successfully."; ?>
                                        <a href="profile.php">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </a>
                                    </div>
                                <?php
                                }
                                if (isset($_GET['wrong_file_type'])) {
                                ?>
                                    <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                        <?php echo $_GET['wrong_file_type'], "You can't upload files with this type."; ?>
                                        <a href="profile.php">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </a>
                                    </div>
                                <?php
                                }
                                if (isset($_GET['registered'])) {
                                ?>
                                    <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                        <?php echo $_GET['registered'], "Student name is already registered."; ?>
                                        <a href="profile.php">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </a>
                                    </div>
                                <?php
                                }
                                if (isset($_GET['unknown'])) {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                        <?php echo $_GET['unknown'], "Unknown error occured"; ?>
                                        <a href="profile.php">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </a>
                                    </div>
                                <?php
                                }
                                if (isset($_GET['success'])) {
                                ?>
                                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                        <?php echo $_GET['success'], "Account updated successfully."; ?>
                                        <a href="profile.php">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="card">
                                    <div class="card-body pt-3">
                                        <ul class="nav nav-tabs nav-tabs-bordered">
                                            <li class="nav-item">
                                                <button class="nav-link active text-success" data-bs-toggle="tab" data-bs-target="#profile-overview">Profile Details</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="nav-link text-success" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                                    Profile</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="nav-link text-success" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                            </li>
                                        </ul>

                                        <div class="tab-content pt-2">
                                            <div class="tab-pane fade show active profile-overview pt-3" id="profile-overview">
                                                <form action="">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-4 label"><label>Full Name</label></div>
                                                        <div class="col-lg-9 col-md-8 text-white fw-bold"><?php echo $firstname . " " . $middlename . " " . $lastname ?></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-4 label"><label>Year</label></div>
                                                        <div class="col-lg-9 col-md-8 text-white fw-bold"><?php echo $year_level ?></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-4 label"><label>Section</label></div>
                                                        <div class="col-lg-9 col-md-8 text-white fw-bold"><?php echo $section ?></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-4 label"><label>Email</label></div>
                                                        <div class="col-lg-9 col-md-8 text-white fw-bold"><?php echo $email ?></div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                                <form action="profile-update-check.php" method="POST" enctype="multipart/form-data">
                                                    <div class="row mb-3">
                                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <img src="../assets/img/profiles/<?= $img_url ?>" width="120" height="120" alt="Profile" style="border-radius: 50%;" id="uploadedImg">
                                                            <div class="pt-2">
                                                                <label for="upload" class="btn btn-primary btn-sm" tabindex="0">
                                                                    <span class="d-none d-sm-block text-white">
                                                                        <i class="bi bi-upload"></i></i>&nbsp;Upload
                                                                    </span>
                                                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                                                    <input name="img_url" type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                                                </label>
                                                                <button class="btn btn-danger btn-sm image-reset" type="button" title="Remove profile image"><i class="bi bi-trash"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="firstname" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="firstname" type="text" class="form-control" id="firstname" value="<?php echo $firstname ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="middlename" class="col-md-4 col-lg-3 col-form-label">Middle Name</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="middlename" type="text" class="form-control" id="middlename" value="<?php echo $middlename ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="lastname" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="lastname" type="text" class="form-control" id="lastname" value="<?php echo $lastname ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="year_level" class="col-md-4 col-lg-3 col-form-label">Year Level</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <?php
                                                            $stmt = $conn->prepare('SELECT * FROM tbl_year_level WHERE year_level = ?');
                                                            $stmt->bind_param('i', $year_level);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            $row = $result->fetch_assoc();
                                                            $year_level_id = $row['id'];
                                                            ?>
                                                            <select name="year_level" id="year_level" class="form-control">
                                                                <option value="<?php echo $year_level_id ?>"><?php echo $year_level ?></option>
                                                                <?php
                                                                $stmt = $conn->prepare('SELECT * FROM tbl_year_level');
                                                                $stmt->execute();
                                                                $result = $stmt->get_result();
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row['id'];
                                                                    $year_level = $row['year_level'];
                                                                    echo '<option value=" ' . $id . ' ">' . $year_level . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="section" class="col-md-4 col-lg-3 col-form-label">Section</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <?php
                                                            $stmt = $conn->prepare('SELECT * FROM tbl_section WHERE section = ?');
                                                            $stmt->bind_param('i', $section);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            $row = $result->fetch_assoc();
                                                            $section_id = $row['id'];
                                                            ?>
                                                            <select name="section" id="section" class="form-control">
                                                                <option value="<?php echo $section_id ?>"><?php echo $section ?></option>
                                                                <?php
                                                                $stmt = $conn->prepare('SELECT * FROM tbl_section');
                                                                $stmt->execute();
                                                                $result = $stmt->get_result();
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row['id'];
                                                                    $section = $row['section'];
                                                                    echo '<option value=" ' . $id . ' ">' . $section . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="email" type="text" class="form-control" id="email" value="<?php echo $email ?>">
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                                <form>
                                                    <div class="row mb-3">
                                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="password" type="password" class="form-control" id="currentPassword">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                            Password</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="newpassword" type="password" class="form-control" id="newPassword">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter
                                                            New Password</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-primary">Change Password</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                        <img src="../assets/img/profiles/<?php echo $img_url ?>" alt="Profile" class="rounded-circle">
                                        <h5 class="text-white mt-3 fw-bold"><?php echo $firstname . " " . $middlename . " " . $lastname ?></h5>
                                        <h3 class="text-secondary mt-2">Student</h3>
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
            document.addEventListener('DOMContentLoaded', function(e) {
                (function() {
                    let accountUserImage = document.getElementById('uploadedImg');
                    const fileInput = document.querySelector('.account-file-input'),
                        resetFileInput = document.querySelector('.image-reset');
                    if (accountUserImage) {
                        const resetImage = accountUserImage.src;
                        fileInput.onchange = () => {
                            if (fileInput.files[0]) {
                                accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                            }
                        };
                        resetFileInput.onclick = () => {
                            fileInput.value = '';
                            accountUserImage.src = resetImage;
                        };
                    }
                })();
            });
        </script>

    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
}
