<?php
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: GROSS            
            if($gross_formula==""){
            	$gross_formula_value=0;
            }else{

	  

			        $gross_formula_text=str_replace("[","{",$gross_formula);
			        $gross_formula_text=str_replace("]","}",$gross_formula_text);
			        $gross_formula_text = $gross_formula_text;
			        $for_translation=$gross_formula_text;
			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $gross_formula_1st=str_replace("[","",$gross_formula);
			        $gross_formula_2nd=str_replace("]","",$gross_formula_1st);    
			        $gross_formula_3=$gross_formula_2nd;
			    /**/$gross_formula_value = eval('return '.$gross_formula_3.';');
			    /**/$gross_formula_text=$gross_formula_desc."<br> $for_translation";

			    	//echo $gross_formula_value;
	 
            if($round_off_payslip=="yes"){// round off
                $gross_formula_value=round($gross_formula_value, $payslip_decimal_place);
            }else{
                $gross_formula_value=bcdiv($gross_formula_value, 1, $payslip_decimal_place); 
            }


            }
?>