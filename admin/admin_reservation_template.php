<?php
ob_start(); //this is so location header works
?>
<?php
// include login checker
include_once "admin_login_checker.php";

echo "<caption><h2 align='center'>Reservation Details</h2></caption>";

// order opposite of the current order
$reverse_order=isset($order) && $order=="ASC" ? "DESC" : "ASC";
				
// field name
$field=isset($field) ? $field : "";

// field sorting arrow
$field_sort_html="";

if(isset($field_sort) && $field_sort==true){
	$field_sort_html.="<span class='badge'>";
	$field_sort_html.=$order=="asc" ? "<span class='glyphicon glyphicon-arrow-up'></span>" : "<span class='glyphicon glyphicon-arrow-down'></span>";
	$field_sort_html.="</span>";
}

echo "<div class='table-responsive'>";
	echo "<table class='table table-hover table-bordered'>";
		
		// table headers
		echo "<tr>";
			echo "<th>"; 
				echo "<a href='admin_reservation_sorted_by_fields.php?field=RESERVEID&order={$reverse_order}'>";
					echo "Reservation ID";
					echo $field=="RESERVEID" ? $field_sort_html : "";
				echo "</a>";
			echo "</th>";
			echo "<th>";
				echo "<a href='admin_reservation_sorted_by_fields.php?field=TRANSACTIONID&order={$reverse_order}'>";
					echo "Transaction ID";
					echo $field=="TRANSACTIONID" ? $field_sort_html : "";
				echo "</a>";
			echo "</th>";
			echo "<th>";
				echo "<a href='admin_reservation_sorted_by_fields.php?field=TRANSDATE&order={$reverse_order}'>";
					echo "Transaction Date";
					echo $field=="TRANSDATE" ? $field_sort_html : "";
				echo "</a>";
			echo "</th>";
			echo "<th>";
				echo "<a href='admin_reservation_sorted_by_fields.php?field=GUESTID&order={$reverse_order}'>";
					echo "Guest ID";
					echo $field=="GUESTID" ? $field_sort_html : "";
				echo "</a>";
			echo "</th>";
			echo "<th>";
				echo "<a href='admin_reservation_sorted_by_fields.php?field=ACCOMID&order={$reverse_order}'>";
					echo "Accomodation ID";
					echo $field=="ACCOMID" ? $field_sort_html : "";
				echo "</a>";
			echo "</th>";
			echo "<th>";
				echo "<a href='admin_reservation_sorted_by_fields.php?field=ARRIVAL&order={$reverse_order}'>";
					echo "Arrival";
					echo $field=="ARRIVAL" ? $field_sort_html : "";
				echo "</a>";
			echo "</th>";
			echo "<th>";
				echo "<a href='admin_reservation_sorted_by_fields.php?field=DEPARTURE&order={$reverse_order}'>";
					echo "Departure";
					echo $field=="DEPARTURE" ? $field_sort_html : "";
				echo "</a>";
			echo "</th>";
			echo "<th>Days</th>";
			echo "<th>Room Price</th>";
		echo "</tr>";
		
		// loop through the records
		while ($row_reservation = $stmt->fetch(PDO::FETCH_ASSOC)){
			//extract($row);
			$reserveid= $row_reservation['RESERVEID'];
			$transid= $row_reservation['TRANSACTIONID'];
			$transdate= $row_reservation['TRANSDATE'];
			$guestid= $row_reservation['GUESTID'];
			$accomid= $row_reservation['ACCOMID'];
			$arrivaldb= $row_reservation['ARRIVAL'];
			$departuredb =$row_reservation['DEPARTURE'];
			$days =$row_reservation['DAYS'];
			$roomprice=$row_reservation['ROOMPRICE'];
			$arrive = new DateTime($arrivaldb);
			$arrival= $arrive->format('d-m-Y');
			$depart = new DateTime($departuredb);
			$departure= $depart->format('d-m-Y');
			
			echo "<tr>";
				echo "<td>{$reserveid}</td>";
				echo "<td>{$transid}</td>";
				echo "<td>{$transdate}</td>";
				echo "<td>{$guestid}</td>";
				echo "<td>{$accomid}</td>";
				echo "<td>{$arrival}</td>";
				echo "<td>{$departure}</td>";
				echo "<td>{$days}</td>";
				echo "<td>{$roomprice}</td>";
			echo "</tr>";	
		}	
	echo "</table>";
echo "</div>";
?>