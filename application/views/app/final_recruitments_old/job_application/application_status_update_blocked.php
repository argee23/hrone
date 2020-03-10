
<?php $recheck_added = $this->recruitments_model->check_last_added_interview_process($app_id);;?> 
 <div class="modal-content">
        

              <div>
                <div class="box-body">
                  <div class="col-lg-12">      
                       <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-aqua-active">
                          <h4 style="font-family: serif;"><n><center><b><?php echo $app_info->fullname;?></b></center></n></h4> 
                          <h4 style="font-family: serif;"><n><center><?php echo $app_info->job_title;?></center></n></h4> 
                            <br>
                        </div>
                          <div class="widget-user-image pull" style="padding-top: 12px;">
                            <img class="img-circle" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $app_info->picture;?>" alt="User Avatar">
                          </div>
                          <div class="box-footer"></div>
                        </div>
                  </div>
                </div>
              </div>
           <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitments/save_blocked_applicant_job_application/<?php echo $app_id."/".$employer_type;?>">

              <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <span class="dl-horizontal col-sm-12"> 
                    <h4 class="text-danger">Reason for Blocking the Applicant Job Application </h4>
                    <input class="form-control" name="reason"   value="<?php if(!empty($reason)){ echo $reason->blocked_reason; }?>" required >
                    <?php if(empty($reason->date_blocked)){ }else{?>
                     <h4 class="text-danger">Date Blocked</h4>
                     
                      <input type="datetime" class="form-control" name="reasondate"   value="<?php echo $reason->date_blocked;?>" required >
                    <?php } ?>
                    

                  </span>
                </div>
              </div>
              </div>

        
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">SAVE</button>
            <button type="button" class="btn btn-default" onclick="location.reload();">Close</button>
          </div> 

          </form>
      </div>
    </div>
