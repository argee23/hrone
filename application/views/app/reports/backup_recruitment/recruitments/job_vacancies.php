<div class="col-md-3">

<?php if($employer_type=='public'){ echo "<input type='hidden' id='company' value='".$company_id."'>"; }
else{?>
    <div class="col-md-12"><label>Company:</label></div>
    <div class="col-md-12">
      <select class="form-control" id="company" onchange="japp_get_jobtitles('<?php echo $employer_type;?>',this.value);">
          <option value="all" selected>All</option>
            <?php 
              foreach($companyList as $company){?>
               <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php  } ?>
      </select>
    </div>
<?php } ?>
    <div class="col-md-12"><label>Job Title:</label></div>
    <div class="col-md-12">
      <select class="form-control" id="jobtitle">
          <?php if(empty($all)){?>
          <option value=''>No job title found.</option>
       <?php  } else {?>

       <?php  echo "<option value='all'>All</option>"; foreach($all as $a){?>
          <option value="<?php echo $a->job_id;?>"><?php echo $a->job_title;?></option>
      <?php }  }?>
      </select>
    </div>

    <div class="col-md-12"><label>Slot Range:</label></div>
    <div class="col-md-12"><input type="checkbox" onclick="for_change('slot_final','slot_from','slot_to');"> All</div>
    <input type="hidden" id="slot_final" value="0">
    <div class="col-md-6">
      <input type="number" class="form-control" id="slot_from">
    </div>
    <div class="col-md-6">
      <input type="number" class="form-control" id="slot_to">
    </div>

     <div class="col-md-12"><label>Salary Range:</label></div>
    <div class="col-md-12"><input type="checkbox" onclick="for_change('salary_final','salary_from','salary_to');"> All</div>
    <input type="hidden" id="salary_final" value="0">
    <div class="col-md-6">
      <input type="number" class="form-control" id="salary_from">
    </div>
    <div class="col-md-6">
      <input type="number" class="form-control" id="salary_to">
    </div>

    <div class="col-md-12"><label>Hire Start Range:</label></div>
    <div class="col-md-12"><input type="checkbox" onclick="for_change('hire_start_final','hire_start_from','hire_start_to');"> All</div>
    <input type="hidden" id="hire_start_final" value="0">
    <div class="col-md-12" >
      <input type="date" class="form-control" id="hire_start_from">
    </div>
    <div class="col-md-12" style="padding-top: 5px;">
      <input type="date" class="form-control" id="hire_start_to">
    </div>
    <div class="col-md-12"><label>Hire End Range:</label></div>
    <div class="col-md-12"><input type="checkbox" onclick="for_change('hire_end_final','hire_end_from','hire_end_to');"> All</div>
    <input type="hidden" id="hire_end_final" value="0">
    <div class="col-md-12">
      <input type="date" class="form-control" id="hire_end_from">
    </div>
    <div class="col-md-12" style="padding-top: 5px;">
      <input type="date" class="form-control" id="hire_end_to">
    </div>

    <div class="col-md-12"><label>Status:</label></div>
    <div class="col-md-12">
      <select class="form-control" id="status">
          <option value="all">All</option>
          <option value="1">open</option>
          <option value="0">close</option>
      </select>
    </div>

    <div class="col-md-12"><label>Location:</label></div>
    <div class="col-md-12"><input type="checkbox" onclick="for_change('location_final','province','city');"> All</div>
     <input type="hidden" id="location_final" value="0">
    <div class="col-md-12">
      <select class="form-control" id="province" onchange="get_city(this.value);">
          <option>Select Province</option>
                    <?php foreach($provinceList as $province){?>
                      <option value="<?php echo $province->id;?>"><?php echo $province->name;?></option>
                    <?php } ?>
      </select>
    </div>

     <div class="col-md-12" style="padding-top:5px;">
      <select class="form-control" id="city">
          <option>Select City</option>
      </select>
    </div>
     <?php if($employer_type=='hris'){ $ss='style="display:none;"';}else{ $ss=''; }?>
    <div class="col-md-12" <?php echo $ss;?>><label>Admin Verified Status:</label></div>
    <div class="col-md-12" <?php echo $ss;?>>
      <select class="form-control" id="adminstatus">
          <option value="all">All</option>
          <option value="waiting">pending</option>
          <option value="1">approved</option>
          <option value="cancelled">cancelled</option>
          <option value="rejected">rejected</option>
      </select>
    </div>

    <div class="col-md-12" style="margin-top: 10px;">
      <button class="col-md-12 btn btn-success" onclick="get_job_vacancies_results('<?php echo $employer_type;?>');">FILTER</button>
    </div>

   

</div>

<div class="col-md-9" id="req_report_action" style="overflow: scroll;">
  <table class="col-md-12 table table-hover" id="req_report">
    <thead>
      <tr class="danger">
        <th>No.</th>
        <th>Company Name</th>
        <th>Position</th>
        <th>Slot</th>
        <th>Salary</th>
        <th>Job Description</th>
        <th>Job Qaulification</th>
        <th>Hiring Start</th>
        <th>Hiring End</th>
        <th>Location</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
