<div class="col-md-12">
<div class="col-md-6">
  <div class="form-group">
  <label for="company">Select a Division</label>
    <select class="form-control" name="division" id="division" onchange="getDepartmentDivision(this.value)" required>
    <option selected="selected" value="" disabled>~select a division~</option>
    <?php
      foreach($company_division as $division ){
      if($_POST['division_employee'] == $division->division_id){
          $selected = "selected='selected'";
      }else{
          $selected = "";
      }
      ?>
    <option value="<?php echo $division->division_id;?>" <?php echo $selected;?>><?php echo $division->division_name;?></option>
    <?php }?>
    </select>
  </div>
</div>
</div>

