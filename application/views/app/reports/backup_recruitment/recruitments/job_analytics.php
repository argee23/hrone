<div class="col-md-3">
   <?php if($employer_type=='public'){ echo "<input type='hidden' id='company' value='".$company_id."'>"; }
    else{?>
    <div class="col-md-12"><label>Company:</label></div>
    <div class="col-md-12">
      <select class="form-control" id="company"  onchange="japp_get_jobtitles('<?php echo $employer_type;?>',this.value);">
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
    <div class="col-md-12">
      <input type="number" class="form-control" id="slot_from">
    </div>
    <div class="col-md-12" style="padding-top: 5px;">
      <input type="number" class="form-control" id="slot_to">
    </div>

    <div class="col-md-12" style="padding-top: 20px;">
      <button class="col-md-12 btn btn-success" onclick="get_job_analytics_results('<?php echo $employer_type;?>');">FILTER</button>
    </div>
    

</div>

<div class="col-md-9" id="req_report_action">
  <table class="col-md-12 table table-hover" id="req_report">
    <thead>
      <tr class="danger">
        <th>No.</th>
        <th>Company Name</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>