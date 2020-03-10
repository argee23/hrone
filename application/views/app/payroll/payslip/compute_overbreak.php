<?php
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: overbreak        
            if($overbreak_formula==""){
            	$overbreak_formula_text="Notice: No overbreak Formula Setup Yet.";
            	$overbreak_formula_value=0;
            }else{

	  

			        $overbreak_formula_text=str_replace("[","{",$overbreak_formula);
			        $overbreak_formula_text=str_replace("]","}",$overbreak_formula_text);
			        $overbreak_formula_text = $overbreak_formula_text;
			        $for_translation=$overbreak_formula_text;

			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $overbreak_formula_1st=str_replace("[","",$overbreak_formula);
			        $overbreak_formula_2nd=str_replace("]","",$overbreak_formula_1st);    
			        $overbreak_formula_3=$overbreak_formula_2nd;
			    /**/$overbreak_formula_value = eval('return '.$overbreak_formula_3.';');

		            if($round_off_payslip=="yes"){// round off
		                $overbreak_formula_value=round($overbreak_formula_value, $payslip_decimal_place);
		            }else{
		                $overbreak_formula_value=bcdiv($overbreak_formula_value, 1, $payslip_decimal_place); 
		            }	
			    
			    /**/$overbreak_formula_text=$overbreak_formula_desc."<br> $for_translation";

			    		//echo $overbreak_formula_value;


					//==============no attendance.
        if($is_salary_fixed=="1"){
						$overbreak_formula_value=0;
						$overbreak_formula_text="Salary is Fixed.";
        }else{	  
					if($no_attendance=="yes"){
						$overbreak_formula_value=0;
						$overbreak_formula_text="";
					}else{

					}	            
		}
            }
?>