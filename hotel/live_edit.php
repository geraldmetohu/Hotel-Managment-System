<?php 
include('includes/header.html'); 
require('includes/hotel_connect.php');

$error = true;
$colVal = '';
$colIndex = 0;
$rowId = 0;
$update_field='';

$msg = array('status' => !$error, 'msg' => 'Failed! updation in mysql');

if(isset($_POST)){
    if((isset($_POST['val'])) && (!empty($_POST['val'])) && $error) {
        $error = false;
    }else {
        $error = true;
    }
    if((isset($_POST['index'])) && ($_POST['index'] >= 0) &&  $error) {
        $error = false;
    } else {
        $error = true;
    }
    if((isset($_POST['id'])) && ($_POST['id'] > 0) && $error) {
        $error = false;
    }else {
        $error = true;
    }

    if(!$error) {
        if($_POST['index'] == 2){
            $q = "SELECT clientID FROM rezervim WHERE resID = '{$_POST['id']}'";
            $r = @mysqli_query($dbc, $q);
            $row = mysqli_fetch_array($r, MYSQLI_NUM);
            $s = $_POST['val'];
            $array = explode(" ",$s);
            $query = "UPDATE klient 
                      SET name='{$array[0]}',lName='{$array[1]}' 
                      WHERE clientID='{$row[0]}'";
        }
        else {
            if($_POST['index'] == 3){
                $test_arr  = explode('-', $_POST['val']);
                if (count($test_arr) == 3) {
                    if (checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
                        $update_field = "resDate='{$_POST['val']}'";
                    } else {
                        $error_msg = "Invalid date.";
                    }
                } else {
                    $error_msg = "Invalid date.";
                }
            }
            if($_POST['index'] == 4){
                $test_arr  = explode('-', $_POST['val']);
                if (count($test_arr) == 3) {
                    if (checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
                        $update_field = "checkIn='{$_POST['val']}'";
                    } else {
                        $error_msg = "Invalid date.";
                    }
                } else {
                    $error_msg = "Invalid date.";
                }
            }
            if($_POST['index'] == 5){
                $test_arr  = explode('-', $_POST['val']);
                if (count($test_arr) == 3) {
                    if (checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
                        $update_field = "checkOut='{$_POST['val']}'";
                    } else {
                        $error_msg = "Invalid date.";
                    }
                } else {
                    $error_msg = "Invalid date.";
                }
            }
            if($_POST['index'] == 6){
                if (preg_match("/^\d+$/", $_POST['val'])) {
                    $update_field = "guests={$_POST['val']}";
                } else {
                    $error_msg = "Wrong input.";
                }
            }
            if($_POST['index'] == 7){
                if (is_numeric($_POST['val'])) {
                    $update_field = "price={$_POST['val']}";
                } else {
                    $error_msg = "Wrong input.";
                }
            }
            if(!isset($error_msg)){
                $query = "UPDATE rezervim SET $update_field WHERE resID = '{$_POST['id']}' ";
            }else{
                echo "<div class='error'> $error_msg </div>";
                exit();
            }
        }
        $status = mysqli_query($dbc, $query);
        $msg = array('status' => !$error, 'msg' => 'Success! updation in mysql');
    }
}
echo json_encode($msg);
?>