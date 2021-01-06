<link rel="stylesheet" type="text/css"> <!--This is here to stop footer paralles image jumping around-->

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
include_once "objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$order = new Order($db);

// set page title
$page_title="Orders";

// include login checker
include_once "login_checker.php";

// set user id as order object property
$order->guestid=$_SESSION['user_id'];

// read all orders in the database
$stmt = $order->readAll_ByGuest();

// count number of orders returned
$num = $stmt->rowCount();
?>
<div class="body_content">
	<div class="container">
		<caption><h3 align='left'>Orders</h3></caption>

		<?php
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
						echo "<a href='read_one_order.php?transactionid={$transactionid}' class='btn-lg btn-primary'>";
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
	</div>
</div>	
		
<?php
// footer HTML and JavaScript codes
include_once 'layout/template_footer.php';
?>