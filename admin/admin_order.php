<!-- jQuery library -->
<script src="js/jquery.js"></script>

<!-- bootbox library -->
<script src="js/bootbox.min.js"></script>

<!-- our custom JavaScript -->
<!--<script src="js/custom-script2.js"></script>-->

<!-- bootstrap JavaScript -->
<script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/bootstrap/docs-assets/js/holder.js"></script>
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
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$order = new Order($db);

// include login checker
include_once "admin_login_checker.php";

echo "<caption><h2 align='center'>Order Details</h2></caption>";

echo "<ul class='nav nav-tabs'>";
	echo $status=="Pending Reconciliation" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
		echo "<a href='admin_order.php'>Pending Reconciliation</a>";
	echo "</li>";
	echo $status=="Payment Reconciled" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
		echo "<a href='admin_order.php?status=Payment Reconciled'>Payment Reconciled</a>";
	echo "</li>";
	echo $status=="Completed" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
		echo "<a href='admin_order.php?status=Completed'>Items Sent / Order Completed</a>";
	echo "</li>";
	echo $status=="Order Cancelled" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
		echo "<a href='admin_order.php?status=Order Cancelled'>Order Cancelled</a>";
	echo "</li>";
echo "</ul>";

$status=isset($_GET['status']) ? $_GET['status'] : "Pending Reconciliation";
$order->status=$status;

// read all orders in the database
$stmt = $order->readAll();

// count number of orders returned
$num = $stmt->rowCount();

echo "<div class='table-responsive'>";
	echo "<table class='table table-hover table-bordered'>";

		// table headers
		echo "<tr>";
			echo "<th class='textAlignLeft'>Transaction ID</th>";
			echo "<th>Transaction Date</th>";
			echo "<th>Customer Name</th>";
			echo "<th>Total Cost</th>";
			echo "<th>Status</th>";
			echo "<th>Action</th>";
		echo "</tr>";

		// loop through the order records
		while ($row_order = $stmt->fetch(PDO::FETCH_ASSOC)){
			//extract($row);
			$transactionid= $row_order['TRANSACTIONID'];
			$createddb= $row_order['CREATED'];
			$fname= $row_order['G_FNAME'];
			$lname= $row_order['G_LNAME'];
			$totalcost= $row_order['TOTALCOST'];
			$status= $row_order['STATUS'];
			$guestid= $row_order['GUESTID'];
			$create=new DateTime($createddb);
			$created= $create->format('d-m-Y, H:i:s');
			
			// display order details
			echo "<tr>";
				echo "<td>{$transactionid}</td>";
				echo "<td>{$created}</td>";
				echo "<td>{$fname} {$lname}</td>";
				echo "<td>&#36;" . number_format($totalcost, 2, '.', ',') . "</td>";
				echo "<td>{$status}</td>";
				echo "<td>";

				// view details button
				echo "<a href='admin_read_one_order.php?transactionid={$transactionid}' class='btn btn-primary'>";
					echo "<span class='glyphicon glyphicon-list'></span> View Details";
				echo "</a>";
				echo "</td>";
			echo "</tr>";
		}
	echo "</table>";
echo "</div>";		

// display the table if number of orders retrieved is greater than zero
if(!$num>0){
	echo "<p>No order rows found.</p>";
}

?>
