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
        if (!$stmt) {
            throw new Exception("Database query error: " . $conn->error);
        }
        $stmt->bind_param("ss", $student_id, $password);
        if (!$stmt->execute()) {
            throw new Exception("Database query execution failed.");
        }
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
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
            } else {
                header("Location: student-login.php?wrong");
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
