<?php
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: undertime        
            if($ut_formula==""){
            	$undertime_formula_text="Notice: No undertime Formula Setup Yet.";
            	$undertime_formula_value=0;
            }else{

	    
			        $undertime_formula_text=str_replace("[","{",$ut_formula);
			        $undertime_formula_text=str_replace("]","}",$undertime_formula_text);
			        $undertime_formula_text = $undertime_formula_text;
			        $for_translation=$undertime_formula_text;
			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $undertime_formula_1st=str_replace("[","",$ut_formula);
			        $undertime_formula_2nd=str_replace("]","",$undertime_formula_1st);    
			        $undertime_formula_3=$undertime_formula_2nd;

			    /**/$undertime_formula_value = eval('return '.$undertime_formula_3.';');

		            if($round_off_payslip=="yes"){// round off
		                $undertime_formula_value=round($undertime_formula_value, $payslip_decimal_place);
		            }else{
		                $undertime_formula_value=bcdiv($undertime_formula_value, 1, $payslip_decimal_place); 
		            }	

			    /**/$undertime_formula_text=$ut_formula_desc."<br> $for_translation";

			    		//echo $undertime_formula_value;

					//==============no attendance.
        if($is_salary_fixed=="1"){
						$undertime_formula_value=0;
						$undertime_formula_text="Salary is Fixed.";
        }else{	  
					if($no_attendance=="yes"){
						$undertime_formula_value=0;
						$undertime_formula_text="";
					}else{

					}	 
		}	            

            }



?>