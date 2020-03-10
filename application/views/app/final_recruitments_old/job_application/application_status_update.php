
<?php $recheck_added = $this->recruitments_model->check_last_added_interview_process($app_id);;?> 
 <div class="modal-content">
        

              <div>
                <div class="box-body">
                  <div class="col-lg-12">      
                       <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-aqua-active">
                          <h4 style="font-family: serif;"><n><center>Update Job Application Status</center></n></h4> 
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


      <?php if(empty($interview_status)){?>
        <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
              <strong>  <h4 class="text-danger"><center>Kindly set first the Interview Process List to continue. Thank you!</center></h4></strong>
          </div>
        </div>
        </div>

      <?php }
      else { ?>

      <input type="hidden" id="current_date" value="<?php echo date('Y-m-d');?>">
      <div class="modal-body">
              <div class="panel panel-default">
              <div class="panel-body">
                <span class="dl-horizontal col-sm-12">
                  <div class="datagrid" id="datagridd">
                    <table>
                      <thead>
                      </thead>
                      <tbody>
                         <tr class="alt" style="text-align: center;">
                            <td>Numbering</td>
                            <td>Title</td>
                            <td>Interview Date</td>
                            <td>Interview Time</td>
                            <td>Interviewer</td>
                            <td>Status</td>
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

                              <td><?php echo $idate;?></td>
                              <td><?php echo $itime;?></td>
                              <td><?php if($employer_type=='public'){ echo $ld->interviewer; } else { echo $ld->fullname; }?></td>

                              <?php  } } ?>

                              <td>
                                <n class="text-success"><b><?php if($check_interviewprocessstatus=='not_exist'){ echo "-"; } else{ echo $check_interviewprocessstatus; }?></b></n>
                              </td>
                          </tr>
                        <?php } ?>
                        <tr class="alt">
                            <td colspan="7"> <h5 style="cursor: pointer;" class="pull-right" onclick="collapse('interview_process_details');">VIEW INTERVIEW DETAILS</h5></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </span>
              </div>
              </div>

              <div id='interview_process_details' style="display: none;">
                  

                  <div class="panel panel-success">
                    <div class="panel-heading">
                      <strong><a class="text-danger">Applicant Interview Process Details<i onclick="collapse('interview_process_details');" class="fa fa-times pull-right" style="cursor: pointer;"></i></i></a></strong>
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
                                       <div class="callout callout-danger">
                                          <h4><i class="icon fa fa-warning"></i>No <?php echo $is->title;?> Yet!</h4>
                                       </div>
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

                                 <?php }  } ?>

                                </span>
                              </div>
                            </div>

                          <?php } } ?>

                    </span>
                  </div>
                </div>
           
                 
              </div>

              <div id='main_divv'>

              <?php 
                
                if($recheck_added=='decline'){?>

                <!-- for declined interview / view all -->

                <div class="panel panel-success">
                    <div class="panel-heading">
                      <strong><a class="text-danger"><center>Applicant Interview Response</center></i></a></strong>
                    </div>
                  <div class="panel-body">
                    <span class="dl-horizontal col-sm-12">

                         <?php foreach($interview_status as $is){
                            $checker_ifexist = $this->recruitments_model->checker_ifexist_interview_process($app_id,$is->interview_id,$is->numbering);
                            if(empty($checker_ifexist)){}
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
                                                    <div class="col-md-7"><n class="text-danger"><?php if(empty($c->response)){ echo "No Response Yet";} else{ echo $c->response; }?></n></div>
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

                                 <?php }  } ?>

                                </span>
                              </div>
                            </div>

                          <?php } }?>
                    </span>
                  </div>
                </div>

                <?php }
                else if($recheck_added=='none')
                {
                  $get_the_first_interview = $this->recruitments_model->get_the_interview_process($company,$app_id);
                  if(!empty($get_the_first_interview)) {
              ?>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <strong><a class="text-danger"><center>Interview Process : <?php echo $get_the_first_interview->title;?> </center></i></a></strong>
                    </div>
                  <div class="panel-body">
                    <span class="dl-horizontal col-sm-12">

                        <div class="col-md-12">
                          <div class="col-md-3"><label class="pull-right">When</label></div>
                          <div class="col-md-9"><input type="date" class="form-control" id="awhen" name="awhen" placeholder="Date of Interview" 
                          onchange="check_date(event);"></div>
                        </div>

                        <div class="col-md-12" style='margin-top: 5px;'>
                          <div class="col-md-3"><label class="pull-right">Time</label></div>
                          <div class="col-md-9"><input type="time" class="form-control" id="atime" name="atime" placeholder="From"></div>
                        </div>

                        <div class="col-md-12"  style='margin-top: 5px;'>
                          <div class="col-md-3"><label class="pull-right">Message</label></div>
                          <div class="col-md-9"><textarea class="form-control" rows="3" name="amessage" id="amessage" placeholder="Message to the applicant"></textarea></div>
                        </div>

                        <div class="col-md-12"  style='margin-top: 5px;'>
                          <div class="col-md-3"><label class="pull-right">Addresss</label></div>
                          <div class="col-md-9"><textarea class="form-control" rows="2" id="aaddress" name="aaddress" placeholder="Address for Job Interview"></textarea></div>
                        </div>

                        <div class="col-md-12"  style='margin-top: 5px;'>
                          <div class="col-md-3"><label class="pull-right">Interviewer</label></div>
                          <div class="col-md-9">
                          <?php if($employer_type=='public')
                          {?>

                            <input type="text" class="form-control" name="interviewer" id="interviewer" placeholder="Assign Interviewer">

                          <?php }
                          else
                          {?>
                              <select class="form-control" id="interviewer" name='interviewer'>
                              <option value="" disabled selected>Assign Interviewer</option>
                              <?php foreach($interviewer as $in){?>
                                  <option value="<?php echo $in->employee_id;?>"><?php echo $in->fullname." (".$in->employee_id.") ";?></option>
                              <?php } ?>
                              </select>
                          <?php } ?>
                           <input type="hidden" class="form-control" name="interviewer_final" id="interviewer_final">

                          </div>
                        </div>

                        
                        <input type="hidden" id="amessage_final">
                        <input type="hidden" id="aaddress_final">

                    </span>
                   </div>
                  </div>
                  <div class="col-md-12"  style='margin-top: 5px;'>
                      <button class="col-md-12 btn btn-info pull-right" style="margin-right: 10px;margin-bottom: 10px;" onclick="save_interview_request('<?php echo $get_the_first_interview->interview_id;?>','<?php echo $get_the_first_interview->numbering;?>','<?php echo $app_id;?>');" id="btn_i1"><b>SAVE INTERVIEW REQUEST</b></button> 
                  </div>

              <?php } else{ ?>


                  <div class="panel panel-success">
                    <div class="panel-heading">
                      <strong><a class="text-danger"><center>Applicant Interview Response</center></i></a></strong>
                    </div>
                    <div class="panel-body">
                      <span class="dl-horizontal col-sm-12">

                        <?php foreach($interview_status as $is){
                            $checker_ifexist = $this->recruitments_model->checker_ifexist_interview_process($app_id,$is->interview_id,$is->numbering);
                            if(empty($checker_ifexist)){}
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
                                                    <div class="col-md-7"><n class="text-danger"><?php echo $c->response;?></n></div>
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

                                 <?php }  } ?>

                                </span>
                              </div>
                            </div>

                        <?php } } ?>
                      </span>
                    </div>
                  </div>



              <?PHP } } else { 

              foreach($recheck_added as $rca){
                  $check = $this->recruitments_model->check_interview_process_status($rca->id,$rca->numbering,$rca->interview_process_id);
                 
              ?>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <strong><a class="text-danger"><center>Interview Process : <?php echo $rca->title;?> </center></i></a></strong>
                    </div>
                    <div class="panel-body">
                      <span class="dl-horizontal col-sm-12">
                       <div class="col-md-12">
                          <div class="col-md-5"><label class="pull-right">When</label></div>
                          <div class="col-md-7">
                                <?php 
                                  $month=substr($rca->interview_date, 5,2);
                                  $day=substr($rca->interview_date, 8,2);
                                  $year=substr($rca->interview_date, 0,4);

                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                ?>
                          </div>
                        </div>

                        <div class="col-md-12" style='margin-top: 5px;'>
                          <div class="col-md-5"><label class="pull-right">Time</label></div>
                          <div class="col-md-7">
                              <?php echo $rca->interview_time;?>
                          </div>
                        </div>

                        <div class="col-md-12"  style='margin-top: 5px;'>
                          <div class="col-md-5"><label class="pull-right">Message</label></div>
                          <div class="col-md-7">
                            <?php echo $rca->interview_message;?>
                          </div>
                        </div>

                        <div class="col-md-12"  style='margin-top: 5px;'>
                          <div class="col-md-5"><label class="pull-right">Addresss</label></div>
                          <div class="col-md-7">
                            <?php echo $rca->interview_address;?>
                          </div>
                        </div>

                        
                        <?php if($rca->response=='Reschedule'){

                            if(empty($rca->company_response))
                            {
                        ?>


                        <div class="col-md-12 callout callout-info" style='margin-top: 15px;'>
                            <div class="col-md-12">
                              <div class="col-md-5"><label class="pull-right" style="color:black;">Applicant Response</label></div>
                              <div class="col-md-7">
                                   <n class="text-danger">RESCHEDULE</n>
                              </div>
                            </div>
                        
                            <div class="col-md-12">
                              <div class="col-md-5"><label class="pull-right" style="color:black;">Requested Date</label></div>
                              <div class="col-md-7"><n class="text-danger"><?php echo $rca->resched_date;?> </n></div>
                            </div>

                             <div class="col-md-12">
                              <div class="col-md-5"><label class="pull-right" style="color:black;">Requested Time</label></div>
                              <div class="col-md-7"><n class="text-danger"><?php echo $rca->resched_time;?> </n></div>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="col-md-5"><label class="pull-right" style="color:black;">Applicant Reason</label></div>
                              <div class="col-md-7"><n class="text-danger"><?php echo $rca->resched_reason;?> </n></div>
                            </div>

                            <?php if($rca->company_response=='Accept' || $rca->company_response=='Decline')
                            {?>
                              <div class="col-md-12">
                                <div class="col-md-5"><label class="pull-right" style="color:black;">Employer Response</label></div>
                                <div class="col-md-7"><n class="text-danger"><?php echo $rca->company_response;?>ed </n></div>
                              </div>
                            <?php }
                            else if($rca->company_response=='Reschedule')
                            {?>
                              <div class="col-md-12">
                                <div class="col-md-5"><label class="pull-right" style="color:black;">Employer Response</label></div>
                                <div class="col-md-7"><n class="text-danger">Resched </n></div>
                              </div>
                            <?php }
                            else
                            {?>
                                 <input type="hidden" class="form-control" id="awhen_checker" value="<?php echo $rca->resched_date;?>">
                                <div class="col-md-12"  style='margin-top: 5px;'>
                                  <div class="col-md-5"><label class="pull-right" style="color:black;">Employer Response</label></div>
                                  <div class="col-md-7">
                                      <select class="form-control" name="company_response" id="company_response" onchange="get_first_interview_reponse(this.value);">
                                        <option value="" selected disabled>Select</option>
                                        <option>Accept</option>
                                        <option>Decline</option>
                                        <option>Reschedule</option>
                                      </select>
                                  </div>
                                </div>

                                <div class="col-md-12"  style='margin-top: 5px;display: none;' id="company_response_div1">
                                  <div class="col-md-5"><label class="pull-right" style="color:black;">Final Date</label></div>
                                  <div class="col-md-7">
                                     <input type="date" class="form-control" id="awhen_final_interview">
                                  </div>
                                </div>

                                <div class="col-md-12"  style='margin-top: 5px;display: none;' id="company_response_div2">
                                  <div class="col-md-5"><label class="pull-right" style="color:black;">Final Time</label></div>
                                  <div class="col-md-7">
                                     <input type="time" class="form-control" id="atime_final_time">
                                  </div>
                                </div>

                                
                            <?php }
                            ?>
                            
                        </div>

                        <button class="col-md-12 btn btn-success" onclick="save_company_response('<?php echo $rca->id;?>');">SAVE RESPONSE</button>
                          <?php } else { ?>

                                  <div class="col-md-12 callout callout-info" style='margin-top: 15px;'>

                                    <div class="col-md-12">
                                      <div class="col-md-5"><label class="pull-right" style="color:black;">Applicant Response</label></div>
                                      <div class="col-md-7">
                                         <n class="text-danger">RESCHEDULE</n>
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                      <div class="col-md-5"><label class="pull-right" style="color:black;">Requested Date</label></div>
                                      <div class="col-md-7">
                                         <n class="text-danger">
                                           <?php 
                                              $month=substr($rca->resched_date, 5,2);
                                              $day=substr($rca->resched_date, 8,2);
                                              $year=substr($rca->resched_date, 0,4);

                                              echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                            ?>
                                         </n>
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                      <div class="col-md-5"><label class="pull-right" style="color:black;">Requested Time</label></div>
                                      <div class="col-md-7">
                                         <n class="text-danger"><?php echo $rca->resched_time;?></n>
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                      <div class="col-md-5"><label class="pull-right" style="color:black;">Reason</label></div>
                                      <div class="col-md-7">
                                         <n class="text-danger"><?php echo $rca->resched_reason;?></n>
                                      </div>
                                    </div>

                                     <div class="col-md-12">
                                      <div class="col-md-5"><label class="pull-right" style="color:black;">Company Response</label></div>
                                      <div class="col-md-7">
                                         <n class="text-danger"><?php echo $rca->company_response;?></n>
                                      </div>
                                    </div>
                                   <?php if($rca->company_response=='Accept' || $rca->company_response=='Decline'){} else{?> 
                                    <div class="col-md-12">
                                      <div class="col-md-5"><label class="pull-right" style="color:black;">Final Date</label></div>
                                      <div class="col-md-7">
                                         <n class="text-danger">
                                            <?php 
                                              $month=substr($rca->new_date, 5,2);
                                              $day=substr($rca->new_date, 8,2);
                                              $year=substr($rca->new_date, 0,4);
                                              echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                            ?>
                                         </n>
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                      <div class="col-md-5"><label class="pull-right" style="color:black;">Final Time</label></div>
                                      <div class="col-md-7">
                                         <n class="text-danger"><?php echo $rca->new_time;?></n>
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                      <div class="col-md-5"><label class="pull-right" style="color:black;">Applicant Response</label></div>
                                      <div class="col-md-7"> <n class="text-danger">
                                  <?php if(empty($rca->company_resched_applicant_response))
                                  {?>
                                        NO APPLICANT RESPONSE YET
                                  <?php }
                                  else
                                  { echo $rca->company_resched_applicant_response."ed"; }?>
                                   </n>
                                      </div>
                                    </div>
                                  </div>




                          <?php } }?>

                        <?php } else if($rca->response=='Accept' || $rca->response=='Decline'){ ?>
                        <div class="col-md-12 callout callout-info" style='margin-top: 15px;'>
                            <div class="col-md-5"><label class="pull-right">Applicant Response</label></div>
                            <div class="col-md-7">
                                <?php echo $rca->response;?>d
                            </div>
                        </div>
                         
                        <?php } else {?>
                        <div class="col-md-12 callout callout-info" style='margin-top: 15px;'>
                          <div class="col-md-5"><label class="pull-right">Applicant Response</label></div>
                            <div class="col-md-7">
                                NO RESPONSE YET
                            </div>
                        </div>

                        <?php } ?>


                        </span>

                      </span>
                  </div>
                </div>

              <?php  } } ?>

              </div>

              <?php } ?>
        
          <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="location.reload();">Close</button>
          </div> 
      </div>
    </div>
<script type="text/javascript">

function collapse(id)
{
  var x = document.getElementById(id);
  var xx = document.getElementById('main_divv');
    if (x.style.display === "none") {
        x.style.display = "block";
        xx.style.display = "none";
    } else {
        x.style.display = "none";
        xx.style.display = "block";
    } 
}

function check_date(val)
{
  var d = new Date();
  var now = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
  var date = val.target.value;
  var date_1 = new Date(date);
  var now_date = date_1.getFullYear() + "-" + (date_1.getMonth()+1) + "-" + date_1.getDate();
  
  if(now > now_date)
  {
    alert("Invalid Date");
    document.getElementById("awhen").style.borderColor = "red";
    document.getElementById('btn_i1').disabled=true;
  }
  else
  {
    document.getElementById("awhen").style.borderColor = "";
    document.getElementById('btn_i1').disabled=false;
  }
   
}
function company_response_resched(val)
{
  if(val=='reschedule')
  {
     $("#company_response_final").show();
  }
  else
  {
     $("#company_response_final").hide();
  }
}


function save_interview_request(id,numbering,app_id)
{

 
    var date = document.getElementById('awhen').value; 
    var time = document.getElementById('atime').value;
    var message = document.getElementById('amessage').value;
    var address = document.getElementById('aaddress').value;
    var interviewer = document.getElementById('interviewer').value;
    
    function_escape('amessage_final',message);
    function_escape('aaddress_final',address);
    function_escape('interviewer_final',interviewer);

    var message_final = document.getElementById('amessage_final').value;
    var address_final = document.getElementById('aaddress_final').value;
    var interviewer_final = document.getElementById('interviewer_final').value;


    if(date=='' || time=='' || interviewer=='' || message_final=='' || address_final=='')
    {
      alert("Fill up all fields to continue");
    }
    else
    {
        if (window.XMLHttpRequest)
              {
              xmlhttp2=new XMLHttpRequest();
              }
            else
              { // code for IE6, IE5
              xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp2.onreadystatechange=function()
              {
              if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
                {
                  location.reload();
                }
              }
        xmlhttp2.open("GET","<?php echo base_url();?>app/final_recruitments/save_interview_request_first/"+date+"/"+time+"/"+message_final+"/"+address_final+"/"+id+"/"+numbering+"/"+app_id+"/"+interviewer_final,false);
        xmlhttp2.send();
    }
    
}
function get_first_interview_reponse(val)
    {
      if(val=='Reschedule')
      {
        $('#company_response_div1').show();
        $('#company_response_div2').show();
      }
      else
      {
        $('#company_response_div1').hide();
        $('#company_response_div2').hide();
      }
    }

function save_company_response(id)
{
  var response = document.getElementById('company_response').value;
  var today =  document.getElementById('current_date').value;

  if(response=='Reschedule')
        {
          var date = document.getElementById('awhen_final_interview').value;
          var time = document.getElementById('atime_final_time').value;
          var date_checker = document.getElementById('awhen_checker').value;


          if(date > today)
          {
            var datetrue = 'true';
          } else { var datetrue = 'false'; }
  }
  else
        {
          var date = 'not_included';
          var time = 'not_included';
          var datetrue = 'true';
        }

  if(response=='' || date=='' || time=='')
  { alert("Fill up all fields to continue"); }
  else if(datetrue=='false')
  {
    alert("Kindly select valid interview date");
  }
  else
  {

     if (window.XMLHttpRequest)
              {
              xmlhttp2=new XMLHttpRequest();
              }
            else
              { // code for IE6, IE5
              xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp2.onreadystatechange=function()
              {
              if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
                {
                  location.reload();
                }
              }
    xmlhttp2.open("GET","<?php echo base_url();?>app/final_recruitments/save_company_response/"+id+"/"+response+"/"+date+"/"+time,false);
    xmlhttp2.send();
  }
  


}
function function_escape(ids,titles)
    {
       var a = titles.replace(/\?/g, '-a-');
       var b = a.replace(/\!/g, "-b-");
       var c = b.replace(/\//g, "-c-");
       var d = c.replace(/\|/g, "-d-");
       var e = d.replace(/\[/g, "-e-");
       var f = e.replace(/\]/g, "-f-");
       var g = f.replace(/\(/g, "-g-");
       var h = g.replace(/\)/g, "-h-");
       var i = h.replace(/\{/g, "-i-");
       var j = i.replace(/\}/g, "-j-");
       var k = j.replace(/\'/g, "-k-");
       var l = k.replace(/\,/g, "-l-");
       var m = l.replace(/\'/g, "-m-");
       var n = m.replace(/\_/g, "-n-");
       var o = n.replace(/\@/g, "-o-");
       var p = o.replace(/\#/g, "-p-");
       var q = p.replace(/\%/g, "-q-");
       var r = q.replace(/\$/g, "-r-");
       var s = r.replace(/\^/g, "-s-");
       var t = s.replace(/\&/g, "-t-");
       var u = t.replace(/\*/g, "-u-");
       var v = u.replace(/\+/g, "-v-");
       var w = v.replace(/\=/g, "-w-");
       var x = w.replace(/\:/g, "-x-");
       var y = x.replace(/\;/g, "-y-");
       var z = y.replace(/\%20/g, "-z-");
       var aa = y.replace(/\./g, "-zz-");
       var bb = aa.replace(/\</g, "-aa-");
       var cc = bb.replace(/\>/g, "-bb-");
       document.getElementById(ids).value=cc;
    }
</script>
