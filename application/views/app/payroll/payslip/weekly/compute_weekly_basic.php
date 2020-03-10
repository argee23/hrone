<?php
//=========================================================== START BASIC DISPLAY

            $basic_formula_text=str_replace("[","{",$net_basic_formula);
            $basic_formula_text=str_replace("]","}",$basic_formula_text);
            $basic_formula_text = $basic_formula_text;
            $for_translation=$basic_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $net_basic_formula_1st=str_replace("[","",$net_basic_formula);
            $net_basic_formula_2nd=str_replace("]","",$net_basic_formula_1st);    
            $net_basic_formula_3=$net_basic_formula_2nd;

        /**/$net_basic_value = eval('return '.$net_basic_formula_3.';');

                    if($round_off_payslip=="yes"){// round off
                        $net_basic_value=round($net_basic_value, $payslip_decimal_place);
                    }else{// cut only
                        $net_basic_value=bcdiv($net_basic_value, 1, $payslip_decimal_place); 
                    }

        /**/$basic_formula_text=$net_basic_formula_desc."<br> $for_translation";
            // }

            $hourly_value=$mysalary_amount/$mysalary_no_of_hours;

            if($round_off_payslip=="yes"){// round off
                $hourly_value=round($hourly_value, $compensation_initial_decimal_place);
            }else{
                $hourly_value=bcdiv($hourly_value, 1, $compensation_initial_decimal_place); 
            }


            $hourly_formula_text='HOURLY RATE( '.$hourly_value.' )=( '.$mysalary_amount.' / '.$mysalary_no_of_hours.')';
            $daily_rate=$mysalary_amount;

            if($round_off_payslip=="yes"){// round off
                $daily_rate=round($daily_rate, $compensation_initial_decimal_place);
            }else{
                $daily_rate=bcdiv($daily_rate, 1, $compensation_initial_decimal_place); 
            }
            $leave_basic_equivalent=$leave_reg_hrs*$daily_rate;
            $daily_formula='DAILY RATE ='. $daily_rate .'';

//=========================================================== END BASIC DISPLAY
?>