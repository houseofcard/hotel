<?php
ob_start();  //this is so location header works
?>
<?php
// core configuration
include_once "config/core.php";

// destroy session, it will remove ALL session settings
session_destroy();
 
//redirect to login page
header('Location: index.php');
?>