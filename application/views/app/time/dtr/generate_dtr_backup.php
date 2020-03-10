<?php
$company_id=$this->input->post('company_id');
$mydtr_theme=$this->time_dtr_model->check_dtr_theme($company_id);
if(!empty($mydtr_theme)){

	$bg_color_genpay=$mydtr_theme->bg_color;
	$font_color_genpay=$mydtr_theme->font_color;
	$overlay_genpay=$mydtr_theme->bg_overlay;

	$show_dtr_summary_button_bg=$mydtr_theme->show_dtr_summary_button_bg;
	$show_dtr_summary_button_font_color=$mydtr_theme->show_dtr_summary_button_font_color;

	$show_logs_root_button_bg=$mydtr_theme->show_logs_root_button_bg;
	$show_logs_root_button_font_color=$mydtr_theme->show_logs_root_button_font_color;

	$hl_sunday=$mydtr_theme->sunday_hl;
	$hl_shift='style="background-color:'.$mydtr_theme->shift_time_hl.';"';
	$hl_logs='style="background-color:'.$mydtr_theme->actual_time_hl.';"';
	$hl_late='style="background-color:'.$mydtr_theme->late.';"';
	$hl_overbrk='style="background-color:'.$mydtr_theme->overbreak.';"';
	$hl_undrtme='style="background-color:'.$mydtr_theme->undertime.';"';

	$hl_hw_head='style="background-color:'.$mydtr_theme->hours_worked_header.';"';
	$hl_hw_reg='style="background-color:'.$mydtr_theme->hw_reg.';"';
	$hl_hw_nd='style="background-color:'.$mydtr_theme->hw_nd.';"';
	$hl_hw_actual='style="background-color:'.$mydtr_theme->hw_actual.';"';
	$regot_hl='style="background-color:'.$mydtr_theme->regot_hl.';"';
	$rdot_hl='style="background-color:'.$mydtr_theme->rdot_hl.';"';
	$snw_hl='style="background-color:'.$mydtr_theme->snw_hl.';"';
	$reghol_hl='style="background-color:'.$mydtr_theme->reghol_hl.';"';
	$rd_snw_hl='style="background-color:'.$mydtr_theme->rd_snw_hl.';"';
	$rd_reghol_hl='style="background-color:'.$mydtr_theme->rd_reghol_hl.';"';
	$ot_nd='style="background-color:'.$mydtr_theme->ot_nd.';"';
	$atro_hl='style="background-color:'.$mydtr_theme->atro_hl.';"';
	$form_change_rdshift_hl='style="background-color:'.$mydtr_theme->form_change_rdshift_hl.';"';
	$form_leave_hl='style="background-color:'.$mydtr_theme->form_leave_hl.';"';
	$form_ob_hl='style="background-color:'.$mydtr_theme->form_ob_hl.';"';
	$form_tk_hl='style="background-color:'.$mydtr_theme->form_tk_hl.';"';
	$form_ut_hl='style="background-color:'.$mydtr_theme->form_ut_hl.';"';

	$early_cutoff_marked_bg=$mydtr_theme->early_cutoff_dates_hl;
	$early_cutoff_marked_color=$mydtr_theme->early_cutoff_dates_color;

}else{ // default dtr theme

	$early_cutoff_marked_bg='#FF0000';
	$early_cutoff_marked_color='#fff';

	$bg_color_genpay="#006699";
	$font_color_genpay="#fff";
	$overlay_genpay="#000";
	$show_dtr_summary_button_bg="#006699";
	$show_dtr_summary_button_font_color="#fff";

	$show_logs_root_button_bg="#006699";
	$show_logs_root_button_font_color="#fff";

	$hl_sunday="#ffccff";
	$hl_shift='style="background-color:#ff99cc;"';
	$hl_logs='style="background-color:#66ff99;"';
	$hl_late='style="background-color:#fff;"';
	$hl_overbrk='style="background-color:#fff;"';
	$hl_undrtme='style="background-color:#fff;"';

	$hl_hw_head='style="background-color:#fff;"';
	$hl_hw_reg='style="background-color:#fff;"';
	$hl_hw_nd='style="background-color:#fff;"';
	$hl_hw_actual='style="background-color:#fff;"';

	$regot_hl='style="background-color:#fff;"';
	$rdot_hl='style="background-color:#fff;"';
	$snw_hl='style="background-color:#fff;"';
	$reghol_hl='style="background-color:#fff;"';
	$rd_snw_hl='style="background-color:#fff;"';
	$rd_reghol_hl='style="background-color:#fff;"';
	$ot_nd='style="background-color:#fff;"';
	$atro_hl='style="background-color:#fff;"';
	$form_change_rdshift_hl='style="background-color:#fff;"';
	$form_leave_hl='style="background-color:#fff;"';
	$form_ob_hl='style="background-color:#fff;"';
	$form_tk_hl='style="background-color:#fff;"';
	$form_ut_hl='style="background-color:#fff;"';

}

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
		.dtr_center{
			text-align: center;
		}
.datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 10px/100% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 1px solid <?php echo $bg_color_genpay;?>; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, <?php echo $bg_color_genpay;?>), color-stop(1, <?php echo $overlay_genpay;?>) );background:-moz-linear-gradient( center top, <?php echo $bg_color_genpay;?> 5%, <?php echo $overlay_genpay;?> 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_genpay;?>', endColorstr='<?php echo $overlay_genpay;?>');background-color:<?php echo $bg_color_genpay;?>; color:<?php echo $font_color_genpay;?>; font-size: 15px; font-weight: bold; border-left: 1px solid #0070A8; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #00496B; border-left: 1px solid #E1EEF4;font-size: 12px;font-weight: normal; }.datagrid table tbody .alt td { background: #E1EEF4; color: #00496B; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid <?php echo $bg_color_genpay;?>;background: #E1EEF4;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: <?php echo $font_color_genpay;?>;border: 1px solid <?php echo $bg_color_genpay;?>;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, <?php echo $bg_color_genpay;?>), color-stop(1, <?php echo $overlay_genpay;?>) );background:-moz-linear-gradient( center top, <?php echo $bg_color_genpay;?> 5%, <?php echo $overlay_genpay;?> 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_genpay;?>', endColorstr='<?php echo $overlay_genpay;?>');background-color:<?php echo $bg_color_genpay;?>; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: <?php echo $bg_color_genpay;?>; color: <?php echo $font_color_genpay;?>; background: none; background-color:<?php echo $overlay_genpay;?>;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }
.datagrid{
	width: 100%;
 margin: auto;
}
/*.shift_time{
	background-color: #F9D4BD;
}
.actual_time{
	background-color: #D9F9BD;
}
.hours_worked{
	background-color: #BDF9EE;

}*/
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
	</style>    
  </head>

<?php
echo "Processing Time: ".$the_process_timer;
$wDivision=$company_info->wDivision;
$company_name=$company_info->company_name;

$pay_type=$this->input->post('pay_type');
$pay_type_group=$this->input->post('pay_type_group');
$selected_dtr_option=$this->input->post('dtr_option'); /*view: view saved dtr, process: reprocess dtr, check: absences,compensation checker*/

$pay_period=$this->input->post('pay_period');
$division=$this->input->post('division');
$department=$this->input->post('department');
$section=$this->input->post('section');

//============================================GET COMPANY TIME/DTR SETTINGS POLICY============================================
require_once(APPPATH.'views/app/time/dtr/check_dtr_policy.php');

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

$month_cover=$pay_period_info->month_cover;
$cut_off=$pay_period_info->cut_off;
//$IsLock=$pay_period_info->IsLock;
$period_no_of_days=$pay_period_info->no_of_days;

$will_early_cutoff=$pay_period_info->will_early_cutoff;
$early_cutoff_start_date=$pay_period_info->early_cutoff_start_date;


}else{

$will_early_cutoff="0";
$early_cutoff_start_date="";

} // no payroll period searched.



$tardiness_total=0;
$overbreak_total=0;
$undertime_total=0;
$absences_total=0;

$total_regular_nd=0;
$total_spec_holiday_nd=0;
$total_reg_holiday_nd=0;
$total_reg_holiday_overtime=0;
$total_reg_holiday_overtime_nd=0;
$total_spec_holiday_overtime_nd=0;

$total_spec_holiday_overtime=0;

$total_restday_nd=0;
$total_regular_hrs_restday=0;
$total_regular_hours=0;
$total_restday_overtime_nd=0;


$total_regular_overtime=0;
$total_regular_overtime_nd=0;

$total_restday_overtime=0;
$regular_holiday_total=0;
$total_regular_hrs_reg_holiday=0;
$total_regular_hrs_spec_holiday=0;

$total_restday_regular_hrs_spec_holiday=0;
$total_restday_spec_holiday_nd=0;

$total_restday_spec_holiday_overtime=0;
$total_restday_spec_holiday_overtime_nd=0;

$total_regular_hrs_reg_holiday_t2=0;

$total_regular_hrs_reg_holiday_t1=0;
$total_restday_reg_holiday_nd=0;
$total_restday_reg_holiday_overtime=0;
$total_restday_reg_holiday_overtime_nd=0;


if($selected_dtr_option=="process"){
	$dtr_processing_state=$this->time_dtr_model->check_payroll_period_dtr_state($pay_period);
	if(!empty($dtr_processing_state)){

		$to_do="";
	}else{
		$to_do="proceed_process";
	}

}else{
		$to_do="proceed_view";
}

if(!empty($employee)){
		$count_employees = 0; // count employees
		
	foreach($employee as $emp){
//============================================EMPLOYEE INFO VARIABLE LISTS============================================
		$employee_id=$emp->employee_id;
		$position=$emp->position_name;
		$name=$emp->name;
		$dept=$emp->dept_name;
		$section=$emp->section_name;
		$wSubsection=$emp->wSubsection;
		$location=$emp->location_name;
		$location_id=$emp->location_id;

		$employment=$emp->employment_name;
		$classification=$emp->classification;
		$classification_id=$emp->ei_classification_id;
		$employment_id=$emp->ei_employment_id;
		$pay_type_name=$emp->pay_type_name;

		$date_employed=$emp->date_employed;

		$mysalary_no_of_hours=$emp->no_of_hours;

//============================================ CHECK IF PAYSLIP IS ALREADY POSTED ===========================================
$the_payslip_status=$this->time_dtr_model->check_payslip_status($employee_id,$company_id,$month_cover,$pay_period);
if(!empty($the_payslip_status)){
	$payslip_status="posted";
}else{
	$payslip_status="";
}

//============================================ CHECK EMPLOYEE PAYROLL PERIOD GROUP ===========================================
$getmy_payroll_period_group=$this->time_dtr_model->spec_payroll_period_group($emp->payroll_period_group_id);
$my_group_name=$getmy_payroll_period_group->group_name;

//============================================GET SALARY RATE
$getmysalaryrate=$this->time_dtr_model->getSalary($emp->salary_rate);
$mysalaryrate=$getmysalaryrate->salary_rate_name;

//============================================ CHECK COMPANY DIVISION SETTING============================================
if($wDivision=="1"){

$getmydivision=$this->time_dtr_model->getDivision($emp->division_id);
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

$getmysubsection=$this->time_dtr_model->getSubsection($emp->section);
	$mysubsection=$getmysubsection->subsection_name;
	$subsection_status='<th>Sub-Section</th>
			<th>'.$mysubsection.'</th>';				
}else{
	$mysubsection="";
	$subsection_status='<th>&nbsp;</th>
			<th>&nbsp;</th>';
}

		$count_employees++; // count employees

//============================================ CHECK LATE GRACE PERIOD============================================
$get_late_grace_period= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,1);
if(!empty($get_late_grace_period)){
	$my_late_grace_period=$get_late_grace_period->setting_value;
}else{
	$my_late_grace_period=0;
}

//============================================ Approved undertime do not deduct to payroll ?============================================
$my_ut_deduction_policy= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,44);
if(!empty($my_ut_deduction_policy)){
	$my_ut_deduction_rule=$my_ut_deduction_policy->setting_value;
}else{
	$my_ut_deduction_rule="no"; // no setting equiavalent to do not remove ut deduction
}
//============================================ CHECK UNDER TIME GRACE PERIOD============================================
$get_ut_grace_period= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,2);
if(!empty($get_ut_grace_period)){
	$my_ut_grace_period=$get_ut_grace_period->setting_value;
}else{
	$my_ut_grace_period=0;

}
//============================================ CHECK ADVANCE OVER TIME ============================================
$get_advance_ot= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,6);
if(!empty($get_advance_ot)){
	$my_set_advance_ot=$get_advance_ot->setting_value;
}else{
	$my_set_advance_ot="no";

}

//============================================ CHECK Regular Night Differential ============================================
$get_reg_nd_setting= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,8);
if(!empty($get_reg_nd_setting)){
	$reg_nd_setting=$get_reg_nd_setting->setting_value;
}else{
	$reg_nd_setting="no";

}
//============================================ CHECK Night Differential (0.13%) ============================================
$get_none_reg_nd_setting= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,3);
if(!empty($get_none_reg_nd_setting)){
	$none_reg_nd_setting=$get_none_reg_nd_setting->setting_value;
}else{
	$none_reg_nd_setting="no";
}

															/*ND DEDUCTION SETTING*/

//============================================ CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (regular days) ============================================
$get_regular_day_nd_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,49);
if(!empty($get_regular_day_nd_break_deduction)){
	$regular_day_nd_break_deduction_setting=$get_regular_day_nd_break_deduction->setting_value;
}else{
	$regular_day_nd_break_deduction_setting="no";
}
//============================================ CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (regular holidays) ============================================
$get_reg_holiday_nd_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,50);
if(!empty($get_reg_holiday_nd_break_deduction)){
	$regular_holiday_nd_break_deduction_setting=$get_reg_holiday_nd_break_deduction->setting_value;
}else{
	$regular_holiday_nd_break_deduction_setting="no";
}
//============================================ CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (special non-working holidays) ============================================
$get_snw_holiday_nd_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,51);
if(!empty($get_snw_holiday_nd_break_deduction)){
	$snw_holiday_nd_break_deduction_setting=$get_snw_holiday_nd_break_deduction->setting_value;
}else{
	$snw_holiday_nd_break_deduction_setting="no";
}
//============================================ CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (restday) ============================================
$get_restday_nd_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,52);
if(!empty($get_restday_nd_break_deduction)){
	$restday_nd_break_deduction_setting=$get_restday_nd_break_deduction->setting_value;
}else{
	$restday_nd_break_deduction_setting="no";
}
																	/*END ND DEDUCTION SETTING*/

																	/*OT DEDUCTION SETTING*/

//============================================ CHECK 1hr BREAK DEDUCTION on OT of 9 hrs shift (regular holidays) ============================================
$get_reg_holiday_ot_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,28);
if(!empty($get_reg_holiday_ot_break_deduction)){
	$regular_holiday_ot_break_deduction_setting=$get_reg_holiday_ot_break_deduction->setting_value;
}else{
	$regular_holiday_ot_break_deduction_setting="no";
}

//============================================ CHECK 1hr BREAK DEDUCTION on OT of 9 hrs shift (special non-working holidays) ============================================
$get_snw_holiday_ot_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,54);
if(!empty($get_snw_holiday_ot_break_deduction)){
	$snw_holiday_ot_break_deduction_setting=$get_snw_holiday_ot_break_deduction->setting_value;
}else{
	$snw_holiday_ot_break_deduction_setting="no";
}

//============================================ CHECK 1hr BREAK DEDUCTION on OT of 9 hrs shift (restday) ============================================
$get_restday_ot_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,55);
if(!empty($get_restday_ot_break_deduction)){
	$restday_ot_break_deduction_setting=$get_restday_ot_break_deduction->setting_value;
}else{
	$restday_ot_break_deduction_setting="no";
}

																	/*END OT DEDUCTION SETTING*/

//============================================ CHECK Auto first 8hrs as approved OT for Regular Holidays ============================================
$get_regular_holiday_auto_ot= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,40);
if(!empty($get_regular_holiday_auto_ot)){
	$regular_holiday_auto_ot_setting=$get_regular_holiday_auto_ot->setting_value;
	if($regular_holiday_auto_ot_setting=="yes"){
		$regular_holiday_auto_ot_setting=8;
	}else{
		$regular_holiday_auto_ot_setting="";
	}
}else{
	$regular_holiday_auto_ot_setting="";
}


//============================================ CHECK Auto first 8hrs as approved OT for Special non-working Holidays ============================================
$get_snw_holiday_auto_ot= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,53);
if(!empty($get_snw_holiday_auto_ot)){
	$snw_holiday_auto_ot=$get_snw_holiday_auto_ot->setting_value;
	if($snw_holiday_auto_ot=="yes"){
		$snw_holiday_auto_ot_setting=8;
	}else{
		$snw_holiday_auto_ot_setting="";
	}
}else{
	$snw_holiday_auto_ot_setting="";
}

//============================================ CHECK Pay Rest day falling on Regular Hol. w/o attendance? ============================================
$get_restday_regular_holiday_no_att_pol= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,33);
if(!empty($get_restday_regular_holiday_no_att_pol)){
	$reg_hol_on_rd_no_att_setting=$get_restday_regular_holiday_no_att_pol->setting_value;
}else{
	$reg_hol_on_rd_no_att_setting="no";
}


//============================================ CHECK monthly salary rate - semi monthly pay type ( regular hours base )============================================
$get_monthly_semimonth_pt_reghrbase= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,59);
if(!empty($get_monthly_semimonth_pt_reghrbase)){
	$monthlyrate_semimonth_reg_hour_base=$get_monthly_semimonth_pt_reghrbase->setting_value;
}else{
	$monthlyrate_semimonth_reg_hour_base="104"; // standard
}


?>
<div class="datagrid">
<table  cellpadding="1" cellspacing="3">
	<thead>
		<tr>
			<th colspan="3"><a href="#">count <span class="badge"><?php echo $count_employees; // count employees?></span></a> </th>		
			<th width="50%"><?php echo "Salary Rate: ".$mysalaryrate."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Employed: ".$date_employed; // get salary rate?></th>	
		</tr>
	</thead>
</table>
</div>
<div class="datagrid">
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
</div>
<br>
<!-- //======================================= -->
<div class="datagrid">
<?php
if($payslip_status!="posted" OR $to_do==""){

?>
<table   cellpadding="1" cellspacing="3" class="table table-striped">
<thead>
	<tr>
		<th colspan="4" class="dtr_center">
			Date
		</th>
		<th colspan="7" class="dtr_center">
			No.Of Hours
		</th>		
		<th colspan="7" class="dtr_center">
			Overtime
		</th>
		<th colspan="6" class="dtr_center">
			Filed Forms
		</th>
	</tr>
<tr>
	<th><?php echo date("F", mktime(0, 0, 0, $month_cover, 10));?></th>
	<td>Day</td>
	<td colspan="2" <?php echo $hl_shift; ?> class="dtr_center">Shift Time
		<table   cellpadding="1" cellspacing="3">
			<tr>
				<td>IN</td>
				<td>OUT</td>
			</tr>
		</table>
	</td>
	<td colspan="2" <?php echo $hl_logs; ?> class="dtr_center">Actual Time
		<table   cellpadding="1" cellspacing="3">
			<tr>
				<td>IN</td>
				<td>OUT</td>
			</tr>
		</table>
	</td>
	<td <?php echo $hl_late; ?>>Late</td>	
	<td <?php echo $hl_overbrk; ?>>Overbreak</td>	
	<td <?php echo $hl_undrtme; ?>>Undertime</td>	
	<td colspan="2" <?php echo $hl_hw_head; ?> class="dtr_center">Hours Worked
		<table   cellpadding="1" cellspacing="3" style="table-layout:fixed;width:150px;">
			<tr>
				<td <?php echo $hl_hw_reg; ?> >REG</td>
				<td <?php echo $hl_hw_nd; ?> >ND</td>
				<?php 
				if($show_actual_hour=="yes"){
					echo '<td '.$hl_hw_actual.'>ACT</td>';
				
				}else{
		
				}
				?>
			</tr>
		</table>
	</td>
	<td>Regular</td>	
	<td>Restday</td>	
	<td colspan="2" class="dtr_center">Holiday
		<table   cellpadding="1" cellspacing="3">
			<tr>
				<td>Special</td>
				<td>Regular</td>
			</tr>
		</table>
	</td>	
	<td colspan="2" class="dtr_center">Restday
		<table   cellpadding="1" cellspacing="3">
			<tr>
				<td>Special</td>
				<td>Regular</td>
			</tr>
		</table>
	</td>	
	<td>ND</td>	
	<td>ATRO</td>	
	<td>Change Sched/Restday</td>	
	<td>Leave</td>			
	<td>Official Business</td>				
	<td>Timekeeping Complaint</td>			
	<td>Undertime</td>				
</tr>	
</thead>
<?php
}else{

}
?>

<tbody>
<?php
	$p_from = $pay_period_from; 	// Start payroll period
	$p_to = $pay_period_to; 	// ENd payroll period

	/*variable initialization of time summary*/
	$tardiness_occurence=0;
	$overbreak_occurence=0;
	$undertime_occurence=0;
	$absences_occurence=0;

	$complete_logs_present_occ=0;
	$complete_logs_present_occ_ref="";

	$with_tk_logs_present_occ=0;
	$with_tk_logs_present_occ_ref="";

	$with_ob_logs_present_occ=0;
	$with_ob_logs_present_occ_ref="";

	$with_leave_present_occ=0;
	$with_leave_present_occ_ref="";

	$restday_w_logs=0;
	$restday_w_logs_ref="";
	$restday_wo_logs=0;
	$restday_wo_logs_ref="";

	$reg_holiday_w_logs=0;
	$reg_holiday_w_logs_ref="";
	$reg_holiday_wo_logs=0;
	$reg_holiday_wo_logs_ref="";
	$rd_reg_holiday_w_logs=0;
	$rd_reg_holiday_w_logs_ref="";
	$rd_reg_holiday_wo_logs=0;
	$rd_reg_holiday_wo_logs_ref="";

	$snw_holiday_w_logs=0;
	$snw_holiday_w_logs_ref="";
	$snw_holiday_wo_logs=0;
	$snw_holiday_wo_logs_ref="";
	$rd_snw_holiday_w_logs=0;
	$rd_snw_holiday_w_logs_ref="";
	$rd_snw_holiday_wo_logs=0;
	$rd_snw_holiday_wo_logs_ref="";

//============================================ start CHECK EARLY CUTOFF SETTING IF ANY FOR THE PREVIOUS CUTOFF.
	$check_prev_early_cutoff_dates= $this->time_dtr_model->check_prev_early_cutoff_dates($pay_period,$p_from);
	if(!empty($check_prev_early_cutoff_dates)){

		$withearlycutoff_payroll_period_id=$check_prev_early_cutoff_dates->payroll_period_id;

		$prev_early_cutoff_date= $this->time_dtr_model->PrevEarlyCutoffStartDate($withearlycutoff_payroll_period_id);
		$p_from=$prev_early_cutoff_date->date_covered;

	}else{
		$withearlycutoff_payroll_period_id="";

	}
//============================================ end CHECK EARLY CUTOFF SETTING IF ANY FOR THE PREVIOUS CUTOFF.
if(($selected_dtr_option=="process")AND ($to_do=="proceed_process")AND($payslip_status!="posted")){


	while (strtotime($p_from) <= strtotime($p_to)) {

//============================================ start CHECK EARLY CUTOFF SETTING IF ANY FOR THE PREVIOUS CUTOFF.                 

require(APPPATH.'views/app/time/dtr/check_auto_early_cutoff.php');

//============================================ end CHECK EARLY CUTOFF SETTING IF ANY FOR THE PREVIOUS CUTOFF.



  	$two_digit_day=substr($p_from, -2, 2)."<br>";
	$dayOfWeek = date("l", strtotime($p_from));

	if($dayOfWeek=="Sunday"){
		$sunday_color='style="background-color:'.$hl_sunday.';"';
	}else{
		$sunday_color='';
	}


//============================================ CHECK EARLY CUTOFF SETTING IF ANY FOR THE CURRENT CUTOFF.
if($will_early_cutoff=="1"){
	$check_early_cutoff_setup= $this->time_dtr_model->check_early_cutoff_setup($pay_period,$p_from);
	if(!empty($check_early_cutoff_setup)){
		$marked_as_early_cutoff_coverage="yes";
	}else{	
		$marked_as_early_cutoff_coverage="no";
	}
}else{
		$marked_as_early_cutoff_coverage="no";
}



//============================================ CHECK WORKING SCHEDULE - CHANGE RESTDAY============================================
$get_change_restday= $this->time_dtr_model->get_change_restday($emp->employee_id,$p_from);
if(!empty($get_change_restday)){

	if($p_from==$get_change_restday->date_from){
		$change_restday_form= '<a href="'.base_url().'app/transaction_employees/form_view/'.$get_change_restday->doc_no.'/emp_change_rest_day/HR027" target="_blank" title="'.$get_change_restday->doc_no.'">change restday from</a>';
	}else{
		$change_restday_form= '<a href="'.base_url().'app/transaction_employees/form_view/'.$get_change_restday->doc_no.'/emp_change_rest_day/HR027" target="_blank" title="'.$get_change_restday->doc_no.'">change restday to</a>';
	}
	
	$old_restday=$get_change_restday->date_from;
	$new_restday=$get_change_restday->date_to;
	$change_restday_doc_no=$get_change_restday->doc_no;
}else{
	$change_restday_form="";
	$old_restday="";
	$new_restday="";
	$change_restday_doc_no="";
}


//============================================ CHECK WORKING SCHEDULE - FIXED SCHED============================================
$get_fixed_schedule= $this->time_dtr_model->get_fixed_schedule($company_id,$emp->employee_id);
if(!empty($get_fixed_schedule)){
$flexi_shift_in="none";
$flexi_shift_out="none";

		$fixed_sched_mon=$get_fixed_schedule->mon;
		$fixed_sched_tue=$get_fixed_schedule->tue;
		$fixed_sched_wed=$get_fixed_schedule->wed;
		$fixed_sched_thu=$get_fixed_schedule->thu;
		$fixed_sched_fri=$get_fixed_schedule->fri;
		$fixed_sched_sat=$get_fixed_schedule->sat;
		$fixed_sched_sun=$get_fixed_schedule->sun;
if($dayOfWeek=="Monday"){
	if($fixed_sched_mon=="restday"){
		$fixed_shift_in="--";
		$fixed_shift_out="--";
		$is_rest_day="yes";
	}else{
		$fixed_shift_in=substr($fixed_sched_mon, 0, -9);
		$fixed_shift_out=substr($fixed_sched_mon, 9, 5);
		$is_rest_day="no";
	}
//check change of restday
require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_fixed.php');
//end check change of restday 

}elseif($dayOfWeek=="Tuesday"){
	if($fixed_sched_tue=="restday"){
		$fixed_shift_in="--";
		$fixed_shift_out="--";
		$is_rest_day="yes";
	}else{
		$fixed_shift_in=substr($fixed_sched_tue, 0, -9);
		$fixed_shift_out=substr($fixed_sched_tue, 9, 5);
		$is_rest_day="no";
	}
//check change of restday
require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_fixed.php');
//end check change of restday 	
}elseif($dayOfWeek=="Wednesday"){
	if($fixed_sched_wed=="restday"){
		$fixed_shift_in="--";
		$fixed_shift_out="--";
		$is_rest_day="yes";
	}else{
		$fixed_shift_in=substr($fixed_sched_wed, 0, -9);
		$fixed_shift_out=substr($fixed_sched_wed, 9, 5);
		$is_rest_day="no";
	}
//check change of restday
require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_fixed.php');
//end check change of restday 
}elseif($dayOfWeek=="Thursday"){
	if($fixed_sched_thu=="restday"){
		$fixed_shift_in="--";
		$fixed_shift_out="--";
		$is_rest_day="yes";
	}else{
		$fixed_shift_in=substr($fixed_sched_thu, 0, -9);
		$fixed_shift_out=substr($fixed_sched_thu, 9, 5);
		$is_rest_day="no";
	}
//check change of restday
require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_fixed.php');
//end check change of restday 	
}elseif($dayOfWeek=="Friday"){
	if($fixed_sched_fri=="restday"){
		$fixed_shift_in="--";
		$fixed_shift_out="--";
		$is_rest_day="yes";
	}else{
		$fixed_shift_in=substr($fixed_sched_fri, 0, -9);
		$fixed_shift_out=substr($fixed_sched_fri, 9, 5);
		$is_rest_day="no";
	}
//check change of restday
require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_fixed.php');
//end check change of restday 
}elseif($dayOfWeek=="Saturday"){
	if($fixed_sched_sat=="restday"){
		$fixed_shift_in="";
		$fixed_shift_out="";
		$is_rest_day="yes";
	}else{
		$fixed_shift_in=substr($fixed_sched_sat, 0, -9);
		$fixed_shift_out=substr($fixed_sched_sat, 9, 5);
		$is_rest_day="no";
	}
//check change of restday
require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_fixed.php');
//end check change of restday 
}elseif($dayOfWeek=="Sunday"){
	if($fixed_sched_sun=="restday"){

		$is_rest_day="yes";
		$fixed_shift_in="";
		$fixed_shift_out="";

	}else{
		$fixed_shift_in=substr($fixed_sched_sun, 0, -9);
		$fixed_shift_out=substr($fixed_sched_sun, 9, 5);
		$is_rest_day="no";
	}
//check change of restday
require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_fixed.php');
//end check change of restday 

}else{
	$fixed_shift_in="none";
	$fixed_shift_out="none";
	$is_rest_day="no";
}
	$check_fixed_schedule="fixed schedule : $p_from YES";
	$check_flexi_schedule="Flexi schedule : $p_from NO";
// fixed schedule: rest day checker
//echo $p_from.$is_rest_day."<br>";

}

else{//start of not fixed schedule 


//============================================ CHECK WORKING SCHEDULE - FLEXI SCHED============================================
$get_flexi_sched= $this->time_dtr_model->get_flexi_sched($company_id,$emp->employee_id);
if(!empty($get_flexi_sched)){

		$flexi_group_name=$get_flexi_sched->group_name;
		$flexi_group_type=$get_flexi_sched->group_type;
		$flexi_controlled_time_limit=$get_flexi_sched->controlled_time_limit;
		$flexi_standard_shift_in=$get_flexi_sched->standard_shift_in;
		$flexi_standard_shift_out=$get_flexi_sched->standard_shift_out;

		$flexi_mon=$get_flexi_sched->mon;
		$flexi_tue=$get_flexi_sched->tue;
		$flexi_wed=$get_flexi_sched->wed;
		$flexi_thu=$get_flexi_sched->thu;
		$flexi_fri=$get_flexi_sched->fri;
		$flexi_sat=$get_flexi_sched->sat;
		$flexi_sun=$get_flexi_sched->sun;

if($dayOfWeek=="Monday"){
	if($flexi_mon=="restday"){
		$flexi_shift_in="--";
		$flexi_shift_out="--";
		$is_rest_day="yes";
	}else{
		$flexi_shift_in=$flexi_standard_shift_in;
		$flexi_shift_out=$flexi_standard_shift_out;
		$is_rest_day="no";
	}
	//check change of restday
	require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_flexi.php');
	//end check change of restday 		
}elseif($dayOfWeek=="Tuesday"){
	if($flexi_tue=="restday"){
		$flexi_shift_in="--";
		$flexi_shift_out="--";
		$is_rest_day="yes";
	}else{
		$flexi_shift_in=$flexi_standard_shift_in;
		$flexi_shift_out=$flexi_standard_shift_out;
		$is_rest_day="no";
	}
	//check change of restday
	require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_flexi.php');
	//end check change of restday 		
}elseif($dayOfWeek=="Wednesday"){
	if($flexi_wed=="restday"){
		$flexi_shift_in="--";
		$flexi_shift_out="--";
		$is_rest_day="yes";
	}else{
		$flexi_shift_in=$flexi_standard_shift_in;
		$flexi_shift_out=$flexi_standard_shift_out;
		$is_rest_day="no";
	}
	//check change of restday
	require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_flexi.php');
	//end check change of restday 		
}elseif($dayOfWeek=="Thursday"){
	if($flexi_thu=="restday"){
		$flexi_shift_in="--";
		$flexi_shift_out="--";
		$is_rest_day="yes";
	}else{
		$flexi_shift_in=$flexi_standard_shift_in;
		$flexi_shift_out=$flexi_standard_shift_out;
		$is_rest_day="no";
	}
	//check change of restday
	require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_flexi.php');
	//end check change of restday 		
}elseif($dayOfWeek=="Friday"){
	if($flexi_fri=="restday"){
		$flexi_shift_in="--";
		$flexi_shift_out="--";
		$is_rest_day="yes";
	}else{
		$flexi_shift_in=$flexi_standard_shift_in;
		$flexi_shift_out=$flexi_standard_shift_out;
		$is_rest_day="no";
	}
	//check change of restday
	require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_flexi.php');
	//end check change of restday 	
}elseif($dayOfWeek=="Saturday"){
	if($flexi_sat=="restday"){
		$flexi_shift_in="--";
		$flexi_shift_out="--";
		$is_rest_day="yes";
	}else{
		$flexi_shift_in=$flexi_standard_shift_in;
		$flexi_shift_out=$flexi_standard_shift_out;
		$is_rest_day="no";
	}
	//check change of restday
	require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_flexi.php');
	//end check change of restday 
}else{ // Sunday
	if($flexi_sun=="restday"){
		$flexi_shift_in="--";
		$flexi_shift_out="--";
		$is_rest_day="yes";
	}else{
		$flexi_shift_in=$flexi_standard_shift_in;
		$flexi_shift_out=$flexi_standard_shift_out;
		$is_rest_day="no";
	}
	//check change of restday
	require(APPPATH.'views/app/time/dtr/check_change_of_restday_for_flexi.php');
	//end check change of restday 		
}

$check_flexi_schedule="Flexi schedule : $p_from YES $is_rest_day<br>";

$fixed_shift_in="none";
$fixed_shift_out="none";

}else{

$flexi_shift_in="none";
$flexi_shift_out="none";

$fixed_shift_in="none";
$fixed_shift_out="none";
$is_rest_day="no";

$check_flexi_schedule="Flexi schedule : $p_from NO";
$check_fixed_schedule="fixed schedule : $p_from NO";	

		//============================================ CHECK WORKING SCHEDULE - INDIVIDUAL PLOTTED============================================
		$get_frm_working_sched_tble= $this->time_dtr_model->get_frm_working_sched_tble($company_id,$emp->employee_id,$p_from);
		if(!empty($get_frm_working_sched_tble)){//start of check sched in working_sched table

			if($get_frm_working_sched_tble->restday=="1"){
					if($p_from==$old_restday){					
						$new_restday_date_sched= $this->time_dtr_model->get_frm_working_sched_tble($company_id,$emp->employee_id,$new_restday);	// get new restday "date" plotted sched			
						$ws_shift_in=$new_restday_date_sched->shift_in;
						$ws_shift_out=$new_restday_date_sched->shift_out;
						$is_rest_day="no";
					}else{
						$ws_shift_in=$get_frm_working_sched_tble->shift_in;
						$ws_shift_out=$get_frm_working_sched_tble->shift_out;
						$is_rest_day="yes";
					}
			}else{
				if($p_from==$new_restday){
						$ws_shift_in=""; // suppose none
						$ws_shift_out=""; // suppose none
						$is_rest_day="yes";
					}else{
						$ws_shift_in=$get_frm_working_sched_tble->shift_in;
						$ws_shift_out=$get_frm_working_sched_tble->shift_out;	
						$is_rest_day="no";						
					}
		
			}

			$check_ws_schedule="wS : $p_from YES";

		}else{
			$ws_shift_in="";
			$ws_shift_out="";

			$is_rest_day="no";
			$check_ws_schedule="wS : $p_from NO";	
		}//end of check sched in working_sched table
	} // end of not flexi schedule
}// end of not fixed schedule

//============================================ CHECK WORKING SCHEDULE - CHANGE SCHEDULE============================================
$get_change_sched= $this->time_dtr_model->get_change_sched($emp->employee_id,$p_from);
if(!empty($get_change_sched)){
	$change_sched_form= '<a href="'.base_url().'app/transaction_employees/form_view/'.$get_change_sched->doc_no.'/emp_change_sched/HR003" target="_blank">change sched</a>';
	$requested_shift=$get_change_sched->time_to;
	$cs="yes";
		$cs_shift_in=substr($requested_shift, 0, -9);
		$cs_shift_out=substr($requested_shift, 9, 5);	
	$change_sched_doc_no=$get_change_sched->doc_no;
}else{
		$change_sched_form="";
		$cs_shift_in="";
		$cs_shift_out="";
	$cs="no";
	$change_sched_doc_no="";
}

//============================================GET OFFICIAL SHIFTS ============================================
if(($fixed_shift_in=="none") && ($flexi_shift_in=="none")){// fixed sched = false , flexi sched = false , ws tables = true
	if($cs=="yes"){
		$shift_in=$cs_shift_in;
		$shift_out=$cs_shift_out;
	}else{
		$shift_in=$ws_shift_in;
		$shift_out=$ws_shift_out;
	}

	if($is_rest_day=="yes"){
		$restday_official="<i class='fa fa-check'></i>";
	}else{
		$restday_official="";
	}
}elseif(($flexi_shift_in!="none") && ($fixed_shift_in=="none")){ // ws tables = false , fixed sched = false ,flexi sched = true 
		
	if($cs=="yes"){
		$shift_in=$cs_shift_in;
		$shift_out=$cs_shift_out;
	}else{
		$shift_in=$flexi_shift_in;
		$shift_out=$flexi_shift_out;
	}
	if($is_rest_day=="yes"){
		$restday_official="<i class='fa fa-check'></i>";
	}else{
		$restday_official="";
	}	

}else{ //check fixed sched tables  // ws tables = false , flexi sched = false ,fixed sched = true 
	if($cs=="yes"){
		$shift_in=$cs_shift_in;
		$shift_out=$cs_shift_out;
	}else{
		$shift_in=$fixed_shift_in;
		$shift_out=$fixed_shift_out;
	}

	if($is_rest_day=="yes"){
		$restday_official="<i class='fa fa-check'></i>";
	}else{
		$restday_official="";		
	}	
}



//============================================SCHEDULE ROOT DEBUGGER ============================================
$check_fixed_schedule;
$check_ws_schedule;
$check_flexi_schedule;

//============================================GET HOLIDAYS
$get_holiday=$this->time_dtr_model->get_location_holiday($emp->location_id,$p_from);
if(!empty($get_holiday)){
	$holiday_name=$get_holiday->holiday;
	$holiday_type=$get_holiday->holiday_type;
	//RH : holiday type means regular holiday

	if(($holiday_type=="RH")AND ($is_rest_day=="no")){
			$regular_holiday_official="<i class='fa fa-check'></i>";
			$restday_regular_holiday_official="";
			$special_holiday_official="";
			$restday_special_holiday_official="";

	}elseif(($holiday_type=="RH")AND ($is_rest_day=="yes")){
			$regular_holiday_official="";
			$restday_regular_holiday_official="<i class='fa fa-check'></i>";
			$special_holiday_official="";
			$restday_special_holiday_official="";


	}elseif(($holiday_type!="RH")AND ($is_rest_day=="no")){
			$regular_holiday_official="";
			$restday_regular_holiday_official="";
			$special_holiday_official="<i class='fa fa-check'></i>";
			$restday_special_holiday_official="";
	}else{
			$regular_holiday_official="";
			$restday_regular_holiday_official="";	
			$special_holiday_official="";	
			$restday_special_holiday_official="<i class='fa fa-check'></i>";		
	}

	$isholiday="yes";

}else{
	$isholiday="no";
	$holiday_type="";
	$holiday_name="";

	$regular_holiday_official="";
	$special_holiday_official="";
	$restday_regular_holiday_official="";
	$restday_special_holiday_official="";
}




//============================================ CHECK TIME KEEPING COMPLAINT FORM============================================
$get_tkcomplaint= $this->time_dtr_model->get_tkcomplaint($emp->employee_id,$p_from);

if(!empty($get_tkcomplaint)){
		$tk_in=$get_tkcomplaint->tk_date;
	
	$time_keeping_complaint_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$get_tkcomplaint->doc_no.'/emp_time_complaint/HR025" target="_blank" title="'.$get_tkcomplaint->doc_no.'">tk complaint</a>';
	$time_keeping_complaint_status="yes";// check if with tk complaint
	$tk_actual_in=$get_tkcomplaint->time_in;
	$tk_actual_out=$get_tkcomplaint->time_out;
	$time_keeping_complaint_doc_no=$get_tkcomplaint->doc_no;
}else{
	$time_keeping_complaint_status="none";// check if with tk complaint			
	$time_keeping_complaint_form="";
	$tk_actual_in="";	
	$tk_actual_out="";	
	$time_keeping_complaint_doc_no="";
}

//============================================ CHECK OFFICICAL BUSINESS FORM============================================
$get_official_business= $this->time_dtr_model->get_official_business($emp->employee_id,$p_from);

if(!empty($get_official_business)){
	$count_filed_ob=count($get_official_business);
	$multiple_ob_time_raw="";
	$multiple_ob_form_raw="";
	$multiple_ob_form_details="";
	foreach($get_official_business as $get_official_business){

		$ob_date=$get_official_business->the_date;

		$official_business_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$get_official_business->doc_no.'/emp_official_business/HR015" target="_blank" title="'.$get_official_business->doc_no.'">Official Business</a>';
		$official_business_status="yes";// check if with ob
		$ob_actual_in=$get_official_business->from_time;
		$ob_actual_out=$get_official_business->to_time;
		$official_business_doc_no=$get_official_business->doc_no;
		$multiple_ob_form_raw.=$official_business_form." ";
		
		$multiple_ob_form_details.=$official_business_doc_no."/";

		if($count_filed_ob>1){
				$multiple_ob_time_raw.=$ob_actual_in."-".$ob_actual_out."/";
				
		}else{

		}

	}
	//============== case two OB in one day

	if($count_filed_ob>1){
					$multiple_ob_form_digit = 50;
					$ob_arr= explode("/", wordwrap($multiple_ob_time_raw, $multiple_ob_form_digit));
					list($first_ob_in,$first_ob_out) = explode("-",$ob_arr[0]);
					list($second_ob_in,$second_ob_out) = explode("-",$ob_arr[1]);


		$check_first_ob_in=$shift_in-$first_ob_in;
		$check_second_ob_in=$shift_in-$second_ob_in;

		$check_first_ob_out=abs($shift_out-$first_ob_out);
		$check_second_ob_out=abs($shift_out-$second_ob_out);

		if($check_first_ob_in<$check_second_ob_in){
			$ob_actual_in=$first_ob_in;
		}else{
			$ob_actual_in=$second_ob_in;
		}	

		if($check_first_ob_out<$check_second_ob_out){
			$ob_actual_out=$first_ob_out;
		}else{
			$ob_actual_out=$second_ob_out;
		}	

	}else{
		$first_ob_in="";
		$second_ob_in="";
		$first_ob_out="";
		$second_ob_out="";
	}


	
}else{

	$official_business_status="none";// check if with ob			
	$official_business_form="";
	$ob_actual_in="";	
	$ob_actual_out="";	
	$official_business_doc_no="";

	$multiple_ob_time_raw="";
	$multiple_ob_form_raw="";
	$multiple_ob_form_details="";
}


//============================================ CHECK LEAVE APPLICATION FORM ============================================
//====== pending
$get_pending_leave_form= $this->time_dtr_model->get_pending_leave_form($emp->employee_id,$p_from);
$count_filed_pending_leave=count($get_pending_leave_form);
$pending_leave="";
if(!empty($get_pending_leave_form)){

	foreach($get_pending_leave_form as $leave_pending){
		$leave_pending_type=$leave_pending->leave_type;
		$leave_pending_no_of_days=$leave_pending->no_of_days;
		$leave_pending_doc_no=$leave_pending->doc_no;
		$pending_leave.='<a href="'.base_url().'app/transaction_employees/form_view/'.$leave_pending_doc_no.'/employee_leave/HR002" target="_blank" title="'.$leave_pending_doc_no.' : pending ('.$leave_pending_no_of_days.')"><span style="color:#ccc;"> '.$leave_pending_type.'</span></a><br>';
	}

}else{
$pending_leave="";
}

//====== approved
$get_leave_form= $this->time_dtr_model->get_leave_form($emp->employee_id,$p_from);
$count_filed_leave=count($get_leave_form);

if(!empty($get_leave_form)){

	$multiple_leave_state="";
	$multiple_leave_application_form="";
	$multiple_leave_application_details="";
	foreach($get_leave_form as $get_leave_form){

		$leave_type=$get_leave_form->leave_type;
		$leave_day_type=$get_leave_form->no_of_days;
		$leave_pay_type=$get_leave_form->with_pay;


		if($leave_pay_type=="1") {// with pay
			if($leave_day_type=="0.5") {
				$leave_day_type_status="halfday";
							$halfleave=" (halfday)";
			}elseif($leave_day_type=="1") {
				$leave_day_type_status="wholeday";
							$halfleave="";
			}else{
				$leave_day_type_status=$leave_day_type;
							$halfleave="";
			}

			$leave_color_pay_type="";
			$leave_pay_type="with pay";
		}else{// without pay
			if($leave_day_type=="0.5") {
				$leave_day_type_status="halfday";
							$halfleave=" (halfday)";
			}else{
				$leave_day_type_status="wholeday";
							$halfleave="";
			}
			$leave_color_pay_type='class="text-danger"';
			$leave_pay_type="without pay";		
		}

		$leave_application_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$get_leave_form->doc_no.'/employee_leave/HR002" target="_blank" title="'.$leave_pay_type.'" '.$leave_color_pay_type.'> '.$leave_type.$halfleave.' </a>';
		$leave_application_status="yes";// check if with leave
		$leave_application_doc_no=$get_leave_form->doc_no;
		$leave_application_details=$leave_application_doc_no."/$leave_type/$leave_pay_type/$leave_color_pay_type/$halfleave*";

		if($count_filed_leave=="1"){
			$multiple_leave_application_form=$leave_application_form;
			$multiple_leave_application_details=$leave_application_details;
		}else{

			$multiple_leave_state.=$leave_pay_type;
			$multiple_leave_application_form.=$leave_application_form;
			$multiple_leave_application_details.=$leave_application_details;

		}
	}

	if($multiple_leave_state=="with paywithout pay" OR $multiple_leave_state=="without paywith pay"){
		$leave_pay_type="with pay";
		$leave_day_type=0.5;
		$leave_day_type_status="halfday";

	}else{

	}

	if($leave_pay_type=="with pay"){
		$leave_fast_hol_reference=$leave_day_type;

		$with_leave_present_occ++;
		$with_leave_present_occ_ref.=$p_from." ";

	}else{
		$leave_fast_hol_reference="";
	}


	
}else{
	$multiple_leave_application_details="";
	$multiple_leave_application_form="";
	$multiple_leave_state="";
	$leave_application_status="none";// check if with leave			
	$leave_application_form="";
	$leave_day_type_status="";
	$leave_pay_type="";
	$leave_day_type="";
	$leave_application_doc_no="";
	$leave_fast_hol_reference="";
}

//============================================ CHECK ATTENDANCE TABLES LOGS============================================
$get_attendance= $this->time_dtr_model->get_attendance($emp->employee_id,$p_from,$shift_in,$shift_out);
if(!empty($get_attendance)){
	$attendance_table_status="yes";// check if with attendance logs
	$att_time_in=$get_attendance->time_in;
	$att_time_out=$get_attendance->time_out;

	$att_break_1_out=$get_attendance->break_1_out;
	$att_break_1_in=$get_attendance->break_1_in;
	$att_lunch_break_out=$get_attendance->lunch_break_out;
	$att_lunch_break_in=$get_attendance->lunch_break_in;	
	$att_break_2_out=$get_attendance->break_2_out;
	$att_break_2_in=$get_attendance->break_2_in;

	$check_att_date_in=$get_attendance->time_in_date;
	$check_att_date_out=$get_attendance->time_out_date;

	$att_date_in='<a href="#" title="'.$get_attendance->time_in_date.'">&nbsp;&nbsp;</a>';
	$att_date_out='<a href="#" title="'.$get_attendance->time_out_date.'">&nbsp;&nbsp;</a>';

}else{
	$check_att_date_in="";
	$check_att_date_out="";
	$attendance_table_status="none";// check if with attendance logs	
	$att_time_in="";
	$att_time_out="";

	$att_break_1_out="";
	$att_break_1_in="";
	$att_lunch_break_out="";
	$att_lunch_break_in="";
	$att_break_2_out="";
	$att_break_2_in="";

	$att_date_in='<a href="#" title="'.$p_from.'">&nbsp;&nbsp;</a>';
	$att_date_out="";
}





//============================================ CHECK COMPUTE BREAK POLICY============================================
$get_compute_overbreak_policy= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,43);
if(!empty($get_compute_overbreak_policy)){
	$compute_break_rule=$get_compute_overbreak_policy->setting_value;
	if($compute_break_rule=="yes"){

//============================================ CHECK BREAK SETUP OF SHIFTS============================================
		$get_break_policy= $this->time_dtr_model->get_break_policy($classification_id,$company_id,$shift_in,$shift_out);
		if(!empty($get_break_policy)){
			$lunch_break_allowed_hour=$get_break_policy->lunch_break;
			$break_1_allowed_hour=$get_break_policy->break_1;
			$break_2_allowed_hour=$get_break_policy->break_2;
			// break 1
				if($att_break_1_out!=""){
					$p_att_break_1_out    = new DateTime($p_from.$att_break_1_out.':00');
					$p_att_break_1_in   = new DateTime($p_from.$att_break_1_in.':00');
					$break_1 = $p_att_break_1_in->diff($p_att_break_1_out);
					$break_1_hour=$break_1->format('%H:%i:%s');

					$time=$break_1_hour;
				    $timesplit=explode(':',$time);
				    $break_1_min=($timesplit[0]*60)+($timesplit[1])+($timesplit[2]>30?1:0);
					//echo "$break_1_min>$break_1_allowed_hour <br>";
					if($break_1_min>$break_1_allowed_hour){
						$raw_over_break=$break_1_min-$break_1_allowed_hour;
						$raw_over_break=$raw_over_break/60;
						if($decimal_place_rounding_setting=="yes"){
							// round off
							$break_1_over_break=round($raw_over_break, $decimal_place_no_setting);
						}else{
							// cut only
							$break_1_over_break=bcdiv($raw_over_break, 1, $decimal_place_no_setting); 
						}
					}else{
						$break_1_over_break="";
					}
				}else{
					$break_1_over_break="";
				}	

			// lunch break
				if($att_lunch_break_out!=""){
					$p_att_lunch_break_out    = new DateTime($p_from.$att_lunch_break_out.':00');
					$p_att_lunch_break_in   = new DateTime($p_from.$att_lunch_break_in.':00');
					$lunch_break = $p_att_lunch_break_in->diff($p_att_lunch_break_out);
					$lunch_break_hour=$lunch_break->format('%H:%i:%s');

					$time=$lunch_break_hour;
				    $timesplit=explode(':',$time);
				    $lunch_break_min=($timesplit[0]*60)+($timesplit[1])+($timesplit[2]>30?1:0);
					//echo "$lunch_break_min VS $lunch_break_allowed_hour <br>";
					if($lunch_break_min>$lunch_break_allowed_hour){
						$raw_over_break=$lunch_break_min-$lunch_break_allowed_hour;
						$raw_over_break=$raw_over_break/60;
						// $lunch_break_over_break=round($raw_over_break, 2);
						if($decimal_place_rounding_setting=="yes"){
							// round off
							$lunch_break_over_break=round($raw_over_break, $decimal_place_no_setting);
						}else{
							// cut only
							$lunch_break_over_break=bcdiv($raw_over_break, 1, $decimal_place_no_setting); 
						}


					}else{
						$lunch_break_over_break="";
					}

				}else{
					$lunch_break_over_break="";
				}	

			// break 2
				if($att_break_2_out!=""){
					$att_break_2_out    = new DateTime($p_from.$att_break_2_out.':00');
					$att_break_2_in   = new DateTime($p_from.$att_break_2_in.':00');
					$break_2 = $att_break_2_in->diff($att_break_2_out);
					$break_2_hour=$break_2->format('%H:%i:%s');
					$time=$break_2_hour;
				    $timesplit=explode(':',$time);
				    $break_2_min=($timesplit[0]*60)+($timesplit[1])+($timesplit[2]>30?1:0);
					//echo "$break_2_min>$break_1_allowed_hour <br>";
					if($break_2_min>$break_2_allowed_hour){
						$raw_over_break=$break_2_min-$break_2_allowed_hour;
						$raw_over_break=$raw_over_break/60;
						// $break_2_over_break=round($raw_over_break, 2);
						if($decimal_place_rounding_setting=="yes"){
							// round off
							$break_2_over_break=round($raw_over_break, $decimal_place_no_setting);
						}else{
							// cut only
							$break_2_over_break=bcdiv($raw_over_break, 1, $decimal_place_no_setting); 
						}						
					}else{
						$break_2_over_break="";
					}					
				}else{
					$break_2_over_break="";
				}	

		}else{
			$lunch_break_over_break="";
			$break_1_over_break="";
			$break_2_over_break="";
		}


	}else{// will not compute or no setup yet
			$lunch_break_over_break="";
			$break_1_over_break="";
			$break_2_over_break="";		
	}

}else{ // no setup yet
			$lunch_break_over_break="";
			$break_1_over_break="";
			$break_2_over_break="";	
}

$over_break=$break_1_over_break+$lunch_break_over_break+$break_2_over_break;
if($over_break=="0"){
	$over_break="";
}else{
	$over_break=$over_break;
}



//============================================GET OFFICIAL IN & OUT ============================================
if(($time_keeping_complaint_status=="none")&&($official_business_status=="yes")&&($attendance_table_status=="none")) { // att tables = false ,tk = false, ob = true

	$actual_in=$ob_actual_in;
	$actual_out=$ob_actual_out;

	if($flexi_shift_in!="none"){ // flexi true
		//check flexi setup ( to replot shift )
		require(APPPATH.'views/app/time/dtr/check_flexi.php');
		//end check flexi setup ( to replot shift )
	}else{}


$obnext_day_out = new DateTime($p_from);
$obnext_day_out->modify('+1 day');
$obnext_day_out=$obnext_day_out->format('Y-m-d');

$trimmed_in=substr($actual_in, 0,2);
$trimmed_out=substr($actual_out, 0,2);

if($trimmed_in=="00"){
$trimmed_in="24";
}else{

}
if($trimmed_in>$trimmed_out){
		$check_att_date_out = new DateTime($p_from);
		$check_att_date_out->modify('+1 day');
		$check_att_date_out=$check_att_date_out->format('Y-m-d');	
		$check_att_date_out=$check_att_date_out;
		$check_att_date_in=$p_from;
}else{
		$check_att_date_out=$p_from;
		$check_att_date_in=$p_from;
}


// if(($trimmed_in<=23) AND ($trimmed_in>=15)){
// 	$check_att_date_in=$p_from;
// 	$check_att_date_out=$obnext_day_out; 
// }else{
// 	$check_att_date_in=$p_from;
// 	$check_att_date_out=$p_from; 
// }


}elseif(($time_keeping_complaint_status=="yes")&&($official_business_status=="none")&&($attendance_table_status=="none")) { // att tables = true , ob = false
	$actual_in=$tk_actual_in;
	$actual_out=$tk_actual_out;

	if($flexi_shift_in!="none"){ // flexi true
		//check flexi setup ( to replot shift )
		require(APPPATH.'views/app/time/dtr/check_flexi.php');
		//end check flexi setup ( to replot shift )
	}else{}

$trimmed_in=substr($actual_in, 0,2);
$trimmed_out=substr($actual_out, 0,2);
if($trimmed_in=="00"){
$trimmed_in="24";
}else{

}
if($trimmed_in>$trimmed_out){
		$check_att_date_out = new DateTime($p_from);
		$check_att_date_out->modify('+1 day');
		$check_att_date_out=$check_att_date_out->format('Y-m-d');	
		$check_att_date_out=$check_att_date_out;
		$check_att_date_in=$p_from;
}else{
		$check_att_date_out=$p_from;
		$check_att_date_in=$p_from;
}


}elseif(($time_keeping_complaint_status=="yes")&&($official_business_status=="none")&&($attendance_table_status=="yes")) { // att tables = true , ob = false
	$actual_in=$tk_actual_in;
	$actual_out=$tk_actual_out;

	if($flexi_shift_in!="none"){ // flexi true
		//check flexi setup ( to replot shift )
		require(APPPATH.'views/app/time/dtr/check_flexi.php');
		//end check flexi setup ( to replot shift )
	}else{}

$trimmed_in=substr($actual_in, 0,2);
$trimmed_out=substr($actual_out, 0,2);
if($trimmed_in=="00"){
$trimmed_in="24";
}else{

}
if($trimmed_in>$trimmed_out){
		$check_att_date_out = new DateTime($p_from);
		$check_att_date_out->modify('+1 day');
		$check_att_date_out=$check_att_date_out->format('Y-m-d');	
		$check_att_date_out=$check_att_date_out;
		$check_att_date_in=$p_from;
}else{
		$check_att_date_out=$p_from;
		$check_att_date_in=$p_from;
}


}elseif(($time_keeping_complaint_status=="yes")&&($official_business_status=="yes")&&($attendance_table_status=="none")) { // att tables = true , ob = false

	//check tk complain & ob combination
	require(APPPATH.'views/app/time/dtr/check_ob_tk_combination.php');
	//end tk complain & ob combination

	if($flexi_shift_in!="none"){ // flexi true
		//check flexi setup ( to replot shift )
		require(APPPATH.'views/app/time/dtr/check_flexi.php');
		//end check flexi setup ( to replot shift )
	}else{}

$trimmed_in=substr($actual_in, 0,2);
$trimmed_out=substr($actual_out, 0,2);
if($trimmed_in=="00"){
$trimmed_in="24";
}else{

}
if($trimmed_in>$trimmed_out){
		$check_att_date_out = new DateTime($p_from);
		$check_att_date_out->modify('+1 day');
		$check_att_date_out=$check_att_date_out->format('Y-m-d');	
		$check_att_date_out=$check_att_date_out;
		$check_att_date_in=$p_from;
}else{
		$check_att_date_out=$p_from;
		$check_att_date_in=$p_from;
}

}elseif(($attendance_table_status=="yes")&&($official_business_status=="none") &&($time_keeping_complaint_status=="none")) { // att tables = true , ob = false , tk= false
	if($flexi_shift_in!="none"){ // flexi true

		$actual_in=$att_time_in;
		$actual_out=$att_time_out;		

	//check flexi setup ( to replot shift )
	require(APPPATH.'views/app/time/dtr/check_flexi.php');
	//end check flexi setup ( to replot shift )

	}else{ // not flexi
		// if($shift_in==""){ // halfday graveyard & nextday is restday
		// 	$actual_in="--:--";
		// 	$actual_out="--:--";		
		// }else{
		// 	$actual_in=$att_time_in;
		// 	$actual_out=$att_time_out;		
		// }

			$actual_in=$att_time_in;
			$actual_out=$att_time_out;		

	}



$trimmed_in=substr($actual_in, 0,2);
$trimmed_out=substr($actual_out, 0,2);
if($trimmed_in=="00"){
$trimmed_in="24";
}else{

}
if($trimmed_in>$trimmed_out){
		$check_att_date_out = new DateTime($p_from);
		$check_att_date_out->modify('+1 day');
		$check_att_date_out=$check_att_date_out->format('Y-m-d');	
		$check_att_date_out=$check_att_date_out;
		$check_att_date_in=$p_from;
}else{
		$check_att_date_out=$p_from;
		$check_att_date_in=$p_from;
}

}elseif(($attendance_table_status=="yes")&&($official_business_status=="yes") &&($time_keeping_complaint_status=="none")) { // att tables = true , ob = true

	//check attendance & ob combination
	require(APPPATH.'views/app/time/dtr/check_ob_att_combination.php');
	//end attendance & ob combination

	if($flexi_shift_in!="none"){ // flexi true
		//check flexi setup ( to replot shift )
		require(APPPATH.'views/app/time/dtr/check_flexi.php');
		//end check flexi setup ( to replot shift )
	}else{}

$check_att_date_in=$p_from;
$check_att_date_out=$p_from;

}else{
	$actual_in="--:--";
	$actual_out="--:--";

$check_att_date_in="";
$check_att_date_out="";

}




if($marked_as_early_cutoff_coverage=="yes"){

	if($is_rest_day=="yes"){

			// if(!empty($get_flexi_sched)){
			// 		$actual_in="";
			// 		$actual_out="";
			// 		$shift_in="";
			// 		$shift_out="";
			
			// }else{
			
			// }		

	}else{
		if($holiday_type){

		}else{


			if(!empty($get_flexi_sched)){

					$actual_in=$flexi_standard_shift_in;
					$actual_out=$flexi_standard_shift_out;
					$shift_in=$flexi_standard_shift_in;
					$shift_out=$flexi_standard_shift_out;						
			}else{
					$actual_in=$shift_in;
					$actual_out=$shift_out;
			}	
						

			$trimmed_xx=substr($shift_in, 0,2);
			$trimmed_yy=substr($shift_out, 0,2);
			$check_att_date_in=$p_from;
			if($trimmed_xx=="00"){
				$trimmed_xx="24";
			}else{

			}
		
			if($trimmed_xx>$trimmed_yy){
						$check_att_date_out = new DateTime($p_from);
						$check_att_date_out->modify('+1 day');
						$check_att_date_out=$check_att_date_out->format('Y-m-d');	
						$check_att_date_out=$check_att_date_out;		

			}else{

						$check_att_date_out=$p_from;

			}
			
			
				

		}

	}
	$early_cutoff_marked='style="background-color:'.$early_cutoff_marked_bg.';color:'.$early_cutoff_marked_color.';"';	
}else{

		$early_cutoff_marked="";
}



//echo "$actual_in to $actual_out $p_from <br>";

//============================================Rest day auto match schedule============================================

if(($is_rest_day=="yes") AND ($actual_in!="--:--") AND ($actual_out!="--:--") ){
	if($restday_auto_schedule_setting=="1"){
		// get nearest schedule from table
		$get_auto_rest_day_sched= $this->time_dtr_model->get_auto_rest_day_sched($classification_id,$company_id,$actual_in,$actual_out);
		if(!empty($get_auto_rest_day_sched)){

			$shift_in=$get_auto_rest_day_sched->time_in;
			if($shift_in=="24:00"){
				$shift_in="00:00";
			}else{

			}
			$shift_out=$get_auto_rest_day_sched->time_out;
			$shift_reg_hours_no=$get_auto_rest_day_sched->no_of_hours;
			
		}else{
			$shift_in=$actual_in;
			$shift_reg_hours_no=$mysalary_no_of_hours;
			$shift_out = new DateTime($shift_in.':00');
			$shift_out->add(new DateInterval('PT8H')); // add 8 hours
			$shift_out=$shift_out->format('H:i');
		}

	}else{

			$shift_in=$actual_in;

			$shift_out = new DateTime($shift_in.':00');
			$shift_out->add(new DateInterval('PT8H')); // add 8 hours
			$shift_out=$shift_out->format('H:i');	
	}

}else{

}

//============================================CHECK IN & OUT DATES============================================
// $att_date_check_shift_in=substr($shift_in, 0,2);
// if($att_date_check_shift_in>="17" OR $att_date_check_shift_in=="00"){// 4pm to 1am or 4pm to 12am : last shift with a possible next date out

// 	$att_date_in_actual_in=substr($actual_in, 0,2);
// 	$att_date_in_shift_in=substr($shift_in, 0,2);

// 	if(($att_date_in_actual_in>="00") AND ($att_date_in_actual_in<="04")){ 
// 		//echo "im here  $att_date_in_actual_in>=00 and $att_date_in_actual_in<=17<br>";
// 			$check_att_date_in = new DateTime($p_from);
// 			$check_att_date_in->modify('+1 day');
// 			$check_att_date_in=$check_att_date_in->format('Y-m-d');		
// 			//echo "$p_from $check_att_date_out <br>";
// 	}else{

// 	}

// 	$check_att_date_out = new DateTime($p_from);
// 	$check_att_date_out->modify('+1 day');
// 	$check_att_date_out=$check_att_date_out->format('Y-m-d');
// }else{
	
// }
//============================================CHECK SHIFT IN & SHIFT OUT DATES============================================

$trimmed_shift_in=substr($shift_in, 0,2);
$trimmed_shift_out=substr($shift_out, 0,2);
if(($trimmed_shift_in>$trimmed_shift_out)OR($trimmed_shift_in=="24")OR($trimmed_shift_in=="00")){ 
	$next_day = new DateTime($p_from);
	$next_day->modify('+1 day');
	$next_day=$next_day->format('Y-m-d');
	$shift_date_out=$next_day;
}else{
	$shift_date_out=$p_from;
}

//============================================  check if shift meet logs.


if(($shift_in)AND($shift_out)AND($actual_in!="--:--")AND($actual_out!="--:--")){

	$meet_shiftin=substr($shift_in, 0,2);
	$meet_shiftout=substr($shift_out, 0,2);

	$meet_actualin=substr($actual_in, 0,2);
	$meet_actualout=substr($actual_out, 0,2);

	if($meet_shiftin<$meet_shiftout){
		$shift_hours=$meet_shiftout-$meet_shiftin;
	}else{
		$shift_hours=$meet_shiftin-$meet_shiftout;
	}

	if($holiday_type OR $is_rest_day=="yes"){

		if(date($shift_in) <= $actual_in) { 
			$holreghr_a = StrToTime ( $p_from.' '.$shift_out.':00' );
			$holreghr_b = StrToTime ( $p_from.' '.$actual_in.':00' );
			$holreghr_raw = $holreghr_a - $holreghr_b;
			$holreghr_raw = $holreghr_raw / ( 60 * 60 );
			if($shift_hours>8){
				$holreghr_raw=$holreghr_raw-1;
			}else{

			}
		
		}else{

			$holreghr_a = StrToTime ( $shift_date_out.' '.$shift_out.':00' );
			$holreghr_b = StrToTime ( $p_from.' '.$shift_in.':00' );
			$holreghr_raw = $holreghr_a - $holreghr_b;
			$holreghr_raw = $holreghr_raw / ( 60 * 60 );
			if($shift_hours>8){
				$holreghr_raw=$holreghr_raw-1;
			}else{

			}		

		}


			if($decimal_place_rounding_setting=="yes"){// round off
				$holreghr_raw=round($holreghr_raw, $decimal_place_no_setting);
			}else{// cut only
				$holreghr_raw=bcdiv($holreghr_raw, 1, $decimal_place_no_setting); 
			}

	}else{
			$holreghr_raw="";
	}
	if($meet_shiftin<$meet_shiftout){
		$shift_hours=$meet_shiftout-$meet_shiftin;
	}else{
		$shift_hours=$meet_shiftin-$meet_shiftout;
	}

		if($shift_hours>4){
			$shift_hours=$shift_hours-1;
		}else{

		}


	if($meet_shiftin<=$meet_actualin){
		$check_logs_diff_from_shift=$meet_actualin-$meet_shiftin;

	}else{
		$check_logs_diff_from_shift=$meet_shiftin-$meet_actualin;
	}



	if($check_logs_diff_from_shift>=$shift_hours OR $check_logs_diff_from_shift==0){
		$logs_shift_dont_meet="yes"; //true 
	}else{
		$logs_shift_dont_meet="no"; // false
	}
}else{
	$logs_shift_dont_meet="";
}	

//============================================CHECK LATE FINAL NO.OF MINUTES============================================

if($shift_in=="00:00"){ 


	// check shift in date 
	$late_date_from_ref_raw = new DateTime($p_from);
	$late_date_from_ref_raw->modify('+1 day');
	$late_date_from_ref=$late_date_from_ref_raw->format('Y-m-d');
	// check actual in date 

	$late_date_to_ref_raw=substr($actual_in, 0,2);
	if(($late_date_to_ref_raw>="16") AND ($late_date_to_ref_raw<="23")){ 
		$late_date_to_ref=$p_from;
	}else{
		$to_raw = new DateTime($p_from);
		$to_raw->modify('+1 day');
		$late_date_to_ref=$to_raw->format('Y-m-d');
	}

}else{

	$late_date_from_ref=$p_from;
	$late_date_to_ref=$p_from;
}


if($late_grace_deduction_policy=="yes"){ // grace period is included to late deduction ( minutes computation )
$with_grace_time_in=$actual_in;

}else{//  grace period IS NOT included to late deduction ( minutes computation )
$with_grace_time_date = $late_date_to_ref.' '.$actual_in;
$with_grace_time_in = date("H:i", strtotime("-".$my_late_grace_period." minutes", strtotime($with_grace_time_date)));


}

$check_late_shift = strtotime($late_date_from_ref." ".$shift_in.":00"); // from
$check_late_actualLog = strtotime($check_att_date_in." ".$with_grace_time_in.":00"); // to

// if($p_from=="2018-03-13"){
// echo ":$late_date_from_ref  $shift_in  TO $check_att_date_in $with_grace_time_in<br>";
// }else{

// }


$my_orig_late= round(abs($check_late_shift - $check_late_actualLog) / 60,2);



if($shift_in==$actual_in){
	//echo "$shift_in $with_grace_time_in $p_from <br><br>";
	$my_orig_late=0;
}else{

}


$absent="0";
//============================================LATE DEDUCTION TABLE============================================
	if($shift_in !=""){
		if($actual_in !="--:--"){
			$my_late_deduction_table=$this->time_dtr_model->get_late_deduction_table($company_id,$my_orig_late,$p_from);
			if(!empty($my_late_deduction_table)){
				$equivalent_late_ded=$my_late_deduction_table->deduction;
			}else{
				$equivalent_late_ded="none";
			}
		}else{ 
			$equivalent_late_ded="none"; // with shift but no in
		}
	}else{ 
		$equivalent_late_ded="none"; // no shift & no in
	}
if($equivalent_late_ded=="none"){

}else{
	$my_orig_late=$equivalent_late_ded;
}


if($late_date_to_ref<$late_date_from_ref){
	$late_tracker="late computation A";
	$my_late="";
	$halfday_due_to_late="no";

}else{

	if($shift_in !=""){
		if($actual_in !="--:--"){


					$my_late_by_hour_raw=$my_orig_late/60;
					//$my_late_by_hour=round($my_late_by_hour_raw, 2);  // late minutes divided by 60 ( 1 hour )

						if($decimal_place_rounding_setting=="yes"){
							// round off
							$my_late_by_hour=round($my_late_by_hour_raw, $decimal_place_no_setting);
						}else{
							// cut only
							$my_late_by_hour=bcdiv($my_late_by_hour_raw, 1, $decimal_place_no_setting); 
						}

					if($my_late_by_hour=="0"){
							$late_tracker="late computation B";
							$my_late="";
							$halfday_due_to_late="no";
							$late_tracker_type="";
					}else{

							if($my_late_by_hour>=4){ // no more grace period
								
							$late_tracker_type="more_than_half_day"; // more than half day ang late officially.

							$afternoon_halfday_log = new DateTime($shift_in.':00');
							$afternoon_halfday_log->add(new DateInterval('PT5H')); //orig shift in + 5 hours
							$afternoon_halfday_log_shift_in=$afternoon_halfday_log->format('H:i');

							$check_afternoon_halfday_log_shift_in = strtotime($p_from." ".$afternoon_halfday_log_shift_in.":00"); // from
							$check_afternoon_halfday_actualLog = strtotime($p_from." ".$actual_in.":00"); // to
							$my_orig_late= round(abs($check_afternoon_halfday_log_shift_in - $check_afternoon_halfday_actualLog) / 60,2);

							$my_late_by_hour_raw2=$my_orig_late/60;
							//$my_late_by_hour=round($my_late_by_hour_raw2, 2);  // late minutes divided by 60 ( 1 hour )

						if($decimal_place_rounding_setting=="yes"){
							// round off
							$my_late_by_hour=round($my_late_by_hour_raw2, $decimal_place_no_setting);
							//echo "$my_late_by_hour $p_from = $my_late <br>";
						}else{
							// cut only
							$my_late_by_hour=bcdiv($my_late_by_hour_raw2, 1, $decimal_place_no_setting); 
						}		
								$late_tracker="late computation C";
								$my_late=$my_late_by_hour;

								if($late_tracker_type=="more_than_half_day"){
									//echo "$p_from ";
									if($holiday_type OR $is_rest_day=="yes"){
										$halfday_due_to_late="yes";

									}else{

										$absent=+0.5;
										$halfday_due_to_late="yes";
									}
									
									
									
								}else{
									$halfday_due_to_late="no";
								}
								
							
							}else{
								$my_late=$my_late_by_hour;

								if($my_late>=$late_as_half_day_policy){
										$late_tracker="late computation D.A";
									$my_late=$my_late_by_hour;
									if($forced_halfday_late_display_to_dtr=="yes"){

									}else{
										$my_late="";
									}

									$halfday_due_to_late="yes";
								}else{
									
									if($my_late==""){
										$my_late="";
										$late_tracker="late computation D.B.1 ";
										$halfday_due_to_late="no";	
									}else{

												$same_date_case_shiftin_hour=substr($shift_in, 0,2);
												$same_date_case_shiftin_minute=substr($shift_in, 3,2);
												$same_date_shift=(int)$same_date_shift_=$same_date_case_shiftin_hour.$same_date_case_shiftin_minute;

												$same_date_case_actualin_hour=substr($with_grace_time_in, 0,2);
												$same_date_case_actualin_minute=substr($with_grace_time_in, 3,2);
												$same_date_actualin=(int)$same_date_actualin_=$same_date_case_actualin_hour.$same_date_case_actualin_minute;

										if($same_date_actualin > $same_date_shift) { 
											$late_tracker="late computation D.B.3 in $same_date_actualin > $same_date_shift $my_late_by_hour";
											$my_late=$my_late_by_hour;		
											$halfday_due_to_late="no";	
										}else{
											$late_tracker="late computation D.B.2 in $same_date_actualin > $same_date_shift";
											$my_late="";		
											$halfday_due_to_late="no";														
										}


									}
									
			
								}
		
							}
							
					}

		}else{
			$late_tracker="late computation E";
			$my_late=""; // with shift but without logs yet
			$halfday_due_to_late="no";
		}


	}else{
		$late_tracker="late computation F";		
		$halfday_due_to_late="no";
		$my_late=""; // without shift
	}

}




//============================================LATE ROOT DEBUGGER ============================================

// echo "$p_from $late_tracker graceperiod: $my_late_grace_period , origlate_graceperiod already applied: $my_orig_late ,equivalent ded: $equivalent_late_ded<br>";
// echo " $p_from  late policy: $late_as_half_day_policy , latehour: $my_late , latepolicyresult: $halfday_due_to_late<br>";

//============================================ CHECK OT APPLICATION FORM============================================
$get_atro= $this->time_dtr_model->get_my_atro($emp->employee_id,$p_from);

if(!empty($get_atro)){
	$total_filed_atro_hours=0;
	foreach($get_atro as $my_ot){
			$atro_date=$my_ot->atro_date;

			$atro_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$my_ot->doc_no.'/emp_atro/HR008" target="_blank" title="'.$my_ot->doc_no.'">OT</a>';
			$atro_status="yes";
			$atro_hours_no=$my_ot->no_of_hours;
			$total_filed_atro_hours+=$atro_hours_no;	

	}

}else{

	$atro_status="none";		
	$atro_form="";
	$atro_hours_no=0;	
	$total_filed_atro_hours=0;
}

if(($holiday_type)AND($holiday_type=="RH")){
	$total_filed_atro_hours=$total_filed_atro_hours+$regular_holiday_auto_ot_setting;
}elseif(($holiday_type)AND($holiday_type=="SNW")){
	$total_filed_atro_hours=$total_filed_atro_hours+$snw_holiday_auto_ot_setting;
}else{

}


//============================================ CHECK UNDERTIME FORM============================================
$get_undertime_form= $this->time_dtr_model->get_undertime_form($emp->employee_id,$p_from);
if(!empty($get_undertime_form)){
	$my_ut_doc_no=$get_undertime_form->doc_no;
	$my_ut_hours=$get_undertime_form->hours;
	$with_under_time_form_status="yes";
	$under_time_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$my_ut_doc_no.'/emp_under_time/HR023" target="_blank" title="'.$my_ut_doc_no.'">undertime</a>';
	$under_time_doc_no=$my_ut_doc_no;
}else{
	$my_ut_doc_no="";
	$my_ut_hours="";
	$with_under_time_form_status="no";
	$under_time_form="";
	$under_time_doc_no="";
}
//============================================CHECK UNDERTIME COMPUTATION============================================
if($shift_out !=""){
	if($actual_out !="--:--"){

	if($ut_grace_deduction_policy=="yes"){ //include the grace period to undertime computation
		$actual_out_ut=$actual_out;
	}else{//do not include the grace period to undertime computation
		$actual_out_ut = strtotime($actual_out);
		$actual_out_ut = date("H:i", strtotime('+'.$my_ut_grace_period.' minutes', $actual_out_ut));
	}

		if($my_ut_deduction_rule=="yes"){ //  Approved undertime do not deduct to payroll ?
			
			if($with_under_time_form_status=="yes"){// if undertime is approved
							$my_undertime="";
							$halfday_due_to_undertime="no";
			}else{//no undertime form or not yet approved
							$ut_shift = strtotime($p_from." ".$shift_out.":00"); // from
							$ut_out = strtotime($p_from." ".$actual_out_ut.":00"); // to
							$my_orig_ut= round(abs($ut_shift - $ut_out) / 60,2);

							if(date($ut_shift) <= $ut_out) {
								$my_undertime="";
								$halfday_due_to_undertime="no";
							}else{
								$my_undertime=$my_orig_ut/60;
								//$my_undertime=round($my_undertime, 2);

								if($decimal_place_rounding_setting=="yes"){
									// round off
									$my_undertime=round($my_undertime, $decimal_place_no_setting);
								}else{
									// cut only
									$my_undertime=bcdiv($my_undertime, 1, $decimal_place_no_setting); 
								}


								if($my_undertime >= $ut_as_half_day_policy){

									if($forced_halfday_ut_display_to_dtr=="yes"){

									}else{
										$my_undertime="";
									}

									$halfday_due_to_undertime="yes";
								}else{
									$halfday_due_to_undertime="no";
								}
							}
			}

		}else{



							$ut_shift = strtotime($shift_date_out." ".$shift_out.":00"); // from
							$ut_out = strtotime($check_att_date_out." ".$actual_out_ut.":00"); // to
							$my_orig_ut= round(abs($ut_shift - $ut_out) / 60,2);



							if(date($ut_shift) <= $ut_out) {
								$my_undertime="";
								$halfday_due_to_undertime="no";

							}else{

								$my_undertime=$my_orig_ut/60;


								//$my_undertime=round($my_undertime, 2);
								if($decimal_place_rounding_setting=="yes"){
									// round off
									$my_undertime=round($my_undertime, $decimal_place_no_setting);
								}else{
									// cut only
									$my_undertime=bcdiv($my_undertime, 1, $decimal_place_no_setting); 
								}

								if($my_undertime >= $ut_as_half_day_policy){

									if($forced_halfday_ut_display_to_dtr=="yes"){

									}else{
										$my_undertime="";
									}

									$halfday_due_to_undertime="yes";
								}else{
									$halfday_due_to_undertime="no";
								}
							}
		}
	}else{// with shift out but no out
		$my_undertime="";
		$halfday_due_to_undertime="no";
	}

}else{//no shift out
$my_undertime="";
$halfday_due_to_undertime="no";
}

// for proper identification of employee treated as halfday absent due to NUMBER OF HOURS TO COUNT TARDINESS AS HALF DAY ABSENT policy setup
if(($halfday_due_to_late=="yes")AND(!$holiday_type)){
	$halfday_due_to_late_class='style="background-color:#FFD8D0;color:#ff0000;" ';
	if($logs_shift_dont_meet=="yes"){
		
	}else{
		if($late_tracker_type=="more_than_half_day"){ // halfday na late pa.
			$tardiness_total+=$my_late;
			$tardiness_occurence++;
		}else{

		}
		
	}

}else{
	if($holiday_type OR $is_rest_day=="yes"){ //
		$my_late=""; //echo "$p_from <br>";
		$my_undertime=""; 
	}else{

	}
	$halfday_due_to_late_class='';
	$tardiness_total+=$my_late;
}




// for proper identification of employee treated as halfday absent due to Number of hours to count under time as half day absent policy setup
if($halfday_due_to_undertime=="yes"){
	$halfday_due_to_undertime_class='style="background-color:#FFD8D0;color:#ff0000;" ';

}else{
	$halfday_due_to_undertime_class='';
	$undertime_total+=$my_undertime;
}



//============================================ACTUAL HOURS WORK COMPUTATION ============================================


if(($check_att_date_in!="")AND($actual_out!="")){
//echo "$p_from $shift_in -----------------> $check_att_date_in $actual_in $actual_in > $shift_in <br><br>";




	if(date($actual_in) < $shift_in) { //case early time in than the shift in schedule
		$reg_time_in = StrToTime ( $check_att_date_in.' '.$shift_in.':00' ); /* count start only on shift */
		$reg_time_out = StrToTime ( $check_att_date_out.' '.$actual_out.':00' );
		$official_actual_hours = $reg_time_out - $reg_time_in;
		$official_actual_hours = $official_actual_hours / ( 60 * 60 );
		//$official_actual_hours=round($official_actual_hours, 2);



		$a = StrToTime ( $check_att_date_in.' '.$actual_in.':00' ); /* count start only on shift */
		$b = StrToTime ( $p_from.' '.$shift_in.':00' );
		$c = $b - $a;
		$c = $c / ( 60 * 60 );
		
		if($c>$mysalary_no_of_hours){
			$official_actual_hours=0;
		}else{

		}

		if($decimal_place_rounding_setting=="yes"){
			// round off
			$official_actual_hours=round($official_actual_hours, $decimal_place_no_setting);
		}else{
			// cut only
			$official_actual_hours=bcdiv($official_actual_hours, 1, $decimal_place_no_setting); 
		}

	}else{

		$reg_time_in = StrToTime ( $check_att_date_in.' '.$actual_in.':00' ); /* count start only on actual in */
		$reg_time_out = StrToTime ( $check_att_date_out.' '.$actual_out.':00' );
		$official_actual_hours = $reg_time_out - $reg_time_in;
		$official_actual_hours = $official_actual_hours / ( 60 * 60 );
		//$official_actual_hours=round($official_actual_hours, 2);
	
		if($decimal_place_rounding_setting=="yes"){
			// round off
			$official_actual_hours=round($official_actual_hours, $decimal_place_no_setting);
		}else{
			// cut only
			$official_actual_hours=bcdiv($official_actual_hours, 1, $decimal_place_no_setting); 
		}		


	}

	if($p_from==$check_att_date_in){

		$date_a = new DateTime(''.$p_from.' '.$shift_in.'');
		$date_b = new DateTime(''.$check_att_date_in.' '.$actual_in.'');
		
		// $date_a = new DateTime('2018-01-01 23:00:00'); // shift tester
		// $date_b = new DateTime('2018-01-01 01:00:00'); // actual in tester

		// if($date_b>$date_a){
		// 	echo "mas beyond yung login";
		// }else{
		// 	echo "mas beyond yung shiftin";
		// }

		$shift_to_actualin_interval = date_diff($date_a,$date_b);

		$shift_to_actualin_interval=$shift_to_actualin_interval->format('%h');
		if($shift_to_actualin_interval>$mysalary_no_of_hours){
			$official_actual_hours=0;
			//echo "$p_from schedule not match.  <br>";
		}else{

		}
		
	}else{

	}

//============ scratch


	$reg_time_in = StrToTime ( $check_att_date_in.' '.$actual_in.':00' );
	$reg_time_out = StrToTime ( $check_att_date_out.' '.$actual_out.':00' );
	$actual_hours = $reg_time_out - $reg_time_in;
	$actual_hours = $actual_hours / ( 60 * 60 );
	//$actual_hours=round($actual_hours, 2);

	if($decimal_place_rounding_setting=="yes"){
		// round off
		$actual_hours=round($actual_hours, $decimal_place_no_setting);
	}else{
		// cut only
		$actual_hours=bcdiv($actual_hours, 1, $decimal_place_no_setting); 
	}		
}else{
	$actual_hours="";
	$official_actual_hours="";
}

//============================================SHOW ACTUAL HOURS WORK 
if($show_actual_hour=="yes"){ 
	if($my_set_advance_ot=="yes"){
		$act_column_content=$actual_hours;
	}else{
		$act_column_content=$official_actual_hours; 
	}

	$col_show_actual_hour='<td  width="50px" style="background-color:#ccc;">'.$act_column_content.'</td>';
}else{
	$col_show_actual_hour='';
	$act_column_content="";
}

//============================================REGULAR HOURS WORK COMPUTATION

	require(APPPATH.'views/app/time/dtr/regular_hours.php');	//regular_hours.php

//============================================REGULAR ND COMPUTATION
			/*
			$reg_nd_setting;
			$none_reg_nd_setting;
			$reg_nd_time_from;
			$reg_nd_time_to;
			$none_reg_nd_time_from;
			$none_reg_nd_time_to;
			*/

if(($reg_nd_setting=="yes")AND($none_reg_nd_setting=="no" OR $none_reg_nd_setting=="no setting" )) {
	//echo "reg nd: yes nonreg nd: no/no setting<br>";
	$official_night_diff_time_from=$reg_nd_time_from;
	$official_night_diff_time_to=$reg_nd_time_to;

}elseif(($reg_nd_setting=="no")AND($none_reg_nd_setting=="yes")) {
	//echo "reg nd: no nonreg nd: yes<br>";
	$official_night_diff_time_from=$none_reg_nd_time_from;
	$official_night_diff_time_to=$none_reg_nd_time_to;

}elseif(($reg_nd_setting=="yes")AND($none_reg_nd_setting=="yes")) {
	//echo "reg nd: yes nonreg nd: yes<br>";
	$official_night_diff_time_from=$reg_nd_time_from;
	$official_night_diff_time_to=$reg_nd_time_to;

}else{
	//echo "reg nd:  no/no setting nonreg nd:  no/no setting<br>";
	$official_night_diff_time_from="";
	$official_night_diff_time_to="";
}

if(($check_att_date_in!="")AND($actual_out!="") AND ($shift_in)){


	if($my_set_advance_ot=="yes"){

		$nd_time_in=$actual_in;
			if(date($actual_out) < $shift_out) { 
				$nd_time_out=$actual_out;
			}else{
				$nd_time_out=$shift_out;			//check if with ot app : wala pa
			}		
	}else{

		if(date($actual_in) < $shift_in) { //case early time in than the shift in schedule
			$nd_time_in=$shift_in; 
			if(date($actual_out) < $shift_out) { 
				$nd_time_out=$actual_out;
			}else{
				$nd_time_out=$shift_out; 			//check if with ot app : wala pa
			}

		}else{


			if(($is_rest_day=="yes") AND ($actual_in!="--:--") AND ($actual_out!="--:--") ){

					if($total_filed_atro_hours==0){
						$nd_time_in="";
						$nd_time_out="";

					}else{

							if(is_float($total_filed_atro_hours)){
								list($whole, $decimal) = explode('.', $total_filed_atro_hours);
							}else{
								$whole=$total_filed_atro_hours;
								$decimal=0;
							}
							

							$ot_hours_coverage = new DateTime($shift_in.':00');
							$ot_hours_coverage->add(new DateInterval('PT'.$whole.'H')); //orig shift in + 5 hours
							$ot_hours_coverage=$ot_hours_coverage->format('H:i');
							$decimal="0.".$decimal;
							$plus_this_minute=$decimal*60;
							$plus_this_minute=(int)($plus_this_minute);

							$ot_hours_coverage = new DateTime($ot_hours_coverage.':00');
							$ot_hours_coverage->add(new DateInterval('PT'.$plus_this_minute.'M')); //orig shift in + 5 hours
							$ot_hours_coverage=$ot_hours_coverage->format('H:i');

							if(($shift_in>="00:00") AND ($shift_in<="03:00")){
								$nd_time_in=$shift_in; 
								$nd_time_out=$ot_hours_coverage;								
							}else{
								if($shift_in>=$reg_nd_time_from){ 
									$nd_time_in=$shift_in;
									$nd_time_out=$ot_hours_coverage;		 							
								}else{
									
									if($ot_hours_coverage>="00:00"){
											$nd_time_in=$reg_nd_time_from;
									if(($is_rest_day=="yes")AND($holiday_type=="SNW")AND($ot_hours_coverage>$reg_nd_time_to)AND($shift_out<$reg_nd_time_to)){
											$nd_time_out=$shift_out;		
									}else{
											$nd_time_out=$ot_hours_coverage;	
									}

												
									}else{
										if($ot_hours_coverage>=$reg_nd_time_from){
											$nd_time_in=$reg_nd_time_from;
											$nd_time_out=$ot_hours_coverage;										
										}else{
											$nd_time_in="";
											$nd_time_out="";

										}

									}


								}								
							}
	
//echo "$nd_time_in $nd_time_out<br>";

							if($nd_time_in!=""){
								if($actual_out>="00:00"){

								}else{
									if(date($ot_hours_coverage)>$actual_out) { 														
										$nd_time_out=$actual_out; 
									}else{

									}	
								}


							}else{

							}

						
					}

			}else{


					$trimmed_shift_start=substr($shift_in, 0,2);
					$trimmed_shift_end=substr($shift_in, 3,2);
					$trimmed_shift_final=$trimmed_shift_start.$trimmed_shift_end;
					$trimmed_in_start=substr($actual_in, 0,2);
					$trimmed_in_end=substr($actual_in, 3,2);
					$trimmed_in_final=$trimmed_in_start.$trimmed_in_end;

					if($trimmed_shift_final=="0000"){
					$trimmed_shift_final="2400";
					}else{

					}
										
					if($trimmed_shift_final > $trimmed_in_final){

					$first_two_digit_in=substr($actual_in, 0,2);

					if(($first_two_digit_in<=23)AND ($first_two_digit_in>11)){
						$nd_time_in=$shift_in;	
					}else{
						$nd_time_in=$actual_in;	
					}

					}else{
					$nd_time_in=$actual_in;		
					}


					if(($actual_in<$official_night_diff_time_from)AND($actual_out<$official_night_diff_time_from)){
						if(($actual_in>"00:00")AND($actual_in<$official_night_diff_time_to)){
							
						}else{
							$nd_time_in=$official_night_diff_time_from;		
						}
						
					}else{

					}

					//$nd_time_in=$actual_in;	
					if(date($actual_out) < $shift_out) { 
						$nd_time_out=$actual_out;

					}else{
						$nd_time_out=$shift_out; 			
					}	



			}



		
		}

	}


if(($nd_time_out<="23:59")AND ($nd_time_out>=$official_night_diff_time_from)){

}else{
	if(date($official_night_diff_time_to) < $nd_time_out) { 
		$nd_time_out=$official_night_diff_time_to;

	}else{
			
	}	
}


if($p_from==$check_att_date_in){ 

		$p_from_plus_one_day = new DateTime($p_from);
		$p_from_plus_one_day->modify('+1 day');
		$p_from_plus_one_day=$p_from_plus_one_day->format('Y-m-d');

		$first_two_digit_in=substr($actual_in, 0,2);

		if($shift_in=="00:00"){

		if(($first_two_digit_in<=23)AND ($first_two_digit_in>11)){
				$official_nd_time_in = StrToTime ( $p_from_plus_one_day.' '.$nd_time_in.':00' );
				$official_nd_time_out = StrToTime ( $check_att_date_out.' '.$nd_time_out.':00' );
				$official_reg_nd = $official_nd_time_out - $official_nd_time_in;
				$official_reg_nd = $official_reg_nd / ( 60 * 60 );
				//$official_reg_nd=round($official_reg_nd, 2);

				if($decimal_place_rounding_setting=="yes"){
					// round off
					$official_reg_nd=round($official_reg_nd, $decimal_place_no_setting);
				}else{
					// cut only
					$official_reg_nd=bcdiv($official_reg_nd, 1, $decimal_place_no_setting); 
				}
		}else{
				$official_nd_time_in = StrToTime ( $p_from.' '.$nd_time_in.':00' );
				$official_nd_time_out = StrToTime ( $check_att_date_out.' '.$nd_time_out.':00' );
				$official_reg_nd = $official_nd_time_out - $official_nd_time_in;
				$official_reg_nd = $official_reg_nd / ( 60 * 60 );
				//$official_reg_nd=round($official_reg_nd, 2);

				if($decimal_place_rounding_setting=="yes"){
					// round off
					$official_reg_nd=round($official_reg_nd, $decimal_place_no_setting);
				}else{
					// cut only
					$official_reg_nd=bcdiv($official_reg_nd, 1, $decimal_place_no_setting); 
				}
		}


		}else{


if(($nd_time_in>="00:00")AND($nd_time_in<="04:00")){
	$nd_time_in_date=$check_att_date_out;
}else{
	$nd_time_in_date=$p_from;
}
if(($nd_time_out<="23:59") AND ($nd_time_out>=$official_night_diff_time_from)){
	$nd_time_out_date=$p_from;
}else{
	$nd_time_out_date=$check_att_date_out;
}

				$official_nd_time_in = StrToTime ( $nd_time_in_date.' '.$nd_time_in.':00' );
				$official_nd_time_out = StrToTime ( $nd_time_out_date.' '.$nd_time_out.':00' );
				$official_reg_nd = $official_nd_time_out - $official_nd_time_in;
				$official_reg_nd = $official_reg_nd / ( 60 * 60 );
				//$official_reg_nd=round($official_reg_nd, 2); 

				if($decimal_place_rounding_setting=="yes"){
					// round off
					$official_reg_nd=round($official_reg_nd, $decimal_place_no_setting);
				}else{
					// cut only
					$official_reg_nd=bcdiv($official_reg_nd, 1, $decimal_place_no_setting); 
				}

		}
		// $official_nd_time_in = StrToTime ( $p_from.' '.$nd_time_in.':00' );
		// $official_nd_time_out = StrToTime ( $check_att_date_out.' '.$nd_time_out.':00' );
		// $official_reg_nd = $official_nd_time_out - $official_nd_time_in;
		// $official_reg_nd = $official_reg_nd / ( 60 * 60 );
		// $official_reg_nd=round($official_reg_nd, 2);

}else{

		$official_nd_time_in = StrToTime ( $check_att_date_in.' '.$nd_time_in.':00' );
		$official_nd_time_out = StrToTime ( $check_att_date_out.' '.$nd_time_out.':00' );
		$official_reg_nd = $official_nd_time_out - $official_nd_time_in;
		$official_reg_nd = $official_reg_nd / ( 60 * 60 );
		//$official_reg_nd=round($official_reg_nd, 2);

		if($decimal_place_rounding_setting=="yes"){
			// round off
			$official_reg_nd=round($official_reg_nd, $decimal_place_no_setting);
		}else{
			// cut only
			$official_reg_nd=bcdiv($official_reg_nd, 1, $decimal_place_no_setting); 
		}

}

$ondtf = StrToTime ( $p_from.' '.$official_night_diff_time_from.':00' );
$s_out = StrToTime ( $check_att_date_out.' '.$shift_out.':00' );

if(date($ondtf) > $s_out) { 

	$ondtf_trimmed=substr($official_night_diff_time_to, 0,2);
	$nd_time_in_trimmed=substr($nd_time_in, 0,2);

	if($nd_time_in_trimmed < $ondtf_trimmed){

	}else{
		$nd_time_in="";
		$nd_time_out="";
		$official_reg_nd="";
	}

}else{

}

}else{
	$nd_time_in="";
	$nd_time_out="";
	$official_reg_nd="";
}

if(($shift_out<=$official_night_diff_time_from)AND($shift_out>=$official_night_diff_time_to)AND ($shift_in>=$official_night_diff_time_to) AND($shift_in<=$official_night_diff_time_from)){
//echo "$p_from $official_reg_nd <br>"; 	
$official_reg_nd="";
}else{

}


//============================================ TAKE EFFECT 1hr BREAK DEDUCTION on ND of 9 hrs shift (regular days)
$check_total_shift_hours_in = StrToTime ( $p_from.' '.$shift_in.':00' );
$check_total_shift_hours_out = StrToTime ( $p_from.' '.$shift_out.':00' );
$total_shift_hours = $check_total_shift_hours_in - $check_total_shift_hours_out;
$total_shift_hours = $total_shift_hours / ( 60 * 60 );
$total_shift_hours=round($total_shift_hours, 2);	
$total_shift_hours=(abs($total_shift_hours));

if(($holiday_type=="" OR $holiday_type=="SWH") AND ($is_rest_day=="no")){

	if($total_shift_hours>="9"){
		if($regular_day_nd_break_deduction_setting=="yes"){
			if($official_reg_nd!=""){

				if(date($shift_in) >= "04:00") { 
				}else{
					$official_reg_nd--;
				}
			}else{

			}			
		}else{

		}		
	}else{//end if 9 hours shift

	}
$regular_day_regular_nd=$official_reg_nd;
$special_holiday_regular_nd="";
$regular_holiday_regular_nd="";
$restday_special_holiday_regular_nd="";
$rd_regular_holiday_regular_nd="";
}elseif(($holiday_type=="RH") AND ($is_rest_day=="no")){

	if($total_shift_hours>="9"){ 
		if($regular_holiday_nd_break_deduction_setting=="yes"){ 
			if($official_reg_nd!=""){

				if(date($shift_in) >= "04:00") { 
					//dont deduct 1hr from nd
				}else{
					$official_reg_nd--; 
				
				}

				if($total_filed_atro_hours!=0){

				}else{
					$official_reg_nd="";
					$my_undertime="";
				}
			}else{



			}			
		}else{

		}
	}else{

	}


$regular_day_regular_nd="";	
$special_holiday_regular_nd="";
$regular_holiday_regular_nd=$official_reg_nd;
$restday_special_holiday_regular_nd="";
$rd_regular_holiday_regular_nd="";
}elseif(($holiday_type=="RH") AND ($is_rest_day=="yes")){

	if($total_shift_hours>="9"){ 
		if($regular_holiday_nd_break_deduction_setting=="yes"){ 
			if($official_reg_nd!=""){

				if(date($shift_in) >= "04:00") { 
					//dont deduct 1hr from nd
				}else{
					$official_reg_nd--; 
				
				}

				if($total_filed_atro_hours!=0){

				}else{
					$official_reg_nd="";
					$my_undertime="";
				}
			}else{



			}			
		}else{

		}
	}else{

	}


$regular_day_regular_nd="";	
$special_holiday_regular_nd="";
$regular_holiday_regular_nd="";
$restday_special_holiday_regular_nd="";
$rd_regular_holiday_regular_nd=$official_reg_nd;
}elseif(($holiday_type=="SNW")AND($is_rest_day=="no")){

	if($total_shift_hours>="9"){
		if($snw_holiday_nd_break_deduction_setting=="yes"){
			if($official_reg_nd!=""){

				if(date($shift_in) >= "04:00") { 
					//dont deduct 1hr from nd
				}else{
					$official_reg_nd--;
				}
			}else{

			}			
		}else{

		}
	}else{

	}
$regular_day_regular_nd="";	
$special_holiday_regular_nd=$official_reg_nd;	
$regular_holiday_regular_nd="";
$restday_special_holiday_regular_nd="";
$rd_regular_holiday_regular_nd="";
}elseif(($holiday_type=="SNW")AND($is_rest_day=="yes")){ // check me

	if($total_shift_hours>="9"){
		if($snw_holiday_nd_break_deduction_setting=="yes"){
			if($official_reg_nd!=""){

				if(date($shift_in) >= "04:00") { 
					//dont deduct 1hr from nd
				}else{
					$official_reg_nd--;
				}
			}else{

			}			
		}else{

		}
	}else{

	}
$regular_day_regular_nd="";	
$special_holiday_regular_nd="";
$restday_special_holiday_regular_nd=$official_reg_nd;	
$regular_holiday_regular_nd="";
$rd_regular_holiday_regular_nd="";
}else{
$regular_day_regular_nd="";		
$special_holiday_regular_nd="";
$regular_holiday_regular_nd="";
$restday_special_holiday_regular_nd="";
$rd_regular_holiday_regular_nd="";
}

//echo "$p_from $nd_time_in $nd_time_out $official_night_diff_time_from $official_night_diff_time_to RESULT $official_reg_nd <br>";
//============================================END REGULAR ND COMPUTATION
// restday present
if(($is_rest_day=="yes") AND ($holiday_type!="SNW") AND ($holiday_type!="RH") AND ($actual_in!="--:--") AND ($actual_out!="--:--") ){ 
	// if($total_filed_atro_hours==0){
	// 	$reg_hours_worked="";
	// 	$official_reg_nd="";
	// 	$official_restday_regular_nd="";
	// 	$official_restday_regular_hour="";
	// }else{		
		
	// 	if($total_filed_atro_hours>8){
	// 		if($halfday_due_to_undertime=="yes"){

	// 		}else{
	// 			$reg_hours_worked=8;
	// 		}
	// 	}else{
	// 		$reg_hours_worked=$total_filed_atro_hours;
	// 	}
	// }

		$official_restday_regular_nd=$official_reg_nd;
		$official_restday_regular_hour=$reg_hours_worked;
	
}else{
	$official_restday_regular_nd="";
	$official_restday_regular_hour="";
}
//restday -special non working holiday present
if(($is_rest_day=="yes") AND ($holiday_type=="SNW") AND ($holiday_type!="RH") AND ($actual_in!="--:--") AND ($actual_out!="--:--") ){ 
	if($total_filed_atro_hours==0){
		$reg_hours_worked="";
		$official_reg_nd="";
		$official_restday_snw_regular_nd="";
		$official_restday_snw_regular_hour="";
	}else{		
		$official_restday_snw_regular_nd=$official_reg_nd;
		if($total_filed_atro_hours>8){
			if($halfday_due_to_undertime=="yes"){

			}else{
				$reg_hours_worked=8;
			}
		}else{
			$reg_hours_worked=$total_filed_atro_hours;
		}
		$official_restday_snw_regular_hour=$reg_hours_worked;
	}
}else{
	$official_restday_snw_regular_nd="";
	$official_restday_snw_regular_hour="";
}

//============================================start treatment for merging regular day- holiday coverage of in & out type
//working day : regular holiday / next day : regular day
if(($holiday_type!="")AND($reg_hours_worked!="")){
	if(($actual_out>"00:00")AND($actual_out<="12:00")){
		require(APPPATH.'views/app/time/dtr/check_merging_holiday_regular_day.php');	

	}else{
			$regular_holiday_deduction="";
			$deduction_regular_holiday_regular_nd="";
	}
}else{
			$regular_holiday_deduction="";
			$deduction_regular_holiday_regular_nd="";
}


//working day : regular day / next day : regular holiday
if(($holiday_type=="")AND($reg_hours_worked!="")){

	if(($actual_out>"00:00")AND($actual_out<="12:00")){
		require(APPPATH.'views/app/time/dtr/check_merging_regular_day_holiday.php');		
	}else{
			$regular_holiday_reghour_addition="";
			$varr="";
	}
	
}else{
			$regular_holiday_reghour_addition="";
			$varr="";
}
//============================================end treatment for merging regular day- holiday coverage of in & out type




//============================================REGULAR OT COMPUTATION
require(APPPATH.'views/app/time/dtr/regular_overtime.php');

//============================================REST DAY OT OT COMPUTATION
require(APPPATH.'views/app/time/dtr/restday_overtime.php');

//============================================REGULAR HOLIDAY OT OT COMPUTATION
require(APPPATH.'views/app/time/dtr/regular_holiday_ot_ot.php');

//============================================SNW HOLIDAY OT OT COMPUTATION
require(APPPATH.'views/app/time/dtr/snw_holiday_ot_ot.php');

//============================================RESTDAY SNW HOLIDAY OT OT COMPUTATION
require(APPPATH.'views/app/time/dtr/restday_snw_holiday_ot_ot.php');

//============================================RESTDAY REG HOLIDAY OT OT COMPUTATION
require(APPPATH.'views/app/time/dtr/restday_reg_holiday_ot_ot.php');

//============================================UNDERTIME ROOT DEBUGGER ============================================

// echo "$p_from  graceperiod: $my_ut_grace_period $ut_as_half_day_policy $halfday_due_to_undertime $shift_out $actual_out_ut<br>";

//============================================OFFICIAL IN & OUT  ROOT DEBUGGER ============================================

// echo " attendance   : $p_from : $attendance_table_status	<br>";
// echo " ob & attendance   : $p_from $official_business_status : $attendance_table_status	<br>";
// echo " tk complaint & ob & att : $p_from $time_keeping_complaint_status : $official_business_status	$attendance_table_status <br>";

$overbreak_total+=$over_break;

//============================================LATE "OCCURENCE" COMPUTATION
if($my_late!=""){
			if($forced_halfday_late_include_to_occurence=="yes"){
					$tardiness_occurence++;
			}else{
				if($halfday_due_to_late=="yes"){

				}else{
					$tardiness_occurence++;

				}
			}
}else{
	
}

if($over_break!=""){
$overbreak_occurence++;
}else{

}

//============================================UNDERTIME "OCCURENCE" COMPUTATION
if($my_undertime!=""){
			if($forced_halfday_ut_include_to_occurence=="yes"){
					$undertime_occurence++;
			}else{
				if($halfday_due_to_undertime=="yes"){

				}else{
					$undertime_occurence++;

				}
			}
}else{
	
}

//============================================ABSENT "OCCURENCE" COMPUTATION
/*
ao_actual_total_absent : means Actual DTR total absent value
ao_wholeday_absent : means Count whole day absences only
ao_wholeday_halfday_absent : means Count whole day & halfday absent ( will count 0.5 absent as +1 occurence not as occurence +0.5 occurence)
*/
if($dtr_absent_occurence_basis=="ao_actual_total_absent"){

		$absences_occurence=$absences_total;

}elseif($dtr_absent_occurence_basis=="ao_wholeday_absent"){

		if($reg_hours_worked=="absent"){
			$absences_occurence++;
		//echo "$p_from <br>";
		}else{

		}

}elseif($dtr_absent_occurence_basis=="ao_wholeday_halfday_absent"){

		if($reg_hours_worked=="absent"){
			$absences_occurence++;
		
		}else{
			if($is_rest_day=="yes" OR $holiday_type){

			}else{
				if(($reg_hours_worked<="4")AND($reg_hours_worked>="1")){
					$absences_occurence++;
				}else{

				}
			}
		}

}else{



}



if(($is_rest_day=="yes") AND ($actual_in!="--:--") AND ($actual_out!="--:--") AND ($reg_hours_worked>0) ){

	$total_regular_hrs_restday+=$official_restday_regular_hour;

}else{
		if($remove_time_credit=="yes"){// auto adjustment of early cutoff

		}else{
	$total_regular_nd+=$regular_day_regular_nd;
		}
}

$total_spec_holiday_nd+=$special_holiday_regular_nd;
$total_reg_holiday_nd+=$regular_holiday_regular_nd;
$total_restday_nd+=$official_restday_regular_nd;
$total_restday_overtime_nd+=$restday_ot_ot_nd;

$total_reg_holiday_overtime+=$regular_holiday_ot_ot;
$total_spec_holiday_overtime+=$snw_holiday_ot_ot;
$total_reg_holiday_overtime_nd+=$regular_holiday_ot_ot_nd;
$total_spec_holiday_overtime_nd+=$snw_holiday_ot_ot_nd;
$total_restday_overtime+=$restday_ot_ot;

$total_regular_overtime+=$official_regular_ot;
$total_regular_overtime_nd+=$official_regular_ot_nd;

$total_regular_hrs_reg_holiday+=$regular_holiday_total;
$total_regular_hrs_spec_holiday+=$special_holiday_total;

$total_restday_regular_hrs_spec_holiday+=$official_restday_snw_regular_hour;
$total_restday_spec_holiday_nd+=$restday_special_holiday_regular_nd;
$total_restday_spec_holiday_overtime+=$rd_snw_holiday_ot_ot;
$total_restday_spec_holiday_overtime_nd+=$rd_snw_holiday_ot_ot_nd;

$total_regular_hrs_reg_holiday_t2+=$no_att_rd_reg_holiday;
$total_regular_hrs_reg_holiday_t1+=$rd_regular_holiday_total;
$total_restday_reg_holiday_nd+=$rd_regular_holiday_regular_nd;
$total_restday_reg_holiday_overtime+=$rd_reg_holiday_ot_ot;
$total_restday_reg_holiday_overtime_nd+=$rd_reg_holiday_ot_ot_nd;


//============================================START treatment for merging regular day- holiday coverage of in & out type

if(($is_rest_day=="yes")AND($holiday_type=="RH")){

$total_regular_hrs_reg_holiday_t1=$total_regular_hrs_reg_holiday_t1-$regular_holiday_deduction;
$total_restday_reg_holiday_nd=$total_restday_reg_holiday_nd-$regular_holiday_deduction; 
//$total_restday_nd=$total_restday_nd+$deduction_regular_holiday_regular_nd;

	if($remove_time_credit=="yes"){// auto adjustment of early cutoff

	}else{
$total_regular_nd=$total_regular_nd+$deduction_regular_holiday_regular_nd;
	}
}else{
	//$deduction_regular_holiday_regular_nd=0;

$total_regular_hrs_reg_holiday=$total_regular_hrs_reg_holiday-$regular_holiday_deduction;
$total_reg_holiday_nd=$total_reg_holiday_nd-$deduction_regular_holiday_regular_nd;


	if($remove_time_credit=="yes"){// auto adjustment of early cutoff
	
		if($PrevEarlyCutoff_regular_nd>$regular_day_regular_nd){
			$additional_regular_nd=$PrevEarlyCutoff_regular_nd-$regular_day_regular_nd;
			$total_regular_nd-=$additional_regular_nd;
		}else{
			$additional_regular_nd=$PrevEarlyCutoff_regular_nd-$regular_day_regular_nd;
			$total_regular_nd+=$additional_regular_nd;
		}


	}else{
		//$additional_regular_nd=0;
		$raw_total_regular_nd=$total_regular_nd+$deduction_regular_holiday_regular_nd;
		$total_regular_nd=$raw_total_regular_nd;
	}
}

//echo "$p_from $regular_holiday_reghour_addition VS $regular_holiday_regular_nd <br>";

$total_regular_hrs_reg_holiday=$total_regular_hrs_reg_holiday+$regular_holiday_reghour_addition;
//echo "$p_from $regular_holiday_reghour_addition <br>";
//============================================END treatment for merging regular day- holiday coverage of in & out type

// start do not display 0 value anymore
require(APPPATH.'views/app/time/dtr/display_null_zero_value.php');
// end do not display 0 value anymore

// not being used
if($restday_ot_ot!=0){
	$show_restday_checkbox="";
}else{
	$show_restday_checkbox=$restday_official;
}
// end not being used


//============================================TOTAL REGULAR HOURS COMPUTATION
if($emp->salary_rate=="1"){//piece rate

}elseif($emp->salary_rate=="2"){ // hourly rate

}elseif($emp->salary_rate=="3"){ // daily rate

		if($remove_time_credit=="yes"){// auto adjustment of early cutoff

				if($is_rest_day=="yes" OR $holiday_type){

				}else{
						if($PrevEarlyCutoff_regular_hour>$reg_hours_worked){
							$additional_regular_hour=$PrevEarlyCutoff_regular_hour-$reg_hours_worked;
							$total_regular_hours-=$additional_regular_hour;
						}else{
							$additional_regular_hour=$PrevEarlyCutoff_regular_hour-$reg_hours_worked;
							$total_regular_hours+=$additional_regular_hour;
						}
				}	

		}else{

				if($reg_hours_worked>=4 OR $holiday_type=="RH"){
					if($is_rest_day=="yes" or $holiday_type){
						if(($holiday_type)AND($reg_hours_worked=="")){
							//echo "$p_from <br>";
							$total_regular_hours+=$mysalary_no_of_hours;
						}else{
							$total_regular_hours+=$reg_hours_worked;
						}
						
					}else{
						if($reg_hours_worked==4){
							$total_regular_hours+=8;
						}else{
							//echo "$p_from <br>";
							$total_regular_hours+=$reg_hours_worked;
						}
						
					}
					
				}else{

				}
		}



}elseif(($emp->salary_rate=="4")and($pay_type=="3")){ // monthly rate

		if($remove_time_credit=="yes"){// auto adjustment of early cutoff

				if($is_rest_day=="yes" OR $holiday_type){

				}else{

						if($PrevEarlyCutoff_regular_hour>$reg_hours_worked){
							if($halfday_due_to_undertime=="yes" OR $halfday_due_to_late=="yes"){
								$absences_total+=0.5;
							}else{

							}
						}else{
							$additional_regular_hour=$PrevEarlyCutoff_regular_hour-$reg_hours_worked;
							
						}

				}	

		}else{

			$total_regular_hours=$monthlyrate_semimonth_reg_hour_base;

		}

}else{

}

//====================== retrack back counting of attendance during restday/holiday
if((!$holiday_type) AND($is_rest_day=="no") AND (!$multiple_leave_application_form)AND($time_keeping_complaint_status=="yes")){
		if($reg_hours_worked){
			$with_tk_logs_present_occ++;
			$with_tk_logs_present_occ_ref.=$p_from." ";
		}else{

		}		

}else{
}

if((!$holiday_type) AND($is_rest_day=="no") AND (!$multiple_leave_application_form)AND($official_business_status=="yes")){

		if($reg_hours_worked){
			$with_ob_logs_present_occ++; 
			$with_ob_logs_present_occ_ref.=$p_from." ";
		}else{

		}
	
}else{
}

if((!$holiday_type) AND($is_rest_day=="no") AND (!$multiple_leave_application_form)AND($attendance_table_status=="yes")AND($official_business_status=="none")AND($time_keeping_complaint_status=="none")){
	$complete_logs_present_occ++;	
	$complete_logs_present_occ_ref.=$p_from." ";
}else{		

}

if(($reg_hours_worked>0)AND($is_rest_day=="yes")AND(!$holiday_type)){
	//echo "$p_from <br>";
	$restday_w_logs++;
	$restday_w_logs_ref.=$p_from." ";
}elseif(($reg_hours_worked=="")AND($is_rest_day=="yes")AND(!$holiday_type)){
	//echo "$p_from <br>";
	$restday_wo_logs++;
	$restday_wo_logs_ref.=$p_from." ";
}elseif(($reg_hours_worked>0)AND($is_rest_day=="no")AND($holiday_type)){
	if($holiday_type=="RH"){
		$reg_holiday_w_logs++;
		$reg_holiday_w_logs_ref.=$p_from." ";
	}elseif($holiday_type=="SNW"){
		$snw_holiday_w_logs++;
		$snw_holiday_w_logs_ref.=$p_from." ";
	}else{

	}
}elseif(($reg_hours_worked>0)AND($is_rest_day=="yes")AND($holiday_type)){
	if($holiday_type=="RH"){
		$rd_reg_holiday_w_logs++;
		$rd_reg_holiday_w_logs_ref.=$p_from." ";
	}elseif($holiday_type=="SNW"){
		$rd_snw_holiday_w_logs++;
		$rd_snw_holiday_w_logs_ref.=$p_from." ";
	}else{

	}
}elseif(($reg_hours_worked=="")AND($is_rest_day=="no")AND($holiday_type)){
	if($holiday_type=="RH"){
		$reg_holiday_wo_logs++;
		$reg_holiday_wo_logs_ref.=$p_from." ";
	}elseif($holiday_type=="SNW"){
		$snw_holiday_wo_logs++;
		$snw_holiday_wo_logs_ref.=$p_from." ";
	}else{

	}
}elseif(($reg_hours_worked=="")AND($is_rest_day=="yes")AND($holiday_type)){
	if($holiday_type=="RH"){
		$rd_reg_holiday_wo_logs++;
		$rd_reg_holiday_wo_logs_ref.=$p_from." ";
	}elseif($holiday_type=="SNW"){
		$rd_snw_holiday_wo_logs++;
		$rd_snw_holiday_wo_logs_ref.=$p_from." ";

	}else{

	}
}else{	

}


if(($total_filed_atro_hours<=0)AND($is_rest_day=="yes" OR $holiday_type)){
	$reg_hours_worked="";
	$official_reg_nd="";

}else{

}

//============================================start check if already employed on this date
// $datehired_on_cur_period_sts
// $datehired_on_cur_period_action

if($p_from>=$date_employed){

}else{
	//$reg_hours_worked="";
	//echo "$p_from $date_employed === save dtr: datehired_on_cur_period_sts , action : $datehired_on_cur_period_action <br>";
}




//============================================end check if already employed on this date
// start process dtr dates query
require(APPPATH.'views/app/time/dtr/process_dtr_dates.php');
// end process dtr dates query

//============================================DAYS 
echo '<tr >'.'<td>'.$two_digit_day.'</td>';
//============================================DAY FO THE WEEK============================================
echo '<td '.$sunday_color.'>'.$dayOfWeek.'</td>';
echo '<td '.$hl_shift.'>'.$shift_in.'</td>';
echo '<td '.$hl_shift.'>'.$shift_out.'</td>';
echo '<td '.$remove_time_credit_class. $early_cutoff_marked. $hl_logs.'>'.$actual_in.$att_date_in.'</td>';
echo '<td '.$remove_time_credit_class. $early_cutoff_marked. $hl_logs.'>'.$actual_out.$att_date_out.'</td>';
echo '<td '.$halfday_due_to_late_class.' '.$hl_late.'>'.$my_late.'</td>';
echo '<td '.$hl_overbrk.'>'.$over_break.'</td>';
echo '<td '.$halfday_due_to_undertime_class.' '.$hl_undrtme.'>'.$my_undertime.'</td>';
echo '<td colspan="2" '.$hl_hw_reg.'>
		<table  cellpadding="1" cellspacing="3" style="table-layout:fixed;width:150px;">
		<tr>
			<td width="50" '.$remove_time_credit_class. $early_cutoff_marked. $reg_hours_worked_class.'>'.$reg_hours_worked.'</td>
			<td width="50" '.$remove_time_credit_class. $early_cutoff_marked. $hl_hw_nd.'>'.$official_reg_nd.'</td>
			'.$col_show_actual_hour.'
		</tr>
		</table>
	</td>';
echo '<td '.$regot_hl.'>'.$official_regular_ot.'</td>';
echo '<td '.$rdot_hl.'>'.$restday_official.$restday_ot_ot.'</td>';
echo '<td colspan="2">
	<table   cellpadding="1" cellspacing="3" style="table-layout:fixed;width="200px;">
	<tr>
		<td '.$snw_hl.' style="text-align:center;width:50%;">'.$special_holiday_official.$snw_holiday_ot_ot.'</td>
		<td '.$reghol_hl.' style="text-align:center;width:50%;">'.$regular_holiday_official.$regular_holiday_ot_ot.'</td>
	</tr>
	</table>
</td>';
echo '<td colspan="2">
	<table   cellpadding="1" cellspacing="3" style="table-layout:fixed;width="200px;">
	<tr>
		<td '.$rd_snw_hl.' style="text-align:center;width:50%;">'.$restday_special_holiday_official.$rd_snw_holiday_ot_ot.'</td>
		<td '.$rd_reghol_hl.' style="text-align:center;width:50%;">'.$restday_regular_holiday_official.$rd_reg_holiday_ot_ot.'</td>
	</tr>
	</table>
</td>';
echo '<td '.$ot_nd.'>'.$official_regular_ot_nd.$regular_holiday_ot_ot_nd.$snw_holiday_ot_ot_nd.$restday_ot_ot_nd.$rd_snw_holiday_ot_ot_nd.$rd_reg_holiday_ot_ot_nd.'</td>';
echo '<td '.$atro_hl.'>';
if(!empty($get_atro)){
	$list_of_ot_form="";
	foreach($get_atro as $my_ot){
			$atro_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$my_ot->doc_no.'/emp_atro/HR008" target="_blank" title="'.$my_ot->no_of_hours.'">OT</a>';
				echo $atro_form."(".$my_ot->no_of_hours.") ";

	$list_of_ot_form.=$my_ot->doc_no."[".$my_ot->no_of_hours."]*";
	}

// start process dtr atro form query
require(APPPATH.'views/app/time/dtr/process_dtr_atro.php');
// end process dtr atro form query

}else{

}
if(($holiday_type=="SNW")AND($snw_holiday_auto_ot_setting!="")) {
	echo $auto_ot_form='<a href="#" title="'.$snw_holiday_auto_ot_setting.'">AUTO OT('.$snw_holiday_auto_ot_setting.')</a>';
}elseif(($holiday_type=="RH")AND($regular_holiday_auto_ot_setting!="")){
	echo $auto_ot_form='<a href="#" title="'.$regular_holiday_auto_ot_setting.'">AUTO OT('.$regular_holiday_auto_ot_setting.')</a>';
}else{
	$auto_ot_form="";
}

// start process dtr auto atro form query
require(APPPATH.'views/app/time/dtr/process_dtr_auto_atro.php');
// end process dtr auto atro form query



echo '</td>';
echo '<td '.$form_change_rdshift_hl.'>'.$change_sched_form.$change_restday_form.'</td>';
echo '<td '.$form_leave_hl.'>'.$multiple_leave_application_form.''.$pending_leave.'</td>';
echo '<td '.$form_ob_hl.'>'.$multiple_ob_form_raw.'</td>';
echo '<td '.$form_tk_hl.'>'.$time_keeping_complaint_form.'</td>';
echo '<td '.$form_ut_hl.'>'.$under_time_form.'</td>';
echo '</tr>';

            $p_from = date ("Y-m-d", strtotime("+1 day", strtotime($p_from)));

	}

?>

</tbody>
</table>
</div>
<!--//============================================TIME SUMMARY-->
<?php
	if($decimal_place_rounding_setting=="yes"){	// round off
		$total_regular_hrs_restday=round($total_regular_hrs_restday, $decimal_place_no_setting);
		$total_regular_hrs_reg_holiday=round($total_regular_hrs_reg_holiday, $decimal_place_no_setting);
		$total_regular_hrs_reg_holiday_t1=round($total_regular_hrs_reg_holiday_t1, $decimal_place_no_setting);
		$total_regular_hrs_reg_holiday_t2=round($total_regular_hrs_reg_holiday_t2, $decimal_place_no_setting);
		$total_regular_hrs_spec_holiday=round($total_regular_hrs_spec_holiday, $decimal_place_no_setting);
		$total_restday_regular_hrs_spec_holiday=round($total_restday_regular_hrs_spec_holiday, $decimal_place_no_setting);
		$absences_total=round($absences_total, $decimal_place_no_setting);

		$total_regular_nd=round($total_regular_nd, $decimal_place_no_setting);
		$total_restday_nd=round($total_restday_nd, $decimal_place_no_setting);
		$total_reg_holiday_nd=round($total_reg_holiday_nd, $decimal_place_no_setting);
		$total_restday_reg_holiday_nd=round($total_restday_reg_holiday_nd, $decimal_place_no_setting);
		$total_spec_holiday_nd=round($total_spec_holiday_nd, $decimal_place_no_setting);
		$total_restday_spec_holiday_nd=round($total_restday_spec_holiday_nd, $decimal_place_no_setting);
		$undertime_total=round($undertime_total, $decimal_place_no_setting);

		$total_regular_overtime=round($total_regular_overtime, $decimal_place_no_setting);
		$total_restday_overtime=round($total_restday_overtime, $decimal_place_no_setting);
		$total_reg_holiday_overtime=round($total_reg_holiday_overtime, $decimal_place_no_setting);
		$total_restday_reg_holiday_overtime=round($total_restday_reg_holiday_overtime, $decimal_place_no_setting);
		$total_spec_holiday_overtime=round($total_spec_holiday_overtime, $decimal_place_no_setting);
		$total_restday_spec_holiday_overtime=round($total_restday_spec_holiday_overtime, $decimal_place_no_setting);
		$tardiness_total=round($tardiness_total, $decimal_place_no_setting);

		$total_regular_overtime_nd=round($total_regular_overtime_nd, $decimal_place_no_setting);
		$total_restday_overtime_nd=round($total_restday_overtime_nd, $decimal_place_no_setting);
		$total_reg_holiday_overtime_nd=round($total_reg_holiday_overtime_nd, $decimal_place_no_setting);
		$total_restday_reg_holiday_overtime_nd=round($total_restday_reg_holiday_overtime_nd, $decimal_place_no_setting);
		$total_spec_holiday_overtime_nd=round($total_spec_holiday_overtime_nd, $decimal_place_no_setting);
		$total_restday_spec_holiday_overtime_nd=round($total_restday_spec_holiday_overtime_nd, $decimal_place_no_setting);
		$overbreak_total=round($overbreak_total, $decimal_place_no_setting);

	}else{// cut only
		$total_regular_hrs_restday=bcdiv($total_regular_hrs_restday, 1, $decimal_place_no_setting); 
		$total_regular_hrs_reg_holiday=bcdiv($total_regular_hrs_reg_holiday, 1, $decimal_place_no_setting); 
		$total_regular_hrs_reg_holiday_t1=bcdiv($total_regular_hrs_reg_holiday_t1, 1, $decimal_place_no_setting); 
		$total_regular_hrs_reg_holiday_t2=bcdiv($total_regular_hrs_reg_holiday_t2, 1, $decimal_place_no_setting); 
		$total_regular_hrs_spec_holiday=bcdiv($total_regular_hrs_spec_holiday, 1, $decimal_place_no_setting); 
		$total_restday_regular_hrs_spec_holiday=bcdiv($total_restday_regular_hrs_spec_holiday, 1, $decimal_place_no_setting); 
		$absences_total=bcdiv($absences_total, 1, $decimal_place_no_setting); 

		$total_regular_nd=bcdiv($total_regular_nd, 1, $decimal_place_no_setting); 
		$total_restday_nd=bcdiv($total_restday_nd, 1, $decimal_place_no_setting); 
		$total_reg_holiday_nd=bcdiv($total_reg_holiday_nd, 1, $decimal_place_no_setting); 
		$total_restday_reg_holiday_nd=bcdiv($total_restday_reg_holiday_nd, 1, $decimal_place_no_setting); 
		$total_spec_holiday_nd=bcdiv($total_spec_holiday_nd, 1, $decimal_place_no_setting); 
		$total_restday_spec_holiday_nd=bcdiv($total_restday_spec_holiday_nd, 1, $decimal_place_no_setting); 
		$undertime_total=bcdiv($undertime_total, 1, $decimal_place_no_setting); 

		$total_regular_overtime=bcdiv($total_regular_overtime, 1, $decimal_place_no_setting); 
		$total_restday_overtime=bcdiv($total_restday_overtime, 1, $decimal_place_no_setting); 
		$total_reg_holiday_overtime=bcdiv($total_reg_holiday_overtime, 1, $decimal_place_no_setting); 
		$total_restday_reg_holiday_overtime=bcdiv($total_restday_reg_holiday_overtime, 1, $decimal_place_no_setting); 
		$total_spec_holiday_overtime=bcdiv($total_spec_holiday_overtime, 1, $decimal_place_no_setting); 
		$total_restday_spec_holiday_overtime=bcdiv($total_restday_spec_holiday_overtime, 1, $decimal_place_no_setting); 
		$tardiness_total=bcdiv($tardiness_total, 1, $decimal_place_no_setting); 

		$total_regular_overtime_nd=bcdiv($total_regular_overtime_nd, 1, $decimal_place_no_setting); 
		$total_restday_overtime_nd= bcdiv($total_restday_overtime_nd, 1, $decimal_place_no_setting); 
		$total_reg_holiday_overtime_nd=bcdiv($total_reg_holiday_overtime_nd, 1, $decimal_place_no_setting); 
		$total_restday_reg_holiday_overtime_nd=bcdiv($total_restday_reg_holiday_overtime_nd, 1, $decimal_place_no_setting); 
		$total_spec_holiday_overtime_nd=bcdiv($total_spec_holiday_overtime_nd, 1, $decimal_place_no_setting); 
		$total_restday_spec_holiday_overtime_nd=bcdiv($total_restday_spec_holiday_overtime_nd, 1, $decimal_place_no_setting); 
		$overbreak_total=bcdiv($overbreak_total, 1, $decimal_place_no_setting); 

	}

// start process dtr summary query
require(APPPATH.'views/app/time/dtr/process_dtr_summary.php');
// end process dtr atro summary query

?>
<div class="datagrid">

<?php 

// echo " 
// bio is $complete_logs_present_occ : $complete_logs_present_occ_ref <br>
// with tk is $with_tk_logs_present_occ  :$with_tk_logs_present_occ_ref <br>
// with ob is $with_ob_logs_present_occ : $with_ob_logs_present_occ_ref <br>
// with leave is $with_leave_present_occ : $with_leave_present_occ_ref <br>
// restday with logs is $restday_w_logs : $restday_w_logs_ref <br>
// restday without logs is $restday_wo_logs : $restday_wo_logs_ref <br>

// reg hol with logs is $reg_holiday_w_logs : $reg_holiday_w_logs_ref <br>
// reg hol without logs is $reg_holiday_wo_logs : $reg_holiday_wo_logs_ref <br>
// rd- reg hol with logs is $rd_reg_holiday_w_logs : $rd_reg_holiday_w_logs_ref <br>
// rd- reg hol without logs is $rd_reg_holiday_wo_logs : $rd_reg_holiday_wo_logs_ref <br>

// snw hol with logs is $snw_holiday_w_logs : $snw_holiday_w_logs_ref <br>
// snw hol without logs is $snw_holiday_wo_logs : $snw_holiday_wo_logs_ref <br>
// rd- snw hol with logs is $rd_snw_holiday_w_logs : $rd_snw_holiday_w_logs_ref <br>
// rd- snw hol without logs is $rd_snw_holiday_wo_logs : $rd_snw_holiday_wo_logs_ref <br>

//  ";

 ?>
<table   cellpadding="1" cellspacing="3">
	<thead>
		<tr>
			<th>Description </th>
			<th>Regular</th>
			<th>Restday</th>
			<th>Regular Holiday</th>
			<th>Regular Holiday/Restday
			<div class="datagrid">
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td>Type 1</td>
		<td>Type 2</td>
	</tr>
	</table>
	</div>
			</th>
			<th>Special Holiday</th>
			<th>Special Holiday/Restday</th>
			<th>Description</th>
			<th>Total</th>
			<th>Occurence</th>
		</tr>
	</thead>
	<tbody>
<!--//============================================TIME SUMMARY- REGULAR HOURS-->		
	<tr>
		<td>Regular</td>
		<td><?php echo $total_regular_hours; $total_regular_hours=""; ?></td>
		<td><?php echo $total_regular_hrs_restday; $total_regular_hrs_restday="";?></td>
		<td><?php echo $total_regular_hrs_reg_holiday; $total_regular_hrs_reg_holiday="";?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo $total_regular_hrs_reg_holiday_t1; $total_regular_hrs_reg_holiday_t1="";?></td>
		<td><?php echo $total_regular_hrs_reg_holiday_t2; $total_regular_hrs_reg_holiday_t2="";?></td>
	</tr>
	</table>
		</td>
		<td><?php echo $total_regular_hrs_spec_holiday; $total_regular_hrs_spec_holiday="";?></td>
		<td><?php echo $total_restday_regular_hrs_spec_holiday; $total_restday_regular_hrs_spec_holiday="";?></td>
		<td>absences</td>		
		<td><?php echo $absences_total; $absences_total="";?></td>		
		<td><?php echo $absences_occurence;?></td>		
	</tr>	
<!--//============================================TIME SUMMARY- REGULAR ND-->			
	<tr>
		<td>Regular-ND</td>
		<td><?php echo $total_regular_nd; $total_regular_nd="";?></td>
		<td><?php echo $total_restday_nd; $total_restday_nd="";?></td>
		<td><?php echo $total_reg_holiday_nd; $total_reg_holiday_nd="";?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo $total_restday_reg_holiday_nd; $total_restday_reg_holiday_nd="";?></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo $total_spec_holiday_nd; $total_spec_holiday_nd="";?></td>
		<td><?php echo $total_restday_spec_holiday_nd; $total_restday_spec_holiday_nd="";?></td>
		<td>undertime</td>		
		<td><?php echo $undertime_total; $undertime_total="";?></td>		
		<td><?php echo $undertime_occurence;?></td>		
	</tr>	
<!--//============================================TIME SUMMARY- OVERTIME-->			
	<tr>
		<td>OVERTIME</td>
		<td><?php echo $total_regular_overtime; $total_regular_overtime="";?></td>
		<td><?php echo $total_restday_overtime; $total_restday_overtime="";?></td>
		<td><?php echo $total_reg_holiday_overtime; $total_reg_holiday_overtime="";?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo $total_restday_reg_holiday_overtime; $total_restday_reg_holiday_overtime="";?></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo $total_spec_holiday_overtime; $total_spec_holiday_overtime="";?></td>
		<td><?php echo $total_restday_spec_holiday_overtime; $total_restday_spec_holiday_overtime="";?></td>
		<td>tardiness</td>		
		<td><?php echo $tardiness_total; $tardiness_total="";?></td>		
		<td><?php echo $tardiness_occurence;?></td>		
	</tr>	
<!--//============================================TIME SUMMARY- OVERTIME ND-->			
	<tr>
		<td>OVERTIME-ND</td>
		<td><?php echo $total_regular_overtime_nd; $total_regular_overtime_nd="";?></td>
		<td><?php echo $total_restday_overtime_nd; $total_restday_overtime_nd="";?></td>
		<td><?php echo $total_reg_holiday_overtime_nd; $total_reg_holiday_overtime_nd="";?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo $total_restday_reg_holiday_overtime_nd; $total_restday_reg_holiday_overtime_nd="";?></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo $total_spec_holiday_overtime_nd; $total_spec_holiday_overtime_nd="";?></td>
		<td><?php echo $total_restday_spec_holiday_overtime_nd; $total_restday_spec_holiday_overtime_nd="";?></td>
		<td>overbreak</td>		
		<td><?php echo $overbreak_total; $overbreak_total="";?></td>		
		<td><?php echo $overbreak_occurence;?></td>		
	</tr>	
	</tbody>
</table>
<?php
//============================================LEAVE ADJUSTMENT-->
$auto_adjust_leave=$this->time_dtr_model->get_late_approved_form($employee_id,$pay_period_from,$late_approved_leave_daysno_setting,$late_approved_leave_datecounting_setting);
?>
<table>
	<thead>
		<tr>
			<th colspan="3" style="text-align: center;">Auto Adjustment</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td >Leave adjustment</td>
			<td>
			<?php // COUNT
if(!empty($auto_adjust_leave)){
	$leave_adjustment_total=0;
	foreach($auto_adjust_leave as $adjust_leave){
		$adjusted_leave_no_of_days=$adjust_leave->no_of_days;
		$leave_adjustment_total+=$adjusted_leave_no_of_days;		
	}

// start process dtr leave adjustment query
require(APPPATH.'views/app/time/dtr/process_dtr_leave_adjustment.php');
// end process dtr leave adjustment query

	echo $leave_adjustment_total;
		 $leave_adjustment_total="";
}else{
	$leave_adjustment_total=0;
	echo $leave_adjustment_total;
}
			?>				
			</td>
			<td>
			<?php // FORM REFERENCES
if(!empty($auto_adjust_leave)){
$list_of_leave_adjustment="";
	foreach($auto_adjust_leave as $adjust_leave){
		$doc_reference=$adjust_leave->doc_no;
		echo '
<a href="'.base_url().'app/transaction_employees/form_view/'.$doc_reference.'/employee_leave/HR002" target="_blank">'.$doc_reference.'</a>&nbsp;';
$list_of_leave_adjustment.=$doc_reference."(".$adjust_leave->no_of_days.")/";		
	}

// start process dtr leave adjustment list of forms query
require(APPPATH.'views/app/time/dtr/process_dtr_leave_adjustment_forms.php');
// end process dtr leave adjustment list of forms query


}else{

}
			?>						
			</td>
		</tr>
		<tr>
			<td>OT</td>
			<td>content</td>
			<td>doc no</td>
		</tr>
	</tbody>
</table>
</div>
<br>
<?php

//============================================END PROCESS/REPROCESS DTR-->
//============================================START VIEW PROCESSED DTR-->
}else if($selected_dtr_option=="view"){ 

require(APPPATH.'views/app/time/dtr/view_processed_dtr.php');

//============================================END VIEW PROCESSED DTR-->

//============================================START DTR PROCESSING PAYROLL IS ALREADY POSTED-->
}elseif($payslip_status=="posted"){ // process is the selected option but the dtr is already locked.

echo '
<div class="locked_prompt_class">
DTR Processing/Re-processing is not allowed . Payroll is already posted <span class="locked_prompt_class_span">( you may verify at payroll > generate payslip )</span>
</div>
';


//============================================END DTR PROCESSING  PAYROLL IS ALREADY POSTED-->
//============================================START DTR PROCESSING IS ALREADY LOCKED-->
}else{ // process is the selected option but the dtr is already locked.

echo '
<div class="locked_prompt_class">
DTR Processing/Re-processing is already locked. <span class="locked_prompt_class_span">( you may verify at payroll > lock payroll period )</span>
</div>
';

}
//============================================END DTR PROCESSING IS ALREADY LOCKED-->

	} // <- END FOREACH OF EMPLOYEE
}else{
	echo "<span style='color:#ff0000;'>no employee found, check your filter options selected.</span>";
}


?>


    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
