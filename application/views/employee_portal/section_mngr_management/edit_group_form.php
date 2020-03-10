<div class="col-sm-3" style="padding-top: 10px;">
  <div class="box box-solid box-default">
    <h4><center>Group Members</center></h4>
     
  <div class="col-md-12"> <div class="box box-danger" class='col-md-12'></div></div>
     <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">
     <div class="box-body">
      <table class="table table-user-information">
        <tbody>
          <?php foreach($data[10] as $d){?>
            <tr ng-repeat="m in members">
              <td><?php echo $d->employee_id;?></td>
              <td class="text-info"><strong><?php echo $d->first_name." ".$d->last_name;?></strong></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    </div>
	</div>
  </div>
</div>

<div class='col-md-9' style="padding-top: 10px;">
   <div class="box box-solid box-default">
      <div class="box body-panel" style="height:700px;">
      		<div class="col-md-12" id="employee_list">
           <h3 class="text-danger"><u><center>Update <?php echo $data[0];?></center></u></h3>
     
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

                $if_fixed = $this->section_mngr_management_model->check_if_enrolled_in_fixed($emp->employee_id);
                $if_flexi = $this->section_mngr_management_model->check_if_enrolled_in_flexi($emp->employee_id);
                $allowed_loc =  $this->section_mngr_management_model->checker_employee_loc($emp->employee_id);
                if($allowed_loc == 0){} else{
                ?>
                <tr <?php if($note=='no group yet'){ } else if($data[7] == $sec){} else{ echo "class='success'"; }?>>
                  <td><?php  if($note=='no group yet' AND $data[7]!=$sec){?> <input type='hidden' id='e_<?php echo $emp->employee_id;?>' value='0'><input type="checkbox" value="<?php echo $emp->employee_id?>" id="emp_<?php echo $i;?>" onclick="add_emp_selected('<?php echo $i;?>','<?php echo $emp->employee_id;?>');"> <?php } elseif($data[7]==$sec){?>
                  <input type='hidden' id='e_<?php echo $emp->employee_id;?>' value='1'><input type="checkbox" value="<?php echo $emp->employee_id?>" id="emp_<?php echo $i;?>" onclick="add_emp_selected('<?php echo $i;?>','<?php echo $emp->employee_id;?>');" checked> 
                  <?php }  else{}?></td>
                  <td><?php echo $emp->employee_id.$allowed_loc;?></td>
                  <td><?php echo $emp->first_name." ".$emp->last_name;?></td>
                  <td><?php echo $emp->location_name;?></td>
                  <td><?php echo $emp->position_name;?></td>
                  <td><?php echo $emp->classification_name;?></td> 
                  <td><?php echo $note;?></td>
                </tr>
              <?php $i = $i+1; } } ?>
              </tbody>
            </table>
          </div>

        <div class="col-md-3"><label class="text-danger">Group Name : </label></div>
        <div class="col-md-8">
            <input type="text" name="group" id="group" class="form-control" value="<?php echo $data[0];?>" required>
            <input type="hidden" value="<?php echo $employee_selected;?>" id="selected_employee" class="form-control" required>
            <input type="hidden" name="section" id="section" value="<?php echo $data[8];?>">
            <input type="hidden" name="subsection" id="subsection" value="<?php echo $data[9];?>" required>
            <input type="hidden" name="department" id="department" value="<?php echo $data[6];?>">
            <input type="hidden" name="division" id="division" value="<?php echo $data[5];?>" required>
            <input type="hidden" name="has_division" id="has_division" value="<?php echo $data[4];?>" required>
            <input type="hidden"  id="group_final" value="" required>
            <input type="hidden"  id="group_id" value="<?php echo $data[7];?>" required>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
           <button type="submit" class="btn btn-success pull-right" style="margin-left:10px;" onclick="save_updated_group();">SAVE CHANGES</button>
            <button class="btn btn-danger pull-right" style="margin-left:10px;" onclick="window.location.reload()">BACK</button>
            <button class="btn btn-info pull-right" style="margin-left:10px;display: none;" onclick="review_selected_emp('review_selected_emp');">REVIEW SELECTED EMPLOYEE</button>
        </div>

			</div>
	  </div>
	</div>