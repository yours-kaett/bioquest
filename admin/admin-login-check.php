<?php
session_start();
include "../database-connection.php";
if (isset($_POST['admin_id']) && isset($_POST['auth_code'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $admin_id = validate($_POST['admin_id']);
    $admin_id = md5($admin_id);
    $auth_code = validate($_POST['auth_code']);
    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE admin_id = ? AND auth_code = ?");
        if (!$stmt) {
            throw new Exception("Database query error: " . $conn->error);
        }
        $stmt->bind_param("ss", $admin_id, $auth_code);
        if (!$stmt->execute()) {
            throw new Exception("Database query execution failed.");
        }
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($admin_id  === $row['admin_id'] && $auth_code === $row['auth_code']) {
                
                $_SESSION['id'] = $row['id'];
                date_default_timezone_set('Asia/Manila');
                $date = date("F j, Y | l - h : i : s a");
                $activity_logs = "You logged in on $date ";
                $stmt = $conn->prepare(' INSERT INTO tbl_admin_logs (activity_logs, admin_id) VALUES (?, ?) ');
                $stmt->bind_param('si', $activity_logs, $_SESSION['id']);
                $stmt->execute();

                header("Location: dashboard.php");
                exit();
            }
        } else {
            header("Location: admin-login.php?invalid");
            exit();
        }
    } catch (Exception $e) {
        header("Location: admin-login.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: admin-login.php?error=Unknown error occured.");
    exit();
}
