<link rel="stylesheet" type="text/css"> <!--This is here to stop footer paralles image jumping around-->

<?php
// core configuration
include_once "config/core.php";

// headings
include_once 'layout/template_header.php';

// check if logged in as admin
//include_once "login_checker.php";

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/order.php';
include_once 'objects/reservation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$order = new Order($db);
$reservation = new Reservation($db);

// read order details based on given id
$transactionid=isset($_GET['transactionid']) ? $_GET['transactionid'] : "";
$order->transactionid=$transactionid;
$stmt=$order->readOneByTransactionId();

$num = $stmt->rowCount();

?>

<div class="body_content">
	<div class="container">
		<caption><h2 align='left'>Read Order Details</h2></caption>

		<?php
		while ($row_order = $stmt->fetch(PDO::FETCH_ASSOC)){
	
			$createddb= $row_order['CREATED'];
			$status= $row_order['STATUS'];
			$totalcost= $row_order['TOTALCOST'];
			$fname= $row_order['G_FNAME'];
			$lname= $row_order['G_LNAME'];
			$create=new DateTime($createddb);
			$created= $create->format('d-m-Y, H:m:s');
	
			// read order details
			?>
			<div>
				<a href='orders.php' class='btn-lg btn-primary pull-right'>
					<span class='glyphicon glyphicon-list'></span>  Back to Orders
				</a>
			</div>
			<br>

			<h3><b>Order Summary</b></h3>
			
			<div class='table-responsive'>
				<table class='table table-hover table-bordered'>
		
					<tr>
						<td><b>Transaction ID</b></td>
						<td><?php echo $transactionid; ?></td>
					</tr>
					<tr>
						<td><b>Transaction Date</b></td>
						<td><?php echo $created; ?></td>
					</tr>
					<tr>
						<td><b>Total Cost</b></td>
						<td>&#36;<?php echo number_format($totalcost, 2, '.', ','); ?></td>
					</tr>
					<tr>	
						<td><b>Payment Method</b></td>
						<td>
						<?php
						//echo $order->from_paypal=="1" ? "PayPal" : "Bank Transfer";
						?>
						</td>
					</tr>
					<tr>
						<td><b>Status</b></td>
						<td><?php echo $status; ?></td>
					</tr>
				</table>
			</div>
			
			<br>
			<h3><b>Order Items</b></h3>
			
			<?php

			// retrieve order items
			$reservation->transactionid=$transactionid;
			$stmt1=$reservation->readAll_TransactionID();

			echo "<div class='table-responsive'>";
				echo "<table class='table table-hover table-bordered'>";
			
				// our table heading
				echo "<tr>";
					echo "<td class='textAlignLeft'><b>Accom ID</b></td>";
					echo "<td><b>Arrival (NZD)</b></td>";
					echo "<td><b>Departure</b></td>";
					echo "<td><b>Room Price</b></td>";
					echo "<td><b>Nights</b></td>";
					echo "<td><b>Subtotal</b></td>";
				echo "</tr>";
			
				while ($row_reservation = $stmt1->fetch(PDO::FETCH_ASSOC)){
					//extract($row);
					$accomid= $row_reservation['ACCOMID'];
					$arrival= $row_reservation['ARRIVAL'];
					$arrival1 = new DateTime($arrival);
					$arrival2= $arrival1->format('d-m-Y');
					$departure= $row_reservation['DEPARTURE'];
					$departure1 = new DateTime($departure);
					$departure2= $departure1->format('d-m-Y');
					$roomprice = $row_reservation['ROOMPRICE'];
					$days = $row_reservation['DAYS'];
				
					//creating new table row per record
					echo "<tr>";
						echo "<td>{$accomid}</td>";
						echo "<td>{$arrival2}</td>";
						echo "<td>{$departure2}</td>";
						echo "<td>&#36;" . number_format($roomprice, 2, '.', ',') . "</td>";
						echo "<td>{$days}</td>";
						echo "<td>&#36;" . number_format($roomprice * $days, 2, '.', ',') . "</td>";
					echo "</tr>";
				}
	
				// order total cost
				echo "<tr>";
					echo "<td><b>Total Cost</b></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td><b>&#36;" . number_format($totalcost, 2, '.', ',') . "</b></td>";
				echo "</tr>";
				
			echo "</table>";
		echo "</div>";
		}
		// tell the user that the order does not exist
		if(!$num>0){
			echo "<p>Order does not exist.</p>";
		}
		?>
	</div>
</div>

<?php
	// footer HTML and JavaScript codes
	include_once 'layout/template_footer.php';
?>
