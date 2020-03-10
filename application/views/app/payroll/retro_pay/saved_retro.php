<?php

$validate_retro=$this->payroll_generate_retro_model->check_retro($employee_id,$c->id,$c->month_cover);
if(!empty($validate_retro)){
	$posting_status_by_payroll_period="Retro Pay is already Posted last ".$validate_retro->date_posted;
	//echo "$employee_id <br>";
}else{
	
	$date_posted=date('Y-m-d H:i:s');
	$save_retro_detailed_values = array(
		'company_id' => $company_id,
		'employee_id' => $employee_id,
		'payroll_period_id' => $pay_period,
		'covered_payroll_period_id' => $c->id,
		'reg_hr' => $retro_total_regular_hours,
		'reg_hr_amt' => $retro_total_regular_hours_amount,
		'reg_nd' => $total_regular_nd,
		'reg_nd_amount' => $retro_total_regular_nd_amount,

		'reg_ot_wond' => $total_regular_overtime,
		'reg_ot_wond_amount' => $retro_total_regular_overtime_amount,
		'reg_ot_wnd' => $total_regular_overtime_nd,
		'reg_ot_wnd_amount' => $retro_total_regular_overtime_nd_amount,

		'rd_ot_wond' => $total_regular_hrs_restday,
		'rd_ot_wond_amount' => $retro_total_regular_hrs_restday_amount,
		'rd_ot_wnd' => $total_restday_nd,
		'rd_ot_wnd_amount' => $retro_total_restday_nd_amount,

		'rdot_ot_wond' => $total_restday_overtime,
		'rdot_ot_wond_amount' => $retro_total_restday_overtime_amount,
		'rdot_ot_wnd' => $total_restday_overtime_nd,
		'rdot_ot_wnd_amount' => $retro_total_restday_overtime_nd_amount,

		'reghol_ot_wond' => $total_regular_hrs_reg_holiday,
		'reghol_ot_wond_amount' => $retro_total_regular_hrs_reg_holiday_amount,
		'reghol_ot_wnd' => $total_reg_holiday_nd,
		'reghol_ot_wnd_amount' => $retro_total_reg_holiday_nd_amount,

		'reghol_ot_ot_wond' => $total_reg_holiday_overtime,
		'reghol_ot_ot_wond_amount' => $retro_total_reg_holiday_overtime_amount,
		'reghol_ot_ot_wnd' => $total_reg_holiday_overtime_nd,
		'reghol_ot_ot_wnd_amount' => $retro_total_reg_holiday_overtime_nd_amount,

		'reghol_rd_type_2' => $total_regular_hrs_reg_holiday_t2,
		'reghol_rd_type_2_amount' => $retro_total_regular_hrs_reg_holiday_t2_amount,

		'reghol_rd_ot_wond' => $total_regular_hrs_reg_holiday_t1,
		'reghol_rd_ot_wond_amount' => $retro_total_regular_hrs_reg_holiday_t1_amount,
		'reghol_rd_ot_wnd' => $total_restday_reg_holiday_nd,
		'reghol_rd_ot_wnd_amount' => $retro_total_restday_reg_holiday_nd_amount,

		'reghol_rd_ot_ot_wond' => $total_restday_reg_holiday_overtime,
		'reghol_rd_ot_ot_wond_amount' => $retro_total_restday_reg_holiday_overtime_amount,
		'reghol_rd_ot_ot_wnd' => $total_restday_reg_holiday_overtime_nd,
		'reghol_rd_ot_ot_wnd_amount' => $retro_total_restday_reg_holiday_overtime_nd_amount,

		'spec_ot_wond' => $total_regular_hrs_spec_holiday,
		'spec_ot_wond_amount' => $retro_total_regular_hrs_spec_holiday_amount,
		'spec_ot_wnd' => $total_spec_holiday_nd,
		'spec_ot_wnd_amount' => $retro_total_spec_holiday_nd_amount,


		'spec_ot_ot_wond' => $total_spec_holiday_overtime,
		'spec_ot_ot_wond_amount' => $retro_total_spec_holiday_overtime_amount,
		'spec_ot_ot_wnd' => $total_spec_holiday_overtime_nd,
		'spec_ot_ot_wnd_amount' => $retro_total_spec_holiday_overtime_nd_amount,

		'spec_rd_ot_wond' => $total_restday_regular_hrs_spec_holiday,
		'spec_rd_ot_wond_amount' => $retro_total_restday_regular_hrs_spec_holiday_amount,
		'spec_rd_ot_wnd' => $total_restday_spec_holiday_nd,
		'spec_rd_ot_wnd_amount' => $retro_total_restday_spec_holiday_nd_amount,

		'spec_rd_otot_wond' => $total_restday_spec_holiday_overtime,
		'spec_rd_otot_wond_amount' => $retro_total_restday_spec_holiday_overtime_amount,
		'spec_rd_otot_wnd' => $total_restday_spec_holiday_overtime_nd,
		'spec_rd_otot_wnd_amount' => $retro_total_restday_spec_holiday_overtime_nd_amount,

		'absent' => $absences_total,
		'absent_amount' => $retro_total_absent,
		'undertime' => $undertime_total,
		'undertime_amount' => $retro_undertime_total,
		'tardiness' => $tardiness_total,
		'tardiness_amount' => $retro_tardiness_total,
		'overbreak' => $overbreak_total,
		'overbreak_amount' => $retro_overbreak_total,
		'total_addition' => $retro_addition_total,
		'total_deduction' => $retro_deduction_total,
		'based_released_reg_hr' => $total_regular_hours,

		'based_released_absent_days' => $absences_total,
		'based_released_absent_hrs' => $total_absent_hours,
		'based_released_ut_hrs' => $undertime_total,
		'based_release_late_hrs' => $tardiness_total,
		'based_release_overbreak_hrs' => $overbreak_total,

		'based_released_daily_rate' => $daily_rate,
		'based_released_hourly_rate' => $hourly_rate,
		'hourly_rate_difference' => $additional_hr,
		'date_posted' => $date_posted

	);


	$this->payroll_generate_retro_model->post_retro($save_retro_detailed_values,$c->month_cover);
}




?>