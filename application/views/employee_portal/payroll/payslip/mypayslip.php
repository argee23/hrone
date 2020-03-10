<?php

/*
-------------------------------------------------------------------
start same with the admin code.
-------------------------------------------------------------------
*/
$gen_pay_theme=$this->payroll_generate_payslip_model->get_payroll_theme($company_id,1);
if(!empty($gen_pay_theme)){
	$bg_color_genpay=$gen_pay_theme->bg_color;
	$font_color_genpay=$gen_pay_theme->font_color;
	$overlay_genpay=$gen_pay_theme->bg_overlay;
	$bg_color_viewcomp_act_cutoff=$gen_pay_theme->view_comp_chosen_cutoff_bg;
	$actual_payslip_design=$gen_pay_theme->payslip_design;
}else{
	$bg_color_genpay="#006699";
	$font_color_genpay="#FFF";
	$overlay_genpay="#000";
	$bg_color_viewcomp_act_cutoff="#D9E6FC";
	$actual_payslip_design="117"; // default Type 1
}
/*
-------------------------------------------------------------------
end same with the admin code.
-------------------------------------------------------------------
*/


?>
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

<?php

/*
-------------------------------------------------------------------
declare/ready general variables needed in viewing the posted payslip.
-------------------------------------------------------------------
*/
$company_name=$comp_profile->company_name;
$company_logo=$comp_profile->logo;
$name=$emp_profile->name;
$emp_electronic_signature=$emp_profile->electronic_signature;
$employee_id=$this->session->userdata('employee_id');
$selected_individual_employee_id=$employee_id;
$pay_period=$payroll_period_id;
$check_payroll_period_id=$payroll_period_id;

if(!empty($pp_details)){

$pay_period_from=$pp_details->complete_from;
$pay_period_to=$pp_details->complete_to;
$month_cover=$pp_details->month_cover;

$p_from=$pay_period_from;
$p_to=$pay_period_to;

}else{

}
$pol=15; //Automatic payslip viewed acknowledge upon employee open the payslip
$payslip_click=$this->My_payslip_model->check_single_setup_payroll($company_id,$pol);
if(!empty($payslip_click)){
	$proceed_acknowledge=$payslip_click->single_field;
}else{
	$proceed_acknowledge="yes"; // default: upon employee click to view the payslip it will mean that he/she already checked the payslip.
}
$pol=16; //Upon payslip acknowledge automatic attached the employee electronic signature on payslip.
$payslip_signature=$this->My_payslip_model->check_single_setup_payroll($company_id,$pol);
if(!empty($payslip_signature)){
	$show_emp_electronic_sign=$payslip_signature->single_field;
}else{
	$show_emp_electronic_sign="no"; // default
}

$pol=1; //Payslip Decimal Place
$pdp=$this->My_payslip_model->check_single_setup_payroll($company_id,$pol);
if(!empty($pdp)){
    $payslip_decimal_place=$pdp->single_field;
}else{
    $payslip_decimal_place="2"; // default
}


if($proceed_acknowledge=="no"){

}else{

}

if($proceed_acknowledge=="yes"){

	$check_first=$this->My_payslip_model->check_acknowledge_payslip($company_id,$employee_id,$payroll_period_id,$month_cover);
	if(!empty($check_first)){
		$is_already_acknow=$check_first->employee_acknowledge;
	
	}else{
		$is_already_acknow="no";
	}

	if($is_already_acknow=="no" OR $is_already_acknow==""){

		$this->My_payslip_model->acknowledge_payslip($company_id,$employee_id,$payroll_period_id,$month_cover);

	}else{
		// no need to acknowledge as already acknowledge before
	}

}else{

}

?>

<!--
------------------------------------------------------------------
start same with the admin code.
------------------------------------------------------------------
-->


<button type="button"  class="btn btn-danger" onclick="printDiv('printableArea')" value="PRINT" >Print</button>

<div id="printableArea">
<div class="datagrid">
    <table  cellpadding="1" cellspacing="3">
        <thead>
            <tr>      
            <th><img src="<?php echo base_url();?>/public/company_logo/<?php echo $company_logo;?>" class="img-rounded" id="company_logo" width="50" height="50"><?php echo $company_name;?>
            <span style="float: right;"><?php echo $pay_period_from." to ".$pay_period_to;?> <br><br> <?php echo $employee_id." ".$name;?></span>
            </th>
                
            </tr>
        </thead>
    </table>
</div>

<?php 
$get_customized_headers=$this->payroll_generate_payslip_model->payslip_customized_headers($company_id);
if(!empty($get_customized_headers)){
        echo 
        '<div class="datagrid"><table  cellpadding="1" cellspacing="3">
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
        </table></div>';
}else{

}
?>
<div class="datagrid">
<table  cellpadding="1" cellspacing="3" border="1">
    <thead>
    <tr>
        <th></th>
        <th colspan="2" class="payroll_center">
     
<table>
<thead >
        <tr >
            </tr>
</thead>
</table>
        </th>

           </tr>
    </thead>
<!--
------------------------------------------------------------------
end same with the admin code.
------------------------------------------------------------------
-->






<?php
   require(APPPATH.'views/app/payroll/payslip/print_payslip_body.php');
?>


</div>