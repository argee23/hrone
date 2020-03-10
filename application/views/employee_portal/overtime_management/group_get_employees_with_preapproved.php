 <?php echo "mila".$atro_option;?>
 <table class="table table-hover" id="overtimes">
                  <thead>
                      <tr class='danger'>
                        <th>No.</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Shift</th>
                       
                        <th><center><?php if($checker > 0){ echo "Hours"; } else{ ?><input type="text" id="hrs" style="width:50px;margin-left:20px;" placeholder="Hrs" onkeypress="return isNumberKey(this, event);" onkeyup="upd_hrs(this.value);"><?php } ?></center></th>
                         <th>Plotted By</th>
                        <th>Attendance</th>
                        <th>OT Hours Rendered</th>
                        <th>Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                   <?php $i=1; $string=""; foreach ($details as $ddd) {
                    $check_selected = $this->overtime_management_model->check_selected($ddd->employee_id,$date,$group,'approved');
                     if(empty($check_selected)){ $ss= ''; }
                     else
                     { 
                      if($check_selected->plotted_by==$this->session->userdata('employee_id'))
                        { $ss=""; } else{ $ss='disabled';  }
                    }       
                    ?>
                      <tr>

                        <td><?php echo $i?></td>
                        <td><?php echo $ddd->employee_id?></td>
                        <td><?php echo $ddd->fullname?></td>
                        <td> 
                            <?php
                               $shifft = $this->overtime_management_model->get_sched_grp_date($date,$ddd->employee_id); 
                                if(empty($shifft->shift_in) AND empty($shifft->shift_out))
                                  { echo "no work schedule plotted"; }
                                else
                                { echo $shifft->shift_in."-".$shifft->shift_out; }
                            ?> </td>
                        <td>
                          <center>
                          <input type="text" class="hrs_update" id="hrs_<?php echo $i?>" style='width:50px;text-align: center;' value='<?php echo $ddd->hours?>' onkeyup="hours_all(this.value,'<?php echo $i?>');" onkeypress="return isNumberKey(this, event);" <?php echo $ss;?>>
                          </center>
                        </td>
                         <td><?php echo $ddd->plotted_by?></td>
                        <?php
                        $month = 'attendance_'.date('m',strtotime($date));
                         $checker =   $this->overtime_management_model->get_attendance_by_date($date, $ddd->employee_id,$month);?>
                        <td><?php if(empty($checker)) { echo "No Attendance Yet"; } else{ echo $checker->time_in."-".$checker->time_out; }?> </td>
                        <td><?php  if(empty($checker->time_out) AND empty($shift_out)) { echo '0'; } else{ echo $checker->time_out - $shifft->shift_out; }?> </td>
                       
                          <?php if(empty($checker->time_in) || empty($checker->time_out)) { echo "<td class='default'>No attendance</td>"; } 
                          else{
                            $cc=  $checker->time_out - $shifft->shift_out;
                            if($cc==$ddd->hours){ echo "<td class='success'>plotted hours matched with the rendered OT</td>"; }
                            elseif($cc > $ddd->hours)
                            { 
                              $xx= $cc - $ddd->hours;
                              $x= $xx * 60;
                                echo "<td class='info'>OT hours rendered excess of ".$x." mins.</td>";
                            }
                            elseif($cc < $ddd->hours)
                            {
                                $xx= $ddd->hours - $cc;
                                $x= $xx * 60;
                                echo "<td class='warning'>OT hours rendered missing of ( ".$x." mins ).</td>";
                            }
                         } ?>
                   <?php $i++;  $dd = $ddd->employee_id."-";  $string .= $dd;  } echo "<input type='hidden' id='upt_count' value='".$i."'> "; ?>
                   </tr>
                  </tbody>
                </table>
                <input type="hidden" id="employee_value" value="<?php echo $string?>">
                <input type="hidden" id="date_value" value="<?php echo $date?>">
                <input type="hidden" id="group_value" value="<?php echo $group?>">
                
                <div class="col-sm-12">
                <button type="submit" class="col-md-2 btn btn-success pull-right" onclick="save_pre_approved_update();">Save Changes</button>
                </div>