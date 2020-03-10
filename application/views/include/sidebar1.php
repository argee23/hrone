<div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
  </div>
<!-- //================= Admin module -->
<div class="btn-group" role="group">
<a type="button" class="btn btn-danger dropdown-toggle btn-flat" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Administrator</a>
<?php
echo '
<ul class="dropdown-menu">'.
'
<li><a href="'.base_url().'app/file_maintenance"><i class="fa fa-files-o"></i> File Maintenance</a></li>
<li><a href="'.base_url().'app/user/index"><i class="fa fa-files-o"></i> User Management</a></li>
<li><a href="'.base_url().'app/roles/index"><i class="fa fa-files-o"></i> User Roles</a></li>
<li><a href="'.base_url().'app/leave_type/index"><i class="fa fa-files-o"></i> Leave Type</a></li>
<li><a href="'.base_url().'app/leave_management/index"><i class="fa fa-files-o"></i>Leave Management</a></li>
<li><a href="'.base_url().'app/holiday_list/index"><i class="fa fa-files-o"></i> Holiday List</a></li>
<li><a href="'.base_url().'app/form_approval/index"><i class="fa fa-files-o"></i> Form Approval</a></li>
<li><a href="'.base_url().'app/section_manager/index"><i class="fa fa-files-o"></i> Section Manager</a></li>
</ul>';
?> 
</div>  
<!-- //================= 201 module -->                         
<div class="btn-group" role="group">
    <a type="button" class="btn btn-success btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> 201 Employee Files</a>
<?php
echo '
<ul class="dropdown-menu">'.
'<li><a href="'.base_url().'app/employee"><i class="fa fa-files-o"></i>Employee Masterlist</a></li>
<li><a href="'.base_url().'app/employee_user_define_fields/user_define_fields"><i class="fa fa-files-o"></i>User Define Fields</a></li>
<li><a href="'.base_url().'app/employee_mass_update/index"><i class="fa fa-files-o"></i>Mass Update</a></li>
<li><a href="'.base_url().'app/employee_account_management/index"><i class="fa fa-files-o"></i>Account Management</a></li>
<li><a href="'.base_url().'app/employee_emp_prof_update_request"><i class="fa fa-files-o"></i>Request for 201 Update</a></li>
<li><a href="'.base_url().'app/account_security"><i class="fa fa-files-o"></i>Account Security</a></li>
</ul>';
?> 
</div>
<!-- //================= Recruitment module -->   
<div class="btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-newspaper-o"></i> Recruitment</a>
<?php
echo '
<ul class="dropdown-menu">'.
'<li><a href="'.base_url().'app/recruitment"><i class="fa fa-files-o"></i>Job Vacancies</a></li>
<li><a href="'.base_url().'app/recruitment/job_application"><i class="fa fa-files-o"></i>Job Application</a></li>
<li><a href="'.base_url().'app/recruitment/job_analytics"><i class="fa fa-files-o"></i>Job Analytics</a></li>
<li><a href="'.base_url().'app/recruitment/requirements"><i class="fa fa-files-o"></i>Requirements</a></li>
<li><a href="'.base_url().'app/recruitment/questions"><i class="fa fa-files-o"></i>Questions</a></li>
</ul>';
?> 

</div>
<!-- //================= Transaction module -->  
<div class="btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-book"></i> Transaction</a>
<?php
echo '
<ul class="dropdown-menu">'.
'<li><a href="'.base_url().'app/transaction_file_maintenance"><i class="fa fa-files-o"></i>System Default Forms</a></li>
<li><a href="'.base_url().'app/transaction_user_define_fields"><i class="fa fa-files-o"></i>User Define Forms</a></li>
<li><a href="'.base_url().'app/transaction_employees"><i class="fa fa-files-o"></i>Transactions Management</a></li>
</ul>';
?> 

</div>
<!-- //================= Time module --> 
<div class="btn-group" role="group">
    <a type="button" class="btn btn-danger btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-clock-o"></i> Time</a>
<?php
echo '
<ul class="dropdown-menu">'.
'<li><a href="'.base_url().'app/time_dtr"><i class="fa fa-files-o"></i>Generate Daily Time Record (DTR)</a></li>
<li><a href="'.base_url().'app/time_shift_table"><i class="fa fa-files-o"></i>Shift Table</a></li>
<li><a href="'.base_url().'app/time_payroll_period"><i class="fa fa-files-o"></i>Payroll Period</a></li>
<li><a href="'.base_url().'app/time_settings"><i class="fa fa-files-o"></i>Time Settings</a></li>
<li><a href="'.base_url().'app/plot_schedule"><i class="fa fa-files-o"></i>Plot Schedule</a></li>
<li><a href="'.base_url().'app/time_fixed_schedule"><i class="fa fa-files-o"></i>Fixed Schedule</a></li>

<li><a href="'.base_url().'app/time_flexi_schedule"><i class="fa fa-files-o"></i>Flexi Schedule</a></li>
<li><a href="'.base_url().'app/time_manual_attendance/time_manual_attendance"><i class="fa fa-files-o"></i>Manual Upload Attendance</a></li>
<li><a href="'.base_url().'app/time_view_attendance/time_view_attendance"><i class="fa fa-files-o"></i>View Attendance</a></li>
<li><a href="'.base_url().'app/time_biometrics_setup"><i class="fa fa-files-o"></i>Biometrics Setup</a></li>
</ul>';
?> 
</div>
<!-- //================= Payroll module --> 
<div class="btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-clock-o"></i> Payroll</a>
<?php
echo '
<ul class="dropdown-menu">'.
'<li><a href="'.base_url().'app/payroll_generate_payslip/index"><i class="fa fa-files-o"></i>Generate Payslip</a></li>
<li><a href="'.base_url().'app/payroll_file_maintenance/index"><i class="fa fa-files-o"></i>File Maintenance</a></li>
<li><a href="'.base_url().'app/payroll_incentive_leave/index"><i class="fa fa-files-o"></i>Incentive Leave</a></li>
<li><a href="'.base_url().'app/payroll_compensation/index"><i class="fa fa-files-o"></i>Compensation</a></li>
<li><a href="'.base_url().'app/payroll_lock_period/index"><i class="fa fa-files-o"></i>Lock Payroll Period</a></li>
<li><a href="'.base_url().'app/payroll_other_addition_emp_enrollment/index"><i class="fa fa-files-o"></i>Other Addition Employee Enrollment</a></li>
<li><a href="'.base_url().'app/payroll_other_deduction_emp_enrollment/index"><i class="fa fa-files-o"></i>Other Deduction Employee Enrollment</a></li>
<li><a href="'.base_url().'app/payroll_formula"><i class="fa fa-files-o"></i>Payroll Formula</a></li>
<li><a href="'.base_url().'app/payroll_emp_loan_enrolment/index"><i class="fa fa-files-o"></i>Employee Loans Enrollment</a></li>
<li><a href="'.base_url().'app/payroll_settings_controller/index"><i class="fa fa-files-o"></i>Payroll Settings</a></li>
</ul>';
?> 
</div>
<!-- //================= Reports Module --> 
<div class="btn-group" role="group">
    <a type="button" class="btn btn-success btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-excel-o"></i> Reports</a>
<?php
echo '
<ul class="dropdown-menu">'.
'<li><a href="'.base_url().'app/reports_employee"><i class="fa fa-files-o"></i>Employee</a></li>
<li><a href="'.base_url().'app/reports_recruitment"><i class="fa fa-files-o"></i>Recruitment</a></li>
<li><a href="'.base_url().'app/reports_time"><i class="fa fa-files-o"></i>Time</a></li>
<li><a href="'.base_url().'app/reports_transaction"><i class="fa fa-files-o"></i>Transaction</a></li>
<li><a href="'.base_url().'app/report_analytics"><i class="fa fa-files-o"></i>Analytics</a></li>
</ul>';
?> 
</div>
<!-- //================= Notification Module --> 
<div class="btn-group" role="group">
    <a type="button" class="btn btn-info btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-warning"></i> Notification</a>
<?php
echo '
<ul class="dropdown-menu">'.
'<li><a href="'.base_url().'app/code_of_discipline/index"><i class="fa fa-files-o"></i>Code of Discipline</a></li>
</ul>';
?> 
</div>

</div>

