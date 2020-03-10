  

  <div class="form-group">
    <div class="col-md-12">
      <label class="col-md-12">Mobile No</label>
      <select class="form-control" name="mobile_no" >
  
      	<option value="mobile_1" selected> Mobile No 1</option>
      	<option value="mobile_2">Mobile No 2</option>
      	<option value="mobile_3">Mobile No 3</option>
      	<option value="mobile_4">Mobile No 4</option>
      </select>
    </div>
   </div>

      <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-4">Location</label>
          <label class="col-md-4">Employment</label>
          <label class="col-md-4">Classification</label>


	<div class="col-sm-4">
		<?php
		$comp_loc=$this->general_model->get_company_locations($company_id);
		if(!empty($comp_loc)){
			foreach($comp_loc as $loc){
				echo '<input type="checkbox" value="'.$loc->location_id.'" checked name="location[]">'.$loc->location_name.'<br>';	
			}
		}else{
			echo 'warning: no location setup yet.';		

		}
		?>

	</div>
  <div class="col-sm-4">
		<?php
				if(!empty($employmentList)){
					foreach($employmentList as $emp){
						echo '<input type="checkbox" value="'.$emp->employment_id.'" checked name="employment[]">'.$emp->employment_name.'<br>';	
					}
				}else{
					echo 'warning: no employment setup yet.';		

				}
		?>
	</div>
	<div class="col-sm-4">
		<?php
		$comp_class=$this->general_model->get_company_classifications($company_id);
		if(!empty($comp_class)){
			foreach($comp_class as $clas){
				echo '<input type="checkbox" value="'.$clas->classification_id.'" checked name="classification[]">'.$clas->classification.'<br>';	
			}
		}else{
			echo '<span class="text-danger">warning: no classification setup yet.</span>';		

		}
		?>

	</div>



        </div>
       </div>




<?php
if($division_setting=="1"){// show division option
?>
<div class="form-group"   >
		<label for="next" class="col-sm-12">Division</label>
	<div class="col-sm-12">
		<select name="division" class="form-control" id="division_id"  required  onchange="fetch_division_dept();">
		<option value="All" selected>All</option>	
		<?php
		$comp_div=$this->general_model->get_company_divisions($company_id);
		if(!empty($comp_div)){
			foreach($comp_div as $div){
				echo '<option value="'.$div->division_id.'">'.$div->division_name.'</option>';
			}
		}else{
			echo '<option value="" disabled selected>warning : no division created yet.</option>';	

		}
		?>
</select>
	</div>
</div> 
<div  id="show_div_dept">
<div class="form-group" >
		<label for="department" class="col-sm-12">Division - Department(s)</label>
	<div class="col-sm-12">
		<select name="department" class="form-control" id="department_id"  required onchange="fetch_section()">
		<option value="All" selected>All</option>
		
		</select>
	</div>
</div> 
</div> 
<?php
}else{
?>
<div class="form-group"  >
		<label for="department" class="col-sm-12">Department</label>
	<div class="col-sm-12">
		<select name="department" class="form-control" id="department_id"  required onchange="fetch_section()">
		<option value="All" selected>All</option>
		<?php
		$comp_dept=$this->general_model->get_company_departments($company_id);
		if(!empty($comp_dept)){
			foreach($comp_dept as $dept){
				echo '<option value="'.$dept->department_id.'">'.$dept->dept_name.'</option>';
			}
		}else{
			echo '<option value="" disabled selected>warning : no department created yet.</option>';		

		}
		?>
		</select>
	</div>
</div> 

<?php
}
?>

 
<div class="form-group" id="show_section">
		<label for="section" class="col-sm-12">Section</label>
	<div class="col-sm-12" >
		<select name="section" class="form-control" id="section"  required >
        <option value="All" selected>-All-</option>
		
		</select>
	</div>
</div>  


<div class="form-group"  id="show_sub_section">
<input type="hidden" name="sub_section" value="All">
<input type="hidden" name="grouped_contact" value="">
</div>

