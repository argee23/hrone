<div class="col-md-12">
<table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>EMPLOYEE ID</th>
        <th>EMPLOYEE NAME</th>
        <th>GROUP NAME</th>
        <th>GROUP TYPE</th>
        <th>STATUS</th>
      </tr>
    </thead>
  <tbody>
  <?php foreach($employee_flexi as $employee){ ?>
  <tr>
    <td><?php echo $employee->employee_id; ?></td>
    <td><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
      <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
    </td>
    <td><?php echo $employee->group_name; ?></td>
    <td><?php echo 'Flexi Schedule Group'; ?></td>
    <?php if($employee->InActive === '1'){ ?>
    <td style="color:#ff0000;">InActive</td>
    <?php } ?>
    <?php if($employee->InActive === '0'){ ?>
    <td>Active</td>
    <?php } ?>
  </tr>
  <?php }
  foreach($employee_fixed as $employee){ ?>
  <tr>
    <td><?php echo $employee->employee_id; ?></td>
    <td><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
      <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
    </td>
    <td><?php echo $employee->group_name; ?></td>
    <td><?php echo 'Fixed Schedule Group'; ?></td>
    <?php if($employee->InActive === '1'){ ?>
    <td style="color:#ff0000;">InActive</td>
    <?php } ?>
    <?php if($employee->InActive === '0'){ ?>
    <td>Active</td>
    <?php } ?>
  </tr>
  <?php }
  foreach($employee_section as $employee){ ?>
  <tr>
    <td><?php echo $employee->employee_id; ?></td>
    <td><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
      <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
    </td>
    <td><?php echo $employee->group_name; ?></td>
    <td><?php echo 'Section Manager Scheduled Group'; ?></td>
    <?php if($employee->InActive === '1'){ ?>
    <td style="color:#ff0000;">InActive</td>
    <?php } ?>
    <?php if($employee->InActive === '0'){ ?>
    <td>Active</td>
    <?php } ?>
  </tr>
  <?php }
  foreach($employee_available as $employee){ ?>
  <tr>
    <td style="color:#ff0000;"><?php echo $employee->employee_id; ?></td>
    <td style="color:#ff0000;"><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
      <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
    </td>
    <td><p style="color:#ff0000;">No group</p></td>
    <td></td>
    <td></td>
  </tr>
</tbody>
</div>

