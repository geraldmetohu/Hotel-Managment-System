<?php 
    $title = "Edit Room";
    include('includes/header.html');
    include('includes/hotel_connect.php');
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $errors = [];
        if(empty($_POST['roomId'])){
            $errors[] = "Error selecting room.";
        }else{
            $roomID = mysqli_real_escape_string($dbc, trim($_POST['roomId']));
        }
        

        if(empty($_POST['roomNO'])){
            $errors[] = "You forgot to enter the number of rooms.";
        }else{
            $roomNo = mysqli_real_escape_string($dbc, trim($_POST['roomNO']));
        }
    
        if(empty($_POST['type'])){
            $errors[] = "You forgot to enter the room type.";
        }else{
            if($_POST['type']!='Single' && $_POST['type']!='Double' && $_POST['type']!='Family' && $_POST['type']!='Suite' && $_POST['type']!='Presidential Suite' && $_POST['type']!='Standard'){
                $errors[] = "Please choose a correct room type.";
            }else{
                $type = mysqli_real_escape_string($dbc, trim($_POST['type']));
            }
        }
    
        if(empty($_POST['beds'])){
            $errors[] = "You forgot to enter the number of beds.";
        }else{
            $beds = mysqli_real_escape_string($dbc, trim($_POST['beds']));
        }

        if(empty($_POST['capacity'])){
            $errors[] = "You forgot to enter the room capacity.";
        }else{
            $capacity = mysqli_real_escape_string($dbc, trim($_POST['capacity']));
        }

        if(empty($_POST['price'])){
            $errors[] = "You forgot to enter the price.";
        }else{
            $price = mysqli_real_escape_string($dbc, trim($_POST['price']));
        }

        if(empty($_POST['internet'])){
            $errors[] = "You forgot to enter the internet information.";
        }else{
            $internet = mysqli_real_escape_string($dbc, trim($_POST['internet']));
        }

        if(empty($_POST['balcony'])){
            $errors[] = "You forgot to enter the balcony information.";
        }else{
            $balcony = mysqli_real_escape_string($dbc, trim($_POST['balcony']));
        }

        if(empty($_POST['floor'])){
            $errors[] = "You forgot to enter the floor number.";
        }else{
            $floor = mysqli_real_escape_string($dbc, trim($_POST['floor']));
        }

        if(empty($_POST['pets'])){
            $errors[] = "You forgot to enter the pets information.";
        }else{
            $pets = mysqli_real_escape_string($dbc, trim($_POST['pets']));
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
            }
        }


        if(!empty($errors)){
            echo '<div class="error">'.$errors[0].'</div>';
        }else{
            $sql = "UPDATE `dhoma` 
            SET `roomNo` = $roomNo, `type` = '$type', `beds` = $beds, `capacity` = $capacity, `price` = $price, `internet` = '$internet', `balcony` = '$balcony', `floor` = $floor, `pets` = '$pets'
            WHERE `roomID`=$roomID"; 
            $result = mysqli_query($dbc, $sql); 

            if ($result == true) {
                if(isset($upload_path)){
                    $sql = "UPDATE `dhoma_foto` 
                            SET photo = '$upload_path' 
                            WHERE `roomID`=$roomID";
                    $result = mysqli_query($dbc, $sql);
                    if($result == true){
                        echo "<div class='sukses'> Record updated successfully. </div>";
                        header("location: view_room.php");
                    }else{
                        echo "<div class='error'>There was an error updating data. We apologize for any inconvenience. </div>";
                    }
                }
            }else{
                echo "<div class='error'>There was an error updating data. We apologize for any inconvenience. </div>";
            }
        }
    }
    elseif(isset($_GET['id'])){
        $roomId = $_GET['id']; 
        $sql = "SELECT * FROM `dhoma` WHERE `roomID`='$roomId'";
        $result = mysqli_query($dbc, $sql); 
        if (mysqli_num_rows($result) > 0) {        
            while ($row = mysqli_fetch_assoc($result)) {
                $roomNo = $row['roomNo'];
                $type = $row['type'];
                $beds = $row['beds'];
                $capacity = $row['capacity'];
                $price = $row['price'];
                $internet = $row['internet'];
                $balcony = $row['balcony'];
                $floor = $row['floor'];
                $pets = $row['pets'];
            } 
        ?>
            <h1 id='amenities'>Edit Room</h1>
            <form action="update_room.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Room information:</legend>
                <div class="controls col-md-6">
                    <h4 class="form-label">Number Of Rooms:</h4><br>
                    <input type="number" min="1" name="roomNO" class="form-control form-control-lg" value="<?php echo $roomNo; ?>" required>
                    <input type="hidden" name="roomId" value="<?php echo $roomId; ?>" required>
                </div>

                <div class="controls col-md-6">
                    <h4 class="form-label">Type:</h4><br>
                    <select name="type" id="type" class="form-control form-control-lg" required>
                        <option selected value="">---</option>
                        <option value="Single" <?php if(isset($_POST['type']) && $_POST['type'] == 'Single') { echo 'selected';} ?> >Single</option>
                        <option value="Couples" <?php if(isset($_POST['type']) && $_POST['type'] == 'Couples') { echo 'selected';} ?>>Couple</option>
                        <option value="Standard" <?php if(isset($_POST['type']) && $_POST['type'] == 'Standard') { echo 'selected';} ?>>Standard</option>
                        <option value="Family" <?php if(isset($_POST['type']) && $_POST['type'] == 'Family') { echo 'selected';} ?>>Family</option>
                        <option value="Suite" <?php if(isset($_POST['type']) && $_POST['type'] == 'Suite') { echo 'selected';} ?>>Suite</option>
                        <option value="Presidential Suite" <?php if(isset($_POST['type']) && $_POST['type'] == 'Presidential Suite') { echo 'selected';} ?>>Presidential Suite</option>
                    </select>
                </div>

                <div class="controls col-md-6">
                    <h4 class="form-label">Beds:</h4><br>
                    <input type="number" name="beds" class="form-control form-control-lg" value="<?php echo $beds; ?>" required><br>
                </div>

                <div class="controls col-md-6">
                    <h4 class="form-label">Capacity:</h4><br>
                    <input type="number" name="capacity" min="1" max="12" class="form-control form-control-lg" value="<?php echo $capacity; ?>" required><br>
                </div> 

                <div class="controls col-md-4">
                    <h4 class="form-label control-label">Internet:</h4><br>
                    <div class="btn-group">
                        <label class="btn btn-sm btn-primary"> <input type="radio" name="internet" value="yes" <?php if($internet == 'yes'){ echo "checked";} ?> > YES </label>
                        <label class="btn btn-sm btn-primary"> <input type="radio" name="internet" value="no" <?php if($internet == 'no'){ echo "checked";} ?> > NO</label>
                    </div>
                </div>
            <br>
                <div class="controls col-md-4">
                    <h4 class="form-label control-label">Balcony:</h4><br>
                    <div class="btn-group">
                        <label class="btn btn-sm btn-primary"> <input type="radio" name="balcony" value="yes" <?php if($balcony == 'yes'){ echo "checked";} ?> > YES </label>
                        <label class="btn btn-sm btn-primary"> <input type="radio" name="balcony" value="no" <?php if($balcony == 'no'){ echo "checked";} ?> > NO</label>
                    </div>
                </div>
            <br>
            <div class="controls col-md-4">
                    <h4 class="form-label control-label">Pets:</h4><br>
                    <div class="btn-group">
                        <label class="btn btn-sm btn-primary"> <input type="radio" name="pets" value="yes" <?php if($pets == 'yes'){ echo "checked";} ?> > YES </label>
                        <label class="btn btn-sm btn-primary"> <input type="radio" name="pets" value="no" <?php if($pets == 'no'){ echo "checked";} ?> > NO</label>
                    </div>
                </div>
            <br><br>
                <div class="controls col-md-10">
                    <h4>Floor Number:</h4><br>
                    <input type="range" name="floor" id="floor" min="0" max="6"  value="<?php echo $floor; ?>" required><br>
                </div>
                <div class="controls col-md-2">
                    <span id="range-value" class="btn btn-primary" style="margin-top: 20%; color: #fff; font-size:large;"><?php echo $floor; ?></span>
                </div>
            <br>
            <div class="controls col-md-6">
                    <h4 class="form-label">Price:</h4>
                    <input type="number" name="price" class="form-control form-control-lg" value="<?php echo $price; ?>" required><br>
            </div> 
            <div class="controls col-md-6">
                    <h4 class="form-label">Image</h4>
                    <input type="file" name="image" accept="image/*" class="form-control form-control-lg" value=""><br>
            </div>
            <br><br>
            <div class="controls col-md-12">
                <input  class="btn btn-primary" type="submit" value="Update" name="update">
                <a class="btn btn-default" href="view_room.php">Cancel</a>
            </div>
            </fieldset>
        </form> 
        
        <script>
            $(document).ready(function(){
                $('#floor').on('input', function(){
                    $('#range-value').html($(this).val());
                });
            });
        </script>
        </body>
        </html> 
        <?php
        } 
    }else{ 
        header('Location: view_room.php');
    }
?>