<?php
include "../database-connection.php";
session_start();
$id = $_SESSION['id'];
if (
    isset($_FILES['img_url']) && isset($_POST['firstname']) && isset($_POST['middlename'])
    && isset($_POST['lastname']) && isset($_POST['year_level']) && isset($_POST['section'])
    && isset($_POST['email'])
) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $firstname = validate($_POST['firstname']);
    $middlename = validate($_POST['middlename']);
    $lastname = validate($_POST['lastname']);
    $year_level = validate($_POST['year_level']);
    $section = validate($_POST['section']);
    $email = validate($_POST['email']);
    date_default_timezone_set('Asia/Manila');
    $updated_at = date("F j, Y | l - h : i : s a");
    $img_name = $_FILES['img_url']['name'];
    $img_size = $_FILES['img_url']['size'];
    $tmp_name = $_FILES['img_url']['tmp_name'];
    $error = $_FILES['img_url']['error'];

    if ($error === 0) {
        if ($img_size > 1000000) {
            header("Location: profile.php?too_large");
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array("jpg", "jpeg", "png");
            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_url = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../assets/img/profiles/' . $new_img_url;
                move_uploaded_file($tmp_name, $img_upload_path);
                $stmt = $conn->prepare("UPDATE tbl_student SET img_url = ?, updated_at = ? WHERE id = ?");
                $stmt->bind_param('ssi', $new_img_url, $updated_at, $id);
                $stmt->execute();
                $target_dir = "../assets/img/profiles/";
                $target_file = $target_dir . basename($_FILES["img_url"]["name"]);

                header("Location: profile.php?updated_img");
                exit();
            } else {
                header("Location: profile.php?wrong_file_type");
                exit();
            }
        }
    }

    // $stmt = $conn->prepare(" SELECT * FROM tbl_student WHERE firstname = ? AND lastname = ? ");
    // $stmt->bind_param("ss", $firstname, $lastname);
    // $stmt->execute();
    // $result = $stmt->get_result();

    // if (mysqli_num_rows($result) > 0) {
    //     header("Location: profile.php?registered");
    //     exit();
    // }

    $stmt = $conn->prepare("UPDATE tbl_student SET 
                    firstname = ?, middlename = ?, lastname = ?, 
                    year_level = ?, section = ?, email = ?, updated_at = ?
                    WHERE id = ?");
    $stmt->bind_param('sssiissi', $firstname, $middlename, $lastname, $year_level, $section, $email, $updated_at, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    header("Location: profile.php?success");
} else {
    header("Location: profile.php?unknown");
    exit();
}
