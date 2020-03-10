

<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/employeeFilter/" target="_blank">

<?php 
$company_id=$this->uri->segment('4');
?>
<input type="hidden" id="company_id" name="company_id" value="<?php echo $company_id;?>">
<input type="hidden" id="taxtype_chosen" name="taxtype_chosen" value="<?php echo $taxtype_chosen;?>">

<?php

if($wDivision=="1"){
?>

<div class="form-group"  >
		<label for="department" class="col-sm-5 control-label">Division</label>
	<div class="col-sm-7">
		<select name="division" class="form-control" id="division_id"  required onchange="fetch_div_dep(this.value)">
		
		<?php

		if(!empty($comp_div)){
			echo '<option value="All" selected>All</option>';
			foreach($comp_div as $div){
				echo '<option value="'.$div->division_id.'">'.$div->division_name.'</option>';
			}
		}else{
			echo '<option value="no_data_yet" disabled selected>warning : no division created yet.</option>';		

		}
		?>
		</select>
	</div>
</div> 

<div id="fetch_div_dep">
		<div class="form-group"  >
				<label for="department" class="col-sm-5 control-label">Department</label>
			<div class="col-sm-7">
				<select name="department" class="form-control" id="department_id"  required>
				<option value="All" selected>All</option>
				</select>
			</div>
		</div>
</div>


<?php
}else{
?>
<input type="hidden" name="division" value="ignore_me">
<div class="form-group"  >
		<label for="department" class="col-sm-5 control-label">Department</label>
	<div class="col-sm-7">
		<select name="department" class="form-control" id="department_id"  required onchange="fetch_dep_sect(this.value)">
		
		<?php
		$comp_dept=$this->general_model->get_company_departments($company_id);
		if(!empty($comp_dept)){
			echo '<option value="All" selected>All</option>';
			foreach($comp_dept as $dept){
				echo '<option value="'.$dept->department_id.'">'.$dept->dept_name.'</option>';
			}
		}else{
			echo '<option value="no_data_yet" disabled selected>warning : no department created yet.</option>';		

		}
		?>
		</select>
	</div>
</div>

<?php
}
?>

<div id="fetch_dep_sect">
		<div class="form-group"  >
				<label for="section" class="col-sm-5 control-label">Section</label>
			<div class="col-sm-7">
				<select name="section" class="form-control" id="section_id"  required>
				<option value="All" selected>All</option>
				</select>
			</div>
		</div>
</div>

<div id="fetch_subsection">
		<div class="form-group"  >
				<label for="sub_section" class="col-sm-5 control-label">Sub Section</label>
			<div class="col-sm-7">
				<select name="sub_section" class="form-control" id="sub_section_id"  required>
				<option value="All" selected>All</option>
				</select>
			</div>
		</div>
</div>


		<div class="form-group"  >
				<label for="location" class="col-sm-5 control-label">Location</label>
			<div class="col-sm-7">
<?php
if(!empty($compLoc)){
	foreach($compLoc as $loc){
		echo '
		<input type="checkbox" class="" name="location[]" value="'.$loc->location_id.'" checked>'.$loc->location_name.'<br>

		';
	}
}else{
echo "none";
}
?>
			</div>
		</div>
		<div class="form-group col-md-12"  >

		</div>
		<div class="form-group"  >
				<label for="classification" class="col-sm-5 control-label">Classification</label>
			<div class="col-sm-7">
<?php
if(!empty($compClass)){
	foreach($compClass as $c){
		echo '
		<input type="checkbox" class="" name="classification[]" value="'.$c->classification_id.'" checked>'.$c->classification.'<br>
		';
	}
}else{

}
?>
			</div>
		</div>
		<div class="form-group col-md-12"  >

		</div>

		<div class="form-group">
				<label for="employment" class="col-sm-5 control-label">Employment</label>
			<div class="col-sm-7">
<?php
if(!empty($employmentList)){
	foreach($employmentList as $e){
		echo '
		<input type="checkbox" class="" name="employment[]" value="'.$e->employment_id.'" checked>'.$e->employment_name.'<br>
		';
	}
}else{

}
?>
			</div>
		</div>




 <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-arrow-right"></i> Generate </button>


 </form>
