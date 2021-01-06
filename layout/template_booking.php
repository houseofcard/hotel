<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="styles/template_booking.css">

<script src="plugins/jquery-datepicker/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="plugins/jquery-datepicker/jquery-ui.css">

<link href="plugins/jquery-datepicker/jquery-ui.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="styles/booking.css">
<script src="styles/bootstrap-4.1.2/popper.js"></script>
<script src="plugins/jquery-datepicker/jquery-ui.js"></script>

<?php
// core configuration
include_once 'config/core.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/capacity.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$capacity = new Capacity($db);

$stmt = $capacity->readCapacity();
?>

<!-- Booking -->

	<div class="booking">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="booking_container d-flex flex-row align-items-end justify-content-start">
						<form action="bookAroom.php" method="POST" class="booking_form" autocomplete="off">
							<div class="booking_form_container d-flex flex-lg-row flex-column align-items-start justify-content-start flex-wrap">
								<div class="booking_form_inputs d-flex flex-row align-items-start justify-content-between flex-wrap">
									<div class="booking_dropdown">
										<input type="text" class ="form-control" id="my_date_picker1" placeholder="Check in" name="arrival" readonly="true" required="required">
									</div>
									<div class="booking_dropdown">
										<input type="text" class ="form-control" id="my_date_picker2" placeholder="Check out" name="departure" readonly="true" required="required">
									</div>
									
									<div class='custom-select'>	
										<select name="guests" id="guests">
										<option value=' '>Rooms & Guests</option>
											<?php
											
											while ($row_capacity = $stmt->fetch(PDO::FETCH_ASSOC)){
												$description = $row_capacity['DESCRIPTION'];
												$capacityid = $row_capacity['CAPACITYID'];
												echo "<option value='{$capacityid}'>";
													echo $description;
												echo "</option>"; 
											}
											?>		
										</select>
									</div>
									
								</div>
									<button class="button ml-lg-auto" id="booking_buttion">VIEW RATES</button>
								<!--<button class="booking_form_button ml-lg-auto">VIEW RATES</button>-->
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<!--</body>
</html>-->

<script> 
$(document).ready(function() { 
  
    $(function() { 
        $("#my_date_picker1").datepicker({
			dateFormat: 'dd-mm-yy',
			minDate: '-0d',
			ignoreReadonly: true, // stops mobile keyboard
			allowInputToggle: true
		}); 
    }); 
	  
    $(function() { 
        $("#my_date_picker2").datepicker({
			dateFormat: 'dd-mm-yy',
			minDate: '+1',
			ignoreReadonly: true, // stops mobile keyboard
			allowInputToggle: true
		});					
    }); 
     $('#my_date_picker1').change(function() { 
        startDate = $(this).datepicker('getDate','+1d'); 
		if (startDate) { // Not null
            startDate.setDate(startDate.getDate() + 1);
       }
        $("#my_date_picker2").datepicker("option", "minDate", startDate); 
	}) 
    $('#my_date_picker2').change(function() { 
        endDate = $(this).datepicker('getDate'); 
		if (endDate) { // Not null
            endDate.setDate(endDate.getDate() - 1);
       }
        $("#my_date_picker1").datepicker("option", "maxDate", endDate); 
    }) 
}) 
</script>

