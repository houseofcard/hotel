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

// given field and order
$field = isset($_GET['field']) ? $_GET['field'] : "";
$order = isset($_GET['order']) ? $_GET['order'] : "";

// read all active products in the database
$stmt = $reservation->readAll_WithSorting($field, $order);
//$stmt = $reservation->readAll_WithSorting();

// count number of products returned
$num = $stmt->rowCount();

// tell the template it is field sort
$field_sort=true;

// include products table HTML template
include_once "admin_reservation_template.php";
?>