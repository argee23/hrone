 <div class="modal-content">
      <div class="modal-header well well-sm bg-olive" >
      <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-success" style="color: white;"><center><b><?php echo $job_details->company_name;?></center></b></h4>
        <h5><center><?php echo $job_details->job_title;?></center> </h5>
      </div>
      <div class="modal-body" id='mila'>

          <div class="col-md-12">
            <div class="panel panel-danger">
              <div class="panel-heading">
                 <strong><a class="text-danger"></i>Job Application Status : <?php if(!empty($job_application_status_details->status_title)){ echo $job_application_status_details->status_title; }?></a></strong>
              </div>
              <div class="panel-body">

                <?php 
                 $details = $this->final_recruitments_model->get_application_status_details($job_application_status_details->ApplicationStatus,$job_application_status_details->app_id);
                
                if($status==2)
                {
                   
                ?>

                          <span class="dl-horizontal col-sm-12">

                              <div class="col-md-12">
                                  <div class="col-md-4"><label>Date Updated</label></div>
                                  <div class="col-md-8">
                                     <n><?php if(!empty($details)){ echo $details->date_created; }?></n>
                                  </div>
                              </div>

                          </span>
                        

                <?php }
                else if($status==3)
                {?>

                   
                          <span class="dl-horizontal col-sm-12">

                              <div class="col-md-12">
                                  <div class="col-md-4"><label>Date Hired</label></div>
                                  <div class="col-md-8">
                                      <?php if(!empty($job_application_status_details->date_hired)){ echo $job_application_status_details->date_hired; }?>
                                  </div>
                              </div>
                              <div class="col-md-12">
                                  <div class="col-md-4"><label>Employer Message</label></div>
                                  <div class="col-md-8">
                                      <?php if(!empty($job_application_status_details->hired_message)){ echo $job_application_status_details->hired_message; }?>
                                  </div>
                              </div>
                          </span>
                        


                <?php }
                else if($status==4)
                {?>

                         <span class="dl-horizontal col-sm-12"> 

                              <div class="col-md-12">
                                  <div class="col-md-4"><label>Date Blocked</label></div>
                                  <div class="col-md-8">
                                     <h1>Wala pa</h1>
                                  </div>
                              </div>
                              <div class="col-md-12">
                                  <div class="col-md-4"><label>Reason</label></div>
                                  <div class="col-md-8">
                                      <?php if(!empty($job_application_status_details->blocked_reason)){ echo $job_application_status_details->blocked_reason; }?>
                                  </div>
                              </div>
                          </span>


                <?php }
                else{ 
                ?>


                          <span class="dl-horizontal col-sm-12">

                              <div class="col-md-12">
                                  <div class="col-md-4"><label>Date Updated</label></div>
                                  <div class="col-md-8">
                                     <n><?php if(!empty($details)){ echo $details->date_created; }?></n>
                                  </div>
                              </div>

                          </span>


                <?php } ?>
            </div>
          </div>
         </div>
      </div>

      <div class="modal-footer">
      </div>
        
  </div>
