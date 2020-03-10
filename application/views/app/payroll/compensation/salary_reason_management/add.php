<form method="post" action="<?php echo base_url()?>app/payroll_compensation/add_save/<?php echo $company_info->company_id; ?>" >

<div class="col-md-12">
	<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Title</th>
      <th>Description</th>
      <th>Status</th>
      <th><a onclick="salary_reason_add('<?php echo $company_info->company_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a></th>
    </tr>
  </thead>
  <tbody>
  	  <tr>
	      <td align="center" >
	        <input type="text" class="form-control" name="reason_title" id="reason_title" placeholder="Reason title" onchange="return trim(this)" required>
	      </td>
	      <td align="center" >
	      	<textarea name="reason_description" rows="5" cols="50" class="form-control" placeholder="Reason description" onchange="return trim(this)" required></textarea>
	      </td>
	      <td>Active</td>
	      <td>
	      <button type="submit" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-check fa-lg"  data-toggle="tooltip" data-placement="right" title="Save" ></i></button>
	      </td>
      </tr>
    <?php $check = false;
    foreach($company_reason as $company){ ?>
    <tr>
      <td><?php echo $company->reason_title; ?></td>
      <td><?php echo $company->reason_description; ?></td>
      <td>
        <?php if($company->InActive === '0'){ ?>
          <a href="<?php echo site_url('app/payroll_compensation/salary_reason_inactivate/'. $company->reason_id.''); ?>" onClick="return confirm('Are you sure you want to inactivate Salary Reason?')">
          <i  class="fa fa-power-off fa-lg" style="color:green;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Active"></i></a>
        <?php }
        if($company->InActive === '1'){ ?>
          <a href="<?php echo site_url('app/payroll_compensation/salary_reason_activate/'. $company->reason_id.''); ?>" onClick="return confirm('Are you sure you want to activate Salary Reason?')">
          <i  class="fa fa-power-off fa-lg" style="color:red;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Inactive"></i></a>
        <?php } ?>
      </td>
      <td>
        
          <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/payroll_compensation/salary_reason_delete/'. $company->reason_id.''); ?>" onClick="return confirm('Are you sure you want to permanently delete Salary Reason?')"></a>

        <?php if($company->InActive === '0'){ ?>
          <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="salary_reason_edit('<?php echo $company->reason_id; ?>')"></i>
        <?php } ?>
        
      </td>
    </tr>
    <?php $check = true; }
    if($check == false){?>
    <td>
      <p style="color:#ff0000;" class='text-center'><strong>No data yet.</strong></p>
    </td>
   <?php } ?>
  </tbody>
</table>
</div>

</form>