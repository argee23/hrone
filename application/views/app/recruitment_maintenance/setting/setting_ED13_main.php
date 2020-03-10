
<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/ED13_save_approver/<?php echo $company_id."/".$code;?>">

  <div class="col-md-3"></div>
    <div class="col-md-6">
        <select class="form-control" name="employee_id" id="employee_id">
            <option value="" disabled selected>Select Employee</option>
            <?php foreach($employee_list as $emp){?>
                  <option value="<?php echo $emp->employee_id;?>"><?php echo "(".$emp->employee_id.") ".$emp->fullname;?></option>
            <?php } ?>  
        </select>
        <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;"> SAVE </button>
    </div>
  <div class="col-md-3"></div>  

</form>

<div class="col-md-12" style="margin-top:10px;">

      <table class="table table-hover" id="settings">
          <thead>
              <tr class="danger">
                  <th>No</th>
                  <th>Employee ID</th>
                  <th>Employee Name</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
          <?php foreach($employees as $emp){?>
              <tr>
                  <td><?php echo $emp->id;?></td>
                  <td><?php echo $emp->employee_id;?></td>
                  <td><?php echo $emp->fullname;?></td>
                  <td>
                     <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'   onclick="action_appprover_choices('delete','<?php echo $company_id;?>','<?php echo $code;?>','<?php echo $emp->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Approver Choices'><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                    <?php if($emp->InActive==1)
                    {?>
                     <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'   onclick="action_appprover_choices('enable','<?php echo $company_id;?>','<?php echo $code;?>','<?php echo $emp->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Enable Approver Choices'><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                    <?php } else{?>
                     <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'   onclick="action_appprover_choices('disable','<?php echo $company_id;?>','<?php echo $code;?>','<?php echo $emp->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Disable Approver Choices'><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                    <?php } ?>
                  </td>
              </tr>
          <?php } ?>
          </tbody>
      </table>

  </div>

