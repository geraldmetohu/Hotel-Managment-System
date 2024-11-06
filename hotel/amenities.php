<?php 
$title = "Amenities";
include('includes/header.html');
if(isset($_SESSION['emp_id']) || isset($_SESSION['role'])){
    header('location: view_reservations.php');
}
?>
<html>
    <link rel="stylesheet" href="hotelStyle.css">
    <h1 id='amenities'>Amenities</h1><br><br>
    <p id='amenities1'>Discover amenities designed with your comfort in mind at our hotel.</p><br><br>
    <hr>
    <img src="includes/amenities.jpeg" alt="amenities" class='center'>
    <hr>
</html>


<?php
include('includes/footer.html');
?>