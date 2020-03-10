<?php foreach($company_isDiv as $company){
	$isDivision = $company->wDivision;
} ?>
<?php if($isDivision==1){ ?>
<div class="col-md-6">
<div class="form-group">
<label >Division</label>
<select class="form-control" name="division" id="division" onchange="getDepartment(this.value);" required>
  <option selected="selected" disabled=disabled value="">~select division~</option>
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
<p style="color:#ff0000;">Division is required</p>
</div>
</div>

<div id="department">
</div>
<?php } 
else{ ?>
	  <div class="col-md-6">
	  <div class="form-group">
	  <label for="department">Department</label>
	    <select class="form-control" name="department" id="department" onchange="getSection(this.value);" required>
	    <option selected="selected" disabled="disabled" value="">~select department~</option>
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
	  <p style="color:#ff0000;">Department is required</p>
	  </div>
	  </div>

	  <div class="col-md-6">
	  </div>
	  
<?php } ?>