<?php
include('../database-connection.php');
session_start();

if (isset($_SESSION['id'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $get_room_number = $_GET['room_number'];
        $room_number = $_POST['room_number'];
        $section_id = $_POST['section_id'];
        $direction = $_POST['direction'];
        date_default_timezone_set('Asia/Manila');

        $stmt = $conn->prepare('UPDATE tbl_quiz SET section_id = ?, direction = ?, room_number = ? WHERE room_number = ? ');
        $stmt->bind_param('isii', $section_id, $direction, $room_number, $get_room_number);
        $stmt->execute();

        $rowCounter = 0;
        while (
            isset($_POST["item_number_$rowCounter"]) &&
            isset($_POST["question_$rowCounter"]) &&
            isset($_POST["choice1_$rowCounter"]) &&
            isset($_POST["choice2_$rowCounter"]) &&
            isset($_POST["choice3_$rowCounter"]) &&
            isset($_POST["choice4_$rowCounter"]) &&
            isset($_POST["correct_answer_$rowCounter"])
        ) {

            $item_number = $_POST["item_number_$rowCounter"];
            $question = $_POST["question_$rowCounter"];
            $choice1 = $_POST["choice1_$rowCounter"];
            $choice2 = $_POST["choice2_$rowCounter"];
            $choice3 = $_POST["choice3_$rowCounter"];
            $choice4 = $_POST["choice4_$rowCounter"];
            $correct_answer = $_POST["correct_answer_$rowCounter"];
            $updated_at = date("F j, Y | l - h:i:s a");

            // Use a different variable for each prepared statement
            $updateStmt = $conn->prepare('UPDATE tbl_quiz SET 
                item_number = ?, question = ?, choice1 = ?, choice2 = ?, choice3 = ?, choice4 = ?, 
                correct_answer = ?, updated_at = ? 
                WHERE room_number = ? AND item_number = ?');

            $updateStmt->bind_param(
                'isssssssii',
                $item_number,
                $question,
                $choice1,
                $choice2,
                $choice3,
                $choice4,
                $correct_answer,
                $updated_at,
                $get_room_number,
                $item_number
            );
            $updateStmt->execute();

            if ($updateStmt->error) {
                header("Location: modify-quiz.php?error");
                exit();
            }

            $rowCounter++;
        }

        header("Location:quizes.php?updated");
        exit();
    }
} else {
    header("Location: ../index.php");
}
