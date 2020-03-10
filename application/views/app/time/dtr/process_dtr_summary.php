<?php
$payperiod_state=$this->time_dtr_model->check_payroll_period_dtr_state($pay_period);

if(!empty($payperiod_state)){
	//echo "nakalock na yung dtr or payroll";
}else{
	// check if payroll is already posted but not locked - pag nagawa na ni sir jc



$process_dtr_summary_state=$this->time_dtr_model->process_my_dtr_summary($month_cover,$company_id,$pay_period,$employee_id,$salary_rate,$pay_type,
$total_regular_hours,$total_regular_hrs_restday,$total_regular_hrs_reg_holiday,$total_regular_hrs_reg_holiday_t1,$total_regular_hrs_reg_holiday_t2,$total_regular_hrs_spec_holiday,$total_restday_regular_hrs_spec_holiday,$absences_total,
$total_regular_nd,$total_restday_nd,$total_reg_holiday_nd,$total_restday_reg_holiday_nd,$total_spec_holiday_nd,$total_restday_spec_holiday_nd,$undertime_total,
$total_regular_overtime,$total_restday_overtime,$total_reg_holiday_overtime,$total_restday_reg_holiday_overtime,$total_spec_holiday_overtime,$total_restday_spec_holiday_overtime,$tardiness_total,
$total_regular_overtime_nd,$total_restday_overtime_nd,$total_reg_holiday_overtime_nd,$total_restday_reg_holiday_overtime_nd,$total_spec_holiday_overtime_nd,$total_restday_spec_holiday_overtime_nd,$overbreak_total,$overbreak_occurence,$tardiness_occurence,$undertime_occurence,$absences_occurence,$complete_logs_present_occ,$complete_logs_present_occ_ref,$with_tk_logs_present_occ,$with_tk_logs_present_occ_ref,$with_ob_logs_present_occ,$with_ob_logs_present_occ_ref,$with_leave_present_occ,$with_leave_present_occ_ref,$restday_w_logs,$restday_w_logs_ref,$restday_wo_logs,$restday_wo_logs_ref,$reg_holiday_w_logs,$reg_holiday_w_logs_ref,$reg_holiday_wo_logs,$reg_holiday_wo_logs_ref,$rd_reg_holiday_w_logs,$rd_reg_holiday_w_logs_ref,$rd_reg_holiday_wo_logs,$rd_reg_holiday_wo_logs_ref,$snw_holiday_w_logs,$snw_holiday_w_logs_ref,$snw_holiday_wo_logs,$snw_holiday_wo_logs_ref,$rd_snw_holiday_w_logs,$rd_snw_holiday_w_logs_ref,$rd_snw_holiday_wo_logs,$rd_snw_holiday_wo_logs_ref,$leave_reg_hrs,$approve_leave_wpay_count,$absences_total_tracker,$regular_hours_total_tracker);


}

?>