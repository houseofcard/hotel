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
include_once 'objects/reservation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$guest = new Guest($db);
$reservation = new Reservation($db);

// get items from place_order.php
$transaction_id = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : "";

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
	$email = $row_guest['G_EMAIL'];
}

//create the user_id for SQL method
$reservation->transactionid=$transaction_id;

// read the database
$stmt_reservation = $reservation->readAllWithAccom();
?>

<div class="body_content">
<div class="container"> 
    <div class="col-xs-12 col-sm-11">
		<!--<td valign="top" class="body" style="padding-bottom:10px;">-->
		
			<caption><h3 align='left'>Reservation Details</h3></caption>

           <form action="index.php?view=payment" method="post"  name="" >
				<span id="printout">
					<p>
						<? echo date("d/m/Y") ; ?>
						<br/><br/>
						<?php echo $firstname.' '.$lastname;?> <br/>
						<?php echo $address;?><br/>
						<?php echo $phone;?> <br/>
						<?php echo $email;?><br/><br/> 
						Dear Sir/Madam. <br/><br/>
						Greetings from Mirimar Resorts.<br/><br/>
						Please check the details of your reservation:<br/><br/>
						<strong>GUEST NAME(S):</strong> <?php echo $firstname.' '.$lastname;?>
					</p>
					
					<div class='table-responsive'>
						<table class='table table-hover table-bordered'>
							<tr>
								<th>Room Description</th>
								<th>Check In</th>
								<th>Check Out</th>
								<th>Adults</th>
								<th>Children</th>
								<th>Price</th>
								<th>Night(s)</th>
								<th>Subtotal</th>
							</tr> 
									
							<?php
				
							while ($row_reservation = $stmt_reservation->fetch(PDO::FETCH_ASSOC)){
								$i=0;
								$reservation_desc = $row_reservation['ACCOMDESC'];
								$reservation_arrivaldb=$row_reservation['ARRIVAL'];
								$arrive = new DateTime($reservation_arrivaldb);
								$arrival= $arrive->format('d-m-Y');
								$reservation_departuredb=$row_reservation['DEPARTURE'];
								$depart = new DateTime($reservation_departuredb);
								$departure= $depart->format('d-m-Y');
								$reservation_adults = $row_reservation['ADULTS'];
								$reservation_children = $row_reservation['CHILDREN'];
								$reservation_price = $row_reservation['ROOMPRICE'];
								$reservation_nights= $row_reservation['DAYS'];
								$reservation_subtotal=$reservation_price * $reservation_nights;
						
								echo "<tr>";
									echo "<td>{$reservation_desc}</td>";
									echo "<td>{$arrival}</td>";
									echo "<td>{$departure}</td>";
									echo "<td>{$reservation_adults}</td>";
									echo "<td>{$reservation_children}</td>";
									echo "<td>&#36;" . number_format($reservation_price, 2, '.', ',') . "</td>";
									echo "<td>{$reservation_nights}</td>";
									echo "<td>&#36;" . number_format($reservation_subtotal, 2, '.', ',') . "</td>";
								echo "</tr>";
							
								$reservation_payable += $reservation_subtotal;
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
								echo "<td><b>&#36;" . number_format($reservation_payable, 2, '.', ',') . "</b></td>";
							echo "</tr>";
							?>
						</table>
					</div>
					<p>We are eagerly anticipating your arrival and would like to advise you of the following in order to help you with your trip planning.Your reservation number is <b><?php// echo $_SESSION['confirmation']?>:</b><br/><br/>Should there be a concern with your reservation, a customer service representative will contact you. Otherwise, consider your reservation confirmed.</p>
					<ul>
						<li>Function Room rate is $500.00 for first four hours and $100.00 for each succeeding hours.</li>
						<li>No pets allowed.</li>
						<li>Outside foods are allowed inside the guest house.</li>
						<li>Check in time is 1pm and Check out time is 12 noon.</li>
						<li>Guest arriving before 1 pm shall be accommodated if rooms are vacant and ready.</li>
						<li>Free WIFI access.</li>
						<li>Room rates inclusive of government tax and service charge.</li>
						<li>Rates are subject to change without prior notice.</li>
						<li>Cancellation notification must be made at least 10 days prior to arrival for refund of deposits. Cancellation received within the 10 days period will result to forfeiture of full deposits.</li>
						<li>We serve Breakfast, Lunch and Dinner upon request with 2 hours notice.</li><br>
						<li><strong>I have agreed that I will present the following documents upon check in:</strong></li><br/>
						<li>Copy of BDO Payment.</li>
						<li>Authorization letter issued by BDO payer for guest/s whose transactions were paid for in his/ her behalf.</li>
					</ul>
					<p>If you have any questions, please email at mirimar.com or call (034) 4713 – 135</p>
					<br/>
					<p>Thank you for choosing Mirimar Resorts</p>
					<br/>
					<p>Respectfully your,</p>
					<br/>
					<p>Mirimar Resorts</p>
					<br/><br/>
				</span>
				<div>
				<!--<div id="divButtons" name="divButtons">-->
					<a href="print_reservation.php?transaction_id=<?php echo $transaction_id; ?>" target="blank">
					<span class="btn btn-primary btn-lg"><i class="fa fa-print"></i> Print</a>
					<!-- <input type="button" value="Print" onclick="tablePrint();" class="btn btn-primary"> -->
				</div>
			</form>
		<!--</td>-->
		<br/><br/><br/>	
	</div>
</div>
</div>
<?
include_once 'layout/template_footer.php';
?>

 <script>
function tablePrint(){ 
 document.all.divButtons.style.visibility = 'hidden';  
    var display_setting="toolbar=no,location=no,directories=no,menubar=no,";  
    display_setting+="scrollbars=no,width=500, height=500, left=100, top=25";  
    var content_innerhtml = document.getElementById("printout").innerHTML;  
    var document_print=window.open("","",display_setting);  
    document_print.document.open();  
    document_print.document.write('<body style="font-family:verdana; font-size:12px;" onLoad="self.print();self.close();" >');  
    document_print.document.write(content_innerhtml);  
    document_print.document.write('</body></html>');  
    document_print.print();  
    document_print.document.close(); 
   
    return false;  
    } 
  $(document).ready(function() {
    oTable = jQuery('#list').dataTable({
    "bJQueryUI": true,
    "sPaginationType": "full_numbers"
    } );
  });   
</script>


    