<?php
//ob_start();  //this is so location header works
?>
<?php
// core configuration
include_once "../config/core.php";

// headings
include_once 'layout/admin_template_header.php';

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../objects/accomodation.php';
include_once '../objects/accomodation_image.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$accomodation = new Accomodation($db);
$accomimage = new AccomodationImage($db);

// include login checker
include_once "admin_login_checker.php";

// get id of the accomodation to be edited
$accomid=isset($_GET['id']) ? $_GET['id'] : die('Missing user ID.');

// set accomodation id property
$accomodation->accomid=$accomid;

// read accomodation details
$stmt=$accomodation->readByAccomId();

while ($row_accomodation = $stmt->fetch(PDO::FETCH_ASSOC)){
         //extract($row);
		$accom= $row_accomodation['ACCOMODATION'];
		$accomdesc= $row_accomodation['ACCOMDESC'];
}

echo "<caption><h2 align='center'>Update Accomodation</h2></caption>";

// if HTML form was posted / submitted
if($_POST){
	
	// assigned posted values to object properties
	$accomodation->accomodation=$_POST['accomodation'];
	$accomodation->accomdesc=$_POST['accomdesc'];
		
	// update information
	if($accomodation->update()){
		
		$accomimage->accomid=$accomid;
		$accomimage->upload();
		header('Location:admin_accomodation.php?action=accom_updated');
		
		
		// tell admin details were updated
		//echo "<p>Accomodation was updated.</p>";
	}

	// tell admin unable to update details
	else{
		echo "<p>Unable to update accomodation.</p>";
	}
}

// read accomodation button
echo "<div>";
	echo "<a href='admin_accomodation.php' class='btn btn-primary pull-left'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Accom";
	echo "</a>";
echo "</div>";
?>

	<!-- HTML form to update user -->
	<form action='admin_update_accom.php?id=<?php echo $accomid; ?>' method='post' enctype='multipart/form-data'>

		<div class='table-responsive'>
			<table class='table table-hover table-bordered'>
		
	        <tr>
	            <td width='20%'>Name:</td>
	            <td width= '80%'><input type='text' name='accomodation' value= "<?php echo $accom; ?>" class='form-control' required></td>
	        </tr>

	       <tr>
	           <td>Description:</td>
	            <td><input type='text' name='accomdesc' value ="<?php echo $accomdesc; ?>"class='form-control' required></td>
	        </tr>
						
			<tr>
				<td>Image(s):</td>
				<td>
				<?php
					// set product id
					$accomimage->accomid=$accomid;

					// read all images under the product id
					$stmt_accomimage = $accomimage->readAll();

					// count number of images under a product id
					$num_accomimage = $stmt_accomimage->rowCount();
										
					// if retrieved images greater was than 0
					if($num_accomimage>0){

						// loop through the retrieved product images
						while ($row = $stmt_accomimage->fetch(PDO::FETCH_ASSOC)){

							// product image id and name
							$accom_image_id = $row['IMAGEID'];
							$accom_image_name = $row['name'];

							// image source
							$image_source="../images/{$accom_image_name}";

							// display the image(s)
							echo "<img src='{$image_source}' Width='50' Height='75'/>";
							echo "<br>";
							echo "<a delete-id='{$accom_image_id}' file='image' class='delete-object' style='text-decoration: underline'>Delete Image?</a>";
							echo "<br>";
							echo "<br>";
						}
					}
				?>
					<!-- browse multiple image files -->
					<input type="file" name="files[]" class='form-control' multiple>
				</td>
			</tr>

			<tr>
	            <td></td>
	            <td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-edit"></span> Edit Accom
					</button>
	            </td>
	        </tr>

	   </table>
		</div>
		
	</form>
</div>

<?php
	include_once 'admin_template_footer.php';
?>