<?php 
$title = "Things To Do";
include('includes/header.html');
require('includes/hotel_connect.php');

if(isset($_SESSION['emp_id']) || isset($_SESSION['role'])){
    header('location: view_reservations.php');
}
echo "
    <h1 id='amenities'>Things To Do</h1>
    <p id='amenities1'>Spend your days exploring downtown Tirana and take a break in our fitness center.<br>
    With plenty to do in and around the hotel, an exciting stay is never far away.</p>
    <hr>
    ";
    $q = "SELECT * FROM events";
    $r = mysqli_query($dbc, $q);
    while($row = mysqli_fetch_assoc($r)){
        echo "<div class='events'> 
            <h3 class='activity text-center'>{$row['Title']}</h3><br>
            <p class='activity-desc'>{$row['description']}<br>
            <img src='".$row['image']."'>
            </p><hr><br><br>
        </div>";
    }
include('includes/footer.html');
?>
