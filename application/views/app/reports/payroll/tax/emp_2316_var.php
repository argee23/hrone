<?php

            $first_name=$e->first_name;
            $last_name=$e->last_name;
            $middle_name=$e->middle_name;
            $civil_status=$e->civil_status;
            $tin=$e->tin;
            $employee_id=$e->employee_id;
            $date_employed=$e->date_employed;
            $date_resigned=$e->date_resigned;

            $gross_compen_income=$e->gross_compen_income;
            $gross_compen_incom_how=$e->gross_compen_incom_how;

            //===NON TAXABLE COMPENSATION INCOME
            $non_taxable_13thmonth=$e->non_taxable_13thmonth;
            $nontaxable_13thmonth_how=$e->nontaxable_13thmonth_how;
            $oa_deminimis=$e->oa_deminimis;
            $oa_deminimis_how=$e->oa_deminimis_how;
            $gov_contribution=$e->gov_contribution;
            $gov_contribution_how=$e->gov_contribution_how;
            $oa_sal_and_otherf=$e->oa_sal_and_otherf;
            $oa_sal_and_otherf_how=$e->oa_sal_and_otherf_how;
            $total_non_taxable= $e->total_non_taxable;
            $total_non_taxable_how=$e->total_non_taxable_how;

            //===TAXABLE COMPENSATION INCOME
            $total_basic=$e->total_basic;
            $basic_how=$e->basic_how;
            $taxable_13thmonth=$e->taxable_13thmonth;
            $taxable_13thmonth_how=$e->taxable_13thmonth_how;
            $oa_sal_and_otherf_taxable=$e->oa_sal_and_otherf_taxable;
            $oa_sal_and_otherf_how_taxable=$e->oa_sal_and_otherf_how_taxable;
            $total_taxable=$e->total_taxable;
            $total_taxable_how=$e->total_taxable_how;

            $taxcode_name=$e->taxcode_name;
            $yearly_exemption=$e->yearly_exemption;
            $covered_year=$e->covered_year;
            $company_id=$e->company_id;
            $company_name=$e->company_name;
            $company_address=$e->company_address;
            $company_tin_no=$e->company_tin_no;

            $jan_to_nov_wtax_nf=$e->jan_to_nov_wtax_nf;
            $net_taxable_compen_income_nf=$e->net_taxable_compen_income_nf;
            $net_taxable_compen_income_how=$e->net_taxable_compen_income_how;

            $witheld_tax_nf=$e->witheld_tax_nf;
            $wtax_formula_text=$e->wtax_formula_text;

            $dec_amt_withheld_nf=$e->dec_amt_withheld_nf;
            $dec_amt_withheld_how=$e->dec_amt_withheld_how;

            $jan_to_nov_wtax_nf = str_replace(",", "", $jan_to_nov_wtax_nf);
            $dec_amt_withheld_nf = str_replace(",", "", $dec_amt_withheld_nf);

            $present_employer_wtax=$jan_to_nov_wtax_nf+$dec_amt_withheld_nf;
            $present_employer_wtax_nf=number_format($present_employer_wtax,2);
            $present_employer_wtax_how="Jan to Nov Wtax ($jan_to_nov_wtax_nf)+Dec Wtax($dec_amt_withheld_nf)";

            $over_withheld_tax_nf=$e->over_withheld_tax_nf;
            $over_withheld_tax_how=$e->over_withheld_tax_how;

            $amt_of_tax_withheld_as_adj_nf=$e->amt_of_tax_withheld_as_adj_nf;
            $amt_of_tax_withheld_as_adj_how=$e->amt_of_tax_withheld_as_adj_how;

            $substitute_filing=$e->substitute_filing;

            $sched=$e->sched;


            $prev_non_taxable_13thmonth=$e->prev_non_taxable_13thmonth;
            $prev_nontaxable_13thmonth_how=$e->prev_nontaxable_13thmonth_how;
            $prev_oa_deminimis=$e->prev_oa_deminimis;
            $prev_oa_deminimis_how=$e->prev_oa_deminimis_how;
            $prev_gov_contribution=$e->prev_gov_contribution;
            $prev_gov_contribution_how=$e->prev_gov_contribution_how;
            $prev_oa_sal_and_otherf=$e->prev_oa_sal_and_otherf;
            $prev_oa_sal_and_otherf_how=$e->prev_oa_sal_and_otherf_how;

            $prev_total_non_taxable=$e->prev_total_non_taxable;
            $prev_total_non_taxable_how=$e->prev_total_non_taxable_how;

            //===PREVIOUS EMPLOYER TAXABLE COMPENSATION INCOME
            $prev_total_basic=$e->prev_total_basic;
            $prev_basic_how=$e->prev_basic_how;
            $prev_taxable_13thmonth=$e->prev_taxable_13thmonth;
            $prev_taxable_13thmonth_how=$e->prev_taxable_13thmonth_how;
            $prev_oa_sal_and_otherf_taxable=$e->prev_oa_sal_and_otherf_taxable;
            $prev_oa_sal_and_otherf_how_taxable=$e->prev_oa_sal_and_otherf_how_taxable;

            $prev_total_taxable=$e->prev_total_taxable;
            $prev_total_taxable_how=$e->prev_total_taxable_how;
            
            $prev_tax_withheld=$e->prev_tax_withheld;

            $total_taxable_prev_pres=$e->total_taxable_prev_pres;
            $total_taxable_prev_pres_how=$e->total_taxable_prev_pres_how;

            $only_holiday_pay_how_7_5=$e->only_holiday_pay_how_7_5;
            $only_holiday_pay_nf_7_5=$e->only_holiday_pay_nf_7_5;
            $only_overtime_pay_how_7_5=$e->only_overtime_pay_how_7_5;
            $only_overtime_pay_nf_7_5=$e->only_overtime_pay_nf_7_5;
            $shift_night_diff_nf_7_5=$e->shift_night_diff_nf_7_5;

            $prev_gross_compen_inc_7_5=$e->prev_gross_compen_inc_7_5;
            $prev_basic_smw_7_5=$e->prev_basic_smw_7_5;
            $prev_holiday_pay_7_5=$e->prev_holiday_pay_7_5;
            $prev_overtime_pay_7_5=$e->prev_overtime_pay_7_5;
            $prev_shift_differential_7_5=$e->prev_shift_differential_7_5;
            $prev_hazard_pay_7_5=$e->prev_hazard_pay_7_5;

            $dailyrate_effectivity_date_7_5=$e->dailyrate_effectivity_date_7_5;
            $daily_rate_nf_7_5=$e->daily_rate_nf_7_5;
            $daily_rate_per_month_how_7_5=$e->daily_rate_per_month_how_7_5;
            $daily_rate_per_month_nf_7_5=$e->daily_rate_per_month_nf_7_5;
            $daily_rate_per_year_how_7_5=$e->daily_rate_per_year_how_7_5;
            $daily_rate_per_year_nf_7_5=$e->daily_rate_per_year_nf_7_5;
            $no_of_days_yearly_7_5=$e->no_of_days_yearly_7_5;
?>