 
      <table class="table table-bordered" id="calendar_modal">
        <thead>
          <tr class="danger">
            <th>Name</th>
            <th>Schedule</th>
            <th>Attendance</th>
            <th>Filed Forms</th>
          </tr>
        </thead>
        <tbody>
        <?php 
                   
                    foreach ($get_schedules as $sched) {
                          $employee = $sched->employee_id;
                          $attendance = $this->reports_personnel_schedule_model->get_employee_attendance($sched->employee_id,$date);
                          $change_sched = $this->reports_personnel_schedule_model->filed_change_sched($employee,$date);
                          $change_restday = $this->reports_personnel_schedule_model->filed_change_restday($employee,$date,'orig_rest_day');
                          $change_restday_requested = $this->reports_personnel_schedule_model->filed_change_restday($employee,$date,'request_rest_day');
                          $leave = $this->reports_personnel_schedule_model->filed_leave($employee,$date);
                          $ob = $this->reports_personnel_schedule_model->filed_ob($employee,$date);
                          $ot = $this->reports_personnel_schedule_model->filed_ot($employee,$date);
                          $tk = $this->reports_personnel_schedule_model->filed_tk($employee,$date);
                          $undertime = $this->reports_personnel_schedule_model->filed_undertime($employee,$date);

                    ?>

                        <tr>
                          <td><?php echo $sched->first_name.' '.$sched->last_name;?></td>
                           <td>
                            <?php
                              if($sched->restday==1)
                                    { echo "<n><b>Schedule:</b></n> restday"; } else{ echo "<n><b>Schedule: ".$sched->shift_in.' to '.$sched->shift_out.'</b></n>'; } echo "<br><br>";
                            ?>
                          </td>
                          <td>
                              <?php 
                                  

                                  if(!empty($attendance)){ foreach($attendance as $a){ if(!empty($a->time_in)){ echo "<b>IN &nbsp;&nbsp;&nbsp;&nbsp;: </b> ".$a->time_in." (".$a->time_in_date.")"; } echo "<br>"; if(!empty($a->time_out)){ echo "<b>OUT :</b> ".$a->time_out." (".$a->time_out_date.")"; } } } else { }
                              ?>

                          </td>
                          <td>
                            <?php 
                  if(!empty($change_sched)){ echo "<n class='text-danger'><b>Change of Schedule</b> </n><br>"; }
                  foreach($change_sched as $c){ ?>
                  <?php echo '<a style="cursor:pointer;" target="_blank" href="'.base_url().'employee_portal/employee_transactions/view/'.$c->doc_no.'/emp_change_sched/HR003">'.$c->doc_no.'</a> ('.$c->status.')';?>
                  <?php } if(!empty($change_sched)){ echo "<br><br>"; } 

                  if(!empty($change_restday)){ echo "<n class='text-danger'><b>Change of Restday (Original restday)</b> </n><br>"; }
                  foreach($change_restday as $c){ ?>
                        <?php echo '<a style="cursor:pointer;" target="_blank"  href="'.base_url().'employee_portal/employee_transactions/view/'.$c->doc_no.'/emp_change_rest_day/HR027">'.$c->doc_no.'</a> ('.$c->status.')';?>
                  <?php } if(!empty($change_restday)){ echo "<br><br>";  }


                 if(!empty($change_restday_requested)){ echo "<n class='text-danger'><b>Change of Restday (Requested restday)</b> </n><br>"; }
                  foreach($change_restday_requested as $c){ ?>
                        <?php echo '<a style="cursor:pointer;"  target="_blank" href="'.base_url().'employee_portal/employee_transactions/view/'.$c->doc_no.'/emp_change_rest_day/HR027">'.$c->doc_no.'</a> ('.$c->status.')';?>
                  <?php } if(!empty($change_restday_requested)){ echo "<br>"; } 

                 if(!empty($leave)){ echo "<n class='text-danger'><b>Employee Leave</b> </n><br>"; }
                 foreach($leave as $c){ ?>
                        <?php echo '<a style="cursor:pointer;"  target="_blank" href="'.base_url().'employee_portal/employee_transactions/view/'.$c->doc_no.'/employee_leave/HR002">'.$c->doc_no.'</a> ('.$c->status.')';?>
                  <?php } if(!empty($leave)){ echo "<br><br>"; }


                  if(!empty($ob)){ echo "<n class='text-danger'><b>Official Business</b> </n><br>"; }
                  foreach($ob as $c){ ?>
                        <?php echo '<a style="cursor:pointer;"  target="_blank" href="'.base_url().'employee_portal/employee_transactions/view/'.$c->doc_no.'/emp_official_business/HR015">'.$c->doc_no.'</a> ('.$c->status.')';?>
                  <?php } if(!empty($ob)){ echo "<br><br>";  } 

                  if(!empty($ot)){ echo "<n class='text-danger'><b>Overtime (ATRO)</b> </n><br>"; }
                   foreach($ot as $c){ ?>
                        <?php echo '<a style="cursor:pointer;"  target="_blank" href="'.base_url().'employee_portal/employee_transactions/view/'.$c->doc_no.'/emp_atro/HR008">'.$c->doc_no.'</a> ('.$c->status.')';?>
                  <?php } if(!empty($ot)){ echo "<br><br>"; } 

                  if(!empty($tk)){ echo "<n class='text-danger'><b>Timekeeping Complaint</b> </n><br>"; }
                   foreach($tk as $c){ ?>
                        <?php echo '<a style="cursor:pointer;"  target="_blank" href="'.base_url().'employee_portal/employee_transactions/view/'.$c->doc_no.'/emp_time_complaint/HR025">'.$c->doc_no.'</a> ('.$c->status.')';?>
                  <?php } if(!empty($tk)){ echo "<br><br>"; } 

                  if(!empty($undertime)){ echo "<n class='text-danger'><b>Undertime</b> </n><br>"; }
                   foreach($undertime as $c){ ?>
                        <?php echo '<a style="cursor:pointer;"  target="_blank" href="'.base_url().'employee_portal/employee_transactions/view/'.$c->doc_no.'/emp_under_time/HR023">'.$c->doc_no.'</a> ('.$c->status.')';?>
              <?php  } if(!empty($undertime)){ echo "<br><br>"; } ?>

                          </td>
                        </tr>

        <?php } ?>
        </tbody>
      </table>
