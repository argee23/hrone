<div class="col-md-12">
 	<div class="panel panel-success">
	</div>
</div>

<div class="col-md-12">
 	<div class="panel panel-success">
 		<div class="panel-heading">
 			<b>13th Month Payroll</b>
 		</div>
 		<div class="panel-body">
 			<h4></h4>
<?php
/*
-------------------------------------------------------------------
my payroll period group
-------------------------------------------------------------------
*/
if(!empty($p_group)){
	$pay_type_group=$p_group->payroll_period_group_id;
	$pay_type=$p_group->pay_type;
	$company_id=$p_group->company_id;

	// $pay_per_dtr = $this->time_dtr_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//
	
}else{

	$pay_type_group="";
	$pay_type="";
	$company_id="";

echo '<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">&nbsp;</label>
	<div class="col-sm-7">
	<span class="form-control">Notice: You are not yet enrolled to payroll period group.</span>
	</div>
</div>  
';
}
	

?>
<input type="hidden" id="pay_type_group" value="<?php echo $pay_type_group;?>">
<input type="hidden" id="pay_type" value="<?php echo $pay_type;?>">
<input type="hidden" id="company_id" value="<?php echo $company_id;?>" >

<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Payrol Period</label>
	<div class="col-sm-7">
		<select name="pay_period" class="form-control" id="pay_period"  onchange="view_my_tertin_month_payslip(this.value);">
		<option value="" selected="selected" disabled="">Select Payroll Period</option>
		<?php
		if(!empty($pay_per_dtr)){
	
			foreach($pay_per_dtr as $pay_period){

				$df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
				$dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;

				echo '<option value="'.$pay_period->id.'" >'.$df.' to '.$dt.'</option>';
			}
		}else{
			echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';		

		}
		?>
		</select>
	</div>
</div>  

<br><br>
<div id="show_payslip" >


</div>





 		</div>	
 	</div>
</div>