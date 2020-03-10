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
                            <!-- Left-aligned -->
        <div class="media">
           <div class="media-left media-middle">
            <span>
              <img src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $e->picture;?>" class="media-object" style="width:150px">
            </span>
           
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

                <dt>Hiring Start</dt>
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


          </div>
        </div>

       
        <?php if(!empty($jb->note)){?>
        <div class="panel panel-default">
          <div class="panel-heading">
          <strong><a>Other Details</a></strong>
          </div>
          <div class="panel-body">
              
              <span class="col-sm-6">
                <dt>Note</dt>
                <dd>
                    <?php echo $jb->note;?>
                </dd>
              </span>
          </div>
        </div>
        <?php } ?>

        <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_job_request_approval/respond_recruitment">
        
        <input type="hidden" name="doc_no" value="<?php echo $doc_no;?>">
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

<?php } } } }?>