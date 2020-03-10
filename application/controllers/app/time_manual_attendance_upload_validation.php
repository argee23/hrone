<?php
		

		/*
		----------------------------------------------------------
		group upload & individual upload the same process below.
		----------------------------------------------------------
		----------------------------------------------------------
		validate :start dont allow overwriting of logs if dtr is locked OR payroll is locked OR payroll is already posted.
		----------------------------------------------------------
		*/

						$emp_PayPeriodGroup=$this->time_manual_attendance_model->checkPayPeriodGroup($comp_employee_employee_id,$upload_date_from,$upload_date_to,$selected_individual_employee_id);
						if(!empty($emp_PayPeriodGroup)){

							$dtr_locked=$emp_PayPeriodGroup->d_t_r;
							$payroll_locked=$emp_PayPeriodGroup->generate_payslip;
							$cfrom=$emp_PayPeriodGroup->complete_from; // cutoff from
							$cto=$emp_PayPeriodGroup->complete_to; // cutoff to

							$mfrom=$emp_PayPeriodGroup->month_from; 
							$dfrom=$emp_PayPeriodGroup->day_from; 
							$yfrom=$emp_PayPeriodGroup->year_from;

							$mto=$emp_PayPeriodGroup->month_to; 
							$dto=$emp_PayPeriodGroup->day_to; 
							$yto=$emp_PayPeriodGroup->year_to; 

							$mfrom_text  = $mfrom;
							$mfrom_text = date('F', mktime(0, 0, 0, $mfrom_text, 10)); 

							$mto_text  = $mto;
							$mto_text = date('F', mktime(0, 0, 0, $mto_text, 10)); 

							$text_from_payperiod=$mfrom_text." ".$dfrom." ".$yfrom;
							$text_to_payperiod=$mto_text." ".$dto." ".$yto;
 
							$payperiod_dtr_lock="yes";
							if(($dtr_locked=="1")AND($payroll_locked=="1")){
								$upl_warning="DTR & Payroll already locked for $text_from_payperiod to $text_to_payperiod";
							}elseif(($dtr_locked=="1")AND($payroll_locked=="0")){
								$upl_warning="DTR already locked for $text_from_payperiod to $text_to_payperiod";
							}elseif(($dtr_locked=="0")AND($payroll_locked=="1")){
								$upl_warning="Payroll already locked for Payroll Period: $text_from_payperiod to $text_to_payperiod";
							}else{
								$upl_warning="";
							}

						}else{

							$checkPayslip=$this->time_manual_attendance_model->GoCheckPayslip($comp_employee_employee_id,$upload_date_from,$upload_date_to,$selected_individual_employee_id);

							if(!empty($checkPayslip)){
								$payperiod_dtr_lock="yes";


								$mfrom=$checkPayslip->month_from; 
								$dfrom=$checkPayslip->day_from; 
								$yfrom=$checkPayslip->year_from;

								$mto=$checkPayslip->month_to; 
								$dto=$checkPayslip->day_to; 
								$yto=$checkPayslip->year_to; 

								$mfrom_text  = $mfrom;
								$mfrom_text = date('F', mktime(0, 0, 0, $mfrom_text, 10)); 

								$mto_text  = $mto;
								$mto_text = date('F', mktime(0, 0, 0, $mto_text, 10)); 

								$text_from_payperiod=$mfrom_text." ".$dfrom." ".$yfrom;
								$text_to_payperiod=$mto_text." ".$dto." ".$yto;


								$upl_warning="Payroll already Posted for : $text_from_payperiod to $text_to_payperiod";
							}else{
								$payperiod_dtr_lock="no";
								$upl_warning="";								
							}

						}
		/*
		----------------------------------------------------------
		validate :end dont allow overwriting of logs if dtr is locked OR payroll is locked OR payroll is already posted.
		----------------------------------------------------------
		*/

?>