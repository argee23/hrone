<?php
$im_minimum_wage=0;
$my_salary=$this->reports_payroll_model->get_cover_year_salary($e->employee_id,$covered_year);
if(!empty($my_salary)){
	$salary_rate=$my_salary->salary_rate;
	$salary_amount=$my_salary->salary_amount;
	$no_of_hours=$my_salary->no_of_hours;
	$no_of_days_monthly=$my_salary->no_of_days_monthly;
	$no_of_days_yearly=$my_salary->no_of_days_yearly;
	$reason=$my_salary->reason;
	$effectivity_date=$my_salary->date_effective;
	$is_salary_fixed=$my_salary->is_salary_fixed;
}else{
	$salary_rate="";
	$salary_amount="";
	$no_of_hours="";
	$no_of_days_monthly="";
	$no_of_days_yearly="";
	$reason="";
	$effectivity_date="";
	$is_salary_fixed="";
}

	$daily_rate=$salary_amount;

$minimum_wage_warning="";
if($salary_rate=="3"){//daily rate

}elseif($salary_rate=="4"){//monthly rate
// ( Salary amount / No. of Days Yearly ) 
// * No. of Months yearly
	//echo $e->employee_id."| $no_of_days_yearly <br>";//1797
	$daily_rate=(($salary_amount/$no_of_days_yearly)*$no_of_days_monthly);
}else{
	// no salary setup
	$minimum_wage_warning="no salary setup";
	$minimum_wage=0;
	$im_minimum_wage=0;
}





if($im_minimum_wage==0){

}else{

			echo $e->employee_id." | $minimum_wage_warning | $im_minimum_wage<br>";
			$loc_min_wage=$this->reports_payroll_model->get_location_wage($e->employee_id,$e->location,$e->company_id);
			if(!empty($loc_min_wage)){
				$minimum_wage=$loc_min_wage->minimum_amount;
				if($minimum_wage<=0){
					$minimum_wage_warning="Please setup the minimum wage of the location";
				}else{

				}
			}else{
				$minimum_wage=0;
				$minimum_wage_warning="Please setup the minimum wage of the location";
			}


			if($daily_rate<=$minimum_wage){
				$im_minimum_wage=1;

			}else{

			}

			$daily_rate_nf=number_format($daily_rate,$payslip_decimal_place);
			$daily_rate_per_month=($daily_rate*($no_of_days_yearly/12));
			$daily_rate_per_month_how="(daily rate($daily_rate)*(no of days yearly($no_of_days_yearly)/months(12))";
			$daily_rate_per_month_nf=number_format($daily_rate_per_month,$payslip_decimal_place);

			$daily_rate_per_year=$daily_rate*$no_of_days_yearly;
			$daily_rate_per_year_how="daily rate($daily_rate)*no of days yearly($no_of_days_yearly)";
			$daily_rate_per_year_nf=number_format($daily_rate_per_year,$payslip_decimal_place);


}



 //echo $e->employee_id." | $daily_rate<=$minimum_wage then $im_minimum_wage<br>";

?>