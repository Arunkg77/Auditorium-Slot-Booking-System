<?php

require_once('db-connect.php');
require 'php_mailer/src/Exception.php';
require 'php_mailer/src/PHPMailer.php';
require 'php_mailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    displayErrorAndRedirect('Error: No data to save.');
}


extract($_POST);

$allday = isset($allday);

function isSlotBooked($conn, $start_datetime, $end_datetime)
{
    $checkSql = "SELECT * FROM `schedule_list` WHERE (? BETWEEN `start_datetime` AND `end_datetime`) OR (? BETWEEN `start_datetime` AND `end_datetime`)";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param('ss', $start_datetime, $end_datetime); 
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    return $result->num_rows > 0;
}

$token = bin2hex(random_bytes(16));

session_start();
$_SESSION['schedule_data'] = compact('title', 'description', 'start_datetime', 'end_datetime', 'token');

try {
    if (isSlotBooked($conn,$start_datetime, $end_datetime)) {
        echo "<script> alert('The slot is already booked. Please choose another slot.'); location.replace('./') </script>";
        exit();
    }
    if($start_datetime>$end_datetime)
    {
        echo "<script> alert('Please enter a valid start and end time'); location.replace('./') </script>";
    }
    else{
    
    sendConfirmationEmail($title, $description, $start_datetime, $end_datetime, $token);

    displaySuccessAndRedirect('Schedule submitted for approval, and confirmation email sent.');
    }
} catch (Exception $e) {
    displayErrorAndRedirect('Error occurred while sending confirmation email.');
} finally {
    
    if (isset($conn)) {
        $conn->close();
    }
}

function sendConfirmationEmail($title, $description, $start_datetime, $end_datetime, $token) {
   
    $mail = new PHPMailer(true);

    configureSMTP($mail);

    
    $mail->setFrom('arunkgudagi77@gmail.com', 'arun Name');
    $mail->addAddress('arunkgudagi77@gmail.com');

    $mail->Subject = 'Auditorium Slot Booking Confirmation Needed';
    $confirmation_link = generateConfirmationLink($token, $title, $description, $start_datetime, $end_datetime);
    $mail->Body = getEmailBody($title, $description, $start_datetime, $end_datetime, $confirmation_link);

    $mail->isHTML(true);
    $mail->send();
}

function configureSMTP(PHPMailer $mail) {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'arunkgudagi77@gmail.com';
    $mail->Password = 'rxlemfklgwehkifp';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
}

function generateConfirmationLink($token, $title, $description, $start_datetime, $end_datetime) {
    return "http://localhost:8081/schedule/confirm.php?token=$token&title=$title&description=$description&start_datetime=$start_datetime&end_datetime=$end_datetime";
}

function getEmailBody($title, $description, $start_datetime, $end_datetime, $confirmation_link) {
    return "
    <!DOCTYPE html>

    <head>
     
        <title>New Schedule Submission</title>
        <style>  
            a {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007bff;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
            }
    
            a:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <p>A new schedule has been submitted for approval:</p>
        <ul>
            <li><strong>Title:</strong> $title</li>
            <li><strong>Description:</strong> $description</li>
            <li><strong>Start Datetime:</strong> $start_datetime</li>
            <li><strong>End Datetime:</strong> $end_datetime</li>
        </ul>
        <p>Please click on the following link to confirm this booking:</p>
        <a href='$confirmation_link'>Confirm Booking</a>
    </body>
    </html>
    
    
    ";
}


function displayErrorAndRedirect($errorMessage) {
    echo "<script> alert('$errorMessage'); location.replace('./') </script>";
    exit;
}

function displaySuccessAndRedirect($successMessage) {
    echo "<script> alert('$successMessage'); location.replace('./') </script>";
    exit;
}

?>
