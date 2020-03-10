<div class="col-md-12">
 	<div class="panel panel-success">
	</div>
</div>

<div class="col-md-12">
 	<div class="panel panel-success">
 		<div class="panel-heading">
 			<b>Regular Payroll</b>
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

	$pay_per_dtr = $this->time_dtr_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//
	
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
		$payslip_setting=$this->My_payslip_model->check_payslip_setting($company_id,$pay_type_group);

		if(!empty($payslip_setting)){
			
				$pol_type=$payslip_setting->allow_view_payroll;
				$pol_type_under=$payslip_setting->payroll_period_option;
				$pol_pay_period=$payslip_setting->payroll_period_id;

				//echo "may setup: $pol_type | $pol_type_under | $pol_pay_period ->";
				if(($pol_type=="Yes")AND($pol_type_under=="All")){
						$payslip_view="";
						$payslip_view_note="";
						$payslip_topic_view="";
				}elseif(($pol_type=="Yes")AND($pol_type_under=="Before")AND($pol_pay_period=="" OR $pol_pay_period=="0")){
						$payslip_view="disabled";
						$payslip_view_note="(Setup in viewing payslip is incomplete yet on the admin side.)";
						$payslip_topic_view="";
				}elseif(($pol_type=="Yes")AND($pol_type_under=="Before")AND($pol_pay_period>1)){
						$payslip_view="";
						$payslip_view_note="";
						$payslip_topic_view="check_spec_pay_period";
				}elseif(($pol_type=="Yes")AND($pol_type_under=="After")AND($pol_pay_period=="" OR $pol_pay_period=="0")){
						$payslip_view="disabled";
						$payslip_view_note="(Setup in viewing payslip is incomplete yet on the admin side.)";
						$payslip_topic_view="";
				}elseif(($pol_type=="Yes")AND($pol_type_under=="After")AND($pol_pay_period>1)){
						$payslip_view="";
						$payslip_view_note="";
						$payslip_topic_view="check_spec_pay_period";
				}else{
						$payslip_view="disabled";
						$payslip_view_note="(This Payroll can be viewed once its already posted.)";
						$payslip_topic_view="";
				}


		}else{
			//ho "walang setup";
			$payslip_view="";
			$payslip_view_note="";
			$payslip_topic_view="";
		}


	if($payslip_topic_view=="check_spec_pay_period"){		
		//ppd : payroll period details
		$ppd=$this->My_payslip_model->get_payroll_period_details($pol_pay_period);
		$mc=$ppd->month_cover;
		$yc=$ppd->year_cover;
		$co=$ppd->cut_off;
		$start_before=$ppd->complete_from." to ".$ppd->complete_to;
		//echo "GO $pol_pay_period ( $mc , $yc , $co ";

		//echo "<br> ";
	}else{

	}

?>
<input type="hidden" id="pay_type_group" value="<?php echo $pay_type_group;?>">
<input type="hidden" id="pay_type" value="<?php echo $pay_type;?>">
<input type="hidden" id="company_id" value="<?php echo $company_id;?>" >

<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Payrol Period</label>
	<div class="col-sm-7">
		<select name="pay_period" class="form-control" id="pay_period"  onchange="view_my_payslip(this.value);">
		<option value="" selected="selected" disabled="">Select Payroll Period</option>
		<?php
		if(!empty($pay_per_dtr)){
	
			foreach($pay_per_dtr as $pay_period){

				$df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
				$dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;


	if($payslip_topic_view=="check_spec_pay_period"){
			$payslip_view="";
			$r_mc=$pay_period->month_cover;
			$r_yc=$pay_period->year_cover;
			$r_co=$pay_period->cut_off;
			
			if($pol_type_under=="Before"){
				if($r_yc>$yc){
					$payslip_view="disabled";
					$payslip_view_note="(Allowed to view payroll cutoff before $start_before only)";
				}elseif($r_yc==$yc){
					if($r_mc>$mc){
						$payslip_view="disabled";
						$payslip_view_note="(Allowed to view payroll cutoff before $start_before only)";
					}elseif($r_mc==$mc){
						if($co=="1"){
									$payslip_view="disabled";	
									$payslip_view_note="(Allowed to view payroll cutoff before $start_before only)";							
						}else{
							if($co==$r_co){						
									$payslip_view="disabled";	
									$payslip_view_note="(Allowed to view payroll cutoff before $start_before only)";					
							}else{
								$payslip_view_note="";
							}
						}

					}else{
						$payslip_view_note="";
					}
				}else{
					$payslip_view="";
					$payslip_view_note="";
				}

			}elseif($pol_type_under=="After"){
				if($r_yc<$yc){
					$payslip_view="disabled";
					$payslip_view_note="(Allowed to view payroll cutoff before $start_before only)";
				}elseif($r_yc==$yc){
					if($r_mc<$mc){
						$payslip_view="disabled";
						$payslip_view_note="(Allowed to view payroll cutoff before $start_before only)";
					}elseif($r_mc==$mc){
						if($co=="2"){
									$payslip_view="disabled";	
									$payslip_view_note="(Allowed to view payroll cutoff After $start_before only)";							
						}else{
							if($co==$r_co){						
									$payslip_view="disabled";	
									$payslip_view_note="(Allowed to view payroll cutoff After $start_before only)";					
							}else{
								$payslip_view_note="";
							}
						}

					}else{
						$payslip_view_note="";
					}
				}else{
					$payslip_view="";
					$payslip_view_note="";
				}

			}else{

			}
	}else{

	}

				echo '<option value="'.$pay_period->id.'" '.$payslip_view.'>'.$df.' to '.$dt.' '.$payslip_view_note.'</option>';
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
	<label for="next" class="col-sm-5 control-label bg-danger">Previous/Old Payroll Period Group</label>
	<div class="col-sm-7">

		<select name="old_pay_period" class="form-control" id="old_pay_period"  required  onchange="view_my_payslip(this.value);">
				<option value="" selected="selected" disabled="">Select Payroll Period</option>
			<?php

				foreach($old_pp as $old){

				$d=$this->payroll_generate_payslip_model->show_old_pp_with_data_only($old->id,$selected_emp);
			
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


<br><br>
<div id="show_payslip" >


</div>





 		</div>	
 	</div>
</div>