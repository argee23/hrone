<!-- 	<div class="form-group">
        <label>Select Location:</label>
        <select multiple="multiple" class="form-control select2" name="location[]" id="location" style="width: 100%;" required="required" >
            <?php 
                foreach($locationList as $location){
                if($_POST['location'] == $location->location_id){
                    $selected = "selected='selected'";
                }
                else{
                    $selected = "";
                }
            ?>
          <option value="<?php echo $location->location_id;?>"><?php echo $location->location_name;?></option>
            <?php }?>
    	</select>
    </div> -->

	<div class="form-group">
        <label for="division" control-label">Division Name</label>
         <input type="text" class="form-control" name="division" id="division" placeholder="Division Name" required>
    </div>
          <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-floppy-o"></i> Save</button>