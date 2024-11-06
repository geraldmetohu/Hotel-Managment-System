<?php
    $title = "Delete reservation";
    include('includes\header.html');
    echo '
    <div class="box"> 
        <div class="page-header">
            <h1 id="amenities" class="text-center">Delete reservation</h1>
        </div>
';
if(!isset($_SESSION['emp_id'])){
    header('location: index.php');
}

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
}elseif(isset($_POST['id']) && is_numeric($_POST['id'])){
    $id = $_POST['id'];
}else{
    echo "<h3> This page has been accessed in error. </h3>";
    include('includes\footer.html');
    exit();
}

require('includes/hotel_connect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = [];

    if (empty($_POST['email'])) {
        $errors[] = 'Please enter your email address.';
    }else {
        $e = mysqli_real_escape_string($dbc,trim($_POST['email']));
    }

    if(!isset($_SESSION['user'])){
        if(empty($_POST['pass'])){
            $errors[] = 'Please enter your current password.';
        }else {
            $p = mysqli_real_escape_string($dbc,trim($_POST['pass']));
        }
    }else{
        $p = mysqli_real_escape_string($dbc,trim($_POST['pass']));
    }

    if($_POST['sure'] == 'no'){
        $errors[] = 'This reservation has NOT been deleted.';
    }
    
    if(empty($errors)){
        $ok = true;
        if(empty($p)){
            $q = "SELECT * FROM staf WHERE (email='$e')";
            $res = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($res);
            if(!empty($row['pass'])){
                $ok = false;
            }
        }else{
            $q = "SELECT * FROM staf WHERE (email='$e' AND pass=SHA2('$p', 512))";
            $res = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($res);
        }
        if(($res == true) && ($row['staffID'] == $_SESSION['emp_id']) && ($ok == true)){
            $q = "DELETE FROM rezervim
                WHERE resID=$id
                LIMIT 1";
            $r = @mysqli_query($dbc, $q);
            if(mysqli_affected_rows($dbc) == 1){
                echo "<p class=\"sukses\"> This reservation has been deleted. </p>";
                header("location: view_reservations.php");
            }else{
                echo '<p class="error">The reservation could not be deleted due to a system error.</p>';
                echo '<p>'. mysqli_error($dbc) .'Query: '. $q . '</p>';
            }
        }else{
           echo '<p class="error">This reservation was not deleted.</p>';
        }
    }else{
        echo "<p class=\"error\"> $errors[0] </p>";
    }
}elseif(!isset($_GET['id']) || !isset($_SESSION['emp_id']) || !isset($_SESSION['role'])){
    header('location: index.php');
}?>
    <div id="delete-box">
        <form action="delete_res.php" method="POST" class="form-horizontal form" > 
        <div class="form-group">
            <label> Email address: </label><br>
            <input class="form-control form-control-lg" type="email" name="email" maxlength="60" value="<?php if(isset($_POST['email'])){echo $_POST['email']; }?>" required><br><br>

            <label> Password: </label><br>
            <input type="hidden" id="id" name="id" value="<?php if(isset($_GET['id'])){ echo $_GET['id']; }else{echo $_POST['id']; }?>">
            <input class="form-control form-control-lg" type="password" name="pass" maxlength="50" value="<?php if(isset($_POST['pass'])){echo $_POST['pass']; }?>"><br><br>
                <label class="col-sm-6 control-label">Are you sure you want to delete this reservation?</label>
                <div class="col-sm-5 radios">
                    <div class="radio radio-danger">
                        <input type="radio" name="sure" id="Radios1" value="yes">
                        <label>
                            Yes
                        </label>
                    </div>
                    <div class="radio radio-danger">
                        <input type="radio" name="sure" id="Radios2" value="no" checked>
                        <label>
                            No
                        </label>
                    </div>  
                </div>                     
            </div>
            <div class="del">
                <button value="Delete" name="submit" type="submit" class="btn btn-primary">Delete</button>
                <a class="btn btn-default" href="view_reservations.php">Cancel</a>
            </div>
        </form>
        </div>
<?php
mysqli_close($dbc);
include('includes\footer.html');
?>