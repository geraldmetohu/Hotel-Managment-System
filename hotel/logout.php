<?php 
session_start();
require('includes/loginFunctions.inc.php');
    if (!isset($_SESSION['emp_id'])) {
        redirect_user();
    }else{
        $_SESSION = [];
        session_destroy();
        setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);
    }
    redirect_user();
?>