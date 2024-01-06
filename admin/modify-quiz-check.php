<?php
include "../database-connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function validate($data)
    {
        return htmlspecialchars(trim($data));
    }
    $year_level = validate($_POST["year_level"]);
    $section_id = validate($_POST["section_id"]);
    $room_number = validate($_POST["room_number"]);
    $direction = validate($_POST["direction"]);
    date_default_timezone_set('Asia/Manila');
    $created_at = date("F j, Y | l - h : i : s a");
    $updated_at = date("F j, Y | l - h : i : s a");

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

        $item_number = validate($_POST["item_number_$rowCounter"]);
        $question = validate($_POST["question_$rowCounter"]);
        $choice1 = validate($_POST["choice1_$rowCounter"]);
        $choice2 = validate($_POST["choice2_$rowCounter"]);
        $choice3 = validate($_POST["choice3_$rowCounter"]);
        $choice4 = validate($_POST["choice4_$rowCounter"]);
        $correct_answer = validate($_POST["correct_answer_$rowCounter"]);

        $stmt = $conn->prepare(
            "INSERT INTO tbl_quiz 
        (year_level, section_id, room_number, direction, item_number, question, choice1, choice2, choice3, choice4, correct_answer, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('iiisissssssss', $year_level, $section_id, $room_number, $direction, $item_number, $question, $choice1, $choice2, $choice3, $choice4, $correct_answer, $created_at, $updated_at);
        $stmt->execute();

        if ($stmt->error) {
            header("Location: modify-quiz.php?error");
            exit();
        }

        $rowCounter++;
    }

    header("Location: quizes.php?updated");
    exit();
} else {
    header("Location: modify-quiz.php?unknown");
    exit();
}
