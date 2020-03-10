<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

<form method="post" action="<?php echo base_url()?>app/payroll_incentive_leave/edit_enrollment_save/<?php echo $this->uri->segment("4"); ?>" >

<div class="col-md-12">
<a onclick="get_company_employee('<?php echo $company_info->company_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="View Enrolled Employee list"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a>
</div>

<div class="col-md-12">
<div id="search_here">
<table id="example1" class="table table-bordered table-striped">
<thead>
  <tr>
    <th>Emp. ID</th>
    <th>Employee Name</th>
    <th>Equivalent incentive leave</th>
    <th>Status</th>
    <th><a onclick="incentive_employee_add('<?php echo $company_info->company_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td><?php echo $incentive_employee_edit->employee_id?></td>
    <td><?php echo $incentive_employee_edit->first_name.' '.$incentive_employee_edit->middle_name.' '.$incentive_employee_edit->last_name ?></td>
    <td>
    	<select class="form-control" name="employee_equivalent" id="employee_equivalent">
		  <option selected="selected" value="<?php echo $incentive_employee_edit->equivalent_incentive_leave?>" disabled="">~<?php if($incentive_employee_edit->equivalent_incentive_leave === 'force_incentive_leave'){ echo 'force convert to incentive leave'; } else{ echo 'has an option'; } ?>~</option>
		  <option value="force_incentive_leave">Force to incentive leave</option>
		  <option value="has_an_option" >Has an option(OT pay or Incentive Leave)</option>
		</select>
    </td>
    <td>
    	Active
    </td>
    <td>
      <button type="submit" class="btn btn-danger btn-xs pull-right" ><i class="fa fa-check fa-lg"  data-toggle="tooltip" data-placement="right" title="Modify" ></i></button>
    </td>
  </tr>
<?php foreach($incentive_company_employee_edit as $employee){ ?>
  <tr>
    <td><?php echo $employee->employee_id?></td>
    <td><?php echo $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name ?></td>
    <td><?php if($employee->equivalent_incentive_leave === 'force_incentive_leave'){ echo 'force convert to incentive leave'; } else{ echo 'has an option'; }?></td>
    <td>
      <?php if($employee->InActive === '0'){ ?>
        <a href="<?php echo site_url('app/payroll_incentive_leave/inactivate_employee/'. $employee->employee_incentive_leave_id.''); ?>" onClick="return confirm('Are you sure you want to inactivate employee?')">
        <i  class="fa fa-power-off fa-lg" style="color:green;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Active"></i></a>
      <?php }
      if($employee->InActive === '1'){ ?>
        <a href="<?php echo site_url('app/payroll_incentive_leave/activate_employee/'. $employee->employee_incentive_leave_id.''); ?>" onClick="return confirm('Are you sure you want to activate employee?')">
        <i  class="fa fa-power-off fa-lg" style="color:red;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Inactive"></i></a>
      <?php } ?>
    </td>
    <td>
      <a  class="fa fa-times-circle fa-lg text-danger pull-right" data-toggle="tooltip" data-placement="right" title="Remove" href="<?php echo site_url('app/payroll_incentive_leave/remove_employee/'. $employee->employee_incentive_leave_id.''); ?>" onClick="return confirm('Are you sure you want to  remove employee?')"></a>
      <?php if($employee->InActive === '0'){ ?>
          <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="incentive_employee_edit('<?php echo $employee->employee_incentive_leave_id; ?>')"></i>
      <?php } ?>
    </td>
  </tr>
<?php }?>
</tbody>
</table>
</div>
</div>

</form>


<script>
$(function () {

  $("#example1").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false
  });
});
</script>




