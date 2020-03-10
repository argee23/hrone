
<button type="button"  class="btn btn-danger" onclick="printDiv('printableArea')" value="PRINT" >Print</button>
<div id="printableArea">
<?php
/*
-------------------------------------------------------------------
declare/ready general variables needed in viewing the processed dtr.
-------------------------------------------------------------------
*/
$employee_id=$this->session->userdata('employee_id');
$selected_individual_employee_id=$employee_id;
$pay_period=$payroll_period_id;

if(!empty($emp_profile)){

	$count_employees=1;
	$mysalaryrate="";

$pay_type_name=$emp_profile->pay_type_name;
$date_employed=$emp_profile->date_employed;

$division_id=$emp_profile->division_id;
$section_id=$emp_profile->section;

$wDivision=$emp_profile->wDivision;
$wSubsection=$emp_profile->wSubsection;
$section=$emp_profile->section_name;
$name=$emp_profile->name;
$employment=$emp_profile->employment_name;
$dept=$emp_profile->dept_name;
$classification=$emp_profile->classification;
$position=$emp_profile->position_name;
$location=$emp_profile->location_name;

$payslip_status=""; // remain this as is.


}else{

}
if(!empty($pp_details)){

$pay_period_from=$pp_details->complete_from;
$pay_period_to=$pp_details->complete_to;
$month_cover=$pp_details->month_cover;
$will_early_cutoff=$pp_details->will_early_cutoff;


$p_from=$pay_period_from;
$p_to=$pay_period_to;

}else{

}


require_once(APPPATH.'views/app/time/dtr/dtr_theme.php');
require_once(APPPATH.'views/app/time/dtr/check_auto_early_cutoff_setting.php');
require_once(APPPATH.'views/app/time/dtr/check_auto_early_cutoff.php');
require_once(APPPATH.'views/app/time/dtr/check_dtr_policy.php');


?>
<br><br>

<?php
//============================================ START CHECK COMPANY DIVISION AND SUBSECTION SETTING  ============================================
require_once(APPPATH.'views/app/time/dtr/check_division_and_subsection.php');
//============================================ END CHECK COMPANY DIVISION AND SUBSECTION SETTING  ============================================



require_once(APPPATH.'views/app/time/dtr/dtr_design.php');
require_once(APPPATH.'views/app/time/dtr/dtr_header.php');
?>

	<tbody>
<?php
require(APPPATH.'views/app/time/dtr/view_processed_dtr.php');

?> 
	</tbody>
</table>	
</div>
</div>
