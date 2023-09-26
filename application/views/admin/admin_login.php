<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin.css')?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<title>Login</title>
</head>
<body>
	<!-- ----------------------Admin login form start---------------------------- -->
	<div class="form_div">
		<h1>Login</h1>
		<form method="POST" action="<?php echo base_url()?>Admin_controller/process_login">
			
			  <div class="form-group">
			    <label for="formGroupExampleInput">User name</label>
			    <input type="text" name="email" class="form-control"  placeholder="Username">
			   	<span class="error"> <?php echo form_error('email'); ?></span>
			  </div>
			  <div class="form-group">
			    <label for="formGroupExampleInput2">Password</label>
			    <input type="password" name="password" class="form-control" placeholder="Password">
			    <span class="error"><?php echo form_error('password'); ?></span>
			  </div>
			   <button type="submit" class="btn btn-primary signIn-btn">Sign in</button>
		</form>
		<!-- Button trigger modal -->
			<button type="button" class="SignUp_link" data-toggle="modal" data-target="#signUp-form">
			  User Signup
			</button>

			<!-- Modal -->
			<div class="modal fade" id="signUp-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">User Registration</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			         <form method="POST" id="Registration_form">
			         	<div class="row">
					  <div class="form-group col-md-6">
					    <label> Name</label>
					    <input type="text" name="name" class="form-control" id=""  placeholder="Full Name">
					  
					  </div>
					  <div class="form-group col-md-6">
					    <label >Phone number</label>
					   <input type="text" id="phone" name="phone_number" class="form-control" pattern="[0-9]+" placeholder="Phone number">
					   
					  </div>
					  </div>
					  <div class="row">
					  <div class="form-group col-md-6">
					    <label >Email</label>
					    <input type="email" name="email" class="form-control" id=""  placeholder="Email">
					   
					  </div>
					  <div class="form-group col-md-6">
					    <label >Password</label>
					    <input type="password" name="password" class="form-control" id=""  placeholder="Password">
					   
					  </div>
					</div>
					<div class="row">
					  <div class="form-group col-md-6">
					    <label >Confirm Password</label>
					    <input type="password" name="confirm_password" class="form-control" id=""  placeholder="Confirm Password">

					  </div>
					   <div class="form-group col-md-6">
					    <label >Gender</label><br>
					    <input type="radio" name="gender" value="male">male
					    <input type="radio" name="gender" value="female">female
					  </div>
					  
					</div>
					<div class="row">
					  <div class="form-group col-md-6">
					    <label >Adress line 1</label>
					    <input type="text" name="address_line1" class="form-control" id=""  placeholder="Address line1">
					   
					  </div>
					  <div class="form-group col-md-6">
					   <label >Adress line 2</label>
					    <input type="text" name="address_line2" class="form-control" id=""  placeholder="Address line2">
					   
					  </div>
					</div>
					<div class="row">
					  <div class="form-group col-md-6">
					    <label >Country</label>
					    <input type="text" name="country" class="form-control" id=""  placeholder="Country">

					  </div>
					  <div class="form-group col-md-6">
					    <label >State</label>
					    <input type="text" name="state" class="form-control" id=""  placeholder="State">

					  </div>
					</div>
					<div class="row">
					  <div class="form-group col-md-6">
					    <label >City</label>
					    <input type="text" name="city" class="form-control" id=""  placeholder="City">

					  </div>
					  <div class="form-group col-md-6">
					    <label >Pincode</label>
					    <input type="text" name="pincode" class="form-control" id=""  placeholder="Pincode">

					  </div>
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
		<?php if (isset($error_message)){ ?>
    		<span class="error"><?php echo $error_message; ?></span>
		<?php }?>
	</div>
	<!-- ----------------------Admin login form start end---------------------------- -->
	<script type="text/javascript">
		$(document).ready(function() {
        $("#Registration_form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>Admin_controller/registration",
                data: $(this).serialize(),
                success: function(response) {
                	if (response.error) {
                    // Show the error message
                    $("#error-message").text(response.error).css('color', 'red');
                }
                   var result = JSON.parse(response);
                    if (result.success) {
                    	$('input[type="text"],input[type="file"], textarea').val('');
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
</script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>