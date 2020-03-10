<?php
$payperiod_state=$this->time_dtr_model->check_payroll_period_dtr_state($pay_period);


if(!empty($payperiod_state)){
	//echo "nakalock na yung dtr or payroll";
}else{

	
	$logs_month=substr($p_from, 5, 2);
	$logs_day=substr($p_from, 8, 2);
	$logs_year=substr($p_from, 0, -6);

	$process_dtr_state=$this->time_dtr_model->process_my_dtr($absent,
	$company_id,$pay_period,$employee_id,$salary_rate,$pay_type,$logs_month,$logs_day,$logs_year,$p_from,
	$shift_in,$shift_out,$actual_in,$actual_out,$act_column_content,$my_late,$over_break,$my_undertime,
	$reg_hours_worked,$official_reg_nd,$official_regular_ot,
	$restday_ot_ot,$snw_holiday_ot_ot,$regular_holiday_ot_ot,
	$rd_snw_holiday_ot_ot,$rd_reg_holiday_ot_ot,
	$official_regular_ot_nd,$regular_holiday_ot_ot_nd,$snw_holiday_ot_ot_nd,$restday_ot_ot_nd,$rd_snw_holiday_ot_ot_nd,$rd_reg_holiday_ot_ot_nd,
	$change_sched_doc_no,$change_restday_doc_no,$old_restday,$new_restday,$multiple_leave_application_details,$pending_leave,$leave_fast_hol_reference,$multiple_ob_form_details,$time_keeping_complaint_doc_no,$under_time_doc_no,$halfday_due_to_undertime_class,$halfday_due_to_late_class,$is_rest_day,$holiday_type,$restday_official,$special_holiday_official,$regular_holiday_official,$restday_special_holiday_official,$restday_regular_holiday_official,$early_cutoff_marked,$remove_time_credit,$advance_duty_form_no,$head_approved_ot_form
		);
}



?>