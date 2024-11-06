<?php
$title = "Forgot Password";
include("includes/header.html");
require("includes/hotel_connect.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php'; 
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

?>

<div class="card">
    <div class="page-header">
            <h1 id="amenities" class="text-center">  Change Password  </h1>
        </div>
    <div class="card-body">
        <form action="forgot_password.php" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <input type="submit" name="password-reset-token" class="btn btn-primary">
        </form>
    </div>
</div>

<?php
if(isset($_POST['password-reset-token']) && $_POST['email']){

    $emailId = $_POST['email'];
 
    $result = mysqli_query($dbc,"SELECT * FROM staf WHERE email='" . $emailId . "'");
 
    $row= mysqli_fetch_array($result);
 
    if($row){
        $token = md5($emailId).rand(10,9999);
    
        $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
 
        $expDate = date("Y-m-d H:i:s",$expFormat);
    
        $update = mysqli_query($dbc,"UPDATE staf set  reset_link_token='" . $token . "' ,exp_date='" . $expDate . "' WHERE email='" . $emailId . "'");
    
        $link = "<a href='http://localhost/hotel/change_password.php?key=".$emailId."&token=".$token."'>Click To Reset password</a>";
    
        $mail = new PHPMailer();
    
        $mail->CharSet =  "utf-8";
        $mail->IsSMTP();
        $mail->SMTPAuth = true;                  
        $mail->Username = "haunted.hotel1234@gmail.com";
        $mail->Password = "brglrcuedyxugvuj";
        $mail->SMTPSecure = "ssl";  
        $mail->Host = "smtp.gmail.com";
        $mail->Port = "465";
        $mail->From='haunted.hotel1234@gmail.com';
        $mail->AddAddress($emailId);
        $mail->Subject  =  'Reset Password';
        $mail->IsHTML(true);
        $mail->Body = 'Click On This Link to Reset Password '.$link.'';

        if($mail->Send()){
            echo "<div class='sukses'> Check Your Email and Click on the link sent to your email </div>";
        }
        else
        {
            echo "Mail Error - >".$mail->ErrorInfo;
        }
    }else{
        echo "Invalid Email Address. Go back";
    }
}
?>