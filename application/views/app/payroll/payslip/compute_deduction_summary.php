<?php

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ABSENT        
            if($deduction_sum_formula==""){
            	$deduction_sum_formula_text="Notice: No Income Sum Up Formula Setup Yet.";
            	$deduction_sum_formula_value=0;
            }else{
			        $deduction_sum_formula_text=str_replace("[","{",$deduction_sum_formula);
			        $deduction_sum_formula_text=str_replace("]","}",$deduction_sum_formula_text);
			        $deduction_sum_formula_text = $deduction_sum_formula_text;
			        $for_translation=$deduction_sum_formula_text;
			        
			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $deduction_sum_formula_1st=str_replace("[","",$deduction_sum_formula);
			        $deduction_sum_formula_2nd=str_replace("]","",$deduction_sum_formula_1st);    
			        $deduction_sum_formula_3=$deduction_sum_formula_2nd;
			        
			    	$deduction_sum_formula_value = eval('return '.$deduction_sum_formula_3.';');

		            if($round_off_payslip=="yes"){// round off
		                $deduction_sum_formula_value=round($deduction_sum_formula_value, $payslip_decimal_place);
		            }else{
		                $deduction_sum_formula_value=bcdiv($deduction_sum_formula_value, 1, $payslip_decimal_place); 
		            }	

			    	$deduction_sum_formula_text=$deduction_sum_formula_desc."<br> $for_translation";  
            }
?>