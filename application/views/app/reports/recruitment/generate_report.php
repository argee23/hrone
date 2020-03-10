<br>
  <ol class="breadcrumb">
    <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Generate Reports | 
    <?php if($code=='RS1'){ echo "Recruitment Settings"; } else if($code=='JV1'){ echo "Job Vacancies"; } else if($code=='JA1'){ echo "Job Application"; }?>
    </h4>
  </ol>

  <div class="col-md-12" id="action_here_div">

  <?php if($code=='RS1'){?>
  <div class="col-md-3"></div>
  <div class="col-md-6">
      <select class="col-md-12 form-control" id="setting_code_type" name="setting_code_type" onchange="get_crystal_report(this.value,'<?php echo $employer_type;?>');">
        <option value="" disabled selected>Select Setting</option>
        <option value="S1">Job Requirements</option>
        <option value="S2">Application Status</option>
        <option value="S3">Interview Process</option>
        <option value="S4">Qualifying Questions</option>
        <option value="S5">Hypothetical Questions</option>
        <option value="S6">Multiple Choice</option>
        <option value="S7">Email Settings</option>
        <option value="S8">Acknowledgement Content</option>
        <option value="S9">Send Interview Email Notification</option>
      </select>

      <select class="col-md-12 form-control" id="crystal_report" name="crystal_report" style="margin-top: 5px;">
          <option value="" disabled selected>Select Crystal Report</option>
      </select>

      <?php if($employer_type=='public')
      {
        $company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
      ?>
        <input type="hidden" id="company_id" value="<?php echo $company_id;?>">

      <?php } else{?>

        <select class="col-md-12 form-control" id="company_id" name="company_id" style="margin-top: 5px;">
          <option value="" disabled selected>Select Company</option>
          <option value="All">All</option>
          <?php foreach($companyList as $comp){?>
            <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
          <?php } ?>
        </select>

      <?php } ?>
     

      <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="generate_report_settings_results('<?php echo $code;?>','<?php echo $employer_type;?>');">GENERATE REPORT</button>
  </div>
  <div class="col-md-3"></div>




  <?php } else if($code=='JV1'){?>

  <div class="col-md-2"></div>
  <div class="col-md-8">
      <select class="form-control" onchange="job_vacancies_filtering(this.value,'<?php echo $employer_type;?>')">
          <option value="" disabled selected>Select Job Vacancies Filtering Type</option>
          <option value='VR1'>Posted Job Vacancies</option>
          <option value='VR2'>Applicants Per Job Position</option>
          <option value='VR3'>Job Vacancies Status (open or close)</option>
          <option value='VR4'>List of Ongoing Job Vacancies</option>
          <option value='VR5'>With target number of applicant / date</option>
          <option value='VR6'>Target Applicant status (check remaining applicant needed)</option>
          <option value='VR7'>Check the target applicants / date Status</option>
          <?php if($employer_type=='public'){ ?><option value='VR8'>Admin Verified Filtering (From public recruitment only)</option><?php } ?>
      </select>
  </div>
  <div class="col-md-2"></div>
  <br><br><br>
  <div class="box box-default" class='col-md-12'></div> 

  <div id="filteringjobvacancies">


  </div>

  <?php  } else if($code=='JA1'){ ?>

    <div class="col-md-2"></div>
    <div class="col-md-8">
        <select class="form-control" onchange="job_application_filtering(this.value,'<?php echo $employer_type;?>')">
            <option value="" disabled selected>Select Job Application Filtering Type</option>
            <option value='AR1'>Job Application Details</option>
            <option value='AR2'>Hired Applicants (date range)</option>
            <option value='AR3'>For Interview Applicants</option>
            <option value='AR4'>List of applicants to be interviewed by the "employee name"</option>
            <option value='AR5'>List of Pending Applications (no application status yet)</option>
            <option value='AR6'>Blocked Applicants</option>
            <option value='AR7'>Hired Applicants</option>
        </select>
    </div>
    <div class="col-md-2"></div>
    <br><br><br>
    <div class="box box-default" class='col-md-12'></div> 

    <div id="filteringjobapplications">


    </div>

  <?php } else if($code=='JAL1'){?>


    <div class="col-md-2"></div>
    <div class="col-md-8">
        <select class="form-control" onchange="job_analytics_filtering(this.value,'<?php echo $employer_type;?>')">
          <option value="" disabled selected>Select Job Analytics Filtering Type</option>
          <?php foreach($analytics as $a){ if($a->code=='A8'){ if($employer_type=='public'){} else{?>
              <option value="<?php echo $a->code;?>"><?php echo $a->title;?></option>
          <?php } } else {?>
                <option value="<?php echo $a->code;?>"><?php echo $a->title;?></option>
          <?php } } ?>
        </select>
    </div>
    <div class="col-md-2"></div>
    <br><br><br>
    <div class="box box-default" class='col-md-12'></div> 

    <div id="filteringjobanalytics">

    </div>


    <?php } ?>


  <br><br><br><br><br><br><br><br>
  <!-- <div class="box box-default" class='col-md-12'></div> -->
    <div class="col-md-12" id="generate_reports" style="overflow:scroll;">
    </div>
  </div>