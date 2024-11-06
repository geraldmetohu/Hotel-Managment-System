<?php 
$title = "Sign Up";
include('includes/header.html');
include('includes/hotel_connect.php');

if(isset($_SESSION['staffid']) && isset($_SESSION['role'])){
    require('includes/loginFunctions.inc.php');
    redirect_user("view_reservations.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = []; 
    $user_exists = FALSE;

    if (empty($_POST['fname'])) {
        $errors[] = 'First name cannot be empty.';
    } else {
        $fn = mysqli_real_escape_string($dbc, trim($_POST['fname']));
    }
    
    if (empty($_POST['lname'])) {
        $errors[] = 'Last name cannot be empty.';
    } else {
        $ln = mysqli_real_escape_string($dbc,trim($_POST['lname']));
    }
    
    if (empty($_POST['email'])) {
        $errors[] = 'Email address cannot be empty.';
    } else {
        $e = mysqli_real_escape_string($dbc,trim($_POST['email']));
        if(filter_var($e,FILTER_VALIDATE_EMAIL)){
            $qt = "SELECT staffID FROM staf WHERE email='$e'";
            $rt = @mysqli_query($dbc,$qt);
            $num = mysqli_num_rows($rt);
            if($num == 1){
                $user_exists = TRUE;
            }
        }else{
            $errors[] = "Invalid email";
        }
    }

    if(empty($_POST['pass'])){
        $errors[] = 'Password is required';
    }elseif($_POST['pass'] != $_POST['passConf']){
        $errors[] = 'Passwords do not match';
    }else{
        $uppercase = preg_match('@[A-Z]@', $_POST['pass']);
        $lowercase = preg_match('@[a-z]@', $_POST['pass']);
        $number    = preg_match('@[0-9]@', $_POST['pass']);
        $specialChars = preg_match('@[^\w]@', $_POST['pass']);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || (strlen($_POST['pass']) < 8)){
            $errors[]="Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
        }else{
            $p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
        }
    }

    if(!preg_match('/^\d+$/', $_POST['phone'])){
        $errors[] = "Invalid phone number";
    }else{
        $phone = mysqli_real_escape_string($dbc,trim($_POST['phone']));
    }
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $new_img_name = "default.jpg";
        if(!empty($_FILES["picture"]['name'])) {
            $check = getimagesize($_FILES["picture"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            }

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $errors[]= " Only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
        }

        if ($uploadOk == 1) {
            $new_img_name = uniqid("IMG-",true) . '.' . $imageFileType;
            $upload_path = $target_dir.$new_img_name;
            move_uploaded_file($_FILES["picture"]["tmp_name"], $upload_path);
        }

    if(empty($errors)){
        if(!$user_exists){
            $q = "INSERT INTO inactive_staf (emer, mbiemer, email, pass, phone_number, roli, profile_pic)
            VALUES('$fn', '$ln', '$e', SHA2('$p',512), '$phone', 'user', '$new_img_name')";
            $r = @mysqli_query($dbc,$q);
            if(mysqli_affected_rows($dbc) == 1){
                include('confirm_mail.php');
                if(isset($_SESSION['emp_id'])){
                    header("location: settings.php");
                }else{
                    header("location: index.php");
                }
                echo'
                </div>';
                exit;
            }else{
                echo '<div class="error">The registration was not complete due to a server error <br> 
                Please try again</div>';
            }
        }else{
            echo '<div class="error">This email is already in use</div>';
        }
    }else{
        echo '<div class="error">'.$errors[0].'</div>';
    }
}
?>
<div class="starter-template">
<div class="page-header">
            <h1 id="amenities" class="text-center">  Create account  </h1>
        </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="controls col-md-6">
            <label class="form-label" for="fname">First Name</label>
            <input type="text" id="fname" name="fname" class="form-control form-control-lg" value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>" required />
        </div>

        <div class="controls col-md-6">
            <label class="form-label" for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" class="form-control form-control-lg" value="<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>" required/>
        </div>

        <div class="controls col-md-12">
            <label class="form-label" for="email">Your Email</label>
            <input type="email" id="email" name="email" class="form-control form-control-lg" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required/>
        </div>

        <div class="controls col-md-12">
            <label class="form-label" for="pass">Password</label>
            <input type="password" minlength="8" id="pass" name="pass" class="form-control form-control-lg" required/>
        </div>

        <div class="controls col-md-12">
            <label class="form-label" for="passConf">Confirm your password</label>
            <input type="password" minlength="8" id="passConf" name="passConf" class="form-control form-control-lg" required/>
        </div>

        <div class="controls col-md-12">
            <label class="form-label" for="phone">Contact Number</label>
            <input type="text" id="phone" name="phone" class="form-control form-control-lg" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>"/>
        </div>
        
        <div class="controls col-md-12">
        <br>
            <label for="picture">Upload Picture(optional)</label>
            <input type="file" accept="image/*" class="form-control form-control-lg" id="picture" name="picture">
        </div>
        <br>
        <div class="controls col-md-12">
            <br>
            <input id="submit" type="submit" name="submit" value="Sign Up" class="btn btn-primary">
        <?php
        if(isset($_SESSION['role'])){
            echo '
            <a href="settings.php" class="btn btn-default">Cancel</a>
        </div>
        ';
        }elseif(!isset($_SESSION['role'])){
            echo '
            <a href="index.php" class="btn btn-default">Cancel</a>
        </div>
        ';
        ?>
        <div class="form-group">
            <div class="col-md-12 control">
                <br>
                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                    Already have an account? 
                    <a href="login.php">Sign In Here</a>
                </div>
            </div>
        </div> 
        <?php 
        }
        ?>   
    </form>

    <script>
        $("#submit").click(function(){
            alert("Sign Up complete! Check email for confirmation.");
        });
    </script>

<?php
include('includes/footer.html');
?>