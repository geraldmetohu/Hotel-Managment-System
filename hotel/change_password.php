<?php 
$title = "Set New Password"; 
include ('includes/header.html');
?>
<div class="card">
    <div class="page-header">
        <h1 id="amenities" class="text-center">  Set New Password  </h1>
    </div>
<div class="card-body">

<?php
if($_GET['key'] && $_GET['token']){
    require "includes/hotel_connect.php";
    $email = $_GET['key'];
    $token = $_GET['token'];
    $query = mysqli_query($dbc,
    "SELECT * FROM `staf` WHERE `reset_link_token`='".$token."' and `email`='".$email."';"
    );
    $curDate = date("Y-m-d H:i:s");
    if (mysqli_num_rows($query) > 0) {
        $row= mysqli_fetch_array($query);
        if($row['exp_date'] >= $curDate){ 
?>
            <form action="update-forget-password.php" method="post">
                <input type="hidden" name="email" value="<?php echo $email;?>">
                <input type="hidden" name="reset_link_token" value="<?php echo $token;?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" name='password' class="form-control">
                </div>                
                <div class="form-group">
                    <label for="exampleInputEmail1">Confirm Password</label>
                    <input type="password" name='cpassword' class="form-control">
                </div>
                <input type="submit" name="new-password" class="btn btn-primary">
            </form>
    <?php 
        } 
    }else{
        echo "<div class='error'>This link has expired. </div>";
    }
}
?>
</div>
</div>