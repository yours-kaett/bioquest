<?php
include "../database-connection.php";
session_start();

date_default_timezone_set('Asia/Manila');
$date = date("F j, Y | l - h : i : s a");
$activity_logs = "You logged out on $date ";
$stmt = $conn->prepare(' INSERT INTO tbl_student_logs (activity_logs, student_id) VALUES (?, ?) ');
$stmt->bind_param('si', $activity_logs, $_SESSION['id']);
$stmt->execute();

session_unset();
session_destroy();
header("Location: ../index.php");
?>