<?php
$company_id=$this->input->post('company_id');
require(APPPATH.'views/app/time/dtr/dtr_theme.php');
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

<?php
require_once(APPPATH.'views/app/time/dtr/dtr_design.php');
?>

  </head>

<?php
$is_dtr_locked=0;
$is_payslip_lock=0;

//$selected_dtr_option=$this->input->post('dtr_option'); 
if($selected_dtr_option=="view"){ 
}else{
//include 'processing_header.php';
}
$bilang_ng_bilang=0;


$wDivision=$company_info->wDivision;
$company_name=$company_info->company_name;

$pay_type=$this->input->post('pay_type');
$pay_type_group=$this->input->post('pay_type_group');

/*
view: view saved dtr, 
process: reprocess dtr, 
check: absences,compensation checker
*/


if($selected_dtr_option=="check"){ 
	$total_process="";
	$total_unprocess="";
echo '
<div class="datagrid">
<table  >
	<thead>
		<tr>
			<th width="10%">EMPLOYEE ID</th>
			<th width="20%">NAME</th>
			<th width="10%">DTR STATUS</th>


		</tr>
	</thead>
</table>
</div>


';
//			<th width="5%">Absences</th>

}else{

}



//$pay_period=$this->input->post('pay_period');
$division=$this->input->post('division');
$department=$this->input->post('department');
$section=$this->input->post('section');

//============================================GET COMPANY TIME/DTR SETTINGS POLICY
require_once(APPPATH.'views/app/time/dtr/check_dtr_policy.php');

//============================================PAYROLL PERIOD VARIABLE LISTS
if(!empty($pay_period_info)){

$complete_from=$pay_period_info->complete_from;
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

//============================================ START INITIALIZE DTR SUMMARY VARIABLES
$reset_dtr_success_count="";// list of incentive leave form.
$reset_dtr_failed_count="";// list of incentive leave form.
$list_of_il_ot_form="";// list of incentive leave form.
$late_tracker_type="";
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

$im_compress=0;
//============================================ END INITIALIZE DTR SUMMARY VARIABLES

//============================================ START CHECK ACTION SELECTED

if($selected_dtr_option=="process"){

	$dtr_processing_state=$this->time_dtr_model->check_payroll_period_dtr_state($pay_period);
	if(!empty($dtr_processing_state)){
		$is_dtr_locked=$dtr_processing_state->d_t_r;
		$is_payslip_lock=$dtr_processing_state->generate_payslip;
		$to_do="";
	}else{
		$to_do="proceed_process";
	}
		
}else{
		$to_do="proceed_view";
		
}

//============================================ END CHECK ACTION SELECTED
if(!empty($employee)){
		$count_employees = 0; // count employees
		
	foreach($employee as $emp){

		$absences_total_tracker="";
		$regular_hours_total_tracker="";
//============================================ START EMPLOYEE INFOR VARIABLE LISTS
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
		$division_id=$emp->division_id;
		$section_id=$emp->section;

		// $mysalary_no_of_hours=$emp->no_of_hours;

//============================================ START CHECK IF COMPRESS WORK WEEK
		$isCompressSched=$this->time_dtr_model->IsCompressSchedule($employee_id);
		$compress_per_hour=0;
		if(!empty($isCompressSched)){
			$im_compress=1;
			$dtr_required_halfday_hrs=$isCompressSched->halfday_required_hrs;//required actual hrs to treat as halfday
			$late_as_half_day_policy=$isCompressSched->halfday_required_hrs;//count tardiness as halfday absent
			$ut_as_half_day_policy=$isCompressSched->halfday_required_hrs;//count undertime as halfday absent

			$compress_mon=$isCompressSched->c_mon;
			$compress_tue=$isCompressSched->c_tue;
			$compress_wed=$isCompressSched->c_wed;
			$compress_thu=$isCompressSched->c_thu;
			$compress_fri=$isCompressSched->c_fri;
			$compress_sat=$isCompressSched->c_sat;
			$compress_sun=$isCompressSched->c_sun;
		
			$compress_per_hour=$isCompressSched->allow_per_hour_filing;

			/*if yes : follow regular hrs as deduction if no standard wholeday halfday*/
	
		}else{
			$im_compress=0;
			$compress_mon=0;
			$compress_tue=0;
			$compress_wed=0;
			$compress_thu=0;
			$compress_fri=0;
			$compress_sat=0;
			$compress_sun=0;
			$compress_per_hour=0;
		}


//============================================ END CHECK IF COMPRESS WORK WEEK


//============================================ START CHECK IF DTR IS ALREADY MANUALY COMPUTED.

$checkManualDtr=$this->time_dtr_model->checkManualDtr($pay_period,$month_cover,$employee_id);
if(!empty($checkManualDtr)){

	//$to_do="proceed_view";	
	$is_dtr_manually_computed_already=1;

}else{

	$is_dtr_manually_computed_already=0;

}


//============================================ START CHECK IF PAYSLIP IS ALREADY POSTED
$the_payslip_status=$this->time_dtr_model->check_payslip_status($employee_id,$company_id,$month_cover,$pay_period);
if(!empty($the_payslip_status)){
	$payslip_status="posted";
}else{
	$payslip_status="";
}
//============================================ START  CHECK EMPLOYEE PAYROLL PERIOD GROUP
$getmy_payroll_period_group=$this->time_dtr_model->spec_payroll_period_group($emp->payroll_period_group_id);
$my_group_name=$getmy_payroll_period_group->group_name;

// //============================================ START GET SALARY RATE
$getmysalaryrate=$this->time_dtr_model->getSalary($complete_from,$emp->employee_id);
// $getmysalaryrate=$this->time_dtr_model->getSalary($salary_rate);
if(!empty($getmysalaryrate)){
	$mysalaryrate=$getmysalaryrate->salary_rate_name;
	$mysalary_no_of_hours=$getmysalaryrate->no_of_hours;
	$salary_rate=$getmysalaryrate->salary_rate;
}else{ 
	/*
	for case no compensation setup yet. or for company not using payroll module of the system
	salary rate is required w/ the system . the default if no setup would be monthly rate 8 hrs a day.
	*/
	$mysalaryrate="no setup | note: default no of hrs : 8 & default salary rate : monthly";
	$mysalary_no_of_hours="8";
	$salary_rate="4";
}


//============================================ START CHECK COMPANY DIVISION AND SUBSECTION SETTING
require(APPPATH.'views/app/time/dtr/check_division_and_subsection.php');
//============================================ END CHECK COMPANY DIVISION AND SUBSECTION SETTING

$count_employees++; // count employees

//================== start one query by classication settings.
$byclass_dtr_setting=$this->time_dtr_model->get_all_time_setting_value($classification_id,$employment_id,$company_id);
if(!empty($byclass_dtr_setting)){
// initialize standard default value.

$per_hour_leave="no";	
$my_late_grace_period=0;
$my_ut_deduction_rule="no"; 
$my_ut_grace_period=0;
$my_set_advance_ot="no";
$reg_nd_setting="no";
$none_reg_nd_setting="no";
$regular_day_nd_break_deduction_setting="no";
$regular_holiday_nd_break_deduction_setting="no";
$snw_holiday_nd_break_deduction_setting="no";
$restday_nd_break_deduction_setting="no";
$regular_holiday_ot_break_deduction_setting="no";
$snw_holiday_ot_break_deduction_setting="no";
$restday_ot_break_deduction_setting="no";
$regular_holiday_auto_ot_setting="";
$snw_holiday_auto_ot_setting="";
$reg_hol_on_rd_no_att_setting="no";
$monthlyrate_semimonth_reg_hour_base="104"; 
$compute_break_rule="";
$break_before_overtime="";
	foreach($byclass_dtr_setting as $ds){
		$tsv_id=$ds->time_setting_id;
		$setting_value=$ds->setting_value;
		if($tsv_id=="1"){//== START CHECK LATE GRACE PERIOD
			$my_late_grace_period=$setting_value;
		}elseif($tsv_id=="44"){//== START Approved undertime do not deduct to payroll?
			$my_ut_deduction_rule=$setting_value;
		}elseif($tsv_id=="2"){//== START CHECK UNDER TIME GRACE PERIOD
			$my_ut_grace_period=$setting_value;
		}elseif($tsv_id=="6"){//== START CHECK ADVANCE OVER TIME
			$my_set_advance_ot=$setting_value;
		}elseif($tsv_id=="8"){//== START CHECK Regular Night Differential
			$reg_nd_setting=$setting_value;
		}elseif($tsv_id=="3"){//== START CHECK Night Differential (0.13%)
			$none_reg_nd_setting=$setting_value;
		}elseif($tsv_id=="49"){//== START CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (regular days)
			$regular_day_nd_break_deduction_setting=$setting_value;
		}elseif($tsv_id=="50"){//== START CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (regular holidays) 
			$regular_holiday_nd_break_deduction_setting=$setting_value;
		}elseif($tsv_id=="51"){//== START CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (special non-working holidays)
			$snw_holiday_nd_break_deduction_setting=$setting_value;
		}elseif($tsv_id=="52"){//== START CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (restday)
			$restday_nd_break_deduction_setting=$setting_value;
		}elseif($tsv_id=="28"){//== START CHECK 1hr BREAK DEDUCTION on OT of 9 hrs shift (regular holidays) 
			$regular_holiday_ot_break_deduction_setting=$setting_value;
		}elseif($tsv_id=="54"){//== START CHECK 1hr BREAK DEDUCTION on OT of 9 hrs shift (special non-working holidays) 
			$snw_holiday_ot_break_deduction_setting=$setting_value;
		}elseif($tsv_id=="55"){//== START CHECK 1hr BREAK DEDUCTION on OT of 9 hrs shift (restday)
			$restday_ot_break_deduction_setting=$setting_value;
		}elseif($tsv_id=="40"){//== START CHECK Auto first 8hrs as approved OT for Regular Holidays
				$regular_holiday_auto_ot_setting=$setting_value;
				if($regular_holiday_auto_ot_setting=="yes"){
					$regular_holiday_auto_ot_setting=8;
				}else{
					$regular_holiday_auto_ot_setting="";
				}
		}elseif($tsv_id=="53"){//== START CHECK Auto first 8hrs as approved OT for Special non-working Holidays 
				$snw_holiday_auto_ot=$setting_value;
				if($snw_holiday_auto_ot=="yes"){
					$snw_holiday_auto_ot_setting=8;
				}else{
					$snw_holiday_auto_ot_setting="";
				}
		}elseif($tsv_id=="33"){//== START CHECK Pay Rest day falling on Regular Hol. w/o attendance?
			$reg_hol_on_rd_no_att_setting=$setting_value;
		}elseif($tsv_id=="59"){//== START CHECK monthly salary rate - semi monthly pay type ( regular hours base 
			$monthlyrate_semimonth_reg_hour_base=$setting_value;
		}elseif($tsv_id=="43"){//== START CHECK monthly salary rate - semi monthly pay type ( regular hours base 
			$compute_break_rule=$setting_value;
		}elseif($tsv_id=="48"){//== Allow per hour leave application?
			$per_hour_leave=$setting_value;
		}elseif($tsv_id=="71"){//== Break before Overtime | during regular day only.
			$break_before_overtime=$setting_value;
		}else{

		}

if($my_late_grace_period=="no setting"){
	$my_late_grace_period=0;
}else{

}

	}


}else{
	// initialize standard default value if theres no setup yet.
	$per_hour_leave="no";
	$compute_break_rule="";
	$my_late_grace_period=0;
	$my_ut_deduction_rule="no"; 
	$my_ut_grace_period=0;
	$my_set_advance_ot="no";
	$reg_nd_setting="no";
	$none_reg_nd_setting="no";
	$regular_day_nd_break_deduction_setting="no";
	$regular_holiday_nd_break_deduction_setting="no";
	$snw_holiday_nd_break_deduction_setting="no";
	$restday_nd_break_deduction_setting="no";

	$regular_holiday_ot_break_deduction_setting="no";
	$snw_holiday_ot_break_deduction_setting="no";
	$restday_ot_break_deduction_setting="no";

	$regular_holiday_auto_ot_setting="";
	$snw_holiday_auto_ot_setting="";
	$reg_hol_on_rd_no_att_setting="no";
	$monthlyrate_semimonth_reg_hour_base="104"; 
	$break_before_overtime=""; 
}

if($im_compress=="1"){
		if($per_hour_leave=="no"){
			if($compress_per_hour=="1"){
				$per_hour_leave="yes";
			}else{
			}
		}else{
		}
}else{
}



//================== end one query by classication settings.



// //============================================ START CHECK LATE GRACE PERIOD
// $get_late_grace_period= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,1);
// if(!empty($get_late_grace_period)){
// 	$my_late_grace_period=$get_late_grace_period->setting_value;
// }else{
// 	$my_late_grace_period=0;
// }

// //============================================ START Approved undertime do not deduct to payroll?
// $my_ut_deduction_policy= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,44);
// if(!empty($my_ut_deduction_policy)){
// 	$my_ut_deduction_rule=$my_ut_deduction_policy->setting_value;
// }else{
// 	$my_ut_deduction_rule="no"; // no setting equiavalent to do not remove ut deduction
// }
// //============================================ START CHECK UNDER TIME GRACE PERIOD
// $get_ut_grace_period= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,2);
// if(!empty($get_ut_grace_period)){
// 	$my_ut_grace_period=$get_ut_grace_period->setting_value;
// }else{
// 	$my_ut_grace_period=0;

// }
// //============================================ START CHECK ADVANCE OVER TIME
// $get_advance_ot= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,6);
// if(!empty($get_advance_ot)){
// 	$my_set_advance_ot=$get_advance_ot->setting_value;
// }else{
// 	$my_set_advance_ot="no";

// }

// //============================================ START CHECK Regular Night Differential
// $get_reg_nd_setting= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,8);
// if(!empty($get_reg_nd_setting)){
// 	$reg_nd_setting=$get_reg_nd_setting->setting_value;
// }else{
// 	$reg_nd_setting="no";

// }
// //============================================ START CHECK Night Differential (0.13%)
// $get_none_reg_nd_setting= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,3);
// if(!empty($get_none_reg_nd_setting)){
// 	$none_reg_nd_setting=$get_none_reg_nd_setting->setting_value;
// }else{
// 	$none_reg_nd_setting="no";
// }

// 															/*ND DEDUCTION SETTING*/

// //============================================ START CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (regular days)
// $get_regular_day_nd_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,49);
// if(!empty($get_regular_day_nd_break_deduction)){
// 	$regular_day_nd_break_deduction_setting=$get_regular_day_nd_break_deduction->setting_value;
// }else{
// 	$regular_day_nd_break_deduction_setting="no";
// }
// //============================================ START CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (regular holidays) 
// $get_reg_holiday_nd_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,50);
// if(!empty($get_reg_holiday_nd_break_deduction)){
// 	$regular_holiday_nd_break_deduction_setting=$get_reg_holiday_nd_break_deduction->setting_value;
// }else{
// 	$regular_holiday_nd_break_deduction_setting="no";
// }
// //============================================ START CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (special non-working holidays)
// $get_snw_holiday_nd_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,51);
// if(!empty($get_snw_holiday_nd_break_deduction)){
// 	$snw_holiday_nd_break_deduction_setting=$get_snw_holiday_nd_break_deduction->setting_value;
// }else{
// 	$snw_holiday_nd_break_deduction_setting="no";
// }
// //============================================ START CHECK 1hr BREAK DEDUCTION on ND of 9 hrs shift (restday)
// $get_restday_nd_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,52);
// if(!empty($get_restday_nd_break_deduction)){
// 	$restday_nd_break_deduction_setting=$get_restday_nd_break_deduction->setting_value;
// }else{
// 	$restday_nd_break_deduction_setting="no";
// }
// 																	/*END ND DEDUCTION SETTING*/

// 																	/*OT DEDUCTION SETTING*/

// //============================================ START CHECK 1hr BREAK DEDUCTION on OT of 9 hrs shift (regular holidays) 
// $get_reg_holiday_ot_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,28);
// if(!empty($get_reg_holiday_ot_break_deduction)){
// 	$regular_holiday_ot_break_deduction_setting=$get_reg_holiday_ot_break_deduction->setting_value;
// }else{
// 	$regular_holiday_ot_break_deduction_setting="no";
// }

// //============================================ START CHECK 1hr BREAK DEDUCTION on OT of 9 hrs shift (special non-working holidays) 
// $get_snw_holiday_ot_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,54);
// if(!empty($get_snw_holiday_ot_break_deduction)){
// 	$snw_holiday_ot_break_deduction_setting=$get_snw_holiday_ot_break_deduction->setting_value;
// }else{
// 	$snw_holiday_ot_break_deduction_setting="no";
// }

// //============================================ START CHECK 1hr BREAK DEDUCTION on OT of 9 hrs shift (restday)
// $get_restday_ot_break_deduction= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,55);
// if(!empty($get_restday_ot_break_deduction)){
// 	$restday_ot_break_deduction_setting=$get_restday_ot_break_deduction->setting_value;
// }else{
// 	$restday_ot_break_deduction_setting="no";
// }

// 																	/*END OT DEDUCTION SETTING*/

// //============================================ START CHECK Auto first 8hrs as approved OT for Regular Holidays
// $get_regular_holiday_auto_ot= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,40);
// if(!empty($get_regular_holiday_auto_ot)){
// 	$regular_holiday_auto_ot_setting=$get_regular_holiday_auto_ot->setting_value;
// 	if($regular_holiday_auto_ot_setting=="yes"){
// 		$regular_holiday_auto_ot_setting=8;
// 	}else{
// 		$regular_holiday_auto_ot_setting="";
// 	}
// }else{
// 	$regular_holiday_auto_ot_setting="";
// }


// //============================================ START CHECK Auto first 8hrs as approved OT for Special non-working Holidays 
// $get_snw_holiday_auto_ot= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,53);
// if(!empty($get_snw_holiday_auto_ot)){
// 	$snw_holiday_auto_ot=$get_snw_holiday_auto_ot->setting_value;
// 	if($snw_holiday_auto_ot=="yes"){
// 		$snw_holiday_auto_ot_setting=8;
// 	}else{
// 		$snw_holiday_auto_ot_setting="";
// 	}
// }else{
// 	$snw_holiday_auto_ot_setting="";
// }

// //============================================ START CHECK Pay Rest day falling on Regular Hol. w/o attendance?
// $get_restday_regular_holiday_no_att_pol= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,33);
// if(!empty($get_restday_regular_holiday_no_att_pol)){
// 	$reg_hol_on_rd_no_att_setting=$get_restday_regular_holiday_no_att_pol->setting_value;
// }else{
// 	$reg_hol_on_rd_no_att_setting="no";
// }

// //============================================ START CHECK monthly salary rate - semi monthly pay type ( regular hours base 
// $get_monthly_semimonth_pt_reghrbase= $this->time_dtr_model->get_time_setting_value($classification_id,$employment_id,$company_id,59);
// if(!empty($get_monthly_semimonth_pt_reghrbase)){
// 	$monthlyrate_semimonth_reg_hour_base=$get_monthly_semimonth_pt_reghrbase->setting_value;
// }else{
// 	$monthlyrate_semimonth_reg_hour_base="104"; // standard
// }
if($selected_dtr_option=="check"){

require(APPPATH.'views/app/time/dtr/check_dtr_status_body.php');

}else{
//============================================ START SHOW DTR HEADER
require(APPPATH.'views/app/time/dtr/dtr_header.php');
//============================================ END SHOW DTR HEADER
}

?>

<tbody>
<?php
	$p_from = $pay_period_from; 	// Start payroll period
	$p_to = $pay_period_to; 	// ENd payroll period

//============================================ START OCCURENCE & REF TIME SUMMARY INITIALIZATION
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

	$leave_reg_hrs=0;
	$approve_leave_wopay_count="";//important instead of 0
	$approve_leave_wpay_count="";//important instead of 0
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


//============================================ START CHECK EARLY CUTOFF SETTING IF ANY FOR THE PREVIOUS CUTOFF.
require(APPPATH.'views/app/time/dtr/check_auto_early_cutoff_setting.php');
//============================================ END CHECK EARLY CUTOFF SETTING IF ANY FOR THE PREVIOUS CUTOFF.
if(($selected_dtr_option=="process")AND ($to_do=="proceed_process")AND($payslip_status!="posted")AND($is_dtr_manually_computed_already=="0")){


	while (strtotime($p_from) <= strtotime($p_to)) {

//============================================ START CHECK EARLY CUTOFF SETTING IF ANY FOR THE PREVIOUS CUTOFF.                 

require(APPPATH.'views/app/time/dtr/check_auto_early_cutoff.php');

//============================================ END CHECK EARLY CUTOFF SETTING IF ANY FOR THE PREVIOUS CUTOFF.
		$period_dmonth=substr($p_from, 5, 2);
		$period_dday=substr($p_from, 8, 2);
		$period_dyear=substr($p_from, 0, -6);	


  	$two_digit_day=substr($p_from, -2, 2)."<br>";
	$dayOfWeek = date("l", strtotime($p_from));

	if($dayOfWeek=="Sunday"){
		$sunday_color='style="background-color:'.$hl_sunday.';"';
	}else{
		$sunday_color='';
	}

//============================================ START CHECK EARLY CUTOFF SETTING IF ANY FOR THE CURRENT CUTOFF.

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


//============================================ START CHECK CHANGE RESTDAY FORM
$get_advance_duty_form= $this->time_dtr_model->get_advance_duty_form($emp->employee_id,$p_from);
if(!empty($get_advance_duty_form)){
	$with_advance_duty_form="yes";
	$ad_id=$get_advance_duty_form->id;
	$ad_covered_date=$get_advance_duty_form->covered_date;

	$advance_shift_in_date=$get_advance_duty_form->advance_shift_in_date;
	$advance_shift_out_date=$get_advance_duty_form->advance_shift_out_date;

	$ad_shiftin=$get_advance_duty_form->advance_shift_in;
	$ad_shiftout=$get_advance_duty_form->advance_shift_out;
	$ad_in_date=$get_advance_duty_form->actual_in_date;
	$ad_out_date=$get_advance_duty_form->actual_out_date;
	$ad_timein=$get_advance_duty_form->actual_timein;
	$ad_timeout=$get_advance_duty_form->actual_timeout;
	$check_att_date_out=$ad_out_date;

}else{
	$ad_id="";
	$with_advance_duty_form="";
	$ad_covered_date="";
	$ad_shiftin="";
	$ad_shiftout="";
	$ad_in_date="";
	$ad_out_date="";
	$ad_timein="";
	$ad_timeout="";

}



//============================================ START CHECK CHANGE RESTDAY FORM
$get_change_restday= $this->time_dtr_model->get_change_restday($emp->employee_id,$p_from);
if(!empty($get_change_restday)){

	if($p_from==$get_change_restday->orig_rest_day){
		$change_restday_form= '<a href="'.base_url().'app/transaction_employees/form_view/'.$get_change_restday->doc_no.'/emp_change_rest_day/HR027" target="_blank" title="'.$get_change_restday->doc_no.'">change restday from</a>';
	}else{
		$change_restday_form= '<a href="'.base_url().'app/transaction_employees/form_view/'.$get_change_restday->doc_no.'/emp_change_rest_day/HR027" target="_blank" title="'.$get_change_restday->doc_no.'">change restday to</a>';
	}
	
	$old_restday=$get_change_restday->orig_rest_day;
	$new_restday=$get_change_restday->request_rest_day;
	$change_restday_doc_no=$get_change_restday->doc_no;
}else{
	$change_restday_form="";
	$old_restday="";
	$new_restday="";
	$change_restday_doc_no="";
}


//============================================ START CHECK WORKING SCHEDULE - FIXED SCHED
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
	$fixed_schedule_state="TRUE";
	$flexi_schedule_state="FALSE";
	$check_fixed_schedule="fixed schedule : $p_from YES";
	$check_flexi_schedule="Flexi schedule : $p_from NO";




}
//============================================ END OF NOT FIXED SCHEDULE 
else{
$fixed_schedule_state="FALSE";

//============================================ START CHECK WORKING SCHEDULE - FLEXI SCHED
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

$fixed_schedule_state="FALSE";
$flexi_schedule_state="TRUE";

//============================================ END CHECK FLEXI SCHEDULE
}else{
$flexi_schedule_state="FALSE";

$flexi_shift_in="none";
$flexi_shift_out="none";

$fixed_shift_in="none";
$fixed_shift_out="none";
$is_rest_day="no";



$check_flexi_schedule="Flexi schedule : $p_from NO";
$check_fixed_schedule="fixed schedule : $p_from NO";	


	} // end of not flexi schedule
}// end of not fixed schedule



//============================================ START CHECK WORKING SCHEDULE - INDIVIDUAL PLOTTED
		$get_frm_working_sched_tble= $this->time_dtr_model->get_frm_working_sched_tble($company_id,$emp->employee_id,$p_from);
		$get_manager_group_plotted= $this->time_dtr_model->get_manager_sched($emp->employee_id,$p_from);

		if(!empty($get_manager_group_plotted)){
			$mngr_shift_in=$get_manager_group_plotted->shift_in;
			$mngr_shift_out=$get_manager_group_plotted->shift_out;
			$manager_plotted_state="TRUE";
		}else{
			$manager_plotted_state="";
		}


		if(!empty($get_frm_working_sched_tble)){//start of check sched in working_sched table

			if($get_frm_working_sched_tble->restday=="1"){
					if($p_from==$old_restday){	

						$new_restday_date_sched= $this->time_dtr_model->get_frm_working_sched_tble($company_id,$emp->employee_id,$new_restday);	// get new restday "date" plotted sched
						if(!empty($new_restday_date_sched)){
							$ws_shift_in=$new_restday_date_sched->shift_in;
							$ws_shift_out=$new_restday_date_sched->shift_out;
						}else{
							$ws_shift_in="";
							$ws_shift_out=="";
						}			

						$is_rest_day="no";

						if($manager_plotted_state=="TRUE"){ // JUST pass manager plotted to ind plotted query.
							$ws_shift_in=$mngr_shift_in;
							$ws_shift_out=$mngr_shift_out;	
						}else{
							$ws_shift_in="";
							$ws_shift_out="";				
						}

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
			$ws_schedule_state="TRUE";
			$check_ws_schedule="wS : $p_from YES";

		}else{
				
				if($p_from==$new_restday){
						$ws_shift_in=""; // suppose none
						$ws_shift_out=""; // suppose none
						$is_rest_day="yes";

					$ws_schedule_state="TRUE";
					$check_ws_schedule="wS : $p_from YES";


				}else{
						if($manager_plotted_state=="TRUE"){ // JUST pass manager plotted to ind plotted query.
							$ws_shift_in=$mngr_shift_in;
							$ws_shift_out=$mngr_shift_out;	
						}else{
							$ws_shift_in="";
							$ws_shift_out="";				
						}


						if($fixed_schedule_state=="TRUE" OR $flexi_schedule_state=="TRUE"){
						}else{
							$is_rest_day="no";
						}

					
						$ws_schedule_state="FALSE";
						$check_ws_schedule="wS : $p_from NO";	

				}




		}//end of check sched in working_sched table


//============================================ START CHECK WORKING SCHEDULE - CHANGE SCHEDULE
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


//echo "$p_from $check_ws_schedule | $check_fixed_schedule | $check_flexi_schedule :: $fixed_shift_in <br>";
//============================================ START GET OFFICIAL SHIFTS
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
		if($ws_schedule_state=="TRUE"){
			$shift_in=$ws_shift_in;
			$shift_out=$ws_shift_out;	
		}else{
			$shift_in=$fixed_shift_in;
			$shift_out=$fixed_shift_out;	

		}

	}

	if($is_rest_day=="yes"){
		$restday_official="<i class='fa fa-check'></i>";
	}else{
		$restday_official="";		
	}	



}


	

// if(($holiday_type)AND($is_rest_day=="yes")){
	
// }else{

// }

//============================================ START FAST SCHEDULE ROOT DEBUGGER 

$check_fixed_schedule;
$check_ws_schedule;
$check_flexi_schedule;

//============================================ START GET HOLIDAYS
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
			$restday_official=""; 
	}elseif(($holiday_type=="RH")AND ($is_rest_day=="yes")){
			$regular_holiday_official="";
			$restday_regular_holiday_official="<i class='fa fa-check'></i>";
			$special_holiday_official="";
			$restday_special_holiday_official="";
			$restday_official=""; 

	}elseif(($holiday_type=="SNW")AND ($is_rest_day=="no")){
			$regular_holiday_official="";
			$restday_regular_holiday_official="";
			$special_holiday_official="<i class='fa fa-check'></i>";
			$restday_special_holiday_official="";
			$restday_official=""; 
	}elseif(($holiday_type=="SNW")AND ($is_rest_day=="yes")){
			$regular_holiday_official="";
			$restday_regular_holiday_official="";
			$special_holiday_official="";
			$restday_special_holiday_official="<i class='fa fa-check'></i>";
			$restday_official=""; 
	}else{

			$regular_holiday_official="";
			$restday_regular_holiday_official="";	
			$special_holiday_official="";	
			$restday_special_holiday_official="";		
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


//============================================ START CHECK TIME KEEPING COMPLAINT FORM
$get_tkcomplaint= $this->time_dtr_model->get_tkcomplaint($emp->employee_id,$p_from);

if(!empty($get_tkcomplaint)){
		//$tk_in=$get_tkcomplaint->tk_date;
	
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

//============================================ START CHECK OFFICICAL BUSINESS FORM
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
				// abs : force positive
		$check_first_ob_in=abs($shift_in-$first_ob_in); 
		$check_second_ob_in=abs($shift_in-$second_ob_in);

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
	$first_ob_in="";
	$second_ob_in="";
	$first_ob_out="";
	$second_ob_out="";

	$official_business_status="none";// check if with ob			
	$official_business_form="";
	$ob_actual_in="";	
	$ob_actual_out="";	
	$official_business_doc_no="";

	$multiple_ob_time_raw="";
	$multiple_ob_form_raw="";
	$multiple_ob_form_details="";
}


if($per_hour_leave=="yes"){

	$leave_pay_type="";
	$leave_application_status="";
	$multiple_leave_application_details="";
	$pending_leave="";
	$leave_fast_hol_reference="";
	$multiple_leave_application_form="";
	$multiple_leave_state="";
	$leave_day_type_status="";
	$leave_code="";
	$halfleave="";
	$leave_color_pay_type="";

	//p_from_phl : means per date per hour leave 
	$p_from_phl="p_from_phl_".$employee_id.$period_dyear.$period_dmonth.$period_dday;//phl : means per hour leave
	$$p_from_phl="";

						$get_perhr_leave= $this->time_dtr_model->get_per_hour_leave_form($emp->employee_id,$p_from);
						$count_filed_leave=count($get_perhr_leave);

						if(!empty($get_perhr_leave)){

							foreach($get_perhr_leave as $phleave){

								$leave_code=$phleave->leave_code;
								$leave_type=$phleave->leave_type;
								$leave_day_type=$phleave->no_of_days;
								$leave_pay_type=$phleave->with_pay;
								$leave_type_id=$phleave->leave_type_id;
								$leave_type_doc_no=$phleave->doc_no;
								$leave_hours=$phleave->total_hours+$phleave->total_minutes;

						if($decimal_place_rounding_setting=="yes"){
							// round off
							$leave_hours=round($leave_hours, $decimal_place_no_setting);
						}else{
							// cut only
							$leave_hours=bcdiv($leave_hours, 1, $decimal_place_no_setting); 
						}

								if($leave_hours=="0.5"){
									$halfleave=" (halfday)";
								}else{

								}
								

								if($p_from==$phleave->the_date){
									$$p_from_phl+=$leave_hours;

									$multiple_leave_application_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$phleave->doc_no.'/employee_leave/HR002" target="_blank" title="'.$leave_hours.' hour(s) leave" > '.$leave_code.'('.$leave_hours.') </a>';
								}else{

								}

					$leave_application_status="yes";// check if with leave
					$leave_application_doc_no=$phleave->doc_no;
					$leave_application_details=$leave_application_doc_no."/$leave_type/$leave_pay_type/$leave_color_pay_type/$halfleave*";

					if($count_filed_leave=="1"){
						$multiple_leave_application_form=$multiple_leave_application_form;
						$multiple_leave_application_details=$leave_application_details;
					}else{

						$multiple_leave_state.=$leave_pay_type;
						$multiple_leave_application_form.=$multiple_leave_application_form;
						$multiple_leave_application_details.=$leave_application_details;

					}


							}//end of foreach leave

		//==== start with pay
							if($leave_hours>0){
									$leave_fast_hol_reference=$leave_hours;
									$leave_reg_hrs+=$leave_hours;
									$with_leave_present_occ++;
									$with_leave_present_occ_ref.=$p_from." ";
									$approve_leave_wpay_count.="($leave_type_id-$leave_hours)x";
									require(APPPATH.'views/app/time/dtr/process_dtr_leave_types.php');
		//echo " $p_from | $with_leave_present_occ <br>";
							}else{

							}



						}else{
						}






}else{



//============================================ START CHECK LEAVE APPLICATION FORM
//====== pending
$get_pending_leave_form= $this->time_dtr_model->get_pending_leave_form($emp->employee_id,$p_from);
$count_filed_pending_leave=count($get_pending_leave_form);
$pending_leave="";
if(!empty($get_pending_leave_form)){

	foreach($get_pending_leave_form as $leave_pending){
		$leave_pending_code=$leave_pending->leave_code;
		$leave_pending_type=$leave_pending->leave_type;
		$leave_pending_no_of_days=$leave_pending->no_of_days;
		$leave_pending_doc_no=$leave_pending->doc_no;
		$pending_leave.='<a href="'.base_url().'app/transaction_employees/form_view/'.$leave_pending_doc_no.'/employee_leave/HR002" target="_blank" title="'.$leave_pending_doc_no.' : pending ('.$leave_pending_no_of_days.')"><span style="color:#F53712;"> '.$leave_pending_code.'</span></a><br>';
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
	$leave_code="";
	foreach($get_leave_form as $get_leave_form){

		$leave_code=$get_leave_form->leave_code;
		$leave_type=$get_leave_form->leave_type;
		$leave_day_type=$get_leave_form->no_of_days;
		$leave_pay_type=$get_leave_form->with_pay;

		$leave_type_id=$get_leave_form->leave_type_id;
		$leave_type_doc_no=$get_leave_form->doc_no;


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
			//echo "$p_from |    $leave_day_type_status<br>";
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

		$leave_application_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$get_leave_form->doc_no.'/employee_leave/HR002" target="_blank" title="'.$leave_pay_type.'" '.$leave_color_pay_type.'> '.$leave_code.$halfleave.' </a>';
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

	}elseif($multiple_leave_state=="with paywith pay"){
		$leave_pay_type="with pay";
		$leave_day_type=1;
		$leave_day_type_status="wholeday";
	}else{

	}

	if($leave_pay_type=="with pay"){
		$leave_fast_hol_reference=$leave_day_type;
		$leave_reg_hrs+=$leave_day_type;
		$with_leave_present_occ++;
		$with_leave_present_occ_ref.=$p_from." ";
		$approve_leave_wpay_count.="($leave_type_id-$leave_day_type)x";

		require(APPPATH.'views/app/time/dtr/process_dtr_leave_types.php');

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


}


//============================================ START CHECK ATTENDANCE TABLES LOGS
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

	if($with_advance_duty_form=="yes"){

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


}


//============================================ START CHECK COMPUTE BREAK POLICY
	if($compute_break_rule=="yes"){

//============================================ CHECK BREAK SETUP OF SHIFTS============================================
		$get_break_policy= $this->time_dtr_model->get_break_policy($classification_id,$company_id,$shift_in,$shift_out);
		if(!empty($get_break_policy)){
			$lunch_break_allowed_hour=$get_break_policy->lunch_break;
			$break_1_allowed_hour=$get_break_policy->break_1;
			$break_2_allowed_hour=$get_break_policy->break_2;
			// break 1
				if(($att_break_1_out!="")AND($att_break_1_in!="")){
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
				if(($att_lunch_break_out!="")AND($att_lunch_break_in!="")){
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
				if(($att_break_2_out!="")AND($att_break_2_in!="")){
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



$over_break=$break_1_over_break+$lunch_break_over_break+$break_2_over_break;
if($over_break=="0"){
	$over_break="";
}else{
	$over_break=$over_break;
}

if($marked_as_early_cutoff_coverage=="yes"){
	$over_break="";
}else{

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


			if($actual_out==""){
					$actual_out="--:--";
			}elseif($actual_in==""){
					$actual_out="--:--";
			}else{

			}



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

}elseif(($time_keeping_complaint_status=="yes")&&($official_business_status=="yes")&&($attendance_table_status=="yes")) { // att tables = true , ob = false

	//check tk complain & ob combination
	require(APPPATH.'views/app/time/dtr/check_ob_tk_combination.php');
	//end tk complain & ob combination

	//yung nacheck sa taas is OB VS TK
	if($att_time_in){//pag may time in sa attendance_tables
		if($att_time_in<$actual_in){ // IF result of above time in is greater than the bio logs.
			$actual_in=$att_time_in;
		}else{

		}		
	}else{
	}
	
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


}else{

	$actual_in="--:--";
	$actual_out="--:--";

	$check_att_date_in="";
	$check_att_date_out="";

}




if($marked_as_early_cutoff_coverage=="yes"){

	if($is_rest_day=="yes"){
		

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



//============================================Rest day auto match schedule============================================

if(($is_rest_day=="yes")AND ($actual_in!="--:--") AND ($actual_out!="--:--")){

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

			// : this causes
			$shift_in=$actual_in;
			$shift_reg_hours_no=$mysalary_no_of_hours;
			$shift_out = new DateTime($shift_in.':00');
			$shift_out->add(new DateInterval('PT9H')); // add 8 hours
			$shift_out=$shift_out->format('H:i');	
			// : this causes
		
		}
	}else{

			$shift_in=$actual_in;

			$shift_out = new DateTime($shift_in.':00');
			$shift_out->add(new DateInterval('PT8H')); // add 8 hours
			$shift_out=$shift_out->format('H:i');	
	}

$shift_reg_hours_no=$mysalary_no_of_hours;
}else{

$shift_reg_hours_no=$mysalary_no_of_hours;

}

$the_ot_nd_time_to="06:00";
/* 
dole 10pm to 06:00 am ( just in case walang setup sa time settings.)
*/
//============================================CHECK SHIFT REG HOURS IF PER HOUR LEAVE============================================
//kapag naka per hour check sa time settings at naka yes sa compress
//kapag naka no sa time settings at naka yes sa compress
if(($per_hour_leave=="yes")AND($compress_per_hour=="1")){// check daily plotted schedule reg hours .
	$srg=$this->time_dtr_model->check_shift_regular_hours($shift_in,$shift_out);
	if(!empty($srg)){
		$shift_reg_hours_no=$srg->shift_reg_hours;
	}else{

	}

}else{

}
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
$shift_date_in=$p_from;

//echo "$p_from $p_from $shift_date_out <br>";
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

			$holreghr_a = StrToTime ( $shift_date_out.' '.$actual_out.':00' ); //shift_out
			$holreghr_b = StrToTime ( $p_from.' '.$shift_in.':00' ); //shift_in
			$holreghr_raw = $holreghr_a - $holreghr_b;
			$holreghr_raw = $holreghr_raw / ( 60 * 60 );

			if($p_from!=$att_date_out){//kapag more than 8 hrs ang pinasok
						if($shift_in>=$actual_in){

							if($shift_hours==8){
								$holreghr_raw=8;//default dole first 8 hrs ot | $mysalary_no_of_hours;		
							}else{
								$holreghr_raw=$mysalary_no_of_hours+1;		
							}
							


							
						}else{

						}		
			}else{

			}

			/*start force positive number: case solved rd/hol : shift: 12:00 to 21:00 log: 09:13 to 05:00 of nxtday*/
			if($holreghr_raw<0){
				$holreghr_raw=abs($holreghr_raw);
			}else{

			}
			/*end force positive number: case solved rd/hol : shift: 12:00 to 21:00 log: 09:13 to 05:00 of nxtday*/

			if($shift_hours>8){

				if($holreghr_raw<8){

				}else{
					$holreghr_raw=$holreghr_raw-1;
				}
				
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



//============================================START CHECK LATE FINAL NO.OF MINUTES============================================

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

if($late_date_from_ref==$check_att_date_in){//kung same date yung shift in at attendance date in
	if($with_grace_time_in<$shift_in){//pag umasok ng maaga 
		$my_orig_late=0;
	}else{

	}

}else{

}

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

		$a = StrToTime ( $p_from.' '.$shift_in.':00' ); /* count start only on shift */
		$b = StrToTime ( $p_from.' '.$actual_in.':00' );
		$aa = $b - $a;
		$aa = $aa / ( 60 * 60 );

		if($aa>=$dtr_required_halfday_hrs){
			$c=$aa-$dtr_required_halfday_hrs;

			

			if($aa<="5"){
				$my_late_by_hour_raw2=0;
				
			}else{
				if($aa<="5"){
					$my_late_by_hour_raw2=0;
				}else{
					$my_late_by_hour_raw2=$my_late_by_hour_raw2;// $c
				}
				
			}
			
		}else{
			
		}

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
								
									if($holiday_type OR $is_rest_day=="yes"){
										$halfday_due_to_late="yes";
									}else{
										//$absent=+0.5; 
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


if ($p_from < $check_att_date_in) { // automatic late since the in date is nextday.

   								$late_tracker="late computation :matic since in is next date.";
								$my_late=$my_late_by_hour;		
								$halfday_due_to_late="no";	
}else{

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

// ==== case nalate or naundertime na hindi categorize as halfday absent and gumamit sya ng leave para hindi malate or maundertime.
if(($halfday_due_to_late=="no")AND($leave_day_type_status=="halfday") AND ($leave_pay_type=="with pay")){
	//$halfday_due_to_undertime=="no" OR 
	if($my_late>0){
		$my_late="";
	}else{

	}
}else{

}



//============================================LATE ROOT DEBUGGER ============================================

//echo "$p_from $late_tracker graceperiod: $my_late_grace_period , origlate_graceperiod already applied: $my_orig_late ,equivalent ded: $equivalent_late_ded<br>";
// echo " $p_from  late policy: $late_as_half_day_policy , latehour: $my_late , latepolicyresult: $halfday_due_to_late<br>";

//============================================ START CHECK OT APPLICATION FORM============================================
$get_managers_approved_atro= $this->time_dtr_model->get_managers_approved_atro($emp->employee_id,$p_from);

if(!empty($get_managers_approved_atro)){
	$with_head_auto_ot="yes";
	$head_approved_ot=$get_managers_approved_atro->hours;
	$head_approved_ot_form='<a title="SUPERVISOR AUTO OT">('.$head_approved_ot.')</a>';
}else{
	$with_head_auto_ot="";
	$head_approved_ot="";
	$head_approved_ot_form="";
}	
//============================================ START CHECK OT APPLICATION FORM============================================
$get_atro= $this->time_dtr_model->get_my_atro($emp->employee_id,$p_from);

if(!empty($get_atro)){
	$total_filed_atro_hours=0;
	foreach($get_atro as $my_ot){
			$atro_date=$my_ot->atro_date;

			$atro_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$my_ot->doc_no.'/emp_atro/HR008" target="_blank" title="EMPLOYEE FILE">OT</a>';
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

//============================================ START CHECK OT APPLICATION FORM: IL============================================
$get_atro_il= $this->time_dtr_model->get_my_atro_il($emp->employee_id,$p_from);



if(($holiday_type)AND($holiday_type=="RH")){
	$total_filed_atro_hours=$total_filed_atro_hours+$regular_holiday_auto_ot_setting+$head_approved_ot;
}elseif(($holiday_type)AND($holiday_type=="SNW")){
	$total_filed_atro_hours=$total_filed_atro_hours+$snw_holiday_auto_ot_setting+$head_approved_ot;
}else{
	$total_filed_atro_hours=$total_filed_atro_hours+$head_approved_ot;
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


if($per_hour_leave=="yes"){
	$my_undertime="";
	$halfday_due_to_undertime="";

}else{ 
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
		if($holiday_type OR $is_rest_day=="yes"){
			$my_orig_ut=0;
		}else{

		}



				
				



									if((date($ut_shift) <= $ut_out) OR $actual_out=="" OR $actual_in=="") {
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

											if($my_undertime>$dtr_required_halfday_hrs){// if more than halfday undertime req hrs ang UT ni employee
												$my_undertime=$my_undertime-1;// minus lunch break

												if($forced_halfday_ut_display_to_dtr=="no"){
													$my_undertime="";
												}else{

												}
												
											}else{
												if($forced_halfday_ut_display_to_dtr=="yes"){

												}else{
													$my_undertime="";
												}
											}
									
											$halfday_due_to_undertime="yes";

		if($check_att_date_in!=$shift_date_in){

			if($actual_out>=$shift_out){
				$halfday_due_to_undertime="no";
				$my_undertime=""; 
			}else{

			}
		}else{

		}									

										
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

}



// for proper identification of employee treated as halfday absent due to Number of hours to count under time as half day absent policy setup



if($my_undertime>$dtr_required_halfday_hrs){// 

	$undertime_total+=$my_undertime;
	$halfday_due_to_undertime_class='';
}else{


	if($halfday_due_to_undertime=="yes"){ 
		$halfday_due_to_undertime_class='style="background-color:#FFD8D0;color:#ff0000;" ';
	}else{
		$halfday_due_to_undertime_class='';
		$undertime_total+=$my_undertime;
	}

}






//============================================START ACTUAL HOURS WORK COMPUTATION ============================================

if(($check_att_date_in!="")AND($actual_out!="")){
//echo "$p_from $shift_in -----------------> $check_att_date_in $actual_in $actual_in > $shift_in <br><br>";

	if((date($actual_in) < $shift_in)AND($p_from==$check_att_date_in)) { //case early time in than the shift in schedule
		$reg_time_in = StrToTime ( $check_att_date_in.' '.$shift_in.':00' ); /* count start only on shift */
		$reg_time_out = StrToTime ( $check_att_date_out.' '.$actual_out.':00' );
		$official_actual_hours = $reg_time_out - $reg_time_in;
		$official_actual_hours = $official_actual_hours / ( 60 * 60 );


		$a = StrToTime ( $check_att_date_in.' '.$actual_in.':00' ); /* count start only on shift */
		$b = StrToTime ( $p_from.' '.$shift_in.':00' );
		$c = $b - $a;
		$c = $c / ( 60 * 60 );


		if($c>$mysalary_no_of_hours){// tinitignan nya if match yung sched
			if($actual_out>=$shift_out){// may case kasi na ang haba ng advance ot nya like 7 hrs before the start of duty.so validate the time out and shift out

			}else{
				$official_actual_hours=0; 
			}
			
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

	if(($p_from==$check_att_date_in)AND($shift_in!="00:00")){

		$date_a = new DateTime(''.$p_from.' '.$shift_in.'');
		$date_b = new DateTime(''.$check_att_date_in.' '.$actual_in.'');

		$shift_to_actualin_interval = date_diff($date_a,$date_b);
		$shift_to_actualin_interval=$shift_to_actualin_interval->format('%h');

		if($shift_to_actualin_interval>$mysalary_no_of_hours){// pag nag early in na 12 midnight ang sched.
			$official_actual_hours=0;
			//echo "$p_from schedule not match.  <br>";
		}else{

		}
		
	}else{

	}

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

//============================================END ACTUAL HOURS WORK COMPUTATION ============================================


// //=== recheck late :remove late if required no of hrs work do not return true	


if($dtr_required_hrs_to_pay>$official_actual_hours){
	$my_late="";
	$halfday_due_to_late="no";

	$late_tracker_type="";// force not more_than_half_day
}else{

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
if(($per_hour_leave=="yes")AND($compress_per_hour=="1")){
// if($per_hour_leave=="yes"){
		require(APPPATH.'views/app/time/dtr/per_hour_regular_hours.php');

}else{
		require(APPPATH.'views/app/time/dtr/regular_hours.php');
}




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

	// $official_night_diff_time_from="";
	// $official_night_diff_time_to="";
	$official_night_diff_time_from=$reg_nd_time_from;
	$official_night_diff_time_to=$reg_nd_time_to;

}

//kapag not applicable ans shift night diff at walang attendance , edi wala syang shift night diff.
if($reg_nd_setting=="no" OR $reg_nd_setting=="no setting" OR $actual_out=="--:--" OR $actual_out==""){// no nd set up at time settings

	// if($official_night_diff_time_from=="" OR $official_night_diff_time_to=="" OR $actual_out=="--:--" OR $actual_out==""){// no nd set up at time settings
	$nd_time_in="";
	$nd_time_out="";
	$official_reg_nd="";
	//echo "$p_from | $official_reg_nd <br>";

}else{

if(($check_att_date_in!="")AND($actual_out!="")AND($shift_in)){

	if($my_set_advance_ot=="yes"){

		if(($actual_in>"00:00")AND($actual_in<"06:00")){
			if($actual_in>$shift_in){
				$nd_time_in=$actual_in;
			}else{
				$nd_time_in=$shift_in;
			}
		}else{
					if($actual_in<$official_night_diff_time_from){
						$nd_time_in=$official_night_diff_time_from;
					}else{
						$nd_time_in=$actual_in;
					}
		}


			if($actual_out>$official_night_diff_time_to){ 
				if($actual_out>$official_night_diff_time_from){										
					if($actual_out>$shift_out){
						$nd_time_out=$shift_out; 
					}else{
						$nd_time_out=$actual_out;
					}
					
				}else{


					if($actual_out>$shift_out){
						$nd_time_out=$shift_out;						
					}else{



		if((($actual_out<=$official_night_diff_time_from)AND($actual_out>=$official_night_diff_time_to))
			AND
			(($nd_time_in<=$official_night_diff_time_from)AND($nd_time_in>="23:59")))
		{	//22:00 to 23:59 AND 00:00 to 06:00 
			$nd_time_out="22:00";	



		}else{
			$nd_time_out=$official_night_diff_time_to;
		}

						
					}
					
				}
				
			}else{
				if($actual_out>$shift_out){
					$nd_time_out=$shift_out;
				}else{
					$nd_time_out=$actual_out;						
				}
		
			}

			if($shift_date_out!=$check_att_date_out){
				$nd_time_out=$shift_out;
			}else{

			}

			if((($shift_in>$official_night_diff_time_from)AND($shift_in<="23:59"))OR
			(($shift_in<$official_night_diff_time_to)AND($shift_in>="00:00")))
			{// if greater than yung shift in sa official nd start in
			
				if($shift_in=="00:00"){
					if(($actual_in<="23:59")AND($actual_in>=$official_night_diff_time_from)){
						$nd_time_in=$shift_in;// pag 12 midnight pa shift nya pero nag early in sya.
					}else{

					}
					
				}else{
					if($actual_in>$shift_in){// if greater than yung actual in sa shift 
						//ok na sa taas > you left here
					}else{

						$nd_time_in=$shift_in;
					}					
				}


			}else{
			}


			if(($nd_time_out>$official_night_diff_time_to)AND($nd_time_out<$official_night_diff_time_from)){
				$nd_time_out=$official_night_diff_time_to;		
			}else{
			}


			if($holiday_type OR $is_rest_day=="yes"){

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



if(($nd_time_in==$official_night_diff_time_from)AND($nd_time_out==$official_night_diff_time_to)){

}else{

if($nd_time_out<=$ot_hours_coverage){	

	if((($shift_in>$official_night_diff_time_from)AND($shift_in<="23:59"))OR
	(($shift_in<$official_night_diff_time_to)AND($shift_in>="00:00")))
	{// if greater than yung shift in sa official nd start in
		$nd_time_in=$shift_in;
	}else{

	}
	if(($nd_time_out>$official_night_diff_time_to)AND($nd_time_out<$official_night_diff_time_from)){
		$nd_time_out=$official_night_diff_time_to;
		
	}else{

	}
	
}else{

							if(($ot_hours_coverage>=$official_night_diff_time_from)AND($ot_hours_coverage<"23:59")){								
							}else{

								if(($ot_hours_coverage<$official_night_diff_time_to)AND($ot_hours_coverage>"00:00")){

								}else{
									$nd_time_in="";
									$nd_time_out;
								}
							}	
}


}


					

			}else{

			}

	if($shift_out==$official_night_diff_time_from){
										$nd_time_in="";
										$nd_time_out;	
	}else{

	}



	if($p_from!=$check_att_date_in){
		if(($actual_in>="00")AND($actual_in<$official_night_diff_time_to)){
					$nd_time_in=$actual_in;
		}else{
		}		
	}else{
	}



	}else{// advance ot setting no start


		if((date($actual_in) < $shift_in)AND($p_from==$check_att_date_in)){ //case early time in than the shift in schedule

			$nd_time_in=$official_night_diff_time_from; 

			if($actual_out>="00:00"){
				/*
					pag yung out is more than 12 midnight
					if shift out is between 10pm to 23:59 only , edi ang ws nd basis nya is shift out
				*/


				if(($shift_out<="23:59")AND($shift_out>$official_night_diff_time_from)){
					$nd_time_out=$shift_out;
				}
				elseif(($shift_out>="00:00")AND($shift_out<$official_night_diff_time_to)AND($actual_out>=$shift_out)){
					$nd_time_out=$shift_out;// 2019-07-21 to 2019-08-05 |1492 |lemon ang shift out is 2am and actual out is 06 am
				}
				else{
					if(($shift_out<=$official_night_diff_time_from)AND($shift_out>="14:00")){//$official_night_diff_time_to
							// why 2pm (first schedule that will not have nd is 6am to 2pm : 2pm shiftout to 10pm shift outs doesnt have nd.)
							/*
								if ang shift out nya is more than 6am and less than 10pm wala syang ws nd
							*/
								$nd_time_out="";
					}else{
						$nd_time_out=$actual_out;
					}

				}

			}else{

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


if($p_from!=$check_att_date_in){
	if(($actual_in>="00")AND($actual_in<$official_night_diff_time_to)){
				$nd_time_in=$actual_in;


	}else{

	}
	
}else{

}


					if(($actual_in<$official_night_diff_time_from)AND($actual_out<$official_night_diff_time_from)){
						if(($actual_in>"00:00")AND($actual_in<$official_night_diff_time_to)){
							
						}else{
							$nd_time_in=$official_night_diff_time_from;		
						}
						
					}else{

					}


					if(date($actual_out) < $shift_out) { 
						$nd_time_out=$actual_out;
					}else{
						$nd_time_out=$shift_out; 			
					}	

					
					if(($shift_out<="23:59")AND($shift_out>=$official_night_diff_time_from)){
							if($check_att_date_out>$p_from){//next day out
								$nd_time_out=$shift_out;
							}else{
							}
					}else{
					}





					//if($actual_out<="23:59" OR $actual_out>="18:00"){
						//echo "$p_from | $nd_time_in | $nd_time_out<br>";
						//$nd_time_in=""; $nd_time_out="";

					// }else{

					// }



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

			if($p_from_plus_one_day>$nd_time_in){
				$p_from_plus_one_day=$check_att_date_out;
				
			}else{

			}
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

$nd_time_in=$official_night_diff_time_from;	

if(($actual_in>=$official_night_diff_time_from)AND($actual_in<="23:59")){
	if($shift_in>$actual_in){
	$nd_time_in=$shift_in;
	}else{
	$nd_time_in=$actual_in;	
	}	
}else{
}

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
				$official_reg_nd=abs($official_reg_nd);

				if($decimal_place_rounding_setting=="yes"){
					// round off
					$official_reg_nd=round($official_reg_nd, $decimal_place_no_setting);
				}else{
					// cut only
					$official_reg_nd=bcdiv($official_reg_nd, 1, $decimal_place_no_setting); 
				}

				if($shift_out==$official_night_diff_time_from){
					$official_reg_nd="";
				}else{
				}



		}


if($nd_time_in=="" OR $nd_time_out==""){
	$official_reg_nd="";
}else{

}


}else{


		$official_nd_time_in = StrToTime ( $check_att_date_in.' '.$nd_time_in.':00' );
		$official_nd_time_out = StrToTime ( $check_att_date_out.' '.$nd_time_out.':00' );
		$official_reg_nd = $official_nd_time_out - $official_nd_time_in;
		$official_reg_nd = $official_reg_nd / ( 60 * 60 );

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

}

// ============== start verify ND
$paymentDate = strtotime(date("2014-01-22 22:01"));
$contractDateBegin = strtotime("2014-01-22 $actual_in");
$contractDateEnd = strtotime("2014-01-23 $official_night_diff_time_to");

if($holiday_type OR $is_rest_day=="yes"){

	
	if(($official_reg_nd>0)AND($official_reg_nd>$reg_hours_worked)){// kung hindi enough yung filed ot time.
		$official_reg_nd=$reg_hours_worked; 

	}else{

	}


}else{

}
			
		

if(($shift_out>$official_night_diff_time_from)AND($shift_out<="23:59")){
	if(($actual_out<=$official_night_diff_time_from)AND($actual_out>=$official_night_diff_time_to)){
		//sample shift out 23:00 but actual out is 20:00
		$official_reg_nd="";
		$nd_time_out="";
		$nd_time_out="";
	}else{

	}

}else{

}



if($shift_in>=$official_night_diff_time_to AND $shift_in<="12:00"){
	$official_reg_nd="";
}else{

}




// ============== end verify ND
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


//============================================END REGULAR ND COMPUTATION
// restday present

if(($is_rest_day=="yes") AND ($holiday_type!="SNW") AND ($holiday_type!="RH") AND ($actual_in!="--:--") AND ($actual_out!="--:--") ){ 
	
	if($total_filed_atro_hours==0){
		$official_restday_regular_nd="";
		$official_restday_regular_hour="";
			
	}else{		
	
		$official_restday_regular_nd=$official_reg_nd;
		$official_restday_regular_hour=$reg_hours_worked;
		

	}
	

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
				$reg_hours_worked=$mysalary_no_of_hours;
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

	


	
//============================================COMPUTE OVERTIME
require(APPPATH.'views/app/time/dtr/compute_overtime.php');



//============================================UNDERTIME ROOT DEBUGGER ============================================

// echo "$p_from  graceperiod: $my_ut_grace_period $ut_as_half_day_policy $halfday_due_to_undertime $shift_out $actual_out_ut<br>";

//============================================OFFICIAL IN & OUT  ROOT DEBUGGER ============================================

// echo " attendance   : $p_from : $attendance_table_status	<br>";
// echo " ob & attendance   : $p_from $official_business_status : $attendance_table_status	<br>";
// echo " tk complaint & ob & att : $p_from $time_keeping_complaint_status : $official_business_status	$attendance_table_status <br>";

$overbreak_total+=$over_break;

//============================================RECHECK LATE (IF WITH APPROVED PAID LEAVE)

if(($my_late>0 OR $my_undertime>0)AND($reg_hours_worked>=8)){

	if(($leave_pay_type=="with pay")AND($leave_day_type=="0.5" OR $leave_day_type=="1")){
		//remove late OR undertime
			if($my_undertime>0){// bawi was added 2430
				$undertime_total=$undertime_total-$my_undertime;

			}else{

			}
		$my_late="";
		$my_undertime="";
	}else{

	}
}else{




}




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
					if($my_undertime>$dtr_required_halfday_hrs){
						$undertime_occurence++;
						//echo "$p_from <br>";
					}else{

					}
					
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

if($per_hour_leave=="yes"){
			if($reg_hours_worked=="absent"){
				$absences_occurence++;
			}else{

			}
}else{
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
//echo "$p_from | $total_regular_nd | $official_reg_nd <br>";
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



$total_regular_hrs_reg_holiday=$total_regular_hrs_reg_holiday+$regular_holiday_reghour_addition;

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
if($salary_rate=="1"){//piece rate

}elseif($salary_rate=="2"){ // hourly rate

}elseif($salary_rate=="3"){ // daily rate

		if($remove_time_credit=="yes"){// auto adjustment of early cutoff

				if($is_rest_day=="yes" OR $holiday_type){
				}else{
						if($PrevEarlyCutoff_regular_hour>$reg_hours_worked){
							$additional_regular_hour=$PrevEarlyCutoff_regular_hour-$reg_hours_worked;
							$total_regular_hours-=$additional_regular_hour;
						}else{
							$additional_regular_hour=$PrevEarlyCutoff_regular_hour-$reg_hours_worked;
							$total_regular_hours-=$additional_regular_hour;
							$regular_hours_total_tracker.="$p_from (was paid last cutoff due to assumed payroll)| -$additional_regular_hour&#13;";
						}
				}	

		}else{

			if($per_hour_leave=="yes"){
					
					if(($reg_hours_worked>0)AND($marked_as_early_cutoff_coverage=="no")){
						$regular_hours_total_tracker.="$p_from | $reg_hours_worked&#13;";
						$total_regular_hours+=$reg_hours_worked;
					}elseif(($reg_hours_worked>0)AND($marked_as_early_cutoff_coverage=="yes")){
						$regular_hours_total_tracker.="$p_from (assumed present)| $reg_hours_worked&#13;";
						$total_regular_hours+=$reg_hours_worked;
					}elseif($holiday_type=="RH"){
						$regular_hours_total_tracker.="$p_from ($holiday_type)| $mysalary_no_of_hours&#13;";
						$total_regular_hours+=$mysalary_no_of_hours;
					}else{

					}


			}else{
							if($is_rest_day=="yes"){					
							}else{

								if($reg_hours_worked>=0.1){// with regular hrs to be paid
									$total_regular_hours+=$reg_hours_worked;//$mysalary_no_of_hours;						
								}else{
									if($holiday_type=="RH"){
										$total_regular_hours+=$mysalary_no_of_hours;
									}else{
									}

								}
						
							}				
			}

		}




}elseif(($salary_rate=="4")and($pay_type=="3")){ // monthly rate

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

// ========= kapag nagexceed sa 104 reg hrs.
if($total_regular_hours>$monthlyrate_semimonth_reg_hour_base){
	$total_regular_hours=$monthlyrate_semimonth_reg_hour_base;
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

		if($reg_hours_worked=="absent"){
				$official_reg_nd="";
		}else{

		}

}else{

		if($reg_hours_worked=="absent"){
				$official_reg_nd="";
		}else{
			
		}
}

//============================================start check if already employed on this date
// $datehired_on_cur_period_sts
// $datehired_on_cur_period_action

if($p_from>=$date_employed){

}else{
	//$reg_hours_worked="";
	//echo "$p_from $date_employed === save dtr: datehired_on_cur_period_sts , action : $datehired_on_cur_period_action <br>";
}


if($with_advance_duty_form=="yes"){
	$advance_duty_class='style="background-color:#000;color:#fff;font-weight:bold;"';
	$advance_duty_form='Advance Duty (ID: '.$ad_id.')';
	$advance_duty_form_no="$ad_id";
}else{
	$advance_duty_class='';
	$advance_duty_form='';
	$advance_duty_form_no='';
}
//echo "$p_from $head_approved_ot_form <br>";

//============================================end check if already employed on this date
// start process dtr dates query
require(APPPATH.'views/app/time/dtr/process_dtr_dates.php');
// end process dtr dates query
if($per_hour_leave=="yes"){
	$per_hour_leave_trace='title="shift required regular hours : '.$shift_reg_hours_no.'" ';
}else{
	$per_hour_leave_trace='';
}


//============================================DAYS 
echo '<tr >'.'<td>'.$two_digit_day.'</td>';
//============================================DAY FO THE WEEK============================================
echo '<td '.$sunday_color.'>'.substr($dayOfWeek, 0,3).'</td>';
echo '<td '.$advance_duty_class.' '.$hl_shift.'>'.$shift_in.'</td>';
echo '<td '.$advance_duty_class.' '.$hl_shift.' '.$per_hour_leave_trace.'>'.$shift_out.'</td>';
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

if(($holiday_type=="SNW")AND($snw_holiday_auto_ot_setting!="")) {
	$auto_ot_form='<a href="#" title="ADMIN AUTO OT">('.$snw_holiday_auto_ot_setting.')</a>';
}elseif(($holiday_type=="RH")AND($regular_holiday_auto_ot_setting!="")){
	$auto_ot_form='<a href="#" title="ADMIN AUTO OT">('.$regular_holiday_auto_ot_setting.')</a>';

}else{
	$auto_ot_form="";
}	

if(($with_head_auto_ot=="yes")AND($auto_ot_form!="")){
	$ot_space_2nd="+";
}else{
	$ot_space_2nd="";
}

if($with_head_auto_ot=="yes" OR $auto_ot_form!=""){
	$ot_space="+";
}else{
	$ot_space="";
}


if(!empty($get_atro)){
	$list_of_ot_form="";
	foreach($get_atro as $my_ot){
			$atro_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$my_ot->doc_no.'/emp_atro/HR008" target="_blank" title="EMPLOYEE FILE">OT</a>';
				echo $atro_form."(".$my_ot->no_of_hours.")".$ot_space;

	$list_of_ot_form.=$my_ot->doc_no."[".$my_ot->no_of_hours."]*";
	}

// start process dtr atro form query
require(APPPATH.'views/app/time/dtr/process_dtr_atro.php');
// end process dtr atro form query

}else{

}

echo $auto_ot_form.$ot_space_2nd.$head_approved_ot_form;//important


if(!empty($get_atro_il)){
	foreach($get_atro_il as $ot_il){

		$atro_form_il='<a href="'.base_url().'app/transaction_employees/form_view/'.$ot_il->doc_no.'/emp_atro/HR008" target="_blank" title="OT is Converted To Incentive Leave">IL Convert</a>';

		$list_of_il_ot_form.=$atro_form_il;
	}
	echo "$list_of_il_ot_form";//important

}else{
		$atro_form_il="";
		$list_of_il_ot_form="";
}	


// if(($holiday_type=="SNW")AND($snw_holiday_auto_ot_setting!="")) {
// 	echo $auto_ot_form='<a href="#" title="ADMIN AUTO OT">('.$snw_holiday_auto_ot_setting.')</a>';
// 	if($with_head_auto_ot=="yes"){
// 		echo "+".$head_approved_ot_form;
// 	}else{
		
// 	}	
// }elseif(($holiday_type=="RH")AND($regular_holiday_auto_ot_setting!="")){
// 	echo $auto_ot_form='<a href="#" title="ADMIN AUTO OT">('.$regular_holiday_auto_ot_setting.')</a>';

// 	if($with_head_auto_ot=="yes"){
// 		echo "+".$head_approved_ot_form;
// 	}else{
	
// 	}

// }else{
// 	if($with_head_auto_ot=="yes"){
// 		echo $head_approved_ot_form;
// 	}else{
// 		$auto_ot_form="";
// 	}
	
// }

// start process dtr auto atro form query
require(APPPATH.'views/app/time/dtr/process_dtr_auto_atro.php');
// end process dtr auto atro form query



echo '</td>';
echo '<td '.$form_change_rdshift_hl.'>'.$change_sched_form.$change_restday_form.$advance_duty_form.'</td>';
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
// while($bilang_ng_bilang<$total_employees){

	require(APPPATH.'views/app/time/dtr/process_dtr_summary.php');

// 	flush();
// 	echo "<script>document.getElementById('proceso').innerHTML='PROCESSING DATA : ".($bilang_ng_bilang+=1)." of ".($total_employees)." <br/> Process time : ".gmdate("H:i:s",((abs(strtotime($from_timer) - time()) / 60) * 60))." <br/>memory usage : ".(round((memory_get_usage()/1024),2))."kb';</script>";

// }

// end process dtr summary query

?>
<div id="proceso"></div>
<script type="text/javascript">
// document.getElementById('proceso').innerHTML='Please wait as dtr is processing';
</script>



<?php

	//include 'processing_footer.php';


?>


<div class="datagrid">

<table   cellpadding="1" cellspacing="3">
	<thead>
		<tr>
			<th>Description</th>
			<th>Regular</th>
			<th>Restday</th>
			<th>Regular Holiday</th>
			<th>Regular Holiday/Restday
			<div class="datagrid">
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><a id="reg_hol_rd_with_logs" title="Regular Holiday that falls on a restday WITH attendance">Type 1</a></td>
		<td><a id="reg_hol_rd" title="Regular Holiday that falls on a restday WITHOUT attendance">Type 2</a></td>
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
		<td><div title="<?php echo $regular_hours_total_tracker;?>"><?php echo $total_regular_hours; $total_regular_hours=""; ?></div></td>
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
		<td><div title="<?php echo $absences_total_tracker;?>"><?php echo $absences_total; $absences_total="";?></div></td>		
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
/*
-------------------------------------------------------------
LEAVE ADJUSTMENT
check at time > time settings 

1)day(s) allowance for late approved leave transaction (e.g 30 days)
meaning: counting of days basis will start from the cutoff first
2)day(s) allowance for late approved leave transaction (from date reference) (cut off start date OR payroll process date)
meaning: counting of days basis will start from date where dtr is being process
-------------------------------------------------------------
*/

if(($late_approved_leave_daysno_setting!="" OR $late_approved_leave_daysno_setting>0)AND($previous_payroll_period)){

	$PrevPeriodState=$this->time_dtr_model->check_payslip_status($employee_id,$company_id,$previous_payroll_period_mc,$previous_payroll_period);
	if(!empty($PrevPeriodState)){
		$auto_adjust_leave=$this->time_dtr_model->get_late_approved_form($employee_id,$pay_period_from,$late_approved_leave_daysno_setting,$late_approved_leave_datecounting_setting);

	}else{
		$auto_adjust_leave="";
	}


}else{
	$auto_adjust_leave="";// theres no setup yet at time settings ->day(s) allowance for late approved leave transaction
}

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
}elseif($selected_dtr_option=="view"){ 

require(APPPATH.'views/app/time/dtr/view_processed_dtr.php');

//============================================END VIEW PROCESSED DTR-->


}elseif($selected_dtr_option=="process"){ // process is the selected option but the dtr is already locked.

	if($payslip_status=="posted"){
		echo '
		<div class="locked_prompt_class">
		DTR Processing/Re-processing is not allowed . Payroll is already posted <span class="locked_prompt_class_span">( you may verify at payroll > generate payslip )</span>
		</div>
		';
	}else{
		if($is_dtr_locked=="1"){
			echo '
			<div class="locked_prompt_class">
			DTR Processing/Re-processing is not allowed . DTR is already locked <span class="locked_prompt_class_span">( you may verify at payroll > lock payroll period )</span>
			</div>
			';
		}elseif($is_payslip_lock=="1"){
			echo '
			<div class="locked_prompt_class">
			DTR Processing/Re-processing is not allowed . Payslip is already locked <span class="locked_prompt_class_span">( you may verify at payroll > lock payroll period )</span>
			</div>
			';
		}else{

		}
		
	}

	if($is_dtr_manually_computed_already=="1"){
			echo '
			<div class="locked_prompt_class">
			DTR Processing/Re-processing is NOT ALLOWED (Summary is already manually computed.)
			</div>
			';
	}else{

	}


}elseif($selected_dtr_option=="check"){


}elseif($selected_dtr_option=="clear_dtr"){

	if($payslip_status=="posted"){
			$reset_dtr_failed_count++;
			echo '
			<div class="locked_prompt_class">
			DTR Reset is NOT allowed <span class="locked_prompt_class_span">(Payroll is already posted)</span>
			</div>
			';
	}else{
			$reset_dtr_success_count++;
			$this->time_dtr_model->reset_dtr($employee_id,$pay_period,$month_cover);
			echo '
			<div class="locked_prompt_class">
			DTR Successfully Reset.
			</div>
			';
	}


}else{ 



}


	} // <- END FOREACH OF EMPLOYEE


	if($selected_dtr_option=="check"){// show total .
		echo "<button class='btn btn-primary col-md-6'>TOTAL PROCESSED: ".$total_process."</button>";
		echo "<button class='btn btn-danger col-md-6'>TOTAL UN-PROCESSED: ".$total_unprocess."</button>";
	}elseif($selected_dtr_option=="clear_dtr"){
		echo "<button class='btn btn-primary col-md-6'>TOTAL RESET SUCCESS: ".$reset_dtr_success_count."</button>";
		echo "<button class='btn btn-danger col-md-6'>TOTAL RESET FAILED: ".$reset_dtr_failed_count."</button>";
	}else{

	}


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
