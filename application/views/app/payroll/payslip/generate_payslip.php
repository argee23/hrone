<?php
$company_id=$this->input->post('company_id');
//============================================GET COMPANY PAYROLL THEME============================================
require_once(APPPATH.'views/app/payroll/payslip/check_general_setup.php');

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
$wDivision=$company_info->wDivision;
$company_name=$company_info->company_name;
$company_logo=$company_info->logo;

$pay_type=$this->input->post('pay_type');
$pay_type_group=$this->input->post('pay_type_group');
//$selected_payroll_option=$this->input->post('payroll_option');
//$pay_period=$this->input->post('pay_period');
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
		$count_employees = 0; // count employees
		
//start declare annualize variables 
$assumed_taxable_monthly="";
$assumed_taxable_yearly="";
$assumed_tax_in_a_year="";
$assumed_tax_in_a_month="";
$assumed_tax_in_a_cutoff="";
$actual_taxable_formula_value="";
//end declare annualize variable

	foreach($employee as $emp){
//============================================EMPLOYEE INFO VARIABLE LISTS============================================
		$employee_id=$emp->employee_id;
        $regday_otmeal="regular_day_otMealCounter".$employee_id;
        $$regday_otmeal=0;

        $restday_otmeal="restday_otMealCounter".$employee_id;
        $$restday_otmeal=0;

        $reghol_otmeal="reghol_otMealCounter".$employee_id;
        $$reghol_otmeal=0;

        $rdreghol_otmeal="rdreghol_otMealCounter".$employee_id;
        $$rdreghol_otmeal=0;

        $snw_otmeal="snw_otMealCounter".$employee_id;
        $$snw_otmeal=0;

        $rdsnw_otmeal="rdsnw_otMealCounter".$employee_id;
        $$rdsnw_otmeal=0;

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

        $date_employed=$emp->date_employed;
		$emp_electronic_signature=$emp->electronic_signature;

        $isCompressSched=$this->time_dtr_model->IsCompressSchedule($employee_id);
        if(!empty($isCompressSched)){
            $compress_per_hour=$isCompressSched->allow_per_hour_filing;
            $im_compress=$compress_per_hour;
        }else{
            $im_compress=0;
        }

$cle=$this->payroll_generate_payslip_model->checkLateExemption($classification_id,$employment_id,$company_id);
if(!empty($cle)){
$lateExempted=$cle->setting_value;
}else{
$lateExempted="no";    
}

//============================================if per employee ang setup ng sss deduction ============================================
if($is_sss_ded_per_emp=="yes"){
    $sssDed=$this->payroll_generate_payslip_model->check_per_emp_sss($employee_id);
    if(!empty($sssDed)){
        $sss_deduct_on=$sssDed->deduction_schedule;
        if($sss_deduct_on=="6"){// every payday deduction
                $deduct_sss="yes"; // proceed deduct sss
        }else{// with specific cutoff deduction setup
            if($cut_off==$sss_deduct_on){
                $deduct_sss="yes"; // proceed deduct sss
            }else{
                $deduct_sss="no"; // 
            }       
        }
    }else{
            $deduct_sss="no"; // 
            $sss_deduct_on="";
            //initialize then individually check sa foreach ni emp.
    }
}else{

}


//============================================if per employee ang setup ng philhealth deduction ============================================
if($is_ph_ded_per_emp=="yes"){
    $phDed=$this->payroll_generate_payslip_model->check_per_emp_ph($employee_id);
    if(!empty($phDed)){
        $philhealth_deduct_on=$phDed->deduction_schedule;
        if($philhealth_deduct_on=="6"){// every payday deduction
                $deduct_philhealth="yes"; // proceed deduct sss
        }else{// with specific cutoff deduction setup
            if($cut_off==$philhealth_deduct_on){
                $deduct_philhealth="yes"; // proceed deduct sss
            }else{
                $deduct_philhealth="no"; // 
            }       
        }
    }else{
            $deduct_philhealth="no"; // 
            $philhealth_deduct_on="";
            //initialize then individually check sa foreach ni emp.
    }
}else{
}

//============================================EMPLOYEE OFFICIAL SALARY ============================================
        $my_official_salary=$this->payroll_generate_payslip_model->get_official_salary($employee_id,$pay_period_from,$pay_period_to);
        if(!empty($my_official_salary)){

            $official_salary_state="yes";
            $mysalary_id=$my_official_salary->salary_id;
            $mysalaryrate=$my_official_salary->salary_rate;
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
            $retro_pay_late_effectivity_reference=$my_official_salary->retro_pay_late_effectivity_reference;
        }else{
            $retro_pay_late_effectivity_reference="";
            $mysalaryrate="";
            $mysalaryrate_name="";
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
$getmy_payroll_period_group=$this->payroll_generate_payslip_model->spec_payroll_period_group($emp->payroll_period_group_id);
$my_group_name=$getmy_payroll_period_group->group_name;

//echo "HEY $is_with_processed_dtr";
//============================================ GET PROCESSED DTR SUMMARY ===========================================
$my_dtr_summary=$this->payroll_generate_payslip_model->get_time_summary($pay_period,$company_id,$employee_id,$month_cover);
if(!empty($my_dtr_summary)){   
    $is_with_processed_dtr="yes";

    $processeddtr_salary_rate=$my_dtr_summary->salary_rate;
    $processeddtr_pay_type=$my_dtr_summary->pay_type;
    $total_regular_hours=$my_dtr_summary->total_regular_hours;
    $leave_reg_hrs=$my_dtr_summary->leave_reg_hrs;


    $total_regular_nd=$my_dtr_summary->total_regular_nd;
    $total_regular_overtime=$my_dtr_summary->total_regular_overtime;
    $total_regular_overtime_nd=$my_dtr_summary->total_regular_overtime_nd;
    $total_regular_hrs_restday=$my_dtr_summary->total_regular_hrs_restday;
    $total_restday_nd=$my_dtr_summary->total_restday_nd;
    $total_restday_overtime=$my_dtr_summary->total_restday_overtime;
    $total_restday_overtime_nd=$my_dtr_summary->total_restday_overtime_nd;
    $total_regular_hrs_reg_holiday=$my_dtr_summary->total_regular_hrs_reg_holiday;
    $total_reg_holiday_nd=$my_dtr_summary->total_reg_holiday_nd;
    $total_reg_holiday_overtime=$my_dtr_summary->total_reg_holiday_overtime;
    $total_reg_holiday_overtime_nd=$my_dtr_summary->total_reg_holiday_overtime_nd;
    $total_regular_hrs_reg_holiday_t1=$my_dtr_summary->total_regular_hrs_reg_holiday_t1;
    $total_regular_hrs_reg_holiday_t2=$my_dtr_summary->total_regular_hrs_reg_holiday_t2;
    $total_restday_reg_holiday_nd=$my_dtr_summary->total_restday_reg_holiday_nd;
    $total_restday_reg_holiday_overtime=$my_dtr_summary->total_restday_reg_holiday_overtime;
    $total_restday_reg_holiday_overtime_nd=$my_dtr_summary->total_restday_reg_holiday_overtime_nd;
    $total_regular_hrs_spec_holiday=$my_dtr_summary->total_regular_hrs_spec_holiday;
    $total_spec_holiday_nd=$my_dtr_summary->total_spec_holiday_nd;
    $total_spec_holiday_overtime=$my_dtr_summary->total_spec_holiday_overtime;
    $total_spec_holiday_overtime_nd=$my_dtr_summary->total_spec_holiday_overtime_nd;
    $total_restday_regular_hrs_spec_holiday=$my_dtr_summary->total_restday_regular_hrs_spec_holiday;
    $total_restday_spec_holiday_nd=$my_dtr_summary->total_restday_spec_holiday_nd;
    $total_restday_spec_holiday_overtime=$my_dtr_summary->total_restday_spec_holiday_overtime;
    $total_restday_spec_holiday_overtime_nd=$my_dtr_summary->total_restday_spec_holiday_overtime_nd;

    $absences_total=$my_dtr_summary->absences_total;
    $undertime_total=$my_dtr_summary->undertime_total;
    $tardiness_total=$my_dtr_summary->tardiness_total;
    $overbreak_total=$my_dtr_summary->overbreak_total;

    $absences_occurence=$my_dtr_summary->absences_occurence;
    $undertime_occurence=$my_dtr_summary->undertime_occurence;
    $tardiness_occurence=$my_dtr_summary->tardiness_occurence;
    $overbreak_occurence=$my_dtr_summary->overbreak_occurence;

    $complete_logs_present_occ=$my_dtr_summary->complete_logs_present_occ;
    $with_tk_logs_present_occ=$my_dtr_summary->with_tk_logs_present_occ;
    $with_ob_logs_present_occ=$my_dtr_summary->with_ob_logs_present_occ;
    $with_leave_present_occ=$my_dtr_summary->with_leave_present_occ;
    $restday_w_logs=$my_dtr_summary->restday_w_logs;
    $restday_wo_logs=$my_dtr_summary->restday_wo_logs;
    $reg_holiday_w_logs=$my_dtr_summary->reg_holiday_w_logs;
    $reg_holiday_wo_logs=$my_dtr_summary->reg_holiday_wo_logs;
    $snw_holiday_w_logs=$my_dtr_summary->snw_holiday_w_logs;
    $snw_holiday_wo_logs=$my_dtr_summary->snw_holiday_wo_logs;

 $total_days_present=$complete_logs_present_occ+$with_tk_logs_present_occ+$with_ob_logs_present_occ+$with_leave_present_occ;

if($mysalaryrate=="3"){//daily rate
    if($total_days_present==0){//total_regular_hours
        $no_attendance="yes";
    }else{
        $no_attendance="";
    }
}else{

   
    if($total_days_present==0){
        $no_attendance="yes";
    }else{
        $no_attendance="";
    }    

}



}else{
   $is_with_processed_dtr="none";

    $processeddtr_salary_rate="";
    $processeddtr_pay_type="";
    $total_regular_hours="";
    $leave_reg_hrs="";

    $total_regular_nd="";
    $total_regular_overtime="";
    $total_regular_overtime_nd="";
    $total_regular_hrs_restday="";
    $total_restday_nd="";
    $total_restday_overtime="";
    $total_restday_overtime_nd="";
    $total_regular_hrs_reg_holiday="";
    $total_reg_holiday_nd="";
    $total_reg_holiday_overtime="";
    $total_reg_holiday_overtime_nd="";
    $total_regular_hrs_reg_holiday_t1="";
    $total_regular_hrs_reg_holiday_t2="";
    $total_restday_reg_holiday_nd="";
    $total_restday_reg_holiday_overtime="";
    $total_restday_reg_holiday_overtime_nd="";
    $total_regular_hrs_spec_holiday="";
    $total_spec_holiday_nd="";
    $total_spec_holiday_overtime="";
    $total_spec_holiday_overtime_nd="";
    $total_restday_regular_hrs_spec_holiday="";
    $total_restday_spec_holiday_nd="";
    $total_restday_spec_holiday_overtime="";
    $total_restday_spec_holiday_overtime_nd="";

    $absences_total="";
    $undertime_total="";
    $tardiness_total="";
    $overbreak_total="";
    $absences_occurence="";
    $undertime_occurence="";
    $tardiness_occurence="";
    $overbreak_occurence="";

    $complete_logs_present_occ="";
    $with_tk_logs_present_occ="";
    $with_ob_logs_present_occ="";
    $with_leave_present_occ="";
    $restday_w_logs="";
    $restday_wo_logs="";
    $reg_holiday_w_logs="";
    $reg_holiday_wo_logs="";
    $snw_holiday_w_logs="";
    $snw_holiday_wo_logs="";
    $no_attendance="";
}
//============================================GET SALARY RATE : SALARY NAME
$active_salary_rate=$mysalaryrate;

//============================================CHECK PAYSLIP STATUS

if($is_salary_fixed=="1"){

}else{


}

if((($pay_type=="1")or($pay_type=="2")or($pay_type=="3"))AND(($is_with_processed_dtr=="yes") or ($is_salary_fixed=="1"))) {

    if($pay_type=="1"){ //weekly
     
            

            $check_other_cutoff_a=$this->payroll_generate_payslip_model->check_other_cutoff_weekly($month_cover,$year_cover,$pay_period,$cut_off,$pay_type_group,$company_id);

    if($cut_off=="1"){
        $payroll_period_id_1=$pay_period;
    }elseif($cut_off=="2"){
        $payroll_period_id_2=$pay_period;
    }elseif($cut_off=="3"){
        $payroll_period_id_3=$pay_period;
    }elseif($cut_off=="4"){
        $payroll_period_id_4=$pay_period;
    }elseif($cut_off=="5"){
        $payroll_period_id_5=$pay_period;
    }else{
    }


            if(!empty($check_other_cutoff_a)){

                                $payroll_period_id_1=""; 
                                $payroll_period_id_2=""; 
                                $payroll_period_id_3="";
                                $payroll_period_id_4="";
                                $payroll_period_id_5=""; 

                foreach($check_other_cutoff_a as $oc){
                    if($oc->cut_off=="1"){
                        $payroll_period_id_1=$oc->id; 
                    }elseif($oc->cut_off=="2"){
                        $payroll_period_id_2=$oc->id; 
                    }elseif($oc->cut_off=="3"){
                        $payroll_period_id_3=$oc->id;
                    }elseif($oc->cut_off=="4"){
                        $payroll_period_id_4=$oc->id;
                    }elseif($oc->cut_off=="5"){
                        $payroll_period_id_5=$oc->id;
                    }else{

 
                    }                 
                }

 

            }else{ // di pa naa-add yung cutoff

                    if($cut_off=="1"){
                                $payroll_period_id_2=""; 
                                $payroll_period_id_3="";
                                $payroll_period_id_4="";
                                $payroll_period_id_5=""; 
                    }elseif($cut_off=="2"){
                                $payroll_period_id_1=""; 
                                $payroll_period_id_3="";
                                $payroll_period_id_4="";
                                $payroll_period_id_5=""; 
                    }elseif($cut_off=="3"){
                                $payroll_period_id_2=""; 
                                $payroll_period_id_1="";
                                $payroll_period_id_4="";
                                $payroll_period_id_5=""; 
                    }elseif($cut_off=="4"){
                                $payroll_period_id_2=""; 
                                $payroll_period_id_3="";
                                $payroll_period_id_1="";
                                $payroll_period_id_5=""; 
                    }elseif($cut_off=="5"){
                                $payroll_period_id_2=""; 
                                $payroll_period_id_3="";
                                $payroll_period_id_4="";
                                $payroll_period_id_1=""; 
                    }else{
                    }  



            }       



    }else{//standard semi-monthly
         if($cut_off=="1"){
            $payroll_period_id_1=$pay_period;
            $check_other_cutoff_a=$this->payroll_generate_payslip_model->check_other_cutoff($month_cover,$year_cover,$pay_period,$cut_off,$pay_type_group,$company_id);
            if(!empty($check_other_cutoff_a)){
                $payroll_period_id_2=$check_other_cutoff_a->id; 
            }else{
                $payroll_period_id_2=""; ////echo "wala pa yung second cutoff";
            }       
        }else{
                $payroll_period_id_2=$pay_period;
                $check_other_cutoff_b=$this->payroll_generate_payslip_model->check_other_cutoff($month_cover,$year_cover,$pay_period,$cut_off,$pay_type_group,$company_id);
                $payroll_period_id_1=$check_other_cutoff_b->id; //       
        }
       
    }





//============================================CHECK POSTED 1st cutoff
$check_payroll_period_id=$payroll_period_id_1;
$payslip_state_1st_cutoff=$this->payroll_generate_payslip_model->check_payslip_status($check_payroll_period_id,$company_id,$employee_id,$month_cover);
//============================================CHECK POSTED 2nd cutoff
$check_payroll_period_id=$payroll_period_id_2;
$payslip_state_2nd_cutoff=$this->payroll_generate_payslip_model->check_payslip_status($check_payroll_period_id,$company_id,$employee_id,$month_cover);

//==== start for weekly only
   if($pay_type=="1"){ 
//============================================CHECK POSTED 3rd cutoff
$check_payroll_period_id=$payroll_period_id_3;
$payslip_state_3rd_cutoff=$this->payroll_generate_payslip_model->check_payslip_status($check_payroll_period_id,$company_id,$employee_id,$month_cover);
//============================================CHECK POSTED 4th cutoff
$check_payroll_period_id=$payroll_period_id_4;
$payslip_state_4th_cutoff=$this->payroll_generate_payslip_model->check_payslip_status($check_payroll_period_id,$company_id,$employee_id,$month_cover);
//============================================CHECK POSTED 4th cutoff
$check_payroll_period_id=$payroll_period_id_5;
$payslip_state_5th_cutoff=$this->payroll_generate_payslip_model->check_payslip_status($check_payroll_period_id,$company_id,$employee_id,$month_cover);


   }else{

   }
//==== end for weekly only


    if(!empty($payslip_state_1st_cutoff)){

        $first_cutoff_payslip_state="posted";

        $first_posted_pay_type=$payslip_state_1st_cutoff->pay_type;
        $first_posted_salary_rate=$payslip_state_1st_cutoff->salary_rate;
        $first_posted_salary_amount=$payslip_state_1st_cutoff->salary_amount;
        $first_posted_salary_no_of_hour=$payslip_state_1st_cutoff->salary_no_of_hour;
        $first_posted_salary_month_days_no=$payslip_state_1st_cutoff->salary_month_days_no;
        $first_posted_salary_year_days_no=$payslip_state_1st_cutoff->salary_year_days_no;

        $first_posted_basic=$payslip_state_1st_cutoff->basic;
        $first_posted_net_basic_formula=$payslip_state_1st_cutoff->posted_net_basic_formula;

        $first_posted_overtime=$payslip_state_1st_cutoff->overtime;
        $first_posted_ot_formula=$payslip_state_1st_cutoff->posted_ot_formula;

        $first_posted_shift_night_diff=$payslip_state_1st_cutoff->shift_night_diff;
        $first_posted_shift_night_diff_formula=$payslip_state_1st_cutoff->posted_shift_night_diff_formula;

        $first_posted_cola=$payslip_state_1st_cutoff->cola;
        $first_posted_cola_how_to=$payslip_state_1st_cutoff->posted_cola_how_to;

        $first_posted_other_addition_taxable=$payslip_state_1st_cutoff->other_addition_taxable;
        $first_posted_oa_taxable_how_to=$payslip_state_1st_cutoff->posted_oa_taxable_how_to;
        $first_posted_other_addition_non_tax=$payslip_state_1st_cutoff->other_addition_non_tax;
        $first_posted_oa_nontax_how_to=$payslip_state_1st_cutoff->posted_oa_nontax_how_to;
        
        $first_posted_other_deduction_taxable=$payslip_state_1st_cutoff->other_deduction_taxable;
        $first_posted_od_taxable_how_to=$payslip_state_1st_cutoff->posted_od_taxable_how_to;
        $first_posted_other_deduction_nontax=$payslip_state_1st_cutoff->other_deduction_nontax;
        $first_posted_od_nontax_how_to=$payslip_state_1st_cutoff->posted_od_nontax_how_to;
        
        $first_posted_gross=$payslip_state_1st_cutoff->gross;
        $first_posted_gross_formula=$payslip_state_1st_cutoff->posted_gross_formula;
        
        $first_posted_loan=$payslip_state_1st_cutoff->loan;
        $first_posted_loan_how_to=$payslip_state_1st_cutoff->posted_loan_how_to;

        $first_posted_sss_employee=$payslip_state_1st_cutoff->sss_employee;
        $first_posted_sss_employer=$payslip_state_1st_cutoff->sss_employer;
        $first_posted_sss_employer_ec_er=$payslip_state_1st_cutoff->sss_ec_er;
        $first_posted_sss_gross=$payslip_state_1st_cutoff->sss_gross;
        $first_posted_sss_formula=$payslip_state_1st_cutoff->posted_sss_formula;
        
        $first_posted_philhealth_employee=$payslip_state_1st_cutoff->philhealth_employee;
        $first_posted_philhealth_employer=$payslip_state_1st_cutoff->philhealth_employer;
        $first_posted_philhealth_gross=$payslip_state_1st_cutoff->philhealth_gross;
        $first_posted_ph_formula=$payslip_state_1st_cutoff->posted_ph_formula;

        $first_posted_pagibig=$payslip_state_1st_cutoff->pagibig;
        $first_posted_pi_formula=$payslip_state_1st_cutoff->posted_pi_formula;

        $first_posted_absent=$payslip_state_1st_cutoff->absent;
        $first_posted_absent_formula=$payslip_state_1st_cutoff->posted_absent_formula;

        $first_posted_late=$payslip_state_1st_cutoff->late;
        $first_posted_late_formula=$payslip_state_1st_cutoff->posted_late_formula;

        $first_posted_undertime=$payslip_state_1st_cutoff->undertime;
        $first_posted_ut_formula=$payslip_state_1st_cutoff->posted_ut_formula;

        $first_posted_overbreak=$payslip_state_1st_cutoff->overbreak;
        $first_posted_overbreak_formula=$payslip_state_1st_cutoff->posted_overbreak_formula;

        $first_posted_taxable=$payslip_state_1st_cutoff->taxable;
        $first_posted_taxable_formula=$payslip_state_1st_cutoff->posted_taxable_formula;

        $first_posted_wtax=$payslip_state_1st_cutoff->wtax;
        $first_posted_wtax_formula=$payslip_state_1st_cutoff->posted_wtax_formula;

        $first_posted_income_total=$payslip_state_1st_cutoff->income_total;
        $first_posted_income_total_how_to=$payslip_state_1st_cutoff->posted_income_total_how_to;

        $first_posted_deduction_total=$payslip_state_1st_cutoff->deduction_total;
        $first_posted_deduction_total_how_to=$payslip_state_1st_cutoff->posted_deduction_total_how_to;

        $first_posted_netpay=$payslip_state_1st_cutoff->net_pay;
        $first_posted_net_pay_formula=$payslip_state_1st_cutoff->posted_net_pay_formula;

        $first_posted_tax_deduction_type_name=$payslip_state_1st_cutoff->tax_deduction_type_name;
        $first_posted_assumed_taxable_monthly=$payslip_state_1st_cutoff->assumed_taxable_monthly;
        $first_posted_assumed_taxable_yearly=$payslip_state_1st_cutoff->assumed_taxable_yearly;
        $first_posted_assumed_tax_in_a_year=$payslip_state_1st_cutoff->assumed_tax_in_a_year;
        $first_posted_assumed_tax_in_a_month=$payslip_state_1st_cutoff->assumed_tax_in_a_month;
        $first_posted_assumed_tax_in_a_cutoff=$payslip_state_1st_cutoff->assumed_tax_in_a_cutoff;
        $first_posted_ytd_taxable=$payslip_state_1st_cutoff->ytd_taxable;
        $first_posted_ytd_wtax=$payslip_state_1st_cutoff->ytd_wtax;

    }else{
       
        $first_posted_ytd_wtax="";

        $first_posted_tax_deduction_type_name="";
        $first_posted_assumed_taxable_monthly="";
        $first_posted_assumed_taxable_yearly="";
        $first_posted_assumed_tax_in_a_year="";
        $first_posted_assumed_tax_in_a_month="";
        $first_posted_assumed_tax_in_a_cutoff="";

        $first_cutoff_payslip_state="";

        $first_posted_pay_type=0;
        $first_posted_salary_rate=0;
        $first_posted_salary_amount=0;
        $first_posted_salary_no_of_hour=0;
        $first_posted_salary_month_days_no=0;
        $first_posted_salary_year_days_no=0;

        $first_posted_basic=0;
        $first_posted_net_basic_formula=0;

        $first_posted_overtime=0;
        $first_posted_ot_formula=0;

        $first_posted_shift_night_diff=0;
        $first_posted_shift_night_diff_formula=0;

        $first_posted_cola=0;
        $first_posted_cola_how_to=0;

        $first_posted_other_addition_taxable=0;
        $first_posted_oa_taxable_how_to=0;
        $first_posted_other_addition_non_tax=0;
        $first_posted_oa_nontax_how_to=0;
        
        $first_posted_other_deduction_taxable=0;
        $first_posted_od_taxable_how_to=0;
        $first_posted_other_deduction_nontax=0;
        $first_posted_od_nontax_how_to=0;
        
        $first_posted_gross=0;
        $first_posted_gross_formula=0;
        
        $first_posted_loan=0;
        $first_posted_loan_how_to=0;

        $first_posted_sss_employee=0;
        $first_posted_sss_employer=0;
        $first_posted_sss_employer_ec_er=0;
        $first_posted_sss_gross=0;
        $first_posted_sss_formula=0;
        
        $first_posted_philhealth_employee=0;
        $first_posted_philhealth_employer=0;
        $first_posted_philhealth_gross=0;
        $first_posted_ph_formula=0;

        $first_posted_pagibig=0;
        $first_posted_pi_formula=0;

        $first_posted_absent=0;
        $first_posted_absent_formula=0;

        $first_posted_late=0;
        $first_posted_late_formula=0;

        $first_posted_undertime=0;
        $first_posted_ut_formula=0;

        $first_posted_overbreak=0;
        $first_posted_overbreak_formula=0;

        $first_posted_taxable=0;
        $first_posted_taxable_formula=0;

        $first_posted_wtax=0;
        $first_posted_wtax_formula=0;


        $first_posted_income_total=0;
        $first_posted_income_total_how_to=0;

        $first_posted_deduction_total=0;
        $first_posted_deduction_total_how_to=0;


        $first_posted_netpay=0;
        $first_posted_net_pay_formula=0;

    }

    if(!empty($payslip_state_2nd_cutoff)){

        $second_cutoff_payslip_state="posted";

        $second_posted_pay_type=$payslip_state_2nd_cutoff->pay_type;
        $second_posted_salary_rate=$payslip_state_2nd_cutoff->salary_rate;
        $second_posted_salary_amount=$payslip_state_2nd_cutoff->salary_amount;
        $second_posted_salary_no_of_hour=$payslip_state_2nd_cutoff->salary_no_of_hour;
        $second_posted_salary_month_days_no=$payslip_state_2nd_cutoff->salary_month_days_no;
        $second_posted_salary_year_days_no=$payslip_state_2nd_cutoff->salary_year_days_no;

        $second_posted_basic=$payslip_state_2nd_cutoff->basic;
        $second_posted_net_basic_formula=$payslip_state_2nd_cutoff->posted_net_basic_formula;

        $second_posted_overtime=$payslip_state_2nd_cutoff->overtime;
        $second_posted_ot_formula=$payslip_state_2nd_cutoff->posted_ot_formula;

        $second_posted_shift_night_diff=$payslip_state_2nd_cutoff->shift_night_diff;
        $second_posted_shift_night_diff_formula=$payslip_state_2nd_cutoff->posted_shift_night_diff_formula;

        $second_posted_cola=$payslip_state_2nd_cutoff->cola;
        $second_posted_cola_how_to=$payslip_state_2nd_cutoff->posted_cola_how_to;

        $second_posted_other_addition_taxable=$payslip_state_2nd_cutoff->other_addition_taxable;
        $second_posted_oa_taxable_how_to=$payslip_state_2nd_cutoff->posted_oa_taxable_how_to;
        $second_posted_other_addition_non_tax=$payslip_state_2nd_cutoff->other_addition_non_tax;
        $second_posted_oa_nontax_how_to=$payslip_state_2nd_cutoff->posted_oa_nontax_how_to;
        
        $second_posted_other_deduction_taxable=$payslip_state_2nd_cutoff->other_deduction_taxable;
        $second_posted_od_taxable_how_to=$payslip_state_2nd_cutoff->posted_od_taxable_how_to;
        $second_posted_other_deduction_nontax=$payslip_state_2nd_cutoff->other_deduction_nontax;
        $second_posted_od_nontax_how_to=$payslip_state_2nd_cutoff->posted_od_nontax_how_to;
        
        $second_posted_gross=$payslip_state_2nd_cutoff->gross;
        $second_posted_gross_formula=$payslip_state_2nd_cutoff->posted_gross_formula;
        
        $second_posted_loan=$payslip_state_2nd_cutoff->loan;
        $second_posted_loan_how_to=$payslip_state_2nd_cutoff->posted_loan_how_to;

        $second_posted_sss_employee=$payslip_state_2nd_cutoff->sss_employee;
        $second_posted_sss_employer=$payslip_state_2nd_cutoff->sss_employer;
        $second_posted_sss_employer_ec_er=$payslip_state_2nd_cutoff->sss_ec_er;
        $second_posted_sss_gross=$payslip_state_2nd_cutoff->sss_gross;
        $second_posted_sss_formula=$payslip_state_2nd_cutoff->posted_sss_formula;
        
        $second_posted_philhealth_employee=$payslip_state_2nd_cutoff->philhealth_employee;
        $second_posted_philhealth_employer=$payslip_state_2nd_cutoff->philhealth_employer;
        $second_posted_philhealth_gross=$payslip_state_2nd_cutoff->philhealth_gross;
        $second_posted_ph_formula=$payslip_state_2nd_cutoff->posted_ph_formula;

        $second_posted_pagibig=$payslip_state_2nd_cutoff->pagibig;
        $second_posted_pi_formula=$payslip_state_2nd_cutoff->posted_pi_formula;

        $second_posted_absent=$payslip_state_2nd_cutoff->absent;
        $second_posted_absent_formula=$payslip_state_2nd_cutoff->posted_absent_formula;

        $second_posted_late=$payslip_state_2nd_cutoff->late;
        $second_posted_late_formula=$payslip_state_2nd_cutoff->posted_late_formula;

        $second_posted_undertime=$payslip_state_2nd_cutoff->undertime;
        $second_posted_ut_formula=$payslip_state_2nd_cutoff->posted_ut_formula;

        $second_posted_overbreak=$payslip_state_2nd_cutoff->overbreak;
        $second_posted_overbreak_formula=$payslip_state_2nd_cutoff->posted_overbreak_formula;

        $second_posted_taxable=$payslip_state_2nd_cutoff->taxable;
        $second_posted_taxable_formula=$payslip_state_2nd_cutoff->posted_taxable_formula;

        $second_posted_wtax=$payslip_state_2nd_cutoff->wtax;
        $second_posted_wtax_formula=$payslip_state_2nd_cutoff->posted_wtax_formula;

        $second_posted_income_total=$payslip_state_2nd_cutoff->income_total;
        $second_posted_income_total_how_to=$payslip_state_2nd_cutoff->posted_income_total_how_to;

        $second_posted_deduction_total=$payslip_state_2nd_cutoff->deduction_total;
        $second_posted_deduction_total_how_to=$payslip_state_2nd_cutoff->posted_deduction_total_how_to;

        $second_posted_netpay=$payslip_state_2nd_cutoff->net_pay;
        $second_posted_net_pay_formula=$payslip_state_2nd_cutoff->posted_net_pay_formula;

        $second_posted_tax_deduction_type_name=$payslip_state_2nd_cutoff->tax_deduction_type_name;
        $second_posted_assumed_taxable_monthly=$payslip_state_2nd_cutoff->assumed_taxable_monthly;
        $second_posted_assumed_taxable_yearly=$payslip_state_2nd_cutoff->assumed_taxable_yearly;
        $second_posted_assumed_tax_in_a_year=$payslip_state_2nd_cutoff->assumed_tax_in_a_year;
        $second_posted_assumed_tax_in_a_month=$payslip_state_2nd_cutoff->assumed_tax_in_a_month;
        $second_posted_assumed_tax_in_a_cutoff=$payslip_state_2nd_cutoff->assumed_tax_in_a_cutoff;


    }else{

        $second_posted_tax_deduction_type_name="";
        $second_posted_assumed_taxable_monthly="";
        $second_posted_assumed_taxable_yearly="";
        $second_posted_assumed_tax_in_a_year="";
        $second_posted_assumed_tax_in_a_month="";
        $second_posted_assumed_tax_in_a_cutoff="";

        $second_cutoff_payslip_state="";

        $second_posted_pay_type=0;
        $second_posted_salary_rate=0;
        $second_posted_salary_amount=0;
        $second_posted_salary_no_of_hour=0;
        $second_posted_salary_month_days_no=0;
        $second_posted_salary_year_days_no=0;

        $second_posted_basic=0;
        $second_posted_net_basic_formula=0;

        $second_posted_overtime=0;
        $second_posted_ot_formula=0;

        $second_posted_shift_night_diff=0;
        $second_posted_shift_night_diff_formula=0;

        $second_posted_cola=0;
        $second_posted_cola_how_to=0;

        $second_posted_other_addition_taxable=0;
        $second_posted_oa_taxable_how_to=0;
        $second_posted_other_addition_non_tax=0;
        $second_posted_oa_nontax_how_to=0;
        
        $second_posted_other_deduction_taxable=0;
        $second_posted_od_taxable_how_to=0;
        $second_posted_other_deduction_nontax=0;
        $second_posted_od_nontax_how_to=0;
        
        $second_posted_gross=0;
        $second_posted_gross_formula=0;
        
        $second_posted_loan=0;
        $second_posted_loan_how_to=0;

        $second_posted_sss_employee=0;
        $second_posted_sss_employer=0;
        $second_posted_sss_employer_ec_er=0;
        $second_posted_sss_gross=0;
        $second_posted_sss_formula=0;
        
        $second_posted_philhealth_employee=0;
        $second_posted_philhealth_employer=0;
        $second_posted_philhealth_gross=0;
        $second_posted_ph_formula=0;

        $second_posted_pagibig=0;
        $second_posted_pi_formula=0;

        $second_posted_absent=0;
        $second_posted_absent_formula=0;

        $second_posted_late=0;
        $second_posted_late_formula=0;

        $second_posted_undertime=0;
        $second_posted_ut_formula=0;

        $second_posted_overbreak=0;
        $second_posted_overbreak_formula=0;

        $second_posted_taxable=0;
        $second_posted_taxable_formula=0;

        $second_posted_wtax=0;
        $second_posted_wtax_formula=0;

        $second_posted_income_total=0;
        $second_posted_income_total_how_to=0;

        $second_posted_netpay=0;
        $second_posted_net_pay_formula=0;

    }

if($pay_type=="1"){
    if(!empty($payslip_state_3rd_cutoff)){

        $third_cutoff_payslip_state="posted";

        $third_posted_pay_type=$payslip_state_3rd_cutoff->pay_type;
        $third_posted_salary_rate=$payslip_state_3rd_cutoff->salary_rate;
        $third_posted_salary_amount=$payslip_state_3rd_cutoff->salary_amount;
        $third_posted_salary_no_of_hour=$payslip_state_3rd_cutoff->salary_no_of_hour;
        $third_posted_salary_month_days_no=$payslip_state_3rd_cutoff->salary_month_days_no;
        $third_posted_salary_year_days_no=$payslip_state_3rd_cutoff->salary_year_days_no;

        $third_posted_basic=$payslip_state_3rd_cutoff->basic;
        $third_posted_net_basic_formula=$payslip_state_3rd_cutoff->posted_net_basic_formula;

        $third_posted_overtime=$payslip_state_3rd_cutoff->overtime;
        $third_posted_ot_formula=$payslip_state_3rd_cutoff->posted_ot_formula;

        $third_posted_shift_night_diff=$payslip_state_3rd_cutoff->shift_night_diff;
        $third_posted_shift_night_diff_formula=$payslip_state_3rd_cutoff->posted_shift_night_diff_formula;

        $third_posted_cola=$payslip_state_3rd_cutoff->cola;
        $third_posted_cola_how_to=$payslip_state_3rd_cutoff->posted_cola_how_to;

        $third_posted_other_addition_taxable=$payslip_state_3rd_cutoff->other_addition_taxable;
        $third_posted_oa_taxable_how_to=$payslip_state_3rd_cutoff->posted_oa_taxable_how_to;
        $third_posted_other_addition_non_tax=$payslip_state_3rd_cutoff->other_addition_non_tax;
        $third_posted_oa_nontax_how_to=$payslip_state_3rd_cutoff->posted_oa_nontax_how_to;
        
        $third_posted_other_deduction_taxable=$payslip_state_3rd_cutoff->other_deduction_taxable;
        $third_posted_od_taxable_how_to=$payslip_state_3rd_cutoff->posted_od_taxable_how_to;
        $third_posted_other_deduction_nontax=$payslip_state_3rd_cutoff->other_deduction_nontax;
        $third_posted_od_nontax_how_to=$payslip_state_3rd_cutoff->posted_od_nontax_how_to;
        
        $third_posted_gross=$payslip_state_3rd_cutoff->gross;
        $third_posted_gross_formula=$payslip_state_3rd_cutoff->posted_gross_formula;
        
        $third_posted_loan=$payslip_state_3rd_cutoff->loan;
        $third_posted_loan_how_to=$payslip_state_3rd_cutoff->posted_loan_how_to;

        $third_posted_sss_employee=$payslip_state_3rd_cutoff->sss_employee;
        $third_posted_sss_employer=$payslip_state_3rd_cutoff->sss_employer;
        $third_posted_sss_employer_ec_er=$payslip_state_3rd_cutoff->sss_ec_er;
        $third_posted_sss_gross=$payslip_state_3rd_cutoff->sss_gross;
        $third_posted_sss_formula=$payslip_state_3rd_cutoff->posted_sss_formula;
        
        $third_posted_philhealth_employee=$payslip_state_3rd_cutoff->philhealth_employee;
        $third_posted_philhealth_employer=$payslip_state_3rd_cutoff->philhealth_employer;
        $third_posted_philhealth_gross=$payslip_state_3rd_cutoff->philhealth_gross;
        $third_posted_ph_formula=$payslip_state_3rd_cutoff->posted_ph_formula;

        $third_posted_pagibig=$payslip_state_3rd_cutoff->pagibig;
        $third_posted_pi_formula=$payslip_state_3rd_cutoff->posted_pi_formula;

        $third_posted_absent=$payslip_state_3rd_cutoff->absent;
        $third_posted_absent_formula=$payslip_state_3rd_cutoff->posted_absent_formula;

        $third_posted_late=$payslip_state_3rd_cutoff->late;
        $third_posted_late_formula=$payslip_state_3rd_cutoff->posted_late_formula;

        $third_posted_undertime=$payslip_state_3rd_cutoff->undertime;
        $third_posted_ut_formula=$payslip_state_3rd_cutoff->posted_ut_formula;

        $third_posted_overbreak=$payslip_state_3rd_cutoff->overbreak;
        $third_posted_overbreak_formula=$payslip_state_3rd_cutoff->posted_overbreak_formula;

        $third_posted_taxable=$payslip_state_3rd_cutoff->taxable;
        $third_posted_taxable_formula=$payslip_state_3rd_cutoff->posted_taxable_formula;

        $third_posted_wtax=$payslip_state_3rd_cutoff->wtax;
        $third_posted_wtax_formula=$payslip_state_3rd_cutoff->posted_wtax_formula;

        $third_posted_income_total=$payslip_state_3rd_cutoff->income_total;
        $third_posted_income_total_how_to=$payslip_state_3rd_cutoff->posted_income_total_how_to;

        $third_posted_deduction_total=$payslip_state_3rd_cutoff->deduction_total;
        $third_posted_deduction_total_how_to=$payslip_state_3rd_cutoff->posted_deduction_total_how_to;

        $third_posted_netpay=$payslip_state_3rd_cutoff->net_pay;
        $third_posted_net_pay_formula=$payslip_state_3rd_cutoff->posted_net_pay_formula;

        $third_posted_tax_deduction_type_name=$payslip_state_1st_cutoff->tax_deduction_type_name;
        $third_posted_assumed_taxable_monthly=$payslip_state_1st_cutoff->assumed_taxable_monthly;
        $third_posted_assumed_taxable_yearly=$payslip_state_1st_cutoff->assumed_taxable_yearly;
        $third_posted_assumed_tax_in_a_year=$payslip_state_1st_cutoff->assumed_tax_in_a_year;
        $third_posted_assumed_tax_in_a_month=$payslip_state_1st_cutoff->assumed_tax_in_a_month;
        $third_posted_assumed_tax_in_a_cutoff=$payslip_state_1st_cutoff->assumed_tax_in_a_cutoff;


    }else{

        $third_posted_tax_deduction_type_name="";
        $third_posted_assumed_taxable_monthly="";
        $third_posted_assumed_taxable_yearly="";
        $third_posted_assumed_tax_in_a_year="";
        $third_posted_assumed_tax_in_a_month="";
        $third_posted_assumed_tax_in_a_cutoff="";

        $third_cutoff_payslip_state="";

        $third_posted_pay_type=0;
        $third_posted_salary_rate=0;
        $third_posted_salary_amount=0;
        $third_posted_salary_no_of_hour=0;
        $third_posted_salary_month_days_no=0;
        $third_posted_salary_year_days_no=0;

        $third_posted_basic=0;
        $third_posted_net_basic_formula=0;

        $third_posted_overtime=0;
        $third_posted_ot_formula=0;

        $third_posted_shift_night_diff=0;
        $third_posted_shift_night_diff_formula=0;

        $third_posted_cola=0;
        $third_posted_cola_how_to=0;

        $third_posted_other_addition_taxable=0;
        $third_posted_oa_taxable_how_to=0;
        $third_posted_other_addition_non_tax=0;
        $third_posted_oa_nontax_how_to=0;
        
        $third_posted_other_deduction_taxable=0;
        $third_posted_od_taxable_how_to=0;
        $third_posted_other_deduction_nontax=0;
        $third_posted_od_nontax_how_to=0;
        
        $third_posted_gross=0;
        $third_posted_gross_formula=0;
        
        $third_posted_loan=0;
        $third_posted_loan_how_to=0;

        $third_posted_sss_employee=0;
        $third_posted_sss_employer=0;
        $third_posted_sss_employer_ec_er=0;
        $third_posted_sss_gross=0;
        $third_posted_sss_formula=0;
        
        $third_posted_philhealth_employee=0;
        $third_posted_philhealth_employer=0;
        $third_posted_philhealth_gross=0;
        $third_posted_ph_formula=0;

        $third_posted_pagibig=0;
        $third_posted_pi_formula=0;

        $third_posted_absent=0;
        $third_posted_absent_formula=0;

        $third_posted_late=0;
        $third_posted_late_formula=0;

        $third_posted_undertime=0;
        $third_posted_ut_formula=0;

        $third_posted_overbreak=0;
        $third_posted_overbreak_formula=0;

        $third_posted_taxable=0;
        $third_posted_taxable_formula=0;

        $third_posted_wtax=0;
        $third_posted_wtax_formula=0;

        $third_posted_income_total=0;
        $third_posted_income_total_how_to=0;

        $third_posted_netpay=0;
        $third_posted_net_pay_formula=0;

    }


    if(!empty($payslip_state_4th_cutoff)){

        $fourth_cutoff_payslip_state="posted";

        $fourth_posted_pay_type=$payslip_state_4th_cutoff->pay_type;
        $fourth_posted_salary_rate=$payslip_state_4th_cutoff->salary_rate;
        $fourth_posted_salary_amount=$payslip_state_4th_cutoff->salary_amount;
        $fourth_posted_salary_no_of_hour=$payslip_state_4th_cutoff->salary_no_of_hour;
        $fourth_posted_salary_month_days_no=$payslip_state_4th_cutoff->salary_month_days_no;
        $fourth_posted_salary_year_days_no=$payslip_state_4th_cutoff->salary_year_days_no;

        $fourth_posted_basic=$payslip_state_4th_cutoff->basic;
        $fourth_posted_net_basic_formula=$payslip_state_4th_cutoff->posted_net_basic_formula;

        $fourth_posted_overtime=$payslip_state_4th_cutoff->overtime;
        $fourth_posted_ot_formula=$payslip_state_4th_cutoff->posted_ot_formula;

        $fourth_posted_shift_night_diff=$payslip_state_4th_cutoff->shift_night_diff;
        $fourth_posted_shift_night_diff_formula=$payslip_state_4th_cutoff->posted_shift_night_diff_formula;

        $fourth_posted_cola=$payslip_state_4th_cutoff->cola;
        $fourth_posted_cola_how_to=$payslip_state_4th_cutoff->posted_cola_how_to;

        $fourth_posted_other_addition_taxable=$payslip_state_4th_cutoff->other_addition_taxable;
        $fourth_posted_oa_taxable_how_to=$payslip_state_4th_cutoff->posted_oa_taxable_how_to;
        $fourth_posted_other_addition_non_tax=$payslip_state_4th_cutoff->other_addition_non_tax;
        $fourth_posted_oa_nontax_how_to=$payslip_state_4th_cutoff->posted_oa_nontax_how_to;
        
        $fourth_posted_other_deduction_taxable=$payslip_state_4th_cutoff->other_deduction_taxable;
        $fourth_posted_od_taxable_how_to=$payslip_state_4th_cutoff->posted_od_taxable_how_to;
        $fourth_posted_other_deduction_nontax=$payslip_state_4th_cutoff->other_deduction_nontax;
        $fourth_posted_od_nontax_how_to=$payslip_state_4th_cutoff->posted_od_nontax_how_to;
        
        $fourth_posted_gross=$payslip_state_4th_cutoff->gross;
        $fourth_posted_gross_formula=$payslip_state_4th_cutoff->posted_gross_formula;
        
        $fourth_posted_loan=$payslip_state_4th_cutoff->loan;
        $fourth_posted_loan_how_to=$payslip_state_4th_cutoff->posted_loan_how_to;

        $fourth_posted_sss_employee=$payslip_state_4th_cutoff->sss_employee;
        $fourth_posted_sss_employer=$payslip_state_4th_cutoff->sss_employer;
        $fourth_posted_sss_employer_ec_er=$payslip_state_4th_cutoff->sss_ec_er;
        $fourth_posted_sss_gross=$payslip_state_4th_cutoff->sss_gross;
        $fourth_posted_sss_formula=$payslip_state_4th_cutoff->posted_sss_formula;
        
        $fourth_posted_philhealth_employee=$payslip_state_4th_cutoff->philhealth_employee;
        $fourth_posted_philhealth_employer=$payslip_state_4th_cutoff->philhealth_employer;
        $fourth_posted_philhealth_gross=$payslip_state_4th_cutoff->philhealth_gross;
        $fourth_posted_ph_formula=$payslip_state_4th_cutoff->posted_ph_formula;

        $fourth_posted_pagibig=$payslip_state_4th_cutoff->pagibig;
        $fourth_posted_pi_formula=$payslip_state_4th_cutoff->posted_pi_formula;

        $fourth_posted_absent=$payslip_state_4th_cutoff->absent;
        $fourth_posted_absent_formula=$payslip_state_4th_cutoff->posted_absent_formula;

        $fourth_posted_late=$payslip_state_4th_cutoff->late;
        $fourth_posted_late_formula=$payslip_state_4th_cutoff->posted_late_formula;

        $fourth_posted_undertime=$payslip_state_4th_cutoff->undertime;
        $fourth_posted_ut_formula=$payslip_state_4th_cutoff->posted_ut_formula;

        $fourth_posted_overbreak=$payslip_state_4th_cutoff->overbreak;
        $fourth_posted_overbreak_formula=$payslip_state_4th_cutoff->posted_overbreak_formula;

        $fourth_posted_taxable=$payslip_state_4th_cutoff->taxable;
        $fourth_posted_taxable_formula=$payslip_state_4th_cutoff->posted_taxable_formula;

        $fourth_posted_wtax=$payslip_state_4th_cutoff->wtax;
        $fourth_posted_wtax_formula=$payslip_state_4th_cutoff->posted_wtax_formula;

        $fourth_posted_income_total=$payslip_state_4th_cutoff->income_total;
        $fourth_posted_income_total_how_to=$payslip_state_4th_cutoff->posted_income_total_how_to;

        $fourth_posted_deduction_total=$payslip_state_4th_cutoff->deduction_total;
        $fourth_posted_deduction_total_how_to=$payslip_state_4th_cutoff->posted_deduction_total_how_to;

        $fourth_posted_netpay=$payslip_state_4th_cutoff->net_pay;
        $fourth_posted_net_pay_formula=$payslip_state_4th_cutoff->posted_net_pay_formula;

        $fourth_posted_tax_deduction_type_name=$payslip_state_1st_cutoff->tax_deduction_type_name;
        $fourth_posted_assumed_taxable_monthly=$payslip_state_1st_cutoff->assumed_taxable_monthly;
        $fourth_posted_assumed_taxable_yearly=$payslip_state_1st_cutoff->assumed_taxable_yearly;
        $fourth_posted_assumed_tax_in_a_year=$payslip_state_1st_cutoff->assumed_tax_in_a_year;
        $fourth_posted_assumed_tax_in_a_month=$payslip_state_1st_cutoff->assumed_tax_in_a_month;
        $fourth_posted_assumed_tax_in_a_cutoff=$payslip_state_1st_cutoff->assumed_tax_in_a_cutoff;


    }else{

        $fourth_posted_tax_deduction_type_name="";
        $fourth_posted_assumed_taxable_monthly="";
        $fourth_posted_assumed_taxable_yearly="";
        $fourth_posted_assumed_tax_in_a_year="";
        $fourth_posted_assumed_tax_in_a_month="";
        $fourth_posted_assumed_tax_in_a_cutoff="";

        $fourth_cutoff_payslip_state="";

        $fourth_posted_pay_type=0;
        $fourth_posted_salary_rate=0;
        $fourth_posted_salary_amount=0;
        $fourth_posted_salary_no_of_hour=0;
        $fourth_posted_salary_month_days_no=0;
        $fourth_posted_salary_year_days_no=0;

        $fourth_posted_basic=0;
        $fourth_posted_net_basic_formula=0;

        $fourth_posted_overtime=0;
        $fourth_posted_ot_formula=0;

        $fourth_posted_shift_night_diff=0;
        $fourth_posted_shift_night_diff_formula=0;

        $fourth_posted_cola=0;
        $fourth_posted_cola_how_to=0;

        $fourth_posted_other_addition_taxable=0;
        $fourth_posted_oa_taxable_how_to=0;
        $fourth_posted_other_addition_non_tax=0;
        $fourth_posted_oa_nontax_how_to=0;
        
        $fourth_posted_other_deduction_taxable=0;
        $fourth_posted_od_taxable_how_to=0;
        $fourth_posted_other_deduction_nontax=0;
        $fourth_posted_od_nontax_how_to=0;
        
        $fourth_posted_gross=0;
        $fourth_posted_gross_formula=0;
        
        $fourth_posted_loan=0;
        $fourth_posted_loan_how_to=0;

        $fourth_posted_sss_employee=0;
        $fourth_posted_sss_employer=0;
        $fourth_posted_sss_employer_ec_er=0;
        $fourth_posted_sss_gross=0;
        $fourth_posted_sss_formula=0;
        
        $fourth_posted_philhealth_employee=0;
        $fourth_posted_philhealth_employer=0;
        $fourth_posted_philhealth_gross=0;
        $fourth_posted_ph_formula=0;

        $fourth_posted_pagibig=0;
        $fourth_posted_pi_formula=0;

        $fourth_posted_absent=0;
        $fourth_posted_absent_formula=0;

        $fourth_posted_late=0;
        $fourth_posted_late_formula=0;

        $fourth_posted_undertime=0;
        $fourth_posted_ut_formula=0;

        $fourth_posted_overbreak=0;
        $fourth_posted_overbreak_formula=0;

        $fourth_posted_taxable=0;
        $fourth_posted_taxable_formula=0;

        $fourth_posted_wtax=0;
        $fourth_posted_wtax_formula=0;

        $fourth_posted_income_total=0;
        $fourth_posted_income_total_how_to=0;

        $fourth_posted_netpay=0;
        $fourth_posted_net_pay_formula=0;

    }

    if(!empty($payslip_state_5th_cutoff)){

        $fifth_cutoff_payslip_state="posted";

        $fifth_posted_pay_type=$payslip_state_5th_cutoff->pay_type;
        $fifth_posted_salary_rate=$payslip_state_5th_cutoff->salary_rate;
        $fifth_posted_salary_amount=$payslip_state_5th_cutoff->salary_amount;
        $fifth_posted_salary_no_of_hour=$payslip_state_5th_cutoff->salary_no_of_hour;
        $fifth_posted_salary_month_days_no=$payslip_state_5th_cutoff->salary_month_days_no;
        $fifth_posted_salary_year_days_no=$payslip_state_5th_cutoff->salary_year_days_no;

        $fifth_posted_basic=$payslip_state_5th_cutoff->basic;
        $fifth_posted_net_basic_formula=$payslip_state_5th_cutoff->posted_net_basic_formula;

        $fifth_posted_overtime=$payslip_state_5th_cutoff->overtime;
        $fifth_posted_ot_formula=$payslip_state_5th_cutoff->posted_ot_formula;

        $fifth_posted_shift_night_diff=$payslip_state_5th_cutoff->shift_night_diff;
        $fifth_posted_shift_night_diff_formula=$payslip_state_5th_cutoff->posted_shift_night_diff_formula;

        $fifth_posted_cola=$payslip_state_5th_cutoff->cola;
        $fifth_posted_cola_how_to=$payslip_state_5th_cutoff->posted_cola_how_to;

        $fifth_posted_other_addition_taxable=$payslip_state_5th_cutoff->other_addition_taxable;
        $fifth_posted_oa_taxable_how_to=$payslip_state_5th_cutoff->posted_oa_taxable_how_to;
        $fifth_posted_other_addition_non_tax=$payslip_state_5th_cutoff->other_addition_non_tax;
        $fifth_posted_oa_nontax_how_to=$payslip_state_5th_cutoff->posted_oa_nontax_how_to;
        
        $fifth_posted_other_deduction_taxable=$payslip_state_5th_cutoff->other_deduction_taxable;
        $fifth_posted_od_taxable_how_to=$payslip_state_5th_cutoff->posted_od_taxable_how_to;
        $fifth_posted_other_deduction_nontax=$payslip_state_5th_cutoff->other_deduction_nontax;
        $fifth_posted_od_nontax_how_to=$payslip_state_5th_cutoff->posted_od_nontax_how_to;
        
        $fifth_posted_gross=$payslip_state_5th_cutoff->gross;
        $fifth_posted_gross_formula=$payslip_state_5th_cutoff->posted_gross_formula;
        
        $fifth_posted_loan=$payslip_state_5th_cutoff->loan;
        $fifth_posted_loan_how_to=$payslip_state_5th_cutoff->posted_loan_how_to;

        $fifth_posted_sss_employee=$payslip_state_5th_cutoff->sss_employee;
        $fifth_posted_sss_employer=$payslip_state_5th_cutoff->sss_employer;
        $fifth_posted_sss_employer_ec_er=$payslip_state_5th_cutoff->sss_ec_er;
        $fifth_posted_sss_gross=$payslip_state_5th_cutoff->sss_gross;
        $fifth_posted_sss_formula=$payslip_state_5th_cutoff->posted_sss_formula;
        
        $fifth_posted_philhealth_employee=$payslip_state_5th_cutoff->philhealth_employee;
        $fifth_posted_philhealth_employer=$payslip_state_5th_cutoff->philhealth_employer;
        $fifth_posted_philhealth_gross=$payslip_state_5th_cutoff->philhealth_gross;
        $fifth_posted_ph_formula=$payslip_state_5th_cutoff->posted_ph_formula;

        $fifth_posted_pagibig=$payslip_state_5th_cutoff->pagibig;
        $fifth_posted_pi_formula=$payslip_state_5th_cutoff->posted_pi_formula;

        $fifth_posted_absent=$payslip_state_5th_cutoff->absent;
        $fifth_posted_absent_formula=$payslip_state_5th_cutoff->posted_absent_formula;

        $fifth_posted_late=$payslip_state_5th_cutoff->late;
        $fifth_posted_late_formula=$payslip_state_5th_cutoff->posted_late_formula;

        $fifth_posted_undertime=$payslip_state_5th_cutoff->undertime;
        $fifth_posted_ut_formula=$payslip_state_5th_cutoff->posted_ut_formula;

        $fifth_posted_overbreak=$payslip_state_5th_cutoff->overbreak;
        $fifth_posted_overbreak_formula=$payslip_state_5th_cutoff->posted_overbreak_formula;

        $fifth_posted_taxable=$payslip_state_5th_cutoff->taxable;
        $fifth_posted_taxable_formula=$payslip_state_5th_cutoff->posted_taxable_formula;

        $fifth_posted_wtax=$payslip_state_5th_cutoff->wtax;
        $fifth_posted_wtax_formula=$payslip_state_5th_cutoff->posted_wtax_formula;

        $fifth_posted_income_total=$payslip_state_5th_cutoff->income_total;
        $fifth_posted_income_total_how_to=$payslip_state_5th_cutoff->posted_income_total_how_to;

        $fifth_posted_deduction_total=$payslip_state_5th_cutoff->deduction_total;
        $fifth_posted_deduction_total_how_to=$payslip_state_5th_cutoff->posted_deduction_total_how_to;

        $fifth_posted_netpay=$payslip_state_5th_cutoff->net_pay;
        $fifth_posted_net_pay_formula=$payslip_state_5th_cutoff->posted_net_pay_formula;

        $fifth_posted_tax_deduction_type_name=$payslip_state_1st_cutoff->tax_deduction_type_name;
        $fifth_posted_assumed_taxable_monthly=$payslip_state_1st_cutoff->assumed_taxable_monthly;
        $fifth_posted_assumed_taxable_yearly=$payslip_state_1st_cutoff->assumed_taxable_yearly;
        $fifth_posted_assumed_tax_in_a_year=$payslip_state_1st_cutoff->assumed_tax_in_a_year;
        $fifth_posted_assumed_tax_in_a_month=$payslip_state_1st_cutoff->assumed_tax_in_a_month;
        $fifth_posted_assumed_tax_in_a_cutoff=$payslip_state_1st_cutoff->assumed_tax_in_a_cutoff;


    }else{

        $fifth_posted_tax_deduction_type_name="";
        $fifth_posted_assumed_taxable_monthly="";
        $fifth_posted_assumed_taxable_yearly="";
        $fifth_posted_assumed_tax_in_a_year="";
        $fifth_posted_assumed_tax_in_a_month="";
        $fifth_posted_assumed_tax_in_a_cutoff="";

        $fifth_cutoff_payslip_state="";

        $fifth_posted_pay_type=0;
        $fifth_posted_salary_rate=0;
        $fifth_posted_salary_amount=0;
        $fifth_posted_salary_no_of_hour=0;
        $fifth_posted_salary_month_days_no=0;
        $fifth_posted_salary_year_days_no=0;

        $fifth_posted_basic=0;
        $fifth_posted_net_basic_formula=0;

        $fifth_posted_overtime=0;
        $fifth_posted_ot_formula=0;

        $fifth_posted_shift_night_diff=0;
        $fifth_posted_shift_night_diff_formula=0;

        $fifth_posted_cola=0;
        $fifth_posted_cola_how_to=0;

        $fifth_posted_other_addition_taxable=0;
        $fifth_posted_oa_taxable_how_to=0;
        $fifth_posted_other_addition_non_tax=0;
        $fifth_posted_oa_nontax_how_to=0;
        
        $fifth_posted_other_deduction_taxable=0;
        $fifth_posted_od_taxable_how_to=0;
        $fifth_posted_other_deduction_nontax=0;
        $fifth_posted_od_nontax_how_to=0;
        
        $fifth_posted_gross=0;
        $fifth_posted_gross_formula=0;
        
        $fifth_posted_loan=0;
        $fifth_posted_loan_how_to=0;

        $fifth_posted_sss_employee=0;
        $fifth_posted_sss_employer=0;
        $fifth_posted_sss_employer_ec_er=0;
        $fifth_posted_sss_gross=0;
        $fifth_posted_sss_formula=0;
        
        $fifth_posted_philhealth_employee=0;
        $fifth_posted_philhealth_employer=0;
        $fifth_posted_philhealth_gross=0;
        $fifth_posted_ph_formula=0;

        $fifth_posted_pagibig=0;
        $fifth_posted_pi_formula=0;

        $fifth_posted_absent=0;
        $fifth_posted_absent_formula=0;

        $fifth_posted_late=0;
        $fifth_posted_late_formula=0;

        $fifth_posted_undertime=0;
        $fifth_posted_ut_formula=0;

        $fifth_posted_overbreak=0;
        $fifth_posted_overbreak_formula=0;

        $fifth_posted_taxable=0;
        $fifth_posted_taxable_formula=0;

        $fifth_posted_wtax=0;
        $fifth_posted_wtax_formula=0;

        $fifth_posted_income_total=0;
        $fifth_posted_income_total_how_to=0;

        $fifth_posted_netpay=0;
        $fifth_posted_net_pay_formula=0;

    }


    
}else{

}



}elseif($pay_type=="4"){

$check_payroll_period_id=$pay_period;

$payslip_state_1st_cutoff=$this->payroll_generate_payslip_model->check_payslip_status($check_payroll_period_id,$company_id,$employee_id,$month_cover);

if(!empty($payslip_state_1st_cutoff)){


        $first_cutoff_payslip_state="posted";

        $first_posted_pay_type=$payslip_state_1st_cutoff->pay_type;
        $first_posted_salary_rate=$payslip_state_1st_cutoff->salary_rate;
        $first_posted_salary_amount=$payslip_state_1st_cutoff->salary_amount;
        $first_posted_salary_no_of_hour=$payslip_state_1st_cutoff->salary_no_of_hour;
        $first_posted_salary_month_days_no=$payslip_state_1st_cutoff->salary_month_days_no;
        $first_posted_salary_year_days_no=$payslip_state_1st_cutoff->salary_year_days_no;

        $first_posted_basic=$payslip_state_1st_cutoff->basic;
        $first_posted_net_basic_formula=$payslip_state_1st_cutoff->posted_net_basic_formula;

        $first_posted_overtime=$payslip_state_1st_cutoff->overtime;
        $first_posted_ot_formula=$payslip_state_1st_cutoff->posted_ot_formula;

        $first_posted_shift_night_diff=$payslip_state_1st_cutoff->shift_night_diff;
        $first_posted_shift_night_diff_formula=$payslip_state_1st_cutoff->posted_shift_night_diff_formula;

        $first_posted_cola=$payslip_state_1st_cutoff->cola;
        $first_posted_cola_how_to=$payslip_state_1st_cutoff->posted_cola_how_to;

        $first_posted_other_addition_taxable=$payslip_state_1st_cutoff->other_addition_taxable;
        $first_posted_oa_taxable_how_to=$payslip_state_1st_cutoff->posted_oa_taxable_how_to;
        $first_posted_other_addition_non_tax=$payslip_state_1st_cutoff->other_addition_non_tax;
        $first_posted_oa_nontax_how_to=$payslip_state_1st_cutoff->posted_oa_nontax_how_to;
        
        $first_posted_other_deduction_taxable=$payslip_state_1st_cutoff->other_deduction_taxable;
        $first_posted_od_taxable_how_to=$payslip_state_1st_cutoff->posted_od_taxable_how_to;
        $first_posted_other_deduction_nontax=$payslip_state_1st_cutoff->other_deduction_nontax;
        $first_posted_od_nontax_how_to=$payslip_state_1st_cutoff->posted_od_nontax_how_to;
        
        $first_posted_gross=$payslip_state_1st_cutoff->gross;
        $first_posted_gross_formula=$payslip_state_1st_cutoff->posted_gross_formula;
        
        $first_posted_loan=$payslip_state_1st_cutoff->loan;
        $first_posted_loan_how_to=$payslip_state_1st_cutoff->posted_loan_how_to;

        $first_posted_sss_employee=$payslip_state_1st_cutoff->sss_employee;
        $first_posted_sss_employer=$payslip_state_1st_cutoff->sss_employer;
        $first_posted_sss_employer_ec_er=$payslip_state_1st_cutoff->sss_ec_er;
        $first_posted_sss_gross=$payslip_state_1st_cutoff->sss_gross;
        $first_posted_sss_formula=$payslip_state_1st_cutoff->posted_sss_formula;
        
        $first_posted_philhealth_employee=$payslip_state_1st_cutoff->philhealth_employee;
        $first_posted_philhealth_employer=$payslip_state_1st_cutoff->philhealth_employer;
        $first_posted_philhealth_gross=$payslip_state_1st_cutoff->philhealth_gross;
        $first_posted_ph_formula=$payslip_state_1st_cutoff->posted_ph_formula;

        $first_posted_pagibig=$payslip_state_1st_cutoff->pagibig;
        $first_posted_pi_formula=$payslip_state_1st_cutoff->posted_pi_formula;

        $first_posted_absent=$payslip_state_1st_cutoff->absent;
        $first_posted_absent_formula=$payslip_state_1st_cutoff->posted_absent_formula;

        $first_posted_late=$payslip_state_1st_cutoff->late;
        $first_posted_late_formula=$payslip_state_1st_cutoff->posted_late_formula;

        $first_posted_undertime=$payslip_state_1st_cutoff->undertime;
        $first_posted_ut_formula=$payslip_state_1st_cutoff->posted_ut_formula;

        $first_posted_overbreak=$payslip_state_1st_cutoff->overbreak;
        $first_posted_overbreak_formula=$payslip_state_1st_cutoff->posted_overbreak_formula;

        $first_posted_taxable=$payslip_state_1st_cutoff->taxable;
        $first_posted_taxable_formula=$payslip_state_1st_cutoff->posted_taxable_formula;

        $first_posted_wtax=$payslip_state_1st_cutoff->wtax;
        $first_posted_wtax_formula=$payslip_state_1st_cutoff->posted_wtax_formula;

        $first_posted_income_total=$payslip_state_1st_cutoff->income_total;
        $first_posted_income_total_how_to=$payslip_state_1st_cutoff->posted_income_total_how_to;

        $first_posted_deduction_total=$payslip_state_1st_cutoff->deduction_total;
        $first_posted_deduction_total_how_to=$payslip_state_1st_cutoff->posted_deduction_total_how_to;

        $first_posted_netpay=$payslip_state_1st_cutoff->net_pay;
        $first_posted_net_pay_formula=$payslip_state_1st_cutoff->posted_net_pay_formula;

        $first_posted_tax_deduction_type_name=$payslip_state_1st_cutoff->tax_deduction_type_name;
        $first_posted_assumed_taxable_monthly=$payslip_state_1st_cutoff->assumed_taxable_monthly;
        $first_posted_assumed_taxable_yearly=$payslip_state_1st_cutoff->assumed_taxable_yearly;
        $first_posted_assumed_tax_in_a_year=$payslip_state_1st_cutoff->assumed_tax_in_a_year;
        $first_posted_assumed_tax_in_a_month=$payslip_state_1st_cutoff->assumed_tax_in_a_month;
        $first_posted_assumed_tax_in_a_cutoff=$payslip_state_1st_cutoff->assumed_tax_in_a_cutoff;
        $first_posted_ytd_taxable=$payslip_state_1st_cutoff->ytd_taxable;
        $first_posted_ytd_wtax=$payslip_state_1st_cutoff->ytd_wtax;

}else{
      $first_posted_ytd_wtax="";

        $first_posted_tax_deduction_type_name="";
        $first_posted_assumed_taxable_monthly="";
        $first_posted_assumed_taxable_yearly="";
        $first_posted_assumed_tax_in_a_year="";
        $first_posted_assumed_tax_in_a_month="";
        $first_posted_assumed_tax_in_a_cutoff="";

        $first_cutoff_payslip_state="";

        $first_posted_pay_type=0;
        $first_posted_salary_rate=0;
        $first_posted_salary_amount=0;
        $first_posted_salary_no_of_hour=0;
        $first_posted_salary_month_days_no=0;
        $first_posted_salary_year_days_no=0;

        $first_posted_basic=0;
        $first_posted_net_basic_formula=0;

        $first_posted_overtime=0;
        $first_posted_ot_formula=0;

        $first_posted_shift_night_diff=0;
        $first_posted_shift_night_diff_formula=0;

        $first_posted_cola=0;
        $first_posted_cola_how_to=0;

        $first_posted_other_addition_taxable=0;
        $first_posted_oa_taxable_how_to=0;
        $first_posted_other_addition_non_tax=0;
        $first_posted_oa_nontax_how_to=0;
        
        $first_posted_other_deduction_taxable=0;
        $first_posted_od_taxable_how_to=0;
        $first_posted_other_deduction_nontax=0;
        $first_posted_od_nontax_how_to=0;
        
        $first_posted_gross=0;
        $first_posted_gross_formula=0;
        
        $first_posted_loan=0;
        $first_posted_loan_how_to=0;

        $first_posted_sss_employee=0;
        $first_posted_sss_employer=0;
        $first_posted_sss_employer_ec_er=0;
        $first_posted_sss_gross=0;
        $first_posted_sss_formula=0;
        
        $first_posted_philhealth_employee=0;
        $first_posted_philhealth_employer=0;
        $first_posted_philhealth_gross=0;
        $first_posted_ph_formula=0;

        $first_posted_pagibig=0;
        $first_posted_pi_formula=0;

        $first_posted_absent=0;
        $first_posted_absent_formula=0;

        $first_posted_late=0;
        $first_posted_late_formula=0;

        $first_posted_undertime=0;
        $first_posted_ut_formula=0;

        $first_posted_overbreak=0;
        $first_posted_overbreak_formula=0;

        $first_posted_taxable=0;
        $first_posted_taxable_formula=0;

        $first_posted_wtax=0;
        $first_posted_wtax_formula=0;


        $first_posted_income_total=0;
        $first_posted_income_total_how_to=0;

        $first_posted_deduction_total=0;
        $first_posted_deduction_total_how_to=0;


        $first_posted_netpay=0;
        $first_posted_net_pay_formula=0;
}



    

}else{

}





//============================================GET FOR AUTOMATIC ADJUSTMENT
/*
----------------
leave
----------------
*/
$adjustment_type="leave_adjustment";
$auto_adjustment=$this->payroll_generate_payslip_model->check_for_automatic_adjustment($employee_id,$pay_period,$adjustment_type);
if(!empty($auto_adjustment)){
    $auto_adj_leave=$auto_adjustment->$adjustment_type;
}else{
    $auto_adj_leave=0;
}


//============================================GET PAY TYPE
if($processeddtr_pay_type){
    $active_pay_type=$processeddtr_pay_type;
}else{
    $active_pay_type=$pay_type;
}

//============================================CHECK PAYROLL FORMULA/SETTINGS
require(APPPATH.'views/app/payroll/payslip/check_payroll_settings.php');

//============================================ CHECK COMPANY DIVISION SETTING============================================
if($wDivision=="1"){

$getmydivision=$this->payroll_generate_payslip_model->getDivision($emp->division_id);
    $mydivision=$getmydivision->division_name;
    $division_status='<th>Division</th>
            <th>'.$mydivision.'</th>';              
}else{
    $mydivision="";
        $division_status='<th>&nbsp;</th>
            <th>&nbsp;</th>';
}

//============================================ CHECK SECTION- SUBSECTION SETTING============================================
if($wSubsection=="1"){

    $getmysubsection=$this->payroll_generate_payslip_model->getSubsection($emp->section);
    $mysubsection=$getmysubsection->subsection_name;
    $subsection_status='<th>Sub-Section</th>
            <th>'.$mysubsection.'</th>';                
}else{
    $mysubsection="";
    $subsection_status='<th>&nbsp;</th>
            <th>&nbsp;</th>';
}

    $count_employees++; // count employees
?>
<div class="datagrid">
<?php


if($selected_payroll_option=="print_payslip"){//=========== PRINT PAYSLIP HEADER
 
?>
    <table  cellpadding="1" cellspacing="3">
        <thead>
            <tr>      
            <th><img src="<?php echo base_url();?>/public/company_logo/<?php echo $company_logo;?>" class="img-rounded" id="company_logo" width="50" height="50"><?php echo $company_name;?>
            <span style="float: right;"><?php echo $pay_period_from." to ".$pay_period_to;?> <br><br> <?php echo $employee_id." ".$name;?></span>
            </th>
                
            </tr>
        </thead>
    </table>
    
<?php
}else{//=========== VIEW-POST PAYSLIP HEADER
?>
<table  cellpadding="1" cellspacing="3">
    <thead>
        <tr>
            <th><a href="#">count <span class="badge"><?php echo $count_employees; // count employees?></span></a> </th>        
            <th width="25%">Salary Rate: <?php echo $mysalaryrate_name; // get salary rate?></th>
        </tr>
    </thead>
</table>
<?php
}
?>

</div>
<div class="datagrid">
<?php
if($selected_payroll_option=="print_payslip"){//=========== PRINT PAYSLIP HEADER
$get_customized_headers=$this->payroll_generate_payslip_model->payslip_customized_headers($company_id);


if(!empty($get_customized_headers)){

        echo 
        '<table  cellpadding="1" cellspacing="3">
        <thead>
        <tr><th><span style="float: right;">';

    foreach($get_customized_headers as $my_payslip_header){
        $head_id=$my_payslip_header->id;
        if($head_id==13){
            $head_title="Classification";
            $head_value=$classification;
        }elseif($head_id==14){
            $head_title="Employment";
            $head_value=$employment;
        }elseif($head_id==15){
            $head_title="Department";
            $head_value=$dept;
        }elseif($head_id==16){
            $head_title="Section";
            $head_value=$section;
        }elseif($head_id==18){
            $head_title="Location";
            $head_value=$location;
        }elseif($head_id==19){
            $head_title="Position";
            $head_value=$position;
        }else{
            $head_title="Others";
            $head_value="Others";
        }
        echo ''.$head_title.' : '.$head_value.'<br><br>';
    }

        echo 
        '</span>    </th></tr>
        </thead>
        </table>';
}else{

}


?>

                     
     

<?php
}else{//=========== VIEW-POST PAYSLIP HEADER
?>
<table  cellpadding="1" cellspacing="3">
    <thead>
            <th>Payroll Period</th>
            <th><?php echo $pay_period_from." to ".$pay_period_to;?></th>
            <?php echo $division_status;?>
            <th>Employment</th>
            <th><?php echo $employment;?></th>
        </tr>
        <tr>
            <th>Employee ID</th>
            <th><?php echo $employee_id;?></th>
            <th>Department</th>
            <th><?php echo $dept;?></th>
            <th>Classification</th>
            <th><?php echo $classification;?></th>

        </tr>
        <tr>
            <th>Name</th>
            <th><?php echo $name;?></th>
            <th>Section</th>
            <th><?php echo $section;?></th>
            <th>Pay Type</th>
            <th><?php echo $pay_type_name;?></th>
        </tr>
        <tr>
            <th>Position</th>
            <th><?php echo $position;?></th>
            <?php echo $subsection_status;?>
            <th>Location</th>
            <th><?php echo $location;?></th>
        </tr>
    </thead>
</table>
<?php
}
?>




</div>
<div class="datagrid">
<table  cellpadding="1" cellspacing="3" border="1">
    <thead>
    <tr>
        <th></th>
        <?php
if($selected_payroll_option=="print_payslip"){
 echo ' <th colspan="2" class="payroll_center">';
}else{
 echo ' <th colspan="2" class="payroll_center">Amount';   
}
        ?>
       
<table>
<thead >
        <tr >
<?php
if($selected_payroll_option=="print_payslip"){

}else{


    if($active_pay_type=="1"){// weekly
    echo '  <th  class="payroll_center" > 1ST</th>
            <th  class="payroll_center" > 2ND</th>
            <th  class="payroll_center" > 3RD</th>
            <th  class="payroll_center">  4TH</th>
            <th  class="payroll_center" > 5TH</th>';
    }elseif($active_pay_type=="2"){// bi-weekly
    echo '  <th  class="payroll_center"> 1ST</th>
            <th  class="payroll_center"> 2ND</th>';
    }elseif($active_pay_type=="3"){// semi monthly
    echo '  <th  class="payroll_center"> 1ST</th>
            <th  class="payroll_center"> 2ND</th>';
    }elseif($active_pay_type=="4"){// monthly
    echo '  <th  class="payroll_center"> 1ST</th>';
    }else{// not recognize

    }

}



if(($is_salary_fixed=="0" OR $is_salary_fixed=="no")AND($is_with_processed_dtr=="yes")){
           $show_generate_payslip_details="yes"; 

}elseif(($is_salary_fixed=="0" OR $is_salary_fixed=="no")AND($is_with_processed_dtr=="none")){
            $show_generate_payslip_details="no"; 

}elseif(($is_salary_fixed=="1" OR $is_salary_fixed=="yes")AND($is_with_processed_dtr=="none")){
            $show_generate_payslip_details="yes"; 

}elseif(($is_salary_fixed=="1" OR $is_salary_fixed=="yes")AND($is_with_processed_dtr=="yes")){
            $show_generate_payslip_details="yes"; 

}else{
            $show_generate_payslip_details="no";

}


?>
    </tr>
</thead>
</table>
        </th>
        <?php
if($selected_payroll_option=="print_payslip"){

}else{
    echo '<th>Formula/System Computation</th>';
}
        ?>
        
    </tr>
    </thead>
<?php


$sss_contribution=0;
$philhealth_contribution=0;

//===========================================================o.a. old loc
//=========================================================== GENERAL COMPUTATION : WILL BASE ON SYSTEM SETUP
if($official_salary_state==""){
//if(($official_salary_state=="")AND($retro_salary_state=="")){

}else{

    if($show_generate_payslip_details=="yes"){

        
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: LOANS
            require(APPPATH.'views/app/payroll/payslip/compute_loan.php');            

    }else{
        
    }
}



//=========================================================== NO SALARY YET
if($official_salary_state==""){//AND($retro_salary_state=="")
//echo '  <th colspan="4" class="payroll_center warning_payroll_status" > NO COMPENSATION SETUP YET </th>';

    echo "
    <tr>
    <td colspan='6'><i class='fa fa-close text-danger' style='font-size:48px;'></i>No Compensation Setup.

    <i class='fa fa-quote-left text-info' style='font-size:20px;'></i>
    <span class='system_auto_guide'>go to payroll > compensation > salary management</span>
    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>

    </td>
    </tr>

        ";


//=========================================================== PAY TYPE : WEEKLY
}elseif(($active_pay_type=="1") AND ($show_generate_payslip_details=="yes")){

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: Weekly payslip details
            require(APPPATH.'views/app/payroll/payslip/weekly_payslip.php');   

//=========================================================== PAY TYPE : BI-WEEKLY OR SEMI MONTHLY
}elseif(($active_pay_type=="2" OR $active_pay_type=="3" OR $active_pay_type=="4") AND ($show_generate_payslip_details=="yes")){

//=========================================================== START FIXED SALARY
    if($is_salary_fixed=="1"){

            if($cut_off=="1"){
                $net_basic_value=$mysalary_amount/2;
                $mysalary_no_of_days_monthly=$mysalary_no_of_days_monthly/2;
                $daily_rate=$net_basic_value/$mysalary_no_of_days_monthly;
                $daily_formula="DAILY RATE ($daily_rate)= $net_basic_value/$mysalary_no_of_days_monthly";
                $hourly_value=$daily_rate/$mysalary_no_of_hours;

                    if($round_off_payslip=="yes"){// round off
                        $net_basic_value=round($net_basic_value, $payslip_decimal_place);
                        $daily_rate=round($daily_rate, $compensation_initial_decimal_place);
                        $hourly_value=round($hourly_value, $payslip_decimal_place);
                    }else{
                        $net_basic_value=bcdiv($net_basic_value, 1, $payslip_decimal_place); 
                        $daily_rate=bcdiv($daily_rate, 1, $payslip_decimal_place); 
                        $hourly_value=bcdiv($hourly_value, 1, $payslip_decimal_place); 
                    }   
                $leave_basic_equivalent=$leave_reg_hrs*$daily_rate;

                $hourly_formula_text="HOURLY RATE ($hourly_value)= $daily_rate/$mysalary_no_of_hours";
                $basic_formula_text="Fixed Salary. ( Monthly Rate / 2 ) <br> $mysalary_amount/2";
                $three_1st='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';
                $three_2nd="";

            }else{

                $net_basic_value=$mysalary_amount/2;
                $mysalary_no_of_days_monthly=$mysalary_no_of_days_monthly/2;
                $daily_rate=$net_basic_value/$mysalary_no_of_days_monthly;
                $daily_formula="DAILY RATE ($daily_rate)= $net_basic_value/$mysalary_no_of_days_monthly";
                $hourly_value=$daily_rate/$mysalary_no_of_hours;

                    if($round_off_payslip=="yes"){// round off
                        $net_basic_value=round($net_basic_value, $payslip_decimal_place);
                        $daily_rate=round($daily_rate, $compensation_initial_decimal_place);
                        $hourly_value=round($hourly_value, $payslip_decimal_place);
                    }else{
                        $net_basic_value=bcdiv($net_basic_value, 1, $payslip_decimal_place); 
                        $daily_rate=bcdiv($daily_rate, 1, $payslip_decimal_place); 
                        $hourly_value=bcdiv($hourly_value, 1, $payslip_decimal_place); 
                    }   
                $leave_basic_equivalent=$leave_reg_hrs*$daily_rate;

                $hourly_formula_text="HOURLY RATE ($hourly_value)= $daily_rate/$mysalary_no_of_hours";
                $basic_formula_text="Fixed Salary. ( Monthly Rate / 2 ) <br> $mysalary_amount/2";                
                $three_1st="";
                $three_2nd='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';


            }

            if($active_pay_type=="4"){//monthly pay type
                $net_basic_value=$mysalary_amount;
                $mysalary_no_of_days_monthly=$mysalary_no_of_days_monthly*2;
                $daily_rate=$net_basic_value/$mysalary_no_of_days_monthly;
                $daily_formula="DAILY RATE ($daily_rate)= $net_basic_value/$mysalary_no_of_days_monthly";
                $hourly_value=$daily_rate/$mysalary_no_of_hours;

                    if($round_off_payslip=="yes"){// round off
                        $net_basic_value=round($net_basic_value, $payslip_decimal_place);
                        $daily_rate=round($daily_rate, $compensation_initial_decimal_place);
                        $hourly_value=round($hourly_value, $payslip_decimal_place);
                    }else{
                        $net_basic_value=bcdiv($net_basic_value, 1, $payslip_decimal_place); 
                        $daily_rate=bcdiv($daily_rate, 1, $payslip_decimal_place); 
                        $hourly_value=bcdiv($hourly_value, 1, $payslip_decimal_place); 
                    }  
                $leave_basic_equivalent=$leave_reg_hrs*$daily_rate;

                $hourly_formula_text="HOURLY RATE ($hourly_value)= $daily_rate/$mysalary_no_of_hours";
                $basic_formula_text="Fixed Salary. ( Monthly Rate ) <br> $mysalary_amount";                
                $three_1st="";
                $three_2nd='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';


            }else{

            }



        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OVERTIME       
            //$ot_table_rate=0;
            require(APPPATH.'views/app/payroll/payslip/compute_overtime.php');
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OTHER ADDITION : look on general computation

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: COLA 
            if($daily_rate<=$minimum_wage){
                require(APPPATH.'views/app/payroll/payslip/compute_cola.php');
            }else{
                $total_cola_amount=0;
                $cola_formula_value=0;
                $cola_formula_text=0;
            }           
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OTHER ADDITION : TAXABLE & NON-TAXABLE
            require(APPPATH.'views/app/payroll/payslip/compute_other_addition.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OTHER DEDUCTION : TAXABLE & NON-TAXABLE
            require(APPPATH.'views/app/payroll/payslip/compute_other_deduction.php');    

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: GROSS
            require(APPPATH.'views/app/payroll/payslip/compute_gross_formula.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ABSENT
            require(APPPATH.'views/app/payroll/payslip/compute_absent.php');                      
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: LATE
            require(APPPATH.'views/app/payroll/payslip/compute_late.php');                        
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: UNDERTIME
            require(APPPATH.'views/app/payroll/payslip/compute_undertime.php');                  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OVERBREAK
            require(APPPATH.'views/app/payroll/payslip/compute_overbreak.php'); 
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: PAGIBIG CONTRIBUTION
            require(APPPATH.'views/app/payroll/payslip/compute_pagibig.php');                     
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: SSS CONTRIBUTION
            require(APPPATH.'views/app/payroll/payslip/compute_sss.php');                          
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: PHILHEALTH CONTRIBUTION
            require(APPPATH.'views/app/payroll/payslip/compute_philhealth.php');                               
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: TAXABLE INCOME
            $pagibig_contribution=$pi_taxable_amt_beyond;
            require(APPPATH.'views/app/payroll/payslip/compute_taxable_income.php');     
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: Witheld TAX
            require(APPPATH.'views/app/payroll/payslip/compute_tax.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: INCOME SUMMARY
            require(APPPATH.'views/app/payroll/payslip/compute_income_summary.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: DEDUCTION SUMMARY
            require(APPPATH.'views/app/payroll/payslip/compute_deduction_summary.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: NET PAY
            require(APPPATH.'views/app/payroll/payslip/compute_netpay.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: DEDUCTION SUMMARY( position here due to priority ded.)
            require(APPPATH.'views/app/payroll/payslip/compute_deduction_summary.php');  
  
//=========================================================== END FIXED SALARY
//=========================================================== START DTR SALARY            
    }else{

//=========================================================== SALARY RATE : PIECE RATE
        if($active_salary_rate=="1"){

//=========================================================== SALARY RATE : HOURLY
        }elseif($active_salary_rate=="2"){

//=========================================================== SALARY RATE : DAILY
        }elseif($active_salary_rate=="3"){
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: NET BASIC


            // if($no_attendance=="yes"){

            //          $basic_formula_text="Basic <i>(No attendance case)</i>= absent ($absences_total) * daily rate($mysalary_amount)";
            //          $net_basic_value=$absences_total*$mysalary_amount;

            //         if($round_off_payslip=="yes"){// round off
            //             $net_basic_value=round($net_basic_value, $payslip_decimal_place);
            //         }else{// cut only
            //             $net_basic_value=bcdiv($net_basic_value, 1, $payslip_decimal_place); 
            //         }

            // }else{

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
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OVERTIME       
            //$ot_table_rate=0;
            require(APPPATH.'views/app/payroll/payslip/compute_overtime.php');
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OTHER ADDITION : look on general computation

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: COLA 
            if($daily_rate<=$minimum_wage){
                require(APPPATH.'views/app/payroll/payslip/compute_cola.php');
            }else{
                $total_cola_amount=0;
                $cola_formula_value=0;
                $cola_formula_text=0;
            }           
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OTHER ADDITION : TAXABLE & NON-TAXABLE
            require(APPPATH.'views/app/payroll/payslip/compute_other_addition.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OTHER DEDUCTION : TAXABLE & NON-TAXABLE
            require(APPPATH.'views/app/payroll/payslip/compute_other_deduction.php');    

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: GROSS
            require(APPPATH.'views/app/payroll/payslip/compute_gross_formula.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ABSENT
            require(APPPATH.'views/app/payroll/payslip/compute_absent.php');                      
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: LATE
            require(APPPATH.'views/app/payroll/payslip/compute_late.php');                        
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: UNDERTIME
            require(APPPATH.'views/app/payroll/payslip/compute_undertime.php');                  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OVERBREAK
            require(APPPATH.'views/app/payroll/payslip/compute_overbreak.php'); 
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: PAGIBIG CONTRIBUTION
            require(APPPATH.'views/app/payroll/payslip/compute_pagibig.php');                     
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: SSS CONTRIBUTION
            require(APPPATH.'views/app/payroll/payslip/compute_sss.php');                          
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: PHILHEALTH CONTRIBUTION
            require(APPPATH.'views/app/payroll/payslip/compute_philhealth.php');                               
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: TAXABLE INCOME
            $pagibig_contribution=$pi_taxable_amt_beyond; 
            require(APPPATH.'views/app/payroll/payslip/compute_taxable_income.php');     
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: Witheld TAX
            require(APPPATH.'views/app/payroll/payslip/compute_tax.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: INCOME SUMMARY
            require(APPPATH.'views/app/payroll/payslip/compute_income_summary.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: DEDUCTION SUMMARY
            require(APPPATH.'views/app/payroll/payslip/compute_deduction_summary.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: NET PAY
            require(APPPATH.'views/app/payroll/payslip/compute_netpay.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: DEDUCTION SUMMARY( position here due to priority ded.)
            require(APPPATH.'views/app/payroll/payslip/compute_deduction_summary.php');  

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: CUTOFF : 1ST         
            if($cut_off=="1"){
                $three_1st='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';
                $three_2nd="";      
        
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: CUTOFF : 2ND
            }else{                
                $three_1st="";
                $three_2nd='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';

            }
//=========================================================== SALARY RATE : MONTHLY
        }elseif($active_salary_rate=="4"){

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: NET BASIC
            $basic_formula_text=str_replace("[","{",$net_basic_formula);
            $basic_formula_text=str_replace("]","}",$basic_formula_text);
            $basic_formula_text = $basic_formula_text;
            $for_translation=$basic_formula_text;
            require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
            $net_basic_formula_1st=str_replace("[","",$net_basic_formula);
            $net_basic_formula_2nd=str_replace("]","",$net_basic_formula_1st);    
            $net_basic_formula_3=$net_basic_formula_2nd;
            /**/$net_basic_value = eval('return '.$net_basic_formula_3.';');
            /**/$basic_formula_text=$net_basic_formula_desc."<br> $for_translation";

            $hourly_value=(($mysalary_amount/$mysalary_no_of_days_yearly)*12)/$mysalary_no_of_hours;

            if($round_off_payslip=="yes"){// round off
                $hourly_value=round($hourly_value, $compensation_initial_decimal_place);
            }else{
                $hourly_value=bcdiv($hourly_value, 1, $compensation_initial_decimal_place); 
            }


            $hourly_formula_text='HOURLY RATE( '.$hourly_value.' )= (((SALARY AMOUNT('.$mysalary_amount.')/'.$mysalary_no_of_days_yearly.') * 12)/'.$mysalary_no_of_hours.')  ';
            $daily_rate=($mysalary_amount/$mysalary_no_of_days_yearly)*12;

            if($round_off_payslip=="yes"){// round off
                $daily_rate=round($daily_rate, $compensation_initial_decimal_place);
            }else{
                $daily_rate=bcdiv($daily_rate, 1, $compensation_initial_decimal_place); 
            }

            $leave_basic_equivalent=$leave_reg_hrs*$daily_rate;
            $daily_formula='DAILY RATE ='. $daily_rate.'';   
            //echo $mysalary_amount / $mysalary_no_of_days_monthly;
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OVERTIME       
            //$ot_table_rate=0;
            require(APPPATH.'views/app/payroll/payslip/compute_overtime.php');
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OTHER ADDITION : look on general computation

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: COLA 

            if($daily_rate<=$minimum_wage){
                require(APPPATH.'views/app/payroll/payslip/compute_cola.php');
            }else{
                $total_cola_amount=0;
                $cola_formula_value=0;
                $cola_formula_text=0;
            }
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OTHER ADDITION : TAXABLE & NON-TAXABLE
            require(APPPATH.'views/app/payroll/payslip/compute_other_addition.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OTHER DEDUCTION : TAXABLE & NON-TAXABLE
            require(APPPATH.'views/app/payroll/payslip/compute_other_deduction.php');    

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: GROSS
            require(APPPATH.'views/app/payroll/payslip/compute_gross_formula.php');     
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ABSENT
            require(APPPATH.'views/app/payroll/payslip/compute_absent.php');      
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: LATE
            require(APPPATH.'views/app/payroll/payslip/compute_late.php');        
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: UNDERTIME
            require(APPPATH.'views/app/payroll/payslip/compute_undertime.php');     
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: OVERBREAK
            require(APPPATH.'views/app/payroll/payslip/compute_overbreak.php');             
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: PAGIBIG CONTRIBUTION
            require(APPPATH.'views/app/payroll/payslip/compute_pagibig.php');  
                    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: SSS CONTRIBUTION
            require(APPPATH.'views/app/payroll/payslip/compute_sss.php');                  
                    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: PHILHEALTH CONTRIBUTION
            require(APPPATH.'views/app/payroll/payslip/compute_philhealth.php');                  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: TAXABLE INCOME
            $pagibig_contribution=$pi_taxable_amt_beyond;
            require(APPPATH.'views/app/payroll/payslip/compute_taxable_income.php');
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: Witheld TAX
            require(APPPATH.'views/app/payroll/payslip/compute_tax.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: INCOME SUMMARY
            require(APPPATH.'views/app/payroll/payslip/compute_income_summary.php');
                                         
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: NET PAY
            require(APPPATH.'views/app/payroll/payslip/compute_netpay.php');  
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: DEDUCTION SUMMARY( position here due to priority ded.)
            require(APPPATH.'views/app/payroll/payslip/compute_deduction_summary.php');      
//::::::::::::::::::::::::::::::::::::::::::::::::::::: :::::: CUTOFF : 1ST  
                if($cut_off=="1"){
                    $three_1st='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';
                    $three_2nd="";   
            
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: CUTOFF : 2ND  
                }else{
                    $three_1st="";
                    $three_2nd='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';
            

                }



        }else{

        }

    }



                    if($show_generate_payslip_details=="yes"){



                    if($pay_type=="4"){
                                                //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: Monthly payslip details
                                                    require(APPPATH.'views/app/payroll/payslip/monthly/monthly_payslip.php');   
                    }else{

                    }

                                            
                    }else{
                        
                    }

//=========================================================== END SALARY     

//============================================CHECK RETRO SALARY 
// $chek_retro_salary=$this->payroll_generate_payslip_model->check_RetroSalary($employee_id,$pay_period_from,$pay_period_to,$mysalary_id);

// if(!empty($chek_retro_salary)){
//     $retro_salary_state="yes";
// }else{
//     $retro_salary_state="";
// }

if($retro_pay_late_effectivity_reference==""){
// salary was not late approved.
}else{
//legend : tr : total retro
$tr_absent=0;
$tr_late=0;
$tr_undertime=0;
$tr_overbreak=0;

$tr_regular_nd=0;
$tr_regular_ot=0;
$tr_restday_ot=0;
$tr_reg_hol_ot=0;
$tr_spec_hol_ot=0;
$tr_rd_reg_hol_ot=0;
$tr_rd_spec_hol_ot=0;
$tr_regular_ot_nd=0;
$tr_restday_ot_nd=0;
$tr_regular_hol_ot_nd=0;
$tr_spec_hol_ot_nd=0;
$tr_rd_reg_hol_ot_nd=0;
$tr_rd_spec_hol_ot_nd=0;


$retroStartCov=$this->payroll_generate_payslip_model->LateSalaryCovered($emp->payroll_period_group_id,$retro_pay_late_effectivity_reference);
if(!empty($retroStartCov)){
    $retro_complete_from=$retroStartCov->complete_from;
    $retro_payperiod_id=$retroStartCov->id;
    $retro_payperiod_month_cover=$retroStartCov->month_cover;

    $retroOldSalary=$this->payroll_generate_payslip_model->CheckOldSalary($employee_id,$retro_payperiod_id,$retro_payperiod_month_cover);
    if(!empty($retroOldSalary)){
        $retro_old_dailyrate=$retroOldSalary->daily_rate;
        $retro_old_hourlyrate=$retroOldSalary->hourly_rate;

        if($daily_rate>$retro_old_dailyrate){
            $salary_retro_type="increase";
            $retro_dr_adj=$daily_rate-$retro_old_dailyrate;
            $retro_hr_adj=$hourly_value-$retro_old_hourlyrate;
        }elseif($daily_rate==$retro_old_dailyrate){
            $salary_retro_type="the_same";
            $retro_dr_adj=0;
            $retro_hr_adj=0;
        }else{
            $salary_retro_type="decrease";
            $retro_dr_adj=$retro_old_dailyrate-$daily_rate;
            $retro_hr_adj=$retro_old_hourlyrate-$hourly_value;
        }




    while (strtotime($retro_complete_from) <= strtotime("-1 day", strtotime($pay_period_from))) {
        $retro_dtr=$this->payroll_generate_payslip_model->getRetroDTR($employee_id,$retro_payperiod_id,$retro_complete_from,$retro_payperiod_month_cover);
        if(!empty($retro_dtr)){           
            $retro_isrestday=$retro_dtr->isrestday;
            $retro_isrestday_snw_holiday=$retro_dtr->isrestday_snw_holiday;
            $retro_isrestday_reg_holiday=$retro_dtr->isrestday_reg_holiday;
            $retro_is_snw_holiday=$retro_dtr->is_snw_holiday;
            $retro_is_regular_holiday=$retro_dtr->is_regular_holiday;

            $retro_regular_hour=$retro_dtr->regular_hour;

            $retro_regular_nd=$retro_dtr->regular_nd;
            $retro_regular_ot=$retro_dtr->regular_ot;
            $retro_restday_ot=$retro_dtr->restday_ot;
            $retro_reg_hol_ot=$retro_dtr->reg_hol_ot;
            $retro_spec_hol_ot=$retro_dtr->spec_hol_ot;
            $retro_rd_reg_hol_ot=$retro_dtr->rd_reg_hol_ot;
            $retro_rd_spec_hol_ot=$retro_dtr->rd_spec_hol_ot;
            $retro_regular_ot_nd=$retro_dtr->regular_ot_nd;
            $retro_restday_ot_nd=$retro_dtr->restday_ot_nd;
            $retro_regular_hol_ot_nd=$retro_dtr->regular_hol_ot_nd;
            $retro_spec_hol_ot_nd=$retro_dtr->spec_hol_ot_nd;
            $retro_rd_reg_hol_ot_nd=$retro_dtr->rd_reg_hol_ot_nd;
            $retro_rd_spec_hol_ot_nd=$retro_dtr->rd_spec_hol_ot_nd;

            $retro_late=$retro_dtr->late;
            $retro_overbreak=$retro_dtr->overbreak;
            $retro_undertime=$retro_dtr->undertime;
            $retro_absent_count=$retro_dtr->absent_count;

            // ==== total ====
            // if($retro_isrestday==""){
            //     $tr_regular_hour+=$regular_hour
            // }else{

            // }


            $tr_absent+=$retro_absent_count;
            $tr_late+=$retro_late;
            $tr_undertime+=$retro_undertime;
            $tr_overbreak+=$retro_overbreak;

            $tr_regular_nd+=$retro_regular_nd;
            $tr_regular_ot+=$retro_regular_ot;
            $tr_restday_ot+=$retro_restday_ot;
            $tr_reg_hol_ot+=$retro_reg_hol_ot;
            $tr_spec_hol_ot+=$retro_spec_hol_ot;
            $tr_rd_reg_hol_ot+=$retro_rd_reg_hol_ot;
            $tr_rd_spec_hol_ot+=$retro_rd_spec_hol_ot;
            $tr_regular_ot_nd+=$retro_regular_ot_nd;
            $tr_restday_ot_nd+=$retro_restday_ot_nd;
            $tr_regular_hol_ot_nd+=$retro_regular_hol_ot_nd;
            $tr_spec_hol_ot_nd+=$retro_spec_hol_ot_nd;
            $tr_rd_reg_hol_ot_nd+=$retro_rd_reg_hol_ot_nd;
            $tr_rd_spec_hol_ot_nd+=$retro_rd_spec_hol_ot_nd;            
            //  ==== total ====


        }else{

        }

        $retro_complete_from = date ("Y-m-d", strtotime("+1 day", strtotime($retro_complete_from)));
    }
            
    }else{

    }

}else{
    $retro_complete_from="";
    $retro_payperiod_id="";
    $retro_old_dailyrate="";
    $retro_old_hourlyrate="";
}
   


/*
1.check payroll period where retro_pay_late_effectivity_reference is covered. get it
2.check the old hourly & daily rate
3.check the actual no of  absent,ot,late,overbreak,undetime per date.
4.if increase put automatic other addition for (ot,daily rate) and automatic deduction
for absent,late,undetime,overbreak
5.add the retro total to corresponding column.
*/

$final_retro_absent=$tr_absent*$retro_dr_adj;
$final_retro_late=$tr_late*$retro_dr_adj;
$final_retro_undertime=$tr_undertime*$retro_dr_adj;
$final_retro_overbreak=$tr_overbreak*$retro_dr_adj;

//echo "$final_retro_absent | $final_retro_late | $final_retro_undertime | $final_retro_overbreak";

if($salary_retro_type=="increase"){

}else{

}



}



    ?>
<tbody>
<?php
//========== checking of cutoffs start

if(($active_pay_type=="2")OR($active_pay_type=="3")){// bi weeekly or semi monthly
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_basic.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($net_basic_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$net_basic_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$basic_formula_text.'<br>
                    '.$daily_formula.'<br>
                    '.$hourly_formula_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no net basic formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_net_basic_formula).'
                </td>';                    
            }else{    
                 if($net_basic_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$basic_formula_text.'<br>
                    '.$daily_formula.'<br>
                    '.$hourly_formula_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no net basic formula reference setup yet.
                    </td>';    
                 }                         
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_overtime.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($ot_formula or $is_salary_fixed=="1"){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$total_overtime_amount.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
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
                    <td style="text-align: left;">
                        notice : no overtime formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_ot_formula).'
                </td>';                    
            }else{    
                 if($ot_formula or $is_salary_fixed=="1"){
                    echo '
                    <td style="text-align: left;">
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
                    <td style="text-align: left;">
                        notice : no overtime formula reference setup yet.
                    </td>';    
                 }                         
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_shift_night_diff.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($ot_formula or $is_salary_fixed=="1"){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$ws_nd_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$ws_nd_formula_text.'

                    </td>';                  
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no overtime formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_shift_night_diff_formula).'
                </td>';                    
            }else{    
                 if($ot_formula or $is_salary_fixed=="1"){
                    echo '
                    <td style="text-align: left;">
                    '.$ws_nd_formula_text.'     

                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no overtime formula reference setup yet.
                    </td>';    
                 }                         
            }
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
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_other_addition_taxable.'
            </td>';
        }else{
            if($cut_off=="2"){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$total_taxable_oa.'
                    </td>';                     
            }else{
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    0
                    </td>';    
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                    echo '
                    <td style="text-align: left;">
                    '.nl2br($first_posted_oa_taxable_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td style="text-align: left;">
                    '.$oae_taxable_list.'<br>
                    '.$auto_oae_taxable_list.'<br>
                    '.$auto_ot_meal_allowance_how_to_taxable.'<br>
                    '.$taxable_payroll_leave_adjustment_how_to.'
                    </td>';                                         
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                    echo '
                    <td style="text-align: left;">
                    '.nl2br($second_posted_oa_taxable_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td style="text-align: left;">
                    '.$oae_taxable_list.'<br>
                    '.$auto_oae_taxable_list.'<br>
                    '.$auto_ot_meal_allowance_how_to_taxable.'<br>
                    '.$taxable_payroll_leave_adjustment_how_to.'
                    </td>';                                         
            }
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
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_other_addition_non_tax.'
            </td>';
        }else{
            if($cut_off=="2"){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$total_nontaxable_oa.'
                    </td>';                     
            }else{
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    0
                    </td>';    
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                    echo '
                    <td style="text-align: left;">
                    '.nl2br($first_posted_oa_nontax_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td style="text-align: left;">
                    '.$oae_nontaxable_list.'<br>
                    '.$auto_oae_nontaxable_list.'<br>
                    '.$auto_ot_meal_allowance_how_to_nontaxable.'<br>
                    '.$nontax_payroll_leave_adjustment_how_to.'
                    </td>';                                         
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                    echo '
                    <td style="text-align: left;">
                    '.nl2br($second_posted_oa_nontax_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td style="text-align: left;">
                    '.$oae_nontaxable_list.'<br>
                    '.$auto_oae_nontaxable_list.'<br>
                    '.$auto_ot_meal_allowance_how_to_nontaxable.'<br>
                    '.$nontax_payroll_leave_adjustment_how_to.'
                    </td>';                                         
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_cola.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($cola_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$total_cola_amount.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$cola_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no cola formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
               '.nl2br($first_posted_cola_how_to).'
                </td>';                    
            }else{    
                 if($cola_formula){
                    echo '
                    <td style="text-align: left;">
                    '.nl2br($cola_formula_text).'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no cola formula reference setup yet.
                    </td>';    
                 }                         
            }
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
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_other_deduction_taxable.'
            </td>';
        }else{
            if($cut_off=="2"){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$total_taxable_od.'
                    </td>';                     
            }else{
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    0
                    </td>';    
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                    echo '
                    <td style="text-align: left;">
                    '.nl2br($first_posted_od_taxable_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td style="text-align: left;">
                    '.$ode_taxable_list.'<br>
                    '.$auto_ode_taxable_list.'<br>
                    </td>';                                         
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                    echo '
                    <td style="text-align: left;">
                    '.nl2br($second_posted_od_taxable_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td style="text-align: left;">
                    '.$ode_taxable_list.'<br>
                    '.$auto_ode_taxable_list.'<br>
                    </td>';                                         
            }
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
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_other_deduction_nontax.'
            </td>';
        }else{
            if($cut_off=="2"){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$total_nontaxable_od.'
                    </td>';                     
            }else{
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    0
                    </td>';    
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                    echo '
                    <td style="text-align: left;">
                    '.nl2br($first_posted_od_nontax_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td style="text-align: left;">
                    '.$ode_nontaxable_list.'<br>
                    '.$auto_ode_nontaxable_list.'<br>
                    </td>';                                         
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                    echo '
                    <td style="text-align: left;">
                   '.nl2br($second_posted_od_nontax_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td style="text-align: left;">
                    '.$ode_nontaxable_list.'<br>
                    '.$auto_ode_nontaxable_list.'<br>
                    </td>';                                         
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_gross.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($gross_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$gross_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$gross_formula_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no gross formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_gross_formula).'
                </td>';                    
            }else{  
                 if($gross_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$gross_formula_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no gross formula reference setup yet.
                    </td>';    
                 }                        
            }
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
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_loan.'
            </td>';
        }else{
            if($cut_off=="2"){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$total_loan.'
                    </td>';                     
            }else{
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    0
                    </td>';    
            }
        }

        if($cut_off=="1"){
            if($first_cutoff_payslip_state=="posted"){
                    echo '
                    <td style="text-align: left;">
                   '.nl2br($first_posted_loan_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td style="text-align: left;">
                    '.$loan_text.'<br>
                    '.$pause_loan_text.'<br>
                    '.$nonpriority_loan_text.'<br>
                    </td>';                                         
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                    echo '
                    <td style="text-align: left;">
                    '.nl2br($second_posted_loan_how_to).'
                    </td>';                    
            }else{  
                    echo '
                    <td style="text-align: left;">
                    '.$loan_text.'<br>
                    '.$pause_loan_text.'<br>
                    '.$nonpriority_loan_text.'<br>
                    </td>';                                         
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_sss_employee.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($sss_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$sss_employee_share.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$sss_formula_text.'<br><br>
                    '.$sss_employer_share_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no sss formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_sss_formula).'
                </td>';                    
            }else{  
                 if($sss_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$sss_formula_text.'<br><br>
                    '.$sss_employer_share_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no sss formula reference setup yet.
                    </td>';    
                 }                        
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_philhealth_employee.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($philhealth_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$philhealth_employee_share.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$philhealth_formula_text.'<br><br>
                    '.$philhealth_employer_share_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no philhealth formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_ph_formula).'
                </td>';                    
            }else{  
                 if($philhealth_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$philhealth_formula_text.'<br><br>
                    '.$philhealth_employer_share_text.'
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no philhealth formula reference setup yet.
                    </td>';    
                 }                        
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_pagibig.'
            </td>';
        }else{
            if($cut_off=="2"){
                if(($pi_amount)AND($pi_amount_type)){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$pagibig_contribution_employee.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$pagibig_contribution_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no pagibig enrollment reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_pi_formula).'
                </td>';                    
            }else{  
                 if(($pi_amount)AND($pi_amount_type)){
                    echo '
                    <td style="text-align: left;">
                    '.$pagibig_contribution_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no pagibig enrollment reference setup yet.
                    </td>';    
                 }                        
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_absent.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($absent_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$absent_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$absent_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no absent formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_absent_formula).'
                </td>';                    
            }else{  
                 if($absent_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$absent_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no absent formula reference setup yet.
                    </td>';    
                 }                        
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_late.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($late_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$late_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$late_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no late formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_late_formula).'
                </td>';                    
            }else{  
                 if($late_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$late_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no late formula reference setup yet.
                    </td>';    
                 }                        
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_undertime.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($ut_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$undertime_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$undertime_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no ut formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_ut_formula).'
                </td>';                    
            }else{  
                 if($ut_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$undertime_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no ut formula reference setup yet.
                    </td>';    
                 }                        
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_overbreak.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($overbreak_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$overbreak_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$overbreak_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no overbreak formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_overbreak_formula).'
                </td>';                    
            }else{  
                 if($overbreak_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$overbreak_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no overbreak formula reference setup yet.
                    </td>';    
                 }                        
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
           '.$second_posted_taxable.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($taxable_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$actual_taxable_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$taxable_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no taxable formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_taxable_formula).'
                </td>';                    
            }else{  
                 if($taxable_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$taxable_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no taxable formula reference setup yet.
                    </td>';    
                 }                        
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
           '.$second_posted_wtax.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($wtax_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$witheld_tax.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$wtax_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no wtax formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
               '.nl2br($second_posted_wtax_formula).'
                </td>';                    
            }else{  
                 if($wtax_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$wtax_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no wtax formula reference setup yet.
                    </td>';    
                 }                        
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_income_total.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($income_sum_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$income_sum_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$income_sum_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no income summary formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_income_total_how_to).'
                </td>';                    
            }else{  
                 if($income_sum_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$income_sum_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no income summary formula reference setup yet.
                    </td>';    
                 }                        
            }
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
                echo '
                <td class="amount_class" '.$three_1st.'>
                0
                </td>';    
            }
        }

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_deduction_total.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($deduction_sum_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
                    '.$deduction_sum_formula_value.'
                    </td>';                     
                }else{
                    echo '
                    <td class="amount_class" '.$three_1st.'>
                    0
                    </td>'; 
                }
            }else{
                echo '
                <td class="amount_class" '.$three_2nd.'>
                0
                </td>';    
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
                    <td style="text-align: left;">
                    '.$deduction_sum_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no deduction summary formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_deduction_total_how_to).'
                </td>';                    
            }else{  
                 if($deduction_sum_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$deduction_sum_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no deduction summary formula reference setup yet.
                    </td>';    
                 }                        
            }
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

        if($second_cutoff_payslip_state=="posted"){
            echo '
            <td class="amount_class" '.$three_2nd.'>
            '.$second_posted_netpay.'
            </td>';
        }else{
            if($cut_off=="2"){
                if($net_pay_formula){
                    echo '
                    <td class="amount_class" '.$three_2nd.'>
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
                <td class="amount_class" '.$three_2nd.'>
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
                    <td style="text-align: left;">
                    '.$net_pay_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no net pay formula reference setup yet.
                    </td>';    
                 }                        
            }
        }else{// second cutoff
            if($second_cutoff_payslip_state=="posted"){
                echo '
                <td style="text-align: left;">
                '.nl2br($second_posted_net_pay_formula).'
                </td>';                    
            }else{  
                 if($net_pay_formula){
                    echo '
                    <td style="text-align: left;">
                    '.$net_pay_formula_text.'<br>
                    </td>';                   
                 }else{
                    echo '
                    <td style="text-align: left;">
                        notice : no net pay formula reference setup yet.
                    </td>';    
                 }                        
            }
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

        <td <?php echo $three_2nd; ?>>
            <?php
          
                 echo $second_cutoff_payslip_state;  
            ?>            
        </td>
        <td>&nbsp;</td>
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

    // echo "
    // <tr>
    // <td colspan='6'><i class='fa fa-check-square-o' style='font-size:48px;'></i> Print Payslip..</td>
    // </tr>
    //     ";


}else{// check payroll .

    echo "
    <tr>
    <td colspan='6'><i class='fa fa-check-square-o' style='font-size:48px;'></i> Payroll Checking..</td>
    </tr>
        ";
}




}else{

}
//========== checking of cutoffs end
?>

</tbody>
<?php

//=========================================================== END PAY TYPE : BI-WEEKLY OR SEMI MONTHLY 
//=========================================================== START PAY TYPE : MONTHLY  
// }elseif(($active_pay_type=="4")AND ($show_generate_payslip_details=="yes")){

//         //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: Monthly payslip details
//             require(APPPATH.'views/app/payroll/payslip/monthly/monthly_payslip.php');   


//=========================================================== END PAY TYPE : MONTHLY  
}else{

    echo "
    <tr>
    <td colspan='6'><i class='fa fa-close text-danger' style='font-size:48px;'></i>DTR is not yet processed.

    <i class='fa fa-quote-left text-info' style='font-size:20px;'></i>
    <span class='system_auto_guide'>go to time > Daily Time Record (DTR)</span>
    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>

    </td>
    </tr>";


}

?>


</table>
</div>

<br/><br/><br/>


<?php
}// END FOREACH OF EMPLOYEES




}else{

    echo "
    <tr>
    <td colspan='6'><i class='fa fa-close text-danger' style='font-size:48px;'></i>no employee found</i>

    </td>
    </tr>";

 
}

?>

