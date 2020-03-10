<?php

//============get minimum wage setup per location
$minimum_wage=$this->payroll_generate_payslip_model->minimum_wage_setup($company_id,$location_id);
if(!empty($minimum_wage)){
	$minimum_wage=$minimum_wage->minimum_amount;
}else{
	$minimum_wage="";
}

//============get standard regular hours in a cutoff ( e.g month 1 to month 15)
$time_setting_id=59; // id is system default  ( regular hours base )
$reg_hrs_base=$this->payroll_generate_payslip_model->get_time_setting_value($classification_id,$employment_id,$company_id,$time_setting_id);
if(!empty($reg_hrs_base)){
	$standard_total_regular_hours=$reg_hrs_base->setting_value;
}else{
	$standard_total_regular_hours=104;
}

//$payroll_formula=$this->payroll_generate_payslip_model->formula_setup($company_id,$location_id,$classification_id,$employment_id,$active_pay_type,$active_salary_rate);
$payroll_formula=$this->payroll_generate_payslip_model->formula_setup($company_id,$employment_id,$active_pay_type,$active_salary_rate);

if(!empty($payroll_formula)){

$taxable_formula=$payroll_formula->taxable_formula;

$absent_formula=$payroll_formula->absent_formula;
$late_formula=$payroll_formula->late_formula;
$ut_formula=$payroll_formula->ut_formula;
$overbreak_formula=$payroll_formula->overbreak_formula;
$thirteenth_month_formula=$payroll_formula->thirteenth_month_formula;
$thirteenth_month_taxable=$payroll_formula->thirteenth_month_taxable;

$net_basic_formula=$payroll_formula->net_basic_formula_code;
$net_basic_formula_desc=$payroll_formula->net_basic_formula_desc;

$ot_formula=$payroll_formula->ot_formula_code;
$ot_formula_desc=$payroll_formula->ot_formula_desc;

$gross_formula=$payroll_formula->gross_formula_code;
$gross_formula_desc=$payroll_formula->gross_formula_desc;

$cola_formula=$payroll_formula->cola_formula_code;
$cola_formula_desc=$payroll_formula->cola_formula_desc;

$absent_formula=$payroll_formula->absent_formula_code;
$absent_formula_desc=$payroll_formula->absent_formula_desc;

$late_formula=$payroll_formula->late_formula_code;
$late_formula_desc=$payroll_formula->late_formula_desc;

$ut_formula=$payroll_formula->ut_formula_code;
$ut_formula_desc=$payroll_formula->ut_formula_desc;

$overbreak_formula=$payroll_formula->overbreak_formula_code;
$overbreak_formula_desc=$payroll_formula->overbreak_formula_desc;

$taxable_formula=$payroll_formula->taxable_formula_code;
$taxable_formula_desc=$payroll_formula->taxable_formula_desc;

$pi_formula=$payroll_formula->pi_formula_code;
$pi_formula_desc=$payroll_formula->pi_formula_desc;

$sss_formula=$payroll_formula->sss_formula_code;
$sss_formula_desc=$payroll_formula->sss_formula_desc;

$philhealth_formula=$payroll_formula->philhealth_formula_code;
$philhealth_formula_desc=$payroll_formula->philhealth_formula_desc;

$wtax_formula=$payroll_formula->wtax_formula_code;
$wtax_formula_desc=$payroll_formula->wtax_formula_desc;

$income_sum_formula=$payroll_formula->income_sum_formula_code;
$income_sum_formula_desc=$payroll_formula->income_sum_formula_desc;

$deduction_sum_formula=$payroll_formula->deduction_sum_formula_code;
$deduction_sum_formula_desc=$payroll_formula->deduction_sum_formula_desc;

$net_pay_formula=$payroll_formula->net_pay_formula_code;
$net_pay_formula_desc=$payroll_formula->net_pay_formula_desc;

}else{

$sss_formula="";
$philhealth_formula="";

$wtax_formula="";
$wtax_formula_desc="";

$overbreak_formula="";

$thirteenth_month_formula="";
$thirteenth_month_taxable="";

$net_basic_formula="";
$net_basic_formula_desc="";

$ot_formula="";
$ot_formula_desc="";

$gross_formula="";
$gross_formula_desc="";

$cola_formula="";
$cola_formula_desc="";

$absent_formula="";
$absent_formula_desc="";

$late_formula="";
$late_formula_desc="";

$ut_formula="";
$ut_formula_desc="";

$taxable_formula="";
$taxable_formula_desc="";

$pi_formula="";
$pi_formula_desc="";

$income_sum_formula="";
$income_sum_formula_desc="";

$deduction_sum_formula="";
$deduction_sum_formula_desc="";

$net_pay_formula="";
$net_pay_formula_desc="";
}


$overtime_table_name="timecard_table_".$company_id;
$validate_ot_table=$this->payroll_generate_payslip_model->check_overtime_table($overtime_table_name);
if(!empty($validate_ot_table)){
	//============regular ot
	$check_ot_table_regular=$this->payroll_generate_payslip_model->get_ot_table($company_id,$employment_id,$active_pay_type,$active_salary_rate,1);
	if(!empty($check_ot_table_regular)){
		$regot_withnd_rate=$check_ot_table_regular->ot_nd;//reg_nd;
		$regot_with_out_nd_rate=$check_ot_table_regular->reg_wnd;
		$regot_ot_withnd_rate=$check_ot_table_regular->ot_nd;
		$regot_ot_with_out_nd_rate=$check_ot_table_regular->ot_wnd;

		$ws_nd=$check_ot_table_regular->reg_nd;
	}else{
		$ws_nd="";
		$regot_withnd_rate="";
		$regot_with_out_nd_rate="";
		$regot_ot_withnd_rate="";
		$regot_ot_with_out_nd_rate="";
	}

	//============rest day ot
	$check_ot_table_rd=$this->payroll_generate_payslip_model->get_ot_table($company_id,$employment_id,$active_pay_type,$active_salary_rate,2);
	if(!empty($check_ot_table_rd)){
		$rdot_withnd_rate=$check_ot_table_rd->reg_nd;
		$rdot_with_out_nd_rate=$check_ot_table_rd->reg_wnd;
		$rdot_ot_withnd_rate=$check_ot_table_rd->ot_nd;
		$rdot_ot_with_out_nd_rate=$check_ot_table_rd->ot_wnd;
	}else{
		$rdot_withnd_rate="";
		$rdot_with_out_nd_rate="";
		$rdot_ot_withnd_rate="";
		$rdot_ot_with_out_nd_rate="";
	}

	//============regular holiday ot
	$check_ot_table_reghol=$this->payroll_generate_payslip_model->get_ot_table($company_id,$employment_id,$active_pay_type,$active_salary_rate,3);
	if(!empty($check_ot_table_reghol)){
		$rhot_withnd_rate=$check_ot_table_reghol->reg_nd;
		$rhot_with_out_nd_rate=$check_ot_table_reghol->reg_wnd;
		$rhot_ot_withnd_rate=$check_ot_table_reghol->ot_nd;
		$rhot_ot_with_out_nd_rate=$check_ot_table_reghol->ot_wnd;
	}else{
		$rhot_withnd_rate="";
		$rhot_with_out_nd_rate="";
		$rhot_ot_withnd_rate="";
		$rhot_ot_with_out_nd_rate="";
	}

	//============regular holiday ot /rest day type 1 ( this is for with attendance)
	$check_ot_table_reghol_rdt1=$this->payroll_generate_payslip_model->get_ot_table($company_id,$employment_id,$active_pay_type,$active_salary_rate,5);
	if(!empty($check_ot_table_reghol_rdt1)){
		$rh_rdt1_ot_withnd_rate=$check_ot_table_reghol_rdt1->reg_nd;
		$rh_rdt1_ot_with_out_nd_rate=$check_ot_table_reghol_rdt1->reg_wnd;
		$rh_rdt1_ot_ot_withnd_rate=$check_ot_table_reghol_rdt1->ot_nd;
		$rh_rdt1_ot_ot_with_out_nd_rate=$check_ot_table_reghol_rdt1->ot_wnd;
	}else{
		$rh_rdt1_ot_withnd_rate="";
		$rh_rdt1_ot_with_out_nd_rate="";
		$rh_rdt1_ot_ot_withnd_rate="";
		$rh_rdt1_ot_ot_with_out_nd_rate="";
	}

	//============regular holiday ot /rest day type 2( this is for no attendance)
	$check_ot_table_reghol_rdt2=$this->payroll_generate_payslip_model->get_ot_table($company_id,$employment_id,$active_pay_type,$active_salary_rate,6);
	if(!empty($check_ot_table_reghol_rdt2)){
		//$rh_rdt2_ot_withnd_rate=$check_ot_table_reghol_rdt2->reg_nd;
		$rh_rdt2_ot_with_out_nd_rate=$check_ot_table_reghol_rdt2->reg_wnd;
		// $rh_rdt2_ot_ot_withnd_rate=$check_ot_table_reghol_rdt2->ot_nd;
		// $rh_rdt2_ot_ot_with_out_nd_rate=$check_ot_table_reghol_rdt2->ot_wnd;
	}else{
		//$rh_rdt2_ot_withnd_rate="";
		$rh_rdt2_ot_with_out_nd_rate="";
		// $rh_rdt2_ot_ot_withnd_rate="";
		// $rh_rdt2_ot_ot_with_out_nd_rate="";
	}

	//============special non working holiday ot
	$check_ot_table_snwhol=$this->payroll_generate_payslip_model->get_ot_table($company_id,$employment_id,$active_pay_type,$active_salary_rate,4);
	if(!empty($check_ot_table_snwhol)){
		$snwot_withnd_rate=$check_ot_table_snwhol->reg_nd;
		$snwot_with_out_nd_rate=$check_ot_table_snwhol->reg_wnd;
		$snwot_ot_withnd_rate=$check_ot_table_snwhol->ot_nd;
		$snwot_ot_with_out_nd_rate=$check_ot_table_snwhol->ot_wnd;
	}else{
		$snwot_withnd_rate="";
		$snwot_with_out_nd_rate="";
		$snwot_ot_withnd_rate="";
		$snwot_ot_with_out_nd_rate="";
	}

	//============special non working holiday /rest day ot
	$check_ot_table_snw_rd_hol=$this->payroll_generate_payslip_model->get_ot_table($company_id,$employment_id,$active_pay_type,$active_salary_rate,7);
	if(!empty($check_ot_table_snw_rd_hol)){
		$snw_rd_ot_withnd_rate=$check_ot_table_snw_rd_hol->reg_nd;
		$snw_rd_ot_with_out_nd_rate=$check_ot_table_snw_rd_hol->reg_wnd;
		$snw_rd_ot_ot_withnd_rate=$check_ot_table_snw_rd_hol->ot_nd;
		$snw_rd_ot_ot_with_out_nd_rate=$check_ot_table_snw_rd_hol->ot_wnd;
	}else{
		$snw_rd_ot_withnd_rate="";
		$snw_rd_ot_with_out_nd_rate="";
		$snw_rd_ot_ot_withnd_rate="";
		$snw_rd_ot_ot_with_out_nd_rate="";
	}

}else{ // no overtime table setup yet.
		$regot_withnd_rate="";
		$regot_with_out_nd_rate="";
		$regot_ot_withnd_rate="";
		$regot_ot_with_out_nd_rate="";

		$rdot_withnd_rate="";
		$rdot_with_out_nd_rate="";
		$rdot_ot_withnd_rate="";
		$rdot_ot_with_out_nd_rate="";

		$rhot_withnd_rate="";
		$rhot_with_out_nd_rate="";
		$rhot_ot_withnd_rate="";
		$rhot_ot_with_out_nd_rate="";

		$rh_rdt1_ot_withnd_rate="";
		$rh_rdt1_ot_with_out_nd_rate="";
		$rh_rdt1_ot_ot_withnd_rate="";
		$rh_rdt1_ot_ot_with_out_nd_rate="";

		$rh_rdt2_ot_with_out_nd_rate="";

		$snwot_withnd_rate="";
		$snwot_with_out_nd_rate="";
		$snwot_ot_withnd_rate="";
		$snwot_ot_with_out_nd_rate="";

		$snw_rd_ot_withnd_rate="";
		$snw_rd_ot_with_out_nd_rate="";
		$snw_rd_ot_ot_withnd_rate="";
		$snw_rd_ot_ot_with_out_nd_rate="";




}


//============get individual pagibig table
$mypagibig_setup=$this->payroll_generate_payslip_model->get_individual_pagibig_table($company_id,$employee_id,$year_cover);
if(!empty($mypagibig_setup)){

	$pi_amount=$mypagibig_setup->amount;
	$pi_will_deduct_on=$mypagibig_setup->cut_off_id;
	$pi_will_deduct_on_name=$mypagibig_setup->cut_off_name;
	$pi_amount_type=$mypagibig_setup->pagibig_type_id; // cValue

}else{

	$pi_amount=0;
	$pi_will_deduct_on_name="";
	$pi_will_deduct_on="";
	$pi_amount_type="";
}


//============get philhealth deduction setup

if($is_ph_ded_per_emp=="yes"){

}else{
	$philhealth_deduction_setup=$this->payroll_generate_payslip_model->get_philhealth_deduction_setup($company_id,$active_pay_type,$active_salary_rate,$year_cover);
	if(!empty($philhealth_deduction_setup)){

		$philhealth_deduct_on=$philhealth_deduction_setup->cut_off_id;
		if($philhealth_deduct_on=="6"){// every payday deduction
				$deduct_philhealth="yes"; // proceed deduct philhealth

		}else{// with specific cutoff deduction setup
			if($cut_off==$philhealth_deduct_on){
				$deduct_philhealth="yes"; // proceed deduct philhealth
			}else{
				$deduct_philhealth="no"; // 
			}		
		}

	}else{
			$deduct_philhealth="no"; // 
			$philhealth_deduct_on="";

	}	
}


//============get sss deduction setup
if($is_sss_ded_per_emp=="yes"){// per employee ang deduction schedule ni sss

}else{
	$sss_deduction_setup=$this->payroll_generate_payslip_model->get_sss_deduction_setup($company_id,$active_pay_type,$active_salary_rate,$year_cover);
	if(!empty($sss_deduction_setup)){
	//$cut_off
		$sss_deduct_on=$sss_deduction_setup->cut_off_id;
		if($sss_deduct_on=="6"){// every payday deduction
				$deduct_sss="yes"; // proceed deduct sss

		}else{// with specific cutoff deduction setup
			if($cut_off==$sss_deduct_on){
				$deduct_sss="yes"; // proceed deduct sss
			}else{
				$deduct_sss="no"; // 
			}		
		}
			
	}else{
			$deduct_sss="no"; // 
			$sss_deduct_on="";
			
	}

}






?>