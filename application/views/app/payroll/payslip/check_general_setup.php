<?php
$gen_pay_theme=$this->payroll_generate_payslip_model->get_payroll_theme($company_id,1);
if(!empty($gen_pay_theme)){
	$bg_color_genpay=$gen_pay_theme->bg_color;
	$font_color_genpay=$gen_pay_theme->font_color;
	$overlay_genpay=$gen_pay_theme->bg_overlay;
	$bg_color_viewcomp_act_cutoff=$gen_pay_theme->view_comp_chosen_cutoff_bg;
	$actual_payslip_design=$gen_pay_theme->payslip_design;
}else{
	$bg_color_genpay="#006699";
	$font_color_genpay="#FFF";
	$overlay_genpay="#000";
	$bg_color_viewcomp_act_cutoff="#D9E6FC";
	$actual_payslip_design="117"; // default Type 1
}

    


// ===== start initialize default settings if setting is not yet set.

$payslip_decimal_place=2;
$round_off_payslip="yes";
$minimum_netpay_to_post=0;
$follow_loan_decimal_policy="no";
$loan_decimal_place=2;
$loan_roundoff="yes";
$minimum_employee_share="100";
$maximum_employee_share="100";
$minimum_employer_share="100";
$maximum_employer_share="100";
$fixed_employer_share=100;
$show_emp_electronic_sign="no";
$ot_auto_meal_allowance="OFF";
$auto_netpay_adjust_setting="Off Manually Check and Adjust";
$pi_taxable_amt_beyond=100;
$compensation_initial_decimal_place="2";
$tax_deduction_type="general by taxtable"; // based on tax table
$pagibig_taxable_contri_ceil=100;
$is_sss_ded_per_emp="no";// default same company same schedule of deduction in sss
$is_ph_ded_per_emp="no";// default same company same schedule of deduction in philhealth
$is_sss_netbasic_basis_fixed="no";// default na kapag every 1st cutoff ang deduction ng sss, it would be base on net basic , no: means netbasic less absent
$is_philhealth_netbasic_basis_fixed="no";// default na kapag every 1st cutoff ang deduction ng philhealth, it would be base on net basic , no: means netbasic less absent
// ===== end initialize default settings if setting is not yet set.

//============get single field general by company payroll policy
$payroll_policy=$this->payroll_generate_payslip_model->check_single_setup_payroll($company_id);
if(!empty($payroll_policy)){

	foreach ($payroll_policy as $pol){

			$payroll_policy_main_id=$pol->payroll_main_id;
			$payroll_policy_company=$pol->company_id;
			$payroll_policy_single_field=$pol->single_field;
			$payroll_policy_title=$pol->title;
			
				if($payroll_policy_main_id=="1"){ //Payslip Decimal Place 
					$payslip_decimal_place=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="5"){//Round it off payslip decimal place
					$round_off_payslip=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="2"){//Minimum Net Pay Amount to Post Payslip 
					$minimum_netpay_to_post=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="7"){//For loan deductions  follow the separate  decimal place treatment setup
					$follow_loan_decimal_policy=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="8"){//Loan Decimal Place
					$loan_decimal_place=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="9"){//Loan Round it Off
					$loan_roundoff=$payroll_policy_single_field;
				}

				else if($payroll_policy_main_id=="10"){//Pagibig Minimum Employee Contribution
					$minimum_employee_share=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="11"){//Pagibig Maximum Employee Contribution
					$maximum_employee_share=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="12"){//Pagibig Minimum EmployER Contribution
					$minimum_employer_share=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="13"){//Pagibig Maximum EmployER Contribution
					$maximum_employer_share=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="14"){//Fixed Employer Share Pagibig Amount Setting
					$fixed_employer_share=$payroll_policy_single_field;

				}else if($payroll_policy_main_id=="16"){//Upon payslip acknowledge automatic attached the employee electronic signature on payslip.
					$show_emp_electronic_sign=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="17"){//Overtime Automatic Meal Allowance.
					$ot_auto_meal_allowance=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="18"){//Automatic Net Pay Adjustment on negative Net Pay.
					$auto_netpay_adjust_setting=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="19"){//Pagibig Taxable Amount is Beyond
					$pi_taxable_amt_beyond=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="21"){//Compensation (daily rate,hourly rate) Decimal Place
					$compensation_initial_decimal_place=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="23"){//Tax Deduction Type
					$tax_deduction_type=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="24"){//Pagibig Taxable Contribution Ceiling
					$pagibig_taxable_contri_ceil=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="25"){//Is SSS deduction schedule per employee?
					$is_sss_ded_per_emp=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="26"){//Is Philhealth deduction schedule per employee?
					$is_ph_ded_per_emp=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="27"){//Is SSS Net Basic basis fixed monthly basic ( for daily rates ) ?
					$is_sss_netbasic_basis_fixed=$payroll_policy_single_field;
				}else if($payroll_policy_main_id=="28"){//Is Philhealth Net Basic basis fixed monthly basic ( for daily rates ) ?
					$is_philhealth_netbasic_basis_fixed=$payroll_policy_single_field;
				}

				else{// unknown - new setting
				}
			
	}

}else{
	//============= system default setup if client didnt set up the policy.

}



//============get default_auto_ot_meal id
$default_other_addition="default_ot_meal";
$auto_oa_id=$this->payroll_generate_payslip_model->get_default_other_addition($company_id,$default_other_addition);
if(!empty($auto_oa_id)){
	$auto_ot_meal_allowance_oa_id=$auto_oa_id->id;
}else{
	$auto_ot_meal_allowance_oa_id="";
}



//============get default_auto_leave_adj id
$default_other_addition="default_leave_adj";
//la -> leave adjustment
$auto_la_id=$this->payroll_generate_payslip_model->get_default_other_addition($company_id,$default_other_addition);
if(!empty($auto_la_id)){
	$auto_leave_adj_oa_id=$auto_la_id->id;
	$is_leave_adj_taxable=$auto_la_id->taxable;
}else{
	// insert the default other addition .?
	$auto_leave_adj_oa_id="";
	$is_leave_adj_taxable="";
}
?>