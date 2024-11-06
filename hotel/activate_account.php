<?php
$title = "Activate Account";
include('includes/header.html');
require 'includes/hotel_connect.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM inactive_staf WHERE id=$id"; 
    $r = mysqli_query($dbc, $sql); 
    $row = mysqli_fetch_assoc($r);
    $sql = "INSERT INTO staf(fname, lname, email, pass, tel, roli, profile_pic) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_prepare($dbc, $sql);
    mysqli_stmt_bind_param($stmt,'sssssss', $row['emer'], $row['mbiemer'], $row['email'], $row['pass'], $row['phone_number'], $row['roli'], $row['profile_pic']);
    if(!mysqli_stmt_execute($stmt)){
        echo "<div class='error'> Error inserting staff data </div>";
        exit();
    }else{
        $sql = "DELETE FROM inactive_staf WHERE id=$id";
        $r = mysqli_query($dbc, $sql); 
        // header("location: login.php");
    }
}
?>
<script>
    $(jQuery).ready(function(){
        alert("Account confirmed! Click OK to continue to login.");
        window.location.href = "login.php";
    });
</script>
