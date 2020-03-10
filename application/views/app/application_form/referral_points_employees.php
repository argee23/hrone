
<table class="table table-hover" id="referral_points">
    <thead>
      <tr class="danger">
        <th style="width: 10%;"></th>
        <th style="width: 35%;">Company</th>
        <th style="width: 20%;">Employee ID</th>
        <th style="width: 35%;">Employee Name</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($employees as $e){?>
      <tr>
        <td><input type="checkbox" name="employee_id" value="<?php echo $e->employee_id;?>" id="employee_id<?php echo $e->employee_id;?>" onclick="selected_employees('<?php echo $e->employee_id;?>');" >
        </td>
        <td><?php echo $e->company_name;?></td>
        <td><?php echo $e->employee_id;?></td>
        <td><?php echo $e->fullname;?></td>
      </tr>
    <?php } ?>
    </tbody>
</table>

<input type="hidden" id="selected_employee" name="selected_employeee" class="form-control">