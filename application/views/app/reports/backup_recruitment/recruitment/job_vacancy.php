<!-- <div class="well"> -->
  <div class="box box-success">
    <div class="box-header">
      <!-- <h1>Coachella</h1> -->
    </div>
    <div class="box-body">
      <h3> Job Vacancy Reports</h3>
      <h4> Filter Report by: </h4>
      <div class="row">
      <div class="col-md-3">
          <label>Company :</label>
          <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="reports()">
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
 }else{
  echo '<option selected="selected" value="0"> All Companies </option>';
 } 
?>          
          
          <?php 
            foreach($companyList as $company){
            if($_POST['company'] == $company->company_id){
                $selected = "selected='selected'";
            }else{
                $selected = "";
            }
            ?>
            <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php }?>
          </select>
      </div>
      <div class="col-md-3">
        <label>Job Title :</label>
        <select class="form-control select2" name="job_title" id="job_title" style="width: 100%;" onchange="reports()">
        <option selected="selected" value="0"> All Job Titles </option>
        <?php 
          foreach($alljobsList as $job){
          ?>
          <option value="<?php echo $job->job_title;?>"><?php echo $job->job_title;?></option>
          <?php }?>
        </select>
       </div>
    <div class="col-md-3">
        <label>Slot :</label>
        <input type="text" name="slot" id="slot" class="form-control" required="required" placeholder="Type Available Slots here" onKeyUp="reports()">
    </div>
    <div class="col-md-3">
        <label>Salary :</label>
        <input type="text" name="salary" id="salary" class="form-control" required="required" placeholder="Type Salary here" onKeyUp="reports()">
    </div>
    </div>
    <div class="row">
    <div class="col-md-3">
        <label>Hire Start :</label>
        <input type="text" name="hireStart" class="form-control" id="hireStart" />
    </div>
    <div class="col-md-3">
        <label>Hire End :</label>
        <input type="text" name="hireEnd" class="form-control" id="hireEnd" />
    </div>
    <div class="col-md-3">
        <label> Status :</label>
        <select class="form-control" name="status" id="status" style="width: 100%;" onchange="reports()">
        <option selected="selected" disabled="disabled" value="">- Select Status -</option>
        <option value="1">Open</option>
        <option value="0">Close</option>
        </select>
    </div>
    </div>
    <!-- <div class="row"> -->
    <div class="col-md-12" id="fill" style="padding: 0 0 1% 0">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <hr>
      </div>
    </div>
    <table id="jobVacancy" class="table table-bordered table-striped">
            <thead>
                      <tr>
                        <th>Company Name</th>
                        <th>Position</th>
                        <th>Slot</th>
                        <th>Salary</th>
                        <th>Job Description</th>
                        <th>Job Qualification</th>
                        <th>Hiring Start</th>
                        <th>Hiring End</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($reports as $reports){ ?>

                      <tr>
                        <td><?php echo $reports->company_name?></td>
                        <!-- <td><a tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="focus" title="Event Description" data-content="<?php echo nl2br($reports->event_description) ?>"><?php echo $reports->event_title?></a></td> -->
                        <!-- <td>
                          <a role="button" data-html="true" data-toggle="collapse" data-target="#info_<?php echo $reports->id?>"><?php echo $reports->job_title?></a>
                          <div id="info_<?php echo $reports->id?>" class="collapse">
                          <p class="text-success">
                          <?php echo nl2br($reports->event_description) ?>
                          </p>
                          </div>
                        </td> -->
                        <td><?php echo $reports->job_title?></td>
                        <td><?php echo $reports->job_vacancy?></td>
                        <td><?php echo $reports->salary?></td>
                        <td><?php echo $reports->job_description?></td>
                        <td><?php echo $reports->job_qualification?></td>
                        <td><?php echo $reports->hiring_start?></td>
                        <td><?php echo $reports->hiring_end?></td>
                        <td><?php if($reports->status_per_company == 1){ echo "Open";} else { echo "Close"; } ?></td>  
                        
                        <!-- <td>
                        <?php 
                        if($reports->event_start && $reports->event_end < date('Y-m-d H:i:s')) { 
                          echo "<strong class='text-danger'>Completed</strong>";
                        } 
                        else if ($reports->event_start < date('Y-m-d H:i:s') && $reports->event_end > date('Y-m-d H:i:s')){
                          echo "<strong class='text-success'>Ongoing</strong>";
                        }
                        else{
                          echo "<strong class='text-info'>Upcoming</strong>";
                        } 
                        ?>
                        </td> -->
                      </tr>
                      <?php }?>
                     
                    </tbody>
    </table>
    </div>
    </div>
    </div>
<!-- </div> -->


