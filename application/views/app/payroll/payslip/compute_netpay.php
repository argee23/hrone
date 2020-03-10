<?php
$nonpriority_loan_text="";

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ABSENT        
            if($net_pay_formula==""){
            	$net_pay_formula_text="Notice: No Net Pay Formula Setup Yet.";
            	$net_pay_formula_value=0;
            }else{

            	if($gross_formula){

			        $net_pay_formula_text=str_replace("[","{",$net_pay_formula);
			        $net_pay_formula_text=str_replace("]","}",$net_pay_formula_text);
			        $net_pay_formula_text = $net_pay_formula_text;
			        $for_translation=$net_pay_formula_text;
			        
			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $net_pay_formula_1st=str_replace("[","",$net_pay_formula);
			        $net_pay_formula_2nd=str_replace("]","",$net_pay_formula_1st);    
			        $net_pay_formula_3=$net_pay_formula_2nd;

			    /**/$net_pay_formula_value = eval('return '.$net_pay_formula_3.';');

		            if($round_off_payslip=="yes"){// round off
		                $net_pay_formula_value=round($net_pay_formula_value, $payslip_decimal_place);
		            }else{
		                $net_pay_formula_value=bcdiv($net_pay_formula_value, 1, $payslip_decimal_place); 
		            }	

			    
			    /**/$net_pay_formula_text=$net_pay_formula_desc."<br> $for_translation";

	if(($net_pay_formula_value<0)AND($total_loan>0) AND($auto_netpay_adjust_setting=="Automatically dont deduct loans" OR $auto_netpay_adjust_setting=="Automatically dont deduct loan AND other deduction") ){


						 $loan_auto_adjust="yes";
						 $net_pay_formula_value=$net_pay_formula_value+$total_loan;
						 $deduction_sum_formula_value= $deduction_sum_formula_value-$total_loan;
						 $loan_text="$loan_text Above suppose to be Loan(s) is automatically not deducted as per setup due to negative net pay result if it will be deducted.";
						 $total_loan=0;

			
	}else{// end // if with loan & netpay result to negative value


	}    	
	    
            	}else{
            		$net_pay_formula_value=0;
            		$net_pay_formula_text="notice : cannot compute netpay. no gross formula reference setup yet..";
            		//echo "useless";
            	}

            }

// ========
if($net_pay_formula_value<0){
			if($auto_netpay_adjust_setting=="Automatically dont deduct loan AND other deduction" OR $auto_netpay_adjust_setting=="Automatically dont deduct other deductions"){

			if($total_taxable_od>0 OR $total_nontaxable_od>0){
				$virtual_taxable_od=$total_taxable_od;
				$virtual_nontaxable_od=$total_nontaxable_od;

				$total_taxable_od=0; $total_nontaxable_od=0;

				if($ode_taxable_list){
					$ode_taxable_list="$ode_taxable_list <br> Above suppose to be other deduction is automatically not deducted as per setup due negative net pay result if it will be deducted.";
				}else{

				}
				if($ode_nontaxable_list){
					$ode_nontaxable_list="$ode_nontaxable_list <br> Above suppose to be other deduction is automatically not deducted as per setup due negative net pay result if it will be deducted.";
				}else{

				}

				if($auto_ode_taxable_list){
					$auto_ode_taxable_list="$auto_ode_taxable_list <br> Above suppose to be other deduction is automatically not deducted as per setup due negative net pay result if it will be deducted.";
				}else{
					
				}
				if($auto_ode_nontaxable_list){
					$auto_ode_nontaxable_list="$auto_ode_nontaxable_list <br> Above suppose to be other deduction is automatically not deducted as per setup due negative net pay result if it will be deducted.";
				}else{
					
				}
			}else{

			}

			$net_pay_formula_value=$net_pay_formula_value+$virtual_taxable_od+$virtual_nontaxable_od;
			// give back other suppose to be other deductions	

			}elseif($auto_netpay_adjust_setting=="Deduct Loans EXCEPT tagged as priority deduction"){
				
					$net_pay_formula_value=$net_pay_formula_value+$total_loan; // deduct orig loans 

				   require(APPPATH.'views/app/payroll/payslip/check_priority_deduction.php');

				    $net_pay_formula_value=$net_pay_formula_value-$total_loan; // 
				
			}else{

			}
//====================start recompute netpay due to priority deduction		
			        $fin_net_pay_formula_text=str_replace("[","{",$net_pay_formula);
			        $fin_net_pay_formula_text=str_replace("]","}",$fin_net_pay_formula_text);
			        $fin_net_pay_formula_text = $fin_net_pay_formula_text;
			        $for_translation=$fin_net_pay_formula_text;
			        
			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $fin_net_pay_formula_1st=str_replace("[","",$net_pay_formula);
			        $fin_net_pay_formula_2nd=str_replace("]","",$fin_net_pay_formula_1st);    
			        $fin_net_pay_formula_3=$fin_net_pay_formula_2nd;

			    /**/$net_pay_formula_value = eval('return '.$fin_net_pay_formula_3.';');

		            if($round_off_payslip=="yes"){// round off
		                $net_pay_formula_value=round($net_pay_formula_value, $payslip_decimal_place);
		            }else{
		                $net_pay_formula_value=bcdiv($net_pay_formula_value, 1, $payslip_decimal_place); 
		            }	

			    
			    /**/$net_pay_formula_text=$net_pay_formula_desc."<br> $for_translation";
//====================end recompute netpay due to priority deduction	

}else{

}
// ========



if($minimum_netpay_to_post>$net_pay_formula_value){
	$proceed_posting="no";
	$proceed_posting_reason="Minimum net pay to post payslip is ($minimum_netpay_to_post).";
}else{

	if($net_pay_formula==""){
		$proceed_posting="no";
		$proceed_posting_reason="$net_pay_formula_text";		
	}else{
		$proceed_posting="yes";
		$proceed_posting_reason="";
	}

}




//echo " $net_pay_formula_value";
?>