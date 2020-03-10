 <div class="modal-content">
      <div class="modal-header" >
      <button type="button" class="close" onclick="window.location.reload()">&times;</button>
          <h4 class="modal-title text-success"><b>Salary Information Approval</center></b></h4>

      </div>
      <div class="modal-body">
             <div class="well well-sm bg-olive">
                            <!-- Left-aligned -->
        <div class="media">
           <div class="media-left media-middle">
            <span>
              <img src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $file->picture;?>" class="media-object" style="width:150px">
            </span>
           
          </div>
          <div class="media-body">
           <h4 class="media-heading text-black"><strong><?php echo $file->first_name." ".$file->middle_name." ".$file->last_name;?></strong></h4>

            <span class="col-sm-6">
               <?php  if($file->division_id==''){}
                else{?>
                  <dt>Division</dt>
                  <dd>
                    <?php 
                    $subsec=$this->notification_approver_model->get_emp_data_emp('division','division_id','division_name',$file->division_id);
                    if(!empty($subsec)){ echo $subsec; }
                    ?>
                  </dd>
                  
                <?php } ?>
              <dt>Department</dt>
              <dd>
                  <?php 
                  $dept=$this->transaction_employees_model->get_emp_dept($file->department);
                  foreach($dept as $dpt){
                    echo $dpt->dept_name;
                  }
                  ?>
              </dd>
              <dt>Section</dt>
              <dd>
                   <?php 
                    $sec=$this->transaction_employees_model->get_emp_sect($file->section);
                    foreach($sec as $sect){
                      echo $sect->section_name;
                    }
                    ?>
              </dd>
              <?php  if($file->subsection==''){}
                else{?>
                  <dt>Subsection</dt>
                  <dd>
                    <?php 
                    $subsec=$this->notification_approver_model->get_emp_data_emp('subsection','subsection_id','subsection_name',$file->subsection);
                    if(!empty($subsec)){ echo $subsec; }
                    ?>
                  </dd>
                  
                <?php } ?>
              </span>
            <span class="col-sm-6">
              <dt>Classification</dt>
              <dd>
                   <?php 
                    $clas=$this->transaction_employees_model->get_emp_clas($file->classification);
                    foreach($clas as $class){
                      echo $class->classification;
                    }
                    ?>
              </dd>
              <dt>Position</dt>
              <dd>  
                  <?php 
                      $pos=$file->position;
                      $pos=$this->transaction_employees_model->get_emp_pos($pos);
                      foreach($pos as $position){
                        echo $position->position_name;
                  }?>
              </dd>
              <dt>Location</dt>
              <dd>
                  <?php 
                    $loc=$this->notification_approver_model->get_emp_data_emp('location','location_id','location_name',$file->location);
                    if(!empty($loc)){ echo $loc; }
                    ?>
              </dd>
            </span>

          </div>
        </div>
        </div>  

         <form class="form-horizontal" method="post" action="<?php echo base_url()?>employee_portal/salary_approver/respond_salary_approver/<?php echo $approver_details[0]."/".$approver_details[2]."/".$approver_details[3];?>">
         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a>Salary Information Details</a></strong>
        </div>
        <div class="panel-body">
         <?php foreach($salary_details as $sd){?>

          <span class="dl-horizontal col-sm-6">
              <dt>EFFECTIVED DATE:</dt>
              <dd> 
                  <?php  $month=substr($sd->date_effective, 5,2);
                    $day=substr($sd->date_effective, 8,2);
                    $year=substr($sd->date_effective, 0,4);

                    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;?>
              </dd>    
              <dt>SALARY RATE:</dt>  
              <dd>
               <?php 
                  $salary_rate = $this->salary_approver_model->get_salary_rate($sd->salary_rate);
                  if(empty($salary_rate)){} else{ echo $salary_rate; }
                ?>
              </dd>  
          </span>

          <span class="dl-horizontal col-sm-6">
              <dt>SALARY AMOUNT:</dt>
              <dd><?php echo $sd->salary_amount;?></dd>    
              <dt>NO. OF HOURS:</dt>  
              <dd><?php echo $sd->no_of_hours;?> hour/s</dd>  
          </span>

           <span class="dl-horizontal col-sm-6">
              <dt>NO. OF DAYS MONTHLY:</dt>
              <dd><?php echo $sd->no_of_days_monthly;?> days</dd>
              <dt>FIXED SALARY AMOUNT:</dt>
              <dd><?php if($sd->is_salary_fixed==1){ echo "yes"; } else{ echo "no"; }?></dd>      
              
          </span>

           <span class="dl-horizontal col-sm-6">
              <dt>SSS:</dt>  
              <dd><?php if($sd->sss==1){ echo "yes"; } else{ echo "no"; }?></dd>  
              <dt>PAGIBIG:</dt>  
              <dd><?php if($sd->pagibig==1){ echo "yes"; } else{ echo "no"; }?></dd>  
          </span>


           <span class="dl-horizontal col-sm-6">
              <dt>NO. OF DAYS YEARLY:</dt>
              <dd><?php echo $sd->no_of_days_yearly;?> day/s</dd>   
              <dt>REASON:</dt>
              <dd><?php echo $sd->reason;?></dd>     
             
          </span>


           <span class="dl-horizontal col-sm-6">
              <dt>WITHHOLDING TAX:</dt>  
              <dd><?php if($sd->withholding_tax==1){ echo "yes"; } else{ echo "no"; }?></dd>     
              <dt>PHILHEALTH:</dt>  
              <dd><?php if($sd->philhealth==1){ echo "yes"; } else{ echo "no"; }?></dd>  
          </span>

         <?php } ?>
        </div>
        </div>


         <div class="panel panel-success">
        <div class="panel-heading">Response</div>
        <div class="panel-body">
        <div class="col-sm-6">
        
        <div class="radio">
            <label style="font-size: 1.5em">
                <input type="radio" name="status" value="approved" onclick="set_status(this.value)">
                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                Approve
            </label>
        </div>
        <div class="radio">
            <label style="font-size: 1.5em">
                <input type="radio" name="status" value="cancelled" onclick="set_status(this.value)">
                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                Cancel
            </label>
        </div>        
        <div class="radio">
            <label style="font-size: 1.5em">
                <input type="radio" name="status" value="rejected" onclick="set_status(this.value)">
                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                Reject
            </label>
        </div>

        <input type="hidden" name="approver_status" id="approver_status">
        </div>
        <div class="col-sm-6">
         <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="2" name="comment" id="comment" onkeyup="check_comment(this.value);"></textarea>
            <center><p id="status_comment" style="display: none;" class="text-danger"><i>Comment is required</i></p></center>
          </div> 
          <button type="submit" class="btn btn-success btn-block" disabled id="submit">Submit Response</button>

        </div>
        </div>
        </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
      </div>
    </div>

