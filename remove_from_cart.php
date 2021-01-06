<?php
// core configuration
include_once 'config/core.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$cart_item = new CartItem($db);

// get the product id
$guestid = isset($_GET['guestid']) ? $_GET['guestid'] : "";
$accomid = isset($_GET['accomid']) ? $_GET['accomid'] : "";
$arrival = isset($_GET['arrival']) ? $_GET['arrival'] : "";
$departure = isset($_GET['departure']) ? $_GET['departure'] : "";

//create the id and user_id for SQL method
$cart_item->guestid=$guestid;
$cart_item->accomid=$accomid;
$cart_item->arrival=$arrival;
$cart_item->departure=$departure;

if($cart_item->delete()){
	// redirect to cart list and tell the user it was removed from cart
	header("Location: booking.php?action=removed");
}

else{
	header("Location: booking.php?action=remove_failed");
}
?>
