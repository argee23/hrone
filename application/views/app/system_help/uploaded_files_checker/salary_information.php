<div class="col-md-12" id="main_result" style="margin-top: 50px;overflow: scroll;">
      
<table class="table table-hover" id="report" >
  <thead>
    <tr class="danger">
      <th>Employee ID</th>
      <th>Employee Name</th>
      <th>Salary Date Effective</th>
      <th>Salary Amount</th>
      <th>Hours a day</th>
      <th>Days a month</th>
      <th>Days a year</th>
      <th>Reason</th>
      <th>Is Salary Fixed</th>
      <th>Withholding tax</th>
      <th>Pagibig</th>
      <th>SSS</th>
      <th>Philhealth</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($details as $s) {?>
    <tr>
    <td><?php echo $s->employee_id;?></td>
    <td><?php echo $s->fullname;?></td>
    <td><?php echo $s->date_effective;?></td>
    <td><?php echo $s->salary_amount;?></td>
    <td><?php echo $s->no_of_hours;?></td>
    <td><?php echo $s->no_of_days_monthly;?></td>
    <td><?php echo $s->no_of_days_yearly;?></td>
    <td><?php echo $s->reason_title;?></td>
    <td><?php if($s->is_salary_fixed==1){ echo "yes"; } else{ echo "no"; }?></td>
    <td><?php if($s->withholding_tax==1){ echo "yes"; } else{ echo "no"; }?> </td>
    <td><?php if($s->pagibig==1){ echo "yes"; } else{ echo "no"; }?> </td>
    <td><?php if($s->sss==1){ echo "yes"; } else{ echo "no"; }?> </td>
    <td><?php if($s->philhealth==1){ echo "yes"; } else{ echo "no"; }?> </td>
    </tr>
  <?php } ?>
  </tbody>
</table>
   



</div>
      