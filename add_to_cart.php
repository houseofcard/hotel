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

$created = date('Y-m-d H:i:s');

?>
<?php
$msg = "";
if(isset($_POST['booknow'])){
	
	function dateDiff($start, $end) {
		$start_ts = strtotime($start);
		$end_ts = strtotime($end);	
		$diff = $end_ts - $start_ts;
		return round($diff / 86400);
	}
	
	$days =0;
    $day = dateDiff($_SESSION['arrival'],$_SESSION['departure']);  
	if($day <= 0){
      $totalprice = $_POST['ROOMPRICE'] *1;
      $days = 1;
    }else{
      $totalprice = $_POST['ROOMPRICE'] * $day;
      $days = $day;
    }
	
	$accomID= $_POST['ACCOMID'];
	$price= $_POST['ROOMPRICE'];
	$adults =  $_POST['ADULTS'];
	$children =  $_POST['CHILDREN'];
	$arrival=$_SESSION['arrival'];
	$departure = $_SESSION['departure'];
		
	$cart_item->guestid=$_SESSION['user_id'];
	$cart_item->accomid=$accomID;
	$cart_item->arrival=$arrival;
	$cart_item->departure=$departure;
	$cart_item->days=$day;
	$cart_item->price=$price;
	$cart_item->adults=$adults;
	$cart_item->children=$children;
	
	
	// if database insert succeeded
	if($cart_item->create()){
		header('Location: booking.php?action=added');
	}

	// if database insert failed
	else{
		header('Location: booking.php?action=failed_add');
	}
}

?>