
<style type="text/css">
    .annualize{
        color:#ff0000;
    }
</style>

<?php

$vl_leave_used="";
$sl_leave_used="";
$ol_leave_used="";

    $for_payslip_payroll_period=$pay_period;
    $check_payroll_period_id=$for_payslip_payroll_period;




$payslip_values=$this->payroll_generate_payslip_model->check_payslip_status($check_payroll_period_id,$company_id,$employee_id,$month_cover);


$checkLeaveUsed=$this->payroll_generate_payslip_model->getLeaveUsedDetails($check_payroll_period_id,$company_id,$employee_id,$month_cover);
   if(!empty($checkLeaveUsed)){
    $approve_leave_wpay_count=$checkLeaveUsed->approve_leave_wpay_count;
    $approve_leave_wopay_count=$checkLeaveUsed->approve_leave_wopay_count;

 $leave_na_nagamit = explode("x", $approve_leave_wpay_count);
 foreach ($leave_na_nagamit as $isang_leave_type) {
       
    $isang_leave_type = str_replace("(","",$isang_leave_type);
    $isang_leave_type = str_replace(")","",$isang_leave_type);
    
     if($isang_leave_type){
     list($leave_id,$leave_count) = explode("-",$isang_leave_type);
    //echo "$leave_id | $leave_count<br>";

$compLeaveType=$this->payroll_generate_payslip_model->checkCompLeavetypes($leave_id);
if(!empty($compLeaveType)){
        $is_vl=$compLeaveType->is_vl;
        $is_sl=$compLeaveType->is_sl;
        if($is_vl=="1"){// Vacation Leave
             $vl_leave_used+=$leave_count;
        }elseif($is_sl=="1"){// Sick Leave
            $sl_leave_used+=$leave_count;
        }else{//Other Leave types.
            $ol_leave_used+=$leave_count;
        }
       
}else{

}


        
     }else{
        // last combination.
     }
     
    // $code = $arr_lv["id-$lv_id"];
    
    // if(strtoupper($code)=="VL"){
    //     $vl_ttl+=$used_leave;
    // }elseif(strtoupper($code)=="SL"){
    //     $sl_ttl+=$used_leave;
    // }elseif(strtoupper($code)=="IL"){
    //     $il_ttl+=$used_leave;
    // }else{
    //     $ol_ttl+=$used_leave;



    }
   }else{
    $approve_leave_wpay_count="";
    $approve_leave_wopay_count="";
   }

    if(!empty($payslip_values)){

    	$actual_payslip_state="posted";

        $ispayslip_viewed=$payslip_values->employee_acknowledge;

        $payslip_ytd_sss=$payslip_values->ytd_sss;
            
        if($payslip_ytd_sss>0){
             $payslip_ytd_sss=number_format($payslip_ytd_sss,$payslip_decimal_place);   
        }else{

        }       

        $payslip_ytd_philhealth=$payslip_values->ytd_philhealth;
        
        if($payslip_ytd_philhealth>0){
             $payslip_ytd_philhealth=number_format($payslip_ytd_philhealth,$payslip_decimal_place);        
        }else{

        }      

        $payslip_ytd_pagibig=$payslip_values->ytd_pagibig;
            
        if($payslip_ytd_pagibig>0){
             $payslip_ytd_pagibig=number_format($payslip_ytd_pagibig,$payslip_decimal_place);      
        }else{  

        }    

        $payslip_ytd_wtax=$payslip_values->ytd_wtax;
          
        if($payslip_ytd_wtax>0){
              $payslip_ytd_wtax=number_format($payslip_ytd_wtax,$payslip_decimal_place);      
        }else{

        }     

        $payslip_ytd_taxable=$payslip_values->ytd_taxable;
                
        if($payslip_ytd_taxable>0){
            $payslip_ytd_taxable=number_format($payslip_ytd_taxable,$payslip_decimal_place);    
        }else{

        }   

        $payslip_ytd_gross=$payslip_values->ytd_gross;
           
        if($payslip_ytd_gross>0){
            $payslip_ytd_gross=number_format($payslip_ytd_gross,$payslip_decimal_place);       
        }else{

        }     


        $payslip_wtax_code=$payslip_values->wtax_code;
        $actual_payslip_salary_ratename=$payslip_values->salary_ratename;
        $actual_payslip_salary_amount=$payslip_values->salary_amount;
           
        if($actual_payslip_salary_amount>0){
             $actual_payslip_salary_amount=number_format($actual_payslip_salary_amount,$payslip_decimal_place);    
        }else{

        }       


        $actual_payslip_basic=$payslip_values->basic;
         
        if($actual_payslip_basic>0){
             $actual_payslip_basic=number_format($actual_payslip_basic,$payslip_decimal_place);         
        }else{

        }    

        $actual_payslip_leave_basic=$payslip_values->leave_basic;
        
        if($actual_payslip_leave_basic>0){
             $actual_payslip_leave_basic=number_format($actual_payslip_leave_basic,$payslip_decimal_place);           
        }else{

        }   

        $basic_minus_leave_basic=$payslip_values->basic-$payslip_values->leave_basic;
        
        if($basic_minus_leave_basic>0){
             $basic_minus_leave_basic=number_format($basic_minus_leave_basic,$payslip_decimal_place);           
        }else{

        }    


        $actual_payslip_overtime=$payslip_values->overtime;
           
        if($actual_payslip_overtime>0){
            $actual_payslip_overtime=number_format($actual_payslip_overtime,$payslip_decimal_place);       
        }else{

        }     


		$actual_payslip_regot_value=$payslip_values->regot_value;
                
        if($actual_payslip_regot_value>0){
             $actual_payslip_regot_value=number_format($actual_payslip_regot_value,$payslip_decimal_place); 
        }else{

        }     

		$actual_payslip_regotnd_value=$payslip_values->regotnd_value;
            
        if($actual_payslip_regotnd_value>0){
             $actual_payslip_regotnd_value=number_format($actual_payslip_regotnd_value,$payslip_decimal_place);     
        }else{

        }     

		$actual_payslip_rdot_with_out_nd_value=$payslip_values->rdot_with_out_nd_value;
             
        if($actual_payslip_rdot_with_out_nd_value>0){
              $actual_payslip_rdot_with_out_nd_value=number_format($actual_payslip_rdot_with_out_nd_value,$payslip_decimal_place);
        }else{

        }        

		$actual_payslip_rdot_withnd_value=$payslip_values->rdot_withnd_value;
                 
        if($actual_payslip_rdot_withnd_value>0){
            $actual_payslip_rdot_withnd_value=number_format($actual_payslip_rdot_withnd_value,$payslip_decimal_place); 
        }else{

        }     

		$actual_payslip_rdot_ot_with_out_nd_value=$payslip_values->rdot_ot_with_out_nd_value;
                   
        if($actual_payslip_rdot_ot_with_out_nd_value>0){
            $actual_payslip_rdot_ot_with_out_nd_value=number_format($actual_payslip_rdot_ot_with_out_nd_value,$payslip_decimal_place);   
        }else{

        } 

		$actual_payslip_rdot_ot_withnd_value=$payslip_values->rdot_ot_withnd_value;
           
        if($actual_payslip_rdot_ot_withnd_value>0){
            $actual_payslip_rdot_ot_withnd_value=number_format($actual_payslip_rdot_ot_withnd_value,$payslip_decimal_place);    
        }else{

        }        

		$actual_payslip_rhot_with_out_nd_value=$payslip_values->rhot_with_out_nd_value;
              
        if($actual_payslip_rhot_with_out_nd_value>0){
             $actual_payslip_rhot_with_out_nd_value=number_format($actual_payslip_rhot_with_out_nd_value,$payslip_decimal_place);
        }else{

        }        

		$actual_payslip_rhot_withnd_value=$payslip_values->rhot_withnd_value;
             
        if($actual_payslip_rhot_withnd_value>0){
             $actual_payslip_rhot_withnd_value=number_format($actual_payslip_rhot_withnd_value,$payslip_decimal_place);   
        }else{

        }      

		$actual_payslip_rhot_ot_with_out_nd_value=$payslip_values->rhot_ot_with_out_nd_value;
                 
        if($actual_payslip_rhot_ot_with_out_nd_value>0){
             $actual_payslip_rhot_ot_with_out_nd_value=number_format($actual_payslip_rhot_ot_with_out_nd_value,$payslip_decimal_place);     
        }else{

        }

		$actual_payslip_rhot_ot_withnd_value=$payslip_values->rhot_ot_withnd_value;
          
        if($actual_payslip_rhot_ot_withnd_value>0){
             $actual_payslip_rhot_ot_withnd_value=number_format($actual_payslip_rhot_ot_withnd_value,$payslip_decimal_place);     
        }else{

        }       

		$actual_payslip_rh_rdt2_value=$payslip_values->rh_rdt2_value;
         
        if($actual_payslip_rh_rdt2_value>0){
             $actual_payslip_rh_rdt2_value=number_format($actual_payslip_rh_rdt2_value,$payslip_decimal_place);       
        }else{

        }      

		$actual_payslip_rh_rdt1_ot_with_out_nd_value=$payslip_values->rh_rdt1_ot_with_out_nd_value;
              
        if($actual_payslip_rh_rdt1_ot_with_out_nd_value>0){
            $actual_payslip_rh_rdt1_ot_with_out_nd_value=number_format($actual_payslip_rh_rdt1_ot_with_out_nd_value,$payslip_decimal_place);   
        }else{

        }     

		$actual_payslip_rh_rdt1_ot_withnd_value=$payslip_values->rh_rdt1_ot_withnd_value;
               
        if($actual_payslip_rh_rdt1_ot_withnd_value>0){
            $actual_payslip_rh_rdt1_ot_withnd_value=number_format($actual_payslip_rh_rdt1_ot_withnd_value,$payslip_decimal_place);
        }else{

        }        

		$actual_payslip_rh_rdt1_ot_ot_with_out_nd_value=$payslip_values->rh_rdt1_ot_ot_with_out_nd_value;
                 
        if($actual_payslip_rh_rdt1_ot_ot_with_out_nd_value>0){
             $actual_payslip_rh_rdt1_ot_ot_with_out_nd_value=number_format($actual_payslip_rh_rdt1_ot_ot_with_out_nd_value,$payslip_decimal_place);    
        }else{

        } 

		$actual_payslip_rh_rdt1_ot_ot_withnd_value=$payslip_values->rh_rdt1_ot_ot_withnd_value ; 
                 
        if($actual_payslip_rh_rdt1_ot_ot_withnd_value>0){
             $actual_payslip_rh_rdt1_ot_ot_withnd_value=number_format($actual_payslip_rh_rdt1_ot_ot_withnd_value,$payslip_decimal_place);     
        }else{

        }

		$actual_payslip_snwot_with_out_nd_value=$payslip_values->snwot_with_out_nd_value;
              
        if($actual_payslip_snwot_with_out_nd_value>0){
             $actual_payslip_snwot_with_out_nd_value=number_format($actual_payslip_snwot_with_out_nd_value,$payslip_decimal_place);
        }else{

        }        

		$actual_payslip_snwot_withnd_value=$payslip_values->snwot_withnd_value;
             
        if($actual_payslip_snwot_withnd_value>0){
             $actual_payslip_snwot_withnd_value=number_format($actual_payslip_snwot_withnd_value,$payslip_decimal_place);   
        }else{

        }      

		$actual_payslip_snwot_ot_with_out_nd_value=$payslip_values->snwot_ot_with_out_nd_value;
              
        if($actual_payslip_snwot_ot_with_out_nd_value>0){
            $actual_payslip_snwot_ot_with_out_nd_value=number_format($actual_payslip_snwot_ot_with_out_nd_value,$payslip_decimal_place);   
        }else{

        }      

		$actual_payslip_snwot_ot_withnd_value=$payslip_values->snwot_ot_withnd_value;
              
        if($actual_payslip_snwot_ot_withnd_value>0){
             $actual_payslip_snwot_ot_withnd_value=number_format($actual_payslip_snwot_ot_withnd_value,$payslip_decimal_place);
        }else{

        }        

		$actual_payslip_snw_rd_ot_with_out_nd_value=$payslip_values->snw_rd_ot_with_out_nd_value;
               
        if($actual_payslip_snw_rd_ot_with_out_nd_value>0){
            $actual_payslip_snw_rd_ot_with_out_nd_value=number_format($actual_payslip_snw_rd_ot_with_out_nd_value,$payslip_decimal_place);       
        }else{

        } 

		$actual_payslip_snw_rd_ot_withnd_value=$payslip_values->snw_rd_ot_withnd_value;
              
        if($actual_payslip_snw_rd_ot_withnd_value>0){
             $actual_payslip_snw_rd_ot_withnd_value=number_format($actual_payslip_snw_rd_ot_withnd_value,$payslip_decimal_place);
        }else{

        }        

		$actual_payslip_snw_rd_ot_ot_with_out_nd_value=$payslip_values->snw_rd_ot_ot_with_out_nd_value;
              
        if($actual_payslip_snw_rd_ot_ot_with_out_nd_value>0){
             $actual_payslip_snw_rd_ot_ot_with_out_nd_value=number_format($actual_payslip_snw_rd_ot_ot_with_out_nd_value,$payslip_decimal_place);        
        }else{

        }

		$actual_payslip_snw_rd_ot_ot_withnd_value=$payslip_values->snw_rd_ot_ot_withnd_value;
                 
        if($actual_payslip_snw_rd_ot_ot_withnd_value>0){
             $actual_payslip_snw_rd_ot_ot_withnd_value=number_format($actual_payslip_snw_rd_ot_ot_withnd_value,$payslip_decimal_place);     
        }else{

        }


        $actual_payslip_shift_night_diff=$payslip_values->shift_night_diff;
             
        if($actual_payslip_shift_night_diff>0){
             $actual_payslip_shift_night_diff=number_format($actual_payslip_shift_night_diff,$payslip_decimal_place);   
        }else{

        }      

        $actual_payslip_cola=$payslip_values->cola;
         
        if($actual_payslip_cola>0){
             $actual_payslip_cola=number_format($actual_payslip_cola,$payslip_decimal_place);      
        }else{

        }       


        $actual_payslip_other_addition_taxable=$payslip_values->other_addition_taxable;
              
        // if($actual_payslip_other_addition_taxable>0){
        //      $actual_payslip_other_addition_taxable=number_format($actual_payslip_other_addition_taxable,$payslip_decimal_place);
        // }else{

        // }        

        $actual_payslip_other_addition_non_tax=$payslip_values->other_addition_non_tax;
             
        // if($actual_payslip_other_addition_non_tax>0){
        //       $actual_payslip_other_addition_non_tax=number_format($actual_payslip_other_addition_non_tax,$payslip_decimal_place);
        // }else{

        // }        

        $total_oa=$actual_payslip_other_addition_taxable+$actual_payslip_other_addition_non_tax;
        
        if($total_oa>0){
             $total_oa=number_format($total_oa,$payslip_decimal_place);          
        }else{

        }    


        $actual_payslip_oa_taxable_how_to=$payslip_values->posted_oa_taxable_how_to_clean;
        $actual_payslip_oa_nontax_how_to=$payslip_values->posted_oa_nontax_how_to_clean;
        
        $actual_payslip_other_deduction_taxable=$payslip_values->other_deduction_taxable;
              
        if($actual_payslip_other_deduction_taxable>0){
             $actual_payslip_other_deduction_taxable=number_format($actual_payslip_other_deduction_taxable,$payslip_decimal_place);
        }else{

        }        

        $actual_payslip_other_deduction_nontax=$payslip_values->other_deduction_nontax;
             
        if($actual_payslip_other_deduction_nontax>0){
              $actual_payslip_other_deduction_nontax=number_format($actual_payslip_other_deduction_nontax,$payslip_decimal_place);
        }else{

        }        

        $total_od=$actual_payslip_other_deduction_taxable+$actual_payslip_other_deduction_nontax;
       
        if($total_od>0){
             $total_od=number_format($total_od,$payslip_decimal_place);          
        }else{

        }     


        $actual_payslip_od_taxable_how_to=$payslip_values->posted_od_taxable_how_to_clean;
        $actual_payslip_od_nontax_how_to=$payslip_values->posted_od_nontax_how_to_clean;



        $actual_payslip_gross=$payslip_values->gross;
         
        if($actual_payslip_gross>0){
             $actual_payslip_gross=number_format($actual_payslip_gross,$payslip_decimal_place);        
        }else{

        }     

        
        $actual_payslip_loan=$payslip_values->loan;
               
        if($actual_payslip_loan>0){
             $actual_payslip_loan=number_format($actual_payslip_loan,$payslip_decimal_place); 
        }else{

        }      


        $actual_payslip_sss_employee=$payslip_values->sss_employee;
            
        if($actual_payslip_sss_employee>0){
            $actual_payslip_sss_employee=number_format($actual_payslip_sss_employee,$payslip_decimal_place);   
        }else{

        }        

        $actual_payslip_sss_employer=$payslip_values->sss_employer;      
          
        if($actual_payslip_sss_employer>0){
             $actual_payslip_sss_employer=number_format($actual_payslip_sss_employer,$payslip_decimal_place);     
        }else{

        }       

        $actual_payslip_philhealth_employee=$payslip_values->philhealth_employee;
                
        if($actual_payslip_philhealth_employee>0){
            $actual_payslip_philhealth_employee=number_format($actual_payslip_philhealth_employee,$payslip_decimal_place); 
        }else{

        }      

        $actual_payslip_philhealth_employer=$payslip_values->philhealth_employer;
               
        if($actual_payslip_philhealth_employer>0){
             $actual_payslip_philhealth_employer=number_format($actual_payslip_philhealth_employer,$payslip_decimal_place); 
        }else{

        }      

        $actual_payslip_pagibig=$payslip_values->pagibig;
             
        if($actual_payslip_pagibig>0){
             $actual_payslip_pagibig=number_format($actual_payslip_pagibig,$payslip_decimal_place);    
        }else{

        }     


        $actual_payslip_absent=$payslip_values->absent;
                
        if($actual_payslip_absent>0){
             $actual_payslip_absent=number_format($actual_payslip_absent,$payslip_decimal_place); 
        }else{  

        }     

        $actual_payslip_late=$payslip_values->late;
                  
        if($actual_payslip_late>0){
            $actual_payslip_late=number_format($actual_payslip_late,$payslip_decimal_place);   
        }else{

        }  

        $actual_payslip_undertime=$payslip_values->undertime;
         
        if($actual_payslip_undertime>0){
            $actual_payslip_undertime=number_format($actual_payslip_undertime,$payslip_decimal_place);        
        }else{

        }      

        $actual_payslip_overbreak=$payslip_values->overbreak;
          
        if($actual_payslip_overbreak>0){
            $actual_payslip_overbreak=number_format($actual_payslip_overbreak,$payslip_decimal_place);       
        }else{

        }      


        $actual_payslip_taxable=$payslip_values->taxable;
            
        if($actual_payslip_taxable>0){
             $actual_payslip_taxable=number_format($actual_payslip_taxable,$payslip_decimal_place);   
        }else{

        }       

        $actual_payslip_wtax=$payslip_values->wtax;
            
        if($actual_payslip_wtax>0){
              $actual_payslip_wtax=number_format($actual_payslip_wtax,$payslip_decimal_place);    
        }else{

        }     

        $actual_payslip_income_total=$payslip_values->income_total;
              
        if($actual_payslip_income_total>0){
             $actual_payslip_income_total=number_format($actual_payslip_income_total,$payslip_decimal_place);   
        }else{

        }     

        $actual_payslip_deduction_total=$payslip_values->deduction_total;
               
        if($actual_payslip_deduction_total>0){
            $actual_payslip_deduction_total=number_format($actual_payslip_deduction_total,$payslip_decimal_place);   
        }else{

        }     

        $actual_payslip_netpay=$payslip_values->net_pay;
             
        if($actual_payslip_netpay>0){
             $actual_payslip_netpay=number_format($actual_payslip_netpay,$payslip_decimal_place);   
        }else{

        }      

        $tax_deduction_type_name=$payslip_values->tax_deduction_type_name;
        $assumed_taxable_monthly=$payslip_values->assumed_taxable_monthly;
        
        if($assumed_taxable_monthly>0){
            $assumed_taxable_monthly=number_format($assumed_taxable_monthly,$payslip_decimal_place);        
        }else{

        }       

        $assumed_taxable_yearly=$payslip_values->assumed_taxable_yearly;
       
        if($assumed_taxable_yearly>0){
             $assumed_taxable_yearly=number_format($assumed_taxable_yearly,$payslip_decimal_place);        
        }else{

        }       


        $assumed_tax_in_a_year=$payslip_values->assumed_tax_in_a_year;
              
        if($assumed_tax_in_a_year>0){
            $assumed_tax_in_a_year=number_format($assumed_tax_in_a_year,$payslip_decimal_place);   
        }else{

        }      

        $assumed_tax_in_a_month=$payslip_values->assumed_tax_in_a_month;
        if($assumed_tax_in_a_month>0){
             $assumed_tax_in_a_month=number_format($assumed_tax_in_a_month,$payslip_decimal_place);     
        }else{

        }
        $assumed_tax_in_a_cutoff=$payslip_values->assumed_tax_in_a_cutoff;
        if($assumed_tax_in_a_cutoff>0){
             $assumed_tax_in_a_cutoff=number_format($assumed_tax_in_a_cutoff,$payslip_decimal_place);        
        }else{

        }
       

// ==================================== Start User Interface Type 1
if($actual_payslip_design=="117"){ // see system_parameters 

echo 
'
<tr>
    <td width="50%">
        <table>
            <tr>
                <td width="33.33333333%"><span class="payslip_main_header_1">EARNINGS</span></td>
                <td><span class="payslip_main_header_1">DAY(s) / HOURS</span></td>
                <td><span class="payslip_main_header_1">AMOUNT</span></td>
            </tr>
            <tr>
                <td>Salary</td>
                <td>'.$actual_payslip_salary_ratename.'</td>
                <td>'.$actual_payslip_salary_amount.'</td>
            </tr>
            <tr>
                <td colspan="2">Net Basic</td>
                <td>'.$actual_payslip_basic.'</td>
            </tr> 
            <tr>
                <td>Leave</td>
                <td>_</td>
                <td>'.$actual_payslip_leave_basic.'</td>
            </tr>                       
            <tr>
                <td>Basic <i>(less leave)</i></td>
                <td>_</td>
                <td>'.$basic_minus_leave_basic.'</td>
            </tr>


            <tr>
                <td colspan="2">Nontax Allowance</td>
                <td>'.$actual_payslip_other_addition_non_tax.'</td>
            </tr>
            <tr>
                <td colspan="2">Taxable Allowance</td>
                <td>'.$actual_payslip_other_addition_taxable.'</td>
            </tr>
            <tr>
                <td colspan="2">COLA</td>
                <td>'.$actual_payslip_cola.'</td>
            </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
        <tr>
            <td colspan="3"><span class="payslip_main_header_1">LEAVE USED</span></td>
        </tr>  
        <tr>
            <td>VL</td>
            <td>'.$vl_leave_used.'</td>
        </tr>
        <tr>
            <td>SL</td>
            <td>'.$sl_leave_used.'</td>
        </tr>
        <tr>
            <td>Other Leave</td>
            <td>'.$ol_leave_used.'</td>
        </tr>


            
        </table>
        
    </td>
    <td style="background-color:#fff;">
        <table >
            <tr>
                <td width="20%"><span class="payslip_main_header_1">DEDUCTIONS</span></td>
                <td width="20%"><span class="payslip_main_header_1">AMOUNT</span></td>
                <td width="20%"><span class="payslip_main_header_1">YTD</span></td>
            </tr>
            <tr>
                <td>SSS</td>
                <td>'.$actual_payslip_sss_employee.'</td>
                <td>'.$payslip_ytd_sss.'</td>
            </tr>
            <tr>
                <td>PHILHEALTH</td>
                <td>'.$actual_payslip_philhealth_employee.'</td>
                <td>'.$payslip_ytd_philhealth.'</td>
            </tr>
            <tr>
                <td>PAGIBIG</td>
                <td>'.$actual_payslip_pagibig.'</td>
                <td>'.$payslip_ytd_pagibig.'</td>
            </tr>
            <tr>
                <td>WTAX (taxcode: '.$payslip_wtax_code.')</td>
                <td>'.$actual_payslip_wtax.'</td>
                <td>'.$payslip_ytd_wtax.'</td>
            </tr>
';
if($tax_deduction_type_name=="Annualize tax"){
echo '
        <tr >
            <td><span class="annualize">Annualize Wtax Details</span></td>
            <td>
          <span class="annualize">  Assumed wtax in a year: <br>
            Assumed wtax in a month: <br>
            Assumed wtax in a payroll period: </span>
            </td>
            <td>
              <span class="annualize">  '.$assumed_tax_in_a_year.'<br>'.$assumed_tax_in_a_month.'<br>'.$assumed_tax_in_a_cutoff.'</span>
            </td>
        </tr>

';
}else{

}

echo '<tr>
                <td>ABSENT</td>
                <td>'.$actual_payslip_absent.'</td>
            </tr>
            <tr>
                <td>LATE</td>
                <td>'.$actual_payslip_late.'</td>
            </tr>
            <tr>
                <td>UNDERTIME</td>
                <td>'.$actual_payslip_undertime.'</td>
            </tr>
            <tr>
                <td>OVERBREAK</td>
                <td>'.$actual_payslip_overbreak.'</td>
            </tr>
        </table>
    </td>
    <td style="background-color:#fff;width:30%;">
        <table>
            <tr>
                <td ><span class="payslip_main_header_1">OTHER ADDITIONS</span></td>
            </tr>';

            if($total_oa=="0"){
echo '
			<tr>
				<td>=====none=====</td>
			</tr>
			';
            }else{


echo '
            <tr>
                 <td><span class="payslip_main_header_1">TAXABLE</span></td>
                 <td><span class="payslip_main_header_1">NON-TAXABLE</span></td>
            </tr>  
            <tr>
                 <td>'.$actual_payslip_oa_taxable_how_to.'</td>
                 <td>'.$actual_payslip_oa_nontax_how_to.'</td>
            </tr>  
            <tr><td>&nbsp;</td></tr>            
            <tr>
                <td><span class="payslip_main_header_1">TOTAL: '.$total_oa.'</span></td>
            </tr>  ';
            
            }

echo '
        </table>
    </td>
</tr>
<tr>
    <td>
        <table>
        <tr>
            <td width="30%"><span class="payslip_main_header_1">OVERTIME BREAKDOWN </span></td>
            <td width="15%"><span class="payslip_main_header_1">REGULAR</span></td>
            <td width="15%"><span class="payslip_main_header_1">OVERTIME</span></td>
            <td width="18%"><span class="payslip_main_header_1">REGULAR w/ ND </span></td>
            <td width="18%"><span class="payslip_main_header_1">OVERTIME w/ ND</span></td>
        </tr>
        <tr>
            <td>Regular</td>
            <td>'.$actual_payslip_regot_value.'</td>
            <td>&nbsp;</td>
            <td>'.$actual_payslip_regotnd_value.'</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Restday</td>
            <td>'.$actual_payslip_rdot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rdot_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rdot_withnd_value.' </td>
            <td>'.$actual_payslip_rdot_ot_withnd_value.'</td>
        </tr>
        <tr>
            <td>Regular Holiday</td>
            <td>'.$actual_payslip_rhot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rhot_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rhot_withnd_value.' </td>
            <td>'.$actual_payslip_rhot_ot_withnd_value.'</td>
        </tr>
        <tr>
            <td>Restday-Regular Holiday Type 2</td>
            <td>'.$actual_payslip_rh_rdt2_value.'</td>
            <td>&nbsp;</td>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Restday-Regular Holiday Type 1</td>
            <td>'.$actual_payslip_rh_rdt1_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rh_rdt1_ot_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rh_rdt1_ot_withnd_value.'</td>
            <td>'.$actual_payslip_rh_rdt1_ot_ot_withnd_value.'</td>
        </tr>

        <tr>
            <td>Special Holiday</td>
            <td>'.$actual_payslip_snwot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_snwot_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_snwot_withnd_value.' </td>
            <td>'.$actual_payslip_snwot_ot_withnd_value.'</td>
        </tr>        
        <tr>
            <td>Restday-Special Holiday</td>
            <td>'.$actual_payslip_snw_rd_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_snw_rd_ot_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_snw_rd_ot_withnd_value.' </td>
            <td>'.$actual_payslip_snw_rd_ot_ot_withnd_value.'</td>
        </tr>  
        <tr>
            <td>Working Schedule ND</td>
            <td>'.$actual_payslip_shift_night_diff.'</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>    
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>

        <tr>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><span class="payslip_main_header_1"> TOTAL OVERTIME</span> </td>
            <td>'.$actual_payslip_overtime.'</td>
        </tr>    
        <tr>
            <td>&nbsp;</td>
            <td><span class="payslip_main_header_1">AMOUNT </span></td>
            <td><span class="payslip_main_header_1">YTD </span></td>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
        </tr>    
        <tr>
            <td><span class="payslip_main_header_1">GROSS </span></td>
            <td>'.$actual_payslip_gross.'</td>
            <td>'.$payslip_ytd_gross.'</td>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
        </tr> 
        <tr>
            <td><span class="payslip_main_header_1">TAXABLE </span></td>
            <td>'.$actual_payslip_taxable.'</td>
            <td>'.$payslip_ytd_taxable.'</td>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
        </tr>
';

if($tax_deduction_type_name=="Annualize tax"){
 echo '       <tr>
            <td><span class="annualize">ANNUALIZE TAXABLE DETAILS</span></td>
            <td colspan="3"><span class="annualize">ASSUMED TAXABLE MONTHLY : '.$assumed_taxable_monthly.'<br>
            ASSUMED TAXABLE YEARLY : '.$assumed_taxable_yearly.'
            </span></td>

        </tr>';
}else{}

echo '

        </table>
    </td>
    <td>
        <table>
        <tr>
                <td><span class="payslip_main_header_1">LOAN(s)</span></td>
                <td><span class="payslip_main_header_1">PAYMENT NO.</span></td>
                <td><span class="payslip_main_header_1">AMOUNT</span></td>
                <td><span class="payslip_main_header_1">BALANCE(s)</span></td>
        </tr>';


    $show_posted_loan=$this->payroll_generate_payslip_model->view_posted_loan($check_payroll_period_id,$company_id,$employee_id,$month_cover);
    if(!empty($show_posted_loan)){
    	foreach($show_posted_loan as $pl){

            if($pl->system_deduction>0){
                $l_system_deduction=number_format($pl->system_deduction,$payslip_decimal_place);   
            }else{               
                $l_system_deduction=$pl->system_deduction;
            }
            if($pl->current_balance>0){
                $l_current_balance=number_format($pl->current_balance,$payslip_decimal_place);   
            }else{               
                $l_current_balance=$pl->current_balance;
            }
			echo '
			        <tr>
			                <td>'.$pl->loan_type.'</td>
			                <td>'.$pl->payment_no.'</td>
			                <td>'.$l_system_deduction.'</td>
			                <td>'.$l_current_balance.'</td>
			        </tr>
			';
    	}
echo '  <tr>
                <td><span class="payslip_main_header_1">TOTAL</span></td>
                <td>&nbsp;</td>
                <td>-</td>
                <td>&nbsp;</td>
        </tr>';

    }else{
echo '
		<tr>
			<td >=====none=====</td>
			<td >=====none=====</td>
			<td >=====none=====</td>
			<td >=====none=====</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>	
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>	
		<tr><td>&nbsp;</td></tr>	
		';
    }

echo '


        </table>
        
    </td>
    <td>
        <table>
            <tr>
                <td><span class="payslip_main_header_1">OTHER DEDUCTION(s)</span></td>
            </tr>';

			if($total_od=="0"){
				$od_break_2="";
				$od_break_1="";
			echo 
				'
				<tr><td>=====none=====</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				';
			}else{


echo '
            <tr>
                 <td><span class="payslip_main_header_1">TAXABLE</span></td>
                 <td><span class="payslip_main_header_1">NON-TAXABLE</span></td>
            </tr>  
            <tr>
                 <td>'.$actual_payslip_od_taxable_how_to.'</td>
                 <td>'.$actual_payslip_od_nontax_how_to.'</td>
            </tr>  
            <tr><td>&nbsp;</td></tr>            
            <tr>
                <td><span class="payslip_main_header_1">TOTAL: '.$total_od.'</span></td>
            </tr>  ';


            }

echo '
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td><span class="payslip_main_header_1">TOTAL EARNING(s)</span></td>
                <td>'.$actual_payslip_income_total.'</td>
            </tr>
            <tr>
                <td><span class="payslip_main_header_1">TOTAL DEDUCTION(s)</span></td>
                <td>'.$actual_payslip_deduction_total.'</td>
            </tr>
            <tr>
                <td><span class="payslip_main_header_1">NET PAY</span></td>
                <td>'.$actual_payslip_netpay.'</td>
            </tr>

        </table>
    </td>
</tr>';

echo '<tr>
	<td colspan="3">
		<div style="text-align:center;">
			<span style="font-weight:bold;">I acknowledge to have received the amount stated here within with no further claim for services rendered. </span>';
if(($ispayslip_viewed=="1")AND($show_emp_electronic_sign=="yes")){
	if($emp_electronic_signature==""){
		$emp_electronic_signature="noee.png";
		$emp_ee_height="";
	}else{
		$emp_ee_height="50";
	}


	echo '<br><img src="'.base_url().'/public/employee_files/electronic_signature/'.$emp_electronic_signature.'" class="img-rounded" id="company_logo" width="250" height="'.$emp_ee_height.'">';
    echo '<br>________________________________<br>'.$name.'</div>';
}else{
	echo '<br>________________________________<br>'.$name;
}
echo 
'		
		
	</td>
</tr>
';


// ==================================== End User Interface Type 1
}elseif($actual_payslip_design=="118"){ // see system_parameters 
   
echo 
'
<tr>
    <td width="50%">
    <table>
        <tr>
            <td><span class="payslip_main_header_1">EARNINGS</span></td>
            <td><span class="payslip_main_header_1">AMOUNT</span></td>
        </tr>
        <tr>
            <td>SALARY</td>
            <td colspan="2">'.$actual_payslip_salary_ratename.': '.$actual_payslip_salary_amount.'</td>
        </tr>
        <tr>
            <td>NET BASIC</td>
            <td>'.$actual_payslip_basic.'</td>

        </tr>
        <tr>
            <td>LEAVE</td>
            <td>'.$actual_payslip_leave_basic.'</td>

        </tr>
        <tr>
            <td>BASIC <i>(less leave)</i></td>
            <td>'.$basic_minus_leave_basic.'</td>

        </tr>
        <tr>
            <td>NON-TAXABLE ALLOWANCE</td>
            <td>'.$actual_payslip_other_addition_non_tax.'</td>

        </tr>
        <tr>
            <td>TAXABLE ALLOWANCE</td>
            <td>'.$actual_payslip_other_addition_taxable.'</td>

        </tr>
        <tr>
            <td>COLA</td>
            <td>'.$actual_payslip_cola.'</td>

        </tr>
        <tr>
            <td>OVERTIME</td>
            <td>'.$actual_payslip_overtime.'</td>

        </tr>

        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
        <tr>
            <td colspan="3"><span class="payslip_main_header_1">LEAVE USED</span></td>
        </tr>  
        <tr>
            <td>VL</td>
            <td>'.$vl_leave_used.'</td>
        </tr>
        <tr>
            <td>SL</td>
            <td>'.$sl_leave_used.'</td>
        </tr>
        <tr>
            <td>Other Leave</td>
            <td>'.$ol_leave_used.'</td>
        </tr>


        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
        <tr>
            <td colspan="3"><span class="payslip_main_header_1">EARNINGS BREAK DOWN</span></td>
        </tr>  
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 

        <tr>
            <td width="30%"><span class="payslip_main_header_1">OVERTIME BREAKDOWN </span></td>
            <td width="15%"><span class="payslip_main_header_1">REGULAR</span></td>
            <td width="15%"><span class="payslip_main_header_1">OVERTIME</span></td>
            <td width="18%"><span class="payslip_main_header_1">REGULAR w/ ND </span></td>
            <td width="18%"><span class="payslip_main_header_1">OVERTIME w/ ND</span></td>
        </tr>
        <tr>
            <td>Regular</td>
            <td>'.$actual_payslip_regot_value.'</td>
            <td>&nbsp;</td>
            <td>'.$actual_payslip_regotnd_value.'</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Restday</td>
            <td>'.$actual_payslip_rdot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rdot_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rdot_withnd_value.' </td>
            <td>'.$actual_payslip_rdot_ot_withnd_value.'</td>
        </tr>
        <tr>
            <td>Regular Holiday</td>
            <td>'.$actual_payslip_rhot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rhot_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rhot_withnd_value.' </td>
            <td>'.$actual_payslip_rhot_ot_withnd_value.'</td>
        </tr>
        <tr>
            <td>Restday-Regular Holiday Type 2</td>
            <td>'.$actual_payslip_rh_rdt2_value.'</td>
            <td>&nbsp;</td>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Restday-Regular Holiday Type 1</td>
            <td>'.$actual_payslip_rh_rdt1_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rh_rdt1_ot_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_rh_rdt1_ot_withnd_value.'</td>
            <td>'.$actual_payslip_rh_rdt1_ot_ot_withnd_value.'</td>
        </tr>

        <tr>
            <td>Special Holiday</td>
            <td>'.$actual_payslip_snwot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_snwot_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_snwot_withnd_value.' </td>
            <td>'.$actual_payslip_snwot_ot_withnd_value.'</td>
        </tr>        
        <tr>
            <td>Restday-Special Holiday</td>
            <td>'.$actual_payslip_snw_rd_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_snw_rd_ot_ot_with_out_nd_value.'</td>
            <td>'.$actual_payslip_snw_rd_ot_withnd_value.' </td>
            <td>'.$actual_payslip_snw_rd_ot_ot_withnd_value.'</td>
        </tr>  
        <tr>
            <td>Working Schedule ND</td>
            <td>'.$actual_payslip_shift_night_diff.'</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr> 
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
        <tr>
            <td ><span class="payslip_main_header_1">OTHER ADDITION(s)</span></td>
            <td colspan="2">TAXABLE</td>
            <td >NON-TAXABLE</td>
        </tr>  
        <tr>
            <td >&nbsp;</td>
            <td colspan="2">'.$actual_payslip_oa_taxable_how_to.'</td>
            <td >'.$actual_payslip_oa_nontax_how_to.'</td>
        </tr>  
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>         
        <tr>
            <td><span class="payslip_main_header_1">TOTAL EARNINGS</span></td>
            <td colspan="2">'.$actual_payslip_income_total.'</td>
        </tr>

    </table>
    </td>

    <td valign="top">
    <table>
        <tr>
            <td><span class="payslip_main_header_1">DEDUCTIONS</span></td>
            <td><span class="payslip_main_header_1">AMOUNT</span></td>
            <td><span class="payslip_main_header_1">YTD</span></td>
        </tr>
        <tr>
            <td>SSS</td>
            <td>'.$actual_payslip_sss_employee.'</td>
            <td>'.$payslip_ytd_sss.'</td>
        </tr>
        <tr>
            <td>PHILHEALTH</td>
            <td>'.$actual_payslip_philhealth_employee.'</td>
            <td>'.$payslip_ytd_philhealth.'</td>
        </tr>
        <tr>
            <td>PAGIBIG</td>
            <td>'.$actual_payslip_pagibig.'</td>
            <td>'.$payslip_ytd_pagibig.'</td>
        </tr>
        <tr>
            <td>WTAX (taxcode: '.$payslip_wtax_code.')</td>
            <td>'.$actual_payslip_wtax.'</td>
            <td>'.$payslip_ytd_wtax.'</td>
        </tr>
';
if($tax_deduction_type_name=="Annualize tax"){
echo '
        <tr >
            <td><span class="annualize">Annualize Wtax Details</span></td>
            <td>
          <span class="annualize">  Assumed wtax in a year: <br>
            Assumed wtax in a month: <br>
            Assumed wtax in a payroll period: </span>
            </td>
            <td>
              <span class="annualize">  '.$assumed_tax_in_a_year.'<br>'.$assumed_tax_in_a_month.'<br>'.$assumed_tax_in_a_cutoff.'</span>
            </td>
        </tr>
';
}else{

}

echo '        <tr>
            <td>ABSENT</td>
            <td>'.$actual_payslip_absent.'</td>
            <td>-</td>
        </tr>
        <tr>
            <td>LATE</td>
            <td>'.$actual_payslip_late.'</td>
            <td>-</td>
        </tr>
        <tr>
            <td>UNDERTIME</td>
            <td>'.$actual_payslip_undertime.'</td>
            <td>-</td>
        </tr>
        <tr>
            <td>OVERBREAK</td>
            <td>'.$actual_payslip_overbreak.'</td>
            <td>-</td>
        </tr>
        <tr>
            <td>OTHER DEDUCTION</td>
            <td>'.$total_od.'</td>
            <td>-</td>
        </tr>
        <tr>
            <td>LOAN</td>
            <td>'.$actual_payslip_loan.'</td>
            <td>-</td>
        </tr>

        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
        <tr>
            <td colspan="3"><span class="payslip_main_header_1">DEDUCTIONS BREAK DOWN</span></td>
        </tr>  
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
        ';

    $show_posted_loan=$this->payroll_generate_payslip_model->view_posted_loan($check_payroll_period_id,$company_id,$employee_id,$month_cover);
echo '       

            <tr>
                <td><span class="payslip_main_header_1">LOAN BREAKDOWN/TYPE</span></td>
                <td><span class="payslip_main_header_1">PAYMENT NO.</span></td>
                <td><span class="payslip_main_header_1">AMORTIZATION</span></td>
                <td><span class="payslip_main_header_1">BALANCE</span></td>
            </tr>
            '; 
    if(!empty($show_posted_loan)){
       
        foreach($show_posted_loan as $pl){

            if($pl->system_deduction>0){
                $l_system_deduction=number_format($pl->system_deduction,$payslip_decimal_place);   
            }else{               
                $l_system_deduction=$pl->system_deduction;
            }
            if($pl->current_balance>0){
                $l_current_balance=number_format($pl->current_balance,$payslip_decimal_place);   
            }else{               
                $l_current_balance=$pl->current_balance;
            }
            
            echo '
                    <tr>
                            <td>'.$pl->loan_type.'</td>
                            <td>'.$pl->payment_no.'</td>
                            <td>'.$l_system_deduction.'</td>
                            <td>'.$l_current_balance.'</td>
                    </tr>
            ';
        }
    }else{
echo '       <tr>
                <td colspan="4" style="text-align:center;">none</td>
            </tr>';
    }

echo '
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 

        <tr>
            <td ><span class="payslip_main_header_1">OTHER DEDUCTION(s)</span></td>
            <td colspan="2">TAXABLE</td>
            <td >NON-TAXABLE</td>
        </tr>  ';

if($total_od>0){
 echo '       <tr>
            <td >&nbsp;</td>
            <td colspan="2">'.$actual_payslip_od_taxable_how_to.'</td>
            <td >'.$actual_payslip_od_nontax_how_to.'</td>
        </tr> 
  ';
}else{

 echo '       <tr>
            <td >&nbsp;</td>
            <td >none</td>
            <td>&nbsp;</td>
            <td >none</td>
        </tr> 
  ';
}


  echo '       
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>         
        <tr>
            <td><span class="payslip_main_header_1">TOTAL DEDUCTIONS</span></td>
            <td colspan="2">'.$actual_payslip_deduction_total.'</td>
        </tr> 


';

  echo  '</table>
    </td>

</tr>
<tr>

<td>
    <table>
        <tr>
            <td><span class="payslip_main_header_1">GROSS : '.$actual_payslip_gross.'</span></td>
            <td><span class="payslip_main_header_1">GROSS YTD : '.$payslip_ytd_gross.'</span></td>

        </tr>
        <tr>
            <td><span class="payslip_main_header_1">TAXABLE : '.$actual_payslip_taxable.'</span></td>
            <td><span class="payslip_main_header_1">TAXABLE YTD : '.$payslip_ytd_taxable.'</span></td>

        </tr>
';

if($tax_deduction_type_name=="Annualize tax"){
 echo '       <tr>
            <td><span class="annualize">ANNUALIZE TAXABLE DETAILS</span></td>
            <td><span class="annualize">ASSUMED TAXABLE MONTHLY : '.$assumed_taxable_monthly.'<br>
            ASSUMED TAXABLE YEARLY : '.$assumed_taxable_yearly.'
            </span></td>

        </tr>';
}else{}

echo '

        <tr>
            <td><span class="payslip_main_header_1">NET PAY : '.$actual_payslip_netpay.'</span></td>
            <td colspan=""></td>
        </tr>
    </table>

</td>

<td >

    <table>
        <tr>
            <td style="text-align:center;"><span class="payslip_main_header_1">
';
  if($this->session->userdata('is_employee')=="1"){
    if($ispayslip_viewed=="1"){
        // already acknowledge
    }else{
    echo '
            <a href="'.base_url().'employee_portal/my_payslip/manual_acknowledge_payslip/'.$pay_period.'/'.$month_cover.'" type="button" class="btn btn-success" />Acknowledge?</a> <br>
        ';        
    }

  }else{

  }
  echo '          I acknowledge to have received the amount stated here within with no further claim for services rendered. </span></td>
        </tr>';
if(($ispayslip_viewed=="1")AND($show_emp_electronic_sign=="yes")){
    if($emp_electronic_signature==""){
        $emp_electronic_signature="noee.png";
        $emp_ee_height="";
    }else{
        $emp_ee_height="50";
    }
echo'        
        <tr>
            <td style="text-align:center;"><img src="'.base_url().'/public/employee_files/electronic_signature/'.$emp_electronic_signature.'" class="img-rounded" id="company_logo" width="250" height="'.$emp_ee_height.'"></td>
        </tr>';

}elseif(($ispayslip_viewed=="1")AND($show_emp_electronic_sign=="no")){
echo'        
        <tr>
            <td style="text-align:center;"><span class="payslip_main_header_1">_____________(already acknowledge)_____________ </span></td>
        </tr>';
}else{
echo'        
        <tr>
            <td style="text-align:center;"><span class="payslip_main_header_1">________________________________ </span></td>
        </tr>';
}




echo '        
        <tr>
            <td style="text-align:center;"><span class="payslip_main_header_1">'.$name.' </span></td>
        </tr>

    </table>


</td>

</tr>


';












}else{ // check customized column design.


}
// ==================================== Start User Interface Type 2
// ==================================== End User Interface Type 2


    }else{
    	$actual_payslip_state="none";

   if($this->session->userdata('is_employee')=="1"){
    $show_how_to_post_payslip="";
   }else{
    $show_how_to_post_payslip="    <i class='fa fa-quote-left text-info' style='font-size:20px;'></i>
    <span class='system_auto_guide'>go to payroll > generate payslip</span>
    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>";
   }

    echo "
    <tr>
    <td colspan='6'><i class='fa fa-close text-danger' style='font-size:48px;'></i>Payroll is not yet posted.
".$show_how_to_post_payslip."
    </td>
    </tr>";
    }




?>

