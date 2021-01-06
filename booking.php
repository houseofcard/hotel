<link rel="stylesheet" type="text/css"> <!--This is here to stop footer paralles image jumping around-->

<?php
// core configuration
include_once 'config/core.php';

// headings
include_once 'layout/template_header.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$cart_item = new CartItem($db);

// parameters
$action = isset($_GET['action']) ? $_GET['action'] : "";
?>

<div class="body_content">
	<div class="container">
		<caption><h2 align='left'>Your Booking Cart</h2></caption>
		<?php
		// display a message
		// if a booking was added to cart
		if($action=='added'){
			echo "<p>A booking was added to your cart!</p>";
		}

		// unable to add booking to cart
		else if($action=='failed_add'){
			echo "<p>A booking was not added to cart.</p>";
		}

		// booking removed from cart
		else if($action=='removed'){
			echo "<p>A booking was removed from your cart!</p>";
		}

		// booking removed from cart
		else if($action=='remove_failed'){
			echo "<p>A booking failed to be removed from your cart.  Please contact us.!</p>";
		}

		// empty cart
		else if($action=='empty_success'){
			echo "<p>Booking cart was emptied!</p>";
		}

		// empty cart failed
		else if($action=='empty_failed'){
			echo "<p>Unable to empty booking cart.</p>";
		}
		echo "<br>";

		//create the user_id for SQL method
		$cart_item->guestid=$_SESSION['user_id'];

		// read the database
		$stmt = $cart_item->readAllWithAccom();

		// count number of rows returned
		$num=$stmt->rowCount();
		
		if($num>0){
	
			echo "<div class='table-responsive'>";
				echo "<table class='table table-hover table-bordered'>";
		
					// table headers
					echo "<tr>";
						echo "<th>Room Description</th>";
						echo "<th>Check In</th>";
						echo "<th>Check Out</th> ";
						echo "<th>Adults</th> ";
						echo "<th>Children</th> ";
						echo "<th>Price</th>"; 
						echo "<th>Night(s)</th>";
						echo "<th>Subtotal</th>";
						echo "<th>Action</th>";
					echo "</tr>";		
	
					// loop through the records
					while ($row_cart_item = $stmt->fetch(PDO::FETCH_ASSOC)){
						$i=0;
						$accomid= $row_cart_item['ACCOMID'];
						$accomdesc = $row_cart_item['ACCOMDESC'];
						$guestid= $row_cart_item['GUESTID'];
						$price= $row_cart_item['PRICE'];
						$arrivaldb= $row_cart_item['ARRIVAL'];
						$departuredb= $row_cart_item['DEPARTURE'];
						$adults = $row_cart_item['ADULTS'];
						$children = $row_cart_item['CHILDREN'];
						$day= $row_cart_item['DAYS'];
						$total=$price * $day;
						$roomtypeid=$row_cart_item['ROOMTYPEID'];
						$arrive = new DateTime($arrivaldb);
						$arrival= $arrive->format('d-m-Y');
						$depart = new DateTime($departuredb);
						$departure= $depart->format('d-m-Y');

						// for delete item purposes
						$cart_item->departure=$departuredb;
		
						echo "<tr>";
							echo "<td>{$accomdesc}</td>";
							echo "<td>{$arrival}</td>";
							echo "<td>{$departure}</td>";
							echo "<td>{$adults}</td>";
							echo "<td>{$children}</td>";
							echo "<td>&#36;" . number_format($price, 2, '.', ',') . "</td>";
							echo "<td>{$day}</td>";
							echo "<td>&#36;" . number_format($total, 2, '.', ',') . "</td>";
							echo "<td>";
								echo"<a href='remove_from_cart.php?guestid={$guestid}&accomid={$accomid}&arrival={$arrivaldb}&departure={$departuredb}'>";
									echo "<span class='btn-lg btn-primary'>Remove";
								echo "</a>";
							echo "</td>";
						echo "</tr>";
				
						$payable += $total;
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
						echo "<td>";
							echo"<a href='empty_cart.php'>";
								echo "<span class='btn-lg btn-danger'>Empty";
							echo "</a>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>"; 

			if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){
			?> 
				<form method="post" action="payment.php">
					<button type="submit" class="button" name="continue">CONTINUE BOOKING PAYMENT</a></div>
				</form>
			<?php 
			}else{ 
			?>
				<div class="button"><a href="login.php"  name="continue">LOGIN</a></div>
			<?php
			}
		}
		
		// tell the user if there's no guest rows in the database
		if(!$num>0){
			echo "<p>No cart items found.</p>";
		}
		?>
	</div>
</div>

<?php
include_once 'layout/template_footer.php';
?>
