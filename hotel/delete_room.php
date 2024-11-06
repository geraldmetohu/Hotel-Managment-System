<?php
$title = "Delete Room";
include('includes/hotel_connect.php');
include('includes/header.html');
echo '
    <div class="box"> 
        <div class="page-header">
            <h1 id="amenities" class="text-center">Delete room</h1>
        </div>
';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $errors = [];

        if (empty($_POST['id'])) {
            $errors[] = 'Room not selected';
        }else {
            $id = $_POST['id'];
        }

        if (empty($_POST['email'])) {
            $errors[] = 'Please enter your email address.';
        }else {
            $e = mysqli_real_escape_string($dbc,trim($_POST['email']));
        }

        if(empty($_POST['pass'])){
            $errors[] = 'Please enter your current password.';
        }else {
            $p = mysqli_real_escape_string($dbc,trim($_POST['pass']));
        }

        if($_POST['conf'] == 'no'){
            $errors[] = 'Room NOT deleted!';
        }
        if(empty($errors)){
            $q = "SELECT * FROM staf WHERE (email='$e' AND pass=SHA2('$p', 512))";
            $r = @mysqli_query($dbc, $q);
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            if($row['roli'] == 'admin'){
                $q = "DELETE FROM dhoma WHERE roomID = '$id'";
                $r = @mysqli_query($dbc, $q);
                if(mysqli_affected_rows($dbc) == 1){
                    echo '<div class="sukses">The room has been deleted.</div>';
                    header("location: view_room.php");
                }else{
                    echo '<div class="error">The room could not be deleted due to a system error.<br>
                    We apologize for any inconvenience. </div>';
                }
            }else{
                echo '<div class="error">You do not have permission to delete rooms.</div>';
            }
        }else{
            echo '<div class="error">'.$errors[0].'</div>';
        }
    }elseif(!isset($_GET['id']) || !isset($_SESSION['emp_id']) || !isset($_SESSION['role'])){
        header('location: index.php');
    }
    ?>
        <div id="delete-box"> 
        <form action="delete_room.php" method="POST" class="form-horizontal form" > 
            <div class="form-group">
            <label> Admin email address: </label><br>
            <input class="form-control form-control-lg" type="email" name="email" maxlength="60" value="<?php if(isset($_POST['email'])){echo $_POST['email']; }?>" required><br><br>

            <label> Admin password: </label><br>
            <input type="hidden" id="id" name="id" value="<?php if(isset($_GET['id'])){ echo $_GET['id']; }else{echo $_POST['id']; }?>">
            <input class="form-control form-control-lg" type="password" name="pass" maxlength="50" value="<?php if(isset($_POST['pass'])){echo $_POST['pass']; }?>" required><br><br>
                <label class="col-sm-6 control-label">Are you sure you want to delete this room?</label>
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
                <a class="btn btn-default" href="view_room.php">Cancel</a>
            </div>
        </form>
        </div>
<?php
include('includes/footer.html');
?>