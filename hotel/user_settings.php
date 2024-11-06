<?php 
$title = "Settings";
include('includes/header.html');
if(!isset($_SESSION['emp_id']) || !isset($_SESSION['role'])){
    header('location: index.php');
}else{
    echo '
    <div class="page-header">
    <h1 id="amenities" class="text-center">  Settings  </h1>
</div>
    ';
        echo '<div class="list-group col-md-12">
            <a href="edit.php" class="list-group-item list-group-item-info">Edit Profile</a>
            <a href="reset_password.php" class="list-group-item list-group-item-info">Change Password</a>
            <a href="delete_account.php" class="list-group-item list-group-item-danger">Delete Account</a>
        </div>
    </div>';
}
include('includes/footer.html');
?>