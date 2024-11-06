<?php
$title = "Change your password";
include('includes\header.html');

if($_SERVER['REQUEST_METHOD']=='POST'){
    require('includes/hotel_connect.php');
    $errors = [];

    if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	}else {
		$e = mysqli_real_escape_string($dbc,trim($_POST['email']));
    }

    if(!isset($_SESSION['user'])){
        if(empty($_POST['pass'])){
            $errors[] = 'You forgot to enter your current password.';
        }else {
            $p = mysqli_real_escape_string($dbc,trim($_POST['pass']));
        }
    }else{
        $p = mysqli_real_escape_string($dbc,trim($_POST['pass']));
    }

    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Your password did not match the confirmed password.';
        } else {
            $np = mysqli_real_escape_string($dbc,trim($_POST['pass1']));
        }
    } else {
        $errors[] = 'You forgot to enter a new password.';
    }

    if(empty($errors)){
        if(empty($p)){
            $q = "SELECT staffID FROM staf WHERE (email='$e')";
        }else{
            $q = "SELECT staffID FROM staf WHERE (email='$e' AND pass=SHA2('$p', 512))";
        }
        $r = @mysqli_query($dbc, $q);
        $num = mysqli_num_rows($r);
        if($num == 1){
            $row = mysqli_fetch_array($r, MYSQLI_NUM);
            $q = "UPDATE staf SET pass=SHA2('$np',512) WHERE staffID=$row[0]";
            $r = @mysqli_query($dbc, $q);
            if(mysqli_affected_rows($dbc) == 1){
                echo "<div class='sukses'>Your password has been changed.</div>";
                header("location: view_profile.php");
            }else{
                echo '<div class="error"> Your password could not be changed due to a system error.<br>
                We apologize for any inconvenience.</div>';
            }
            mysqli_close($dbc);
            include ('includes\footer.html');
            exit();
        }else {
            echo "<div class='error'>The email address and password do not match those on file.</div>";
        }
    }else{
        echo "<div class='error'>$errors[0]</div>";
    }
    mysqli_close($dbc);
}
?>
<div class="starter-template">
    <div class="page-header">
        <h1 id="amenities" class="text-center">  Change Password  </h1>
    </div>
<form action="reset_password.php" method="POST">
    <div class="controls col-md-12">
        <label class="form-label" for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control form-control-lg" required value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"/>
    </div>

    <div class="controls col-md-12">
        <label class="form-label" for="pass">Current Password</label>
        <input type="password" id="pass" name="pass" class="form-control form-control-lg" value="<?php if(isset($_POST['pass'])) echo $_POST['pass']; ?>"/>
    </div> 

    <div class="controls col-md-12">
        <label class="form-label" for="pass1">New Password</label>
        <input type="password" id="pass1" name="pass1" class="form-control form-control-lg" required value="<?php if(isset($_POST['pass1'])) echo $_POST['pass1']; ?>"/>
    </div> 

    <div class="controls col-md-12">
        <label class="form-label" for="pass2">Confirm New Password</label>
        <input type="password" id="pass2" name="pass2" class="form-control form-control-lg" required value="<?php if(isset($_POST['pass2'])) echo $_POST['pass2']; ?>"/>
    </div> 

    <div class="controls col-md-12">
        <br>
        <button class="btn btn-info" type="submit" name="submit" value="Change Password">Change Password </button>
        <?php 
        if(isset($_SESSION['emp_id'])){
           echo ' <a class="btn btn-default" href="user_settings.php">Cancel</a> ';
        }else{
           echo ' <a class="btn btn-default" href="login.php">Cancel</a> ';
        }
        ?>
    </div>
</form>
<?php include ('includes\footer.html');?>