<?php
ob_start();  //this is so location header works
?>
<?php
// core configuration
include_once "config/core.php";

// headings
include_once 'layout/template_header.php';

// connect to database
include_once "config/database.php";

// include objects and classes
include_once "objects/reservation.php";
include_once 'objects/cart_item.php';
include_once 'objects/order.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$reservation = new Reservation($db);
$cart_item = new CartItem($db);
$order = new Order($db);

// set page title
$page_title="Place Order";

// include login checker
include_once "login_checker.php";

// get items from payment.php
$transaction_id = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : ""; 
$payable = isset($_GET['payable']) ? $_GET['payable'] : ""; 

//$trans_id=$_SESSION['trans_id'];
$_SESSION['user_id'];
$cart_item->guestid=$_SESSION['user_id'];
$stmt= $cart_item->readAll();
	
// loop through product in the cart
while ($row_cart_item = $stmt->fetch(PDO::FETCH_ASSOC)){
	$cart_accomid = $row_cart_item['ACCOMID'];	
	$cart_guestid = $row_cart_item['GUESTID'];
	$cart_arrival = $row_cart_item['ARRIVAL'];
	$cart_departure = $row_cart_item['DEPARTURE'];
	$cart_adults = $row_cart_item['ADULTS'];
	$cart_children = $row_cart_item['CHILDREN'];
	$cart_days = $row_cart_item['DAYS'];
	$cart_price = $row_cart_item['PRICE'];
	
	$reservation->transactionid=$transaction_id;
	$reservation->transdate=date("Y-m-d H:i:s");
	$reservation->guestid=$cart_guestid;
	$reservation->accomid=$cart_accomid;
	$reservation->arrival=$cart_arrival;
	$reservation->departure=$cart_departure;
	$reservation->adults=$cart_adults;
	$reservation->children=$cart_children;
	$reservation->days=$cart_days;
	$reservation->roomprice=$cart_price;
	
	$reservation->createReservation();
}

// save order information
$order->guestid=$_SESSION['user_id'];
$order->transactionid=$transaction_id;
$order->totalcost=$payable;
	
$order->status="Pending Reconciliation";
$order->created=date("Y-m-d H:i:s");
	
// create the order
$order->create();
	
// remove cart items
$cart_item->user_id=$_SESSION['user_id'];
$cart_item->deleteAllByUser();

header('Location: reservation.php?transaction_id=' .$transaction_id);	
?>

<?
include_once 'layout/template_footer.php';
?>