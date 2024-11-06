<link rel="stylesheet" href="hotelStyle.css?">
<?php
$title = "Edit Profile";
include('includes/header.html');
include('includes/hotel_connect.php');
if(!isset($_GET['i']) || !isset($_GET['r']) || !isset($_SESSION['emp_id']) || !isset($_SESSION['role'])){
    header('location: index.php');
}else{
    echo '
    <div class="page-header">
    <h1 id="amenities" class="text-center"> Edit Account </h1>
</div>
    ';
    $id = $_GET['i'];
    $roli = $_GET['r'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $errors = [];
        
        if(empty($_POST['fname'])){
            $errors[] = "You forgot to enter first name.";
        }else{
            $fn = mysqli_real_escape_string($dbc, trim($_POST['fname']));
        }
    
        if(empty($_POST['lname'])){
            $errors[] = "You forgot to enter last name.";
        }else{
            $ln = mysqli_real_escape_string($dbc, trim($_POST['lname']));
        }
    
        if(empty($_POST['email'])){
            $errors[] = "You forgot to enter email.";
        }else{
            $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
        }

        if(!preg_match('/^\d+$/', $_POST['tel'])){
            $errors[] = "Invalid phone number";
        }else{
            $phone = mysqli_real_escape_string($dbc,trim($_POST['tel']));
        }

    
        if(empty($errors)){
            $q = "SELECT staffID FROM staf WHERE email='$e' AND staffID != '$id'";
            $r = @mysqli_query($dbc, $q);
            $num = mysqli_num_rows($r);
            if($num == 0){
                $q = "UPDATE staf SET
                      fname='$fn', lname='$ln', email='$e', tel='$phone'
                      WHERE staffID=$id
                      LIMIT 1";
                $r = @mysqli_query($dbc, $q);
                if($r == true){
                    echo '<div class="sukses">The user has been edited.</div>';
                    header("location: settings.php");
                }else{
                    echo '<div class="error">The user could not be edited due to a system error.<br>
                            We apologize for any inconvenience. </div>'; 
                }
            }else{
                echo '<div class="error"> This email is already in use. </div>';
            }
        }else{
            echo '<div class="error">';
            print_r($errors);
            echo '</div>';
        }
    }
    $q = "SELECT fname, lname, email, roli, tel  
          FROM staf
          WHERE staffID='$id'";
    $r = @mysqli_query($dbc, $q);
    if(mysqli_num_rows($r) == 1){
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        echo '<form action="ManEdit.php?i='.$id.'&&r='.$roli.'" method="POST"> 
            <label> First Name: </label><br>
            <input type="text" class="form-control form-control-lg" name="fname" maxlength="20" size="20" value="'.$row['fname'].'"><br><br>
            <label> Last Name: </label><br>
            <input type="text" class="form-control form-control-lg" name="lname" maxlength="30" size="20" value="'.$row['lname'].'"><br><br>
            <label> Email: </label><br>
            <input type="email" class="form-control form-control-lg" name="email" maxlength="60" size="25" value="'.$row['email'].'">
            <br>
            <label> Phone Number: </label><br>
            <input type="text" class="form-control form-control-lg" name="tel" maxlength="60" size="25" value="'.$row['tel'].'"><br>
<br>';
            echo'
            <br><br>
            <input type="submit" class="btn btn-primary" type="submit" name="submit" value="Save">
            <a class="btn btn-default" href="settings.php">Cancel</a>
            <input type="hidden" name="id" value="'.$id.'">
            </form> ';
    }else{
        echo '<p class="error"> This page has been accessed in error</p>';
    }

mysqli_close($dbc);
include('includes\footer.html'); 
}  
?>