<?php
if($selected_payroll_option=="view"){


?>
<!--//=========================================================== START BASIC DISPLAY -->
    <tr>
        <td class="topic_class">BASIC</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_basic.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($net_basic_formula or $is_salary_fixed=="1"){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$net_basic_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
   
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_net_basic_formula).'
                </td>';                    
            }else{  
                 if($net_basic_formula or $is_salary_fixed=="1"){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$basic_formula_text.'<br>
                    '.$daily_formula.'<br>
                    '.$hourly_formula_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no net basic formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// no more next cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END BASIC  -->
<!--//=========================================================== START OVERTIME DISPLAY -->
    <tr>
        <td class="topic_class">OVERTIME</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_overtime.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($ot_formula or $is_salary_fixed=="1"){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$total_overtime_amount.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{   
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_ot_formula).'
                </td>';                    
            }else{  
                 if($ot_formula or $is_salary_fixed=="1"){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$ot_formula_desc.'<br>
                    '.$regot_formula_text.'<br>
                    '.$regotnd_formula_text.'<br><br>

                    '.$rdot_with_out_nd_formula_text.'<br>
                    '.$rdot_withnd_formula_text.'<br>
                    '.$rdot_ot_with_out_nd_formula_text.'<br>
                    '.$rdot_ot_withnd_formula_text.'<br><br>

                    '.$rhot_with_out_nd_formula_text.'<br>
                    '.$rhot_withnd_formula_text.'<br>
                    '.$rhot_ot_with_out_nd_formula_text.'<br>
                    '.$rhot_ot_withnd_formula_text.'<br><br>

                    '.$rh_rdt2_formula_text.'<br><br>

                    '.$rh_rdt1_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_withnd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_withnd_formula_text.'<br><br>  

                    '.$snwot_with_out_nd_formula_text.'<br>
                    '.$snwot_withnd_formula_text.'<br>
                    '.$snwot_ot_with_out_nd_formula_text.'<br>
                    '.$snwot_ot_withnd_formula_text.'<br><br>   

                    '.$snw_rd_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_withnd_formula_text.'<br>
                    '.$snw_rd_ot_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_ot_withnd_formula_text.'<br><br>         

                    </td>';                  
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no overtime formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END OVERTIME  -->

<!--//=========================================================== START WORKING SCHEDULE NIGHT DIFFERENTIAL DISPLAY -->
    <tr>
        <td class="topic_class">WORING SCHEDULE NIGHT DIFFERENTIAL</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_shift_night_diff.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($ot_formula or $is_salary_fixed=="1"){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$ws_nd_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{  
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_shift_night_diff_formula).'
                </td>';                    
            }else{  
                 if($ot_formula or $is_salary_fixed=="1"){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$ws_nd_formula_text.'

                    </td>';                  
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no overtime formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END WORKING SCHEDULE NIGHT DIFF   -->

<!--//=========================================================== START OTHER ADDITIONS TAXABLE DISPLAY -->
    <tr>
        <td class="topic_class">OTHER ADDITIONS TAXABLE</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_other_addition_taxable.'
            </td>';
        }else{
            if($cut_off=="1"){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$total_taxable_oa.'
                    </td>';                     
            }else{
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.nl2br($first_posted_oa_taxable_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$oae_taxable_list.'<br>
                    '.$auto_oae_taxable_list.'<br>
                    '.$auto_ot_meal_allowance_how_to_taxable.'<br>
                    '.$taxable_payroll_leave_adjustment_how_to.'
                    </td>';                                         
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END OTHER ADDITIONS TAXABLE  -->

<!--//=========================================================== START OTHER ADDITIONS NON-TAXABLE DISPLAY -->
    <tr>
        <td class="topic_class">OTHER ADDITIONS NON-TAXABLE</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_other_addition_non_tax.'
            </td>';
        }else{
            if($cut_off=="1"){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$total_nontaxable_oa.'
                    </td>';                     
            }else{
   
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.nl2br($first_posted_oa_nontax_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$oae_nontaxable_list.'<br>
                    '.$auto_oae_nontaxable_list.'<br>
                    '.$auto_ot_meal_allowance_how_to_nontaxable.'<br>
                    '.$nontax_payroll_leave_adjustment_how_to.'
                    </td>';                                         
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END OTHER ADDITIONS NON-TAXABLE  -->


<!--//=========================================================== START COLA DISPLAY -->
    <tr>
        <td class="topic_class">COLA</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_cola.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($cola_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$total_cola_amount.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
 
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_cola_how_to).'
                </td>';                    
            }else{  
                 if($cola_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$cola_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no cola formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END COLA  -->


<!--//=========================================================== START OTHER DEDUCTIONS TAXABLE DISPLAY -->
    <tr>
        <td class="topic_class">OTHER DEDUCTIONS TAXABLE</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_other_deduction_taxable.' 
            </td>';
        }else{
            if($cut_off=="1"){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$total_taxable_od.'
                    </td>';                     
            }else{ 
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.nl2br($first_posted_od_taxable_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$ode_taxable_list.'<br>
                    '.$auto_ode_taxable_list.'<br>
                    </td>';                                         
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END OTHER DEDUCTIONS TAXABLE  -->


<!--//=========================================================== START OTHER DEDUCTIONS NON-TAXABLE DISPLAY -->
    <tr>
        <td class="topic_class">OTHER DEDUCTIONS NON-TAXABLE</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_other_deduction_nontax.' 
            </td>';
        }else{
            if($cut_off=="1"){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$total_nontaxable_od.'
                    </td>';                     
            }else{   
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.nl2br($first_posted_od_nontax_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$ode_nontaxable_list.'<br>
                    '.$auto_ode_nontaxable_list.'<br>
                    </td>';                                         
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END OTHER DEDUCTIONS NON-TAXABLE  -->

<!--//=========================================================== START GROSS DISPLAY -->
    <tr>
        <td class="topic_class">GROSS</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_gross.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($gross_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$gross_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
  
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_gross_formula).'
                </td>';                    
            }else{  
                 if($gross_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$gross_formula_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no gross formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END GROSS  -->

<!--//=========================================================== START LOANS DISPLAY -->
    <tr>
        <td class="topic_class">LOANS <?php //echo "$loan_auto_adjust_text";?></td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_loan.' 
            </td>';
        }else{
            if($cut_off=="1"){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$total_loan.'
                    </td>';                     
            }else{
    
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                    echo '
                    <td colspan="2" style="text-align: left;">
                   '.nl2br($first_posted_loan_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$loan_text.'<br>
                    '.$pause_loan_text.'<br>
                    '.$nonpriority_loan_text.'<br>
                    </td>';                                         
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END LOANS  DISPLAY-->

<!--//=========================================================== START SSS DISPLAY -->
    <tr >
        <td class="topic_class">SSS</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_sss_employee.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($sss_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$sss_employee_share.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
   
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
               '.nl2br($first_posted_sss_formula).'
                </td>';                    
            }else{  
                 if($sss_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$sss_formula_text.'<br><br>
                    '.$sss_employer_share_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no sss formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END SSS  -->


<!--//=========================================================== START PHILHEALTH DISPLAY -->
    <tr >
        <td class="topic_class">PHILHEALTH</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_philhealth_employee.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($philhealth_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$philhealth_employee_share.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
   
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_ph_formula).'
                </td>';                    
            }else{  
                 if($philhealth_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$philhealth_formula_text.'<br><br>
                    '.$philhealth_employer_share_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no philhealth formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END PHILHEALTH  -->

<!--//=========================================================== START PAGIBIG DISPLAY -->
    <tr>
        <td class="topic_class">PAG-IBIG</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_pagibig.'
            </td>';
        }else{
            if($cut_off=="1"){
                if(($pi_amount)AND($pi_amount_type)){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$pagibig_contribution_employee.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
   
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_pi_formula).'
                </td>';                    
            }else{  
                 if(($pi_amount)AND($pi_amount_type)){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$pagibig_contribution_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no pagibig enrollment reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END PAGIBIG  -->

<!--//=========================================================== START ABSENT DISPLAY -->
    <tr >
        <td class="topic_class">ABSENT</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_absent.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($absent_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$absent_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
    
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
               '.$first_posted_absent_formula.'
                </td>';                    
            }else{  
                 if($absent_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$absent_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no absent formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END ABSENT  -->

<!--//=========================================================== START LATE DISPLAY -->
    <tr >
        <td class="topic_class">LATE</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_late.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($late_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$late_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
     
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_late_formula).'
                </td>';                    
            }else{  
                 if($late_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$late_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no late formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END LATE  -->


<!--//=========================================================== START UNDERTIME DISPLAY -->
    <tr >
        <td class="topic_class">UNDERTIME</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_undertime.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($ut_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$undertime_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{    
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_ut_formula).'
                </td>';                    
            }else{  
                 if($ut_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$undertime_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no ut formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END UNDERTIME  -->


<!--//=========================================================== START OVERBREAK DISPLAY -->
    <tr >
        <td class="topic_class">OVERBREAK</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_overbreak.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($overbreak_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$overbreak_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
      
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_overbreak_formula).'
                </td>';                    
            }else{  
                 if($overbreak_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$overbreak_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no overbreak formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END OVERBREAK  -->


<!--//=========================================================== START TAXABLE DISPLAY -->
    <tr >
        <td class="topic_class">TAXABLE </td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_taxable.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($taxable_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$actual_taxable_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
    
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($first_posted_taxable_formula).'
                </td>';                    
            }else{  
                 if($taxable_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$taxable_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no taxable formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
        }
        ?>  
    </tr>        
<!--//=========================================================== END TAXABLE  -->


<!--//=========================================================== START WTAX DISPLAY -->
    <tr>
        <td class="topic_class">WTAX ( <?php echo $taxcode_name;?> ) </td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
            '.$first_posted_wtax.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($wtax_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$witheld_tax.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{   
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
               '.nl2br($first_posted_wtax_formula).'
                </td>';                    
            }else{  
                 if($wtax_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$wtax_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no wtax formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
        }
        ?>  
    </tr>        
<!--//=========================================================== END WTAX  -->


<!--//=========================================================== START INCOME SUMMARY DISPLAY -->
    <tr >
        <td class="topic_class">INCOME SUMMARY</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
           '.$first_posted_income_total.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($income_sum_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$income_sum_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
    
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
               '.nl2br($first_posted_income_total_how_to).'
                </td>';                    
            }else{  
                 if($income_sum_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$income_sum_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no income summary formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END INCOME SUMMARY  -->    


<!--//=========================================================== START DEDUCTION SUMMARY DISPLAY -->
    <tr >
        <td class="topic_class">DEDUCTION SUMMARY</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
           '.$first_posted_deduction_total.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($deduction_sum_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$deduction_sum_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
  
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
               '.nl2br($first_posted_deduction_total_how_to).'
                </td>';                    
            }else{  
                 if($deduction_sum_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$deduction_sum_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no deduction summary formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END DEDUCTION SUMMARY  -->    



<!--//=========================================================== START NET PAY DISPLAY -->
    <tr>
        <td class="topic_class">NET PAY</td>
        <?php 
        if($first_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_1st.'>
           '.$first_posted_netpay.'
            </td>';
        }else{
            if($cut_off=="1"){
                if($net_pay_formula){
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    '.$net_pay_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }


        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
               '.nl2br($first_posted_net_pay_formula).'
                </td>';                    
            }else{  
                 if($net_pay_formula){
                    echo '
                    <td colspan="2" style="text-align: left;">
                    '.$net_pay_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td colspan="2" style="text-align: left;">
                        notice : no net pay formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff

        }
        ?>  
    </tr>        
<!--//=========================================================== END NET PAY  -->
    <tr>
        <td>STATUS</td>
        <td <?php echo $three_1st; ?>>
            <?php
               echo $first_cutoff_payslip_state;                        
            ?>
        </td>

        <td colspan="2">&nbsp;</td>
    </tr>






    <?php

}elseif($selected_payroll_option=="post_all"){
    
if(($cut_off=="1")AND($first_cutoff_payslip_state=="posted")){
    echo "
    <tr>
    <td colspan='6'><i class='fa fa-check-square text-info' style='font-size:48px;'></i> 
    Payroll is already posted previously.
    <span class='system_auto_guide'> If you would like to repost/recalculate the payroll reset the payslip first . go to payroll > reset payslip</span>
    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>
    </td></tr>";

}elseif(($cut_off=="2")AND($second_cutoff_payslip_state=="posted")){
    echo "
    <tr>
    <td colspan='6'><i class='fa fa-check-square text-info' style='font-size:48px;'></i> 
    Payroll is already posted previously.
    <span class='system_auto_guide'> If you would like to repost/recalculate the payroll reset the payslip first . go to payroll > reset payslip</span>
    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>
    </td></tr>";
}else{


    require(APPPATH.'views/app/payroll/payslip/save_payroll.php');

}

}elseif($selected_payroll_option=="print_payslip"){
   
    require(APPPATH.'views/app/payroll/payslip/print_payslip_body.php');


}else{// check payroll .

    echo "
    <tr>
    <td colspan='6'><i class='fa fa-check-square-o' style='font-size:48px;'></i> Payroll Checking..</td>
    </tr>
        ";
}




    ?>