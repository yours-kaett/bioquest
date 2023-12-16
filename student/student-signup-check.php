<?php
include "../database-connection.php";
session_start();

// Send email using PHPMailer library
// require '../src/PHPMailer.php';
// require '../src/SMTP.php';
// require '../src/Exception.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

if (isset($_POST['email']) && isset($_POST['student_id']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $email = validate($_POST['email']);
    $student_id = validate($_POST['student_id']);
    $password = validate($_POST['password']);
    $firstname = "empty-first_name";
    $middlename = "empty-middle_name";
    $lastname = "empty-last_name";
    $year_level = 5;
    $section = 5;
    $img_url = "default.jpg";
    date_default_timezone_set('Asia/Manila');
    $created_at = date("F j, Y | l - h : i : s a");
    
    $stmt = $conn->prepare(" SELECT * FROM tbl_student WHERE student_id = ? ");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        header("Location: student-signup.php?registered");
        exit();
    } else {

        $password = md5($password);
        $acccount_status = 2 //Pending
        $stmt = $conn->prepare("INSERT INTO tbl_student (email, student_id, password, firstname, middlename, lastname, year_level, section, img_url, acccount_status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
        $stmt->bind_param('ssssssiisis',$email, $student_id, $password, $firstname, $middlename, $lastname, $year_level, $section, $img_url, $acccount_status, $created_at);
        $stmt->execute();
        $result = $stmt->get_result();

        
        header("Location: student-signup.php?success");
        exit();
        // $mail = new PHPMailer(true);
        // try {
        //     // SMTP configuration
        //     $mail->isSMTP();
        //     $mail->Host = 'smtp.gmail.com';
        //     $mail->SMTPAuth = true;
        //     $mail->Username = 'christianschool.main@gmail.com';
        //     $mail->Password = 'lhkvevgaglyugygu';
        //     $mail->SMTPSecure = 'tls';
        //     $mail->Port = 587;

        //     // Email content
        //     date_default_timezone_set('Asia/Manila');
        //     $datetime = date("F j, Y - l")." | ".date("h : i : s a");
        //     $recipient = 'kentanthony2022@gmail.com';
        //     $subject = 'Account Creation';
        //     $message = "New Account has been added to the system on $datetime. \n \n";
        //     $message .= "Email: " . $email . "\n";
        //     $message .= "Username: " . $username . "\n";
        //     $message .= "Password: " . $password . "\n \n";
        //     $message .= "Note: Make sure to save the credentials for future purposes.";
        //     $mail->setFrom('christianschool.main@gmail.com', 'Dreamers');
        //     $mail->addAddress($recipient);
        //     $mail->Subject = $subject;
        //     $mail->Body = $message;
        //     $mail->send();
        // }
        // catch (Exception $e) {
        //     echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
        // }
    }
} else {
    header("Location: student-signup.php");
    exit();
}
