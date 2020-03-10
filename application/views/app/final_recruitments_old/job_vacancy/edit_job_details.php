<?php foreach($jobs as $j){?>
<div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Update "<?php echo $j->job_title;?>" Position</center></h4>
      </div>
    
      <div class="modal-body">
       <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/final_recruitments/update_job_position/<?php echo $j->job_id."/".$company_id."/".$employer_type;?>">
         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger">Position Details <i>(All fields are required)</i></a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-10">

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
                        <option value='<?php echo $ps->position_id;?>' <?php if($j->position_id==$ps->position_id){ echo "selected"; }?>><?php echo $ps->position_name;?></option>";
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
                      if($j->job_specialization==$job_specs->param_id)
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
                <textarea rows="4" class="form-control" name="job_description" id="job_description" placeholder="Job Description" required> <?php echo $j->job_description;?></textarea>
            </dd>
            <br>
            <dt>Qualification</dt>
            <dd>
                <textarea rows="4" class="form-control" name="job_qualification" id="job_qualification" placeholder="Qualification" required><?php echo $j->job_qualification;?></textarea>
            </dd>
            <br>

            <dt>Years of Experience</dt>
            <dd><input type="text" class="form-control" name="yrs_experience" id="yrs_experience" placeholder="Required Years of Experience" required value="<?php echo $j->yrs_of_experience;?>"></dd>
            <br>

             <dt></dt>
            <dd>
                <?php if(!empty($j->with_target_applicant)){  $cn='checked'; } else{ $cn=''; }?>
                With target number of hired applicant on a specific date <br><input type="radio" name="a_d" id="targetyes" onclick="with_target(1);" <?php echo $cn;?>> Yes &nbsp;&nbsp;&nbsp; <input type="radio" name="a_d" onclick="with_target(0);" id="targetno" <?php if($cn==''){ echo "checked"; } ?>> No 
                <input type="hidden" id="target_val" value="0">
            </dd>
            <br>

            <dt>Target Applicants</dt>
            <dd>
              <?php if(!empty($j->with_target_applicant)){  $cd=''; $cdd=$j->with_target_applicant; } 
                  else{ $cd='disabled'; $cdd=''; }?>
                <input type="text" class="form-control" name="target_applicant" id="target_applicant" placeholder="With target number of hired applicants" value="<?php echo $cdd;?>" <?php echo $cd;?>>
            </dd>
            <br>
            
            <dt>Target Date</dt>
            <dd>
                 <?php if(!empty($j->with_target_applicant)){  $cdd=''; $cddd=$j->with_target_date; } 
                  else{ $cdd='disabled'; $cddd=''; }?>

                <input type="date" class="form-control" name="target_date" id="target_date" value="<?php echo $cddd;?>" <?php echo $cdd;?>>
            </dd>
            <br>
                <center><n id="with" style="display:none;" class="text-danger">Make sure to fill up the target applicants and target date <br><br></n></center>

            <dt>Salary</dt>
            <dd><input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" required value="<?php echo $j->salary;?>"></dd>
            <br>
            <dt>Vacancy Slot</dt>
            <dd><input type="number" class="form-control" name="job_vacancy" id="job_vacancy" placeholder="Vacancy (slot)" value="<?php echo $j->job_vacancy;?>" required></dd>
            <br>
            <dt>Hiring Start</dt>
            <dd><input type="date" class="form-control" name="hiring_start" id="hiring_start" value="<?php echo $j->hiring_start;?>" required></dd>
            <br>
            <dt>Hiring Closed</dt>
            <dd><input type="date" class="form-control" name="hiring_end" id="hiring_end" value="<?php echo $j->hiring_end;?>" required></dd>
            <br>
            <dt>Location</dt>
            <dd>
                <select class="form-control" id="province" name="province" required onchange="get_city(this.value);">
                    <option>Select Province</option>
                    <?php foreach($provinceList as $province){?>
                      <option value="<?php echo $province->id;?>" <?php if($province->id==$j->loc_province){ echo "selected"; }?>><?php echo $province->name;?></option>
                    <?php } ?>
                </select> 
                <select class="form-control" style="margin-top: 5px;" id="city" name="city" required>
                   <?php 
                        $city =  $this->final_recruitments_model->get_city($j->loc_province); 
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
        </div>
        </div>

          <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger">Requirements</a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-10">
          <?php if(count($requirements)==0){ echo "<n class='text-danger'>No Requirement/s found.</n>"; }
          else
          {
            $i=0; foreach($requirements as $r){ 
              $check_exist = $this->final_recruitments_model->check_if_exist($j->job_id,'req_per_jobs','req_id',$r->id);

              if($check_exist==0)
              {
                $c='';
              }
              else
              {
                $c='checked';
              }
              ?>
            <dt><input type="checkbox" id="req<?php echo $i;?>" name="req_id[]"  value="<?php echo $r->id;?>" <?php echo $c;?>></dt>
            <dd><?php echo $r->title;?></dd>
           
           <?php $i++;  }  echo "<input type='hidden' id='req_count' value='".$i."'>"; }?>
            

          </span>
        </div>
        </div>

         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger">Qualifying Questions</a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-10">

             <?php if(count($qualifying)==0){ echo "<n class='text-danger'>No Qualifying Question/s found.</n>";}
              else
              {
                $i=0; foreach($qualifying as $q){
                   $check_exist = $this->recruitments_model->check_if_exist($j->job_id,'qualifying_question_job','questionid',$q->id);
            
                    if($check_exist==0)
                    {
                      $c='';
                    }
                    else
                    {
                      $c='checked';
                    }
                ?>
                <dt><input type="checkbox" name="ques_id[]" id="req<?php echo $i;?>" value="<?php echo $q->id;?>" <?php echo $c;?>></dt>
                <dd><?php echo $q->question;?></dd>
               
               <?php $i++;  }  echo "<input type='hidden' id='qualifying_count' value='".$i."'>"; }?>
                

          </span>
        </div>
        </div>


         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger">Hypothetical Question(s)</a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-10">

          
             <?php if(count($hypothetical)==0){ echo "<n class='text-danger'>No Hypothetical Question/s found.</n>";}
              else
              {
                $i=0; foreach($hypothetical as $h){ 
                    $check_exist = $this->recruitments_model->check_if_exist($j->job_id,'preliminary_questions_job','pre_ques_id',$h->id);
            
                    if($check_exist==0)
                    {
                      $c='';
                    }
                    else
                    {
                      $c='checked';
                    }
                  ?>
                <dt><input  type="checkbox" name="hypoQues_id[]" id="req<?php echo $i;?>" value="<?php echo $h->id;?>" <?php echo $c;?>></dt>
                <dd><?php echo $h->question;?></dd>
               
               <?php $i++;  }  echo "<input type='hidden' id='hypothetical_count' value='".$i."'>"; }?>
                

          </span>
        </div>
        </div>

         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger">Multiple Choice Question(s)</a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-10">

            <?php if(count($multiple_choice)==0){ echo "<n class='text-danger'>No Multiple Choices Question/s found.</n>";}
              else
              {
                $i=0; foreach($multiple_choice as $m){ 
                  $check_exist = $this->recruitments_model->check_if_exist($j->job_id,'preliminary_questions_job','pre_ques_id',$h->id);
            
                    if($check_exist==0)
                    {
                      $c='';
                    }
                    else
                    {
                      $c='checked';
                    }
                    ?>
                <dt><input type="checkbox" name="mcQues_id[]" id="req<?php echo $i;?>" value="<?php echo $m->id;?>" <?php echo $c;?>></dt>
                <dd><?php echo $m->question;?></dd>
               
               <?php $i++;  }  echo "<input type='hidden' id='multiple_choice_count' value='".$i."'>"; }?>
                

          </span>
        </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="submit">Submit</button>
            <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
      </div>
       </form>
      </div>
</div>
  
<?php } ?>


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