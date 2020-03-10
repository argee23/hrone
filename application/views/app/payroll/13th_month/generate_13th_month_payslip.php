<?php
$company_id=$this->input->post('company_id');
//============================================GET COMPANY PAYROLL THEME============================================
require_once(APPPATH.'views/app/payroll/13th_month/check_general_setup.php');
    // $bg_color_genpay="#006699";
    // $font_color_genpay="#FFF";
    // $overlay_genpay="#000";
    // $bg_color_viewcomp_act_cutoff="#D9E6FC";
    // $actual_payslip_design="117"; // default Type 1

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
//$IsLock=$pay_period_info->IsLock;
$period_no_of_days=$pay_period_info->no_of_days;


}else{} // no payroll period searched.


if(!empty($employee)){

if($selected_payroll_option=="print_payslip" OR $selected_payroll_option=="reset_payslip" OR $selected_payroll_option=="encode_adjustment" OR $selected_payroll_option=="manual_tertin_month"){

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
               // echo 'true'.$oa_id.'<br>';
                $get_this_oa.="oa_id='".$oa_id."' OR ";
            }else{
                //echo 'False'.$oa_id.'<br>';
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
               // echo 'true'.$oa_id.'<br>';
                $get_this_od.="od_id='".$od_id."' OR ";
            }else{
                //echo 'False'.$oa_id.'<br>';
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

if($selected_payroll_option=="encode_adjustment"){
?>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_generate_13th_month/save_adjustment/<?php echo $pay_period?>/<?php echo $company_id?>" >

  <input type="hidden" name="payroll_option" value="manual_adjustment">

<div class="datagrid">
<table class="table table">
    <thead>
        <thead>
            <tr>
                <th colspan="3" style="text-align:center;">Encode Adjustment to 13th month computation</th>
            </tr>
        </thead>
    </thead>
</table>
</div>

<?php  

}elseif($selected_payroll_option=="manual_tertin_month"){
?>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_generate_13th_month/save_manual_tertin_month/<?php echo $pay_period?>/<?php echo $company_id?>" target="_blank">

  <input type="hidden" name="payroll_option" value="manual_tertin_month">

<div class="datagrid">
<table class="table table">
    <thead>
        <thead>
            <tr>
                <th colspan="3" style="text-align:center;">Encode Manual 13th Month Computation</th>
            </tr>
        </thead>
    </thead>
</table>
</div>

<?php
}else{

}


	foreach($employee as $emp){
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
        $location_id=$emp->location_id;
        $taxcode_name=$emp->taxcode_name;
		$taxcode_id=$emp->taxcode_id;

		$employment=$emp->employment_name;
		$classification=$emp->classification;
		$classification_id=$emp->ei_classification_id;
		$employment_id=$emp->ei_employment_id;
        $pay_type_name=$emp->pay_type_name;
        $active_pay_type=$emp->pay_type;


        $date_employed=$emp->date_employed;
		$emp_electronic_signature=$emp->electronic_signature;


if($selected_payroll_option=="encode_adjustment"){
    $check_saved_adj=$this->Payroll_generate_13th_month_model->check_adjustment($employee_id,$pay_period);
    if(!empty($check_saved_adj)){
        $current_amount=$check_saved_adj->amount;
    }else{
        $current_amount="";
    }
}else{

}


//============================================ CHECK COMPANY DIVISION SETTING============================================
if($wDivision=="1"){

$getmydivision=$this->Payroll_generate_13th_month_model->getDivision($emp->division_id);
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

$getmysubsection=$this->Payroll_generate_13th_month_model->getSubsection($emp->section);
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

//============================================ CHECK EMPLOYEE PAYROLL PERIOD GROUP ===========================================
$getmy_payroll_period_group=$this->Payroll_generate_13th_month_model->spec_payroll_period_group($emp->payroll_period_group_id);
$my_group_name=$getmy_payroll_period_group->group_name;

//============================================GET SALARY RATE : SALARY NAME
$active_salary_rate=$mysalaryrate;

if($selected_payroll_option=="encode_adjustment"){
    require(APPPATH.'views/app/payroll/13th_month/payslip_header_adjustment.php');  
}elseif($selected_payroll_option=="manual_tertin_month"){
    require(APPPATH.'views/app/payroll/13th_month/payslip_header_manual_tertin_month.php');  
}else{
    require(APPPATH.'views/app/payroll/13th_month/payslip_header.php');  
}
  


if($selected_payroll_option=="print_payslip"){
$payperiod_from = $this->general_model->get_payroll_period($emp->covered_from);
$payperiod_to = $this->general_model->get_payroll_period($emp->covered_to);
$ispayslip_viewed=$emp->employee_acknowledge;


require(APPPATH.'views/app/payroll/13th_month/print_payslip_body.php');    


}elseif($selected_payroll_option=="reset_payslip"){

$payperiod_from = $this->general_model->get_payroll_period($emp->covered_from);
$payperiod_to = $this->general_model->get_payroll_period($emp->covered_to);
$ispayslip_viewed=$emp->employee_acknowledge;
$posted_status="Successfully Reset.";
require(APPPATH.'views/app/payroll/13th_month/reset_payslip.php');    //print_payslip_body

               
               $reset_posted_tertin_month=$this->Payroll_generate_13th_month_model->reset_posted_tertin_month($company_id,$employee_id,$pay_period);
               





}elseif($selected_payroll_option=="encode_adjustment" OR $selected_payroll_option=="manual_tertin_month"){


}else{


//============================================ CHECK standard variables ===========================================
$compute_tertin_month=$this->Payroll_generate_13th_month_model->compute_tertin_month($employee_id,$final_payroll_coverage,$formula_code);

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
    //echo "$postive_manual_adj | $negative_manual_adj";
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
        $tertin_month_value=$tertin_month_value+$manual_adj;
        //echo "$tertin_month_value | $manual_adj ";

        if($tertin_month_value>$taxable_amt_beyond){// with tax
            $taxable_tertin_month=$tertin_month_value-$taxable_amt_beyond;
            $taxable_formula_value=$tertin_month_value-$taxable_amt_beyond;



            $payroll_formula=$this->payroll_generate_payslip_model->formula_setup($company_id,$location_id,$classification_id,$employment_id,$active_pay_type,$active_salary_rate);

            $wtax_formula=$payroll_formula->wtax_formula_code;
            $wtax_formula_desc=$payroll_formula->wtax_formula_desc;

            $wtax_table_setup=$this->payroll_generate_payslip_model->get_wtax_table($company_id,$active_pay_type,$active_salary_rate,$year_cover,$taxcode_id,$taxable_formula_value);
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


    $check_posted_tertin_month=$this->Payroll_generate_13th_month_model->check_posted_tertin_month($company_id,$employee_id,$pay_period,$from_cov_pay_period,$to_cov_pay_period);

if($selected_payroll_option=="post_all"){

    if(!empty($check_posted_tertin_month)){
        $posted_status="Already Posted last ".$check_posted_tertin_month->date_added;
          $how_many_did_post_prev++; 
    }else{

        if($tertin_month_value>=$minimum_netpay_to_post){
            $this->Payroll_generate_13th_month_model->post_tertin_month($company_id,$employee_id,$tertin_month_value,$tertin_month_formula_var,$tertin_month_formula_math,$formula_id,$pay_period,$from_cov_pay_period,$to_cov_pay_period,$manual_adj,$taxable_tertin_month,$wtax_formula_text,$witheld_tax);   
             $posted_status="Successfully Posted.";   
             $how_many_did_post++;      
        }else{
             $how_many_did_not_post++;
             $posted_status="Notice: Cannot Post as Minimum Netpay setup is $minimum_netpay_to_post.";
        }


       
    }

}elseif($selected_payroll_option=="view"){

    if(!empty($check_posted_tertin_month)){
        $posted_status="Note: This is Already Posted last ".$check_posted_tertin_month->date_added;

    }else{
        $posted_status="<span class='text-danger'>Not Yet Posted</span>";
    }

}else{
    $posted_status="";

}



require(APPPATH.'views/app/payroll/13th_month/payslip_body.php');    


//echo " $employee_id | $tertin_month_value | $selected_payroll_option | $posted_status <br><br>";
//echo " $go_check_od | $employee_id | $tertin_month_value | $selected_payroll_option | $posted_status <br><br>";




}// END IF NOT PRINT PAYSLIP



}// END FOREACH OF EMPLOYEES


if($selected_payroll_option=="encode_adjustment" OR $selected_payroll_option=="manual_tertin_month"){
?>

 <button type="submit" class="btn btn-lg btn-danger pull-right"> Save </button>
</form>
<?php
}else{

}


}else{ // END IF THERES NO EMPLOYEE FOUND.

    echo "
    <tr>
    <td colspan='6'><i class='fa fa-close text-danger' style='font-size:48px;'></i>No Employee Found</i>

    </td>
    </tr>";

 
}


if($selected_payroll_option=="post_all"){

    echo "
    <div class='col-md-12'>
    Did not post due to minimum net pay requirement which is ($minimum_netpay_to_post) . <i class='fa fa-arrow-right'></i> ".$how_many_did_not_post." Employees
    </div>
    <div class='col-md-12'>
    Current Process Successfully Posted . <i class='fa fa-arrow-right'></i> ".$how_many_did_post." Employees
    </div>
    <div class='col-md-12'>
    Previously Posted . <i class='fa fa-arrow-right'></i> ".$how_many_did_post_prev." Employees
    </div>
    ";

}else{


}






?>

<br>

<?php
}// end no problem with selection on filtering
?>

