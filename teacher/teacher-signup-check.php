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

if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])&& isset($_POST['auth_code'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $email = validate($_POST['email']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $my_auth_code = validate($_POST['auth_code']);
    $firstname = "first_name";
    $middlename = "middle_name";
    $lastname = "last_name";
    $img_url = "default.jpg";
    date_default_timezone_set('Asia/Manila');
    $created_at = date("F j, Y | l - h : i : s a");
    
    $stmt = $conn->prepare(" SELECT * FROM tbl_teacher WHERE username = ? ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        header("Location: teacher-signup.php?warning");
        exit();
    } else {
        $stmt = $conn->prepare(" SELECT auth_code FROM tbl_admin ");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $auth_code = $row['auth_code'];
        if ($my_auth_code !== $auth_code) {
            header("Location: teacher-signup.php?invalid");
            exit();
        } else {
            $password = md5($password);
            $stmt = $conn->prepare("INSERT INTO tbl_teacher (email, username, password, firstname, middlename, lastname, img_url, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");
            $stmt->bind_param('ssssssss', $email, $username, $password, $firstname, $middlename, $lastname, $img_url, $created_at);
            $stmt->execute();

            header("Location: teacher-signup.php?success");
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
    }
} else {
    header("Location: teacher-signup.php");
    exit();
}
