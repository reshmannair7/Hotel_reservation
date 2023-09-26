<form method="post" action="<?php echo base_url(); ?>Admin_controller/updateFloortype">
    <input type="hidden" name="id" value="<?php echo $type_data['id']; ?>">
    <input type="text" name="floor" value="<?php echo $type_data['floor']; ?>" required>
   
    <button type="submit">Update</button>
</form>