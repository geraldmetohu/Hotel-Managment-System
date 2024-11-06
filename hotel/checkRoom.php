<?php
require("includes/hotel_connect.php");
$title = "Available rooms";
include("includes/header.html");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = [];
    if(empty($_POST["arrival"])){
        $errors[] = "Select Date";
    }else{
        $checkIn = $_POST["arrival"];
    }

    if(empty($_POST["departure"])){
        $errors[] = "Select Date";
    }else{
        $checkOut = $_POST["departure"];
    }
   
    if(empty($_POST["first_name"])){
        $errors[] = "Enter Name";
    }else{
        $fName = mysqli_real_escape_string($dbc,$_POST["first_name"]);
    }

    if(empty($_POST["last_name"])){
        $errors[] = "Enter Last Name";
    }else{
        $lName = mysqli_real_escape_string($dbc,$_POST["last_name"]);
    }

    if (empty($_POST['email'])) {
        $errors[] = 'Email address cannot be empty.';
    } else {
        $email = mysqli_real_escape_string($dbc,trim($_POST['email']));
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors[] = "Invalid email";
        }
    }

    if(!preg_match('/^\d+$/', $_POST['phone'])){
        $errors[] = "Invalid phone number";
    }else{
        $phone = mysqli_real_escape_string($dbc,trim($_POST['phone']));
    }

    if(empty($_POST["adults"])){
        $errors[] = "Invalid guest number";
    }else{
        $adults = mysqli_real_escape_string($dbc, $_POST["adults"]);
    }

    $children = $_POST["children"];

    if(empty($_POST["room_pref"])){
        $errors[] = "Invalid room preference";
    }else{
        $room = mysqli_real_escape_string($dbc, $_POST["room_pref"]);
    }


    $start = strtotime($checkIn);
    $end = strtotime($checkOut);
    $timeDiff = abs($start - $end);
    $numberDays = $timeDiff/86400;
    $numberDays = intval($numberDays);
    $total = $adults+$children;

    if($room == 'Any'){
        $q = "SELECT a.*, b.photo
        FROM dhoma AS a
        INNER JOIN dhoma_foto AS b USING(roomID)
        WHERE a.roomID NOT IN ( SELECT rezervim.roomID FROM rezervim WHERE ? <= checkOut AND ? >= checkIn)";
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt,'ss',$checkIn, $checkOut);
    }else{
        $q = "SELECT a.*, b.photo
        FROM dhoma AS a
        INNER JOIN dhoma_foto AS b USING(roomID)
        WHERE a.roomID NOT IN ( SELECT rezervim.roomID FROM rezervim WHERE ? <= checkOut AND ? >= checkIn) AND a.type=?";
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt,'sss', $checkIn, $checkOut, $room);
    } 
    
    if(mysqli_stmt_execute($stmt)){
        $r = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($r)){
            echo "<div data-toggle='modal' data-target='#myModal' class='col-md-3 dhoma' style='background-image: url({$row['photo']})' id='{$row['roomID']}'>
            Room type: {$row['type']} <br>
            Floor: {$row['floor']} <br>
            Beds: {$row['beds']} <br>
            Capacity: {$row['capacity']} <br>
            Internet: {$row['internet']} <br>
            Balcony: {$row['balcony']} <br>
            Pets: {$row['pets']} <br>
            Price: {$row['price']}ALL/night. <br><br>
            </div>";
        }
    }
}

include('includes/footer.html');
?>

<div class="modal fade" id="myModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Please confirm your reservation.</h4>
            </div>
            <div class="modal-body">
                <form action="confirmRes.php" method="POST"> 
                    <label>Full Name: </label><br>
                    <input id="first_name" type="text" name="first_name" value="" readonly>
                    <input id="last_name" type="text" name="last_name" value="" readonly><br><br>
                    <input type="hidden" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                    <input type="hidden" name="phone" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>">
                    <input type="hidden" id="roomID" name="roomID" value="">
                    <label>Arrival: </label>
                    <input id="arrival" type="text" name="arrival" value="" readonly>
                    <label>Departure: </label>
                    <input id="departure" type="text" name="departure" value="" readonly><br>
                    <label>Total Guests: </label><br>
                    <input type="number" id="adults" name="adults" value="" min="1" max="10" readonly><br>
                    <label>Full Price: </label><br>
                    <input type="text" id="price" name="price" value="" readonly>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-info" >Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.dhoma').click(function(){
            var id = $(this).attr('id');
            var days = "<?php echo $numberDays; ?>";
            var guests = "<?php echo $total; ?>";
            var name = "<?php echo $fName; ?>";
            var lname = "<?php echo $lName; ?>";
            var arrival = "<?php echo $checkIn; ?>";
            var departure = "<?php echo $checkOut; ?>";

            $.ajax({
                url:"getData.php",
                type: "POST",
                data: {
                    id: id, 
                    days: days
                },
                dataType : 'json',
                success: function(result){
                    $('#first_name').val(name);
                    $('#last_name').val(lname);
                    $('#arrival').val(arrival);
                    $('#departure').val(departure);
                    $('#adults').val(guests);
                    $('#price').val(result.price*days);
                    $('#roomID').val(id);
                }
            });
        });
    });
</script>