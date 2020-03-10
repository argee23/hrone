<?php
$payperiod_state=$this->time_dtr_model->check_payroll_period_dtr_state($pay_period);

if(!empty($payperiod_state)){
	//echo "nakalock na yung dtr or payroll";
}else{


$process_leave_type_state=$this->time_dtr_model->process_my_dtr_leave_type($leave_type_id,$leave_day_type,$employee_id,$pay_period,$leave_type_doc_no,$company_id,$p_from);


}
?>