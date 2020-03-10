<div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" href="<?php echo base_url()?>employee_portal/employee_dashboard/"><i class="fa fa-dashboard"></i> Dashboard</a>
  </div>

  <div class="btn-group" role="group">
    <a type="button" href="<?php echo base_url()?>employee_portal/employee_201/" class="btn btn-success btn-flat"><i class="fa fa-files-o"></i> My Profile</a>
  </div>

  <div class="btn-group" role="group">
    <a type="button" class="btn btn-danger btn-flat dropdown-toggle" href="<?php echo base_url()?>employee_portal/employee_transactions/"  data-toggle="dropdown"><i class="fa fa-book"></i> Transactions</a>
      <ul class="dropdown-menu">
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/employee_transactions/transactions"><i class="fa fa-eye"></i> View Filed Transactions</a></li>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/employee_transactions/"><i class="fa fa-plus-circle"></i> Create New Transaction</a></li>
      </ul>
  </div>
<div class="btn-group" role="group">
    <a type="button" class="btn btn-success btn-flat dropdown-toggle" href="<?php echo base_url()?>employee_portal/employee_transactions/"  data-toggle="dropdown"><i class="fa fa-money"></i> Memos</a>
      <ul class="dropdown-menu">
        <li class="bg-danger"><a href="<?php echo base_url()?>employee_portal/employee_notifications/"><i class="fa fa-money"></i> My Notification </a></li></li>
      </ul>
  </div>



<div class="btn-group" role="group">
    <a type="button" class="btn btn-info btn-flat dropdown-toggle" href="<?php echo base_url()?>employee_portal/employee_transactions/"  data-toggle="dropdown"><i class="fa fa-calendar"></i> DTR</a>
      <ul class="dropdown-menu">
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/employee_dtr/working_schedule/"><i class="fa fa-calendar"></i> My Working Schedule</a></li>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/My_dtr/myattendance"><i class="fa fa-calendar-o"></i> My Attendances</a></li>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/My_dtr/"><i class="fa fa-calendar-check-o"></i> My Daily Time Record (DTR)</a></li>
      </ul>
  </div>

<div class="btn-group" role="group">
    <a type="button" class="btn btn-success btn-flat dropdown-toggle" href="<?php echo base_url()?>employee_portal/employee_transactions/"  data-toggle="dropdown"><i class="fa fa-money"></i> Payroll</a>
      <ul class="dropdown-menu">
        <li class="bg-info"><a href=""><a href="<?php echo base_url()?>employee_portal/my_payslip/"><i class="fa fa-money"></i> Payslip</a></li></li>
        <li class="bg-info"><a href=""><a href="<?php echo base_url()?>employee_portal/my_payslip/my_loan/"><i class="fa fa-money"></i> Loan Record</a></li></li>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/my_payslip/my_oa/"><i class="fa fa-money"></i> Other Addition</a></li></li>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/my_payslip/my_od/"><i class="fa fa-money"></i> Other Deduction</a></li></li>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/my_payslip/my_13th_month/"><i class="fa fa-money"></i> 13th Month Payslip</a></li></li>
        <li class="bg-danger"><a href=""><i class="fa fa-money"></i> Bonus</a></li></li>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/my_payslip/my_ytd/"><i class="fa fa-money"></i> My YTD</a></li></li>
      </ul>
  </div>

     <div class="btn-group" role="group">
    <a type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i> Others</a>
    <ul class="dropdown-menu">

      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/employee_faq/"><i class="fa fa-eye"></i>FAQ</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>app/downloadable_forms/employee_downloadable_forms"><i class="fa fa-eye"></i>Downloadable Forms</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/company_policy/"><i class="fa fa-eye"></i>Company Policy</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/points_history"><i class="fa fa-eye"></i>Points History</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/training_request"><i class="fa fa-eye"></i>Training and Seminar Requests</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/poll/"><i class="fa fa-eye"></i>Poll</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/for_interview_applicants"><i class="fa fa-eye"></i>For Interview Applicants</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/interview_applicants_status"><i class="fa fa-eye"></i>For Applicant Interview Status</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/applicant_interview_result"><i class="fa fa-eye"></i>Applicant Interview Result</a></li>
    </ul>
  </div>
  
  <?php 
        $employee_id = $this->session->userdata('employee_id'); 
        $check_salary = $this->general_model->check_approvers_salary($employee_id);
        $check_notification = $this->general_model->check_approvers_notification($employee_id);
        $check_transaction = $this->general_model->check_approvers_transaction($employee_id);
        if($check_salary!='true' AND $check_notification!='true' AND $check_transaction!='true'){}else{
    ?>
   <div class="btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file-text-o"></i>Approval</a>
      <ul class="dropdown-menu">
       <?php if($check_transaction=='true'){?>
       <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/form_approver/"><i class="fa fa-file-text-o"></i>Form(s) Approval</a></li>
       <?php } if($check_notification=='true'){?>
       <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/notification_approver/"><i class="fa fa-money"></i>Notification(s) Approval</a></li></li>

        <?php }
              if($check_salary=='true')
              {
        ?>

       <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/salary_approver/"><i class="fa fa-money"></i>Salary Approval</a></li></li>
       <?php } ?>
      </ul>
  </div>
 
 <?php } ?>
   
   
  <div class="btn-group" role="group">  
    <a type="button" class="btn btn-success btn-flat " href="<?php echo base_url()?>employee_portal/employee_settings/" ><i class="fa fa-gear"></i>Settings</a>
  </div>

   <?php $ci = &get_instance(); 
      $ci->load->model("employee_portal/pms_model"); 

      $creator = $ci->pms_model->is_scorecard_creator($this->session->userdata('employee_id'));
      $evaluator = $ci->pms_model->is_form_evaluator($this->session->userdata('employee_id'));
      $fp_approver = $ci->pms_model->is_form_approver($this->session->userdata('employee_id'));
      $emp = $ci->pms_model->is_form_employee($this->session->userdata('employee_id'));
    ?>

<div class="btn-group" role="group">
    <a type="button" class="btn btn-info btn-flat dropdown-toggle" href="#"  data-toggle="dropdown"><i class="fa fa-calendar"></i> PMS</a>
      <ul class="dropdown-menu">
          
      <?php if($creator){ ?>   
       <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/pms/"><i class="fa fa-calendar"></i>Create Scorecard</a></li>
     <?php }

     if($evaluator){?>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/pms/evaluation"><i class="fa fa-calendar-o"></i>Evaluate Scorecard</a></li>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/pms/evaluation_history/"><i class="fa fa-calendar-check-o"></i>History of Evaluation  </a></li>
    <?php }
    if($fp_approver){  ?>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/pms/index_approval/"><i class="fa fa-calendar-check-o"></i>PMS Form Approval</a></li>
         <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/pms/approver_history/"><i class="fa fa-calendar-check-o"></i>History of Approval</a></li>
      
      <?php }elseif($emp){?>
              <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/pms/view_pms/"><i class="fa fa-calendar-check-o"></i>My Appraisal Form</a></li>
              <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/pms/selfeval/"><i class="fa fa-calendar-check-o"></i>Self Evaluation</a></li>
      <?php  } ?>
      </ul>
  </div>

  <?php if ($this->session->userdata('is_section_manager')) { 
    ?>
  <div class="btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sitemap"></i> My Staffs</a>
      <ul class="dropdown-menu">
       <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/section_mngr_management/"><i class="fa fa-calendar"></i> Manage Schedules</a></li>
       <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/overtime_management/index/<?php echo 'approved';?>"><i class="fa fa-clock-o"></i> Manage Allowed & Approved Over Time </a></li>
        <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/overtime_management/index/<?php echo 'pre_approved';?>"><i class="fa fa-clock-o"></i> Manage Pre-Approved Over Time </a></li>
        <li class="bg-danger"><a href="<?php echo base_url()?>employee_portal/walapa/index/<?php echo 'pre_approved';?>"><i class="fa fa-clock-o"></i> Personnel Employment Status </a></li>
         <li class="bg-danger"><a href="<?php echo base_url()?>employee_portal/employee_work_schedule_sm/index/<?php echo 'pre_approved';?>"><i class="fa fa-clock-o"></i>Employee Work Schedule</a></li>
      </ul>
  </div>
  <?php } ?>



 <?php if ($this->session->userdata('is_section_manager')) { 
    ?>
  <div class="btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i> Reports</a>
    <ul class="dropdown-menu pull-right">
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/personnel_reports/index_schedule_report/"><i class="fa fa-clock-o"></i>Personnel Schedule Report</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/personnel_reports/index_forms_report/"><i class="fa fa-clock-o"></i>Personnel Forms Report</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/personnel_reports/index_approved_ot/"><i class="fa fa-clock-o"></i>Personnel Allowed and Approved Overtime</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/personnel_reports/index_preapproved_ot/"><i class="fa fa-clock-o"></i>Personnel Pre-Approved Overtime</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>employee_portal/personnel_reports/index_leave_calendar/"><i class="fa fa-clock-o"></i>Personnel Leave Calendar</a></li>
       <li class="bg-danger"><a href="<?php echo base_url()?>employee_portal/notification_approver_reports/index"><i class="fa fa-clock-o"></i>Personnel Notification Report</a></li>
        <li class="bg-danger"><a href="<?php echo base_url()?>employee_portal/applicant_interview_result_report/index"><i class="fa fa-clock-o"></i>Applicant Interview Result</a></li>
    </ul>
  </div>
<?php } ?>
</div>