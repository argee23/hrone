
<div>

          <div class="col-md-2"></div>

          <div class="col-md-8"> 
          <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/S10_save_approvers/<?php echo $company_id."/".$code;?>">

            <div class="col-md-12">
                <div class="col-md-6">
                <select class="form-control" id="department" required name="department">
                  <option value="" disabled selected>Select Department</option>
                  <?php if(empty($department)){ echo "<option value=''>No Department Found.</option>"; }
                  else{
                    echo "<option value='All'>All</option>";
                    foreach($department as $d){
                  ?>
                    <option value="<?php echo $d->department_id?>"><?php echo $d->dept_name;?></option>
                  <?php } }?>
                </select>
                </div>

                <div class="col-md-6">
                <select class="form-control" id="location" required name="location">
                 <option value="" disabled selected>Select Location</option>
                  <?php if(empty($location)){ echo "<option value=''>No Location Found.</option>"; }
                  else{
                    echo "<option value='All'>All</option>";
                    foreach($location as $d){
                  ?>
                    <option value="<?php echo $d->location_id?>"><?php echo $d->location_name;?></option>
                  <?php } }?>
                </select>
                </div>
            </div>

             <div class="col-md-12" style="margin-top: 10px;">
                <div class="col-md-3">
                <select class="form-control" id="set" name="set" required>
                  <option value="set">Set As</option>
                  <option value="align">Align On</option>
                </select>
                </div>

                <div class="col-md-3">
                <select class="form-control" id="num" required name="num">
                  <option value="" disabled selected>Select</option>
                  <?php if(empty($max_approver)){ echo "<option value=''>No setup for Maximum Number of Approver. Please add  first to continue.</option>"; }
                  else{
                      foreach($max_approver as $m){
                      $data = $m->data;
                      $x = 1; 
                      while($x <= $data) {
                        if($x=="1"){
                          $ext="st";
                        }else if($x=="3"){
                          $ext="rd";
                        }else if($x=="2"){
                          $ext="nd";
                        }else{
                          $ext="th";
                        }
                       ?>

                       <option value="<?php echo $x;?>"><?php echo $x.$ext;?></option>

                  <?php $x++; }} } ?>
                </select>
                </div>

                <div class="col-md-6">
                <select class="form-control"  id="approver" name="approver" required>
                  <option value="" disabled selected>Select Approver</option>
                  <?php foreach($approver_choices as $ap){?>
                      <option value="<?php echo $ap->employee_id;?>"><?php echo $ap->fullname;?></option>
                  <?php } ?>
                </select>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 10px;">
              <div class="col-md-12"><button type="submit" class="col-md-12 btn btn-success btn-sm">SAVE</button></div>
            </div>

            </form>
          </div>
          <div class="col-md-2"></div>



    <div class="col-md-12" style="margin-top: 30px;" id="approverlist">
        <table id="settings" class="table table-bordered table-striped">
            <thead>
              <tr class="danger">
                  <th>Department</th>
                  <th>Location</th>
                  <th>Employee ID</th>
                  <th>Employee Name</th>
                  <th>Approver Level</th>
                  <th>Approver Category</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($details as $d){?>
              <tr>
                  <td><?php echo $d->dept_name;?></td>
                  <td><?php echo $d->location_name;?></td>
                  <td><?php echo $d->employee_id;?></td>
                  <td><?php echo $d->fullname;?></td>
                  <td><?php 
                      $x=$d->approval_level;
                       if($x=="1"){
                            $ext="st";
                          }else if($x=="3"){
                            $ext="rd";
                          }else if($x=="2"){
                            $ext="nd";
                          }else{
                            $ext="th";
                          }
                        echo $d->approval_level.$ext." Approval "?></td>
                  <td><?php echo $d->approval_category;?></td>
                  <td>
                      
                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  onclick="action_setting10_action('delete','<?php echo $d->id;?>','<?php echo $d->company;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Approver'  ><i class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                            
                            <?php if($d->InActive==1)
                            {?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'   onclick="action_setting10_action('enable','<?php echo $d->id;?>','<?php echo $d->company;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Enable Approver'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } else{?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'   onclick="action_setting10_action('disable','<?php echo $d->id;?>','<?php echo $d->company;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Disable Approver'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                            <?php } ?>
                           
                  </td>
              </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

