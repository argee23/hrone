<div class="col-md-12">
	<table id="ot_allowance_edit" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>OT Type</th>
      <th>Location</th>
      <th>Classification</th>
      <th>Employement Type</th>
      <th>Number of Hour</th>
      <th>Start</th>
      <th>End</th>
      <th>Amount</th>
      <th>Status</th>
      <th><a onclick="get_company_table('<?php echo $company_info->company_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Cancel"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a></th>
    </tr>
  </thead>
  <tbody>
      <tr>        
        <td>
          <select class ="form-control" name="ot_type_edit" id="ot_type_edit" required>
            <option value="<?php echo $ot_meal->param_id; ?>" selected="selected" disabled><?php echo $ot_meal->cValue; ?></option>
            <?php foreach ($otTypeList as $otType):?>
            <option value="<?php echo $otType->param_id; ?>"><?php echo $otType->cValue; ?></option>
            <?php endforeach?>
          </select>
        </td>
        <td align="center" >
          <select class ="form-control" name="location_edit" id="location_edit" required>
            <option value="<?php echo $ot_meal->location_id; ?>" selected="selected" disabled><?php echo $ot_meal->location_name; ?></option>
            <?php foreach ($locationList as $location):?>
             <option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
            <?php endforeach?>
          </select>
        </td>
        <td align="center" >
          <select class ="form-control" name="classification_edit" id="classification_edit" required>
             <option value="<?php echo $ot_meal->classification_id; ?>" selected="selected" disabled><?php echo $ot_meal->classification; ?></option>
            <?php foreach ($classificationList as $class):?>
             <option value="<?php echo $class->classification_id; ?>"><?php echo $class->classification; ?></option>
            <?php endforeach?>
          </select>
        </td>
        <td align="center" >
          <select class ="form-control" name="emp_type_edit" id="emp_type_edit" required>
            <option value="<?php echo $ot_meal->employment; ?>" selected="selected" disabled><?php echo $ot_meal->employment_name; ?></option>
            <?php foreach ($employmentList as $emp):?>
             <option value="<?php echo $emp->employment_id; ?>"><?php echo $emp->employment_name; ?></option>
            <?php endforeach?>
          </select>
        </td>
        <td align="center" >
          <input type="number" name="every_hour_edit" id="every_hour_edit" class="form-control" value="<?php echo $ot_meal->every_hour; ?>" required>
        </td>
        <td align="center" >
          <input type="number" name="from_hour_edit" id="from_hour_edit" class="form-control" value="<?php echo $ot_meal->from_hour; ?>" required>
        </td>
        <td align="center" >
          <input type="number" name="to_hour_edit" id="to_hour_edit" class="form-control" value="<?php echo $ot_meal->to_hour; ?>" required>
        </td>
        <td align="center" >
          <input type="number" name="amount_edit" id="amount_edit" class="form-control" value="<?php echo $ot_meal->amount; ?>" required>
        </td>
        <td>
          Active
        </td>
        <td>
          <button id="save_edit_ot_meal" class="btn btn-danger btn-xs pull-right" ><i class="fa fa-check fa-lg"  data-toggle="tooltip" data-placement="right" title="Modify" ></i></button>
        </td>
      </tr>
    <?php foreach($company_table as $company){ ?>
    <tr>
      <td><?php echo $company->cValue; ?></td>
      <td><?php echo $company->location_name; ?></td>
      <td><?php echo $company->classification; ?></td>
      <td><?php echo $company->employment_name; ?></td>
      <td><?php echo $company->every_hour; ?></td>
      <td><?php echo $company->from_hour; ?></td>
      <td><?php echo $company->to_hour; ?></td>
      <td><?php echo $company->amount; ?></td>
      <td>
        <?php if($company->InActive === '0'){ ?>
          <a href="<?php echo site_url('app/payroll_automatic_ot_meal/ot_meal_inactivate/'. $company->id.''); ?>" onClick="return confirm('Are you sure you want to inactivate incentive leave credit?')">
          <i  class="fa fa-power-off fa-lg" style="color:green;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Active"></i></a>
        <?php }
        if($company->InActive === '1'){ ?>
          <a href="<?php echo site_url('app/payroll_automatic_ot_meal/ot_meal_activate/'. $company->id.''); ?>" onClick="return confirm('Are you sure you want to activate incentive leave credit?')">
          <i class="fa fa-power-off fa-lg" style="color:red;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Inactive"></i></a>
        <?php } ?>
      </td>
      <td></td>
    </tr>
   <?php } ?>
  </tbody>
</table>
</div>