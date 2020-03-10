<?php
$company_manual_oa_list=$this->payroll_generate_payslip_model->get_company_oa($company_id,$employee_id,$pay_period);
if(!empty($company_manual_oa_list)){
	$oae_total_amount_taxable=0;
	$oae_total_amount_nontaxable=0;
	$oae_taxable_list="";
	$oae_taxable_list_clean="";
	$oae_nontaxable_list="";
	$oae_nontaxable_list_clean="";
	foreach ($company_manual_oa_list as $oa){

		$oa_type=$oa->oa_other_addition_type;
		$oa_rate=$oa->oa_rate;
		$oa_amount=$oa->oa_amount;
		$is_oa_taxable=$oa->oa_taxable;
		$is_oa_nontax=$oa->oa_non_tax;
		$is_oa_bonus=$oa->oa_bonus;
		$is_oa_tertin_mnt=$oa->oa_th_month_pay;
		$is_oa_basic=$oa->oa_basic;
		$is_oa_ot=$oa->oa_ot;
		$is_oa_leave=$oa->oa_other_addition_leave;
		$is_oa_alphalist_excluded=$oa->oa_exclude;
		$oa_category=$oa->oa_category;
		$oa_added=$oa->oa_date;

		$oae_amount=$oa->amount;
		$oae_entry_type=$oa->entry_type;

		if($is_oa_taxable=="1"){ // TAXABLE
			$is_taxable="1";
			$oae_amount;
			$oae_total_amount_taxable+=$oae_amount;
			$oae_taxable_list.="<a title='".$oae_entry_type."'>".$oa_type." : ".$oae_amount."</a><br>";
			$oae_taxable_list_clean.=" $oa_type : $oae_amount <br>";
		}else{// NON-TAXABLE
			$is_taxable="0";
			$oae_amount;
			$oae_total_amount_nontaxable+=$oae_amount;
			$oae_nontaxable_list.="<a title='".$oae_entry_type."'>".$oa_type." : ".$oae_amount."</a><br>";
			$oae_nontaxable_list_clean.=" $oa_type : $oae_amount <br>";
		}


			if($selected_payroll_option=="post_all"){
					$save_each_oa = array(
						'oa_id' => $oa->other_addition_id,
						'company_id' => $oa->company_id,
						'employee_id' => $oa->employee_id,
						'payroll_period_id' => $pay_period,
						'oa_amount' => $oae_amount,
						'is_taxable' => $is_taxable,
						'date_process' => date('Y-m-d H:i:s'),

					);

					$this->payroll_generate_payslip_model->post_other_addition($save_each_oa,$month_cover);

			}else{

			}

		

	}

}else{
		$oa_type="";
		$oa_rate="";
		$oa_amount="";
		$is_oa_taxable="";
		$is_oa_nontax="";
		$is_oa_bonus="";
		$is_oa_tertin_mnt="";
		$is_oa_basic="";
		$is_oa_ot="";
		$is_oa_leave="";
		$is_oa_alphalist_excluded="";
		$oa_category="";
		$oa_added="";

		$oae_amount="";
		$oae_encode_type="";

		$oae_total_amount_taxable="";
		$oae_total_amount_nontaxable="";
		$oae_taxable_list="";
		$oae_taxable_list_clean="";
		$oae_nontaxable_list="";
		$oae_nontaxable_list_clean="";

}

$company_automatic_oa_list=$this->payroll_generate_payslip_model->get_company_auto_addition($company_id,$employee_id,$pay_period,$pay_period_from,$cut_off);
if(!empty($company_automatic_oa_list)){

	$auto_oae_taxable_list="";
	$auto_oae_taxable_list_clean="";
	$auto_oae_taxable_total="";
	$auto_oae_nontaxable_list="";
	$auto_oae_nontaxable_list_clean="";
	$auto_oae_nontaxable_total="";

	foreach($company_automatic_oa_list as $auto_oa){
		$auto_oa_formula_id=$auto_oa->payroll_formulas_id;

$get_auto_oa_formula=$this->payroll_generate_payslip_model->get_auto_oa_formula($auto_oa_formula_id);
if(!empty($get_auto_oa_formula)){
	$auto_oa_fd=$get_auto_oa_formula->formula_description;
	$auto_oa_f=$get_auto_oa_formula->formula;
	$is_auto_oa_fb="yes";// is auto o.a formula based
}else{
	$auto_oa_fd="";
	$auto_oa_f="";
	$is_auto_oa_fb="no";
}


		$auto_oa_type=$auto_oa->oa_other_addition_type;
		$auto_oa_rate=$auto_oa->oa_rate;
		$auto_oa_amount=$auto_oa->oa_amount;
		$is_auto_oa_taxable=$auto_oa->oa_taxable;
		$is_auto_oa_nontax=$auto_oa->oa_non_tax;
		$is_auto_oa_bonus=$auto_oa->oa_bonus;
		$is_auto_oa_tertin_mnt=$auto_oa->oa_th_month_pay;
		$is_auto_oa_basic=$auto_oa->oa_basic;
		$is_auto_oa_ot=$auto_oa->oa_ot;
		$is_auto_oa_leave=$auto_oa->oa_other_addition_leave;
		$is_auto_oa_alphalist_excluded=$auto_oa->oa_exclude;
		$auto_oa_category=$auto_oa->oa_category;
		$auto_oa_added=$auto_oa->oa_date;

		$auto_oae_entry_type=$auto_oa->entry_type;
		$open_entry=$auto_oa->open_entry;
		$optional_open_entry=$auto_oa->optional_open_entry;

		$auto_oae_formula_description=$auto_oa_fd;
		$auto_oae_formula=$auto_oa_f;

	if($is_auto_oa_fb=="no"){
		$auto_oae_value=$open_entry;
		$auto_oae_formula_text="Fixed Amount/Non Formula Base.";
	}else{
		

        $auto_oae_formula_text=str_replace("[","{",$auto_oae_formula);
        $auto_oae_formula_text=str_replace("]","}",$auto_oae_formula_text);
        $auto_oae_formula_text = $auto_oae_formula_text;
        $for_translation=$auto_oae_formula_text;
        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
        $auto_oae_formula_1st=str_replace("[","",$auto_oae_formula);
        $auto_oae_formula_2nd=str_replace("]","",$auto_oae_formula_1st);    
        $auto_oae_formula_3=$auto_oae_formula_2nd;
	/**/$auto_oae_formula_3 = preg_replace('/(?<=\d)\s+(?=\d)/', '', $auto_oae_formula_3);

	if (preg_match('/[0-9]/', $auto_oae_formula)){
	    //echo 'Contains at least one number'; if with number on formula created. use this
	   		$a=$for_translation;
	    /**/$auto_oae_value = $a;//eval('return '.$auto_oae_formula_3.';');
		    $auto_oae_value=str_replace(' ','',$auto_oae_value);//remove space between numbers
		    $auto_oae_value=eval('return '.$auto_oae_value.';');
	}else{
		
		/**/$auto_oae_value = eval('return '.$auto_oae_formula_3.';');
	}
 		
    
if (strpos($auto_oae_formula, '$absences_total') !== false) {
	if($no_attendance=="yes"){
		$auto_oae_value=0;
		$for_translation=$for_translation."<br>(Formula is base on absences. No Attendance found,therefore force to 0 value)";
	}else{
		
	}
}else{

}


    /**/$auto_oae_formula_text=$auto_oae_formula_description."<br> $for_translation";

	}

		if($is_auto_oa_taxable=="1"){ // TAXABLE
			$is_taxable="1";
			$auto_oae_taxable_total+=$auto_oae_value;
			$auto_oae_taxable_list.="<a title='".$auto_oae_entry_type."'> $auto_oae_formula_text <br> ".$auto_oa_type." : ".$auto_oae_value."</a><br><br>";
			$auto_oae_taxable_list_clean.="$auto_oa_type :$auto_oae_value <br>";


		}else{// NON- TAXABLE
			$is_taxable="0";
			$auto_oae_nontaxable_total+=$auto_oae_value;
			$auto_oae_nontaxable_list.="<a title='".$auto_oae_entry_type."'> $auto_oae_formula_text <br> ".$auto_oa_type." : ".$auto_oae_value."</a><br><br>";
			$auto_oae_nontaxable_list_clean.="$auto_oa_type :$auto_oae_value <br>";

		}



			if($selected_payroll_option=="post_all"){
					$save_each_oa = array(
						'oa_id' => $auto_oa->other_addition_id,
						'company_id' => $auto_oa->company_id,
						'employee_id' => $auto_oa->employee_id,
						'payroll_period_id' => $pay_period,
						'oa_amount' => $auto_oae_value,
						'is_taxable' => $is_taxable,
						'date_process' => date('Y-m-d H:i:s'),

					);

					$this->payroll_generate_payslip_model->post_other_addition($save_each_oa,$month_cover);

			}else{

			}




    
	}
}else{
		$auto_oae_nontaxable_list_clean="";
		$auto_oae_taxable_list_clean="";
		$auto_oae_taxable_list="";
		$auto_oae_taxable_total="";
		$auto_oae_nontaxable_list="";
		$auto_oae_nontaxable_total="";
}

            if($round_off_payslip=="yes"){// round off
                $auto_oae_taxable_total=round($auto_oae_taxable_total, $payslip_decimal_place);
            }else{
                $auto_oae_taxable_total=bcdiv($auto_oae_taxable_total, 1, $payslip_decimal_place); 
            }


//============================ start default automatic overtime meal allowance





if($ot_auto_meal_allowance=="OFF"){
	$auto_ot_meal_allowance_text="";

	$auto_ot_clean_nontaxable="";
	$auto_ot_clean_taxable="";
	$total_auto_meal_allowance_taxable="";
	$total_auto_meal_allowance_nontaxable="";
	$auto_ot_meal_allowance_how_to_taxable="";
	$auto_ot_meal_allowance_how_to_nontaxable="";
}else{


	$emp_with_ot_meal=$this->payroll_generate_payslip_model->verifyEnrolledWithOtMeal($employee_id);




	$auto_ot_meal_allowance_text="AUTOMATIC OT MEAL ALLOWANCE";
	$default_ot_meal=$this->payroll_generate_payslip_model->ot_meal_table($company_id,$employment_id,$classification_id,$location_id);
		//echo "$ot_auto_meal_allowance HEY GEL | $company_id | $employment_id | $classification_id | $location_id";

		if(!empty($default_ot_meal)){

			$fin_regday_meal_value="";
			$fin_restday_meal_value="";
			$fin_regholiday_meal_value="";
			$fin_rd_regholiday_meal_value="";
			$fin_specholiday_meal_value="";
			$fin_rd_specholiday_meal_value="";
			$total_auto_meal_allowance="";
			$total_auto_meal_allowance_how_to="";
			foreach($default_ot_meal as $ot_setup){
				$fixed_hour_policy=$ot_setup->every_hour;	
				$from_hour=$ot_setup->from_hour;
				$to_hour=$ot_setup->to_hour;
				$e_amount=$ot_setup->amount;
				$ot_type=$ot_setup->param_id;

				$regday_ttl_ot_hrs=$total_regular_overtime+$total_regular_overtime_nd;
				$restday_ttl_ot_hrs=$total_regular_hrs_restday+$total_restday_nd+$total_restday_overtime+$total_restday_overtime_nd; //
				$regholiday_ttl_ot_hrs=$total_regular_hrs_reg_holiday+$total_reg_holiday_nd+$total_reg_holiday_overtime+$total_reg_holiday_overtime_nd;
				$rd_regholiday_ttl_ot_hrs=$total_regular_hrs_reg_holiday_t1+$total_restday_reg_holiday_nd+$total_restday_reg_holiday_overtime+$total_restday_reg_holiday_overtime_nd;
				$specholiday_ttl_ot_hrs=$total_regular_hrs_spec_holiday+$total_spec_holiday_nd+$total_spec_holiday_overtime+$total_spec_holiday_overtime_nd;
				$rd_specholiday_ttl_ot_hrs=$total_restday_regular_hrs_spec_holiday+$total_restday_spec_holiday_nd+$total_restday_spec_holiday_overtime+$total_restday_spec_holiday_overtime_nd;

				if($fixed_hour_policy==""){ // by range ot meal allowance
					$ot_how_to="(Days Count * Equivalent Amount <br>";
					$equivalent_amount=$e_amount;
					$count_meal=$this->payroll_generate_payslip_model->checkPerDateOt($employee_id,$pay_period,$month_cover);
					
					if(!empty($count_meal)){
						foreach($count_meal as $p){
							if($ot_type=="111"){
								if(($p->pd_total_regular_day_ot>=$from_hour)AND($p->pd_total_regular_day_ot<=$to_hour)){//regular day ot
									$$regday_otmeal++;
								}else{}
							}else{}

							if($ot_type=="112"){
								if(($p->pd_total_restday_ot>=$from_hour)AND($p->pd_total_restday_ot<=$to_hour)){//rest day ot					
									$$restday_otmeal++;
								}else{}
							}else{

							}

							if($ot_type=="113"){
								if(($p->pd_total_reghol_ot>=$from_hour)AND($p->pd_total_reghol_ot<=$to_hour)){//reghol ot 
									$$reghol_otmeal++;
								}else{}
							}else{}

							if($ot_type=="114"){
								if(($p->pd_total_rdreghol_ot>=$from_hour)AND($p->pd_total_rdreghol_ot<=$to_hour)){//restday reghol ot 
									$$rdreghol_otmeal++;
								}else{}
							}else{}

							if($ot_type=="115"){
								if(($p->pd_total_snw_ot>=$from_hour)AND($p->pd_total_snw_ot<=$to_hour)){//snw ot 
									$$snw_otmeal++;
								}else{}
							}else{}

							if($ot_type=="116"){
								if(($p->pd_total_rdsnw_ot>=$from_hour)AND($p->pd_total_rdsnw_ot<=$to_hour)){//rd snw ot 
									$$rdsnw_otmeal++;
								}else{}
							}else{}



						}//end of foreach
					}else{}





						// if($ot_type=="111"){// regular ot

						// 	if($regday_ttl_ot_hrs>0){
						// 		if(($regday_ttl_ot_hrs>=$from_hour)AND($regday_ttl_ot_hrs<=$to_hour)){
						// 			$regday_meal_value=$e_amount;
						// 			$fin_regday_meal_value+=$regday_meal_value;
						// 		}else{
						// 			$regday_meal_value=0; 
						// 			$fin_regday_meal_value+=$regday_meal_value;
						// 		}

						// 		if($regday_meal_value>0){
						// 			$fin_regday_text="regular ot is $regday_ttl_ot_hrs  hr(s) with equivalent amount of $fin_regday_meal_value<br>";
						// 			$total_auto_meal_allowance_how_to.=$fin_regday_text;
						// 		}else{

						// 		}

						// 	}else{
						// 		$fin_regday_meal_value=0;
						// 	}


						// }elseif($ot_type=="112"){// regular ot

						// 	if($restday_ttl_ot_hrs>0){
						// 		if(($restday_ttl_ot_hrs>=$from_hour)AND($restday_ttl_ot_hrs<=$to_hour)){
						// 			$restday_meal_value=$e_amount;
						// 			$fin_restday_meal_value+=$restday_meal_value;
						// 		}else{
						// 			$restday_meal_value=0;
						// 			$fin_restday_meal_value+=$restday_meal_value;
						// 		}

						// 		if($restday_meal_value>0){
						// 			$fin_restday_text="restday ot is $restday_ttl_ot_hrs  hr(s) with equivalent amount of $fin_restday_meal_value<br>";
						// 			$total_auto_meal_allowance_how_to.=$fin_restday_text;
						// 		}else{

						// 		}

						// 	}else{
						// 		$fin_restday_meal_value=0;
						// 	}

						// }elseif($ot_type=="113"){// regular ot
						// 	if($regholiday_ttl_ot_hrs>0){
						// 		if(($regholiday_ttl_ot_hrs>=$from_hour)AND($regholiday_ttl_ot_hrs<=$to_hour)){
						// 			$regholiday_meal_value=$e_amount;
						// 			$fin_regholiday_meal_value+=$regholiday_meal_value;
						// 		}else{
						// 			$regholiday_meal_value=0;
						// 			$fin_regholiday_meal_value+=$regholiday_meal_value;
						// 		}
						// 		if($regholiday_meal_value>0){
						// 			$fin_regholiday_text="regular holiday ot is $regholiday_ttl_ot_hrs  hr(s) with equivalent amount of $fin_regholiday_meal_value<br>";
						// 			$total_auto_meal_allowance_how_to.=$fin_regholiday_text;
						// 		}else{

						// 		}


						// 	}else{
						// 		$fin_regholiday_meal_value=0;
						// 	}
						// }elseif($ot_type=="114"){// regular ot
						// 	if($rd_regholiday_ttl_ot_hrs>0){
						// 		if(($rd_regholiday_ttl_ot_hrs>=$from_hour)AND($rd_regholiday_ttl_ot_hrs<=$to_hour)){
						// 			$rd_regholiday_meal_value=$e_amount;
						// 			$fin_rd_regholiday_meal_value+=$rd_regholiday_meal_value;
						// 		}else{
						// 			$rd_regholiday_meal_value=0;
						// 			$fin_rd_regholiday_meal_value+=$rd_regholiday_meal_value;
						// 		}

						// 		if($rd_regholiday_meal_value>0){
						// 			$fin_rd_regholiday_text="restday regular holiday ot is $rd_regholiday_ttl_ot_hrs  hr(s) with equivalent amount of $fin_rd_regholiday_meal_value<br>";
						// 			$total_auto_meal_allowance_how_to.=$fin_rd_regholiday_text;
						// 		}else{

						// 		}


						// 	}else{
						// 		$fin_rd_regholiday_meal_value=0;
						// 	}
						// }elseif($ot_type=="115"){// regular ot
						// 	if($specholiday_ttl_ot_hrs>0){
						// 		if(($specholiday_ttl_ot_hrs>=$from_hour)AND($specholiday_ttl_ot_hrs<=$to_hour)){
						// 			$specholiday_meal_value=$e_amount;
						// 			$fin_specholiday_meal_value+=$specholiday_meal_value;
						// 		}else{
						// 			$specholiday_meal_value=0;
						// 			$fin_specholiday_meal_value+=$specholiday_meal_value;
						// 		}

						// 		if($specholiday_meal_value>0){
						// 			$fin_specholiday_text="special holiday ot is $specholiday_ttl_ot_hrs  hr(s) with equivalent amount of $fin_specholiday_meal_value<br>";
						// 			$total_auto_meal_allowance_how_to.=$fin_specholiday_text;
						// 		}else{

						// 		}

						// 	}else{
						// 		$fin_specholiday_meal_value=0;
						// 	}
						// }elseif($ot_type=="116"){// regular ot
						// 	if($rd_specholiday_ttl_ot_hrs>0){
						// 		if(($rd_specholiday_ttl_ot_hrs>=$from_hour)AND($rd_specholiday_ttl_ot_hrs<=$to_hour)){
						// 			$rd_specholiday_meal_value=$e_amount;
						// 			$fin_rd_specholiday_meal_value+=$rd_specholiday_meal_value;
						// 		}else{
						// 			$rd_specholiday_meal_value=0;
						// 			$fin_rd_specholiday_meal_value+=$rd_specholiday_meal_value;
						// 		}

						// 		if($rd_specholiday_meal_value>0){
						// 			$fin_rd_specholiday_text="rest day-special holiday ot is $rd_specholiday_ttl_ot_hrs  hr(s) with equivalent amount of $fin_rd_specholiday_meal_value<br>";
						// 			$total_auto_meal_allowance_how_to.=$fin_rd_specholiday_text;
						// 		}else{

						// 		}

						// 	}else{
						// 		$fin_rd_specholiday_meal_value=0;
						// 	}
						// }else{

						// }				

				}else{ // fixed hour equivalent value ot meal allowance

					$every_hour=$fixed_hour_policy;
					$equivalent_amount=$e_amount;
					$ot_how_to="(Days Count * Equivalent Amount <br>";

					$count_meal=$this->payroll_generate_payslip_model->checkPerDateOt($employee_id,$pay_period,$month_cover);
					
					if(!empty($count_meal)){
						foreach($count_meal as $p){

							if($ot_type=="111"){
								if($p->pd_total_regular_day_ot==$every_hour){//regular day ot
									$$regday_otmeal++;
								}else{}
							}else{								
							}

							if($ot_type=="112"){
								if($p->pd_total_restday_ot==$every_hour){//rest day ot							
									$$restday_otmeal++;
								}else{}
							}else{

							}

							if($ot_type=="113"){
								if($p->pd_total_reghol_ot==$every_hour){//reghol ot
									$$reghol_otmeal++;
								}else{}
							}else{}

							if($ot_type=="114"){
								if($p->pd_total_rdreghol_ot==$every_hour){//restday reghol ot
									$$rdreghol_otmeal++;
								}else{}
							}else{}

							if($ot_type=="115"){
								if($p->pd_total_snw_ot==$every_hour){//snw ot
									$$snw_otmeal++;
								}else{}
							}else{}

							if($ot_type=="116"){
								if($p->pd_total_rdsnw_ot==$every_hour){//rd snw ot
									$$rdsnw_otmeal++;
								}else{}
							}else{}
						}
					}else{
					}
				}//end of every hours

// ================start compute
					if($ot_type=="111"){// regular ot						
						if($$regday_otmeal>0){
							$fin_regday_meal_value=$$regday_otmeal*$equivalent_amount;
							$fin_regday_text=$$regday_otmeal."*$equivalent_amount = $fin_regday_meal_value <i class='fa fa-arrow-right'></i> regular day ot meal allowance<br>";
							$total_auto_meal_allowance_how_to.=$fin_regday_text;
						}else{
							$fin_regday_meal_value=0;
							$fin_regday_text="";
						}

					}elseif($ot_type=="112"){//rest day ot						
						if($$restday_otmeal>0){
							$fin_restday_meal_value=$$restday_otmeal*$equivalent_amount;
							$fin_restday_texts=$$restday_otmeal."*$equivalent_amount = $fin_restday_meal_value <i class='fa fa-arrow-right'></i> restday ot meal allowance<br>";
							$total_auto_meal_allowance_how_to.=$fin_restday_texts;
						}else{
							$fin_restday_meal_value=0;
							$fin_restday_texts="";
						}

					}elseif($ot_type=="113"){// regular holiday ot
						
						if($$reghol_otmeal>0){
							$fin_regholiday_meal_value=$$reghol_otmeal*$equivalent_amount;
							$fin_regholiday_text=$$reghol_otmeal."*$equivalent_amount = $fin_regholiday_meal_value  <i class='fa fa-arrow-right'></i> regular holiday ot meal allowance<br>";
							$total_auto_meal_allowance_how_to.=$fin_regholiday_text;
						}else{
							$fin_regholiday_meal_value=0;
							$fin_regholiday_text="";
						}						
					}elseif($ot_type=="114"){//rest day regular holiday ot
						
						if($$rdreghol_otmeal>0){
							$fin_rd_regholiday_meal_value=$$rdreghol_otmeal*$equivalent_amount;
							$fin_rd_regholiday_text=$$rdreghol_otmeal."*$equivalent_amount = $fin_rd_regholiday_meal_value  <i class='fa fa-arrow-right'></i> restday-regular holiday ot meal allowance<br>";
							$total_auto_meal_allowance_how_to.=$fin_rd_regholiday_text;
						}else{
							$fin_rd_regholiday_meal_value=0;
							$fin_rd_regholiday_text="";
						}							
					}elseif($ot_type=="115"){// special holiday
						
						if($$snw_otmeal>0){
							$fin_specholiday_meal_value=$$snw_otmeal*$equivalent_amount;
							$fin_specholiday_text=$$snw_otmeal."*$equivalent_amount = $fin_specholiday_meal_value  <i class='fa fa-arrow-right'></i> snw ot meal allowance<br>";
							$total_auto_meal_allowance_how_to.=$fin_specholiday_text;
						}else{
							$fin_specholiday_meal_value=0;
							$fin_specholiday_text="";
						}	
					}elseif($ot_type=="116"){// rest day special holiday ot
						
						if($$rdsnw_otmeal>0){
							$fin_rd_specholiday_meal_value=$$rdsnw_otmeal*$equivalent_amount;
							$fin_rd_specholiday_text=$rdsnw_otmeal."*$equivalent_amount = $fin_rd_specholiday_meal_value  <i class='fa fa-arrow-right'></i> restday-snw ot meal allowance<br>";
							$total_auto_meal_allowance_how_to.=$fin_rd_specholiday_text;
						}else{
							$fin_rd_specholiday_meal_value=0;
							$fin_rd_specholiday_text="";
						}							
					}else{// unknown ot code.

					}
//=================end compute





			}

$total_auto_meal_allowance=$fin_regday_meal_value+$fin_restday_meal_value+$fin_regholiday_meal_value+$fin_rd_regholiday_meal_value+$fin_specholiday_meal_value+$fin_rd_specholiday_meal_value;

				

		}else{
		$auto_ot_clean_nontaxable="";
		$auto_ot_clean_taxable="";
		$total_auto_meal_allowance=0;

		}

	if($ot_auto_meal_allowance=="ON as taxable"){

		$total_auto_meal_allowance_taxable=$total_auto_meal_allowance;
		$total_auto_meal_allowance_nontaxable="";

		$auto_ot_meal_allowance_how_to_nontaxable="";

		if($total_auto_meal_allowance_taxable>0){
			$auto_ot_clean_taxable="$auto_ot_meal_allowance_text : $total_auto_meal_allowance_taxable";
		$auto_ot_meal_allowance_how_to_taxable=$total_auto_meal_allowance_how_to.$auto_ot_meal_allowance_text.": $total_auto_meal_allowance_taxable";

		}else{
			$auto_ot_clean_taxable="";
			$auto_ot_meal_allowance_how_to_taxable="";
		}


		$auto_ot_clean_nontaxable="";
	}else{

		$total_auto_meal_allowance_nontaxable=$total_auto_meal_allowance;
		$total_auto_meal_allowance_taxable="";

		$auto_ot_meal_allowance_how_to_taxable="";

		if($total_auto_meal_allowance_nontaxable>0){
			$auto_ot_clean_nontaxable="$auto_ot_meal_allowance_text : $total_auto_meal_allowance_nontaxable";
		$auto_ot_meal_allowance_how_to_nontaxable=$total_auto_meal_allowance_how_to.$auto_ot_meal_allowance_text.": $total_auto_meal_allowance_nontaxable";

		}else{
			$auto_ot_clean_nontaxable="";
			$auto_ot_meal_allowance_how_to_nontaxable="";
		}
		
		$auto_ot_clean_taxable="";

	}


	if(!empty($emp_with_ot_meal)){		
	}else{
		$auto_ot_clean_taxable="";
		$auto_ot_clean_nontaxable="";
		$auto_ot_meal_allowance_how_to_taxable="";
		$auto_ot_meal_allowance_how_to_nontaxable="";
		$total_auto_meal_allowance=0;
	}

}


//============================ start default automatic leave adjustment
if($auto_adj_leave>0){
	$payroll_leave_adjustment=$auto_adj_leave*$daily_rate;
	$payroll_leave_adjustment_how_to="AUTOMATIC Leave Adjustment <br> leave * daily rate ($auto_adj_leave * $daily_rate)";

        if($round_off_payslip=="yes"){// round off
            $payroll_leave_adjustment=round($payroll_leave_adjustment, $payslip_decimal_place);
        }else{
            $payroll_leave_adjustment=bcdiv($payroll_leave_adjustment, 1, $payslip_decimal_place); 
        }

		if($is_leave_adj_taxable=="1"){ // taxable
			$taxme=1;
			$taxable_payroll_leave_adjustment=$payroll_leave_adjustment;
			$nontax_payroll_leave_adjustment="";
			$taxable_payroll_leave_adjustment_how_to=$payroll_leave_adjustment_how_to;
			$nontax_payroll_leave_adjustment_how_to="";
		}else{// nontax
			$taxme=0;
			$taxable_payroll_leave_adjustment="";
			$nontax_payroll_leave_adjustment=$payroll_leave_adjustment;
			$nontax_payroll_leave_adjustment_how_to=$payroll_leave_adjustment_how_to;
			$taxable_payroll_leave_adjustment_how_to="";
		}

}else{
	$payroll_leave_adjustment=0;
	$payroll_leave_adjustment_how_to="";
	$taxable_payroll_leave_adjustment="";
	$nontax_payroll_leave_adjustment="";
	$nontax_payroll_leave_adjustment_how_to="";
	$taxable_payroll_leave_adjustment_how_to="";
} // no for automatic adjustment


		if($selected_payroll_option=="post_all"){

			if($payroll_leave_adjustment>0){
								$save_each_oa = array(
									'oa_id' => $auto_leave_adj_oa_id,
									'company_id' => $company_id,
									'employee_id' => $employee_id,
									'payroll_period_id' => $pay_period,
									'oa_amount' => $payroll_leave_adjustment,
									'is_taxable' => $taxme,
									'date_process' => date('Y-m-d H:i:s'),
								);
								$this->payroll_generate_payslip_model->post_other_addition($save_each_oa,$month_cover);
			}else{}


			if($total_auto_meal_allowance_taxable>0){
								$save_each_oa = array(
									'oa_id' => $auto_ot_meal_allowance_oa_id,
									'company_id' => $company_id,
									'employee_id' => $employee_id,
									'payroll_period_id' => $pay_period,
									'oa_amount' => $total_auto_meal_allowance_taxable,
									'is_taxable' => '1',
									'date_process' => date('Y-m-d H:i:s'),
								);
								$this->payroll_generate_payslip_model->post_other_addition($save_each_oa,$month_cover);
			}elseif($total_auto_meal_allowance_nontaxable>0){
								$save_each_oa = array(
									'oa_id' => $auto_ot_meal_allowance_oa_id,
									'company_id' => $company_id,
									'employee_id' => $employee_id,
									'payroll_period_id' => $pay_period,
									'oa_amount' => $total_auto_meal_allowance_nontaxable,
									'is_taxable' => '0',
									'date_process' => date('Y-m-d H:i:s'),
								);
								$this->payroll_generate_payslip_model->post_other_addition($save_each_oa,$month_cover);

			}else{}

					

			}else{

			}


//============================ end defualt automatic overtime meal allowance
$total_taxable_oa=$oae_total_amount_taxable+$auto_oae_taxable_total+$total_auto_meal_allowance_taxable+$taxable_payroll_leave_adjustment;//
$total_nontaxable_oa=$oae_total_amount_nontaxable+$auto_oae_nontaxable_total+$total_auto_meal_allowance_nontaxable+$nontax_payroll_leave_adjustment; 


            if($round_off_payslip=="yes"){// round off
                $total_taxable_oa=round($total_taxable_oa, $payslip_decimal_place);
                $total_nontaxable_oa=round($total_nontaxable_oa, $payslip_decimal_place);
            }else{
                $total_taxable_oa=bcdiv($total_taxable_oa, 1, $payslip_decimal_place); 
                $total_nontaxable_oa=bcdiv($total_nontaxable_oa, 1, $payslip_decimal_place); 
            }


//echo "$oae_taxable_list_clean <br> $oae_nontaxable_list_clean <br> $auto_oae_taxable_list_clean <br> $auto_oae_nontaxable_list_clean";


?>