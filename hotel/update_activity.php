<?php 
    $title = "Edit Activity";
    include('includes/header.html');
    include('includes/hotel_connect.php');
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $errors = [];
        if(isset($_POST['eventID'])){
            $eventID = $_POST['eventID'];
        }else{
            $errors[] = "No activity selected.";
        }

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
        
        if(isset($_POST['image'])){
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
                
                $sql = "UPDATE `events`
                        SET `description` = '$desc', `Title` = '$title', `image` = '$upload_path'
                        WHERE `eventID` = $eventID";
            }
        }else{
            $sql = "UPDATE `events`
                    SET `description` = '$desc', `Title` = '$title'
                    WHERE `eventID` = $eventID";
        }
    
        if(empty($errors)){
            $result = mysqli_query($dbc,$sql);
    
            if($result){
                echo "<div class='sukses'> Activity Edited successfully. </div>";
                header("location: add_activities.php");
            }
            else{
                echo "<div class='error'> There was an error inserting data. </div>";
            }
        }else{
            echo "<div class='error'> $errors[0] </div>";
        }
        
    }
    elseif(isset($_GET['id'])){
        $eventID = $_GET['id']; 
        $sql = "SELECT * FROM `events` WHERE `eventID` = '$eventID'";
        $result = mysqli_query($dbc, $sql); 
        if (mysqli_num_rows($result) > 0) {        
            while ($row = mysqli_fetch_assoc($result)) {
                $desc = $row['description'];
                $title = $row['Title'];
                $image = $row['image'];
            } 
        }
    }else{
        header('Location: add_activities.php');
    }
        ?>
            <h1 id='amenities'>Edit Activity</h1>
            <form action="update_activity.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Activity Information:</legend>
                <div class="controls col-md-6">
                    <h4 class="form-label">Activity Name:</h4><br>
                    <input type="text" name="title" class="form-control form-control-lg" value="<?php echo $title; ?>">
                    <input type="hidden" name="eventID" value="<?php echo $eventID; ?>"><br>
                    <h4 class="form-label">Image</h4><br>
                    <input type="file" name="image" accept="image/*" class="form-control form-control-lg" value="<?php echo $image; ?>"><br>
                </div>
                <div class="controls col-md-6">
                    <h4 class="form-label">Description:</h4><br>
                    <textarea class="form-control form-control-lg" name="description" id="description" cols="30" rows="7"><?php echo $desc;?></textarea>
                </div>
                <div class="controls col-md-12">
                    <input type="submit" class="btn btn-primary" value="Update" name="update">
                    <a href="add_activities.php" class="btn btn-default">Cancel</a>
                </div>
            </fieldset>
        </form> 
        </body>
        </html>