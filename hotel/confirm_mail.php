<?php
$title = "Activate Account";
include('includes/header.html');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php'; 
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $sql = "select id from inactive_staf where email='$email'";
    $r = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($r);
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = 'true'; 
    $mail->Username = 'haunted.hotel1234@gmail.com';
    $mail->Password = 'brglrcuedyxugvuj';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
        
    $mail->setFrom('haunted.hotel1234@gmail.com');
        
    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = 'Account Confirmation.';

    $msg = "Please verify your account by clicking the following link: <a href='localhost/hotel/activate_account.php?id={$row['id']}'>Click Here</a>";

    $mail->Body = $msg; 

    $mail->send();

    if(isset($_SESSION['emp_id'])){
        header('location: view_reservations.php');
    }
}

?>