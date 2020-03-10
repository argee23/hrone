 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Add New JOb Position</center></h4>
      </div>
  
      <div class="modal-body">
       <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_plantilla/save_position/<?php echo $company_id."/".$employer_type;?>">


          <div class="panel panel-default">
            <div class="panel-heading">
              <strong><a class="text-danger">Position Details <i>(All fields are )</i></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-12">

                  <div class="col-md-6">
                        <dt>Department</dt>
                        <dd>
                            <select class="form-control" name="department" id="adepartment" onchange="check_plantilla_position('<?php echo $company_id;?>','<?php echo $employer_type;?>');" required>
                            <?php if(empty($department)){ echo "<option value=''>No Department Found.</option>"; } else{?>
                            <option value="All">All</option>   
                            <?php foreach($department as $d){?>
                                <option value="<?php echo $d->department_id;?>"><?php echo $d->dept_name;?></option>
                            <?php } }?> 
                            </select>
                        </dd>
                        <br>

                        <dt>Plantilla</dt>
                        <dd>
                            <select class="form-control" name="plantilla" id="aplantilla" onchange="get_plantilla_dates(this.value);" required>
                            <?php if(empty($plantilla)){echo "<option value=''>No Plantilla Found.</option>";  } 
                            else { 
                              echo '<option value="" disabled selected>Select Plantilla</option>';
                              foreach($plantilla as $p){?>
                                <option value="<?php echo $p->id;?>"><?php echo $p->plantilla_no;?></option>
                            <?php } } ?> 
                            </select>
                        </dd>
                        <br>
                  </div>

                  <div class="col-md-6">
                        <dt>Location</dt>
                        <dd>
                            <select class="form-control" name="location" id="alocation" onchange="check_plantilla_position('<?php echo $company_id;?>','<?php echo $employer_type;?>');" required>
                             
                            <?php if(empty($location)){ echo "<option value=''>No Location Found.</option>"; } 
                            else{
                              echo '<option value="All">All</option>';
                              foreach($location as $l){?>
                                  <option value="<?php echo $l->location_id;?>"><?php echo $l->location_name;?></option>
                              }
                            }
                            <?php } }?> 
                            </select>
                        </dd>
                        <br>

                        <dt>Position</dt>
                        <dd>
                            <select class="form-control" name="position" id="apositionn" onchange="check_plantilla_position('<?php echo $company_id;?>','<?php echo $employer_type;?>');" required>
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
                  </div>
              </span>
              
              <span class="dl-horizontal col-sm-12" id="positiondetails">

              </span>

              <div id="pantilla_dates"></div>

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
