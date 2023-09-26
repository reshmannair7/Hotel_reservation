<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin.css')?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<title>Admin dashboard</title>
</head>
<body>
<header>
<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#">
    Admin dashboard 
  </a>
  <a href="<?php echo site_url('Admin_controller/logout'); ?>">Logout</a>
  </nav>
</header>
<div class="row">
<div class="col-2">
	<div class="left-sidenav">
		<ul class="list_views">
			<li id="room_master_list">Room type master</li>
			<li id="floor_master_list">floor master</li>
			<li id="room_list">Room mater</li>
			<li id="user_reservation">Room reservation</li>
		</ul>

	</div>

</div>
<div class="col-10 table_list_view">
	<?php echo $content; ?>
</div>
</div>
<script>
    $(document).ready(function() {
        $("#Add-room-types").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>Admin_controller/add_room_type",
                data: $(this).serialize(),
                success: function(response) {
                	if (response.error) {
                    // Show the error message
                    $("#error-message").text(response.error).css('color', 'red');
                }
                   var result = JSON.parse(response);
                    if (result.success) {
                    	$("#Add-room-types")[0].reset();
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

        $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const triggerClick = urlParams.get('triggerClick');

        if (triggerClick === 'floor') {
            var selectedContent = "floor_master_list";
            $.ajax({
                url: "<?php echo site_url();?>Admin_controller/"+selectedContent+"/" + selectedContent,
                type: "GET",
                success: function(response) {
                    $(".table_list_view").html(response);
                },
                error: function() {
                    $(".table_list_view").html("Error loading content.");
                }
            });
        }
         if (triggerClick === 'room') {
            var selectedContent = "room_list";
            $.ajax({
                url: "<?php echo site_url();?>Admin_controller/"+selectedContent+"/" + selectedContent,
                type: "GET",
                success: function(response) {
                    $(".table_list_view").html(response);
                },
                error: function() {
                    $(".table_list_view").html("Error loading content.");
                }
            });
        }
        $(".list_views").find("li").click(function() {
            var selectedContent = $(this).attr('id');
            $.ajax({
                url: "<?php echo site_url();?>Admin_controller/"+selectedContent+"/" + selectedContent,
                type: "GET",
                success: function(response) {
                    $(".table_list_view").html(response);
                },
                error: function() {
                    $(".table_list_view").html("Error loading content.");
                }
            });
        });
    });
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>