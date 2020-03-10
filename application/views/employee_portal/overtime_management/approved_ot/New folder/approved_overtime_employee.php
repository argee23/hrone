
<table class="table table-hover" id="details">
    <thead>
        <tr class="default">
            <th>No.</th>
            <th>Employee ID</th>
            <th>OT Hours</th>
            <th>Shift</th>
            <th>Attendance</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
      <?php $i=1; foreach($plotted as $p){
         $attendance = $this->overtime_management_section_mngr_approved_ot_model->get_employee_attendance($p->employee_id,$p->date);
      ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><center><?php echo $p->employee_id.' <br>('.$p->first_name.' '.$p->last_name.')'; ?></center></td>
            <td><?php echo $p->hours; ?></td>
            <td>
               
               <?php
                    $datef = $p->date;
                    $m =  date("m", strtotime($datef));
                    $yy =  date("Y", strtotime($datef));
                    
                                $individual_schedules = $this->reports_personnel_schedule_model->get_individual_schedules($p->employee_id,$datef,$m,$yy);
                                if(!empty($individual_schedules))
                                {
                                  $schedule_result=$individual_schedules;
                                  $schedule_type="individual";
                                }
                                else
                                {
                                  $fixed_schedules = $this->reports_personnel_schedule_model->checker_if_fixed_sched($p->employee_id,$datef);
                                  if(!empty($fixed_schedules))
                                  {
                                    $schedule_result=$fixed_schedules;
                                     $schedule_type="fixed";
                                  }
                                  else
                                  {
                                      $group_schedules = $this->reports_personnel_schedule_model->checker_if_group_sched($p->employee_id,$datef);
                                      if(!empty($group_schedules))
                                      {
                                        $schedule_result=$group_schedules;
                                         $schedule_type="group";
                                      }
                                      else
                                      {
                                        $schedule_result="";
                                         $schedule_type="no_schedule";
                                      }
                                  }
                                }

                                if(!empty($schedule_result))
                                        {
                                          $schedule="";
                                          foreach($schedule_result as $sched)
                                          {
                                           
                                            if($schedule_type=='fixed')
                                            {  
                                              $day  =  date("D", strtotime($datef)); 
                                              $day_ =  strtolower($day);
                                              if($day_=='restday'){  $schedule = 'restday'; } else {  $schedule = $sched->$day_; }
                                            }
                                            else
                                            {   
                                               if($sched->restday==1)
                                                { $schedule = "restday"; } else{  $schedule=$sched->shift_in.' to '.$sched->shift_out; }
                                            }
                                          } 
                                        }
                                        else
                                        {
                                          $schedule =" No Plotted Schedule";
                                        }
                                echo $schedule;

               ?>   

            </td>
            <td>
                <?php if(!empty($attendance)){ foreach($attendance as $a){ if(!empty($a->time_in)){ echo "<b>&nbsp;IN &nbsp;&nbsp;&nbsp;&nbsp;: </b> ".$a->time_in; } echo "<br>"; if(!empty($a->time_out)){ echo "<b>&nbsp;OUT :</b> ".$a->time_out; } } } else { } ?>
            </td>
            <td>
                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick='delete_approved_ot_member("<?php echo $p->a_i;?>","<?php echo $id;?>","<?php echo $p->date;?>")' aria-hidden='true' data-toggle='tooltip' title='Click to Delete OT Hours'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
            </td>
        </tr>
      <?php $i++; } ?>
    </tbody>
</table>