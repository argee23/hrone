<div class="col-md-12">
 	<div class="panel panel-default">
	</div>
</div>


<div class="col-md-12">
 	<div class="panel panel-default">
 		<div class="panel-heading">
 			DTR Viewing Ongoing..
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

		$dtr_setting=$this->my_dtr_model->check_dtr_setting($company_id);
		$allow_to_view=$dtr_setting->single_field_setting;

		if($allow_to_view=="1_dtr_view"){//yes
			$dtr_view="";
			$dtr_view_note="";
		}elseif($allow_to_view=="2_dtr_view"){//after payroll is already posted
			$dtr_view="";
			$dtr_view_note="";
		}elseif($allow_to_view=="3_dtr_view"){//no
			$dtr_view="disabled";
			$dtr_view_note="(Viewing of DTR is disabled by the admin.)";
		}else{
			$dtr_view="";
			$dtr_view_note="";
		}

?>

<input type="hidden" id="pay_type_group" value="<?php echo $pay_type_group;?>">
<input type="hidden" id="pay_type" value="<?php echo $pay_type;?>">
<input type="hidden" id="company_id" value="<?php echo $company_id;?>" >




<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Payrol Period</label>
	<div class="col-sm-7">
		<select name="pay_period" class="form-control" id="pay_period"  onchange="view_my_dtr(this.value);">
		<option value="" selected="selected" disabled="">Select Payroll Period</option>
		<?php
		if(!empty($pay_per_dtr)){
			foreach($pay_per_dtr as $pay_period){

if($allow_to_view=="2_dtr_view"){
	// //pc: payslip checking
				$pc=$this->my_dtr_model->verify_payslip($selected_emp,$pay_period->id);
				if(!empty($pc)){
					$dtr_view="";
					$dtr_view_note="";
				}else{
					$dtr_view="disabled";
					$dtr_view_note=" (This DTR can be viewed once payroll is already posted.)";
				}
}else{

}
				$df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
				$dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
				echo '<option value="'.$pay_period->id.'" '.$dtr_view.'>'.$df.' to '.$dt.' '.$dtr_view_note.'</option>';
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

		<select name="old_pay_period" class="form-control" id="old_pay_period"  required onchange="view_my_dtr(this.value);">
			<option value="" selected="selected" disabled="">Select Previous Group : Payroll Period</option>
			<?php

				foreach($old_pp as $old){

					$d=$this->time_dtr_model->show_old_pp_with_data_only($old->id,$selected_emp);
					if(!empty($d)){
						$disable_me="";
						$disable_me_remark="";
					}else{
						$disable_me="disabled";
						$disable_me_remark="[No Processed DTR]";
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





<div id="show_dtr" >


</div>





 		</div>	
 	</div>
</div>