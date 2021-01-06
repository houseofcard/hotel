<link rel="stylesheet" type="text/css"> <!--This is here to stop footer paralles image jumping around-->

<?php
// core configuration
include_once 'config/core.php';

// headings
include_once 'layout/template_header.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/guest.php';
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$guest = new Guest($db);
$cart_item = new CartItem($db);

$guest = new Guest($db);
$cart_item = new CartItem($db);

$guest->guestid=$_SESSION['user_id'];

$stmt = $guest->listGuestID();

while ($row_guest = $stmt->fetch(PDO::FETCH_ASSOC)){
	$id= $row_guest['GUESTID'];
	$firstname= $row_guest['G_FNAME'];
	$lastname= $row_guest['G_LNAME'];
	$city= $row_guest['G_CITY'];
	$address= $row_guest['G_ADDRESS'];
	$phone= $row_guest['G_PHONE'];
	$nationality= $row_guest['G_NATIONALITY'];
	$company= $row_guest['G_COMPANY'];
	$companyaddress= $row_guest['G_CADDRESS'];
	$terms= $row_guest['G_TERMS'];
	$zip=  $row_guest['ZIP'];
	$location = $row_guest['LOCATION'];
}

//create the user_id for SQL method
$cart_item->guestid=$_SESSION['user_id'];

// read the database
$stmt_cart = $cart_item->readAllWithAccom();

// generate unique transaction id
$transaction_id=strtoupper(uniqid());
?>
<div class="body_content">
	<div class="container">
		<caption><h2 align='left'>Booking Details</h2></caption>

		<form action="place_order.php" method="post"  name="personal" >
			<div class="col">
			<!--<div class="col-md-12">-->
				<div class="row">
					
				<!--<div class="col-md-8 col-sm-4">-->
					<div class="col-md-12">
						<p><label>Name:</label>
						<?php echo $firstname . ' '. $lastname;?></p>
					</div>
					<div class="col-md-12">
						<p><label>Address:</label>
						<?php echo $address . ' '. $city;?> </p>
					</div>
					<div class="col-md-12"> 
						<p><label>Phone #:</label>
						<?php echo $phone ?></p>
					</div>
					<div class="col-md-12">
						<p><label>Transaction Date:</label>
						<?php echo date("d/m/Y") ; ?></p>
					</div>
					<div class="col-md-12">
						<p><label>Transaction Id:</label>
						<?php echo $transaction_id; ?></p>
					</div>
				</div>
			</div>
			<div class='table-responsive'>
				<table class='table table-hover table-bordered'>
					<tr>
						<th>Room Description</th>
						<th>Arrival</th>
						<th>Departure</th>
						<th>Adults</th>
						<th>Children</th>
						<th>Price</th>
						<th>Night(s)</th>
						<th>Subtotal</th>
					</tr>	

					<?php
					while ($row_cart = $stmt_cart->fetch(PDO::FETCH_ASSOC)){
						$i = 0;
						$cart_accomid = $row_cart['ACCOMID'];	
						$cart_accomdesc = $row_cart['ACCOMDESC'];
						$cart_arrival = $row_cart['ARRIVAL'];
						$arrive = new DateTime($cart_arrival);
						$arrival= $arrive->format('d-m-Y');
						$cart_departure = $row_cart['DEPARTURE'];
						$depart = new DateTime($cart_departure);
						$departure= $depart->format('d-m-Y');
						$adults = $row_cart['ADULTS'];
						$children = $row_cart['CHILDREN'];
						$cart_days = $row_cart['DAYS'];
						$cart_price = $row_cart['PRICE'];
						$subtotal=$cart_price * $cart_days;
					?>
						<tr>
							<td><?php echo $cart_accomdesc; ?></td>
							<td><?php echo $arrival; ?></td>
							<td><?php echo $departure; ?></td>
							<td><?php echo $adults; ?></td>
							<td><?php echo $children; ?></td>
							<td><?php echo "&#36;" . number_format($cart_price, 2, '.', ',') . "";?></td>
							<td><?php echo $cart_days; ?></td>
							<td><?php echo "&#36;" . number_format($subtotal, 2, '.', ',') . "";?></td>
						</tr>
						<?php
						$payable += $subtotal;
						$i++;
					}
					
					// order total cost
					echo "<tr>";
						echo "<td><b>Total: </b></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td><b>&#36;" . number_format($payable, 2, '.', ',') . "</b></td>";
					echo "<tr>";
					?>
				</table>	
			</div>		
		</form>

	
		<!-- payment information -->
		<h3>Payment Method</h3>
		<p>Payment can be made by bank transer into the following account:</p>
		<p>Account Name:  Marimar Limited</p>
		<p>Account Number:  06 0942 005 125678 00</p>
		<p>Please include your username within the bank transfer details</p>
		<p>Items will be dispatched once payment is received by Marimar Limited</p>	
		<br>
	
		<form method="post" action="place_order.php?transaction_id=<?php echo $transaction_id; ?>&payable=<?php echo $payable; ?>">
			<button type="submit" class="button" name="continue">PLACE ORDER</a></button>
		</form>
	</div>
</div>
<?
include_once 'layout/template_footer.php';
?>