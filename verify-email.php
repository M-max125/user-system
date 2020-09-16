<?php

include_once('session.php');
$vuser = new Notes();

if(isset($_GET['email'])){
    $email = $_GET['email'];

    $vuser->verify_email($email);
    header('location:profile.php');
    exit();
}else{
    header('location:index.php');
    exit();
}


?>