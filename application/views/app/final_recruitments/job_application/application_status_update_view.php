 <?php if($this->session->flashdata('success_updated') AND $action_=='updated')
  { 
              echo '<div id="flashdata_result" style="margin-bottom:20px;"> <n class="text-danger" style="font-weight:bold;"> <center>Interview Details is successfully updated.</center></n></div>';
  } 
  else if($this->session->flashdata('success_cancelled') AND $action_=='cancelled') {
    echo '<div id="flashdata_result" style="margin-bottom:20px;"> <n class="text-danger" style="font-weight:bold;"> <center>Interview Request is successfully cancelled.</center></n></div>';
  } 
  else{}?>

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
                            <td></td>
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

                              <td>
                                  <div id='origdate<?php echo $is->interview_id;?>'><?php echo $idate;?></div>
                                  <div id='upddate<?php echo $is->interview_id;?>' style='display: none;'>
                                    <input type="date" class="form-control" name="date<?php echo $is->interview_id;?>" id="date<?php echo $is->interview_id;?>" value="<?php echo $idate;?>">
                                  </div>
                              </td>
                              <td>
                                  <div id='origtime<?php echo $is->interview_id;?>'><?php echo $itime;?></div>
                                  <div id='updtime<?php echo $is->interview_id;?>' style='display: none;'>
                                    <input type="time" class="form-control" name="time<?php echo $is->interview_id;?>" id="time<?php echo $is->interview_id;?>" value="<?php echo $itime;?>">
                                  </div>

                              </td>
                              <td>
                                <?php if($employer_type=='public'){?>

                                    <div id='originterviewer<?php echo $is->interview_id;?>'><?php echo $ld->interviewer;  ?></div>
                                    <div id='updinterviewer<?php echo $is->interview_id;?>' style='display: none;'>
                                      <input type="date" class="form-control" name="interviewer<?php echo $is->interview_id;?>" id="interviewer<?php echo $is->interview_id;?>" value="<?php echo $ld->fullname; ?>">
                                    </div>

                                <?php } else{?>

                                    <div id='originterviewer<?php echo $is->interview_id;?>'><?php echo $ld->fullname;  ?></div>
                                    <div id='updinterviewer<?php echo $is->interview_id;?>' style='display: none;'>
                                      <select class="form-control" id="interviewer<?php echo $is->interview_id;?>" name='interviewer'>
                                        <?php foreach($interviewer as $in){?>
                                            <option value="<?php echo $in->employee_id;?>" <?php if($ld->employee_id==$in->employee_id){ echo "selected"; }?>><?php echo $in->fullname." (".$in->employee_id.") ";?></option>
                                        <?php } ?>
                                      </select>
                                    </div>


                                <?php } ?>
                                <input type="hidden" id="interviewerfinal<?php echo $is->interview_id;?>">

                              </td>

                              <?php  } } ?>
                              <td>
                                <n class="text-success"><b><?php if($check_interviewprocessstatus=='not_exist'){ echo "-"; } else{ echo $check_interviewprocessstatus; }?></b></n>
                              </td>

                              <td>
                                <div id="origation<?php echo $is->interview_id;?>">
                                    <?php if($check_interviewprocessstatus=='not_exist'){} else{
                                      if($ld->response==Null || $ld==''){
                                    ?>
                                       <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Interview Details' onclick='update_interview_details("<?php echo $is->interview_id;?>");' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                                        <a style='cursor:pointer;color:red;'  aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Interview' onclick="cancel_interview_request('<?php echo $is->interview_id;?>','<?php echo $is->company_id;?>','<?php echo $app_id;?>','<?php echo $employer_type;?>','<?php echo $is->numbering;?>');" ><i  class="fa fa-times fa-lg  pull-left"></i></a>


                                    <?php  }} ?>
                                </div>

                                <div id="updation<?php echo $is->interview_id;?>" style='display: none;'>
                                      <a style='cursor:pointer;color:green;' style="margin-top: 20px;margin-left: 10px;"  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="save_updated_details('<?php echo $is->interview_id;?>','<?php echo $is->company_id;?>','<?php echo $app_id;?>','<?php echo $employer_type;?>','<?php echo $is->numbering;?>');"><i  class="fa fa-check fa-lg  pull-left"></i></a>
                                      <a  style="margin-top: 20px;margin-left: 10px;color:red;" onclick='cancel_interview_details("<?php echo $is->interview_id;?>");' aria-hidden='true' data-toggle='tooltip' title='Click to cancel numbering update'><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                </div>
                               
                              </td>
                          </tr>
                        <?php } ?>
                        <tr class="alt">
                            <td colspan="7"> <h5 style="cursor: pointer;" class="pull-right" onclick="collapse('interview_process_details');">VIEW INTERVIEW DETAILS</h5></td>
                        </tr>
                      </tbody>
                    </table>