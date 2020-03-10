<?php
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: LATE        
            if($late_formula==""){
            	$late_formula_text="Notice: No Late Formula Setup Yet.";
            	$late_formula_value=0;
            }else{

			        $late_formula_text=str_replace("[","{",$late_formula);
			        $late_formula_text=str_replace("]","}",$late_formula_text);
			        $late_formula_text = $late_formula_text;
			        $for_translation=$late_formula_text;
			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $late_formula_1st=str_replace("[","",$late_formula);
			        $late_formula_2nd=str_replace("]","",$late_formula_1st);    
			        $late_formula_3=$late_formula_2nd;

			    /**/$late_formula_value = eval('return '.$late_formula_3.';');

		            if($round_off_payslip=="yes"){// round off
		                $late_formula_value=round($late_formula_value, $payslip_decimal_place);
		            }else{
		                $late_formula_value=bcdiv($late_formula_value, 1, $payslip_decimal_place); 
		            }	

			    /**/$late_formula_text=$late_formula_desc."<br> $for_translation";

			    		//echo $late_formula_value;
	    
					//==============no attendance.
        if($is_salary_fixed=="1"){
						$late_formula_value=0;
						$late_formula_text="Salary is Fixed.";
        }else{	  
					if($no_attendance=="yes"){
						$late_formula_value=0;
						$late_formula_text="";
					}else{

					}

					if($lateExempted=="yes"){
						$late_formula_value="0";
						$late_formula_text="exempted";
					}else{

					}

		}

            }






?>