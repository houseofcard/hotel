<!DOCTYPE html>

<html lang="en">
<body>

<div id="main">

    <h3>Import SQL</h3>

    <?php
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {

        $conn = new mysqli('localhost', 'threecor', 'uaj478u5', 'threecor_hotel');
        if ($conn->connect_errno) {
            echo "Unable to connect to SQL";
            echo "<br>";
        }
		
		$sql = "CREATE TABLE IF NOT EXISTS `tblaccomodation` (
		`ACCOMID` int(11) NOT NULL AUTO_INCREMENT,
		`ACCOMODATION` varchar(90) NOT NULL,
		`ACCOMDESC` varchar(90) NOT NULL,
		`PRICERANGE` varchar(90) NOT NULL,
		PRIMARY KEY (`ACCOMID`)
		) AUTO_INCREMENT=1";
		
		if($conn->query($sql) === TRUE) {
			echo "Table tblaccomodation created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
		
		$sql="INSERT INTO `tblaccomodation` (`ACCOMID`, `ACCOMODATION`, `ACCOMDESC`,  `PRICERANGE`) VALUES
		(12, 'Single Room Standard', 'Two single beds, maximum two people per room.', '$100 per adult and $50 per child.'),
		(13, 'Single Room Delux', 'Two single beds, maximum two people per room.', '$125 per adult and $75 per child.'),
		(14, 'Double Room Standard', 'One double bed, maximum two people per room.', '$125 per adult and $75 per child.'),
		(15, 'Double Room Delux', 'One double bed, maximum two people per room', '$150 per adult and $100 per child.')";
				
		if($conn->query($sql) === TRUE) {
			echo "Import into tblaccomodation successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}

		$sql = "CREATE TABLE IF NOT EXISTS `tblaccomimages` (
		`IMAGEID` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(512) NOT NULL,
		`ACCOMID` int(11) NOT NULL,
		PRIMARY KEY (`IMAGEID`),
		KEY `ACCOMID` (`ACCOMID`)
		) AUTO_INCREMENT=1" ;
		
		if($conn->query($sql) === TRUE) {
			echo "Table tblaccomimages created successfully";
			echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}	
		
		$sql = "INSERT INTO `tblaccomimages` (`IMAGEID`, `name`, `ACCOMID`) VALUES
		(1, 'rooms1.jpg', 12),
		(2, 'rooms2.jpg', 13),
		(3, 'rooms3.jpg', 14),
		(4, 'rooms4.jpg', 15)";
		
		if($conn->query($sql) === TRUE) {
			echo "Import into tblaccomimages successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}
		
		$sql="CREATE TABLE IF NOT EXISTS `tblroomtype` (
		`ROOMTYPEID` int(11) NOT NULL AUTO_INCREMENT,
		`ACCOMID` int(11) NOT NULL,
		`ADULTS` int(11) NOT NULL,
		`CHILDREN` int(11) NOT NULL,
		`ROOMDESC` varchar(30) NOT NULL,
		`PRICE` double NOT NULL,
		PRIMARY KEY (`ROOMTYPEID`),
		KEY `ACCOMID` (`ACCOMID`)
		) AUTO_INCREMENT=1";

		if($conn->query($sql) === TRUE) {
			echo "Table tblroomtype created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
		
		$sql="INSERT INTO `tblroomtype` (`ROOMTYPEID`, `ACCOMID`, `ADULTS`, `CHILDREN`, `ROOMDESC`, `PRICE`) VALUES
		(1, 12, 0, 1, 'Single Room Standard', 50.00),
		(2, 12, 0, 2, 'Single Room Standard', 100.00),
		(3, 12, 1, 0, 'Single Room Standard', 100.00),
		(4, 12, 1, 1, 'Single Room Standard', 150.00),
		(5, 12, 2, 0, 'Single Room Standard', 200.00),
		(6, 13, 0, 1, 'Single Room Delux', 75.00),
		(7, 13, 0, 2, 'Single Room Delux', 150.00),
		(8, 13, 1, 0, 'Single Room Delux', 125.00),
		(9, 13, 1, 1, 'Single Room Delux', 200.00),
		(10, 13, 2, 0, 'Single Room Delux', 250.00),
		(11, 14, 0, 1, 'Double Room Standard', 75.00),
		(12, 14, 0, 2, 'Double Room Standard', 150.00),
		(13, 14, 1, 0, 'Doublee Room Standard', 125.00),
		(14, 14, 1, 1, 'Double Room Standard', 200.00),
		(15, 14, 2, 0, 'Double Room Standard', 250.00),
		(16, 15, 0, 1, 'Double Room Delux', 100.00),
		(17, 15, 0, 2, 'Double Room Delux', 200.00),
		(18, 15, 1, 0, 'Doublee Room Delux', 150.00),
		(19, 15, 1, 1, 'Double Room Delux', 250.00),
		(20, 15, 2, 0, 'Double Room Delux', 300.00)";
		
		if($conn->query($sql) === TRUE) {
			echo "Import into tblroomtype successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}

		$sql="CREATE TABLE IF NOT EXISTS `tblroom` (
		`ROOMID` int(11) NOT NULL AUTO_INCREMENT,
		`ROOMNUM` int(11) NOT NULL,
		`ACCOMID` int(11) NOT NULL,
		PRIMARY KEY (`ROOMID`),	
		KEY `ACCOMID` (`ACCOMID`)
		) AUTO_INCREMENT=1";
		
		if($conn->query($sql) === TRUE) {
			echo "Table tblroom created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
		
		$sql="INSERT INTO `tblroom` (`ROOMID`, `ROOMNUM`, `ACCOMID`) VALUES
		(11, 1, 12),
		(12, 2, 12),
		(13, 3, 12),
		(14, 4, 12),
		(15, 5, 13),
		(16, 6, 13),
		(17, 7, 13),
		(18, 8, 14),
		(19, 9, 14),
		(20, 10, 15),
		(21, 10, 15),
		(22, 11, 15)";
		
		if($conn->query($sql) === TRUE) {
			echo "Import into tblroom successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}
						
		$sql="CREATE TABLE IF NOT EXISTS `tblreservation` (
		`RESERVEID` int(11) NOT NULL AUTO_INCREMENT,
		`TRANSACTIONID` varchar(512) NOT NULL,
		`TRANSDATE` datetime NOT NULL,
		`GUESTID` int(11) NOT NULL,
		`ACCOMID` int(11) NOT NULL,
		`ARRIVAL` datetime NOT NULL,
		`DEPARTURE` datetime NOT NULL,
		`ADULTS` varchar(512) NOT NULL,
		`CHILDREN` varchar(512) NOT NULL,
		`DAYS` int(11) NOT NULL,
		`ROOMPRICE` double NOT NULL,
		PRIMARY KEY (`RESERVEID`),
		KEY `GUESTID` (`GUESTID`),
		KEY `ACCOMID` (`ACCOMID`)
		) AUTO_INCREMENT=4";

		if($conn->query($sql) === TRUE) {
			echo "Table tblreservation created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
				
		$sql="CREATE TABLE IF NOT EXISTS `tblguest` (
  		GUESTID int(11) NOT NULL AUTO_INCREMENT,
		G_FNAME varchar(30) NOT NULL,
		G_LNAME varchar(30) NOT NULL,
		G_ADDRESS varchar(90) NOT NULL,
		G_CITY varchar(90) NOT NULL,
		G_COUNTRY varchar(90) NOT NULL,
		G_ZIP int(11) NOT NULL,
		G_PHONE varchar(20) NOT NULL,
		`G_DBIRTH` datetime NOT NULL,
		G_NATIONALITY varchar(30) NOT NULL,
		G_COMPANY varchar(90),
		G_CADDRESS varchar(90),
		ACCESS_LEVEL varchar(16) NOT NULL,
		CURRENT_MEMBER varchar(16) NOT NULL,
		G_EMAIL varchar(99) NOT NULL,
		G_PASSWORD varchar(255) NOT NULL,
		PRIMARY KEY (`GUESTID`)
		) AUTO_INCREMENT=1";

		if($conn->query($sql) === TRUE) {
			echo "Table tblguest created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
		
		$sql="CREATE TABLE IF NOT EXISTS `tblcart_items` (
		`CARTID` int(11) NOT NULL AUTO_INCREMENT,
		`GUESTID` varchar(512) NOT NULL COMMENT 'can be a temporary id',
		`ACCOMID` int(11) NOT NULL,
		`ARRIVAL` datetime NOT NULL,
		`DEPARTURE` datetime NOT NULL,
		`DAYS` int(11) NOT NULL,
		`PRICE` double NOT NULL,
		`ADULTS` int(11) NOT NULL,
		`CHILDREN` double NOT NULL,
		PRIMARY KEY (`CARTID`),	
		KEY `GUESTID` (`GUESTID`),
		KEY `ACCOMID` (`ACCOMID`)
		) AUTO_INCREMENT=1";
		
		if($conn->query($sql) === TRUE) {
			echo "Table tblcart_items created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
		
		$sql="CREATE TABLE IF NOT EXISTS `tblorder` (
		`ORDERID` int(11) NOT NULL AUTO_INCREMENT,
		`TRANSACTIONID` varchar(512) NOT NULL,
		`GUESTID` varchar(512) NOT NULL COMMENT 'can be a temporary id',
		`TOTALCOST` decimal(19,2) NOT NULL,
		`STATUS` varchar(30) NOT NULL,
		`CREATED` datetime NOT NULL,
		PRIMARY KEY (`ORDERID`),	
		KEY `GUESTID` (`GUESTID`)
		) AUTO_INCREMENT=1";
		
		if($conn->query($sql) === TRUE) {
			echo "Table tblorders created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
				
		$sql="CREATE TABLE IF NOT EXISTS `tblpayment` (
		`SUMMARYID` int(11) NOT NULL AUTO_INCREMENT,
		`TRANSDATE` datetime NOT NULL,
		`CONFIRMATIONCODE` varchar(30) NOT NULL,
		`PQTY` int(11) NOT NULL,
		`GUESTID` int(11) NOT NULL,
		`SPRICE` double NOT NULL,
		`MSGVIEW` tinyint(1) NOT NULL,
		`STATUS` varchar(30) NOT NULL,
		PRIMARY KEY (`SUMMARYID`),
		UNIQUE KEY `CONFIRMATIONCODE` (`CONFIRMATIONCODE`),
		KEY `GUESTID` (`GUESTID`)
		) AUTO_INCREMENT=1";

		if($conn->query($sql) === TRUE) {
			echo "Table tblpayment created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
				
		$sql="CREATE TABLE IF NOT EXISTS `tblauto` (
		AUTOID int(11) NOT NULL AUTO_INCREMENT,
		START int(11) NOT NULL,
		END int(11) NOT NULL,
		PRIMARY KEY (`autoid`)
		) AUTO_INCREMENT=2" ;
	
		if($conn->query($sql) === TRUE) {
			echo "Table tblauto created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
		
		$sql="INSERT INTO `tblauto` (`AUTOID`, `START`, `END`) VALUES
		(1, 11122, 1)";

		if($conn->query($sql) === TRUE) {
			echo "Import into tblauto successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}
		
		$sql="CREATE TABLE IF NOT EXISTS `tblcapacity` (
		`CAPACITYID` int(11) NOT NULL AUTO_INCREMENT,
		`CAPACITY` int(11) NOT NULL,
		`DESCRIPTION` varchar(40) NOT NULL,
		`C_ADULTS` int(11) NOT NULL,
		`C_CHILDREN` int(11) NOT NULL,
		PRIMARY KEY (`CAPACITYID`)	
		) AUTO_INCREMENT=1";
		
		if($conn->query($sql) === TRUE) {
			echo "Table tblcapacity created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}
		
		$sql="INSERT INTO `tblcapacity` (`CAPACITYID`, `CAPACITY`, `DESCRIPTION`, `C_ADULTS`, `C_CHILDREN`) VALUES
		(11, 2, 'Room: 1 Adult', 1, 0),
		(12, 2, 'Room: 1 Adult, 1 Child', 1, 1),
		(13, 2, 'Room: 2 Adults', 2, 0),
		(14, 2, 'Room: 1 Child', 0, 1),
		(15, 2, 'Room: 2 Children', 0, 2)";
		
		if($conn->query($sql) === TRUE) {
			echo "Import into tblcapacity successfully";
			echo "<br>";
		}else {
			echo "Error: " .$sql . "<br>" .$conn->error;
		}
		
		$sql="CREATE TABLE IF NOT EXISTS `tblcomments` (
		`COMMENTID` int(11) NOT NULL AUTO_INCREMENT,
		`COMMENT_NAME` varchar(30) NOT NULL,
		`COMMENT_EMAIL` varchar(99) NOT NULL,
		`SUBJECT` varchar(70) NOT NULL,
		`MESSAGE` varchar(90) NOT NULL,
		`CREATED` datetime NOT NULL,
		PRIMARY KEY (`COMMENTID`)	
		) AUTO_INCREMENT=1";
		
		if($conn->query($sql) === TRUE) {
			echo "Table tblcomments created successfully";
				echo "<br>";
		}else {
			echo "Error creating table: " .$conn->error;
		}		
	}
	$conn->close();
	?>	
</div>

</body>
</html>	
