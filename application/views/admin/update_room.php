<!-- application/views/edit_student.php -->

<form method="post" action="<?php echo base_url(); ?>Admin_controller/updateRoom">
    <input type="hidden" name="id" value="<?php echo $type_data['id']; ?>">
    <input type="text" name="room_type" value="<?php echo $type_data['room_type']; ?>" required>
   
    <button type="submit">Update</button>
</form>
