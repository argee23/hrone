<br>
  <ol class="breadcrumb">
    <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Crystal Reports | 
      <?php if($code=='CRR1'){ echo "Recruitment Settings"; } else if($code=='CRR2'){ echo "Job Vacancies"; } else if($code=='CRR3') { echo "Job Application"; } else if($code=='CRR4') { echo "Job Analytics"; } else if($code=='CRR5') { echo "Hired Applicants"; } else{ echo "Interview Details"; } ?>
    </h4>
  </ol>


  <div class="col-md-12" id="action_here_div">

  <div class="col-md-4"></div>
  <div class="col-md-4">
      <select class="col-md-12 form-control" id="code_type" name="code_type">
      <?php if($code=='CRR2'){?>
        <option value="" disabled selected>Select Job Vacancy Options</option>
        <option value="V1">V1 - Job Vacancy</option>
        <option value="V2">V2 - Job Vacancy Applicant Details</option>
      <?php } else if($code=='CRR3'){?>

          <option value="" disabled selected>Select Application Reports</option>
          <option value="AR1">AR1 - Job Application Details</option>
          <option value="AR2">AR2 - Applied Applicants on specific date </option>
          <option value="AR3">AR3 - For Interview Applicants(date and time range)</option>
          <option value="AR4">AR4 - List of applicants to be interviewed by the "employee name"</option>
          <option value="AR5">AR5 - Pending applications (no application status yet)</option>
          <option value="AR6">AR6 - Blocked Applicants</option>
          <option value="AR7">AR7 - Hired Applicants</option>
          <option value="AR8">AR8 - Applicant Interview Result</option>

      <?php } else if($code=='CRR4'){?>
            <option value="" disabled selected>Select Analytics</option>
        <?php foreach($analytics as $a){?>
            <option value="<?php echo $a->code;?>"><?php echo $a->code." - ".$a->title;?></option>
      <?php } }  else{?>

        <option value="" disabled selected>Select Setting</option>
        <option value="S1">S1 - Job Requirements </option>
        <option value="S2">S2 - Application Status</option>
        <option value="S3">S3 - Interview Process</option>
        <option value="S4">S4 - Qualifying Questions</option>
        <option value="S5">S5 - Hypothetical Questions</option>
        <option value="S6">S6 - Multiple Choice</option>
        <option value="S7">S7 - Email Settings </option>
        <option value="S8">S8 - Acknowledgement</option>
        <option value="S9">S9 - Send Interview Email Notification</option>
        <option value="S10">S10 - Plantilla</option>
        <option value="S11">S11 - Recruitment Approval Setting</option>
        <option value="S12">S12 - Maximum Number of Approval </option>
        <option value="S13">S13 - Approver Choices</option>
        <option value="S14">S14 - Approved Job Vacancy Request Settings</option>
        <option value="S15">S15 - Cancel Job Vacancy Request on Employee Portal</option>
        <option value="S16">S16 - Assigned Employee and Email for Email Notification</option>
      <?php } ?>
      </select>
      <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="add_crystal_report('<?php echo $code;?>');"> ADD CRYSTAL REPORT</button>
  </div>
  <div class="col-md-4"></div>

   <br><br><br><br><br>
   <div class="box box-default" class='col-md-12'></div>
    <div class="col-md-12">
      <table class="table table-hover" id="crystal_report_table">
          <thead>
              <tr class="danger">
                <th>No.</th>
                <th>Type</th>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
          </thead>
          <tbody>
            <?php $i=1; foreach($crystal_report as $cd){
              $code = $cd->code;
            ?>
              <tr>
                <td><?php echo $i;?></td>
                <td>

                    <?php 
                     echo $code;  
                    ?>
                      
                </td>
                <td><?php echo $cd->title;?></td>
                <td><?php echo $cd->description;?></td>
                <td>
                    
                    <?php if($cd->InActive==1){} else{ ?><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_crystal_report('edit','<?php echo $cd->id?>','<?php echo $cd->type;?>','<?php echo $cd->code;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Update Crystal report details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> <?php } ?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="stat_crystal_report('delete','<?php echo $cd->id?>','<?php echo $cd->type;?>','<?php echo $cd->code;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                       <?php if($cd->InActive==1){?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="stat_crystal_report('enable','<?php echo $cd->id?>','<?php echo $cd->type;?>','<?php echo $cd->code;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                        <?php }else{ ?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'onclick="stat_crystal_report('disable','<?php echo $cd->id?>','<?php echo $cd->type;?>','<?php echo $cd->code;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                        <?php } ?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="stat_crystal_report('view','<?php echo $cd->id?>','<?php echo $cd->type;?>','<?php echo $cd->code;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to View crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                </td>
              </tr>
            <?php $i++; } ?>
          </tbody>
      </table>
    </div>

  </div>