 
<div class="col-md-12">
    <div class="col-md-5">
        <div class="col-md-12"><n class='text-danger'><center>Company :</center> </n></div>
        <div class="col-md-12"><u><center><?php echo $details->company_name?><input type="hidden" value="<?php echo $details->company_id?>" id="company_upd"></center></u></div>
    </div>
    <div class="col-md-4">
        <div class="col-md-12"><n class='text-danger'><center>Group Name :</center> </n></div>
        <div class="col-md-12"><input type='text' id="group_upd" class="form-control" value="<?php echo $details->group_name?>"><input type="hidden" id="group_f"></div>
    </div>
    <div class="col-md-3">
        <div class="col-md-12"><n class='text-danger'><center>Policy Type : </center></n></div>
        <div class="col-md-12"><u><center><?php echo $details->cValue?><input type="hidden" value="<?php echo $details->policy_type?>" id="policy_upd"></center></u></div>
    </div>
</div><br><br><br>
 <div class="box box-danger" class='col-md-12'></div>
 <br>
 <table class="table table-bordered" id="blocked_leave"  style="margin-top:20px;">
    <thead>
        <tr class="success">
            <th style="width: 5%;"></th>
            <th style="width: 10%;">Name</th>
            <th style="width: 20%;">Name</th>
            <th style="width: 25%;">Company </th>
            <th style="width: 20%;">Department</th>
            <th style="width: 20%;">Section</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($group_details as $gd) {?>
        <tr>
          <td><input type="checkbox" class="empp_value" id="c<?php echo $gd->employee_id?>" onclick="for_emp_upd(<?php echo $gd->employee_id?>);" checked></td>
            <td><?php echo $gd->employee_id?></td>
          <td><?php echo $gd->name?></td>
          <td><?php echo $gd->company_name?></td>
          <td><?php echo $gd->dept_name?></td>
          <td><?php echo $gd->section_name?></td>
         
        </tr>
    <?php } 
      foreach ($employees as $emp) {?>
        <tr>
          <td><input type="checkbox" class="empp_value" id="c<?php echo $emp->employee_id?>" onclick="for_emp_upd(<?php echo $emp->employee_id?>);"></td>
           <td><?php echo $emp->employee_id?></td>
          <td><?php echo $emp->name?></td>
          <td><?php echo $emp->company_name?></td>
          <td><?php echo $emp->dept_name?></td>
          <td><?php echo $emp->section_name?></td>
        </tr>
    <?php }?>

   </tbody>
 </table>

<button class="btn btn-danger pull-right" onclick="policy_group_details(<?php echo $group?>);">BACK</button>
<button class="btn btn-success pull-right" onclick="save_updated_group_policy(<?php echo $group?>);" style='margin-right:10px;'>SAVE CHANGES</button>

<input type="hidden" id="selected_emp" value="<?php echo $selected_emp?>" class="form-control">
