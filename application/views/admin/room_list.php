<div class="floor-master">
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#floor-master-Modal">
		  Add
		</button>

		<!-- Modal -->
		<div class="modal fade" id="floor-master-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		  <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add floor master</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form method="POST" id="Add-room" enctype="multipart/form-data">
					  <div class="form-group">
					    <label for="">Room master type</label>
					    <select name="room_type_id" class="form-control">
					    	<?php foreach ($types as $row): ?>
						    	<option value="<?php echo $row->id;?>"><?php echo $row->room_type;?></option>
						    	
					    	 <?php endforeach; ?>
					    </select>
					  </div>
					  <div class="form-group">
					    <label for="">Floor master</label>
					    <select name="floor_id" class="form-control">
					    	<?php foreach ($floors as $row): ?>
					    	<option value="<?php echo $row->id;?>"><?php echo $row->floor;?></option>
					    	<?php endforeach; ?>
					    </select>
					  </div>
					  <div class="form-group">
					    <label>Room master</label>
					    <input type="text" name="room_number" class="form-control" id=""  placeholder="Room number">
					  </div>
					  <div class="form-group">
					    <label>Description</label>
					    <textarea name="description" class="form-control"></textarea>
					  </div>
					  <div class="form-group">
					    <label>image</label>
					       <input type="file" name="userfile[]" id="files"  multiple required>
					  </div>
					  <div id="error-container"><span class="error"></span>
					 	<span class="success"></span>
					 </div>
					 <?php echo validation_errors(); ?>
					 <?php if (isset($error_message)) { echo $error_message; } ?>
					 
					  <button type="submit" class="btn btn-primary">save</button>
					   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</form>
		      </div>
		      
		    </div>
		  </div>
		</div>
		
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Room ID</th>
		      <th scope="col">Room type</th>
		      <th scope="col">Floor</th>
		      <th scope="col">Room number</th>
		      <th scope="col">Description</th>
		      <th scope="col">Image</th>
		      <th scope="col"></th>

		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach ($room as $row): ?>   	
		    <tr>
		      <th scope="row"><?php echo $row->id;?></th>
		      <td><?php echo $row->room_type;?></td>
		      <td><?php echo $row->floor;?></td>
		      <td><?php echo $row->room_number;?></td>
		      <td><?php echo $row->description;?></td>
		      <td><?php foreach ($images as $rows): ?>
				      <?php if ($row->id == $rows->room_id ) {?> 
				      	<ul class="image_ul">
				      		<li ><img src="<?php echo base_url($rows->image);?>" alt="Uploaded Image" width="150px"></li>
				      	</ul>
				      	
				      <?php } ?> 
				      <?php endforeach; ?></td>
		      <td><a onclick="updateRoomForm(<?php echo $row->id;?>)" id="update_type">Edit</a> |<a  href="<?php echo base_url('Admin_controller/deleteRooms/' . $row->id); ?>">Delete</a></td>
		    </tr>
		     <?php endforeach; ?>
		</tbody>
	</table>
		

	</div>
	<div class="modal" tabindex="-1" role="dialog" id="update_room_modal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Update room</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		       
		      </div>
		      
		    </div>
		  </div>
		</div>
	<script type="text/javascript">
		$(document).ready(function() {
        $("#Add-room").submit(function(e) {
        	var formData = new FormData(this);
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>Admin_controller/add_room",
                data: formData,
                processData: false, // Important: prevent jQuery from processing the data
	            contentType: false, // Important: let the server handle the content type
	            dataType: "json",
                success: function(response) {
                	var jsonData = response;
                	 console.log(response.success);
                	 if(response.success == false)
                	 {
                	 	 $("#error-container").find(".error").html(response.errors);

                        $("#error-container").find(".success").empty();
                	 }
                	 else
                	 {
                	 	$('input[type="text"],input[type="file"], textarea').val('');
                    	$("#error-container").find(".success").html("Data inserted sucess");
	                    setTimeout(function() {
	                        $("#error-container").find(".success").empty();
	                    }, 2000);
                        
                         $("#error-container").find(".error").empty();
                	 }
                	
                   

                }
            });
        });

    });
		function updateRoomForm($id) {
				$.ajax({
                url: "<?php echo site_url();?>Admin_controller/editFloortype/"+$id,
                type: "GET",
                success: function(response) {
                	$("#update_floor_modal").modal('show');
                    $("#update_floor_modal").find(".modal-body").html(response);
                },
                error: function() {
                    $(".table_list_view").html("Error loading content.");
                }
			})
			}
		


	</script>