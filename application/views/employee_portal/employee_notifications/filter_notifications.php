
                <table class="table table-responsive table-sm" id="notif">
                  <thead>
                      <tr class="danger">
                        <th>Document No.</th>
                        <th>Date Filed</th>
                        <th>Approvers</th>
                        <th><center>Time Viewed</center></th>
                        <th><center>Time Acknowledged</center></th>
                        <th><center>Action</center></th>
                      </tr>
                  </thead>
                  <tbody> 
                    <?php $i=1; foreach($details as $d){?>
                      <tr>
                        <td>
                          <a style="cursor: pointer;" href="<?php echo base_url();?>app/issue_notifications/view_notif_form/<?php echo $d->doc_no."/".$this->session->userdata('company_id')."/".$this->session->userdata('employee_id'); ?>" target="_blank"><?php echo $d->doc_no;?></a>
                        </td>
                        <td>
                          <?php
                              $month=substr($d->date_created, 5,2);
                              $day=substr($d->date_created, 8,2);
                              $year=substr($d->date_created, 0,4);

                              echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                            ?>
                        </td>
                        <td>
                          <?php 
                            if($notif_details->issuance_type=='1'){
                              $get_approvers = $this->employee_notifications_model->get_approvers_by_doc($d->doc_no,$notif_details->t_table_name."_approval");
                              ?>
                           <a data-toggle='collapse' data-target='#app<?php echo $d->doc_no;?>' style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view approver/s'><?php echo count($get_approvers)." approver/s";?></a>
                            <div id="app<?php echo $d->doc_no;?>" class="collapse">
                              <?php if(empty($get_approvers)){ echo "No approver/s found."; } else { 
                                foreach ($get_approvers as $app) {
                                  echo "<n class='text-danger'>".$app->first_name." ".$app->last_name."</n><br>";
                                ?>
                                  
                              <?php } } ?>
                            </div>

                            <?php  } 
                            else{ echo "no approvers"; }
                          ?>
                        </td>
                        <td>
                            <?php 
                              if(empty($d->time_viewed))
                                { echo "not yet viewed"; }
                                else
                                {
                                  echo $d->time_viewed;  
                                }
                            ?>
                        </td>
                        <td>
                            <?php 

                              if(empty($d->time_acknowledge))
                                { echo "not yet acknowledged"; }
                                else
                                {
                                  echo $d->time_acknowledge;  
                                }

                            ?>
                        </td>
                        <td>
                         <?php 

                            $eff=$this->employee_notifications_model->get_employee_fields_tofill($notif_details->id,$d->doc_no,$notif_details->t_table_name);
                            if($eff==0)
                            {
                                  if(empty($d->time_acknowledge))
                                   { ?>
                                    <center><a   style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('employee_portal/employee_notifications/aswer_to_notification')."/".$d->doc_no."/".$this->session->userdata('company_id')."/".$d->employee_id."/".$notif_details->t_table_name;?>"><span class="badge bg-green">Acknowledge</span></a></center></td>
                    
                                    <?php } else{?>
                                      <center><a   style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('employee_portal/employee_notifications/aswer_to_notification')."/".$d->doc_no."/".$this->session->userdata('company_id')."/".$d->employee_id."/".$notif_details->t_table_name;?>"><span class="badge bg-green">View Answer</span></a></center></td>
                                    <?php }
                            }
                            else{
                            if(empty($d->time_acknowledge))
                                { ?>
                                    <center><a   style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('employee_portal/employee_notifications/aswer_to_notification')."/".$d->doc_no."/".$this->session->userdata('company_id')."/".$d->employee_id."/".$notif_details->t_table_name;?>"><span class="badge bg-green">Answer</span></a></center></td>
                    
                                <?php } else{?>
                                      <center><a   style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('employee_portal/employee_notifications/aswer_to_notification')."/".$d->doc_no."/".$this->session->userdata('company_id')."/".$d->employee_id."/".$notif_details->t_table_name;?>"><span class="badge bg-green">View Answer</span></a></center></td>
                                <?php }

                              } ?>
                        </tr>
                    <?php $i++;  }?>
                  </tbody> 
                </table>