<?php
$company_logo=$company_info->logo;
$company_name=$company_info->company_name;
$company_id=$company_info->company_id;
$wDivision=$company_info->wDivision;
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

    </style>    
</head>
<body>

<?php


if(!empty($emp)){
    foreach($emp as $emp){
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
        $classification_id=$emp->classification_id;
        $employment_id=$emp->employment_id;
        $pay_type_name=$emp->pay_type_name;
        $active_pay_type=$emp->pay_type;

        $date_employed=$emp->date_employed;
        $emp_electronic_signature=$emp->electronic_signature;


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


        $credits_for_conversion=$emp->credits_for_conversion;
        $nontax_amount=$emp->nontax_amount;
        $nontax_amount_how=$emp->nontax_amount_how;
        $taxable_amount=$emp->taxable_amount;
        $taxable_amount_how=$emp->taxable_amount_how;
        $witheld_tax=$emp->witheld_tax;
        $wtax_formula_text=$emp->wtax_formula_text;
        $salary_details=$emp->salary_details;
        $taxable_leave_beyond=$emp->taxable_leave_beyond;
        $non_taxable_credit=$emp->non_taxable_credit;
        $taxable_credit=$emp->taxable_credit;
        $other_add_typ=$emp->other_add_typ;
        $leave_id=$emp->leave_id;
        $amount_converted=$emp->amount_converted;
        $amount_converted_how=$emp->amount_converted_how;

        require(APPPATH.'views/app/payroll/leave_conversion/lc_payslip_header.php');    
        require(APPPATH.'views/app/payroll/leave_conversion/lc_payslip_body.php');    

?>





<?php
        
    }
}else{
echo "no posted yet.";
}
?>


</body>
</html>