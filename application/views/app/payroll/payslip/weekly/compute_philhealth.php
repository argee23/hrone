<?php
if($deduct_philhealth=="yes" OR $philhealth_deduct_on=="2"){

//============GET PHILHEATLH GROSS
	if($philhealth_formula==""){// no formula for PHILHEALTH gross yet
	            	$philhealth_formula_text="Notice: No PHILHEALTH Formula Setup Yet.";
	            	$philhealth_formula_value=0;
	            	$philhealth_gross=0;
	}else{
					if(($active_pay_type=="2")OR($active_pay_type=="3")){// bi weekly or semi monhtly pay type

					}else{

					}

			        $philhealth_formula_text=str_replace("[","{",$philhealth_formula);
			        $philhealth_formula_text=str_replace("]","}",$philhealth_formula_text);
			        $philhealth_formula_text = $philhealth_formula_text;
			        $for_translation=$philhealth_formula_text;


			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $philhealth_formula_1st=str_replace("[","",$philhealth_formula);
			        $philhealth_formula_2nd=str_replace("]","",$philhealth_formula_1st);    
			        $philhealth_formula_3=$philhealth_formula_2nd;


			    /*every payday*/$philhealth_formula_text=$philhealth_formula_desc."<br> $for_translation";
			    /*every payday*/$philhealth_formula_value = eval('return '.$philhealth_formula_3.';');

				/*every 1stcutoff*/	if($philhealth_deduct_on=="1"){
										$philhealth_formula_value=$daily_rate*$mysalary_no_of_days_monthly;
										$philhealth_formula_text="1st Cut Off Deduction will base on net basic only : ".number_format($philhealth_formula_value);
										$philhealth_gross=0;
				/*every 2ndcutoff*/	}elseif($philhealth_deduct_on=="2"){

											$philhealth_gross=$philhealth_formula_value;
											$philhealth_formula_text=$philhealth_formula_text. "<br><br> Gross For PHILHEALTH =  2nd cutoff PHILHEALTH GROSS ($philhealth_formula_value) + 1st cutoff PHILHEALTH GROSS ($first_posted_philhealth_gross)";
											$philhealth_formula_value+=$first_posted_philhealth_gross;
									}else{
										$philhealth_formula_value+=$first_posted_philhealth_gross;
										
									}
				// == clear employER employEE contribution on : leave to save the philhealth gross as a ready value for 2nd cutoff computation	
				
				if(($deduct_philhealth=="no")AND($philhealth_deduct_on=="2")){
					$philhealth_formula_text="PHIHEALTH Deduction is set on 2nd cutoff. <br> Current Cutoff PHILHEALTH GROSS:( $philhealth_gross )";
				}else{

				}	


	}


}else{
					$philhealth_gross=0;
					$philhealth_formula_value=0;
					$philhealth_formula_text="PHILHEALTH Deduction is not on this cutoff.";
}


//============get philhealth maximum contribution
$philhealth_max_contri=$this->payroll_generate_payslip_model->get_philhealth_max_contri($company_id,$active_pay_type,$active_salary_rate,$year_cover);
if(!empty($philhealth_max_contri)){
	$philhealth_maximum_contribution_employee=$philhealth_max_contri->employee_maximum_contribution; // employEE
	$philhealth_maximum_contribution_employer=$philhealth_max_contri->employer_maximum_contribution; // employER
}else{
	$philhealth_maximum_contribution_employee=""; // employEE
	$philhealth_maximum_contribution_employer=""; // employER
}


//============get philhealth table
$philhealth_table=$this->payroll_generate_payslip_model->get_philhealth_table($company_id,$active_pay_type,$active_salary_rate,$year_cover,$philhealth_formula_value);

	if(!empty($philhealth_table)){

			if($deduct_philhealth=="yes"){

				$philhealth_deduction_type=$philhealth_table->philhealth_type;
				$ph_rate=$philhealth_table->percent_value; // rate holder//total_monthly_contribution

				if($philhealth_deduction_type=="109"){// Actual value of employee , employer field.

					$philhealth_employee_share=$philhealth_table->employee_share; // employEE
					$philhealth_employer_share=$philhealth_table->employer_share; // employER

			            if($round_off_payslip=="yes"){// round off
			                $philhealth_employer_share=round($philhealth_employer_share, $payslip_decimal_place);
			            }else{
			                $philhealth_employer_share=bcdiv($philhealth_employer_share, 1, $payslip_decimal_place); 
			            }	


					$philhealth_employer_share_text="(Employer Share : $philhealth_employer_share)";	
					$philhealth_rate_process="";
				}elseif($philhealth_deduction_type=="110"){ // rate total_monthly_contribution /2 
					$rate_value_total=$philhealth_formula_value*$ph_rate;
					$orig_rate_value_total=$philhealth_formula_value*$ph_rate;

					$philhealth_rate_process="$philhealth_formula_value * $ph_rate <br> $rate_value_total/2";
					$rate_value_total=$rate_value_total/2;

					$philhealth_employee_share=$rate_value_total;
					$philhealth_employer_share=$rate_value_total;
					
			            if($round_off_payslip=="yes"){// round off
			                $philhealth_employee_share=round($philhealth_employee_share, $payslip_decimal_place);
			                $philhealth_employer_share=round($philhealth_employer_share, $payslip_decimal_place);
			            }else{
			                $philhealth_employee_share=bcdiv($philhealth_employee_share, 1, $payslip_decimal_place); 
			                $philhealth_employer_share=bcdiv($philhealth_employer_share, 1, $payslip_decimal_place); 
			            }	
			            // check for case with decimal 
			           $assumed_ttl_contri=$philhealth_employee_share+$philhealth_employer_share;
			            //
			            
			            if($assumed_ttl_contri>$orig_rate_value_total){
							//echo "ok na ang total contribution";
			            }else{

			            	$for_employer_shoulder=$orig_rate_value_total-$assumed_ttl_contri;
			            	$philhealth_employer_share=$philhealth_employee_share+$for_employer_shoulder;
							
			            if($round_off_payslip=="yes"){// round off
			                $philhealth_employer_share=round($philhealth_employer_share, $payslip_decimal_place);
			            }else{
			                $philhealth_employer_share=bcdiv($philhealth_employer_share, 1, $payslip_decimal_place); 
			            }	

			            }

					$philhealth_employer_share_text="$philhealth_rate_process <br> (Employer Share : $philhealth_employer_share)";

				}else{// invalid philhealth type
					$philhealth_rate_process="";
					$philhealth_employee_share="";
					$philhealth_employer_share="";
					$philhealth_employer_share_text="notice: invalid philhealth type.";
				}

		//==============start take effect maximum contribution
		if($philhealth_deduct_on=="1"){// 1st cutoff deduction

		}elseif($philhealth_deduct_on=="2"){ // 2nd cutoff deduction

		}else{// per pay day
			
			$philhealth_gross=$philhealth_formula_value;

			$two_cutoff_employee_philhealth_share=$first_posted_philhealth_employee+$philhealth_employee_share; // employEE
			$two_cutoff_employer_philhealth_share=$first_posted_philhealth_employer+$philhealth_employer_share; // employER
			/*start for case per payday only. */
			$philhealth_maximum_contribution_employee=$philhealth_employee_share;
			$philhealth_maximum_contribution_employer=$philhealth_employee_share;
			/*end for case per payday only. */

				//== Check employEE max contri
				if($two_cutoff_employee_philhealth_share>$philhealth_maximum_contribution_employee){
					$philhealth_employee_share=$philhealth_maximum_contribution_employee-$first_posted_philhealth_employee;
						$max_ee_state=1; // true
				}else{
						$max_ee_state=0; // false
				}
				//== Check employER max contri
				if($two_cutoff_employer_philhealth_share>$philhealth_maximum_contribution_employer){
					$max_not_yet_applied_ph_er_share=$philhealth_employer_share;// maximum contri not yet applied employer share
					$philhealth_employer_share=$philhealth_maximum_contribution_employer-$first_posted_philhealth_employer;

					/*start for case per payday only. */
					$two_cutoff_employer_philhealth_share=$first_posted_philhealth_employer+$philhealth_employer_share; // employER
					/*end for case per payday only. */
					
					$max_limit_process="1st Cutoff ($first_posted_philhealth_employer)  + 2nd Cutoff($philhealth_employer_share) = $two_cutoff_employer_philhealth_share <br> Maximum Contribution is $philhealth_maximum_contribution_employer only therefore $philhealth_maximum_contribution_employer - $first_posted_philhealth_employer = $philhealth_employer_share <br>";

					$max_er_state=1;	// true
				}else{
					$max_er_state=0;	// false
				}
				if($max_ee_state==1 OR $max_er_state==1){
					$philhealth_employer_share_text="$philhealth_rate_process <br> $max_limit_process (Employer Share : $philhealth_employer_share)";
				}else{

				}
				
				
		}
		//==============end take effect maximum contribution


			}else{

				$philhealth_employee_share=0;
				$philhealth_employer_share=0;
				$philhealth_employer_share_text="";
				//$philhealth_gross=0;
			}

	}else{
			$philhealth_employee_share=0;
			$philhealth_employer_share=0;
			$philhealth_employer_share_text="";
			$philhealth_gross=0;
	}


            if($round_off_payslip=="yes"){// round off
                $philhealth_employee_share=round($philhealth_employee_share, $payslip_decimal_place);
                $philhealth_employer_share=round($philhealth_employer_share, $payslip_decimal_place);
                $philhealth_gross=round($philhealth_gross, $payslip_decimal_place);
            }else{
                $philhealth_employee_share=bcdiv($philhealth_employee_share, 1, $payslip_decimal_place); 
                $philhealth_employer_share=bcdiv($philhealth_employer_share, 1, $payslip_decimal_place); 
                $philhealth_gross=bcdiv($philhealth_gross, 1, $payslip_decimal_place); 
            }	


		//==============philhealth deduction at salary information setup if turned off.

if($salary_deduct_philhealth==0){
	
	$philhealth_employee_share=0;
	$philhealth_employer_share=0;
	$philhealth_formula_text="Philhealth Deduction is turned off.";
	$philhealth_employer_share_text="";
	$philhealth_gross=0;

}else{

}

		//==============no attendance.no basic income.

        if($is_salary_fixed=="1"){

        }else{


				if($no_attendance=="yes"){

					$philhealth_employee_share=0;
					$philhealth_employer_share=0;
					$philhealth_employer_share_text="";
					$philhealth_formula_text="";
					$philhealth_gross=0;

				}else{



				}



		}
//echo "HEY INSERT THIS $philhealth_gross ";

?>