<?php
ob_start(); //this is so location header works
?>
<?php
// core configuration
include_once "../config/core.php";

// connect to database
include_once '../config/database.php';
 
// include objects and classes
include_once '../objects/accomodation.php';
include_once '../objects/accomodation_image.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$accomodation = new Accomodation($db);
$accomimage = new AccomodationImage($db);

// include login checker
include_once "admin_login_checker.php";

// get ID of the room to be deleted
$imageid=isset($_GET['id']) ? $_GET['id'] : die('Missing room ID.');
 
// delete the room
$accomimage->imageid=$imageid;

if($accomimage->delete()){
   header('Location: admin_accomodation.php?action=image_deleted');
}

// if unable to delete the room
else{
    echo "<p>Unable to delete object.</p>";
}
?>
<?php
include_once 'admin_template_footer.php';
?>