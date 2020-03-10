<?php
$prev_emp=$this->reports_payroll_model->get_previous_employer($e->employee_id,$covered_year);
if(!empty($prev_emp)){
	$prev_nontax_tertinmonth=$prev_emp->nontax_tertinmonth;
	$prev_nontax_deminimis=$prev_emp->nontax_deminimis;
	$prev_gov_contri=$prev_emp->gov_contri;
	$prev_nontax_other_salaries=$prev_emp->nontax_other_salaries;

	$prev_basic_salary=$prev_emp->basic_salary;
	$prev_taxable_tertinmonth=$prev_emp->taxable_tertinmonth;
	$prev_taxable_other_salaries=$prev_emp->taxable_other_salaries;

	// start 7.5	
	$prev_gross_compen_inc=$prev_emp->gross_compen_inc;
	$prev_hazard_pay=$prev_emp->hazard_pay;
	$prev_shift_differential=$prev_emp->shift_differential;
	$prev_overtime_pay=$prev_emp->overtime_pay;
	$prev_holiday_pay=$prev_emp->holiday_pay;
	$prev_basic_smw=$prev_emp->basic_smw;
	// end 7.5

	$prev_total_non_taxable=$prev_emp->total_non_taxable;
	$prev_total_taxable=$prev_emp->total_taxable;

	$prev_tax_withheld=$prev_emp->tax_withheld;
}else{
	$prev_nontax_tertinmonth=0;
	$prev_nontax_deminimis=0;
	$prev_gov_contri=0;
	$prev_nontax_other_salaries=0;

	$prev_basic_salary=0;
	$prev_taxable_tertinmonth=0;
	$prev_taxable_other_salaries=0;

	// start 7.5	
	$prev_gross_compen_inc=0;
	$prev_hazard_pay=0;
	$prev_shift_differential=0;
	$prev_overtime_pay=0;
	$prev_holiday_pay=0;
	$prev_basic_smw=0;
	// end 7.5


	$prev_total_non_taxable=0;
	$prev_total_taxable=0;

	$prev_tax_withheld=0;
}

?>