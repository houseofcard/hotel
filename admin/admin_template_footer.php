<script src="js/jquery.js"></script>

<!-- bootbox library -->
<script src="js/bootbox.min.js"></script>

<!-- bootstrap JavaScript -->
<script src="js/bootstrap/bootstrap.min.js"></script>

	<script>
// jQuery codes
$(document).ready(function(){
	
	// change order status
	$('input[type=radio][name=status]').change(function() {
		// get the transaction id
		var transaction_id=$(this).attr('transaction-id');

		// post the change status request to change_order_status.php file
		// post variable include transaction_id and status
		$.post("admin_change_order_status.php", {
			transaction_id: transaction_id,
			status: this.value
		}, function(data){

			// view the response in the log
			console.log(data);

			// tell the user order status was changed
			bootbox.alert("Order status was changed.");

		}).fail(function() {

			// in case posting the request failed, tell the user
			bootbox.alert("Unable to change order status.");

		});
	});
		
	// click listener for all delete buttons
	$(document).on('click', '.delete-object', function(){
		
		// current button
		var current_element=$(this);

		// id of record to be deleted
		var id = $(this).attr('delete-id');
		
		// php file used for deletion
		var file = $(this).attr('file');
		
		//window.alert(id);
		//window.alert(file);
		
		bootbox.confirm({
			message: "<h4>Are you sure?</h4>",
			buttons: {
				confirm: {
					label: '<span class="glyphicon glyphicon-ok"></span> Yes',
					className: 'btn-danger'
				},
				cancel: {
					label: '<span class="glyphicon glyphicon-remove"></span> No',
					className: 'btn-primary'
				}
			},
			callback: function (result) {
				
				if(result==true){
					if(file=='accom'){ 
						document.location.href = "admin_delete_accom.php?id=" + id;
					} 
					else if(file=='room'){ 
						document.location.href = "admin_delete_room.php?id=" + id;
					}
					else if(file=='roomtype'){ 
						document.location.href = "admin_delete_roomtype.php?id=" + id;
					}
					else if(file=='guest'){
						document.location.href = "admin_delete_guest.php?id=" + id;
					}	
					else if(file=='comment'){
						document.location.href = "admin_delete_comment.php?id=" + id;
					}	
					else if(file=='image'){
						document.location.href = "admin_delete_image.php?id=" + id;
					}	
				}
			}
		});

		return false;
	});
});	
</script>
