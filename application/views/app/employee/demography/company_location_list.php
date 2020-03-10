<div class="col-md-6">
<div class="form-group">
    <label for="location">Location</label>
    <select class="form-control select2" name="location" id="location" style="width: 100%;" onchange="applyFilterlocation(this.value);">
      <option selected="selected" value="0">-All location-</option>
      <?php 
        foreach($company_locations as $location){
        if($_POST['location'] == $location->location_id){
            $selected = "selected='selected'";
        }else{
            $selected = "";
        }
        ?>
        <option value="<?php echo $location->location_id;?>" <?php echo $selected;?>><?php echo $location->location_name;?></option>
        <?php }?>
    </select>
</div>
</div>
  