<style type="text/css">
    .immediateNotice{
        color:#ff0000;
        font-weight: bold;
    }
</style>
<?php
//regot_withnd_rate : for working schedule ND

            $overtime_with_value_stand_out="immediateNotice";


                                            //::::::::::::::::::::::: WORKING SCHEDULE ND: total_regular_nd is total_working_schedule_nd
            $ws_nd_formula_text=str_replace("[","{",$ot_formula);
            $ws_nd_formula_text=str_replace("]","}",$ws_nd_formula_text);
        /**/$ws_nd_formula_text=str_replace("total_overtime","total_regular_nd",$ws_nd_formula_text); 
        /**/$ws_nd_formula_text=str_replace("ot_table_rate","regot_withnd_rate",$ws_nd_formula_text);  
            $ws_nd_formula_text = $ws_nd_formula_text;
            $for_translation=$ws_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $ws_nd_formula_1st=str_replace("[","",$ot_formula);
            $ws_nd_formula_2nd=str_replace("]","",$ws_nd_formula_1st);    
        /**/$ws_nd_formula_2nd=str_replace("total_overtime","total_regular_nd",$ws_nd_formula_2nd);  
        /**/$ws_nd_formula_text=str_replace("ot_table_rate","regot_withnd_rate",$ws_nd_formula_2nd);   
            $ws_nd_value_raw=$ws_nd_formula_text;
        /**/$ws_nd_value = eval('return '.$ws_nd_value_raw.';');
        /**/$ws_nd_formula_text="<i>(Working Schedule Night Diff)</i> <i class='fa fa-arrow-right'></i> $for_translation = $ws_nd_value";

            //echo "HEY $total_regular_nd * $hourly_value * $regot_withnd_rate  = $ws_nd_value <br>";


                                            //::::::::::::::::::::::: OVERTIME: total_regular_overtime
            $regot_formula_text=str_replace("[","{",$ot_formula);
            $regot_formula_text=str_replace("]","}",$regot_formula_text);
        /**/$regot_formula_text=str_replace("total_overtime","total_regular_overtime",$regot_formula_text); 
        /**/$regot_formula_text=str_replace("ot_table_rate","regot_with_out_nd_rate",$regot_formula_text);  
            $regot_formula_text = $regot_formula_text;
            $for_translation=$regot_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $regot_formula_1st=str_replace("[","",$ot_formula);
            $regot_formula_2nd=str_replace("]","",$regot_formula_1st);    
        /**/$regot_formula_2nd=str_replace("total_overtime","total_regular_overtime",$regot_formula_2nd);  
        /**/$regot_formula_text=str_replace("ot_table_rate","regot_with_out_nd_rate",$regot_formula_2nd);   
            $regot_value_raw=$regot_formula_text;
        /**/$regot_value = eval('return '.$regot_value_raw.';');

            if($regot_value>0){
                $regot_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $regot_value_formula_text_class="";
            }

        /**/$regot_formula_text="<i class='$regot_value_formula_text_class'>(Regular Overtime without ND)</i> <i class='fa fa-arrow-right $regot_value_formula_text_class'> $for_translation = $regot_value</i>";
            //echo "check:". $regot_formula_text." = ".$regot_value;
                                            //::::::::::::::::::::::: OVERTIME: total_regular_overtime_nd
            $regotnd_formula_text=str_replace("[","{",$ot_formula);
            $regotnd_formula_text=str_replace("]","}",$regotnd_formula_text);
        /**/$regotnd_formula_text=str_replace("total_overtime","total_regular_overtime_nd",$regotnd_formula_text); 
        /**/$regotnd_formula_text=str_replace("ot_table_rate","regot_withnd_rate",$regotnd_formula_text);  
            $regotnd_formula_text = $regotnd_formula_text;
            $for_translation=$regotnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $otnd_formula_1st=str_replace("[","",$ot_formula);
            $otnd_formula_2nd=str_replace("]","",$otnd_formula_1st);    
        /**/$otnd_formula_2nd=str_replace("total_overtime","total_regular_overtime_nd",$otnd_formula_2nd);  
        /**/$regotnd_formula_text=str_replace("ot_table_rate","regot_withnd_rate",$otnd_formula_2nd);   
            $regotnd_value_raw=$regotnd_formula_text;
        /**/$regotnd_value = eval('return '.$regotnd_value_raw.';');

            if($regotnd_value>0){
                $regotnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $regotnd_value_formula_text_class="";
            }

        /**/$regotnd_formula_text="<i  class='$regotnd_value_formula_text_class'>(Regular Overtime with ND)</i> <i class='fa fa-arrow-right $regotnd_value_formula_text_class'> $for_translation = $regotnd_value</i>";
           //echo "check:". $regotnd_formula_text." = ".$regotnd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_regular_hrs_restday
            $rdot_with_out_nd_formula_text=str_replace("[","{",$ot_formula);
            $rdot_with_out_nd_formula_text=str_replace("]","}",$rdot_with_out_nd_formula_text);
        /**/$rdot_with_out_nd_formula_text=str_replace("total_overtime","total_regular_hrs_restday",$rdot_with_out_nd_formula_text); 
        /**/$rdot_with_out_nd_formula_text=str_replace("ot_table_rate","rdot_with_out_nd_rate",$rdot_with_out_nd_formula_text);  
            $rdot_with_out_nd_formula_text = $rdot_with_out_nd_formula_text;
            $for_translation=$rdot_with_out_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rdot_with_out_nd_formula_1st=str_replace("[","",$ot_formula);
            $rdot_with_out_nd_formula_2nd=str_replace("]","",$rdot_with_out_nd_formula_1st);    
        /**/$rdot_with_out_nd_formula_2nd=str_replace("total_overtime","total_regular_hrs_restday",$rdot_with_out_nd_formula_2nd);  
        /**/$rdot_with_out_nd_formula_text=str_replace("ot_table_rate","rdot_with_out_nd_rate",$rdot_with_out_nd_formula_2nd);   
            $rdot_with_out_nd_value_raw=$rdot_with_out_nd_formula_text;
        /**/$rdot_with_out_nd_value = eval('return '.$rdot_with_out_nd_value_raw.';');

            if($rdot_with_out_nd_value>0){
                $rdot_with_out_nd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rdot_with_out_nd_value_formula_text_class="";
            }

        /**/$rdot_with_out_nd_formula_text="<i class='$rdot_with_out_nd_value_formula_text_class'>(Rest Day Overtime without ND)</i> <i class='fa fa-arrow-right $rdot_with_out_nd_value_formula_text_class'> $for_translation = $rdot_with_out_nd_value </i>";
            
                                            //::::::::::::::::::::::: OVERTIME: total_restday_nd
            $rdot_withnd_formula_text=str_replace("[","{",$ot_formula);
            $rdot_withnd_formula_text=str_replace("]","}",$rdot_withnd_formula_text);
        /**/$rdot_withnd_formula_text=str_replace("total_overtime","total_restday_nd",$rdot_withnd_formula_text); 
        /**/$rdot_withnd_formula_text=str_replace("ot_table_rate","rdot_withnd_rate",$rdot_withnd_formula_text);  
            $rdot_withnd_formula_text = $rdot_withnd_formula_text;
            $for_translation=$rdot_withnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rdot_withnd_formula_1st=str_replace("[","",$ot_formula);
            $rdot_withnd_formula_2nd=str_replace("]","",$rdot_withnd_formula_1st);    
        /**/$rdot_withnd_formula_2nd=str_replace("total_overtime","total_restday_nd",$rdot_withnd_formula_2nd);  
        /**/$rdot_withnd_formula_text=str_replace("ot_table_rate","rdot_withnd_rate",$rdot_withnd_formula_2nd);   
            $rdot_withnd_value_raw=$rdot_withnd_formula_text;
        /**/$rdot_withnd_value = eval('return '.$rdot_withnd_value_raw.';');

            if($rdot_withnd_value>0){
                $rdot_withnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rdot_withnd_value_formula_text_class="";
            }

        /**/$rdot_withnd_formula_text="<i class='$rdot_withnd_value_formula_text_class'>(Rest Day Overtime with ND)</i> <i class='fa fa-arrow-right $rdot_withnd_value_formula_text_class'> $for_translation = $rdot_withnd_value</i>";
            //echo "check:". $rdot_withnd_formula_text." = ".$rdot_withnd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_restday_overtime
            $rdot_ot_with_out_nd_formula_text=str_replace("[","{",$ot_formula);
            $rdot_ot_with_out_nd_formula_text=str_replace("]","}",$rdot_ot_with_out_nd_formula_text);
        /**/$rdot_ot_with_out_nd_formula_text=str_replace("total_overtime","total_restday_overtime",$rdot_ot_with_out_nd_formula_text); 
        /**/$rdot_ot_with_out_nd_formula_text=str_replace("ot_table_rate","rdot_ot_with_out_nd_rate",$rdot_ot_with_out_nd_formula_text);  
            $rdot_ot_with_out_nd_formula_text = $rdot_ot_with_out_nd_formula_text;
            $for_translation=$rdot_ot_with_out_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rdot_ot_with_out_nd_formula_1st=str_replace("[","",$ot_formula);
            $rdot_ot_with_out_nd_formula_2nd=str_replace("]","",$rdot_ot_with_out_nd_formula_1st);    
        /**/$rdot_ot_with_out_nd_formula_2nd=str_replace("total_overtime","total_restday_overtime",$rdot_ot_with_out_nd_formula_2nd);  
        /**/$rdot_ot_with_out_nd_formula_text=str_replace("ot_table_rate","rdot_ot_with_out_nd_rate",$rdot_ot_with_out_nd_formula_2nd);   
            $rdot_ot_with_out_nd_value_raw=$rdot_ot_with_out_nd_formula_text;
        /**/$rdot_ot_with_out_nd_value = eval('return '.$rdot_ot_with_out_nd_value_raw.';');

            if($rdot_ot_with_out_nd_value>0){
                $rdot_ot_with_out_nd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rdot_ot_with_out_nd_value_formula_text_class="";
            }

        /**/$rdot_ot_with_out_nd_formula_text="<i class='$rdot_ot_with_out_nd_value_formula_text_class'>(Rest Day Overtime-OT without ND)</i> <i class='fa fa-arrow-right $rdot_ot_with_out_nd_value_formula_text_class'> $for_translation = $rdot_ot_with_out_nd_value</i>";
            //echo "check:". $rdot_ot_with_out_nd_formula_text." = ".$rdot_ot_with_out_nd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_restday_overtime_nd
            $rdot_ot_withnd_formula_text=str_replace("[","{",$ot_formula);
            $rdot_ot_withnd_formula_text=str_replace("]","}",$rdot_ot_withnd_formula_text);
        /**/$rdot_ot_withnd_formula_text=str_replace("total_overtime","total_restday_overtime_nd",$rdot_ot_withnd_formula_text); 
        /**/$rdot_ot_withnd_formula_text=str_replace("ot_table_rate","rdot_ot_withnd_rate",$rdot_ot_withnd_formula_text);  
            $rdot_ot_withnd_formula_text = $rdot_ot_withnd_formula_text;
            $for_translation=$rdot_ot_withnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rdot_ot_withnd_formula_1st=str_replace("[","",$ot_formula);
            $rdot_ot_withnd_formula_2nd=str_replace("]","",$rdot_ot_withnd_formula_1st);    
        /**/$rdot_ot_withnd_formula_2nd=str_replace("total_overtime","total_restday_overtime_nd",$rdot_ot_withnd_formula_2nd);  
        /**/$rdot_ot_withnd_formula_text=str_replace("ot_table_rate","rdot_ot_withnd_rate",$rdot_ot_withnd_formula_2nd);   
            $rdot_ot_withnd_value_raw=$rdot_ot_withnd_formula_text;
        /**/$rdot_ot_withnd_value = eval('return '.$rdot_ot_withnd_value_raw.';');

            if($rdot_ot_withnd_value>0){
                $rdot_ot_withnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rdot_ot_withnd_value_formula_text_class="";
            }

        /**/$rdot_ot_withnd_formula_text="<i class='$rdot_ot_withnd_value_formula_text_class'>(Rest Day Overtime-OT with ND)</i> <i class='fa fa-arrow-right $rdot_ot_withnd_value_formula_text_class'> $for_translation = $rdot_ot_withnd_value</i>";
            //echo "check:". $rdot_ot_withnd_formula_text." = ".$rdot_ot_withnd_value;


                                            //::::::::::::::::::::::: OVERTIME: total_regular_hrs_reg_holiday
            $rhot_with_out_nd_formula_text=str_replace("[","{",$ot_formula);
            $rhot_with_out_nd_formula_text=str_replace("]","}",$rhot_with_out_nd_formula_text);
        /**/$rhot_with_out_nd_formula_text=str_replace("total_overtime","total_regular_hrs_reg_holiday",$rhot_with_out_nd_formula_text); 
        /**/$rhot_with_out_nd_formula_text=str_replace("ot_table_rate","rhot_with_out_nd_rate",$rhot_with_out_nd_formula_text);  
            $rhot_with_out_nd_formula_text = $rhot_with_out_nd_formula_text;
            $for_translation=$rhot_with_out_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rhot_with_out_nd_formula_1st=str_replace("[","",$ot_formula);
            $rhot_with_out_nd_formula_2nd=str_replace("]","",$rhot_with_out_nd_formula_1st);    
        /**/$rhot_with_out_nd_formula_2nd=str_replace("total_overtime","total_regular_hrs_reg_holiday",$rhot_with_out_nd_formula_2nd);  
        /**/$rhot_with_out_nd_formula_text=str_replace("ot_table_rate","rhot_with_out_nd_rate",$rhot_with_out_nd_formula_2nd);   
            $rhot_with_out_nd_value_raw=$rhot_with_out_nd_formula_text;
        /**/$rhot_with_out_nd_value = eval('return '.$rhot_with_out_nd_value_raw.';');
            if($rhot_with_out_nd_value>0){
                $rhot_with_out_nd_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rhot_with_out_nd_formula_text_class="";
            }
        /**/$rhot_with_out_nd_formula_text="<i class='$rhot_with_out_nd_formula_text_class'>(Regular Holiday Overtime without ND)</i> <i class='fa fa-arrow-right $rhot_with_out_nd_formula_text_class'> $for_translation = $rhot_with_out_nd_value</i>";
            //echo "check:". $rhot_with_out_nd_formula_text." = ".$rhot_with_out_nd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_reg_holiday_nd
            $rhot_withnd_formula_text=str_replace("[","{",$ot_formula);
            $rhot_withnd_formula_text=str_replace("]","}",$rhot_withnd_formula_text);
        /**/$rhot_withnd_formula_text=str_replace("total_overtime","total_reg_holiday_nd",$rhot_withnd_formula_text); 
        /**/$rhot_withnd_formula_text=str_replace("ot_table_rate","rhot_withnd_rate",$rhot_withnd_formula_text);  
            $rhot_withnd_formula_text = $rhot_withnd_formula_text;
            $for_translation=$rhot_withnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rhot_withnd_formula_1st=str_replace("[","",$ot_formula);
            $rhot_withnd_formula_2nd=str_replace("]","",$rhot_withnd_formula_1st);    
        /**/$rhot_withnd_formula_2nd=str_replace("total_overtime","total_reg_holiday_nd",$rhot_withnd_formula_2nd);  
        /**/$rhot_withnd_formula_text=str_replace("ot_table_rate","rhot_withnd_rate",$rhot_withnd_formula_2nd);   
            $rhot_withnd_value_raw=$rhot_withnd_formula_text;
        /**/$rhot_withnd_value = eval('return '.$rhot_withnd_value_raw.';');

            if($rhot_withnd_value>0){
                $rhot_withnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rhot_withnd_value_formula_text_class="";
            }

        /**/$rhot_withnd_formula_text="<i class='$rhot_withnd_value_formula_text_class'>(Regular Holiday Overtime with ND)</i> <i class='fa fa-arrow-right $rhot_withnd_value_formula_text_class'> $for_translation = $rhot_withnd_value</i>";
            //echo "check:". $rhot_withnd_formula_text." = ".$rhot_withnd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_reg_holiday_overtime
            $rhot_ot_with_out_nd_formula_text=str_replace("[","{",$ot_formula);
            $rhot_ot_with_out_nd_formula_text=str_replace("]","}",$rhot_ot_with_out_nd_formula_text);
        /**/$rhot_ot_with_out_nd_formula_text=str_replace("total_overtime","total_reg_holiday_overtime",$rhot_ot_with_out_nd_formula_text); 
        /**/$rhot_ot_with_out_nd_formula_text=str_replace("ot_table_rate","rhot_ot_with_out_nd_rate",$rhot_ot_with_out_nd_formula_text);  
            $rhot_ot_with_out_nd_formula_text = $rhot_ot_with_out_nd_formula_text;
            $for_translation=$rhot_ot_with_out_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rhot_ot_with_out_nd_formula_1st=str_replace("[","",$ot_formula);
            $rhot_ot_with_out_nd_formula_2nd=str_replace("]","",$rhot_ot_with_out_nd_formula_1st);    
        /**/$rhot_ot_with_out_nd_formula_2nd=str_replace("total_overtime","total_reg_holiday_overtime",$rhot_ot_with_out_nd_formula_2nd);  
        /**/$rhot_ot_with_out_nd_formula_text=str_replace("ot_table_rate","rhot_ot_with_out_nd_rate",$rhot_ot_with_out_nd_formula_2nd);   
            $rhot_ot_with_out_nd_value_raw=$rhot_ot_with_out_nd_formula_text;
        /**/$rhot_ot_with_out_nd_value = eval('return '.$rhot_ot_with_out_nd_value_raw.';');

            if($rhot_ot_with_out_nd_value>0){
                $rhot_ot_with_out_nd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rhot_ot_with_out_nd_value_formula_text_class="";
            }

        /**/$rhot_ot_with_out_nd_formula_text="<i class='$rhot_ot_with_out_nd_value_formula_text_class'>(Regular Holiday Overtime-OT without ND)</i> <i class='fa fa-arrow-right $rhot_ot_with_out_nd_value_formula_text_class'> $for_translation = $rhot_ot_with_out_nd_value</i>";
            //echo "check:". $rhot_ot_with_out_nd_formula_text." = ".$rhot_ot_with_out_nd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_reg_holiday_overtime_nd
            $rhot_ot_withnd_formula_text=str_replace("[","{",$ot_formula);
            $rhot_ot_withnd_formula_text=str_replace("]","}",$rhot_ot_withnd_formula_text);
        /**/$rhot_ot_withnd_formula_text=str_replace("total_overtime","total_reg_holiday_overtime_nd",$rhot_ot_withnd_formula_text); 
        /**/$rhot_ot_withnd_formula_text=str_replace("ot_table_rate","rhot_ot_withnd_rate",$rhot_ot_withnd_formula_text);  
            $rhot_ot_withnd_formula_text = $rhot_ot_withnd_formula_text;
            $for_translation=$rhot_ot_withnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rhot_ot_withnd_formula_1st=str_replace("[","",$ot_formula);
            $rhot_ot_withnd_formula_2nd=str_replace("]","",$rhot_ot_withnd_formula_1st);    
        /**/$rhot_ot_withnd_formula_2nd=str_replace("total_overtime","total_reg_holiday_overtime_nd",$rhot_ot_withnd_formula_2nd);  
        /**/$rhot_ot_withnd_formula_text=str_replace("ot_table_rate","rhot_ot_withnd_rate",$rhot_ot_withnd_formula_2nd);   
            $rhot_ot_withnd_value_raw=$rhot_ot_withnd_formula_text;
        /**/$rhot_ot_withnd_value = eval('return '.$rhot_ot_withnd_value_raw.';');

            if($rhot_ot_withnd_value>0){
                $rhot_ot_withnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rhot_ot_withnd_value_formula_text_class="";
            }

        /**/$rhot_ot_withnd_formula_text="<i class='$rhot_ot_withnd_value_formula_text_class'>(Regular Holiday Overtime-OT with ND)</i> <i class='fa fa-arrow-right $rhot_ot_withnd_value_formula_text_class'> $for_translation = $rhot_ot_withnd_value</i>";
            //echo "check:". $rhot_ot_withnd_formula_text." = ".$rhot_ot_withnd_value;

                                            //::::::::::::::::::::::: OVERTIME: total_regular_hrs_reg_holiday_t2 (this is for no attendance)
            $rh_rdt2_formula_text=str_replace("[","{",$ot_formula);
            $rh_rdt2_formula_text=str_replace("]","}",$rh_rdt2_formula_text);
        /**/$rh_rdt2_formula_text=str_replace("total_overtime","total_regular_hrs_reg_holiday_t2",$rh_rdt2_formula_text); 
        /**/$rh_rdt2_formula_text=str_replace("ot_table_rate","rh_rdt2_ot_with_out_nd_rate",$rh_rdt2_formula_text);  
            $rh_rdt2_formula_text = $rh_rdt2_formula_text;
            $for_translation=$rh_rdt2_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rh_rdt2_formula_1st=str_replace("[","",$ot_formula);
            $rh_rdt2_formula_2nd=str_replace("]","",$rh_rdt2_formula_1st);    
        /**/$rh_rdt2_formula_2nd=str_replace("total_overtime","total_regular_hrs_reg_holiday_t2",$rh_rdt2_formula_2nd);  
        /**/$rh_rdt2_formula_text=str_replace("ot_table_rate","rh_rdt2_ot_with_out_nd_rate",$rh_rdt2_formula_2nd);   
            $rh_rdt2_value_raw=$rh_rdt2_formula_text;
        /**/$rh_rdt2_value = eval('return '.$rh_rdt2_value_raw.';');

            if($rh_rdt2_value>0){
                $rh_rdt2_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rh_rdt2_value_formula_text_class="";
            }

        /**/$rh_rdt2_formula_text="<i class='$rh_rdt2_value_formula_text_class'>(Regular Holiday/Rest day no attendance)</i> <i class='fa fa-arrow-right $rh_rdt2_value_formula_text_class'> $for_translation = $rh_rdt2_value</i>";
            //echo "check:". $rh_rdt2_formula_text." = ".$rh_rdt2_value;

                                            //::::::::::::::::::::::: OVERTIME: total_regular_hrs_reg_holiday_t1
            $rh_rdt1_ot_with_out_nd_formula_text=str_replace("[","{",$ot_formula);
            $rh_rdt1_ot_with_out_nd_formula_text=str_replace("]","}",$rh_rdt1_ot_with_out_nd_formula_text);
        /**/$rh_rdt1_ot_with_out_nd_formula_text=str_replace("total_overtime","total_regular_hrs_reg_holiday_t1",$rh_rdt1_ot_with_out_nd_formula_text); 
        /**/$rh_rdt1_ot_with_out_nd_formula_text=str_replace("ot_table_rate","rh_rdt1_ot_with_out_nd_rate",$rh_rdt1_ot_with_out_nd_formula_text);  
            $rh_rdt1_ot_with_out_nd_formula_text = $rh_rdt1_ot_with_out_nd_formula_text;
            $for_translation=$rh_rdt1_ot_with_out_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rh_rdt1_ot_with_out_nd_formula_1st=str_replace("[","",$ot_formula);
            $rh_rdt1_ot_with_out_nd_formula_2nd=str_replace("]","",$rh_rdt1_ot_with_out_nd_formula_1st);    
        /**/$rh_rdt1_ot_with_out_nd_formula_2nd=str_replace("total_overtime","total_regular_hrs_reg_holiday_t1",$rh_rdt1_ot_with_out_nd_formula_2nd);  
        /**/$rh_rdt1_ot_with_out_nd_formula_text=str_replace("ot_table_rate","rh_rdt1_ot_with_out_nd_rate",$rh_rdt1_ot_with_out_nd_formula_2nd);   
            $rh_rdt1_ot_with_out_nd_value_raw=$rh_rdt1_ot_with_out_nd_formula_text;
        /**/$rh_rdt1_ot_with_out_nd_value = eval('return '.$rh_rdt1_ot_with_out_nd_value_raw.';');

            if($rh_rdt1_ot_with_out_nd_value>0){
                $rh_rdt1_ot_with_out_nd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rh_rdt1_ot_with_out_nd_value_formula_text_class="";
            }

        /**/$rh_rdt1_ot_with_out_nd_formula_text="<i class='$rh_rdt1_ot_with_out_nd_value_formula_text_class'>(Regular Holiday/Restday Overtime without ND)</i> <i class='fa fa-arrow-right $rh_rdt1_ot_with_out_nd_value_formula_text_class'> $for_translation = $rh_rdt1_ot_with_out_nd_value</i>";
            //echo "check:". $rh_rdt1_ot_with_out_nd_formula_text." = ".$rh_rdt1_ot_with_out_nd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_restday_reg_holiday_nd
            $rh_rdt1_ot_withnd_formula_text=str_replace("[","{",$ot_formula);
            $rh_rdt1_ot_withnd_formula_text=str_replace("]","}",$rh_rdt1_ot_withnd_formula_text);
        /**/$rh_rdt1_ot_withnd_formula_text=str_replace("total_overtime","total_restday_reg_holiday_nd",$rh_rdt1_ot_withnd_formula_text); 
        /**/$rh_rdt1_ot_withnd_formula_text=str_replace("ot_table_rate","rh_rdt1_ot_withnd_rate",$rh_rdt1_ot_withnd_formula_text);  
            $rh_rdt1_ot_withnd_formula_text = $rh_rdt1_ot_withnd_formula_text;
            $for_translation=$rh_rdt1_ot_withnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rh_rdt1_ot_withnd_formula_1st=str_replace("[","",$ot_formula);
            $rh_rdt1_ot_withnd_formula_2nd=str_replace("]","",$rh_rdt1_ot_withnd_formula_1st);    
        /**/$rh_rdt1_ot_withnd_formula_2nd=str_replace("total_overtime","total_restday_reg_holiday_nd",$rh_rdt1_ot_withnd_formula_2nd);  
        /**/$rh_rdt1_ot_withnd_formula_text=str_replace("ot_table_rate","rh_rdt1_ot_withnd_rate",$rh_rdt1_ot_withnd_formula_2nd);   
            $rh_rdt1_ot_withnd_value_raw=$rh_rdt1_ot_withnd_formula_text;
        /**/$rh_rdt1_ot_withnd_value = eval('return '.$rh_rdt1_ot_withnd_value_raw.';');

            if($rh_rdt1_ot_withnd_value>0){
                $rh_rdt1_ot_withnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rh_rdt1_ot_withnd_value_formula_text_class="";
            }

        /**/$rh_rdt1_ot_withnd_formula_text="<i class='$rh_rdt1_ot_withnd_value_formula_text_class'>(Regular Holiday/Restday Overtime with ND)</i> <i class='fa fa-arrow-right $rh_rdt1_ot_withnd_value_formula_text_class'> $for_translation = $rh_rdt1_ot_withnd_value</i>";
            //echo "check:". $rh_rdt1_ot_withnd_formula_text." = ".$rh_rdt1_ot_withnd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_restday_reg_holiday_overtime
            $rh_rdt1_ot_ot_with_out_nd_formula_text=str_replace("[","{",$ot_formula);
            $rh_rdt1_ot_ot_with_out_nd_formula_text=str_replace("]","}",$rh_rdt1_ot_ot_with_out_nd_formula_text);
        /**/$rh_rdt1_ot_ot_with_out_nd_formula_text=str_replace("total_overtime","total_restday_reg_holiday_overtime",$rh_rdt1_ot_ot_with_out_nd_formula_text); 
        /**/$rh_rdt1_ot_ot_with_out_nd_formula_text=str_replace("ot_table_rate","rh_rdt1_ot_ot_with_out_nd_rate",$rh_rdt1_ot_ot_with_out_nd_formula_text);  
            $rh_rdt1_ot_ot_with_out_nd_formula_text = $rh_rdt1_ot_ot_with_out_nd_formula_text;
            $for_translation=$rh_rdt1_ot_ot_with_out_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rh_rdt1_ot_ot_with_out_nd_formula_1st=str_replace("[","",$ot_formula);
            $rh_rdt1_ot_ot_with_out_nd_formula_2nd=str_replace("]","",$rh_rdt1_ot_ot_with_out_nd_formula_1st);    
        /**/$rh_rdt1_ot_ot_with_out_nd_formula_2nd=str_replace("total_overtime","total_restday_reg_holiday_overtime",$rh_rdt1_ot_ot_with_out_nd_formula_2nd);  
        /**/$rh_rdt1_ot_ot_with_out_nd_formula_text=str_replace("ot_table_rate","rh_rdt1_ot_ot_with_out_nd_rate",$rh_rdt1_ot_ot_with_out_nd_formula_2nd);   
            $rh_rdt1_ot_ot_with_out_nd_value_raw=$rh_rdt1_ot_ot_with_out_nd_formula_text;
        /**/$rh_rdt1_ot_ot_with_out_nd_value = eval('return '.$rh_rdt1_ot_ot_with_out_nd_value_raw.';');

            if($rh_rdt1_ot_ot_with_out_nd_value>0){
                $rh_rdt1_ot_ot_with_out_nd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rh_rdt1_ot_ot_with_out_nd_value_formula_text_class="";
            }

        /**/$rh_rdt1_ot_ot_with_out_nd_formula_text="<i class='$rh_rdt1_ot_ot_with_out_nd_value_formula_text_class'>(Regular Holiday/Restday Overtime-OT without ND)</i> <i class='fa fa-arrow-right $rh_rdt1_ot_ot_with_out_nd_value_formula_text_class'> $for_translation = $rh_rdt1_ot_ot_with_out_nd_value</i>";
            //echo "check:". $rh_rdt1_ot_ot_with_out_nd_formula_text." = ".$rh_rdt1_ot_ot_with_out_nd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_restday_reg_holiday_overtime_nd
            $rh_rdt1_ot_ot_withnd_formula_text=str_replace("[","{",$ot_formula);
            $rh_rdt1_ot_ot_withnd_formula_text=str_replace("]","}",$rh_rdt1_ot_ot_withnd_formula_text);
        /**/$rh_rdt1_ot_ot_withnd_formula_text=str_replace("total_overtime","total_restday_reg_holiday_overtime_nd",$rh_rdt1_ot_ot_withnd_formula_text); 
        /**/$rh_rdt1_ot_ot_withnd_formula_text=str_replace("ot_table_rate","rh_rdt1_ot_ot_withnd_rate",$rh_rdt1_ot_ot_withnd_formula_text);  
            $rh_rdt1_ot_ot_withnd_formula_text = $rh_rdt1_ot_ot_withnd_formula_text;
            $for_translation=$rh_rdt1_ot_ot_withnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $rh_rdt1_ot_ot_withnd_formula_1st=str_replace("[","",$ot_formula);
            $rh_rdt1_ot_ot_withnd_formula_2nd=str_replace("]","",$rh_rdt1_ot_ot_withnd_formula_1st);    
        /**/$rh_rdt1_ot_ot_withnd_formula_2nd=str_replace("total_overtime","total_restday_reg_holiday_overtime_nd",$rh_rdt1_ot_ot_withnd_formula_2nd);  
        /**/$rh_rdt1_ot_ot_withnd_formula_text=str_replace("ot_table_rate","rh_rdt1_ot_ot_withnd_rate",$rh_rdt1_ot_ot_withnd_formula_2nd);   
            $rh_rdt1_ot_ot_withnd_value_raw=$rh_rdt1_ot_ot_withnd_formula_text;
        /**/$rh_rdt1_ot_ot_withnd_value = eval('return '.$rh_rdt1_ot_ot_withnd_value_raw.';');

            if($rh_rdt1_ot_ot_withnd_value>0){
                $rh_rdt1_ot_ot_withnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $rh_rdt1_ot_ot_withnd_value_formula_text_class="";
            }

        /**/$rh_rdt1_ot_ot_withnd_formula_text="<i class='$rh_rdt1_ot_ot_withnd_value_formula_text_class'>(Regular Holiday/Restday Overtime-OT with ND)</i> <i class='fa fa-arrow-right $rh_rdt1_ot_ot_withnd_value_formula_text_class'> $for_translation = $rh_rdt1_ot_ot_withnd_value</i>";
            //echo "check:". $rh_rdt1_ot_ot_withnd_formula_text." = ".$rh_rdt1_ot_ot_withnd_value;

                                            //::::::::::::::::::::::: OVERTIME: total_regular_hrs_spec_holiday
            $snwot_with_out_nd_formula_text=str_replace("[","{",$ot_formula);
            $snwot_with_out_nd_formula_text=str_replace("]","}",$snwot_with_out_nd_formula_text);
        /**/$snwot_with_out_nd_formula_text=str_replace("total_overtime","total_regular_hrs_spec_holiday",$snwot_with_out_nd_formula_text); 
        /**/$snwot_with_out_nd_formula_text=str_replace("ot_table_rate","snwot_with_out_nd_rate",$snwot_with_out_nd_formula_text);  
            $snwot_with_out_nd_formula_text = $snwot_with_out_nd_formula_text;
            $for_translation=$snwot_with_out_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $snwot_with_out_nd_formula_1st=str_replace("[","",$ot_formula);
            $snwot_with_out_nd_formula_2nd=str_replace("]","",$snwot_with_out_nd_formula_1st);    
        /**/$snwot_with_out_nd_formula_2nd=str_replace("total_overtime","total_regular_hrs_spec_holiday",$snwot_with_out_nd_formula_2nd);  
        /**/$snwot_with_out_nd_formula_text=str_replace("ot_table_rate","snwot_with_out_nd_rate",$snwot_with_out_nd_formula_2nd);   
            $snwot_with_out_nd_value_raw=$snwot_with_out_nd_formula_text;
        /**/$snwot_with_out_nd_value = eval('return '.$snwot_with_out_nd_value_raw.';');

            if($snwot_with_out_nd_value>0){
                $snwot_with_out_nd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $snwot_with_out_nd_value_formula_text_class="";
            }

        /**/$snwot_with_out_nd_formula_text="<i class='$snwot_with_out_nd_value_formula_text_class'>(Special Non-working Holiday Overtime without ND)</i> <i class='fa fa-arrow-right $snwot_with_out_nd_value_formula_text_class'> $for_translation = $snwot_with_out_nd_value</i>";
            //echo "check:". $snwot_with_out_nd_formula_text." = ".$snwot_with_out_nd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_spec_holiday_nd
            $snwot_withnd_formula_text=str_replace("[","{",$ot_formula);
            $snwot_withnd_formula_text=str_replace("]","}",$snwot_withnd_formula_text);
        /**/$snwot_withnd_formula_text=str_replace("total_overtime","total_spec_holiday_nd",$snwot_withnd_formula_text); 
        /**/$snwot_withnd_formula_text=str_replace("ot_table_rate","snwot_withnd_rate",$snwot_withnd_formula_text);  
            $snwot_withnd_formula_text = $snwot_withnd_formula_text;
            $for_translation=$snwot_withnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $snwot_withnd_formula_1st=str_replace("[","",$ot_formula);
            $snwot_withnd_formula_2nd=str_replace("]","",$snwot_withnd_formula_1st);    
        /**/$snwot_withnd_formula_2nd=str_replace("total_overtime","total_spec_holiday_nd",$snwot_withnd_formula_2nd);  
        /**/$snwot_withnd_formula_text=str_replace("ot_table_rate","snwot_withnd_rate",$snwot_withnd_formula_2nd);   
            $snwot_withnd_value_raw=$snwot_withnd_formula_text;
        /**/$snwot_withnd_value = eval('return '.$snwot_withnd_value_raw.';');

            if($snwot_withnd_value>0){
                $snwot_withnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $snwot_withnd_value_formula_text_class="";
            }

        /**/$snwot_withnd_formula_text="<i class='$snwot_withnd_value_formula_text_class'>(Special Non-working Holiday Overtime with ND)</i> <i class='fa fa-arrow-right $snwot_withnd_value_formula_text_class'> $for_translation = $snwot_withnd_value</i>";
            //echo "check:". $snwot_withnd_formula_text." = ".$snwot_withnd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_spec_holiday_overtime
            $snwot_ot_with_out_nd_formula_text=str_replace("[","{",$ot_formula);
            $snwot_ot_with_out_nd_formula_text=str_replace("]","}",$snwot_ot_with_out_nd_formula_text);
        /**/$snwot_ot_with_out_nd_formula_text=str_replace("total_overtime","total_spec_holiday_overtime",$snwot_ot_with_out_nd_formula_text); 
        /**/$snwot_ot_with_out_nd_formula_text=str_replace("ot_table_rate","snwot_ot_with_out_nd_rate",$snwot_ot_with_out_nd_formula_text);  
            $snwot_ot_with_out_nd_formula_text = $snwot_ot_with_out_nd_formula_text;
            $for_translation=$snwot_ot_with_out_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $snwot_ot_with_out_nd_formula_1st=str_replace("[","",$ot_formula);
            $snwot_ot_with_out_nd_formula_2nd=str_replace("]","",$snwot_ot_with_out_nd_formula_1st);    
        /**/$snwot_ot_with_out_nd_formula_2nd=str_replace("total_overtime","total_spec_holiday_overtime",$snwot_ot_with_out_nd_formula_2nd);  
        /**/$snwot_ot_with_out_nd_formula_text=str_replace("ot_table_rate","snwot_ot_with_out_nd_rate",$snwot_ot_with_out_nd_formula_2nd);   
            $snwot_ot_with_out_nd_value_raw=$snwot_ot_with_out_nd_formula_text;
        /**/$snwot_ot_with_out_nd_value = eval('return '.$snwot_ot_with_out_nd_value_raw.';');

            if($snwot_ot_with_out_nd_value>0){
                $snwot_ot_with_out_nd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $snwot_ot_with_out_nd_value_formula_text_class="";
            }

        /**/$snwot_ot_with_out_nd_formula_text="<i class='$snwot_ot_with_out_nd_value_formula_text_class'>(Special Non-working Holiday Overtime-OT without ND)</i> <i class='fa fa-arrow-right $snwot_ot_with_out_nd_value_formula_text_class'> $for_translation = $snwot_ot_with_out_nd_value</i>";
            //echo "check:". $snwot_ot_with_out_nd_formula_text." = ".$snwot_ot_with_out_nd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_spec_holiday_overtime_nd
            $snwot_ot_withnd_formula_text=str_replace("[","{",$ot_formula);
            $snwot_ot_withnd_formula_text=str_replace("]","}",$snwot_ot_withnd_formula_text);
        /**/$snwot_ot_withnd_formula_text=str_replace("total_overtime","total_spec_holiday_overtime_nd",$snwot_ot_withnd_formula_text); 
        /**/$snwot_ot_withnd_formula_text=str_replace("ot_table_rate","snwot_ot_withnd_rate",$snwot_ot_withnd_formula_text);  
            $snwot_ot_withnd_formula_text = $snwot_ot_withnd_formula_text;
            $for_translation=$snwot_ot_withnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $snwot_ot_withnd_formula_1st=str_replace("[","",$ot_formula);
            $snwot_ot_withnd_formula_2nd=str_replace("]","",$snwot_ot_withnd_formula_1st);    
        /**/$snwot_ot_withnd_formula_2nd=str_replace("total_overtime","total_spec_holiday_overtime_nd",$snwot_ot_withnd_formula_2nd);  
        /**/$snwot_ot_withnd_formula_text=str_replace("ot_table_rate","snwot_ot_withnd_rate",$snwot_ot_withnd_formula_2nd);   
            $snwot_ot_withnd_value_raw=$snwot_ot_withnd_formula_text;
        /**/$snwot_ot_withnd_value = eval('return '.$snwot_ot_withnd_value_raw.';');

            if($snwot_ot_withnd_value>0){
                $snwot_ot_withnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $snwot_ot_withnd_value_formula_text_class="";
            }

        /**/$snwot_ot_withnd_formula_text="<i class='$snwot_ot_withnd_value_formula_text_class'>(Special Non-working Holiday Overtime-OT with ND)</i> <i class='fa fa-arrow-right $snwot_ot_withnd_value_formula_text_class'> $for_translation = $snwot_ot_withnd_value</i>";
            //echo "check:". $snwot_ot_withnd_formula_text." = ".$snwot_ot_withnd_value;


                                            //::::::::::::::::::::::: OVERTIME: total_restday_regular_hrs_spec_holiday
            $snw_rd_ot_with_out_nd_formula_text=str_replace("[","{",$ot_formula);
            $snw_rd_ot_with_out_nd_formula_text=str_replace("]","}",$snw_rd_ot_with_out_nd_formula_text);
        /**/$snw_rd_ot_with_out_nd_formula_text=str_replace("total_overtime","total_restday_regular_hrs_spec_holiday",$snw_rd_ot_with_out_nd_formula_text); 
        /**/$snw_rd_ot_with_out_nd_formula_text=str_replace("ot_table_rate","snw_rd_ot_with_out_nd_rate",$snw_rd_ot_with_out_nd_formula_text);  
            $snw_rd_ot_with_out_nd_formula_text = $snw_rd_ot_with_out_nd_formula_text;
            $for_translation=$snw_rd_ot_with_out_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $snw_rd_ot_with_out_nd_formula_1st=str_replace("[","",$ot_formula);
            $snw_rd_ot_with_out_nd_formula_2nd=str_replace("]","",$snw_rd_ot_with_out_nd_formula_1st);    
        /**/$snw_rd_ot_with_out_nd_formula_2nd=str_replace("total_overtime","total_restday_regular_hrs_spec_holiday",$snw_rd_ot_with_out_nd_formula_2nd);  
        /**/$snw_rd_ot_with_out_nd_formula_text=str_replace("ot_table_rate","snw_rd_ot_with_out_nd_rate",$snw_rd_ot_with_out_nd_formula_2nd);   
            $snw_rd_ot_with_out_nd_value_raw=$snw_rd_ot_with_out_nd_formula_text;
        /**/$snw_rd_ot_with_out_nd_value = eval('return '.$snw_rd_ot_with_out_nd_value_raw.';');

            if($snw_rd_ot_with_out_nd_value>0){
                $snw_rd_ot_with_out_nd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $snw_rd_ot_with_out_nd_value_formula_text_class="";
            }

        /**/$snw_rd_ot_with_out_nd_formula_text="<i class='$snw_rd_ot_with_out_nd_value_formula_text_class'>(Special Non-working Holiday/Restday Overtime without ND)</i> <i class='fa fa-arrow-right $snw_rd_ot_with_out_nd_value_formula_text_class'> $for_translation = $snw_rd_ot_with_out_nd_value</i>";
            //echo "check:". $snw_rd_ot_with_out_nd_formula_text." = ".$snw_rd_ot_with_out_nd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_restday_spec_holiday_nd
            $snw_rd_ot_withnd_formula_text=str_replace("[","{",$ot_formula);
            $snw_rd_ot_withnd_formula_text=str_replace("]","}",$snw_rd_ot_withnd_formula_text);
        /**/$snw_rd_ot_withnd_formula_text=str_replace("total_overtime","total_restday_spec_holiday_nd",$snw_rd_ot_withnd_formula_text); 
        /**/$snw_rd_ot_withnd_formula_text=str_replace("ot_table_rate","snw_rd_ot_withnd_rate",$snw_rd_ot_withnd_formula_text);  
            $snw_rd_ot_withnd_formula_text = $snw_rd_ot_withnd_formula_text;
            $for_translation=$snw_rd_ot_withnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $snw_rd_ot_withnd_formula_1st=str_replace("[","",$ot_formula);
            $snw_rd_ot_withnd_formula_2nd=str_replace("]","",$snw_rd_ot_withnd_formula_1st);    
        /**/$snw_rd_ot_withnd_formula_2nd=str_replace("total_overtime","total_restday_spec_holiday_nd",$snw_rd_ot_withnd_formula_2nd);  
        /**/$snw_rd_ot_withnd_formula_text=str_replace("ot_table_rate","snw_rd_ot_withnd_rate",$snw_rd_ot_withnd_formula_2nd);   
            $snw_rd_ot_withnd_value_raw=$snw_rd_ot_withnd_formula_text;
        /**/$snw_rd_ot_withnd_value = eval('return '.$snw_rd_ot_withnd_value_raw.';');

            if($snw_rd_ot_withnd_value>0){
                $snw_rd_ot_withnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $snw_rd_ot_withnd_value_formula_text_class="";
            }

        /**/$snw_rd_ot_withnd_formula_text="<i class='$snw_rd_ot_withnd_value_formula_text_class'>(Special Non-working Holiday/Restday Overtime with ND)</i> <i class='fa fa-arrow-right $snw_rd_ot_withnd_value_formula_text_class'> $for_translation = $snw_rd_ot_withnd_value</i>";
            //echo "check:". $snw_rd_ot_withnd_formula_text." = ".$snw_rd_ot_withnd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_restday_spec_holiday_overtime
            $snw_rd_ot_ot_with_out_nd_formula_text=str_replace("[","{",$ot_formula);
            $snw_rd_ot_ot_with_out_nd_formula_text=str_replace("]","}",$snw_rd_ot_ot_with_out_nd_formula_text);
        /**/$snw_rd_ot_ot_with_out_nd_formula_text=str_replace("total_overtime","total_restday_spec_holiday_overtime",$snw_rd_ot_ot_with_out_nd_formula_text); 
        /**/$snw_rd_ot_ot_with_out_nd_formula_text=str_replace("ot_table_rate","snw_rd_ot_ot_with_out_nd_rate",$snw_rd_ot_ot_with_out_nd_formula_text);  
            $snw_rd_ot_ot_with_out_nd_formula_text = $snw_rd_ot_ot_with_out_nd_formula_text;
            $for_translation=$snw_rd_ot_ot_with_out_nd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $snw_rd_ot_ot_with_out_nd_formula_1st=str_replace("[","",$ot_formula);
            $snw_rd_ot_ot_with_out_nd_formula_2nd=str_replace("]","",$snw_rd_ot_ot_with_out_nd_formula_1st);    
        /**/$snw_rd_ot_ot_with_out_nd_formula_2nd=str_replace("total_overtime","total_restday_spec_holiday_overtime",$snw_rd_ot_ot_with_out_nd_formula_2nd);  
        /**/$snw_rd_ot_ot_with_out_nd_formula_text=str_replace("ot_table_rate","snw_rd_ot_ot_with_out_nd_rate",$snw_rd_ot_ot_with_out_nd_formula_2nd);   
            $snw_rd_ot_ot_with_out_nd_value_raw=$snw_rd_ot_ot_with_out_nd_formula_text;
        /**/$snw_rd_ot_ot_with_out_nd_value = eval('return '.$snw_rd_ot_ot_with_out_nd_value_raw.';');

            if($snw_rd_ot_ot_with_out_nd_value>0){
                $snw_rd_ot_ot_with_out_nd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $snw_rd_ot_ot_with_out_nd_value_formula_text_class="";
            }

        /**/$snw_rd_ot_ot_with_out_nd_formula_text="<i class='$snw_rd_ot_ot_with_out_nd_value_formula_text_class'>(Special Non-working Holiday/Restday Overtime-OT without ND)</i> <i class='fa fa-arrow-right $snw_rd_ot_ot_with_out_nd_value_formula_text_class'> $for_translation = $snw_rd_ot_ot_with_out_nd_value</i>";
            //echo "check:". $snw_rd_ot_ot_with_out_nd_formula_text." = ".$snw_rd_ot_ot_with_out_nd_value;
                                            //::::::::::::::::::::::: OVERTIME: total_restday_spec_holiday_overtime_nd
            $snw_rd_ot_ot_withnd_formula_text=str_replace("[","{",$ot_formula);
            $snw_rd_ot_ot_withnd_formula_text=str_replace("]","}",$snw_rd_ot_ot_withnd_formula_text);
        /**/$snw_rd_ot_ot_withnd_formula_text=str_replace("total_overtime","total_restday_spec_holiday_overtime_nd",$snw_rd_ot_ot_withnd_formula_text); 
        /**/$snw_rd_ot_ot_withnd_formula_text=str_replace("ot_table_rate","snw_rd_ot_ot_withnd_rate",$snw_rd_ot_ot_withnd_formula_text);  
            $snw_rd_ot_ot_withnd_formula_text = $snw_rd_ot_ot_withnd_formula_text;
            $for_translation=$snw_rd_ot_ot_withnd_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $snw_rd_ot_ot_withnd_formula_1st=str_replace("[","",$ot_formula);
            $snw_rd_ot_ot_withnd_formula_2nd=str_replace("]","",$snw_rd_ot_ot_withnd_formula_1st);    
        /**/$snw_rd_ot_ot_withnd_formula_2nd=str_replace("total_overtime","total_restday_spec_holiday_overtime_nd",$snw_rd_ot_ot_withnd_formula_2nd);  
        /**/$snw_rd_ot_ot_withnd_formula_text=str_replace("ot_table_rate","snw_rd_ot_ot_withnd_rate",$snw_rd_ot_ot_withnd_formula_2nd);   
            $snw_rd_ot_ot_withnd_value_raw=$snw_rd_ot_ot_withnd_formula_text;
        /**/$snw_rd_ot_ot_withnd_value = eval('return '.$snw_rd_ot_ot_withnd_value_raw.';');

            if($snw_rd_ot_ot_withnd_value>0){
                $snw_rd_ot_ot_withnd_value_formula_text_class="$overtime_with_value_stand_out";
            }else{
                $snw_rd_ot_ot_withnd_value_formula_text_class="";
            }

        /**/$snw_rd_ot_ot_withnd_formula_text="<i class='$snw_rd_ot_ot_withnd_value_formula_text_class'>(Special Non-working Holiday/Restday Overtime-OT with ND)</i> <i class='fa fa-arrow-right $snw_rd_ot_ot_withnd_value_formula_text_class'> $for_translation = $snw_rd_ot_ot_withnd_value</i>";
            //echo "check:". $snw_rd_ot_ot_withnd_formula_text." = ".$snw_rd_ot_ot_withnd_value;


        if($round_off_payslip=="yes"){// round off
            $ws_nd_value=round($ws_nd_value, $payslip_decimal_place);
            $regot_value=round($regot_value, $payslip_decimal_place);
            $regotnd_value=round($regotnd_value, $payslip_decimal_place);
            $rdot_with_out_nd_value=round($rdot_with_out_nd_value, $payslip_decimal_place);
            $rdot_withnd_value=round($rdot_withnd_value, $payslip_decimal_place);
            $rdot_ot_with_out_nd_value=round($rdot_ot_with_out_nd_value, $payslip_decimal_place);
            $rdot_ot_withnd_value=round($rdot_ot_withnd_value, $payslip_decimal_place);
            $rhot_with_out_nd_value=round($rhot_with_out_nd_value, $payslip_decimal_place);
            $rhot_withnd_value=round($rhot_withnd_value, $payslip_decimal_place);
            $rhot_ot_with_out_nd_value=round($rhot_ot_with_out_nd_value, $payslip_decimal_place);
            $rhot_ot_withnd_value=round($rhot_ot_withnd_value, $payslip_decimal_place);
            
            $rh_rdt2_value=round($rh_rdt2_value, $payslip_decimal_place);
            $rh_rdt1_ot_with_out_nd_value=round($rh_rdt1_ot_with_out_nd_value, $payslip_decimal_place);
            $rh_rdt1_ot_withnd_value=round($rh_rdt1_ot_withnd_value, $payslip_decimal_place);
            $rh_rdt1_ot_ot_with_out_nd_value=round($rh_rdt1_ot_ot_with_out_nd_value, $payslip_decimal_place);
            $rh_rdt1_ot_ot_withnd_value=round($rh_rdt1_ot_ot_withnd_value, $payslip_decimal_place);

            $snwot_with_out_nd_value=round($snwot_with_out_nd_value, $payslip_decimal_place);
            $snwot_withnd_value=round($snwot_withnd_value, $payslip_decimal_place);
            $snwot_ot_with_out_nd_value=round($snwot_ot_with_out_nd_value, $payslip_decimal_place);
            $snwot_ot_withnd_value=round($snwot_ot_withnd_value, $payslip_decimal_place);

            $snw_rd_ot_with_out_nd_value=round($snw_rd_ot_with_out_nd_value, $payslip_decimal_place);
            $snw_rd_ot_withnd_value=round($snw_rd_ot_withnd_value, $payslip_decimal_place);
            $snw_rd_ot_ot_with_out_nd_value=round($snw_rd_ot_ot_with_out_nd_value, $payslip_decimal_place);
            $snw_rd_ot_ot_withnd_value=round($snw_rd_ot_ot_withnd_value, $payslip_decimal_place);
        }else{// cut only
            $ws_nd_value=bcdiv($ws_nd_value, 1, $payslip_decimal_place); 
            $regot_value=bcdiv($regot_value, 1, $payslip_decimal_place); 
            $regotnd_value=bcdiv($regotnd_value, 1, $payslip_decimal_place); 
            $rdot_with_out_nd_value=bcdiv($rdot_with_out_nd_value, 1, $payslip_decimal_place); 
            $rdot_withnd_value=bcdiv($rdot_withnd_value, 1, $payslip_decimal_place); 
            $rdot_ot_with_out_nd_value=bcdiv($rdot_ot_with_out_nd_value, 1, $payslip_decimal_place); 
            $rdot_ot_withnd_value=bcdiv($rdot_ot_withnd_value, 1, $payslip_decimal_place); 
            $rhot_with_out_nd_value=bcdiv($rhot_with_out_nd_value, 1, $payslip_decimal_place); 
            $rhot_withnd_value=bcdiv($rhot_withnd_value, 1, $payslip_decimal_place); 
            $rhot_ot_with_out_nd_value=bcdiv($rhot_ot_with_out_nd_value, 1, $payslip_decimal_place); 
            $rhot_ot_withnd_value=bcdiv($rhot_ot_withnd_value, 1, $payslip_decimal_place); 
            $rh_rdt2_value=bcdiv($rh_rdt2_value, 1, $payslip_decimal_place); 
            $rh_rdt1_ot_with_out_nd_value=bcdiv($rh_rdt1_ot_with_out_nd_value, 1, $payslip_decimal_place); 
            $rh_rdt1_ot_withnd_value=bcdiv($rh_rdt1_ot_withnd_value, 1, $payslip_decimal_place); 
            $rh_rdt1_ot_ot_with_out_nd_value=bcdiv($rh_rdt1_ot_ot_with_out_nd_value, 1, $payslip_decimal_place); 
            $rh_rdt1_ot_ot_withnd_value=bcdiv($rh_rdt1_ot_ot_withnd_value, 1, $payslip_decimal_place); 
            $snwot_with_out_nd_value=bcdiv($snwot_with_out_nd_value, 1, $payslip_decimal_place); 
            $snwot_withnd_value=bcdiv($snwot_withnd_value, 1, $payslip_decimal_place); 
            $snwot_ot_with_out_nd_value=bcdiv($snwot_ot_with_out_nd_value, 1, $payslip_decimal_place); 
            $snwot_ot_withnd_value=bcdiv($snwot_ot_withnd_value, 1, $payslip_decimal_place); 
            $snw_rd_ot_with_out_nd_value=bcdiv($snw_rd_ot_with_out_nd_value, 1, $payslip_decimal_place); 
            $snw_rd_ot_withnd_value=bcdiv($snw_rd_ot_withnd_value, 1, $payslip_decimal_place); 
            $snw_rd_ot_ot_with_out_nd_value=bcdiv($snw_rd_ot_ot_with_out_nd_value, 1, $payslip_decimal_place); 
            $snw_rd_ot_ot_withnd_value=bcdiv($snw_rd_ot_ot_withnd_value, 1, $payslip_decimal_place); 
        }


$total_overtime_amount=$regot_value+$regotnd_value+
                $rdot_with_out_nd_value+$rdot_withnd_value+$rdot_ot_with_out_nd_value+$rdot_ot_withnd_value+
                $rhot_with_out_nd_value+$rhot_withnd_value+$rhot_ot_with_out_nd_value+$rhot_ot_withnd_value+
                $rh_rdt2_value+
                $rh_rdt2_value+$rh_rdt1_ot_withnd_value+$rh_rdt1_ot_ot_with_out_nd_value+$rh_rdt1_ot_ot_withnd_value+
                $snwot_with_out_nd_value+$snwot_withnd_value+$snwot_ot_with_out_nd_value+$snwot_ot_withnd_value+
                $snw_rd_ot_with_out_nd_value+$snw_rd_ot_withnd_value+$snw_rd_ot_ot_with_out_nd_value+$snw_rd_ot_ot_withnd_value;


            if($round_off_payslip=="yes"){// round off
                $total_overtime_amount=round($total_overtime_amount, $payslip_decimal_place);
            }else{
                $total_overtime_amount=bcdiv($total_overtime_amount, 1, $payslip_decimal_place); 
            }


?>