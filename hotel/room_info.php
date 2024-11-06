<?php
$title = "Rooms & Suites";
include('includes/header.html');
require('includes/hotel_connect.php');

if(isset($_POST['submit'])){
    $q = "SELECT dhoma.*, dhoma_foto.photo
         FROM dhoma
        INNER JOIN dhoma_foto USING(roomID)
        WHERE dhoma.type='{$_POST['room_type']}'";
    $r = mysqli_query($dbc, $q); 
    echo '<div class="row">';
    while($row=mysqli_fetch_assoc($r)){
    echo '
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <img src="'.$row['photo'].'" alt="Imazh">
        <div class="caption">
        <p> <span class="glyphicon glyphicon-bed" aria-hidden="true"> </span> Beds: '.$row["beds"].'<br>
        <span class="glyphicon glyphicon-user" aria-hidden="true"> </span> Capacity: '.$row["capacity"].'<br>
        <span class="glyphicon glyphicon-leaf" aria-hidden="true"> </span> Balcony: '.$row["balcony"].'<br>
        <span class="glyphicon glyphicon-sort" aria-hidden="true"></span> Floor number: '.$row["floor"].'<br>
        <span class="glyphicon glyphicon-globe" aria-hidden="true"> </span> Internet: '.$row["internet"].'<br>
        <span class="glyphicon glyphicon-heart" aria-hidden="true"> </span> Pets allowed: '.$row["pets"].'<br>
        <span class="glyphicon glyphicon-usd" aria-hidden="true"> </span> Price per night: '.$row["price"].'<br>
        </p>
        </form>
        </div>
      </div>
    </div>
    ';
}
echo ' </div>';
}
include('includes/footer.html');
?>