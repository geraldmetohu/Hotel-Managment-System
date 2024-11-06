<link rel="stylesheet" href="hotelStyle.css?">
<?php
$title = "Delete Account";
include('includes/hotel_connect.php');
include('includes/header.html');
echo '
        <div class="page-header">
            <h1 id="amenities" class="text-center">Delete Account</h1>
        </div>
';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = [];
    if (empty($_POST['i'])) {
        $errors[] = 'Account not selected';
    }else {
        $id = $_POST['i'];
    }
        if (empty($_POST['email'])) {
            $errors[] = 'Admin, please enter your email address.';
        }else {
            $e = mysqli_real_escape_string($dbc,trim($_POST['email']));
        }

        if(empty($_POST['pass'])){
            $errors[] = 'Admin, please enter your current password.';
        }else {
            $p = mysqli_real_escape_string($dbc,trim($_POST['pass']));
        }

        if($_POST['conf'] == 'no'){
            $errors[] = 'Account NOT deleted!';
        }

        if(empty($errors)){
            $q = "SELECT * FROM staf WHERE (email='$e' AND pass=SHA2('$p', 512))";
            $r = @mysqli_query($dbc, $q);
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            if($row['roli'] == 'admin'){
                $q = "DELETE FROM staf WHERE staffID = '$id'";
                $r = @mysqli_query($dbc, $q);
                if(mysqli_affected_rows($dbc) == 1){
                    echo '<div class="sukses">Account has been deleted.</div>';
                    header("location: settings.php");
                }else{
                    echo '<div class="error">The user could not be deleted due to a system error.<br>
                    We apologize for any inconvenience. </div>';
                }
            }else{
                echo '<div class="error">You do not have permission to delete accounts.</div>';
            }
        }else{
            echo '<div class="error">'.$errors[0].'</div>';
        }
    }
    ?>
        <div id="delete-box"> 
        <form action="ManDelete.php" method="POST" class="form-horizontal form" > 
        <div class="form-group">
            <label> Admin email address: </label><br>
            <input class="form-control form-control-lg" type="email" name="email" maxlength="60" value="" required><br><br>

            <label> Admin password: </label><br>
            <input type="hidden" id="i" name="i" value="<?php if(isset($_GET['i'])){ echo $_GET['i']; }else{echo $_POST['i']; }?>">
            <input class="form-control form-control-lg" type="password" name="pass" maxlength="50" value="" required><br><br>
                <label class="col-sm-6 control-label">Are you sure you want to delete this account?</label>
                <div class="col-sm-5 radios">
                    <div class="radio radio-danger">
                        <input type="radio" name="conf" id="Radios1" value="yes">
                        <label>
                            Yes
                        </label>
                    </div>
                    <div class="radio radio-danger">
                        <input type="radio" name="conf" id="Radios2" value="no" checked>
                        <label>
                            No
                        </label>
                    </div>  
                </div>                     
            </div>
            <div class="del">
                <button value="Delete" name="submit" type="submit" class="btn btn-primary">Delete</button>
                <a class="btn btn-default" href="settings.php">Cancel</a>
            </div>
        </form>
        </div>
<?php
include('includes/footer.html');
?>