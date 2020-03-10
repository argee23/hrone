<?php
$net_basic_formula_how_to=$hourly_formula_text."<br>".$daily_formula."<br>".$basic_formula_text;
$ot_formula_how_to=$ot_formula_desc.'<br>
                    '.$regot_formula_text.'
                    '.$regotnd_formula_text.'

                    '.$rdot_with_out_nd_formula_text.'
                    '.$rdot_withnd_formula_text.'
                    '.$rdot_ot_with_out_nd_formula_text.'
                    '.$rdot_ot_withnd_formula_text.'

                    '.$rhot_with_out_nd_formula_text.'
                    '.$rhot_withnd_formula_text.'
                    '.$rhot_ot_with_out_nd_formula_text.'
                    '.$rhot_ot_withnd_formula_text.'

                    '.$rh_rdt2_formula_text.'

                    '.$rh_rdt1_ot_with_out_nd_formula_text.'
                    '.$rh_rdt1_ot_withnd_formula_text.'
                    '.$rh_rdt1_ot_ot_with_out_nd_formula_text.'
                    '.$rh_rdt1_ot_ot_withnd_formula_text.' 

                    '.$snwot_with_out_nd_formula_text.'
                    '.$snwot_withnd_formula_text.'
                    '.$snwot_ot_with_out_nd_formula_text.'
                    '.$snwot_ot_withnd_formula_text.'  

                    '.$snw_rd_ot_with_out_nd_formula_text.'
                    '.$snw_rd_ot_withnd_formula_text.'
                    '.$snw_rd_ot_ot_with_out_nd_formula_text.'
                    '.$snw_rd_ot_ot_withnd_formula_text.'';

$oa_taxable_how_to=$oae_taxable_list."".$auto_oae_taxable_list."".$auto_ot_meal_allowance_how_to_taxable."".$taxable_payroll_leave_adjustment_how_to;
$oa_nontax_how_to=$oae_nontaxable_list."".$auto_oae_nontaxable_list."".$auto_ot_meal_allowance_how_to_nontaxable."".$nontax_payroll_leave_adjustment_how_to;

$cola_how_to=$cola_formula_text."<br>";

$od_taxable_how_to=$ode_taxable_list."<br>".$auto_ode_taxable_list."<br>";
$od_nontax_how_to=$ode_nontaxable_list."<br>".$auto_ode_nontaxable_list."<br>";

$gross_formula_how_to=$gross_formula_text;
$loan_how_to=$loan_text."<br>".$pause_loan_text."<br>".$nonpriority_loan_text;

$sss_formula_how_to=$sss_formula_text."<br>".$sss_employer_share_text;
$ph_formula_how_to=$philhealth_formula_text."<br>".$philhealth_employer_share_text;
$pi_formula_how_to=$pagibig_contribution_text;

$absent_formula_how_to=$absent_formula_text;
$late_formula_how_to=$late_formula_text;
$ut_formula_how_to=$undertime_formula_text;
$overbreak_formula_how_to=$overbreak_formula_text;
$taxable_formula_how_to=$taxable_formula_text;
$wtax_formula_how_to=$wtax_formula_text;
$income_total_how_to=$income_sum_formula_text;
$deduction_total_how_to=$deduction_sum_formula_text;
$net_pay_formula_how_to=$net_pay_formula_text;


if(($selected_payroll_option=="post_all")AND($proceed_posting=="no")){
	/* == kasi nauna nyang pinost doon sa loop ng computing ng loans.==
	at the compute_loans upon posting payroll . loan will be posted already.
	at the save_payroll system will check if netpay is within the minimum required netpay to post payslip
	if false : reset the initially posted loan. thats why start below code.
	*/
	$month_cover_edited = sprintf("%02d", $month_cover);
	$table_for_loans="payslip_loan_".$month_cover_edited;

	$this->db->query("DELETE FROM `".$table_for_loans."` WHERE payroll_period_id = '".$pay_period."' and employee_id='".$employee_id."' and company_id='".$company_id."'");
	// if false : end reset the initially posted loan.

	echo "
	<tr>
	<td colspan='6'><i class='fa fa-close text-danger' style='font-size:48px;'></i> Minimum Net Pay Amount to Post Payslip is ($minimum_netpay_to_post). Employee Net Pay is ($net_pay_formula_value). 
	<i class='fa fa-quote-left text-info' style='font-size:20px;'></i>
	<span class='system_auto_guide'>go to payroll > payroll settings > choose the employee company > Minimum Net Pay Amount to Post Payslip</span>
	<i class='fa fa-quote-right text-info' style='font-size:20px;'></i>
	</td></tr>";

}else{

}


if(($month_cover==1)AND($cut_off=="1")){
	$ytd_sss=$sss_employee_share;
	$ytd_philhealth=$philhealth_employee_share;
	$ytd_pagibig=$pagibig_contribution_employee;
	$ytd_wtax=$witheld_tax;

	$ytd_gross=$gross_formula_value;
	$ytd_taxable=$actual_taxable_formula_value;

}else{

	if($cut_off=="1"){
		$ytd_month_ref=$month_cover-1;
		$mustbegreaterthan="yes";
	}else{
		$ytd_month_ref=$month_cover;
		$mustbegreaterthan="";
	}
	$get_ytd=$this->payroll_generate_payslip_model->get_ytd($ytd_month_ref,$year_cover,$pay_period,$cut_off,$employee_id,$mustbegreaterthan);
	if(!empty($get_ytd)){
		$ytd_sss=$sss_employee_share+$get_ytd->ytd_sss;
		$ytd_philhealth=$philhealth_employee_share+$get_ytd->ytd_philhealth;
		$ytd_pagibig=$pagibig_contribution_employee+$get_ytd->ytd_pagibig;
		$ytd_wtax=$witheld_tax+$get_ytd->ytd_wtax;

		$ytd_gross=$gross_formula_value+$get_ytd->ytd_gross;
		$ytd_taxable=$actual_taxable_formula_value+$get_ytd->ytd_taxable;
	}else{
		$ytd_sss=$sss_employee_share;
		$ytd_philhealth=$philhealth_employee_share;
		$ytd_pagibig=$pagibig_contribution_employee;
		$ytd_wtax=$witheld_tax;
		$ytd_gross=$gross_formula_value;
		$ytd_taxable=$actual_taxable_formula_value;

	}
}




if(($selected_payroll_option=="post_all")AND($proceed_posting=="yes")){

	if($total_loan=="0"){

			$month_cover_edited = sprintf("%02d", $month_cover);
			$table_for_loans="payslip_loan_".$month_cover_edited;

			$this->db->query("DELETE FROM `".$table_for_loans."` WHERE payroll_period_id = '".$pay_period."' and employee_id='".$employee_id."' and company_id='".$company_id."'");


	}else{

	}

	$date_posted=date('Y-m-d H:i:s');
	$save_payroll_values = array(
		'payroll_period_id' => $pay_period,
		'company_id' => $company_id,
		'employee_id' => $employee_id,
		'pay_type' => $active_pay_type,
		'salary_rate' => $active_salary_rate,
		'salary_ratename' => $mysalaryrate_name,
		'salary_amount' => $mysalary_amount,
		'salary_no_of_hour' => $mysalary_no_of_hours,
		'salary_month_days_no' => $mysalary_no_of_days_monthly,
		'salary_year_days_no' => $mysalary_no_of_days_yearly,
		'salary_id' => $mysalary_id,
		'daily_rate' => $daily_rate,
		'hourly_rate' => $hourly_value,
		'wtax_code' => $taxcode_name,
		'ytd_sss' => $ytd_sss,
		'ytd_philhealth' => $ytd_philhealth,
		'ytd_pagibig' => $ytd_pagibig,
		'ytd_wtax' => $ytd_wtax,
		'ytd_gross' => $ytd_gross,
		'ytd_taxable' => $ytd_taxable,
		'basic' => $net_basic_value,
		'leave_basic' => $leave_basic_equivalent,
		'overtime' => $total_overtime_amount,
		'regot_value' => $regot_value,
		'regotnd_value' => $regotnd_value,
		'rdot_with_out_nd_value' => $rdot_with_out_nd_value,
		'rdot_withnd_value' => $rdot_withnd_value,
		'rdot_ot_with_out_nd_value' => $rdot_ot_with_out_nd_value,
		'rdot_ot_withnd_value' => $rdot_ot_withnd_value,
		'rhot_with_out_nd_value' => $rhot_with_out_nd_value,
		'rhot_withnd_value' => $rhot_withnd_value,
		'rhot_ot_with_out_nd_value' => $rhot_ot_with_out_nd_value,
		'rhot_ot_withnd_value' => $rhot_ot_withnd_value,
		'rh_rdt2_value' => $rh_rdt2_value,
		'rh_rdt1_ot_with_out_nd_value' => $rh_rdt1_ot_with_out_nd_value,
		'rh_rdt1_ot_withnd_value' => $rh_rdt1_ot_withnd_value,
		'rh_rdt1_ot_ot_with_out_nd_value' => $rh_rdt1_ot_ot_with_out_nd_value,
		'rh_rdt1_ot_ot_withnd_value' =>   $rh_rdt1_ot_ot_withnd_value , 
		'snwot_with_out_nd_value' => $snwot_with_out_nd_value,
		'snwot_withnd_value' => $snwot_withnd_value,
		'snwot_ot_with_out_nd_value' => $snwot_ot_with_out_nd_value,
		'snwot_ot_withnd_value' =>    $snwot_ot_withnd_value,
		'snw_rd_ot_with_out_nd_value' => $snw_rd_ot_with_out_nd_value,
		'snw_rd_ot_withnd_value' =>  $snw_rd_ot_withnd_value,
		'snw_rd_ot_ot_with_out_nd_value' => $snw_rd_ot_ot_with_out_nd_value,
		'snw_rd_ot_ot_withnd_value' => $snw_rd_ot_ot_withnd_value,
		'shift_night_diff' => $ws_nd_value,
		'cola' => $total_cola_amount,
		'other_addition_taxable' => $total_taxable_oa,
		'other_addition_non_tax' => $total_nontaxable_oa,
		'other_deduction_taxable' => $total_taxable_od,
		'other_deduction_nontax' => $total_nontaxable_od,
		'gross' => $gross_formula_value,
		'loan' => $total_loan,
		'sss_employee' => $sss_employee_share,
		'sss_employer' => $sss_employer_share,
		'sss_ec_er' => $sss_employer_share_ec,
		'sss_gross' => $sss_gross,
		'philhealth_employee' => $philhealth_employee_share,
		'philhealth_employer' => $philhealth_employer_share,
		'philhealth_gross' => $philhealth_gross,
		'pagibig' => $pagibig_contribution_employee,
		'pagibig_employer' => $pagibig_contribution_employer,
		'absent' => $absent_formula_value,
		'late' => $late_formula_value,
		'undertime' => $undertime_formula_value,
		'overbreak' => $overbreak_formula_value,
		'taxable' => $actual_taxable_formula_value,
		'wtax_type' => '',
		'wtax' => $witheld_tax,
		'income_total' => $income_sum_formula_value,
		'deduction_total' => $deduction_sum_formula_value,
		'net_pay' => $net_pay_formula_value,
		'date_posted' => $date_posted,
		'tax_deduction_type_name' => $tax_deduction_type_name,
		'assumed_taxable_yearly' => $assumed_taxable_yearly,
		'assumed_taxable_monthly' => $assumed_taxable_monthly,
		'assumed_tax_in_a_year' => $assumed_tax_in_a_year,
		'assumed_tax_in_a_month' => $assumed_tax_in_a_month,
		'assumed_tax_in_a_cutoff' => $assumed_tax_in_a_cutoff,
		'system_user' => '',
	);


$oa_taxable_how_to_clean_all=$oae_taxable_list_clean."<br>".$auto_oae_taxable_list_clean."<br>".$auto_ot_clean_taxable;
$oa_nontaxable_how_to_clean_all=$oae_nontaxable_list_clean."<br>".$auto_oae_nontaxable_list_clean."<br>".$auto_ot_clean_nontaxable;

$od_taxable_how_to_clean_all=$ode_taxable_list_clean."<br>".$auto_ode_taxable_list_clean;
$od_nontaxable_how_to_clean_all=$ode_nontaxable_list_clean."<br>".$auto_ode_nontaxable_list_clean;

	$save_payroll_how_to = array(
		'payroll_period_id' => $pay_period,
		'company_id' => $company_id,
		'employee_id' => $employee_id,
		'net_basic_formula' => $net_basic_formula_how_to,
		'ot_formula' => $ot_formula_how_to,
		'shift_night_diff_formula' => $ws_nd_formula_text,
		'oa_taxable_how_to' => $oa_taxable_how_to,
		'oa_nontax_how_to' => $oa_nontax_how_to,
		'od_taxable_how_to' => $od_taxable_how_to,
		'od_nontax_how_to' => $od_nontax_how_to,
		'oa_taxable_how_to_clean' => $oa_taxable_how_to_clean_all,
		'oa_nontax_how_to_clean' => $oa_nontaxable_how_to_clean_all,
		'od_taxable_how_to_clean' => $od_taxable_how_to_clean_all,
		'od_nontax_how_to_clean' => $od_nontaxable_how_to_clean_all,
		'cola_how_to' => $cola_how_to,
		'gross_formula' => $gross_formula_how_to,
		'loan_how_to' => $loan_how_to,
		'sss_formula' => $sss_formula_how_to,
		'ph_formula' => $ph_formula_how_to,
		'pi_formula' => $pi_formula_how_to,
		'absent_formula' => $absent_formula_how_to,
		'late_formula' => $late_formula_how_to,
		'ut_formula' => $ut_formula_how_to,
		'overbreak_formula' => $overbreak_formula_how_to,
		'taxable_formula' => $taxable_formula_how_to,
		'wtax_formula' => $wtax_formula_how_to,
		'income_total_how_to' => $income_total_how_to,
		'deduction_total_how_to' => $deduction_total_how_to,
		'net_pay_formula' => $net_pay_formula_how_to,
		'date_posted' => $date_posted,
		'system_user' => '',

	);




if(($cut_off=="1")AND($first_cutoff_payslip_state=="posted")){
	echo "
	<tr>
	<td colspan='6'><i class='fa fa-check-square text-info' style='font-size:48px;'></i> 
	Payroll is already posted previously.
	<span class='system_auto_guide'> If you would like to repost/recalculate the payroll reset the payslip first . go to payroll > reset payslip</span>
	<i class='fa fa-quote-right text-info' style='font-size:20px;'></i>
	</td></tr>";

}elseif(($cut_off=="2")AND($second_cutoff_payslip_state=="posted")){
	echo "
	<tr>
	<td colspan='6'><i class='fa fa-check-square text-info' style='font-size:48px;'></i> 
	Payroll is already posted previously.
	<span class='system_auto_guide'> If you would like to repost/recalculate the payroll reset the payslip first . go to payroll > reset payslip</span>
	<i class='fa fa-quote-right text-info' style='font-size:20px;'></i>
	</td></tr>";
}else{


	echo "
	<tr>
	<td colspan='6'><i class='fa fa-check-square-o' style='font-size:48px;'></i> Payroll is Successfully Posted.</td>
	</tr>
		";


	$save_payroll=$this->payroll_generate_payslip_model->post_payroll($save_payroll_values,$save_payroll_how_to,$month_cover);

}

	

}else{

}





?>