<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin.css')?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	
	<title>User dashboard</title>
</head>
<body>
	<?php foreach ($records as $row): ?>
	<header>
		<nav class="navbar navbar-light bg-light">

		  <a class="navbar-brand" href="#">
		    <?php echo $row->name;?> 
		  </a>
		  <a class="navbar-brand" href="#" data-toggle="modal" data-target="#user-profile">
		    profile
		  </a>
		  <a href="<?php echo site_url('Admin_controller/logout'); ?>">Logout</a>
		  </nav>
</header>
<?php endforeach; ?>
<div class="row">
<div class="col-2">
	<div class="left-sidenav">
		<ul class="list_views">
			<li id="room_master_list">Reservation history</li>
			
			

	</div>

</div>
<div class="col-10 table_list_view">
	<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ReservationForm">
  Book room
</button>

<!-- Modal -->
<div class="modal fade" id="ReservationForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form method="POST" id="Add-room" enctype="multipart/form-data">
					  <div class="form-group">
					    <label for="">Room type</label>
					    <select name="room_type_id" class="form-control" id="room_type_id">
					    	<option disable>Select room type</option>
					    	<?php foreach ($types as $row): ?>
						    	<option value="<?php echo $row->id;?>"><?php echo $row->room_type;?></option>
						    	
					    	 <?php endforeach; ?>
					    </select>
					  </div>
					  <div class="form-group">
					    <label for="">Floor</label>
					    
					    <select name="floor_id" class="form-control" id="floor_data">
					    	<option disable>Select floor</option>
					    	<?php foreach ($floors as $row): ?>
					    	<option value="<?php echo $row->id;?>"><?php echo $row->floor;?></option>
					    	<?php endforeach; ?>
					    </select>
					  </div>
					  <div class="form-group">
					    <label>Room</label>
					    <select name="room_number" class="form-control" id="roomNumber">
					    	<option disable>Select room</option>
					    </select>
					  </div>
					  <div class="form-group">
					    <label>Description</label>
					    <textarea name="description" class="form-control"></textarea>
					  </div>
					  <!-- <div class="form-group">
					    <label>image</label>
					       <input type="file" name="userfile[]" id="files"  multiple required>
					  </div> -->
					  <div id="error-container"><span class="error"></span>
					 	<span class="success"></span>
					 </div>
					 
					 
					  <button type="submit" class="btn btn-primary">save</button>
					   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
	<div class="row">
		<?php foreach ($rooms as $row): ?>
		<div class="col-md-4">
			<div class="card" style="width: 18rem;">
			 
			  <div class="card-body">
			    <h5 class="card-title">#<?php echo $row->room_number;?></h5>
			    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
			    <a href="#" class="btn btn-primary">Go somewhere</a>
			  </div>
			</div>
		</div>
		<?php endforeach; ?>
		
		
	</div>
</div>
	<div class="modal fade" id="user-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<?php foreach ($records as $row): ?>
        <p><?php echo $row->name;?> </p>
        <p><?php echo $row->email;?> </p>
        <p><?php echo $row->phone_number;?> </p>
		<?php endforeach; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
	<script>
$(document).ready(function() {
    $("#floor_data").change(function() {
        var room_type_id = $('#room_type_id').val();
        var floor_id = $('#floor_data').val();
        console.log(floor_id);
        
        // Make an AJAX request to the CodeIgniter controller
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Admin_controller/AllfetchData'); ?>",
            data: { room_type_id: room_type_id, floor_id: floor_id },
            dataType: "json",
            success: function(data) {
            	
            	var roomNumber = $('#roomNumber');
                roomNumber.empty();
               $.each(data.result, function(index, room) {
               	console.log(room.id);
                         roomNumber.append('<option value=' + room.id + '>' + room.room_number + '</option>');
                    });
                
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    });
});
</script>

		
		
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>