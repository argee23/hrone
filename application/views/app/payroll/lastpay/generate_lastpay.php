<?php
$company_id=$this->input->post('company_id');
//============================================GET COMPANY PAYROLL THEME============================================
require_once(APPPATH.'views/app/payroll/13th_month/check_general_setup.php');


?>
<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    <style type="text/css">
        .payroll_center{
            text-align: center;
        }
.datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 10px/100% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 1px solid <?php echo $bg_color_genpay;?>; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, <?php echo $bg_color_genpay;?>), color-stop(1, <?php echo $overlay_genpay;?>) );background:-moz-linear-gradient( center top, <?php echo $bg_color_genpay;?> 5%, <?php echo $overlay_genpay;?> 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_genpay;?>', endColorstr='<?php echo $overlay_genpay;?>');background-color:<?php echo $bg_color_genpay;?>; color:<?php echo $font_color_genpay;?>; font-size: 15px; font-weight: bold; border-left: 1px solid #0070A8; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #00496B; border-left: 1px solid #E1EEF4;font-size: 12px;font-weight: normal; }.datagrid table tbody .alt td { background: #E1EEF4; color: #00496B; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid <?php echo $bg_color_genpay;?>;background: #E1EEF4;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: <?php echo $font_color_genpay;?>;border: 1px solid <?php echo $bg_color_genpay;?>;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, <?php echo $bg_color_genpay;?>), color-stop(1, <?php echo $overlay_genpay;?>) );background:-moz-linear-gradient( center top, <?php echo $bg_color_genpay;?> 5%, <?php echo $overlay_genpay;?> 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_genpay;?>', endColorstr='<?php echo $overlay_genpay;?>');background-color:<?php echo $bg_color_genpay;?>; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: <?php echo $bg_color_genpay;?>; color: <?php echo $font_color_genpay;?>; background: none; background-color:<?php echo $overlay_genpay;?>;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }
.datagrid{
    width: 100%;
 margin: auto;
}
.topic_class{
    width: 18%;
}
.amount_class{
    width: 10%;
}

.shift_time{
    background-color: #F9D4BD;
}
.actual_time{
    background-color: #D9F9BD;
}
.hours_worked{
    background-color: #BDF9EE;

}
.locked_prompt_class{
    font-size: 1.5em;
    height: 100px;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
    line-height: 100px; 
    color: #ff0000;
}
.locked_prompt_class_span{
    color:#000;font-style: italic;text-transform: lowercase; 
}

.warning_payroll_status{
    color:#ff0000;font-size:1.5em;
}
.system_auto_guide{
    font-style: italic;
    font-weight: bold;
}

/*PAYSLIP*/
.payslip_main_header_1{

    color:#000;
    font-weight: bold;
    font-size: 1em;
}

/*last pay*/

.center_Topic{
    text-align: center !important;
}
.salhis_td{
    width: 25%;
}
.justBold{
    font-weight: bold;
}
.titleBG{
    background-color: #98D3F4;
}
/*last pay*/



    </style>    
</head>

<?php


if($incomplete_options>0){

    echo "$incomplete_options_notice";

}else{

$wDivision=$company_info->wDivision;
$company_name=$company_info->company_name;
$company_logo=$company_info->logo;

$pay_type=$this->input->post('pay_type');
$pay_type_group=$this->input->post('pay_type_group');
$selected_payroll_option=$this->input->post('payroll_option');

$pay_period=$this->input->post('pay_period');
$division=$this->input->post('division');
$department=$this->input->post('department');
$section=$this->input->post('section');


//============================================PAYROLL PERIOD VARIABLE LISTS============================================
if(!empty($pay_period_info)){

$month_from=$pay_period_info->month_from;
$day_from=$pay_period_info->day_from;
$year_from=$pay_period_info->year_from;
$pay_period_from=$year_from."-".$month_from."-".$day_from;

$month_to=$pay_period_info->month_to;
$day_to=$pay_period_info->day_to;
$year_to=$pay_period_info->year_to; 
$pay_period_to=$year_to."-".$month_to."-".$day_to;

$year_cover=$pay_period_info->year_cover;
$month_cover=$pay_period_info->month_cover;
$cut_off=$pay_period_info->cut_off;

$period_no_of_days=$pay_period_info->no_of_days;


}else{} // no payroll period searched.


if(!empty($emp)){

if($selected_payroll_option=="post_all" OR $selected_payroll_option=="print_payslip" OR $selected_payroll_option=="reset_payslip" OR $selected_payroll_option=="print_2316"){

}else{
$formula_text=$formula_details->formula_description;
$formula_code=$formula_details->formula;
$formula_id=$formula_details->id;

/*
----------------------
START GENERAL INFO
----------------------
*/

/*
----------------------------------------------------------------------------------------
start Initialize oa_id=0
----------------------------------------------------------------------------------------
*/

    for ($i=1; $i <1000 ; $i++) { 
        $initial_oa="OA_$i";
        $initial_oa_raw=$initial_oa;
        $initial_oa_fin="$initial_oa_raw";
        $$initial_oa_fin=0;

        $initial_od="OD_$i";
        $initial_od_raw=$initial_od;
        $initial_od_fin="$initial_od_raw";
        $$initial_od_fin=0;
    }

    if(!empty($company_oa)){
        $get_this_oa="";
        foreach($company_oa as $oa){
            $oa_id=$oa->id;
            if (strpos($formula_text, 'OA_'.$oa_id) !== false) {
          
                $get_this_oa.="oa_id='".$oa_id."' OR ";
            }else{
                
            }
        }
        $get_this_oa=substr($get_this_oa, 0, -3);  
    }else{
        $get_this_oa="";
    }
    if(!empty($company_od)){
        $get_this_od="";
        foreach($company_od as $od){
            $od_id=$od->id;
            if (strpos($formula_text, 'OD_'.$od_id) !== false) {
               
                $get_this_od.="od_id='".$od_id."' OR ";
            }else{
              
            }
        }
        $get_this_od=substr($get_this_od, 0, -3);  
    }else{
        $get_this_od="";
    }

    if($get_this_oa!=""){
         $go_check_oa="yes";
    }else{
         $go_check_oa="no";
    }

    if($get_this_od!=""){
         $go_check_od="yes";
    }else{
         $go_check_od="no";
    }

}
/*
----------------------------------------------------------------------------------------
end Initialize oa_id=0
----------------------------------------------------------------------------------------
*/
        $how_many_did_post=0;
        $how_many_did_not_post=0;
        $how_many_did_post_prev=0;
		$count_employees = 0; // count employees


	// foreach($employeeList as $emp){

/*
----------------------------------------------------------------------------------------
EMPLOYEE INFO VARIABLE LISTS
----------------------------------------------------------------------------------------
*/
        $count_employees++; // count employees
		$employee_id=$emp->employee_id;
		$position=$emp->position_name;
		$name=$emp->name;
		$dept=$emp->dept_name;
		$section=$emp->section_name;
		$wSubsection=$emp->wSubsection;
		$location=$emp->location_name;
        $location_id=$emp->location;
        $taxcode_name=$emp->taxcode_name;
		$taxcode_id=$emp->taxcode;

		$employment=$emp->employment_name;
		$classification=$emp->classification_name;
		$classification_id=$emp->classification;
		$employment_id=$emp->employment;
        $pay_type_name=$emp->pay_type_name;
        $active_pay_type=$emp->pay_type;


        $date_employed=$emp->date_employed;
		//$emp_electronic_signature=$emp->electronic_signature;

$getExemption=$this->payroll_generate_lastpay_model->getExemption($taxcode_id,$from_yc);
if(!empty($getExemption)){
    $yearly_tax_excemption=$getExemption->total;
}else{
    $yearly_tax_excemption=0;
}
//============================================ CHECK COMPANY DIVISION SETTING============================================
if($wDivision=="1"){

$getmydivision=$this->payroll_generate_lastpay_model->getDivision($emp->division_id);
    $mydivision=$getmydivision->division_name;
    $division_status='<th width="15%">Division</th>
            <th>'.$mydivision.'</th>';              
}else{
    $mydivision="";
        $division_status='<th width="15%">&nbsp;</th>
            <th>&nbsp;</th>';
}

//============================================ CHECK SECTION- SUBSECTION SETTING============================================
if($wSubsection=="1"){

$getmysubsection=$this->payroll_generate_lastpay_model->getSubsection($emp->section);
    $mysubsection=$getmysubsection->subsection_name;
    $subsection_status='<th>Sub-Section</th>
            <th>'.$mysubsection.'</th>';                
}else{
    $mysubsection="";
    $subsection_status='<th>&nbsp;</th>
            <th>&nbsp;</th>';
}

//============================================EMPLOYEE OFFICIAL SALARY ============================================

    $my_official_salary=$this->Payroll_generate_13th_month_model->get_official_salary($employee_id,$pay_period_from,$pay_period_to);
    if(!empty($my_official_salary)){

        $official_salary_state="yes";
        $mysalary_id=$my_official_salary->salary_id;
        $mysalaryrate=$my_official_salary->salary_rate;
        //$active_salary_rate=$my_official_salary->salary_rate;
        $mysalaryrate_name=$my_official_salary->salary_rate_name;
        $mysalary_no_of_hours=$my_official_salary->no_of_hours;
        $mysalary_no_of_days_monthly=$my_official_salary->no_of_days_monthly;
        $mysalary_no_of_days_yearly=$my_official_salary->no_of_days_yearly;
        $mysalary_amount=$my_official_salary->salary_amount;
        $mysalary_date_effective=$my_official_salary->date_effective;
        $is_salary_fixed=$my_official_salary->is_salary_fixed;

        $salary_deduct_withholding_tax=$my_official_salary->withholding_tax;
        $salary_deduct_pagibig=$my_official_salary->pagibig;
        $salary_deduct_sss=$my_official_salary->sss;
        $salary_deduct_philhealth=$my_official_salary->philhealth;
    }else{
        $mysalaryrate="";
        $official_salary_state="";
        $mysalary_id=""; 
        $mysalary_no_of_hours="";
        $mysalary_no_of_days_monthly="";
        $mysalary_no_of_days_yearly="";
        $mysalary_amount="";
        $mysalary_date_effective="";
        $is_salary_fixed="";   

        $salary_deduct_withholding_tax="";   
        $salary_deduct_pagibig="";  
        $salary_deduct_sss="";
        $salary_deduct_philhealth="";
    }


//============================================GET SALARY RATE : SALARY NAME
$active_salary_rate=$mysalaryrate;

if($selected_payroll_option=="print_payslip"){

}elseif($selected_payroll_option=="reset_payslip"){

}elseif($selected_payroll_option=="print_2316"){

          echo '<embed src="'. base_url().'/public/gov_reports_templates/2316.pdf" width="100%" height="1500px" />';

}elseif($selected_payroll_option=="post_all"){

}else{

    require(APPPATH.'views/app/payroll/13th_month/payslip_header.php');  

  



// ===================================================================== SALARY HISTORY
   if(!empty($MySalHistory)){
    echo '
    <div class="table-responsive">
    <table class="table table" cellpadding="1" cellspacing="3" >
    <thead>
    <tr>
        <th colspan="4" class="center_Topic titleBG">SALARY HISTORY</th>
    </tr>
    <tr>
        <th class="salhis_td">Date Created</th>
        <th class="salhis_td">Date Effective</th>
        <th class="salhis_td">Amount</th>
        <th class="salhis_td">Rate</th>
    </tr>
    </thead>';
    foreach($MySalHistory as $h){
        echo '
            <tr>
                <td>'.$h->date_added.'</td>
                <td>'.$h->date_effective.'</td>
                <td>'.$h->salary_amount.'</td>
                <td>'.$h->salary_rate_name.'</td>
            </tr>
        ';
    }


    echo ' </table>
    </div>';

   }else{

   } 


// ===================================================================== 13th month pay

$compute_tertin_month=$this->payroll_generate_lastpay_model->compute_tertin_month($employee_id,$final_payroll_coverage,$formula_code);

if(!empty($compute_tertin_month)){
    $net_pay=$compute_tertin_month->net_pay;
    $net_basic_value=$compute_tertin_month->basic;
    $total_overtime_amount=$compute_tertin_month->overtime;
    $total_taxable_oa=$compute_tertin_month->other_addition_taxable;
    $total_nontaxable_oa=$compute_tertin_month->other_addition_non_tax;
    $total_cola_amount=$compute_tertin_month->cola;
    $absent_formula_value=$compute_tertin_month->absent;
    $undertime_formula_value=$compute_tertin_month->undertime;
    $late_formula_value=$compute_tertin_month->late;
    $overbreak_formula_value=$compute_tertin_month->overbreak;
    $total_taxable_od=$compute_tertin_month->other_deduction_taxable;
    $total_nontaxable_od=$compute_tertin_month->other_deduction_nontax;
}else{
    $net_pay=0;
    $net_basic_value=0;
    $total_overtime_amount=0;
    $total_taxable_oa=0;
    $total_nontaxable_oa=0;
    $total_cola_amount=0;
    $absent_formula_value=0;
    $undertime_formula_value=0;
    $late_formula_value=0;
    $overbreak_formula_value=0;
    $total_taxable_od=0;
    $total_nontaxable_od=0;
}

//=== start check manual adjustment

    $check_manual_adj=$this->Payroll_generate_13th_month_model->check_adjustment($employee_id,$pay_period);
    if(!empty($check_manual_adj)){
        $manual_adj=$check_manual_adj->amount;
    }else{
        $manual_adj=0;
    }
    if($manual_adj>0){
        $postive_manual_adj=$manual_adj;
        $negative_manual_adj="0";
    }else{
        $negative_manual_adj=$manual_adj;
        $postive_manual_adj="0";
    }


//=== end check manual adjustment


//=== check other addition

if($go_check_oa=="yes"){
        foreach($company_oa as $oa_actual){
           $oa_id=$oa_actual->id;

     if (strpos($formula_text, 'OA_'.$oa_id) !== false) {
            // get the sum of this other addition.$oa_id
            //=========== actual start get oa values.
            $test=$this->Payroll_generate_13th_month_model->compute_actual_oa_val($employee_id,$final_payroll_coverage,$oa_id);
            /*ok na double check na lang*/
            $fin_amount=$test->oa_amount;
            if($fin_amount==""){
                $fin_amount=0;
            }else{
            }

            $initial_oa_="OA_".$oa_id;
            $initial_oa_raw_=$initial_oa_;
            $initial_oa_fin_="$initial_oa_raw_";
            $$initial_oa_fin_=$fin_amount;
            //=========== actual end get oa values.
     }else{
            // no need to get the sum of this other addition.
     }
        }
}else{

}
if($go_check_od=="yes"){
        foreach($company_od as $od_actual){
           $od_id=$od_actual->id;

     if (strpos($formula_text, 'OD_'.$od_id) !== false) {
            // get the sum of this other deduction.$od_id
            //=========== actual start get od values.
            $actual_od_val=$this->Payroll_generate_13th_month_model->compute_actual_od_val($employee_id,$final_payroll_coverage,$od_id);
            /*ok na double check na lang*/
            $fin_amount_od=$actual_od_val->od_amount;
            if($fin_amount_od==""){
                $fin_amount_od=0;
            }else{

            }

            $initial_od_="OD_".$od_id;
            $initial_od_raw_=$initial_od_;
            $initial_od_fin_="$initial_od_raw_";
            $$initial_od_fin_=$fin_amount_od;

            //echo "$employee_id  | $fin_amount_od <br>";
            //=========== actual end get od values.
     }else{
            // no need to get the sum of this other addition.
     }
        }
}else{

}


        $tertin_month_formula_text=str_replace("[","{",$formula_code);
        $tertin_month_formula_text=str_replace("]","}",$tertin_month_formula_text);
        $tertin_month_formula_text = $tertin_month_formula_text;
        $for_translation=$tertin_month_formula_text;
        require(APPPATH.'views/app/payroll/13th_month/transverse_variable.php');
        $tertin_month_formula_1st=str_replace("[","",$formula_code);
        $tertin_month_formula_2nd=str_replace("]","",$tertin_month_formula_1st);    
        $tertin_month_formula_3=$tertin_month_formula_2nd;
    /**/$tertin_month_formula_3 = preg_replace('/(?<=\d)\s+(?=\d)/', '', $tertin_month_formula_3);

    /**/$tertin_month_value = eval('return '.$tertin_month_formula_3.';');
    /**/$tertin_month_formula_text=$formula_text." <br> $for_translation";
    /**/$tertin_month_formula_math="$for_translation";
    /**/$tertin_month_formula_var="$formula_text";
        $tertin_month_value=$tertin_month_value;
       //echo "$tertin_month_value | $manual_adj ";

        if($tertin_month_value>$taxable_amt_beyond){// with tax
            $taxable_tertin_month=$tertin_month_value-$taxable_amt_beyond;
            $taxable_formula_value=$tertin_month_value-$taxable_amt_beyond;


            $payroll_formula=$this->payroll_generate_lastpay_model->formula_setup($company_id,$location_id,$classification_id,$employment_id,$active_pay_type,$active_salary_rate);

            $wtax_formula=$payroll_formula->wtax_formula_code;
            $wtax_formula_desc=$payroll_formula->wtax_formula_desc;

            $wtax_table_setup=$this->payroll_generate_lastpay_model->get_wtax_table($company_id,$active_pay_type,$active_salary_rate,$year_cover,$taxcode_id,$taxable_formula_value);
            if(!empty($wtax_table_setup)){
                    $tax_code_field="tax_code_".$taxcode_id;
                    $exempt_percentage=$wtax_table_setup->exempt_percentage;
                    $exempt_value=$wtax_table_setup->exempt_value;
                    $tax_code_field=$wtax_table_setup->taxcodefield;

                    foreach($taxcodeList as $tc_list){
                        $tcid=$tc_list->taxcode_id;
                        $transpose_var='tax_code_'.$tcid;
                        $$transpose_var=$tax_code_field; // yes this is double dollar sign.
                    }
                    // start compute tax

                        $wtax_formula_text=str_replace("[","{",$wtax_formula);
                        $wtax_formula_text=str_replace("]","}",$wtax_formula_text);
                        $wtax_formula_text = $wtax_formula_text;

                        $string = "$wtax_formula_text";
                        $newword='tax_code_'.$taxcode_id; // get the taxcode id
                        $newstring = str_replace("tax_code", $newword, $string);
                        $wtax_formula_text=$newstring;

                            $for_translation=$wtax_formula_text;
                            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
                            $wtax_formula_1st=str_replace("[","",$wtax_formula);
                            $wtax_formula_2nd=str_replace("]","",$wtax_formula_1st);    

                        $string_2 = "$wtax_formula_2nd";
                        $newword_2='tax_code_1';
                        $newstring_2 = str_replace("tax_code", $newword_2, $string_2);
                        $wtax_formula_3=$newstring_2;
                                                 
                            $wtax_formula_text=$wtax_formula_desc."<br> $for_translation";
                            $witheld_tax = eval('return '.$wtax_formula_3.';');

                    if($round_off_payslip=="yes"){// round off
                        $witheld_tax=round($witheld_tax, $payslip_decimal_place);
                    }else{
                        $witheld_tax=bcdiv($witheld_tax, 1, $payslip_decimal_place); 
                    }   
                            
            }else{
                    $wtax_formula_text="taxable value: no match row in tax table.";
                    $witheld_tax=0;
            }

        }else{
            $taxable_tertin_month=0;
            $wtax_formula_text="tax exempted.";
            $witheld_tax=0;            
        }

                    if($round_off_payslip=="yes"){// round off
                        $tertin_month_value=round($tertin_month_value, $payslip_decimal_place);
                    }else{
                        $tertin_month_value=bcdiv($tertin_month_value, 1, $payslip_decimal_place); 
                    }  



    echo '
<input type="hidden" id="taxable_amt_beyond" value="'.$taxable_amt_beyond.'">

    <div class="table-responsive">
    <table class="table table" cellpadding="1" cellspacing="3" >
    <thead>
    <tr>
        <th colspan="4" class="center_Topic titleBG">13TH MONTH PAY <input type="checkbox" id="include_13thmonth" onclick="recompute_final_tertin_month();"></th>
    </tr>

    </thead>';
    // ===start stored val 13th month
    

   

    echo '

    <input type="hidden" id="automatic_tm" value="'.$tertin_month_value.'">     ';
    // ===end stored val 13th month
        echo '
            <tr>
                <td class="salhis_td"><span class="justBold">Payroll Period From-To </span><br> '.$from_complete.' TO '.$to_complete.'</td>
                <td ><span class="justBold">Formula<br></span>'.$tertin_month_formula_text.'</td>
                <td></td>
            </tr>
            <tr>
                <th>Manual Adjustment<br>(Addition[positive] Or Deduction[negative])</th>
                <td><input type="number" step="any" class="form-control" id="manual_adj_tm" value="0" placeholder="warning: do not leave blank" ></td>
    
            </tr>
                <tr>
                <th>Total 13th Month</th>
                <td> <div id="show_recompute_tertin_month" >'.$tertin_month_value.'</div></td>
                <td>&nbsp;</td>
                </tr>
        ';
        // <input type="button" class="btn btn-danger col-md-3" value="Click Me to Recompute?" onclick="recompute_tertin_month();">
    echo ' </table>
    </div>';             

// =====================================================================  Start Leave Convertion
if(!empty($MyCurrentSal)){
    $cs_salary_amount=$MyCurrentSal->salary_amount;
    $cs_salary_rate=$MyCurrentSal->salary_rate;
    $cs_no_of_hours=$MyCurrentSal->no_of_hours;
    $cs_no_of_days_monthly=$MyCurrentSal->no_of_days_monthly;
    $cs_no_of_days_yearly=$MyCurrentSal->no_of_days_yearly;

    if($cs_salary_rate=="3"){
        $dailyrate=$cs_salary_amount;
    }elseif($cs_salary_rate=="4"){
        $dailyrate=$cs_salary_amount/$cs_no_of_days_monthly;
    }else{

    }
}else{
    $cs_salary_amount=0;
    $cs_salary_rate="";
    $cs_no_of_hours="";
    $cs_no_of_days_monthly="";
    $cs_no_of_days_yearly="";
}

    if($round_off_payslip=="yes"){// round off
        $dailyrate=round($dailyrate, $compensation_decimal_place);
    }else{
        $dailyrate=bcdiv($dailyrate, 1, $compensation_decimal_place); 
    }  




echo '
<div class="table-responsive">
<table class="table table">
<thead>
    <tr>
        <th colspan="8" class="center_Topic titleBG">CONVERT LEAVE TO CASH</th>
    </tr>
    <tr>
        <th>Convert?</th>
        <th>Leave Type</th>
        <th>Taxable Leave Beyond <a href="#" title="I am Configurable at Administrator>Leave Type"><i class="fa fa-info"></i>Help</a></th>
        <th>Remaining Leave <a href="#" title="I can be found at Administrator>Leave Management"><i class="fa fa-info"></i>Help</a></th>
        <th>Daily Rate</th>
        <th>Non-Tax</th>
        <th>Taxable</th>
        <th>Total</th>
    </tr>
</thead>
<tbody>
';

if(!empty($MyRemLeave)){
    $i=0;
    foreach($MyRemLeave as $r){
        $i++;
        $c=$r->id;
        echo '
<tr>
<td><input type="checkbox" id="leaveTypeCheckbox'.$i.'" onclick="computeCL'.$i.'();"></td>
<td>'.$r->leave_type.'</td>
<td><input type="text" readonly id="leaveBeyondTax'.$i.'" value="'.$r->taxable_leave_beyond.'"></td>
<td><input type="text" id="leaveType'.$i.'" value="'.$r->available.'"></td>

<td><input type="text" readonly id="Rate'.$i.'" value="'.$dailyrate.'"></td>
<td><div class="bg-danger col-md-12" id="leavetotalNontax'.$i.'" >0.00</div></td>
<td><div class="bg-primary col-md-12" id="leavetotalTaxable'.$i.'" >0.00</div></td>
<td><div class="bg-danger col-md-12" id="totalLeave'.$i.'" >0.00</div></td>
</tr>
    
        ';
?>

<script type="text/javascript">

    function computeCL<?php echo $i;?>(){ 

        var leaveType = document.getElementById("leaveType<?php echo $i;?>").value;  
        var available = Number(leaveType);
        var Rate = document.getElementById("Rate<?php echo $i;?>").value;  
        var Rate = Number(Rate);

        var totalPerLeave = Number(available) * Number(Rate);

        var leaveBeyondTax = document.getElementById("leaveBeyondTax<?php echo $i;?>").value;
        var leaveBeyondTax =Number(leaveBeyondTax);

        if(available>leaveBeyondTax){
            var nontax = leaveBeyondTax;
            var taxable = Number(available) - Number(leaveBeyondTax);
        }else{
            var nontax = available;
            var taxable = 0;
        }

        var finalNontax = Number(nontax) * Number(Rate);
        var finalTaxable = Number(taxable) * Number(Rate);


        var checkBox = document.getElementById("leaveTypeCheckbox<?php echo $i;?>");
        

        if(checkBox.checked == true){
           // document.getElementById("final").innerHTML=available;
            document.getElementById("totalLeave<?php echo $i;?>").innerHTML=totalPerLeave;
            document.getElementById("leavetotalNontax<?php echo $i;?>").innerHTML=finalNontax;
            document.getElementById("leavetotalTaxable<?php echo $i;?>").innerHTML=finalTaxable;
        }else{
           // document.getElementById("final").innerHTML="0.00";
            document.getElementById("totalLeave<?php echo $i;?>").innerHTML="0.00";
            document.getElementById("leavetotalNontax<?php echo $i;?>").innerHTML="0.00";
            document.getElementById("leavetotalTaxable<?php echo $i;?>").innerHTML="0.00";
        }

        ttlc_lv();

    }

</script>
<?php
    }
}else{

}
?>

<script type="text/javascript">
    function ttlc_lv(){   
        var z=0;  
        var leavetotalNontax=0;
        var leavetotalTaxable=0;
<?php 
$a=$i;
while($a>0){?>
        var oa = document.getElementById("totalLeave<?php echo $a;?>").innerHTML;
        var oa =Number(oa);

        var n = document.getElementById("leavetotalNontax<?php echo $a;?>").innerHTML;
        var n =Number(n);

        var t = document.getElementById("leavetotalTaxable<?php echo $a;?>").innerHTML;
        var t =Number(t);

        var checkBox = document.getElementById("leaveTypeCheckbox<?php echo $a;?>");
        if(checkBox.checked == true){
            var z=z+oa;
            var leavetotalNontax=leavetotalNontax+n;
            var leavetotalTaxable=leavetotalTaxable+t;
            document.getElementById("leaveFinal_over_all").innerHTML=z;
            document.getElementById("leaveFinal_taxable").innerHTML=leavetotalTaxable;
            document.getElementById("aw_taxable_salariesOtherForm").innerHTML=leavetotalTaxable;
            document.getElementById("leaveFinal_nontaxable").innerHTML=leavetotalNontax;
        }else{
            document.getElementById("leaveFinal_over_all").innerHTML=z;
            document.getElementById("leaveFinal_taxable").innerHTML=leavetotalTaxable;
             document.getElementById("aw_taxable_salariesOtherForm").innerHTML=leavetotalTaxable;
            document.getElementById("leaveFinal_nontaxable").innerHTML=leavetotalNontax;
        }
<?php 
$a=$a-1;
}
?>
document.getElementById("leaveFinal_over_all").innerHTML=z;
    }
</script>

<?php
echo '
<tr>
<td>Over All Total
<div class="bg-primary col-md-12" id="leaveFinal_over_all">
    0.00 
</div></td>

<td>Total Taxable
<div class="bg-primary col-md-12" id="leaveFinal_taxable">
    0.00 
</div></td>

<td>Total Non-Taxable
<div class="bg-primary col-md-12" id="leaveFinal_nontaxable">
    0.00 
</div></td>

</tr>
</tbody>
</table>
</div>



';



  
// =====================================================================  End Leave Convertion

// =====================================================================  Start Amount Withheld
$gross_compen_income=0;
$gross_compen_income_how="";
$taxable_salariesOtherForm=0;
$taxable_salariesOtherForm_how="";
$nontax_salariesOtherForm=0;
$nontax_salariesOtherForm_how="";

$nontax_deminimis=0;
$nontax_deminimis_how="";

$government_contribution=0;

$nontax_pi=0;
$nontax_pi_how="";
$government_contribution_nontax=0;
$government_contribution_nontax_how="";

$government_contribution_how="";

$total_basic=0;
$total_basic_how="";

$total_overtime=0;
$total_overtime_how="";

$separate_bonus_net_and_tax=0;
$separate_bonus_net_and_tax_how="";
$separate_bonus_tax=0;
$separate_bonus_tax_how="";

$separate_tertin_net_and_tax=0;
$separate_tertin_net_and_tax_how="";


$tax_due=0;
$tax_due_how="";

$jn_aw=0;
$jn_aw_how="";

$amount_withheld=0;
$amount_withheld_how="";

if(!empty($MySeparateBonus)){
    foreach($MySeparateBonus as $b){
        $separate_bonus_net_and_tax+=$b->final_bonus+$b->bonus_tax;
        $separate_bonus_tax+=$b->bonus_tax;
        $separate_bonus_net_and_tax_how.=$b->complete_from." TO ".$b->complete_to." BONUS: ".number_format($b->final_bonus,2)." TAX: ".number_format($b->bonus_tax,2)."&#10;";
        $separate_bonus_tax_how.=$b->complete_from." TO ".$b->complete_to." BONUS: ".number_format($b->final_bonus,2)." TAX: ".number_format($b->bonus_tax,2)."&#10;";
    }
}else{

}


if(!empty($MySeparateTertinMonth)){
    foreach($MySeparateTertinMonth as $t){
        $separate_tertin_net_and_tax+=$t->final_tertin_month+$t->tertin_month_tax;
        $separate_tertin_tax=$t->tertin_month_tax;
        $separate_tertin_net_and_tax_how.=$t->complete_from." TO ".$t->complete_to." NET: ".number_format($t->final_tertin_month,2)." TAX: ".number_format($t->tertin_month_tax,2)."&#10;";
    }
}else{
    $separate_tertin_tax=0;
}


//============ payroll details
if(!empty($MyPayrollDetails)){
    foreach($MyPayrollDetails as $pd){//payroll details
        $sss_employee=$pd->sss_employee;
        $philhealth_employee=$pd->philhealth_employee;
        $pagibig_employee=$pd->pagibig;
            if($pagibig_employee>$pagibig_nontax_ceiling){
                $nontax_pi=$pagibig_nontax_ceiling;
                $nontax_pi_how="*note: actual contribution is $pagibig_employee : nontaxable is only $pagibig_nontax_ceiling*";
            }else{
                $nontax_pi=$pagibig_employee;
                $nontax_pi_how="";
            }

        $total_basic+=$pd->basic;
        $total_overtime+=$pd->overtime;

        $government_contribution+=$sss_employee+$philhealth_employee+$pagibig_employee;

        $government_contribution_nontax+=$sss_employee+$philhealth_employee+$nontax_pi;
        $government_contribution_nontax_how.=$pd->complete_from." TO ".$pd->complete_to." sss: ".number_format($sss_employee,2)." | philhealth: ".number_format($philhealth_employee,2)." | pagibig: ".number_format($nontax_pi,2)." ".$nontax_pi_how." &#10;";

        $gross_compen_income+=$pd->gross;     

        $total_overtime_how.=$pd->complete_from." TO ".$pd->complete_to." OT: ".number_format($pd->overtime,2)."&#10;";

        $total_basic_how.=$pd->complete_from." TO ".$pd->complete_to." Basic: ".number_format($pd->basic,2)."&#10;";
        $gross_compen_income_how.=$pd->complete_from." TO ".$pd->complete_to." GROSS: ".number_format($pd->gross,2)."&#10;";
        $government_contribution_how.=$pd->complete_from." TO ".$pd->complete_to." sss: ".number_format($sss_employee,2)." | philhealth: ".number_format($philhealth_employee,2)." | pagibig: ".number_format($pagibig_employee,2)."&#10;";
    }
}else{
}
//============ 
if(!empty($MyPayslipOtherAddtition)){
    foreach($MyPayslipOtherAddtition as $oa){

        $other_addition_type=$oa->other_addition_type;
        $is_oa_deminimis=$oa->is_oa_deminimis;
        $is_oa_bonus=$oa->is_oa_bonus;
        $is_oa_tertin_month=$oa->is_oa_tertin_month;
        $is_oa_basic=$oa->is_oa_basic;
        $is_oa_ot=$oa->is_oa_ot;
        $is_oa_leave=$oa->is_oa_leave;
        $is_oa_alphalist_exclude=$oa->is_oa_alphalist_exclude;
        $is_oa_taxable=$oa->is_oa_taxable;

            if($is_oa_deminimis>0){
                $nontax_deminimis+=$oa->oa_amount;     
                $nontax_deminimis_how.=$oa->complete_from." TO ".$oa->complete_to." Other Addition:($other_addition_type) "." AMOUNT: ".number_format($oa->oa_amount,2)."&#10;";
            }elseif($is_oa_bonus>0){

            }elseif($is_oa_tertin_month>0){

            }elseif($is_oa_basic>0){

                if($is_oa_taxable>0){
                     $total_basic+=$oa->oa_amount;
                     $total_basic_how.=$oa->complete_from." TO ".$oa->complete_to." Other Addition:($other_addition_type) ".number_format($oa->oa_amount,2)."&#10;";
                }else{

                }
               
            }elseif($is_oa_ot>0){

            }elseif($is_oa_leave>0){

            }else{

                if($is_oa_taxable>0){//taxable other salaries
                    $taxable_salariesOtherForm+=$oa->oa_amount;
                    $taxable_salariesOtherForm_how.=$oa->complete_from." TO ".$oa->complete_to." TYPE: ".$other_addition_type." | AMOUNT: ".number_format($oa->oa_amount,2)."&#10;";
                }else{//nontax other salaries
                    $nontax_salariesOtherForm+=$oa->oa_amount;
                    $nontax_salariesOtherForm_how.=$oa->complete_from." TO ".$oa->complete_to." TYPE: ".$other_addition_type." | AMOUNT: ".number_format($oa->oa_amount,2)."&#10;";
                }

            }

    }
}else{
}


$taxable_salariesOtherForm+=$total_overtime;
$taxable_salariesOtherForm_how.="&#10;".$total_overtime_how;


$nontax_TertinBonusRaw=$separate_bonus_net_and_tax+$tertin_month_value+$separate_tertin_net_and_tax;
$nontax_TertinBonus=$separate_bonus_net_and_tax+$tertin_month_value+$separate_tertin_net_and_tax;

if($nontax_TertinBonus>$taxable_amt_beyond){
    $nontax_TertinBonus=$taxable_amt_beyond;
    $aw_tertin_month_taxable=$nontax_TertinBonusRaw-$taxable_amt_beyond;

}else{
     $aw_tertin_month_taxable="0.00";

}


$nontax_TertinBonus_how="<a title='Separate Bonus & tax($separate_bonus_net_and_tax) Automatic 13th Month($tertin_month_value) Separate 13th Month($separate_tertin_net_and_tax)'><i class='fa fa-info'></i>help</a>";

$nontax_compen_income_a=$nontax_TertinBonus+$government_contribution+$nontax_deminimis;
$nontax_compen_income_a_how="nontax 13th month & bonus ($nontax_TertinBonus) + government contribution($government_contribution) + deminimis($nontax_deminimis)";

// TOTAL TAXABLE COMPENSATION INCOME (B)
$total_taxable_income_b=$total_basic+$aw_tertin_month_taxable+$taxable_salariesOtherForm;
$total_taxable_income_b_how="Basic($total_basic) + taxable 13th month & bonus($aw_tertin_month_taxable) + taxable salaries & other forms($taxable_salariesOtherForm)";

//NET TAXABLE COMP. INCOME (B - C)
$net_taxable_bc=$total_taxable_income_b-$yearly_tax_excemption;
$net_taxable_bc_how="B ($total_taxable_income_b) - C ($yearly_tax_excemption)";


$myTaxRate=$this->payroll_generate_lastpay_model->get_tax_rates($company_id,$net_taxable_bc);
if(!empty($myTaxRate)){
    $tr_excess_over=$myTaxRate->excess_over;
    $tr_not_over=$myTaxRate->not_over;
    $tr_percentage=$myTaxRate->percentage."%";
    $tr_additional_rate=$myTaxRate->additional_rate;
}else{
    $tr_excess_over=0;
    $tr_not_over=0;
    $tr_percentage=0;
    $tr_additional_rate=0;
}

// TAX DUE
$tax_due=(($net_taxable_bc-$tr_excess_over)*($tr_percentage))+$tr_additional_rate;
$tax_due_how="((Net Taxable(b-c): $net_taxable_bc- Excess: $tr_excess_over)*(percentage: $tr_percentage))+Additional: $tr_additional_rate";


//AMOUNT WITHHELD JAN TO NOV
if(!empty($jan_to_nov_aw)){
    foreach($jan_to_nov_aw as $j){
        //jn : january to novem
        //aw : amount withheld
        $jn_aw+=$j->wtax;
        $jn_aw_how.=$j->complete_from." TO ".$j->complete_to." | tax amount: ".number_format($j->wtax,2)."&#10;";
    }
}else{

}

$jn_aw+=$separate_bonus_tax+$separate_tertin_tax;
$jn_aw_how.="separate bonus payroll tax: ".number_format($separate_bonus_tax,2)."&#10;";
$jn_aw_how.="separate 13th month payroll tax: ".number_format($separate_tertin_tax,2)."&#10;";

$amount_withheld=$jn_aw-$tax_due;
$amount_withheld_how="Jan to Nov Amount Withheld($jn_aw)-Tax Due ($tax_due)";

echo '
<input type="hidden" id="separate_tertin_net_and_tax" value="'.$separate_tertin_net_and_tax.'">
<input type="hidden" id="separate_bonus_net_and_tax" value="'.$separate_bonus_net_and_tax.'">
<input type="hidden" id="nontax_deminimis" value="'.$nontax_deminimis.'">
<input type="hidden" id="government_contribution" value="'.$government_contribution.'">
<input type="hidden" id="total_basic" value="'.$total_basic.'">
';

$nontax_compen_income_a=number_format($nontax_compen_income_a,2);
$nontax_deminimis=number_format($nontax_deminimis,2);
$gross_compen_income=number_format($gross_compen_income,2);

echo '
<input type="hidden" id="amount_withheld" value="'.$amount_withheld.'"> 

<div class="table-responsive">
<table class="table table">
<thead>
<tr>
    <th colspan="2" class="center_Topic titleBG">AMOUNT WITH-HELD <input type="checkbox" id="include_amount_withheld" onclick="recompute_final_amount_withheld();"></th>
</tr>
</thead>
<tbody>
    <tr>
        <td>Gross Compensation Income (A+B)</td>
        <td>'.$gross_compen_income.' <a title="'.$gross_compen_income_how.'">(<i class="fa fa-info"></i>help)</a></td>
    </tr>
    <tr>
        <td class="bg-primary">NON-TAX(13TH MONTH AND BONUS) '.$taxable_amt_beyond.' below</td>
        <td><div id="aw_tertin_month_nontax">'.$nontax_TertinBonus.' '.$nontax_TertinBonus_how.'</div></td>
    </tr>
    <tr>
        <td class="bg-primary">NON-TAX(DE MINIMIS)</td>
        <td>'.$nontax_deminimis.' <a title="'.$nontax_deminimis_how.'">(<i class="fa fa-info"></i>help)</a></td>
    </tr>
    <tr>
        <td class="bg-primary">NON-TAX(SSS,PHILHEALTH,PAG-IBIG UNION)</td>
         <td>'.$government_contribution_nontax.' <a title="'.$government_contribution_nontax_how.'">(<i class="fa fa-info"></i>help)</a></td>
    </tr>
    <tr>
        <td class="bg-primary">NON-TAX SALARIES OTHER FORM</td>
        <td>'.$nontax_salariesOtherForm.' <a title="'.$nontax_salariesOtherForm.'">(<i class="fa fa-info"></i>help)</a></td>
    </tr>
    <tr>
        <td class="bg-primary">TOTAL NON-TAX/EXEMPT COMP. INCOME (A)<i><small>(13th month,bonus,deminimis,government deduction)</small></i></td>
        <td><div id="show_nontax_compen_income_a">'.$nontax_compen_income_a.' <a title="'.$nontax_compen_income_a_how.'">(<i class="fa fa-info"></i>help)</a></div></td>
    </tr>
    <tr>
        <td class="bg-primary">TAXABLE BASIC SALARY</td>
        <td>'.$total_basic.' <a title="'.$total_basic_how.'">(<i class="fa fa-info"></i>help)</a></td>
    </tr>
    <tr>
        <td class="bg-primary">TAX(13TH MONTH AND BONUS) Excess of '.$taxable_amt_beyond.'</td>
        <td><div id="aw_tertin_month_taxable">'.$aw_tertin_month_taxable.'</div></td>
    </tr>
    <tr>
        <td class="bg-primary">TAXABLE SALARIES OTHER FORM</td>
        <td><div id="aw_taxable_salariesOtherForm">'.$taxable_salariesOtherForm.' <a title="'.$taxable_salariesOtherForm_how.'">(<i class="fa fa-info"></i>help)</div></a></td>
    </tr>
    <tr>
        <td class="bg-primary">TOTAL TAXABLE COMPENSATION INCOME (B)</td>
        <td><div id="aw_total_taxable_income_b">'.$total_taxable_income_b.'<a title="'.$total_taxable_income_b_how.'">(<i class="fa fa-info"></i>help)</a></div> </td>
    </tr>
    <tr>
        <td class="bg-primary">GOVT. DEDUCTION</td>
        <td>'.$government_contribution.' <a title="'.$government_contribution_how.'">(<i class="fa fa-info"></i>help)</a></td>
    </tr>
    <tr>
        <td class="bg-primary">EXEMPTION CODE</td>
        <td>'.$taxcode_name.'</td>
    </tr>
    <tr>
        <td class="bg-primary">AMOUNT OF EXEMPTION( C )</td>
        <td>'.$yearly_tax_excemption.'</td>
    </tr>
    <tr>
        <td class="bg-primary">NET TAXABLE COMP. INCOME (B - C)</td>
        <td><div id="aw_net_taxable_bc">'.$net_taxable_bc.' <a title="'.$net_taxable_bc_how.'">(<i class="fa fa-info"></i>help)</a></di></td>
    </tr>
    <tr>
        <td class="bg-primary">tax due (Annual Tax Rate) FORMULA : '.$tax_due_how.'</td>
        <td>'.$tax_due.' <a title="'.$tax_due_how.'">(<i class="fa fa-info"></i>help)</a></td>
    </tr>
    <tr>
        <td class="bg-primary">AMOUNT WITHHELD (JAN-NOV)</td>
        <td>'.$jn_aw.' <a title="'.$jn_aw_how.'">(<i class="fa fa-info"></i>help)</a></td>
    </tr>
    <tr>
        <td class="bg-primary">AMOUNT WITHHELD (REFUND) - DEC</td>
        <td>'.$amount_withheld.' <a title="'.$amount_withheld_how.'">(<i class="fa fa-info"></i>help)</a></td>
    </tr>
</tbody>

</table
</div>
';


// =====================================================================  End Amount Withheld

// =====================================================================  Start Length of Stay/Retirement
/*show service record*/

echo '
<div class="table-responsive">
<table class="table table">
    <thead>
        <tr>
            <th colspan="13" class="center_Topic titleBG">SERVICE RECORD/RETIREMENT</th>
        </tr>
        <tr>
            <th colspan="13" class="center_Topic bg-danger">Employment Record</th>
        </tr>
        <tr>
            <th class="salhis_td">Date Employed</th>
            <th class="salhis_td" >Date Resigned</th>
            <th class="salhis_td" >Length of Service</th>
        </tr>
       ';
// ==start first employment
       $total_service_length_y=0;
       $total_service_length_m=0;
       $total_service_length_d=0;

echo '
    </thead>
 <tbody>
        <tr>
        <td class="salhis_td" >'.$date_employed.'</td>
        <td  class="salhis_td" >';
        $initialResignation=$this->payroll_generate_lastpay_model->checkResignation($employee_id,$date_employed);

        if(!empty($initialResignation)){
        echo $ResignedFirst=$initialResignation->date_resigned;
        }else{ echo "Active";
        $ResignedFirst=date('Y-m-d');// active as of now
        }

        $date1 = new DateTime($date_employed);
        $date2 = new DateTime($ResignedFirst);
        $lengthService = $date1->diff($date2);

$total_service_length_y+=$lengthService->y;
$total_service_length_m+=$lengthService->m;
$total_service_length_d+=$lengthService->d;
echo '
        </td>
        <td class="salhis_td" > Year(s): '. $lengthService->y.' Month(s): '. $lengthService->m.' Day(s): '. $lengthService->d.'</td>
       
        </tr>';
// ==end first employment   

// ==start re-employment

if(!empty($EmploymentRecord)){
    foreach($EmploymentRecord as $e){
        $checkResignation=$this->payroll_generate_lastpay_model->checkResignation($employee_id,$e->date_employed);
        if(!empty($checkResignation)){
            $date_resigned=$checkResignation->date_resigned;
            $e_date_employed=$checkResignation->date_employed;
            $dr=1;
        }else{
            $date_resigned="Active";
            $dr=0;
        }
        if($dr>0){//resigned already.
            $ede = new DateTime($e_date_employed);
            $edr = new DateTime($date_resigned);
            $serviceLength = $ede->diff($edr);

            $serviceLength_y=$serviceLength->y;
            $serviceLength_m=$serviceLength->m;
            $serviceLength_d=$serviceLength->d;
        }else{
            $cd=date('Y-m-d');
            $ede = new DateTime($e->date_employed);
            $edr = new DateTime($cd);
            $serviceLength = $ede->diff($edr);

            $serviceLength_y=$serviceLength->y;
            $serviceLength_m=$serviceLength->m;
            $serviceLength_d=$serviceLength->d;
        }


$total_service_length_y+=$serviceLength_y;
$total_service_length_m+=$serviceLength_m;
$total_service_length_d+=$serviceLength_d;


        echo '
        <tr>
        <td class="salhis_td" >'.$e->date_employed.'</td>
        <td class="salhis_td" >'.$date_resigned.'</td>
        <td class="salhis_td" > Year(s): '. $serviceLength_y.' Month(s): '. $serviceLength_m.' Day(s): '. $serviceLength_d.'</td>
        </tr>
        ';
    }
}else{

}
// ==end re-employment

// ==start total employment

if($total_service_length_m>=12){
    $additionalYears=$total_service_length_m/12;
    $additionalYears=(int)($additionalYears);
    $total_service_length_y+=$additionalYears;
    $deductFromMonths=$additionalYears*12;
    $total_service_length_m=$total_service_length_m-$deductFromMonths;
}else{

}

if($total_service_length_d>=365){
     $additionalYears=$total_service_length_d/365;
    $additionalYears=(int)($additionalYears);
    $total_service_length_y+=$additionalYears;
    $deductFromDays=$additionalYears*365;
    $total_service_length_d=$total_service_length_d-$deductFromDays;   
}else{

}


echo '
<tr>
<th class="salhis_td">Total Length of Service</th>
<th class="salhis_td" >'.$total_service_length_y.' Year(s): </th>
<th class="salhis_td" >'.$total_service_length_m.' Month(s): </th>
<th class="salhis_td" >'.$total_service_length_d.' Day(s): </th>
</tr>
<tr>

<th class="salhis_td" >Retirement Amount taxable</th>
<th class="salhis_td" ><input type="text" class="form-control"></th>
<th class="salhis_td" >Retirement Amount Non-taxable</th>
<th class="salhis_td" ><input type="text" class="form-control"></th>


</tr>
';
// ==end total employment


echo '        <tr><td colspan="12"></td></tr>
 </tbody>   
     <thead>    
        <tr>
            <th>Movement Type</th>
            <th>Date Duration</th>
            <th>Company From - TO</th>
            <th>Location From- To</th>
            <th>Division From- To</th>
            <th>Department From- To</th>
            <th>Section From- To</th>
            <th>Sub-Section From- To</th>
            <th>TaxCode From- To</th>
            <th>PayType From- To</th>
            <th>Employment From- To</th>
            <th>Classification From- To</th>
            <th>Position From- To</th>
        </tr>        
    </thead>
<tbody>';
if(!empty($MyServiceRecord)){
    foreach($MyServiceRecord as $s){

        $comp_info_from=$this->general_model->get_company_info($s->company_id_from);
        $comp_info_to=$this->general_model->get_company_info($s->company_id_to);

        $checkSectionFrom=$this->payroll_generate_lastpay_model->getSection($s->section_from);
        if(!empty($checkSectionFrom)){
            $wSubsectionFrom=$checkSectionFrom->wSubsection;
        }else{
            $wSubsectionFrom=0;
        }
        $checkSectionTo=$this->payroll_generate_lastpay_model->getSection($s->section_to);
        if(!empty($checkSectionFrom)){
            $wSubsectionTo=$checkSectionFrom->wSubsection;
        }else{
            $wSubsectionTo=0;
        }

        if($wSubsectionFrom>0){
            $SubSecFrom=$this->payroll_generate_lastpay_model->getSubsection_Final($s->subsection_from);
            if(!empty($SubSecFrom)){
               $SubSecFromName=$SubSecFrom->subsection_name;
            }else{
                $SubSecFromName="";
            }
        }else{
            $SubSecFromName="";
        }
        if($wSubsectionTo>0){
            $SubSecTo=$this->payroll_generate_lastpay_model->getSubsection_Final($s->subsection_to);
            if(!empty($SubSecTo)){
               $SubSecToName=$SubSecTo->subsection_name;
            }else{
                $SubSecToName="";
            }
        }else{
            $SubSecToName="";
        }


        if($comp_info_from->wDivision>0){
            $divFrom=$this->payroll_generate_lastpay_model->getDivision($s->division_from);
            if(!empty($divFrom)){
                $divFromName=$divFrom->division_name;
            }else{
                $divFromName="";
            }
        }else{
            $divFromName="";
        }
        if($comp_info_to->wDivision>0){
            $divTo=$this->payroll_generate_lastpay_model->getDivision($s->division_to);
            if(!empty($divTo)){
                $divToName=$divTo->division_name;
            }else{
                $divToName="";
            }
        }else{
            $divToName="";
        }
$withMovement='style="color:#ff0000;font-weight:bold;"';
$noMovement='style="color:#817F7E;"';

if($s->company_from_name!=$s->company_to_name){ $m_comp_class=$withMovement;}else{$m_comp_class=$noMovement;}
if($s->location_name_from!=$s->location_name_to){ $m_loc_class=$withMovement;}else{$m_loc_class=$noMovement;}
if($divFromName!=$divToName){ $m_div_class=$withMovement;}else{$m_div_class=$noMovement;}
if($s->dept_name_from!=$s->dept_name_to){ $m_dept_class=$withMovement;}else{$m_dept_class=$noMovement;}
if($s->section_name_from!=$s->section_name_to){ $m_sect_class=$withMovement;}else{$m_sect_class=$noMovement;}
if($SubSecFromName!=$SubSecToName){ $m_subsect_class=$withMovement;}else{$m_subsect_class=$noMovement;}
if($s->taxcode_name_from!=$s->taxcode_name_to){ $m_taxcode_class=$withMovement;}else{$m_taxcode_class=$noMovement;}
if($s->employment_name_from!=$s->employment_name_to){ $m_employ_class=$withMovement;}else{$m_employ_class=$noMovement;}

if($s->classification_name_from!=$s->classification_name_to){ $m_classfic_class=$withMovement;}else{$m_classfic_class=$noMovement;}
if($s->position_name_from!=$s->position_name_to){ $m_pos_class=$withMovement;}else{$m_pos_class=$noMovement;}
if($s->pay_type_name_from!=$s->pay_type_name_to){$m_paytype_class=$withMovement;}else{$m_paytype_class=$noMovement;}

        echo '
        <tr>
            <td>'.$s->movement_type_name.'</td>
            <td>'.$s->date_from.' TO '.$s->date_to.'</td>
            <td '.$m_comp_class.'>'.$s->company_from_name.' TO '.$s->company_to_name.'</td>
            <td '.$m_loc_class.'>'.$s->location_name_from.' TO '.$s->location_name_to.'</td>
            <td '.$m_div_class.'>'.$divFromName.' TO '.$divToName.'</td>
            <td '.$m_dept_class.'>'.$s->dept_name_from.' TO '.$s->dept_name_to.'</td>
            <td '.$m_sect_class.'>'.$s->section_name_from.' TO '.$s->section_name_to.'</td>
            <td '.$m_subsect_class.'>'.$SubSecFromName.' TO '.$SubSecToName.'</td>
            <td '.$m_taxcode_class.'>'.$s->taxcode_name_from.' TO '.$s->taxcode_name_to.'</td>
            <td '.$m_paytype_class.'>'.$s->pay_type_name_from.' TO '.$s->pay_type_name_to.'</td>
            <td '.$m_employ_class.'>'.$s->employment_name_from.' TO '.$s->employment_name_to.'</td>
            <td '.$m_classfic_class.'>'.$s->classification_name_from.' TO '.$s->classification_name_to.'</td>
            <td '.$m_pos_class.'>'.$s->position_name_from.' TO '.$s->position_name_to.'</td>
        </tr>
        ';
    }
}else{

}

echo '</tbody></table>
</div>
';

// =====================================================================  End Length of Stay/Retirement


// =====================================================================  Start Employees Hold Salary

echo '
<div class="table-responsive">
<table class="table table">
    <thead>
        <tr>
            <th colspan="4" class="center_Topic titleBG">HOLD SALARY</th>
        </tr>
        <tr>
            <th>Payroll Period</th>
            <th>Reason Salary Was Hold</th>
            <th>Date Hold</th>
            <th>Net Pay</th>
        </tr>
    </thead>
    <tbody>';                

if(!empty($MyHoldPayroll)){
    foreach($MyHoldPayroll as $h){

      $myHoldNetPay=$this->payroll_generate_lastpay_model->checkHoldSalNetPay($h->month_cover,$employee_id,$h->payroll_period);
      if(!empty($myHoldNetPay)){
        $my_hold_netpay=$myHoldNetPay->net_pay;
      }else{
        $my_hold_netpay=0;
      }
        echo '
            <tr>
                <td>'.$h->complete_from.' TO '.$h->complete_to.'</td>
                <td>'.$h->reason.'</td>
                <td>'.$h->date_hold.'</td>
                <td>'.$my_hold_netpay.'</td>
            </tr>
        ';
    }
}else{

}

echo    ' </tbody>
</table>
</div>
';

// =====================================================================  End Employees Hold Salary

// ===================================================================== Start Loan Balance
echo '
    <div class="table-responsive">
    <table class="table table">
        <thead>
        <tr>
        <th colspan="6" class="center_Topic titleBG">LOAN BALANCES </th>
        </tr>
            <tr>
                <th>Deduct?</th>
                <th>Loan Type</th>
                <th>Principal Amount</th>
                <th>Loan Amount</th>
                <th>Amortization Details</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>';

$l_count=0;        
if(!empty($MyLoanBalance)){
    foreach($MyLoanBalance as $l){
    $l_count++;
        $total_amort_rawname="ttl_amortization_".$l->emp_loan_id;
        $$total_amort_rawname=0;
        
        $total_finalLoan_rawname="ttl_finalLoan_".$l->emp_loan_id;
        $$total_finalLoan_rawname=0;

        //get ALL additional Loans.
        $MyAdditionalLoansAll=$this->payroll_generate_lastpay_model->AdditionalLoansAll($l->emp_loan_id);
        // //get total additional Loans.
        // $MyAdditionalLoansTotal=$this->payroll_generate_lastpay_model->AdditionalLoansTotal($l->emp_loan_id);
        //get all amortization
        $MyLoanAmort=$this->payroll_generate_lastpay_model->LoanAmort($l->emp_loan_id);


  
        echo '
        <tr>
            <td><input type="checkbox" id="loabBalCheckbox'.$l_count.'" onclick="computeLB'.$l_count.'();"></td>
            <td>'.$l->loan_type_name.'</td>
            <td>'.$l->principal_amt.'</td>
            <td>
                <table class="table table"> 
                <thead>
                    <tr>
                        <th class="bg-danger">Original Loan Amount</th>
                        <th class="text-primary">'.$l->loan_amt.'</th>                   
                    </tr>
                    <tr>
                        <th>Date Effective</th>
                        <th>Additional Loan Amount</th>                   
                    </tr>
                </thead>
                <tbody>
                ';       

        if(!empty($MyAdditionalLoansAll)){


            foreach($MyAdditionalLoansAll as $a){

        $$total_finalLoan_rawname+=$a->loan_amount;
                echo '
                <tr>
                    <td>'.$a->date_effective.'</td>
                    <td>'.$a->loan_amount.'</td>                   
                </tr>
                ';
            }
                echo '
                <tr>
                    <th class="bg-danger">Total Additional</th>
                    <th class="text-primary">'.$$total_finalLoan_rawname.'</th>                   
                </tr>
                ';
        }else{

        }
        $overAllTotalLoan=$l->loan_amt+$$total_finalLoan_rawname;

                echo '
                <tr>
                    <th class="bg-danger">Overall Total Loan</th>
                    <th class="bg-primary">'.$overAllTotalLoan.'</th>                   
                </tr>
                ';

        echo '            
                </tbody></table>
            </td>
    
            <td>
                <table class="table table">
                    <thead>
                    <tr>
                        <th>Payroll Period</th>
                        <th>Amortization</th>
                    </tr>
                    </thead>
                    <tbody>';

if(!empty($MyLoanAmort)){
    foreach($MyLoanAmort as $amort){

        $ttl_amort=$amort->system_deduction;
        $$total_amort_rawname+=$ttl_amort;
        echo '
            <tr>
                <td>'.$amort->complete_from.' TO '.$amort->complete_to.'</td>
                <td>'.$amort->system_deduction.'</td>
            </tr>
        ';
    }
    echo '
    <tr>
    <th>Total</th>
    <td>'.$$total_amort_rawname.'</td>
    </tr>
    ';


}else{

}

$LoanBalTotal=$overAllTotalLoan-$$total_amort_rawname;

        echo '      </tbody>
                </table>
            </td>
            <td><div id="loanBal'.$l_count.'">'.$LoanBalTotal.'</div>
<div style="display:none;" id="totalLoan'.$l_count.'">
</div>
            </td>
        </tr>

        ';
?>        
<script type="text/javascript">
        function computeLB<?php echo $l_count;?>(){ 

        var loanBal = document.getElementById("loanBal<?php echo $l_count;?>").innerHTML;
        var loanBal = Number(loanBal);  
        var loanBalcheckBox = document.getElementById("loabBalCheckbox<?php echo $l_count;?>");

        if(loanBalcheckBox.checked == true){
            document.getElementById("totalLoan<?php echo $l_count;?>").innerHTML=loanBal;
        }else{
            document.getElementById("totalLoan<?php echo $l_count;?>").innerHTML="0.00";
        }

        ttl_loan();

        }

</script>


<?php
    }
}else{

}
?>

<script type="text/javascript">
    function ttl_loan(){   
        var z_loan=0;  
<?php 
$ab=$l_count;
while($ab>0){?>
        var tl = document.getElementById("totalLoan<?php echo $ab;?>").innerHTML;
        var tl =Number(tl);

        var loabBalCheckbox = document.getElementById("loabBalCheckbox<?php echo $ab;?>");
        if(loabBalCheckbox.checked == true){
            var z_loan=z_loan+tl;
            document.getElementById("LoanFinalOverAll").innerHTML=z_loan;
        }else{
            document.getElementById("LoanFinalOverAll").innerHTML=z_loan;
        }
<?php 
$ab=$ab-1;
}
?>
document.getElementById("LoanFinalOverAll").innerHTML=z_loan;
    }
</script>



<?php

echo '  
<tr>
    <td class="justBold" colspan="3">TOTAL LOAN FOR DEDUCTION : </td>
    <td class="justBold"><div class="col-md-12" id="LoanFinalOverAll">0.00 </div></td>
    <td colspan="6"></td>
</tr>


</tbody>

    </table>

    </div>

';
// ===================================================================== End Loan Balance

// ===================================================================== Start Training Fees
echo '
<table class="table table">
    <thead>
        <tr>
            <th colspan="7" class="center_Topic titleBG">TRAINING FEES AND TENURE</th>
        </tr>
        <tr>
            <th>Training Title</th>
            <th>Date</th>
            <th>Fee</th>
            <th>Fee Type</th>
            <th>Balance</th>
            <th>Required Tenure</th>
            <th>Penalty Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Training Title</td>
            <td>Date</td>
            <td>Fee</td>
            <td>Fee Type</td>
            <td>Balance</td>
            <td>Required Tenure</td>
            <td>Penalty Amount</td>
        </tr>
    </tbody>
</table>
';
// ===================================================================== End Training Fees
// ===================================================================== Start General Adjustment
echo '
<table class="table table">
    <thead>
        <tr>
            <th colspan="2" class="center_Topic titleBG">GENERAL ADJUSTMENT</th>
        </tr>
        <tr>
            <th class="salhis_td">Adjustment Taxable</th>
            <th class="salhis_td">Adjustment Non-Taxable</th>
        </tr>
    </thead>

    <tbody>
         <tr>
            <td><input type="text" class="form-control" name="gen_adj_taxable"></td>
            <td><input type="text" class="form-control" name="gen_adj_nontaxable"></td>
        </tr>   
    </tbody>
</table>

';

// ===================================================================== End General Adjustment


// ===================================================================== Start Total Computation
echo '
<table class="table table">
<thead>
    <tr>
        <th colspan="2" class="center_Topic titleBG">TOTAL COMPUTATION</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>13th Month Pay</td>
        <td><div id="final_tertin_month">0.00</div></td>
    </tr>
    <tr>
        <td>Amount Withheld</td>
        <td><div id="final_amount_withheld">0.00</div></td>
    </tr>
    <tr>
        <td>Leave Balance Convert To Cash</td>
        <td>0.00</td>
    </tr>
    <tr>
        <td>Length Of Stay(Non-Tax)</td>
        <td>0.00</td>
    </tr>
    <tr>
        <td>Length Of Stay(Taxable)</td>
        <td>0.00</td>
    </tr>
    <tr>
        <td>Hold Salary</td>
        <td>0.00</td>
    </tr>
    <tr>
        <td>Loan Balance</td>
        <td>0.00</td>
    </tr>
    <tr>
        <td>Training Fees</td>
        <td>0.00</td>
    </tr>
    <tr>
        <td>General Adjustment(taxable)</td>
        <td>0.00</td>
    </tr>
    <tr>
        <td>General Adjustment(non-taxable)</td>
        <td>0.00</td>
    </tr>
    <tr>
        <td>Total</td>
        <td><div id="final_lastpay"></div></td>
    </tr>

</tbody>

</table>
';

// =====================================================================  next lastpay







}// END IF NOT PRINT PAYSLIP






?>

 <button type="submit" class="btn btn-lg btn-danger pull-right"> Save </button>

<?php



}else{ // END IF THERES NO EMPLOYEE FOUND.

    echo "
    <tr>
    <td colspan='6'><i class='fa fa-close text-danger' style='font-size:48px;'></i>No Employee Found</i>

    </td>
    </tr>";

 
}





?>

<br>

<?php
}// end no problem with selection on filtering
?>

<script type="text/javascript">
// ======== start total computation


function recompute_final_amount_withheld(){ 
        var amount_withheld = document.getElementById("amount_withheld").value;  
        var a = Number(amount_withheld);

        var checkBox = document.getElementById("include_amount_withheld");
          
        if(checkBox.checked == true){
            document.getElementById("final_amount_withheld").innerHTML=a;
        }else{
            document.getElementById("final_amount_withheld").innerHTML="0.00";
        }
}

function draft_lastpay_save(){

          if (window.XMLHttpRequest)
            {
            xmlhttp=new XMLHttpRequest();
            }
          else
            {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
          xmlhttp.onreadystatechange=function()
            {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
              {
              
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_lastpay/draft_lastpay_save/",true);
          xmlhttp.send();


}
function recompute_final_tertin_month(){
            var total_basic = document.getElementById("total_basic").value;  

            var automatic_tm = document.getElementById("automatic_tm").value;  
            var manual_adj_tm = document.getElementById("manual_adj_tm").value;   
// ===
            var separate_tertin_net_and_tax = document.getElementById("separate_tertin_net_and_tax").value; 
            var separate_bonus_net_and_tax = document.getElementById("separate_bonus_net_and_tax").value; 
            var taxable_amt_beyond = document.getElementById("taxable_amt_beyond").value;  
            var nontax_deminimis = document.getElementById("nontax_deminimis").value;    
            var government_contribution = document.getElementById("government_contribution").value;  

            var final_tertin = Number(automatic_tm) + Number(manual_adj_tm) + Number(separate_bonus_net_and_tax) + Number(separate_tertin_net_and_tax);

            var withtaxabletertin= Number(final_tertin)-Number(taxable_amt_beyond);


            if(Number(final_tertin)>Number(taxable_amt_beyond)){
                var tertin_taxable_how ='<a title="(automatic 13th month ('+automatic_tm+') + manual 13th month adjustment('+manual_adj_tm+') + separate payslip bonus net & tax('+separate_bonus_net_and_tax+')+ separate 13th month net & tax('+separate_tertin_net_and_tax+')) - taxable amount beyond('+taxable_amt_beyond+')"><i class="fa fa-info">help</i></a>';

                var final_tertin =Number(taxable_amt_beyond);
                var tertin_taxable= withtaxabletertin;

            }else{
                var tertin_taxable = 0;
                var tertin_taxable_how ='';
            }

            var nontax_compen_income_a = Number(nontax_deminimis) + Number(government_contribution) + Number(final_tertin);
            var nontax_compen_income_a_how ='<a title="non taxable 13th month & bonus('+final_tertin+')  + deminimis('+nontax_deminimis+') + government deduction('+government_contribution+')"><i class="fa fa-info">help</i></a>';

            var tertin_taxable =Number(tertin_taxable).toFixed(2);  

            var total_taxable_income_b_how='<a title="Basic('+total_basic+') + taxable 13th month and bonus('+tertin_taxable+') + taxable salaries & other forms() "><i class="fa fa-info">help</i></a>';

            var checkBox = document.getElementById("include_13thmonth");
            var a =Number(automatic_tm) + Number(manual_adj_tm);

            if(checkBox.checked == true){
            document.getElementById("final_tertin_month").innerHTML=a;
            document.getElementById("show_recompute_tertin_month").innerHTML=a;

            document.getElementById("aw_tertin_month_nontax").innerHTML=final_tertin;// aw: amount withheld
            document.getElementById("aw_tertin_month_taxable").innerHTML=tertin_taxable+" "+tertin_taxable_how;// aw: amount withheld

            document.getElementById("aw_total_taxable_income_b").innerHTML=tertin_taxable+" "+total_taxable_income_b_how;//
            document.getElementById("aw_net_taxable_bc").innerHTML=tertin_taxable+" "+tertin_taxable_how;//


            document.getElementById("show_nontax_compen_income_a").innerHTML=nontax_compen_income_a+" "+nontax_compen_income_a_how;// aw: 

            }else{
            document.getElementById("final_tertin_month").innerHTML="0.00";
            document.getElementById("show_recompute_tertin_month").innerHTML="0.00";

            document.getElementById("aw_tertin_month_nontax").innerHTML="0.00";
            document.getElementById("aw_tertin_month_taxable").innerHTML="0.00";
            document.getElementById("show_nontax_compen_income_a").innerHTML="0.00";
            }

}

 // function recompute_tertin_month()
 //        {    
 //            var automatic_tm = document.getElementById("automatic_tm").value;  
 //            var manual_adj_tm = document.getElementById("manual_adj_tm").value;  

 //            var separate_tertin_net_and_tax = document.getElementById("separate_tertin_net_and_tax").value; 
 //            var separate_bonus_net_and_tax = document.getElementById("separate_bonus_net_and_tax").value; 
 //            var taxable_amt_beyond = document.getElementById("taxable_amt_beyond").value;  
 //            var nontax_deminimis = document.getElementById("nontax_deminimis").value;    
 //            var government_contribution = document.getElementById("government_contribution").value;  

 //            var final_tertin = Number(automatic_tm) + Number(manual_adj_tm) + Number(separate_bonus_net_and_tax) + Number(separate_tertin_net_and_tax);

 //            var withtaxabletertin= Number(final_tertin)-Number(taxable_amt_beyond);

 //            if(Number(final_tertin)>Number(taxable_amt_beyond)){
 //                var tertin_taxable_how ='<a title="(automatic 13th month ('+automatic_tm+') + manual 13th month adjustment('+manual_adj_tm+') + separate payslip bonus net & tax('+separate_bonus_net_and_tax+')+ separate 13th month net & tax('+separate_tertin_net_and_tax+')) - taxable amount beyond('+taxable_amt_beyond+')"><i class="fa fa-info">help</i></a>';

 //                var final_tertin =Number(taxable_amt_beyond);
 //                var tertin_taxable= withtaxabletertin;

 //            }else{
 //                var tertin_taxable = 0;
 //                var tertin_taxable_how ='';
 //            }

 //            var nontax_compen_income_a = Number(nontax_deminimis) + Number(government_contribution) + Number(final_tertin);
 //            var nontax_compen_income_a_how ='<a title="non taxable 13th month & bonus('+final_tertin+')  + deminimis('+nontax_deminimis+') + government deduction('+government_contribution+')"><i class="fa fa-info">help</i></a>';

 //            var tertin_taxable =Number(tertin_taxable).toFixed(2);  


 //        if (window.XMLHttpRequest)
 //          {
 //          xmlhttp=new XMLHttpRequest();
 //          }
 //        else
 //          {// code for IE6, IE5
 //          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 //          }
 //        xmlhttp.onreadystatechange=function()
 //          {
 //          if (xmlhttp.readyState==4 && xmlhttp.status==200)
 //            {            
 //            document.getElementById("show_recompute_tertin_month").innerHTML=xmlhttp.responseText;
 //            document.getElementById("aw_tertin_month_nontax").innerHTML=final_tertin;// aw: amount withheld
 //            document.getElementById("aw_tertin_month_taxable").innerHTML=tertin_taxable+" "+tertin_taxable_how;// aw: amount withheld
 //            document.getElementById("show_nontax_compen_income_a").innerHTML=nontax_compen_income_a+" "+nontax_compen_income_a_how;// aw: amount withheld
 //            }
 //          }
 //        xmlhttp.open("GET","<?php //echo base_url();?>app/payroll_generate_lastpay/recompute_tertin_month/"+automatic_tm+"/"+manual_adj_tm,true);
 //        xmlhttp.send();

 //        }



</script>