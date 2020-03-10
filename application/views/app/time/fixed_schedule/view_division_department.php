<div class="form-group">
  <label>Department</label>
  <select class="form-control" name="department" id="department" onchange="getDepartmentSection(this.value)" required>
    <option selected="selected" value="All" >All</option>
    <?php
      foreach($division_department as $department ){
      if($_POST['company_department'] == $department->department_id){
          $selected = "selected='selected'";
      }else{
          $selected = "";
      }
      ?>
    <option value="<?php echo $department->department_id;?>" <?php echo $selected;?>><?php echo $department->dept_name;?></option>
    <?php }?>
  </select>
</div>