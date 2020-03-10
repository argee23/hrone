<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/manual_adding_approved_request/admin_manual_adding/<?php echo $doc_no;?>">

<?php foreach($doc as $f){
  foreach($emp as $e){
?>

    <div class="modal-content">
      <div class="modal-header" >
          <button type="button" class="close" onclick="window.location.reload()">&times;</button>
          <h4 class="modal-title text-success"><b>RECRUITMENT JOB VACANCY REQUEST</center></b></h4>
      </div>
      <div class="modal-body">
          <div class="well well-sm bg-olive">
            <div class="media">
              <div class="media-left media-middle">
                <span><img src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $e->picture;?>" class="media-object" style="width:150px"></span>
              </div>
              <div class="media-body">
                  <h4 class="media-heading text-black"><strong><?php echo $e->fullname;?></strong></h4>
                  <span class="col-sm-6">
                    <dt>Division</dt>
                    <dd>
                        <?php if(!empty($e->dept_name)){ echo $e->dept_name; }?>
                    </dd>
                    <dt>Department</dt>
                    <dd>
                        <?php echo $e->dept_name;?>
                    </dd>
                    <dt>Section</dt>
                    <dd>
                        <?php echo $e->section_name;?>
                    </dd> 
                    <dt>Subsection</dt>
                    <dd>
                        <?php if(empty($e->subsection_name)){ echo $e->dept_name; }?>
                    </dd>
                  </span>
                  <span class="col-sm-6">
                    <dt>Classification</dt>
                    <dd>
                      <?php echo $e->classification;?>
                    </dd>
                    <dt>Position</dt>
                    <dd>  
                       <?php echo $e->position_name;?>
                    </dd>
                    <dt>Location</dt>
                    <dd>
                       <?php echo $e->location_name;?>
                    </dd>
                  </span>
              </div>
        </div>
        </div>
  
        
         <?php foreach($details as $d){
          if($d->type=='new')
          { $job_details = $this->job_vacancy_request_approval_model->get_job_request_details($d->doc_no); }
          else{ $job_details = $this->job_vacancy_request_approval_model->get_jobdetails_additional($d->doc_no); }

          foreach($job_details as $jb){
        ?>

       

        <div class="panel panel-default">
          <div class="panel-heading">
          <strong><a><?php echo $d->job_title;?> (<?php if($jb->type=='new'){ echo "New Job Vacancy"; } else{  echo "Additional Job Vacancy"; }?>)</a></strong>
          </div>
          <div class="panel-body">
              
          <?php if($d->type=='additional'){?>
              <span class="col-sm-6">
                <dt>Industry</dt>
                <dd>
                    <?php $industry = $this->recruitment_job_vacancy_request_list_model->get_industry($jb->job_specialization); 
                    if(empty($industry)){ echo "No data found"; } else{ echo $industry; }
                    ?>
                </dd>
                <dt>Salary</dt>
                <dd>  
                    <?php echo number_format($jb->salary);?>
                </dd>
                <dd>
                  <?php 
                  $month=substr($jb->hiring_start, 5,2);
                  $day=substr($jb->hiring_start, 8,2);
                  $year=substr($jb->hiring_start, 0,4);
                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                  ?>
                </dd>
                <dt>Years of Experience</dt>
                <dd>
                  <?php echo $jb->yrs_of_experience;?>
                </dd>
                <dt>Job Qualification</dt>
                <dd>
                  <?php echo $jb->job_qualification;?>
                </dd>
              </span>

              <span class="col-sm-6">
                <dt>Vacancy Slot</dt>
                <dd>  
                  <?php echo $jb->job_vacancy;?>
                </dd>
                <dt>Location</dt>
                <dd>
                  <?php $location = $this->recruitment_job_vacancy_request_list_model->get_location($jb->loc_province,$jb->loc_city);
                    if(!empty($location)){ echo $location; }
                  ?>
                </dd>
                 <dt>Hiring End</dt>
                <dd>
                  <?php 
                    $month=substr($jb->hiring_end, 5,2);
                    $day=substr($jb->hiring_end, 8,2);
                    $year=substr($jb->hiring_end, 0,4);
                    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                  ?>
                </dd>
                <dt>Job Description</dt>
                <dd>
                  <?php echo $jb->job_description;?>
                </dd>
              </span>
          <?php } else{ ?>    

            <span class="dl-horizontal col-sm-12">
                <dt>Position</dt>
                <dd>
                    <select class="form-control" name="position" id="position" required>
                      <?php 
                      if(empty($position))
                      {
                        echo "<option value=''>No Job Position Found.</option>";
                      }
                      else
                      {
                        echo "<option value='' selected disabled>Select Job Position</option>";
                          foreach($position as $ps)
                          {?>
                            <option value='<?php echo $ps->position_id;?>' <?php if($jb->position_id==$ps->position_id){ echo "selected"; }?>><?php echo $ps->position_name;?></option>";
                          <?php }
                      }
                      ?>
                    </select>
                </dd>
                <br>
                <dt>Industry</dt>
                <dd>
                    <select class="form-control" name="industry">
                       <?php
                        
                        foreach ($job_specList as $job_specs){
                          if($jb->job_specialization==$job_specs->param_id)
                          {
                            $d='selected';
                          } else{ $d=''; }
                        echo "<option value='".$job_specs->param_id."' ".$d.">".$job_specs->cValue."</option>";
                        }
                      ?>
                    </select>
                </dd>
                <br>
                <dt>Job Description</dt>
                <dd>
                    <textarea rows="4" class="form-control" name="job_description" id="job_description" placeholder="Job Description" required> <?php echo $jb->job_description;?></textarea>
                </dd>
                <br>
                <dt>Qualification</dt>
                <dd>
                    <textarea rows="4" class="form-control" name="job_qualification" id="job_qualification" placeholder="Qualification" required><?php echo $jb->job_qualification;?></textarea>
                </dd>
                <br>

                <dt>Years of Experience</dt>
                <dd><input type="text" class="form-control" name="yrs_experience" id="yrs_experience" placeholder="Required Years of Experience" required value="<?php echo $jb->yrs_of_experience;?>"></dd>
                <br>

                <dt></dt>
                <dd>
                    <?php if(!empty($jb->with_target_applicant)){  $cn='checked'; } else{ $cn=''; }?>
                    With target number of hired applicant on a specific date <br><input type="radio" name="a_d" id="targetyes" onclick="with_target(1);" <?php echo $cn;?>> Yes &nbsp;&nbsp;&nbsp; <input type="radio" name="a_d" onclick="with_target(0);" id="targetno" <?php if($cn==''){ echo "checked"; } ?>> No 
                    <input type="hidden" id="target_val" value="0">
                </dd>
                <br>

                <dt>Target Applicants</dt>
                <dd>
                  <?php if(!empty($jb->with_target_applicant)){  $cd=''; $cdd=$jb->with_target_applicant; } 
                      else{ $cd='disabled'; $cdd=''; }?>
                    <input type="text" class="form-control" name="target_applicant" id="target_applicant" placeholder="With target number of hired applicants" value="<?php echo $cdd;?>" <?php echo $cd;?>>
                </dd>
                <br>
            
                <dt>Target Date</dt>
                <dd>
                     <?php if(!empty($jb->with_target_applicant)){  $cdd=''; $cddd=$jb->with_target_date; } 
                      else{ $cdd='disabled'; $cddd=''; }?>

                    <input type="date" class="form-control" name="target_date" id="target_date" value="<?php echo $cddd;?>" <?php echo $cdd;?>>
                </dd>
                <br>
                    <center><n id="with" style="display:none;" class="text-danger">Make sure to fill up the target applicants and target date <br><br></n></center>

                <dt>Salary</dt>
                <dd><input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" required value="<?php echo $jb->salary;?>"></dd>
                <br>
                <dt>Vacancy Slot</dt>
                <dd><input type="number" class="form-control" name="job_vacancy" id="job_vacancy" placeholder="Vacancy (slot)" value="<?php echo $jb->job_vacancy;?>" required></dd>
                <br>
                <dt>Hiring Start</dt>
                <dd><input type="date" class="form-control" name="hiring_start" id="hiring_start" value="<?php echo $jb->hiring_start;?>" required></dd>
                <br>
                <dt>Hiring Closed</dt>
                <dd><input type="date" class="form-control" name="hiring_end" id="hiring_end" value="<?php echo $jb->hiring_end;?>" required></dd>
                <br>
                <dt>Location</dt>
                <dd>
                    <select class="form-control" id="province" name="province" required onchange="get_city(this.value);">
                        <option>Select Province</option>
                        <?php foreach($provinceList as $province){?>
                          <option value="<?php echo $province->id;?>" <?php if($province->id==$jb->loc_province){ echo "selected"; }?>><?php echo $province->name;?></option>
                        <?php } ?>
                    </select> 
                    <select class="form-control" style="margin-top: 5px;" id="city" name="city" required>
                       <?php 
                            $city =  $this->final_recruitments_model->get_city($jb->loc_province); 
                            if(empty($city)){ echo "<option>No cities found.</option>"; }
                            else
                            {
                              foreach($city as $c)
                              { if($c->id==$loc_city){ $d='selected'; } else{ $d=''; }
                                echo "<option value='".$c->id."' ".$d.">".$c->city_name."</option>";
                              }
                            }
                        ?>
                    </select>
                </dd>
            </span>

          <?php  } ?>
          </div>
        </div>

        <?php if(!empty($jb->note)){?>
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong><a>Requested Job Vacancy</a></strong>
            </div>
            <div class="panel-body">
                <span class="col-sm-12">
                   <?php if($jb->type=='additional'){?>
                    <dt>Requested Job Vacancy</dt>
                    <dd>
                       <input type="text" class="form-control" name="additionaljob_vacancy" id="additionaljob_vacancy" value="<?php echo $jb->request_vacancy;?>" style='width:50%;' required>
                    </dd>
                  <?php } ?>
                    <dt>Note</dt>
                    <dd>
                      <?php echo $jb->note;?>
                    </dd>
                </span>
            </div>
          </div>
        <?php } ?>


      <div class="modal-footer">
        <button type="submit" class="btn btn-success">SUBMIT JOB VACANCY REQUEST</button>
        <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
      </div>

   </div>
  </div>

<?php  }} } }?>

</form>



<script type="text/javascript">
   function with_target(val)
  {
    document.getElementById('target_val').value=val;

    if(val==1)
    {
      document.getElementById('target_date').disabled=false;
      document.getElementById('target_applicant').disabled=false;
      $('#with').show();
    }
    else
    {
      document.getElementById('target_date').disabled=true;
      document.getElementById('target_applicant').disabled=true;
      $('#with').hide();
    }
  }
</script>