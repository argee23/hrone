<?php
if($deduct_sss=="yes" OR $sss_deduct_on=="2"){
//============GET SSS GROSS
	if($sss_formula==""){// no formula for sss gross yet
	            	$sss_formula_text="Notice: No SSS Formula Setup Yet.";
	            	$sss_formula_value=0;
	}else{
					if(($active_pay_type=="2")OR($active_pay_type=="3")){// bi weekly or semi monhtly pay type

					}else{

					}

			        $sss_formula_text=str_replace("[","{",$sss_formula);
			        $sss_formula_text=str_replace("]","}",$sss_formula_text);
			        $sss_formula_text = $sss_formula_text;
			        $for_translation=$sss_formula_text;
			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $sss_formula_1st=str_replace("[","",$sss_formula);
			        $sss_formula_2nd=str_replace("]","",$sss_formula_1st);    
			        $sss_formula_3=$sss_formula_2nd;

			    /*every payday*/$sss_formula_text=$sss_formula_desc."<br> $for_translation";
			    /*every payday*/$sss_formula_value = eval('return '.$sss_formula_3.';');

				/*every 1stcutoff*/	if($sss_deduct_on=="1"){ 
											$sss_gross=$sss_formula_value;

											if($is_sss_netbasic_basis_fixed=="yes"){
						if($active_salary_rate=="3"){
												$sss_formula_value=($mysalary_amount*$mysalary_no_of_days_yearly)/12;
												$net_basic_means="(salary amount[$mysalary_amount] * no of days a year[$mysalary_no_of_days_yearly])/12";
												
						}else{
												$sss_formula_value=$net_basic_value*2;
												$net_basic_means="$net_basic_value*2";							
						}	

											}else{
												$sss_formula_value=$net_basic_value*2;
												$net_basic_means="$net_basic_value*2";
											}																						
											$sss_formula_text="1st Cut Off Deduction will base on net basic only : ".number_format($sss_formula_value,$payslip_decimal_place)." <i class='fa fa-arrow-left'></i>($net_basic_means)";
				/*every 2ndcutoff*/	}elseif($sss_deduct_on=="2"){

											$sss_gross=$sss_formula_value;
											$sss_formula_text=$sss_formula_text. "<br><br> Gross For SSS =  2nd cutoff SSS GROSS ($sss_formula_value) + 1st cutoff SSS GROSS ($first_posted_sss_gross)";
											$sss_formula_value+=$first_posted_sss_gross;
									}else{
											$sss_gross=$sss_formula_value+$first_posted_sss_gross; 
											$sss_formula_value=$sss_formula_value+$first_posted_sss_gross;
									}
				// == clear employER employEE contribution on : leave to save the sss gross as a ready value for 2nd cutoff computation	
				
				if(($deduct_sss=="no")AND($sss_deduct_on=="2")){
					$sss_formula_text="SSS Deduction is set on 2nd cutoff. <br> Current Cutoff SSS GROSS:( $sss_gross )";
				}else{

				}	
	}

}else{
					$sss_formula_value=0;
					$sss_formula_text="SSS Deduction is not on this cutoff.";

}

//============get sss maximum contribution
$sss_max_contri=$this->payroll_generate_payslip_model->get_sss_max_contri($company_id,$active_pay_type,$active_salary_rate,$year_cover);
if(!empty($sss_max_contri)){
	$sss_maximum_contribution_employee=$sss_max_contri->employee_maximum_contribution; // employEE
	$sss_maximum_contribution_employer=$sss_max_contri->employer_maximum_contribution; // employER
}else{
	$sss_maximum_contribution_employee=""; // employEE
	$sss_maximum_contribution_employer=""; // employER
}

//============get sss table
$sss_table=$this->payroll_generate_payslip_model->get_sss_table($company_id,$active_pay_type,$active_salary_rate,$year_cover,$sss_formula_value);

if(!empty($sss_table)){

	if($deduct_sss=="yes"){
		$sss_employee_share=$sss_table->ss_ee; // employEE
		$sss_employer_share=$sss_table->ss_er; // employER
		$sss_employer_share_ec=$sss_table->ec_er; // EC ER

if($cut_off=="2"){// c.o mam clarence
			if($first_posted_sss_employer_ec_er<$sss_employer_share_ec){//kulang pa yung ec last cutoff
				 $sss_employer_share_ec=$sss_employer_share_ec-$first_posted_sss_employer_ec_er;
			}elseif($first_posted_sss_employer_ec_er==$sss_employer_share_ec){//kulang pa yung ec last cutoff
				 $sss_employer_share_ec=0;// if enough na yung ec. dont put ec on this cutoff anymore.
			}else{
				
			}
}else{

}


		$sss_employer_share_text="(Employer Share : $sss_employer_share) <br> (EC : $sss_employer_share_ec)";	

		//==============take effect maximum contribution
		if($sss_deduct_on=="1"){// 1st cutoff deduction

		}elseif($sss_deduct_on=="2"){ // 2nd cutoff deduction

		}else{// per pay day


			$two_cutoff_employee_sss_share=$first_posted_sss_employee+$sss_employee_share; // employEE
			$two_cutoff_employer_sss_share=$first_posted_sss_employer+$sss_employer_share; // employER
				//== Check employEE max contri

			if($cut_off=="2"){


				if($sss_employee_share>$first_posted_sss_employee){
					


					$sss_employee_share=$sss_employee_share-$first_posted_sss_employee;
					$sss_employer_share=$sss_employer_share-$first_posted_sss_employer;//sss_employer_share_ec
					

					$sss_employer_share_text="(Employer Share : $sss_employer_share) <br> (EC : $sss_employer_share_ec)";
				
				}else{

				}
			}else{

			}

				// if($two_cutoff_employee_sss_share>$sss_maximum_contribution_employee){
				// 	$sss_employee_share=$sss_maximum_contribution_employee-$first_posted_sss_employee; 
					
				// 	if($sss_employee_share==0){
				// 		$sss_employer_share_text="Maximum contribution already reached.";
				// 		$sss_employer_share_ec=0;
				// 		$sss_formula_text="";
				// 	}else{

				// 	}
					
				// }else{

				// }
				//== Check employER max contri
				
				// hide me

				// if($two_cutoff_employer_sss_share>$sss_maximum_contribution_employer){
				// 	$sss_employer_share=$sss_maximum_contribution_employer-$first_posted_sss_employer;
				// }else{
				// }
		}



	}else{
		$sss_employee_share=0;
		$sss_employer_share=0;
		$sss_employer_share=0;
		$sss_employer_share_text="";	
		$sss_gross=0;
		$sss_employer_share_ec=0;
	}

	
}else{
		$sss_employee_share=0;
		$sss_employer_share=0;
		$sss_employer_share=0;
		$sss_employer_share_text="";
		$sss_gross=0;
		$sss_employer_share_ec=0;
}

		//==============sss deduction at salary information setup if turned off.

if($salary_deduct_sss==0){
	
	$sss_employee_share=0;
	$sss_employer_share=0;
	$sss_formula_text="SSS Deduction is turned off.";
	$sss_employer_share_text="";
	$sss_gross=0;
	$sss_employer_share_ec=0;

}else{

}

		//==============no attendance.no basic income.

        if($is_salary_fixed=="1"){

        }else{

			if($no_attendance=="yes"){

				$sss_employee_share=0;
				$sss_employer_share=0;
				$sss_formula_text="";
				$sss_employer_share_text="";
				$sss_gross=0;

			}else{



			}


        }



?>