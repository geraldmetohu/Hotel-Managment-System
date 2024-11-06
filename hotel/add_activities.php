<?php 
$title = "Manage Activities";
include('includes/header.html');
include('includes/hotel_connect.php');
$sql = "SELECT * FROM events";
$result = mysqli_query($dbc, $sql);
?>
    <h1 id='amenities'>Activities</h1>
    <hr>
    <a href="create_activity.php" id="addActivity">Click To Add New Activity</a> 
    <br> <hr>
    <hr>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                ?>

                <tr>
                    <td><?php echo $row['Title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo "<img src='".$row['image']."' width='100' height='100'>"; ?></td>
                    <td><a class="btn btn-info" href="update_activity.php?id=<?php echo $row['eventID']; ?>">Edit</a>&nbsp;<a class="btn btn-danger" href="delete_activity.php?id=<?php echo $row['eventID']; ?>">Delete</a></td>
                </tr>                    
                <?php      
                 }
                    }
                ?>                
            </tbody>
        </table>
</body>
</html>