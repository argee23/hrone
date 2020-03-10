<div class="col-md-12">
      <?php  if($employee_list=='no_setting'){?>
        <div class="jumbotron" style="margin-top: 25px;">
            <center><h2 class="text-danger">Warning: No setting.</h2> <h3>Please advise admin to set up the <br>ADMINISTRATOR -> SECTION MANGER -> BY CLASSIFICATION/LEVEL setting</h3></center>
        </div>

      <?php } else{?>
      
        <div class="col-md-12" >
           <h3><center>Employee List</center></h3>
          <div class="col-md-12" id="review_selected_emp">

          </div>
        <div class="col-md-12" style=" height:500px;overflow-y: scroll;">
            <table class="table table-hover" id='grp'>
              <thead>
                <tr class="danger">
                  <th></th>
                   <th>Employee id</th>
                  <th>Name</th>
                  <th>Location</th>
                  <th>Position</th>
                  <th>Classification</th>
                  <th>Notes</th>
                </tr>
              </thead>
              <tbody>
              <?php  $i=0; foreach($employee_list as $emp){ 
                $admin =$emp->admin_group_id;
                $sec = $emp->sec_group_id;

                $if_fixed = $this->section_mngr_management_model->check_if_enrolled_in_fixed($emp->employee_id);
                $if_flexi = $this->section_mngr_management_model->check_if_enrolled_in_flexi($emp->employee_id);

                if(empty($admin) AND empty($sec)) { $note = 'no group yet'; }
                else if(!empty($admin))
                {
              
                  $check = $this->section_mngr_management_model->check_emp_availability($admin,'working_schedule_group_by_administrator');
                  if(empty($check)){ $note=''; }else{   $note = $check->group_name."/".$check->manager_in_charge;  }
                
                }
                else if(!empty($sec))
                {
                    $check = $this->section_mngr_management_model->check_emp_availability($sec,'working_schedule_group_by_sec_manager');
                   if(empty($check)){ $note='';  }else{   $note = $check->group_name."/".$check->manager_in_charge;  }
                }
                else
                {
                  $note='';
                }
                ?>
                  <tr <?php if($note=='no group yet' || $emp->employee_id==$this->session->userdata('employee_id')){ } else{ echo "class='success'"; }?>>
                  <td>
                    <?php  
                          if(!empty($if_flexi))
                          {?>
                              <n class='text-danger'><i>Enrolled in flexi schedule under group - <?php echo $if_flexi->group_name;?></i></n>
                          <?php }
                          else if(!empty($if_fixed))
                          {?>
                              <n class='text-danger'><i>Enrolled in fixed schedule under group - <?php echo $if_fixed->group_name;?></i></n>
                          
                          <?php }
                          else if($note=='no group yet' AND $emp->employee_id!=$this->session->userdata('employee_id')){?> 
                              <input type='hidden' id='e_<?php echo $emp->employee_id;?>' value='0'>
                              <input type="checkbox" class="class_input" value="<?php echo $emp->employee_id?>" id="emp_<?php echo $i;?>" onclick="add_emp_selected('<?php echo $i;?>','<?php echo $emp->employee_id;?>');"> 
                           <?php } 
                          
                           elseif($emp->employee_id==$this->session->userdata('employee_id')){ 
                              if(!empty($plot_own_setting) AND $plot_own_setting==1)
                              {?>
                                <input type='hidden' id='e_<?php echo $emp->employee_id;?>' value='0'>
                                <input type="checkbox" class="class_input" value="<?php echo $emp->employee_id?>" id="emp_<?php echo $i;?>" onclick="add_emp_selected('<?php echo $i;?>','<?php echo $emp->employee_id;?>');">
                              <?php }
                              else
                              {
                                echo "<n class='text-danger'><i>you're not allowed to plot your own schedule</i></n>"; 
                              }
                           }
                           else{}?>
                  </td>
                  <td><?php echo $emp->employee_id;?></td>
                  <td><?php echo $emp->first_name." ".$emp->last_name;?></td>
                  <td><?php echo $emp->location_name;?></td>
                  <td><?php echo $emp->position_name;?></td>
                  <td><?php echo $emp->classification_name;?></td>
                  <td><?php echo $note;?></td>
                </tr>
              <?php if($note=='no group yet'){ $i=$i+1; } else{  $i = $i+0; } } echo "<input type='text' style='display:none;' id='count_class' value='".$i."'>";?>
              </tbody>
            </table>
            </div>
        </div>

        <div class="col-md-3"><label class="text-danger">Group Name : </label></div>
        <div class="col-md-8">
            <input type="text" name="group" id="group" class="form-control" required>
            <input type="hidden" name="selected_employee" id="selected_employee" class="form-control" required>
            <input type="hidden" name="section" id="section" value="<?php echo $section;?>">
            <input type="hidden" name="subsection" id="subsection" value="<?php echo $subsection;?>" required>
            <input type="hidden" name="department" id="department" value="<?php echo $department;?>">
            <input type="hidden" name="division" id="division" value="<?php echo $division;?>" required>
            <input type="hidden" name="has_division" id="has_division" value="<?php echo $has_division;?>" required>
            <input type="hidden"  id="group_final" value="" required>
            <input type="hidden"  id="check_uncheck" value="0">
        </div>
  
      
      <?php } ?>
   
</div>


<div class="col-md-12" style="margin-top:20px;">
  <div class="col-md-12" id="updmembers">
        <button type="submit" class="btn btn-success pull-right" style="margin-left:10px;" onclick="save_group();">SAVE</button>
        <button type="submit" class="btn btn-warning pull-right" style="margin-left:10px;" onclick="check_uncheck();">CHECK|UNCHECK ALL</button>
        <button class="btn btn-danger pull-right" style="margin-left:10px;" onclick="window.location.reload()">BACK</button>
        <button class="btn btn-info pull-right" style="margin-left:10px;display: none;" onclick="review_selected_emp('review_selected_emp');">REVIEW SELECTED EMPLOYEE</button>
  </div>
  <div class="col-md-12" id='loader' style="display: none;"> <h5 class="text-info pull-right"><label><div class="loader" style="height: 20px;width: 20px;"></div>L O A D I N G . .</label></h5></div>

</div>