<?php
ob_start(); //this is so location header works
?>
<?php
// core configuration
include_once "../config/core.php";

// headings
include_once 'layout/admin_template_header.php';

// connect to database
include_once '../config/database.php';

// include objects and classes
//include_once '../libs/php/utils.php';
include_once "../objects/comments.php";

// initialize utilities class
//$utils = new Utils();

// get databae connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$comment = new Comments($db);

// include login checker
include_once "admin_login_checker.php";

//create action variable
$action = isset($_GET['action']) ? $_GET['action'] : "";

echo "<caption><h2 align='center'>Comment Details</h2></caption>";

if ($action=='comment_deleted') {	
	echo"<p>Comment was deleted!</p>";
}	

// read the database
$stmt=$comment->readComment();

// count number of rows returned
$num = $stmt->rowCount();

echo "<div class='table-responsive'>";
	echo "<table class='table table-hover table-bordered'>";

		// table headers
		echo "<tr>";
			echo "<th width='10%'>ID</th>";
			echo "<th width='10%'>Name</th>";
			echo "<th width='15%'>Email</th>";
			echo "<th width='10%'>Subject</th>";
			echo "<th width='30%'>Comment</th>";
			echo "<th width='10%'>Created</th>";
			echo "<th width= 15%>Actions</th>";
		echo "</tr>";
		
		 // loop through the records
		while ($row_comment = $stmt->fetch(PDO::FETCH_ASSOC)){
			//extract($row);
			$commentid= $row_comment['COMMENTID'];
			$commentname= $row_comment['COMMENT_NAME'];
			$commentemail= $row_comment['COMMENT_EMAIL'];
			$subject= $row_comment['SUBJECT'];
			$message= $row_comment['MESSAGE'];
			$created= $row_comment['CREATED'];
			
			echo "<tr>";
				echo "<td>{$commentid}</td>";
				echo "<td>{$commentname}</td>";
				echo "<td>{$commentemail}</td>";
				echo "<td>{$subject}</td>";
				echo "<td>{$message}</td>";	
				echo "<td>{$created}</td>";	
				echo "<td>";
									
					//delete button
					echo "<a delete-id='{$commentid}' file='comment' class='btn btn-danger delete-object btn-block'>";
					//echo "<a delete-id='{$roomid}' file='room' class='btn btn-danger delete-object btn-block'>";
					//echo "<a href='admin_delete_room.php?roomid={$roomid}' class='btn btn-danger delete-object btn-block'>";
						echo "<span class='glyphicon glyphicon-remove'></span> Delete";
					echo "</a>";
				echo "</td>";
			echo "<tr>";
		}
     echo "</table>";
echo "</div>";

// tell the user there are no room rows in the database
if(!$num>0){
	echo "<p>No comment rows found.</p>";
}
?>

<?php
	include_once 'admin_template_footer.php';
?>