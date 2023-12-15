<?php
include '../database-connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
    $student_id = $_SESSION['id'];
    $room_number = $_GET['id'];
    $stmt = $conn->prepare(' SELECT * FROM tbl_quiz_student WHERE room_number = ? ');
    $stmt->bind_param('i', $room_number);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($rows = $result->fetch_assoc()) {
        $stmt = $conn->prepare(' UPDATE tbl_quiz_student SET student_answer = ? WHERE item_number = ? AND room_number = ? AND student_id = ? ');
        foreach ($_POST['answers'] as $item_number => $selected_answer) {
            $stmt->bind_param('siii', $selected_answer, $item_number, $room_number, $_SESSION['id']);
            $stmt->execute();
        }
    }

    $stmt = $conn->prepare(' SELECT * FROM tbl_quiz_student WHERE room_number = ? AND student_id = ? ORDER BY item_number ASC');
    $stmt->bind_param('ii', $room_number, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($rows = $result->fetch_assoc()) {
        $item_number = $rows['item_number'];
        $question = $rows['question'];
        $choice1 = $rows['choice1'];
        $choice2 = $rows['choice2'];
        $choice3 = $rows['choice3'];
        $choice4 = $rows['choice4'];
        $correct_answer = $rows['correct_answer'];
        $student_answer = $rows['student_answer'];
        $total_items = mysqli_num_rows($result);
        if ($student_answer !== '' && $student_answer === $correct_answer) {
            $score += 1;
        } else {
            $score += 0;
        }
    }

    $stmt = $conn->prepare(' SELECT img_url FROM tbl_student WHERE id = ? ');
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $img_url = $row['img_url'];

    $stmt = $conn->prepare(' INSERT INTO tbl_quiz_ranking (room_number, score, student_id, img_url) VALUES (?, ?, ?, ?) ');
    $stmt->bind_param('iiis', $room_number, $score, $student_id, $img_url);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();
    header('Location: quiz-result.php?room_number=' . $room_number . '');
    exit();
} else {
    header('Location: quiz-result.php?room_number=' . $room_number . '');
    exit();
}
