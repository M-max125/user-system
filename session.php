<?php
include_once('autoloader.inc.php');
session_start();


$cuser = new Auth();


if(!isset($_SESSION['user'])){
    header('location:index.php');
    die();
}
$cemail = $_SESSION['user'];

$data = $cuser->currentUser($cemail);

$cid = $data['id'];
$cname = $data['name'];
$cpass = $data['password'];
$cphone = $data['phone'];
$cgender = $data['gender'];
$cdob = $data['dob'];
$cphoto = $data['photo'];
$created = $data['created_at'];

$reg_on = date('d M Y', strtotime($created));
$verified = $data['verified'];

if($verified == 0){
    $verified = 'Not Verified!';
}else{
    $verified = 'Verified!';
}

$fname = strtok($cname, " "); // This function is to display only the first name




?>