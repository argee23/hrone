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
.summary_title_des{
    color:#ff0000;
    font-weight: bold;
    text-transform: uppercase;
    text-align: center !important;
    font-size: 15px;
}

.note_summary{
    text-align: right;
}

/*PAYSLIP*/

    </style>    
</head>

<?php
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

        $computation_option=$this->input->post('computation_option');

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

        $how_many_did_post=0;
        $how_many_did_not_post=0;
        $how_many_did_post_prev=0;

		$count_employees = 0; // count employees


if($selected_payroll_option=="view_saved_retro" OR $selected_payroll_option=="reset_retro_pay"){

    if($selected_payroll_option=="reset_retro_pay"){
        $note_display="You are resetting the previously posted Retro Pay";
    }else{
        $note_display='Note: This will be included to Regular Payroll '.$month_from.'/'.$day_from.'/'.$year_from.' TO '.
        $month_to.'/'.$day_to.'/'.$year_to;
    }

    echo '
    <div class="summary_title_des">Retro Pay Summary</div>

<div class="datagrid">

    <table  cellpadding="1" cellspacing="3">
    <thead>
       <tr>
        <th class="note_summary" colspan="4">'.$note_display.'</th>
        
      </tr>
         
      <tr>
        <th>Company Name</th>
        <th colspan="3">'.$company_name.'</th>
      </tr>
      <tr>
        <th>Employee Name</th>
        <th>Total Addition</th>
        <th>Total Deduction</th>
        <th>Total Retro Pay</th>
      </tr>
    </thead>
    <tbody>

    ';

}elseif($selected_payroll_option=="encode_retro"){
?>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_generate_bonus/save_manual_bonus/<?php echo $pay_period?>/<?php echo $company_id?>" target="_blank">

  <input type="hidden" name="payroll_option" value="encode_retro">

<div class="datagrid">
<table class="table table">
    <thead>
        <thead>
            <tr>
                <th colspan="3" style="text-align:center;">Encode Manual Bonus Computation</th>
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


//============================================ CHECK EMPLOYEE PAYROLL PERIOD GROUP ===========================================
$getmy_payroll_period_group=$this->Payroll_generate_13th_month_model->spec_payroll_period_group($emp->payroll_period_group_id);
$my_group_name=$getmy_payroll_period_group->group_name;




//============================================SHOW HEADER
if($selected_payroll_option=="encode_retro"){
    require(APPPATH.'views/app/payroll/bonus/payslip_header_manual_bonus.php');  
}elseif($selected_payroll_option=="view_saved_retro"){
// no header
}else{
    require(APPPATH.'views/app/payroll/retro_pay/payslip_header.php');  

}
  
//============================================SHOW BODY
if($selected_payroll_option=="system_computed_retro"  OR $selected_payroll_option=="post_system_computed_retro"){

require(APPPATH.'views/app/payroll/retro_pay/system_computed_retro.php');  


}elseif($selected_payroll_option=="view_saved_retro" OR $selected_payroll_option=="reset_retro_pay"){

require(APPPATH.'views/app/payroll/retro_pay/view_saved_retro.php');  


}else{

}



}// END FOREACH OF EMPLOYEES




if($selected_payroll_option=="view_saved_retro" OR $selected_payroll_option=="reset_retro_pay"){

   echo '
    </tbody>
  </table>
</div>
   ';

}elseif($selected_payroll_option=="encode_retro"){
?>

<div class="col-md-2">
    <label class="checkbox-inline"><input type="radio" value="review" checked name="generate_type">REVIEW</label>
    <label class="checkbox-inline"><input type="radio" value="save" name="generate_type">SAVE</label>
</div>

<div class="col-md-8">
    <button type="submit" class="btn btn-lg btn-danger"> Generate </button>
</div>



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




?>

<br><br>

