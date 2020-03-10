<?php

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ABSENT        
            if($absent_formula==""){
            	$absent_formula_text="Notice: No Absent Formula Setup Yet.";
            	$absent_formula_value=0;
            }else{
					if($im_compress=="1"){
						$absent_formula="[$hourly_value] * [$absences_total]";
						$absent_formula_desc="Total Absent =  HOURLY RATE * ABSENT TOTAL";
					}else{}

			        $absent_formula_text=str_replace("[","{",$absent_formula);
			        $absent_formula_text=str_replace("]","}",$absent_formula_text);
			        $absent_formula_text = $absent_formula_text;
			        $for_translation=$absent_formula_text;
			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $absent_formula_1st=str_replace("[","",$absent_formula);
			        $absent_formula_2nd=str_replace("]","",$absent_formula_1st);    
			        $absent_formula_3=$absent_formula_2nd;

			    /**/$absent_formula_value = eval('return '.$absent_formula_3.';');

		            if($round_off_payslip=="yes"){// round off
		                $absent_formula_value=round($absent_formula_value, $payslip_decimal_place);
		            }else{
		                $absent_formula_value=bcdiv($absent_formula_value, 1, $payslip_decimal_place); 
		            }	

			    	/**/$absent_formula_text=$absent_formula_desc."<br> $for_translation";

			        if($is_salary_fixed=="1"){
			        				$absent_formula_value=0;
			        				$absent_formula_text="Salary is Fixed.";
			        }else{	            
								if($no_attendance=="yes"){
									$absent_formula_text="Total Basic ($net_basic_value)";
									$absent_formula_value=$net_basic_value;//$absences_total*$mysalary_amount;
								}else{
								}

					}

            }

?>