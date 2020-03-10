<?php
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ABSENT        
            if($income_sum_formula==""){
            	$income_sum_formula_text="Notice: No Income Sum Up Formula Setup Yet.";
            	$income_sum_formula_value=0;
            }else{
			        $income_sum_formula_text=str_replace("[","{",$income_sum_formula);
			        $income_sum_formula_text=str_replace("]","}",$income_sum_formula_text);
			        $income_sum_formula_text = $income_sum_formula_text;
			        $for_translation=$income_sum_formula_text;
			        
			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $income_sum_formula_1st=str_replace("[","",$income_sum_formula);
			        $income_sum_formula_2nd=str_replace("]","",$income_sum_formula_1st);    
			        $income_sum_formula_3=$income_sum_formula_2nd;
			        
			    	$income_sum_formula_value = eval('return '.$income_sum_formula_3.';');

		            if($round_off_payslip=="yes"){// round off
		                $income_sum_formula_value=round($income_sum_formula_value, $payslip_decimal_place);
		            }else{
		                $income_sum_formula_value=bcdiv($income_sum_formula_value, 1, $payslip_decimal_place); 
		            }	

			    	
			    	$income_sum_formula_text=$income_sum_formula_desc."<br> $for_translation";  
            }
?>