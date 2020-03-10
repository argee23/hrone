

<div class="panel panel-default">
  <div class="panel-body">
    <div class="box-header with-border">
         <h3 class="box-title text-danger"><u><?php echo $notif_details->form_name;?></u></h3> 
         <button class="btn btn-danger pull-right btn-xs" onclick="view_filtering('filtering_notif','filtering_notif_val');">Click to filter history</button>

    </div>
      <div class="box box-primary">
        <div class="col-md-12" style="margin-top: 30px;margin-bottom: 20px;display: none;"  id="filtering_notif">
            <div class="col-md-12">
            <input type="hidden" id="filtering_notif_val" value="0">
            <div class="col-md-12">
                  <div class="col-md-1"></div>
                   <div class="col-md-8">
                      <div class="col-md-4" style="text-align: right;">Status</div>
                      <div class="col-md-8">
                          <select class="form-control" id="notif_status">
                            <option value="">Select</option>
                            <option value="all">all</option>
                            <option value="v">viewed</option>
                            <option value="a">acknowledged</option>
                            <option value="nv">not yet viewed</option>
                            <option value="na">not yet acknowledged</option>
                          </select>
                      </div>
                  </div>
                   <div class="col-md-3"></div>
            </div>
             <div class="col-md-12" style="margin-top: 10px;">

                  <div class="col-md-1"></div>
                   <div class="col-md-8">
                      <div class="col-md-4" style="text-align: right;">Date Range</div>
                      <div class="col-md-4">
                            <input type="date" class="form-control" id="date_from">
                      </div>
                       <div class="col-md-4">
                            <input type="date" class="form-control" id="date_to">
                      </div>
                  </div>
                   <div class="col-md-1">

                       <button type="button" class="btn btn-success" onclick="filter_notifications('<?php echo $notif_details->t_table_name;?>','<?php echo $notif_details->id;?>','<?php echo $notif_details->identification;?>');"><i class="fa fa-search"></i></button>
                   </div>
            </div>

            </div>

            
            <br><br><br> <br><br> <div class="box box-default" class='col-md-12'></div>
        </div>

            <div class="box-body" style="margin-top: 20px;" id="filter_result">
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
            </div>
      </div>
    </div>
  </div>
</div>

