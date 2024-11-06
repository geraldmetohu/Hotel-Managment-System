<?php
$title = "Reservation Complete";
include('includes/header.html');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php'; 
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'includes/hotel_connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $fName = $_POST['first_name'];
    $lName = $_POST['last_name'];
    $tel = $_POST['phone'];
    $email = $_POST['email'];
    
    $roomID = $_POST['roomID'];
    $resDate = date("Y-m-d");
    $arrival = $_POST['arrival'];
    $departure = $_POST['departure']; 
    $guests = $_POST['adults'];
    $price = $_POST['price'];

    $q = "SELECT clientID from klient WHERE email = '$email'";
    $r = mysqli_query($dbc, $q); 
    $row = mysqli_fetch_assoc($r);

    if(!isset($row['clientID'])){
        $sql = "INSERT INTO klient(name, lName, tel, email) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($dbc, $sql);
        mysqli_stmt_bind_param($stmt,'ssss', $fName, $lName, $tel, $email);
        if(!mysqli_stmt_execute($stmt)){
            echo "<div class='error'> Error inserting client data </div>";
            exit();
        }else{
            $q_after = "SELECT clientID from klient WHERE email = '$email'";
            $r_after = mysqli_query($dbc, $q); 
            $row = mysqli_fetch_assoc($r_after);
        }
    }
    
    $sql = "INSERT INTO rezervim(roomID, clientID, resDate, checkIn, checkOut, guests, price) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_prepare($dbc, $sql);
    mysqli_stmt_bind_param($stmt,'iisssid', $roomID, $row['clientID'],$resDate, $arrival, $departure, $guests, $price);
    if(mysqli_stmt_execute($stmt)){
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

        $mail->Subject = 'Reservation Confirmation.';

        $msg = "Thank you for choosing our hotel. Your reservation is under the name: $fName $lName. Room number: $roomID for the dates: $arrival to $departure. 
                    If you wish to cancel, please reply to this email. ";
        $mail->Body = $msg; 

        $mail->send();
        echo "<div class='sukses'> Reservation Complete! Check email for confirmation. </div>";
        if(isset($_SESSION['emp_id'])){
            header('location: view_reservations.php');
        }
    }else{
        echo "<div class='error'> Error inserting reservation data </div>";
    }
}

?>