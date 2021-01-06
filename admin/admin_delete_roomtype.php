<?php
ob_start(); //this is so location header works
?>
<?php
// core configuration
include_once "../config/core.php";

// connect to database
include_once '../config/database.php';
 
// include objects and classes
include_once '../objects/roomtype.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$roomtype = new Roomtype($db);

// include login checker
include_once "admin_login_checker.php";

// get ID of the roomtype to be deleted
$roomtypeid=isset($_GET['id']) ? $_GET['id'] : die('Missing room type ID.');
 
// delete the roomtype
$roomtype->roomtypeid=$roomtypeid;

if($roomtype->delete()){
	header('Location: admin_roomtype.php?action=roomtype_deleted');
}

// if unable to delete the roomtype
else{
    echo "<p>Unable to delete object.</p>";
}
?>
<?php
include_once 'admin_template_footer.php';
?>