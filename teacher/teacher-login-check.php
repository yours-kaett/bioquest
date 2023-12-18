<?php
session_start();
include "../database-connection.php";
if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $password = md5($password);
    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_teacher WHERE username = ? AND password = ?");
        if (!$stmt) {
            throw new Exception("Database query error: " . $conn->error);
        }
        $stmt->bind_param("ss", $username, $password);
        if (!$stmt->execute()) {
            throw new Exception("Database query execution failed.");
        }
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($row['username'] === $username && $row['password'] === $password) {
                
                $_SESSION['id'] = $row['id'];
                date_default_timezone_set('Asia/Manila');
                $date = date("F j, Y | l - h : i : s a");
                $activity_logs = "You logged in on $date ";
                $stmt = $conn->prepare(' INSERT INTO tbl_teacher_logs (activity_logs, teacher_id) VALUES (?, ?) ');
                $stmt->bind_param('si', $activity_logs, $_SESSION['id']);
                $stmt->execute();

                header("Location: teacher-dashboard.php");
                exit();
            }
        } else {
            header("Location: teacher-login.php?invalid");
            exit();
        }
    } catch (Exception $e) {
        header("Location: teacher-login.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: teacher-login.php?error=Unknown error occured.");
    exit();
}
