<?php
            if($cola_formula){
                $cola_formula = preg_replace('/(?<=\d)\s+(?=\d)/', '', $cola_formula); // remove space
                    $cola_formula_text=str_replace("[","{",$cola_formula);
                    $cola_formula_text=str_replace("]","}",$cola_formula_text);
                    $cola_formula_text = $cola_formula_text;
                    $for_translation=$cola_formula_text;
                    require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
                    $cola_formula_1st=str_replace("[","",$cola_formula);
                    $cola_formula_2nd=str_replace("]","",$cola_formula_1st);    
                    $cola_formula_3=$cola_formula_2nd;
                /**/$cola_formula_value = eval('return '.$cola_formula_3.';');
                /**/$cola_formula_text=$cola_formula_desc."<br> $for_translation";
                    $total_cola_amount=$cola_formula_value;


            if($round_off_payslip=="yes"){// round off
                $total_cola_amount=round($total_cola_amount, $payslip_decimal_place);
            }else{
                $total_cola_amount=bcdiv($total_cola_amount, 1, $payslip_decimal_place); 
            }

                    
            }else{
                $total_cola_amount=0;
                $cola_formula_value=0;
                $cola_formula_text=0;
            }


?>