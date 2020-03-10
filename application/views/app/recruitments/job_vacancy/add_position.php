 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Add New JOb Position</center></h4>
      </div>
  
      <div class="modal-body">
       <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitments/save_position/<?php echo $company_id."/".$employer_type;?>">

         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger">Position Details <i>(All fields are )</i></a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-10">

            <dt>Position</dt>
            <dd>
                <select class="form-control" name="position" id="position" >
                  <?php 
                  if(empty($position))
                  {
                    echo "<option value=''>No Job Position Found.</option>";
                  }
                  else
                  {
                      echo "<option value='' selected disabled>Select Job Position</option>";
                      foreach($position as $ps)
                      {
                        echo "<option value='".$ps->position_id."'>".$ps->position_name."</option>";
                      }
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
                    echo "<option value='".$job_specs->param_id."'>".$job_specs->cValue."</option>";
                    }
                  ?>
                </select>
            </dd>
            <br>
            <dt>Job Description</dt>
            <dd>
                <textarea rows="4" class="form-control" name="job_description" id="job_description" placeholder="Job Description" ></textarea>
            </dd>
            <br>
            <dt>Qualification</dt>
            <dd>
                <textarea rows="4" class="form-control" name="job_qualification" id="job_qualification" placeholder="Qualification" ></textarea>
            </dd>
            <br>
            <dt>Years of Experience</dt>
            <dd>
                <input class="form-control" name="yrs_experience" id="yrs_experience" placeholder=" Years of Experience" >
            </dd>
            <br>

            <dt></dt>
            <dd>
                With target number of hired applicant on a specific date <br><input type="radio" name="a_d" id="targetyes" onclick="with_target(1);"> Yes &nbsp;&nbsp;&nbsp; <input type="radio" name="a_d" onclick="with_target(0);" id="targetno" checked> No 
                <input type="hidden" id="target_val" value="0">
            </dd>
            <br>

            <dt>Target Applicants</dt>
            <dd>
                <input type="text" class="form-control" name="target_applicant" id="target_applicant" placeholder="With target number of hired applicants" disabled>
            </dd>
            <br>
            
            <dt>Target Date</dt>
            <dd>
                <input type="date" class="form-control" name="target_date" id="target_date" disabled>
            </dd>
            <br>
                <center><n id="with" style="display:none;" class="text-danger">Make sure to fill up the target applicants and target date <br><br></n></center>

            <dt>Salary</dt>
            <dd><input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" ></dd>
            <br>
            <dt>Vacancy Slot</dt>
            <dd><input type="number" class="form-control" name="job_vacancy" id="job_vacancy" placeholder="Vacancy (slot)" ></dd>
            <br>
            <dt>Hiring Start</dt>
            <dd><input type="date" class="form-control" name="hiring_start" id="hiring_start" ></dd>
            <br>
            <dt>Hiring Closed</dt>
            <dd><input type="date" class="form-control" name="hiring_end" id="hiring_end" ></dd><br>
            <dt>Location</dt>
            <dd>
                <select class="form-control" id="province" name="province"  onchange="get_city(this.value);">
                    <option>Select Province</option>
                    <?php foreach($provinceList as $province){?>
                      <option value="<?php echo $province->id;?>"><?php echo $province->name;?></option>
                    <?php } ?>
                </select> 
                <select class="form-control" style="margin-top: 5px;" id="city" name="city" >
                    <option>Select City</option>>
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
            $i=0; foreach($requirements as $r){ ?>
            <dt><input type="checkbox" id="req<?php echo $i;?>" name="req_id[]"  value="<?php echo $r->id;?>" checked></dt>
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
                $i=0; foreach($qualifying as $q){ ?>
                <dt><input type="checkbox" name="ques_id[]" id="req<?php echo $i;?>" value="<?php echo $q->id;?>" checked></dt>
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
                $i=0; foreach($hypothetical as $h){ ?>
                <dt><input  type="checkbox" name="hypoQues_id[]" id="req<?php echo $i;?>" value="<?php echo $h->id;?>" checked></dt>
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
                $i=0; foreach($multiple_choice as $m){ ?>
                <dt><input type="checkbox" name="mcQues_id[]" id="req<?php echo $i;?>" value="<?php echo $m->id;?>" checked></dt>
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
