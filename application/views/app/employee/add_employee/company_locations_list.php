<div class="col-md-6">
<div class="form-group">
    <label>Location</label>
    <select class="form-control select2" name="location" id="location" style="width: 100%;" ng-model="location" required>
      <option selected="selected" value="" disabled>-Select-</option>
      <?php 
        foreach($company_locations as $location){
        if($_POST['location'] == $location->company_id){
            $selected = "selected='selected'";
        }else{
            $selected = "";
        }
        ?>
        <option value="<?php echo $location->location_id;?>" <?php echo $selected;?>><?php echo $location->location_name;?></option>
        <?php }?>
    </select>

    <span class="text-danger" ng-show="userForm.location.$invalid">
    <span ng-show="userForm.location.$error.required">Location is required</span>
    </span>
</div>
</div>