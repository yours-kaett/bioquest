<?php
session_start();
include "../database-connection.php";
if (isset($_POST['student_id']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $student_id = validate($_POST['student_id']);
    $password = validate($_POST['password']);
    $password = md5($password);
    try {

        $stmt = $conn->prepare("SELECT * FROM tbl_student WHERE student_id = ? AND password = ?");
        $stmt->bind_param("ss", $student_id, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $account_status_id = $row['account_status_id'];

        if ($account_status_id == 1) {
            header("Location: student-login.php?pending");
            exit();
        } else if ($account_status_id == 2) {
            if ($row['student_id'] === $student_id && $row['password'] === $password) {
                $_SESSION['id'] = $row['id'];
                date_default_timezone_set('Asia/Manila');
                $date = date("F j, Y | l - h : i : s a");
                $activity_logs = "You logged in on $date ";
                $stmt = $conn->prepare(' INSERT INTO tbl_student_logs (activity_logs, student_id) VALUES (?, ?) ');
                $stmt->bind_param('si', $activity_logs, $_SESSION['id']);
                $stmt->execute();
                header("Location: student-dashboard.php");
                exit();

            }
        } else {
            header("Location: student-login.php?invalid");
            exit();
        }
    } catch (Exception $e) {
        header("Location: student-login.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: student-login.php?error=Unknown error occured.");
    exit();
}
