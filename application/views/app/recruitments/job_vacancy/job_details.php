 <div class="modal-content">
      <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Web Developer</center></h4>
      </div>

      <div class="modal-body">
       
        <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger">Position Details <i>(All fields are required)</i></a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-10">
          <?php foreach($jobs as $j){?>
            <dt>Position</dt>
            <dd>
              <?php 
                   echo $j->job_title;
              ?>
            </dd>
            <br>
            <dt>Industry</dt>
            <dd>
                <?php $job_specs=$this->recruitment_model->getjob_specs($j->job_specialization);
                    echo  $thejob_specizalization=$job_specs->cValue;?>
            </dd>
            <br>
            <dt>Job Description</dt>
            <dd>
                <?php echo $j->job_description;?>
            </dd>
            <br>
            <dt>Qualification</dt>
            <dd>
                <?php echo $j->job_qualification;?>
            </dd>
            <br>

            <dt>Years of Experience</dt>
            <dd><?php echo $j->yrs_of_experience;?></dd>
            <br>


            <dt>Salary</dt>
            <dd><?php echo $j->salary;?></dd>
            <br>
            <dt>Vacancy Slot</dt>
            <dd><?php echo $j->job_vacancy;?></dd>
            <br>
            <dt>Hiring Start</dt>
            <dd><?php echo $j->hiring_start;?></dd>
            <br>
            <dt>Hiring Closed</dt>
            <dd><?php echo $j->hiring_end;?></dd>
            <br>

            <?php if(!empty($j->with_target_date) AND !empty($j->with_target_applicant))
            {?>

            <dt>Target Hired Applicant</dt>
            <dd><?php echo $j->with_target_applicant;?></dd>
            <br>

             <dt>Target Date</dt>
            <dd><?php echo $j->with_target_date;?></dd>
            <br>


            <?php } ?>
            <dt>Address</dt>
            <dd>
              <?php 
                  $province = $this->recruitments_model->get_province_city('provinces','id','name',$j->loc_province);
                  $city = $this->recruitments_model->get_province_city('cities','id','city_name',$j->loc_city);

                  echo $province.",".$city;
              ?>
            </dd>
            <?php }?>
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
            <dt><input type="checkbox" id="req<?php echo $i;?>" name="req_id[]"  value="<?php echo $r->id;?>" checked disabled></dt>
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
                <dt><input type="checkbox" name="ques_id[]" id="req<?php echo $i;?>" value="<?php echo $q->id;?>" checked disabled></dt>
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
                <dt><input  type="checkbox" name="hypoQues_id[]" id="req<?php echo $i;?>" value="<?php echo $h->id;?>" checked disabled></dt>
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
                <dt><input type="checkbox" name="mcQues_id[]" id="req<?php echo $i;?>" value="<?php echo $m->id;?>" checked disabled></dt>
                <dd><?php echo $m->question;?></dd>
               
               <?php $i++;  }  echo "<input type='hidden' id='multiple_choice_count' value='".$i."'>"; }?>
                

          </span>
        </div>
        </div>

        </div>


        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
      </div>
      </div>


     

</div>
  
