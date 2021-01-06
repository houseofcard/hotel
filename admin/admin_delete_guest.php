<?php
ob_start(); //this is so location header works
?>
<?php
// core configuration
include_once "../config/core.php";

// connect to database
include_once '../config/database.php';
 
// include objects and classes
include_once '../objects/guest.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$guest = new Guest($db);

// include login checker
include_once "admin_login_checker.php";
 
// get ID of the guest to be deleted
$guestid = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing guest ID.');
 
// delete the guest
$guest->guestid = $guestid;

if($guest->delete()){
   	header('Location: admin_guest.php?action=guest_deleted');
}

// if unable to delete the guest
else{
    echo "<p>Unable to delete object.</p>";
}
?>
<?php
include_once 'admin_template_footer.php';
?>