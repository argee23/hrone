
    <div class="col-md-12"><center><h4><b>Update Group Member/s</b></h4></center></div>
      <div class="col-md-12" id='t_show' style="height:320px;display:none;" >
          <h3 class="text-danger"><center>Selected Employee</center></h3>
          <div id="mmmmmm" style="height:200px;overflow-y: auto;">
         
          </div>
      </div>
        <table class="table table-bordered" id="enroll_employee_grp">
          <thead>
           <tr  class="success">
              <th style="width:10%;">Emp ID</th>
              <th style="width:15%;">Name</th>
              <th style="width:20%;">Department</th>
              <th style="width:20%;">Section</th>
              <th style="width:10%;">Location</th>
              <th style="width:10%;">Classification</th>
              <th style="width:8%;">Payroll Period Group</th>
              <th>Note</th>
              <td style="width:7%;">Action</td>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; foreach ($company_employees as $gm) {
              $exist = $this->plot_schedules_model->checker_if_already_exist($gm->employee_id,$group);
              $pp = $this->plot_schedules_model->emp_get_payroll_period($gm->employee_id);
              $name = $gm->first_name." ".$gm->last_name;?>
                <tr>
                  <td> <?php echo $gm->employee_id;?><input type="text" style='display:none;' id="c_<?php echo $i?>" value="<?php if($exist=='member'){ echo '1'; } else{ echo '0'; } ?>"></td>
                  <td><?php echo $name?></td>
                  <td><?php echo $gm->dept_name?></td>
                  <td><?php echo $gm->section_name?></td>
                  <td><?php echo $gm->location_name?></td>
                  <td><?php echo $gm->cname?></td>
                  <td><?php if(empty($pp)){ echo "no group yet"; } else{ echo $pp->group_name; }?> </td>
                  <td>
                      <?php  if($exist=='member'){ ?> 
                          <n class='text-info'>member already</n> 
                      <?php } elseif($exist=='exist'){ ?>
                          <n class='text-danger'>member in other admin group</n> 
                      <?php } elseif($exist=='exist_sm'){ ?>
                          <n class='text-danger'>member in section manager/s group</n> 
                      <?php } elseif($exist=='fixed'){?>
                          <n class='text-success'>enrolled in fixed schedule</n>
                      <?php } elseif($exist=='flexi'){?>
                      <n class='text-success'>enrolled in flexi schedule</n>
                      <?php } elseif(empty($pp)){ echo " <n class='text-danger'>no payroll period group</n>"; } else{ ?>  <n class='text-success'>no group yet</n>  <?php } ?></td>
                  <td>
                       <?php  if($exist=='member'){ ?> 
                          <input type="checkbox" value="<?php echo $gm->employee_id?>" id="c<?php echo $i?>" onclick="enrol_employee_action('<?php echo $i?>','<?php echo $gm->employee_id?>','<?php echo $pp->payroll_period_group_id?>');" checked >
                        <?php } elseif($exist=='exist') {
                           $gp = $this->plot_schedules_model->group_name($gm->employee_id,'admin');
                           echo "<a style='cursor:pointer'; >".$gp->group_name."</a>";
                        } elseif($exist=='exist_sm') { 
                          $gp = $this->plot_schedules_model->group_name($gm->employee_id,'sm');
                           echo "<a style='cursor:pointer'; >".$gp->group_name."</a>";
                        } elseif($exist=='fixed'){
                          $gp = $this->plot_schedules_model->group_name($gm->employee_id,'fixed');
                           echo "<a style='cursor:pointer'; >".$gp->group_name."</a>";
                         } elseif($exist=='flexi'){ 
                          $gp = $this->plot_schedules_model->flexi($gm->employee_id);
                          echo "<a style='cursor:pointer'; >".$gp->group_name."</a>";
                          }  elseif(empty($pp)){echo "--";} else { ?> 
                           <input type="checkbox" value="<?php echo $gm->employee_id?>" id="c<?php echo $i?>" onclick="enrol_employee_action('<?php echo $i?>','<?php echo $gm->employee_id?>','<?php echo $pp->payroll_period_group_id?>');"> 
                        <?php   }  ?>
                  </td>
                </tr>
            <?php $i++; } echo "<input type='hidden' id='count_emp' value='".$i."'>";?>
          </tbody>
      </table>

      <input type="text"  id="checker_pp" style="display: none;" value="<?php echo $ppp;?>">
      <input type="text"  name="selected_load_emp" style="display:none;" id="selected_load_emp" value="<?php echo $grp_employees?>" class="form-control">
      <div class="col-md-12" id="save_btn">
      <button class="btn btn-info pull-right" style="margin-left:5px;" onclick="enrol_employees('<?php echo $group?>','<?php echo $company?>')">BACK</button>

        <button class="btn btn-danger pull-right" style="margin-left:5px;" onclick="view_emp_selected();">VIEW SELECTED</button>
        <button class="btn btn-success pull-right" onclick="admin_update_members_group('<?php echo $group ?>','<?php echo $company?>');">SAVE CHANGES</button>
      </div>
      <br><br><br>
       <div class="box box-default" class='col-md-12'></div></div>
