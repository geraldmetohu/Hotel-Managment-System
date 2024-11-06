<?php 
$title = "Rooms & Suites";
include('includes/header.html');
require('includes/hotel_connect.php');

$q = "SELECT DISTINCT(type) FROM dhoma"; 
$r = mysqli_query($dbc, $q); 
echo '
    <div class="page-header">
        <h1 id="amenities" class="text-center">  Rooms & Suites  </h1>
    </div>
    <div id="amenities1"> 
        Whether you choose a simple room or one with energizing city view, 
        expect a host of amenities, spacious size, and extra comforts for rest-filled evenings and exciting days. <br> Scroll down to explore more of what 
        we have to offer.
    </div>
    <hr>
';
echo '<div class="row">';
while($row=mysqli_fetch_assoc($r)){
    echo '
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <img src="roomImages/'.$row['type'].'1.jpg" alt="Imazh">
        <div class="caption">
        <form method="POST" action="room_info.php">
        <input type="hidden" name="room_type" value="'.$row['type'].'">
          <h3>'.$row['type'].'</h3>
          <p><input type="submit" class="btn btn-primary" value="View More" name="submit"></p>
        </form>
        </div>
      </div>
    </div>
    ';
}
echo ' </div>';