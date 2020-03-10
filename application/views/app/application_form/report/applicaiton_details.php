
 <div class="datagrid" style="margin-top: 20px;">
      <table>
        <thead>
          <tr>
            <th colspan="6"><center>Job Application Details</center></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($job_details as $j){?>
          <tr>
              <td><n class="text-danger">Company Name</n></td>
              <td><?php echo $j->company_name;?></td>
              <td><n class="text-danger">Job Title</n></td>
              <td><?php echo $j->job_title;?></td>
              
          </tr>

          <tr>
              <td><n class="text-danger">Job Vacancy</n></td>
              <td><?php echo $j->job_vacancy;?></td>
              <td><n class="text-danger">Hiring Start</n></td>
              <td><?php echo $j->hiring_start;?></td>
          </tr>

          <tr>
              <td><n class="text-danger">Hiring End</n></td>
              <td><?php echo $j->hiring_end;?></td>
              <td><n class="text-danger">Salary</n></td>
              <td><?php echo $j->salary;?></td>
          </tr> 
          <tr>
              <td><n class="text-danger">Job Description</n></td>
              <td><?php echo $j->job_qualification;?></td>
              <td><n class="text-danger">Job Qualification</n></td>
              <td><?php echo $j->job_description;?></td>
          </tr>
          <tr>
              <td><n class="text-danger">Location</n></td>
              <td> <?php echo $data = $this->applicant_reports_model->get_location($j->loc_province,$j->loc_city);?></td>
              <td><n class="text-danger">Date Posted</n></td>
              <td><?php echo $j->date_posted;?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
</div>

<div class="datagrid" style="margin-top: 20px;">
    
 <?php if(empty($req)){ echo "<h3 class='text-danger'><center>No Requirement/s found . . </center></h3>";}
          else{?>
          <table>
              <thead>
                <tr>
                  <th colspan="4"><center>Job Requirements Details</center></th>
                </tr>
              </thead>
              <tbody>
              <tr class="alt"> 
                  <td>Requirement</td>
                  <td>Status</td>
                  <td>Employer Comment</td>
                  <td>File</td>
              </tr>
              <?php $i=1; foreach ($req as $r) {
                $req_res = $this->application_forms_model->check_requirement_status($r->idd,$applicant_id,$job_id);
              
               ?>
                <tr>
                  <td><?php echo $r->title;?></td>
                  <td>
                    <?php 

                        if(!empty($req_res->status) AND $req_res->status==1)
                          { 
                              echo "approved";
                          } 

                        else
                          { 
                              echo "pending"; 
                          } 
                    ?>
                  </td>
                  <td><?php if(empty($r->comment)){ echo "no comment yet"; } else{ echo $r->comment; } ?></td>
                  <td>
                    <?php if(empty($req_res->file)) { echo "no file yet"; } else { ?>
                           <a href="<?php echo base_url(); ?>app/application_forms/download_requirements/<?php echo $req_res->file; ?>"
                           title="Download File" ><?php echo $req_res->file;?></a> 
                        <?php } ?>
                  </td>
                 
                </tr>
              <?php $i++; } echo "<input type='hidden' name='req_count' value='".$i."'>"; ?>
                <tr class="alt"> 
                  <td colspan="4"></td>
                </tr>
              </tbody>
          </table>
          <?php } ?>

</div>

<div class="datagrid" style="margin-top: 20px;">
    
          <table>
              <thead>
                <tr>
                  <th colspan="2"><center>Application Status History</center></th>
                </tr>
              </thead>
              <tbody>
                <tr class="alt"> 
                    <td>Status</td>
                    <td>Date</td>
                </tr>
                <?php if(empty($applicationstatus)){ echo "<tr><td colspan='2'>No Application Status found.</td></tr>"; } else{ foreach($applicationstatus as $p){?>
                  <tr> 
                    <td><?php echo $p->status_title;?></td>
                    <td><?php echo $p->date_created;?></td>
                </tr>
                <?php } } ?>
              </tbody>
          </table>

</div>


<div class="datagrid" style="margin-top: 20px;">
    
          <table>
              <thead>
                <tr>
                  <th colspan="4"><center>Interview Request History</center></th>
                </tr>
              </thead>
          </table>


          <div class="panel panel-success">
              <div class="panel-heading">
                <strong><a class="text-danger">Applicant Interview Process Details</a></strong>
              </div>
          <div class="panel-body">
              <span class="dl-horizontal col-sm-12">
                
                        <?php  foreach($interview_status as $is){
                            $checker_ifexist = $this->recruitments_model->checker_ifexist_interview_process($app_id,$is->interview_id,$is->numbering);
                            if(empty($checker_ifexist)){?>

                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <strong><?php echo $is->title;?></strong>
                                  </div>
                                  <div class="panel-body">
                                    <span class="dl-horizontal col-sm-12">
                                     
                                          <h4><i class="icon fa fa-warning"></i>No <?php echo $is->title;?> Yet!</h4>
                                      
                                    </span>
                                  </div>
                                </div>
                            <?php }
                            else {
                          ?>
                               <div class="panel panel-default">
                                <div class="panel-heading">
                                  <strong><?php echo $is->title;?></strong>
                                </div>
                              <div class="panel-body">
                                <span class="dl-horizontal col-sm-12">
                                  <?php foreach($checker_ifexist as $c){?>

                                        <div class="col-md-12">
                                            <div class="col-md-5">Interview Date</div>
                                            <div class="col-md-7">
                                                <?php 
                                                  $month=substr($c->interview_date, 5,2);
                                                  $day=substr($c->interview_date, 8,2);
                                                  $year=substr($c->interview_date, 0,4);

                                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                                ?>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="col-md-5">Time of Interview </div>
                                            <div class="col-md-7"><?php echo $c->interview_time;?> </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="col-md-5">Message</div>
                                            <div class="col-md-7"><?php echo $c->interview_message;?> </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="col-md-5">Interview Address</div>
                                            <div class="col-md-7"><?php echo $c->interview_address;?> </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="col-md-5">Date Send</div>
                                            <div class="col-md-7">
                                              <?php 
                                                  $month=substr($c->interview_date_send, 5,2);
                                                  $day=substr($c->interview_date_send, 8,2);
                                                  $year=substr($c->interview_date_send, 0,4);

                                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 20px;">
                                                    <div class="col-md-5"><n class="text-danger">Applicant Response</n></div>
                                                    <div class="col-md-7"><n class="text-danger"><?php  if(empty($c->response)){ echo "No Response Yet";} else{ echo $c->response; } ?></n></div>
                                        </div>
                                        <?php if($c->response=='Reschedule')
                                        {

                                        ?>
                                                <div class="col-md-12">
                                                    <div class="col-md-5"><n class="text-danger">Requested Date</n></div>
                                                    <div class="col-md-7">
                                                      <n class="text-danger">
                                                        <?php 
                                                          $month=substr($c->resched_date, 5,2);
                                                          $day=substr($c->resched_date, 8,2);
                                                          $year=substr($c->resched_date, 0,4);

                                                          echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                                        ?>
                                                      </n>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="col-md-5"><n class="text-danger">Requested Time</n></div>
                                                    <div class="col-md-7"><n class="text-danger"><?php echo $c->resched_time;?></n></div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="col-md-5"><n class="text-danger">Reason</n></div>
                                                    <div class="col-md-7"><n class="text-danger"><?php echo $c->resched_reason;?></n></div>
                                                </div>

                                                <div class="col-md-12"  style="margin-top: 20px;">
                                                    <div class="col-md-5">Company Response</div>
                                                    <div class="col-md-7"><?php echo $c->company_response;?></div>
                                                </div>

                                                <?php  if($c->company_response=='Accept' || $c->company_response=='Decline'){ } else{ ?>

                                                    <div class="col-md-12">
                                                      <div class="col-md-5">Final Interview Date</div>
                                                      <div class="col-md-7">
                                                        <?php 
                                                          $month=substr($c->new_date, 5,2);
                                                          $day=substr($c->new_date, 8,2);
                                                          $year=substr($c->new_date, 0,4);

                                                          echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                                        ?>
                                                      </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                      <div class="col-md-5">Final Interview Time</div>
                                                      <div class="col-md-7"><?php echo $c->new_time;?></div>
                                                    </div>

                                                    <div class="col-md-12"  style="margin-top: 20px;">
                                                      <div class="col-md-5"><n class="text-danger">Applicant Response</n></div>
                                                      <div class="col-md-7"><n class="text-danger"><?php echo $c->company_resched_applicant_response;?></n></div>
                                                    </div>

                                                <?php }?>

                                               
                                 <?php }?>
                                                

                                                  <div class="col-md-12"  style="margin-top: 20px;">

                                                  <div class="col-md-5"><n class="text-info">Interview Result</n></div>
                                                  <div class="col-md-7"><n class="text-info"><?php  if($c->interview_result=='pending'){ echo "No Result Yet";} else{ echo $c->interview_result; } ?></n></div>

                                                  <div class="col-md-5"><n class="text-info">Interviewer Comment</n></div>
                                                  <div class="col-md-7"><n class="text-info"><?php  if(empty($c->interviewer_comment)){ echo "No Comment Yet";} else{ echo $c->interviewer_comment; } ?></n></div>

                                                  <?php if($c->interview_result=='pending'){} else{?>
                                                  <div class="col-md-5"><n class="text-info">Response Type</n></div>
                                                  <div class="col-md-7"><n class="text-info"><?php  if(empty($c->response_type)){ echo "No response yet";} else{ echo $c->response_type; } ?></n></div>
                                                  <?php } ?>

                                                </div>

                                 <?php  } ?>

                                </span>
                              </div>
                            </div>

                          <?php } } ?>
              </span>
          </div>

</div>



<div class="datagrid" style="margin-top: 20px;">
    
          <table>
              <thead>
                <tr>
                  <th colspan="2"><center>Employee Referral Points</center></th>
                </tr>
              </thead>
              <tbody>
                <tr class="alt"> 
                    <td>Employee</td>
                    <td>Date Added</td>
                </tr>
                <?php if(empty($referral)){ echo "<tr><td colspan='2'>No Employee Referral found.</td></tr>"; } else{ foreach($referral as $p){?>
                  <tr> 
                    <td><?php echo $p->employee;?></td>
                    <td><?php echo $p->date_added;?></td>
                </tr>
                <?php } } ?>
              </tbody>
          </table>

</div>


