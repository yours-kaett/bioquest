<?php
include "../database-connection.php";
session_start();

if (isset($_SESSION['id'])) {
    $id = $_GET['id'];
    $requested = 1;
    $stmt = $conn->prepare('UPDATE tbl_student SET account_status_id = ? WHERE id = ?');
    $stmt->bind_param('ii', $requested, $id);
    if ($stmt->execute()) {
        header("Location: students-masterlist.php?updated_account_status");
        exit();
    } else {
        header("Location: students-masterlist.php?unable");
        exit();
    }
} else {
    header("Location: modify-quiz.php?unknown");
    exit();
}
