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
		        <form method="POST" id="Add-floor-types">
					  <div class="form-group">
					    <label >Floor master</label>
					    <input type="text" name="floor" class="form-control" id=""  placeholder="Floor number">
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
		      <th scope="col">Floor ID</th>
		      <th scope="col">Floor</th>
		      <th scope="col">Created date</th>
		      <th scope="col"></th>
		    </tr>
		  </thead>
		  <tbody>
		  	 <?php foreach ($records as $row): ?>
		    <tr>
		      <th scope="row"><?php echo $row->id;?></th>
		      <td><?php echo $row->floor;?></td>
		      <td><?php echo $row->created_at;?></td>
		      <td><a onclick="updatefloorForm(<?php echo $row->id;?>)" id="update_type">Edit</a> |<a  href="<?php echo base_url('Admin_controller/deleteFloortype/' . $row->id); ?>">Delete</a></td>
		    </tr>
		   <?php endforeach; ?>
		  </tbody>
		</table>

	</div>
	<div class="modal" tabindex="-1" role="dialog" id="update_floor_modal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Update floor</h5>
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
        $("#Add-floor-types").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>Admin_controller/add_floor_type",
                data: $(this).serialize(),
                success: function(response) {
                	if (response.error) {
                    // Show the error message
                    $("#error-message").text(response.error).css('color', 'red');
                }
                   var result = JSON.parse(response);
                    if (result.success) {
                    	$("#Add-floor-types")[0].reset();
                    	$("#error-container").find(".success").html("Data inserted sucess");
	                    setTimeout(function() {
	                        $("#error-container").find(".success").empty();
	                    }, 2000);
                        
                         $("#error-container").find(".error").empty();
                    } else {
                        $("#error-container").find(".error").html(result.errors);
                        $("#error-container").find(".success").empty();
                    }

                }
            });
        });
    });
		function updatefloorForm($id) {
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