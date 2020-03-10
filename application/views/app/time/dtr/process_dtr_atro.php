<?php
//$list_of_ot_form;
$payperiod_state=$this->time_dtr_model->check_payroll_period_dtr_state($pay_period);

if(!empty($payperiod_state)){
	//echo "nakalock na yung dtr or payroll";
}else{

	// check if payroll is already posted but not locked - pag nagawa na ni sir jc
$process_dtr_atro_state=$this->time_dtr_model->process_my_dtr_atro($company_id,$pay_period,$employee_id,$salary_rate,$pay_type,$logs_month,$logs_day,$logs_year,$p_from,$list_of_ot_form);

}



?>