<div class="col-md-3">
<div class="form-group">
<label for="department">Department</label>
<select class="form-control" name="department" id="department" onchange="getSection(this.value); applyFilterdepartment(this.value);">
<option selected="selected" value="All">All</option>
<?php 
  foreach($company_division as $department){
  if($_POST['department'] == $department->department_id){
      $selected = "selected='selected'";
  }else{
      $selected = "";
  }
  ?>
  <option value="<?php echo $department->department_id;?>" <?php echo $selected;?>><?php echo $department->dept_name;?></option>
  <?php }?>
</select>
</div>
</div>

