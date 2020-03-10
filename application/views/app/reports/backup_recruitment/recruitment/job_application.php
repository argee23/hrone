<!-- <div class="well"> -->
  <div class="box box-success">
    <div class="box-header">
      <!-- <h1>Coachella</h1> -->
    </div>
    <div class="box-body">
      <h3> Job Application Reports</h3>
      <h4> Filter Report by: </h4>
      <div class="row">
      <div class="col-md-3">
          <label>Company :</label>
          <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="reportsApplication()">
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
        <label>Position :</label>
        <select class="form-control select2" name="position" id="position" style="width: 100%;" onchange="reportsApplication()">
        <option selected="selected" value="0"> All Position </option>
        <?php 
          foreach($alljobsList as $job){
          ?>
          <option value="<?php echo $job->job_title;?>"><?php echo $job->job_title;?></option>
          <?php }?>
        </select>
       </div>
       <div class="col-md-3">
        <label>Date Applied :</label>
        <input type="text" name="date_applied" class="form-control" id="date_applied" />
      </div>
      <div class="col-md-3">
        <label> Status :</label>
        <select class="form-control" name="status" id="status" style="width: 100%;" onchange="reportsApplication()">
        <option selected="selected" value="0">- All Status -</option>
        <?php 
            foreach($application_optionList as $status){
        ?>
            <option value="<?php echo $status->app_stat_id;?>"><?php echo $status->status_title;?></option>
        <?php }?>
        </select>
      </div>
    </div>
    <div class="row">
    
    </div>
    <!-- <div class="row"> -->
    <div class="col-md-12" id="fill" style="padding: 0 0 1% 0">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <hr>
      </div>
    </div>
    <table id="jobApplication" class="table table-bordered table-striped">
            <thead>
                      <tr>
 <?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
}else{
  echo '<th>Company Name</th>';
}
?>                     
                        
                        <th>Name</th>
                        <th>Position</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($applicantListAll as $reports){ ?>

                      <tr>
 <?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
}else{
  echo '<td>'.$reports->company_name.'</td>';
}
?>                        

                        <td><?php echo $reports->fullname?></td>
                        <td><?php echo $reports->job_title?></td>
                        <td><?php echo $reports->date_applied?></td>
                        <td><?php if(isset($reports->status_title)){echo $reports->status_title;} else { echo "No Status Set Yet";}?></td>
                        
                      </tr>
                      <?php }?>
                     
                    </tbody>
    </table>
    </div>
    </div>
    </div>
<!-- </div> -->


