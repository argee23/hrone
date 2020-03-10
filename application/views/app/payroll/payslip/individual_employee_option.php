        <?php

		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");

		$comp_details=$this->general_model->get_company_info($company_id);
		$division_setting=$comp_details->wDivision;

        ?>

<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Payrol Period</label>
	<div class="col-sm-7">
		<select name="pay_period" class="form-control" id="pay_period"  required >
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
<?php
if(!empty($old_pp)){
?>
<div class="form-group">
	<label for="next" class="col-sm-5 control-label bg-danger">Note:</label>
	<div class="col-sm-7">
		<span>
			* If the employee has an old payroll period group, you are only allowed to view the previously posted payroll/payroll history.
			<br>
			* System will force your action to viewing only, if you select reset payslip/post payroll from the category 'Option'
		</span>
	</div>
</div>
<div class="form-group">
	<label for="next" class="col-sm-5 control-label bg-danger">Old Payrol Period</label>
	<div class="col-sm-7">

		<select name="old_pay_period" class="form-control" id="old_pay_period"  required >
			<option selected value="ignore">Ignore Me or You may Select</option>
			<?php

				foreach($old_pp as $old){

				$d=$this->payroll_generate_payslip_model->show_old_pp_with_data_only($old->id,$employee_id);
			
				if(!empty($d)){
					$disable_me="";
					$disable_me_remark="";
				}else{
					$disable_me="disabled";
					$disable_me_remark="[No Posted Payroll]";
				}

				$df= date("F", mktime(0, 0, 0, $old->month_from, 10))." ".$old->day_from." ".$old->year_from; 
				$dt= date("F", mktime(0, 0, 0, $old->month_to, 10)). " ".$old->day_to." ".$old->year_to;
				echo '<option value="'.$old->id.'" '.$disable_me.'>['.$old->group_name.'] '.$df.' to '.$dt.' '.$disable_me_remark.'</option>';
				}

			?>
		</select>
	</div>	
</div> 

<?php
}else{
echo '
<input type="hidden" name="old_pay_period" class="form-control" id="old_pay_period" value="ignore" >
';
}
?>



 <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Generate</button>
