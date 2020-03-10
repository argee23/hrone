<?php
$company_manual_od_list=$this->payroll_generate_payslip_model->get_company_od($company_id,$employee_id,$pay_period);
if(!empty($company_manual_od_list)){
	$ode_total_amount_taxable=0;
	$ode_total_amount_nontaxable=0;
	$ode_taxable_list="";
	$ode_nontaxable_list="";
	$ode_taxable_list_clean="";
	$ode_nontaxable_list_clean="";
	foreach ($company_manual_od_list as $od){
		$od_type=$od->od_other_deduction_type;
		$od_rate=$od->od_rate;
		$od_amount=$od->od_amount;
		$is_od_taxable=$od->od_taxable;
		$is_od_nontax=$od->od_non_tax;
		$is_od_bonus=$od->od_bonus;
		$is_od_tertin_mnt=$od->od_th_month_pay;
		$is_od_basic=$od->od_basic;
		$is_od_ot=$od->od_ot;
		$is_od_leave=$od->od_other_deduction_leave;
		$is_od_alphalist_excluded=$od->od_exclude;
		$od_category=$od->od_category;
		$od_added=$od->od_date;

		$ode_amount=$od->amount;
		$ode_entry_type=$od->entry_type;

		if($is_od_taxable=="1"){ // TAXABLE
			$is_taxable="1";
			$ode_amount;
			$ode_total_amount_taxable+=$ode_amount;
			$ode_taxable_list.="<a title='".$ode_entry_type."'>".$od_type." : ".$ode_amount."</a><br>";
			$ode_taxable_list_clean.=" $od_type : $ode_amount <br>";

		}else{// NON-TAXABLE
			$is_taxable="0";
			$ode_amount;
			$ode_total_amount_nontaxable+=$ode_amount;
			$ode_nontaxable_list.="<a title='".$ode_entry_type."'>".$od_type." : ".$ode_amount."</a><br>";
			$ode_nontaxable_list_clean.=" $od_type : $ode_amount <br>";
		}

			if($selected_payroll_option=="post_all"){
					$save_each_od = array(
						'od_id' => $od->other_deduction_id,
						'company_id' => $od->company_id,
						'employee_id' => $od->employee_id,
						'payroll_period_id' => $pay_period,
						'oa_amount' => $ode_amount,
						'is_taxable' => $is_taxable,
						'date_process' => date('Y-m-d H:i:s'),

					);

					$this->payroll_generate_payslip_model->post_other_deduction($save_each_od,$month_cover);

			}else{

			}


	}

//================ check if negative netpay - lw income
if($is_salary_fixed=="1"){

}else{
	if($no_attendance=="yes"){
		$my_other_ded=$ode_total_amount_nontaxable+$ode_total_amount_taxable;
		$my_other_income=$total_nontaxable_oa+$total_taxable_oa;

		if($my_other_income<$my_other_ded){

			if($ode_total_amount_taxable>0){
				$ode_taxable_list="the below is automatically NOT deducted due to low income/negative netpay result <br> (<br>$ode_taxable_list) ";
				$ode_total_amount_taxable=0;
			}else{

			}
			if($ode_total_amount_nontaxable>0){
				$ode_nontaxable_list="the below is automatically NOT deducted due to low income/negative netpay result <br> (<br>$ode_nontaxable_list) ";
				$ode_total_amount_nontaxable=0;
			}else{

			}


		}else{

		}

	}else{

	}

}



}else{
		$od_type="";
		$od_rate="";
		$od_amount="";
		$is_od_taxable="";
		$is_od_nontax="";
		$is_od_bonus="";
		$is_od_tertin_mnt="";
		$is_od_basic="";
		$is_od_ot="";
		$is_od_leave="";
		$is_od_alphalist_excluded="";
		$od_category="";
		$od_added="";

		$ode_amount="";
		$ode_encode_type="";

		$ode_total_amount_taxable="";
		$ode_total_amount_nontaxable="";
		$ode_taxable_list="";
		$ode_nontaxable_list="";
		$ode_taxable_list_clean="";
		$ode_nontaxable_list_clean="";

}

$company_automatic_od_list=$this->payroll_generate_payslip_model->get_company_auto_deduction($company_id,$employee_id,$pay_period,$pay_period_from);
if(!empty($company_automatic_od_list)){

	$auto_ode_taxable_list="";
	$auto_ode_taxable_list_clean="";
	$auto_ode_taxable_total="";
	$auto_ode_nontaxable_list="";
	$auto_ode_nontaxable_list_clean="";
	$auto_ode_nontaxable_total="";

	foreach($company_automatic_od_list as $auto_od){
		$auto_od_type=$auto_od->od_other_deduction_type;
		$auto_od_rate=$auto_od->od_rate;
		$auto_od_amount=$auto_od->od_amount;
		$is_auto_od_taxable=$auto_od->od_taxable;
		$is_auto_od_nontax=$auto_od->od_non_tax;
		$is_auto_od_bonus=$auto_od->od_bonus;
		$is_auto_od_tertin_mnt=$auto_od->od_th_month_pay;
		$is_auto_od_basic=$auto_od->od_basic;
		$is_auto_od_ot=$auto_od->od_ot;
		$is_auto_od_leave=$auto_od->od_other_deduction_leave;
		$is_auto_od_alphalist_excluded=$auto_od->od_exclude;
		$auto_od_category=$auto_od->od_category;
		$auto_od_added=$auto_od->od_date;

		$auto_ode_formula_description=$auto_od->formula_description;
		$auto_ode_entry_type=$auto_od->entry_type." (via automatic addition)";
		$open_entry=$auto_od->open_entry;
		$auto_ode_formula=$auto_od->formula;
		$auto_ode_payroll_formulas_id=$auto_od->payroll_formulas_id;
		
        $auto_ode_formula_text=str_replace("[","{",$auto_ode_formula);
        $auto_ode_formula_text=str_replace("]","}",$auto_ode_formula_text);
        $auto_ode_formula_text = $auto_ode_formula_text;
        $for_translation=$auto_ode_formula_text;
        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
        $auto_ode_formula_1st=str_replace("[","",$auto_ode_formula);
        $auto_ode_formula_2nd=str_replace("]","",$auto_ode_formula_1st);    
        $auto_ode_formula_3=$auto_ode_formula_2nd;
    /**/$auto_ode_formula_3 = preg_replace('/(?<=\d)\s+(?=\d)/', '', $auto_ode_formula_3);

    /**/$auto_ode_value = eval('return '.$auto_ode_formula_3.';');
    /**/$auto_ode_formula_text=$auto_ode_formula_description."<br> $for_translation";

    	if($auto_ode_payroll_formulas_id==""){
    		$auto_ode_value=$open_entry;
    	}else{

    	}
    	//echo "$auto_ode_value : $auto_ode_formula_text <br>";

		if($is_auto_od_taxable=="1"){ // TAXABLE\
			$is_taxable="1";
			$auto_ode_taxable_total+=$auto_ode_value;
			$auto_ode_taxable_list.="<a title='".$auto_ode_entry_type."'> $auto_ode_formula_text <br> ".$auto_od_type." : ".$auto_ode_value."</a><br>";
			$auto_ode_taxable_list_clean.=" $auto_od_type : $auto_ode_value <br>";

		}else{// NON- TAXABLE
			$is_taxable="0";
			$auto_ode_nontaxable_total+=$auto_ode_value;
			$auto_ode_nontaxable_list.="<a title='".$auto_ode_entry_type."'> $auto_ode_formula_text <br> ".$auto_od_type." : ".$auto_ode_value."</a><br>";
			$auto_ode_nontaxable_list_clean.=" $auto_od_type : $auto_ode_value <br>";

		}

			if($selected_payroll_option=="post_all"){
					$save_each_od = array(
						'od_id' => $auto_od->other_deduction_id,
						'company_id' => $auto_od->company_id,
						'employee_id' => $auto_od->employee_id,
						'payroll_period_id' => $pay_period,
						'oa_amount' => $auto_ode_value,
						'is_taxable' => $is_taxable,
						'date_process' => date('Y-m-d H:i:s'),

					);

					$this->payroll_generate_payslip_model->post_other_deduction($save_each_od,$month_cover);

			}else{

			}





	}
}else{
		$auto_ode_taxable_list="";
		$auto_ode_taxable_list_clean="";
		$auto_ode_taxable_total="";
		$auto_ode_nontaxable_list="";
		$auto_ode_nontaxable_list_clean="";
		$auto_ode_nontaxable_total="";
		
}

            if($round_off_payslip=="yes"){// round off
                $auto_ode_taxable_total=round($auto_ode_taxable_total, $payslip_decimal_place);
            }else{
                $auto_ode_taxable_total=bcdiv($auto_ode_taxable_total, 1, $payslip_decimal_place); 
            }

$total_taxable_od=$ode_total_amount_taxable+$auto_ode_taxable_total;
$total_nontaxable_od=$ode_total_amount_nontaxable+$auto_ode_nontaxable_total; 

            if($round_off_payslip=="yes"){// round off
                $total_taxable_od=round($total_taxable_od, $payslip_decimal_place);
                $total_nontaxable_od=round($total_nontaxable_od, $payslip_decimal_place);
            }else{
                $total_taxable_od=bcdiv($total_taxable_od, 1, $payslip_decimal_place); 
                $total_nontaxable_od=bcdiv($total_nontaxable_od, 1, $payslip_decimal_place); 
            }

		//==============no attendance.no basic income.
		if($is_salary_fixed=="1"){

		}else{

			if($no_attendance=="yes"){

				$total_taxable_od=0;
				$total_nontaxable_od=0;

				$auto_ode_taxable_list="";
				$auto_ode_taxable_total="";
				$auto_ode_nontaxable_list="";
				$auto_ode_nontaxable_total="";	

			}else{



			}


		}


		if($auto_netpay_adjust_setting=="Automatically dont deduct loan AND other deduction" OR $auto_netpay_adjust_setting=="Automatically dont deduct other deductions"){//
			
		}else{

		}


?>