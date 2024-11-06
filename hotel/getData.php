<?php
require('includes/hotel_connect.php');
$result = mysqli_query($dbc,"SELECT * FROM dhoma WHERE roomID='" . $_POST['id'] . "'");
$row= mysqli_fetch_array($result);
echo json_encode($row);
?>