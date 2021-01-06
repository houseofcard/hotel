<?php
ob_start(); //this is so location header works
?>
<?php
// core configuration
include_once "../config/core.php";

// connect to database
include_once '../config/database.php';
 
// include objects and classes
include_once "../objects/accomodation.php";
include_once "../objects/accomodation_image.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$accomodation = new Accomodation($db);
$accomimage = new AccomodationImage($db);

// include login checker
include_once "admin_login_checker.php";
 
// get ID of the guest to be deleted
$accomid=isset($_GET['id']) ? $_GET['id'] : die('Missing accom ID.');

// set user id property
$accomodation->accomid=$accomid;

if($accomodation->delete()){
   	  
	// delete all related images in database & directory
	$accomimage->accomid=$accomid;
	$accomimage->deleteAll();  
	 
	header('Location: admin_accomodation.php?action=accom_deleted');
}

// if unable to delete the guest
else{
    echo "<p>Unable to delete object.</p>";
}
?>
<?php
include_once 'admin_template_footer.php';
?>