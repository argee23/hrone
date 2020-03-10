<?php
	

		/*=============================CHECK JAN TO NOV TAX WITHHELD=============================*/
		//jn:means jan to nov of regular payroll payslip
		$jn=$this->reports_payroll_model->compute_jan_to_nov_tax($e->employee_id,$covered_year);
		if(!empty($jn)){
			$jan_to_nov_wtax=$jn->jan_to_nov_wtax;
		}else{
			$jan_to_nov_wtax=0;
		}
		// jan to nov tax of separate bonus payslip
		$jn_bonus=$this->reports_payroll_model->only_tax_bonus_payslip_jan_to_nov($e->employee_id,$covered_year);
		if(!empty($jn_bonus)){
			$jan_to_nov_wtax+=$jn_bonus->jan_to_nov_bonus_tax;
		}else{			
		}
		// jan to nov tax of separate 13th month payslip
		$jn_tertin=$this->reports_payroll_model->only_tax_13thmonth_payslip_jan_to_nov($e->employee_id,$covered_year);
		if(!empty($jn_tertin)){
			$jan_to_nov_wtax+=$jn_tertin->jan_to_nov_tertin_month_tax;
		}else{			
		}

		$jan_to_nov_wtax_nf=number_format($jan_to_nov_wtax,$payslip_decimal_place);
		/*=============================CHECK PAYROLL>FILE MAINTENANCE>YEARLY ANNUAL TAX RATES=============================*/
		$ex=$this->reports_payroll_model->check_annual_tax_exemption($e->taxcode_id,$e->company_id,$covered_year);
		if(!empty($ex)){
			$yearly_exemption=$ex->total;
		}else{
			$yearly_exemption=0;
		}

		/*=============================CHECK DECEMBER WITHHELD=============================*/
		$dt=$this->reports_payroll_model->compute_dec_tax($e->employee_id,$covered_year);
		if(!empty($dt)){
			$dec_amt_withheld=$dt->dec_wtax;
			$regpayslip_dec_tax=$dt->dec_wtax;
		}else{
			$dec_amt_withheld=0;
			$regpayslip_dec_tax=0;
		}		
		// dec tax of separate bonus payslip
		$dt_bonus=$this->reports_payroll_model->get_payslip_bonus_dec($e->employee_id,$covered_year);
		if(!empty($dt_bonus)){
			$dec_amt_withheld+=$dt_bonus->dec_bonus_tax;
			$bonuspayslip_dec_tax=$dt_bonus->dec_bonus_tax;
		}else{	
			$bonuspayslip_dec_tax=0;		
		}

		// dec tax of separate 13th month payslip
		$dt_tertin=$this->reports_payroll_model->get_payslip_13thmonth_dec($e->employee_id,$covered_year);
		if(!empty($dt_tertin)){
			$dec_amt_withheld+=$dt_tertin->dec_tertin_month_tax;
			$tertin_month_payslip_dec_tax=$dt_tertin->dec_tertin_month_tax;
		}else{		
			$tertin_month_payslip_dec_tax=0;	
		}

		$dec_amt_withheld_how="Regular Payslip Wtax($regpayslip_dec_tax)+Bonus Payslip Wtax($bonuspayslip_dec_tax)+13th Month Payslip Wtax($tertin_month_payslip_dec_tax)";

		/*=============================CHECK REGULAR PAYROLL PAYSLIP DETAILS=============================*/
		$v=$this->reports_payroll_model->compute_regpayslip_alpha($e->employee_id,$year_regpayslip_payroll_period);
		/*=============================CHECK REGULAR PAYROLL OTHER ADDITION TAGGING=============================*/
		$oav=$this->reports_payroll_model->compute_oa_alpha($e->employee_id,$covered_year);
		/*=============================CHECK PAYROLL>GENERATE 13TH MONTH PAY=============================*/
		$t=$this->reports_payroll_model->compute_tertinmonth_alpha($e->employee_id,$year_tertinpayslip_payroll_period);
		if(!empty($t)){
			$sep_payslip_tertin_month=$t->final_tertin_month;			
		}else{
			$sep_payslip_tertin_month=0;
		}/*=============================CHECK PAYROLL>GENERATE BONUS=============================*/
		$bon=$this->reports_payroll_model->compute_bonus_alpha($e->employee_id,$year_tertinpayslip_payroll_period);
		if(!empty($bon)){
			$sep_payslip_bonus=$bon->final_bonus;
			$sep_payslip_gross_bonus=$bon->gross_bonus;
			$sep_payslip_bonus_tax=$bon->bonus_tax;			
		}else{
			$sep_payslip_bonus=0;
			$sep_payslip_gross_bonus=0;
			$sep_payslip_bonus_tax=0;
		}

		$oa_13th="oa_13_".$e->employee_id;
		$oa_13th_how="oa_13_how_".$e->employee_id;
		$oa_deminimis="oa_deminimis_".$e->employee_id;
		$oa_deminimis_how="oa_deminimis_how_".$e->employee_id;
		$oa_sal_and_otherf="oa_sal_and_otherf_".$e->employee_id;
		$oa_sal_and_otherf_how="oa_sal_and_otherf_how_".$e->employee_id;		
		$oa_sal_and_otherf_taxable="oa_sal_and_otherf_taxable_".$e->employee_id;
		$oa_sal_and_otherf_how_taxable="oa_sal_and_otherf_how_taxable_".$e->employee_id;		
		$oa_basic="oa_basic_".$e->employee_id;
		$oa_basic_how="oa_basic_how_".$e->employee_id;		
		$oa_premium_health="oa_premium_health_".$e->employee_id;
		$oa_premium_health_how="oa_premium_health_how_".$e->employee_id;
		$oa_union_dues="oa_union_dues_".$e->employee_id;
		$oa_union_dues_how="oa_union_dues_how_".$e->employee_id;
		
		$$oa_13th=0;
		$$oa_13th_how="";
		$$oa_deminimis=0;
		$$oa_deminimis_how="";
		$$oa_sal_and_otherf=0;
		$$oa_sal_and_otherf_how="";
		$$oa_basic=0;
		$$oa_basic_how="";
		$$oa_sal_and_otherf_taxable=0;
		$$oa_sal_and_otherf_how_taxable="";
		$$oa_premium_health=0;
		$$oa_premium_health_how="";
		$$oa_union_dues=0;
		$$oa_union_dues_how="";

		if(!empty($oav)){
			foreach($oav as $oa){
				$p_from=$oa->complete_from;
				$p_to=$oa->complete_to;
				$oa_amount=$oa->oa_amount;
				$other_addition_type=$oa->other_addition_type;
				$is_oa_taxable=$oa->taxable;
				$is_oa_deminimis=$oa->non_tax;
				$is_oa_bonus=$oa->bonus;
				$is_oa_th_month_pay=$oa->th_month_pay;
				$is_oa_basic=$oa->basic;
				$is_oa_ot=$oa->ot;
				$is_oa_leave_adj=$oa->other_addition_leave;
				$is_oa_exclude_alpha=$oa->exclude;
				$is_oa_union_dues=$oa->union_dues;

				if($is_oa_exclude_alpha=="1"){// exclude to alphalist
				}else{
								if($is_oa_union_dues=="1"){
									$$oa_union_dues+=$oa_amount;
									$$oa_union_dues_how.="$other_addition_type($oa_amount)&#10;";
								}elseif($is_oa_basic=="1"){
									$$oa_basic+=$oa_amount;
									$$oa_basic_how.="$other_addition_type($oa_amount)&#10;";
								}elseif($is_oa_th_month_pay=="1"){
									$$oa_13th+=$oa_amount;
									$$oa_13th_how.="$other_addition_type($oa_amount)&#10;";
								}elseif($is_oa_bonus=="1"){
									$$oa_13th+=$oa_amount;
									$$oa_13th_how.="$other_addition_type($oa_amount)&#10;";
								}elseif($is_oa_deminimis=="1"){
									$$oa_deminimis+=$oa_amount;
									$$oa_deminimis_how.="$p_from to $p_to | $other_addition_type($oa_amount)&#10;";					
								}elseif(($is_oa_taxable=="0")AND($is_oa_deminimis=="0")AND($is_oa_bonus=="0")AND($is_oa_th_month_pay=="0")AND($is_oa_basic=="0")AND($is_oa_ot=="0")AND($is_oa_leave_adj=="0")){//other salaries and forms of compensation nontax
									$$oa_sal_and_otherf+=$oa_amount;
									$$oa_sal_and_otherf_how.="$p_from to $p_to | $other_addition_type($oa_amount)&#10;";					

								}elseif(($is_oa_taxable=="1")AND($is_oa_deminimis=="0")AND($is_oa_bonus=="0")AND($is_oa_th_month_pay=="0")AND($is_oa_basic=="0")AND($is_oa_ot=="0")AND($is_oa_leave_adj=="0")){//other salaries and forms of compensation nontax
									$$oa_sal_and_otherf_taxable+=$oa_amount;
									$$oa_sal_and_otherf_how_taxable.="$p_from to $p_to | $other_addition_type($oa_amount)&#10;";					
								}else{

								}
				}// END OF DO NOT EXCLUDE TO ALPHALIST
			}//END OF FOREACH OTHER ADDITION TAGGING

		}else{// IF WALANG OTHER ADDITIONS
		}	

		/*=============================NUMBER FORMAT OTHER ADDITION=============================*/	

		$$oa_deminimis=number_format($$oa_deminimis,2);
		$$oa_sal_and_otherf=number_format($$oa_sal_and_otherf,2);
		$$oa_sal_and_otherf_taxable=number_format($$oa_sal_and_otherf_taxable,2);


		/*=============================START CHECK 13TH MONTH & BONUS=============================*/	
		if(!empty($taxable_tertin_ceiling)){
			$tertin_month_ceiling=$taxable_tertin_ceiling->single_field;
		}else{
			$tertin_month_ceiling=90000;
		}

		$final_tertin_month=$$oa_13th+$sep_payslip_tertin_month+$sep_payslip_bonus;

		if($final_tertin_month>$tertin_month_ceiling){
			$taxable_13thmonth=$final_tertin_month-$tertin_month_ceiling;
			$taxable_13thmonth_how="((Other Additions Tagged as 13th Month/Bonus(".$$oa_13th.")+Separate 13th Month Payslip($sep_payslip_tertin_month)+Separate Bonus Payslip($sep_payslip_bonus))-(Taxable 13th Month Ceiling($tertin_month_ceiling)";
			$non_taxable_13thmonth=$tertin_month_ceiling;
			$nontaxable_13thmonth_how="Non-Taxable Ceiling($tertin_month_ceiling) => Total 13th Month was ($final_tertin_month)";
		}else{
			$taxable_13thmonth=0;
			$taxable_13thmonth_how="";
			$non_taxable_13thmonth=$final_tertin_month;
			$nontaxable_13thmonth_how="Separate 13th Month Payslip($sep_payslip_tertin_month)+Other Additions Tagged as 13th Month/Bonus(".$$oa_13th.")";
		}
		
		$taxable_13thmonth=round($taxable_13thmonth,$payslip_decimal_place);
		$taxable_13thmonth_nf=number_format($taxable_13thmonth,2);
		$non_taxable_13thmonth=round($non_taxable_13thmonth,$payslip_decimal_place);

		/*=============================END CHECK 13TH MONTH & BONUS=============================*/	

		if(!empty($v)){
			$basic=$v->basic;
			$leave_basic=$v->leave_basic;
			$overtime=$v->overtime;

			$shift_night_diff=$v->shift_night_diff;
			$regotnd_value=$v->regotnd_value;
			$regot_value=$v->regot_value;
						
			// special non working holiday & restday ot
			$snw_rd_ot_ot_withnd_value=$v->snw_rd_ot_ot_withnd_value;
			$snw_rd_ot_ot_with_out_nd_value=$v->snw_rd_ot_ot_with_out_nd_value;
			$snw_rd_ot_with_out_nd_value=$v->snw_rd_ot_with_out_nd_value;
			$snw_rd_ot_withnd_value=$v->snw_rd_ot_withnd_value;

			// special non working holiday ot
			$snwot_ot_withnd_value=$v->snwot_ot_withnd_value;
			$snwot_ot_with_out_nd_value=$v->snwot_ot_with_out_nd_value;
			$snwot_withnd_value=$v->snwot_withnd_value;
			$snwot_with_out_nd_value=$v->snwot_with_out_nd_value;

			// regular holiday & restday na pumasok si employee ot
			$rh_rdt1_ot_ot_withnd_value=$v->rh_rdt1_ot_ot_withnd_value;
			$rh_rdt1_ot_ot_with_out_nd_value=$v->rh_rdt1_ot_ot_with_out_nd_value;
			$rh_rdt1_ot_withnd_value=$v->rh_rdt1_ot_withnd_value;
			$rh_rdt1_ot_with_out_nd_value=$v->rh_rdt1_ot_with_out_nd_value;

			// regular holiday & restday na hindi pumasok si employee
			$rh_rdt2_value=$v->rh_rdt2_value;

			// regular holiday
			$rhot_ot_withnd_value=$v->rhot_ot_withnd_value;
			$rhot_ot_with_out_nd_value=$v->rhot_ot_with_out_nd_value;
			$rhot_withnd_value=$v->rhot_withnd_value;
			$rhot_with_out_nd_value=$v->rhot_with_out_nd_value;

			// restday ot
			$rdot_ot_withnd_value=$v->rdot_ot_withnd_value;
			$rdot_ot_with_out_nd_value=$v->rdot_ot_with_out_nd_value;
			$rdot_withnd_value=$v->rdot_withnd_value;
			$rdot_with_out_nd_value=$v->rdot_with_out_nd_value;


			$cola=$v->cola;
			$other_addition_taxable=$v->other_addition_taxable;
			$other_addition_non_tax=$v->other_addition_non_tax;

			$other_deduction_taxable=$v->other_deduction_taxable;
			$other_deduction_nontax=$v->other_deduction_nontax;

			$gross=$v->gross;
			$loan=$v->loan;

			$sss_employee=$v->sss_employee;
			$sss_employer=$v->sss_employer;
			$sss_ec_er=$v->sss_ec_er;
			$sss_gross=$v->sss_gross;

			$philhealth_employee=$v->philhealth_employee;
			$philhealth_employer=$v->philhealth_employer;
			$philhealth_gross=$v->philhealth_gross;

			$pagibig=$v->pagibig;
			$pagibig_employer=$v->pagibig_employer;

			$absent=$v->absent;
			$late=$v->late;
			$undertime=$v->undertime;
			$overbreak=$v->overbreak;

			$taxable=$v->taxable;
			$wtax=$v->wtax;

			$income_total=$v->income_total;
			$deduction_total=$v->deduction_total;

			$net_pay=$v->net_pay;


			// for 7.5 only.
			$only_holiday_pay=$snw_rd_ot_ot_withnd_value+$snw_rd_ot_ot_with_out_nd_value+$snw_rd_ot_with_out_nd_value+$snw_rd_ot_withnd_value+
$snwot_ot_withnd_value+$snwot_ot_with_out_nd_value+$snwot_withnd_value+$snwot_with_out_nd_value+
$rh_rdt1_ot_ot_withnd_value+$rh_rdt1_ot_ot_with_out_nd_value+$rh_rdt1_ot_withnd_value+$rh_rdt1_ot_with_out_nd_value+
$rh_rdt2_value+$rhot_ot_withnd_value+$rhot_ot_with_out_nd_value+$rhot_withnd_value+$rhot_with_out_nd_value;

$only_holiday_pay_how="special non working holiday & restday ot ($snw_rd_ot_ot_withnd_value+$snw_rd_ot_ot_with_out_nd_value+$snw_rd_ot_with_out_nd_value+$snw_rd_ot_withnd_value) +special non working holiday ot(
$snwot_ot_withnd_value+$snwot_ot_with_out_nd_value+$snwot_withnd_value+$snwot_with_out_nd_value)+regular holiday & restday na pumasok si employee ot(
$rh_rdt1_ot_ot_withnd_value+$rh_rdt1_ot_ot_with_out_nd_value+$rh_rdt1_ot_withnd_value+$rh_rdt1_ot_with_out_nd_value)+regular holiday & restday na hindi pumasok si employee(
$rh_rdt2_value)+regular holiday($rhot_ot_withnd_value+$rhot_ot_with_out_nd_value+$rhot_withnd_value+$rhot_with_out_nd_value)";

			$only_overtime_pay=$rdot_ot_withnd_value+$rdot_ot_with_out_nd_value+$rdot_withnd_value+$rdot_with_out_nd_value+$regotnd_value+$regot_value;

			$only_overtime_pay_how="restday ot($rdot_ot_withnd_value+$rdot_ot_with_out_nd_value+$rdot_withnd_value+$rdot_with_out_nd_value)+regular day ot($regotnd_value+$regot_value)";
			// $only_holiday_pay=0;
			// $only_overtime_pay=0;;
		}else{
			$basic=0;
			$only_holiday_pay=0;
			$only_overtime_pay=0;
			$overtime=0;
		}
		
		$basic=round($basic-($absent+$late+$undertime+$overbreak),$payslip_decimal_place);
		$total_basic=$basic+$$oa_basic;
		//$total_basic=($basic-($absent+$late+$undertime+$overbreak))+$$oa_basic;
		$total_basic=round($total_basic,$payslip_decimal_place);
		$total_basic=number_format($total_basic,2);
		$basic_how="(Payslip Basic($basic)-(Absent($absent)+Late($late)+Undertime($undertime)+Overbreak($overbreak)))+Other Additions Tagged as Basic Adjustment(".$$oa_basic.")&#10;Details: &#10;".$$oa_basic_how."";

		$gov_contribution=$sss_employee+$philhealth_employee+$pagibig+$$oa_union_dues;
		$gov_contribution=round($gov_contribution,2);
		$gov_contribution_how="SSS($sss_employee)+Philhealth($philhealth_employee)+Pagibig($pagibig)+Union Dues(".$$oa_union_dues.")";


		$total_non_taxable=$non_taxable_13thmonth+$$oa_deminimis+$gov_contribution+$$oa_sal_and_otherf;
		$total_non_taxable=round($total_non_taxable,2);
		$total_non_taxable=number_format($total_non_taxable,$payslip_decimal_place);
		$total_non_taxable_how="13th Month Pay & Other Benefits($non_taxable_13thmonth)+De Minimis Benefits(".$$oa_deminimis.")+SSS,GSIS,PHIC, & Pag - ibig Contributions, and Union Dues($gov_contribution)+Salaries & Other Forms of Compensation(".$$oa_sal_and_otherf.")";

		$total_taxable=$basic+$taxable_13thmonth+$$oa_sal_and_otherf_taxable;
		$total_taxable_nf=number_format($total_taxable,$payslip_decimal_place);
		$total_taxable_how="Basic Salary($basic)+13th Month Pay & Other Benefits($taxable_13thmonth)+Salaries & Other Forms of Compensation(".$$oa_sal_and_otherf_taxable.")";


		$shift_night_diff_nf=number_format($shift_night_diff,$payslip_decimal_place);
		$only_holiday_pay_nf=number_format($only_holiday_pay,$payslip_decimal_place);
		$only_overtime_pay_nf=number_format($only_overtime_pay,$payslip_decimal_place);

		$basic_nf=number_format($basic,$payslip_decimal_place);
		$overtime_nf=number_format($overtime,$payslip_decimal_place);
		$other_addition_taxable_nf=number_format($other_addition_taxable,$payslip_decimal_place);
		$other_addition_non_tax_nf=number_format($other_addition_non_tax,$payslip_decimal_place);
		$cola_nf=number_format($cola,$payslip_decimal_place);

		$gross_compen_incom=$basic+$overtime+$shift_night_diff+$other_addition_taxable+$other_addition_non_tax+$cola+$sep_payslip_tertin_month+$sep_payslip_bonus+$gov_contribution;
		$gross_compen_incom_nf=number_format($gross_compen_incom,$payslip_decimal_place);

		$net_taxable_compen_income=$gross_compen_incom-$total_non_taxable;
		$net_taxable_compen_income_how="Gross Compensation Income($gross_compen_incom_nf)-Non-Taxable Compensation Income($total_non_taxable)";
		$net_taxable_compen_income_nf=number_format($net_taxable_compen_income,$payslip_decimal_place);


		require(APPPATH.'views/app/reports/payroll/tax/alpha_compute_tax_due.php');

		$gross_compen_incom_how="Basic($basic_nf)+Overtime($overtime_nf)+shift_night_diff($shift_night_diff)+Other Addition Taxable($other_addition_taxable_nf)+Other Addition Non-Tax($other_addition_non_tax_nf)+COLA($cola)+Separate Payslip 13th Month ($sep_payslip_tertin_month)+Separate Bonus($sep_payslip_bonus)+Gov Contribution($gov_contribution)";

		//$dec_amt_withheld=$witheld_tax-$jan_to_nov_wtax;
		$dec_amt_withheld_nf=number_format($dec_amt_withheld,$payslip_decimal_place);
		

		$over_withheld_tax=$jan_to_nov_wtax-$witheld_tax;
		$over_withheld_tax_nf=number_format($over_withheld_tax,$payslip_decimal_place);
		$over_withheld_tax_how="(10b)=(9) - (8)";

		$amt_of_tax_withheld_as_adj=$jan_to_nov_wtax+$prev_tax_withheld+$dec_amt_withheld;
		$amt_of_tax_withheld_as_adj_nf=number_format($amt_of_tax_withheld_as_adj,$payslip_decimal_place);
		$amt_of_tax_withheld_as_adj_how="(11)=(9+10a) or (9-10b)";

		//$tax_due=(($total_taxable-$tax_code_rate)*$tax_percentage)+$tax_exemption;

		//Witheld Tax = ( ( TOTAL TAXABLE AMT - Tax CODE Rate ) * Tax percentage ) + Tax exemption


		$non_taxable_13thmonth=number_format($non_taxable_13thmonth,2);
		$gov_contribution=number_format($gov_contribution,2);

?>