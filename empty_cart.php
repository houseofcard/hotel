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

//create the user_id for SQL method
$cart_item->guestid=$_SESSION['user_id'];

if($cart_item->deleteAllByUser()){
	// redirect to product list and tell the user it was removed from cart
	header("Location: booking.php?action=empty_success");
}

else{
	header("Location: booking.php?action=empty_failed");
}
?>
