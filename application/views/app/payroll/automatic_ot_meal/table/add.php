<form method="post" action="<?php echo base_url()?>app/payroll_automatic_ot_meal/add_save/<?php echo $company_info->company_id; ?>" >
  <div class="col-md-12">
  	<table id="ot_allowance_add" class="table table-bordered table-striped">
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
        <td align="center" >
        <select class ="form-control" name="ot_type" required>
          <option selected="selected" disabled>~select a ot type~</option>
          <?php foreach ($otTypeList as $otType):?>
           <option value="<?php echo $otType->param_id; ?>"><?php echo $otType->cValue; ?></option>
          <?php endforeach?>
        </select>
        </td>
        <td align="center" >
        <select class="form-control" data-live-search="true" name="locationselected[]" id="location_add" multiple data-selected-text-format="count>2" required>
          <option value="all">~select all~</option>
          <?php foreach ($locationList as $location):?>
           <option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
          <?php endforeach?>
        </select>
        </td>
        <td align="center" >
        <select class ="form-control" name="classification" required>
          <option selected="selected" value="" disabled>~select a classification~</option>
          <?php foreach ($classificationList as $class):?>
           <option value="<?php echo $class->classification_id; ?>"><?php echo $class->classification; ?></option>
          <?php endforeach?>
        </select>
        </td>
        <td align="center" >
        <select class ="form-control" name="emp_type" required>
          <option selected="selected" value="" disabled>~select a employment~</option>
          <?php foreach ($employmentList as $emp):?>
           <option value="<?php echo $emp->employment_id; ?>"><?php echo $emp->employment_name; ?></option>
          <?php endforeach?>
        </td>
        <td align="center" >
          <input type="number" name="every_hour" id="every_hour_add" class="form-control" placeholder="0" step="0.125" value="" required>
        </td>
        <td align="center" >
          <input type="number" name="from_hour" id="from_hour_add" class="form-control" placeholder="00.00" step="0.125" value="" required>
        </td>
        <td align="center" >
          <input type="number" name="to_hour" id="to_hour_add" class="form-control" placeholder="00.00" step="0.125" value="" required>
        </td>
        <td align="center" >
          <input type="number" name="amount" class="form-control" placeholder="00.00" step="0.125" value="" required>
        </td>
        <td>
          Active
        </td>
        <td>
          <button type="submit" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-check fa-lg"  data-toggle="tooltip" data-placement="right" title="Save" ></i></button>
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
            <a href="<?php echo site_url('app/payroll_incentive_leave/incentive_leave_inactivate/'. $company->id.''); ?>" onClick="return confirm('Are you sure you want to inactivate incentive leave credit?')">
            <i  class="fa fa-power-off fa-lg" style="color:green;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Active"></i></a>
          <?php }
          if($company->InActive === '1'){ ?>
            <a href="<?php echo site_url('app/payroll_incentive_leave/incentive_leave_activate/'. $company->id.''); ?>" onClick="return confirm('Are you sure you want to activate incentive leave credit?')">
            <i  class="fa fa-power-off fa-lg" style="color:red;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Inactive"></i></a>
          <?php } ?>
        </td>
        <td></td>
      </tr>
     <?php } ?>
    </tbody>
  </table>
  </div>
</form>