<?php

		$posted_val=$this->reports_payroll_model->get_posted_alpha_1($e->company_id,$e->employee_id,$covered_year);
		if(!empty($posted_val)){
			$posted_id=$posted_val->id;
			$with_posted=1;
			$current_status="posted";
			$posted_val->date_employed;
			$posted_val->date_resigned;

			$prev_tax_withheld=$posted_val->prev_tax_withheld;
			$gross_compen_incom_nf=$posted_val->gross_compen_income;
			$gross_compen_incom_how=$posted_val->gross_compen_incom_how;

			$non_taxable_13thmonth=$posted_val->non_taxable_13thmonth;
			$nontaxable_13thmonth_how=$posted_val->nontaxable_13thmonth_how;

			$oa_deminimis=$posted_val->oa_deminimis;
			$oa_deminimis_how=$posted_val->oa_deminimis_how;

			$gov_contribution=$posted_val->gov_contribution;
			$gov_contribution_how=$posted_val->gov_contribution_how;

			$oa_sal_and_otherf=$posted_val->oa_sal_and_otherf;
			$oa_sal_and_otherf_how=$posted_val->oa_sal_and_otherf_how;

			$total_non_taxable=$posted_val->total_non_taxable;
			$total_non_taxable_how=$posted_val->total_non_taxable_how;

			$total_basic=$posted_val->total_basic;
			$basic_how=$posted_val->basic_how;

			$taxable_13thmonth_nf=$posted_val->taxable_13thmonth;
			$taxable_13thmonth_how=$posted_val->taxable_13thmonth_how;

			$oa_sal_and_otherf_taxable=$posted_val->oa_sal_and_otherf_taxable;
			$oa_sal_and_otherf_how_taxable=$posted_val->oa_sal_and_otherf_how_taxable;

			$total_taxable_nf=$posted_val->total_taxable;
			$total_taxable_how=$posted_val->total_taxable_how;

			$net_taxable_compen_income_nf=$posted_val->net_taxable_compen_income_nf;
			$net_taxable_compen_income_how=$posted_val->net_taxable_compen_income_how;

			$witheld_tax_nf=$posted_val->witheld_tax_nf;
			$wtax_formula_text=$posted_val->wtax_formula_text;

			$dec_amt_withheld_nf=$posted_val->dec_amt_withheld_nf;
			$dec_amt_withheld_how=$posted_val->dec_amt_withheld_how;

			$over_withheld_tax_nf=$posted_val->over_withheld_tax_nf;
			$over_withheld_tax_how=$posted_val->over_withheld_tax_how;

			$amt_of_tax_withheld_as_adj_nf=$posted_val->amt_of_tax_withheld_as_adj_nf;
			$amt_of_tax_withheld_as_adj_how=$posted_val->amt_of_tax_withheld_as_adj_how;

			$substitute_filing=$posted_val->substitute_filing;

			$taxcode_name=$posted_val->taxcode_name;
			$yearly_exemption=$posted_val->yearly_exemption;
			$jan_to_nov_wtax_nf=$posted_val->jan_to_nov_wtax_nf;
			$covered_year=$posted_val->covered_year;
			$company_id=$posted_val->company_id;
			$sched=$posted_val->sched;


			$only_holiday_pay_how=$posted_val->only_holiday_pay_how_7_5;
			$only_holiday_pay_nf=$posted_val->only_holiday_pay_nf_7_5;
			$only_overtime_pay_how=$posted_val->only_overtime_pay_how_7_5;
			$only_overtime_pay_nf=$posted_val->only_overtime_pay_nf_7_5;
			$shift_night_diff_nf=$posted_val->shift_night_diff_nf_7_5;

			$prev_gross_compen_inc=$posted_val->prev_gross_compen_inc_7_5;
			$prev_basic_smw=$posted_val->prev_basic_smw_7_5;
			$prev_holiday_pay=$posted_val->prev_holiday_pay_7_5;
			$prev_overtime_pay=$posted_val->prev_overtime_pay_7_5;
			$prev_shift_differential=$posted_val->prev_shift_differential_7_5;
			$prev_hazard_pay=$posted_val->prev_hazard_pay_7_5;

			$dailyrate_effectivity_date=$posted_val->dailyrate_effectivity_date_7_5;
			$daily_rate_nf=$posted_val->daily_rate_nf_7_5;
			$daily_rate_per_month_how=$posted_val->daily_rate_per_month_how_7_5;
			$daily_rate_per_month_nf=$posted_val->daily_rate_per_month_nf_7_5;
			$daily_rate_per_year_how=$posted_val->daily_rate_per_year_how_7_5;
			$daily_rate_per_year_nf=$posted_val->daily_rate_per_year_nf_7_5;
			$no_of_days_yearly=$posted_val->no_of_days_yearly_7_5;


				if($alphalist_type=="7_4" OR $alphalist_type=="7_5"){

					$prev_non_taxable_13thmonth=$posted_val->prev_non_taxable_13thmonth;
					$prev_nontaxable_13thmonth_how=$posted_val->prev_nontaxable_13thmonth_how;

					$prev_oa_deminimis=$posted_val->prev_oa_deminimis;
					$prev_oa_deminimis_how=$posted_val->prev_oa_deminimis_how;

					$prev_gov_contribution=$posted_val->prev_gov_contribution;
					$prev_gov_contribution_how=$posted_val->prev_gov_contribution_how;

					$prev_oa_sal_and_otherf=$posted_val->prev_oa_sal_and_otherf;
					$prev_oa_sal_and_otherf_how=$posted_val->prev_oa_sal_and_otherf_how;

					$prev_total_non_taxable=$posted_val->prev_total_non_taxable;
					$prev_total_non_taxable_how=$posted_val->prev_total_non_taxable_how;

					/*previous taxable */
					$prev_total_basic=$posted_val->prev_total_basic;
					$prev_basic_how=$posted_val->prev_basic_how;

					$prev_taxable_13thmonth=$posted_val->prev_taxable_13thmonth;
					$prev_taxable_13thmonth_how=$posted_val->prev_taxable_13thmonth_how;

					$prev_oa_sal_and_otherf_taxable=$posted_val->prev_oa_sal_and_otherf_taxable;
					$prev_oa_sal_and_otherf_how_taxable=$posted_val->prev_oa_sal_and_otherf_how_taxable;

					$prev_total_taxable=$posted_val->prev_total_taxable;
					$prev_total_taxable_how=$posted_val->prev_total_taxable_how;

					$total_taxable=$total_taxable_nf;//$posted_val->prev_total_taxable_how;
					$total_taxable_prev_pres_how=$posted_val->total_taxable_prev_pres_how;
					$total_taxable_prev_pres=$posted_val->total_taxable_prev_pres;

				}else{

				}

		}else{
			$sched=$alphalist_type;
			$with_posted=0;
			$posted_id=0;
			$prev_tax_withheld=0;
			$current_status="not yet posted";

			//pag walang posted saka lang sya magcompute.
			require(APPPATH.'views/app/reports/payroll/tax/alpha_common_computation.php');
		}


		if($alphalist_type=="7_4"){
				if($with_posted=="1"){
				}else{
						$total_taxable_prev_pres_how="$prev_total_taxable+$total_taxable";
						$total_taxable_prev_pres=$prev_total_taxable+$total_taxable;
				}
		}elseif($alphalist_type=="7_5"){
				if($with_posted=="1"){
				}else{
					$total_taxable_prev_pres_how="$prev_total_taxable+$total_taxable";
					// for 7.5 only
					$total_taxable=$taxable_13thmonth+$$oa_sal_and_otherf_taxable;
					// for 7.5 only
					$total_taxable_prev_pres=$prev_total_taxable+$total_taxable;
					$total_taxable_prev_pres_nf=number_format($total_taxable_prev_pres,$payslip_decimal_place);
				}

		}else{
		}

		

	if($generate_action=="post"){

		if($with_posted=="1"){
			$current_status="already previously posted";
			$generate_action_remark="view only";
		}else{
			$current_status="posted";
			$generate_action_remark="successfully saved";

		if($alphalist_type=="7_1"){
			$date_resigned=$e->date_resigned;
		}else{
			$date_resigned="";
		}


		if($alphalist_type=="7_1" OR $alphalist_type=="7_2" OR $alphalist_type=="7_3"){
			$prev_nontax_tertinmonth=0;
			$prev_nontax_deminimis=0;
			$prev_gov_contri=0;
			$prev_nontax_other_salaries=0;
			$prev_total_non_taxable=0;
			$prev_basic_salary=0;
			$prev_taxable_tertinmonth=0;
			$prev_taxable_other_salaries=0;
			$prev_total_taxable=0;
			$total_taxable_prev_pres=0;
			$total_taxable_prev_pres_how=0;
			$prev_tax_withheld=0;
		}else{
		}

		if($alphalist_type=="7_1" OR $alphalist_type=="7_2" OR $alphalist_type=="7_3" OR $alphalist_type=="7_4"){
			$only_holiday_pay_how=0;
			$only_holiday_pay_nf=0;
			$only_overtime_pay_how=0;
			$only_overtime_pay_nf=0;
			$shift_night_diff_nf=0;

			$prev_gross_compen_inc=0;
			$prev_basic_smw=0;
			$prev_holiday_pay=0;
			$prev_overtime_pay=0;
			$prev_shift_differential=0;
			$prev_hazard_pay=0;

			$dailyrate_effectivity_date=0;
			$daily_rate_nf=0;
			$daily_rate_per_month_how=0;

			$daily_rate_per_month_nf=0;
			$daily_rate_per_year_how=0;

			$daily_rate_per_year_nf=0;
			$no_of_days_yearly=0;
		}else{
			$dailyrate_effectivity_date=$effectivity_date;
		}





			$save_alpha = array(
				'employee_id'			=>		$e->employee_id,
				'date_employed'			=>		$e->date_employed,
				'date_resigned'			=>		$date_resigned,
				'gross_compen_income'	=>		$gross_compen_incom_nf,
				'gross_compen_incom_how'	=>		$gross_compen_incom_how,
				'non_taxable_13thmonth'	=>		$non_taxable_13thmonth,
				'nontaxable_13thmonth_how'	=>		$nontaxable_13thmonth_how,
				'oa_deminimis'	=>		$$oa_deminimis,
				'oa_deminimis_how'	=>		$$oa_deminimis_how,
				'gov_contribution'	=>		$gov_contribution,
				'gov_contribution_how'	=>		$gov_contribution_how,
				'oa_sal_and_otherf'	=>		$$oa_sal_and_otherf,
				'oa_sal_and_otherf_how'	=>		$$oa_sal_and_otherf_how,
				'total_non_taxable'	=>		$total_non_taxable,
				'total_non_taxable_how'	=>		$total_non_taxable_how,
				'total_basic'	=>		$total_basic,
				'basic_how'	=>		$basic_how,
				'taxable_13thmonth'	=>		$taxable_13thmonth,
				'taxable_13thmonth_how'	=>		$taxable_13thmonth_how,
				'oa_sal_and_otherf_taxable'	=>		$$oa_sal_and_otherf_taxable,
				'oa_sal_and_otherf_how_taxable'	=>		$$oa_sal_and_otherf_how_taxable,
				'total_taxable'	=>		$total_taxable_nf,
				'total_taxable_how'	=>		$total_taxable_how,
				'taxcode_name'	=>		$e->taxcode_name,
				'yearly_exemption'	=>		$yearly_exemption,
				'jan_to_nov_wtax_nf'	=>		$jan_to_nov_wtax_nf,
				'covered_year'	=>		$covered_year,
				'company_id'	=>		$company_id,
				'net_taxable_compen_income_nf'	=>		$net_taxable_compen_income_nf,	
				'net_taxable_compen_income_how'	=>		$net_taxable_compen_income_how,	
				'witheld_tax_nf'	=>		$witheld_tax_nf,	
				'wtax_formula_text'	=>		$wtax_formula_text,	
				'dec_amt_withheld_nf'	=>		$dec_amt_withheld_nf,	
				'dec_amt_withheld_how'	=>		$dec_amt_withheld_how,	
				'over_withheld_tax_nf'	=>		$over_withheld_tax_nf,	
				'over_withheld_tax_how'	=>		$over_withheld_tax_how,	
				'amt_of_tax_withheld_as_adj_nf'	=>		$amt_of_tax_withheld_as_adj_nf,	
				'amt_of_tax_withheld_as_adj_how'	=>		$amt_of_tax_withheld_as_adj_how,	
				'substitute_filing'	=>		'no',
				'sched'					=>		$sched,
				'prev_non_taxable_13thmonth'	=>		$prev_nontax_tertinmonth,
				'prev_nontaxable_13thmonth_how'	=>		$prev_nontax_tertinmonth,
				'prev_oa_deminimis'	=>		$prev_nontax_deminimis,
				'prev_oa_deminimis_how'	=>		$prev_nontax_deminimis,
				'prev_gov_contribution'	=>		$prev_gov_contri,
				'prev_gov_contribution_how'	=>		$prev_gov_contri,
				'prev_oa_sal_and_otherf'	=>		$prev_nontax_other_salaries,
				'prev_oa_sal_and_otherf_how'	=>		$prev_nontax_other_salaries,
				'prev_total_non_taxable'	=>		$prev_total_non_taxable,
				'prev_total_non_taxable_how'	=>		$prev_total_non_taxable,
				'prev_total_basic'	=>		$prev_basic_salary,
				'prev_basic_how'	=>		$prev_basic_salary,
				'prev_taxable_13thmonth'	=>		$prev_taxable_tertinmonth,
				'prev_taxable_13thmonth_how'	=>		$prev_taxable_tertinmonth,
				'prev_oa_sal_and_otherf_taxable'	=>		$prev_taxable_other_salaries,
				'prev_oa_sal_and_otherf_how_taxable'	=>		$prev_taxable_other_salaries,
				'prev_total_taxable'	=>		$prev_total_taxable,
				'prev_total_taxable_how'	=>		$prev_total_taxable,
				'total_taxable_prev_pres'	=>		$total_taxable_prev_pres,
				'total_taxable_prev_pres_how'	=>		$total_taxable_prev_pres_how,
				'prev_tax_withheld'	=>		$prev_tax_withheld,
			'only_holiday_pay_how_7_5'				=>	$only_holiday_pay_how,
			'only_holiday_pay_nf_7_5'				=>	$only_holiday_pay_nf,
			'only_overtime_pay_how_7_5'				=>	$only_overtime_pay_how,
			'only_overtime_pay_nf_7_5'				=>	$only_overtime_pay_nf,
			'shift_night_diff_nf_7_5'				=>	$shift_night_diff_nf,

			'prev_gross_compen_inc_7_5'				=>		$prev_gross_compen_inc,			
			'prev_basic_smw_7_5'					=>		$prev_basic_smw,			
			'prev_holiday_pay_7_5'					=>		$prev_holiday_pay,			
			'prev_overtime_pay_7_5'					=>		$prev_overtime_pay,			
			'prev_shift_differential_7_5'			=>		$prev_shift_differential,			
			'prev_hazard_pay_7_5'					=>		$prev_hazard_pay,			
			'dailyrate_effectivity_date_7_5'		=>		$dailyrate_effectivity_date,					
			'daily_rate_nf_7_5'						=>		$daily_rate_nf,					
			'daily_rate_per_month_how_7_5'			=>		$daily_rate_per_month_how,					
			'daily_rate_per_month_nf_7_5'			=>		$daily_rate_per_month_nf,					
			'daily_rate_per_year_how_7_5'			=>		$daily_rate_per_year_how,					
			'daily_rate_per_year_nf_7_5'			=>		$daily_rate_per_year_nf,					
			'no_of_days_yearly_7_5'					=>		$no_of_days_yearly

			);

			$this->db->query("delete from alphalist_posted where company_id='".$company_id."' AND  covered_year='".$covered_year."' AND employee_id='".$e->employee_id."' ");
			$this->reports_payroll_model->save_alphalist_1($save_alpha);
		}



	}elseif($generate_action=="view"){
		$generate_action_remark="view only";
	}elseif($generate_action=="reset"){
		$current_status="now reset";
		$this->db->query("delete from alphalist_posted where company_id='".$company_id."' AND  covered_year='".$covered_year."' AND employee_id='".$e->employee_id."' ");
		$generate_action_remark="successfully reset";
	}else{
		$generate_action_remark="unknown";
	}


?>