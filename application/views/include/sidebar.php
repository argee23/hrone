<?php
/*
--------------------------
Check Admin module user access.
--------------------------
*/

$administrator_tab=$this->session->userdata('administrator_tab');
$file_maintenance_li=$this->session->userdata('file_maintenance_li');
$user_management_li=$this->session->userdata('user_management_li');
$user_roles_li=$this->session->userdata('user_roles_li');
$leave_type_li=$this->session->userdata('leave_type_li');
$leave_management_li=$this->session->userdata('leave_management_li');
$holiday_list_li=$this->session->userdata('holiday_list_li');
$form_approval_li=$this->session->userdata('form_approval_li');
$section_manager_li=$this->session->userdata('section_manager_li');

/*
--------------------------
Check Employee module user access.
--------------------------
*/
$employee_tab=$this->session->userdata('employee_tab');
$employee_masterlist_li=$this->session->userdata('employee_masterlist_li');
$emp_user_def_field_li=$this->session->userdata('emp_user_def_field_li');
$emp_mass_update_li=$this->session->userdata('emp_mass_update_li');
$emp_account_mng_li=$this->session->userdata('emp_account_mng_li');
$emp_201_request_li=$this->session->userdata('emp_201_request_li');

/*
--------------------------
Check Recruitment module user access.
--------------------------
*/
$recruitment_tab=$this->session->userdata('recruitment_tab');
$recruitment_jobs_li=$this->session->userdata('recruitment_jobs_li');
$rec_job_application_li=$this->session->userdata('rec_job_application_li');
$rec_requirements_li=$this->session->userdata('rec_requirements_li');
$rec_questions_li=$this->session->userdata('rec_questions_li');
$rec_job_analytics_li=$this->session->userdata('rec_job_analytics_li');

/*
--------------------------
Check Transactions/Forms module user access.
--------------------------
*/

$transaction_tab=$this->session->userdata('transaction_tab');
$transaction_default_forms_li=$this->session->userdata('transaction_default_forms_li');
$transaction_user_def_forms_li=$this->session->userdata('transaction_user_def_forms_li');
$transaction_management_li=$this->session->userdata('transaction_management_li');

/*
--------------------------
Check Timekeeping module user access.
--------------------------
*/

$time_tab=$this->session->userdata('time_tab');
$time_shift_table_li=$this->session->userdata('time_shift_table_li');
$time_payroll_period_li=$this->session->userdata('time_payroll_period_li');
$time_settings_li=$this->session->userdata('time_settings_li');
$time_plot_schedule_li=$this->session->userdata('time_plot_schedule_li');
$time_fixed_schedule_li=$this->session->userdata('time_fixed_schedule_li');
$time_dtr_li=$this->session->userdata('time_dtr_li');
$time_flexi_schedule_li=$this->session->userdata('time_flexi_schedule_li');
$time_compress_schedule_li=$this->session->userdata('time_compress_schedule_li');
$time_manual_upd_att_li=$this->session->userdata('time_manual_upd_att_li');
$time_view_attendance=$this->session->userdata('time_view_attendance');
$time_bio_setup_li=$this->session->userdata('time_bio_setup_li');
$time_web_bundy_li=$this->session->userdata('time_web_bundy_li');
$time_late_abs_li=$this->session->userdata('time_late_abs_li');

/*
--------------------------
Check Payroll module user access.
--------------------------
*/
$payroll_tab=$this->session->userdata('payroll_tab');
$pr_gen_payslip_li=$this->session->userdata('pr_gen_payslip_li');
$pr_gen_13th_month_pay_li=$this->session->userdata('pr_gen_13th_month_pay_li');
$pr_gen_bonus_li=$this->session->userdata('pr_gen_bonus_li');
$pr_convert_leave_cash_li=$this->session->userdata('pr_convert_leave_cash_li');
$pr_gen_last_pay_li=$this->session->userdata('pr_gen_last_pay_li');
$pr_fm_li=$this->session->userdata('pr_fm_li');
$pr_incentive_leave_li=$this->session->userdata('pr_incentive_leave_li');
$pr_compensation_li=$this->session->userdata('pr_compensation_li');
$pr_lock_pp_li=$this->session->userdata('pr_lock_pp_li');
$pr_oa_emp_enrol_li=$this->session->userdata('pr_oa_emp_enrol_li');
$pr_od_emp_enrol_li=$this->session->userdata('pr_od_emp_enrol_li');
$pr_formula_li=$this->session->userdata('pr_formula_li');
$pr_hold_emp_payroll_li=$this->session->userdata('pr_hold_emp_payroll_li');
$pr_loans_emp_enrol_li=$this->session->userdata('pr_loans_emp_enrol_li');
$pr_settings_li=$this->session->userdata('pr_settings_li');
$pr_automatic_ot_meal=$this->session->userdata('pr_automatic_ot_meal');
$pr_prio_ded_li=$this->session->userdata('pr_prio_ded_li');
$pr_retro_pay_li=$this->session->userdata('pr_retro_pay_li');

/*
--------------------------
Check Memos/Notification module user access.
--------------------------
*/

$notification_tab=$this->session->userdata('notification_tab');


/*
--------------------------
Check PMS module user access.
--------------------------
*/
$pms_tab=$this->session->userdata('pms_tab');
$pms_settings_li=$this->session->userdata('pms_settings_li');
$pms_scorecard_li=$this->session->userdata('pms_scorecard_li');
$pms_evaluator_li=$this->session->userdata('pms_evaluator_li');
$pms_approver_li=$this->session->userdata('pms_approver_li');
$pms_eval_mngt_li=$this->session->userdata('pms_eval_mngt_li');
$pms_app_mngt_li=$this->session->userdata('pms_app_mngt_li');

$sms_tab=$this->session->userdata('sms_tab');

/*
--------------------------
Check Reports module user access.
--------------------------
*/

$reports_tab=$this->session->userdata('reports_li');
$report_employee_li=$this->session->userdata('report_employee_li');
$report_recruitment_li=$this->session->userdata('report_recruitment_li');
$report_dtr_li=$this->session->userdata('report_dtr_li');
$report_payroll_li=$this->session->userdata('report_payroll_li');
$report_transaction_li=$this->session->userdata('report_transaction_li');
$report_pms_li=$this->session->userdata('report_pms_li');
$report_notification_li=$this->session->userdata('report_notification_li');
$report_analytics_li=$this->session->userdata('report_analytics_li');
$report_training_li=$this->session->userdata('report_training_li');


            if($this->session->userdata('serttech_account')=="1"){
              $recompute_pagibig_employer_share="";
              $recompute_sss_ec="";
              $udf_add_to_crystal_report="";
            }else{
              $recompute_pagibig_employer_share="hidden";
              $recompute_sss_ec="hidden";
              $udf_add_to_crystal_report="hidden";
            }
?>

<div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
  </div>
<!-- //================= Admin module -->
<div class="<?php echo $administrator_tab;?> btn-group" role="group">
<a type="button" class="btn btn-danger dropdown-toggle btn-flat" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Administrator</a>
<?php
echo '
<ul class="dropdown-menu">'.
'
<li class="'.$file_maintenance_li.'">
  <a href="'.base_url().'app/file_maintenance"><i class="fa fa-files-o"></i> File Maintenance</a>
</li>
<li class="'.$user_management_li.'">
  <a href="'.base_url().'app/user/index"><i class="fa fa-files-o"></i> User Management</a>
</li>
<li class="'.$user_roles_li.'">
  <a href="'.base_url().'app/roles/index"><i class="fa fa-files-o"></i> User Roles</a>
</li>
<li class="'.$leave_type_li.'">
  <a href="'.base_url().'app/leave_type/index"><i class="fa fa-files-o"></i> Leave Type</a>
</li>
<li class="'.$leave_management_li.'">
  <a href="'.base_url().'app/leave_management/index"><i class="fa fa-files-o"></i>Leave Management</a>
</li>
<li class="'.$holiday_list_li.'">
  <a href="'.base_url().'app/holiday_list/index"><i class="fa fa-files-o"></i> Holiday List</a>
</li>
<li class="'.$form_approval_li.'">
  <a href="'.base_url().'app/form_approval/index"><i class="fa fa-files-o"></i> Form Approval</a>
</li>
<li class="'.$form_approval_li.'">
  <a href="'.base_url().'app/salary_approval/index"><i class="fa fa-files-o"></i>Salary Approval </a>
</li>
<li class="'.$form_approval_li.'">
  <a href="'.base_url().'app/notification_approval/index"><i class="fa fa-files-o"></i>Notification Approval</a>
</li>
<li class="'.$section_manager_li.'">
  <a href="'.base_url().'app/section_manager/index"><i class="fa fa-files-o"></i> Section Manager</a>
</li>
<li>
  <a href="'.base_url().'app/email_settings/index"><i class="fa fa-files-o"></i>Email Setting</a>
</li>
<li>
  <a href="'.base_url().'app/downloadable_forms/index"><i class="fa fa-files-o"></i>Downloadable Forms</a>
</li>
<li>
  <a href="'.base_url().'app/inventory_storage_settings/index"><i class="fa fa-files-o"></i>Inventory Storage Setting</a>
</li>
<li>
  <a href="'.base_url().'app/working_schedule_color_code/index"><i class="fa fa-files-o"></i>Working Schedule Color Code</a>
</li>

<li>
  <a href="'.base_url().'app/employee_acknowledgment_settings/index"><i class="fa fa-files-o"></i>Employee Acknowledgment Setting</a>
</li>

<li><a href="'.base_url().'app/downloadable_company_policy/index"><i class="fa fa-files-o"></i>Downloadable Company Policy</a></li>
<li><a href="'.base_url().'app/code_of_discipline/index"><i class="fa fa-files-o"></i>Code of Discipline</a></li>
</ul>';
?> 
</div>  
<!-- //================= Recruitment module -->   
<?php
if(true){

}else{
?>
<div class="<?php echo $recruitment_tab;?> btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-newspaper-o"></i> Recruitment</a>
<?php

echo '
 <ul class="dropdown-menu">'.

'
 <li class="'.$recruitment_jobs_li.'">
      <a href="'.base_url().'app/recruitment_hris/index";><i class="fa fa-files-o"></i>Settings</a>
    </li>

    <li class="'.$recruitment_jobs_li.'">
        <a href="'.base_url().'app/recruitment_plantilla/vacancies/hris";><i class="fa fa-files-o"></i>Job Vacancies</a>
    </li>

    <li class="'.$recruitment_jobs_li.'">
        <a href="'.base_url().'app/recruitment_plantilla/analytics/hris";><i class="fa fa-files-o"></i>Job Analytics</a>
    </li>

    <li class="'.$recruitment_jobs_li.'">
      <a href="'.base_url().'app/final_recruitments/job_application_index/hris/all/all"><i class="fa fa-files-o"></i>Job Application</a>
    </li>
    
    <li class="'.$recruitment_jobs_li.'">
      <a href="'.base_url().'app/recruitment_request/index";><i class="fa fa-files-o"></i>Job Vacancy Request</a>
    </li>

    <li class="'.$recruitment_jobs_li.'">
      <a href="'.base_url().'app/recruitment_job_request_approval/index";><i class="fa fa-files-o"></i>Job Vacancy Request Approval</a>
    </li>

    <li class="'.$recruitment_jobs_li.'">
      <a href="'.base_url().'app/manual_adding_approved_request/index";><i class="fa fa-files-o"></i>Manual Adding of Approved Job Vacancy Request</a>
    </li>

</ul>';
?> 

</div>
<?php
}
?>
<!-- //================= 201 module -->                         
<div class="<?php echo $employee_tab;?> btn-group" role="group">
    <a type="button" class="btn btn-success btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> 201 Employee</a>
<?php
echo '
<ul class="dropdown-menu">'.
'
<li class="'.$employee_masterlist_li.'">
  <a href="'.base_url().'app/employee"><i class="fa fa-files-o"></i>Employee Masterlist</a>
</li>
<li class="'.$emp_user_def_field_li.'">
  <a href="'.base_url().'app/employee_user_define_fields/user_define_fields"><i class="fa fa-files-o"></i>User Define Fields</a>
</li>
<li class="'.$emp_mass_update_li.'">
  <a href="'.base_url().'app/employee_mass_update/index"><i class="fa fa-files-o"></i>Mass Update</a>
</li>
<li class="'.$emp_account_mng_li.'">
  <a href="'.base_url().'app/employee_account_management/index"><i class="fa fa-files-o"></i>Account Management</a>
</li>
<li class="'.$emp_201_request_li.'">
  <a href="'.base_url().'app/employee_emp_prof_update_request"><i class="fa fa-files-o"></i>Request for 201 Update</a>
</li>
<li class="'.$emp_account_mng_li.'">
  <a href="'.base_url().'app/account_security"><i class="fa fa-files-o"></i>Employee Account Info</a>
</li>
<li>
  <a href="'.base_url().'app/employee_training_seminars_final"><i class="fa fa-files-o"></i>Employee Trainings and Seminars</a>
</li>
</ul>';
?> 
</div>

<!-- //================= Transaction module -->  
<div class="<?php echo $transaction_tab;?> btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-book"></i> Transaction</a>
<?php
echo '
<ul class="dropdown-menu">'.
'<li class="'.$transaction_default_forms_li.'">
  <a href="'.base_url().'app/transaction_file_maintenance"><i class="fa fa-files-o"></i>System Default Forms</a>
</li>
<li class="'.$transaction_user_def_forms_li.'">
  <a href="'.base_url().'app/transaction_user_define_fields"><i class="fa fa-files-o"></i>User Define Forms</a>
</li>
<li class="'.$transaction_management_li.'">
  <a href="'.base_url().'app/transaction_employees"><i class="fa fa-files-o"></i>Transactions Management</a>
</li>
</ul>';
?> 

</div>
<!-- //================= Time module --> 
<div class="<?php echo $time_tab;?> btn-group" role="group">
    <a type="button" class="btn btn-danger btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-clock-o"></i> Time</a>
<?php
echo '
<ul class="dropdown-menu">'.
'<li class="'.$time_dtr_li.'">
  <a href="'.base_url().'app/time_dtr"><i class="fa fa-files-o"></i>Generate Daily Time Record (DTR)</a>
</li>
<li class="'.$time_shift_table_li.'">
  <a href="'.base_url().'app/time_shift_table"><i class="fa fa-files-o"></i>Shift Table</a>
</li>
<li class="'.$time_plot_schedule_li.'">
  <a href="'.base_url().'app/plot_schedules"><i class="fa fa-files-o"></i>Plot Schedule</a>
</li>
<li class="'.$time_payroll_period_li.'">
  <a href="'.base_url().'app/time_payroll_period"><i class="fa fa-files-o"></i>Payroll Period</a>
</li>
<li class="'.$time_manual_upd_att_li.'">
  <a href="'.base_url().'app/time_manual_attendance/time_manual_attendance"><i class="fa fa-files-o"></i>Manual Upload Attendance</a>
</li>
<li class="'.$time_view_attendance.'">
  <a href="'.base_url().'app/time_view_attendance/time_view_attendance"><i class="fa fa-files-o"></i>View Attendance</a>
</li>
<li class="'.$time_fixed_schedule_li.'">
  <a href="'.base_url().'app/time_fixed_schedule"><i class="fa fa-files-o"></i>Fixed Schedule</a>
</li>
<li class="'.$time_flexi_schedule_li.'">
  <a href="'.base_url().'app/time_flexi_schedule"><i class="fa fa-files-o"></i>Flexi Schedule</a>
</li>
<li class="'.$time_compress_schedule_li.'">
  <a href="'.base_url().'app/time_compress_schedule"><i class="fa fa-files-o"></i>Compress Work Schedule</a>
</li>
<li class="'.$time_settings_li.'">
  <a href="'.base_url().'app/time_settings"><i class="fa fa-files-o"></i>Time Settings</a>
</li>
<li class="'.$time_bio_setup_li.'">
  <a href="'.base_url().'app/time_biometrics_setup"><i class="fa fa-files-o"></i>Biometrics Setup</a>
</li>
<li class="'.$time_web_bundy_li.'">
  <a href="'.base_url().'app/time_web_bundy/web_bundy"><i class="fa fa-files-o"></i>Web Bundy</a>
</li>
';

// <li>
//   <a href="'.base_url().'app/time_work_schedule/index"><i class="fa fa-files-o"></i>Check Employee Work Schedule </a>
// </li>

echo '
<li class="'.$time_late_abs_li.'" >
  <a href="'.base_url().'app/late_absences_occurence_settings/index"><i class="fa fa-files-o"></i>Late and Absences Monitoring </a>
</li>

</ul>

';
?> 
</div>
<!-- //================= Payroll module --> 

<div class="<?php echo $payroll_tab;?> btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-clock-o"></i> Payroll</a>
<?php
echo '
<ul class="dropdown-menu">'.
'<li class="'.$pr_gen_payslip_li.'">
<a href="'.base_url().'app/payroll_generate_payslip/index"><i class="fa fa-files-o"></i>Generate Payslip</a>
</li>

<li class="'.$pr_fm_li.'">
<a href="'.base_url().'app/payroll_file_maintenance/index"><i class="fa fa-files-o"></i>File Maintenance</a>
</li>

<li class="'.$pr_compensation_li.'">
<a href="'.base_url().'app/payroll_compensation/index"><i class="fa fa-files-o"></i>Compensation</a>
</li>

<li class="'.$pr_oa_emp_enrol_li.'">
<a href="'.base_url().'app/payroll_other_addition_emp_enrollment/index"><i class="fa fa-files-o"></i>Other Addition Employee Enrollment</a>
</li>
<li class="'.$pr_od_emp_enrol_li.'">
<a href="'.base_url().'app/payroll_other_deduction_emp_enrollment/index"><i class="fa fa-files-o"></i>Other Deduction Employee Enrollment</a>
</li>

<li class="'.$pr_loans_emp_enrol_li.'">
<a href="'.base_url().'app/payroll_emp_loan_enrolment/index"><i class="fa fa-files-o"></i>Employee Loans Enrollment</a>
</li>

<li class="'.$pr_automatic_ot_meal.'">
<a href="'.base_url().'app/payroll_automatic_ot_meal/index"><i class="fa fa-files-o"></i>Automatic OT Meal</a>
</li>
<li class="'.$pr_retro_pay_li.'">
<a href="'.base_url().'app/payroll_generate_retro/index"><i class="fa fa-files-o"></i>Compute Retro Pay</a>
</li>
<li class="'.$pr_prio_ded_li.'">
<a href="'.base_url().'app/payroll_priority_deduction/index"><i class="fa fa-files-o"></i>Priority Deduction</a>
</li>
<li class="'.$pr_gen_13th_month_pay_li.'">
<a href="'.base_url().'app/payroll_generate_13th_month/index"><i class="fa fa-files-o"></i>Generate 13th Month Pay</a>
</li>
<li class="'.$pr_gen_bonus_li.'">
<a href="'.base_url().'app/payroll_generate_bonus/index"><i class="fa fa-files-o"></i>Generate Bonus</a>
</li>
<li class="'.$pr_convert_leave_cash_li.'">
<a href="'.base_url().'app/Leave_conversion/index"><i class="fa fa-files-o"></i>Convert Leave To Cash</a>
</li>
<li class="'.$pr_gen_last_pay_li.'">
<a href="'.base_url().'app/payroll_generate_lastpay/index"><i class="fa fa-files-o"></i>Generate Last Pay</a>
</li>
<li class="'.$pr_lock_pp_li.'">
<a href="'.base_url().'app/payroll_lock_period/index"><i class="fa fa-files-o"></i>Lock Payroll Period</a>
</li>
<li class="'.$pr_incentive_leave_li.'">
<a href="'.base_url().'app/payroll_incentive_leave/index"><i class="fa fa-files-o"></i>Incentive Leave Table</a>
</li>

<li class="'.$pr_formula_li.'">
<a href="'.base_url().'app/payroll_formula"><i class="fa fa-files-o"></i>Payroll Formula</a></li>
<li class="'.$pr_hold_emp_payroll_li.'">
<a href="'.base_url().'app/payroll_hold_employee"><i class="fa fa-files-o"></i>Hold Employee Payroll</a></li>

<li class="'.$pr_settings_li.'">
<a href="'.base_url().'app/payroll_settings_controller/index"><i class="fa fa-files-o"></i>Payroll Settings</a>
</li>
<li>
<a href="'.base_url().'app/payroll_compensation/pending_salary_information_approval"><i class="fa fa-files-o"></i>Salary Information Approval </a>
</li>
</ul>';
?> 
</div>

<!-- //================= Notification Module --> 
<div class="<?php echo $notification_tab;?> btn-group" role="group">
    <a type="button" class="btn btn-info btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-warning"></i> Memo(s)</a>
<?php
echo '
<ul class="dropdown-menu">'.
'
<li><a href="'.base_url().'app/notification_user_define_fields/index"><i class="fa fa-files-o"></i>User Define Notification</a></li>
<li><a href="'.base_url().'app/issue_notifications/index"><i class="fa fa-files-o"></i>Issue Notification</a></li>
</ul>';

?> 
</div>


<!-- //================= PMS Module -->
<div class="btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-folder"></i> PMS</a>


<ul class="dropdown-menu">
  <li>
  <a href="<?=base_url();?>app/pms/index"><i class="fa fa-files-o"></i>Settings</a>

  </li>


</ul>
 
</div>



<!-- //================= Reports Module --> 
<div class="<?php echo $reports_tab?> btn-group" role="group">
    <a type="button" class="btn btn-success btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-excel-o"></i> Reports</a>
<?php
//<li><a href="'.base_url().'app/reports_employee"><i class="fa fa-files-o"></i>Employee (old)</a></li>

echo '
<ul class="dropdown-menu">'.
'

<li class="'.$report_employee_li.'"><a href="'.base_url().'app/employee_reports"><i class="fa fa-files-o"></i>Employee Report</a></li>
<li class="'.$report_recruitment_li.'"><a href="'.base_url().'app/report_recruitments/index/hris"><i class="fa fa-files-o"></i>Recruitment</a></li>
<li class="'.$report_dtr_li.'"><a href="'.base_url().'app/reports_time"><i class="fa fa-files-o"></i>Time</a></li>
<li class="'.$report_payroll_li.'"><a href="'.base_url().'app/reports_payroll"><i class="fa fa-files-o"></i>Payroll</a></li>
<li class="'.$report_transaction_li.'"><a href="'.base_url().'app/reports_transaction"><i class="fa fa-files-o"></i>Transaction</a></li>
<li class="'.$report_pms_li.'"><a href="'.base_url().'app/report_pms"><i class="fa fa-files-o"></i>PMS</a></li>
<li class="'.$report_analytics_li.'"><a href="'.base_url().'app/report_analytics"><i class="fa fa-files-o"></i>Analytics</a></li>
<li class="'.$report_notification_li.'"><a href="'.base_url().'app/notifications_report"><i class="fa fa-files-o"></i>Notification</a></li>
<li class="'.$report_training_li.'"><a href="'.base_url().'app/training_seminar_reports"><i class="fa fa-files-o"></i>Training and Seminar Reports</a></li>
<li class="'.$report_training_li.'"><a href="'.base_url().'app/training_seminar_request_reports"><i class="fa fa-files-o"></i>Training and<br> Seminar Request Reports</a></li>
<li class="'.$report_recruitment_li.'"><a href="'.base_url().'app/interview_checklist"><i class="fa fa-files-o"></i>Interview Checklist</a></li>

<li class=""><a href="'.base_url().'app/reports_leave_calendar/index_leave_calendar/"><i class="fa fa-files-o"></i>Leave Calendar</a></li>

<li><a href="'.base_url().'app/uploaded_files"><i class="fa fa-files-o"></i>Uploaded Files</a></li>



<li class="'.$recompute_pagibig_employer_share.'"><a href="'.base_url().'app/reports_payroll/correct_pi_employer_contribution" target="_blank"><i class="fa fa-files-o"></i>Recompute Pagibig<br> Employer Share</a></li>

<li class="'.$recompute_sss_ec.'"><a href="'.base_url().'app/reports_payroll/correct_sss_employer_ec" target="_blank"><i class="fa fa-files-o"></i>Recompute SSS EC</a></li>
<li class="'.$recompute_sss_ec.'"><a href="'.base_url().'app/reports_payroll/correct_sss_employer_share" target="_blank"><i class="fa fa-files-o"></i>Recompute SSS Employer Share</a></li>
<li class="'.$udf_add_to_crystal_report.'"><a href="'.base_url().'app/employee_reports/crystal_report_add_udffield" target="_blank"><i class="fa fa-files-o"></i>Add User Define Fields to<br> Crystal Report</a></li>

</ul>';
?> 
</div><!-- //================= SMS Module --> 


<div class="<?php echo $sms_tab;?> btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-folder"></i> SMS</a>


<?php
echo '
<ul class="dropdown-menu">'.
'<li><a href="'.base_url().'app/sms"><i class="fa fa-files-o"></i>SMS</a></li>
</ul>';
?> 
</div>
</div>

