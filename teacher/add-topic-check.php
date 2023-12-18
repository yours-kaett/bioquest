<?php
include "../database-connection.php";
session_start();

if ((isset($_POST['topic_title'])) && isset($_POST['module'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $topic_title = validate($_POST['topic_title']);
    $module = validate($_POST['module']);
    $teacher_id = $_SESSION['id'];
    date_default_timezone_set('Asia/Manila');
    $created_at = date("F j, Y | l - h : i : s a");
    
    $stmt = $conn->prepare(" SELECT * FROM tbl_topics WHERE topic_title = ? ");
    $stmt->bind_param("s", $topic_title);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        header("Location: topics.php?warning");
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO tbl_topics (topic_title, teacher_id, created_at) 
        VALUES (?, ?, ?) ");
        $stmt->bind_param('sis', $topic_title, $teacher_id, $created_at);
        $stmt->execute();
        header("Location: topics.php?success");
        exit();
        
    }
} else {
    header("Location: topics.php");
    exit();
}
