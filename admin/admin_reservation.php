<?php
ob_start(); //this is so location header works
?>
<?php
// core configuration
include_once "../config/core.php";

// headings
include_once 'layout/admin_template_header.php';

// connect to database
include_once "../config/database.php";

// include objects and classes
include_once "../objects/reservation.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$reservation = new Reservation($db);

// include login checker
include_once "admin_login_checker.php";

// read the database
$stmt=$reservation->readAllReservations();

// count number of rows returned
$num = $stmt->rowCount();

// include reservation table HTML template
include_once "admin_reservation_template.php";
?>


