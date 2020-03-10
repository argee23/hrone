<div class="col-md-3">

    <?php if($employer_type=='public'){ echo "<input type='hidden' id='jobcompany' value='".$company_id."'>"; }
    else{?>
       <div class="col-md-12"><label>Company:</label></div>
        <div class="col-md-12">
          <select class="form-control" id="jobcompany" onchange="japp_get_jobtitles('<?php echo $employer_type;?>',this.value);">
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
          <option value="all">All Job Title</option>
          <?php 
          foreach($all as $a){?>
            <option value="<?php echo $a->job_id;?> "><?php echo $a->job_title;?></option>
          <?php }?>
      </select>
    </div>

   

    <div class="col-md-12"><label>Date Applied Range:</label></div>
    <div class="col-md-12"><input type="checkbox" onclick="for_change('jobdate_applied_final','date_applied_from','date_applied_to');"> All</div>
    <input type="hidden" id="jobdate_applied_final" value="0">
    <div class="col-md-12" >
      <input type="date" class="form-control" id="date_applied_from">
    </div>
    <div class="col-md-12" style="padding-top: 5px;">
      <input type="date" class="form-control" id="date_applied_to">
    </div>
    
   
    <div class="col-md-12"><label>Status:</label></div>
    <div class="col-md-12">
      <select class="form-control" id="jobstatus">
          <option value="" selected disabled>Select</option>
          <option value="all">All</option>
          <?php 
          foreach($status as $stat){?>
            <option value="<?php echo $stat->id;?>"><?php echo $stat->status_title;?></option>
          <?php } ?>
          ?>
      </select>
    </div>
    <div class="col-md-12" style="padding-top: 20px;">
    <button class="col-md-12 btn btn-success" onclick="get_job_application_results('<?php echo $employer_type;?>');">FILTER</button>
    </div>

</div>

<div class="col-md-9" id="req_report_action">
  <table class="col-md-12 table table-hover" id="req_report">
    <thead>
      <tr class="danger">
        <th>No.</th>
        <th>Company Name</th>
        <th>Name</th>
        <th>Date Applied</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>