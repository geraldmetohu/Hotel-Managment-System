<?php
$title = "Forgot Password";
include('includes/header.html');
if(isset($_POST['password']) && $_POST['reset_link_token'] && $_POST['email']){
    require "includes/hotel_connect.php";
    $emailId = $_POST['email'];
    $token = $_POST['reset_link_token'];
    $password = $_POST['password'];
    $query = mysqli_query($dbc,"SELECT * FROM `staf` WHERE `reset_link_token`='".$token."' and `email`='".$emailId."'");
    $row = mysqli_num_rows($query);
    if($row){
        mysqli_query($dbc,"UPDATE staf set  pass=SHA2('".$password."',512), reset_link_token='" . NULL . "' ,exp_date='" . NULL . "' WHERE email='" . $emailId . "'");
        if(mysqli_affected_rows($dbc) == 1){
            echo "<div class='sukses'> Your password has been updated successfully. <br> <a href='login.php'> Go to Login </a> </div>";
        }else{
            echo "<div class='error'>Something went wrong.</div>";
        }
    }
}
?>