<?php
include "../database-connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function validate($data)
    {
        return htmlspecialchars(trim($data));
    }
    $teacher_id = $_SESSION['id'];
    $topic_id = validate($_POST["topic_id"]);
    date_default_timezone_set('Asia/Manila');
    $created_at = date("F j, Y | l - h : i : s a");

    $rowCounter = 0;
    while (
        isset($_POST["lesson_number_$rowCounter"]) &&
        isset($_POST["lesson_title_$rowCounter"]) &&
        isset($_POST["section_title_$rowCounter"]) &&
        isset($_POST["discussion_$rowCounter"])
    ) {
        $lesson_number = validate($_POST["lesson_number_$rowCounter"]);
        $lesson_title = validate($_POST["lesson_title_$rowCounter"]);
        $section_title = validate($_POST["section_title_$rowCounter"]);
        $discussion = validate($_POST["discussion_$rowCounter"]);

        $stmt = $conn->prepare("INSERT INTO tbl_sub_topics
        (topic_id, lesson_number, lesson_title, section_title, discussion, teacher_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('issssis', $topic_id, $lesson_number, $lesson_title, $section_title, $discussion, $teacher_id, $created_at);
        $stmt->execute();

        if ($stmt->error) {
            header("Location: discussion-add.php?id=$topic_id&error=" . urlencode("Error inserting data: {$stmt->error}"));
            exit();
        }
        header("Location: discussion-add.php?id=$topic_id&success");
        $rowCounter++;
    }
} else {
    header("Location: discussion-add.php?id=$topic_id&error=Unknown error occurred.");
    exit();
}
