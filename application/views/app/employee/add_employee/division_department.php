<div class="col-md-6">
<div class="form-group">
<label for="department">Department</label>
<select class="form-control" name="department" id="department" onchange="getSection(this.value);" required>
<option selected="selected" disabled="disabled" value="">~select department~</option>
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
<p style="color:#ff0000;">Department is required</p>
</div>
</div>