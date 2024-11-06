<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- the css file link  -->
  <link rel="stylesheet" href="hotelStyle.css?">
  

</head>
<body>

</body>
</html>

<?php
$title = "Manage Accounts";
include ('includes/hotel_connect.php');
include('includes/header.html');

if(!isset($_SESSION['emp_id']) || !isset($_SESSION['role'])){
    header('location: index.php');
}else{
    echo '
    <div class="page-header">
        <h1 id="amenities" class="text-center"> Manage accounts </h1>
    </div>
    <a href="register.php" id="addAccount">Click To Add Account</a> <br> <hr>'
    
    ;
    

    $q = "SELECT * FROM staf WHERE roli='user'"; 
    $r = @mysqli_query($dbc, $q);
    echo'
    <div id="order_table">  
    <table id="data_table" width="100%" class="table table-striped table-bordered table-hover table-rensponsive">
        <thead>
            <tr class="table-header"> 
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr> 
        </thead>
        <tbody id="export_table">';
    while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
        echo '
        <tr>
        <td align="left">'.$row['staffID'].'</td>
        <td align="left">'.$row['fname'].'</td>
        <td align="left">'.$row['lname'].'</td>
        <td align="left">'.$row['email'].'</td>
        <td align="left">'.$row['tel'].'</td>
        <td align="center"><a href="ManEdit.php?i=' . $row['staffID'].'&r='.$row['roli'].'">Edit</a></td>
        <td align="center"><a href="ManDelete.php?i=' . $row['staffID'].'">Delete</a></td>
        </tr>
        ';
    }
    echo'
            </tbody>
        </table>
    </div>
    ';
}
include('includes/footer.html');
?>