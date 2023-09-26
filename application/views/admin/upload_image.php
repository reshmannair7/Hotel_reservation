<div class="room-master">
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#room-master-Modal">
		  Add
		</button>

		<!-- Modal -->
		<div class="modal fade" id="room-master-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		   <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add room master</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      
					  <input type="file" name="files" id="files"  multiple>
					  <div id="uploaded-images"></div>
					
		      </div>
		      
		    </div>
		  </div>
		</div>
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">First</th>
		      <th scope="col">Last</th>
		      <th scope="col">Handle</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <th scope="row">1</th>
		      <td>Mark</td>
		      <td>Otto</td>
		      <td>@mdo</td>
		    </tr>
		    <tr>
		      <th scope="row">2</th>
		      <td>Jacob</td>
		      <td>Thornton</td>
		      <td>@fat</td>
		    </tr>
		    <tr>
		      <th scope="row">3</th>
		      <td>Larry</td>
		      <td>the Bird</td>
		      <td>@twitter</td>
		    </tr>
		  </tbody>
		</table>

	</div>
	<script>
		$(document).ready(function(){
			$("#files").change(function()
			{
				var files =$("#files")[0].files;
				var error = '';
				var form_data = new FormData();
				for(var count = 0; count < files.length; count++)
				{
					var name = files[count].name;
					var extension =name.split('.').pop().toLowerCase();
					if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
					{
						error += "Invalid"+count+"Image file";
					}else 
					{
						form_data.append("files[]",files[count]);
					}
				}
				if(error == '')
				{
					$.ajax({
						url : "<?php echo base_url();?>Admin_controller/upload",
						method :"POST",
						data:form_data,
						contentType:false,
						cache:false,
						processData:false,
						beforeSend:function()
						{
							$("#uploaded_images").html("<label>Uploading....</label>");
						},
						success:function(data)
						{
							$("#uploaded_images").html(data);
							$("#files").val('');
						}
					})
				}
				else
				{
					alert(error);
				}
			})
		})

	</script>