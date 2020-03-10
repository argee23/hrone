<form method="post" action="<?php echo base_url()?>app/payroll_incentive_leave/edit_save/<?php echo $this->uri->segment("4"); ?>" >

<?php
    $not_allowed            = array();
    $index_not_allowed      = 0;

    foreach($company_table_edit as $company){
      for($index_start=$company->start_ot_hour; $index_start <= $company->end_ot_hour; $index_start++){
        $not_allowed[$index_not_allowed] = $index_start;
        $index_not_allowed++;
      }
      
    }
    $allowed  = array();
    $index_allowed  = 0;
    for($value=1;$value<=24;$value++){
      $check = false;
      for($index = 0; $index < count($not_allowed); $index++){
        if($value == $not_allowed[$index]){
          $check = true;
        }
      }
      if($check == false){
        $allowed[$index_allowed] = $value;
        $index_allowed++;
      }
    }
?>

<div class="col-md-12">
	<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Start of OT Hour</th>
      <th>End of OT Hour</th>
      <th>Equivalent of Incentive Credit</th>
      <th>Status</th>
      <th><a onclick="credit_table_add('<?php echo $company_info->company_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a></th>
    </tr>
  </thead>
  <tbody>
      <tr>
      <td align="center" >
        <input type="text" class="form-control" name="start_ot_hour" id="start_ot_hour" placeholder="00.00" step="0.125" value="<?php echo $incentive->start_ot_hour; ?>">
      </td>
      <td align="center" >
        <input type="text" class="form-control" name="end_ot_hour" id="end_ot_hour"  placeholder="00.00" step="0.125" value="<?php echo $incentive->end_ot_hour; ?>">
      </td>
      <td align="center" >
        <input type="number" name="equivalent_incentive_credit" class="form-control" p placeholder="00.00" step="0.125" value="<?php echo $incentive->equivalent_incentive_credit; ?>" required>
      </td>
      <td>Active</td>
      <td>
      <button type="submit" class="btn btn-danger btn-xs pull-right" ><i class="fa fa-check fa-lg"  data-toggle="tooltip" data-placement="right" title="Modify" ></i></button>
      </td>
      </tr>
    <?php $check = false;
    foreach($company_table as $company){ ?>
    <tr>
    <?php if($company->incentive_leave_id != $this->uri->segment("4")){ ?>
      <td><?php echo $company->start_ot_hour; ?></td>
      <td><?php echo $company->end_ot_hour; ?></td>
      <td><?php echo $company->equivalent_incentive_credit; ?></td>
      <td>
        <?php if($company->InActive === '0'){ ?>
          <a href="<?php echo site_url('app/payroll_incentive_leave/incentive_leave_inactivate/'. $company->incentive_leave_id.''); ?>" onClick="return confirm('Are you sure you want to inactivate incentive leave credit?')">
          <i  class="fa fa-power-off fa-lg" style="color:green;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Active"></i></a>
        <?php }
        if($company->InActive === '1'){ ?>
          <a href="<?php echo site_url('app/payroll_incentive_leave/incentive_leave_activate/'. $company->incentive_leave_id.''); ?>" onClick="return confirm('Are you sure you want to activate incentive leave credit?')">
          <i  class="fa fa-power-off fa-lg" style="color:red;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Inactive"></i></a>
        <?php } ?>
      </td>
      <td>
        
         <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/payroll_incentive_leave/incentive_leave_delete/'. $company->incentive_leave_id.''); ?>" onClick="return confirm('Are you sure you want to permanently delete incentive leave credit?')"></a>

        <?php if($company->InActive === '0'){ ?>
          <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="incentive_table_edit('<?php echo $company->incentive_leave_id; ?>')"></i>
        <?php } ?>
        
      </td>
    </tr>
    <?php $check = true; 
      }
    }
    if($check == false){?>
    <td>
      <!-- <p style="color:#ff0000;" class='text-center'><strong>No data yet.</strong></p> -->
    </td>
   <?php } ?>
  </tbody>
</table>
</div>

</form>