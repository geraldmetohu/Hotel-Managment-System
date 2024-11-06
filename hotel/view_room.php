<?php 
$title = "Manage Rooms";
include('includes/header.html');
include('includes/hotel_connect.php');
if(!isset($_SESSION['emp_id'])){
    header('location: index.php');
}
$sql = "SELECT * FROM dhoma";
$result = mysqli_query($dbc, $sql);
?>
    <h1 id='amenities'>Rooms</h1>
    <hr>
    <div class="box"> 
        <a href="create_room.php" id="addRoom">Click To Add New Room</a> 
        <br> <hr>
    </div>
    <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>Room No.</th>
                    <th>Number of rooms.</th>
                    <th>Type</th>
                    <th>Beds</th>
                    <th>Capacity</th>
                    <th>Price</th>
                    <th>Internet</th>
                    <th>Balcony</th>
                    <th>Floor</th>
                    <th>Pets</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                ?>

                <tr>
                    <td><?php echo $row['roomID']; ?></td>
                    <td><?php echo $row['roomNo']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['beds']; ?></td>
                    <td><?php echo $row['capacity']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['internet']; ?></td>
                    <td><?php echo $row['balcony']; ?></td>
                    <td><?php echo $row['floor']; ?></td>
                    <td><?php echo $row['pets']; ?></td>
                    <td><a class="btn btn-info" href="update_room.php?id=<?php echo $row['roomID']; ?>">Edit</a>&nbsp;<a class="btn btn-danger" href="delete_room.php?id=<?php echo $row['roomID']; ?>">Delete</a></td>
                </tr>                    
                <?php      
                 }
                    }
                ?>                
            </tbody>
        </table>
</body>
</html>