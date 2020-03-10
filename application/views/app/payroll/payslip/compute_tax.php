<?php
// =============================================
if($no_attendance=="yes"){
	/* 
	kapag walang attendance edi no basic sya.
	kapag walang other addition taxable: force 0 tax deduction 
	*/	
	if($total_taxable_oa<=0){
		$taxable_formula_value=0;
	}else{

	}
}else{}
// =============================================

	if($wtax_formula==""){// no formula for sss gross yet
	            	$wtax_formula_text="Notice: No WTAX Formula Setup Yet.";
	            	$witheld_tax=0;
	}else{
					if(($active_pay_type=="2")OR($active_pay_type=="3")){// bi weekly or semi monhtly pay type

					}else{

					}

		if($salary_deduct_withholding_tax==1){ // salary setting deduct tax : yes

$tax_table_name="tax_table_".$company_id;
$validate_tax_table=$this->payroll_generate_payslip_model->check_tax_table($tax_table_name);
if(!empty($validate_tax_table)){

			$wtax_table_setup=$this->payroll_generate_payslip_model->get_wtax_table($company_id,$active_pay_type,$active_salary_rate,$year_cover,$taxcode_id,$taxable_formula_value);

			if(!empty($wtax_table_setup)){
					$tax_code_field="tax_code_".$taxcode_id;
					$exempt_percentage=$wtax_table_setup->exempt_percentage;
					$exempt_value=$wtax_table_setup->exempt_value;
					$tax_code_field=$wtax_table_setup->taxcodefield;

					//option 1
					foreach($taxcodeList as $tc_list){
						$tcid=$tc_list->taxcode_id;
						$transpose_var='tax_code_'.$tcid;
						$$transpose_var=$tax_code_field; // yes this is double dollar sign.
					}
					//option 2
					
					// start compute tax

				        $wtax_formula_text=str_replace("[","{",$wtax_formula);
				        $wtax_formula_text=str_replace("]","}",$wtax_formula_text);
				        $wtax_formula_text = $wtax_formula_text;

						$string = "$wtax_formula_text";
						$newword='tax_code_'.$taxcode_id; // get the taxcode id
						$newstring = str_replace("tax_code", $newword, $string);
						$wtax_formula_text=$newstring;

					        $for_translation=$wtax_formula_text;
					        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
					        $wtax_formula_1st=str_replace("[","",$wtax_formula);
					        $wtax_formula_2nd=str_replace("]","",$wtax_formula_1st);    

						$string_2 = "$wtax_formula_2nd";
						$newword_2='tax_code_1';
						$newstring_2 = str_replace("tax_code", $newword_2, $string_2);
						$wtax_formula_3=$newstring_2;
							        		     
					    	
					    	$witheld_tax = eval('return '.$wtax_formula_3.';');
					    	$wtax_formula_text=$wtax_formula_desc."<br> $for_translation = $witheld_tax";

// =============== start validate of tax deduction is annualize
if($tax_deduction_type=="general by taxtable" OR $tax_deduction_type=="tax_table"){

}elseif($tax_deduction_type=="general annualize" OR $tax_deduction_type=="annualize"){

	if($month_cover=="1"){// first month of the year.
		if($cut_off=="1"){// first cutoff of the month
				$assumed_tax_in_a_year=$witheld_tax;
				$assumed_tax_in_a_month=$assumed_tax_in_a_year/12;
				$assumed_tax_in_a_cutoff=$assumed_tax_in_a_month/2;

				$wtax_formula_text=$wtax_formula_text."<br><br>
				ANNUALIZE WTAX DETAILS<br>
				Assumed wtax in a year: $assumed_tax_in_a_year <br>
				Assumed wtax in a month: $assumed_tax_in_a_year/12= $assumed_tax_in_a_month <br>
				Assumed wtax in a payroll period: $assumed_tax_in_a_month/2= $assumed_tax_in_a_cutoff <br>
				";


				$witheld_tax=$assumed_tax_in_a_cutoff;
		}else{//2nd cutoff of the month
				$assumed_tax_in_a_year=$witheld_tax-$first_posted_ytd_wtax;// minus previously deducted ytd wtax
				$assumed_tax_in_a_month=$assumed_tax_in_a_year/12;
				$assumed_tax_in_a_cutoff=$assumed_tax_in_a_month/2;

				$wtax_formula_text=$wtax_formula_text."<br><br>
				ANNUALIZE WTAX DETAILS<br>
				Assumed wtax in a year: current actual wtax - previous total wtax<br> $witheld_tax-$first_posted_ytd_wtax = $assumed_tax_in_a_year <br>
				Assumed wtax in a month: $assumed_tax_in_a_year/12= $assumed_tax_in_a_month <br>
				Assumed wtax in a payroll period: $assumed_tax_in_a_month/2= $assumed_tax_in_a_cutoff <br>
				";
				$witheld_tax=$assumed_tax_in_a_cutoff;
		}
	}else{

				$prev_cutoff_wtax_ytd=$this->payroll_generate_payslip_model->prev_cutoff_wtax_ytd($month_cover,$employee_id,$cut_off);
				if(!empty($prev_cutoff_wtax_ytd)){
					$prev_ytd_wtax=$prev_cutoff_wtax_ytd->ytd_wtax;
				}else{
					$prev_ytd_wtax=0;
				}
				$assumed_tax_in_a_year=$witheld_tax-$prev_ytd_wtax;
				$assumed_tax_in_a_month=$assumed_tax_in_a_year/$months_count;//months_count : see at compute_annualize_taxable.php
				$assumed_tax_in_a_cutoff=$assumed_tax_in_a_month/2;

				$wtax_formula_text=$wtax_formula_text."<br><br>
				ANNUALIZE WTAX DETAILS<br>
				Assumed wtax in a year: $assumed_tax_in_a_year <br>
				Assumed wtax in a month: $assumed_tax_in_a_year/12= $assumed_tax_in_a_month <br>
				Assumed wtax in a payroll period: $assumed_tax_in_a_month/2= $assumed_tax_in_a_cutoff <br>
				";

				$witheld_tax=$assumed_tax_in_a_cutoff;

	}
}else{

}
// =============== end validate of tax deduction is annualize



		            if($round_off_payslip=="yes"){// round off
		                $witheld_tax=round($witheld_tax, $payslip_decimal_place);
		            }else{
		                $witheld_tax=bcdiv($witheld_tax, 1, $payslip_decimal_place); 
		            }	
					    	
					// end compute tax
			}else{
					$wtax_formula_text="taxable value: no match row in tax table.";
					$witheld_tax=0;
			}
}else{
					$wtax_formula_text="notice : tax table is not yet setup.";
					$witheld_tax=0;
}


		}else{ // do not deduct tax.

$witheld_tax=0;
$wtax_formula_text="WTAX Deduction is turned off.";

		}






}

?>