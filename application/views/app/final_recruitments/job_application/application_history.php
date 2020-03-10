
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
              <h4><center>Job Application Status Details</center></h4>
             
              <?php foreach($status as $s){
                $details = $this->final_recruitments_model->get_application_status_details($s->id,$app_id);
                
              ?>
              <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                   <strong><n class="text-danger"><b><?php echo $s->status_title;?></b></n></strong>
                </div>
                <div class="panel-body">
                  <span class="dl-horizontal col-sm-12"> 

                      <?php if($s->id==1){?>

                               <table class="table table-hover">
                                  <thead>
                                  </thead>
                                  <tbody>
                                     <tr class="danger" style="text-align: center;">
                                        <td>Numbering</td>
                                        <td>Title</td>
                                        <td>Interview Date</td>
                                        <td>Interview Time</td>
                                        <td>Interviewer</td>
                                        <td>Status</td>
                                        <td>Result</td>
                                    </tr>

                                    <?php foreach($interview_status as $is){
                                      $check_interviewprocessstatus = $this->recruitments_model->check_interviewprocessstatus($is->interview_id,$is->numbering,$app_id);
                                    ?>
                                      <tr style="text-align: center;">
                                          <td><?php echo $is->numbering;?></td>
                                          <td><?php echo $is->title;?></td>
                                          <?php if($check_interviewprocessstatus=='not_exist'){ ?>
                                          <td>-</td>
                                          <td>-</td>
                                          <?php  } else { 
                                            $latest_dates = $this->recruitments_model->lates_interviewprocess_details($is->interview_id,$is->numbering,$app_id);
                                            foreach($latest_dates as $ld){
                                              if(empty($ld->response))
                                              {
                                                  $idate = $ld->interview_date;
                                                  $itime = $ld->interview_time;
                                              }
                                              else
                                              {
                                                if($ld->response=='Accept' || $ld->response=='Decline')
                                                {
                                                  $idate = $ld->interview_date;
                                                  $itime = $ld->interview_time;
                                                }
                                                else
                                                {
                                                  if(empty($ld->company_response))
                                                  {
                                                     $idate = $ld->resched_date;
                                                     $itime = $ld->resched_time;  
                                                  }
                                                  else
                                                  {
                                                    if($ld->company_response=='Accept' || $ld->company_response=='Decline')
                                                    {
                                                      $idate = $ld->resched_date;
                                                      $itime = $ld->resched_time; 
                                                    }
                                                    else
                                                    {
                                                       
                                                      $idate = $ld->new_date;
                                                      $itime = $ld->new_time; 
                                                    }
                                                  }
                                                 
                                                }
                                              }
                                          ?>

                                          <td>
                                              <div id='origdate<?php echo $is->interview_id;?>'><?php echo $idate;?></div>
                                          </td>
                                          <td>
                                              <div id='origtime<?php echo $is->interview_id;?>'><?php echo $itime;?></div>
                                          </td>
                                          <td>
                                            <?php if($employer_type=='public'){?>

                                                <div id='originterviewer<?php echo $is->interview_id;?>'><?php echo $ld->interviewer;  ?></div>
                                               
                                            <?php } else{?>

                                                <div id='originterviewer<?php echo $is->interview_id;?>'><?php echo $ld->fullname;  ?></div>

                                            <?php } ?>
                                            <input type="hidden" id="interviewerfinal<?php echo $is->interview_id;?>">

                                          </td>

                                          <?php  } } ?>
                                          <td>
                                            <n class="text-success"><b><?php if($check_interviewprocessstatus=='not_exist'){ echo "-"; } else{ echo $check_interviewprocessstatus; }?></b></n>
                                          </td>
                                          <td>
                                              <?php 
                                                  $result_interview = $this->final_recruitments_model->result_interview($is->interview_id,$is->numbering,$app_id); 
                                                  if(empty($result_interview)){} else{ echo $result_interview; }
                                              ?>
                                          </td>
                                         

                                      </tr>
                                    <?php } ?>
                                   
                                  </tbody>
                                </table>

                      <?php } else if($s->id==3){ 

                      ?>


                              <?php if(empty($details)){ echo "no application status yet"; } else{?>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        Date Update
                                    </div>
                                    <div class="col-md-8">
                                        <n><?php echo $details->date_created;?></n>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        Admin Comment
                                    </div>
                                    <div class="col-md-8">
                                        <n><?php echo $details->admin_comment;?></n>
                                    </div>
                                </div>

                               <div class="col-md-12">
                                    <div class="col-md-4">
                                        Date Hired
                                    </div>
                                    <div class="col-md-8">
                                        <n><?php if(!empty($application_details->date_hired)){ echo $application_details->date_hired; }?></n>
                                    </div>
                              </div>

                              <div class="col-md-12">
                                    <div class="col-md-4">
                                        Employee ID
                                    </div>
                                    <div class="col-md-8">
                                        <n><?php if(!empty($application_details->hired_employee)){ echo $application_details->hired_employee; }?></n>
                                    </div>
                              </div>

                              <div class="col-md-12">
                                    <div class="col-md-4">
                                        Message
                                    </div>
                                    <div class="col-md-8">
                                        <n><?php if(!empty($application_details->hired_message)){ echo $application_details->hired_message; }?></n>
                                    </div>
                              </div>

                              <?php } ?>

                              




                      <?php } else if($s->id==4){?>


                              <?php if(empty($details)){ echo "no application status yet"; } else{?>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        Date Update
                                    </div>
                                    <div class="col-md-8">
                                        <n><?php echo $details->date_created;?></n>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        Admin Comment
                                    </div>
                                    <div class="col-md-8">
                                        <n><?php echo $details->admin_comment;?></n>
                                    </div>
                                </div>

                               
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        Reason
                                    </div>
                                    <div class="col-md-8">
                                        <n><?php if(!empty($application_details->blocked_reason)){ echo $application_details->blocked_reason; }?></n>
                                    </div>
                                </div>


                              <?php } ?>


                      <?php } else{?>

                              <?php if(empty($details)){ echo "no application status yet"; } else{?>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        Date Update
                                    </div>
                                    <div class="col-md-8">
                                        <n><?php echo $details->date_created;?></n>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        Admin Comment
                                    </div>
                                    <div class="col-md-8">
                                        <n><?php echo $details->admin_comment;?></n>
                                    </div>
                                </div>
                              <?php } ?>

                      <?php } ?>
                  </span>
                </div>
              </div>
              </div>
              <?php } ?>

        
          <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="location.reload();">Close</button>
          </div> 

         
      </div>
    </div>
