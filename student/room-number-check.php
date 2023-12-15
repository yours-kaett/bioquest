<?php
include "../database-connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $student_session_id = $_SESSION['id'];
    function validate($data)
    {
        return htmlspecialchars(trim($data));
    }
    $room_number = validate($_POST['room_number']);
    $student_session_id = $_SESSION['id'];

    $stmt = $conn->prepare(' SELECT room_number, student_id, student_answer FROM tbl_quiz_student WHERE room_number = ? AND student_id = ? ');
    $stmt->bind_param('ii', $room_number, $student_session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();
    if (!empty($rows['student_answer'])) {
        header("Location: room-number.php?done");
        exit();
    }

    $stmt = $conn->prepare(' SELECT year_level, section, id FROM tbl_student WHERE id = ? ');
    $stmt->bind_param('i', $student_session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();
        $year_level = $row['year_level'];
        $section_id = $row['section'];
        $stmt = $conn->prepare(' SELECT year_level, section_id, room_number FROM tbl_quiz WHERE year_level = ? AND section_id = ? AND room_number = ? ');
        $stmt->bind_param('iii', $year_level, $section_id, $room_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $room_number = $row['room_number'];
        if (mysqli_num_rows($result) > 0) {
            header("Location: quiz-level.php?room_number=" . $room_number . "");
        } else {
            header("Location: room-number.php?notfound");
            exit();
        }
    }

} else {
    header("Location: room-number.php?unknown");
    exit();
}
