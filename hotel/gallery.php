<?php
$title = "Gallery"; 
include('includes/header.html');
require('includes/hotel_connect.php');
?>
    <div class="page-header">
        <h1 id="amenities" class="text-center">Gallery</h1>
    </div>
<?php 
if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
echo '
<div class="crud-form">
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="photo">Upload Photo</label>
		<input type="file" name="photo" id="photo" class="form-control-file">
	</div>
	<button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>
</div>
';
}else{
	echo '
	<p id="amenities1">Take a look around and explore our rooms, restaurants, and amenities before your stay.</p>
	<hr>
	';
}
?>
    <div class="gallery">
		<?php
			if (!$dbc) {
			  die("Connection failed: " . mysqli_connect_error());
			}

			if (isset($_POST['submit'])) {
			$photo = $_FILES['photo']['name'];
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["photo"]["name"]);
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $error= " Only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
			if(!isset($error)){
				move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
				$photo = $target_file;
				$sql = "INSERT INTO gallery (photo) VALUES ('$photo')";
				if (mysqli_query($dbc, $sql)) {
				// echo '<div class="alert alert-success" role="alert">File uploaded successfully</div>';
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			}else{
				echo '<div class="error">'.$error.'</div>';
			}
		}

		$sql = "SELECT * FROM gallery";
		$result = mysqli_query($dbc, $sql);

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
					echo '<div style="display:block; width:350px; height:250px;">';
					echo '<form method="POST" action="">';
					echo '<input type="hidden" name="photo" value="' . $row["pic_id"] . '">';
					echo '<button class="fa fa-button btn btn-danger" type="submit" name="delete"><i class="fa fa-trash"></i></button>';
					echo '</form>';
					echo '<img src="' . $row["photo"] . '" alt="Imazhi">';
					echo '<form method="POST" action="">';
					echo '</form>';
					echo '</div>';
				}else{
					echo '<div style="display:block; width:350px; height:250px;">';
					echo '<img src="' . $row["photo"] . '" alt="Imazhi">';
					echo '</div>';
				}
			}
		} else {
			echo "0 results";
		}

		if (isset($_POST['delete'])) {
			$photo = $_POST['photo'];
			$sql = "DELETE FROM gallery WHERE pic_id = '$photo'";
			if (mysqli_query($dbc, $sql)) {
			  // mesazh per sukses
			  header('Location: ' . $_SERVER['PHP_SELF']); 
			} else {
			  // mesazh per gabim
			}
		  }

			mysqli_close($dbc);
		?>
	</div>
	<div class="overlay">
		<span class="close">&times;</span>
		<img src="" alt="Imazhi I Plote">
	</div>

	<script>
        const gallery = document.querySelector('.gallery');
        const overlay = document.querySelector('.overlay');
      
        const fullImg = overlay.querySelector('img');
        const closeBtn = overlay.querySelector('.close');
      
        gallery.querySelectorAll('img').forEach(img => {
          img.addEventListener('click', () => {
            fullImg.src = img.src;
      
            overlay.style.display = 'block';
      
            document.body.style.overflow = 'hidden';
          });
        });
      
        closeBtn.addEventListener('click', () => {
          overlay.style.display = 'none';
      
          document.body.style.overflow = 'auto';
        });
    </script>