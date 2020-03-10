<?php
$payperiod_state=$this->time_dtr_model->check_payroll_period_dtr_state($pay_period);

if(!empty($payperiod_state)){
	//echo "nakalock na yung dtr or payroll";
}else{
	//check if payroll is already posted but not locked - pag nagawa na ni sir jc
$process_dtr_summary_state=$this->time_dtr_model->process_my_dtr_leave_adjustment_forms($company_id,$pay_period,$employee_id,$salary_rate,$pay_type,$list_of_leave_adjustment);


}
?>