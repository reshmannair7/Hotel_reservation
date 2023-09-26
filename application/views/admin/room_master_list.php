<div class="room-master-type">
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#room-master-type-Modal">
		  Add
		</button>

		<!-- Modal -->
		<div class="modal fade" id="room-master-type-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add room master type</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form method="POST" id="Add-room-types" action="">
					  <div class="form-group">
					    <label for="">Room master type</label>
					    <input type="text" name="room_type" class="form-control" id=""  placeholder="Enter type">
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
		      <th scope="col">Room Mater</th>
		      <th scope="col">Created date</th>
		      <th scope="col"></th>
		    </tr>
		  </thead>
		  <tbody>
		  	  <?php foreach ($records as $row): ?>
		    <tr>
		      <th scope="row"><?php echo $row->id;?></th>
		      <td><?php echo $row->room_type;?></td>
		      <td><?php echo $row->created_at ?></td>
		      <td><a onclick="updateForm(<?php echo $row->id;?>)" id="update_type">Edit</a> |<a  href="<?php echo base_url('Admin_controller/deleteRoomtype/' . $row->id); ?>">Delete</a></td>
		    </tr>
		    <?php endforeach; ?>
		  </tbody>
		</table>

	</div>
	<div class="modal" tabindex="-1" role="dialog" id="update_type_modal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Update room type</h5>
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
			function updateForm($id) {
				$.ajax({
                url: "<?php echo site_url();?>Admin_controller/editRoomtype/"+$id,
                type: "GET",
                success: function(response) {
                	$("#update_type_modal").modal('show');
                    $("#update_type_modal").find(".modal-body").html(response);
                },
                error: function() {
                    $(".table_list_view").html("Error loading content.");
                }
			})
			}

	
	</script>