        <?php

		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");


		$comp_details=$this->general_model->get_company_info($company_id);
		$division_setting=$comp_details->wDivision;
		//echo "HEY | ".$this->uri->segment("7");


        ?>

<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Payrol Period- (Covered Release of Lastpay).</label>
	<div class="col-sm-7">
		<select name="pay_period" class="form-control" id="pay_period"  required >
		<?php
		if(!empty($pay_per_dtr)){
			foreach($pay_per_dtr as $pay_period){
				$df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
				$dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;

				if($payroll_option=="print_payslip" OR $payroll_option=="reset_payslip"){
					$check_posted_payroll_period=$this->Payroll_generate_13th_month_model->check_posted_payroll_period($pay_period->id);
						if(!empty($check_posted_payroll_period)){
							echo '<option value="'.$pay_period->id.'" >'.$df.' to '.$dt.' </option>';
						}else{

						}									
				}else{
					echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';
				}				
			}
		}else{
			echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';		
		}
		?>
		</select>
	</div>
</div>  

<?php
	if($payroll_option=="print_payslip" OR $payroll_option=="reset_payslip" OR $payroll_option=="encode_adjustment" ){
		echo '
		<input type="hidden" name="from_cov_pay_period" id="from_cov_pay_period" value="not_involved">
		<input type="hidden" name="to_cov_pay_period" id="to_cov_pay_period" value="not_involved">
		<input type="hidden" name="formula" id="formula" value="not_involved">
		';
	}else{


?>
<!-- //==============================Coverage From of 13th month -->
<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Coverage From</label>
	<div class="col-sm-7">
		<select name="from_cov_pay_period" class="form-control" id="from_cov_pay_period"  required >
		<?php
		if(!empty($pay_per_dtr)){
			foreach($pay_per_dtr as $pay_period){
				$df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
				$dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
				echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';
			}
		}else{
			echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';		

		}
		?>
		</select>
	</div>
</div>
<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Coverage To</label>
	<div class="col-sm-7">
		<select name="to_cov_pay_period" class="form-control" id="to_cov_pay_period"  required >
		<?php
		if(!empty($pay_per_dtr)){
			foreach($pay_per_dtr as $pay_period){
				$df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
				$dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
				echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';
			}
		}else{
			echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';		

		}
		?>
		</select>
	</div>
</div>


<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Choose Formula (for 13th Month) </label>
	<div class="col-sm-7">
		<select name="formula" class="form-control" id="formula"  required >
		<option selected disabled>Select</option>
		<?php
		if(!empty($formula_list)){
			foreach($formula_list as $f){
				
				echo '<option value="'.$f->id.'">'.$f->formula_description.'</option>';
			}
		}else{
			echo '<option value="" disabled selected>warning : no formula options created yet.</option>';		

		}
		?>
		</select>
	</div>
</div>  

<?php

		
}

?>

<!-- //==============================Coverage To of 13th month -->

<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Location</label>
	<div class="col-sm-7">
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
</div>  
<?php
if($division_setting=="1"){// show division option
?>
<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Division</label>
	<div class="col-sm-7">
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
		<label for="department" class="col-sm-5 control-label">Division - Department(s)</label>
	<div class="col-sm-7">
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
		<label for="department" class="col-sm-5 control-label">Department</label>
	<div class="col-sm-7">
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

 
<div class="form-group"   >
		<label for="section" class="col-sm-5 control-label">Section</label>
	<div class="col-sm-7" id="show_section">
		<select name="section" class="form-control" id="section"  required >
        <option value="All" selected>-All-</option>
		
		</select>
	</div>
</div>  
<div id="show_sub_section">

</div>
<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Classification</label>
	<div class="col-sm-7">
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
&nbsp;
<div class="form-group text-info">
		<label for="next" class="col-sm-5 control-label"><br>Employment</label>
	<div class="col-sm-7"><br>
		<?php

		if(!empty($employmentList)){
			foreach($employmentList as $emp){
				echo '<input type="checkbox" value="'.$emp->employment_id.'" checked name="employment[]">'.$emp->employment_name.'<br>';	
			}
		}else{
			echo 'warning: no location setup yet.';		

		}
		?>

	</div>
</div>  

<div class="form-group">
		<label for="next" class="col-sm-5 control-label"><br>Status</label>
	<div class="col-sm-7"><br>
			<select name="employee_status" class="form-control" id="status"  required >
		<option value="0">Active</option>
		<option value="1">InActive</option>
		<option value="All"> All</option> <!-- value=All important-->
			</select>
	</div>
</div>  


 <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Generate</button>
