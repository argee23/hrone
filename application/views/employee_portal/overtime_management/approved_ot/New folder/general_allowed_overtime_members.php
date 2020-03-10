 <table class="table table-hover" id="overtime">
                  <thead>
                      <tr class='danger'>
                        <th><center><input type="checkbox" id="All" onclick="checkall_emp('All','All');" style="margin-left:20px;"></center></th>
                        <th><center><input type="number" id="hrs" style="width:50px;margin-left:20px;" onkeypress="return isNumberKey(this, event);" placeholder="Hrs" onkeyup="hours_all(this.value,'All');"></center></th>
                        <th><center>Employee ID</center></th>
                        <th><center>Employee Name</center></th>
                        <th><center>Section Name</center></th>
                        <th><center>Shift</center></th>
                        <th><center>Note</center></th>
                      </tr>
                    </thead>
                    <tbody>
                   
                    <?php $i= 1; $string =""; foreach ($group_members as $m) {
                         $stat = $this->overtime_management_section_mngr_approved_ot_model->checker_member($m->section,$m->subsection,$m->location,$this->session->userdata('employee_id'));
                          if($stat > 0)
                          {
                                $check_selected = $this->overtime_management_section_mngr_approved_ot_model->check_selected($m->employee_id,$date);
                                if(empty($check_selected->hours)){ $ot_hr = 0; $plotted_by = "";   } else { $ot_hr = $check_selected->hours; $plotted_by = $check_selected->plotted_by; }
                                $shifft = $this->overtime_management_section_mngr_approved_ot_model->get_sched_grp_date($date,$m->employee_id); 
                               
                                if(!empty($check_selected))
                                {
                                  echo "<tr style='color:red;'>
                                          <td><center><input type='checkbox' disabled></center></td>
                                          <td><center>".$ot_hr."</center></td>
                                          <td><center>".$m->employee_id."</center></td>
                                          <td><center>".$m->first_name.' '.$m->last_name."</center></td>
                                          <td><center>".$m->section_name."</center></td>
                                          <td><center>";
                                        if(empty($shifft->shift_in) AND empty($shifft->shift_out))
                                  { echo "no work schedule plotted"; }
                                else
                                  { echo $shifft->shift_in."-".$shifft->shift_out; } echo "</center></td>";
                                ?>
                                        <td><center>Plotted by <?php echo $plotted_by; if(!empty($check_selected->reason)){ echo '<br>Reason:'.$check_selected->reason; } ?><br></center></td>
                                </tr>
                                <?php }
                                else
                                {
                      ?>
                      <tr>
                        <td>
                            <center>
                              <input type="checkbox" name="checkall" id="id<?php echo $i?>"  onclick="checkall_emp(<?php echo $i?>,'<?php echo $m->employee_id?>');" class="selected" value="<?php echo $m->employee_id?>">
                            </center>
                        </td>
                        <td><center><input type="text" class="hrs_selected" name="hrs" id="hrs<?php echo $i?>" style='width:50px;' value='0' onkeyup="hours_all(this.value,'<?php echo $i?>');" onkeypress="return isNumberKey(this, event);"></center></td>
                        <td><center><?php echo $m->employee_id?></center></td>
                        <td><center><?php echo $m->fullname?></center></td>
                        <td><center><?php echo $m->section_name?></center></td>
                        <td>
                        <center>
                            <?php
                              
                              if(empty($shifft->shift_in) AND empty($shifft->shift_out))
                                { echo "no work schedule plotted"; }
                              else
                                { echo $shifft->shift_in."-".$shifft->shift_out; }
                            ?> 
                        </center>
                        </td>
                        <td><center>No Approved OT</center></td>
                     
                    <?php $i++; $dd = $m->employee_id."-";  $string .= $dd; 
            } } else{} } ?> 
                  <div style="display: none;">
                  <input type='text'   id="count_emp" value="<?php echo $i;?>">  
                  <input type="text"   id="employee_all" value="<?php echo $string;?>">
                  <input type="text"   id="selected_employee" value="">
                  <input type="text"   id="employee_i" value="">
                  <input type="text"   id="recheck_hrs" value="">
                  <input type="text"   id="reason_" value="">
                  </div>
                   </tr>
                  </tbody>
                </table>

                <br><br><br>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="email">Reason / Work To Accomplish</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="1" id="reason" name="reason"></textarea>
                    </div>
                </div>
          <br><br>

         <div class="form-group">
         
          <div class="col-sm-12">
          <button type="submit" class="col-md-2 btn btn-info pull-right" style="margin-left: 6px;">Home</button>
          <button type="submit" class="col-md-2 btn btn-success pull-right" onclick="save_pre_approved();">Submit</button>
          </div>
        
        </div>