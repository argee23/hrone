<?php
$the_date = new DateTime($p_from);
$the_date->modify($to_check_day.' day');
$the_date=$the_date->format('Y-m-d');

$the_date_state=$this->time_dtr_model->check_holiday_policy_on_date($employee_id,$the_date);

if(!empty($the_date_state)){
	//checkhol_regular_hour
	$checkhol_regular_hour=$the_date_state->checkhol_regular_hour;
	$checkhol_isrestday=$the_date_state->checkhol_isrestday;
	$checkhol_isrestday_snw_holiday=$the_date_state->checkhol_isrestday_snw_holiday;
	$checkhol_isrestday_reg_holiday=$the_date_state->checkhol_isrestday_reg_holiday;

	$checkhol_is_regular_holiday=$the_date_state->checkhol_is_regular_holiday;
	$checkhol_is_snw_holiday=$the_date_state->checkhol_is_snw_holiday;
	$checkhol_is_leave=$the_date_state->leave_fast_hol_reference;

	if(($absent_if_onwholeDayleave=="yes")AND($absent_if_onhalfDayleave=="yes")){
		require(APPPATH.'views/app/time/dtr/check_holiday_condition_1.php');
		
	}elseif(($absent_if_onwholeDayleave=="yes")AND($absent_if_onhalfDayleave=="")){
		require(APPPATH.'views/app/time/dtr/check_holiday_condition_2.php');

	}elseif(($absent_if_onwholeDayleave=="")AND($absent_if_onhalfDayleave=="yes")){
		require(APPPATH.'views/app/time/dtr/check_holiday_condition_3.php');
		
	}else{

		require(APPPATH.'views/app/time/dtr/check_holiday_condition_4.php');
	}
	

}else{ 
	$Datesforchecked_verdict="";
	$checkhol_regular_hour="";
}
	

?>