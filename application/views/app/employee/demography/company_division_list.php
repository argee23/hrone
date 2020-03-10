<?php
	$isDivision = 3; 
	foreach($company_isDiv as $company){
	$isDivision = $company->wDivision;
} ?>
<?php if($isDivision==1){ ?>
<div class="col-md-6">
<div class="form-group">
<label >Division</label>
<select class="form-control" name="division" id="division" onchange="getDepartment(this.value); applyFilterdivision(this.value)">
  <option selected="selected" value="0">~select all division~</option>
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

<div id="department">
</div>

<?php } 
else{ ?>
	  <div class="col-md-6">
	  <div class="form-group">
	  <label for="department">Department</label>
	    <select class="form-control" name="department" id="department" onchange="getSection(this.value); applyFilterdepartment(this.value);">
	    <option selected="selected" value="0">~select all department~</option>
	    <?php 
	      foreach($company_department as $department){
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

	  <div class="col-md-6">
	  </div>
	  
<?php } ?>