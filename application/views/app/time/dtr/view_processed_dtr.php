<?php


$mydtr_summary=$this->time_dtr_model->get_processed_dtr_summary($company_id,$pay_period,$employee_id,$month_cover);
if(!empty($mydtr_summary)){
	//========

$is_manual_dtr=$mydtr_summary->is_manual_dtr;

if($is_manual_dtr=="1"){

echo "
<tr>
<td colspan='25' style='text-align:center;'><a title='Notice: This DTR is manually Encoded/Computed.'><i class='fa fa-info text-success' style='font-size:48px;'></i> </a> DTR is Manually Computed/Encoded.
</td>
</tr>";

}else{


	while (strtotime($p_from) <= strtotime($p_to)) {
                 
//============================================ start CHECK EARLY CUTOFF SETTING IF ANY FOR THE PREVIOUS CUTOFF.                 

require(APPPATH.'views/app/time/dtr/check_auto_early_cutoff.php');

//============================================ end CHECK EARLY CUTOFF SETTING IF ANY FOR THE PREVIOUS CUTOFF.
//============================================ start CHECK EARLY CUTOFF SETTING IF ANY FOR THE CURRENT CUTOFF.
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



//============================================ end CHECK EARLY CUTOFF SETTING IF ANY FOR THE CURRENT CUTOFF.
  	$two_digit_day=substr($p_from, -2, 2)."<br>";
	$dayOfWeek = date("l", strtotime($p_from));
	
	if($dayOfWeek=="Sunday"){
		$sunday_color='style="background-color:'.$hl_sunday.';"';
	}else{
		$sunday_color='';
	}

$myprocessed_dtr=$this->time_dtr_model->get_processed_dtr($company_id,$pay_period,$employee_id,$p_from);
if(!empty($myprocessed_dtr)){

$shift_in=$myprocessed_dtr->shift_in;
$shift_out=$myprocessed_dtr->shift_out;
$actual_in=$myprocessed_dtr->actual_in;
$actual_out=$myprocessed_dtr->actual_out;
$actual_hour=$myprocessed_dtr->actual_hour;

$late=$myprocessed_dtr->late;
$overbreak=$myprocessed_dtr->overbreak;
$undertime=$myprocessed_dtr->undertime;
$regular_hour=$myprocessed_dtr->regular_hour;
$regular_nd=$myprocessed_dtr->regular_nd;
$regular_ot=$myprocessed_dtr->regular_ot;
$restday_ot=$myprocessed_dtr->restday_ot;
$reg_hol_ot=$myprocessed_dtr->reg_hol_ot;
$spec_hol_ot=$myprocessed_dtr->spec_hol_ot;
$rd_reg_hol_ot=$myprocessed_dtr->rd_reg_hol_ot;
$rd_spec_hol_ot=$myprocessed_dtr->rd_spec_hol_ot;
$regular_ot_nd=$myprocessed_dtr->regular_ot_nd;
$restday_ot_nd=$myprocessed_dtr->restday_ot_nd;
$regular_hol_ot_nd=$myprocessed_dtr->regular_hol_ot_nd;
$spec_hol_ot_nd=$myprocessed_dtr->spec_hol_ot_nd;
$rd_reg_hol_ot_nd=$myprocessed_dtr->rd_reg_hol_ot_nd;
$rd_spec_hol_ot_nd=$myprocessed_dtr->rd_spec_hol_ot_nd;
$atro_form=$myprocessed_dtr->atro_form;
$auto_ot_form=$myprocessed_dtr->auto_ot_form;
$atro_incentive_leave=$myprocessed_dtr->atro_incentive_leave;

$adv_duty_form=$myprocessed_dtr->advance_duty_form;
$head_approved_ot_form=$myprocessed_dtr->head_approved_ot_form;

$isrestday=$myprocessed_dtr->isrestday;
$isrestday_snw_holiday=$myprocessed_dtr->isrestday_snw_holiday;
$isrestday_reg_holiday=$myprocessed_dtr->isrestday_reg_holiday;
$is_snw_holiday=$myprocessed_dtr->is_snw_holiday;
$is_regular_holiday=$myprocessed_dtr->is_regular_holiday;

$myprocessed_pending_leave=$myprocessed_dtr->pending_leave;


if($marked_as_early_cutoff_coverage=="yes"){

		$early_cutoff_marked='style="background-color:'.$early_cutoff_marked_bg.';color:'.$early_cutoff_marked_color.';"';		
		
}else{
		$early_cutoff_marked="";
}



if($myprocessed_dtr->change_sched_form){
	$change_sched_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$myprocessed_dtr->change_sched_form.'/emp_change_sched/HR003" target="_blank">change sched</a>';
}else{
	$change_sched_form="";
}


if($myprocessed_dtr->change_rd_form){

list($rd_doc_no,$rd_from,$rd_to) = explode("*",$myprocessed_dtr->change_rd_form);

	if($myprocessed_dtr->logs_whole_date==$rd_from){
		$change_rd_form= '<a href="'.base_url().'app/transaction_employees/form_view/'.$rd_doc_no.'/emp_change_rest_day/HR027" target="_blank" >change restday from</a>';
	}else{
		$change_rd_form= '<a href="'.base_url().'app/transaction_employees/form_view/'.$rd_doc_no.'/emp_change_rest_day/HR027" target="_blank" >change restday to</a>';
	}
}else{
	$change_rd_form="";
}


$leave_form=$myprocessed_dtr->leave_form;
$ob_form=$myprocessed_dtr->ob_form;

if($myprocessed_dtr->tk_complaint_form){
$tk_complaint_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$myprocessed_dtr->tk_complaint_form.'/emp_time_complaint/HR025" target="_blank" title="'.$myprocessed_dtr->tk_complaint_form.'">tk complaint</a>';
}else{
$tk_complaint_form="";	
}

if($myprocessed_dtr->ut_form){
$ut_form='<a href="'.base_url().'app/transaction_employees/form_view/'.$myprocessed_dtr->ut_form.'/emp_under_time/HR023" target="_blank" title="'.$myprocessed_dtr->ut_form.'">undertime</a>';
}else{
$ut_form="";
}


$undertime_class=$myprocessed_dtr->undertime_class;
$late_class=$myprocessed_dtr->late_class;

}else{

	//echo "DTR STATUS IS UNPROCESSED. (CHOOSE PROCESS/REPROCESS TO PROCESS THE DTR)";
}


if($regular_hour=="absent"){
	$regular_hour_class='style="color:#ff0000;"';
}elseif($regular_hour=="4"){
	$regular_hour_class='style="color:#D629A7;font-weight:bold;"';
}else{
	$regular_hour_class='';
}

if($adv_duty_form!=""){
	$advance_duty_class='style="background-color:#000;color:#fff;font-weight:bold;"';
	$advance_duty_form='Advance Duty (ID: '.$adv_duty_form.')';
}else{
	$advance_duty_class="";
	$advance_duty_form="";
}

//============================================DAYS 
echo '<tr >'.'<td>'.$two_digit_day.'</td>';
//============================================DAY FO THE WEEK============================================
echo '<td '.$sunday_color.'>'.substr($dayOfWeek, 0,3).'</td>';
echo '<td '.$advance_duty_class.' '.$hl_shift.'>'.$shift_in.'</td>';
echo '<td '.$advance_duty_class.' '.$hl_shift.'>'.$shift_out.'</td>';
echo '<td '.$remove_time_credit_class. $early_cutoff_marked. $hl_logs.'>'.$actual_in.'</td>';
echo '<td '.$remove_time_credit_class. $early_cutoff_marked. $hl_logs.'>'.$actual_out.'</td>';
echo '<td '.$late_class.' '.$hl_late.'>'.$late.'</td>';
echo '<td '.$hl_overbrk.'>'.$overbreak.'</td>';
echo '<td '.$undertime_class.' '.$hl_undrtme.'>'.$undertime.'</td>';
echo '<td colspan="2"  '.$hl_hw_reg.'>
	<table  cellpadding="1" cellspacing="3" style="table-layout:fixed;width:150px;">
	<tr>
		<td width="50px" '.$remove_time_credit_class. $early_cutoff_marked. $regular_hour_class.'>'.$regular_hour.'</td>
		<td width="50px" '.$remove_time_credit_class. $early_cutoff_marked. $hl_hw_nd.'>'.$regular_nd.'</td>
		<td width="52px">'.$actual_hour.'<td>
	</tr>
	</table>
</td>';
echo '<td '.$regot_hl.'>'.$regular_ot.'</td>';
echo '<td '.$rdot_hl.'>'.$isrestday.$restday_ot.'</td>';
echo '<td colspan="2">
	<table   cellpadding="1" cellspacing="3" style="table-layout:fixed;width:100px;">
	<tr>
		<td '.$snw_hl.' style="text-align:center;width:50%;">'.$is_snw_holiday.$spec_hol_ot.'</td>
		<td '.$reghol_hl.' style="text-align:center;width:50%;">'.$is_regular_holiday.$reg_hol_ot.'</td>
	</tr>
	</table>
</td>';
echo '<td colspan="2">
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td '.$rd_snw_hl.' style="text-align:center;width:50%;">'.$isrestday_snw_holiday.$rd_spec_hol_ot.'</td>
		<td '.$rd_reghol_hl.' style="text-align:center;width:50%;">'.$isrestday_reg_holiday.$rd_reg_hol_ot.'</td>
	</tr>
	</table>
</td>';
echo '<td '.$ot_nd.'>'.$regular_ot_nd.$restday_ot_nd.$regular_hol_ot_nd.$spec_hol_ot_nd.$rd_reg_hol_ot_nd.$rd_spec_hol_ot_nd.'</td>';
echo '<td '.$atro_hl.'>';

if(($auto_ot_form!="")AND($head_approved_ot_form!="")){
	$ot_space_2nd="+";
}else{
	$ot_space_2nd="";
}
if($auto_ot_form!="" OR $head_approved_ot_form!=""){
	$ot_space="+";
}else{
	$ot_space="";
}

if($atro_form){
	$x = 50;
	$atro_form_arr = explode("*", wordwrap($atro_form, $x));

	if($atro_form_arr[0]){
		list($form_doc_no,$ot_no_of_hours) = explode("[",$atro_form_arr[0]);
		echo '<a href="'.base_url().'app/transaction_employees/form_view/'.$form_doc_no.'/emp_atro/HR008" target="_blank" title="EMPLOYEE FILE">OT['.$ot_no_of_hours.$ot_space.'</a>';
	}else{

	}
	//echo "&nbsp;";
	if($atro_form_arr[1]){
		list($form_doc_no1,$ot_no_of_hours1) = explode("[",$atro_form_arr[1]);
		echo '<a href="'.base_url().'app/transaction_employees/form_view/'.$form_doc_no1.'/emp_atro/HR008" target="_blank" title="EMPLOYEE FILE" >OT['.$ot_no_of_hours1.$ot_space.'</a>';
	}else{

	}

}else{

}

echo "".$auto_ot_form.$ot_space_2nd.$head_approved_ot_form.$atro_incentive_leave;

echo '</td>';
echo '<td '.$form_change_rdshift_hl.'>'. $change_sched_form.$change_rd_form.$advance_duty_form.'</td>';
echo '<td '.$form_leave_hl.'>';
if($leave_form){
	$x = 50;
	$leave_form_arr = explode("*", wordwrap($leave_form, $x));
	if($leave_form_arr[0]){
		list($leaveDocno,$leaveType,$leavePayType,$leaveColor,$leaveDayState) = explode("/",$leave_form_arr[0]);
		echo '<a href="'.base_url().'app/transaction_employees/form_view/'.$leaveDocno.'/employee_leave/HR002" target="_blank" '.$leaveColor.'  title="'.$leavePayType.'" > '.$leaveType.$leaveDayState.' </a>';		
	}else{}
	if($leave_form_arr[1]){
		list($leaveDocno,$leaveType,$leavePayType,$leaveColor,$leaveDayState) = explode("/",$leave_form_arr[1]);
		echo '<a href="'.base_url().'app/transaction_employees/form_view/'.$leaveDocno.'/employee_leave/HR002" target="_blank" '.$leaveColor.' title="'.$leavePayType.'" > '.$leaveType.$leaveDayState.' </a>';		
	}else{}
}else{

}
if($myprocessed_pending_leave){
echo $myprocessed_pending_leave;
}else{

}
echo '</td>';
echo '<td '.$form_ob_hl.'>';
if($ob_form){
	$x = 50;
	$ob_form_arr = explode("/", wordwrap($ob_form, $x));
	if($ob_form_arr[0]){
		echo '<a href="'.base_url().'app/transaction_employees/form_view/'.$ob_form_arr[0].'/emp_official_business/HR015" target="_blank" title="'.$ob_form_arr[0].'">Official Business</a>';
	}else{}
	if($ob_form_arr[1]){
		echo '<br><a href="'.base_url().'app/transaction_employees/form_view/'.$ob_form_arr[1].'/emp_official_business/HR015" target="_blank" title="'.$ob_form_arr[1].'">Official Business</a>';
	}else{}
}else{

}
echo '</td>';
echo '<td '.$form_tk_hl.'>'.$tk_complaint_form.'</td>';
echo '<td '.$form_ut_hl.'>'.$ut_form.'</td>';
echo '</tr>';
            $p_from = date ("Y-m-d", strtotime("+1 day", strtotime($p_from)));
	}


}// dtr summary is not manual
?>

</tbody>
</table>
</div>

<?php


$total_regular_hours=$mydtr_summary->total_regular_hours;
$total_regular_nd=$mydtr_summary->total_regular_nd;
$total_regular_overtime=$mydtr_summary->total_regular_overtime;
$total_regular_overtime_nd=$mydtr_summary->total_regular_overtime_nd;
$total_regular_hrs_restday=$mydtr_summary->total_regular_hrs_restday;
$total_restday_nd=$mydtr_summary->total_restday_nd;
$total_restday_overtime=$mydtr_summary->total_restday_overtime;
$total_restday_overtime_nd=$mydtr_summary->total_restday_overtime_nd;
$total_regular_hrs_reg_holiday=$mydtr_summary->total_regular_hrs_reg_holiday;
$total_reg_holiday_nd=$mydtr_summary->total_reg_holiday_nd;
$total_reg_holiday_overtime=$mydtr_summary->total_reg_holiday_overtime;
$total_reg_holiday_overtime_nd=$mydtr_summary->total_reg_holiday_overtime_nd;
$total_regular_hrs_reg_holiday_t1=$mydtr_summary->total_regular_hrs_reg_holiday_t1;
$total_regular_hrs_reg_holiday_t2=$mydtr_summary->total_regular_hrs_reg_holiday_t2;
$total_restday_reg_holiday_nd=$mydtr_summary->total_restday_reg_holiday_nd;
$total_restday_reg_holiday_overtime=$mydtr_summary->total_restday_reg_holiday_overtime;
$total_restday_reg_holiday_overtime_nd=$mydtr_summary->total_restday_reg_holiday_overtime_nd;
$total_regular_hrs_spec_holiday=$mydtr_summary->total_regular_hrs_spec_holiday;
$total_spec_holiday_nd=$mydtr_summary->total_spec_holiday_nd;
$total_spec_holiday_overtime=$mydtr_summary->total_spec_holiday_overtime;
$total_spec_holiday_overtime_nd=$mydtr_summary->total_spec_holiday_overtime_nd;
$total_restday_regular_hrs_spec_holiday=$mydtr_summary->total_restday_regular_hrs_spec_holiday;
$total_restday_spec_holiday_nd=$mydtr_summary->total_restday_spec_holiday_nd;
$total_restday_spec_holiday_overtime=$mydtr_summary->total_restday_spec_holiday_overtime;
$total_restday_spec_holiday_overtime_nd=$mydtr_summary->total_restday_spec_holiday_overtime_nd;
$absences_total=$mydtr_summary->absences_total;
$undertime_total=$mydtr_summary->undertime_total;
$tardiness_total=$mydtr_summary->tardiness_total;
$overbreak_total=$mydtr_summary->overbreak_total;
$absences_occurence=$mydtr_summary->absences_occurence;
$undertime_occurence=$mydtr_summary->undertime_occurence;
$tardiness_occurence=$mydtr_summary->tardiness_occurence;
$overbreak_occurence=$mydtr_summary->overbreak_occurence;


$complete_logs_present_occ=$mydtr_summary->complete_logs_present_occ;
$with_tk_logs_present_occ=$mydtr_summary->with_tk_logs_present_occ;
$with_ob_logs_present_occ=$mydtr_summary->with_ob_logs_present_occ;
$with_leave_present_occ=$mydtr_summary->with_leave_present_occ;
$restday_w_logs=$mydtr_summary->restday_w_logs;
$restday_wo_logs=$mydtr_summary->restday_wo_logs;
$reg_holiday_w_logs=$mydtr_summary->reg_holiday_w_logs;
$reg_holiday_wo_logs=$mydtr_summary->reg_holiday_wo_logs;
$snw_holiday_w_logs=$mydtr_summary->snw_holiday_w_logs;
$snw_holiday_wo_logs=$mydtr_summary->snw_holiday_wo_logs;
$rd_reg_holiday_w_logs=$mydtr_summary->rd_reg_holiday_w_logs;
$rd_reg_holiday_wo_logs=$mydtr_summary->rd_reg_holiday_wo_logs;
$rd_snw_holiday_w_logs=$mydtr_summary->rd_snw_holiday_w_logs;
$rd_snw_holiday_wo_logs=$mydtr_summary->rd_snw_holiday_wo_logs;
$complete_logs_present_occ_ref=$mydtr_summary->complete_logs_present_occ_ref;
$with_tk_logs_present_occ_ref=$mydtr_summary->with_tk_logs_present_occ_ref;
$with_ob_logs_present_occ_ref=$mydtr_summary->with_ob_logs_present_occ_ref;
$with_leave_present_occ_ref=$mydtr_summary->with_leave_present_occ_ref;
$restday_w_logs_ref=$mydtr_summary->restday_w_logs_ref;
$restday_wo_logs_ref=$mydtr_summary->restday_wo_logs_ref;
$reg_holiday_w_logs_ref=$mydtr_summary->reg_holiday_w_logs_ref;
$reg_holiday_wo_logs_ref=$mydtr_summary->reg_holiday_wo_logs_ref;
$snw_holiday_w_logs_ref=$mydtr_summary->snw_holiday_w_logs_ref;
$snw_holiday_wo_logs_ref=$mydtr_summary->snw_holiday_wo_logs_ref;
$rd_reg_holiday_w_logs_ref=$mydtr_summary->rd_reg_holiday_w_logs_ref;
$rd_reg_holiday_wo_logs_ref=$mydtr_summary->rd_reg_holiday_wo_logs_ref;
$rd_snw_holiday_w_logs_ref=$mydtr_summary->rd_snw_holiday_w_logs_ref;
$rd_snw_holiday_wo_logs_ref=$mydtr_summary->rd_snw_holiday_wo_logs_ref;



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
		<td><?php echo number_format($total_regular_hours,$decimal_place_no_setting);?></td>
		<td><?php echo number_format($total_regular_hrs_restday,$decimal_place_no_setting);?></td>
		<td><?php echo number_format($total_regular_hrs_reg_holiday,$decimal_place_no_setting);?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo number_format($total_regular_hrs_reg_holiday_t1,$decimal_place_no_setting);?></td>
		<td><?php echo number_format($total_regular_hrs_reg_holiday_t2,$decimal_place_no_setting); ?></td>
	</tr>
	</table>
		</td>
		<td><?php echo number_format($total_regular_hrs_spec_holiday,$decimal_place_no_setting);?></td>
		<td><?php echo number_format($total_restday_regular_hrs_spec_holiday,$decimal_place_no_setting); ?></td>
		<td>absences</td>		
		<td><?php

$show_holiday_absent=$this->time_dtr_model->get_holiday_absent($company_id,$pay_period,$employee_id);

if(!empty($show_holiday_absent)){

// sha means show holiday absent
	$sha_list="";
foreach($show_holiday_absent as $sha){

// ha means holiday absent
$ha_date=$sha->the_date;
$ha_remarks=$sha->remarks;

$sha_list.=$ha_date." : ".$ha_remarks."<br/>";
}

echo '<a data-toggle="tooltip" data-placement="left" data-html="true" title="'.$sha_list.'" >'.$absences_total.'</a>';

}else{
 echo $absences_total; 
}



		?></td>		
		<td><?php echo $absences_occurence;?></td>		
	</tr>	
<!--//============================================TIME SUMMARY- REGULAR ND-->			
	<tr>
		<td>Regular-ND</td>
		<td><?php echo number_format($total_regular_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($total_restday_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($total_reg_holiday_nd,$decimal_place_no_setting);?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo number_format($total_restday_reg_holiday_nd,$decimal_place_no_setting); ?></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo number_format($total_spec_holiday_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($total_restday_spec_holiday_nd,$decimal_place_no_setting); ?></td>
		<td>undertime</td>		
		<td><?php echo $undertime_total;?></td>		
		<td><?php echo $undertime_occurence;?></td>		
	</tr>	
<!--//============================================TIME SUMMARY- OVERTIME-->			
	<tr>
		<td>OVERTIME</td>
		<td><?php echo number_format($total_regular_overtime,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($total_restday_overtime,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($total_reg_holiday_overtime,$decimal_place_no_setting); ?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo number_format($total_restday_reg_holiday_overtime,$decimal_place_no_setting); ?></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo number_format($total_spec_holiday_overtime,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($total_restday_spec_holiday_overtime,$decimal_place_no_setting);?></td>
		<td>tardiness</td>		
		<td><?php echo $tardiness_total; ?></td>		
		<td><?php echo $tardiness_occurence;?></td>		
	</tr>	
<!--//============================================TIME SUMMARY- OVERTIME ND-->			
	<tr>
		<td>OVERTIME-ND</td>
		<td><?php echo number_format($total_regular_overtime_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($total_restday_overtime_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($total_reg_holiday_overtime_nd,$decimal_place_no_setting); ?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo number_format($total_restday_reg_holiday_overtime_nd,$decimal_place_no_setting); ?></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo number_format($total_spec_holiday_overtime_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($total_restday_spec_holiday_overtime_nd,$decimal_place_no_setting); ?></td>
		<td>overbreak</td>		
		<td><?php echo $overbreak_total; ?></td>		
		<td><?php echo $overbreak_occurence;?></td>		
	</tr>	
	</tbody>
</table>

<?php
if($is_manual_dtr=="1"){

}else{
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
			<td> leave adjustment view pending
			</td>
			<td>leave adjustment view pending </td>
		</tr>
		<tr>
			<td>OT</td>
			<td>content</td>
			<td>doc no</td>
		</tr>
	</tbody>
</table>
<?php } ?>
</div>

<!-- //========================== DTR SUMMARY HISTORY -->
<?php
if($is_manual_dtr=="1"){

}else{


?>
<a href="#show_history_<?php echo $company_id.$pay_period.$employee_id;?>" role="button" data-toggle="collapse" style="background-color: <?php echo $show_dtr_summary_button_bg;?>;color:<?php echo $show_dtr_summary_button_font_color;?>;" class="btn btn btn-xs" ><i class="fa fa-arrow-down"></i> Show DTR Summary History </a>

<a href="#show_attendance_root_<?php echo $company_id.$pay_period.$employee_id;?>" role="button" data-toggle="collapse" style="background-color: <?php echo $show_logs_root_button_bg;?>;color:<?php echo $show_logs_root_button_font_color;?>;"  class="btn btn btn-xs "><i class="fa fa-arrow-down"></i> Show Logs Root.</a>

<div class="collapse" id="show_attendance_root_<?php echo $company_id.$pay_period.$employee_id;?>">

<div class="datagrid">
<table   cellpadding="1" cellspacing="3">
	<thead>
		<tr>
			<th colspan="11" style="background-color: :#ff0000;text-align: center;"> DTR LOGS ROOT </th>

		</tr>
		<tr>
			<th>Type</th>
			<th>Count</th>
			<th>Reference</th>
		</tr>
	</thead>

	<tbody>
		
		<?php 
echo 
"<tr><td>No Forms</td>	<td> $complete_logs_present_occ </td>	<td> $complete_logs_present_occ_ref </td></tr>".
"<tr><td>With TK Form</td>	<td> $with_tk_logs_present_occ </td>	<td> $with_tk_logs_present_occ_ref </td></tr>".
"<tr><td>With Official Business</td>	<td> $with_ob_logs_present_occ </td>	<td> $with_ob_logs_present_occ_ref </td></tr>".
"<tr><td>With Leave Form</td>	<td> $with_leave_present_occ </td>	<td> $with_leave_present_occ_ref </td></tr>".
"<tr><td>Restday with logs (<i>& approved ot form</i>)</td>	<td> $restday_w_logs </td>	<td> $restday_w_logs_ref </td></tr>".
"<tr><td>Restday without logs</td>	<td> $restday_wo_logs </td>	<td> $restday_wo_logs_ref </td></tr>".

"<tr><td>Regular Holiday with logs (<i>& approved ot form</i>)</td>	<td> $reg_holiday_w_logs </td>	<td> $reg_holiday_w_logs_ref </td></tr>".
"<tr><td>Regular Holiday without logs</td>	<td> $reg_holiday_wo_logs </td>	<td> $reg_holiday_wo_logs_ref </td></tr>".
"<tr><td>Restday - Regular Holiday with logs (<i>& approved ot form</i>)</td>	<td> $rd_reg_holiday_w_logs </td>	<td> $rd_reg_holiday_w_logs_ref </td></tr>".
"<tr><td>Restday - Regular Holiday without logs</td>	<td> $rd_reg_holiday_wo_logs </td>	<td> $rd_reg_holiday_wo_logs_ref </td></tr>".

"<tr><td>SNW Holiday with logs (<i>& approved ot form</i>)</td>	<td> $snw_holiday_w_logs </td>	<td> $snw_holiday_w_logs_ref </td></tr>".
"<tr><td>SNW Holiday without logs</td>	<td> $snw_holiday_wo_logs </td>	<td> $snw_holiday_wo_logs_ref </td></tr>".
"<tr><td>Restday - SNW Holiday with logs (<i>& approved ot form</i>)</td>	<td> $rd_snw_holiday_w_logs </td>	<td> $rd_snw_holiday_w_logs_ref </td></tr>".
"<tr><td>Restday - SNW Holiday without logs</td>	<td> $rd_snw_holiday_wo_logs </td>	<td> $rd_snw_holiday_wo_logs_ref </td></tr>";

		?>
				
	</tbody>
</table>
</div>
</div>

<!-- //============================================================= -->

<div class="collapse" id="show_history_<?php echo $company_id.$pay_period.$employee_id;?>">

<div class="datagrid">
<table   cellpadding="1" cellspacing="3">
	<thead>
		<tr>
			<th colspan="11" style="background-color: :#ff0000;text-align: center;"> DTR SUMMARY HISTORY </th>

		</tr>
		<tr>
			<th>Description</th>
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

<?php

$mydtr_summary_history=$this->time_dtr_model->get_dtr_summary_history($company_id,$pay_period,$employee_id);
if(!empty($mydtr_summary_history)){
	foreach($mydtr_summary_history as $mydtr_history){
$h_total_regular_hours=$mydtr_history->total_regular_hours;
$h_total_regular_nd=$mydtr_history->total_regular_nd;
$h_total_regular_overtime=$mydtr_history->total_regular_overtime;
$h_total_regular_overtime_nd=$mydtr_history->total_regular_overtime_nd;
$h_total_regular_hrs_restday=$mydtr_history->total_regular_hrs_restday;
$h_total_restday_nd=$mydtr_history->total_restday_nd;
$h_total_restday_overtime=$mydtr_history->total_restday_overtime;
$h_total_restday_overtime_nd=$mydtr_history->total_restday_overtime_nd;
$h_total_regular_hrs_reg_holiday=$mydtr_history->total_regular_hrs_reg_holiday;
$h_total_reg_holiday_nd=$mydtr_history->total_reg_holiday_nd;
$h_total_reg_holiday_overtime=$mydtr_history->total_reg_holiday_overtime;
$h_total_reg_holiday_overtime_nd=$mydtr_history->total_reg_holiday_overtime_nd;
$h_total_regular_hrs_reg_holiday_t1=$mydtr_history->total_regular_hrs_reg_holiday_t1;
$h_total_regular_hrs_reg_holiday_t2=$mydtr_history->total_regular_hrs_reg_holiday_t2;
$h_total_restday_reg_holiday_nd=$mydtr_history->total_restday_reg_holiday_nd;
$h_total_restday_reg_holiday_overtime=$mydtr_history->total_restday_reg_holiday_overtime;
$h_total_restday_reg_holiday_overtime_nd=$mydtr_history->total_restday_reg_holiday_overtime_nd;
$h_total_regular_hrs_spec_holiday=$mydtr_history->total_regular_hrs_spec_holiday;
$h_total_spec_holiday_nd=$mydtr_history->total_spec_holiday_nd;
$h_total_spec_holiday_overtime=$mydtr_history->total_spec_holiday_overtime;
$h_total_spec_holiday_overtime_nd=$mydtr_history->total_spec_holiday_overtime_nd;
$h_total_restday_regular_hrs_spec_holiday=$mydtr_history->total_restday_regular_hrs_spec_holiday;
$h_total_restday_spec_holiday_nd=$mydtr_history->total_restday_spec_holiday_nd;
$h_total_restday_spec_holiday_overtime=$mydtr_history->total_restday_spec_holiday_overtime;
$h_total_restday_spec_holiday_overtime_nd=$mydtr_history->total_restday_spec_holiday_overtime_nd;
$h_absences_total=$mydtr_history->absences_total;
$h_undertime_total=$mydtr_history->undertime_total;
$h_tardiness_total=$mydtr_history->tardiness_total;
$h_overbreak_total=$mydtr_history->overbreak_total;
$h_absences_occurence=$mydtr_history->absences_occurence;
$h_undertime_occurence=$mydtr_history->undertime_occurence;
$h_tardiness_occurence=$mydtr_history->tardiness_occurence;
$h_overbreak_occurence=$mydtr_history->overbreak_occurence;

$h_date_process=$mydtr_history->date_process;
$h_system_user_id=$mydtr_history->system_user_id;
$h_users_employee_id=$mydtr_history->users_employee_id;
?>
<!--//============================================TIME SUMMARY- REGULAR HOURS-->		
	<tr>
		<td>Regular</td>
		<td><?php echo number_format($h_total_regular_hours,$decimal_place_no_setting);?></td>
		<td><?php echo number_format($h_total_regular_hrs_restday,$decimal_place_no_setting);?></td>
		<td><?php echo number_format($h_total_regular_hrs_reg_holiday,$decimal_place_no_setting);?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo number_format($h_total_regular_hrs_reg_holiday_t1,$decimal_place_no_setting);?></td>
		<td><?php echo number_format($h_total_regular_hrs_reg_holiday_t2,$decimal_place_no_setting); ?></td>
	</tr>
	</table>
		</td>
		<td><?php echo number_format($h_total_regular_hrs_spec_holiday,$decimal_place_no_setting);?></td>
		<td><?php echo number_format($h_total_restday_regular_hrs_spec_holiday,$decimal_place_no_setting); ?></td>
		<td>absences</td>		
		<td><?php echo $h_absences_total; ?></td>		
		<td><?php echo $h_absences_occurence;?></td>		
	</tr>	
<!--//============================================TIME SUMMARY- REGULAR ND-->			
	<tr>
		<td>Regular-ND</td>
		<td><?php echo number_format($h_total_regular_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($h_total_restday_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($h_total_reg_holiday_nd,$decimal_place_no_setting);?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo number_format($h_total_restday_reg_holiday_nd,$decimal_place_no_setting); ?></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo number_format($h_total_spec_holiday_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($h_total_restday_spec_holiday_nd,$decimal_place_no_setting); ?></td>
		<td>undertime</td>		
		<td><?php echo $h_undertime_total;?></td>		
		<td><?php echo $h_undertime_occurence;?></td>		
	</tr>	
<!--//============================================TIME SUMMARY- OVERTIME-->			
	<tr>
		<td>OVERTIME</td>
		<td><?php echo number_format($h_total_regular_overtime,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($h_total_restday_overtime,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($h_total_reg_holiday_overtime,$decimal_place_no_setting); ?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo number_format($h_total_restday_reg_holiday_overtime,$decimal_place_no_setting); ?></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo number_format($h_total_spec_holiday_overtime,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($h_total_restday_spec_holiday_overtime,$decimal_place_no_setting);?></td>
		<td>tardiness</td>		
		<td><?php echo $h_tardiness_total; ?></td>		
		<td><?php echo $h_tardiness_occurence;?></td>		
	</tr>	
<!--//============================================TIME SUMMARY- OVERTIME ND-->			
	<tr>
		<td>OVERTIME-ND</td>
		<td><?php echo number_format($h_total_regular_overtime_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($h_total_restday_overtime_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($h_total_reg_holiday_overtime_nd,$decimal_place_no_setting); ?></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo number_format($h_total_restday_reg_holiday_overtime_nd,$decimal_place_no_setting); ?></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo number_format($h_total_spec_holiday_overtime_nd,$decimal_place_no_setting); ?></td>
		<td><?php echo number_format($h_total_restday_spec_holiday_overtime_nd,$decimal_place_no_setting); ?></td>
		<td>overbreak</td>		
		<td><?php echo $h_overbreak_total; ?></td>		
		<td><?php echo $h_overbreak_occurence;?></td>		
	</tr>	
	<tr>
			<td>DATE PROCESS: </td>
			<td><?php echo $h_date_process;?></td>		
	</tr>
	<tr>
			<td>PROCESS BY: </td>
			<td><?php echo "employee id: ".$h_users_employee_id." , system user id: ".$h_system_user_id;?></td>		
	</tr>	
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>

<?php

	}
?>

	</tbody>
</table>




<?php

}else{
	// no dtr summary history yet.
}
?>

<?php } ?>
<?php

}else{

	if ($this->session->userdata('is_employee')){
    echo "
    <tr>
    <td colspan='25' style='text-align:center;'><i class='fa fa-close text-danger' style='font-size:48px;'></i>DTR is not yet processed.


    </td>
    </tr>";
	}else{
	    echo "
    <tr>
    <td colspan='25' style='text-align:center;'><i class='fa fa-close text-danger' style='font-size:48px;'></i>DTR is not yet processed.

    <i class='fa fa-quote-left text-info' style='font-size:20px;'></i>
    <span class='system_auto_guide'>choose Process DTR</span>
    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>

    </td>
    </tr>";	
	}



}

?>



</div>












</div>

<br><br>