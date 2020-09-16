<?php
session_start();
include_once('autoloader.inc.php');
$userOut = new Auth();
$userOut->logout();
header('location:index.php');
die();
?>