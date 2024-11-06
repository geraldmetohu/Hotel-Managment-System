<?php
require("includes/hotel_connect.php");
$title = "Manage Activities";
include("includes/header.html");

if(isset($_POST['submit'])){
    $errors = [];

    if(empty($_POST['title'])){
        $errors[] = "Please insert a title.";
    }else{
        $title = mysqli_real_escape_string($dbc, $_POST['title']);
    }

    if(empty($_POST['description'])){
        $errors[] = "Please insert a short description.";
    }else{
        $desc = mysqli_real_escape_string($dbc, $_POST['description']);
    }
    
    if(isset($_FILES['image'])){
        $target_dir = "includes/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["picture"])) {
            $check = getimagesize($_FILES["picture"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            }
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $errors[]= " Only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            $new_img_name = uniqid("IMG-",true) . '.' . $imageFileType;
            $upload_path = $target_dir.$new_img_name;
            move_uploaded_file($_FILES["image"]["tmp_name"], $upload_path);
            
            $sql = "INSERT INTO `events`(`description`, `Title`, `image`)
            VALUES ('$desc', '$title', '$upload_path')";
        }
    }else{
        $sql = "INSERT INTO `events`(`description`, `Title`)
        VALUES ('$desc', '$title')";
    }

    if(empty($errors)){
        $result = mysqli_query($dbc,$sql);
        if(mysqli_affected_rows($dbc) == 1){
            echo "<div class='sukses'> New Activity Added successfully. </div>";
            header("location: add_activities.php");
        }
        else{
            echo "<div class='error'> There was an error inserting data. </div>";
        }
    }else{
        echo "<div class='error'> $errors[0] </div>";
    }
}
?>

<!DOCTYPE html>
<html>
    <body>
        <div class="page-header">
            <h1 id='amenities'>Add New Activity</h1>
        </div>
        <form action="create_activity.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Activity Information:</legend>
                <div class="controls col-md-6">
                    <h4 class="form-label">Activity Name:</h4><br>
                    <input type="text" name="title" class="form-control form-control-lg" value="<?php if(isset($_POST['title'])){ echo $_POST['title']; } ?>">
                    <br>
                    <h4 class="form-label">Image</h4><br>
                    <input type="file" name="image" accept="image/*" class="form-control form-control-lg" value=""><br>
                </div>
                <div class="controls col-md-6">
                    <h4 class="form-label">Description:</h4><br>
                    <textarea class="form-control form-control-lg" name="description" id="description" cols="30" rows="7"><?php if(isset($_POST['description'])){ echo $_POST['description']; } ?></textarea>
                </div>
                <div class="controls col-md-12">
                    <input type="submit" class="btn btn-primary" value="Add" name="submit">
                    <a href="add_activities.php" class="btn btn-default">Cancel</a>
                </div>
            </fieldset>
        </form>
    </body>
</html>